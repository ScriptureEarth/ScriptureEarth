# Redirect layer (ticket 08) — Cloudflare Pages

Implements the resolved URL-scheme decision (`issues/08-url-scheme-redirect-map.md` §Answer,
`research/08-url-redirects.md`). Two files:

- **`public/_redirects`** — path-only redirects (Cloudflare copies it to the deploy root).
- **`functions/*.php.js`** — one Function route per legacy `.php` entry point (17), for query-string deep links `_redirects` can't read. Shared logic: `functions-lib/legacy-redirect.js`.

Assumes **slug strategy (B)**: the language-detail slug *is* the legacy vanity string
`<iso>[-<rod>][-<var>]`, so `/language/kek/`, `/language/abt-3053/`, `/language/acr-00000-a/`. Exception: Deaf languages with the placeholder ISO `qqq` use `sgn-<rod>`
(`/language/sgn-ao84/`); `?iso=qqq&rod=` resolves there. The legacy `/qqq-<rod>` vanity rows
all name retired RODs, so they 404 like any other missing language.
This is what collapses ~3,779 legacy rows to 3 rules and removes the iso→idx lookup entirely.

## What each rule group does

### `public/_redirects`
| Group | Rows | Effect |
|---|---|---|
| L1 HTTP→HTTPS / www→apex | 0 | **Not in this file** — handled by CF "Always Use HTTPS" + one www→apex Redirect Rule (see below). |
| Precedence guards | 10 | Reserved dirs (`/assets/ /browse/ /country/ /language/ /i18n/`) + the 5 known top-level dotted assets. `200` = serve-in-place, stops matching, so the `/:iso` catch-all can't shadow them. |
| L3/L4/L5 homepages + aliases | 17 | 10 `00<loc>.php` + 6 localized alias index files → `/?lang=<loc>` (301); `/index.php` → `/` (302, provisional). |
| L2 vanity → detail | 3 | `/:iso-:rod-:var`, `/:iso-:rod`, `/:iso` → `/language/<same>/` (301). Most-specific first. Replaces the 3,779 legacy `Redirect 301` lines 1:1, no lookup, except the 5 with an uppercase ROD (`/ncj-C`, `/tuk-Iran`…): Pages matches paths case-sensitively and slugs are lowercase, so each has its own row above these. |

### `functions/*.php.js` (query-string deep links)
Pages routes a file named `functions/<name>.php.js` to `/<name>.php` only. There is one per legacy entry
point: `/index.php`, the ten `00<loc>.php` locale pages and the six alias index files
(`00i-Scripture_Index.php` → eng, `00e-Escrituras_Indice.php` → spa, `00p-…` → por, `00f-…` → fra,
`00d-…` → nld, `00de-…` → deu). Each is one line, `legacyRedirect('<loc>')`, naming the interface locale
that entry point forced on the old site (none for `/index.php`, which negotiated it). On the old site the
alias files just 302'd to `00<loc>.php` with the same query string, so both get the same treatment here.

The resolver (`functions-lib/legacy-redirect.js`, bound to the map by `functions-lib/route.js`) maps:
- `?sortby=country&name=<CC>` → `/country/<CC>/` (301); `name=all`/empty → `/browse/` (301).  *(L7)*
- `?idx=` / `?ISO_ROD_index=<n>` → `/language/<slug>/` (301) via the bundled idx→slug map; unknown idx → **404**.  *(L6 idx-form)*
- `?iso=`/`?name=` (+ `rod`/`ROD_Code`, `var`/`Variant_Code`) → `/language/<slug>/` (301) when that slug exists, **404** when a ROD/variant is given that the ISO doesn't have (default ROD `00000` counts as no ROD); bare `?iso=` with one entry → its slug (301); an ISO shared by several entries → `/language/?iso=<iso>` (302, chooser page); unknown ISO → **404**.  *(L3/L6 iso-form)*
- no recognized query → `/` (301). That URL was the old home page, and it still is with unrelated
  params (`?fbclid=`, `?utm_*=`), so this is not a fallback for broken links.

**Broken links are 404, never a redirect.** A link naming a language the catalog doesn't have used to
get "The ISO language code is not found" on the old site. Here the Function answers it in place with
the site's 404 page (`src/pages/404.astro`) and a 404 status, so it shows up in logs and to crawlers
instead of being hidden behind the home page or a neighbouring language.

**Interface language:** a locale entry point appends `lang=<loc>` to whatever target it resolves, so
`/00i-Scripture_Index.php?iso=tzo&rod=02641` → `/language/tzo-02641/?lang=eng` and a plain
`/00spa.php` → `/?lang=spa`, as the old site kept the visitor in that file's language.

