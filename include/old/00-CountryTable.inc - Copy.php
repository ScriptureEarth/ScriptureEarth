<?php
	if (!isset($GetName)) {
		$GetName = "all";
	}
	
	if ($GetName == "all") {
		$query = "SELECT DISTINCT * FROM scripture_main";
	}
	else {
		$query="SELECT DISTINCT $SpecificCountry, scripture_main.* FROM scripture_main, countries, ISO_countries WHERE ISO_countries.ISO_countries = '$GetName' AND scripture_main.ISO_ROD_index = ISO_countries.ISO_ROD_index AND ISO_countries.ISO_countries = countries.ISO_Country ORDER BY scripture_main.ISO";
	}
	$result=mysql_query($query);
	$num=mysql_num_rows($result);

	/*
		*********************************************************************************************************************
			select the default primary language name to be used by displaying the Countries and indigenous langauge names
		*********************************************************************************************************************
	*/
	mysql_query("DROP TABLE IF EXISTS LN_Temp");							// Get the names of all of the major languages or else get the default names
	$result_Temp = mysql_query("CREATE TEMPORARY TABLE LN_Temp (ISO VARCHAR(3) NOT NULL, ROD_Code VARCHAR(5) NOT NULL, ISO_ROD_index INT NULL, LN VARCHAR(50) NOT NULL) ENGINE = MEMORY CHARSET = utf8") or die (translate('Query failed:', $st, 'sys') . ' ' . mysql_error() . "</body></html>");
	$i=0;
	while ($i < $num) {
		$ISO=mysql_result($result,$i,"scripture_main.ISO");									// ISO
		$ROD_Code=mysql_result($result,$i,"scripture_main.ROD_Code");						// ROD_Code
		$Variant_Code=mysql_result($result,$i,"scripture_main.Variant_Code");				// Variant_Code
		$ISO_ROD_index=mysql_result($result,$i,"scripture_main.ISO_ROD_index");				// ISO_ROD_index

		include ('./include/00-DBLanguageCountryName.inc.php');

		$LN = check_input($LN);
		$result_Temp = mysql_query("INSERT INTO LN_Temp (ISO, ROD_Code, ISO_ROD_index, LN) VALUES ('$ISO', '$ROD_Code', '$ISO_ROD_index', '$LN')");
		$i++;
	}

	?>
    <div id='Letters'>
	<table class='languageNames'>
	<tr valign='middle'>
	<td width='90%'>
    <?php
	$Letter = "";
	if ($GetName == "all") {
		$number = 2;
		$query="SELECT DISTINCT LEFT(LN, 1) AS Beg FROM LN_Temp ORDER BY LN";
		$resultLetter = mysql_query($query);
		$numLetter=mysql_num_rows($resultLetter);
		/*if ($st == "spa")
			$BegLetters="Que&nbsp;comienzan&nbsp;con:&nbsp;&nbsp;";
		else
			$BegLetters="Beginning&nbsp;with:&nbsp;&nbsp;";*/
		$BegLetters=str_replace(" ", "&nbsp;", translate('Beginning with:', $st, 'sys')) . "&nbsp;&nbsp;";
		//$BegLetters=translate('Beginning with:', $st, 'sys') . "&nbsp;&nbsp;";
		$i=0;
		while ($i < $numLetter) {
			$BegLetter=mysql_result($resultLetter,$i,"Beg");
			if (!isset($_GET["Beg"]) || $_GET["Beg"] == "" || $_GET["Beg"] == $BegLetter) {
				$BegLetters=$BegLetters . "<a style='text-decoration: underline; color: red; ' href='#' onclick='Switch(" . $number . ", \"" . $BegLetter . "\")'>" . $BegLetter . "</a>&nbsp;&nbsp;";
				$Letter = $BegLetter;
				$_GET["Beg"] = $BegLetter;
			}
			else
				$BegLetters=$BegLetters . "<a style='text-decoration: underline; ' href='#' onclick='Switch(" . $number . ", \"" . $BegLetter . "\")'>" . $BegLetter . "</a>&nbsp;&nbsp;";
			$i++;
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
		echo "<th width='36%' class='secondHeader' style='font-size: .88em; '>".translate('Alternate Language Names', $st, 'sys').":</th>";
		echo "<th width='16%' class='secondHeader' style='font-size: .92em; '><a id='one' title='".translate('Click to sort.', $st, 'sys')."' href='#' onmouseup='Switch(1, \"$Letter\")'>".translate('Language Code', $st, 'sys').":</a></th>";
		echo "<th width='17%' class='secondHeader' style='font-size: .88em; '>".translate('Country', $st, 'sys').":</th>";
	?>
    </tr>
	<tr id='languageCode'>
    <?php
		echo "<th width='31%' class='secondHeader' style='font-size: .95em; '><a id='two' title='".translate('Click to sort.', $st, 'sys')."' href='#' onmouseup='Switch(2, \"$Letter\")'>".translate('Language Name', $st, 'sys').":</a></th>";
		echo "<th width='36%' class='secondHeader' style='font-size: .88em; '>".translate('Alternate Language Names', $st, 'sys').":</th>";
		echo "<th width='16%' class='secondHeaderSelection' style='font-size: .92em; '>".translate('Language Code', $st, 'sys').":&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='images/downTriangle.png' /></th>";
		echo "<th width='17%' class='secondHeader' style='font-size: .88em; '>".translate('Country', $st, 'sys').":</th>";
	?>
	</tr>
	</table>
	<div id='canvas' class='LangNames'>
	<div id="wait" style="display:none; position:absolute; top:45%; left:50%; padding:2px; "><img src="images/wait.gif" width="64" height="64" /></div>
	<?php

	// order by language name or ISO code
	if ($which == 'Name') {
		if ($Letter != "")
			$query="SELECT DISTINCT LN_Temp.LN, scripture_main.* FROM LN_Temp, scripture_main WHERE scripture_main.ISO_ROD_index = LN_Temp.ISO_ROD_index AND LN_Temp.LN LIKE '$Letter%' ORDER BY LN_Temp.LN";
		else
			$query="SELECT DISTINCT LN_Temp.LN, scripture_main.* FROM LN_Temp, scripture_main WHERE scripture_main.ISO_ROD_index = LN_Temp.ISO_ROD_index ORDER BY LN_Temp.LN";
	}
	else {	// $which == 'Code'
		$query="SELECT DISTINCT LN_Temp.LN, scripture_main.* FROM LN_Temp, scripture_main WHERE scripture_main.ISO_ROD_index = LN_Temp.ISO_ROD_index ORDER BY LN_Temp.ISO, LN_Temp.ROD_Code";
	}
	$result = mysql_query($query);
	$num=mysql_num_rows($result);

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
			while ($i < $num) {
				if ($i % 2)
					$color = "f8fafa";
				else
					//$color = "f0f4f0";
					$color = "EEF1F2";
				$ISO = mysql_result($result,$i,"scripture_main.ISO");
				$ROD_Code = mysql_result($result,$i,"scripture_main.ROD_Code");
				$Variant_Code = mysql_result($result,$i,"scripture_main.Variant_Code");
				$ISO_ROD_index = mysql_result($result,$i,"scripture_main.ISO_ROD_index");
				$LN = mysql_result($result,$i,"LN_Temp.LN");
				echo "<tr style='background-color: #$color; '>";
				echo "<td width='30%'><a target='_top' href='$Scriptname?sortby=lang&name=$ISO&ROD_Code=$ROD_Code&Variant_Code=$Variant_Code'>$LN</a></td>";
				$query_alt="SELECT alt_lang_name FROM alt_lang_names WHERE ISO_ROD_index = '$ISO_ROD_index'";				// alt_lang_names
				$result_alt=mysql_query($query_alt);
				$alt_lang_names = '';
				if ($result_alt) {
					$num_alt=mysql_num_rows($result_alt);
					echo "<td width='35%'>";
					$i_alt=0;
					while ($i_alt < $num_alt) {
						if ($i_alt <> 0) {
							echo ", ";
							$alt_lang_names .= ", ";
						}
						$alt_lang_name=trim(mysql_result($result_alt,$i_alt,"alt_lang_name"));
						echo "$alt_lang_name";
						$alt_lang_names .= $alt_lang_name;
						$i_alt++;
					}
					echo "</td>";
				}
				else
					echo "<td width='35%'>&nbsp;</td>";
				//$ISO=trim(mysql_result($result,$i,"scripture_main.ISO"));											// ISO
				//$ROD_Code=trim(mysql_result($result,$i,"scripture_main.ROD_Code"));								// ROD_Code
				//$ISO_ROD_index=trim(mysql_result($result,$i,"scripture_main.ISO_ROD_index"));						// ISO_ROD_index
				echo "<td width='15%'>$ISO";
				$VD = "";
				if (!is_null($Variant_Code) && $Variant_Code != "") {
					$query = "SELECT Variant_Description FROM Variants WHERE Variant_Code = '$Variant_Code'";
					$resultVar=mysql_query($query) or die (translate('Query failed:', $st, 'sys') . ' ' . mysql_error() . "</body></html>");
					if ($resultVar > 0) {
						$VD = mysql_result($resultVar,0,"Variant_Description");
						include ("./include/00-MajorLanguageVariantCode.inc.php");
						echo "<br /><span style='font-style: italic; font-size: 8pt; '>($VD)</span>";
					}
				}		
				echo "</td>";
				$query="SELECT $SpecificCountry FROM ISO_countries, countries WHERE ISO_countries.ISO_ROD_index = '$ISO_ROD_index' AND ISO_countries.ISO_countries = countries.ISO_Country ORDER BY $SpecificCountry";
				$result_ISO_countries=mysql_query($query);
				$num_ISO_countries=mysql_num_rows($result_ISO_countries);
				$country = trim(mysql_result($result_ISO_countries,0,$SpecificCountry));						// name of the country in the language version
				for ($i_ISO_countries = 1; $i_ISO_countries < $num_ISO_countries; $i_ISO_countries++) {
					$country = $country.', '.trim(mysql_result($result_ISO_countries,$i_ISO_countries,$SpecificCountry));		// name of the country in the language version
				}
				echo "<td width='20%'>$country</td>";
				echo "</tr>";
				$i++;
			}
			?>
		    </table>
		</div>
	</div>
    <?php
	mysql_query("DROP TABLE LN_Temp"); 
		?>
		<script type="text/javascript"> 
		<!--
			$(document).ready(function() {
				var divHeight = 0;
				divHeight += document.getElementById("container").offsetHeight;
				divHeight += 18;
				document.getElementById("container").style.height = divHeight + "px";
				// if the table is long enough IE goes to dark black (blur and opacity). I don't know why.
				$("#container").dropShadow({left: 5, top: 5, blur: 2, opacity: 0.5, color: "black", swap: false});
			});
		-->
		</script>
	</div>
