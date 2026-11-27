/**
 * ScriptureEarth soft-launch feedback → Google Sheet.
 *
 * Paste this file into the sheet's Apps Script editor (Extensions → Apps Script) and deploy it
 * as a web app. The site's Pages Function (astro/functions-lib/feedback.js) POSTs one JSON
 * message per feedback; this script checks the shared secret and appends one row.
 * Setup and the SIL Workspace test: astro/feedback-sheet/README.md.
 *
 * Script properties (Project Settings → Script properties):
 *   SECRET        required. Same value as FEEDBACK_SHEET_SECRET in Cloudflare Pages.
 *                 Run setup() once to create a random one (it is written to the log).
 *   NOTIFY_EMAIL  optional. Comma-separated addresses that get an email for each new row.
 */
const SHEET_NAME = 'Feedback';
const COLUMNS = ['created_at', 'kind', 'message', 'email', 'page', 'locale', 'width', 'user_agent', 'country', 'status'];

/** Run once from the editor: creates the tab and header row, makes a SECRET, asks for permissions. */
function setup() {
  const props = PropertiesService.getScriptProperties();
  if (!props.getProperty('SECRET')) props.setProperty('SECRET', Utilities.getUuid() + Utilities.getUuid());
  sheet_();
  Logger.log('SECRET (copy into Cloudflare Pages as FEEDBACK_SHEET_SECRET): ' + props.getProperty('SECRET'));
  // Touch MailApp so the first authorization also covers the optional notification email.
  Logger.log('Email quota left today: ' + MailApp.getRemainingDailyQuota());
}

/** Health check: open the web app URL in a private browser window. JSON means "Anyone" works. */
function doGet() {
  return out_({ ok: true, service: 'se-feedback' });
}

function doPost(e) {
  let d;
  try {
    d = JSON.parse(e.postData.contents);
  } catch (err) {
    return out_({ ok: false, error: 'bad_body' });
  }
  const secret = PropertiesService.getScriptProperties().getProperty('SECRET');
  if (!secret || d.secret !== secret) return out_({ ok: false, error: 'secret' });

  const row = COLUMNS.map((c) => (c === 'status' ? 'new' : safe_(d[c])));
  const lock = LockService.getScriptLock();
  lock.waitLock(10000);
  try {
    sheet_().appendRow(row);
  } finally {
    lock.releaseLock();
  }
  notify_(d);
  return out_({ ok: true });
}

/** Run from the editor to check the sheet side alone (adds one test row). */
function testAppend() {
  const secret = PropertiesService.getScriptProperties().getProperty('SECRET');
  const res = doPost({ postData: { contents: JSON.stringify({ secret, kind: 'other', message: 'Test row from the editor', page: '/' }) } });
  Logger.log(res.getContent());
}

function sheet_() {
  const ss = SpreadsheetApp.getActiveSpreadsheet();
  let sh = ss.getSheetByName(SHEET_NAME);
  if (!sh) sh = ss.insertSheet(SHEET_NAME);
  if (sh.getLastRow() === 0) {
    sh.appendRow(COLUMNS);
    sh.setFrozenRows(1);
  }
  return sh;
}

// Text that starts with = + - @ would become a formula in the sheet. Visitors write this
// text, so store it as plain text.
function safe_(v) {
  if (v === null || v === undefined) return '';
  if (typeof v === 'number') return v;
  const s = String(v);
  return /^[=+\-@\t\r]/.test(s) ? "'" + s : s;
}

function notify_(d) {
  const to = PropertiesService.getScriptProperties().getProperty('NOTIFY_EMAIL');
  if (!to) return;
  try {
    MailApp.sendEmail({
      to: to,
      subject: 'ScriptureEarth feedback (' + (d.kind || 'other') + ')',
      body: String(d.message || '') + '\n\nPage: ' + (d.page || '') + '\nLocale: ' + (d.locale || '') +
        '\nReply to: ' + (d.email || '(none)') + '\n\n' + SpreadsheetApp.getActiveSpreadsheet().getUrl(),
    });
  } catch (err) {
    // The row is saved; a mail quota or policy problem must not fail the request.
    console.warn('notify failed: ' + err);
  }
}

function out_(o) {
  return ContentService.createTextOutput(JSON.stringify(o)).setMimeType(ContentService.MimeType.JSON);
}
