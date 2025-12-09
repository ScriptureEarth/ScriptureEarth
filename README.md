# Scripture Earth

[ScriptureEarth.org](https://scriptureearth.org) (SE.org) is a website that provides a source for accessing Scripture resources in thousands of languages (4050 Scripture resources as of 9/2025) through text, audio, and video for speakers of minority languages. SE.org does not publish extra Biblical materials (like Bible studies) in the minority languages (but there are limited exceptions).

## Description

### Primary and Secondary Audiences

**The primary target audience** is speakers of minority languages to access Scripture for the speakers of the minority languages whether living in the homeland or as part of the diaspora. The primary audiences may be indirectly served by **other people and organizations** (the secondary audience) who would like to receive these resources to pass it on to the primary target audience.

### Strategy and Goal

**The strategy** of the SE.org website is to provide actual primary language Scripture resources in ways that are simple and easy to transfer from the repository to the user. **The goal** is for a user to easily find their language page and note the kind of resource by the form of icons.

### Simplest Possible Way

In our primary target audience we have noticed that in most of the Central and South America locations the Internet connections are inconsistent or the Internet bandwidth is frequently low. The objective is to provide Scripture resources in the simplest way possible that is accessible even in less than ideal Internet locations. We have been very careful to use the fonts, text, and images for the SE.org layout to be more sparse, simple, and streamlined than all of the other Scripture websites. And, we would rather not want libraries for CSS and JavaScript to be on the server except for jQuery.

### The Scripts

This repository contains most of the HTML, CSS, JavaScript, PHP, MySQL (MariaDB), and fetch/AJAX for the SE.org website. In addition, it contains the “add” and “edit” for the CMS.

If you are the user of SE.org, scripts are divided up into two sections: 1) the searches for the minority languages page, and 2) the specific minority language page.

## Search For and Display Specific Minority Languages Page

### `You have to have SE.org database operational before running the SE.org website!` See the [SE.org database structure sql.](./MariaDB/scripture_structure.sql)

### Searches For the Minority Languages Page

The image below shows how to use the home page to find a particular language. Whenever the user types in one of the search boxes or selects “List by Country” one or more choices will appear. The desired item can be selected from the list.

