// Legacy deep links on /00deu.php -> new routes, keeping the deu interface (REDIRECTS.md).
import { legacyRedirect } from '../functions-lib/route.js';

export const onRequest = legacyRedirect('deu');
