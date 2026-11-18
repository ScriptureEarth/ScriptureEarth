// node --test scripts/dump_fields.test.mjs — synthetic dumps only; no network, no real data.
import { test } from 'node:test';
import assert from 'node:assert/strict';
import { analyse, matches, parsePath, fmtPath, toMarkdown } from './dump_fields.mjs';

const entry = (rel, attrs = {}) => ({ type: 'language', id: '1', attributes: { iso: 'abc', ...attrs }, relationships: { idx: 1, rod: '00000', ...rel } });

test('paths round-trip, including keys with dots', () => {
  const s = 'relationships.links_media["Bible.is"].#.url';
  assert.deepEqual(parsePath(s), ['relationships', 'links_media', 'Bible.is', '#', 'url']);
  assert.equal(fmtPath(parsePath(s)), s);
});

test('wildcards', () => {
  const p = (x) => parsePath(x);
  assert.ok(matches(p('a.#.url'), p('a.#.url')));
  assert.ok(!matches(p('a.#.url'), p('a.b.url')));
  assert.ok(matches(p('a.*.url'), p('a.b.url')));
  assert.ok(matches(p('a.**'), p('a')));
  assert.ok(matches(p('a.**.z'), p('a.b.c.z')));
});

test('reports a new link type and a new column on a known group', () => {
  const r = analyse({
    1: entry({
      links_media: {
        YouVersion: { 0: { url: 'https://bible.com/x', title: 'NT' } },
        Wycliffe_Studio: { 0: { url: 'https://example.org/s', title: 'Studio' } },
        eBible: { 0: { url: 'https://ebible.org/x', title: 'NT', copyright: 'CC BY-SA' } },
      },
    }),
    2: entry({ links_media: { YouVersion: { 0: { url: 'https://bible.com/y' } } } }),
  });
  const paths = r.unclassified.map((p) => p.path);
  assert.deepEqual(paths, [
    'relationships.links_media.Wycliffe_Studio.#.title',
    'relationships.links_media.Wycliffe_Studio.#.url',
    'relationships.links_media.eBible.#.copyright',
  ]);
  assert.equal(r.unclassified[1].withData, 1);
  assert.equal(r.unclassified[1].sample, 'https://example.org/s');
  assert.ok(r.used.some((p) => p.path === 'relationships.links_media.YouVersion.#.url' && p.withData === 2));
});

test('all three link-group shapes count as used', () => {
  const r = analyse([
    entry({ watch: { 0: 'https://a' } }),
    entry({ watch: { 0: { url: 'https://b', watch_what: 'Film' } } }),
    entry({ watch: { url: { 0: 'https://c' }, organization: { 0: 'JF' } } }),
  ]);
  assert.deepEqual(r.unclassified, []);
});

test('empty fields, ignored fields and absent groups', () => {
  const r = analyse([entry({ se_new_thing: {}, watch: {}, links_media: { YouVersion: [] }, se_ePub: { 0: { url: 'x.epub', title: 'format' } } })]);
  assert.deepEqual(r.unclassifiedEmpty.map((p) => p.path), ['relationships.se_new_thing']);
  assert.deepEqual(r.ignored.map((p) => p.path), ['id', 'relationships.se_ePub.#.title', 'type']);
  assert.ok(r.missing.includes('Bible.is'));
  assert.ok(!r.missing.includes('SAB (legacy shape)'));
  assert.ok(!r.missing.includes('ePub'));
});

test('markdown escapes pipes', () => {
  const md = toMarkdown(analyse([entry({ new_field: 'a|b' })]));
  assert.match(md, /a\\\|b/);
});
