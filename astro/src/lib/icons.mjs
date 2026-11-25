// Site icon registry: semantic name → Iconify icon. scripts/gen_icons.mjs turns it into
// src/styles/icons.css; use an icon as <span class="ic ic-<name>" aria-hidden="true">.
//
// The set is Fluent UI Color (Microsoft, MIT). It is multicolour and small, so:
//   - a bare name is a `fluent-color` icon, drawn as an image in its own colours
//   - gaps fall back to mono `fluent:` icons (same family), tinted by the text colour
//   - brand marks come from `logos:` (CC0)
//
// Add or change an icon here, then run `pnpm run gen:icons`.
// Browse: https://icon-sets.iconify.design/fluent-color/
export const ICON_SET = 'fluent-color';

export const ICONS = {
  search: 'search-sparkle-24',
  home: 'home-24',
  languages: 'fluent:translate-24-regular',
  countries: 'globe-24',
  locale: 'fluent:local-language-24-regular',
  menu: 'fluent:navigation-24-regular',
  // resource rights / groups — match the data-r keys used by pills, facets and groups
  read: 'book-open-24',
  listen: 'headphones-24',
  watch: 'video-24',
  app: 'phone-24',
  buy: 'building-store-24',
  other: 'apps-24',
  // actions
  download: 'fluent:arrow-download-24-regular',
  play: 'fluent:play-24-filled',
  open: 'fluent:open-24-regular',
  // resource-row format badges (see badge() in src/lib/ui.ts)
  web: 'link-24',
  pdf: 'document-text-24',
  audio: 'mic-24',
  video: 'video-24',
  youtube: 'logos:youtube-icon',
  phone: 'phone-24',
  googleplay: 'logos:google-play-icon',
  apple: 'logos:apple',
  print: 'fluent:print-24-regular',
};

/**
 * Icons that card pills draw as `.pill[data-r=<key>]::before`, with no icon element of
 * their own. Keep in step with PILLS in src/lib/ui.ts.
 */
export const PILL_ICONS = ['read', 'listen', 'watch', 'app', 'buy', 'other'];

/** Split a registry value into { set, name }; a bare name belongs to ICON_SET. */
export function parseIcon(value) {
  const i = value.indexOf(':');
  return i === -1 ? { set: ICON_SET, name: value } : { set: value.slice(0, i), name: value.slice(i + 1) };
}
