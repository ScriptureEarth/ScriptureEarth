<?php
/*
	Created by Scott Starker
	AJAX
*/
	$st = $_GET["st"];
	$SpecificCountry = $_GET['SpecificCountry'];

	include './include/conn.inc.php';
	$db = get_my_db();
	include './translate/functions.php';							// translation function
	
	$responseText = '';
	$query="SELECT DISTINCT ISO_Country, $SpecificCountry FROM countries, ISO_countries WHERE countries.ISO_Country = ISO_countries.ISO_countries ORDER BY $SpecificCountry";														// create a prepared statement
	$result=$db->query($query) or die (translate('Query failed:', $st, 'sys') . ' ' . $db->error . '</body></html>');
	while ($row = $result->fetch_array()) {
		$Country = trim($row[$SpecificCountry]);
		$ISO_Country = $row['ISO_Country'];
		$responseText .= $Country . '|' . $ISO_Country . '<br />';
	}
	echo $responseText;
?>
