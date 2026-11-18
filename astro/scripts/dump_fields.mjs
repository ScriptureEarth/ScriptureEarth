// Report the fields in the JSON dump (data/scripture.json) that the projector
// (extract.mjs) does not read, so new data the dump starts carrying gets noticed
// instead of silently ignored.
//
// It walks every entry, normalises each leaf to a path (numeric keys → `#`, so row
// ordinals and row indexes collapse), and classifies each path against FIELDS below:
//   used        extract.mjs reads it
//   ignored     we know about it and deliberately don't use it (with a reason)
//   unclassified  neither → NEW or UNUSED data: the thing this report exists to surface
// It also lists FIELDS entries the dump no longer has (a rename or reshape).
//
// FIELDS is hand-maintained. When extract.mjs starts reading a field, add it here as
// `used`; when you decide a field isn't wanted, add it as `ignored` with a reason.
//
// Run:  pnpm run audit:fields            (text report)
//       node scripts/dump_fields.mjs --markdown out.md --json out.json
//       --strict  → exit 1 when unclassified fields exist
// In GitHub Actions the Markdown report is appended to $GITHUB_STEP_SUMMARY and each
// unclassified field becomes a ::warning annotation.
import { readFileSync, writeFileSync, appendFileSync } from 'node:fs';
import { fileURLToPath } from 'node:url';
import path from 'node:path';
import { dataPaths } from './data-dir.mjs';

// --- path syntax ----------------------------------------------------------------
// Dot-separated segments; keys that aren't plain identifiers are quoted: links_media["Bible.is"].
// In patterns: `#` = any numeric key, `*` = any one key, `**` = any number of keys (≥0).
const PLAIN = /^[A-Za-z_][A-Za-z0-9_]*$/;
const isNum = (k) => /^\d+$/.test(k);
export const fmtPath = (segs) =>
  segs.map((s, i) => (s === '#' || PLAIN.test(s) ? (i ? '.' : '') + s : `[${JSON.stringify(s)}]`)).join('');

export function parsePath(str) {
  const segs = [];
  const re = /\[("(?:[^"\\]|\\.)*")\]|\.?([^.[\]]+)/g;
  let m;
  while ((m = re.exec(str))) segs.push(m[1] ? JSON.parse(m[1]) : m[2]);
  return segs;
}

export function matches(pattern, segs, i = 0, j = 0) {
  if (i === pattern.length) return j === segs.length;
  const p = pattern[i];
  if (p === '**') {
    for (let k = j; k <= segs.length; k++) if (matches(pattern, segs, i + 1, k)) return true;
    return false;
  }
  if (j === segs.length) return false;
  const s = segs[j];
  const ok = p === '*' || (p === '#' ? s === '#' : p === s);
  return ok && matches(pattern, segs, i + 1, j + 1);
}

// --- what extract.mjs reads -------------------------------------------------------
// A link group has had three shapes (see linkRows in extract.mjs):
//   flat G.#  (bare URL)   rows G.#.field   cols G.field.#
const linkGroup = (g, fields = []) => [
  `${g}.#`,
  ...['url', 'URL', ...fields].flatMap((f) => [`${g}.#.${f}`, `${g}.${f}.#`]),
];
const playlist = (g) => linkGroup(g, ['filename', 'title']);
const R = 'relationships';

const used = (id, patterns, opts = {}) => ({ id, status: 'used', patterns, ...opts });
const ignored = (id, patterns, note, opts = {}) => ({ id, status: 'ignored', patterns, note, ...opts });

