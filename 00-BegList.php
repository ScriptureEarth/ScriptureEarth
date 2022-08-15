<?php
// called by 00-CountryTableSwitchAJAX,inc.php in AJAX

function check_input($value) {							// used for ' and " that find it in the input to \' and \"
	$value = trim($value);
    /* Automatic escaping is deprecated, but many sites do it anyway. */
	// Stripslashes
	//if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
		$value = stripslashes($value);
	//}
	// Quote if not a number
	if (!is_numeric($value)) {
		$db = get_my_db();
		$value = $db->real_escape_string($value);
	}
	return $value;
}

	if (!isset($_GET['st']) || !isset($_GET['MajorLanguage']) || !isset($_GET['SpecificCountry']) || !isset($_GET['Scriptname']) || !isset($_GET['b']) || !isset($_GET['gn']) || !isset($_GET['n']))
		die('One or more GET wasn\'t on the URL line!</body></html>');
	$st = $_GET['st'];
	$st = preg_replace('/^([a-z]{3})/', "$1", $st);
	$MajorLanguage = $_GET['MajorLanguage'];
	$MajorLanguage = preg_replace('/^(LN_\w)/', "$1", $MajorLanguage);
	$SpecificCountry = $_GET['SpecificCountry'];
	$SpecificCountry = preg_replace('/^(countries\.\w)/', "$1", $SpecificCountry);
	$Scriptname = $_GET['Scriptname'];
	$Beg = $_GET['b'];								// first letter of the language names or ISO code and the 'Get Name of country' != "ALL"
	$Beg = preg_replace('/^([a-zA-Z]{1,3})/', "$1", $Beg);
	$GN = $_GET['gn'];								// Get Name of country or 'ALL'
	$GN = preg_replace('/^([a-zA-Z]{1,3})/', "$1", $GN);
	$number = $_GET['n'];							// either number = 2 (LanguageName) or 1 (LanguageCode)
	$number = preg_replace('/^(1-2)/', "$1", $number);
	if (empty($st) || empty($MajorLanguage) || empty($SpecificCountry) || empty($Beg) || empty($GN) || empty($number))
		die('HACK! One or more variables wasn\'t on the URL line!</body></html>');

	require_once './include/conn.inc.php';
	$db = get_my_db();
	include './translate/functions.php';
	
	if ($GN == 'all') {
		$query = 'SELECT DISTINCT * FROM scripture_main';
	}
	else {
		$query="SELECT DISTINCT $SpecificCountry, scripture_main.* FROM scripture_main, countries, ISO_countries WHERE ISO_countries.ISO_countries = '$GN' AND scripture_main.ISO_ROD_index = ISO_countries.ISO_ROD_index AND ISO_countries.ISO_countries = countries.ISO_Country ORDER BY scripture_main.ISO";
	}
	$result=$db->query($query);

	/*
		*************************************************************************************************************
			select the default primary language name to be used by displaying the Countries and indigenous langauge names
		*************************************************************************************************************
	*/
	$db->query('DROP TABLE IF EXISTS LN_Temp');			// Get the names of all of the Spanish languages or else get the default names
	$db->query('CREATE TEMPORARY TABLE LN_Temp (ISO VARCHAR(3) NOT NULL, ROD_Code VARCHAR(5) NOT NULL, ISO_ROD_index INT NULL, LN VARCHAR(50) NOT NULL) ENGINE = MEMORY CHARSET = utf8') or die (translate('Query failed:', $st, 'sys') . ' ' . $db->error . '</body></html>');
	$stmt = $db->prepare('INSERT INTO LN_Temp (ISO, ROD_Code, ISO_ROD_index, LN) VALUES (?, ?, ?, ?)');			// create a prepared statement
	while ($r = $result->fetch_array()) {
		$ISO=$r['ISO'];									// ISO
		$ROD_Code=$r['ROD_Code'];						// ROD_Code
		$Variant_Code=$r['Variant_Code'];				// Variant_Code
		$ISO_ROD_index=$r['ISO_ROD_index'];				// ISO_ROD_index
		$ML=$r["$MajorLanguage"];						// the major language
		$Def_LN=$r['Def_LN'];							// default langauge (a 2 digit number for the national langauge)
		if (!$ML) {										// if the English then the default langauge
			switch ($Def_LN){
				case 1:
					$query="SELECT LN_English FROM LN_English WHERE ISO_ROD_index = '$ISO_ROD_index'";
					$result_LN=$db->query($query);
					$row_temp=$result_LN->fetch_assoc();
					$LN=trim($row_temp['LN_English']);
					break;
				case 2:
					$query="SELECT LN_Spanish FROM LN_Spanish WHERE ISO_ROD_index = '$ISO_ROD_index'";
					$result_LN=$db->query($query);
					$row_temp=$result_LN->fetch_assoc();
					$LN=trim($row_temp['LN_Spanish']);
					break;
				case 3:
					$query="SELECT LN_Portuguese FROM LN_Portuguese WHERE ISO_ROD_index = '$ISO_ROD_index'";
					$result_LN=$db->query($query);
					$row_temp=$result_LN->fetch_assoc();
					$LN=trim($row_temp['LN_Portuguese']);
					break;	
				case 4:
					$query="SELECT LN_French FROM LN_French WHERE ISO_ROD_index = '$ISO_ROD_index'";
					$result_LN=$db->query($query);
					$row_temp=$result_LN->fetch_assoc();
					$LN=trim($row_temp['LN_French']);
					break;	
				case 5:
					$query="SELECT LN_Dutch FROM LN_Dutch WHERE ISO_ROD_index = '$ISO_ROD_index'";
					$result_LN=$db->query($query);
					$row_temp=$result_LN->fetch_assoc();
					$LN=trim($row_temp['LN_Dutch']);
					break;
				case 6:
					$query="SELECT LN_German FROM LN_German WHERE ISO_ROD_index = '$ISO_ROD_index'";
					$result_LN=$db->query($query);
					$row_temp=$result_LN->fetch_assoc();
					$LN=trim($row_temp['LN_German']);
					break;
				case 6:
					$query="SELECT LN_Chinese FROM LN_Chinese WHERE ISO_ROD_index = '$ISO_ROD_index'";
					$result_LN=$db->query($query);
					$row_temp=$result_LN->fetch_assoc();
					$LN=trim($row_temp['LN_Chinese']);
					break;
				default:
					echo 'This isn’t supposed to happen! The default language isn�t found.';
					break;
			}
		}
		else {
			$query="SELECT $MajorLanguage FROM $MajorLanguage WHERE ISO_ROD_index = '$ISO_ROD_index'";
			$result_LN=$db->query($query);
			$row_temp=$result_LN->fetch_assoc();
			$LN=trim($row_temp["$MajorLanguage"]);
		}
		$stmt->bind_param('ssis', $ISO, $ROD_Code, $ISO_ROD_index, $LN);			// bind parameters for markers
		$stmt->execute();															// execute query
	}
	$stmt->close();																	// close statement

	if ($number == 1) {		// $which == 'Name'
		if ($Beg == 'all')
			if ($GN == 'all')
				$query='SELECT DISTINCT LN_Temp.LN, scripture_main.* FROM LN_Temp, scripture_main WHERE scripture_main.ISO_ROD_index = LN_Temp.ISO_ROD_index ORDER BY LN_Temp.ISO, LN_Temp.ROD_Code';
			else
				$query="SELECT DISTINCT LN_Temp.LN, $SpecificCountry, scripture_main.* FROM LN_Temp, scripture_main, countries, ISO_countries WHERE ISO_countries.ISO_countries = '$GN' AND scripture_main.ISO_ROD_index = LN_Temp.ISO_ROD_index AND scripture_main.ISO_ROD_index = ISO_countries.ISO_ROD_index AND ISO_countries.ISO_countries = countries.ISO_Country ORDER BY LN_Temp.ISO, LN_Temp.ROD_Code";
		else
			$query="SELECT DISTINCT LN_Temp.LN, scripture_main.* FROM LN_Temp, scripture_main WHERE scripture_main.ISO_ROD_index = LN_Temp.ISO_ROD_index AND LN_Temp.ISO LIKE '$Beg%' ORDER BY LN_Temp.ISO, LN_Temp.ROD_Code";
	}
	else {	// $which == 'Code'
		if ($Beg == 'all')
			if ($GN == 'all')
				$query='SELECT DISTINCT LN_Temp.LN, scripture_main.* FROM LN_Temp, scripture_main WHERE scripture_main.ISO_ROD_index = LN_Temp.ISO_ROD_index ORDER BY LN_Temp.LN';
			else
				$query="SELECT DISTINCT LN_Temp.LN, $SpecificCountry, scripture_main.* FROM LN_Temp, scripture_main, countries, ISO_countries WHERE ISO_countries.ISO_countries = '$GN' AND scripture_main.ISO_ROD_index = LN_Temp.ISO_ROD_index AND scripture_main.ISO_ROD_index = ISO_countries.ISO_ROD_index AND ISO_countries.ISO_countries = countries.ISO_Country ORDER BY LN_Temp.LN";
		else
			$query="SELECT DISTINCT LN_Temp.LN, scripture_main.* FROM LN_Temp, scripture_main WHERE scripture_main.ISO_ROD_index = LN_Temp.ISO_ROD_index AND LN_Temp.LN LIKE '$Beg%' ORDER BY LN_Temp.LN";
	}
	$resultSwitch=$db->query($query);
	$numSwitch=$resultSwitch->num_rows;

	$query = 'SELECT Variant_Description FROM Variants WHERE Variant_Code = ?';				// Variants table
	$stmt_Var=$db->prepare($query);															// create a prepared statement
	$query="SELECT $SpecificCountry FROM ISO_countries, countries WHERE ISO_countries.ISO_ROD_index = ? AND ISO_countries.ISO_countries = countries.ISO_Country ORDER BY $SpecificCountry";
	$stmt_ISO_countries=$db->prepare($query);												// create a prepared statement
	$query='SELECT alt_lang_name FROM alt_lang_names WHERE ISO_ROD_index = ?';				// alt_lang_names table
	$stmt_alt=$db->prepare($query);															// create a prepared statement
	echo "<div id='CT'><table id='CountryTable'>";		// <div id='CT'> required for IE because it can't handle tables!
	$i=0;
	while ($i < $numSwitch) {
		if ($i % 2)
			$color = 'f8fafa';
		else
			//$color = 'f0f4f0';
			$color = 'EEF1F2';
		$row=$resultSwitch->fetch_assoc();
		$LN = $row['LN'];
		// Cross Site Scripting (XSS) attack happens where client side code (usually JavaScript) gets injected into the output of your PHP script. The next line cleans it up.
		$LN = htmlspecialchars($LN, ENT_QUOTES, 'UTF-8');
		$ISO = $row['ISO'];
		$ROD_Code = $row['ROD_Code'];
		$ISO_ROD_index = $row['ISO_ROD_index'];
		$Variant_Code = $row['Variant_Code'];
		$VD = '';
		if (!is_null($Variant_Code) && $Variant_Code != '') {
			$stmt_Var->bind_param('s', $Variant_Code);										// bind parameters for markers								// 
			$stmt_Var->execute();															// execute query
			$resultVar = $stmt_Var->get_result();											// instead of bind_result (used for only 1 record):
			if ($resultVar) {
				$rowVD = $resultVar->fetch_assoc();
				$VD = $rowVD['Variant_Description'];
			}
		}		
		$stmt_ISO_countries->bind_param('i', $ISO_ROD_index);								// bind parameters for markers								// 
		$stmt_ISO_countries->execute();														// execute query
		$result_ISO_countries = $stmt_ISO_countries->get_result();							// instead of bind_result (used for only 1 record):
		$row_ISO_countries = $result_ISO_countries->fetch_assoc();
		$countryTemp = $SpecificCountry;
		if (strpos("$SpecificCountry", '.')) $countryTemp = substr("$SpecificCountry", strpos("$SpecificCountry", '.')+1);			// In case there's a "." in the "country"
		$country = trim($row_ISO_countries["$countryTemp"]);														// name of the country in the language version
		$Country_Count = 1;
		while ($row_ISO_countries = $result_ISO_countries->fetch_assoc()) {
			$country = $country.', '.trim($row_ISO_countries["$countryTemp"]);										// name of the country in the language version
			$Country_Count++;
		}
		echo "<tr style='background-color: #". $color . "; '>";
		echo "<td width='30%' onclick='location.href=\"$Scriptname?sortby=lang&name=$ISO&ROD_Code=$ROD_Code&Variant_Code=$Variant_Code\"'>" . $LN . '</td>';
		$stmt_alt->bind_param('i', $ISO_ROD_index);											// bind parameters for markers								// 
		$stmt_alt->execute();																// execute query
		$result_alt = $stmt_alt->get_result();												// instead of bind_result (used for only 1 record):
		$alt_lang_names = '';
		if ($result_alt) {
			echo "<td width='35%'>";
			$i_alt=0;
			while ($row_alt = $result_alt->fetch_assoc()) {
				if ($i_alt != 0) {
					echo ', ';
					$alt_lang_names .= ', ';
				}
				$alt_lang_name=trim($row_alt['alt_lang_name']);
				// Cross Site Scripting (XSS) attack happens where client side code (usually JavaScript) gets injected into the output of your PHP script. The next line cleans it up.
				$alt_lang_name = htmlspecialchars($alt_lang_name, ENT_QUOTES, 'UTF-8');
				echo $alt_lang_name;
				$i_alt++;
			}
			echo '</td>';
		}
		else
			echo "<td width='35%'>&nbsp;</td>";
		echo "<td width='15%' onclick='location.href=\"$Scriptname?sortby=lang&name=$ISO&ROD_Code=$ROD_Code&Variant_Code=$Variant_Code\"'>" . $ISO;
		if ($VD != "") {
			include ('./include/00-MajorLanguageVariantCode.inc.php');
			echo "<br /><span style='font-style: italic; font-size: 8pt; '>($VD)</span>";
		}
		echo '</td>';
		echo "<td width='20%'>";
		if ($Country_Count < 5) {
			echo "<span style='font-size: .9em; '>$country</span>";
		}
		else {
			echo "<textarea rows='2' readonly disabled style='background-color: #$color; '>$country</textarea>";
		}
		echo '</td>';
		echo '</tr>';
		$i++;
	}
	echo '</table>';
	echo '</div>';
	
	if ($GN == 'all') {
		echo "~||~";
		
		echo "<div id='Letters'>";
		echo "<table style='width: 100%; margin-left: 25px; padding: 0; '>";
		echo "<tr valign='middle'>";
		echo "<td style='width: 100%; '>";
		$Letter = '';
		if ($number == 1)
			$query='SELECT DISTINCT LEFT(ISO, 1) AS Beg FROM LN_Temp ORDER BY ISO';
		else
			$query='SELECT DISTINCT LEFT(LN, 1) AS Beg FROM LN_Temp ORDER BY LN';
		$resultLetter = $db->query($query);
			
		$BegLetters=str_replace(' ', '&nbsp;', translate('Beginning with:', $st, 'sys')) . '&nbsp;&nbsp;';
		while ($r = $resultLetter->fetch_assoc()) {
			$BegLetter=$r['Beg'];
			if ($Beg == $BegLetter) {
				$BegLetters=$BegLetters . "<a style='text-decoration: underline; color: red; ' href='#' onclick='Switch(" . $number . ", \"" . $BegLetter . "\")'>" . $BegLetter . "</a>&nbsp;&nbsp;";
				$Letter = $BegLetter;
			}
			else
				$BegLetters=$BegLetters . "<a style='text-decoration: underline; ' href='#' onclick='Switch(" . $number . ", \"" . $BegLetter . "\")'>" . $BegLetter . "</a>&nbsp;&nbsp;";
		}
		if ($Beg == 'all')
			$BegLetters=$BegLetters . "[<a style='text-decoration: underline; color: red; ' href='#' onclick='Switch(" . $number . ", \"all\")'>" . translate('All', $st, 'sys') . "</a>]";
		else
			$BegLetters=$BegLetters . "[<a style='text-decoration: underline; ' href='#' onclick='Switch(" . $number . ", \"all\")'>" . translate('All', $st, 'sys') . "</a>]";
		echo "<div id='BeginningLetters' style='margin-top: 10px; margin-bottom: 10px; font-weight: bold; font-size: .95em; '>$BegLetters</div>";
		echo '</td>';
		echo '</tr>';
		echo '</table>';
		echo '</div>';
		$resultLetter->free();
	}
	
	$db->query('DROP TABLE LN_Temp');
	$result->free();
	$resultSwitch->free();
	$stmt_alt->close();
	$stmt_Var->close();
	$stmt_ISO_countries->close();
	$db->close();
?>