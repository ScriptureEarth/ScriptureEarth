<?php
// 00-BegList.Edit.php?st=<?php echo $st; ? >&MajorLanguage=<?php echo $MajorLanguage; ? >&SpecificCountry=<?php echo $SpecificCountry; ? >&Scriptname=<?php echo $Scriptname; ? >&b=" + Beg + "&gn=" + GN + "&n="+number, true

function check_input($value) {						// used for ' and " that find it in the input
	$value = trim($value);
    /* Automatic escaping is highly deprecated, but many sites do it anyway. */
	// Stripslashes
	//if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
		$value = stripslashes($value);
	//}
	// Quote if not a number
	if (!is_numeric('$value')) {
		$db = get_my_db();
		$value = $db->real_escape_string($value);
	}
	return $value;
}

	$MajorLanguage = 'LN_English';
	$SpecificCountry = 'countries.English';
	$Country = 'English';
	$Scriptname = basename($_SERVER["SCRIPT_NAME"]);

	$Beg = $_GET['b'];
	$number = $_GET['n'];
	require_once './include/conn.inc.php';
	$db = get_my_db();
	
	$query = 'SELECT * FROM nav_ln';
	$result = $db->query($query);

	/*
		*************************************************************************************************************
			select the default primary language name to be used by displaying the Countries and indigenous langauge names
		*************************************************************************************************************
	*/
	$db->query('DROP TABLE IF EXISTS LN_Temp');							// Get the names of all of the Spanish languages or else get the default names
	$db->query('CREATE TEMPORARY TABLE LN_Temp (iso VARCHAR(3) NOT NULL, rod VARCHAR(5) NOT NULL, idx INT NULL, LN VARCHAR(50) NOT NULL) ENGINE = MEMORY CHARSET = utf8') or die ('Query failed: ' . $db->error . '</body></html>');
	$stmt = $db->prepare('INSERT INTO LN_Temp (iso, rod, idx, LN) VALUES (?, ?, ?, ?)');			// create a prepared statement
	while ($row = $result->fetch_assoc()) {
		$iso=$row['ISO'];									// ISO
		$rod=$row['ROD_Code'];								// ROD_Code
		$var=$row['Variant_Code'];							// Variant_Code
		$idx=$row['ISO_ROD_index'];							// ISO_ROD_index
		
		$ISO_ROD_index = (string)$idx;						// make sure that00-DBLanguageCountryName.inc.php will work correctly
		include ('./include/00-DBLanguageCountryName.inc.php');
		
		$stmt->bind_param("ssis", $iso, $rod, $idx, $LN);							// bind parameters for markers
		$stmt->execute();															// execute query
	}
	$stmt->close();																	// close statement

	if ($number == 1) {		// $which == 'Name'
		if ($Beg == 'all')
			$query="SELECT DISTINCT LN_Temp.LN, scripture_main.* FROM LN_Temp, scripture_main WHERE scripture_main.ISO_ROD_index = LN_Temp.idx ORDER BY LN_Temp.iso, LN_Temp.rod";
		else
			$query="SELECT DISTINCT LN_Temp.LN, scripture_main.* FROM LN_Temp, scripture_main WHERE scripture_main.ISO_ROD_index = LN_Temp.idx AND LN_Temp.iso LIKE '$Beg%' ORDER BY LN_Temp.iso, LN_Temp.rod";
	}
	else {					// $which == 'Code'
		if ($Beg == 'all')
			$query="SELECT DISTINCT LN_Temp.LN, scripture_main.* FROM LN_Temp, scripture_main WHERE scripture_main.ISO_ROD_index = LN_Temp.idx ORDER BY LN_Temp.LN";
		else
			$query="SELECT DISTINCT LN_Temp.LN, scripture_main.* FROM LN_Temp, scripture_main WHERE scripture_main.ISO_ROD_index = LN_Temp.idx AND LN_Temp.LN LIKE '$Beg%' ORDER BY LN_Temp.LN";
	}
	$resultSwitch=$db->query($query);
	$numSwitch=$resultSwitch->num_rows;										// see 'Total languages are' at the end of this script

	$query="SELECT Variant_Eng FROM Variants WHERE Variant_Code = ?";						// Variants table
	$stmt_Var = $db->prepare($query);														// create a prepared statement
	$query="SELECT $SpecificCountry FROM ISO_countries, countries WHERE ISO_countries.ISO_ROD_index = ? AND ISO_countries.ISO_countries = countries.ISO_Country ORDER BY $SpecificCountry";
	$stmt_ISO_countries = $db->prepare($query);												// create a prepared statement
	$query="SELECT alt_lang_name FROM alt_lang_names WHERE ISO_ROD_index = ?";				// alt_lang_names table
	$stmt_alt = $db->prepare($query);														// create a prepared statement
	echo "<div id='CT'><table id='CountryTable'>";							// <div id='CT'> required for IE because it can't handle tables!
	$i=0;
	while ($r = $resultSwitch->fetch_assoc()) {
		if ($i % 2)
			$color = "f8fafa";
		else
			//$color = "f0f4f0";
			$color = "EEF1F2";
		$LN = $r['LN'];
		// Cross Site Scripting (XSS) attack happens where client side code (usually JavaScript) gets injected into the output of your PHP script. The next line cleans it up.
		$LN = htmlspecialchars($LN, ENT_QUOTES, 'UTF-8');
		$iso = $r['ISO'];
		$rod = $r['ROD_Code'];
		$idx = $r['ISO_ROD_index'];
		$var = $r['Variant_Code'];
		$VD = '';
		if (!is_null($var) && $var != '') {
			$stmt_Var->bind_param("s", $var);												// bind parameters for markers								// 
			$stmt_Var->execute();															// execute query
			$resultVar = $stmt_Var->get_result();											// instead of bind_result (used for only 1 record):
			if ($resultVar) {
				$r_temp = $resultVar->fetch_assoc();
				$VD = $r_temp['Variant_Eng'];
			}
		}		
		$stmt_ISO_countries->bind_param("i", $idx);								// bind parameters for markers								// 
		$stmt_ISO_countries->execute();														// execute query
		$result_ISO_countries = $stmt_ISO_countries->get_result();							// instead of bind_result (used for only 1 record):
		// $SpecificCountry = the past dot $counterName	
		$r_temp = $result_ISO_countries->fetch_assoc();
		$country = trim($r_temp[$Country]);													// name of the country in the language version
		while ($r_temp = $result_ISO_countries->fetch_assoc()) {
			$country .= ', ' . trim($r_temp[$Country]);										// name of the country in the language version
		}
		echo "<tr style='background-color: #". $color . "; '>";
		echo "<td width='6%' style='cursor: pointer; '><img style='margin-bottom: 3px; margin-left: 13px; cursor: hand; ' onclick='parent.location=\"Scripture_Edit.php?idx=$idx\"' src='images/pencil_edit.png' /></td>";
		echo "<td width='28%' style='padding: 3px 5px 3px 5px; '>$LN</td>";
		$stmt_alt->bind_param("i", $idx);											// bind parameters for markers								// 
		$stmt_alt->execute();																// execute query
		$result_alt = $stmt_alt->get_result();												// instead of bind_result (used for only 1 record):
		$alt_lang_names = '';
		if ($result_alt) {
			echo "<td width='31%' style='padding: 3px 5px 3px 5px; '>";
			$i_alt=0;
			while ($r_temp = $result_alt->fetch_assoc()) {
				if ($i_alt != 0) {
					$alt_lang_names .= ", ";
				}
				$alt_lang_name = trim($r_temp['alt_lang_name']);
				$alt_lang_names .= $alt_lang_name;
				$i_alt++;
			}
			// Cross Site Scripting (XSS) attack happens where client side code (usually JavaScript) gets injected into the output of your PHP script. The next line cleans it up.
			$alt_lang_names = htmlspecialchars($alt_lang_names, ENT_QUOTES, 'UTF-8');
			echo $alt_lang_names;
			echo "</td>";
		}
		else
			echo "<td width='31%'>&nbsp;</td>";
		$result_alt->close();
		echo "<td width='15%' style='padding: 3px 5px 3px 5px; '>" . $iso . " " . $rod;
		if ($VD != "") {
			echo "<br /><span style='font-style: italic; font-size: 8pt; '>($VD)</span>";
		}
		echo "</td>";
		echo "<td width='20%' style='padding: 3px 5px 3px 5px; '>" . $country . "</td>";
		echo "</tr>";
		$i++;
	}
	echo "</table>";
	echo "</div>";
	
	echo "~||~";
	
	echo "<div id='Letters'>";
	echo "<table style='width: 100%; margin-left: 25px; padding: 0; '>";
	echo "<tr valign='middle'>";
	echo "<td style='width: 100%; '>";
	$Letter = "";
	$BegLetters="";
	if ($number == 1) {
		$query="SELECT DISTINCT LEFT(iso, 1) AS Beg FROM LN_Temp ORDER BY iso";
		$BegLetters=str_replace(" ", "&nbsp;", 'Select the beginning of the ISO code:') . "&nbsp;&nbsp;";
	}
	else {
		$query="SELECT DISTINCT LEFT(LN, 1) AS Beg FROM LN_Temp ORDER BY LN";
		$BegLetters=str_replace(" ", "&nbsp;", 'Select the beginning of the Language Name:') . "&nbsp;&nbsp;";
	}
	$resultLetter = $db->query($query);
	while ($r_temp = $resultLetter->fetch_assoc()) {
		$BegLetter=$r_temp['Beg'];
		if ($Beg == $BegLetter) {
			$BegLetters=$BegLetters . "<a style='text-decoration: underline; color: red; ' href='#' onclick='Switch(" . $number . ", \"" . $BegLetter . "\")'>" . $BegLetter . "</a>&nbsp;&nbsp;";
			$Letter = $BegLetter;
		}
		else
			$BegLetters=$BegLetters . "<a style='text-decoration: underline; ' href='#' onclick='Switch(" . $number . ", \"" . $BegLetter . "\")'>" . $BegLetter . "</a>&nbsp;&nbsp;";
	}
	if ($Beg == 'all')
		$BegLetters=$BegLetters . "[<a style='text-decoration: underline; color: red; ' href='#' onclick='Switch(" . $number . ", \"all\")'>" . "All" . "</a>]";
	else
		$BegLetters=$BegLetters . "[<a style='text-decoration: underline; ' href='#' onclick='Switch(" . $number . ", \"all\")'>" . "All" . "</a>]";
	echo "<div id='BeginningLetters' style='margin-top: 10px; margin-bottom: 10px; font-weight: bold; '>$BegLetters</div>";
	echo "</td>";
	echo "</tr>";
	echo "</table>";
	echo "</div>";
	
	echo "~||~";
	
	echo "<div style='margin: 40px; font-size: 14pt; color: navy; font-weight: bold; '>Total languages are $numSwitch</div>";
	
	$db->query("DROP TABLE LN_Temp");
	$result->free();
	$resultSwitch->free();
	$stmt_alt->close();
	$stmt_Var->close();
	$stmt_ISO_countries->close();
	$resultLetter->free();
	$db->close();
?>