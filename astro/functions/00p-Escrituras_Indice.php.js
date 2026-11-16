// Legacy deep links on /00p-Escrituras_Indice.php -> new routes, keeping the por interface (REDIRECTS.md).
import { legacyRedirect } from '../functions-lib/route.js';

export const onRequest = legacyRedirect('por');
