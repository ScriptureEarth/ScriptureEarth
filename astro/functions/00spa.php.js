// Legacy deep links on /00spa.php -> new routes, keeping the spa interface (REDIRECTS.md).
import { legacyRedirect } from '../functions-lib/route.js';

export const onRequest = legacyRedirect('spa');
