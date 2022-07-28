<?php
/*
	*********************************************************************************************
		in case someone does ?iso=[ISO] and there is more than one ROD and/or variant codes
	*********************************************************************************************
*/
	echo '<div id="langBackground" style="cursor: pointer; " onclick="window.open(\''.$Scriptname.'\', \'_self\')">';
	echo "<img src='images/00".$st."-ScriptureEarth_header.jpg' class='langHeader' alt='".translate('Scripture Resources in Thousands of Languages', $st, 'sys')."' />";									// just the ScriptureEarth.org icon
	echo '</div>';
	$stmt_SC = $db->prepare("SELECT DISTINCT $SpecificCountry, ISO_Country FROM scripture_main, countries, ISO_countries WHERE countries.ISO_Country = ISO_countries.ISO_countries AND ISO_countries.ISO = scripture_main.ISO AND scripture_main.ISO = ?");														// create a prepared statement
	$stmt_c = $db->prepare("SELECT ISO_Country FROM countries WHERE $SpecificCountry = ?");
	$stmt_Var = $db->prepare("SELECT $Variant_major FROM Variants WHERE Variant_Code = ?");
	$stmt_alt = $db->prepare("SELECT alt_lang_name FROM alt_lang_names WHERE ISO_ROD_index = ?");
	$stmt_asset = $db->prepare("SELECT Cell_Phone_File, optional FROM CellPhone WHERE ISO_ROD_index = ? AND Cell_Phone_Title = 'iOS Asset Package'");
	$i = 0;
	$ln_result = '';
	foreach($_SESSION['nav_ln_array'] as $code => $array){
		$ln_result .= 'LN_'.$array[1].', ';
	}
	$query="SELECT DISTINCT ISO_ROD_index, ISO, ROD_Code, Variant_Code, ".$ln_result."Def_LN FROM nav_ln WHERE ISO = '$ISO'";
	if ($result = $db->query($query)) {
		$LN = '';
		echo '<br /><div style="color: navy; background-color: white; font-size: 20pt; ">'.translate('Choose one...', $st, 'sys').'</div><br />';
		echo "<p style='line-height: 2px; '>&nbsp;</p>";
		echo "<div id='languageName' class='countryFirst'>";
			echo "<div class='countryLN1'>".translate('Language Name', $st, 'sys')."</div>";
			echo "<div class='countryCountry1'>".translate('Country', $st, 'sys')."</div>";
			echo "<div class='countryCode1' style='cursor: pointer; '>".translate('Code', $st, 'sys')."</div>";
			echo "<div class='countryAlt1'>".translate('Alternate Language Names', $st, 'sys')."</div>";
		echo '</div>';
		echo '<div class="MTORODCode">';
		while ($row = $result->fetch_assoc()) {												// scripture_main - all ROD and variant codes for just one ISO
			echo "<p style='line-height: 2px; '>&nbsp;</p>";
			$idx = trim($row['ISO_ROD_index']);
			$rod = $row['ROD_Code'];
			$var = $row['Variant_Code'];
			$VD = '';
			
			$ISO_ROD_index = $row['ISO_ROD_index'];											// make sure that 00-DBLanguageCountryName.inc.php works
			include './include/00-DBLanguageCountryName.inc.php';							// returns LN
			
			if ($asset == 1) {
				// URL from CellPhone.Cell_Phone_File
				$stmt_asset->bind_param('i', $idx);											// bind parameters for markers
				$stmt_asset->execute();														// execute query
				$result_asset = $stmt_asset->get_result();
				$row_asset = $result_asset->fetch_assoc();
				$URL = $row_asset['Cell_Phone_File'];
				$optional = $row_asset['optional'];
			}

			// countries
			$stmt_SC->bind_param('s', $ISO);												// bind parameters for markers
			$stmt_SC->execute();															// execute query
			$result_con=$stmt_SC->get_result() or die (translate('Query failed:', $st, 'sys') . ' ' . $db->error . '</body></html>');
			if ($result_con->num_rows == 0) {
				die (translate('The ISO language code is not found.', $st, 'sys') . '</body></html>');
			}
			$country = '';
			$temp_Country = '';
			while ($row_con = $result_con->fetch_array()) {									// get all of the country names
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
			
			// variant code
			if (is_null($var) || $var == '') {
				$VD = '';
			}
			else {
				$stmt_Var->bind_param('s', $var);											// bind parameters for markers								// 
				$stmt_Var->execute();														// execute query
				$result_Var = $stmt_Var->get_result();
				$row_Var = $result_Var->fetch_assoc();
				$VD = $row_Var["$Variant_major"];
			}
			
			// alternate language names
			$alt = '';
			$stmt_alt->bind_param('i', $idx);												// bind parameters for markers
			$stmt_alt->execute();															// execute query
			if ($result_alt = $stmt_alt->get_result()) {
				$a = 1;
				while ($row_alt = $result_alt->fetch_assoc()) {
					$alt_temp = $row_alt['alt_lang_name'];
					if ($a < $result_alt->num_rows) {
						$alt .= $alt_temp.', ';
					}
					else {
						$alt .= $alt_temp;
					}
					$a++;
				}
			}
			
			// Cross Site Scripting (XSS) attack happens where client side code (usually JavaScript) gets injected into the output of your PHP script. The next line cleans it up.
			echo "<div class='moreThanOneRODCode'>";
// here: checked
			if ($asset == 1) {
				echo "<div class='moreThanLN2' onclick='iOSLanguage(\"$st\", \"$idx\", \"$LN\", \"$URL\")'>".$LN;
			}
			else {
				echo "<div class='moreThanLN2' onclick='window.open(\"".$Scriptname."?idx=".$idx."\", \"_self\")'>".$LN;
			}
			if ($VD != '') echo "<br /><span style='font-style: italic; font-size: 8pt; '>(".$VD.")</span>";
			echo "</div>";
			
			echo "<p class='moreThanCountry2'>";
			$countrySplit = explode(', ', $country);										// full country name : ZZ abbreviated country name
			if (count($countrySplit) < 5) {
				for ($k = 0; $k < count($countrySplit); $k++) {
					$tempCountry = substr($countrySplit[$k], 0, strlen($countrySplit[$k]) - 3);		// full country name (split ':')
					$tempAbbCountry = substr($countrySplit[$k], strlen($countrySplit[$k]) - 2);		// ZZ abbreviated country name (split ':')
					echo '<span style="font-size: .9em; cursor: pointer; " onclick="window.open(\'./'.$Scriptname.'?sortby=country&name='.$tempAbbCountry.'\', \'_self\')">'.$tempCountry.'</span>';
					if ($k+1 < count($countrySplit)) {
						echo ', ';
					}
				}
			}
			else {
				$country_no_abbrev = preg_replace('/:[A-Z]{2}/', '', $country);				// delete the ":" and the abberviation ZZ of the country leaving the full country(ies)
				echo "<textarea rows='2' readonly style='width: 100%; height: 100%; border: none; '>".$country_no_abbrev."</textarea>";
			}
			
			echo "</p>";
// here: checked
			if ($asset == 1) {
				echo "<div class='moreThanAlt2' onclick='iOSLanguage(\"$st\", \"$idx\", \"$LN\", \"$URL\")'>".$alt."</div>";
			}
			else {
				echo "<div class='moreThanAlt2' onclick='window.open(\"".$Scriptname."?idx=".$idx."\", \"_self\")'>".$alt."</div>";
			}
			
// here: checked
			if ($asset == 1) {
				echo "<div class='moreThanCode2' onclick='iOSLanguage(\"$st\", \"$idx\", \"$LN\", \"$URL\")'>".$ISO."<br />[".$rod."]";
			}
			else {			
				echo "<div class='moreThanCode2' onclick='window.open(\"".$Scriptname."?idx=".$idx."\", \"_self\")'>".$ISO."<br />[".$rod."]";
			}
			if (isset($Variant_Code) && $Variant_Code != '') {
				echo "<br />[".$var."]";
			}
			echo '</div>';
			
			echo '</div>';
		}
		echo "</div>";
		echo '<br />';
	}
?>