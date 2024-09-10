<?php
// 00-CountriesList.php
// Start the session
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Countries List</title>
<link rel="stylesheet" type="text/css" href="_css/Scripture_Index.css" />
<style type="text/css">
	/* from Scripture-Index.css */
	a.country, a.country:hover, a.country:link, a.country:active {
		color: navy;
		font-size: 11pt;
		text-decoration: underline;
		font-weight: normal;
		line-height: 26px;
		margin: 0 0 0 10px;
		padding: 3px 5px 3px 5px;
	}
</style>
</head>
<body style='background-image: url(../images/grayNav.png); background-repeat: repeat-x; background-color: #B0B8C1; min-width: 200px; '>
<?php
	require_once './include/conn.inc.php';								// connect to the database named 'scripture'
	$db = get_my_db();
	include 'translate/functions.php';

	if (!isset($_GET["st"])) {
		die ("<body>'st' is empty.</body></html>");
	}
	if (!isset($_GET["GetName"])) {
		die ("<body>'GetName' " . translate('is empty.', $st, 'sys') . "</body></html>");
	}
	if (!isset($_GET["Location"])) {
		die ("<body>'Location' " . translate('is empty.', $st, 'sys') . "</body></html>");
	}
	if (!isset($_GET["Scriptname"])) {
		die ("<body>'Scriptname' " . translate('is empty.', $st, 'sys') . "</body></html>");
	}

	$st = $_GET["st"];
	if (!preg_match('/^[a-z]{3}/', $st)) {
		die ('‘st’ is empty.</body></html>');
	}
	$Location = $_GET["Location"];
	$GetName = $_GET["GetName"];
	if (!preg_match('/^[a-zA-Z]{1,3}/', $GetName)) {
		die ('‘GetName’ ' . translate('is empty', $st, 'sys') . '.</body></html>');
	}
	$Scriptname = $_GET["Scriptname"];

	/*
		from 'translations' tables:
			'en' (
				[0] => eng							translation_code
				[1] => English						name
				[2] => 00eng.php					nav_fileName
				[3] => 1							ln_number
				[4] => i							ln_abbreviation
			)
			'nl' (
				...
			)
	*/

	$languages = array_column($_SESSION['nav_ln_array'], 1, 0);		// an array: [0] => 1 - e.g. ['eng'] => 'English', etc.
	//print_r($languages);
	//echo '<br />' . $languages[$st] . '<br />';
	$MajorLanguage = "LN_". $languages[$st];
	$SpecificCountry = $languages[$st];

	/*
		*************************************************************************************
			Get the list of all countries to display.
		*************************************************************************************
	*/
	//$query="SELECT DISTINCT countries.English, ISO_countries.ISO_countries FROM scripture_main, countries, ISO_countries WHERE countries.ISO_Country = ISO_countries.ISO_countries AND ISO_countries.ISO = scripture_main.ISO AND ISO_countries.ROD_Code = scripture_main.ROD_Code ORDER BY countries.English";
	$query="SELECT DISTINCT `countries`.$SpecificCountry, ISO_countries.ISO_countries FROM scripture_main, countries, ISO_countries WHERE countries.ISO_Country = ISO_countries.ISO_countries AND ISO_countries.ISO_ROD_index = scripture_main.ISO_ROD_index ORDER BY $SpecificCountry";
	$result=$db->query($query) or die (translate('Query failed:', $st, 'sys') . ' ' . $db->error . "</body></html>");
	if (!$result) {
		die (translate('The countries are not found.', $st, 'sys') . "</body></html>");
	}
	//$num=$result->num_rows;
	//$i=0;
	echo "<div style=''>";
	echo "<div class='countryMain'><br />".translate('Country', $st, 'sys')."</div>";
	echo "<br />";
	//echo "<table width='100%' style='text-align: left; margin: 0px; padding: 0px; '>";
	//echo "<tr style='text-align: left; margin: 0px; padding: 0px; '><td width='100%' style='text-align: left; margin: 0px; padding: 0px; '>";
	echo "<p style='text-align: left; margin: 0; padding: 0; '>";
	if ($GetName == "all") {
		echo "<a class='country' style='color: #A82120; font-weight: bold; text-decoration: none; ' href='$Scriptname?sortby=country&name=all' target='_top'>".translate('All', $st, 'sys')."</a>";
	}
	else {
		echo "<a class='country' href='$Scriptname?sortby=country&name=all' target='_top'>".translate('All', $st, 'sys')."</a>";
	}
	//echo "</td></tr>";
	echo "</p>";
	$countryTemp = $SpecificCountry;
	//if (strpos("$SpecificCountry", '.')) $countryTemp = substr("$SpecificCountry", strpos("$SpecificCountry", '.')+1);					// In case there's a "." in the "country"
	while ($r = $result->fetch_array()) {
		$country=$r["$countryTemp"];
		$country = str_replace(' ', '&nbsp;', $country); 
		$ISO_Country=$r['ISO_countries'];
		//echo "<tr style='text-align: left; margin: 0px; padding: 0px; '>";
		//echo "<td width='100%' style='text-align: left; margin: 0px; padding: 0px; '>";
		echo "<p style='text-align: left; margin: 2px 0; padding: 0; '>";
		if ($GetName == $ISO_Country) {
			if ($Location == "Country") {
				echo "<a class='country' style='color: #A82120; font-weight: bold; text-decoration: none; ' href='$Scriptname?sortby=country&name=$ISO_Country' target='_top'>$country</a>";
			}
			else {		/* $Location == "Language" */
				echo "<a class='country' style='color: #A82120; ' href='$Scriptname?sortby=country&name=$ISO_Country' target='_top'>$country</a>";
			}
		}
		else {
			echo "<a class='country' href='$Scriptname?sortby=country&name=$ISO_Country' target='_top'>$country</a>";
		}
		//echo "</td>";
		//echo "</tr>";
		echo "</p>";
		//$i++;
	}
	//echo "</table>";
	echo "</div>";
?>
</body>
</html>