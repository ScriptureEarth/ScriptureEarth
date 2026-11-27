// POST /api/feedback — the floating "Feedback" button (src/components/FeedbackButton.astro).
// Appends a row to a Google Sheet through an Apps Script web app; see functions-lib/feedback.js
// and feedback-sheet/README.md.
import { makeFeedbackHandler } from '../../functions-lib/feedback.js';

export const onRequestPost = makeFeedbackHandler();
