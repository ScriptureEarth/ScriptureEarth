# Size benchmark — specification

Implementation-ready spec for a **custom size-regression benchmark** on the Astro
build. It catches systemic bloat — the case where a tweak to one template quietly
inflates every language site — by tracking each page archetype's **cold-load weight**
against a baseline **fetched from the deployed production site**, and failing CI when
a metric grows past a threshold.

This spec is the output of the `astro-size-benchmark` wayfinder map
(`.scratch/astro-size-benchmark/`). Every design decision below traces to a resolved
ticket there; the working extractor core is prototyped on branch
`proto/coldload-benchmark` (`astro/bench/proto/coldload.mjs`).

---

## 1. Metrics & archetypes

### 1.1 The unit: cold-load weight

For each archetype the benchmark computes **cold-load weight** = the bytes a first-time
visitor's browser downloads. It is reported as **two numbers**, each tracked and
thresholded independently:

- **STRICT** — what loads on page render with **no interaction**, for the **English**
  default locale. This is the headline number.
- **WITH-DEFERRED** — STRICT plus the runtime/deferred assets the page will pull
  (see §1.4). Reported as a second number so page-shell bloat and data-payload bloat
  move independently and a regression is localized to one or the other.

Each number is broken into **per-type sub-lines** (html / css / js / img / font / data)
so the cause of a move is visible at a glance.

Shared assets (site CSS, the logo images, shared JS chunks) are counted **in full**
within every archetype that loads them — this is the "cold first-visit" model, and it
is deliberate: a shared bundle growing lifts *every* archetype's number, which is
exactly the "all language sites grew 20%" signal. The same shared files are *also*
tracked once each in the shared per-type buckets (§1.5), giving the complementary
"counted once" view.

### 1.2 Archetypes

| Archetype | Source page | dist path(s) measured |
|---|---|---|
| `home` | `src/pages/index.astro` | `dist/index.html` |
| `browse` (language list) | `src/pages/browse/index.astro` | `dist/browse/index.html` |
| `countries` (country list) | `src/pages/countries/index.astro` | `dist/countries/index.html` |
| `country` | `src/pages/country/[code].astro` | one representative, e.g. `dist/country/NG/index.html` |
| `language` | `src/pages/language/[slug].astro` | **all** `dist/language/*/index.html` (~4,233), aggregated |

`home`, `browse`, `countries`, `country` are tracked as single pages. `language` is
tracked as an **aggregate over every language page** (building all of them is already
part of the normal build — no extra cost), reported as **avg, total, p95, max** of the
per-page cold-load weight. p95/max catch a regression that only hits some pages.

### 1.3 Static dependency computation

Per page, the static (STRICT) dependency set is derived by:

1. **Flat HTML scan** of the page's `index.html` for `href` / `src` / `srcset`
   attributes; keep only root-absolute refs that resolve to a real file in `dist/`
   (drop navigational `<a href>`). A `<picture>` counts only its first `<source>`
   (the format a current browser fetches), not the fallbacks or the `<img>`.
2. **One-level `_astro` JS-graph follow**: for each referenced `/_astro/*.js`, scan its
   source for string refs to sibling `/_astro/*.js` chunks and include those too. Guards
   against a future shared/vendor code-split that isn't named directly in the HTML.
   (In the current build each page's HTML already names exactly its own chunks, so this
   is insurance, not a present need.)

This captures every CSS / JS / image / favicon correctly on real Astro output
(verified in the prototype).

### 1.4 Deferred/runtime dependencies — the recipe

The largest assets are fetched by script at runtime and are **invisible to any HTML
parse**. They are captured by a small **declarative recipe** mapping each archetype to
its runtime deps (not by a headless browser — see ticket 01 rationale). The recipe
encodes two source-level facts:

- **i18n triad** (`src/scripts/i18n.js`): `/i18n/chrome.<loc>.json`,
  `/i18n/names.<loc>.json`, `/i18n/autonyms.json` — fetched **only for a non-English
  locale**. A cold **English** visitor fetches none of these. Model the **largest
  non-English locale**'s triad as worst case in the WITH-DEFERRED number.
