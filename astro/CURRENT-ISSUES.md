# Current issues / known gaps

Running list of known limitations in the Astro rebuild. Each entry: what, why, and
where to look. Remove an entry when it's fixed.

## Data projection (JSON dump → `content/`)

The projector is `scripts/extract.mjs` (reads `data/scripture.json`). The consolidated
JSON dump is the source of truth (see `scripts/README-dump.md`); the earlier SQLite/`mysqldump`
and JSON-harvest ingest paths have been removed. The items below are places the JSON projection
differs from what the old SQLite extractor produced, or where the dump doesn't carry enough to
build a link.

### 1. RESOLVED (2026-11-06): GoBible·MySword·theWord and other_titles are linked
The dump now gives full URLs for `se_other_software.*` (under `/data/<iso>/study/`) and
`other_titles.*`. GoBible + MySword are listed under Apps, theWord under Other (labelled from
its `testament` + `alphabet` columns), and other_titles PDFs/audio/video under Read/Listen/Watch.

### 1a. Placeholders: data we know about but can't show properly
Rather than silently dropping a resource the dump doesn't describe well enough, the page shows
it with an amber, dashed **placeholder** (`.ph`, chrome keys `ph.*`, texts in
`PLACEHOLDERS` in `scripts/resource-labels.mjs`) so the gap gets noticed. Counts and the asks
behind each are in `DUMP-API-REQUESTS.md` § Priority 2b: *Title missing* (other_titles),
*Playlist file not found* (568 video playlists whose `.txt` 404s — mostly JESUS Film),
*Zip not available*, *File location unknown* (the one ePub), *Book not recognized*,
*Link missing*. The projector marks rows with `missing: 'link'|'playlist'|'file'` and
`zipMissing`; the name side uses `label` parts with a `ph.*` key.

### 1c. Generic phrases are localized; real titles are not
Resource names that are fixed phrases (the dump's "Audio recording", "texto bíblico",
"Nuevo Testamento", our own fallbacks like "Online viewer") are matched against `PHRASES` in
`scripts/resource-labels.mjs` (English + Spanish variants, accent/case-insensitive) and
rendered as `data-i18n` spans. Anything not in that dictionary is a real title and stays as
entered. New generic phrases in the dump need a dictionary entry + chrome keys in every
catalog. Translations for ind/hin/swa/fil/fas (and Dutch book names) were written for this
change, not taken from the legacy tables; worth a native-speaker review.

### 1d. Testament audio is grouped by book from filenames
The dump has no book/chapter numbers for `se_media.audio`, so `parseAudioSet()` reads them
from the filename (USFM code or 2-digit book number; NT numbering is 40- or 41-based per set).
~99% agree with the legacy DB; unparsed files land in a *Book not recognized* group with no
zip. Per-book zips use the legacy `00-AudioSaveZip.php?T=&iso=&rod=&Books=<0-based book>`.

### 1b. RESOLVED (2026-09-28): SAB HTML readers are linked, first in Read
The dump's `se_sab` now carries the full `SAB_scriptoria` rows:
`{ "0": { path, url, description } }` — `path` is the SE-hosted reader folder as a full URL
(`https://www.ScriptureEarth.org/data/<iso>/sab/<subfolder>/`), `url` an externally hosted
reader (mostly `media.ipsapps.org`), `description` the legacy page's suffix text. 1019
languages / 1099 readers (812 local, 287 external). `sabRows()` in `extract.mjs` emits one
`kind: 'viewer'` row per reader at the **top of Read, Listen and Watch** (a text-only reader —
"texto bíblico" / "Bible text" — only in Read), above everything else, opening
in a new tab. Quirks handled: a few `url`s are site-relative (`/data/mlg/sab/bts`, no slash)
and get absolutized; descriptions carry a `- ` / `: ` lead-in that is stripped; ~30% have no
description and fall back to "Read, listen and view" (the legacy label). The older
`{ text:{}, audio:{} }` shape is still tolerated (read pill only, no link).

### 2. Dump-vs-old-SQLite gaps — mostly RESOLVED (see `DUMP-API-REQUESTS.md`)
A full diff of the JSON build against the old SQLite dump found several gaps. As of 2026-09-22
the dev delivered most: `watch`/`buy`/`se_apps`/`links_media` were restructured into nested maps
carrying **titles/organizations**, and Bible.is read/listen/view is now split via
`links_media["Bible.is"].media_type` (1–8) — restoring the ~2082 lost Bible.is audio entries.
`extract.mjs` consumes every shape the dump has used. As of 2026-09-23 buy's title is the
`title` key, `eBible` has `title`+`description`, and new `se_iPhone`/`se_ePub` fields exist.
Audio playlists now emit per-track mp3 links (parsed from the JS-object audio `.txt`), and video
playlist clips carry thumbnails (`data/~images/<subfolder>/<img>` from the video `.txt`'s image
column). **Still open:**
- **Study tools (~610)** — no `study` field in the dump at all.
- **`se_ePub`** — bare filename `url` (no resolvable path) + junk title; not emitted yet.
- **`other_websites`** — sometimes only `organization`, no title (minor).

