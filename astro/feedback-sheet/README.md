# Feedback → Google Sheet

The floating **Feedback** button on the site posts to `/api/feedback` (Pages Function,
`functions/api/feedback.js`). The Function checks the message and sends it to an **Apps Script web
app** that is bound to a Google Sheet. The script (`Code.gs`) adds one row per message.

```
browser ──POST /api/feedback──► Pages Function ──POST {secret, row}──► Apps Script /exec ──► Sheet row
          (same origin, honeypot,               (FEEDBACK_SHEET_URL,          (checks SECRET,
           size limits)                          FEEDBACK_SHEET_SECRET)        optional email)
```

Columns: `created_at, kind, message, email, page, locale, width, user_agent, country, status`.
`status` starts as `new`; use it for triage. Text that starts with `= + - @` is stored as plain text,
so visitors cannot put formulas in the sheet.

Until both Pages variables exist, `/api/feedback` answers 503 and the dialog shows the contact email
with the message filled in. If the script fails, it answers 502 and the dialog does the same.

## Set up and test in a Google Workspace (for example SIL)

Do the steps in order. Each **Check** tells you if the Workspace allows this design. If a check
fails, stop: see "If a check fails" below.

1. **Make the sheet.** Make a new Google Sheet with your Workspace account. A shared drive is better
   than My Drive, so the sheet does not belong to one person.
2. **Add the script.** In the sheet: Extensions → Apps Script. Delete the sample code, paste
   `Code.gs`, and save.
3. **Run `setup`.** Pick `setup` in the function list and click Run. Give the permissions it asks for
   (the sheet, and send email as you).
   - **Check A:** if Google says the app is blocked or needs admin approval, the Workspace blocks
     Apps Script (or this kind of script).
   - The log shows the `SECRET`. It is also in Project Settings → Script properties.
4. **Run `testAppend`.** A row "Test row from the editor" appears in the `Feedback` tab.
5. **Deploy as a web app.** Deploy → New deployment → type **Web app**.
   Execute as: **Me**. Who has access: **Anyone**. Deploy, and copy the URL that ends in `/exec`.
   - **Check B:** if "Anyone" is not in the list (only "Anyone within …"), the Workspace does not
     allow public web apps. The site cannot use this script.
6. **Open the URL in a private browser window** (not signed in to Google).
   - **Check C:** you see `{"ok":true,"service":"se-feedback"}`. A Google sign-in page means the
     web app is not open to everyone.
7. **Send a test row from outside Google** (any terminal):
   ```bash
   curl -sL -X POST 'https://script.google.com/macros/s/…/exec' \
     -H 'Content-Type: application/json' \
     -d '{"secret":"PASTE-SECRET","kind":"other","message":"curl test","page":"/"}'
   ```
   - **Check D:** the answer is `{"ok":true}` and a "curl test" row appears. With a wrong secret
     the answer is `{"ok":false,"error":"secret"}` and no row appears.
8. **Optional email alert.** In Project Settings → Script properties, add `NOTIFY_EMAIL` (one or
   more addresses, comma separated). Send another curl test; each address gets an email.
9. **Connect the site.** Cloudflare dashboard → Pages → `se-proto-en` → Settings → Variables and
   Secrets, for Production (and Preview if you want previews to save too):
   - `FEEDBACK_SHEET_URL` = the `/exec` URL (plain text)
   - `FEEDBACK_SHEET_SECRET` = the `SECRET` (type **Secret**)

   Redeploy, open the site, click **Feedback** and send a message.

### Test the site side on your computer

```bash
cd astro
pnpm run build            # after an extract, as usual
printf 'FEEDBACK_SHEET_URL=https://script.google.com/macros/s/…/exec\nFEEDBACK_SHEET_SECRET=…\n' > .dev.vars
pnpm exec wrangler pages dev dist
# open http://localhost:8788/ and use the Feedback button
```

`.dev.vars` holds the secret. Do not commit it (it is in `.gitignore`).

## Change the script later

Edit `Code.gs` here, paste it into the editor, then Deploy → Manage deployments → edit (pencil) →
Version: **New version** → Deploy. The `/exec` URL stays the same. A **new** deployment gets a new
URL, and then `FEEDBACK_SHEET_URL` must change too.

## If a check fails

- Ask the Workspace admins to allow Apps Script web apps with access "Anyone" for this one script.
- Or keep the data in Cloudflare D1 instead (the first version of this branch, commit `09e5218`).
- Do not move the sheet to a personal Google account: visitors' email addresses would leave the
  organization.

## Limits to know

- The web app runs as the account that deployed it. If that account is closed, saving stops (the
  dialog then falls back to email). Deploy from an account the team keeps.
- Apps Script has daily quotas (run time, emails sent). They are far above soft-launch traffic.
- Everyone who can open the sheet can read visitors' email addresses. Share it only with the team.