- **search index** (`src/pages/index.astro` → `src/scripts/search.js`):
  `/search-index.txt` — fetched **lazily on first search interaction**, only on `home`.
- **world map** (`src/components/WorldMap.astro` → `src/scripts/world-map.js`): the
  content-hashed `/_astro/world-map.<hash>.svg` named in the home page's `data-map-url` —
  fetched **when the map section scrolls near the viewport**, only on `home`.

- **install icon** (`public/manifest.webmanifest`): Chrome fetches the manifest and then
  **one manifest icon after every cold page load**, with no interaction, to decide
  whether the site is installable (seen in a desktop Chrome network log, 2026-11-25:
  `manifest.webmanifest` + `app-icons/icon-192.png`). It does not block rendering, so it
  is DEFERRED on every archetype. Which icon depends on the device, so the recipe takes
  the **heaviest manifest icon below 512px**; the 512px icons load only at install time.
  The manifest itself is an `href` in the HTML and counts as STRICT.
  `<link rel="apple-touch-icon">` is skipped by the HTML scan: no browser fetches it on
  page load.

Recipe shape (all archetypes get the i18n triad and the install icon in deferred;
`home` also gets the search index and the world map):

```js
const I18N_TRIAD = (loc) => [`/i18n/chrome.${loc}.json`, `/i18n/names.${loc}.json`, '/i18n/autonyms.json'];
const WORST_LOCALE = 'spa';           // pick the largest triad at build time; see §7
const ALL = [...I18N_TRIAD(WORST_LOCALE), INSTALL_ICON /* heaviest manifest icon < 512px */];
const RECIPE = {
  home:      { deferred: ['/search-index.txt', MAP_SVG /* from data-map-url */, ...ALL] },
  browse:    { deferred: ALL },
  countries: { deferred: ALL },
  country:   { deferred: ALL },
  language:  { deferred: ALL },
};
```

**Staleness guard (optional, not per-run):** a periodic headless cross-check (one real
browser load per archetype, capturing actual network requests) confirms the recipe
still matches reality. Run it manually or on a schedule, never in the PR gate.

### 1.5 Shared buckets

Independently of archetypes, every file in `dist/` is bucketed by type
(html / css / js / img / font / data / other) and the **per-bucket total** is tracked.
This is the "counted once" view and ensures nothing inflates unseen.

---

## 2. Compression

Every measured file is sized as **raw bytes + wire bytes**, using Node's built-in
`node:zlib` brotli — no new dependency.

- **Wire = brotli quality 4** for normally-served assets. Cloudflare's edge brotli is
  q4 (has been since 2017); this is the representative "bytes users download" number.
  (Free-tier's edge default is actually Zstd, but q4 brotli tracks regressions faithfully
  and is close enough — this is a recorded assumption, not a moving part.)
- **Wire = brotli quality 11** for the one `_headers`-pinned file, `/search-index.txt`,
  which ships pre-compressed and passes through Cloudflare byte-for-byte
  (see `scripts/precompress_dist.mjs`).
- **Raw** bytes reported alongside as a diagnostic — raw and wire sometimes move
  independently, and the gap is informative.

```js
import { brotliCompressSync, constants as Z } from 'node:zlib';
const wire = (buf, pinned) =>
  brotliCompressSync(buf, { params: { [Z.BROTLI_PARAM_QUALITY]: pinned ? 11 : 4 } }).length;
```

---

## 3. Producer — generating `sizes.json`

A post-build script (`scripts/build_sizes.mjs`) walks `dist/`, computes all metrics
above, and writes **`dist/assets/sizes.json`**.

- **Placement:** `dist/assets/sizes.json` → served at `https://<origin>/assets/sizes.json`.
  Using a dedicated `/assets/` dir means **one** `_redirects` guard covers it and any
  future build artifacts.
- **`_redirects` guard (required):** the `/:iso` vanity catch-all in `public/_redirects`
  would otherwise capture `/assets/*`. Add a serve-in-place guard **above** the catch-all:

  ```
  /assets/*  /assets/:splat  200
  ```

  (See `REDIRECTS.md` caveat 3 — any new top-level path needs a guard.)
