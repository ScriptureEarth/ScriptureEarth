<?php

/*
	AJAX form countryChange.js - countryChange.php => ISO_countries and downloads tables (<select> <option>)
*/

/*
	in phpMyAdmin SELECT DISTINCT `ISO_countries`.`ISO_ROD_index`, `ISO_countries`.`ISO`, `ISO_countries`.`ROD_Code`, `ISO_countries`.`Variant_Code` FROM `scripture`.`ISO_countries`, `awstats_gui_log`.`downloads` WHERE `scripture`.`ISO_countries`.`ISO_countries` = 'MX' AND `scripture`.`ISO_countries`.`ISO` = `awstats_gui_log`.`downloads`.`iso` AND `awstats_gui_log`.`downloads`.`month` = 8 AND `awstats_gui_log`.`downloads`.`year` = 2025 ORDER BY `scripture`.`ISO_countries`.`ISO`, `scripture`.`ISO_countries`.`ROD_Code`, `scripture`.`ISO_countries`.`Variant_Code`
		WILL WORK, but
	in countryChange.php IT WONT WORK!
*/

if (isset($_GET['cc'])) $CCode = $_GET['cc']; else { die('Hack!'); }					// cc = countryCode
if (isset($_GET['m'])) $month = $_GET['m']; else { die('Hack!'); }
if (isset($_GET['y'])) $year = $_GET['y']; else { die('Hack!'); }

if (substr($_SERVER['REMOTE_ADDR'], 0, 7) == '192.168' || substr($_SERVER['REMOTE_ADDR'], 0, 9) == '127.0.0.1') {				// Is the script local?
	$awstats_db = 'awstats_gui_log';
	$scripture_db = 'scripture';
}
else {
	$awstats_db = 'se_awstats_gui_log';
	$scripture_db = 'se_scripture';
}

require_once './include/conn.inc.php';													// connect to the database named 'scripture'
$db = get_my_db();
	
$query="SELECT `LN_English` FROM `LN_English` WHERE `ISO_ROD_index` = ?";
$LN_English_stmt=$db->prepare($query);
	
// list of languages per country
if ($month = 13) {
	$query="SELECT DISTINCT `ISO_countries`.`ISO_ROD_index`, `ISO_countries`.`ISO`, `ISO_countries`.`ROD_Code`, `ISO_countries`.`Variant_Code` FROM `$scripture_db`.`ISO_countries` INNER JOIN `$awstats_db`.`downloads` ON `$scripture_db`.`ISO_countries`.`ISO_countries` = '$CCode' AND `$scripture_db`.`ISO_countries`.`ISO` = `$awstats_db`.`downloads`.`iso` AND `$awstats_db`.`downloads`.`year` = $year ORDER BY `$scripture_db`.`ISO_countries`.`ISO`, `$scripture_db`.`ISO_countries`.`ROD_Code`, `$scripture_db`.`ISO_countries`.`Variant_Code`";
}
else {
	$query="SELECT DISTINCT `ISO_countries`.`ISO_ROD_index`, `ISO_countries`.`ISO`, `ISO_countries`.`ROD_Code`, `ISO_countries`.`Variant_Code` FROM `$scripture_db`.`ISO_countries` INNER JOIN `$awstats_db`.`downloads` ON `$scripture_db`.`ISO_countries`.`ISO_countries` = '$CCode' AND `$scripture_db`.`ISO_countries`.`ISO` = `$awstats_db`.`downloads`.`iso` AND `$awstats_db`.`downloads`.`month` = $month AND `$awstats_db`.`downloads`.`year` = $year ORDER BY `$scripture_db`.`ISO_countries`.`ISO`, `$scripture_db`.`ISO_countries`.`ROD_Code`, `$scripture_db`.`ISO_countries`.`Variant_Code`";
}
// doesn't work!: SELECT DISTINCT `ISO_countries`.`ISO_ROD_index`, `ISO_countries`.`ISO`, `ISO_countries`.`ROD_Code`, `ISO_countries`.`Variant_Code` FROM `scripture`.`ISO_countries` INNER JOIN `awstats_gui_log`.`downloads` ON `scripture`.`ISO_countries`.`ISO_countries` = 'MX' AND `scripture`.`ISO_countries`.`ISO` = `awstats_gui_log`.`downloads`.`iso` AND `awstats_gui_log`.`downloads`.`month` = 8 AND `awstats_gui_log`.`downloads`.`year` = 2025 ORDER BY `scripture`.`ISO_countries`.`ISO`, `scripture`.`ISO_countries`.`ROD_Code`, `scripture`.`ISO_countries`.`Variant_Code`

$result_country = $db->query($query) or die('Query failed:  ' . $db->error . '</body></html>');
if ($result_country->num_rows === 0) {
	echo 'none';
}
else {
	$first = '{';
	$n = 0;
	while ($row_country = $result_country->fetch_assoc()) {
		$ISO = $row_country['ISO'];
		$ROD_Code = $row_country['ROD_Code'];
		$Variant_Code = $row_country['Variant_Code'];
		$ISO_ROD_index = (int) $row_country['ISO_ROD_index'];
		$LN_English_stmt->bind_param("i", $ISO_ROD_index);
		$LN_English_stmt->execute();
		$result_LN_English = $LN_English_stmt->get_result();
		// if ($result_LN_English->num_rows === 0) {
		// }
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