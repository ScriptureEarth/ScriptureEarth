# `db_dump.php` — requested additions

The static Astro rebuild builds entirely from `GET /api/db_dump.php?v=1&key=…` (one JSON
object keyed by row ordinal; the real key is `relationships.idx`). Comparing the JSON build
against the data the **old SQLite dump** produced surfaced fields the dump drops. Everything
below **already exists in the database and in the committed granular API** — the aggregated
`db_dump.php` just needs to carry it. File/line refs are to the current committed API.

The dump is already inconsistent about this: `se_media.playlist_video` carries
`{ title:{…}, filename:{…} }`, but `watch` and `buy` are bare URL lists. The ask is to make
the rest consistent with the playlist pattern.

## Status (2026-09-23)

Nearly all **done**. Titles/organizations are in for watch/buy/apps/links, Bible.is
read/listen/view is split via `media_type` (1–8), buy's title is now the `title` key, and
`eBible` now carries `title` + `description`. The dev also added `se_iPhone` (App Store apps)
and `se_ePub`. NOTE: the dump has now settled on an **array-of-objects** shape
(`{ "0": { title, url, … } }`) for watch/buy/links/playlists/apps; `extract.mjs`'s `linkRows()`
tolerates that plus the two earlier shapes, so future flips won't silently break us.

