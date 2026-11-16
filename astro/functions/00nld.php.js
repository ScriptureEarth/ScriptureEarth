// Legacy deep links on /00nld.php -> new routes, keeping the nld interface (REDIRECTS.md).
import { legacyRedirect } from '../functions-lib/route.js';

export const onRequest = legacyRedirect('nld');
