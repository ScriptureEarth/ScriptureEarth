<?php
session_start();

// called by 00_CountryTable.inc.php in AJAX
// ajaxCountryRequest.open("GET", "00_BegList.php?st=< ?php echo $st; ? >&MajorLanguage=<?php echo $MajorLanguage; ? >&SpecificCountry=< ?php echo $SpecificCountry; ? >&Scriptname=< ?php echo $Scriptname; ? >&gn=" + GN + "&n="+number, true);
// Created by Scott Starker
// Updated by Scott Starker, Lærke Roager

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

	if (!isset($_GET["st"]) || !isset($_GET["MajorLanguage"]) || !isset($_GET["SpecificCountry"]) || !isset($_GET["Scriptname"]) || !isset($_GET["gn"]) || !isset($_GET["n"]))
		die('One or more GET wasn\'t on the URL line!</body></html>');
	$st = $_GET["st"];
	$st = preg_replace("/^([a-z]{3})/", "$1", $st);
	$MajorLanguage = $_GET["MajorLanguage"];
	$MajorLanguage = preg_replace("/^(LN_\w)/", "$1", $MajorLanguage);
	$SpecificCountry = $_GET["SpecificCountry"];
	$SpecificCountry = preg_replace("/^(countries\.\w)/", "$1", $SpecificCountry);
	$Scriptname = $_GET["Scriptname"];
	$GN = $_GET["gn"];								// Get Name of country or "ALL"
	$GN = preg_replace("/^([a-zA-Z]{1,3})/", "$1", $GN);
	$number = $_GET["n"];							// either number = 2 (LanguageName) or 1 (LanguageCode)
	$number = preg_replace("/^([1-2])/", "$1", $number);
	if (empty($st) || empty($MajorLanguage) || empty($SpecificCountry) || empty($GN) || empty($number))
		die('HACK! One or more variables wasn\'t on the URL line!</body></html>');
	$asset = 0;
	if (isset($_GET['asset'])) {
		$asset = $_GET['asset'];
		if ($asset != 0 && $asset != 1) {
			die('asset is not valid.</body></html>');
		}
	}

	require_once './include/conn.inc.php';
	$db = get_my_db();
	include './translate/functions.php';
	
	if ($asset == 1) {
		$query="SELECT DISTINCT nav_ln.* , $SpecificCountry FROM nav_ln, countries, ISO_countries, CellPhone WHERE ISO_countries.ISO_countries = '$GN' AND nav_ln.ISO_ROD_index = ISO_countries.ISO_ROD_index AND ISO_countries.ISO_countries = countries.ISO_Country AND nav_ln.ISO_ROD_index = CellPhone.ISO_ROD_index AND CellPhone.Cell_Phone_Title = 'iOS Asset Package' ORDER BY nav_ln.ISO";
		$stmt_asset = $db->prepare('SELECT Cell_Phone_File, optional FROM CellPhone WHERE ISO_ROD_index = ? AND Cell_Phone_Title = "iOS Asset Package"');			// create a prepared statement
	}
	else {
		$query="SELECT DISTINCT $SpecificCountry, nav_ln.* FROM nav_ln, countries, ISO_countries WHERE ISO_countries.ISO_countries = '$GN' AND nav_ln.ISO_ROD_index = ISO_countries.ISO_ROD_index AND ISO_countries.ISO_countries = countries.ISO_Country ORDER BY nav_ln.ISO";
	}
	$result=$db->query($query);

	/*
		*************************************************************************************************************
			select the default primary language name to be used by displaying the Countries and indigenous langauge names
		*************************************************************************************************************
	*/
	$db->query("DROP TABLE IF EXISTS LN_Temp");			// Get the names of all of the Spanish languages or else get the default names
	$db->query("CREATE TEMPORARY TABLE LN_Temp (ISO VARCHAR(3) NOT NULL, ROD_Code VARCHAR(5) NOT NULL, ISO_ROD_index INT NULL, LN VARCHAR(50) NOT NULL) ENGINE = MEMORY CHARSET = utf8") or die (translate('Query failed:', $st, 'sys') . ' ' . $db->error . "</body></html>");
	//$i=0;
	$stmt = $db->prepare('INSERT INTO LN_Temp (ISO, ROD_Code, ISO_ROD_index, LN) VALUES (?, ?, ?, ?)');			// create a prepared statement
	while ($row = $result->fetch_array()) {
		$ISO=$row['ISO'];								// ISO
		$ROD_Code=$row['ROD_Code'];						// ROD_Code
		$Variant_Code=$row['Variant_Code'];				// Variant_Code
		$ISO_ROD_index=$row['ISO_ROD_index'];			// ISO_ROD_index
		$ML=$row["$MajorLanguage"];						// $ML booloen the major language
		$def_LN=$row['Def_LN'];							// default langauge (a 2 digit number for the national langauge)
		if (!$ML) {										// if the English then the default langauge
			foreach ($_SESSION['nav_ln_array'] as $code => $nav_ln_temp_array){
				if ($nav_ln_temp_array[3] == $def_LN){
					$query="SELECT LN_".$nav_ln_temp_array[1]." FROM LN_".$nav_ln_temp_array[1]." WHERE ISO_ROD_index = '$ISO_ROD_index'";
					$result_LN=$db->query($query);
					$row_temp=$result_LN->fetch_assoc();
					$LN=trim($row_temp['LN_'.$nav_ln_temp_array[1]]);
				}
			}
		}
		else {
			$query="SELECT $MajorLanguage FROM $MajorLanguage WHERE ISO_ROD_index = '$ISO_ROD_index'";
			$result_LN=$db->query($query);
			$row_temp=$result_LN->fetch_assoc();
			$LN=trim($row_temp["$MajorLanguage"]);
		}
		$stmt->bind_param("ssis", $ISO, $ROD_Code, $ISO_ROD_index, $LN);			// bind parameters for markers								// 
		$stmt->execute();															// execute query
	}
	$stmt->close();																	// close statement

	if ($number == 1) {		// $which == 'Name'
		$query="SELECT DISTINCT LN_Temp.LN, nav_ln.* FROM LN_Temp, nav_ln WHERE nav_ln.ISO_ROD_index = LN_Temp.ISO_ROD_index ORDER BY LN_Temp.ISO, LN_Temp.ROD_Code";
	}
	else {	// $which == 'Code'
		$query="SELECT DISTINCT LN_Temp.LN, nav_ln.* FROM LN_Temp, nav_ln WHERE nav_ln.ISO_ROD_index = LN_Temp.ISO_ROD_index ORDER BY LN_Temp.LN";
	}
	$resultSwitch=$db->query($query);
	$numSwitch=$resultSwitch->num_rows;

	$query = "SELECT Variant_Description FROM Variants WHERE Variant_Code = ?";				// Variants table
	$stmt_Var=$db->prepare($query);															// create a prepared statement
	$query="SELECT $SpecificCountry, ISO_countries FROM ISO_countries, countries WHERE ISO_countries.ISO_ROD_index = ? AND ISO_countries.ISO_countries = countries.ISO_Country ORDER BY $SpecificCountry";
	$stmt_ISO_countries=$db->prepare($query);												// create a prepared statement
	$query="SELECT alt_lang_name FROM alt_lang_names WHERE ISO_ROD_index = ?";				// alt_lang_names table
	$stmt_alt=$db->prepare($query);															// create a prepared statement
	echo "<div id='CT'>";		// <div id='CT'> required for IE because it can't handle tables!
		$i=0;
		while ($i < $numSwitch) {
			echo "<p style='line-height: 2px; '>&nbsp;</p>";
			$row=$resultSwitch->fetch_assoc();
			$ISO = $row['ISO'];
			$ROD_Code = $row['ROD_Code'];
			$ISO_ROD_index = $row['ISO_ROD_index'];
			$Variant_Code = $row['Variant_Code'];
			$LN = $row['LN'];
			// Cross Site Scripting (XSS) attack happens where client side code (usually JavaScript) gets injected into the output of your PHP script. The next line cleans it up.
			$LN = htmlspecialchars($LN, ENT_QUOTES, 'UTF-8');
			
			if ($asset == 1) {
				// URL from CellPhone.Cell_Phone_File
				$stmt_asset->bind_param('i', $ISO_ROD_index);										// bind parameters for markers
				$stmt_asset->execute();																// execute query
				$result_asset = $stmt_asset->get_result();
				if ($result_asset->num_rows == 0) continue;
				$row_asset = $result_asset->fetch_assoc();
				$URL = $row_asset['Cell_Phone_File'];
				$optional = $row_asset['optional'];
			}
			
			echo "<div class='countrySecond'>";
				// language
				if ($asset == 1) {
					echo "<div class='countryLN2' onclick='iOSLanguage(\"$st\",$ISO_ROD_index,\"$LN\", \"$URL\")'>$LN";
				}
				else {
					echo "<div class='countryLN2' onclick='location.href=\"$Scriptname?sortby=lang&name=$ISO&ROD_Code=$ROD_Code&Variant_Code=$Variant_Code\"'>$LN";
				}
				$VD = '';
				if (!is_null($Variant_Code) && $Variant_Code != '') {
					$stmt_Var->bind_param("s", $Variant_Code);										// bind parameters for markers								// 
					$stmt_Var->execute();															// execute query
					$resultVar = $stmt_Var->get_result();											// instead of bind_result (used for only 1 record):
					if ($resultVar) {
						$rowVar = $resultVar->fetch_array();
						$VD = $rowVar['Variant_Description'];
						include ("./include/00-MajorLanguageVariantCode.inc.php");
						echo "<div>($VD)</div>";
					}
					$resultVar->free();
				}
				echo '</div>';
				
				// Country(ies)
				$stmt_ISO_countries->bind_param("i", $ISO_ROD_index);								// bind parameters for markers								// 
				$stmt_ISO_countries->execute();														// execute query
				$result_ISO_countries = $stmt_ISO_countries->get_result();							// instead of bind_result (used for only 1 record):
				$row_ISO_countries = $result_ISO_countries->fetch_array();
				$countryTemp = $SpecificCountry;
				if (strpos("$SpecificCountry", '.')) $countryTemp = substr("$SpecificCountry", strpos("$SpecificCountry", '.')+1);		// In case there's a "." in the "country"
				$countryTextarea = trim($row_ISO_countries["$countryTemp"]);						// name of the country in the language version
				$country = '<a class="indivCountry" href="./'.$Scriptname.'?sortby=country&name=' . trim($row_ISO_countries["ISO_countries"]) . '&st=' . $st . '">' . trim($row_ISO_countries["$countryTemp"]) . '</a>';
				while ($row_ISO_countries = $result_ISO_countries->fetch_array()) {
					$countryTextarea = $countryTextarea . ', ' . trim($row_ISO_countries["$countryTemp"]);
					$country = $country . ', <a class="indivCountry" href="./'.$Scriptname.'?sortby=country&name=' . trim($row_ISO_countries["ISO_countries"]) . '&st=' . $st . '">' . trim($row_ISO_countries["$countryTemp"]) . '</a>';			// name of the country in the language version
				}
				echo "<p class='countryCountry2'>";
				echo "<span style='font-size: .9em; '>$country</span>";
				echo "</p>";
		
				// ISO
				if ($asset == 1) {
					echo "<div class='countryCode2' onclick='iOSLanguage(\"".$st."\",".$ISO_ROD_index.",\"".$LN."\",\"".$URL."\")'>$ISO</div>";
				}
				else {
					echo "<div class='countryCode2' onclick='location.href=\"$Scriptname?sortby=lang&name=$ISO&ROD_Code=$ROD_Code&Variant_Code=$Variant_Code\"'>$ISO</div>";
				}
				
				// alternate language names
				$stmt_alt->bind_param("i", $ISO_ROD_index);											// bind parameters for markers								// 
				$stmt_alt->execute();																// execute query
				$result_alt = $stmt_alt->get_result();												// instead of bind_result (used for only 1 record):
				$alt_lang_names = '';
				if ($result_alt) {
					if ($asset == 1) {
						echo "<div class='countryAlt2' onclick='iOSLanguage(\"".$st."\",".$ISO_ROD_index.",\"".$LN."\",\"".$URL."\")'>";
					}
					else {
						echo "<div class='countryAlt2' onclick='location.href=\"$Scriptname?sortby=lang&name=$ISO&ROD_Code=$ROD_Code&Variant_Code=$Variant_Code\"'>";
					}
					$alt_item = '';
					$i_alt=0;
					while ($row_alt = $result_alt->fetch_assoc()) {
						if ($i_alt > 0) {
							$alt_item .= ', ';
							//$alt_lang_names .= ', ';
						}
						$alt_lang_name=trim($row_alt['alt_lang_name']);
						// Cross Site Scripting (XSS) attack happens where client side code (usually JavaScript) gets injected into the output of your PHP script. The next line cleans it up.
						$alt_lang_name = htmlspecialchars($alt_lang_name, ENT_QUOTES, 'UTF-8');
						$alt_item .= $alt_lang_name;
						$i_alt++;
					}
					echo "<div style='display: inline; font-size: .95em; '>$alt_item</div>";
					echo "</div>";
				}
				else
					echo "<div width='40%'>&nbsp;</div>";
			echo "</div>";
			$i++;
		}
	echo '</div>';
	
	$db->query('DROP TABLE LN_Temp');
	$result->free();
	$resultSwitch->free();
	$stmt_alt->close();
	$stmt_Var->close();
	$stmt_ISO_countries->close();
	$db->close();
?>