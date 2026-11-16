// Legacy deep links on /00kor.php -> new routes, keeping the kor interface (REDIRECTS.md).
import { legacyRedirect } from '../functions-lib/route.js';

export const onRequest = legacyRedirect('kor');
