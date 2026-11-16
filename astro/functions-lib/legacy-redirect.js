// ScriptureEarth — legacy query-string deep-link resolver (REDIRECTS.md).
//
// Pure logic shared by every functions/<legacy>.php.js route. It lives outside functions/
// so Cloudflare Pages does not turn it into a route of its own, and it takes the lookup
// map as an argument so it can be unit-tested without a content/ extract.
//
// `map` is content/lang-map.json (scripts/extract.mjs): idx -> slug for ?idx=; iso -> slug
// for ISOs with one entry. An ISO shared by several entries (or an unknown one) goes to
// the /language/ page, which shows a chooser or the not-found fallback.
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

// -> { path, status } for the redirect this legacy request should get.
export function resolveLegacy(q, map, lang = null) {
  const withLang = (path) => (lang ? `${path}${path.includes('?') ? '&' : '?'}lang=${lang}` : path);
  const to = (path, status) => ({ path: withLang(path), status });
  const chooser = (params) => to(`/language/?${params}`, 302); // chooser / not-found landing

  // L7 — country deep link: ?sortby=country&name=<CC>  (name=all -> whole grid)
  if (q.get('sortby') === 'country') {
    const cc = (q.get('name') || '').trim();
    if (!cc || cc.toLowerCase() === 'all') return to('/browse/', 301);
    return to(`/country/${cc.toUpperCase()}/`, 301);
  }

  // L6 — idx-keyed deep links (machine-generated integer key). Direct 301 via the map;
  // an unknown idx lands on the /language/ page, which shows the not-found fallback.
  const idx = q.get('idx') || q.get('ISO_ROD_index');
  if (idx && /^\d+$/.test(idx)) {
    const slug = map.idx[idx];
    return slug ? to(`/language/${slug}/`, 301) : chooser(`idx=${idx}`);
  }

  // L6/L3 — iso-keyed deep links (canonical ?iso=&rod=&var= and verbose synonyms).
  const iso = (q.get('iso') || q.get('name') || '').trim().toLowerCase();
  if (iso) {
    let rod = (q.get('rod') || q.get('ROD_Code') || '').trim();
    const varc = (q.get('var') || q.get('Variant_Code') || '').trim().toLowerCase();
    if (varc && !rod) rod = '00000'; // variant present but rod omitted -> default rod
    if (rod || varc) {
      let slug = iso;
      if (rod) slug += `-${rod}`;
      if (varc) slug += `-${varc}`;
      if (isSlug(map, slug)) return to(`/language/${slug}/`, 301);
      // Assembled slug doesn't exist (stale rod/var) — fall through to bare-iso resolution.
    }
    if (map.iso[iso]) return to(`/language/${map.iso[iso]}/`, 301); // one entry for this ISO
    return chooser(`iso=${encodeURIComponent(iso)}`); // shared ISO -> chooser; unknown -> not found
  }

  // No recognized query -> home, in the entry point's locale.
  return to('/', 301);
}

// Pages Function handler factory.
export const makeHandler = (map, lang = null) => (context) => {
  const { path, status } = resolveLegacy(new URL(context.request.url).searchParams, map, lang);
  return new Response(null, { status, headers: { Location: path } });
};