export const FIELDS = [
  ignored('envelope', ['type', 'id'], 'row envelope; relationships.idx is the real key'),
  ignored('legacy nav', ['attributes.navigation.*', 'attributes.num_nav', `${R}.se_maps`], 'legacy PHP site navigation / feature flag'),
  ignored('derived', [`${R}.alternate_language_count`, `${R}.country_count`, `${R}.idx_query_string`, `${R}.iso_query_string`],
    'derived from other fields (counts, idx=/iso= query strings)'),
  // Verified 2026-11-16: same values as se_media.text/audio in every entry.
  ignored('download copies', [`${R}.se_download_media.text.*.#`, `${R}.se_download_media.audio.*.#`], 'duplicate of se_media.text/audio'),
  used('iso', ['attributes.iso']),
  used('identity', [`${R}.idx`, `${R}.rod`, `${R}.var_code`, `${R}.var_name`]),
  used('names', [`${R}.language_name.English`, ...['Spanish', 'Portuguese', 'French', 'Dutch', 'German', 'Chinese', 'Korean', 'Russian', 'Arabic'].map((l) => `${R}.language_name.${l}`)]),
  used('alt names', [`${R}.alternate_language_names.#`]),
  used('countries', [`${R}.countries_codes.#`, `${R}.countries_names.#`]),

  used('online viewer', [`${R}.se_online_viewer`]),
  used('PDF', [`${R}.se_media.text.OT.#`, `${R}.se_media.text.NT.#`]),
  used('audio', [`${R}.se_media.audio.OT.#`, `${R}.se_media.audio.NT.#`]),
  used('audio playlists', playlist(`${R}.se_media.playlist_audio`)),
  used('video playlists', playlist(`${R}.se_media.playlist_video`)),
  used('download playlists', playlist(`${R}.se_download_media.playlist_video`)),
  used('other text', linkGroup(`${R}.se_media.other_text`, ['title', 'summary'])),
  used('other audio', linkGroup(`${R}.se_media.other_audio`, ['title', 'summary'])),
  used('other video', linkGroup(`${R}.se_download_media.other_video_download`, ['title', 'summary'])),
  used('other titles (legacy shape)', ['other_PDF', 'other_audio', 'other_video_download'].map((k) => `${R}.other_titles.${k}.#`), { legacy: true }),
  used('ePub', linkGroup(`${R}.se_ePub`)),
  ignored('ePub title', [`${R}.se_ePub.#.title`, `${R}.se_ePub.title.#`], 'holds the format, not a title'),
  used('SAB readers', [`${R}.se_sab.#.path`, `${R}.se_sab.#.url`, `${R}.se_sab.#.description`]),
  used('SAB (legacy shape)', [`${R}.se_sab.text.#`, `${R}.se_sab.audio.#`], { legacy: true }),

  used('Bible.is', linkGroup(`${R}.links_media["Bible.is"]`, ['title', 'media_type'])),
  used('Bible.is Gospel Film', linkGroup(`${R}.links_media["Bible.is_Gospel_Film"]`, ['title'])),
  used('YouVersion', linkGroup(`${R}.links_media.YouVersion`, ['title'])),
  used('eBible', linkGroup(`${R}.links_media.eBible`, ['title'])),
  used('GRN', linkGroup(`${R}.links_media.GRN`, ['title'])),
  used('Kalaam', linkGroup(`${R}.links_media.Kalaam_websites`, ['title', 'organization'])),
  used('other websites', linkGroup(`${R}.links_media.other_websites`, ['title', 'organization'])),
  used('contact', linkGroup(`${R}.links_media.email`, ['title'])),
  used('AppleStore', linkGroup(`${R}.links_media.AppleStore`, ['title'])),
  used('buy links', linkGroup(`${R}.links_media.buy`, ['title', 'organization'])),

  used('watch', linkGroup(`${R}.watch`, ['watch_what', 'organization', 'JesusFilm', 'YouTube'])),
  used('buy', linkGroup(`${R}.buy`, ['title', 'testament', 'buy_what', 'organization'])),
  used('apps', linkGroup(`${R}.se_apps.*`, ['title'])),
  used('Google Play', linkGroup(`${R}.se_google_play`, ['title'])),
  used('iPhone', linkGroup(`${R}.se_iPhone`, ['title'])),
  used('GoBible', linkGroup(`${R}.se_other_software.GoBible`, ['title'])),
  used('MySword', linkGroup(`${R}.se_other_software.MySword`, ['title'])),
  used('theWord', ['filename', 'url', 'testament', 'alphabet'].map((f) => `${R}.se_other_software.theWord.#.${f}`)),

  used('maps', [`${R}.maps.#`]),
  used('SIL link', [`${R}.SIL_link`]),
].map((f) => ({ ...f, compiled: f.patterns.map(parsePath) }));

