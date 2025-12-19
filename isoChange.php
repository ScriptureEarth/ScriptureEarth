<?php
// Created by Scott Starker - 8/2024
// Updated by Scott Starker - 9/2025, 11/2025
/*
	Two different SELECTs: downloads and html tables. Each separated by "@"!

	fetch form AWStatsScripts.js - isoChange.php?i="+langArray[1]+"&m="+month+"&y="+year) => downloads and html tables. Each separated by "@"!
*/

if (isset($_GET['i'])) $langGen = $_GET['i']; else { die('Did you make a mistake?'); }	// 'idx iso rod var'
if (isset($_GET['m'])) $month = (int)$_GET['m']; else { die('Did you make a mistake?'); }
if ($month != 1 && $month != 2 && $month != 3 && $month != 4 && $month != 5 && $month != 6 && $month != 7 && $month != 8 && $month != 9 && $month != 10 && $month != 11 && $month != 12 && $month != 13) { die('Did you make a mistake?'); }	// only months 1-12 or 13 (year) are allowed
if (isset($_GET['y'])) $year = (int)$_GET['y']; else { die('Did you make a mistake?'); }
if ($year < 2020 || $year > 2100) { die('Did you make a mistake?'); }	// only years 2020-2100 are allowed

$idx = '';																// = idx, iso, rod, var
$iso = $langGen;
$rod = '';
$variant = '';

/*$isoArray = explode(' ', $langGen);									// split a string by a string
$idx = $isoArray[0];
$iso = $isoArray[1];
$rod = $isoArray[2];
if (count($isoArray) == 4) {
	$variant = $isoArray[3];
}*/

if (substr($_SERVER['REMOTE_ADDR'], 0, 7) == '192.168' || substr($_SERVER['REMOTE_ADDR'], 0, 9) == '127.0.0.1' || substr($_SERVER['REMOTE_ADDR'], 0, 9) == '172.20.0.') {	// Is the script local?
	$awstats_db = 'awstats_gui_log';
	//$scripture_db = 'scripture';
}
else {
	$awstats_db = 'se_awstats_gui_log';
	//$scripture_db = 'se_scripture';
}

require_once './include/conn.inc.AWStats.php';							// connect to the database named 'scripture'
$db = get_my_AWStatsDB();

// languages names per ISO
// get just txt
// get just pdf
// get just ...-timing.txt (sab)
if ($month == 13) {														// a year
	$queryTXT="SELECT `extension`, SUM(`dHit`) `Hits` FROM `$awstats_db`.`downloads` WHERE `$awstats_db`.`downloads`.`iso` = '$iso' AND `$awstats_db`.`downloads`.`year` = $year AND `$awstats_db`.`downloads`.`isoPlus` <> '' AND `$awstats_db`.`downloads`.`extension` = 'txt' AND `$awstats_db`.`downloads`.`download` LIKE '%-timing.txt' GROUP BY `$awstats_db`.`downloads`.`extension` ORDER BY `$awstats_db`.`downloads`.`iso`";
	$queryISO="SELECT `extension`, SUM(`dHit`) `Hits` FROM `$awstats_db`.`downloads` WHERE `$awstats_db`.`downloads`.`iso` = '$iso' AND `$awstats_db`.`downloads`.`year` = $year AND `$awstats_db`.`downloads`.`isoPlus` = '' GROUP BY `$awstats_db`.`downloads`.`extension` ORDER BY `$awstats_db`.`downloads`.`extension`";
	$queryHTML="SELECT `extension`, SUM(`view`) `Hits` FROM `$awstats_db`.`html` WHERE `$awstats_db`.`html`.`iso` = '$iso' AND `$awstats_db`.`html`.`year` = $year GROUP BY `$awstats_db`.`html`.`extension` ORDER BY `$awstats_db`.`html`.`view`";
}
else {
	$queryTXT="SELECT `extension`, SUM(`dHit`) `Hits` FROM `$awstats_db`.`downloads` WHERE `$awstats_db`.`downloads`.`iso` = '$iso' AND `$awstats_db`.`downloads`.`month` = $month AND `$awstats_db`.`downloads`.`year` = $year AND `$awstats_db`.`downloads`.`isoPlus` <> '' AND `$awstats_db`.`downloads`.`extension` = 'txt' AND `$awstats_db`.`downloads`.`download` LIKE '%-timing.txt' GROUP BY `$awstats_db`.`downloads`.`extension` ORDER BY `$awstats_db`.`downloads`.`iso`";
	$queryISO="SELECT `extension`, SUM(`dHit`) `Hits` FROM `$awstats_db`.`downloads` WHERE `$awstats_db`.`downloads`.`iso` = '$iso' AND `$awstats_db`.`downloads`.`month` = $month AND `$awstats_db`.`downloads`.`year` = $year AND `$awstats_db`.`downloads`.`isoPlus` = '' GROUP BY `$awstats_db`.`downloads`.`extension` ORDER BY `$awstats_db`.`downloads`.`extension`";
	$queryHTML="SELECT `extension`, SUM(`view`) `Hits` FROM `$awstats_db`.`html` WHERE `$awstats_db`.`html`.`iso` = '$iso' AND `$awstats_db`.`html`.`month` = $month AND `$awstats_db`.`html`.`year` = $year GROUP BY `$awstats_db`.`html`.`extension` ORDER BY `$awstats_db`.`html`.`view`";
}