![Searches For the Minority Languages Page](https://scriptureearth.org/images/00eng-helpExplanation.jpg)

### Display Specific Minority Language Page

All of the specific minority language is displayed on this page. There are 7 tabs on this page: Text, Audio, Video, App, Other, Map, and All. Depending on which tabs the user selects, the screen with display those which matches the tab. Then, clicking on the icon or text will take the user to the desired section.

## SE.org Database

### `You have to have SE.org database operational before running the SE.org website!` See the [SE.org database structure sql.](./MariaDB/scripture_structure.sql)

### Login Tables (4 tables)

* **users** – the users
* **active_guests** – active guests
* **active_users** – when the user logs in
* **banned_users** – banned users

### API Users Table (1 table)

* **api_users** – the key codes for SE.org API

### SAB Requests Table (1 table)

* **add_resource** – SAB requests: do you want to accept, reject, or wait?

### SE.org Tables (51 tables)

* **add_resource** – add to SE.org database (must have access)
* **alt_lang_names** – alternate language names
* **buy** – buy print Bibles/NTs from links
* **CellPhone** – MySword (Android), GoBible (Java), Android App, iOS Asset Package, ePub, and iPhone executable files
* **countries** – English, Spanish, Portuguese, French, Dutch, German, Chinese, Korean, Russian, and Arabic country names and ISO_Country (two uppercase letters)
* **ISO_countries** – ISO_countries (two UPPERCASE letters) field
* **ISO_Lang_Countries** – ISO and ISO_Country (two UPPERCASE letters)
* **subfamilies** – subfamilies
* **eBible_list** – eBible matching list
* **GotoInterest** – 12 rows, interests to go to another subfamilies
* **isop** – 58 rows, ISO Plus (ISO + 1 up to 4 UPPERCASE letters)
* **leafletjs_maps** – ISO (the field name is "hid"), latitude, and longitude for each language
* **links** – company, company_title, and URL for buy, map, BibleIs, BibleIsGospelFilm, YouVersion, Bibles_org, GooglePlay, GRN, email, and other
* **LN_Arabic** – Arabic language name
* **LN_Chinese** – Chinese language name
* **LN_Dutch** – Dutch language name
* **LN_English** – English language name
* **LN_French** – French language name
* **LN_German** – German language name
* **LN_Korean** – Korean language name
* **LN_Portuguese** – Portuguese language name
* **LN_Russian** – Russian language name
* **LN_Spanish** – Spanish language name
* **nav_ln** – 0 or 1 for Def_LN (default language name), LN_English, LN_Spanish, LN_Portuguese, LN_French, LN_Dutch, LN_German, LN_Chinese, LN_Korean, LN_Russian, and LN_Arabic for each ISO+ROD+Variant codes (or index field)
* **NT_Audio_Media** – ogg/mp3 files for every book and chapter for NT
* **NT_PDF_Media** – PDF files for every book and NT
* **other_titles** – other and other_title either other_PDF or other_audio or download_video
* **OT_Audio_Media** – ogg/mp3 files for every book and chapter for OT
* **OT_PDF_Media** – PDF files for every book and OT
* **PlaylistAudio** – 1 up to 10 navigational language txt files and containing ogg/mp3 files
* **PlaylistVideo** – 1 up to 10 navigational language txt files and containing webm/mp4 files
* **ROD_subfamily** – ISO_country (two UPPERCASE letters), language_name, (langauge name that is larger that the subfamily name), subfamily_name, location (can be smaller than the country. E.g., India, Arunachal Pradesh, etc.)
* **SAB** – contains the html (read, listen, and/or view) files for each book and chapter for each language
* **SAB_scriptoria** – url (remote) or subfolder (local), description, and SAB_number (0 up to 3)
* **Scripture_and_or_Bible** – PDF of the Bible or some portions and NT
* **scripture_main** – The main ScriptureEarth.org table (all of the fields are set to 0 or 1 except for SAB)
* **study** – *The Word* program for Windows users
* **translations** – name (name of the navigational language), nav_fileName (equivalent to PHP parse_url($url, PHP_URL_PATH);), language_code, ln_number (internal number of the navigational language), ln_abbreviation
* **translations_arb** – Arabic translations
* **translations_cmn** – Chinese translations
* **translations_nld** – Dutch translations
* **translations_eng** – English translations
* **translations_fra** – French translations
* **translations_deu** – German translations
* **translations_kor** – Korean translations
* **translations_por** – Portuguese translations
* **translations_rus** – Russian translations
* **translations_spa** – Spanish translations
* **Variants** – list of variants for navigational languages (Variant_Description, Variant_Eng, Variant_Spa, Variant_Por, Variant_Fre, Variant_Dut, Variant_Ger, Variant_Chi, Variant_Kor, Variant_Rus, and Variant_Ara)
* **viewer** – 4 rows, viewer_ROD_Variant for viewer icon
* **watch** – organization, watch_what, URL, JesusFilm (0 or 1), YouTube (0 or 1)

## Content Management System (CMS)

You will need to login (login.php).

(under development)

### Add to ScripturesEarth’s Database

(under development)

### Edit ScripturesEarth’s Database

(under development)

## SE.org API

This is the summary of the Application Programming Interface (API) for ScriptureEarth.org. You will need a key in order to run these PHP scripts. The API exposes the application's data to anyone who has a key. Each of the PHP scripts will pull out the JSON appropriate for that PHP. See the [ScriptureEarth.org API Introduction](https://scriptureearth.org/api/SE_API_specification.php) for more information.

### Summary of the API

SE.org API has these requests:

* **records.php** with the ISO 639-3 code, index, or the English language name the SE API and will pull out the counts of the products based on ISO 639-3 code, index, or the English language name
* **all_iso.php** the SE API will pull out the counts of **all** of the ISO 639-3 products
* **partial_languageNames.php** with the partial (3 or more letters) for English language names and alternate language names starting at the beginning of the words and will pull out the English language names as well as the ISO 639-3 codes, indexes, alternate language numbers and names, country names, and coumtry codes
* **country.php** with the country name or country code the SE API will pull out the English language names as well as the ISO 639-3 codes, indexes, alternate language numbers, and alternate language names
* **partial_countries.php** with the partial (2 or more letters) country names starting at the beginning of the words and will pull out the English language names as well as the ISO 639-3 codes, indexes, alternate language numbers, and alternate language names
* **all_countries.php** the SE API will pull out **all** of the countries and country codes
* **subfamilies.php** the SE API will pull out the subfamily(s)
* **media_se.php** with the ISO 639-3 code or index the SE API will pull out all of the SE URLs for texts, audio, videos, audio playlists, video playlists, theWord (Windows OS), and the online viewer
* **general_links.php** with the ISO 639-3 code or index the SE API will pull out the general URLs for texts, audio, and videos (Bible.is, YouVersion, and watch full Scripture videos) also the websites for GRN and eBible
* **apps.php** with the ISO 639-3 code or index the SE API will pull out the Android app (apk) and iOS Assent Package for that ISO 639-3 code or index
* **languageNames.php** with the ISO 639-3 code, index number, or the country code with either the Android app (apk) and iOS Assent Package, or both, the SE API will pull out the language name(s)
* **sab.php** with the ISO 639-3 code or index the SE API will pull out path and all of the SAB HTML files
* **other_se.php** with the ISO 639-3 code or index the SE API will pull out the other SE audio/PDF/ePub files
* **website_links.php** with the ISO 639-3 code or index the SE API will pull out the other website links (e.g. OneStory, iTunes, Facebook, and other links)
* **download_media.php** with the ISO 639-3 code or index the SE API will pull out the downloadable SE files (OT and NT audio files, playlist audio files, playlist video files, *The Word* program for Windows users, etc.)