// --- walk -----------------------------------------------------------------------------
const nonEmpty = (v) => v !== null && v !== undefined && !(typeof v === 'string' && !v.trim());

/** Every leaf of one entry → Map(pathString → { segs, values: [..non-empty..], empty }). */
function leaves(entry) {
  const out = new Map();
  const visit = (v, segs) => {
    if (v && typeof v === 'object') {
      const keys = Object.keys(v);
      if (keys.length) { for (const k of keys) visit(v[k], [...segs, isNum(k) ? '#' : k]); return; }
      v = null; // {} / [] — the key exists but holds nothing
    }
    const key = fmtPath(segs);
    let rec = out.get(key);
    if (!rec) out.set(key, (rec = { segs, values: [] }));
    if (nonEmpty(v)) rec.values.push(v);
  };
  visit(entry, []);
  return out;
}

const classify = (segs) => FIELDS.find((f) => f.compiled.some((p) => matches(p, segs))) || null;
// An empty container ({} where rows would be) of a known group, e.g. `watch` with no rows.
const isKnownContainer = (segs) =>
  FIELDS.some((f) => f.compiled.some((p) => !p.includes('**') && p.length > segs.length && matches(p.slice(0, segs.length), segs)));

/** Build the report from the parsed dump (top-level object keyed by row ordinal, or an array). */
export function analyse(raw) {
  const entries = Array.isArray(raw) ? raw : Object.values(raw);
  const paths = new Map(); // path → { segs, field, entries, nonEmptyEntries, values, sample }
  for (const e of entries) {
    for (const [key, { segs, values }] of leaves(e)) {
      let p = paths.get(key);
      if (!p) paths.set(key, (p = { path: key, segs, field: classify(segs), entries: 0, withData: 0, values: 0, sample: undefined }));
      p.entries++;
      if (values.length) { p.withData++; p.values += values.length; p.sample ??= values[0]; }
    }
  }
  const all = [...paths.values()].sort((a, b) => (a.path < b.path ? -1 : 1));
  const strip = ({ segs, field, ...p }) => ({ ...p, field: field?.id, note: field?.note });
  const seen = new Set(all.filter((p) => p.withData && p.field).map((p) => p.field.id));
  return {
    entries: entries.length,
    unclassified: all.filter((p) => !p.field && p.withData).map(strip),
    // Skip empty containers of known groups, and of groups whose rows are reported elsewhere.
    unclassifiedEmpty: all.filter((p) => !p.field && !p.withData && !isKnownContainer(p.segs)
      && !all.some((q) => q.withData && q.segs.length > p.segs.length && matches(p.segs, q.segs.slice(0, p.segs.length)))).map(strip),
    ignored: all.filter((p) => p.field?.status === 'ignored' && p.withData).map(strip),
    used: all.filter((p) => p.field?.status === 'used' && p.withData).map(strip),
    missing: FIELDS.filter((f) => f.status === 'used' && !f.legacy && !seen.has(f.id)).map((f) => f.id),
  };
}

// --- output -------------------------------------------------------------------------------
const clip = (v, n = 70) => {
  const s = typeof v === 'string' ? v : JSON.stringify(v);
  return s.length > n ? `${s.slice(0, n - 1)}…` : s;
};
const pct = (n, of) => `${n} (${((100 * n) / of).toFixed(n * 1000 < of ? 2 : 1)}%)`;

