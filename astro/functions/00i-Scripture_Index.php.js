// Legacy deep links on /00i-Scripture_Index.php -> new routes, keeping the eng interface (REDIRECTS.md).
import { legacyRedirect } from '../functions-lib/route.js';

export const onRequest = legacyRedirect('eng');
