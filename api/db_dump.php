<?php
/*
 * db_dump.php — full JSON ScriptureEarth data dump
 *
 * Created by Scott Starker and Lumo AI - 9/2026
 *
 * Required Get params:
 *   ?v=1&key=[your key]
 *
 * Optional GET params:
 *   &iso=[ISO]      limit to one ISO code
 *   &limit=N        stop after N records (0 = all)
 *   &offset=N       skip first N records
 *   &pretty=1       human-readable output
 *
 */

header('Content-Type: application/json; charset=utf-8');

require_once '../include/conn.inc.php';
$db = get_my_db();

include 'include/v.key.php';																	// get v and key

//set_time_limit(0);							// Setting it to 0 will impose no time limit whatsoever to the execution of your PHP scripts.
//ini_set('max_execution_time', 2400);			// 2400 seconds/60 seconds = 40 minutes
//ini_set('default_socket_timeout', 2400);
ini_set('memory_limit', '300M');				// make sure there is enough memory!

// ---------------------------------------------------------------- request params

$pretty  = isset($_GET['pretty']);
$isoWant = (isset($_GET['iso']) && preg_match('/^[a-z]{3}$/', $_GET['iso'])) ? $_GET['iso'] : '';
$limit   = isset($_GET['limit'])  ? max(0, (int)$_GET['limit'])  : 0;
$offset  = isset($_GET['offset']) ? max(0, (int)$_GET['offset']) : 0;

function out_json($data, $pretty) {
    $flags = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;
    if ($pretty) { $flags |= JSON_PRETTY_PRINT; }
    echo json_encode($data, $flags);
    exit;
}

function obj(array $a) { return (object)$a; }

// Single-value rows: { "0": "value", "1": "value", ... }
function mkObj(array $list, callable $proj) {
    if (!$list) { return new stdClass(); }
    $out = [];
    foreach (array_values($list) as $i => $r) {
        $out[(string)$i] = $proj($r);
    }
    return (object)$out;
}

// Multi-field rows: each entry holds ALL its fields in one object.
//   [ ['title'=>..., 'url'=>...], ... ]  ->  { "0": {"title":..., "url":...}, ... }
function mkRowObj(array $list, callable $mapper) {
    if (!$list) { return new stdClass(); }
    $out = [];
    foreach (array_values($list) as $i => $r) {
        $out[(string)$i] = $mapper($r);
    }
    return (object)$out;
}

// Bucket all rows of a sub-table by ISO_ROD_index, keeping only $keep columns.
// Returns [idx][rownum][column] = raw varchar value.
function lookupRows($db, string $table, array $keep, string $extraWhere = '', string $orderBy = '') {
    $out = [];
    $cols = implode(', ', array_map(fn($c) => "`$c`", $keep));
    $sql = "SELECT `ISO_ROD_index`, $cols FROM `$table`"
         . ($extraWhere ? " WHERE $extraWhere" : '')
         . " ORDER BY `ISO_ROD_index`" . ($orderBy ? ", $orderBy" : '');
    if ($res = $db->query($sql)) {
        while ($r = $res->fetch_assoc()) {
            $row = [];
            foreach ($keep as $c) { $row[$c] = $r[$c]; }   // raw values, untouched
            $out[(int)$r['ISO_ROD_index']][] = $row;
        }
    }
    return $out;
}

function rowsAt(array $lut, int $idx): array {
    return isset($lut[$idx]) ? $lut[$idx] : [];
}

if (!$db) { out_json(['error' => 'database connection failed'], $pretty); }

// ---------------------------------------------------------------- static lookups

$nav = [];
$res = $db->query("SELECT name, nav_fileName FROM translations ORDER BY ln_number");
if ($res) { while ($r = $res->fetch_assoc()) { $nav[$r['name']] = $r['nav_fileName']; } }

$variantEng = [];
$res = $db->query("SELECT Variant_Code, Variant_Eng FROM Variants");
if ($res) { while ($r = $res->fetch_assoc()) { $variantEng[$r['Variant_Code']] = $r['Variant_Eng']; } }

$LNkeys = [];
$res = $db->query("SHOW COLUMNS FROM nav_ln WHERE Field LIKE 'LN_%'");
while ($r = $res->fetch_assoc()) { $LNkeys[] = substr($r['Field'], 3); }