**Tests:** `pnpm run test:redirects` (`functions-lib/legacy-redirect.test.mjs`, no extract needed). It also
fails if a home-page `.php` row in `_redirects` has no route file, or one in a different locale.

**Lookup map:** `scripts/extract.mjs` writes `content/lang-map.json` (`idx` → slug for every entry, `iso` → slug
for the ~4,000 ISOs with exactly one entry, `multi` = the 96 ISOs shared by several entries). The Function
imports it, so wrangler bundles it into the Worker at deploy time (~100 KB, one property read per request;
a deploy therefore always needs a prior extract, as `dist/` does). The only case that cannot be resolved
at the edge — a shared ISO with no ROD — goes to `src/pages/language/index.astro`, which bakes just those
96 card groups and shows the matching one as a chooser (not-found fallback otherwise).

## Cap headroom
Cloudflare Pages cap: **2,000 static + 100 dynamic = 2,100**.

| | Used | Cap |
|---|---|---|
| `_redirects` static rows | **34** (14 guards + 17 homepages/aliases + 3 vanity) | 2,000 |
| `_redirects` dynamic (splat/placeholder) rows | counted within the 34; ≪ 100 | 100 |
| Pages Functions route files | 17 (bundled into one Worker) | — |

~34 of 2,000 — >98% headroom. The 2,100 cap is a non-issue once slug=(B) removes per-entry enumeration.

## Shadowing / precedence reasoning
`_redirects` placeholders are **not** anchored regex and `/:iso` matches *any* single path segment —
including top-level asset files (`site.css`, `sil-logo.webp`, …) and bare section names. First match
wins, so the fix is ordering: the **guard block sits above the vanity rules**, matching the real
routes/assets first (`200` serve-in-place) so `/:iso` never reaches them. The dashed forms
(`/:iso-:rod`) are also guarded because `sil-logo.webp` etc. contain a dash. `/index.php` and
`/00*.php` are `.php`, so the Function inspects them *before* `_redirects` (Functions run first on
Pages); the Function answers every hit on those paths itself, so the static `.php` rules are only a backstop.

## Caveats for the build team
1. **Adopt slug=(B).** Everything here assumes the public route is the iso-vanity slug with `idx` kept
   internal. If the team keeps raw `[idx]` in the URL, the `?iso=`→slug map still works but the vanity
   `_redirects` rules need a real idx↔slug map — see research/08 §3.4 (the Function already bundles one).
2. **HTTP→HTTPS / www→apex** live in CF settings, not this repo: enable *SSL/TLS → Always Use HTTPS*
   and add a Bulk/Single Redirect `www.scriptureearth.org/* → https://scriptureearth.org/:splat` (301).
3. **New top-level dotted assets** must get a guard line in `_redirects`, or the `/:iso` catch-all will
   redirect them to `/language/<file>/`. Safer long-term: move the bare `/:iso` rule into the Function
   (regex `^[a-z]{2,3}(-[0-9A-Za-z]{1,5})?(-[a-z])?$` won't match dotted assets or reserved words);
   the dashed `/:iso-:rod[-var]` forms can stay as placeholders.
4. **Landing target** for the homepage redirects is `/` pending the ticket-04 landing decision; flip to
   `/browse/` in one place. `/index.php` is 302 until that target is final, then make it 301.
5. **Scoped to per-path route files** (not a root `_middleware.js` or `[[path]].js`) so Pages invokes
   Functions only on the 17 legacy `.php` paths — home/pages/assets are pure static and not counted as
   Functions invocations. A new legacy entry point needs a `_redirects` row *and* a route file.
6. **`?st=<iso>`** ("start at", L4) is not mapped (it lands on the locale home), and niche `.php`
   (`iso_direct.php`) have no rule at all. An unpadded ROD (`rod=2641`) never
   worked on the old site either; it is a 404. Add a final `/*.php / 302` safety net only if
   server-log sweep shows meaningful traffic (§5.6).
   The legacy site-menu pages are mapped path-only: `00<loc>-CTPHC.php` (any `?I=` section) → `/about/`,
   `/Feedback/Feedback.php` → `/contact/`, `/promotionMaterials/promotion.php` → `/promotion/`. Not the rest of
   `/promotionMaterials/*`: `/promotion/` links the video and print originals there on the legacy host.
7. **Validate ordering with `wrangler pages dev` / preview** before launch — confirm `/site.css`,
   `/browse/`, `/aaa`, `/abt-3053`, `/index.php?iso=abt&rod=3053`, `/00i-Scripture_Index.php?iso=tzo&rod=02641`,
   and `?sortby=country&name=GT` all
   resolve as intended.
