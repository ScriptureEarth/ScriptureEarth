// node --test functions-lib/   (pnpm run test:redirects)
import { test } from 'node:test';
import assert from 'node:assert/strict';
import { makeFeedbackHandler, validateFeedback } from './feedback.js';

test('validate: message is required, the rest is optional', () => {
  assert.deepEqual(validateFeedback({ message: '' }), { ok: false, error: 'message_required' });
  const v = validateFeedback({ message: '  The map is slow  ' });
  assert.equal(v.ok, true);
  assert.deepEqual(v.row, { kind: 'other', message: 'The map is slow', email: '', page: '', locale: '', width: null });
});

test('validate: honeypot, email, kind, page, locale, width', () => {
  assert.equal(validateFeedback({ message: 'hi there', website: 'x' }).error, 'spam');
  assert.equal(validateFeedback({ message: 'hi there', email: 'nope' }).error, 'bad_email');
  const v = validateFeedback({
    message: 'hi there', email: 'a@b.org', kind: 'problem',
    page: 'https://se-proto-en.pages.dev/language/ngu/?lang=spa#x', locale: 'spa', width: 390,
  });
  assert.deepEqual(v.row, { kind: 'problem', message: 'hi there', email: 'a@b.org', page: '/language/ngu/?lang=spa', locale: 'spa', width: 390 });
  const w = validateFeedback({ message: 'hi there', kind: 'drop table', page: 'javascript:alert(1)', locale: '../x', width: -4 });
  assert.deepEqual([w.row.kind, w.row.page, w.row.locale, w.row.width], ['other', '', '', null]);
});

const ENV = { FEEDBACK_SHEET_URL: 'https://script.example/exec', FEEDBACK_SHEET_SECRET: 's3cret' };
// Stand-in for the Apps Script web app: records calls, answers like the real one.
const fakeSheet = (answer = { ok: true }, { status = 200, html = false, throws = false } = {}) => {
  const calls = [];
  const f = async (url, opts) => {
    calls.push({ url, opts, body: JSON.parse(opts.body) });
    if (throws) throw new Error('network');
    return new Response(html ? '<html>Sign in</html>' : JSON.stringify(answer), { status });
  };
  f.calls = calls;
  return f;
};
const post = (body, { origin = 'https://se.example', length } = {}) => {
  const headers = { 'Content-Type': 'application/json', 'User-Agent': 'test' };
  if (origin) headers.Origin = origin;
  if (length) headers['Content-Length'] = String(length);
  return new Request('https://se.example/api/feedback', { method: 'POST', headers, body: JSON.stringify(body) });
};

test('handler: sends the row with the secret and answers ok', async () => {
  const sheet = fakeSheet();
  const res = await makeFeedbackHandler(sheet)({ request: post({ message: 'Love it', kind: 'idea', page: '/' }), env: ENV });
  assert.equal(res.status, 200);
  assert.deepEqual(await res.json(), { ok: true });
  assert.equal(sheet.calls.length, 1);
  const { url, opts, body } = sheet.calls[0];
  assert.equal(url, ENV.FEEDBACK_SHEET_URL);
  assert.equal(opts.method, 'POST');
  assert.equal(opts.redirect, 'follow');
  assert.equal(body.secret, 's3cret');
  assert.deepEqual([body.kind, body.message, body.email, body.page, body.user_agent], ['idea', 'Love it', '', '/', 'test']);
  assert.match(body.created_at, /^\d{4}-\d\d-\d\dT/);
});

test('handler: sheet failures give 502 so the dialog falls back to email', async () => {
  for (const sheet of [
    fakeSheet({ ok: false, error: 'secret' }),
    fakeSheet(null, { html: true }), // web app not open to "Anyone": Google sign-in page
    fakeSheet({ ok: true }, { status: 500 }),
    fakeSheet(null, { throws: true }),
  ]) {
    const res = await makeFeedbackHandler(sheet)({ request: post({ message: 'x y' }), env: ENV });
    assert.equal(res.status, 502);
  }
});

test('handler: refusals', async () => {
  const sheet = fakeSheet();
  const h = makeFeedbackHandler(sheet);
  assert.equal((await h({ request: post({ message: 'x y' }, { origin: 'https://evil.example' }), env: ENV })).status, 403);
  assert.equal((await h({ request: post({ message: 'x y' }, { origin: null }), env: ENV })).status, 403);
  assert.equal((await h({ request: post({ message: 'x y' }), env: {} })).status, 503);
  assert.equal((await h({ request: post({ message: 'x y' }), env: { FEEDBACK_SHEET_URL: ENV.FEEDBACK_SHEET_URL } })).status, 503);
  assert.equal((await h({ request: post({ message: '' }), env: ENV })).status, 400);
  assert.equal((await h({ request: post({ message: 'x y' }, { length: 99999 }), env: ENV })).status, 413);
  const bot = await h({ request: post({ message: 'buy now', website: 'http://spam' }), env: ENV });
  assert.equal(bot.status, 200);
  assert.equal(sheet.calls.length, 0);
});
