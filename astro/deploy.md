# Deploy to Cloudflare Pages

Live site: **https://se-proto-en.pages.dev/** (Cloudflare Pages project `se-proto-en`, production branch `main`).

Direct upload via Wrangler — **no Git integration, no build-on-Cloudflare.** The build runs in GitHub
Actions (or locally), and only the finished `dist/` is uploaded. Wrangler is a pinned devDependency and
is always run from this `astro/` dir so it picks up `functions/` alongside `dist/`.

`dist/` is ~4,500 files, well under the **20,000-file Free** limit.

## Automatic (the normal path)

| Trigger | Workflow | What happens |
|---|---|---|
| push to `main` | `.github/workflows/deploy.yml` | fetch dump → build → `pnpm run deploy` → **production** |
| manual | `.github/workflows/deploy.yml` (Run workflow) | same |
| PR to `main` touching `astro/**` | `.github/workflows/preview.yml` | same build, `wrangler pages deploy --branch <pr-branch>` → per-branch **preview URL** posted as a PR comment |
| PR to `main` touching `astro/**` | `.github/workflows/size-benchmark.yml` | build, diff `dist/assets/sizes.json` against production, sticky comment, fail on budget breach |

All three share `.github/actions/build-site` (pnpm install → `fetch:dump` → `build:dump`).

Repository configuration (Settings → Secrets and variables → Actions):

| name | kind | required | purpose |
|---|---|---|---|
| `SE_KEY` | secret | yes | API key for `/api/db_dump.php` |
| `CLOUDFLARE_API_TOKEN` | secret | for publish | token with *Account · Cloudflare Pages · Edit* |
| `CLOUDFLARE_ACCOUNT_ID` | secret | for publish | Cloudflare account id |
| `SE_BASE`, `SE_DUMP_PATH` | variable | no | endpoint overrides (defaults are correct for production) |
| `SIZE_BENCH_BASELINE_URL` | variable | no | override the size-benchmark baseline URL |

Without the two Cloudflare secrets, `deploy.yml` still builds (and fails on data problems) but skips
the publish step; `preview.yml` skips entirely with a notice.

## Manual

**1. Authenticate** — one-time (opens a browser for Cloudflare OAuth):
```bash
pnpm exec wrangler login
```

**2. Build + deploy:**
```bash
SE_KEY=… pnpm run deploy:fresh   # fetch dump -> extract -> build -> precompress -> deploy
pnpm run deploy:dump             # same, from the existing data/scripture.json
pnpm run deploy                  # upload the current dist/ as-is (still runs predeploy)
```
`predeploy` (npm `pre*` lifecycle) writes `dist/assets/sizes.json` and brotli-precompresses the search
index before every deploy. Each deploy publishes a new production deployment (~30 s).

First-time only, if recreating the project:
`pnpm exec wrangler pages project create se-proto-en --production-branch main`.

## What ships alongside the pages
- **`public/_redirects`** (in `dist/`) — legacy path redirects: `00<loc>.php` → `/?lang=<loc>`, and the
  vanity `/‹iso›[-rod[-var]]` → `/language/‹slug›/` collapse (see `REDIRECTS.md`).
- **`functions/*.php.js`** — one route per legacy entry point (`/index.php`, the ten `00<loc>.php` pages,
  the six alias index files such as `00i-Scripture_Index.php`). They handle the legacy **query-string**
  deep links (`?iso=`, `?idx=`, `?sortby=country`) that `_redirects` can't read, resolving `idx`/`iso`
  through `content/lang-map.json` (written by the extract step, bundled by wrangler). Shared logic is in
  `functions-lib/`. Functions are **scoped to those 17 paths**, so every other path is served as a pure
  static file and is not counted as a Functions invocation.
- **`public/_headers`** — immutable caching for `/_astro/*` and `/i18n/*`; `precompress_dist.mjs` appends
  the `Content-Encoding: br` rule for the search index.

## Go-live checklist (Cloudflare dashboard, not this repo)
- Add the custom domain to the Pages project (Pages → Custom domains).
- SSL/TLS → **Always Use HTTPS** on.
- One Redirect Rule: `www.scriptureearth.org/*` → apex (301). `_redirects` cannot express host redirects.
- Keep the legacy PHP host reachable: media, the `/api/db_dump.php` build source, and the CMS still live there
  (the static site links out to `scriptureearth.org/data/...` assets).

## Notes
- **Routing:** absolute paths + trailing slashes work at the `pages.dev` root as-is; no base-path config.
- **Custom domain / HTTP→HTTPS / www:** Cloudflare dashboard, not this repo.
- Renaming the Pages project means creating a new one and updating `se-proto-en` in `package.json`,
  `preview.yml` and `scripts/check_sizes.mjs`.
