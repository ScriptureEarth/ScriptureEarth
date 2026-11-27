// Feedback dialog, loaded on the first click of the floating button
// (src/components/FeedbackButton.astro). Builds a <dialog> once, translates it with the
// site's i18n hook (feedback.* chrome keys; baked English is the fallback), and POSTs JSON
// to the button's data-endpoint. On any failure it shows a mailto link with the message
// pre-filled, so nothing typed is lost.
// Styles live here (not a .css import): Astro drops CSS imported by a lazily loaded chunk.
const CSS = `
.fb-dlg {
  width: min(32rem, calc(100vw - 2 * var(--s4)));
  max-height: calc(100dvh - 2 * var(--s4));
  padding: var(--s5);
  border: 1px solid var(--border);
  border-radius: var(--radius);
  background: var(--surface);
  color: var(--text);
  box-shadow: var(--shadow-md);
}
.fb-dlg::backdrop { background: rgba(0, 48, 73, 0.35); }
.fb-dlg :focus-visible { outline: 3px solid var(--ring); outline-offset: 2px; }
.fb-dlg [hidden] { display: none; }
.fb-head { display: flex; align-items: start; justify-content: space-between; gap: var(--s3); }
.fb-head h2 { margin: 0; color: var(--heading); font-size: var(--t-h3); }
.fb-x { border: 0; background: none; color: var(--muted); font-size: 1.6rem; line-height: 1; cursor: pointer; padding: 0 var(--s1); }
.fb-lead { margin: var(--s2) 0 var(--s4); color: var(--muted); }
.fb-kinds { display: flex; flex-wrap: wrap; gap: var(--s2) var(--s4); margin: 0 0 var(--s4); padding: 0; border: 0; }
.fb-kinds label { display: inline-flex; align-items: center; gap: var(--s1); cursor: pointer; }
.fb-field { display: flex; flex-direction: column; gap: var(--s1); margin-block-end: var(--s4); font-weight: 600; color: var(--heading); }
.fb-field textarea,
.fb-field input {
  font: 400 var(--t-body) / 1.4 var(--font);
  color: var(--text);
  padding: var(--s2) var(--s3);
  border: 1px solid var(--border);
  border-radius: var(--radius-sm);
  background: var(--surface-2);
  resize: vertical;
}
.fb-opt { font-weight: 400; color: var(--muted); font-size: var(--t-sm); }
.fb-hp { position: absolute; inset-inline-start: -9999px; width: 1px; height: 1px; overflow: hidden; }
.fb-vh { position: absolute; width: 1px; height: 1px; overflow: hidden; clip: rect(0 0 0 0); white-space: nowrap; }
.fb-note { margin: 0 0 var(--s3); color: var(--muted); font-size: var(--t-sm); }
.fb-err { margin: 0 0 var(--s3); color: #b42318; font-weight: 600; }
.fb-actions { display: flex; justify-content: flex-end; }
.fb-btn {
  padding: var(--s2) var(--s5);
  border: 0;
  border-radius: var(--pill);
  background: var(--cta);
  color: var(--cta-text);
  font: 600 var(--t-body) / 1.2 var(--font);
  cursor: pointer;
}
.fb-btn:hover { background: var(--accent-hover); }
.fb-send:disabled { opacity: 0.6; cursor: progress; }
.fb-big { font-size: var(--t-lead); color: var(--heading); font-weight: 600; }
.fb-mail { font-weight: 600; word-break: break-all; }
`;

