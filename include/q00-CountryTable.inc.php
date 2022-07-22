	<?php
	if (!isset($GetName)) {
		$GetName = "all";
	}
	if (isset($_GET["number"])) {
		$number = $_GET["number"];
		//echo $number;
		// Cross Site Scripting (XSS) attack happens where client side code (usually JavaScript) gets injected into the output of your PHP script. The next line cleans it up.
		//$number = htmlspecialchars($number, ENT_QUOTES, 'UTF-8');
		$test = preg_match('/^(1-2)/', $number, $matches);
		if ($test === 0) {
			$number = 1;
		}
		else {
			$number = $matches[1];
		}
	}
	else {
		$number = 2;
	}
	
	if ($GetName == "all") {
		$query = "SELECT DISTINCT * FROM scripture_main";
	}
	else {
		$query="SELECT DISTINCT $SpecificCountry, scripture_main.* FROM scripture_main, countries, ISO_countries WHERE ISO_countries.ISO_countries = '$GetName' AND scripture_main.ISO_ROD_index = ISO_countries.ISO_ROD_index AND ISO_countries.ISO_countries = countries.ISO_Country ORDER BY scripture_main.ISO";
	}
	$result=$db->query($query);
	//$num=$result->num_rows;

	/*
		*********************************************************************************************************************
			select the default major language name to be used by displaying the Countries and indigenous langauge names
		*********************************************************************************************************************
	*/
	$db->query("DROP TABLE IF EXISTS LN_Temp");				// Get the names of all of the major languages or else get the default names
	$db->query("CREATE TEMPORARY TABLE LN_Temp (ISO VARCHAR(3) NOT NULL, ROD_Code VARCHAR(5) NOT NULL, ISO_ROD_index INT NULL, LN VARCHAR(50) NOT NULL) ENGINE = MEMORY CHARSET = utf8") or die (translate('Query failed:', $st, 'sys') . ' ' . $db->error . "</body></html>");
	//$i=0;
	$stmt = $db->prepare('INSERT INTO LN_Temp (ISO, ROD_Code, ISO_ROD_index, LN) VALUES (?, ?, ?, ?)');			// create a prepared statement
	while ($row = $result->fetch_array()) {
		$ISO=$row['ISO'];									// ISO
		$ROD_Code=$row['ROD_Code'];							// ROD_Code
		$Variant_Code=$row['Variant_Code'];					// Variant_Code
		$ISO_ROD_index=$row['ISO_ROD_index'];				// ISO_ROD_index

		include ('./include/00-DBLanguageCountryName.inc.php');

		//$db->query("INSERT INTO LN_Temp (ISO, ROD_Code, ISO_ROD_index, LN) VALUES ('$ISO', '$ROD_Code', '$ISO_ROD_index', '$LN')");
		$stmt->bind_param("ssis", $ISO, $ROD_Code, $ISO_ROD_index, $LN);			// bind parameters for markers								// 
		$stmt->execute();															// execute query
		//$i++;
	}
	$stmt->close();																	// close statement
	?>
    <div id='Letters'>
	<table class='languageNames'>
	<tr valign='middle'>
	<td width='90%'>
    <?php
	$Letter = "";
	if ($GetName == "all") {
		//$number = 2;
		if ($number == 1) {
			$query="SELECT DISTINCT LEFT(ISO, 1) AS Beg FROM LN_Temp ORDER BY ISO";
		}
		else {
			$query="SELECT DISTINCT LEFT(LN, 1) AS Beg FROM LN_Temp ORDER BY LN";
		}
		$resultLetter = $db->query($query);
		//$numLetter=mysql_num_rows($resultLetter);
		/*if ($st == "spa")
			$BegLetters="Que&nbsp;comienzan&nbsp;con:&nbsp;&nbsp;";
		else
			$BegLetters="Beginning&nbsp;with:&nbsp;&nbsp;";*/
		$BegLetters=str_replace(" ", "&nbsp;", translate('Beginning with:', $st, 'sys')) . "&nbsp;&nbsp;";
		//$BegLetters=translate('Beginning with:', $st, 'sys') . "&nbsp;&nbsp;";
		//$i=0;
		while ($r = $resultLetter->fetch_array()) {
			$BegLetter=$r['Beg'];
			if (!isset($_GET["Beg"]) || $_GET["Beg"] == "" || $_GET["Beg"] == $BegLetter) {
				$BegLetters=$BegLetters . "<a style='text-decoration: underline; color: red; ' href='#' onclick='Switch(" . $number . ", \"" . $BegLetter . "\")'>" . $BegLetter . "</a>&nbsp;&nbsp;";
				$Letter = $BegLetter;
				$_GET["Beg"] = $BegLetter;
			}
			else
				$BegLetters=$BegLetters . "<a style='text-decoration: underline; ' href='#' onclick='Switch(" . $number . ", \"" . $BegLetter . "\")'>" . $BegLetter . "</a>&nbsp;&nbsp;";
			//$i++;
		}
		if ($_GET["Beg"] == 'all')
			$BegLetters=$BegLetters . "[<a style='text-decoration: underline; color: red; ' href='#' onclick='Switch(" . $number . ", \"all\")'>" . translate('All', $st, 'sys') . "</a>]";
		else
			$BegLetters=$BegLetters . "[<a style='text-decoration: underline; ' href='#' onclick='Switch(" . $number . ", \"all\")'>" . translate('All', $st, 'sys') . "</a>]";
		echo "<div id='BeginningLetters' style='margin-top: 10px; margin-bottom: 10px; font-weight: bold; font-size: .95em; '>$BegLetters</div>";
	}
	else
		echo "<span style='font-size: 2em; color: black; font-weight: bold; '>$country</span>";
	?>
    </td>
	<td width='10%'>&nbsp;
	</td>
	</tr>
	</table>
	</div>
    <?php
	// language name and ISO code here
	// The width and padding-left are what changes the spaces around the words.
	// When doing a Switch() Netscape 9 drops the table down a 1/2 inch. I don't know why.