`SE_STRICT=1 pnpm run extract` audits a dump and fails when a field has data but nothing is
projected (its raw-detectors are shape-agnostic, so a nested/flat change is caught), and reports
`watch`/`buy` title coverage. It is **not** in CI (CI must still deploy).

### 3. Countries with zero languages are dropped
`countries.json` is built by inverting languages → countries, so a country code that no
language references never appears. The old extractor seeded from a full `countries`
table and could include empty countries.
- **Effect:** the countries list only contains countries that have ≥1 language (almost
  certainly the desired behavior, but noting the difference).

### 4. `messages.eng.json` is no longer emitted
The dump doesn't carry the `translations_eng` table. That file was unused by `src`
(UI chrome is code-owned in `public/i18n/`), so this is intentional — listed only so its
absence isn't mistaken for a bug.

### 5. Video playlists depend on fetching `.txt` listings — never skip for a deploy
Video playlists (e.g. JESUS Film) are stored as a `.txt` filename; `extract.mjs` fetches
each to expand its per-clip rows. A playlist with no fetched clips has no URL, so it shows
the **"Playlist file not found" placeholder**. A build made with `SE_SKIP_PLAYLISTS=1` (a
dev-speed flag) turns them all into placeholders — the flag is documented dev-only. CI does **not** use `setup:data`; it lets
`extract.mjs` fetch the `.txt` listings from the server (`pnpm run setup:data` is local-dev
convenience only).

### 5b. RESOLVED: the dump's playlist format changed
The live dump changed `se_media.playlist_video`/`playlist_audio` from a flat
`{ "0": "file.txt" }` (basenames) to `{ title: {0:..}, filename: {0: <full URL>} }`, and
`se_media.text`/`audio` values from basenames to full URLs. The old projector read the flat
shape and found nothing (a CI build shipped with 0 video playlists). Fixed: `playlistItems()`
normalizes both shapes and uses the dump-provided title ("The JESUS Film"); `asset()` uses a
full URL as-is. The dump format has been in flux, so the projector now tolerates both shapes —
re-verify against a fresh dump if resources go missing again.

## CI

### 7. Cloudflare Pages project is still named `se-proto-en`
Pages projects can't be renamed. Moving to a better name means creating a new project,
deploying once, and moving the custom domain. The name is referenced in `package.json`
(`deploy`), `.github/workflows/preview.yml`, and `scripts/check_sizes.mjs` (baseline URL).

## Front end

### 8. `search-index.txt` is not content-hashed
The rewrite spec (ticket 07) called for a content-hashed, immutable search index with a
hash-keyed localStorage cache. Today `/search-index.txt` is an unhashed `public/` asset served
with Cloudflare's default `must-revalidate` + ETag, and `src/scripts/search.js` keeps nothing in
localStorage, so correctness is fine (a rebuild is picked up on the next 304 check) — the cost is
one conditional request per search session instead of an immutable hit. Hashing it means emitting
a manifest the home page reads and updating the `_redirects` guard + `precompress_dist.mjs`.

### 9. RESOLVED (2026-11-06): Country names are localized
`data-i18n-country=<CC>` spans (cards, search results, language/country pages, `/countries/`)
are filled by `i18n.js` from the browser's `Intl.DisplayNames` (CLDR), like the home map, with
the baked English name as fallback. No catalog download. Names follow CLDR, so a few differ
from the legacy site's own translations (e.g. Arabic spellings). The `/countries/` list stays
sorted by English name.

### 10. The `/language/` chooser and `/404` pages are English-only
Their few strings have no `data-i18n` keys (adding keys means touching all 14 chrome catalogs).

### 11. Help, About, Contact and Promotion page bodies are English-only
These pages port the legacy site menu (`src/pages/{help,about,contact,promotion}/`). Only their
crumbs and `<h1>` swap via chrome keys; long prose doesn't fit the chrome-overlay i18n. The legacy
site has the About texts (Copyright, Partners, Terms, Privacy) in 10 locales in
`00<loc>-CTPHC.php` (repo root), so translated bodies could be baked per locale or swapped in as
fragments. The `nav.*` menu labels for `fas`, `fil`, `hin`, `ind`, `swa`, and `nav.menu` in every
locale, are new translations (no legacy phrase) awaiting native-speaker review.

### 12. Promotion originals live on the legacy host
`/promotion/` ships only WebP thumbnails (`public/promotion/`); the video and full-size print
files link to `www.scriptureearth.org/promotionMaterials/` (~19 MB kept out of `dist/` and git).
If that host goes away, move the files to wherever `/data/` assets end up. Don't add a
`/promotionMaterials/*` redirect while the links point there. Cross-origin, the `download`
attribute is ignored, so "Download" opens the file instead.
