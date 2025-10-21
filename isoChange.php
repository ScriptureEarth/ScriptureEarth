<?php

/*
	AJAX form AWStatsScripts.js - isoChange.php => downloads and html tables
*/

if (isset($_GET['i'])) $langGen = $_GET['i']; else { die('Hack!'); }	// 'idx iso rod var'
if (isset($_GET['m'])) $month = $_GET['m']; else { die('Hack!'); }		// month
if (isset($_GET['y'])) $year = $_GET['y']; else { die('Hack!'); }		// year

$idx = '';																// = idx, iso, rod, var
$iso = '';
$rod = '';
$variant = '';

$isoArray = explode(' ', $langGen);										// split a string by a string
$idx = $isoArray[0];
$iso = $isoArray[1];
$rod = $isoArray[2];
if (count($isoArray) == 4) {
	$variant = $isoArray[3];
}

if (substr($_SERVER['REMOTE_ADDR'], 0, 7) == '192.168' || substr($_SERVER['REMOTE_ADDR'], 0, 9) == '127.0.0.1') {	// Is the script local?
	$awstats_db = 'awstats_gui_log';
	$scripture_db = 'scripture';
}
else {
	$awstats_db = 'se_awstats_gui_log';
	$scripture_db = 'se_scripture';
}

require_once './include/conn.inc.php';									// connect to the database named 'scripture'
$db = get_my_db();
	
// languages names per ISO
// get just ...-timing.txt (sab)
if ($month == 13) {														// a year
	$query="SELECT `extension`, SUM(`dHit`) `Hits`, SUM(`dBandwidth`) `Bandwidth` FROM `$awstats_db`.`downloads` WHERE `$awstats_db`.`downloads`.`iso` = '$iso' AND `$awstats_db`.`downloads`.`year` = $year AND `$awstats_db`.`downloads`.`isoPlus` <> '' AND `$awstats_db`.`downloads`.`extension` = 'txt' AND `$awstats_db`.`downloads`.`download` LIKE '%-timing.txt' GROUP BY `$awstats_db`.`downloads`.`extension` ORDER BY `$awstats_db`.`downloads`.`extension`";
}
else {
	$query="SELECT `extension`, SUM(`dHit`) `Hits`, SUM(`dBandwidth`) `Bandwidth` FROM `$awstats_db`.`downloads` WHERE `$awstats_db`.`downloads`.`iso` = '$iso' AND `$awstats_db`.`downloads`.`month` = $month AND `$awstats_db`.`downloads`.`year` = $year AND `$awstats_db`.`downloads`.`isoPlus` <> '' AND `$awstats_db`.`downloads`.`extension` = 'txt' AND `$awstats_db`.`downloads`.`download` LIKE '%-timing.txt' GROUP BY `$awstats_db`.`downloads`.`extension` ORDER BY `$awstats_db`.`downloads`.`extension`";
}
$result_txt = $db->query($query) or die('Query failed:  ' . $db->error . '</body></html>');

// get everything
if ($month == 13) {														// a year
	$query="SELECT `extension`, SUM(`dHit`) `Hits`, SUM(`dBandwidth`) `Bandwidth` FROM `$awstats_db`.`downloads` WHERE `$awstats_db`.`downloads`.`iso` = '$iso' AND `$awstats_db`.`downloads`.`year` = $year AND `$awstats_db`.`downloads`.`isoPlus` = '' GROUP BY `$awstats_db`.`downloads`.`extension` ORDER BY `$awstats_db`.`downloads`.`extension`";
}
else {
	$query="SELECT `extension`, SUM(`dHit`) `Hits`, SUM(`dBandwidth`) `Bandwidth` FROM `$awstats_db`.`downloads` WHERE `$awstats_db`.`downloads`.`iso` = '$iso' AND `$awstats_db`.`downloads`.`month` = $month AND `$awstats_db`.`downloads`.`year` = $year AND `$awstats_db`.`downloads`.`isoPlus` = '' GROUP BY `$awstats_db`.`downloads`.`extension` ORDER BY `$awstats_db`.`downloads`.`extension`";
}

