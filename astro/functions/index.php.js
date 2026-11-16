// Legacy query-string deep links on /index.php (?iso=, ?idx=, ?sortby=country) — see
// REDIRECTS.md. Pages routes this file to /index.php alone, so no other request invokes a
// Function. index.php negotiated the interface language itself, so none is carried over.
import { legacyRedirect } from '../functions-lib/route.js';

export const onRequest = legacyRedirect();