$LNlookup = [];
foreach ($LNkeys as $key) {
    $tbl = 'LN_' . $key;
    $LNlookup[$key] = [];
    $res = $db->query("SELECT ISO_ROD_index, `$tbl` AS v FROM `$tbl`");
    if ($res) {
        while ($r = $res->fetch_assoc()) {
            $LNlookup[$key][(int)$r['ISO_ROD_index']] = trim($r['v']);
        }
    }
}

$stmt_viewer = $db->prepare("SELECT viewer_ROD_Variant, rtl FROM viewer WHERE ISO_ROD_index = ? AND Variant_Code = ?");

// One raw autonym string per ISO (last row wins if duplicates exist)
$autonymByIdx = [];
$res = $db->query("SELECT ISO, autonym FROM autonyms");
if ($res) { while ($r = $res->fetch_assoc()) { $autonymByIdx[$r['ISO']] = $r['autonym']; } }

// Countries and alternate names — raw text lists per idx
$countriesN = lookupRows($db, 'ISO_countries', ['ISO_countries'], '', 'ISO_Countries_index');
$altNames   = lookupRows($db, 'alt_lang_names', ['alt_lang_name'], '', 'Alt_Lang_Name_index');
$countryEng = [];   // code => English name
$res = $db->query("SELECT ISO_Country, English FROM countries");
if ($res) { while ($r = $res->fetch_assoc()) { $countryEng[$r['ISO_Country']] = $r['English']; } }

// ---------------------------------------------------------------- text-payload lookups

$otPdf   = lookupRows($db, 'OT_PDF_Media',   ['OT_PDF', 'OT_PDF_Filename']);
$ntPdf   = lookupRows($db, 'NT_PDF_Media',   ['NT_PDF', 'NT_PDF_Filename']);
$otAudio = lookupRows($db, 'OT_Audio_Media', ['OT_Audio_Book', 'OT_Audio_Filename', 'OT_Audio_Chapter'], '', 'OT_Audio_Book');
$ntAudio = lookupRows($db, 'NT_Audio_Media', ['NT_Audio_Book', 'NT_Audio_Filename', 'NT_Audio_Chapter'], '', 'NT_Audio_Book');

// `url`, `subfolder`, `description` FROM `SAB_scriptoria`
$SAB_scriptoria = lookupRows($db, 'SAB_scriptoria', ['URL', 'subfolder', 'description']);			// one 'url' or the other 'subfolder'; 'description' could be empty

// SAB rows split by audio flag — raw Book_Chapter_HTML payloads
//$sabAudio = lookupRows($db, 'SAB', ['Book_Chapter_HTML', 'SAB_Book', 'SAB_Chapter'], 'SAB_Audio = 1', 'SAB_Book');
//$sabText  = lookupRows($db, 'SAB', ['Book_Chapter_HTML', 'SAB_Book', 'SAB_Chapter'], 'SAB_Audio = 0', 'SAB_Book');

$cell = lookupRows($db, 'CellPhone', ['Cell_Phone_Title', 'Cell_Phone_File', 'optional']);

// Playlists — titles + filenames, raw text
$plAudio = lookupRows($db, 'PlaylistAudio', ['PlaylistAudioTitle', 'PlaylistAudioFilename']);
$plVideo = lookupRows($db, 'PlaylistVideo', ['PlaylistVideoTitle', 'PlaylistVideoFilename', 'PlaylistVideoDownload']);

// Links — organization/title/URL, raw text, flagged rows only
$linksRows = lookupRows($db, 'links',													// company 	company_title 	URL 	buy 	map 	BibleIs 	BibleIsGospelFilm 	YouVersion 	Bibles_org 	GooglePlay 	GRN 	email 	Kalaam 	AppleStore
    ['company', 'company_title', 'URL', 'buy', 'map', 'BibleIs', 'BibleIsGospelFilm',
     'YouVersion', 'GooglePlay', 'GRN', 'email', 'Kalaam', 'AppleStore'],
    "(buy >= 1 OR map >= 1 OR BibleIs >= 1 OR BibleIsGospelFilm >= 1 OR YouVersion >= 1
      OR GooglePlay >= 1 OR GRN >= 1 OR email >= 1 OR Kalaam >= 1 OR AppleStore >= 1 OR company_title IN ('website','webpage'))");

// study — keyed by its own ISO_ROD_index column
$study = lookupRows($db, 'study',
    ['ScriptureDescription', 'Testament', 'alphabet', 'ScriptureURL']);

