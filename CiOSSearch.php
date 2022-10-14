<?php
/*
Created by Scott Starker

AJAX from LangSearch.js

Can't use $_SESSION because as AJAX PHP there is NO global variables with AJAX including $_SESSION. Although SESSION_ID would work slower than mine.

MySQL: utf8_general_ci flattens accents as well as lower-casing:
You must ensure that all parties (your app, mysql connection, your table or column) have set utf8 as charset.
- header('Content-Type: text/html; charset=utf-8'); (or <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />)
- ensure your mysqli connection use utf8 before any operation:
	- $mysqli->set_charset('utf8')
- create your table or column using utf8_general_ci
*/

/*
	These are defined at the end of $response:
	countryNotFound = "The country is not found."
	colCountries = "Countries"
*/

// display all of the language names, ROD codes and variant codes from a major and alternate languages names

if (isset($_GET['country'])) $TryCountry = $_GET['country']; else { die('Hack!'); }
// saltillo: ꞌ; U+A78C
if (preg_match("/[-. ,'ꞌ()a-záéíóúàèìòùÑñçãõâêîôûäëöüï&]/ui", $TryCountry)) {
}
else {
	die('Hack!');
}
if (isset($_GET['st'])) {
	$st = $_GET['st'];
	if (!preg_match('/^([a-z]{3})/', $st)) {
		die('Hach! 1');
	}
}
else {
	 die('Hack! 2');
}
$st = substr($st, 0, 3);

if (isset($_GET['SpecificCountry'])) {
	$SpecificCountry = $_GET['SpecificCountry'];
	if (!preg_match('/^([A-Za-z]+)/', $SpecificCountry, $match)) {
		die('Hach! 1b');
	}
}
else {
	 die('Hack! 2b');
}
$SpecificCountry = $match[1];

$response = '';
$hint = 0;

include './include/conn.inc.php';
$db = get_my_db();
include './translate/functions.php';							// translation function

// here 1/2 lines - check
$query="SELECT DISTINCT ISO_Country, $SpecificCountry FROM countries, ISO_countries, CellPhone WHERE countries.ISO_Country = ISO_countries.ISO_countries AND ISO_countries.ISO = CellPhone.ISO AND CellPhone.Cell_Phone_Title = 'iOS Asset Package' AND countries.$SpecificCountry LIKE '".$TryCountry."%' ORDER BY $SpecificCountry";														// create a prepared statement
if ($result = $db->query($query)) {
	while ($row = $result->fetch_assoc()) {
		$ISO_Country = $row['ISO_Country'];
		$Country = trim($row[$SpecificCountry]);
		if ($hint == 0) {
			$response = $Country.'|'.$ISO_Country;
			$hint = 1;
		}
		else {
			$response .= '<br />'.$Country.'|'.$ISO_Country;
		}
	}
}
	
if ($hint == 0) {
	$response = translate("This country is not found.", $st, "sys");
}
else {
	$response .= '<br />'.translate("Countries", $st, "sys");
}
echo $response;

?>