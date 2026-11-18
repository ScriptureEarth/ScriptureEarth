# JSON dump → content → build

The site is built from a **single consolidated JSON dump** of the production `scripture`
database, downloaded from the API — no per-record scraping. The dump endpoint is:

```
https://www.scriptureearth.org/api/db_dump.php?v=1&key=<your key>
```

`<your key>` is a row in the server's `api_users` table (same key the rest of `/api/` uses).

## Get the latest dump (quick reference)

1. Put your key in `config.env` in the shared data folder (`git config se.datadir`, e.g.
   `C:/dev/ScriptureEarth/astro/data/config.env`; gitignored), as an **uncommented** line:
   `SE_KEY=your-api-key`. Or pass it inline each time: `SE_KEY=… pnpm run fetch:dump`.
2. From `astro/`: `pnpm run fetch:dump`. This overwrites `scripture.json` in the shared folder,
   so every worktree sees it.
3. Check it: `pnpm run audit:fields` lists fields the projector doesn't read yet (new link
   types, new columns), then `SE_STRICT=1 pnpm run extract` checks nothing it does read broke.

Two steps, then the normal build:

```
fetch_dump.mjs                    extract.mjs + astro build
────────────────                  ─────────────────────────
/api dump endpoint ─► data/scripture.json ─► content/*.json ─► dist/
   (SE_KEY auth)          (one JSON object)     (projector)
```

`data/scripture.json` is git-ignored (`data/`); every fresh build re-downloads it.

## Dump shape

One JSON object. Each **top-level key is a row ordinal** (`1`, `2`, …) — *not* the language
id — and each value is `{ type, id, attributes, relationships }`. The real per-language key is
**`relationships.idx`**; `attributes.iso` is the ISO code. `relationships` holds the resources
(`se_media`, `se_download_media`, `links_media`, `watch`, `se_apps`, `se_sab`, `buy`, `maps`,
localized `language_name`, `countries_codes`/`countries_names`, …). This is the same data the
live site's per-language nav renders. `scripts/extract.mjs` projects it into the `content/`
schema (`languages.json`, `countries.json`, `search-index.json`).

Media values (`se_media.text`/`audio`) are full URLs; playlists come as
`{ title:{0:..}, filename:{0:<full URL>} }` under `se_media.playlist_video`/`playlist_audio`.
(Older captures used bare basenames and a flat `{0:file}` playlist shape — the projector still
tolerates both.) `se_sab` is `{ "0": { path, url, description } }` — one row per SAB HTML
reader (`path` = SE-hosted folder URL, `url` = external reader); older captures had
`{ text:{}, audio:{} }` file lists, still tolerated. The dump format has changed more than
once, so if resources vanish, re-probe a fresh dump before assuming a build bug.

## Unused-field report (`pnpm run audit:fields`)

`dump_fields.mjs` walks every entry, turns each value into a path (numeric keys become `#`, e.g.
`relationships.links_media.YouVersion.#.title`) and checks it against the `FIELDS` list at the
top of the script. Each path is either **used** (extract.mjs reads it), **ignored** (known and
deliberately unused, with a reason), or **unclassified**. Unclassified paths with data are the
report's point: new link types or new columns the site doesn't show yet. It also lists `FIELDS`
groups the dump no longer has, which usually means a rename or reshape.

`FIELDS` is kept by hand. When `extract.mjs` starts reading a field, add it there as `used`; when
you decide not to use one, add it as `ignored` with a reason, so it stops being reported.

In CI, `preview.yml` runs it after the build: the report goes into the job summary and each
unused field becomes a warning annotation on the PR. It never fails the job. Locally,
`--strict` exits 1 when unclassified fields exist, and `--markdown <file>` / `--json <file>`
save the report.

## Worktrees: share one data folder (`pnpm run setup:data`)

> **`setup:data` is for local dev only.** CI never runs it — a CI build fetches the dump fresh
> (`fetch:dump`) and lets `extract.mjs` fetch video playlist listings from the server directly.

Because `data/` is git-ignored, a freshly-created **git worktree starts with no dump** — and you
don't want each worktree re-downloading it. The fix is one shared folder that every worktree
points at, recorded in a single **shared git config key** (lives in the common `.git/config`, so
every worktree sees it — no machine path is ever committed):

```bash
# once per machine, from any worktree — pick any absolute path (the main checkout's is fine):
git config se.datadir "C:/dev/ScriptureEarth/astro/data"

# (maintainers only) to rebuild from the live API, put your key in that folder:
#   <that folder>/config.env
#     SE_KEY=your-api-key
#     # endpoint defaults are correct; override only for testing:
#     # SE_DUMP_URL=https://www.scriptureearth.org/api/db_dump.php?v=1

pnpm run setup:data     # ensures the dump + playlist cache exist in the shared folder, else no-op
```

`setup:data` populates two things in the shared folder, downloading each only if missing:

- **`scripture.json`** — the consolidated dump the build reads. Downloaded from a prebuilt Drive
  zip (no key needed). `SE_JSON_URL` may point at a zip **or** a raw `.json`.
- **`playlist-txt-cache/`** — a cache of PlaylistVideo `.txt` listings. Optional: `extract.mjs`
  re-fetches any missing `.txt` from scriptureearth.org on demand, so this just skips thousands
  of network round-trips.

**No API key needed to get started.** By default it downloads *prebuilt* artifacts from public
links (baked into `setup-data.mjs`, overridable via `SE_JSON_URL` / `SE_PLAYLIST_CACHE_URL`).
**Maintainers** who want a fresh dump from the live API instead set `SE_KEY` (+ optional
`SE_DUMP_URL`) and run `pnpm run fetch:dump` (or `build:fresh`).

