// node --test functions-lib/   (pnpm run test:redirects)
import { test } from 'node:test';
import assert from 'node:assert/strict';
import { readdirSync, readFileSync } from 'node:fs';
import { makeHandler, resolveLegacy } from './legacy-redirect.js';

// Shape of content/lang-map.json: ngu has one entry, tzo is shared by five.
const map = {
  idx: { 113: 'ngu', 178: 'tzo-00060', 181: 'tzo-01204', 182: 'tzo-02443', 533: 'tzo-02641', 220: 'tzo-02681', 9: 'acr-00000-a' },
  iso: { ngu: 'ngu' },
  multi: ['acr', 'tzo'],
};
const go = (query, lang) => {
  const r = resolveLegacy(new URLSearchParams(query), map, lang);
  return r.notFound ? '404' : `${r.status} ${r.path}`;
};

test('the three reported 00i-Scripture_Index.php links', () => {
  assert.equal(go('iso=ngu', 'eng'), '301 /language/ngu/?lang=eng');
  assert.equal(go('iso=tzo', 'eng'), '302 /language/?iso=tzo&lang=eng');
  assert.equal(go('iso=tzo&rod=02641', 'eng'), '301 /language/tzo-02641/?lang=eng');
});

test('index.php carries no interface language', () => {
  assert.equal(go('iso=ngu'), '301 /language/ngu/');
  assert.equal(go('iso=tzo'), '302 /language/?iso=tzo');
  assert.equal(go('iso=tzo&rod=02641'), '301 /language/tzo-02641/');
  assert.equal(go(''), '301 /');
});

test('no recognized query goes home in the entry point locale', () => {
  assert.equal(go('', 'spa'), '301 /?lang=spa');
  assert.equal(go('foo=bar', 'eng'), '301 /?lang=eng');
});

test('iso edge cases', () => {
  assert.equal(go('iso=NGU', 'eng'), '301 /language/ngu/?lang=eng'); // case-insensitive
  assert.equal(go('iso=ngu&rod=00000&var=', 'eng'), '301 /language/ngu/?lang=eng'); // the old site's own link form
  assert.equal(go('iso=acr&var=a', 'eng'), '301 /language/acr-00000-a/?lang=eng'); // var implies rod 00000
  assert.equal(go('name=tzo&ROD_Code=02641', 'spa'), '301 /language/tzo-02641/?lang=spa'); // verbose synonyms
});

test('idx and country deep links', () => {
  assert.equal(go('idx=533', 'eng'), '301 /language/tzo-02641/?lang=eng');
  assert.equal(go('ISO_ROD_index=113'), '301 /language/ngu/');
  assert.equal(go('sortby=country&name=mx', 'eng'), '301 /country/MX/?lang=eng');
  assert.equal(go('sortby=country&name=all', 'fra'), '301 /browse/?lang=fra');
});

// The old site answered these with "The ISO language code is not found"; a redirect to the
// home page or a nearby language would hide the broken link.
test('links to a language the catalog does not have are 404, not a redirect', () => {
  assert.equal(go('iso=zzz', 'eng'), '404'); // unknown ISO
  assert.equal(go('iso=ngu&rod=99999', 'eng'), '404'); // ROD that does not exist for a known ISO
  assert.equal(go('iso=tzo&rod=2641', 'eng'), '404'); // unpadded ROD never worked
  assert.equal(go('iso=tzo&rod=00000', 'eng'), '302 /language/?iso=tzo&lang=eng'); // default ROD = bare ISO
  assert.equal(go('iso=acr&var=z', 'eng'), '404'); // unknown variant
  assert.equal(go('idx=99999', 'eng'), '404');
  assert.equal(go('idx=abc'), '404');
});

test('handler serves the 404 page with a 404 status', async () => {
  const asked = [];
  const env = { ASSETS: { fetch: async (u) => (asked.push(String(u)), new Response('<h2>Page not found</h2>')) } };
  const res = await makeHandler(map, 'eng')({
    request: new Request('https://scriptureearth.org/00i-Scripture_Index.php?iso=zzz'),
    env,
  });
  assert.equal(res.status, 404);
  assert.equal(res.headers.get('Location'), null);
  assert.deepEqual(asked, ['https://scriptureearth.org/legacy/not-found/']);
  assert.match(await res.text(), /Page not found/);
});

test('handler returns a redirect response', async () => {
  const res = await makeHandler(map, 'eng')({
    request: new Request('https://scriptureearth.org/00i-Scripture_Index.php?iso=tzo&rod=02641'),
  });
  assert.equal(res.status, 301);
  assert.equal(res.headers.get('Location'), '/language/tzo-02641/?lang=eng');
});

// Every .php row in public/_redirects that targets the home page is a legacy index entry
// point: it needs a Function route, or its query-string deep links silently fall back to
// the home page (path-only rules can't read the query). Rows with another target (the
// site-menu pages -> /about/, /contact/, /promotion/) are path-only by design.
test('every legacy index .php redirect row has a Function route in the same locale', () => {
  const rows = readFileSync(new URL('../public/_redirects', import.meta.url), 'utf8')
    .split('\n')
    .map((l) => l.trim().split(/\s+/))
    .filter(([from, target]) => from?.endsWith('.php') && /^\/(\?lang=\w+)?$/.test(target));
  assert.equal(rows.length, 17);
  const routes = new Set(readdirSync(new URL('../functions/', import.meta.url)));
  for (const [from, target] of rows) {
    const file = `${from.slice(1)}.js`;
    assert.ok(routes.has(file), `missing functions/${file}`);
    const src = readFileSync(new URL(`../functions/${file}`, import.meta.url), 'utf8');
    const lang = target.match(/lang=(\w+)/)?.[1];
    assert.ok(src.includes(lang ? `legacyRedirect('${lang}')` : 'legacyRedirect()'), `${file} locale`);
  }
});
