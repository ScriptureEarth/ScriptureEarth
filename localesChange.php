<?php

/*
	AJAX form AWStatsScripts.js - locales tables
*/
if (isset($_GET['m'])) $month = $_GET['m']; else { die('Hack!'); }
if (isset($_GET['y'])) $year = $_GET['y']; else { die('Hack!'); }

if (substr($_SERVER['REMOTE_ADDR'], 0, 7) == '192.168' || substr($_SERVER['REMOTE_ADDR'], 0, 9) == '127.0.0.1') {	// Is the script local?
	$awstats_db = 'awstats_gui_log';
	$scripture_db = 'scripture';
}
else {
	$awstats_db = 'se_awstats_gui_log';
	$scripture_db = 'se_scripture';
}

require_once './include/conn.inc.php';													// connect to the database named 'scripture'
$db = get_my_db();

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