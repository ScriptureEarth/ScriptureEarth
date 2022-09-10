<?php
// Start the session
session_start();
/*
Updated by Scott Starker, Lærke Roager
AJAX from LangSearch.js
Can't use $_SESSION because as AJAX PHP there is NO global variables with AJAX including $_SESSION. Although SESSION_ID would work slower than mine.
Problems: TryLanguage ' should be \' 
MySQL: utf8_general_ci flattens accents as well as lower-case:
You must ensure that all parties (your app, mysql connection, your table or column) have set utf8 as charset.
- header('Content-Type: text/html; charset=utf-8'); (or <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />)
- ensure your mysqli connection use utf8 before any operation:
	- $mysqli->set_charset('utf8')
- create your table or column using utf8_general_ci
*/

/*
	input:
		language (string: 'try language')
		st (string: eng, spa, por, fre, ndl, deu, cmn)
		nav_ln_line (strng: navigational languages separated by ', ')
		MajorLanguage = LN_English
		Variant_major = Variant_Eng
		SpecificCountry = English
		e.g. LSearch.php?language=kerala&st=eng&Variant_major=Variant_Eng&SpecificCountry=English&MajorLanguage=LN_English&nav_ln_line=LN_English,%20LN_Spanish,%20LN_Portuguese,%20LN_French,%20LN_Dutch,%20LN_German,%20LN_Chinese,
*/

/*
	These are defined at the end of $response:
	langNotFound = "The language is not found.";
	colLN = "Language Name";
	colAlt = "Alternate Language Names";
	colCode = "Code";
	colCountry = "Country";
*/

// display all of the language names, ROD codes and variant codes from a major and alternate languages names
if (isset($_GET['language'])) $TryLanguage = $_GET['language']; else { die('Hack!'); }
if (preg_match("/^[-. ,'?()A-Za-záéíóúÑñçãõâêîôûäëöüï&]+/", $TryLanguage)) {
}
else {
	die('Hack!');
}
if (isset($_GET['st'])) {
	$st = $_GET['st'];
	$st = preg_replace('/^([a-z]{3})/', '$1', $st);
	if ($st == NULL) {
		die('Hack!');
	}
}
else {
	 die('Hack!');
}