- **Build hook:** run in `predeploy`, mirroring `precompress_dist.mjs` (which already
  writes into `dist/` post-build). Order: `astro build` → `build_sizes.mjs` →
  `precompress_dist.mjs`. Wire into `package.json`:

  ```json
  "predeploy": "node scripts/build_sizes.mjs && node scripts/precompress_dist.mjs",
  "bench:size": "node scripts/build_sizes.mjs && node scripts/check_sizes.mjs"
  ```

  Note `build_sizes.mjs` measures the **pre-brotli** `dist/` (it computes its own brotli
  numbers); it must run **before** `precompress_dist.mjs` replaces files with their
  compressed bytes, or measure the originals explicitly.

### 3.1 `sizes.json` schema

```jsonc
{
  "schema": 1,
  "generatedAt": "2026-09-05T00:00:00Z",
  "commit": "<git sha>",
  "config": { "wireQuality": 4, "pinnedQuality": 11, "worstLocale": "spa" },
  "archetypes": {
    "home": {
      "strict":   { "wire": 27443, "raw": 55123, "byType": { "html": {...}, "css": {...}, "js": {...}, "img": {...} } },
      "deferred": { "wire": 31810, "raw": 66742, "byType": { "data": {...} } }
    },
    "language": {
      "count": 4233,
      "strict":   { "avg": {...}, "total": {...}, "p95": {...}, "max": {...} },
      "deferred": { "avg": {...}, "total": {...}, "p95": {...}, "max": {...} }
    }
    // browse, countries, country ...
  },
  "buckets": { "html": { "wire": ..., "raw": ..., "count": ... }, "css": {...}, "js": {...}, "img": {...}, "font": {...}, "data": {...} }
}
```

Every leaf size object is `{ "wire": <bytes>, "raw": <bytes> }`.

---

## 4. Baseline & comparison

The baseline is the **`sizes.json` currently deployed to production** — never committed
to the repo, never stored as a CI artifact. Prod self-updates on every deploy, so there
is no baseline file to hand-bump: merging + deploying *is* accepting the new sizes.

`scripts/check_sizes.mjs`:

1. Read the freshly produced `dist/assets/sizes.json` (current build).
2. `fetch()` the baseline from `${SIZE_BENCH_BASELINE_URL:-https://<prod-origin>/assets/sizes.json}`
   (configurable; prod origin is the apex `scriptureearth.org`, currently the
   `se-proto-en.pages.dev` preview).
3. Diff current vs baseline per tracked metric (§5).
4. Render a report and set an exit code (§5, §6).

**First run / no baseline:** if the fetch 404s or fails, **report only** — print the
current sizes as the inaugural baseline and exit 0. Never fail a build for a missing
baseline.

**Schema mismatch:** if `baseline.schema !== current.schema`, report-only and exit 0
(the metric shapes changed; treat as a fresh baseline).

---

## 5. Gating

Config lives in one block (in `check_sizes.mjs` or a sibling `size-bench.config.json`):

```jsonc
{
  "floorBytes": 300,          // ignore any delta smaller than this (per metric) — noise
  "bands": {                  // percentage growth vs baseline
    "archetypeStrict":   { "warn": 2, "fail": 5 },
    "archetypeDeferred": { "warn": 2, "fail": 5 },
    "totalWire":         { "warn": 2, "fail": 5 },   // total-site brotli
    "buckets":           { "warn": 2, "fail": null } // shared buckets warn-only
  }
}
```

Comparison logic per metric (wire bytes are the gated figure; raw is reported only):

- `delta = current - baseline`; skip if `abs(delta) < floorBytes`.
- `pct = delta / baseline * 100`.
- `pct >= fail` → **fail**; `pct >= warn` → **warn**; else **ok**.
- A metric with `fail: null` can only warn.

Gated metrics: each archetype's STRICT wire, each archetype's WITH-DEFERRED wire
(`archetypeDeferred` band applies to the deferred portion), total-site wire. Shared
buckets are warn-only. For `language`, gate **avg** and **p95** (not `total`, which
scales with page count as the catalog grows).

