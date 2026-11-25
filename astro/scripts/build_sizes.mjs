// Size-benchmark producer. Walks the freshly built dist/, computes each page
// archetype's cold-load weight (STRICT = English, on-load; DEFERRED = the
// runtime assets a flat HTML parse can't see) plus shared per-type buckets, and
// writes dist/assets/sizes.json. See bench/SIZE-BENCH-SPEC.md.
//
// It sizes every file as raw + wire (brotli q4, the Cloudflare edge quality;
// q11 for the one _headers-pinned file, /search-index.txt). It measures the
// PRE-brotli dist/, so it MUST run BEFORE precompress_dist.mjs replaces files
// with their compressed bytes (see package.json `predeploy`).
import { readFileSync, existsSync, statSync, readdirSync, mkdirSync, writeFileSync } from 'node:fs';
import path from 'node:path';
import { fileURLToPath } from 'node:url';
import { execFileSync } from 'node:child_process';
import { brotliCompressSync, constants as Z } from 'node:zlib';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const DIST = path.join(__dirname, '..', 'dist');

const Q_WIRE = 4;    // Cloudflare edge brotli quality
const Q_PINNED = 11; // /search-index.txt ships pre-compressed at q11 (see precompress_dist.mjs)
const PINNED = new Set(['/search-index.txt']);
const SCHEMA = 1;

const brotli = (buf, q) => brotliCompressSync(buf, { params: { [Z.BROTLI_PARAM_QUALITY]: q } }).length;

function bucketOf(p) {
  const e = path.extname(p).toLowerCase();
  if (e === '.html' || p.endsWith('/')) return 'html';
  if (e === '.css') return 'css';
  if (e === '.js' || e === '.mjs') return 'js';
  if (['.png', '.jpg', '.jpeg', '.webp', '.avif', '.jxl', '.gif', '.svg', '.ico'].includes(e)) return 'img';
  if (['.woff', '.woff2', '.ttf', '.otf'].includes(e)) return 'font';
  if (['.json', '.txt', '.bin', '.xml', '.csv'].includes(e)) return 'data';
  return 'other';
}

// Resolve a root-absolute URL ref (/_astro/x.js) to a dist file path.
function toFile(ref) {
  const clean = ref.split('?')[0].split('#')[0];
  if (!clean.startsWith('/')) return null; // external / relative
  return path.join(DIST, clean);
}

// Size one file as { raw, wire }, memoized so shared assets referenced by
// thousands of language pages are only compressed once.
const sizeCache = new Map();
function size(file, pinned = false) {
  if (!file || !existsSync(file) || !statSync(file).isFile()) return null;
  const key = `${pinned ? 'p:' : ''}${file}`;
  const hit = sizeCache.get(key);
  if (hit) return hit;
  const buf = readFileSync(file);
  const s = { raw: buf.length, wire: brotli(buf, pinned ? Q_PINNED : Q_WIRE) };
  sizeCache.set(key, s);
  return s;
}

// Static refs a flat HTML scan can see: href/src/srcset resolving to a real
// asset file under dist/ (navigational <a href> to directories are dropped).
// A <picture> counts only its first <source> (what a current browser fetches);
// the later sources and the <img> fallback are for older browsers.
// <link rel="apple-touch-icon"> is dropped: browsers fetch it only when the user
// adds the site to a home screen, never on page load.
function scanHtml(htmlFile) {
  const html = readFileSync(htmlFile, 'utf8').replace(/<link\b[^>]*\brel="apple-touch-icon[^>]*>/g, '').replace(/<picture\b[^>]*>([\s\S]*?)<\/picture>/g, (block, inner) => {
    const first = inner.match(/<source\b[^>]*>/);
    return first ? first[0] : inner;
  });
  const refs = new Set();
  for (const m of html.matchAll(/(?:href|src)\s*=\s*"([^"]+)"/g)) refs.add(m[1]);
  for (const m of html.matchAll(/srcset\s*=\s*"([^"]+)"/g)) {
    for (const part of m[1].split(',')) refs.add(part.trim().split(/\s+/)[0]);
  }
  return [...refs].filter((r) => r.startsWith('/') && /\.[a-z0-9]+$/i.test(r.split('?')[0]));
}

