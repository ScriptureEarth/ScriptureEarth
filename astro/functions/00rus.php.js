// Legacy deep links on /00rus.php -> new routes, keeping the rus interface (REDIRECTS.md).
import { legacyRedirect } from '../functions-lib/route.js';

export const onRequest = legacyRedirect('rus');