// watch — keyed by its own ISO_ROD_index column
$watch = lookupRows($db, 'watch',
    ['organization', 'watch_what', 'URL', 'JesusFilm', 'YouTube']);

$other_titlesRows = lookupRows($db, 'other_titles',
	['other', 'other_title', 'other_PDF', 'other_audio', 'download_video']);

$buy = lookupRows($db, 'buy',															// organization, buy_what, URL
	['organization', 'buy_what', 'URL']);

// eBible_list — keyed by its own ISO_ROD_index column
$eBibleRows = lookupRows($db, 'eBible_list',
    ['title', 'description', 'publicationURL', 'shortTitle'], '`Redistributable` = "True"');

// ---------------------------------------------------------------- main query

$sql = "SELECT sm.* FROM scripture_main sm
        INNER JOIN nav_ln n ON sm.ISO_ROD_index = n.ISO_ROD_index";
if ($isoWant) { $sql .= " WHERE sm.ISO = '" . $isoWant . "'"; }
$sql .= " ORDER BY sm.ISO, sm.ROD_Code, sm.Variant_Code";

$result_iso = $db->query($sql);
if (!$result_iso || $result_iso->num_rows == 0) {
    out_json(['error' => 'no matching rows in scripture_main'], $pretty);
}

// ---------------------------------------------------------------- build records

$records = [];
$m = 0;
$emitted = 0;

