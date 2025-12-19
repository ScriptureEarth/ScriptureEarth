<?php
// Created by Scott Starker - 8/2024
// Updated by Scott Starker - 9/2025, 11/2025
/*
	fecth form countryChange.js - countryChange.php?cc=$_GET['cc']&m=(int)$_GET&y=(int)$_GET
		ISO_countries, downloads, html tables (<select> <option>)
*/

/*
	in phpMyAdmin SELECT DISTINCT `ISO_countries`.`ISO_ROD_index`, `ISO_countries`.`ISO`, `ISO_countries`.`ROD_Code`, `ISO_countries`.`Variant_Code` FROM `scripture`.`ISO_countries`, `awstats_gui_log`.`downloads` WHERE `scripture`.`ISO_countries`.`ISO_countries` = 'MX' AND `scripture`.`ISO_countries`.`ISO` = `awstats_gui_log`.`downloads`.`iso` AND `awstats_gui_log`.`downloads`.`month` = 8 AND `awstats_gui_log`.`downloads`.`year` = 2025 ORDER BY `scripture`.`ISO_countries`.`ISO`, `scripture`.`ISO_countries`.`ROD_Code`, `scripture`.`ISO_countries`.`Variant_Code`
		WILL WORK, but
	in countryChange.php IT WONT WORK!
*/

if (isset($_GET['cc'])) $CCode = $_GET['cc']; else { die('Did you make a mistake?'); }	// cc = countryCode
if (isset($_GET['m'])) $month = (int)$_GET['m']; else { die('Did you make a mistake?'); }
if ($month != 1 && $month != 2 && $month != 3 && $month != 4 && $month != 5 && $month != 6 && $month != 7 && $month != 8 && $month != 9 && $month != 10 && $month != 11 && $month != 12 && $month != 13) { die('Did you make a mistake?'); }	// only months 1-12 or 13 (year) are allowed
if (isset($_GET['y'])) $year = (int)$_GET['y']; else { die('Did you make a mistake?'); }
if ($year < 2020 || $year > 2100) { die('Did you make a mistake?'); }					// only years 2020-2100 are allowed

if (substr($_SERVER['REMOTE_ADDR'], 0, 7) == '192.168' || substr($_SERVER['REMOTE_ADDR'], 0, 9) == '127.0.0.1' || substr($_SERVER['REMOTE_ADDR'], 0, 9) == '172.20.0.') {	// Is the script local?
	$awstats_db = 'awstats_gui_log';
	$scripture_db = 'scripture';
}
else {
	$awstats_db = 'se_awstats_gui_log';
	$scripture_db = 'se_scripture';
}

require_once './include/conn.inc.php';													// connect to the scripture database
$db = get_my_db();
	
$query="SELECT `LN_English` FROM `LN_English` WHERE `ISO_ROD_index` = ?";
$LN_English_stmt=$db->prepare($query);
	
// list of languages per country
if ($month = 13) {
	$queryDownloads="SELECT DISTINCT `ISO_countries`.`ISO_ROD_index`, `ISO_countries`.`ISO`, `ISO_countries`.`ROD_Code`, `ISO_countries`.`Variant_Code` FROM `$scripture_db`.`ISO_countries` INNER JOIN `$awstats_db`.`downloads` ON `$scripture_db`.`ISO_countries`.`ISO_countries` = '$CCode' AND `$scripture_db`.`ISO_countries`.`ISO` = `$awstats_db`.`downloads`.`iso` AND `$awstats_db`.`downloads`.`year` = $year ORDER BY `$scripture_db`.`ISO_countries`.`ISO`, `$scripture_db`.`ISO_countries`.`ROD_Code`, `$scripture_db`.`ISO_countries`.`Variant_Code`";
	$queryHTML="SELECT DISTINCT `ISO_countries`.`ISO_ROD_index`, `ISO_countries`.`ISO`, `ISO_countries`.`ROD_Code`, `ISO_countries`.`Variant_Code` FROM `$scripture_db`.`ISO_countries` INNER JOIN `$awstats_db`.`html` ON `$scripture_db`.`ISO_countries`.`ISO_countries` = '$CCode' AND `$scripture_db`.`ISO_countries`.`ISO` = `$awstats_db`.`html`.`iso` AND `$awstats_db`.`html`.`year` = $year ORDER BY `$scripture_db`.`ISO_countries`.`ISO`, `$scripture_db`.`ISO_countries`.`ROD_Code`, `$scripture_db`.`ISO_countries`.`Variant_Code`";
}
else {
	$queryDownloads="SELECT DISTINCT `ISO_countries`.`ISO_ROD_index`, `ISO_countries`.`ISO`, `ISO_countries`.`ROD_Code`, `ISO_countries`.`Variant_Code` FROM `$scripture_db`.`ISO_countries` INNER JOIN `$awstats_db`.`downloads` ON `$scripture_db`.`ISO_countries`.`ISO_countries` = '$CCode' AND `$scripture_db`.`ISO_countries`.`ISO` = `$awstats_db`.`downloads`.`iso` AND `$awstats_db`.`downloads`.`month` = $month AND `$awstats_db`.`downloads`.`year` = $year ORDER BY `$scripture_db`.`ISO_countries`.`ROD_Code`, `$scripture_db`.`ISO_countries`.`Variant_Code`";
	$queryHTML="SELECT DISTINCT `ISO_countries`.`ISO_ROD_index`, `ISO_countries`.`ISO`, `ISO_countries`.`ROD_Code`, `ISO_countries`.`Variant_Code` FROM `$scripture_db`.`ISO_countries` INNER JOIN `$awstats_db`.`html` ON `$scripture_db`.`ISO_countries`.`ISO_countries` = '$CCode' AND `$scripture_db`.`ISO_countries`.`ISO` = `$awstats_db`.`html`.`iso` AND `$awstats_db`.`html`.`month` = $month AND `$awstats_db`.`html`.`year` = $year ORDER BY `$scripture_db`.`ISO_countries`.`ISO_ROD_index`, `$scripture_db`.`ISO_countries`.`ISO`, `$scripture_db`.`ISO_countries`.`ROD_Code`, `$scripture_db`.`ISO_countries`.`Variant_Code`";
}

