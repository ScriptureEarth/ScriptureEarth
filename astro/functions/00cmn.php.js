// Legacy deep links on /00cmn.php -> new routes, keeping the cmn interface (REDIRECTS.md).
import { legacyRedirect } from '../functions-lib/route.js';

export const onRequest = legacyRedirect('cmn');