if (strlen($TryLanguage) > 2) {
	$response = '';
	$MajorLanguage = '';
	$Variant_major = '';

	$ln_result = '';												// get all of the navigigatioal language fields
	foreach($_SESSION['nav_ln_array'] as $code => $array){
		if ($st == $array[0]){
			$MajorLanguage = 'LN_'.$array[1];
			$Variant_major = 'Variant_'.$array[0];
			$SpecificCountry = $array[1];
		}
		$ln_result .= 'LN_'.$array[1].', ';
	}
	if ($Variant_major == ''){
		$response = '"st" never found.';
		exit();
	}

	$MajorLanguage = $_GET['MajorLanguage'];
	$Variant_major = $_GET['Variant_major'];
	$SpecificCountry = $_GET['SpecificCountry'];
	$hint = 0;
	include './include/conn.inc.php';
	$db = get_my_db();
	include './translate/functions.php';							// translation function
	
	$langISOrod = [];
	$ISO_only = '';
	$Country_Total = [];

	$stmt_SC = $db->prepare("SELECT DISTINCT $SpecificCountry, ISO_Country FROM nav_ln, countries, ISO_countries WHERE countries.ISO_Country = ISO_countries.ISO_countries AND ISO_countries.ISO = nav_ln.ISO AND nav_ln.ISO_ROD_index = ?");														// create a prepared statement
	$stmt_c = $db->prepare("SELECT ISO_Country FROM countries WHERE $SpecificCountry = ?");
	$stmt_Var = $db->prepare("SELECT $Variant_major FROM Variants WHERE Variant_Code = ?");
	$stmt_alt = $db->prepare("SELECT alt_lang_name FROM alt_lang_names WHERE ISO_ROD_index = ?");
	$stmt_nav_ln_idx = $db->prepare("SELECT ISO, ROD_Code, Variant_Code, ".$ln_result."Def_LN FROM nav_ln WHERE ISO_ROD_index = ?");
	$stmt_nav_ln_iso = $db->prepare("SELECT ISO_ROD_index, ISO, ROD_Code, Variant_Code, ".$ln_result."Def_LN FROM nav_ln WHERE ISO = ?");

	// ISO
	if (strlen($TryLanguage) == 3) {
		$stmt_nav_ln_iso->bind_param('s', $TryLanguage);										// bind parameters for markers
		$stmt_nav_ln_iso->execute();															// execute query
		$result=$stmt_nav_ln_iso->get_result() or die (translate('Query failed:', $st, 'sys') . ' ' . $db->error . '</body></html>');
		$LN = '';
		while ($row = $result->fetch_assoc()) {
			$ISO_ROD_index = $row['ISO_ROD_index'];
			$ISO = $row['ISO'];
			$ROD_Code = $row['ROD_Code'];
			$Variant_Code = $row['Variant_Code'];
			$VD = '';
			include './include/00-DBLanguageCountryName.inc.php';							// returns $LN
			$stmt_SC->bind_param('i', $ISO_ROD_index);										// bind parameters for markers
			$stmt_SC->execute();															// execute query
			$result_con=$stmt_SC->get_result() or die (translate('Query failed:', $st, 'sys') . ' ' . $db->error . '</body></html>');
			if ($result_con->num_rows == 0) {
				die (translate('The ISO language code is not found.', $st, 'sys') . '</body></html>');
			}
			$country = '';
			$temp_Country = '';
			while ($row_con = $result_con->fetch_array()) {
				$temp_Country = trim($row_con["$SpecificCountry"]);							// name of the country in the language version
				if (strpos($temp_Country, ',')) {											// if $temp_Country contains a ','
					$temp_c = FALSE;
					$country_array = preg_split('/, ?/', $temp_Country);					// split the string $temp_Country for the beginning of word(s)
					foreach ($country_array as $key => $value) {
						$temp_c = in_array($value, $Country_Total);							// if $value is within the $Country_Total array
						if ($temp_c == FALSE) {
							array_push($Country_Total, $value);								// save the string $value into $Country_Total array
							if ($country === '') {
								$country = $value;											// name of the country in the language version
							}
							else {
								$country .= ', ' . $value;									// name of the country in the language version
							}
							$stmt_c->bind_param('s', $value);								// bind parameters for markers
							$stmt_c->execute();												// execute query
							$result_c=$stmt_c->get_result() or die (translate('Query failed:', $st, 'sys') . ' ' . $db->error . '</body></html>');
							if ($result_c->num_rows <= 0) {
								//die (translate('The ISO_Country language code is not found.', $st, 'sys') . '</body></html>');
							}
							$row_c = $result_c->fetch_array();
							$country .= ':' . $row_c['ISO_Country'];
						}
						$temp_c = FALSE;
					}
				}
				else {
					if ($country === '') {
						$country = $temp_Country . ':' . $row_con['ISO_Country'];			// name of the country in the language version
					}
					else {
						$country .= ', ' . $temp_Country . ':' . $row_con['ISO_Country'];	// name of the country in the language version
					}
				}
			}

			if (is_null($Variant_Code) || $Variant_Code == '') {
				$VD = '';
			}
			else {
				$stmt_Var->bind_param('s', $Variant_Code);									// bind parameters for markers								// 
				$stmt_Var->execute();														// execute query
				$result_Var = $stmt_Var->get_result();
				$row_Var = $result_Var->fetch_assoc();
				$VD = $row_Var["$Variant_major"];
			}
			
			/******************************************************************************
					alternate language names
			*******************************************************************************/
			$alt = '';
			$stmt_alt->bind_param('i', $ISO_ROD_index);										// bind parameters for markers
			$stmt_alt->execute();															// execute query
			if ($result_alt = $stmt_alt->get_result()) {
				$bool = 0;
				while ($row_alt = $result_alt->fetch_assoc()) {
					$alt_temp = $row_alt['alt_lang_name'];
					$temp_TL = str_replace('(', '\(', $TryLanguage);
					$temp_TL = str_replace(')', '\)', $temp_TL);
					$temp_TL = str_replace('.', '\.', $temp_TL);
					if (preg_match("/(\s|-|^)".$temp_TL."/i", $alt_temp)) {
						if ($bool == 0) {
							$alt = $alt_temp;
							$bool = 1;
							continue;
						}
						$alt .= ', '.$alt_temp;
					}
				}
			}
			
			if ($hint == 0) {
				$response = $LN.'|'.$alt.'|'.$ISO.'|'.$country.'|'.$ROD_Code.'|'.$VD.'|'.$ISO_ROD_index;
				$hint = 1;
			}
			else {
				$response .= '<br />'.$LN.'|'.$alt.'|'.$ISO.'|'.$country.'|'.$ROD_Code.'|'.$VD.'|'.$ISO_ROD_index;
			}
			$langISOrod[] = $ISO_ROD_index;
			$ISO_only = $ISO;
		}
	}
//echo $country . '#<br />';
	
	$RD = ['?' => 'a', '?' => 'A', '?' => 'a', '?' => 'A', '?' => 'a', '?' => 'A', '?' => 'a', '?' => 'A', '?' => 'a', '?' => 'A', '?' => 'ae', '?' => 'AE', '?' => 'ae', '?' => 'AE', '?' => 'c', '?' => 'C', '?' => 'D', '?' => 'dh', '?' => 'Dh', '?' => 'e', '?' => 'E', '?' => 'e', '?' => 'E', '?' => 'e', '?' => 'E', '?' => 'e', '?' => 'E', '?' => 'i', '?' => 'I', '?' => 'i', '?' => 'I', '?' => 'i', '?' => 'I', '?' => 'i', '?' => 'I', '?' => 'n', '?' => 'N', '?' => 'o', '?' => 'O', '?' => 'o', '?' => 'O', '?' => 'o', '?' => 'O', '?' => 'o', '?' => 'O', '?' => 'oe', '?' => 'OE', '?' => 'oe', '?' => 'OE', '?' => 's', '?' => 'S', '?' => 'SS', '?' => 'u', '?' => 'U', '?' => 'u', '?' => 'U', '?' => 'u', '?' => 'U', '?' => 'ue', '?' => 'UE', '?' => 'y', '?' => 'Y', '?' => 'y', '?' => 'Y', '?' => 'z', '?' => 'Z'];
	if (preg_match('/[??????????????????????????]/', $TryLanguage)) {							// diacritic removal
		$TryLanguage = strtr($TryLanguage, $RD);												// PHP: strtr - Translate characters ($addr = strtr($addr, "???", "aao");)
	}
	
	$TryLanguage = str_replace("'", "\'", $TryLanguage);

	// Try languages names:
	$query="SELECT * FROM nav_ln ORDER BY ISO";
	if ($result = $db->query($query)) {
		$LN = '';
		while ($row = $result->fetch_assoc()) {													// All ISOs + ROD codes + variants
			$ISO_ROD_index = $row['ISO_ROD_index'];
			include './include/00-DBLanguageCountryName.inc.php';								// returns LN
			// Author: 'ChickenFeet'
			$temp_LN = CheckLetters($LN);														// diacritic removal
			
			$temp_LN = mb_strtolower($temp_LN);													// lower case language name without the diacritics
			
			$temp_TL = str_replace('(', '\(', $TryLanguage);
			$temp_TL = str_replace(')', '\)', $temp_TL);
			$temp_TL = str_replace('.', '\.', $temp_TL);
			if (preg_match("/\b".$temp_TL.'/ui', $temp_LN, $match)) {							// match the beginning of the word(s) with TryLanguage from the user
				$ISO = $row['ISO'];
				if (strlen($TryLanguage) == 3 && $ISO == $ISO_only) {							// if the length of $TryLanguage is 3 and the top section is there
					continue;
				}
				$ROD_Code = $row['ROD_Code'];
				$Variant_Code = $row['Variant_Code'];
				$VD = '';
				$stmt_SC->bind_param('i', $ISO_ROD_index);										// bind parameters for markers
				$stmt_SC->execute();															// execute query
				$result_con=$stmt_SC->get_result() or die (translate('Query failed:', $st, 'sys') . ' ' . $db->error . '</body></html>');
				if ($result_con->num_rows <= 0) {
					die (translate('The ISO language code is not found.', $st, 'sys') . '</body></html>');
				}
				$country = '';
				$temp_Country = '';
				while ($row_con = $result_con->fetch_array()) {
					$temp_Country = trim($row_con["$SpecificCountry"]);							// name of the full country in the language version
					if (strpos($temp_Country, ',')) {											// if $temp_Country contains a ',' (from the error that somebody made when the CMS entery didn't contain 1 country at a time)
						$temp_c = FALSE;
						$country_array = preg_split('/, ?/', $temp_Country);					// splits out the word(s) (i.e. countries)
						foreach($country_array as $key => $value) {
							$temp_c = in_array($value, $Country_Total);							// is the string $value is within $Country_Total array and delete the value if it exists
							if ($temp_c == FALSE) {
								array_push($Country_Total, $value);								// save $value as the last value in the $Country_Total array
								if ($country === '') {
									$country = $value;											// name of the country in the language version
								}
								else {
									$country .= ', ' . $value;									// name of the country in the language version
								}
								$stmt_c->bind_param("s", $value);								// bind parameters for markers								// 
								$stmt_c->execute();												// execute query
								$result_c=$stmt_c->get_result() or die (translate('Query failed:', $st, 'sys') . ' ' . $db->error . '</body></html>');
								if ($result_c->num_rows <= 0) {
									//die (translate('The ISO_Country language code is not found.', $st, 'sys') . '</body></html>');
								}
								$row_c = $result_c->fetch_array();
								$country .= ':' . $row_c['ISO_Country'];						// add the ZZ abbreviation to $country
							}
							$temp_c = FALSE;
						}
					}
					else {
						if ($country === '') {
							$country = $temp_Country . ':' . $row_con['ISO_Country'];			// full name of the country and the ZZ abbreviation of the country in the language version
						}
						else {
							$country .= ', ' . $temp_Country . ':' . $row_con['ISO_Country'];	// full name of the country and the ZZ abbreviation of the country in the language version
						}
					}
				}

				if (is_null($Variant_Code) || $Variant_Code == '') {
					$VD = '';
				}
				else {
					$stmt_Var->bind_param('s', $Variant_Code);									// bind parameters for markers								// 
					$stmt_Var->execute();														// execute query
					$result_Var = $stmt_Var->get_result();
					$row_Var = $result_Var->fetch_assoc();
					$VD = $row_Var["$Variant_major"];
				}
				
				/******************************************************************************
						alternate language names
				*******************************************************************************/
				$alt = '';
				$stmt_alt->bind_param('i', $ISO_ROD_index);										// bind parameters for markers								// 
				$stmt_alt->execute();															// execute query
				if ($result_alt = $stmt_alt->get_result()) {
					$bool = 0;
					while ($row_alt = $result_alt->fetch_assoc()) {
						$alt_temp = $row_alt['alt_lang_name'];
						if (preg_match_all("/(\s|-|^)".$TryLanguage."/ui", mb_strtolower($alt_temp))) {
							if ($bool == 0) {
								$alt = $alt_temp;
								$bool = 1;
								continue;
							}
							$alt .= ', '.$alt_temp;
						}
					}
				}
				
				if ($hint == 0) {
					$response = $LN.'|'.$alt.'|'.$ISO.'|'.$country.'|'.$ROD_Code.'|'.$VD.'|'.$ISO_ROD_index;
					$hint = 1;
				}
				else {
					$response .= '<br />'.$LN.'|'.$alt.'|'.$ISO.'|'.$country.'|'.$ROD_Code.'|'.$VD.'|'.$ISO_ROD_index;
				}
				$langISOrod[] = $ISO_ROD_index;
			}
		}
	}
	// Try alt_lang_names:
	// REGEXP '[[:<:]]... = in PHP '\b... (word boundries)
	if (empty($langISOrod)) {
		$query="SELECT DISTINCT ISO_ROD_index FROM alt_lang_names WHERE alt_lang_name REGEXP '[[:<:]]$TryLanguage'";
	}
	else {
		//$query="SELECT DISTINCT ISO_ROD_index FROM alt_lang_names WHERE alt_lang_name REGEXP '[[:<:]]$TryLanguage' AND ISO_ROD_index NOT IN (".implode(',', $langISOrod).")";		// won't quick work under MariaDB 10.1.44
		$query="SELECT DISTINCT ISO_ROD_index FROM alt_lang_names WHERE alt_lang_name REGEXP '(^| )$TryLanguage' AND ISO_ROD_index NOT IN (".implode(',', $langISOrod).")";
	}

//echo '4th<br />';
//exit;
	if ($result = $db->query($query)) {
		while ($r = $result->fetch_assoc()) {
			$ISO_ROD_index = $r['ISO_ROD_index'];
			$stmt_nav_ln_idx->bind_param('i', $ISO_ROD_index);									// bind parameters for markers								// 
			$stmt_nav_ln_idx->execute();														// execute query
			$result_SM = $stmt_nav_ln_idx->get_result();
			if ($row = $result_SM->fetch_assoc()) {
				$ISO = $row['ISO'];
				$ROD_Code = $row['ROD_Code'];
				$Variant_Code = $row['Variant_Code'];
				$VD = '';
				include './include/00-DBLanguageCountryName.inc.php';							// returns LN
				$stmt_SC->bind_param("i", $ISO_ROD_index);										// bind parameters for markers
				$stmt_SC->execute();															// execute query
				$result_con=$stmt_SC->get_result() or die (translate('Query failed:', $st, 'sys') . ' ' . $db->error . '</body></html>');
				if ($result_con->num_rows <= 0) {
					die (translate('The ISO language code is not found.', $st, 'sys') . '</body></html>');
				}
				$country = '';
				$temp_Country = '';
				while ($row_con = $result_con->fetch_array()) {
					$temp_Country = trim($row_con["$SpecificCountry"]);							// name of the country in the language version
					if (strpos($temp_Country, ',')) {											// if $temp_Country contains a ','
						$temp_c = FALSE;
						$country_array = preg_split('/, ?/', $temp_Country);					// split the word(s) (i.e. countries)
						foreach($country_array as $key => $value) {
							$temp_c = in_array($value, $Country_Total);							// is the string $value is within $Country_Total array
							if ($temp_c == FALSE) {
								array_push($Country_Total, $value);								// save $value as the last value in the $Country_Total array
								if ($country === '') {
									$country = $value;											// name of the country in the language version
								}
								else {
									$country .= ', ' . $value;									// name of the country in the language version
								}
								$stmt_c->bind_param('s', $value);								// bind parameters for markers
								$stmt_c->execute();												// execute query
								$result_c=$stmt_c->get_result() or die (translate('Query failed:', $st, 'sys') . ' ' . $db->error . '</body></html>');
								if ($result_c->num_rows <= 0) {
									//die (translate('The ISO_Country language code is not found.', $st, 'sys') . '</body></html>');
								}
								$row_c = $result_c->fetch_array();
								$country .= ':' . $row_c['ISO_Country'];						// add the ZZ abbreviation to $country
							}
							$temp_c = FALSE;
						}
					}
					else {
						if ($country === '') {
							$country = $temp_Country . ':' . $row_con['ISO_Country'];			// full name of the country and the ZZ abbreviation of the country in the language version
						}
						else {
							$country .= ', ' . $temp_Country . ':' . $row_con['ISO_Country'];	// full name of the country and the ZZ abbreviation of the country in the language version
						}
					}
				}

				if (is_null($Variant_Code) || $Variant_Code == '') {
					$VD = '';
				}
				else {
					//$resultVar = $db->query("SELECT $Variant_major FROM Variants WHERE Variant_Code = '$Variant_Code'");
					$stmt_Var->bind_param('s', $Variant_Code);									// bind parameters for markers
					$stmt_Var->execute();														// execute query
					$result_Var = $stmt_Var->get_result();
					$row_Var = $result_Var->fetch_assoc();
					$VD = $row_Var["$Variant_major"];
				}
				
				/******************************************************************************
						alternate language names
				*******************************************************************************/
				$alt = '';
				$stmt_alt->bind_param('i', $ISO_ROD_index);										// bind parameters for markers
				$stmt_alt->execute();															// execute query
				if ($result_alt = $stmt_alt->get_result()) {
					$bool = 0;
					while ($row_alt = $result_alt->fetch_assoc()) {
						$alt_temp = $row_alt['alt_lang_name'];
						$temp_TL = str_replace('(', '\(', $TryLanguage);
						$temp_TL = str_replace(')', '\)', $temp_TL);
						$temp_TL = str_replace('.', '\.', $temp_TL);
						if (preg_match_all("/(\s|-|^)".$temp_TL."/ui", mb_strtolower($alt_temp))) {
							if ($bool == 0) {
								$alt = $alt_temp;
								$bool = 1;
								continue;
							}
							$alt .= ', '.$alt_temp;
						}
					}
				}
				
				if ($hint == 0) {
					$response = $LN.'|'.$alt.'|'.$ISO.'|'.$country.'|'.$ROD_Code.'|'.$VD.'|'.$ISO_ROD_index;
					$hint = 1;
				}
				else {
					$response .= '<br />'.$LN.'|'.$alt.'|'.$ISO.'|'.$country.'|'.$ROD_Code.'|'.$VD.'|'.$ISO_ROD_index;
				}
			}
		}
	}
	
	if ($hint == 0) {
		$response = translate("This language is not found.", $st, "sys");
		echo $response;
	}
	else {
		$temp = explode('<br />', $response);
		sort($temp);
		$response = implode('<br />', $temp);
		$response .= '<br />'.translate("Language Name", $st, "sys");
		$response .= '<br />'.translate("Alternate Language Names", $st, "sys");
		$response .= '<br />'.translate("Code", $st, "sys");
		$response .= '<br />'.translate("Country", $st, "sys");
		echo $response;
	}
}