$result_Downloads = $db->query($queryDownloads) or die('Query failed:  ' . $db->error . '</body></html>');
$result_HTML = $db->query($queryHTML) or die('Query failed:  ' . $db->error . '</body></html>');

if ($result_Downloads->num_rows === 0 && $result_HTML->num_rows === 0) {
	echo 'none';
}
else {
	$first = '{';
	$n = 0;
	while ($row_downloads = $result_Downloads->fetch_assoc()) {
		$ISO = $row_downloads['ISO'];
		$ROD_Code = $row_downloads['ROD_Code'];
		$Variant_Code = $row_downloads['Variant_Code'];
		$ISO_ROD_index = (int) $row_downloads['ISO_ROD_index'];
		$LN_English_stmt->bind_param("i", $ISO_ROD_index);
		$LN_English_stmt->execute();
		$result_LN_English = $LN_English_stmt->get_result();
		$ln_row = $result_LN_English->fetch_array();
		$LN = $ln_row['LN_English'];
		$n++;
		$first .= '"'.($n-1).'": {';
		$first .= '"iso":                       "'.$ISO.'",';
		$first .= '"rod":				        "'.$ROD_Code.'",';
		$first .= '"var":		    	        "'.$Variant_Code.'",';
		$first .= '"LN":		    	        "'.$LN.'",';
		$first .= '"idx":		                '.$ISO_ROD_index.'},';
	}

	while ($row_html = $result_HTML->fetch_assoc()) {
		$ISO = $row_html['ISO'];
		$ROD_Code = $row_html['ROD_Code'];
		$Variant_Code = $row_html['Variant_Code'];
		$ISO_ROD_index = (int) $row_html['ISO_ROD_index'];
		$LN_English_stmt->bind_param("i", $ISO_ROD_index);
		$LN_English_stmt->execute();
		$result_LN_English = $LN_English_stmt->get_result();
		$ln_row = $result_LN_English->fetch_array();
		$LN = $ln_row['LN_English'];
		$n++;
		$first .= '"'.($n-1).'": {';
		$first .= '"iso":                       "'.$ISO.'",';
		$first .= '"rod":				        "'.$ROD_Code.'",';
		$first .= '"var":		    	        "'.$Variant_Code.'",';
		$first .= '"LN":		    	        "'.$LN.'",';
		$first .= '"idx":		                '.$ISO_ROD_index.'},';
	}

	$first = rtrim($first, ',');
	$first .= '}';

	//echo $first;
	//exit;

	$marks = [];
	$marks = json_decode($first);														// string to JSON array

	//header('Content-Type: application/json');											// instead of <pre></pre>
	// An associative array
	//$json_string = json_encode($marks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
	$json_string = json_encode($marks, JSON_UNESCAPED_UNICODE);							// JSON array into string in order to pass it to the js
	//echo '<pre>'.$json_string.'</pre>';
	echo $json_string;
}
?>