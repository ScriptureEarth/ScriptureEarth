<?php
/*
	PHP script by Scott Starker and Lumo AI
*/

$index = 0;

require_once '../include/conn.inc.php';													// connect to the database named 'scripture'
$db = get_my_db();

include 'include/v.key.php';															// get v and key

include 'include/idx.iso.php';															// get idx or iso

if ($index == 0) {
	die ('HACK!');
}

if ($index == 1) {
    $stmt_main = $db->prepare("SELECT * FROM `scripture_main` WHERE ISO_ROD_index = ? AND (BibleIs != 0 OR YouVersion = 1 OR `Bibles_org` = 1 OR GRN = 1 OR eBible = 1 OR watch = 1)");
    $stmt_main->bind_param('i', $idx);
}
else {
	if ($rod == 'ALL' && $var == 'ALL') {
		$stmt_main = $db->prepare("SELECT * FROM `scripture_main` WHERE `ISO` = ? AND (BibleIs != 0 OR YouVersion = 1 OR `Bibles_org` = 1 OR GRN = 1 OR eBible = 1 OR watch = 1) ORDER BY `ROD_Code`, `Variant_Code`");
		$stmt_main->bind_param('s', $iso);
	}
	elseif ($rod == 'ALL') {
		$stmt_main = $db->prepare("SELECT * FROM `scripture_main` WHERE `ISO` = ? AND `Variant_Code` = ? AND (BibleIs != 0 OR YouVersion = 1 OR Bibles_org = 1 OR GRN = 1 OR eBible = 1 OR watch = 1) ORDER BY `ROD_Code`, `Variant_Code`");
		$stmt_main->bind_param('ss', $iso, $var);
	}
	elseif ($var == 'ALL') {
		$stmt_main = $db->prepare("SELECT * FROM `scripture_main` WHERE `ISO` = ? AND `ROD_Code` = ? AND (BibleIs != 0 OR YouVersion = 1 OR Bibles_org = 1 OR GRN = 1 OR eBible = 1 OR watch = 1) ORDER BY `ROD_Code`, `Variant_Code`");
		$stmt_main->bind_param('ss', $iso, $rod);
	}
	else {
		$stmt_main = $db->prepare("SELECT * FROM `scripture_main` WHERE `ISO` = ? AND `ROD_Code` = ? AND `Variant_Code` = ? AND (BibleIs != 0 OR YouVersion = 1 OR Bibles_org = 1 OR GRN = 1 OR eBible = 1 OR watch = 1) ORDER BY `ROD_Code`, `Variant_Code`");
		$stmt_main->bind_param('sss', $iso, $rod, $var);
	}
}

$stmt_main->execute();
$result_main = $stmt_main->get_result();

$stmt_BibleIs = $db->prepare("SELECT * FROM links WHERE ISO_ROD_index = ? AND NOT BibleIs = 0 ORDER BY BibleIs");
$stmt_BibleIsGospelFilm = $db->prepare("SELECT * FROM links WHERE ISO_ROD_index = ? AND BibleIsGospelFilm = 1");
$stmt_YouVersion = $db->prepare("SELECT * FROM links WHERE ISO_ROD_index = ? AND YouVersion = 1");
$stmt_Bibles_org = $db->prepare("SELECT * FROM links WHERE ISO_ROD_index = ? AND `Bibles_org` = 1");
$stmt_GooglePlay = $db->prepare("SELECT * FROM links WHERE ISO_ROD_index = ? AND GooglePlay = 1");
$stmt_AppleStore = $db->prepare("SELECT * FROM links WHERE ISO_ROD_index = ? AND AppleStore = 1");
$stmt_GRN = $db->prepare("SELECT * FROM links WHERE ISO_ROD_index = ? AND GRN = 1");
$stmt_eBible = $db->prepare("SELECT homeDomain, translationId FROM eBible_list WHERE ISO_ROD_index = ?");
$stmt_watch = $db->prepare("SELECT * FROM watch WHERE ISO_ROD_index = ? ORDER BY organization, watch_what, JesusFilm, YouTube");
$stmt_var = $db->prepare("SELECT Variant_Eng FROM Variants WHERE Variant_Code = ?");

