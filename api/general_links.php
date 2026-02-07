<?php

$index = 0;
$first = '';
$marks = [];
$json_string = '';

require_once '../include/conn.inc.php';															// connect to the database named 'scripture'
$db = get_my_db();

include 'include/v.key.php';																	// get v and key

include 'include/idx.iso.php';																	// get idx or iso

if ($index == 0) {
	die ('HACK!');
}

//echo $index . '<br />';
//echo  $iso . '; rod=' . $rod . '; var=' . $var . '<br />';

if ($index == 1) {
    $stmt_main = $db->prepare("SELECT * FROM `scripture_main` WHERE ISO_ROD_index = ? AND (BibleIs != 0 OR YouVersion = 1 OR `Bibles_org` = 1 OR GRN = 1 OR eBible = 1 OR watch = 1)");
    $stmt_main->bind_param('i', $idx);															// bind parameters for markers
}
else {
	if ($rod == 'ALL' && $var == 'ALL') {
		$stmt_main = $db->prepare("SELECT * FROM `scripture_main` WHERE `ISO` = ? AND (BibleIs != 0 OR YouVersion = 1 OR `Bibles_org` = 1 OR GRN = 1 OR eBible = 1 OR watch = 1) ORDER BY `ROD_Code`, `Variant_Code`");
		$stmt_main->bind_param('s', $iso);														// bind parameters for markers
	}
	elseif ($rod == 'ALL') {
		$stmt_main = $db->prepare("SELECT * FROM `scripture_main` WHERE `ISO` = ? AND `Variant_Code` = ? AND (BibleIs != 0 OR YouVersion = 1 OR Bibles_org = 1 OR GRN = 1 OR eBible = 1 OR watch = 1) ORDER BY `ROD_Code`, `Variant_Code`");
		$stmt_main->bind_param('ss', $iso, $var);												// bind parameters for markers
	}
	elseif ($var == 'ALL') {
			$stmt_main = $db->prepare("SELECT * FROM `scripture_main` WHERE `ISO` = ? AND `ROD_Code` = ? AND (BibleIs != 0 OR YouVersion = 1 OR Bibles_org = 1 OR GRN = 1 OR eBible = 1 OR watch = 1) ORDER BY `ROD_Code`, `Variant_Code`");
			$stmt_main->bind_param('ss', $iso, $rod);											// bind parameters for markers
	}
	else {
		$stmt_main = $db->prepare("SELECT * FROM `scripture_main` WHERE `ISO` = ? AND `ROD_Code` = ? AND `Variant_Code` = ? AND (BibleIs != 0 OR YouVersion = 1 OR Bibles_org = 1 OR GRN = 1 OR eBible = 1 OR watch = 1) ORDER BY `ROD_Code`, `Variant_Code`");
		$stmt_main->bind_param('sss', $iso, $rod, $var);										// bind parameters for markers
	}
}

$stmt_main->execute();															        		// execute query
$result_main = $stmt_main->get_result();

/*
Bible.is: URL, company_title ($BibleIsVersion), BibleIs
Bible.com (YouVersion): URL, company_title ($organization), YouVersion
Bibles.org: URL, company_title ($BiblesComVersion), company ($organization), Bibles_org
GRN: URL, GRN
eBible_list: homeDomain, translationId
watch: organization, watch_what, URL, JesusFilm (0 or 1), YouTube (0 or 1)
*/