$result_txt = $db->query($queryTXT) or die('Query failed:  ' . $db->error . '</body></html>');
$result_iso = $db->query($queryISO) or die('Query failed:  ' . $db->error . '</body></html>');
$result_html = $db->query($queryHTML) or die('Query failed:  ' . $db->error . '</body></html>');

$extension = '';
$numOfHits = 0;
// $numOfBandwidth = 0;
$exten = '';
$numHits = 0;
$numBand = 0;
if ($result_iso->num_rows === 0 && $result_txt->num_rows === 0 && $result_html->num_rows === 0) {
	echo 'none';
}
else {
	/*
		apk
		docx
		epub
		jar
		mp3
		mp4
		pdf
		txt
		webm
	*/
	//echo $result_iso->num_rows . ' ' . $result_txt->num_rows . "\n";

	$first = '{';
	$n = 0;
	while ($row_iso = $result_iso->fetch_assoc()) {						// iterate through "get everything"
		$n++;
		$extension = $row_iso['extension'];
		$numOfHits = (int) $row_iso['Hits'];
		//$numOfBandwidth = (int) $row_iso['Bandwidth'];
		$first .= '"'.($n-1).'": {';
		$first .= '"extension":                     	"'.$extension.'",';
		$first .= '"accesses":				        	'.$numOfHits.'},';
		//$first .= '"numOfBandwidth":		    	    '.$numOfBandwidth.'},';
	}

	while ($row_txt = $result_txt->fetch_assoc()) {						// fetch "get just"; 'txt' and '%-timing.txt'
		$n++;
		$extension = $row_txt['extension'];
		$numOfHits = (int) $row_txt['Hits'];
		// $numOfBandwidth = (int) $row_txt['Bandwidth'];
		$first .= '"'.($n-1).'": {';
		$first .= '"extension":                     	"'.$extension.'",';				// "extension": "txt|"
		$first .= '"accesses":				        	'.$numOfHits.'},';
		// $first .= '"numOfBandwidth":		    	    '.$numOfBandwidth.'},';
	}

	while ($row_html = $result_html->fetch_assoc()) {
		$n++;
		$extension = $row_html['extension'];
		$sumView = (int) $row_html['Hits'];
		$first .= '"'.($n-1).'": {';
		$first .= '"extension":                     	"'.$extension.'",';
		$first .= '"accesses":				        	'.$sumView.'},';
	}
	
	$first = rtrim($first, ',');
	$first .= '}';

	$marks = [];
	$marks = json_decode($first);										// string to JSON array
	
	// An associative array
	//$json_string = json_encode($marks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
	$json_string = json_encode($marks, JSON_UNESCAPED_UNICODE);			// JSON array into string in order to pass it to the js
	
	//header('Content-Type: application/json');							// instead of <pre></pre>
	//echo '<pre>'.$json_string.'</pre>';
	echo $json_string;
}
?>