// Follow /_astro/*.js one level for imported sibling chunks — guards against a
// future shared/vendor split not named directly in the HTML.
function followJsGraph(jsFiles) {
  const found = new Set();
  for (const f of jsFiles) {
    if (!f || !existsSync(f)) continue;
    const src = readFileSync(f, 'utf8');
    for (const m of src.matchAll(/["'`](\/_astro\/[A-Za-z0-9._-]+\.js)["'`]/g)) found.add(m[1]);
  }
  return [...found];
}

const emptyByType = () => ({});
function addToByType(byType, bucket, s) {
  const b = byType[bucket] || (byType[bucket] = { wire: 0, raw: 0 });
  b.wire += s.wire;
  b.raw += s.raw;
}
function sumByType(byType) {
  return Object.values(byType).reduce((t, b) => ({ wire: t.wire + b.wire, raw: t.raw + b.raw }), { wire: 0, raw: 0 });
}

// STRICT cold-load set for one page: the HTML doc + its static deps (flat scan +
// one-level JS-graph follow), bucketed by type. English, no interaction.
function strictOf(pageFile) {
  const byType = emptyByType();
  const html = size(pageFile);
  addToByType(byType, 'html', html);

  const staticRefs = scanHtml(pageFile);
  const graphRefs = followJsGraph(staticRefs.filter((r) => r.endsWith('.js')).map(toFile));
  const seen = new Set();
  for (const ref of [...new Set([...staticRefs, ...graphRefs])]) {
    if (seen.has(ref)) continue;
    seen.add(ref);
    const s = size(toFile(ref), PINNED.has(ref));
    if (!s) continue;
    addToByType(byType, bucketOf(ref), s);
  }
  return { ...sumByType(byType), byType };
}

// DEFERRED set: the runtime assets pulled by script (invisible to an HTML scan),
// from the declarative recipe. Only the added assets are counted here.
function deferredOf(refs) {
  const byType = emptyByType();
  for (const ref of refs) {
    const s = size(toFile(ref), PINNED.has(ref));
    if (!s) continue;
    addToByType(byType, bucketOf(ref), s);
  }
  return { ...sumByType(byType), byType };
}

// --- WORST_LOCALE: pick the largest i18n triad empirically (spec §7) ---------
// The triad is chrome.<loc>.json + names.<loc>.json + autonyms.json (shared).
// Measure every locale present in dist/i18n and choose the heaviest by wire.
function pickWorstLocale() {
  const dir = path.join(DIST, 'i18n');
  if (!existsSync(dir)) return null;
  const locales = new Set();
  for (const f of readdirSync(dir)) {
    const m = /^chrome\.(.+)\.json$/.exec(f);
    if (m) locales.add(m[1]);
  }
  let best = null;
  for (const loc of locales) {
    const triad = [`/i18n/chrome.${loc}.json`, `/i18n/names.${loc}.json`, '/i18n/autonyms.json'];
    const wire = triad.reduce((t, ref) => t + (size(toFile(ref))?.wire || 0), 0);
    if (!best || wire > best.wire) best = { loc, wire };
  }
  return best?.loc || null;
}

// --- install icon: the manifest icon Chrome fetches after load (spec §1.4) ----
// Chrome reads the manifest (in the HTML, so STRICT) and then downloads one icon to
// decide whether the site is installable. Which one depends on the device, so model
// the heaviest icon below 512px; the 512s are only fetched at install time.
function installIcon() {
  const file = path.join(DIST, 'manifest.webmanifest');
  if (!existsSync(file)) return null;
  let best = null;
  for (const icon of JSON.parse(readFileSync(file, 'utf8')).icons || []) {
    if (parseInt(icon.sizes, 10) >= 512) continue;
    const wire = size(toFile(icon.src))?.wire || 0;
    if (!best || wire > best.wire) best = { ref: icon.src, wire };
  }
  return best?.ref || null;
}

// --- shared per-type buckets + total site, over ALL of dist/ -----------------
function walkFiles(dir, out = []) {
  for (const name of readdirSync(dir, { withFileTypes: true })) {
    const full = path.join(dir, name.name);
    if (name.isDirectory()) walkFiles(full, out);
    else if (name.isFile()) out.push(full);
  }
  return out;
}

function computeBuckets() {
  const buckets = {};
  const site = { wire: 0, raw: 0, count: 0 };
  for (const file of walkFiles(DIST)) {
    const rel = '/' + path.relative(DIST, file).split(path.sep).join('/');
    const s = size(file, PINNED.has(rel));
    if (!s) continue;
    const b = buckets[bucketOf(rel)] || (buckets[bucketOf(rel)] = { wire: 0, raw: 0, count: 0 });
    b.wire += s.wire;
    b.raw += s.raw;
    b.count += 1;
    site.wire += s.wire;
    site.raw += s.raw;
    site.count += 1;
  }
  return { buckets, site };
}

// --- language aggregate: avg / total / p95 / max over every language page -----
function aggregate(values) {
  // values: array of { wire, raw }; returns { avg, total, p95, max } size objs.
  const n = values.length;
  const total = values.reduce((t, v) => ({ wire: t.wire + v.wire, raw: t.raw + v.raw }), { wire: 0, raw: 0 });
  const avg = { wire: Math.round(total.wire / n), raw: Math.round(total.raw / n) };
  const pct = (arr, p) => {
    const sorted = [...arr].sort((a, b) => a - b);
    const idx = Math.min(sorted.length - 1, Math.ceil((p / 100) * sorted.length) - 1);
    return sorted[Math.max(0, idx)];
  };
  const wires = values.map((v) => v.wire);
  const raws = values.map((v) => v.raw);
  const p95 = { wire: pct(wires, 95), raw: pct(raws, 95) };
  const max = { wire: Math.max(...wires), raw: Math.max(...raws) };
  return { avg, total, p95, max };
}

function gitCommit() {
  try {
    return execFileSync('git', ['rev-parse', 'HEAD'], { cwd: __dirname }).toString().trim();
  } catch {
    return null;
  }
}

function pageFile(rel) {
  return path.join(DIST, rel);
}

// Representative country page: prefer NG, else the first country dir present.
function representativeCountry() {
  const dir = path.join(DIST, 'country');
  if (existsSync(pageFile('country/NG/index.html'))) return 'NG';
  if (!existsSync(dir)) return null;
  for (const name of readdirSync(dir, { withFileTypes: true })) {
    if (name.isDirectory() && existsSync(path.join(dir, name.name, 'index.html'))) return name.name;
  }
  return null;
}

function main() {
  if (!existsSync(DIST)) {
    console.error(`dist/ not found at ${DIST} — run \`astro build\` first.`);
    process.exit(1);
  }

  const worstLocale = pickWorstLocale();
  const triad = worstLocale
    ? [`/i18n/chrome.${worstLocale}.json`, `/i18n/names.${worstLocale}.json`, '/i18n/autonyms.json']
    : [];

  // The home world map SVG has a content-hashed /_astro/ name; WorldMap.astro exposes
  // it as data-map-url (fetched by script when scrolled near, so not in the HTML scan).
  const homeHtml = path.join(DIST, 'index.html');
  const mapRef = existsSync(homeHtml) ? /data-map-url="([^"]+)"/.exec(readFileSync(homeHtml, 'utf8'))?.[1] : null;

  // Recipe: every archetype defers the worst-case i18n triad and the install icon;
  // home also defers the lazily-fetched search index and world map.
  // (See spec §1.4 / src/scripts/{i18n,search,world-map}.js.)
  const icon = installIcon();
  const all = [...triad, ...(icon ? [icon] : [])];
  const RECIPE = {
    home: ['/search-index.txt', ...(mapRef ? [mapRef] : []), ...all],
    browse: all,
    countries: all,
    country: all,
    language: all,
  };

  const country = representativeCountry();
  const SINGLES = {
    home: 'index.html',
    browse: 'browse/index.html',
    countries: 'countries/index.html',
    country: country ? `country/${country}/index.html` : null,
  };

  const archetypes = {};
  for (const [key, rel] of Object.entries(SINGLES)) {
    if (!rel || !existsSync(pageFile(rel))) {
      console.error(`  WARN: archetype ${key} page missing (${rel}) — skipped`);
      continue;
    }
    const entry = { strict: strictOf(pageFile(rel)), deferred: deferredOf(RECIPE[key]) };
    if (key === 'country') entry.representative = country;
    archetypes[key] = entry;
  }

  // language: aggregate over all dist/language/*/index.html
  const langDir = path.join(DIST, 'language');
  const langStrict = [];
  const langDeferred = [];
  if (existsSync(langDir)) {
    const deferred = deferredOf(RECIPE.language); // identical for every language page
    for (const name of readdirSync(langDir, { withFileTypes: true })) {
      if (!name.isDirectory()) continue;
      const f = path.join(langDir, name.name, 'index.html');
      if (!existsSync(f)) continue;
      const s = strictOf(f);
      langStrict.push({ wire: s.wire, raw: s.raw });
      langDeferred.push({ wire: deferred.wire, raw: deferred.raw });
    }
  }
  if (langStrict.length) {
    archetypes.language = {
      count: langStrict.length,
      strict: aggregate(langStrict),
      deferred: aggregate(langDeferred),
    };
  } else {
    console.error('  WARN: no language pages found under dist/language');
  }

  const { buckets, site } = computeBuckets();

  const out = {
    schema: SCHEMA,
    generatedAt: new Date().toISOString(),
    commit: gitCommit(),
    config: { wireQuality: Q_WIRE, pinnedQuality: Q_PINNED, worstLocale },
    archetypes,
    buckets,
    site,
  };

  const assetsDir = path.join(DIST, 'assets');
  mkdirSync(assetsDir, { recursive: true });
  const outPath = path.join(assetsDir, 'sizes.json');
  writeFileSync(outPath, JSON.stringify(out, null, 2) + '\n', 'utf8');

  // Console summary.
  const kib = (n) => (n / 1024).toFixed(1) + 'K';
  console.error(`\nsize-bench → ${path.relative(process.cwd(), outPath)}  (worstLocale=${worstLocale})`);
  for (const [key, a] of Object.entries(archetypes)) {
    if (key === 'language') {
      console.error(`  ${key.padEnd(10)} strict avg ${kib(a.strict.avg.wire)} p95 ${kib(a.strict.p95.wire)} max ${kib(a.strict.max.wire)}  +deferred ${kib(a.deferred.avg.wire)}  (${a.count} pages)`);
    } else {
      console.error(`  ${key.padEnd(10)} strict ${kib(a.strict.wire)}  +deferred ${kib(a.deferred.wire)}  = ${kib(a.strict.wire + a.deferred.wire)}`);
    }
  }
  console.error(`  total-site wire ${kib(site.wire)} raw ${kib(site.raw)} (${site.count} files)`);
}

main();