$stmt_BibleIs = $db->prepare("SELECT * FROM links WHERE ISO_ROD_index = ? AND NOT BibleIs = 0 ORDER BY BibleIs");
$stmt_BibleIsGospelFilm = $db->prepare("SELECT * FROM links WHERE ISO_ROD_index = ? AND BibleIsGospelFilm = 1");
$stmt_YouVersion = $db->prepare("SELECT * FROM links WHERE ISO_ROD_index = ? AND YouVersion = 1");
$stmt_Bibles_org = $db->prepare("SELECT * FROM links WHERE ISO_ROD_index = ? AND `Bibles_org` = 1");
$stmt_GooglePlay = $db->prepare("SELECT * FROM links WHERE ISO_ROD_index = ? AND GooglePlay = 1");
$stmt_AppleStore = $db->prepare("SELECT * FROM links WHERE ISO_ROD_index = ? AND AppleStore = 1");
$stmt_GRN = $db->prepare("SELECT * FROM links WHERE ISO_ROD_index = ? AND GRN = 1");
$stmt_eBible = $db->prepare("SELECT homeDomain, translationId FROM eBible_list WHERE ISO_ROD_index = ?");
$stmt_watch = $db->prepare("SELECT * FROM watch WHERE ISO_ROD_index = ? ORDER BY organization, watch_what, JesusFilm, YouTube");

$m=0;

$main_rows = $result_main->num_rows;                                                            // number of rows for PDF OT
if ($main_rows == 0) {
    die ('idx or iso does not exist in SE.');
}

