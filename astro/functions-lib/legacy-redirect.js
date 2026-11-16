// ScriptureEarth — legacy query-string deep-link resolver (REDIRECTS.md).
//
// Pure logic shared by every functions/<legacy>.php.js route. It lives outside functions/
// so Cloudflare Pages does not turn it into a route of its own, and it takes the lookup
// map as an argument so it can be unit-tested without a content/ extract.
//
// `map` is content/lang-map.json (scripts/extract.mjs): idx -> slug for ?idx=; iso -> slug
// for ISOs with one entry; multi = ISOs shared by several entries, which go to the
// /language/ chooser page.
//
// A link that names a language the catalog doesn't have (unknown ISO or idx, or a ROD /
// variant that doesn't exist for that ISO) is a real 404, as the old site answered "The ISO
// language code is not found". It is never sent to the home page or a nearby language:
// that would hide a broken link. Only a request with NO language/country query goes home,
// because that URL was the old home page (and still is with ?fbclid=, ?utm_*= etc.).
//
// `lang` is the interface locale the legacy entry point forced (00eng.php -> 'eng',
// 00e-Escrituras_Indice.php -> 'spa'); null for /index.php, which negotiated it. It is
// carried onto every target as ?lang= so the visitor keeps the language the old link gave.

const slugSets = new WeakMap(); // built once per map (i.e. once per isolate)
const isSlug = (map, s) => {
  let set = slugSets.get(map);
  if (!set) slugSets.set(map, (set = new Set(Object.values(map.idx))));
  return set.has(s);
};

const MISSING_PATH = '/legacy/not-found/';
export const NOT_FOUND = Object.freeze({ notFound: true });

// -> { path, status } for the redirect this legacy request should get, or NOT_FOUND.
export function resolveLegacy(q, map, lang = null) {
  const withLang = (path) => (lang ? `${path}${path.includes('?') ? '&' : '?'}lang=${lang}` : path);
  const to = (path, status) => ({ path: withLang(path), status });

  // L7 — country deep link: ?sortby=country&name=<CC>  (name=all -> whole grid)
  if (q.get('sortby') === 'country') {
    const cc = (q.get('name') || '').trim();
    if (!cc || cc.toLowerCase() === 'all') return to('/browse/', 301);
    return to(`/country/${cc.toUpperCase()}/`, 301);
  }

  // L6 — idx-keyed deep links (machine-generated integer key). Direct 301 via the map.
  const idx = q.get('idx') || q.get('ISO_ROD_index');
  if (idx) {
    const slug = /^\d+$/.test(idx) && map.idx[idx];
    return slug ? to(`/language/${slug}/`, 301) : NOT_FOUND;
  }

  // L6/L3 — iso-keyed deep links (canonical ?iso=&rod=&var= and verbose synonyms).
  const iso = (q.get('iso') || q.get('name') || '').trim().toLowerCase();
  if (iso) {
    const rod = (q.get('rod') || q.get('ROD_Code') || '').trim();
    const varc = (q.get('var') || q.get('Variant_Code') || '').trim().toLowerCase();
    // Same slug rule as makeSlug() in scripts/extract.mjs: the default ROD 00000 is left
    // out unless a variant follows it.
    if (varc || (rod && rod !== '00000')) {
      const slug = varc ? `${iso}-${rod || '00000'}-${varc}` : `${iso}-${rod}`;
      return isSlug(map, slug) ? to(`/language/${slug}/`, 301) : NOT_FOUND;
    }
    if (rod && isSlug(map, iso)) return to(`/language/${iso}/`, 301); // explicit default ROD
    if (map.iso[iso]) return to(`/language/${map.iso[iso]}/`, 301); // one entry for this ISO
    if (map.multi.includes(iso)) return to(`/language/?iso=${encodeURIComponent(iso)}`, 302); // chooser
    return NOT_FOUND;
  }

  // No recognized query -> home, in the entry point's locale.
  return to('/', 301);
}

// Pages Function handler factory. NOT_FOUND serves the site's 404 page (dist/404.html) with
// a 404 status at the legacy URL itself, so the broken link stays visible in the address
// bar, in logs and to crawlers.
export const makeHandler = (map, lang = null) => async (context) => {
  const url = new URL(context.request.url);
  const r = resolveLegacy(url.searchParams, map, lang);
  if (r.notFound) {
    // Ask the asset server for a path that cannot exist: it answers with dist/404.html.
    // (Not /404.html itself: the single-segment /:iso vanity rule in _redirects claims it.)
    const page = await context.env.ASSETS.fetch(new URL(MISSING_PATH, url));
    return new Response(page.body, {
      status: 404,
      headers: { 'Content-Type': 'text/html; charset=utf-8', 'Cache-Control': 'no-store' },
    });
  }
  return new Response(null, { status: r.status, headers: { Location: r.path } });
};
