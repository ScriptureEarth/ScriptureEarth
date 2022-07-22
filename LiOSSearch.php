<?php
/*
Created by Scottt Starker
AJAX

Problems: TryLanguage ' should be \' 

MySQL: utf8_general_ci flattens accents as well as lower-case:
You must ensure that all parties (your app, mysql connection, your table or column) have set utf8 as charset.
- header('Content-Type: text/html; charset=utf-8'); (or <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />)
- ensure your mysqli connection use utf8 before any operation:
	- $mysqli->set_charset('utf8')
- create your table or column using utf8_general_ci
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
if (preg_match("/^[-. ,'ꞌ()A-Za-záéíóúÑñçãõâêîôûäëöüï&]+/", $TryLanguage)) {
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

$response = '';
$MajorLanguage = '';
$Variant_major = '';

switch ($st) {
	case 'eng':
		$MajorLanguage = 'LN_English';
		$Variant_major = 'Variant_Eng';
		$SpecificCountry = 'English';
		break;
	case 'spa':
		$MajorLanguage = 'LN_Spanish';
		$Variant_major = 'Variant_Spa';
		$SpecificCountry = 'Spanish';
		break;
	case 'por':
		$MajorLanguage = 'LN_Portuguese';
		$Variant_major = 'Variant_Por';
		$SpecificCountry = 'Portuguese';
		break;
	case 'dut':
		$MajorLanguage = 'LN_Dutch';
		$Variant_major = 'Variant_Dut';
		$SpecificCountry = 'Dutch';
		break;
	case 'fre':
		$MajorLanguage = 'LN_French';
		$Variant_major = 'Variant_Fre';
		$SpecificCountry = 'French';
		break;
	case 'deu':
		$MajorLanguage = 'LN_German';
		$Variant_major = 'Variant_Deu';
		$SpecificCountry = 'German';
		break;
	default:
		$response = '"st" never found.';
		exit();
}

if (strlen($TryLanguage) > 2) {
	$hint = 0;
	include './include/conn.inc.php';
	$db = get_my_db();
	include './translate/functions.php';							// translation function
	
	$langISOrod = [];
	$ISO_only = '';
	$Country_Total = [];

	$stmt_SC = $db->prepare("SELECT DISTINCT $SpecificCountry, ISO_Country FROM scripture_main, countries, ISO_countries WHERE countries.ISO_Country = ISO_countries.ISO_countries AND ISO_countries.ISO = scripture_main.ISO AND scripture_main.ISO_ROD_index = ?");														// create a prepared statement
	$stmt_c = $db->prepare("SELECT ISO_Country FROM countries WHERE $SpecificCountry = ?");
	$stmt_Var = $db->prepare("SELECT $Variant_major FROM Variants WHERE Variant_Code = ?");
	$stmt_alt = $db->prepare("SELECT alt_lang_name FROM alt_lang_names WHERE ISO_ROD_index = ?");

	// ISO
	if (strlen($TryLanguage) == 3) {
// here 1/2 lines - check
		$query="SELECT DISTINCT `scripture_main`.`ISO_ROD_index`, `scripture_main`.`ISO`, `scripture_main`.`ROD_Code`, `scripture_main`.`Variant_Code`, `LN_Dutch`, `LN_Spanish`, `LN_French`, `LN_English`, `LN_Portuguese`, `LN_German`, `Def_LN`, `Cell_Phone_File`, `optional` FROM `scripture_main`, `CellPhone` WHERE `scripture_main`.`ISO` = '$TryLanguage' AND `scripture_main`.`ISO` = `CellPhone`.`ISO` AND `scripture_main`.`ROD_Code` = `CellPhone`.`ROD_Code` AND `scripture_main`.`Variant_Code` = `CellPhone`.`Variant_Code` AND `CellPhone`.`Cell_Phone_Title` = 'iOS Asset Package' ORDER BY `scripture_main`.`ISO`";
		if ($result = $db->query($query)) {
			$LN = '';
			while ($row = $result->fetch_assoc()) {
				$ISO_ROD_index = $row['ISO_ROD_index'];
				$ISO = $row['ISO'];
				$ROD_Code = $row['ROD_Code'];
				$Variant_Code = $row['Variant_Code'];
				$VD = '';
				$URL = $row['Cell_Phone_File'];
				$optional = $row['optional'];
				include './include/00-DBLanguageCountryName.inc.php';							// returns LN
				//$LN = htmlspecialchars($LN, ENT_QUOTES, 'UTF-8');								// The results are wrong because it changes ' to &#039;
				
				//$query = "SELECT DISTINCT $SpecificCountry, ISO_countries FROM scripture_main, countries, ISO_countries WHERE countries.ISO_Country = ISO_countries.ISO_countries AND ISO_countries.ISO = scripture_main.ISO AND scripture_main.ISO_ROD_index = $ISO_ROD_index";
				$stmt_SC->bind_param('i', $ISO_ROD_index);										// bind parameters for markers
				$stmt_SC->execute();															// execute query
				$result_con=$stmt_SC->get_result() or die (translate('Query failed:', $st, 'sys') . ' ' . $db->error . '</body></html>');
				if ($result_con->num_rows <= 0) {
					die (translate('The ISO language code is not found.', $st, 'sys') . '</body></html>');
				}
				$country = '';
				$temp_Country = '';
				while ($row_con = $result_con->fetch_array()) {
					//$countryTemp = $SpecificCountry;
					//if (strpos("$SpecificCountry", '.')) $countryTemp = substr("$SpecificCountry", strpos("$SpecificCountry", '.')+1);		// In case there's a "." in the "country"
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
								//$GetName=trim($row_c["ISO_Country"]);
								// SELECT ISO_Country [2 uppercase letters] FROM $SpecificCountry:
								//$query="SELECT ISO_Country FROM countries WHERE $SpecificCountry = '$value'";
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
					//$resultVar = $db->query("SELECT $Variant_major FROM Variants WHERE Variant_Code = '$Variant_Code'");
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
				//$query="SELECT alt_lang_name FROM alt_lang_names WHERE ISO_ROD_index = $ISO_ROD_index";
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
				
				//$query="SELECT DISTINCT $SpecificCountry FROM countries WHERE ISO_Country = '$GetName'";
				//$result=$db->query($query);
				//$num=mysql_num_rows($result);
				//if ($result->num_rows > 0) {
					//$r = $result->fetch_array();
					//$countryTemp = $SpecificCountry;
					//if (strpos("$SpecificCountry", '.')) $countryTemp = substr("$SpecificCountry", strpos("$SpecificCountry", '.')+1);					// In case there's a "." in the "country"
					//$country = trim($r["countryTemp"]);											// name of the country if there is one
				//}
				
				if ($hint == 0) {
					$response = $LN.'|'.$alt.'|'.$ISO.'|'.$country.'|'.$ROD_Code.'|'.$VD.'|'.$ISO_ROD_index.'|'.$URL;
					$hint = 1;
				}
				else {
					$response .= '<br />'.$LN.'|'.$alt.'|'.$ISO.'|'.$country.'|'.$ROD_Code.'|'.$VD.'|'.$ISO_ROD_index.'|'.$URL;
				}
				$langISOrod[] = $ISO_ROD_index;
				$ISO_only = $ISO;
			}
		}
	}
	
	$RD = ['�' => 'a', '�' => 'A', '�' => 'a', '�' => 'A', '�' => 'a', '�' => 'A', '�' => 'a', '�' => 'A', '�' => 'a', '�' => 'A', '�' => 'ae', '�' => 'AE', '�' => 'ae', '�' => 'AE', '�' => 'c', '�' => 'C', '�' => 'D', '�' => 'dh', '�' => 'Dh', '�' => 'e', '�' => 'E', '�' => 'e', '�' => 'E', '�' => 'e', '�' => 'E', '�' => 'e', '�' => 'E', '�' => 'i', '�' => 'I', '�' => 'i', '�' => 'I', '�' => 'i', '�' => 'I', '�' => 'i', '�' => 'I', '�' => 'n', '�' => 'N', '�' => 'o', '�' => 'O', '�' => 'o', '�' => 'O', '�' => 'o', '�' => 'O', '�' => 'o', '�' => 'O', '�' => 'oe', '�' => 'OE', '�' => 'oe', '�' => 'OE', '�' => 's', '�' => 'S', '�' => 'SS', '�' => 'u', '�' => 'U', '�' => 'u', '�' => 'U', '�' => 'u', '�' => 'U', '�' => 'ue', '�' => 'UE', '�' => 'y', '�' => 'Y', '�' => 'y', '�' => 'Y', '�' => 'z', '�' => 'Z'];
	if (preg_match('/[��������������������������]/', $TryLanguage)) {							// diacritic removal
		$TryLanguage = strtr($TryLanguage, $RD);												// PHP: strtr - Translate characters ($addr = strtr($addr, "���", "aao");)
	}
	
	$TryLanguage = str_replace("'", "\'", $TryLanguage);

	// Try languages names:
	//$query="SELECT DISTINCT $MajorLanguage, ISO, ROD_Code, Variant_Code, ISO_ROD_index FROM LN_English WHERE ISO_ROD_index IS NOT NULL ORDER BY $MajorLanguage";
// here 1/2 line - check
	$query="SELECT DISTINCT `scripture_main`.`ISO_ROD_index`, `scripture_main`.`ISO`, `scripture_main`.`ROD_Code`, `scripture_main`.`Variant_Code`, `LN_Dutch`, `LN_Spanish`, `LN_French`, `LN_English`, `LN_Portuguese`, `LN_German`, `Def_LN`, `Cell_Phone_File`, `optional` FROM `scripture_main`, `CellPhone` WHERE `scripture_main`.`ISO` = `CellPhone`.`ISO` AND `scripture_main`.`ROD_Code` = `CellPhone`.`ROD_Code` AND `scripture_main`.`Variant_Code` = `CellPhone`.`Variant_Code` AND `CellPhone`.`Cell_Phone_Title` = 'iOS Asset Package' ORDER BY `scripture_main`.`ISO`";
	if ($result = $db->query($query)) {
		$LN = '';
		while ($row = $result->fetch_assoc()) {													// All ISOs + ROD codes + variants + (`Cell_Phone_Title` = 'iOS Asset Package')
			$ISO_ROD_index = $row['ISO_ROD_index'];
			include './include/00-DBLanguageCountryName.inc.php';								// returns LN
			//$LN = htmlspecialchars($LN, ENT_QUOTES, 'UTF-8');									// language name. The results are wrong because it changes ' to &#039;
			//setlocale(LC_CTYPE, 'en_US');
			//$temp_LN = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $LN);							// iconv - Convert string to requested character encoding [WON'T WORK!]
			//if (preg_match("/[��������������������������]/", $TryLanguage)) {						// WON'T WORK! Above will work but here it won't! I don't know why. E.g. locslhost will give '"e" and the server will give '?' for 'ë'.
			//	$TryLanguage = strtr($TryLanguage, $RD);											// PHP: strtr - Translate characters ($addr = strtr($addr, "���", "aao");)
			//}

			// Author: 'ChickenFeet'
			$temp_LN = CheckLetters($LN);														// diacritic removal
			
			$temp_LN = mb_strtolower($temp_LN);													// lower case language name without the diacritics
			
			$temp_TL = str_replace('(', '\(', $TryLanguage);
			$temp_TL = str_replace(')', '\)', $temp_TL);
			$temp_TL = str_replace('.', '\.', $temp_TL);
			$test = preg_match("/\b".$temp_TL.'/ui', $temp_LN, $match);							// match the beginning of the word(s) with TryLanguage from the user

			if ($test === 1) {
				$ISO = $row['ISO'];
				if (strlen($TryLanguage) == 3 && $ISO == $ISO_only) {							// if the length of $TryLanguage is 3 and the top section is there
					continue;
				}
				$ROD_Code = $row['ROD_Code'];
				$Variant_Code = $row['Variant_Code'];
				$VD = '';
				
				//$query = "SELECT DISTINCT $SpecificCountry FROM scripture_main, countries, ISO_countries WHERE countries.ISO_Country = ISO_countries.ISO_countries AND ISO_countries.ISO = scripture_main.ISO AND scripture_main.ISO_ROD_index = $ISO_ROD_index";
				$stmt_SC->bind_param('i', $ISO_ROD_index);										// bind parameters for markers
				$stmt_SC->execute();															// execute query
				$result_con=$stmt_SC->get_result() or die (translate('Query failed:', $st, 'sys') . ' ' . $db->error . '</body></html>');
				if ($result_con->num_rows <= 0) {
					die (translate('The ISO language code is not found.', $st, 'sys') . '</body></html>');
				}
				$country = '';
				$temp_Country = '';
				while ($row_con = $result_con->fetch_array()) {
					//$countryTemp = $SpecificCountry;
					//if (strpos("$SpecificCountry", '.')) $countryTemp = substr("$SpecificCountry", strpos("$SpecificCountry", '.')+1);					// In case there's a "." in the "country"
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
								//$GetName=trim($row_c["ISO_Country"]);
								// SELECT ISO_Country [2 uppercase letters] FROM $SpecificCountry:
								//$query="SELECT ISO_Country FROM countries WHERE $SpecificCountry = '$value'";
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
					//$resultVar = $db->query("SELECT $Variant_major FROM Variants WHERE Variant_Code = '$Variant_Code'");
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
				//$query="SELECT alt_lang_name FROM alt_lang_names WHERE ISO_ROD_index = $ISO_ROD_index";
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
					$response = $LN.'|'.$alt.'|'.$ISO.'|'.$country.'|'.$ROD_Code.'|'.$VD.'|'.$ISO_ROD_index.'|'.$URL;
					$hint = 1;
				}
				else {
					$response .= '<br />'.$LN.'|'.$alt.'|'.$ISO.'|'.$country.'|'.$ROD_Code.'|'.$VD.'|'.$ISO_ROD_index.'|'.$URL;
				}
				$langISOrod[] = $ISO_ROD_index;
			}
		}
	}

	// Try alt_lang_names:
	// REGEXP '[[:<:]]... = in PHP '\b... (word boundries)
	if (empty($langISOrod)) {
// here - check
		$query="SELECT DISTINCT alt_lang_names.ISO_ROD_index FROM alt_lang_names, CellPhone WHERE CellPhone.Cell_Phone_Title = 'iOS Asset Package' AND `alt_lang_names`.`ISO` = `CellPhone`.`ISO` AND `alt_lang_names`.`ROD_Code` = `CellPhone`.`ROD_Code` AND `alt_lang_names`.`Variant_Code` = `CellPhone`.`Variant_Code` AND alt_lang_names.alt_lang_name REGEXP '[[:<:]]$TryLanguage' AND alt_lang_names.ISO_ROD_index IS NOT NULL";
	}
	else {
		//$query="SELECT DISTINCT ISO_ROD_index FROM alt_lang_names WHERE alt_lang_name REGEXP '[[:<:]]$TryLanguage' AND ISO_ROD_index NOT IN (".implode(',', $langISOrod).")";		// won't quick work under MariaDB 10.1.44
// here - check
		$query="SELECT DISTINCT alt_lang_names.ISO_ROD_index FROM alt_lang_names, CellPhone WHERE CellPhone.Cell_Phone_Title = 'iOS Asset Package' AND `alt_lang_names`.`ISO` = `CellPhone`.`ISO` AND `alt_lang_names`.`ROD_Code` = `CellPhone`.`ROD_Code` AND `alt_lang_names`.`Variant_Code` = `CellPhone`.`Variant_Code` AND alt_lang_names.ISO_ROD_index IS NOT NULL AND alt_lang_names.alt_lang_name REGEXP '(^| )$TryLanguage' AND alt_lang_names.ISO_ROD_index NOT IN (".implode(',', $langISOrod).")";
	}
	if ($result = $db->query($query)) {
		while ($r = $result->fetch_assoc()) {
			$ISO_ROD_index = $r['ISO_ROD_index'];
			$query="SELECT scripture_main.ISO, scripture_main.ROD_Code, scripture_main.Variant_Code, LN_Dutch, LN_Spanish, LN_French, LN_English, LN_Portuguese, LN_German, Def_LN, Cell_Phone_File, optional FROM scripture_main, CellPhone WHERE scripture_main.ISO_ROD_index = $ISO_ROD_index AND scripture_main.ISO_ROD_index = CellPhone.ISO_ROD_index AND CellPhone.Cell_Phone_Title = 'iOS Asset Package'";
			if ($result_SM = $db->query($query)) {
				if ($row = $result_SM->fetch_assoc()) {
					$ISO = $row['ISO'];
					$ROD_Code = $row['ROD_Code'];
					$Variant_Code = $row['Variant_Code'];
					$VD = '';
					$URL = $row['Cell_Phone_File'];
					$optional = $row['optional'];
					include './include/00-DBLanguageCountryName.inc.php';							// returns LN
					//$LN = htmlspecialchars($LN, ENT_QUOTES, 'UTF-8');
					//$query = "SELECT DISTINCT $SpecificCountry, ISO_countries FROM scripture_main, countries, ISO_countries WHERE countries.ISO_Country = ISO_countries.ISO_countries AND ISO_countries.ISO = scripture_main.ISO AND scripture_main.ISO_ROD_index = $ISO_ROD_index";
					$stmt_SC->bind_param("i", $ISO_ROD_index);										// bind parameters for markers
					$stmt_SC->execute();															// execute query
					$result_con=$stmt_SC->get_result() or die (translate('Query failed:', $st, 'sys') . ' ' . $db->error . '</body></html>');
					if ($result_con->num_rows <= 0) {
						die (translate('The ISO language code is not found.', $st, 'sys') . '</body></html>');
					}
					$country = '';
					$temp_Country = '';
					while ($row_con = $result_con->fetch_array()) {
						//$countryTemp = $SpecificCountry;
						//if (strpos("$SpecificCountry", '.')) $countryTemp = substr("$SpecificCountry", strpos("$SpecificCountry", '.')+1);					// In case there's a "." in the "country"
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
									//$GetName=trim($row_c["ISO_Country"]);
									// SELECT ISO_Country [2 uppercase letters] FROM $SpecificCountry:
									//$query="SELECT ISO_Country FROM countries WHERE $SpecificCountry = '$value'";
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
					//$query="SELECT alt_lang_name FROM alt_lang_names WHERE ISO_ROD_index = $ISO_ROD_index";
					$stmt_alt->bind_param('i', $ISO_ROD_index);										// bind parameters for markers
					$stmt_alt->execute();															// execute query
					if ($result_alt = $stmt_alt->get_result()) {
						$bool = 0;
						while ($row_alt = $result_alt->fetch_assoc()) {
							$alt_temp = $row_alt['alt_lang_name'];
//echo 'alt_temp: ' . $alt_temp . '<br />';
//echo 'TryLanguage: ' . $TryLanguage . '<br />';
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
						$response = $LN.'|'.$alt.'|'.$ISO.'|'.$country.'|'.$ROD_Code.'|'.$VD.'|'.$ISO_ROD_index.'|'.$URL;
						$hint = 1;
					}
					else {
						$response .= '<br />'.$LN.'|'.$alt.'|'.$ISO.'|'.$country.'|'.$ROD_Code.'|'.$VD.'|'.$ISO_ROD_index.'|'.$URL;
					}
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
    $transliterationTable = ['�' => 'a', '�' => 'A', '�' => 'a', '�' => 'A', '�' => 'a', '�' => 'A', '�' => 'a', '�' => 'A', '�' => 'a', '�' => 'A', '�' => 'ae', '�' => 'AE', '�' => 'ae', '�' => 'AE', '�' => 'c', '�' => 'C', '�' => 'D', '�' => 'dh', '�' => 'Dh', '�' => 'e', '�' => 'E', '�' => 'e', '�' => 'E', '�' => 'e', '�' => 'E', '�' => 'e', '�' => 'E', '�' => 'i', '�' => 'I', '�' => 'i', '�' => 'I', '�' => 'i', '�' => 'I', '�' => 'i', '�' => 'I', '�' => 'n', '�' => 'N', '�' => 'o', '�' => 'O', '�' => 'o', '�' => 'O', '�' => 'o', '�' => 'O', '�' => 'o', '�' => 'O', '�' => 'oe', '�' => 'OE', '�' => 'oe', '�' => 'OE', '�' => 's', '�' => 'S', '�' => 'SS', '�' => 'u', '�' => 'U', '�' => 'u', '�' => 'U', '�' => 'u', '�' => 'U', '�' => 'ue', '�' => 'UE', '�' => 'y', '�' => 'Y', '�' => 'y', '�' => 'Y', '�' => 'z', '�' => 'Z'];
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