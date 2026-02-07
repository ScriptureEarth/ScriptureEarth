<?php

$index = 0;
$first = '';
$marks = [];
//$temp_array = [];

require_once '../include/conn.inc.php';															// connect to the database named 'scripture'
$db = get_my_db();

include 'include/v.key.php';																	// get v and key

include 'include/idx.iso.php';																	// get idx or iso

if ($index == 0) {																				// or language language and alternate language names
	// retrieve all of the language names
	if (isset($_GET['pln'])) {
		$languageName = $_GET['pln'];
		$index = 3;																				// $index = 3;
	}
	else {
		die ('HACK!');
	}
}

//$stmt_iso = $db->prepare("SELECT * FROM scripture_main WHERE ISO = ?");
$stmt_main = $db->prepare("SELECT * FROM scripture_main, nav_ln WHERE scripture_main.ISO_ROD_index = ? AND scripture_main.ISO_ROD_index = nav_ln.ISO_ROD_index");
$stmt_var = $db->prepare("SELECT Variant_Eng FROM Variants WHERE Variant_Code = ?");
$stmt_country = $db->prepare("SELECT ISO_countries, English FROM countries, ISO_countries WHERE ISO_countries.ISO_ROD_index = ? AND ISO_countries.ISO_countries = countries.ISO_Country");
$stmt_alt = $db->prepare("SELECT alt_lang_name FROM alt_lang_names WHERE ISO_ROD_index = ?");
$stmt_OT_PDF = $db->prepare("SELECT COUNT(*) AS OT_PDF_temp FROM OT_PDF_Media WHERE ISO_ROD_index = ?");
$stmt_NT_PDF = $db->prepare("SELECT COUNT(*) AS NT_PDF_temp FROM NT_PDF_Media WHERE ISO_ROD_index = ?");
$stmt_OT_Audio = $db->prepare("SELECT COUNT(*) AS OT_Audio_temp FROM OT_Audio_Media WHERE ISO_ROD_index = ?");
$stmt_NT_Audio = $db->prepare("SELECT COUNT(*) AS NT_Audio_temp FROM NT_Audio_Media WHERE ISO_ROD_index = ?");
$stmt_SAB = $db->prepare("SELECT COUNT(*) AS SAB_temp FROM SAB WHERE ISO_ROD_index = ? AND SAB_Audio = ?");
$stmt_links = $db->prepare("SELECT LOWER(company) AS company_temp, map, BibleIs, BibleIsGospelFilm, YouVersion, GooglePlay, GRN, email, Kalaam, AppleStore FROM links WHERE ISO_ROD_index = ? AND (map >= 1 OR BibleIs >= 1 OR BibleIsGospelFilm >= 1 OR GRN >= 1 OR email >= 1 OR Kalaam >= 1 OR YouVersion >= 1 OR GooglePlay >= 1 OR company = 'website' OR company = 'webpage' OR AppleStore >= 1)");
$stmt_CellPhone = $db->prepare("SELECT Cell_Phone_Title FROM CellPhone WHERE ISO_ROD_index = ?");
$stmt_PlaylistVideo = $db->prepare("SELECT PlaylistVideoDownload FROM PlaylistVideo WHERE ISO_ROD_index = ?");
$stmt_other_titles = $db->prepare("SELECT COUNT(*) AS ePub FROM other_titles WHERE ISO_ROD_index = ? AND other_PDF LIKE '%.epub'");
$stmt_English = $db->prepare("SELECT LN_English FROM LN_English WHERE ISO_ROD_index = ?");
$stmt_Spanish = $db->prepare("SELECT LN_Spanish FROM LN_Spanish WHERE ISO_ROD_index = ?");
$stmt_Portuguese = $db->prepare("SELECT LN_Portuguese FROM LN_Portuguese WHERE ISO_ROD_index = ?");
$stmt_French = $db->prepare("SELECT LN_French FROM LN_French WHERE ISO_ROD_index = ?");
$stmt_Dutch = $db->prepare("SELECT LN_Dutch FROM LN_Dutch WHERE ISO_ROD_index = ?");
$stmt_German = $db->prepare("SELECT LN_German FROM LN_German WHERE ISO_ROD_index = ?");
$stmt_Chinese = $db->prepare("SELECT LN_Chinese FROM LN_Chinese WHERE ISO_ROD_index = ?");
$stmt_Korean = $db->prepare("SELECT LN_Korean FROM LN_Korean WHERE ISO_ROD_index = ?");
$stmt_Russian = $db->prepare("SELECT LN_Russian FROM LN_Russian WHERE ISO_ROD_index = ?");
$stmt_Arabic = $db->prepare("SELECT LN_Arabic FROM LN_Arabic WHERE ISO_ROD_index = ?");
//$stmt_iso_languages = $db->prepare("SELECT * FROM scripture_main ORDER BY ISO");

