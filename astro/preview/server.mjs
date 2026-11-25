// Live preview server for database editors.
//
// GET /preview/<idx>/ fetches ONE language from the dump API, runs the normal
// projector (scripts/extract.mjs) and `astro build` on it, and returns that
// language's page. The extract code is not changed: a one-language dump is a
// normal dump with one entry, built with SE_MIN_LANGS=1.
//
// Env:
//   SE_KEY        (required)  API key for /api/db_dump.php
//   SE_BASE       default https://www.scriptureearth.org   API host (on the SE
//                 server this can be the PHP container, e.g. http://server)
//   SE_DUMP_PATH  default /api/db_dump.php
//   SE_DUMP_URL   optional full endpoint URL; overrides SE_BASE + SE_DUMP_PATH
//   SE_SITE_URL   default https://se-proto-en.pages.dev     public new site; every
//                 link off the preview page (home, other languages) goes there
//   PORT          default 8080
//   BUILD_TIMEOUT_MS  default 180000
//
// One build runs at a time (extract and astro write to fixed folders in this
// package). Requests for the same idx while it builds share that build.
import http from 'node:http';
import { spawn } from 'node:child_process';
import { createReadStream, existsSync, statSync } from 'node:fs';
import { cp, mkdir, mkdtemp, readFile, rm, writeFile } from 'node:fs/promises';
import os from 'node:os';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

const HERE = path.dirname(fileURLToPath(import.meta.url));
const ROOT = path.resolve(HERE, '..'); // the astro/ package
const DIST = path.join(ROOT, 'dist');
const CONTENT = path.join(ROOT, 'content');
// Static assets (/_astro, /i18n, icons, logos) of every build so far. Hashed
// names make this safe to merge: a page from an earlier build keeps its files.
const ASSETS = process.env.PREVIEW_ASSETS_DIR || path.join(os.tmpdir(), 'se-preview-assets');

const KEY = process.env.SE_KEY || '';
const BASE = (process.env.SE_BASE || 'https://www.scriptureearth.org').replace(/\/+$/, '');
const DUMP_PATH = process.env.SE_DUMP_PATH || '/api/db_dump.php';
const DUMP_URL = process.env.SE_DUMP_URL || `${BASE}${DUMP_PATH.startsWith('/') ? '' : '/'}${DUMP_PATH}`;
const SITE = (process.env.SE_SITE_URL || 'https://se-proto-en.pages.dev').replace(/\/+$/, '');
const PORT = Number(process.env.PORT || 8080);
const BUILD_TIMEOUT_MS = Number(process.env.BUILD_TIMEOUT_MS || 180000);

if (!KEY && !process.env.SE_DUMP_URL) {
  console.error('FATAL: set SE_KEY (or SE_DUMP_URL with the key in it).');
  process.exit(1);
}

const log = (...a) => console.log(new Date().toISOString(), ...a);
const redact = (s) => String(s).replace(/key=[^&\s]+/gi, 'key=***').split(KEY || '\u0000').join('***');

// ---------- dump ----------

function dumpUrl(idx) {
  const u = new URL(DUMP_URL);
  if (!u.searchParams.has('v')) u.searchParams.set('v', '1');
  u.searchParams.set('idx', String(idx));
  if (KEY && !u.searchParams.has('key')) u.searchParams.set('key', KEY);
  return u.toString();
}

// Returns a dump object holding only the entry for idx, or null if there is none.
// Filters locally too, so this works before the API supports ?idx= (it then
// downloads the full dump, which is slower).
async function fetchOne(idx) {
  const res = await fetch(dumpUrl(idx), { headers: { Accept: 'application/json' } });
  if (!res.ok) throw new Error(`dump API answered HTTP ${res.status}`);
  const all = await res.json();
  for (const [k, e] of Object.entries(all || {})) {
    if (Number(e?.relationships?.idx) === idx) return { [k]: e };
  }
  return null;
}

// ---------- build ----------

function run(cmd, args, env) {
  return new Promise((resolve, reject) => {
    const p = spawn(cmd, args, { cwd: ROOT, env: { ...process.env, ...env }, stdio: ['ignore', 'pipe', 'pipe'] });
    let out = '';
    p.stdout.on('data', (d) => { out += d; });
    p.stderr.on('data', (d) => { out += d; });
    const t = setTimeout(() => p.kill('SIGKILL'), BUILD_TIMEOUT_MS);
    p.on('error', (e) => { clearTimeout(t); reject(e); });
    p.on('close', (code) => {
      clearTimeout(t);
      if (code === 0) resolve(out);
      else reject(new Error(`${path.basename(args[0] || cmd)} failed (exit ${code}):\n${out.slice(-2000)}`));
    });
  });
}

const ASTRO = path.join(ROOT, 'node_modules', 'astro', 'astro.js');

async function build(idx) {
  const started = Date.now();
  const entry = await fetchOne(idx);
  if (!entry) return { notFound: true };

  // Fresh data dir per build: no stale playlist cache, no config.env from elsewhere.
  const tmp = await mkdtemp(path.join(os.tmpdir(), `se-preview-${idx}-`));
  try {
    const json = path.join(tmp, 'scripture.json');
    await writeFile(json, JSON.stringify(entry));
    const env = { SE_JSON: json, SE_DATA_DIR: tmp, SE_MIN_LANGS: '1' };
    await run(process.execPath, ['scripts/extract.mjs'], env);
    await run(process.execPath, ['scripts/build_search_index.mjs'], env);
    await run(process.execPath, ['scripts/gen_map.mjs'], env);
    await run(process.execPath, [ASTRO, 'build'], env);
  } finally {
    await rm(tmp, { recursive: true, force: true });
  }

  const langs = JSON.parse(await readFile(path.join(CONTENT, 'languages.json'), 'utf8'));
  const lang = langs.find((l) => l.idx === idx) || langs[0];
  const slug = lang?.identity?.slug;
  if (!slug) throw new Error('the build produced no language page');
  const html = await readFile(path.join(DIST, 'language', slug, 'index.html'), 'utf8');

  await mkdir(ASSETS, { recursive: true });
  await cp(DIST, ASSETS, { recursive: true, force: true });

  log(`built idx=${idx} slug=${slug} in ${Date.now() - started} ms`);
  return { html: decorate(html, slug), slug };
}

