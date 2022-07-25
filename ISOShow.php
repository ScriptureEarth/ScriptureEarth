<?php
	// Called from Scripture_Add.php in JavaScript function ISOShow(iso, rod, var)
	
	// locate the iso and display it and all of the rod codes and var codes
	
	if (isset($_GET["iso"])) $iso = $_GET["iso"]; else { die('Hack!'); }
	if (isset($_GET["rod"])) $RODCode = $_GET["rod"]; else $RODCode = "00000";						// $RODCode !!!
	if (isset($_GET["var"])) $var = $_GET["var"]; else $var = '';
	
	include './include/conn.inc.php';
	$db = get_my_db();
	
	if (strlen($iso) == 3) {																		// if not, exit this ISOShow.php script
		$query="SELECT ISO_Lang_Countries.ISO_Country, ISO_Lang_Countries.LanguageName, countries.English FROM ISO_Lang_Countries, countries WHERE ISO_Lang_Countries.ISO = '$iso' AND countries.ISO_Country = ISO_Lang_Countries.ISO_Country AND ISO_Lang_Countries.LangNameType = 'L'";	// 'L' is for Language instead of Dialect, etc.
        $result_country = $db->query($query);
		$num = $result_country->num_rows;
		if (!$result_country || $num <= 0) {
			echo "<span style='color: red; font-weight: bold; '>Error. The langauge for " . $iso . " does not exist. Did you spell it right?</span>";
			//sleep(5);
			exit(0);
		}

// display ROD Code
		echo "<div style='position: relative; top: -125px; left: 240px; z-index: 5; display: inline; font-size: 11pt; font-weight: bold; '>ROD Codes:";	// dope-down dispay of the ROD Code and discriptions
			
		// Build the ROD_Temp table of ROD codes from scripture_main table where the ROD codes have the same ISO
		$db->query("DROP TABLE IF EXISTS ROD_Temp");											// Get the names of all of the Spanish languages or else get the default names
		$db->query("CREATE TEMPORARY TABLE ROD_Temp (rod VARCHAR(5) NOT NULL, language_name VARCHAR(60) NULL, dialect_name VARCHAR(60) NULL, location VARCHAR(60) NULL) ENGINE = MEMORY CHARSET = utf8")  or die ("Query failed: " . $db->error . "</body></html>");
		$query="SELECT ROD_Code FROM scripture_main WHERE ISO = '$iso' ORDER BY ROD_Code";		// all ROD codes selected for the ISO
		$result = $db->query($query);
		$num = $result->num_rows;
		if ($result && $num > 0) {																// There is 1 or more ROD dialects
			$query="INSERT INTO ROD_Temp (rod, language_name, dialect_name, location) VALUES (?, NULL, NULL, NULL)";
			$stmt=$db->prepare($query);															// create a prepared statement
			while ($r = $result->fetch_assoc()) {
				$rod=$r['ROD_Code'];
				//echo '<option style="font-size: 10pt; font-weight: bold; color: navy; " value="'.$rod.'">'.$rod.'</option>';
				//$db->query("INSERT INTO ROD_Temp (rod, language_name, dialect_name, location) VALUES ('$rod', NULL, NULL, NULL)");
				$stmt->bind_param("s", $rod);													// bind parameters for markers
				$stmt->execute();																// execute query
			}
			$stmt->close();
		}
		
		// INSERT into ROD_Temp table only when the ROD_Dialect table has the ISO
		$query="SELECT ROD_Code, language_name, dialect_name, location FROM ROD_Dialect WHERE ISO = '$iso' ORDER BY ROD_Code";		// all ROD dialects selected for ISO
		$result = $db->query($query);
		$num = $result->num_rows;
		if ($result && $num > 0) {																// There is 1 or more ROD dialects
			while ($r = $result->fetch_assoc()) {
				$rod=$r['ROD_Code'];
				$language_name=$r['language_name'];
				$dialect_name=$r['dialect_name'];
				$location=$r['location'];
				//echo $rod . ' ' . $language_name . ' ' . $dialect_name . ' ' . $location . '<br />';
				//echo '<option style="font-size: 10pt; font-weight: bold; color: navy; " value="'.$rod.'" selected>'.$rod.' '.$dialect_name.'; '.$location.'</option>';
				$db->query("INSERT INTO ROD_Temp (rod, language_name, dialect_name, location) VALUES ('$rod', '$language_name', '$dialect_name', '$location')");
			}
		}

		// Display the ROD codes with select option box
		echo "<select id='disROD' name='disROD' style='font-size: 10pt; color: navy; font-weight: bold; display: inline; ' onchange=\"RODCode('$iso', this.options[this.selectedIndex].value)\">";	// if onchange then re-do Scripture_Add.php with the new Trod
//		echo "<select id='addROD' name='AddROD' style='font-size: 10pt; color: navy; font-weight: bold; display: inline; ' onchange='document.getElementById(\"rod\").value'>";	// if onchange then re-do Scripture_Add.php with the new Trod
		$query="SELECT DISTINCT * FROM ROD_Temp ORDER BY rod, language_name DESC";
		$result = $db->query($query);
		$num = $result->num_rows;
		if ($result && $num > 0) {		// There is 1 or more ROD dialects
			$RODTemp = '';
			for ($i=0; $i < $num; $i++) {
				$r = $result->fetch_assoc();
				$rod=$r['rod'];
				if ($i == 0 && $rod != "00000") {
					if ($RODCode == "00000") {			// $RODCode is real ROD code
						echo '<option style="font-size: 10pt; font-weight: bold; color: navy; " value="00000" selected>00000</option>';
					}
					else {
						echo '<option style="font-size: 10pt; font-weight: bold; color: navy; " value="00000">00000</option>';
					}
				}
				if ($rod != $RODTemp) {
					$language_name=$r['language_name'];
					$dialect_name=$r['dialect_name'];
					$location=$r['location'];
					if ($RODCode == $rod) {
						echo '<option style="font-size: 10pt; font-weight: bold; color: navy; " value="'.$rod.'" selected>'.$rod.' '.$dialect_name.'; '.$location.'</option>';
					}
					else {
						echo '<option style="font-size: 10pt; font-weight: bold; color: navy; " value="'.$rod.'">'.$rod.' '.$dialect_name.'; '.$location.'</option>';
					}
					$RODTemp = $rod;
				}
			}
		}
		else {
			echo '<option style="font-size: 10pt; font-weight: bold; color: navy; " value="00000" selected>00000</option>';
		}
		echo "</select>";
		$db->query("DROP TABLE ROD_Temp");
		?>
		<form style="display: inline; ">
			<div id="addROD" name="addROD" style="display: inline; ">
				<input type="button" value="Add to ROD Code" onClick="addROD('rod', 'addingROD')" />
				<input type="button" value="Replace this ROD Code with the new ROD Code" onClick="replaceROD('rod', 'replacingROD')" />
			</div>
		</form>
	</div>
	
<!-- Add ROD Code -->
	<div id='addingROD' name='addingROD' style='display: none; position: relative; top: -115px; left: 0px; '>
		<br />
		<form>
		<table width="100%" border="0" cellspacing="2" cellpadding="4" align="center" style="padding: 15px; color: navy; background-color: #F7889E; ">
		  <tr>
			<th colspan="6">
			  Add ROD Code
			</th>
		  </tr>
		  <tr style="vertical-align: bottom; ">
			<th scope="col" width="4%">ISO</th>
			<th scope="col" width="10%">ROD Code</th>
			<th scope="col" width="12%">Country Code</th>
			<th scope="col" width="25%">Country<br />spoken in</th>
			<th scope="col" width="25%">Family<br />Language</th>
			<th scope="col" width="24%">This ISO's<br />Language Name</th>
		  </tr>
		  <tr>
			<td style="border: navy thin solid; font-weight: bold; "><?php echo $iso ?></td>
			<td style="border: navy thin solid; "><input type="text" value='' id='RODCodeValue' name='RODCodeValue' size='8' maxlenght='5' /></td>
		<?php
		// SELECT $result_country (from the top of this script)
		if ($result_country->num_rows == 1) {			// 1 country
			$r_Temp = $result_country->fetch_assoc();
			$CountryCode=$r_Temp['ISO_Country'];
			$CountryName=$r_Temp['English'];
			echo '<td style="border: navy thin solid; text-align: center; ">'.$CountryCode.'</td>';
			echo '<td style="border: navy thin solid; ">'.$CountryName.'</td>';
		}
//            elseif (mysql_num_rows($result_country) > 1) {		// There is 2 or more countries
		else {
			echo '<td style="border: navy thin solid; text-align: center; "><select name="formCountryCode" id="formCountryCode" onChange="CountryCodeChange()">';
			while ($r_Temp = $result_country->fetch_assoc()) {
				$CountryCode=$r_Temp['ISO_Country'];
				echo '<option value="'.$CountryCode.'">'.$CountryCode.'</option>';
			}
			echo '</select></td>';
			echo '<td style="border: navy thin solid; "><select name="formCountryName" id="formCountryName" onChange="CountryNameChange()">';
			$result_country->data_seek(0);
			while ($r_Temp = $result_country->fetch_assoc()) {
				$CountryName=$r_Temp['English'];
				echo '<option value="'.$CountryName.'">'.$CountryName.'</option>';
			}
			echo '</select></td>';
		}
/*            else {
			echo "Error. The langauge for " . $iso . " does not exist. Did you spell it right?";
			//sleep(5);
			exit(0);
		}
*/			
		$result_country->data_seek(0);
		$r_Temp = $result_country->fetch_assoc();
		$iso_Lang_Countries_LanguageName=$r_Temp['LanguageName'];				// ISO_Lang_Countries table
			//<td style="border: navy thin solid; "><input type="text" value='' name='CountryCode' size='13' maxlenght='2' /></td>
			//<td style="border: navy thin solid; "><input type="text" value='' name='Location' /></td>
		?>
			<td style="border: navy thin solid; "><input type="text" value='<?php echo $iso_Lang_Countries_LanguageName ?>' name='Language' size='30' /></td>
			<td style="border: navy thin solid; "><input type="text" value='' name='Dialect' size='29' /></td>
		  </tr>
		</table>
		<!--input type="button" value="Submit" onClick="addSubmit('ROD', 'addingROD', '<php echo $iso >', document.forms[0].ROD_Code.value, document.forms[0].CountryCode.value, document.forms[0].Language.value, document.forms[0].Dialect.value, document.forms[0].Location.value)" /-->
		<div style='text-align: center; '>
			<input type='button' value='Submit' onClick="addSubmit('rod', 'addingROD', '<?php echo $iso ?>', '<?php echo $CountryCode ?>', '<?php echo $CountryName ?>', this.form)" />
			<input type="button" value="Cancel" onClick="addCancel('rod', 'addingROD')" />
		</div>
		</form>
	</div>

<!-- Replace ROD Code -->
	<div id='replacingROD' name='replacingROD' style='display: none; position: relative; top: -115px; left: 0px; '>
		<br />
		<form>
		<table width="45%" border="0" cellspacing="2" cellpadding="4" align="center" style="padding: 15px; color: navy; background-color: #F7889E; ">
		  <tr>
			<th colspan="3">
			  Replace ROD Code
			</th>
		  <tr>
			<th scope="col" width="10%">ISO</th>
			<th scope="col" width="45%">From: ROD Code</th>
			<th scope="col" width="45%">To: ROD Code</th>
		  </tr>
			<td style="border: navy thin solid; "><?php echo $iso ?></td>
			<td style="border: navy thin solid; "><?php echo $RODCode ?></td>
			<td style="border: navy thin solid; "><input type="text" value='' name='ChangeCode' size='8' maxlenght='5' /></td>
		  </tr>
		</table>
		<div style='text-align: center; '>
			<input type="button" value="Submit" onClick="replaceSubmit('rod', 'replacingROD', '<?php echo $iso ?>', '<?php echo $RODCode ?>', this.form)" />
			<input type="button" value="Cancel" onClick="replaceCancel('rod', 'replacingROD')" />
		</div>
		</form>
	</div>
	<?php
	$query="SELECT ROD_Code FROM scripture_main WHERE ISO = '$iso' AND ROD_Code = '$RODCode'";
	$resultROD=$db->query($query);
	$numROD=$resultROD->num_rows;
	$TempRODCode = 0;
	if (!$resultROD || $numROD <= 0) {
		echo "|livesearch:<span style='color: navy; font-weight: bold; font-size: 12pt; '>Success for ROD Code.</span>|";
		$TempRODCode = 1;
	}
	else {
		echo "|livesearch:<span style='color: red; font-weight: normal; font-size: 12pt; '>Wrong ROD Code.</span>|";
	}

	echo "<br />";
	
// display Variant Code
	$query="SELECT Variant_Code FROM scripture_main WHERE ISO = '$iso' AND ROD_Code = '$RODCode'";		// all ROD dialects selected
	$result = $db->query($query);
	$num=$result->num_rows;
	echo "<div style='position: relative; top: -115px; left: 240px; z-index: 5; display: inline; font-size: 11pt; font-weight: bold; '>Variant Descriptions <small>(rarely used)</small>: ";
		echo "<form id='myVC' name='myVC' action='#' style='display: inline; font-size: 11pt; '>";
			echo "<select id='var' name='var' style='width: 250px; font-size: 10pt; color: navy; font-weight: bold; display: inline; '>";
			if ($result && $num > 0) {
				$query="SELECT Variant_Description FROM Variants WHERE Variant_Code = ?";
				$stmt=$db->prepare($query);																// create a prepared statement
				while ($r = $result->fetch_assoc()) {
					$var=$r['Variant_Code'];
					if ($var == '' || $var == NULL) {
						echo "<option id='var0' style='font-size: 10pt; font-weight: bold; color: navy; ' value=''></option>";
					}
					else {
						//$query="SELECT Variant_Description FROM Variants WHERE Variant_Code = '$Variant_Code'";
						//$resultVar = $db->query($query);
						$stmt->bind_param("s", $var);													// bind parameters for markers								// 
						$stmt->execute();																// execute query
						$resultVar = $stmt->get_result();												// instead of bind_result (used for only 1 record):
						$r_Des = $resultVar->fetch_assoc();
						$Variant_Description=$r_Des['Variant_Description'];
						echo "<option id='$var' style='font-size: 10pt; font-weight: bold; color: navy; ' value='$var'>$Variant_Description</option>";
					}
				}
				$stmt->close();
			}
			echo "</select>";
			echo '<input type="button" value="Add" onClick="addVariant()" />';
		echo '</form>';
		$query="SELECT Variant_Code FROM scripture_main WHERE ISO = '$iso' AND ROD_Code = '$RODCode'";
		$resultVariant=$db->query($query);
		$num=$resultVariant->num_rows;
		if (!$resultVariant) {
		}
		else {
			echo "<div id='variant' style='background-color: white; font-size: 10pt; '>";
			if ($TempRODCode == 0 || (($var == NULL || $var == "") && $num == 1)) {
			}
			else {
				if (0 < $num) {
					echo "|livesearch:<span style='color: red; font-weight: normal; '>Wrong for Variant Code.</span>|";
				}
				else {
					// Scott: 4/6/2021
					//$r = $resultVariant->fetch_assoc();
					//$Variant_Code=$r['Variant_Code'];
					echo "|livesearch:<span style='color: navy; font-weight: bold; '>Success for Variant Code.</span>|";
				}
			}
			echo "</div>";
		}
		echo "</div>";
		
// Add Variant
// List all variant desciptions from Variants table
// usually hidden
		?>
		<div id="addingVariant" name="addingVariant" style="position: relative; top: -130px; left: 0px; z-index: 5; display: none; ">
			<br />
			<form id='Variants' name='Variants' action='#'>
			<table width="100%" border="0" cellspacing="2" cellpadding="4" align="center" style="padding: 15px; color: navy; background-color: #F7889E; ">
			  <tr>
				<th width="100%" colspan="3">
					Add Variant
				</th>
			  </tr>
			  <tr>
				<th scope="col" width="4%">ISO</th>
				<th scope="col" width="13%">ROD Code</th>
				<th scope="col" width="83%">Variant Description</th>
			  </tr>
			  <tr>
				<td style="border: navy thin solid; font-weight: bold; "><?php echo $iso ?></td>
				<td style="border: navy thin solid; font-weight: bold; "><?php echo $RODCode ?></td>
				<td style="border: navy thin solid; ">
					<select id='Variant_Codes' name='Variant_Codes' style='font-size: 10pt; color: navy; font-weight: bold; display: inline; '>
						<?php
						$query="SELECT Variant_Code, Variant_Description FROM Variants ORDER BY Variant_index";
						$resultVar = $db->query($query);
						$numVar = $resultVar->num_rows;
						if ($resultVar && $numVar > 0) {
							while ($r_Var = $resultVar->fetch_assoc()) {
								$var=$r_Var['Variant_Code'];
								$Variant_Description=$r_Var['Variant_Description'];
								echo '<option style="font-size: 10pt; font-weight: bold; color: navy; " value="'.$var.'">'.$Variant_Description.'</option>';
							}
						}
						?>
					</select>
				</td>
			  </tr>
			</table>
			<div style="text-align: center; ">
				<!-- http://www.javascriptkit.com/jsref/select.shtml#section2, http://www.felgall.com/jstip22.htm -->
				<input type="button" value="Submit" onClick="addVarSubmit(document.Variants.Variant_Codes.options[document.Variants.Variant_Codes.selectedIndex].value, document.Variants.Variant_Codes.options[document.Variants.Variant_Codes.selectedIndex].text)" />
				<input type="button" value="Cancel" onClick="addVarCancel()" />
			</div>
			</form>
		</div>
		<?php
		
// re-display the ISO countries, navigational languages, alternate language name(s), and "The Bible in..." with the actual default data
        $db->query("DROP TABLE IF EXISTS ISO_Temp");
        $result_Temp = $db->query("CREATE TEMPORARY TABLE ISO_Temp (iso VARCHAR(3), rod VARCHAR(5)) ENGINE = MEMORY") or die ("Query failed: " . $db->error . "</body></html>");
        foreach ($_SESSION['nav_ln_array'] as $code => $array){
			$db->query("INSERT INTO ISO_Temp (iso, rod) SELECT DISTINCT ISO, ROD_Code FROM LN_".$array[1]." WHERE ISO = '$iso' AND ROD_Code = '$RODCode'");
		}
        $query="SELECT DISTINCT iso, rod FROM ISO_Temp WHERE iso = '$iso' AND rod = '$RODCode'";
        $result = $db->query($query);
		$num = $result->num_rows;
        $db->query("DROP TABLE ISO_Temp");
		if (!$result || $num <= 0) {
        	?>
			<div id="Countrys" name="Countrys">
				<div class='enter' style='clear: both; font-weight: bold; '>COUNTRIES</div>
				<table width="100%" cellpadding="0" cellspacing="0" name="tableEngCountries" id="tableEngCountries">
					<tr>
						<td width="53%">
							<span style='font-size: 10pt; '>In English, enter the Country in which the Language is indigenous:</span>
						</td>
						<td width="30%">
							<?php
								echo "<input type='text' name='Eng_country-1' id='Eng_country-1' style='color: navy; ' size='60' value='";
								if ($result_country) {
									$result_country->data_seek(0);
									$r_Temp = $result_country->fetch_assoc();
									echo str_replace("'","&#x27;", $r_Temp['English']);
								}
								echo "' />";
							?>
						</td>
						<td width="17%" style="text-align: right; ">
							<input style="font-size: 9pt; " type="button" value="Add" onclick="addRowToTableCol1('tableEngCountries', 'Eng_country');" />
							<input style="font-size: 9pt; " type="button" value="Remove" onclick="removeRowFromTable('tableEngCountries');" />
						</td>
					</tr>
                    <?php
					$i = 2;
					$result_country->data_seek(1);
					while ($r_Temp = $result_country->fetch_assoc()) {
						$Eng_country=$r_Temp['English'];
						$Eng_country = str_replace("'","&#x27;",$Eng_country);	// for input tag
						echo "<tr>";
							echo "<td width='53%'>";
								echo "&nbsp;";
							echo "</td>";
							echo "<td width='30%'>";
								echo "<input type='text' name='Eng_country-$i' id='Eng_country-$i' style='color: navy; ' size='60' value='$Eng_country' />";
							echo "</td>";
							echo "<td width='17%'>";
								echo "&nbsp;";
							echo "</td>";
						echo "</tr>";
						$i++;
					}
					?>
				</table>
				<br />
                <?php
					$result_country->data_seek(0);
					$r_Temp = $result_country->fetch_assoc();
					
					
					foreach ($_SESSION['nav_ln_array'] as $code => $array){
						$html = "<div class='MajorLang'>In <span>".strtoupper($array[1])."</span>, enter the Language Name: <input type='text' name='".$array[1]."_lang_name' id='".$array[1]."_lang_name' size='35' style='color: navy; font-weight: bold; ' value=\"switch\" /></div>";
						if (isset($_POST[$array[1].'_lang_name'])){
							$result = str_replace('switch', $_POST[$array[1].'_lang_name'], $html);
						} else {
							$result = str_replace('switch', '', $html);
						}
						echo $result;
					}
				?>
				<br />
				<p>Select the default major langauge <span style="font-size: 10pt; ">(i.e. the major language from above)</span>: 
				<select name="DefaultLang">
					<?php foreach ($_SESSION['nav_ln_array'] as $code => $array){
						$html = '<option value="'.$array[1].'Lang" switch>'.$array[1].'</option>';
						if ($code == "es"){
							$result = str_replace("switch", " selected='yes'", $html);
						} else {
							$result = str_replace("switch", "", $html);
						}
						echo $result;
					}
					?>
				</select>
				</p>
				<br />
                
				<table width="100%" cellpadding="0" cellspacing="0" name="tableAltNames" id="tableAltNames">
					<tr>
						<td width="53%">
							Enter the Alternate Language Names<span style="font-size: 9pt; "> (one line per Name)</span>:
						</td>
						<td width="30%">
							<input type='text' name='txtAltNames-1' id='txtAltNames-1' style='color: navy; ' size='60' value='' />
						</td>
						<td width="17%" style="text-align: right; ">
							<input style="font-size: 9pt; " type="button" value="Add" onclick="addRowToTableCol1('tableAltNames', 'txtAltNames');" />
							<input style="font-size: 9pt; " type="button" value="Remove" onclick="removeRowFromTable('tableAltNames');" />
						</td>
					</tr>
				</table>
                
                <br />

                <input type='radio' name='GroupAdd' value='AddNo' checked /> No "The Bible In" or "The Scripture In".<br />
                <input type='radio' name='GroupAdd' value='AddTheBibleIn' /> "The Bible In" added to the specific name of the language on the top of the screen.<br />
                <input type='radio' name='GroupAdd' value='AddTheScriptureIn' /> "The Scripture In" added to the specific name of the language on the top of the screen.

			</div>
			<?php
		}
		else {
			
			$query="SELECT countries.English FROM countries, ISO_countries WHERE ISO_countries.ISO_countries = countries.ISO_Country AND ISO_countries.ISO = '$iso' AND ISO_countries.ROD_Code = '$RODCode'";
			$result=$db->query($query);
			$num = $result->num_rows;
			if ($result && $num > 0) {
				$row = $result->fetch_array();
				$Eng_country=$row['English'];
			}
			$Eng_country = str_replace("'","&#x27;",$Eng_country);			// for input tag
			?>
			<div id="Countrys" name="Countrys">
				<div class='enter' style='font-weight: bold; '>COUNTRIES</div>
				<table width="100%" cellpadding="0" cellspacing="0" name="tableEngCountries" id="tableEngCountries">
					<tr>
						<td width="53%">
							<span style='font-size: 10pt; '>In English, enter the <span style='font-size: 11pt; font-weight: bold; '>COUNTRY(IES)</span> in which the Language is indigenous:</span>
						</td>
						<td width="30%">
                        	<?php
							echo "<input type='text' name='Eng_country-1' id='Eng_country-1' style='color: navy; ' size='40' value='$Eng_country' />";
							?>
						</td>
						<td width="17%" style="text-align: right; ">
							<input style="font-size: 9pt; " type="button" value="Add" onclick="addRowToTableCol1('tableEngCountries', 'Eng_country')" />
							<input style="font-size: 9pt; " type="button" value="Remove" onclick="removeRowFromTable('tableEngCountries')" />
						</td>
					</tr>
					<?php
					$i = 2;
					$result->data_seek(1);
					while ($row = $result->fetch_assoc()) {
						$Eng_country=$row['English'];
						$Eng_country = str_replace("'","&#x27;",$Eng_country);	// for input tag
						echo "<tr>";
							echo "<td width='53%'>";
								echo "&nbsp;";
							echo "</td>";
							echo "<td width='30%'>";
								echo "<input type='text' name='Eng_country-$i' id='Eng_country-$i' style='color: navy; ' size='40' value='$Eng_country' />";
							echo "</td>";
							echo "<td width='17%'>";
								echo "&nbsp;";
							echo "</td>";
						echo "</tr>";
						$i++;
					}
					?>
				</table>
				<br /><br />
				
				<?php

				foreach ($_SESSION['nav_ln_array'] as $code => $array){
					${$array[1]."_lang_name"}='';
					$query="SELECT LN_".$array[1]." FROM LN_".$array[1]." WHERE ISO = '$iso' AND ROD_Code = '$RODCode'";
					$result=$db->query($query);
					$num = $result->num_rows;
					if ($result && $num > 0) {
						$row = $result->fetch_array();
						${$array[1]."_lang_name"}=$row['LN_'.$array[1]];
						${$array[1]."_lang_name"} = str_replace("'","&#x27;",${$array[1]."_lang_name"});	// for input tag
					}
					echo "<div class='enter' style='font-size: 10pt; '>In <span style='font-size: 12pt; font-weight: bold; '>".strtoupper($array[1])."</span>, enter the Language Name: <input type='text' name='".$array[1]."_lang_name' id='".$array[1]."_lang_name' size='35' style='color: navy; font-weight: bold; ' value=\"".${$array[1]."_lang_name"}."\" /></div>";
				}
				?>


				
				<?php
				$query="SELECT Def_LN FROM scripture_main WHERE ISO = '$iso' AND ROD_Code = '$RODCode'";
				$result=$db->query($query);
				$row = $result->fetch_array();
				$def_LN=$row['Def_LN'];
				?>
				<br />

                <p>Select the default major langauge <span style="font-size: 10pt; ">(i.e. the major language from above)</span>:
				<select name="DefaultLang">
					<?php
					foreach ($_SESSION['nav_ln_array'] as $code => $array){
						$html = "<option value=\"EnglishLang\" switch >".$array[1]."</option>";
						if ($def_LN == $array[3]) {
							$result = str_replace('switch', " selected='yes'", $html);
						} else {
							$result = str_replace('switch', '', $html);
						}
						echo $result;
					}
					?>
				</select>
				</p>
                <br />
			
				<?php
				$query="SELECT rtl FROM viewer WHERE ISO = '$iso' AND ROD_Code = '$RODCode' AND Variant_Code = '$var'";
				$result=$db->query($query);
				$rtl = 0;
				if ($result->num_rows > 0) {
					$row = $result->fetch_array();
					$rtl=$row['rtl'];
				}

				// display alternate language names
				$query = "SELECT * FROM alt_lang_names WHERE ISO = '$iso' AND ROD_Code = '$RODCode'";
				$result1 = $db->query($query) or die ("Query failed: " . $db->error . "</body></html>");
				$num = $result1->num_rows;
				if (!$result1 || $num <= 0) {
					//die ("'$iso' is not found.</body></html>");
					$row1=0;
				}
				else {
					$row1=$result1->num_rows;
				}
				?>
				<table width="100%" cellpadding="0" cellspacing="0" name="tableAltNames" id="tableAltNames">
					<tr>
						<td width="53%">
							Enter the Alternate Language Names<span style="font-size: 9pt; "> (one line per Name)</span>:
						</td>
						<td width="30%">
						<?php
							if ($row1 > 0) {
								$r_row1 = $result1->fetch_array();
								$txtAltNames=str_replace("'","&#x27;",$r_row1['alt_lang_name']);
								echo "<input type='text' name='txtAltNames-1' id='txtAltNames-1' style='color: navy; ' size='40' value='$txtAltNames' />";
							}
							else {
								echo "<input type='text' name='txtAltNames-1' id='txtAltNames-1' style='color: navy; ' size='40' value='' />";
							}
						?>
						</td>
						<td width="17%" style="text-align: right; ">
							<input style="font-size: 9pt; " type="button" value="Add" onclick="addRowToTableCol1('tableAltNames', 'txtAltNames');" />
							<input style="font-size: 9pt; " type="button" value="Remove" onclick="removeRowFromTable('tableAltNames');" />
						</td>
					</tr>
					<?php
					//if ($row1 > 1) {
					$i = 1;
					$result1->data_seek(1);
					while ($i < $row1) {
						echo "<tr>";
							echo "<td width='53%'>";
								echo "&nbsp;";
							echo "</td>";
							echo "<td width='30%'>";
								$y = $i + 1;
								$r_row = $result1->fetch_array();
								echo "<input type='text' name='txtAltNames-$y' id='txtAltNames-$y' style='color: navy; ' size='40' value='" . str_replace("'","&#x27;",$r_row['alt_lang_name']) . "' />";
							echo "</td>";
							echo "<td width='17%'>";
								echo "&nbsp;";
							echo "</td>";
						echo "</tr>";
						$i++;
					}
					//}
					?>
				</table>
                
                <br /><br />
                
				<?php
				$query="SELECT AddNo, AddTheBibleIn, AddTheScriptureIn FROM scripture_main WHERE ISO = '$iso' AND ROD_Code = '$RODCode'";
				$result=$db->query($query);
				$row = $result->fetch_array();
				$AddNo=$row['AddNo'];
				$AddTheBibleIn=$row['AddTheBibleIn'];
				$AddTheScriptureIn=$row['AddTheScriptureIn'];
				?>
                <input type='radio' name='GroupAdd' value='AddNo' checked <?php echo ($AddNo == 1 ? ' checked' : '') ?> /> No "The Bible In" or "The Scripture In".<br />
                <input type='radio' name='GroupAdd' value='AddTheBibleIn' <?php echo ($AddTheBibleIn == 1 ? ' checked' : '') ?> /> "The Bible In" added to the specific name of the language on the top of the screen.<br />
                <input type='radio' name='GroupAdd' value='AddTheScriptureIn' <?php echo ($AddTheScriptureIn == 1 ? ' checked' : '') ?> /> "The Scripture In" added to the specific name of the language on the top of the screen.

			</div>
			<?php
		}
	}
?>