$first = '{';
//echo $main_rows . '<br />';
while ($row_main = $result_main->fetch_assoc()) {
    $iso = $row_main['ISO'];
    $rod = $row_main['ROD_Code'];
    $var = $row_main['Variant_Code'];
    $Variant_name = '';
    if ($var != '') {
        $stmt_var->bind_param('s', $var);													    // bind parameters for markers
        $stmt_var->execute();																    // execute query
        $result_temp = $stmt_var->get_result();
        $row_temp = $result_temp->fetch_assoc();
        $Variant_name = $row_temp['Variant_Eng'];
    }
    $idx = (int)$row_main['ISO_ROD_index'];

    $stmt_BibleIs->bind_param('i', $idx);													    // bind parameters for markers
    $stmt_BibleIs->execute();																    // execute query
    $result_BibleIs = $stmt_BibleIs->get_result();
    $stmt_BibleIsGospelFilm->bind_param('i', $idx);												// bind parameters for markers
    $stmt_BibleIsGospelFilm->execute();															// execute query
    $result_BibleIsGospelFilm = $stmt_BibleIsGospelFilm->get_result();
    $stmt_YouVersion->bind_param('i', $idx);													// bind parameters for markers
    $stmt_YouVersion->execute();																// execute query
    $result_YouVersion = $stmt_YouVersion->get_result();
    $stmt_Bibles_org->bind_param('i', $idx);													// bind parameters for markers
    $stmt_Bibles_org->execute();																// execute query
    $result_Bibles_org = $stmt_Bibles_org->get_result();
    $stmt_GooglePlay->bind_param('i', $idx);													// bind parameters for markers
    $stmt_GooglePlay->execute();																// execute query
    $result_GooglePlay = $stmt_GooglePlay->get_result();
    $stmt_AppleStore->bind_param('i', $idx);													// bind parameters for markers
    $stmt_AppleStore->execute();																// execute query
    $result_AppleStore = $stmt_AppleStore->get_result();
    $stmt_GRN->bind_param('i', $idx);													        // bind parameters for markers
    $stmt_GRN->execute();																        // execute query
    $result_GRN = $stmt_GRN->get_result();
    $stmt_eBible->bind_param('i', $idx);													    // bind parameters for markers
    $stmt_eBible->execute();																    // execute query
    $result_eBible = $stmt_eBible->get_result();
    $stmt_watch->bind_param('i', $idx);													        // bind parameters for markers
    $stmt_watch->execute();																        // execute query
    $result_watch = $stmt_watch->get_result();

    $BibleIs=$row_main['BibleIs'];						// boolean
    $BibleIsGospelFilm=$row_main['BibleIsGospelFilm'];	// boolean
    $YouVersion=$row_main['YouVersion'];				// boolean
    $Biblesorg=$row_main['Bibles_org'];			    	// boolean
    $GRN=$row_main['GRN'];								// boolean
    $eBible = $row_main['eBible'];						// boolean
    $watch=$row_main['watch'];							// boolean
    //$links=$row_main['links'];							// boolean

    $m++;																					    // id
    $first .= '"'.($m-1).'": ';
    $first .= '{"type":                     "General Links",';
    $first .= '"id":                        "'.$m.'",';
    $first .= '"attributes": {';
    $first .= '"iso":                       "'.$iso.'",';
    $first .= '"rod":				        "'.$rod.'",';
    $first .= '"var_code":		    	    "'.$var.'",';
    $first .= '"var_name":					"'.$Variant_name.'",';
    $first .= '"iso_query_string":	        "iso='.$iso;
    if ($rod != '00000') {
        $first .= '&rod='.$rod;
    }
    if ($var != '') {
        $first .= '&var='.$var;
    }
    $first .= '",';
    $first .= '"idx":		                '.$idx.',';
    $first .= '"idx_query_string":          "idx='.$idx.'"';	
    $first .= '},';
    $first .= '"relationships": {';

    $n = 0;
    if ($BibleIs) {
        $BibleIsLinkTemp = 0;
        //$num=$result_BibleIs->num_rows;
        if ($result_BibleIs->num_rows > 0) {
            $first .= '"Bible.Is": {';
        }
        while ($r_links=$result_BibleIs->fetch_array(MYSQLI_ASSOC)) {
            $URL=trim($r_links['URL']);
            if (preg_match('/^(.*\/)[a-zA-Z0-9][a-zA-Z]{2}\/[0-9]+$/', $URL, $matches)) {		// remove e.g. Mat/1
                $URL=$matches[1];
            }
            $BibleIsVersion=trim($r_links['company_title']);
            $BibleIsLink=$r_links['BibleIs'];
            $BibleIsActText = '';
            switch ($BibleIsLink) {
                case 1:
                    $BibleIsActText = 'Read and Listen';
                    break;
                case 2:
                    $BibleIsActText = 'Read';
                    break;			
                case 3:
                    $BibleIsActText = 'Read and Listen';
                    break;			
                case 4:
                    $BibleIsActText = 'Read, Listen, and View';
                    break;			
                default:
                    break;
            }
            
            if ($BibleIsLink != $BibleIsLinkTemp) {                                     // 
                if ($n != 0) {
                    $first = rtrim($first, ',');
                    $first .= '},'; 
                }
                $n = 0;
                $first .= '"'.$BibleIsActText.'": {';
            }
            $first .= '"'.$n++.'":	{';
            $first .= '"URL":                           "'.$URL.'",';
            $first .= '"version":                       "'.$BibleIsVersion.'"';
            $first .= '},';
            if ($BibleIsLink != $BibleIsLinkTemp) {                                     // 
                if ($BibleIsLinkTemp != 0) {
                    $first = rtrim($first, ',');
                    $first .= '}}},';
                }
                $BibleIsLink = $BibleIsLinkTemp;
            }
        }
        if ($result_BibleIs->num_rows > 0) {
            $first = rtrim($first, ',');
            $first .= '}},';
        }
    }
    $n=0;

    if ($BibleIsGospelFilm) {
        //$num=mysql_num_rows($result_YouVersion);
        if ($result_BibleIsGospelFilm->num_rows > 0) {
            $first .= '"Bible.is Gospel Film": {';
        }
        while ($r2 = $result_BibleIsGospelFilm->fetch_array(MYSQLI_ASSOC)) {
            $URL=trim($r2['URL']);
            //$organization=trim($r2['company']);
            $BibleIsGospel=trim($r2['company_title']);
            $BibleIsGospel= preg_replace('/^ ?-? ?(.*)/', '$1', $BibleIsGospel);     // remove the text including  -
            $first .= '"'.$n++.'":	{';
            //$first .= '"organization":                  "'.$organization.'",';
            $first .= '"Which Gospel":                  "'.$BibleIsGospel.'",';
            $first .= '"URL":                           "'.$URL.'"';
            $first .= '},';
        }
        if ($result_BibleIsGospelFilm->num_rows > 0) {
            $first = rtrim($first, ',');
            $first .= '},';
        }
    }
    $n=0;

   if ($YouVersion) {
        //$num=mysql_num_rows($result_YouVersion);
        if ($result_YouVersion->num_rows > 0) {
            $first .= '"YouVersion": {';
        }
        while ($r2 = $result_YouVersion->fetch_array(MYSQLI_ASSOC)) {
            $URL=trim($r2['URL']);
            $organization=trim($r2['company_title']);
            $organization = preg_replace('/[^-)]*[-)] (.*)/', '$1', $organization);     // remove the text including ) or -
            $organization = ltrim($organization, '- ');                                 // just in case
            $first .= '"'.$n++.'":	{';
            $first .= '"title":                         "'.$organization.'",';
            $first .= '"URL":                           "'.$URL.'"';
            $first .= '},';
        }
        if ($result_YouVersion->num_rows > 0) {
            $first = rtrim($first, ',');
            $first .= '},';
        }
    }
    $n=0;

    if ($Biblesorg) {
        //$num=mysql_num_rows($result_Bibles_org);
        if ($result_Bibles_org->num_rows > 0) {
            $first .= '"Bibles.org": {';
        }
        while ($r2 = $result_Bibles_org->fetch_array(MYSQLI_ASSOC)) {
            $URL=trim($r2['URL']);
            $organization=trim($r2['company']);
            $BiblesComVersion=trim($r_links['company_title']);
            $first .= '"'.$n++.'":	{';
            $first .= '"organization":                  "'.$organization.'",';
            $first .= '"version":                       "'.$BiblesComVersion.'",';
            $first .= '"URL":                           "'.$URL.'"';
            $first .= '},';
        }
        if ($result_Bibles_org->num_rows > 0) {
            $first = rtrim($first, ',');
            $first .= '},';
        }
    }
    $n=0;

//   if ($GooglePlay) {
        //$num=mysql_num_rows($result_YouVersion);
        if ($result_GooglePlay->num_rows > 0) {
            $first .= '"Google Play": {';
        }
        while ($r2 = $result_GooglePlay->fetch_array(MYSQLI_ASSOC)) {
            $URL=trim($r2['URL']);
            $organization=trim($r2['company_title']);
            $organization = preg_replace('/[^-)]*[-)] (.*)/', '$1', $organization);     // remove the text including ) or -
            $organization = ltrim($organization, '- ');                                 // just in case
            $first .= '"'.$n++.'":	{';
            $first .= '"title":                         "'.$organization.'",';
            $first .= '"URL":                           "'.$URL.'"';
            $first .= '},';
        }
        if ($result_GooglePlay->num_rows > 0) {
            $first = rtrim($first, ',');
            $first .= '},';
        }
//    }
    $n=0;

//   if ($AppleStore) {
        //$num=mysql_num_rows($result_YouVersion);
        if ($result_AppleStore->num_rows > 0) {
            $first .= '"Apple Store": {';
        }
        while ($r2 = $result_AppleStore->fetch_array(MYSQLI_ASSOC)) {
            $URL=trim($r2['URL']);
            $organization=trim($r2['company_title']);
            $organization = preg_replace('/[^-)]*[-)] (.*)/', '$1', $organization);     // remove the text including ) or -
            $organization = ltrim($organization, '- ');                                 // just in case
            $first .= '"'.$n++.'":	{';
            $first .= '"title":                         "'.$organization.'",';
            $first .= '"URL":                           "'.$URL.'"';
            $first .= '},';
        }
        if ($result_AppleStore->num_rows > 0) {
            $first = rtrim($first, ',');
            $first .= '},';
        }
//    }
    $n=0;

    if ($GRN) {
        //$num=mysql_num_rows($result_GRN);
        if ($result_GRN->num_rows > 0) {
            $first .= '"GRN": {';
        }
        while ($r2 = $result_GRN->fetch_array(MYSQLI_ASSOC)) {
            $URL=trim($r2['URL']);
            //$organization=trim($r2['company']);
            $first .= '"'.$n++.'":	{';
            $first .= '"URL":                           "'.$URL.'"';
            $first .= '},';
        }
        if ($result_GRN->num_rows > 0) {
            $first = rtrim($first, ',');
            $first .= '},';
        }
    }
    $n=0;

    if ($eBible) {
        //$num2=$result_eBible->num_rows;
        if ($result_eBible->num_rows > 0) {
            $first .= '"eBible": {';
        }
        if ($r2 = $result_eBible->fetch_array(MYSQLI_ASSOC)) {
            $homeDomain=trim($r2['homeDomain']);
            $translationId=trim($r2['translationId']);
            if ($homeDomain == 'inscript.org') {
                $publicationURL='eBible.org/find/details.php?id=' . $translationId;
            }
            else {
                $publicationURL=$homeDomain . '/' . $translationId;
            }
            $first .= '"'.$n++.'":	{';
            $first .= '"URL":                           "http://'.$publicationURL.'"';
            $first .= '},';
        }
        if ($result_eBible->num_rows > 0) {
            $first = rtrim($first, ',');
            $first .= '},';
        }
    }
    $n=0;

    if ($watch) {
        //$num2=$result_watch->num_rows;
        $y=0;
        $o=0;
        while ($r2 = $result_watch->fetch_array(MYSQLI_ASSOC)) {
            $URL=trim($r2['URL']);
            $organization=trim($r2['organization']);
            $title=trim($r2['watch_what']);
            $JesusFilm=trim($r2['JesusFilm']);							// booleon
            $YouTube=trim($r2['YouTube']);								// booleon
            if ($JesusFilm) {
                if ($n == 0) {
                    $first .= '"JesusFilm": {';
                }
                $first .= '"'.$n++.'":	{';
                // JESUS Film
                $first .= '"title":                     "'.$title.'",';
                if (substr($URL, 0, strlen("http://api.arclight.org/videoPlayerUrl")) == "http://api.arclight.org/videoPlayerUrl") {
                    $first .= '"URL":                       "JESUSFilmView.php?'.$URL.'"';
                }
                else {
                    $first .= '"URL":                   "'.$URL.'"';
                }
            }
            elseif ($YouTube) {
                if ($n > 0 && $y == 0) {
                    $first = rtrim($first, ',');
                    $first .= '},';
                }
                if ($y == 0) {
                    $first .= '"YouTube": {';
                }
                $first .= '"'.$y++.'": {';
                // YouTube
                $first .= '"organization":              "'.$organization.'",';
                $first .= '"title":                     "'.$title.'",';
                $first .= '"URL":                       "'.$URL.'"';
                $first .= '},';
            }
            else {
                if ($n > 0 || $y > 0 && $o == 0) {
                    $first = rtrim($first, ',');
                    $first .= '},';
                }
                if ($o == 0) {
                    $first .= '"other_videos": {';
                }
                $first .= '"'.$o++.'": {';
                $first .= '"organization":              "'.$organization.'",';
                $first .= '"title":                     "'.$title.'",';
                $first .= '"URL":                       "'.$URL.'"';
                $first .= '},';
            }
        }
        if ($result_watch->num_rows > 0) {
            $first = rtrim($first, ',');
            $first .= '},';
        }
    }
    $n=0;

    if ($m < $main_rows) {
        $first = rtrim($first, ',');
        $first .= '}},';
    }
}
    
$first = rtrim($first, ',');
$first .= '}}}';

//echo $first;
//exit;

$marks = json_decode($first, true, 4096, JSON_INVALID_UTF8_IGNORE);

//foreach ($marks as $mark) {
//    echo $mark . '<br />';
//}
//var_dump($marks);
//exit;

header('Content-Type: application/json');														// instead of <pre></pre>
// An associative array
$json_string = json_encode($marks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
//echo '<pre>'.$json_string.'</pre>';
echo $json_string;

?>