// One build at a time; the same idx asked twice while queued shares one build.
let queue = Promise.resolve();
const pending = new Map();
function buildQueued(idx) {
  if (pending.has(idx)) return pending.get(idx);
  const p = queue.then(() => build(idx)).finally(() => pending.delete(idx));
  queue = p.catch(() => {});
  pending.set(idx, p);
  return p;
}

// ---------- page ----------

const esc = (s) => String(s).replace(/[&<>"]/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' })[c]);

function decorate(html, slug) {
  const when = new Date().toISOString().slice(0, 16).replace('T', ' ') + ' UTC';
  const banner =
    `<div role="note" style="background:#fff4d6;color:#4a3500;border-bottom:2px solid #e0b84a;padding:.6rem 1rem;font:14px/1.4 system-ui,sans-serif;text-align:center">` +
    `<strong>Preview</strong> from the live database, built ${esc(when)}. Reload to see new changes. ` +
    `Links off this page go to the public site. <a href="${esc(`${SITE}/language/${slug}/`)}" style="color:inherit">Open the public page</a></div>`;
  return html
    .replace(/<head([^>]*)>/i, `<head$1><meta name="robots" content="noindex,nofollow">`)
    .replace(/<body([^>]*)>/i, `<body$1>${banner}`);
}

function page(res, status, title, body) {
  res.writeHead(status, { 'Content-Type': 'text/html; charset=utf-8', 'X-Robots-Tag': 'noindex, nofollow', 'Cache-Control': 'no-store' });
  res.end(`<!doctype html><meta charset="utf-8"><meta name="robots" content="noindex,nofollow"><title>${esc(title)}</title>` +
    `<body style="font:16px/1.5 system-ui,sans-serif;max-width:40rem;margin:3rem auto;padding:0 1rem"><h1>${esc(title)}</h1>${body}</body>`);
}

// ---------- static assets ----------

const TYPES = {
  '.js': 'text/javascript', '.css': 'text/css', '.json': 'application/json', '.svg': 'image/svg+xml',
  '.png': 'image/png', '.webp': 'image/webp', '.jxl': 'image/jxl', '.ico': 'image/x-icon',
  '.woff2': 'font/woff2', '.txt': 'text/plain; charset=utf-8', '.xml': 'application/xml',
};

function serveAsset(req, res, urlPath) {
  let rel;
  try { rel = decodeURIComponent(urlPath); } catch { rel = urlPath; }
  const file = path.join(ASSETS, path.normalize(rel));
  const inside = file.startsWith(ASSETS + path.sep);
  const ext = path.extname(file).toLowerCase();
  // HTML pages (home, other languages, countries) come from the public site:
  // the preview build only holds this one language.
  if (!inside || ext === '' || ext === '.html' || !existsSync(file) || !statSync(file).isFile()) {
    res.writeHead(302, { Location: SITE + urlPath + (req.url.includes('?') ? req.url.slice(req.url.indexOf('?')) : '') });
    return res.end();
  }
  const longCache = rel.startsWith('/_astro/');
  res.writeHead(200, {
    'Content-Type': TYPES[ext] || 'application/octet-stream',
    'Cache-Control': longCache ? 'public, max-age=31536000, immutable' : 'no-cache',
  });
  createReadStream(file).pipe(res);
}

// ---------- server ----------

const server = http.createServer(async (req, res) => {
  const url = new URL(req.url, 'http://localhost');
  const p = url.pathname;
  if (req.method !== 'GET' && req.method !== 'HEAD') { res.writeHead(405); return res.end(); }
  if (p === '/healthz') { res.writeHead(200, { 'Content-Type': 'text/plain' }); return res.end('ok'); }

  const m = p.match(/^\/preview\/(\d{1,7})(\/?)$/);
  if (m) {
    if (!m[2]) { res.writeHead(301, { Location: `/preview/${m[1]}/` }); return res.end(); }
    const idx = Number(m[1]);
    try {
      const r = await buildQueued(idx);
      if (r.notFound) return page(res, 404, 'Language not found', `<p>The database has no language with idx ${idx}.</p>`);
      res.writeHead(200, { 'Content-Type': 'text/html; charset=utf-8', 'X-Robots-Tag': 'noindex, nofollow', 'Cache-Control': 'no-store' });
      return res.end(req.method === 'HEAD' ? undefined : r.html);
    } catch (e) {
      log(`build failed idx=${idx}: ${redact(e.message)}`);
      return page(res, 502, 'Preview failed', `<p>The preview could not be built. Reload to try again.</p><pre style="white-space:pre-wrap">${esc(redact(e.message))}</pre>`);
    }
  }
  if (p === '/' || p === '/preview/') {
    return page(res, 200, 'ScriptureEarth preview', '<p>Open <code>/preview/&lt;idx&gt;/</code>, where idx is the language’s index in the database.</p>');
  }
  return serveAsset(req, res, p);
});

server.listen(PORT, () => log(`preview server on :${PORT}, dump ${redact(dumpUrl(0)).replace('idx=0', 'idx=<idx>')}, links to ${SITE}`));