The job **fails** (non-zero exit) if any gated metric lands in its fail band. Warnings
never fail the build.

Defaults are provisional — tune `warn`/`fail`/`floorBytes` once real run-to-run noise
is observed (§7).

---

## 6. Surfaces

### 6.1 Local

```bash
pnpm run bench:size
```

Builds (or reuses) `dist/assets/sizes.json`, fetches the prod baseline, prints a
console table: per-archetype STRICT and WITH-DEFERRED (wire + raw), per-type sub-lines,
shared buckets, and each metric's delta vs baseline with warn/fail markers. Exits
non-zero on a fail-band breach (same logic as CI) so it's usable as a pre-push check.

### 6.2 CI

A job that builds, produces `sizes.json`, fetches the baseline, diffs, posts a **sticky
PR comment**, then gates. The comment uses
**`marocchino/sticky-pull-request-comment@v3`** — one comment per check, updated in
place via its `header:` key, body read from a rendered file. Posting the comment and
failing the job are **separate steps**, so a failing gate still leaves the comment up.

```yaml
permissions:
  contents: read
  pull-requests: write            # required to post/update the comment

jobs:
  size-benchmark:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - uses: actions/setup-node@v4
        with: { node-version: 20, cache: npm, cache-dependency-path: astro/package-lock.json }
      - run: pnpm install --frozen-lockfile
        working-directory: astro
      # build the site + produce dist/assets/sizes.json
      - run: pnpm run build:dump && node scripts/build_sizes.mjs
        working-directory: astro
      # diff vs prod baseline, render markdown table + a verdict file, never fails here
      - run: node scripts/check_sizes.mjs --report size-report.md --verdict size-verdict.txt
        working-directory: astro
      # upsert THIS check's one sticky comment
      - uses: marocchino/sticky-pull-request-comment@v3
        with:
          header: size-benchmark
          path: astro/size-report.md
      # separate gate: comment already posted, THEN fail on a fail-band breach
      - name: Enforce size budget
        run: |
          if [ "$(cat astro/size-verdict.txt)" = "fail" ]; then
            echo "::error::Cold-load size exceeds the fail-band budget"; exit 1
          fi
```

**Fork-PR caveat:** on `pull_request` from a fork, `GITHUB_TOKEN` is read-only and the
comment step 403s. If external-fork PRs must be supported, switch to the
`pull_request_target` or artifact + `workflow_run` two-workflow pattern. For same-repo
PRs, the above is sufficient. (This is a GitHub platform limit, not action-specific.)

The build step above is what shipped as `.github/actions/build-site` (fetch JSON dump →
`extract.mjs` → `astro build`), shared by `deploy.yml` and `preview.yml` (the size benchmark now runs inside `preview.yml`, reusing its build).

---

## 7. Open calibration items (deferred by decision)

- **Threshold tuning.** The warn/fail bands (2% / 5%) and `floorBytes` (300) are
  starting points. Observe several real runs and adjust so legitimate content additions
  don't trip while systemic inflation is caught well below 20%.
- **`WORST_LOCALE` selection.** Pick the largest i18n triad empirically at build time
  (measure all `/i18n/chrome.*.json` + `names.*.json` sets and choose the max) rather
  than hard-coding `spa`; or track the triad total in the shared `data` bucket instead
  of pinning one locale. Decide during implementation.
- **Baseline-freshness wrinkle.** A PR is compared against *live prod*, which is stale
  between merge and deploy; accepted for now. Revisit if a queue of in-flight PRs
  produces confusing readings (e.g. compare against a post-merge preview instead).
- **Per-bucket file counts** as a secondary signal (not just bytes) — cheap to add to
  the `buckets` schema; add if byte-only misses a "many tiny files" regression.

---

## 8. Out of scope

- Absolute performance budgets / Lighthouse performance scores — this guards *size
  regression*, not load performance.
- Exact Zstd wire modeling — brotli q4 is the representative wire number by decision.
- Runtime/load metrics (TTFB, LCP) — size only.
