<?php
/*
	Created by Scott Starker
	AJAX
*/
$st = "eng";
if (isset($_GET["st"])) {
	$st = trim($_GET["st"]);
	if (!preg_match('/^[a-z]{3}/', $st)) {
		die ('‘st’ is empty.');
	}
	$st = substr($st, 0, 3);
}

	$SpecificCountry = $_GET['SpecificCountry'];

	include './include/conn.inc.php';
	$db = get_my_db();
	include './translate/functions.php';							// translation function
	
	$responseText = '';
// // here 1/2 lines - check
	$query="SELECT DISTINCT ISO_Country, $SpecificCountry FROM countries, ISO_countries, CellPhone WHERE countries.ISO_Country = ISO_countries.ISO_countries AND ISO_countries.ISO = CellPhone.ISO AND ISO_countries.ROD_Code = CellPhone.ROD_Code AND ISO_countries.Variant_Code = CellPhone.Variant_Code AND CellPhone.Cell_Phone_Title = 'iOS Asset Package' ORDER BY $SpecificCountry";														// create a prepared statement
	$result=$db->query($query) or die (translate('Query failed:', $st, 'sys') . ' ' . $db->error . '</body></html>');
	while ($row = $result->fetch_array()) {
		$Country = trim($row[$SpecificCountry]);
		$ISO_Country = $row['ISO_Country'];
		$responseText .= $Country . '|' . $ISO_Country . '<br />';
	}
	echo $responseText;
?>
