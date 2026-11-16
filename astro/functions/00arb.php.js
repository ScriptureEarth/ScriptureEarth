// Legacy deep links on /00arb.php -> new routes, keeping the arb interface (REDIRECTS.md).
import { legacyRedirect } from '../functions-lib/route.js';

export const onRequest = legacyRedirect('arb');
