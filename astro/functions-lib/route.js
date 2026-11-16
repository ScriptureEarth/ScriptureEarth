// Binds the legacy resolver to the real lookup map. Each functions/<legacy>.php.js route
// is one line: `export const onRequest = legacyRedirect('<locale>')`.
//
// content/lang-map.json is written by scripts/extract.mjs and bundled into the Functions
// Worker by wrangler at deploy time (so a deploy always needs a prior extract — same as
// dist/ itself). wrangler bundles all routes into one Worker, so the map ships once.

import map from '../content/lang-map.json';
import { makeHandler } from './legacy-redirect.js';

export const legacyRedirect = (lang = null) => makeHandler(map, lang);
