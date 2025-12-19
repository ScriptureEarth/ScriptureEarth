<?php
// Created by Scott Starker - 8/2024
// Updated by Scott Starker - 9/2025, 11/2025
/*
	fetch form AWStatsScripts.js => selectCountries.php?m="+month+"&y="+year
		return: $country . '^' . $countryCode . '|'
*/

if (isset($_GET['m'])) $month = (int)$_GET['m']; else { die('Did you make a mistake?'); }
if ($month != 1 && $month != 2 && $month != 3 && $month != 4 && $month != 5 && $month != 6 && $month != 7 && $month != 8 && $month != 9 && $month != 10 && $month != 11 && $month != 12 && $month != 13) { die('Did you make a mistake?'); }	// only months 1-12 or 13 (year) are allowed
if (isset($_GET['y'])) $year = (int)$_GET['y']; else { die('Did you make a mistake?'); }
if ($year < 2020 || $year > 2100) { die('Did you make a mistake?'); }		// only years 2020-2100 are allowed

if (substr($_SERVER['REMOTE_ADDR'], 0, 7) == '192.168' || substr($_SERVER['REMOTE_ADDR'], 0, 9) == '127.0.0.1' || substr($_SERVER['REMOTE_ADDR'], 0, 9) == '172.20.0.') {	// Is the script local?
	//$awstats_db = 'awstats_gui_log';
	$scripture_db = 'scripture';
}
else {
	//$awstats_db = 'se_awstats_gui_log';
	$scripture_db = 'se_scripture';
}

require_once './include/conn.inc.php';										// connect to the database named 'scripture'
$db = get_my_db();

$second = '';
	
$query = 'SELECT DISTINCT `ISO_countries`.`ISO_countries`, `countries`.`English` FROM `ISO_countries` INNER JOIN `countries` ON `ISO_countries`.`ISO_countries` = `countries`.`ISO_country` ORDER BY `countries`.`English`';
$result_countries = $db->query($query) or die('Query failed:  ' . $db->error);
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