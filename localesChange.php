<?php
// Created by Scott Starker - 8/2024
// Updated by Scott Starker - 9/2025, 11/2025

/*
	fetch from AWStatsScripts.js => localesChange.php?m="+month+"&y="+year - locales tables
*/
if (isset($_GET['m'])) $month = (int)$_GET['m']; else { die('Did you make a mistake?'); }
if ($month != 1 && $month != 2 && $month != 3 && $month != 4 && $month != 5 && $month != 6 && $month != 7 && $month != 8 && $month != 9 && $month != 10 && $month != 11 && $month != 12 && $month != 13) { die('Did you make a mistake?'); }	// only months 1-12 or 13 (year) are allowed
if (isset($_GET['y'])) $year = (int)$_GET['y']; else { die('Did you make a mistake?'); }
if ($year < 2020 || $year > 2100) { die('Did you make a mistake?'); }					// only years 2020-2100 are allowed

if (substr($_SERVER['REMOTE_ADDR'], 0, 7) == '192.168' || substr($_SERVER['REMOTE_ADDR'], 0, 9) == '127.0.0.1' || substr($_SERVER['REMOTE_ADDR'], 0, 9) == '172.20.0.') {	// Is the script local?
	$awstats_db = 'awstats_gui_log';
	//$scripture_db = 'scripture';
}
else {
	$awstats_db = 'se_awstats_gui_log';
	//$scripture_db = 'se_scripture';
}

//require_once './include/conn.inc.php';													// connect to the database named 'scripture'
//$db = get_my_db();
require_once './include/conn.inc.AWStats.php';											// connect to the AWStats database
$db = get_my_AWStatsDB();																// connect to the AWStats database named 'awstats_gui_log' or 'se_awstats_gui_log'

if ($month == 13) {																		// a year				
	$query="SELECT `locales`, `lPages`, `lBandwidth` FROM $awstats_db.`locales` WHERE $awstats_db.`locales`.`year` = $year GROUP BY $awstats_db.`locales`.locales ORDER BY $awstats_db.`locales`.`lBandwidth` DESC";
}
else {
	$query="SELECT `locales`, `lPages`, `lBandwidth` FROM $awstats_db.`locales` WHERE $awstats_db.`locales`.`month` = $month AND $awstats_db.`locales`.`year` = $year ORDER BY $awstats_db.`locales`.`lBandwidth` DESC";
}
$result_locales = $db->query($query) or die('Query failed:  ' . $db->error . '</body></html>');

if ($result_locales->num_rows == 0) {
	echo 'none';
}
else {
	$lChange = '{';
	$n = 0;
	$c = 0;
	while ($row_locales = $result_locales->fetch_assoc()) {
		$n++;
		$c++;
		if ($c <= 25) {
			$locales = $row_locales['locales'];
			$pages = (int) $row_locales['lPages'];
			$bandwidth = (int) $row_locales['lBandwidth'];
			$lChange .= '"'.($n-1).'": {';
			$lChange .= '"locales":                       	"'.$locales.'",';
			$lChange .= '"pages":				        	'.$pages.',';
			$lChange .= '"bandwidth":		    	        '.$bandwidth.'},';
		}
	}
	$lChange = rtrim($lChange, ',');
	$lChange .= '}';

	//echo $lChange;
	//exit;

	$marksThree = [];
	$marksThree = json_decode($lChange);												// string to JSON array

	header('Content-Type: application/json');											// instead of <pre></pre>
	// An associative array
	//$json_string = json_encode($marks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
	$json_string_Three = json_encode($marksThree, JSON_UNESCAPED_UNICODE);				// JSON array into string in order to pass it to the js
	//echo '<pre>'.$json_string.'</pre>';
	echo $json_string_Three;
}
?>