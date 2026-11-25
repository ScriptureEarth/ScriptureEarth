# Live preview for database editors

A small Node server that shows how one language's page will look on the new site,
built from the live database. An editor saves in the PHP editor, then opens
`/preview/<idx>/` on this server.

On each request the server:

1. Gets that one language from the dump API (`db_dump.php?v=1&idx=<idx>&key=…`).
2. Runs the normal build on it: `scripts/extract.mjs` (with `SE_MIN_LANGS=1`),
   `build_search_index.mjs`, `gen_map.mjs`, then `astro build`. No build code is changed.
3. Returns the language page, with a yellow "Preview" bar and `noindex`.

A preview takes about 2 to 4 seconds (more for languages with many playlists, because
their `.txt` files are fetched fresh each time). One build runs at a time. Two requests
for the same idx share one build.

Links off the preview page (home, browse, other languages, countries) redirect to the
public site (`SE_SITE_URL`), because the preview build holds only the one language.

## Environment

| Variable | Required | Default | Purpose |
|---|---|---|---|
| `SE_KEY` | yes | | API key for `db_dump.php` (a row in `api_users`) |
| `SE_BASE` | no | `https://www.scriptureearth.org` | Host of the API. On the SE server, use the PHP container, for example `http://server` |
| `SE_DUMP_PATH` | no | `/api/db_dump.php` | API path |
| `SE_DUMP_URL` | no | | Full API URL; replaces `SE_BASE` + `SE_DUMP_PATH` |
| `SE_SITE_URL` | no | `https://se-proto-en.pages.dev` | Public new site, for links off the preview page |
| `PORT` | no | `8080` | Port the server listens on |
| `BUILD_TIMEOUT_MS` | no | `180000` | A build step that runs longer than this is stopped |

The key never shows in logs or error pages.

## The dump API's `idx` filter

The server sends `idx=<idx>` to `db_dump.php` and then keeps only the entry whose
`relationships.idx` matches. So:

- **Before** `db_dump.php` supports `idx`, the preview still works, but each preview
  downloads the full dump (slower).
- **After** `db_dump.php` supports `idx` (same JSON shape, one entry), each preview
  downloads only that language. See `DUMP-API-REQUESTS.md`.

## Build and run

From the `astro/` folder:

```bash
docker build -f preview/Dockerfile -t se-preview .
docker run -d --name se-preview -p 8081:8080 -e SE_KEY=… -e SE_BASE=https://www.scriptureearth.org se-preview
# then open http://localhost:8081/preview/<idx>/
```

Without Docker (after `pnpm install`):

```bash
SE_KEY=… node preview/server.mjs
```

### Docker Compose on the SE server

Add a service next to the PHP `server` service in `compose.yaml`. `SE_BASE` can point at
the PHP container, so the API call stays on the server:

```yaml
  preview:
    build:
      context: ./astro            # path to this repo's astro/ folder
      dockerfile: preview/Dockerfile
    restart: always
    environment:
      - SE_KEY=${SE_PREVIEW_KEY}  # an api_users key
      - SE_BASE=http://server     # the PHP container
    ports:
      - 9002:8080
```

Then publish it on a path or subdomain of the SE site in the web server config (for
example `preview.scriptureearth.org`).

## Link from the PHP editor

In `Scripture_Edit.php`, after a save (or next to the language being edited), add a link
to the preview, for example:

```php
<?php $previewBase = getenv('SE_PREVIEW_URL') ?: 'https://preview.scriptureearth.org'; ?>
<a href="<?= htmlspecialchars($previewBase) ?>/preview/<?= (int)$idx ?>/" target="_blank" rel="noopener">Preview on the new site</a>
```

## Things to know

- The preview is public to anyone who can reach the server, but it shows only what the
  database already shows on the old site. Each request runs a build (a few seconds of
  CPU), so do not expose it where crawlers or the whole internet can hammer it, or put it
  behind the web server's basic auth.
- `GET /healthz` returns `ok` (used by the Docker health check).
- The image is large (about 1.7 GB), because it installs all dev dependencies, wrangler
  included. The extract step needs `d3-geo`, a dev dependency.