After setup, every worktree's `fetch:dump` / `extract` reads and writes that one folder.
Resolution order for the data dir: `SE_DATA_DIR` env → `git config se.datadir` → `<package>/data`
(worktree-local fallback, used when nothing is configured). `setup:data` is idempotent — if you
already have a `scripture.json`, drop it in the folder and re-run.

## Run it

```bash
# One shot: fetch + project + astro build
SE_KEY=yourkey pnpm run build:fresh

# Or step by step
SE_KEY=yourkey pnpm run fetch:dump     # → data/scripture.json
pnpm run build:dump                    # extract.mjs (project) + astro build → dist/

# Rebuild content from an existing data/scripture.json (no download)
pnpm run extract                       # → content/*.json + public/search-index.txt
```

`SE_SKIP_PLAYLISTS=1 pnpm run extract` skips the per-playlist `.txt` fetch for a fast dev build.
**Dev only — never deploy a build made with it:** a video playlist with no fetched clips has no
URL, so the whole playlist row is dropped (e.g. a language loses its JESUS Film entry). Production
and CI builds must fetch playlists; run `pnpm run setup:data` first so the cache makes that fast.

### Test your key first

`fetch:dump` prints a redacted URL and validates the response (rejects HTML/error pages and
non-dump JSON), so the quickest check is just `SE_KEY=yourkey pnpm run fetch:dump`. To poke the
endpoint directly:

```bash
# 200 = OK (JSON streams), 403 = bad/missing key, 404 = wrong path.
# You MUST send a real User-Agent — the server returns 406 Not Acceptable for
# curl's default UA (and Node fetch's default). fetch_dump.mjs already sets one.
curl -s -o /dev/null -w '%{http_code}\n' \
  -H 'User-Agent: ScriptureEarth-Build/1.0' \
  "https://www.scriptureearth.org/api/db_dump.php?v=1&key=YOUR_KEY"
```

## Configuration (env)

| var | default | meaning |
|---|---|---|
| `SE_KEY` | *(required for fetch)* | API key — a row in the server's `api_users` table. Never logged or committed. |
| `SE_DUMP_PATH` | `/api/db_dump.php` | Dump endpoint path (confirmed production endpoint). |
| `SE_BASE` | `https://www.scriptureearth.org` | API host (the canonical `www` host; the bare host also works today). |
| `SE_V` | `1` | API version query param. |
| `SE_DUMP_URL` | *(unset)* | Full endpoint URL, auth included — overrides `SE_BASE`+`SE_DUMP_PATH` and disables key-appending. Escape hatch for local testing. |
| `SE_DUMP_OUT` | `<data dir>/scripture.json` | Where the dump is written / read. |
| `SE_JSON` | `<data dir>/scripture.json` | Dump path read by `extract.mjs`. |
| `SE_SKIP_PLAYLISTS` | *(unset)* | `1` → `extract.mjs` skips fetching playlist `.txt` listings. **Dev only** — drops video-playlist rows; never deploy such a build. |
| `SE_STRICT` | *(unset)* | `1` → `extract.mjs` runs a data audit and exits non-zero (without writing) if a dump field has data but nothing was projected (shape change), a field group the projector reads has no data anywhere (renamed or moved; uses `dump_fields.mjs`), or `watch`/`buy` titles are absent. Audit tool — not wired into CI. See `DUMP-API-REQUESTS.md`. |
| `SE_MIN_LANGS` | `4000` | Strict-mode floor: fail if fewer than this many languages projected. |
| `SE_DATA_DIR` | *(unset)* | Override the shared data dir for one command (else `git config se.datadir`, else `<package>/data`). Also the folder `config.env` is read from. |
| `SE_JSON_URL` | *(Drive link)* | `setup:data`: prebuilt dump download URL — a zip of `scripture.json`, or a raw `.json`. |
| `SE_PLAYLIST_CACHE_URL` | *(Drive link)* | `setup:data`: prebuilt `playlist-txt-cache.zip` download URL (zip must contain a top-level `playlist-txt-cache/`). |

## Files

| file | role |
|---|---|
| `data-dir.mjs` | Resolves the shared data dir (`SE_DATA_DIR` → `git config se.datadir` → `<package>/data`) and loads `<dir>/config.env` secrets without clobbering real env. |
| `setup-data.mjs` | `pnpm run setup:data` — worktree bootstrap: download (or fetch) the dump and download+unzip the playlist cache into the shared folder, else no-op; guides you to set `se.datadir` / `config.env` when unconfigured. |
| `download.mjs` | Helpers for `setup-data.mjs`: streaming `download()`, `driveUrl()`, and a dependency-free ZIP extractor (`unzipInto()`, stored + deflate, zip-slip guarded). |
| `fetch_dump.mjs` | Download the JSON dump (same `?v=&key=` auth as the rest of `/api/`). Detects gzip; validates it's the language dump; saves an inspectable `scripture.unexpected.*` on a surprise. |
| `extract.mjs` | **Projector** — reads `data/scripture.json` → `content/{languages,countries,search-index,lang-map}.json`. Fetches playlist `.txt` listings for video clip URLs. |
| `dump_fields.mjs` | `pnpm run audit:fields` — reports dump fields `extract.mjs` doesn't read (see above). Tests: `pnpm run test:fields`. |
| `playlistTxt.mjs` | Resolves PlaylistVideo `.txt` listings to clip URLs (cached under `playlist-txt-cache/`). |
