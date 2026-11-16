// Projects the consolidated JSON dump (data/scripture.json) into content-JSON
// documents (languages, countries, search-index). This is the CURRENT source of
// truth — the ScriptureEarth /api/db_dump.php endpoint returns one pre-joined JSON
// object (keyed by a row ordinal; the real language key is relationships.idx), the
// same data the live site's per-language nav renders. See scripts/README-dump.md.
//
// Run: node scripts/extract.mjs   (then build_search_index.mjs — `pnpm run extract`)
import { mkdirSync, writeFileSync, statSync, readFileSync } from 'node:fs';
import path from 'node:path';
import { fileURLToPath } from 'node:url';
import { loadPlaylistClips } from './playlistTxt.mjs';
import { dataPaths } from './data-dir.mjs';
import { BOOK_EN, parseAudioSet, label, compose, part, en, ph, PLACEHOLDERS } from './resource-labels.mjs';

const HERE = path.dirname(fileURLToPath(import.meta.url));
const DATA = dataPaths();
const SRC = process.env.SE_JSON || DATA.json;
const OUT = path.join(HERE, '..', 'content');
const ASSET_BASE = 'https://scriptureearth.org';
const PLAYLIST_CACHE = DATA.playlistCache;

// language_name locale keys → our locale codes.
const LN = {
  English: 'eng', Spanish: 'spa', Portuguese: 'por', French: 'fra', Dutch: 'nld',
  German: 'deu', Chinese: 'cmn', Korean: 'kor', Russian: 'rus', Arabic: 'arb',
};
const AUTONYM_KEY = 'autonym(s)';

mkdirSync(OUT, { recursive: true });
const t0 = Date.now();

const raw = JSON.parse(readFileSync(SRC, 'utf8'));
if (raw && typeof raw === 'object' && !Array.isArray(raw) && '__error' in raw) {
  console.error(`ERROR: ${SRC} looks like an API error payload, not a dump.`);
  process.exit(1);
}
// Top-level object is keyed by a row ordinal, NOT the idx. Take the values.
const entries = Array.isArray(raw) ? raw : Object.values(raw);
if (!entries.length) {
  console.error(`ERROR: ${SRC} has no entries.`);
  process.exit(1);
}