$main_rows = $result_main->num_rows;
if ($main_rows == 0) {
    die ('idx or iso does not exist in SE.');
}

// Clean up prefixes like "- " and "(something) " from titles
function se_clean_title($s) {
    $s = trim($s);
    $s = preg_replace('/[^-)]*[-)] (.*)/', '$1', $s);		// remove text up to and including ) or -
    $s = ltrim($s, '- ');
    return trim($s);
}

$out = [];													// build as a PHP array; json_encode handles all syntax
$m = 0;

while ($row_main = $result_main->fetch_assoc()) {
    $iso = $row_main['ISO'];
    $rod = $row_main['ROD_Code'];
    $var = $row_main['Variant_Code'];
    $Variant_name = '';
    if ($var != '') {
        $stmt_var->bind_param('s', $var);
        $stmt_var->execute();
        $result_temp = $stmt_var->get_result();
        if ($row_temp = $result_temp->fetch_assoc()) {
            $Variant_name = $row_temp['Variant_Eng'];
        }
    }
    $idx = (int)$row_main['ISO_ROD_index'];

    $stmt_BibleIs->bind_param('i', $idx);
    $stmt_BibleIs->execute();
    $result_BibleIs = $stmt_BibleIs->get_result();
    $stmt_BibleIsGospelFilm->bind_param('i', $idx);
    $stmt_BibleIsGospelFilm->execute();
    $result_BibleIsGospelFilm = $stmt_BibleIsGospelFilm->get_result();
    $stmt_YouVersion->bind_param('i', $idx);
    $stmt_YouVersion->execute();
    $result_YouVersion = $stmt_YouVersion->get_result();
    $stmt_Bibles_org->bind_param('i', $idx);
    $stmt_Bibles_org->execute();
    $result_Bibles_org = $stmt_Bibles_org->get_result();
    $stmt_GooglePlay->bind_param('i', $idx);
    $stmt_GooglePlay->execute();
    $result_GooglePlay = $stmt_GooglePlay->get_result();
    $stmt_AppleStore->bind_param('i', $idx);
    $stmt_AppleStore->execute();
    $result_AppleStore = $stmt_AppleStore->get_result();
    $stmt_GRN->bind_param('i', $idx);
    $stmt_GRN->execute();
    $result_GRN = $stmt_GRN->get_result();
    $stmt_eBible->bind_param('i', $idx);
    $stmt_eBible->execute();
    $result_eBible = $stmt_eBible->get_result();
    $stmt_watch->bind_param('i', $idx);
    $stmt_watch->execute();
    $result_watch = $stmt_watch->get_result();

    $m++;

    // attributes
    $iso_q = 'iso=' . $iso;
    if ($rod != '00000') { $iso_q .= '&rod=' . $rod; }
    if ($var != '')       { $iso_q .= '&var=' . $var; }

    $rec = [
        'type' => 'General_Links',
        'id' => (string)$m,
        'attributes' => [
            'iso' => $iso,
            'rod' => $rod,
            'var_code' => $var,
            'var_name' => $Variant_name,
            'iso_query_string' => $iso_q,
            'idx' => $idx,
            'idx_query_string' => 'idx=' . $idx,
        ],
        'relationships' => [],
    ];
    $rels = &$rec['relationships'];

    // ---- Bible.Is: group by action; multiple versions become an ARRAY (no duplicate-key collisions)
    if ($row_main['BibleIs'] && $result_BibleIs->num_rows > 0) {
        $actMap = [
            1 => 'Read_Listen',
            2 => 'Read',
            3 => 'Read_Listen',
            4 => 'Read_Listen_View',
			5 => 'Listen',
			6 => 'Listen_View',
			7 => 'View',
			8 => 'Read_View',
        ];
        while ($r = $result_BibleIs->fetch_assoc()) {
            $URL = trim($r['URL']);
            if (preg_match('/^(.*\/)[a-zA-Z0-9][a-zA-Z]{2}\/[09]+$/', $URL, $matches)) {	// remove e.g. Mat/1
                $URL = $matches[1];
            }
            $act = $actMap[(int)$r['BibleIs']] ?? null;
            if ($act === null) { continue; }
            $rels['Bible.Is'][$act][] = [
                'URL' => $URL,
                'version' => trim($r['company_title']),
            ];
        }
    }

    // ---- Bible.is Gospel Film
    if ($row_main['BibleIsGospelFilm'] && $result_BibleIsGospelFilm->num_rows > 0) {
        while ($r = $result_BibleIsGospelFilm->fetch_assoc()) {
            $rels['LUMO_Gospel_Film'][] = [
                'Which_Gospel' => preg_replace('/^ ?-? ?(.*)/', '$1', trim($r['company_title'])),
                'URL' => trim($r['URL']),
            ];
        }
    }

    // ---- YouVersion
    if ($row_main['YouVersion'] && $result_YouVersion->num_rows > 0) {
        while ($r = $result_YouVersion->fetch_assoc()) {
            $rels['YouVersion'][] = [
                'title' => se_clean_title($r['company_title']),
                'URL' => trim($r['URL']),
            ];
        }
    }

    // ---- Bibles.org
    if ($row_main['Bibles_org'] && $result_Bibles_org->num_rows > 0) {
        while ($r = $result_Bibles_org->fetch_assoc()) {
            $rels['Bibles.org'][] = [
                'organization' => trim($r['company']),			// FIX: was leftover $r_links
                'version' => trim($r['company_title']),			// FIX: was leftover $r_links
                'URL' => trim($r['URL']),
            ];
        }
    }

    // ---- Google Play
    if ($result_GooglePlay->num_rows > 0) {
        while ($r = $result_GooglePlay->fetch_assoc()) {
            $rels['Google_Play'][] = [
                'title' => se_clean_title($r['company_title']),
                'URL' => trim($r['URL']),
            ];
        }
    }

    // ---- Apple Store
    if ($result_AppleStore->num_rows > 0) {
        while ($r = $result_AppleStore->fetch_assoc()) {
            $rels['Apple_Store'][] = [
                'title' => se_clean_title($r['company_title']),
                'URL' => trim($r['URL']),
            ];
        }
    }

    // ---- GRN
    if ($row_main['GRN'] && $result_GRN->num_rows > 0) {
        while ($r = $result_GRN->fetch_assoc()) {
            $rels['GRN'][] = ['URL' => trim($r['URL'])];
        }
    }

    // ---- eBible
    if ($row_main['eBible'] && $result_eBible->num_rows > 0) {
        while ($r = $result_eBible->fetch_assoc()) {
            $homeDomain = trim($r['homeDomain']);
            $translationId = trim($r['translationId']);
            if ($homeDomain == 'inscript.org') {
                $publicationURL = 'eBible.org/find/details.php?id=' . $translationId;
            }
            else {
                $publicationURL = $homeDomain . '/' . $translationId;
            }
            $rels['eBible'][] = ['URL' => 'https://' . $publicationURL];
        }
    }

    // ---- watch: JesusFilm / YouTube / other_videos
    if ($row_main['watch'] && $result_watch->num_rows > 0) {
        while ($r = $result_watch->fetch_assoc()) {
            $URL = trim($r['URL']);
            $organization = trim($r['organization']);
            $title = trim($r['watch_what']);
            $JesusFilm = (bool)$r['JesusFilm'];
            $YouTube = (bool)$r['YouTube'];

            if ($JesusFilm) {
                // JESUS Film
                if (strncmp($URL, "https://api.arclight.org/videoPlayerUrl", 40) === 0) {
                    $URL = 'JESUSFilmView.php?' . $URL;
                }
                $rels['JesusFilm'][] = [
                    'title' => $title,
                    'URL' => $URL,
                ];
            }
            elseif ($YouTube) {
                $rels['YouTube'][] = [
                    'organization' => $organization,
                    'title' => $title,
                    'URL' => $URL,
                ];
            }
            else {
                $rels['other_videos'][] = [
                    'organization' => $organization,
                    'title' => $title,
                    'URL' => $URL,
                ];
            }
        }
    }

    $out[] = $rec;
    unset($rec, $rels);
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($out, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
?>