function removeDiacritics($txt) {
    $transliterationTable = ['?' => 'a', '?' => 'A', '?' => 'a', '?' => 'A', '?' => 'a', '?' => 'A', '?' => 'a', '?' => 'A', '?' => 'a', '?' => 'A', '?' => 'ae', '?' => 'AE', '?' => 'ae', '?' => 'AE', '?' => 'c', '?' => 'C', '?' => 'D', '?' => 'dh', '?' => 'Dh', '?' => 'e', '?' => 'E', '?' => 'e', '?' => 'E', '?' => 'e', '?' => 'E', '?' => 'e', '?' => 'E', '?' => 'i', '?' => 'I', '?' => 'i', '?' => 'I', '?' => 'i', '?' => 'I', '?' => 'i', '?' => 'I', '?' => 'n', '?' => 'N', '?' => 'o', '?' => 'O', '?' => 'o', '?' => 'O', '?' => 'o', '?' => 'O', '?' => 'o', '?' => 'O', '?' => 'oe', '?' => 'OE', '?' => 'oe', '?' => 'OE', '?' => 's', '?' => 'S', '?' => 'SS', '?' => 'u', '?' => 'U', '?' => 'u', '?' => 'U', '?' => 'u', '?' => 'U', '?' => 'ue', '?' => 'UE', '?' => 'y', '?' => 'Y', '?' => 'y', '?' => 'Y', '?' => 'z', '?' => 'Z'];
	return strtr($txt, $transliterationTable);
}    // or, return str_replace(array_keys($transliterationTable), array_values($transliterationTable), $txt);

// Author: 'ChickenFeet'
// https://stackoverflow.com/questions/3371697/replacing-accented-characters-php
function CheckLetters($field){
	//echo $field . ' # ';
	$field = htmlentities($field, ENT_COMPAT, "UTF-8");
	$field = preg_replace('/&([a-zA-Z])(acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml|caron);/','$1',$field);
	//echo $field . '<br />';
	return html_entity_decode($field);

	// global $letters;										// won't work
    /*$letters = [
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
    return $field;*/
}
?>