export function toText(r) {
  const lines = [`dump field report — ${r.entries} entries`];
  const block = (title, rows, row) => {
    lines.push('', `${title}: ${rows.length}`);
    for (const p of rows) lines.push(`  ${row(p)}`);
  };
  block('UNUSED / NEW fields (not read by extract.mjs, not marked ignored)', r.unclassified,
    (p) => `${p.path}  — ${pct(p.withData, r.entries)} entries  e.g. ${clip(p.sample)}`);
  block('Unclassified fields that are always empty', r.unclassifiedEmpty, (p) => `${p.path}  — present in ${p.entries} entries`);
  block('Ignored on purpose', r.ignored, (p) => `${p.path}  — ${p.withData} entries  (${p.note})`);
  block('Expected but absent from this dump (renamed or reshaped?)', r.missing.map((id) => ({ id })), (p) => p.id);
  lines.push('', `used fields with data: ${r.used.length} paths`);
  return lines.join('\n');
}

export function toMarkdown(r) {
  const esc = (s) => String(s).replace(/\|/g, '\\|').replace(/\n/g, ' ');
  const code = (s) => '`' + esc(s).replace(/`/g, "'") + '`';
  const out = ['## Dump field report', '',
    `${r.entries} entries · **${r.unclassified.length}** unused/new field(s) · ${r.missing.length} expected field group(s) absent`, ''];
  if (r.unclassified.length) {
    out.push('### Unused / new fields', '', 'In the dump but not read by `extract.mjs` and not marked ignored in `scripts/dump_fields.mjs`.', '',
      '| path | entries with data | sample |', '|---|---:|---|',
      ...r.unclassified.map((p) => `| ${code(p.path)} | ${pct(p.withData, r.entries)} | ${code(clip(p.sample))} |`), '');
  } else out.push('No unused or new fields. ✅', '');
  if (r.missing.length) out.push('### Expected but absent', '', 'Field groups `extract.mjs` reads that have no data in this dump (renamed or reshaped?):', '', ...r.missing.map((id) => `- ${id}`), '');
  const details = (title, rows, head, row) => rows.length && out.push(`<details><summary>${title} (${rows.length})</summary>`, '', head, ...rows.map(row), '', '</details>', '');
  details('Unclassified, always empty', r.unclassifiedEmpty, '| path | entries |\n|---|---:|', (p) => `| ${code(p.path)} | ${p.entries} |`);
  details('Ignored on purpose', r.ignored, '| path | entries with data | reason |\n|---|---:|---|', (p) => `| ${code(p.path)} | ${p.withData} | ${esc(p.note)} |`);
  return out.join('\n');
}

// --- CLI ------------------------------------------------------------------------------------
if (process.argv[1] && path.resolve(process.argv[1]) === fileURLToPath(import.meta.url)) {
  const args = process.argv.slice(2).filter((a) => a !== '--'); // pnpm forwards a bare --
  const opt = (name) => { const i = args.indexOf(name); return i >= 0 ? args[i + 1] : undefined; };
  const src = process.env.SE_JSON || dataPaths().json;
  const report = analyse(JSON.parse(readFileSync(src, 'utf8')));
  console.log(toText(report));
  const md = toMarkdown(report);
  if (opt('--markdown')) writeFileSync(opt('--markdown'), md);
  if (opt('--json')) writeFileSync(opt('--json'), JSON.stringify(report, null, 2));
  if (process.env.GITHUB_ACTIONS) {
    if (process.env.GITHUB_STEP_SUMMARY) appendFileSync(process.env.GITHUB_STEP_SUMMARY, `${md}\n`);
    for (const p of report.unclassified) console.log(`::warning title=Unused dump field::${p.path} has data in ${p.withData} entries but extract.mjs doesn't read it`);
    for (const id of report.missing) console.log(`::warning title=Dump field absent::${id} — extract.mjs reads it but this dump has no data for it`);
  }
  if (args.includes('--strict') && report.unclassified.length) process.exit(1);
}
