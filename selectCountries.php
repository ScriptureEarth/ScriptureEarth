<?php

/*
	AJAX form AWStatsScripts.js => $country . '^' . $countryCode . '|'
*/

if (isset($_GET['m'])) $month = $_GET['m']; else { die('Hack!'); }
if (isset($_GET['y'])) $year = $_GET['y']; else { die('Hack!'); }

require_once './include/conn.inc.php';										// connect to the database named 'scripture'
$db = get_my_db();

$second = '';
	
$query = 'SELECT DISTINCT `ISO_countries`.`ISO_countries`, `countries`.`English` FROM `ISO_countries` INNER JOIN `countries` ON `ISO_countries`.`ISO_countries` = `countries`.`ISO_country` ORDER BY `countries`.`English`';
$result_countries = $db->query($query) or die('Query failed:  ' . $db->error . '</body></html>');
if ($result_countries->num_rows == 0) {
	echo 'none';
}
else {
	while ($row_countries = $result_countries->fetch_assoc()) {
		$country = $row_countries['English'];
		$countryCode = $row_countries['ISO_countries'];
		$second .= $country . '^' . $countryCode . '|';
	}
	$second = rtrim($second, '|');
	echo $second;
}