if ($index == 1) {					// idx
	$query = "SELECT * FROM scripture_main, nav_ln WHERE `scripture_main`.`ISO_ROD_index` = $idx AND `scripture_main`.`ISO_ROD_index` = `nav_ln`.`ISO_ROD_index`";
	$result=$db->query($query) or die ('Query failed: ' . $db->error . '</body></html>');
	if ($result->num_rows === 0) {
		die ('<div style="background-color: white; color: red; font-size: 16pt; padding-top: 20px; padding-bottom: 20px; margin-top: 200px; ">The ISO/ROD index is not found.</div></body></html>');
	}
	$row = $result->fetch_array();

	include("include/ISO_details.php");

	include('include/LN_details.php');	
	// Author: 'ChickenFeet'
	//$LN_[the language name] = CheckLetters($LN_[the language name]);							// diacritic removal

	$m = 1;
	$first = '{';
	include('include/print.php');
	$first = rtrim($first, ',');
	$first .= '}';

	$marks = [];
	$marks = json_decode($first);

//	$marks[] = ["links" => ["self" => "https://ScriptureEarth.org"]];
//	$marks[] = ["data" => ["ISO"=>$ISO, "ROD code"=>$ROD_Code, "variant code"=>$Variant_Code, "ISO_ROD_index"=>$idx, "OT PDF"=>$OT_PDF, "NT PDF"=>$NT_PDF, "OT Audio"=>$OT_Audio, "NT Audio"=>$NT_Audio, "links"=>$links, "other titles"=>$other_titles, "watch"=>$watch, "buy"=>$buy, "study"=>$study, "viewer"=>$viewer, "Cell Phone"=>$CellPhone, "Bible.is"=>$BibleIs, "You Version"=>$YouVersion, "Bibles.org"=>$Bibles_org, "Playlist Audio"=>$PlaylistAudio, "Playlist Video"=>$PlaylistVideo, "SAB Audio"=>$SAB_Audio, "SAB Text"=>$SAB_Text, "eBible"=>$eBible, "SIL link"=>$SILlink, "Global Recaords Network"=>$GRN]];
}
elseif ($index == 2) {						// iso/rod/var
	//$query = "SELECT * FROM scripture_main, nav_ln WHERE scripture_main.ISO = '$iso' AND `scripture_main`.`ISO` = `nav_ln`.`ISO`";
	//$query = "SELECT * FROM scripture_main WHERE scripture_main.ISO = '$iso' " . ($rod == 'ALL' ? '' : "AND scripture_main.ROD_Code = '$rod' ") . ($var == 'ALL' ? '' : "AND scripture_main.Variant_Code = '$var'");
	$query = "SELECT * FROM scripture_main, nav_ln WHERE scripture_main.ISO = '$iso' " . ($rod == 'ALL' ? '' : "AND scripture_main.ROD_Code = '$rod' ") . ($var == 'ALL' ? '' : "AND scripture_main.Variant_Code = '$var'") . " AND `scripture_main`.`ISO_ROD_index` = `nav_ln`.`ISO_ROD_index`";
	$result=$db->query($query) or die ('Query failed:' . $db->error . '</body></html>');
	if ($result->num_rows === 0) {
		die ('<div style="background-color: white; color: red; font-size: 16pt; padding-top: 20px; padding-bottom: 20px; margin-top: 200px; ">The ISO language code is not found.</div></body></html>');
	}

	//$temp_array = [];
	$m = 0;
	//$first = '{"links": {"self": "https://ScriptureEarth.org"},';		// must HAVE " around the strings!
	//$first .= '"data": {';
	$first = '{';
	while ($row = $result->fetch_array()) {
		$m++;

		include("include/ISO_details.php");

		include('include/LN_details.php');
		// Author: 'ChickenFeet'
		//$LN_[the language name] = CheckLetters([the language name]);							// diacritic removal

//echo '<br /><br />';
//var_dump($marks);
//echo '<br /><br />';
		//$temp_array = [];
		include('include/print.php');
	}
	$first = rtrim($first, ',');
	$first .= '}';

//echo $first . '<br /><br />';		// It works as a JSON!!!!
	$marks = [];
//var_dump(json_decode($first));
//echo '<br /><br />';
//echo json_encode(json_decode($first), JSON_FORCE_OBJECT);
	$marks = json_decode($first);
//var_dump($marks);
}
else {										// part of the language/alternate names
	//$query = "SELECT * FROM scripture_main WHERE ISO_ROD_index = $iso_rod_index";
	//$result=$db->query($query) or die (translate('Query failed:', $st, 'sys') . ' ' . $db->error . '</body></html>');
	$query="SELECT * FROM `scripture_main`, `nav_ln` WHERE `scripture_main`.`ISO_ROD_index` = `nav_ln`.`ISO_ROD_index` ORDER BY `scripture_main`.`ISO`";
	if ($result = $db->query($query)) {
		if ($result->num_rows <= 0) {
			die ('<div style="background-color: white; color: red; font-size: 16pt; padding-top: 20px; padding-bottom: 20px; margin-top: 200px; ">The language name is not found.</div></body></html>');
		}
		$LN = [];
		$m = 0;
		$first = '{';
		while ($row = $result->fetch_array()) {													// "SELECT * FROM scripture_main ORDER BY ISO"

			include('include/alt_LN_details.php');												// reads record row
			
			$LN = array_unique($LN);															// removes duplicate values from an array

			$LN_string = implode(', ', $LN);													// Convert Array To String

			// Author: 'ChickenFeet'
			$temp_LN = CheckLetters($LN_string);												// diacritic removal
			
			$ALN = mb_strtolower($temp_LN);														// lower case language name without the diacritics

			//echo $languageName . ': ' . $ALN . ': ' . $row['ISO'] . '<br /><br />';
			
			$test = preg_match("/\b".$languageName.'(\t|,|$)/ui', $ALN, $match);						// match the beginning of the word(s) with TryLanguage from the user
			if ($test == 1) {
				//$query="SELECT * FROM scripture_main WHERE ISO_ROD_index = $idx";
				$stmt_main->bind_param('i', $idx);												// bind parameters for markers
				$stmt_main->execute();															// execute query
				if ($result_temp = $stmt_main->get_result()) {
					if ($result_temp->num_rows <= 0) {
						die ('<div style="background-color: white; color: red; font-size: 16pt; padding-top: 20px; padding-bottom: 20px; margin-top: 200px; ">The language name is not found.</div></body></html>');
					}

					//$alt = '';
					//$alt_ln = 0;
					//$query="SELECT alt_lang_name FROM alt_lang_names WHERE ISO_ROD_index = $idx";
					//$stmt_alt->bind_param('i', $idx);									// bind parameters for markers
					//$stmt_alt->execute();														// execute query
					//if ($result_alt = $stmt_alt->get_result()) {
					//	if ($result_alt->num_rows > 0) {
					//		$alt_ln = $result_alt->num_rows;													// 0 or 1
					//		while ($row_alt = $result_alt->fetch_assoc()) {						// alternate language names
					//			$alt .= $row_alt['alt_lang_name'] . ', ';
					//		}
					//		$alt = rtrim($alt, ', ');
					//	}
					//}

					$m++;
					$row = $result_temp->fetch_assoc();											// "SELECT * FROM scripture_main WHERE ISO_ROD_index = $idx"

					include("include/ISO_details.php");

					include("include/LN_details.php");

					include("include/print.php");

					// "LN"=>$temp_LN, 
					//$temp_array = ["Partial Language Name"=>$languageName, "Language Name"=>$temp_LN, "Alternate"=>$alt, "ISO_ROD_index"=>$idx, "ISO"=>$ISO, "ROD code"=>$ROD_Code, "variant code"=>$Variant_Code, "ISO_ROD_index"=>$idx, "OT PDF"=>$OT_PDF, "NT PDF"=>$NT_PDF, "OT Audio"=>$OT_Audio, "NT Audio"=>$NT_Audio, "links"=>$links, "other titles"=>$other_titles, "watch"=>$watch, "buy"=>$buy, "study"=>$study, "viewer"=>$viewer, "Cell Phone"=>$CellPhone, "Bible.is"=>$BibleIs, "You Version"=>$YouVersion, "Bibles.org"=>$Bibles_org, "Playlist Audio"=>$PlaylistAudio, "Playlist Video"=>$PlaylistVideo, "SAB Audio"=>$SAB_Audio, "SAB Text"=>$SAB_Text, "eBible"=>$eBible, "SIL link"=>$SILlink, "GRN"=>$GRN];
					//$marks[] = $temp_array;														// add an array to another array
					$langISOrod[] = $idx;
					//echo '<br /><br />';
					//print_r($marks);
					//echo '<br /><br />';
					//$temp_array = [];
				}
			}
			$LN = [];
		}
	}

	//echo $first . '<br /><br />';

	// Try alt_lang_names:
	//echo '<p>Do not have alternate language names done because language names have alreay be done:</p>';
	//echo '<pre>';
	//var_dump($langISOrod);
	//echo '</pre>';

	// REGEXP '[[:<:]]... = in PHP '\b... (word boundries)
	if (empty($langISOrod)) {
		$query="SELECT DISTINCT ISO_ROD_index FROM alt_lang_names WHERE alt_lang_name REGEXP '[[:<:]]$languageName($|,)'";
	}
	else {
		$query="SELECT DISTINCT ISO_ROD_index FROM alt_lang_names WHERE alt_lang_name REGEXP '(^| )$languageName($|,)' AND ISO_ROD_index NOT IN (".implode(',', $langISOrod).")";		// won't quick work under MariaDB 10.1.44
	}
	if ($result = $db->query($query)) {
		while ($r = $result->fetch_assoc()) {
			$idx = $r['ISO_ROD_index'];
			//$query="SELECT * FROM scripture_main WHERE ISO_ROD_index = $idx";
			//if ($result_SM = $db->query($query)) {
			$stmt_main->bind_param('i', $idx);										// bind parameters for markers
			$stmt_main->execute();																// execute query
			if ($result_SM = $stmt_main->get_result()) {
				if ($row = $result_SM->fetch_assoc()) {
					//$query="SELECT alt_lang_name FROM alt_lang_names WHERE ISO_ROD_index = $idx";
					$stmt_alt->bind_param('i', $idx);									// bind parameters for markers
					$stmt_alt->execute();														// execute query
					if ($result_alt = $stmt_alt->get_result()) {
						if ($result_alt->num_rows > 0) {
							$m++;
							//$alt = '';
							//while ($row_alt = $result_alt->fetch_assoc()) {						// alternate language names
							//	$alt .= $row_alt['alt_lang_name'] . ', ';
							//}
							//$alt = rtrim($alt, ', ');

							//$LN = [];
							//include('include/alt_LN_details.php');
							//$LN_string = implode(', ', $LN);									// Convert Array To String
							// Author: 'ChickenFeet'
							//$ALN = CheckLetters($LN_string);									// diacritic removal
							//echo $ALN . '<br />';

							include('include/ISO_details.php');

							include("include/LN_details.php");

							include('include/print.php');

//							$first = rtrim($first, ',');
//							$first .= '}';

//							$marks = [];
//							$marks = json_decode($first);
							//echo $first;

//							$temp_array = ["Partial Language Name"=>$languageName, "Language Name"=>$LN, "Alternate"=>$alt, "ISO_ROD_index"=>$idx, "ISO"=>$ISO, "ROD code"=>$ROD_Code, "variant code"=>$Variant_Code, "ISO_ROD_index"=>$idx, "OT PDF"=>$OT_PDF, "NT PDF"=>$NT_PDF, "OT Audio"=>$OT_Audio, "NT Audio"=>$NT_Audio, "links"=>$links, "other titles"=>$other_titles, "watch"=>$watch, "buy"=>$buy, "study"=>$study, "viewer"=>$viewer, "Cell Phone"=>$CellPhone, "Bible.is"=>$BibleIs, "You Version"=>$YouVersion, "Bibles.org"=>$Bibles_org, "Playlist Audio"=>$PlaylistAudio, "Playlist Video"=>$PlaylistVideo, "SAB Audio"=>$SAB_Audio, "SAB Text"=>$SAB_Text, "eBible"=>$eBible, "SIL link"=>$SILlink, "GRN"=>$GRN];
//							$marks[] = $temp_array;																	// add an array to another array
							//echo '<br /><br />';
							//print_r($marks);
							//echo '<br /><br />';
//							$temp_array = [];
						}
					}
				}
			}
		}
		$first = rtrim($first, ',');
		$first .= '}';		
	}
	$marks = [];
	$marks = json_decode($first);
}
//echo $first;
//exit;
header('Content-Type: application/json');														// instead of <pre></pre>
// An associative array
$json_string = json_encode($marks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
//echo '<pre>'.$json_string.'</pre>';
echo $json_string;


// actual exit!


function removeDiacritics($txt) {
    $transliterationTable = ['à' => 'a', 'À' => 'A', 'á' => 'a', 'Á' => 'A', 'â' => 'a', 'Â' => 'A', 'ä' => 'a', 'Ä' => 'A', 'ā' => 'a', 'Ã' => 'A', 'å' => 'a', 'Å' => 'A', 'æ' => 'ae', 'Æ' => 'AE', 'ǣ' => 'ae', 'Ǣ' => 'AE',
	'ç' => 'c', 'Ç' => 'C',
	'�' => 'D', 'ð' => 'dh', 'Ð' => 'Dh',
	'é' => 'e', 'É' => 'E', 'è' => 'e', 'È' => 'E', 'ë' => 'e', 'Ë' => 'E', 'ē' => 'e', 'Ê' => 'E',
	'ī' => 'i', 'Ī' => 'I', 'í' => 'i', 'Í' => 'I', 'ì' => 'i', 'Ì' => 'I', 'ï' => 'i', 'Ï' => 'I',
	'ñ' => 'n', 'Ñ' => 'N',
	'ō' => 'o', 'Ō' => 'O', 'ó' => 'o', 'Ó' => 'O', 'ò' => 'o', 'Ò' => 'O', 'ö' => 'o', 'Ö' => 'O', 'œ' => 'oe', 'Œ' => 'OE', 'œ' => 'oe', 'Œ' => 'OE',
	'ś' => 's', 'Ś' => 'S', 'ß' => 'SS',
	'ū' => 'u', 'Ū' => 'U', 'ú' => 'u', 'Ú' => 'U', 'ù' => 'u', 'Ù' => 'U', 'ü' => 'ue', 'Ü' => 'UE',
	'ŷ' => 'y', 'Ŷ' => 'Y', 'ÿ' => 'y', 'Ÿ' => 'Y',
	'ź' => 'z', 'Ź' => 'Z'];
	return strtr($txt, $transliterationTable);
}    // or, return str_replace(array_keys($transliterationTable), array_values($transliterationTable), $txt);


// Author: 'ChickenFeet'
function CheckLetters($field){
	// global $letters;										// won't work
    $letters = [
        0 => "a à á â ä æ ã å ā",
        1 => "c ç ć č",
        2 => "e é è ê ë ę ė ē",
        3 => "i ī į í ì ï î",
        4 => "l ł",
        5 => "n ñ ń",
        6 => "o ō ø œ õ ó ò ö ô",
        7 => "s ß ś š",
        8 => "u ū ú ù ü û",
        9 => "w ŵ",
        10 => "y ŷ ÿ",
        11 => "z ź ž ż",
    ];
    foreach ($letters as &$values){
        $newValue = substr($values, 0, 1);
        $values = substr($values, 2, strlen($values));
        $values = explode(' ', $values);
        foreach ($values as &$oldValue){
            while (strpos($field, $oldValue) !== false){
                $field = preg_replace('/' . $oldValue . '/', $newValue, $field, 1);
            }
        }
    }
    return $field;
}
?>