$extension = '';
$numOfHits = 0;
$numOfBandwidth = 0;
$exten = '';
$numHits = 0;
$numBand = 0;

$result_iso = $db->query($query) or die('Query failed:  ' . $db->error . '</body></html>');
if ($result_iso->num_rows === 0 && $result_txt->num_rows === 0) {
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
	$first = '{';
	$n = 0;
	while ($row_iso = $result_iso->fetch_assoc()) {											// iterate through "get everything"
		$n++;
		$extension = $row_iso['extension'];
		$numOfHits = (int) $row_iso['Hits'];
		$numOfBandwidth = (int) $row_iso['Bandwidth'];
		$first .= '"'.($n-1).'": {';
		$first .= '"extension":                     	"'.$extension.'",';
		$first .= '"numOfHits":				        	'.$numOfHits.',';
		$first .= '"numOfBandwidth":		    	    '.$numOfBandwidth.'},';
	}

	if ($result_txt->num_rows >= 1) {														// fetch "get just"; 'txt' and '%-timing.txt'
		$row_txt = $result_txt->fetch_assoc();
		$n++;
		$extension = $row_txt['extension'];
		$numOfHits = (int) $row_txt['Hits'];
		$numOfBandwidth = (int) $row_txt['Bandwidth'];
		$first .= '"'.($n-1).'": {';
		$first .= '"extension":                     	"'.$extension.'|",';				// "extension": "txt|"
		$first .= '"numOfHits":				        	'.$numOfHits.',';
		$first .= '"numOfBandwidth":		    	    '.$numOfBandwidth.'},';
	}
	
	$first = rtrim($first, ',');
	$first .= '}';

	$marks = [];
	$marks = json_decode($first);										// string to JSON array
	
	// An associative array
	//$json_string = json_encode($marks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
	$json_string = json_encode($marks, JSON_UNESCAPED_UNICODE);			// JSON array into string in order to pass it to the js


	$json_stringTwo = '';
	if ($month == 13) {													// a year
		$query="SELECT DISTINCT `extension`, SUM(`view`) `sumView` FROM $awstats_db.`html` WHERE $awstats_db.`html`.`iso` = '$iso' AND $awstats_db.`html`.`year` = $year GROUP BY $awstats_db.`html`.`extension` ORDER BY $awstats_db.`html`.`view`";
	}
	else {
		$query="SELECT DISTINCT `extension`, SUM(`view`) `sumView` FROM $awstats_db.`html` WHERE $awstats_db.`html`.`iso` = '$iso' AND $awstats_db.`html`.`month` = $month AND $awstats_db.`html`.`year` = $year GROUP BY $awstats_db.`html`.`extension` ORDER BY $awstats_db.`html`.`view`";
	}
	$result_html = $db->query($query) or die('Query failed:  ' . $db->error . '</body></html>');
	if ($result_html->num_rows == 0) {
		$second = '@none';
	}
	else {
		$second = '{';
		$n=0;
		while ($row_html = $result_html->fetch_assoc()) {
			$n++;
			$extension = $row_html['extension'];
			$sumView = (int) $row_html['sumView'];
			$second .= '"'.($n-1).'": {';
			$second .= '"extension":                     	"'.$extension.'",';
			$second .= '"sumView":				        	'.$sumView.'},';
		}
		$second = rtrim($second, ',');
		$second .= '}';
	
		$marksTwo = [];
		$marksTwo = json_decode($second);								// string to JSON array
		
		// An associative array
		//$json_string = json_encode($marks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
		$json_stringTwo = json_encode($marksTwo, JSON_UNESCAPED_UNICODE);	// JSON array into string in order to pass it to the js
	}
	
	//	echo $second;
	//	exit;
	
	if ($second != '@none') {
		$json_string = $json_string . '@' . $json_stringTwo;
	}
	else {
	}
	
	//header('Content-Type: application/json');							// instead of <pre></pre>
	//echo '<pre>'.$json_string.'</pre>';
	echo $json_string;
}
?>