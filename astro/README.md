# ScriptureEarth — static site

The ScriptureEarth **public discovery site**: Astro-generated static HTML, hosted on Cloudflare Pages,
with client-side search and UI localisation. It is built from a single JSON dump of the ScriptureEarth
database and deployed by GitHub Actions on every push to `main`.

## Prerequisites
- **Node 22+** and **pnpm** (`corepack enable` or `npm i -g pnpm`). All build scripts are Node `.mjs`.
- A **data source** — `data/scripture.json`, the consolidated JSON dump of the ScriptureEarth DB (git-ignored).
  Get one via **`pnpm run setup:data`** (downloads a prebuilt dump — no key needed) or fetch it fresh
  from the live **dump API** (needs `SE_KEY`; see [`scripts/README-dump.md`](scripts/README-dump.md)).
  Override the data dir with `SE_DATA_DIR`, or the dump path with `SE_JSON=/path/to.json`.

## Data source: the JSON dump
The site is built from one pre-joined JSON dump of the production `scripture` DB, downloaded from the API:
```
https://www.scriptureearth.org/api/db_dump.php?v=1&key=<your key>
```
`<your key>` is a row in the server's `api_users` table. Flow:
`fetch_dump.mjs` (→ `data/scripture.json`) → `extract.mjs` (projector → `content/*.json`) → `astro build`.
The dump keys entries by a row ordinal (the real key is `relationships.idx`); the projector builds asset
URLs as `scriptureearth.org/data/<iso>/<PDF|audio|video>/<file>`. Details + how to test your key:
[`scripts/README-dump.md`](scripts/README-dump.md).

## Build & run
```bash
pnpm install
pnpm run setup:data          # one-time: get data/scripture.json (prebuilt; no key needed)

# (A) Build from an existing data/scripture.json
pnpm run build:dump          # extract.mjs (project -> content/) then astro build -> dist/

# (B) FRESH build — re-download the live dump first (maintainers; needs SE_KEY)
SE_KEY=… pnpm run build:fresh  # fetch:dump -> extract -> astro build

pnpm run dev                 # dev server (build content once first: pnpm run extract)
pnpm run preview             # serve dist/
```
- `pnpm run extract` regenerates `content/` (and `public/search-index.txt`) from `data/scripture.json` without building.
  Add `SE_SKIP_PLAYLISTS=1` for a fast dev build (skips the per-playlist `.txt` fetch — never deploy such a build).
- `pnpm run extract:i18n` regenerates the per-locale UI catalogs — rarely needed (see note below).
- `pnpm run gen:icons` regenerates `src/styles/icons.css` from the icon list in `src/lib/icons.mjs` (see Icons below).
- `pnpm run bench:search-index` / `pnpm run bench:size` — the two size gates (see `bench/`).

## Layout
- `src/pages/` — routes: `/` (search-first home), `/browse/` (full grid), `/language/<slug>/`
  (per-entry, slug = `<iso>[-<rod>][-<var>]`), `/countries/`, `/country/<CC>/`.
- `src/components/`, `src/layouts/`, `src/lib/`, `src/scripts/`, `src/styles/` — cards, base layout, UI helpers,
  client bundles (search, i18n localizer, browse facets, geo hint), stylesheet.
- `public/` — static assets: `_headers`, `_redirects`, logos, favicon, and **`i18n/*.json`** (see below).
  `search-index.txt` is generated (git-ignored).
- `functions/*.php.js` (logic in `functions-lib/`, tests: `pnpm run test:redirects`) + `public/_redirects` — Cloudflare legacy-URL redirects (see `REDIRECTS.md`).
- `scripts/` — `fetch_dump.mjs` (dump API → `data/scripture.json`), `extract.mjs` (projector → content JSON),
  `build_search_index.mjs`, `precompress_dist.mjs`, `build_sizes.mjs`/`check_sizes.mjs`, i18n/geo generators.
- `content/`, `data/`, `public/search-index.txt`, `dist/` — **generated / local; git-ignored.**

## Icons
Labels carry a [Material Symbols](https://icon-sets.iconify.design/material-symbols/) icon (Apache-2.0) so the
site stays navigable for people who can't read the text; brand marks Material lacks (YouTube, Google Play, Apple)
come from [mdi](https://icon-sets.iconify.design/mdi/) (Apache-2.0). To keep bandwidth low there is **no icon font and no
extra request**: `scripts/gen_icons.mjs` pulls just the icons named in `src/lib/icons.mjs` from the Iconify API and
writes them into `src/styles/icons.css` with `@iconify/utils` as CSS `mask-image` data URIs (~2 KB brotli, cached with the site CSS).
Use one as `<span class="ic ic-<name>" aria-hidden="true"></span>`; it sizes to `1em` and inherits `color`.
The generated CSS is committed — rerun `pnpm run gen:icons` only when the list changes.

## i18n
UI shows in English by default; the other locales are a **client-side** enhancement (`src/scripts/i18n.js`
swaps text from `public/i18n/*.json`). Those catalogs are **code-owned** — committed to the repo and edited
here; the DB `translations_*` tables were a one-time seed, **not** re-run on every build.

## Deploy
Automatic: `.github/workflows/deploy.yml` builds and publishes to Cloudflare Pages on every push to `main`.
Manual and PR-preview details: [`deploy.md`](deploy.md). Known gaps: [`CURRENT-ISSUES.md`](CURRENT-ISSUES.md).
Agent/contributor guide: [`AGENTS.md`](AGENTS.md).
