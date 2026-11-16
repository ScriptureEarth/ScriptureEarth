// Legacy deep links on /00fra.php -> new routes, keeping the fra interface (REDIRECTS.md).
import { legacyRedirect } from '../functions-lib/route.js';

export const onRequest = legacyRedirect('fra');