//	echo $Letter;
	?>
    <table class='languageNames'>
	<tr id='languageName'>
    <?php
		echo "<th width='31%' class='secondHeaderSelection' style='font-size: .95em; '>".translate('Language Name', $st, 'sys').":&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='images/downTriangle.png' /></th>";
		echo "<th width='36%' class='secondHeader' style='font-size: .88em; color: black; '>".translate('Alternate Language Names', $st, 'sys').":</th>";
		echo "<th width='16%' class='secondHeader' style='font-size: .92em; '><a id='one' title='".translate('Click to sort.', $st, 'sys')."' href='#' onmouseup='Switch(1, \"$Letter\")'>".translate('Language Code', $st, 'sys').":</a></th>";
		echo "<th width='17%' class='secondHeader' style='font-size: .88em; color: black; '>".translate('Country', $st, 'sys').":</th>";
	?>
    </tr>
	<tr id='languageCode'>
    <?php
		echo "<th width='31%' class='secondHeader' style='font-size: .95em; '><a id='two' title='".translate('Click to sort.', $st, 'sys')."' href='#' onmouseup='Switch(2, \"$Letter\")'>".translate('Language Name', $st, 'sys').":</a></th>";
		echo "<th width='36%' class='secondHeader' style='font-size: .88em; color: black; '>".translate('Alternate Language Names', $st, 'sys').":</th>";
		echo "<th width='16%' class='secondHeaderSelection' style='font-size: .92em; '>".translate('Language Code', $st, 'sys').":&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='images/downTriangle.png' /></th>";
		echo "<th width='17%' class='secondHeader' style='font-size: .88em; color: black; '>".translate('Country', $st, 'sys').":</th>";
	?>
	</tr>
	</table>
	<div id='canvas' class='LangNames'>
	<div id="wait" style="display:none; position:absolute; top:45%; left:50%; padding:2px; "><img src="images/wait.gif" width="64" height="64" /></div>
	<?php

	if (!isset($_GET["Beg"])) $_GET["Beg"] = $GetName;			// display the same country though a different major langauge is displayed (7/2015)
	$Beg = $_GET["Beg"];
	if ($number == 1) {		// $which == 'Name'
		if ($Beg == 'all')
			if ($GetName == 'all')
				$query="SELECT DISTINCT LN_Temp.LN, scripture_main.* FROM LN_Temp, scripture_main WHERE scripture_main.ISO_ROD_index = LN_Temp.ISO_ROD_index ORDER BY LN_Temp.ISO, LN_Temp.ROD_Code";
			else
				$query="SELECT DISTINCT LN_Temp.LN, $SpecificCountry, scripture_main.* FROM LN_Temp, scripture_main, countries, ISO_countries WHERE ISO_countries.ISO_countries = '$GetName' AND scripture_main.ISO_ROD_index = LN_Temp.ISO_ROD_index AND scripture_main.ISO_ROD_index = ISO_countries.ISO_ROD_index AND ISO_countries.ISO_countries = countries.ISO_Country ORDER BY LN_Temp.ISO, LN_Temp.ROD_Code";
		else
			$query="SELECT DISTINCT LN_Temp.LN, scripture_main.* FROM LN_Temp, scripture_main WHERE scripture_main.ISO_ROD_index = LN_Temp.ISO_ROD_index AND LN_Temp.ISO LIKE '$Letter%' ORDER BY LN_Temp.ISO, LN_Temp.ROD_Code";
	}
	else {	// $which == 'Code'
		if ($Beg == 'all')
			if ($GetName == 'all')
				$query="SELECT DISTINCT LN_Temp.LN, scripture_main.* FROM LN_Temp, scripture_main WHERE scripture_main.ISO_ROD_index = LN_Temp.ISO_ROD_index ORDER BY LN_Temp.LN";
			else
				$query="SELECT DISTINCT LN_Temp.LN, $SpecificCountry, scripture_main.* FROM LN_Temp, scripture_main, countries, ISO_countries WHERE ISO_countries.ISO_countries = '$GetName' AND scripture_main.ISO_ROD_index = LN_Temp.ISO_ROD_index AND scripture_main.ISO_ROD_index = ISO_countries.ISO_ROD_index AND ISO_countries.ISO_countries = countries.ISO_Country ORDER BY LN_Temp.LN";
		else
			$query="SELECT DISTINCT LN_Temp.LN, scripture_main.* FROM LN_Temp, scripture_main WHERE scripture_main.ISO_ROD_index = LN_Temp.ISO_ROD_index AND LN_Temp.LN LIKE '$Letter%' ORDER BY LN_Temp.LN";
	}
	$result = $db->query($query);
	$num=$result->num_rows;

	?>
    <div id='NamesLang' class='callR'>
	    <?php

		/*
			*************************************************************************************************************
				display the langauge names for this country
			*************************************************************************************************************
		*/
		?>
	    <div id='CT'>
			<table id='CountryTable'>
		    <?php
			$i=0;

			$query = "SELECT alt_lang_name FROM alt_lang_names WHERE ISO_ROD_index = ?";			// alt_lang_names table
			//$result_alt=$db->query($query_alt);
			$stmt_alt = $db->prepare($query);														// create a prepared statement
			$query = "SELECT Variant_Description FROM Variants WHERE Variant_Code = ?";				// Variants table
			//$resultVar=$db->query($query);
			$stmt_Var = $db->prepare($query);														// create a prepared statement
			$query="SELECT $SpecificCountry FROM ISO_countries, countries WHERE ISO_countries.ISO_ROD_index = ? AND ISO_countries.ISO_countries = countries.ISO_Country ORDER BY $SpecificCountry";
			//$result_ISO_countries=$db->query($query);
			$stmt_ISO_countries = $db->prepare($query);												// create a prepared statement
			
			while ($i < $num) {
				if ($i % 2)
					$color = "f8fafa";
				else
					//$color = "f0f4f0";
					$color = "EEF1F2";
				$r = $result->fetch_array();
				$ISO = $r['ISO'];
				$ROD_Code = $r['ROD_Code'];
				$Variant_Code = $r['Variant_Code'];
				$ISO_ROD_index = $r['ISO_ROD_index'];
				$LN = $r['LN'];
				// Cross Site Scripting (XSS) attack happens where client side code (usually JavaScript) gets injected into the output of your PHP script. The next line cleans it up.
				$LN = htmlspecialchars($LN, ENT_QUOTES, 'UTF-8');
				echo "<tr style='background-color: #$color; '>";
				echo "<td width='30%' onclick='location.href=\"$Scriptname?sortby=lang&name=$ISO&ROD_Code=$ROD_Code&Variant_Code=$Variant_Code\"'>$LN</td>";
				//$query_alt="SELECT alt_lang_name FROM alt_lang_names WHERE ISO_ROD_index = '$ISO_ROD_index'";			// alt_lang_names
				//$result_alt=$db->query($query_alt);
				$stmt_alt->bind_param("i", $ISO_ROD_index);											// bind parameters for markers								// 
				$stmt_alt->execute();																// execute query
				$result_alt = $stmt_alt->get_result();												// instead of bind_result (used for only 1 record):
				$alt_lang_names = '';
				if ($result_alt) {
					$num_alt=$result_alt->num_rows;
					echo "<td width='35%'>";
					$i_alt=0;
					while ($row_temp = $result_alt->fetch_array()) {
						if ($i_alt != 0) {
							echo ", ";
							//$alt_lang_names .= ", ";
						}
						$alt_lang_name=trim($row_temp['alt_lang_name']);
						// Cross Site Scripting (XSS) attack happens where client side code (usually JavaScript) gets injected into the output of your PHP script. The next line cleans it up.
						$alt_lang_name = htmlspecialchars($alt_lang_name, ENT_QUOTES, 'UTF-8');
						echo "$alt_lang_name";
						//$alt_lang_names .= $alt_lang_name;
						$i_alt++;
					}
					echo "</td>";
				}
				else
					echo "<td width='35%'>&nbsp;</td>";
				//$ISO=trim($row['scripture_main.ISO"));											// ISO
				//$ROD_Code=trim($row['scripture_main.ROD_Code"));									// ROD_Code
				//$ISO_ROD_index=trim($row['scripture_main.ISO_ROD_index"));						// ISO_ROD_index
				echo "<td width='15%' onclick='location.href=\"$Scriptname?sortby=lang&name=$ISO&ROD_Code=$ROD_Code&Variant_Code=$Variant_Code\"'>$ISO";
				$VD = '';
				if (!is_null($Variant_Code) && $Variant_Code != '') {
					//$query = "SELECT Variant_Description FROM Variants WHERE Variant_Code = '$Variant_Code'";
					//$resultVar=$db->query($query) or die (translate('Query failed:', $st, 'sys') . ' ' . $db->error . "</body></html>");
					$stmt_Var->bind_param("s", $Variant_Code);										// bind parameters for markers								// 
					$stmt_Var->execute();															// execute query
					$resultVar = $stmt_Var->get_result();											// instead of bind_result (used for only 1 record):
					if ($resultVar) {
						$rowVar = $resultVar->fetch_array();
						$VD = $rowVar['Variant_Description'];
						include ("./include/00-MajorLanguageVariantCode.inc.php");
						echo "<br /><span style='font-style: italic; font-size: 8pt; '>($VD)</span>";
					}
					$resultVar->free();
				}		
				echo "</td>";
				//$query="SELECT $SpecificCountry FROM ISO_countries, countries WHERE ISO_countries.ISO_ROD_index = '$ISO_ROD_index' AND ISO_countries.ISO_countries = countries.ISO_Country ORDER BY $SpecificCountry";
				//$result_ISO_countries=$db->query($query);
				$stmt_ISO_countries->bind_param("i", $ISO_ROD_index);								// bind parameters for markers								// 
				$stmt_ISO_countries->execute();														// execute query
				$result_ISO_countries = $stmt_ISO_countries->get_result();							// instead of bind_result (used for only 1 record):
				$row_ISO_countries = $result_ISO_countries->fetch_array();
				//$num_ISO_countries=mysql_num_rows($result_ISO_countries);
				$countryTemp = $SpecificCountry;
				if (strpos("$SpecificCountry", '.')) $countryTemp = substr("$SpecificCountry", strpos("$SpecificCountry", '.')+1);		// In case there's a "." in the "country"
				$country = trim($row_ISO_countries["$countryTemp"]);								// name of the country in the language version
				$Country_Count = 1;
				while ($row_ISO_countries = $result_ISO_countries->fetch_array()) {
					$country = $country . ', ' . trim($row_ISO_countries["$countryTemp"]);			// name of the country in the language version
					$Country_Count++;
				}
				echo "<td width='20%'>";
				if ($Country_Count < 5) {
					echo "<span style='font-size: .9em; '>$country</span>";
				}
				else {
					echo "<textarea rows='2' readonly disabled style='background-color: #$color; '>$country</textarea>";
				}
				echo "</td>";
				echo "</tr>";
				$i++;
			}
			?>
		    </table>
		</div>
	</div>
    <?php
	//$result_ISO_countries->free();
	//$result_alt->free();
	$result->free();
	$stmt_alt->close();
	$stmt_Var->close();
	$stmt_ISO_countries->close();
	$db->query("DROP TABLE LN_Temp");
	
	// This HAS TO be below the code for id="languageName" and id="languageCode"!!!!!
	if ($number == 2) {
		// capital letter for list
		?>
		<script type="text/javascript">
			document.getElementById('languageCode').style.display = 'none';
			document.getElementById('languageName').style.display = 'block';
			//which = 'Name';
			//if (Beg != 'all')
			//	Beg = Beg.toUpperCase();
		</script>
		<?php
	}
	else {	// $number == 1
		// lower-case letter for list
		?>
		<script type="text/javascript">
			document.getElementById('languageName').style.display = 'none';
			document.getElementById('languageCode').style.display = 'block';
			//which = 'Code';
			//Beg = Beg.toLowerCase();
		</script>
		<?php
	}
	?>
		<script type="text/javascript"> 
			$(document).ready(function() {
				var divHeight = 0;
				divHeight += document.getElementById("container").offsetHeight;
				divHeight += 18;
				document.getElementById("container").style.height = divHeight + "px";
				// if the table is long enough IE goes to dark black (blur and opacity). I don't know why.
				$("#container").dropShadow({left: 5, top: 5, blur: 2, opacity: 0.5, color: "black", swap: false});
			});
		</script>
	</div>
