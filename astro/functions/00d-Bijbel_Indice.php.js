// Legacy deep links on /00d-Bijbel_Indice.php -> new routes, keeping the nld interface (REDIRECTS.md).
import { legacyRedirect } from '../functions-lib/route.js';

export const onRequest = legacyRedirect('nld');