const HTML = `
<form class="fb-form" novalidate>
  <div class="fb-head">
    <h2 id="fb-title" data-i18n="feedback.title">Tell us what you think</h2>
    <button type="button" class="fb-x" aria-label="Close" data-i18n-label="feedback.close">×</button>
  </div>
  <p class="fb-lead" data-i18n="feedback.lead">This is the new ScriptureEarth site. What works, what is broken, what is missing?</p>
  <fieldset class="fb-kinds">
    <legend class="fb-vh" data-i18n="feedback.kind">Type of feedback</legend>
    <label><input type="radio" name="kind" value="problem"> <span data-i18n="feedback.kind.problem">Something is wrong</span></label>
    <label><input type="radio" name="kind" value="idea"> <span data-i18n="feedback.kind.idea">An idea</span></label>
    <label><input type="radio" name="kind" value="other" checked> <span data-i18n="feedback.kind.other">Other</span></label>
  </fieldset>
  <label class="fb-field"><span data-i18n="feedback.message">Your feedback</span>
    <textarea name="message" rows="5" maxlength="4000" required></textarea></label>
  <label class="fb-field"><span><span data-i18n="feedback.email">Email</span> <span class="fb-opt" data-i18n="feedback.optional">(optional, only if you want a reply)</span></span>
    <input type="email" name="email" autocomplete="email" maxlength="254"></label>
  <label class="fb-hp" aria-hidden="true">Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label>
  <p class="fb-note"><span data-i18n="feedback.pageNote">We also send the address of this page.</span> <a href="/about/privacy/" data-i18n="nav.privacy">Privacy Policy</a></p>
  <p class="fb-err" hidden data-i18n="feedback.required">Please write a message.</p>
  <p class="fb-err" hidden data-i18n="feedback.badEmail">Please check the email address.</p>
  <div class="fb-actions"><button type="submit" class="fb-btn fb-send" data-i18n="feedback.send">Send</button></div>
</form>
<div class="fb-done" hidden>
  <p class="fb-big" data-i18n="feedback.thanks">Thank you! We read every message.</p>
  <div class="fb-actions"><button type="button" class="fb-btn fb-close" data-i18n="feedback.close">Close</button></div>
</div>
<div class="fb-fail" hidden>
  <p data-i18n="feedback.failed">Sorry, we could not send your message. Please email it to us:</p>
  <p><a class="fb-mail"></a></p>
  <div class="fb-actions"><button type="button" class="fb-btn fb-close" data-i18n="feedback.close">Close</button></div>
</div>`;

let dlg;

function build(opener) {
  const style = document.createElement('style');
  style.textContent = CSS;
  document.head.appendChild(style);
  dlg = document.createElement('dialog');
  dlg.className = 'fb-dlg';
  dlg.setAttribute('aria-labelledby', 'fb-title');
  dlg.innerHTML = HTML;
  document.body.appendChild(dlg);
  if (window.__seApplyI18n) window.__seApplyI18n(dlg);

  const form = dlg.querySelector('.fb-form');
  const send = dlg.querySelector('.fb-send');
  const done = dlg.querySelector('.fb-done');
  const fail = dlg.querySelector('.fb-fail');
  const mail = dlg.querySelector('.fb-mail');
  const [errMsg, errEmail] = dlg.querySelectorAll('.fb-err');
  const to = opener.dataset.mail;
  mail.textContent = to;
  mail.href = `mailto:${to}`;

  dlg.show = (view = form) => {
    for (const v of [form, done, fail]) v.hidden = v !== view;
    errMsg.hidden = errEmail.hidden = true;
  };
  // Light dismiss: a click on the backdrop lands on the <dialog> element itself.
  dlg.addEventListener('click', (e) => { if (e.target === dlg) dlg.close(); });
  dlg.querySelectorAll('.fb-x, .fb-close').forEach((b) => b.addEventListener('click', () => dlg.close()));
  dlg.addEventListener('close', () => opener.focus());

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const f = form.elements;
    const message = f.message.value.trim();
    const email = f.email.value.trim();
    errMsg.hidden = message.length >= 2;
    errEmail.hidden = !email || f.email.checkValidity();
    if (!errMsg.hidden) { f.message.focus(); return; }
    if (!errEmail.hidden) { f.email.focus(); return; }

    send.disabled = true;
    let ok = false;
    try {
      const r = await fetch(opener.dataset.endpoint, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          kind: f.kind.value,
          message,
          email,
          website: f.website.value,
          page: location.href,
          locale: window.__seLoc || 'eng',
          width: window.innerWidth,
        }),
      });
      ok = r.ok;
    } catch { /* offline or blocked: fall back to email */ }
    send.disabled = false;
    if (ok) {
      form.reset();
      dlg.show(done);
      return;
    }
    mail.href = `mailto:${to}?subject=${encodeURIComponent('ScriptureEarth feedback')}&body=${encodeURIComponent(`${message}\n\n${location.href}`)}`;
    dlg.show(fail);
  });
}

export function openFeedback(opener) {
  if (!dlg) build(opener);
  if (dlg.open) return;
  dlg.show();
  dlg.showModal();
  dlg.querySelector('textarea').focus();
}