while ($row = $result_iso->fetch_assoc()) {												// iterate through scripture_main
    $m++;
    $emitted++;
    if ($emitted < $offset) { continue; }                 								// pagination: skip
    if ($limit > 0 && $emitted >= $offset + $limit) { break; }

    $iso = $row['ISO'];
    $rod = $row['ROD_Code'];
    $var = $row['Variant_Code'];
    $idx = (int)$row['ISO_ROD_index'];

    $qs = 'iso=' . $iso;
    if ($rod != '00000') { $qs .= '&rod=' . $rod; }
    if ($var !== '')     { $qs .= '&var=' . $var; }

    // language names + autonym (raw text per idx)
    $language_name = [];
    foreach ($LNkeys as $key) {
        $language_name[$key] = isset($LNlookup[$key][$idx]) ? $LNlookup[$key][$idx] : '';
    }
    $language_name['autonym(s)'] = isset($autonymByIdx[$iso]) ? $autonymByIdx[$iso] : '';

    // countries — raw English names and codes
    $cn = []; $cc = [];
    foreach (rowsAt($countriesN, $idx) as $r) {
        $cn[] = $countryEng[$r['ISO_countries']] ?? '';
        $cc[] = $r['ISO_countries'];
    }

    // alternate names — raw text
    $altList = array_map(fn($r) => $r['alt_lang_name'], rowsAt($altNames, $idx));

    // media — raw payloads, gated on scripture_main flags like the beta
    $otPdfRows   = ((int)$row['OT_PDF']   >= 1) ? rowsAt($otPdf,   $idx) : [];
    $ntPdfRows   = ((int)$row['NT_PDF']   >= 1) ? rowsAt($ntPdf,   $idx) : [];
    $otAudioRows = ((int)$row['OT_Audio'] >= 1) ? rowsAt($otAudio, $idx) : [];
    $ntAudioRows = ((int)$row['NT_Audio'] >= 1) ? rowsAt($ntAudio, $idx) : [];
	$SABRows     = rowsAt($SAB_scriptoria, $idx);
    //$sabTextRows  = ((int)$row['SAB'] == 1) ? rowsAt($sabText, $idx) : [];
    //$sabAudioRows  = ((int)$row['SAB'] == 1) ? rowsAt($sabAudio, $idx) : [];
    $cellRows     = rowsAt($cell, $idx);
    $plVideoRows  = rowsAt($plVideo, $idx);
    $plAudioRows  = ((int)$row['PlaylistAudio'] >= 1) ? rowsAt($plAudio, $idx) : [];
    $linksList    = ((int)$row['links'] == 1) ? rowsAt($linksRows, $idx) : [];
    $studyRows    = ((int)$row['study'] >= 1) ? rowsAt($study, $idx) : [];
    $watchRows    = ((int)$row['watch'] >= 1) ? rowsAt($watch, $idx) : [];
	$other_titlesList = ((int)$row['other_titles'] >= 1) ? rowsAt($other_titlesRows, $idx) : [];
	$buyRows = ((int)$row['buy'] >= 1) ? rowsAt($buy, $idx) : [];
    $eBibleList   = ((int)$row['eBible'] >= 1) ? rowsAt($eBibleRows, $idx) : [];

    // cell phone categorization still by title, but emitting the file itself
    $appsAndroid = []; $iPhone = []; $appsIos = []; $goBible = []; $mySword = []; $epubs = [];
    foreach ($cellRows as $r) {
        switch ($r['Cell_Phone_Title']) {
            case 'GoBible (Java)':    $goBible[]     = $r; break;
            case 'MySword (Android)': $mySword[]     = $r; break;
            case 'iPhone':            $iPhone[]      = $r; break;
            case 'Android App':       $appsAndroid[] = $r; break;
            case 'iOS Asset Package': $appsIos[]     = $r; break;
            case 'ePub':              $epubs[]       = $r; break;
            default: break;   // silently skip unexpected titles
        }
    }

    // playlists split by download flag
    $plStream = []; $plDl = [];
    foreach ($plVideoRows as $r) {
        if ((int)$r['PlaylistVideoDownload'] >= 1) { $plDl[] = $r; } else { $plStream[] = $r; }
    }

    // per-flag filtered link lists (computed once, reused below)
    $fBibleIs    = array_values(array_filter($linksList, fn($r) => (int)$r['BibleIs'] >= 1));
    $fGospel     = array_values(array_filter($linksList, fn($r) => (int)$r['BibleIsGospelFilm'] >= 1));
    $fBuyLink    = array_values(array_filter($linksList, fn($r) => (int)$r['buy'] >= 1));
    $fYouVersion = array_values(array_filter($linksList, fn($r) => (int)$r['YouVersion'] >= 1));
    $fGooglePlay = array_values(array_filter($linksList, fn($r) => (int)$r['GooglePlay'] >= 1));
    $fKalaam     = array_values(array_filter($linksList, fn($r) => (int)$r['Kalaam'] >= 1));
    $fWebsites   = array_values(array_filter($linksList, fn($r) => in_array(strtolower($r['company_title']), ['website','webpage'])));
    $fApple      = array_values(array_filter($linksList, fn($r) => (int)$r['AppleStore'] >= 1));
    $fEmail      = array_values(array_filter($linksList, fn($r) => (int)$r['email'] >= 1));
    $fGRN        = array_values(array_filter($linksList, fn($r) => (int)$r['GRN'] >= 1));
    $fMap        = array_values(array_filter($linksList, fn($r) => (int)$r['map'] >= 1));

    // other_titles split by media type
    $otPDFList   = array_values(array_filter($other_titlesList, fn($r) => $r['other_PDF'] != ''));
    $otAudioList = array_values(array_filter($other_titlesList, fn($r) => $r['other_audio'] != ''));
    $otVideoList = array_values(array_filter($other_titlesList, fn($r) => $r['download_video'] != ''));

	$SILlink = '';
	if ((int)$row['SILlink'] >= 1) {
		$SILlink = "https://www.sil.org/resources/search/code/$iso?sort_order=DESC&sort_by=field_reap_sortdate";
	}

	$viewer = '';
	if ((int)$row['viewer'] >= 1) {
		$ROD_Var='';
		$rtl = 0;
        $stmt_viewer->bind_param('is', $idx, $var);										// bind parameters for markers
        $stmt_viewer->execute();														// execute query
        $resultViewer = $stmt_viewer->get_result();
		if ($resultViewer->num_rows >= 1) {
			$r_Viewer = $resultViewer->fetch_array(MYSQLI_ASSOC);
			$ROD_Var=trim($r_Viewer['viewer_ROD_Variant']);
			$rtl=trim($r_Viewer['rtl']);
		}
		$viewer = "https://www.ScriptureEarth.org/viewer/views.php?iso=$iso&ROD_Code=$rod&Variant_Code=$var&ROD_Var=$ROD_Var&rtl=$rtl&st=eng";
	}

    $records[(string)$emitted] = [
        'type' => 'iso',
        'id'   => $emitted + 1,
        'attributes' => [
            'iso'        => $iso,
            'num_nav'    => count($nav),
            'navigation' => $nav,
        ],
        'relationships' => [
            'rod'              => $rod,
            'var_code'         => $var,
            'var_name'         => ($var !== '' && isset($variantEng[$var])) ? $variantEng[$var] : '',
            'iso_query_string' => $qs,
            'idx'              => $idx,
            'idx_query_string' => 'idx=' . $idx,
            'language_name'    => $language_name,
            'alternate_language_count'   => count($altList),
            'alternate_language_names'  => mkObj($altList, fn($n) => $n),
            'country_count'    => count($cn),
            'countries_names'  => mkObj($cn, fn($n) => $n),
            'countries_codes'  => mkObj($cc, fn($c) => $c),

            'se_apps' => [
                'Android_App' => mkRowObj($appsAndroid,
                    fn($r) => ['title' => $r['optional'], 'url' => $r['Cell_Phone_File']]),
                'iOS_Asset_Package' => mkRowObj($appsIos,
                    fn($r) => ['title' => $r['optional'], 'url' => $r['Cell_Phone_File']]),
            ],
            'se_google_play' => mkRowObj($fGooglePlay,
                fn($r) => ['title' => $r['company_title'], 'url' => $r['URL']]),
            'se_iPhone' => mkRowObj($iPhone,
                fn($r) => ['title' => $r['optional'], 'url' => $r['Cell_Phone_File']]),
            'se_ePub' => mkRowObj($epubs,
                fn($r) => ['title' => $r['optional'], 'url' => $r['Cell_Phone_File']]),
            'se_sab' => mkRowObj($SABRows, fn($r) => [
					'path'         => $r['subfolder'] != '' ? 'https://www.ScriptureEarth.org/data/'.$iso.'/'.$r['subfolder'] : '',
					'url'          => $r['URL'],
					'description'  => $r['description'],
                //'text'  => mkObj($sabTextRows,  fn($r) => $r['Book_Chapter_HTML']),
                //'audio' => mkObj($sabAudioRows, fn($r) => $r['Book_Chapter_HTML']),
            ]),
            'se_online_viewer' => $viewer,
            'se_media' => [
                'text' => [
                    'OT' => mkObj($otPdfRows,
                        fn($r) => "https://ScriptureEarth.org/data/$iso/PDF/".$r['OT_PDF_Filename']),
                    'NT' => mkObj($ntPdfRows,
                        fn($r) => "https://ScriptureEarth.org/data/$iso/PDF/".$r['NT_PDF_Filename']),
                ],
                'audio' => [
                    'OT' => mkObj($otAudioRows,
                        fn($r) => "https://ScriptureEarth.org/data/$iso/audio/".$r['OT_Audio_Filename']),
                    'NT' => mkObj($ntAudioRows,
                        fn($r) => "https://ScriptureEarth.org/data/$iso/audio/".$r['NT_Audio_Filename']),
                ],
                'playlist_audio' => mkRowObj($plAudioRows, fn($r) => [
                    'title'    => $r['PlaylistAudioTitle'],
                    'filename' => "https://ScriptureEarth.org/data/$iso/audio/".$r['PlaylistAudioFilename'],
                ]),
                'playlist_video' => mkRowObj($plStream, fn($r) => [
                    'title'    => $r['PlaylistVideoTitle'],
                    'filename' => "https://ScriptureEarth.org/data/$iso/video/".$r['PlaylistVideoFilename'],
                ]),
            ],
            'se_download_media' => [
                'text' => [
                    'OT' => mkObj($otPdfRows,
                        fn($r) => "https://ScriptureEarth.org/data/$iso/PDF/".$r['OT_PDF_Filename']),
                    'NT' => mkObj($ntPdfRows,
                        fn($r) => "https://ScriptureEarth.org/data/$iso/PDF/".$r['NT_PDF_Filename']),
                ],
                'audio' => [
                    'OT' => mkObj($otAudioRows,
                        fn($r) => "https://ScriptureEarth.org/data/$iso/audio/".$r['OT_Audio_Filename']),
                    'NT' => mkObj($ntAudioRows,
                        fn($r) => "https://ScriptureEarth.org/data/$iso/audio/".$r['NT_Audio_Filename']),
                ],
                'playlist_audio' => mkRowObj($plAudioRows, fn($r) => [						// manual
                    'title'    => $r['PlaylistAudioTitle'],
                    'filename' => "https://ScriptureEarth.org/data/$iso/audio/".$r['PlaylistAudioFilename'],
                ]),
                'playlist_video' => mkRowObj($plDl, fn($r) => [
                    'title'    => $r['PlaylistVideoTitle'],
                    'filename' => "https://ScriptureEarth.org/data/$iso/video/".$r['PlaylistVideoFilename'],
                ]),
            ],
            'se_other_software' => [
                'GoBible' => mkRowObj($goBible, fn($r) => [
                    'title' => $r['optional'],
                    'url'   => "https://ScriptureEarth.org/data/$iso/study/".$r['Cell_Phone_File'],
                ]),
                'MySword' => mkRowObj($mySword, fn($r) => [
                    'title' => $r['optional'],
                    'url'   => "https://ScriptureEarth.org/data/$iso/study/".$r['Cell_Phone_File'],
                ]),
                'theWord' => mkRowObj($studyRows, fn($r) => [
                    'description' => $r['ScriptureDescription'],
                    'testament'  => $r['Testament'],
                    'alphabet'   => $r['alphabet'],
                    'filename'   => "https://ScriptureEarth.org/data/$iso/study/".$r['ScriptureURL'],
                ]),
            ],
            'links_media' => [
                'Bible.is' => mkRowObj($fBibleIs, fn($r) => [
                    'media_type' => (int)$r['BibleIs'],
                    'title'      => $r['company_title'],
                    'url'        => $r['URL'],
                ]),
                'Bible.is_Gospel_Film' => mkRowObj($fGospel, fn($r) => [
                    'title' => $r['company_title'],
                    'url'   => $r['URL'],
                ]),
                'buy' => mkRowObj($fBuyLink, fn($r) => [
                    'organization' => $r['company'],
                    'title'       => $r['company_title'],
                    'url'         => $r['URL'],
                ]),
                'YouVersion' => mkRowObj($fYouVersion, fn($r) => [
                    'title' => $r['company_title'],
                    'url'   => $r['URL'],
                ]),
                'eBible' => mkRowObj($eBibleList, fn($r) => [
                    'title'       => $r['title'],
                    'description' => $r['description'],
                    'url'         => $r['publicationURL'],
                ]),
                'Kalaam_websites' => mkRowObj($fKalaam, fn($r) => [
                    'organization' => $r['company'],
                    'title'        => $r['company_title'],
                    'url'          => $r['URL'],
                ]),
                'other_websites' => mkRowObj($fWebsites, fn($r) => [
                    'organization' => $r['company'],
                    'url'          => $r['URL'],
                ]),
                'AppleStore' => mkRowObj($fApple, fn($r) => [
                    'apple_store' => $r['company'],
                    'title'       => $r['company_title'],
                    'url'         => $r['URL'],
                ]),
                'email' => mkRowObj($fEmail, fn($r) => [
                    'title' => $r['company_title'],
                    'url'   => $r['URL'],
                ]),
                'GRN' => mkRowObj($fGRN, fn($r) => [
                    'grn'   => 'Global Recordings Network',
                    'title' => 'Audio recording',
                    'url'   => $r['URL'],
                ]),
            ],
            'buy' => mkRowObj($buyRows, fn($r) => [										// organization, buy_what, URL
                'organization' => $r['organization'],
                'title'       => $r['buy_what'],
                'url'         => $r['URL'],
            ]),
            'maps'    => mkObj($fMap, fn($r) => $r['URL']),
            'se_maps' => 1,
            'watch' => mkRowObj($watchRows, fn($r) => [								// 'organization', 'watch_what', 'URL', 'JesusFilm', 'YouTube'
                'organization' => $r['organization'],
                'watch_what'   => $r['watch_what'],
                'url'          => $r['URL'],
                'JesusFilm'    => (int)$r['JesusFilm'],
                'YouTube'      => (int)$r['YouTube'],
            ]),
            'other_titles' => [
                'other_PDF' => mkObj($otPDFList,
                    fn($r) => "https://ScriptureEarth.org/data/$iso/PDF/".$r['other_PDF']),
                'other_audio' => mkObj($otAudioList,
                    fn($r) => "https://ScriptureEarth.org/data/$iso/audio/".$r['other_audio']),
                'other_video_download' => mkObj($otVideoList,
                    fn($r) => "https://ScriptureEarth.org/data/$iso/video/".$r['download_video']),
            ],
            'SIL_link' => $SILlink,														// https://www.sil.org/resources/search/code/[ISO]?sort_order=DESC&sort_by=field_reap_sortdate
        ],
    ];
}
//print_r($records);
out_json(obj($records), $pretty);
?>