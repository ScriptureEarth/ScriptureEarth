// Client localizer. English HTML is source of truth; this swaps chrome
// (data-i18n) and names (data-i18n-name) from /i18n/*.json, cached in
// localStorage. window.__seApplyI18n(root) localizes dynamically inserted nodes.
import locales from '../../public/i18n/locales.json';

const orig = new WeakMap();
const VER = window.__seI18nVer || '';
const Q = VER ? `?v=${VER}` : '';

try {
  if (localStorage.getItem('se-ver') !== VER) {
    for (const k of Object.keys(localStorage)) {
      if (/^se-(chrome|names|autonyms)/.test(k)) localStorage.removeItem(k);
    }
    localStorage.setItem('se-ver', VER);
  }
} catch { /* private mode */ }

function cacheGet(k) {
  try { return JSON.parse(localStorage.getItem(k)); } catch { return null; }
}

let AUTO = cacheGet('se-autonyms') || null;

function baked(n, attr) {
  const key = attr || 'text';
  const m = orig.get(n) || {};
  if (!(key in m)) {
    m[key] = attr ? n.getAttribute(attr) : n.textContent;
    orig.set(n, m);
  }
  return m[key];
}

// Country names come from the browser's CLDR data (Intl.DisplayNames), keyed by the
// ISO 3166 code in data-i18n-country; the baked English name is the fallback.
let dn = null;
let dnLang = '';
function countryName(code) {
  const lang = document.documentElement.lang;
  try {
    if (lang !== dnLang) { dn = new Intl.DisplayNames([lang], { type: 'region' }); dnLang = lang; }
    const n = dn.of(code);
    return n && n !== code ? n : null;
  } catch {
    return null;
  }
}

function apply(chrome, names, root = document) {
  // Capture baked English before overwrite so switching back to English restores it.
  // A template with {n} (e.g. "{n} chapters") is filled from data-i18n-n.
  root.querySelectorAll('[data-i18n]').forEach((n) => {
    const b = baked(n);
    const tpl = chrome && chrome[n.getAttribute('data-i18n')];
    const num = n.getAttribute('data-i18n-n');
    n.textContent = tpl ? (num != null ? tpl.replace('{n}', num) : tpl) : b;
  });
  root.querySelectorAll('[data-i18n-country]').forEach((n) => {
    const b = baked(n);
    n.textContent = countryName(n.getAttribute('data-i18n-country')) || b;
  });
  root.querySelectorAll('[data-i18n-ph]').forEach((n) => {
    const b = baked(n, 'placeholder');
    n.setAttribute('placeholder', (chrome && chrome[n.getAttribute('data-i18n-ph')]) || b);
  });
  root.querySelectorAll('[data-i18n-label]').forEach((n) => {
    const b = baked(n, 'aria-label');
    n.setAttribute('aria-label', (chrome && chrome[n.getAttribute('data-i18n-label')]) || b);
  });
  root.querySelectorAll('[data-i18n-name]').forEach((n) => {
    const b = baked(n);
    const k = n.getAttribute('data-i18n-name');
    n.textContent = (names && names[k]) || (AUTO && AUTO[k]) || b;
  });
  document.documentElement.removeAttribute('data-i18n-pending');
}

function toEnglish(root = document) {
  root.querySelectorAll('[data-i18n]').forEach((n) => { n.textContent = baked(n); });
  root.querySelectorAll('[data-i18n-ph]').forEach((n) => { n.setAttribute('placeholder', baked(n, 'placeholder')); });
  root.querySelectorAll('[data-i18n-label]').forEach((n) => { n.setAttribute('aria-label', baked(n, 'aria-label')); });
  root.querySelectorAll('[data-i18n-name]').forEach((n) => { n.textContent = baked(n); });
  root.querySelectorAll('[data-i18n-country]').forEach((n) => { n.textContent = baked(n); });
  document.documentElement.removeAttribute('data-i18n-pending');
}

function okjson(r) {
  return r.ok ? r.json() : {};
}

function localize(loc, root) {
  if (loc === 'eng') { toEnglish(root); return; }
  const c = cacheGet('se-chrome-' + loc);
  const nm = cacheGet('se-names-' + loc);
  const au = AUTO || cacheGet('se-autonyms');
  if (c && nm && au) {
    AUTO = au;
    apply(c, nm, root);
    return;
  }
  Promise.all([
    c ? Promise.resolve(c) : fetch('/i18n/chrome.' + loc + '.json' + Q).then(okjson),
    nm ? Promise.resolve(nm) : fetch('/i18n/names.' + loc + '.json' + Q).then(okjson),
    au ? Promise.resolve(au) : fetch('/i18n/autonyms.json' + Q).then(okjson),
  ]).then((a) => {
    try {
      localStorage.setItem('se-chrome-' + loc, JSON.stringify(a[0]));
      localStorage.setItem('se-names-' + loc, JSON.stringify(a[1]));
      localStorage.setItem('se-autonyms', JSON.stringify(a[2]));
    } catch { /* quota */ }
    AUTO = a[2];
    apply(a[0], a[1], root);
  }).catch(() => {
    document.documentElement.removeAttribute('data-i18n-pending');
  });
}

window.__seApplyI18n = function (root) {
  const loc = window.__seLoc || 'eng';
  if (loc === 'eng') return;
  const c = cacheGet('se-chrome-' + loc);
  const nm = cacheGet('se-names-' + loc);
  const au = AUTO || cacheGet('se-autonyms');
  if (c && nm && au) {
    AUTO = au;
    apply(c, nm, root || document);
  } else {
    localize(loc, root || document);
  }
};

// The HTML is baked in English, so an English first load has nothing to undo. Skipping
// toEnglish here avoids ~24k no-op textContent writes (and a full relayout) on /browse/.
if ((window.__seLoc || 'eng') === 'eng') document.documentElement.removeAttribute('data-i18n-pending');
else localize(window.__seLoc);

const sel = document.getElementById('locale-picker');
if (sel) {
  sel.value = window.__seLoc || 'eng';
  sel.addEventListener('change', () => {
    const nl = sel.value;
    localStorage.setItem('se-loc', nl);
    window.__seLoc = nl;
    const meta = locales[nl];
    const el = document.documentElement;
    el.lang = meta?.bcp || 'en';
    el.dir = meta?.dir || 'ltr';
    localize(nl);
  });
}
