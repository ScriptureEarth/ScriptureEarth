// Legacy deep links on /00por.php -> new routes, keeping the por interface (REDIRECTS.md).
import { legacyRedirect } from '../functions-lib/route.js';

export const onRequest = legacyRedirect('por');