const base = (f) => String(f || '').trim().replace(/\\/g, '/').split('/').pop();
// Numeric-keyed maps ({"0":"a","1":"b"}) → array of non-empty string values.
function vals(m) {
  if (!m || typeof m !== 'object') return [];
  return Object.values(m).filter((v) => typeof v === 'string' && v.trim());
}
const ext = (u) => /^https?:/i.test(String(u || ''));
const s = (v) => (typeof v === 'string' ? v.trim() : '');
// Display title from a dump title/description column. The legacy page printed these
// after a fixed label ("Read/Listen/View  - Adioukrou Bible (NT)"), so thousands carry a
// "- " / ": " lead-in; some are HTML-escaped (&#x27;). Strip the lead-in and unescape.
const ENT = { amp: '&', lt: '<', gt: '>', quot: '"', apos: "'", nbsp: ' ' };
const t = (v) => s(v)
  .replace(/&(#x[0-9a-f]+|#\d+|[a-z]+);/gi, (m, e) => e[0] === '#'
    ? String.fromCodePoint(e[1].toLowerCase() === 'x' ? parseInt(e.slice(2), 16) : parseInt(e.slice(1), 10))
    : (ENT[e.toLowerCase()] ?? m))
  .replace(/^[\s\-–—:]+/, '')
  .trim();
const host = (u) => { try { return new URL(u).hostname.replace(/^www\./, ''); } catch { return '—'; } };
// The dump has used three shapes for a resource group over time; normalize all to
// [{ url, title, organization, ... }]. The format has changed repeatedly, so tolerate
// every shape we've seen:
//   flat:  { "0": url, "1": url }
//   rows:  { "0": { url, title, ... }, "1": {...} }   (numeric keys → row objects)  ← current
//   cols:  { url:{0:..}, title:{0:..}, ... }           (field keys → parallel maps)
// Rows with data but no URL are KEPT (url undefined): res() marks them missing:'link' so the
// page shows a visible placeholder instead of silently dropping them.
const hasData = (row) => Object.values(row).some((v) => (typeof v === 'string' ? v.trim() : v != null && v !== ''));
function linkRows(obj) {
  if (!obj || typeof obj !== 'object') return [];
  const entries = Object.entries(obj);
  if (!entries.length) return [];
  const norm = (row) => ({ ...row, url: row.url || row.URL });
  if (entries.every(([, v]) => typeof v === 'string')) {
    return vals(obj).map((u) => ({ url: u })); // flat
  }
  if (entries.every(([k]) => /^\d+$/.test(k))) { // rows
    return entries
      .sort((a, b) => Number(a[0]) - Number(b[0]))
      .map(([, v]) => v)
      .filter((v) => v && typeof v === 'object')
      .map(norm)
      .filter((v) => v.url || hasData(v));
  }
  const subs = entries.filter(([, v]) => v && typeof v === 'object'); // cols
  const idxs = new Set();
  for (const [, v] of subs) for (const k of Object.keys(v)) idxs.add(k);
  const out = [];
  for (const i of [...idxs].sort((x, y) => Number(x) - Number(y))) {
    const row = {};
    for (const [name, v] of subs) if (v[i] !== undefined && v[i] !== '') row[name] = v[i];
    const n = norm(row);
    if (n.url || hasData(n)) out.push(n);
  }
  return out;
}
// Bible.is media_type code (1–8) → which resource groups the link belongs in.
const bibleIsGroups = (m) => ({
  read: [1, 2, 3, 4, 8].includes(m) || !m,
  listen: [1, 3, 4, 5, 6].includes(m),
  watch: [4, 6, 7, 8].includes(m),
});
// se_sab: one row per Scripture App Builder HTML reader (the legacy SAB_scriptoria table).
//   rows: { 0:{ path, url, description } }  ← current
//     path = SE-hosted reader folder (full URL, e.g. https://www.ScriptureEarth.org/data/adj/sab/adj/)
//     url  = externally hosted reader (media.ipsapps.org, …); a few are site-relative (/data/…)
//   legacy: { text:{0:file.html}, audio:{…} } — reader file basenames only, not linkable.
// Normalize to [{ url, name, local }]; the legacy shape yields [] (see sabLegacyFlag).
function sabRows(obj) {
  if (!obj || typeof obj !== 'object') return [];
  const out = [];
  for (const [k, v] of Object.entries(obj).sort((a, b) => Number(a[0]) - Number(b[0]))) {
    if (!/^\d+$/.test(k) || !v || typeof v !== 'object') continue;
    const local = s(v.path), ext = s(v.url);
    let u = ext || local;
    // A reader row with no usable address is kept as a "Link missing" placeholder.
    const placeholder = { url: null, name: t(v.description), local: false };
    if (!u) { if (hasData(v)) out.push(placeholder); continue; }
    // Site-relative reader path → absolute, with the directory slash the server 301s to.
    if (u.startsWith('/')) u = `${ZIP_BASE}${u}${/\/$|\.[a-z0-9]+$/i.test(u) ? '' : '/'}`;
    if (!/^https?:\/\//i.test(u)) { out.push(placeholder); continue; }
    const name = t(v.description); // "- Adioukrou Bible (NT)", ": Read online" → lead-in stripped
    out.push({ url: u, name, local: host(u).toLowerCase() === 'scriptureearth.org' });
  }
  return out;
}
// Older dumps listed reader files under se_sab.text/audio with no folder — count them
// toward read availability without a link, as before.
const sabLegacyFlag = (sab) => vals(sab?.text).length > 0 || vals(sab?.audio).length > 0;
function asset(iso, kind, file) {
  // The dump gives media as full URLs now (older captures used basenames); use the
  // URL as-is, else build it under the standard /data/<iso>/<kind>/ path.
  const s = String(file || '');
  return /^https?:/i.test(s) ? s : `${ASSET_BASE}/data/${iso}/${kind}/${base(s)}`;
}
// "…/Amarasi_Bible_epub3.epub" → "EPUB" (format badge for non-PDF downloads).
const fileExt = (u) => (base(u).match(/\.([a-z0-9]{2,5})$/i)?.[1] || 'File').toUpperCase();
// App links come in three shapes: a full URL (https:, or asset:// for the iOS app — passed
// through), a host path missing its scheme ("app.scriptoria.io/api/…/apk" → https://), or a
// bare file name ("…-13.3.2.apk"), which the legacy page served from /data/<iso>/study/
// via 00-CellPhoneModule.php.
function appUrl(iso, raw) {
  const u = s(raw);
  if (!u) return null;
  if (/^[a-z][a-z0-9+.-]*:/i.test(u)) return u;
  if (/^[a-z0-9-]+(\.[a-z0-9-]+)+\//i.test(u)) return `https://${u}`;
  return `${ASSET_BASE}/data/${iso}/study/${encodeURIComponent(base(u))}`;
}
// The file name as shown under a "Title missing" placeholder (decoded, so spaces read).
function fileName(u) {
  const n = base(u);
  try { return decodeURIComponent(n); } catch { return n; }
}
// Playlists have used the same three shapes as other groups; the file lives under
// `filename` (or `url`). Normalize to [{ file, title }].
//   rows: { 0:{ title, filename } }  ← current    cols: { title:{0}, filename:{0} }    flat: { 0:file }
function playlistItems(pl) {
  if (!pl || typeof pl !== 'object') return [];
  const entries = Object.entries(pl);
  if (!entries.length) return [];
  if (entries.every(([, v]) => typeof v === 'string')) {
    return vals(pl).map((f) => ({ file: f, title: null })); // flat
  }
  if (entries.every(([k]) => /^\d+$/.test(k))) { // rows
    return entries
      .sort((a, b) => Number(a[0]) - Number(b[0]))
      .map(([, v]) => v)
      .filter((v) => v && typeof v === 'object')
      .map((v) => ({ file: v.filename || v.url || v.URL, title: s(v.title) || null }))
      .filter((v) => v.file);
  }
  if (pl.filename && typeof pl.filename === 'object') { // cols
    const titles = pl.title || {};
    return Object.entries(pl.filename)
      .filter(([, f]) => typeof f === 'string' && f.trim())
      .map(([k, f]) => ({ file: f, title: s(titles[k]) || null }));
  }
  return [];
}
// Fallback title when the dump gives no playlist title: drop .txt + trailing language
// code, special-case JESUS Film, else split CamelCase/separators into words.
function playlistTitle(file) {
  let s = base(file).replace(/\.txt$/i, '').replace(/-[A-Za-z]{2,4}\d*$/, '');
  if (/^JESUS ?Film/i.test(s)) return 'JESUS Film';
  s = s.replace(/([a-z])([A-Z])/g, '$1 $2').replace(/[_-]+/g, ' ').trim();
  return s || 'Video playlist';
}
// `name` is a plain string or { name, label } from resource-labels.mjs; `label` (parts
// [[i18nKey|null, text], …]) lets ResourceRow render generic phrases in the UI language.
function res(group, kind, fmt, name, source, url, external, meta = {}) {
  const cleaned = {};
  for (const [k, v] of Object.entries(meta)) {
    if (v !== null && v !== undefined && v !== '') cleaned[k] = v;
  }
  const n = typeof name === 'object' && name ? name : { name };
  const out = { group, kind, format: fmt, name: n.name, source, url, external, meta: cleaned };
  if (n.label) out.label = n.label;
  if (source === en('src.pod')) out.srcKey = 'src.pod';
  // Placeholders (ResourceRow shows them visibly) for rows we know about but can't link:
  // 'playlist' = the playlist .txt couldn't be loaded; 'link' = the dump row has no URL.
  // Callers may preset meta.missing (e.g. 'file') to say something more specific.
  if (cleaned.missing) { out.missing = cleaned.missing; delete cleaned.missing; }
  else if (!url && !cleaned.books) out.missing = cleaned.playlistFile ? 'playlist' : 'link';
  if (cleaned.zipMissing) { out.zipMissing = true; delete cleaned.zipMissing; }
  return out;
}

// "Download whole playlist" — ScriptureEarth's PHP zip endpoints (public GET, stream a
// zip with Content-Disposition: attachment). Audio takes the mp3 filenames; video takes
// the clip index numbers from the .txt + the .txt name. Only SE-hosted media can zip.
const ZIP_BASE = 'https://www.scriptureearth.org';
const SAFE_BOOKS = /^[0-9a-zñA-ZÑ., _|()-]+$/; // the audio endpoint's own validation
function audioZipUrl(iso, clips) {
  const books = clips.map((c) => decodeURIComponent(base(c.url))).filter(Boolean);
  const joined = books.join('|');
  if (!books.length || !SAFE_BOOKS.test(joined)) return null; // server would reject
  return `${ZIP_BASE}/00-PlaylistAudioSaveZip.php?st=eng&iso=${iso}&Books=${encodeURIComponent(joined)}`;
}
// The endpoint reads line <n>+2 of the .txt for each checkBox n (the legacy page numbered
// its checkboxes from the first clip line, which is line 2), so n = line - 2 — NOT the
// .txt's own first-column number, which is 1-based in many files.
function videoZipUrl(iso, playlistFile, clips) {
  const idxs = clips.filter((c) => /\.mp4(\?|$)/i.test(c.url || '') && Number.isFinite(c.line) && c.line >= 2).map((c) => c.line - 2);
  if (!idxs.length || !/^[a-zA-Z0-9._-]+$/.test(playlistFile)) return null;
  return `${ZIP_BASE}/00-PlaylistDownloadVideoZip.php?st=eng&iso=${iso}&PlaylistVideoFilename=${encodeURIComponent(playlistFile)}&checkBoxes=${encodeURIComponent(idxs.join('|'))}`;
}
// One testament book as a zip: 00-AudioSaveZip.php looks the files up in the DB by
// iso + rod + book number (0-based within the testament).
const bookZipUrl = (iso, rod, T, book) =>
  `${ZIP_BASE}/00-AudioSaveZip.php?T=${T}&st=eng&iso=${iso}&rod=${encodeURIComponent(rod || '00000')}&Books=${book}`;

// --- canonical country name per code (first seen; verified conflict-free) ---
const countryName = new Map();
function countriesOf(r) {
  const codes = vals(r.countries_codes);
  const names = vals(r.countries_names);
  return codes.map((code, i) => {
    const nm = names[i] || code;
    if (!countryName.has(code)) countryName.set(code, nm);
    return { code, name_eng: countryName.get(code) };
  });
}

// --- slug ---
const seenSlugs = new Map();
function makeSlug(iso, rod, variant, idx) {
  let s;
  if (variant) s = `${iso}-${rod}-${variant}`;
  else if (rod && rod !== '00000') s = `${iso}-${rod}`;
  else s = iso;
  s = String(s).toLowerCase();
  if (seenSlugs.has(s) && seenSlugs.get(s) !== idx) s = `${s}-${idx}`;
  seenSlugs.set(s, idx);
  return s;
}

// Testament PDFs: one row linking the combined 00-*.pdf (else the first book).
function testamentPdf(iso, map, T) {
  const files = vals(map);
  if (!files.length) return null;
  const combined = files.find((f) => /^00-/.test(base(f)));
  const count = files.filter((f) => !/^00-/.test(base(f))).length || files.length;
  return res('read', 'pdf', 'PDF', compose(part(T === 'OT' ? 'res.ot' : 'res.nt')), 'ScriptureEarth',
    asset(iso, 'PDF', combined || files[0]), false, { books: count });
}
// Testament audio: one row per testament whose meta.books lists each book with its
// chapters (playable) and a per-book zip. Files whose book can't be parsed from the name
// go in a trailing "Other recordings" pseudo-book with no zip.
function testamentAudio(iso, rod, map, T) {
  const files = vals(map);
  if (!files.length) return null;
  const parsed = parseAudioSet(files, iso, T);
  const byBook = new Map();
  for (const p of parsed) {
    const k = p.book < 0 ? 'zz' : String(p.book).padStart(2, '0');
    if (!byBook.has(k)) byBook.set(k, []);
    byBook.get(k).push(p);
  }
  const books = [...byBook.entries()].sort((a, b) => (a[0] < b[0] ? -1 : 1)).map(([k, ps]) => {
    const unknown = k === 'zz';
    const ch = ps.map((p, i) => ({ n: unknown || p.chapter == null ? i + 1 : p.chapter, url: asset(iso, 'audio', p.file) }));
    return unknown
      ? { key: 'ph.book', name: PLACEHOLDERS['ph.book'], ph: true, ch }
      : { key: `book.${ps[0].code}`, name: BOOK_EN[ps[0].code], ch, zip: bookZipUrl(iso, rod, T, ps[0].book) };
  });
  return res('listen', 'audio', 'Audio', compose(part(T === 'OT' ? 'res.ot' : 'res.nt')), 'ScriptureEarth',
    books[0].ch[0].url, false, { books, chapters: files.length });
}

// --- playlists: gather (iso, filename) pairs, fetch clip/track listings once ---
const playlistClips = new Map();       // video: iso\tbasename → [{title,url,image?}]
const playlistAudioClips = new Map();  // audio: iso\tbasename → [{title,url}]
async function poolMap(items, concurrency, fn) {
  let next = 0;
  const worker = async () => { while (next < items.length) await fn(items[next++]); };
  const n = Math.min(concurrency, items.length);
  if (n > 0) await Promise.all(Array.from({ length: n }, worker));
}
function gatherPlaylists(field, group = 'se_media') {
  const seen = new Set();
  const pairs = [];
  for (const e of entries) {
    const iso = e.attributes?.iso;
    for (const it of playlistItems(e.relationships?.[group]?.[field])) {
      const key = `${iso}\t${base(it.file)}`;
      if (!iso || seen.has(key)) continue;
      seen.add(key);
      pairs.push({ iso, filename: it.file, key });
    }
  }
  return pairs;
}
{
  // se_download_media.playlist_video = the legacy "PlaylistVideoDownload = 1" playlists
  // (…-download.txt): the ones the old site offered as zip downloads.
  const videoPairs = [...gatherPlaylists('playlist_video'), ...gatherPlaylists('playlist_video', 'se_download_media')]
    .filter((p, i, a) => a.findIndex((q) => q.key === p.key) === i);
  const audioPairs = gatherPlaylists('playlist_audio');
  if (process.env.SE_SKIP_PLAYLISTS) {
    console.error(`skipping ${videoPairs.length} video + ${audioPairs.length} audio playlist txt files (SE_SKIP_PLAYLISTS set — playlists get no clip URLs)`);
  } else {
    console.error(`fetching ${videoPairs.length} video + ${audioPairs.length} audio playlist txt files...`);
    await poolMap(videoPairs, 12, async (p) => {
      playlistClips.set(p.key, await loadPlaylistClips({ iso: p.iso, filename: p.filename, cacheDir: PLAYLIST_CACHE, kind: 'video' }));
    });
    await poolMap(audioPairs, 12, async (p) => {
      playlistAudioClips.set(p.key, await loadPlaylistClips({ iso: p.iso, filename: p.filename, cacheDir: PLAYLIST_CACHE, kind: 'audio' }));
    });
  }
}

const languages = [];
const search = [];
for (const e of entries) {
  const a = e.attributes || {};
  const r = e.relationships || {};
  const iso = a.iso;
  const idx = Number(r.idx);
  if (!iso || !Number.isFinite(idx)) continue;

  const R = { read: [], listen: [], watch: [], app: [], buy: [], other: [] };
  const media = r.se_media || {};
  const lm = r.links_media || {};
  const url = (x) => x.url || x.URL;

  // Order within each section (reviewer request, 2026-11): the SAB "Read/Listen/View"
  // reader first in Read, Listen and Watch; then ScriptureEarth's own items; then partners
  // (Bible.is, YouVersion, eBible, …). With no SAB reader, Bible.is would lead Read — but
  // ScriptureEarth items still come before it.
  const L = (raw, fb) => label(t(raw), fb);
  const FCBH = 'Faith Comes By Hearing';

  // SAB HTML readers. Always open in a new tab (external=true), like the online viewer:
  // it's a self-contained app, even when SE hosts it. A reader described as text-only
  // ("texto bíblico", "Bible text") is not repeated under Listen/Watch.
  const sab = r.se_sab || {};
  for (const x of sabRows(sab)) {
    const nm = label(x.name, 'res.rlv');
    const src = x.local ? 'ScriptureEarth' : host(x.url);
    R.read.push(res('read', 'viewer', 'Web', nm, src, x.url, true));
    if (nm.label?.[0]?.[0] === 'res.bibleText') continue;
    R.listen.push(res('listen', 'viewer', 'Web', nm, src, x.url, true));
    R.watch.push(res('watch', 'viewer', 'Web', nm, src, x.url, true));
  }

  // read: SE online viewer, SE PDFs, other SE titles, then partners.
  if (s(r.se_online_viewer)) R.read.push(res('read', 'viewer', 'Web', compose(part('res.viewer')), 'ScriptureEarth', s(r.se_online_viewer), true));
  const otPdf = testamentPdf(iso, media.text?.OT, 'OT');
  const ntPdf = testamentPdf(iso, media.text?.NT, 'NT');
  if (otPdf) R.read.push(otPdf);
  if (ntPdf) R.read.push(ntPdf);
  // other_titles.* are bare URLs: the legacy title columns (other, other_title) aren't in
  // the dump yet (DUMP-API-REQUESTS.md), so they show a "Title missing" placeholder with
  // the file name as the source line.
  for (const u of vals(r.other_titles?.other_PDF)) {
    const isPdf = /\.pdf(\?|$)/i.test(u);
    R.read.push(res('read', isPdf ? 'pdf' : 'download', isPdf ? 'PDF' : fileExt(u), compose(ph('ph.title')), fileName(u), asset(iso, 'PDF', u), false));
  }
  // se_ePub: { 0: { title: "format", url: "Keley-i Bible.epub" } } — a bare filename whose
  // folder on the server is unknown, and a junk title. Placeholder until the dump has a URL.
  for (const l of linkRows(r.se_ePub)) {
    const f = s(url(l));
    const real = /^https?:/i.test(f);
    R.read.push(res('read', 'download', 'EPUB', compose(ph('ph.title')), base(f) || 'ePub', real ? f : null, false, real ? {} : { missing: 'file' }));
  }

  // listen: SE testament audio, SE playlists, other SE audio, then partners.
  const otAud = testamentAudio(iso, r.rod, media.audio?.OT, 'OT');
  const ntAud = testamentAudio(iso, r.rod, media.audio?.NT, 'NT');
  if (otAud) R.listen.push(otAud);
  if (ntAud) R.listen.push(ntAud);
  for (const it of playlistItems(media.playlist_audio)) {
    const clips = playlistAudioClips.get(`${iso}\t${base(it.file)}`) || [];
    const first = clips[0];
    R.listen.push(res('listen', 'audio', 'MP3', label(it.title || base(it.file).replace(/\.txt$/i, ''), 'res.audioPlaylist'), 'ScriptureEarth',
      first ? first.url : null, first ? ext(first.url) : false,
      { clips: clips.length > 1 ? clips : undefined, playlistFile: base(it.file), zipUrl: audioZipUrl(iso, clips) }));
  }
  for (const u of vals(r.other_titles?.other_audio)) {
    R.listen.push(res('listen', 'audio', 'MP3', compose(ph('ph.title')), fileName(u), asset(iso, 'audio', u), false, { direct: true }));
  }

  // watch: SE playlists, other SE video, then partners. A streaming playlist takes its
  // "Download all" zip from the matching download playlist (se_download_media, the
  // legacy …-download.txt); a download playlist with no streaming twin gets its own row.
  const dlVideo = playlistItems(r.se_download_media?.playlist_video).map((it) => ({ ...it, base: base(it.file), used: false }));
  const twinOf = (it) => dlVideo.find((d) => !d.used && (
    d.base.replace(/-download(?=\.txt$)/i, '') === base(it.file) || (it.title && d.title && it.title.toLowerCase() === d.title.toLowerCase())));
  const watchPlaylist = (it, clips, dl) => {
    const first = clips[0];
    const dlClips = dl ? (playlistClips.get(`${iso}\t${dl.base}`) || []) : [];
    const zip = dl ? videoZipUrl(iso, dl.base, dlClips) : null;
    R.watch.push(res('watch', 'video', 'Video', label(it.title || playlistTitle(it.file), 'res.videoPlaylist'), 'ScriptureEarth',
      first ? first.url : null, first ? /^https?:/.test(first.url) : false,
      { clips: clips.length > 1 ? clips : undefined, playlistFile: base(it.file), zipUrl: zip,
        // A download playlist exists, but the zip endpoint can't take it (it only accepts
        // [A-Za-z0-9._-] filenames) or its .txt didn't load → visible "Zip not available".
        zipMissing: dl && !zip ? true : undefined }));
  };
  for (const it of playlistItems(media.playlist_video)) {
    const dl = twinOf(it);
    if (dl) dl.used = true;
    watchPlaylist(it, playlistClips.get(`${iso}\t${base(it.file)}`) || [], dl);
  }
  for (const d of dlVideo.filter((x) => !x.used)) watchPlaylist(d, playlistClips.get(`${iso}\t${d.base}`) || [], d);
  for (const u of vals(r.other_titles?.other_video_download)) {
    R.watch.push(res('watch', 'video', 'MP4', compose(ph('ph.title')), fileName(u), asset(iso, 'video', u), false, { direct: true }));
  }

  // Bible.is in read/listen/watch per its media_type code (1–8), after SE's own items.
  for (const l of linkRows(lm['Bible.is'])) {
    const g = bibleIsGroups(Number(l.media_type));
    const nm = L(l.title) , u = url(l);
    const n = nm.name ? nm : { name: 'Bible.is' };
    if (g.read) R.read.push(res('read', 'web', 'Web', n, FCBH, u, ext(u)));
    if (g.listen) R.listen.push(res('listen', 'audio', 'Audio', n, FCBH, u, ext(u)));
    if (g.watch) R.watch.push(res('watch', 'video', 'Video', n, FCBH, u, ext(u)));
  }
  for (const l of linkRows(lm['Bible.is_Gospel_Film'])) {
    const nm = L(l.title);
    R.watch.push(res('watch', 'video', 'Video', nm.name ? nm : { name: 'Bible.is Gospel Film' }, FCBH, url(l), ext(url(l))));
  }
  for (const l of linkRows(lm.YouVersion)) {
    // "Bible.com (YouVersion) - <title>": the prefix repeats the source line.
    const title = t(String(l.title || '').replace(/^\s*(Bible\.com\s*\(YouVersion\)|YouVersion(\.com)?)\s*/i, ''));
    R.read.push(res('read', 'web', 'Web', title ? L(title) : { name: 'YouVersion' }, 'Bible.com (YouVersion)', url(l), ext(url(l))));
  }
  for (const l of linkRows(lm.eBible)) R.read.push(res('read', 'web', 'Web', L(l.title, 'res.ebible'), 'eBible.org', url(l), ext(url(l))));
  for (const w of linkRows(r.watch)) {
    const jf = String(w.JesusFilm) === '1', yt = String(w.YouTube) === '1';
    const nm = L(w.watch_what, jf ? 'res.jesusFilm' : 'res.video');
    const src = s(w.organization) || (jf ? 'Jesus Film Project' : yt ? 'YouTube' : '—');
    R.watch.push(res('watch', 'video', 'Video', nm, src, url(w), ext(url(w))));
  }

  // apps. se_apps sections are { <Platform>: { 0: { title, url } } }.
  const apps = r.se_apps || {};
  for (const [section, data] of Object.entries(apps)) {
    const platform = /ios|apple|asset/i.test(section) ? 'res.iosApp' : 'res.androidApp';
    for (const app of linkRows(data)) {
      const u = appUrl(iso, url(app));
      R.app.push(res('app', 'app', 'App', L(app.title, platform), 'Scripture App Builder', u, ext(u)));
    }
  }
  for (const l of linkRows(r.se_google_play)) { const u = appUrl(iso, url(l)); R.app.push(res('app', 'app', 'App', L(l.title, 'res.androidApp'), 'Google Play', u, ext(u))); }
  for (const l of linkRows(r.se_iPhone)) { const u = appUrl(iso, url(l)); R.app.push(res('app', 'app', 'App', L(l.title, 'res.iosApp'), 'App Store', u, ext(u))); }
  for (const l of linkRows(lm.AppleStore)) { const u = appUrl(iso, url(l)); R.app.push(res('app', 'app', 'App', L(l.title, 'res.iosApp'), 'App Store', u, ext(u))); }
  // Study software modules hosted under /data/<iso>/study/ (legacy "Download the app for
  // GoBible (Java)" / MySword). theWord goes under Other, below.
  const sw = r.se_other_software || {};
  for (const l of linkRows(sw.GoBible)) R.app.push(res('app', 'download', 'Java', L(l.title, 'res.gobible'), 'GoBible', asset(iso, 'study', url(l)), false));
  for (const l of linkRows(sw.MySword)) R.app.push(res('app', 'download', 'MySword', L(l.title, 'res.mysword'), 'MySword', asset(iso, 'study', url(l)), false));

  // buy: the buy table, then links rows flagged buy (e.g. multilanguagemedia.org).
  for (const b of linkRows(r.buy)) R.buy.push(res('buy', 'buy', 'Buy', L(t(b.title) || t(b.testament) || t(b.buy_what), 'res.printed'), s(b.organization) || en('src.pod'), url(b), ext(url(b))));
  for (const l of linkRows(lm.buy)) R.buy.push(res('buy', 'buy', 'Buy', L(l.title, 'res.printed'), s(l.organization) || host(url(l)), url(l), ext(url(l))));

  // other: theWord modules, then resources that aren't Scripture itself — GRN
  // stories/songs, Kalaam and other multi-purpose websites, SIL language & culture.
  // theWord rows are { description, testament, alphabet, filename } (no url key).
  for (const [, v] of Object.entries(sw.theWord || {}).sort((a, b) => Number(a[0]) - Number(b[0]))) {
    const f = v && typeof v === 'object' ? s(v.filename) || s(v.url) : '';
    if (!f) continue;
    const tk = /bible|biblia/i.test(v.testament || '') ? 'res.bible' : /old|antiguo/i.test(v.testament || '') ? 'res.ot' : 'res.nt';
    const ak = /trad/i.test(v.alphabet || '') ? 'res.alphaTrad' : /new|nuevo/i.test(v.alphabet || '') ? 'res.alphaNew' : s(v.alphabet) ? 'res.alphaStd' : null;
    const nm = ak ? compose(part(tk), [null, ' ('], part(ak), [null, ')']) : compose(part(tk));
    R.other.push(res('other', 'download', 'theWord', nm, 'theWord', asset(iso, 'study', f), false));
  }
  for (const l of linkRows(lm.GRN)) R.other.push(res('other', 'web', 'Web', L(l.title, 'res.audioRecordings'), 'Global Recordings Network', url(l), ext(url(l))));
  for (const l of linkRows(lm.Kalaam_websites)) R.other.push(res('other', 'web', 'Web', L(l.title, 'res.website'), s(l.organization) || 'Kalaam Media', url(l), ext(url(l))));
  for (const l of linkRows(lm.other_websites)) R.other.push(res('other', 'web', 'Web', L(l.title, 'res.website'), s(l.organization) || host(url(l)), url(l), ext(url(l))));
  // links_media.email: contact rows ({ title, url } where url is an email address or a
  // phone number) and maps: bare map URLs (mostly Google My Maps).
  for (const l of linkRows(lm.email)) {
    const v = s(url(l));
    const href = !v ? null : /@/.test(v) ? `mailto:${v}` : /^[+\d][\d\s().-]{5,}$/.test(v) ? `tel:${v.replace(/[^\d+]/g, '')}` : /^https?:/i.test(v) ? v : null;
    R.other.push(res('other', 'contact', 'Contact', L(l.title, 'res.contact'), v, href, false));
  }
  for (const u of vals(r.maps)) R.other.push(res('other', 'web', 'Map', compose(part('res.map')), host(u), u, true));
  if (s(r.SIL_link)) R.other.push(res('other', 'web', 'Web', compose(part('res.langCulture')), 'SIL', s(r.SIL_link), true));

  const hasSab = sabLegacyFlag(sab);

  const avail = {
    read: R.read.length > 0 || hasSab,
    listen: R.listen.length > 0,
    watch: R.watch.length > 0,
    app: R.app.length > 0,
    buy: R.buy.length > 0,
    other: R.other.length > 0,
  };

  const ln = r.language_name || {};
  const name = (typeof ln.English === 'string' && ln.English.trim()) ? ln.English.trim() : iso;
  const localizedNames = [];
  for (const key of Object.keys(LN)) {
    const v = ln[key];
    if (typeof v === 'string' && v.trim()) localizedNames.push(v.trim());
  }
  const alt = [...new Set(vals(r.alternate_language_names))]; // the DB repeats some names
  const countries = countriesOf(r);
  const slug = makeSlug(iso, r.rod, r.var_code, idx);

  languages.push({
    idx,
    identity: {
      iso,
      slug,
      rod: r.rod,
      variant_code: r.var_code || '',
      variant_name: r.var_name || '',
      iso_query: `iso=${iso}`,
      idx_query: `idx=${idx}`,
    },
    names: { default_locale: 'eng', localized: { eng: name }, autonym: null, alt_names: alt },
    countries,
    availability: avail,
    resources: R,
  });

  search.push({
    idx,
    slug,
    code: iso,
    nm: name,
    vn: r.var_name || '',
    auto: null,
    nms: [...new Set(localizedNames)].filter((n) => n !== name),
    alt,
    where: countries.map((c) => c.name_eng).join(', '),
    cc: countries.map((c) => c.code),
    r: Object.entries(avail).filter(([, v]) => v).map(([k]) => k),
  });
}

// --- countries.json: invert languages by country ---
const byidx = new Map(languages.map((d) => [d.idx, d]));
const langsByCountry = new Map();
for (const d of languages) {
  for (const c of d.countries) {
    let ls = langsByCountry.get(c.code);
    if (!ls) { ls = []; langsByCountry.set(c.code, ls); }
    ls.push(d);
  }
}
const countriesOut = [];
for (const [code, name] of [...countryName.entries()].sort((a, b) => (a[0] < b[0] ? -1 : 1))) {
  const ls = langsByCountry.get(code) ?? [];
  countriesOut.push({
    code,
    name: { eng: name },
    language_idxs: ls.map((d) => d.idx),
    languages: ls.map((d) => ({
      idx: d.idx,
      slug: d.identity.slug,
      iso: d.identity.iso,
      name_eng: d.names.localized.eng,
      alt_names: d.names.alt_names.slice(0, 3),
      variant_name: d.identity.variant_name,
    })),
  });
}

function dump(name, obj) {
  const p = path.join(OUT, name);
  writeFileSync(p, JSON.stringify(obj), 'utf8');
  const count = Array.isArray(obj) ? obj.length : Object.keys(obj).length;
  const kb = Math.floor(statSync(p).size / 1024);
  console.error(`  ${name.padEnd(22)} ${String(count).padStart(6)}  ${kb} KB`);
}

// --- data audit / strict mode -------------------------------------------------
// Catches the class of regression that has bitten us twice (dump field shapes
// changing so the projector silently emits nothing). For each dump field, count
// languages that HAVE raw data in it vs. languages we actually emitted a row from.
// raw>0 but emitted==0 ⇒ the field shape changed. SE_STRICT=1 turns findings into a
// non-zero exit (use it to audit a dump; NOT wired into CI, which must still deploy
// the best-available build). Also reports title coverage for watch/buy.
function auditData(ents, langs) {
  const byIdx = new Map(langs.map((d) => [d.idx, d]));
  const some = (a, p) => Array.isArray(a) && a.some(p);
  const isPlaylist = (x) => x.meta && x.meta.playlistFile;
  // raw detectors are shape-agnostic (linkRows handles flat and nested) so a shape
  // change shows up as emitted==0 rather than silently reading raw==0 too.
  const anyApp = (r) => Object.values(r.se_apps || {}).some((sec) => linkRows(sec).length)
    || linkRows(r.se_google_play).length || linkRows(r.se_iPhone).length || linkRows(r.links_media?.AppleStore).length;
  const checks = [
    ['se_media.text',    (r) => vals(r.se_media?.text?.OT).length || vals(r.se_media?.text?.NT).length, (d) => some(d.resources.read, (x) => x.kind === 'pdf')],
    ['se_media.audio',   (r) => vals(r.se_media?.audio?.OT).length || vals(r.se_media?.audio?.NT).length, (d) => some(d.resources.listen, (x) => x.kind === 'audio' && /Testament/.test(x.name))],
    ['playlist_video',   (r) => playlistItems(r.se_media?.playlist_video).length, (d) => some(d.resources.watch, isPlaylist)],
    ['playlist_audio',   (r) => playlistItems(r.se_media?.playlist_audio).length, (d) => some(d.resources.listen, (x) => x.meta && x.meta.playlistFile)],
    ['se_sab',           (r) => sabRows(r.se_sab).length, (d) => some(d.resources.read, (x) => x.kind === 'viewer')],
    ['links.YouVersion', (r) => linkRows(r.links_media?.YouVersion).length, (d) => some(d.resources.read, (x) => x.source === 'Bible.com (YouVersion)')],
    ['links.eBible',     (r) => linkRows(r.links_media?.eBible).length, (d) => some(d.resources.read, (x) => x.source === 'eBible.org')],
    ['links.Bible.is',   (r) => linkRows(r.links_media?.['Bible.is']).length, (d) => some([...d.resources.read, ...d.resources.listen, ...d.resources.watch], (x) => x.source === 'Faith Comes By Hearing' && x.name !== 'Bible.is Gospel Film')],
    ['links.GRN',        (r) => linkRows(r.links_media?.GRN).length, (d) => some(d.resources.other, (x) => x.source === 'Global Recordings Network')],
    ['links.Kalaam',     (r) => linkRows(r.links_media?.Kalaam_websites).length, (d) => d.resources.other.length > 0],
    ['SIL_link',         (r) => s(r.SIL_link), (d) => some(d.resources.other, (x) => x.source === 'SIL')],
    ['watch',            (r) => linkRows(r.watch).length, (d) => some(d.resources.watch, (x) => !isPlaylist(x) && x.kind !== 'viewer' && !x.meta?.direct && x.source !== 'Faith Comes By Hearing')],
    ['buy',              (r) => linkRows(r.buy).length, (d) => d.resources.buy.length > 0],
    ['se_apps',          anyApp, (d) => some(d.resources.app, (x) => x.kind === 'app')],
    ['dl.playlist_video', (r) => playlistItems(r.se_download_media?.playlist_video).length, (d) => some(d.resources.watch, (x) => x.meta?.zipUrl)],
    ['other_PDF',        (r) => vals(r.other_titles?.other_PDF).length, (d) => some(d.resources.read, (x) => x.label?.[0]?.[0] === 'ph.title')],
    ['sw.GoBible',       (r) => linkRows(r.se_other_software?.GoBible).length, (d) => some(d.resources.app, (x) => x.source === 'GoBible')],
    ['sw.MySword',       (r) => linkRows(r.se_other_software?.MySword).length, (d) => some(d.resources.app, (x) => x.source === 'MySword')],
    ['sw.theWord',       (r) => Object.keys(r.se_other_software?.theWord || {}).length, (d) => some(d.resources.other, (x) => x.source === 'theWord')],
  ];
  const failures = [];
  console.error('data audit (languages with raw field → languages we emitted from it):');
  for (const [name, rawFn, emitFn] of checks) {
    let raw = 0, emitted = 0;
    for (const e of ents) {
      if (!rawFn(e.relationships || {})) continue;
      raw++;
      const d = byIdx.get(Number(e.relationships?.idx));
      if (d && emitFn(d)) emitted++;
    }
    const flag = raw > 0 && emitted === 0 ? '  ✗ SHAPE CHANGED' : (emitted < raw * 0.5 ? '  ⚠ partial' : '');
    console.error(`  ${name.padEnd(18)} ${String(raw).padStart(5)} → ${String(emitted).padStart(5)}${flag}`);
    if (raw > 0 && emitted === 0) failures.push(`${name}: ${raw} languages have data but none was projected — dump field shape likely changed`);
  }
  // Title coverage for watch/buy (data the JSON dump currently omits vs the old DB dump).
  const genericWatch = new Set(['The JESUS Film', 'YouTube', 'Video']);
  let wRows = 0, wTitled = 0, bRows = 0, bTitled = 0;
  for (const d of langs) {
    for (const x of d.resources.watch) { if (isPlaylist(x)) continue; wRows++; if (!genericWatch.has(x.name)) wTitled++; }
    for (const x of d.resources.buy) { bRows++; if (x.name !== 'Printed edition') bTitled++; }
  }
  console.error(`  watch titles: ${wTitled}/${wRows}   buy titles: ${bTitled}/${bRows}`);
  if (wRows > 0 && wTitled === 0) failures.push('watch: 0 rows have a real title (dump omits watch_what/organization)');
  if (bRows > 0 && bTitled === 0) failures.push('buy: 0 rows have a real title (dump omits buy_what/organization)');
  return failures;
}

// Hard floor, independent of SE_STRICT: a truncated or partial dump must never reach a deploy.
const MIN_LANGS = Number(process.env.SE_MIN_LANGS || 4000);
if (languages.length < MIN_LANGS) {
  console.error(`FATAL: only ${languages.length} languages projected (< SE_MIN_LANGS=${MIN_LANGS}) — refusing to write content/.`);
  process.exit(1);
}

const auditFailures = auditData(entries, languages);
if (auditFailures.length) {
  console.error(`\n${process.env.SE_STRICT ? 'STRICT ' : ''}data audit: ${auditFailures.length} issue(s):`);
  for (const f of auditFailures) console.error(`  - ${f}`);
  if (process.env.SE_STRICT) {
    console.error('SE_STRICT set — failing without writing content/.');
    process.exit(1);
  }
}

console.error('writing content/...');
dump('languages.json', languages);
dump('countries.json', countriesOut);
dump('search-index.json', search);
// Legacy-URL resolver map for functions-lib/route.js (bundled into the Pages Functions at
// deploy time). idx -> slug for ?idx= deep links; iso -> slug for ISOs with exactly one
// entry; multi = ISOs shared by several entries (the /language/ chooser page handles those).
{
  const idx = {}, byIso = {};
  for (const d of languages) {
    idx[String(d.idx)] = d.identity.slug;
    const iso = String(d.identity.iso).toLowerCase();
    (byIso[iso] ??= []).push(d.identity.slug);
  }
  const iso = {}, multi = [];
  for (const [k, slugs] of Object.entries(byIso)) (slugs.length === 1 ? (iso[k] = slugs[0]) : multi.push(k));
  dump('lang-map.json', { idx, iso, multi: multi.sort() });
}

console.error(`done in ${((Date.now() - t0) / 1000).toFixed(1)}s  (${languages.length} languages, ${countriesOut.length} countries)`);
