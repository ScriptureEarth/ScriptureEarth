// Soft-launch feedback: validation + hand-off to a Google Sheet for functions/api/feedback.js.
// Pure functions so `node --test functions-lib/` (pnpm run test:redirects) covers them.
//
// Storage is a Google Sheet. An Apps Script web app bound to the sheet
// (feedback-sheet/Code.gs) appends one row per message. The Pages project needs two
// environment variables (Pages → Settings → Variables and Secrets):
//   FEEDBACK_SHEET_URL     the web app's /exec URL
//   FEEDBACK_SHEET_SECRET  the same value as the script property SECRET (type: Secret)
// With either missing the endpoint answers 503 and the dialog offers the contact email
// instead, so the button is safe to ship before the sheet exists. See feedback-sheet/README.md.

export const KINDS = ['problem', 'idea', 'other'];
export const LIMITS = { message: 4000, email: 254, page: 2048, locale: 8, ua: 512 };

const clip = (v, n) => String(v ?? '').trim().slice(0, n);
// Loose on purpose: we only use it to reply. A typo should not lose the message.
const EMAIL = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

/**
 * Check and normalise a submitted body. Returns { ok: true, row } or { ok: false, error }.
 * `website` is a honeypot: real visitors never see it, so any value means a bot.
 */
export function validateFeedback(body) {
  if (!body || typeof body !== 'object') return { ok: false, error: 'bad_body' };
  if (clip(body.website, 200)) return { ok: false, error: 'spam' };
  const message = clip(body.message, LIMITS.message);
  if (message.length < 2) return { ok: false, error: 'message_required' };
  const email = clip(body.email, LIMITS.email);
  if (email && !EMAIL.test(email)) return { ok: false, error: 'bad_email' };
  const kind = KINDS.includes(body.kind) ? body.kind : 'other';
  let page = clip(body.page, LIMITS.page);
  // Keep only the path + query of our own pages; drop anything that is not a URL.
  try {
    const u = new URL(page);
    page = /^https?:$/.test(u.protocol) ? u.pathname + u.search : '';
  } catch {
    page = page.startsWith('/') && !page.startsWith('//') ? page : '';
  }
  const locale = /^[a-z]{3}$/.test(body.locale) ? body.locale : '';
  const width = Number.isInteger(body.width) && body.width > 0 && body.width < 20000 ? body.width : null;
  return { ok: true, row: { kind, message, email, page, locale, width } };
}

/** Same-origin check: the browser always sends Origin on a fetch POST. */
export function sameOrigin(request) {
  const origin = request.headers.get('Origin');
  return !!origin && origin === new URL(request.url).origin;
}

const json = (status, data) =>
  new Response(JSON.stringify(data), {
    status,
    headers: { 'Content-Type': 'application/json; charset=utf-8', 'Cache-Control': 'no-store' },
  });

/**
 * Send one validated row to the Apps Script web app. Apps Script answers a POST with a 302
 * to a googleusercontent.com URL that holds the script's output; fetch follows it.
 * A Google sign-in page (HTML) instead of JSON means the web app is not open to "Anyone".
 */
export async function sendToSheet(env, row, fetchImpl = fetch) {
  const r = await fetchImpl(env.FEEDBACK_SHEET_URL, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ secret: env.FEEDBACK_SHEET_SECRET, ...row }),
    redirect: 'follow',
  });
  let data = null;
  try { data = await r.json(); } catch { /* sign-in page or error page */ }
  return !!(r.ok && data && data.ok);
}

/** Pages Function handler factory (POST only; Pages answers 405 for other methods). */
export function makeFeedbackHandler(fetchImpl = (...a) => fetch(...a)) {
  return async ({ request, env }) => {
    if (!sameOrigin(request)) return json(403, { ok: false, error: 'origin' });
    if (!env || !env.FEEDBACK_SHEET_URL || !env.FEEDBACK_SHEET_SECRET) return json(503, { ok: false, error: 'not_configured' });
    if (Number(request.headers.get('Content-Length') || 0) > 16384) return json(413, { ok: false, error: 'too_large' });
    let body;
    try { body = await request.json(); } catch { return json(400, { ok: false, error: 'bad_body' }); }
    const v = validateFeedback(body);
    // Pretend a bot succeeded so it does not retry with another value.
    if (!v.ok) return v.error === 'spam' ? json(200, { ok: true }) : json(400, v);
    const row = {
      ...v.row,
      created_at: new Date().toISOString(),
      user_agent: clip(request.headers.get('User-Agent'), LIMITS.ua),
      country: (request.cf && request.cf.country) || '',
    };
    let saved = false;
    try { saved = await sendToSheet(env, row, fetchImpl); } catch { /* network */ }
    // 502: the dialog then offers the contact email with the message pre-filled.
    return saved ? json(200, { ok: true }) : json(502, { ok: false, error: 'store_failed' });
  };
}