Playlists are now fully used: audio playlists emit per-track mp3 links (parsed from the
JS-object audio `.txt`), and video clips show thumbnails (`data/~images/<subfolder>/<img>` when
the video `.txt` header's 3rd field is `images`).

Still open / to confirm:
- **`study` table** — still absent from the dump (~610 languages have no study/tools resource).
- **`se_ePub`** — present but `url` is a bare filename (e.g. `Keley-i Bible.epub`) with no
  resolvable path, and `title` is often junk (`"format"`); not emitted yet. Please give full
  URLs (like `se_media.text`) and a real title, or confirm the `/data/<iso>/…` path.
- **`other_websites`** — sometimes only has `organization`, no `title` (minor).
- **`SAB_scriptoria` (SAB HTML readers)** — **DONE (2026-09-28).** `se_sab` is now
  `{ "0": { path, url, description } }` per reader: `path` = SE-hosted folder as a full URL,
  `url` = external reader. 1019 languages, 1099 readers; all listed first in Read. Two small
  nits: 7 `url`s are site-relative without a trailing slash (`/data/mlg/sab/bts` — we
  absolutize them), and `description` keeps the legacy `- ` / `: ` lead-in (we strip it).
  The original request follows for reference.
  - **Local readers** (`subfolder` set, e.g. `sab/adj/`): the legacy page opens
    `/data/<iso>/sab/<subfolder minus "sab/">/`. The dump's `se_sab.text`/`audio` gives only the
    reader's HTML file basenames (`adj-01-MAT-000.html`), not the folder. Guessing it is
    unreliable: `<iso>` resolves for 94/114 languages and the file prefix for 89/114. `<iso>` can
    also open the wrong translation where one ISO has several (`bpe` rows 522/523/525: files
    `wraP-…`/`wraB-…`/`wraS-…`; neither `/data/bpe/sab/bpe/` nor `/sab/wraP/` exists).
  - **External readers** (`url` set, `subfolder` empty, e.g. `skn` idx 2770 →
    `https://media.ipsapps.org/skn/osa/bible/index.html`; `lao` idx 877 →
    `https://laobible.sea-sda.org/#/read`, description `: Read online`): absent from the dump
    entirely. `se_sab` is `{"text":{},"audio":{}}` and no entry contains an `/osa/` URL. Some
    languages have several (`lif`: "Limbu Bible" and "Limbu Hymns").
  - **Coverage:** in the legacy SQLite snapshot, 936 languages have an SAB reader (785 local,
    158 external), but the dump's `se_sab` lists files for only 114.

## New (2026-11): `idx` filter for the editor preview

The live editor preview (`preview/`, see `preview/README.md`) builds one language at a
time. Please accept an optional `idx` parameter:

```
GET /api/db_dump.php?v=1&idx=1234&key=…
```

It should return the **same JSON shape** as the full dump, with only the entry whose
`relationships.idx` is 1234 (and `{}` when there is none). Until this exists, the preview
downloads the full dump and filters it itself, which works but is slow.

## Columns at a glance

One row per DB column the dump should carry but currently doesn't:

| Table | Column | Why we want it |
|---|---|---|
| `watch` | `watch_what` | The video's title (e.g. "My Last Day"), instead of a generic "YouTube". |
| `watch` | `organization` | Who produced/hosts the video (often the local-language title) — shown as the source. |
| `buy` | `buy_what` | The printed edition's title, instead of a generic "Printed edition". |
| `buy` | `organization` | The store/publisher selling it (Lulu.com, Virtual Storehouse, …). |
| `CellPhone` | `Cell_Phone_Title` | The app's name, instead of a generic "Android app" / "iOS app". |
| `links` | `company_title` | The edition/version name for web links (YouVersion, Bibles.org, GRN, Bible.is). |
| `links` | `BibleIs` | Code marking a Bible.is link as text / audio / both, so it can be listed under Read **and** Listen (~2000 languages lost their Bible.is audio without it). |
| `eBible_list` | `title` | The eBible edition's title, instead of a generic "eBible edition". |
| `study` | `ScriptureDescription` | The study/reference tool's title (the whole `study` table is absent; ~610 languages). |
| `study` | `ScriptureURL` | The study tool's link (fall back to `othersiteURL` when empty). |
| `SAB_scriptoria` | `subfolder`, `url`, `description` | **Done** — `se_sab` now carries `{ path, url, description }` rows for every reader. |

The first 8 are columns the dump can already reach (the granular API emits them); the two
`study` rows plus `links.BibleIs` are the additions that need real work. Detail below.

## Priority 1 — titles/organizations that were on the old site

| dump field | today | add | source in DB / committed API |
|---|---|---|---|
| `watch` | `{ "0": "<url>" }` | `{ title:{…}, organization:{…}, url:{…} }` (parallel maps, like `playlist_video`) | `watch.watch_what`, `watch.organization` — already emitted by [`api/general_links.php:315-362`](api/general_links.php) as `title`/`organization`/`URL` |
| `buy` | `{ "0": "<url>" }` | `{ title:{…}, organization:{…}, url:{…} }` | `buy.buy_what`, `buy.organization` — rendered on the live page ([`include/00-SpecificLanguage.inc.php:3807`](include/00-SpecificLanguage.inc.php)) |
| `se_apps` (`android`/`ios`), `se_google_play` | `{ "0": "<url>" }` | include the app title | `CellPhone.Cell_Phone_Title` — emitted as `title` in [`api/languageNames.php`](api/languageNames.php) |
| `links_media` (`YouVersion`, `eBible`, `Bible.is`) | `{ "0": "<url>" }` | include the edition/version title | `links.company_title` (+ eBible `title`) — see [`api/general_links.php`](api/general_links.php) |

The projector reads whatever it can; where a title is absent it falls back to a generic label
("Printed edition", "YouTube", "eBible edition"). These labels are the visible symptom.

## Priority 2 — resources missing from the dump entirely

| what | status | source | notes |
|---|---|---|---|
| **Bible.is audio** | dump can't distinguish text vs audio | `scripture_main.BibleIs` code (1–4) | The old site listed Bible.is under **both read and listen** using the `BibleIs` code (2,3,4 → text; 1,3,4 → audio). The dump gives one `links_media["Bible.is"]` URL with no type, so ~2,000 languages lost their Bible.is **listen** entry. Please expose the type (a code, or split `Bible.is_text` / `Bible.is_audio`). |
| **Study tools** | absent from the dump | `study` table (`ScriptureURL` / `othersiteURL`, `ScriptureDescription`) | ~600 languages had a study/tools resource; there is no `study` field in the dump at all. |

## Priority 2b — shown on the page as placeholders today (2026-11)

The new site shows a visible placeholder (amber, dashed) wherever the dump lacks what's
needed, so these gaps are easy to spot on a language page:

| placeholder | count | what's missing | source in DB |
|---|---|---|---|
| **Title missing** | 646 PDFs, 11 audio, 20 video | `other_titles.other_PDF` / `other_audio` / `other_video_download` are bare URLs. The old page printed `other` + `other_title` (e.g. mil: "Read selecciones del Antiguo Testamento: Historias antiguas"). | `other_titles.other`, `other_titles.other_title` |
| **Playlist file not found** | 568 video playlists (564 are `JESUSFilm-<iso>.txt`) | The playlist `.txt` the dump names returns 404 on scriptureearth.org (e.g. `/data/aaa/video/JESUSFilm-aaa.txt`). Either remove the rows or restore the files. | `PlaylistVideo` |
| **Zip not available** | 12 playlists | The download playlist's filename has spaces/parentheses (`arzLUK(Lumo).txt`, `LukeVideo-beo .txt`, …), which `00-PlaylistDownloadVideoZip.php` rejects (`^[a-zA-Z0-9._-]*$`), or the file is missing (`qws-ScrSlide-download.txt`). The legacy page can't zip these either. | file names on disk |
| **File location unknown** | 1 (Keley-i) | `se_ePub` gives `"Keley-i Bible.epub"` with no folder, and a junk title `"format"`. Please send a full URL and a real title. | ePub table |
| **Book not recognized** | 5 testament audio sets | Testament audio files carry no book/chapter numbers in the dump, so the projector parses them from the filename (~99% agree with the DB). Adding `book` + `chapter` per file (the DB has `OT/NT_Audio_Book`, `…_Chapter`) would remove the guesswork. | `OT_Audio_Media`, `NT_Audio_Media` |
| **Link missing** | 1 `watch` row | A row with a title but no URL. | `watch` |

## Priority 3 — confirmations (no change needed, just verify stability)

- `se_media.text` / `audio` values are now **full URLs** (were basenames). Fine — just confirm this is intentional and stable.
- `se_media.playlist_video` / `playlist_audio` = `{ title:{…}, filename:{…} }` with full URLs. Good — this is the shape we want everywhere.
- Has the dump format changed more than once recently? Two different shapes have been observed within a few days. A `v=` bump on breaking shape changes would let the build pin a known-good version.

## How we guard against silent breakage

`extract.mjs` has a data audit (`SE_STRICT=1` to fail the build): for every dump field it
compares "languages that have raw data" vs "languages we emitted a row from" — if a field has
data but yields nothing, the shape changed. It also reports `watch`/`buy` title coverage. This
is how the playlist-format change was caught; adding the fields above will turn the audit green.
