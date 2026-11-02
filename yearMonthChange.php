<?php
/******************************************************************************************************** 
	fetch form AWStatsScripts.js when the user changes the year or month select box.

	yearMonthChange.php -- Returns JSON string with:
		uniqueVisitors, numberOfVisits, pages from visitors table, 
		and fileType, description, and hits from filetype table.
********************************************************************************************************/

// Created by Scott Starker - 8/2024
// Updated by Scott Starker - 9/2025, 11/2025

//echo '<pre>yearMonthChange.php?m=' . $_GET['m'] . '&y=' . $_GET['y'] . '</pre>';
//echo '<pre>REMOTE_ADDR=' . $_SERVER['REMOTE_ADDR'] . '</pre>';
//exit;

if (isset($_GET['m'])) $month = (int)$_GET['m']; else { die('Did you make a mistake?'); }
if ($month != 1 && $month != 2 && $month != 3 && $month != 4 && $month != 5 && $month != 6 && $month != 7 && $month != 8 && $month != 9 && $month != 10 && $month != 11 && $month != 12 && $month != 13) { die('Did you make a mistake?'); }	// only months 1-12 or 13 (year) are allowed
if (isset($_GET['y'])) $year = (int)$_GET['y']; else { die('Did you make a mistake?'); }
if ($year < 2010 || $year > 2100) { die('Did you make a mistake?'); }														// only years 2000-2100 are allowed

// SELECT WHERE `fileType` NOT IN ('" . implode("','", $notFileTypeArray) . "') [array to string]
$notFileTypeArray = ['png','jpg','tif','js','php','css','gif','jpeg','ttf','json','ods','odt','docx','doc','msg','tpl','ffs_db','svg','shtml','bak','cgi','sql','bat','sh','jsp','action','aspx','xml','do','ini','jsf','pl','jspa','ashx','cfm','asp','dll','cmd','zgz','cfc','log','esp','mwsl','hsp','me','portal','gch','xhtml','pem','py','dat','axd','md5','conf','bz2','en','local','env','stream','lp','php7','iwc','md','xls','xlsx','exp','online','key','ns','set','yml','zul','index','ehp','rsp','ccp','csv','jsn','lua','mjs','view','web','inc','srf','lst','1','ptx','junk','jnnk','cfg','sty','tex','xdv','id'];

if (substr($_SERVER['REMOTE_ADDR'], 0, 7) == '192.168' || substr($_SERVER['REMOTE_ADDR'], 0, 9) == '127.0.0.1' || substr($_SERVER['REMOTE_ADDR'], 0, 9) == '172.20.0.') {	// Is the script local?
	$awstats_db = 'awstats_gui_log';
	//$scripture_db = 'scripture';
}
else {
	$awstats_db = 'se_awstats_gui_log';
	//$scripture_db = 'se_scripture';
}

//require_once './include/conn.inc.php';													// connect to the database named 'scripture' or 'se_scripture'
//$db = get_my_db();
require_once './include/conn.inc.AWStats.php';											// connect to the AWStats database
$db = get_my_AWStatsDB();																// connect to the AWStats database named 'awstats_gui_log' or 'se_awstats_gui_log'


$numOfVisits = 0;
$ipPages = 0;
	
if ($month == 13) {																			// a year				
	$query = "SELECT `ip`, `ipPages`, `ipBandwidth` FROM $awstats_db.`ip` WHERE $awstats_db.`ip`.`year` = $year GROUP BY $awstats_db.`ip`.`ip`";
}
else {
	$query = "SELECT `ip`, `ipPages`, `ipBandwidth` FROM $awstats_db.`ip` WHERE $awstats_db.`ip`.`month` = $month AND $awstats_db.`ip`.`year` = $year";
}
$result_ipPages = $db->query($query) or die('Query failed:  ' . $db->error);
//echo 'num: '.$result_ipPages->num_rows . '<br />';; // Debug: print the query being executed
if ($result_ipPages->num_rows == 0) {
	$ipPages = 0;
}
else {
	while ($row_ipPages = $result_ipPages->fetch_assoc()) {
		$ip = $row_ipPages['ip'];
		if ($ip == 'Others') {								// skip 'Others' IPs
			$ipPages = $ipPages + $row_ipPages['ipPages'];
			$numOfVisits++;
			continue;
		}
//echo 'Processing IP: '.$ip.'<br />'; // Debug: print the IP being processed
		/*******************************************************
		 * 	ip China or Google then skip!
		 * *****************************************************/
		if (str_starts_with($ip, "114.119.") || str_starts_with($ip, "72.14.") || str_starts_with($ip, "74.125.")) {
			$ipPages = $ipPages + $row_ipPages['ipPages'];
			$numOfVisits++;
			continue;
		}
		$testIParray = explode('.', $ip);
		$testIPzero = (int)$testIParray[0];
		$testIPone = (int)$testIParray[1];
		$testIPtwo= (int)$testIParray[2];
		$testIPthree = (int)$testIParray[3];
		// [34.4.5.0 - 34.191.255.255]
		if ($testIPzero == 34) {
			if ($testIPone >= 4 && $testIPone <= 191) {
				$ipPages = $ipPages + $row_ipPages['ipPages'];
				$numOfVisits++;
				continue;
			}
		}
		// [35.252.0.0 - 35.255.255.255]
		if ($testIPzero == 35) {
			if ($testIPone >= 252 && $testIPone <= 255) {
				$ipPages = $ipPages + $row_ipPages['ipPages'];
				$numOfVisits++;
				continue;
			}
		}
		// [66.249.64.0 - 66.249.95.255]
		if ($testIPzero == 66 && $testIPone == 249) {
			if ($testIPtwo >= 64 && $testIPtwo <= 95) {
				$ipPages = $ipPages + $row_ipPages['ipPages'];
				$numOfVisits++;
				continue;
			}
		}
		// [136.112.0.0 - 136.127.255.255])
		if ($testIPzero == 136) {
			if ($testIPone >= 112 && $testIPone <= 127) {
				$ipPages = $ipPages + $row_ipPages['ipPages'];
				$numOfVisits++;
				continue;
			}
		}
		//$ipBandwidth = (int)$row_ipPages['ipBandwidth'];
	}
}
//echo $ipPages.'^'.$numOfVisits.'^';


	
if ($month == 13) {																		// a year
	$query = "SELECT SUM(uniqueVisitors) uniqueVisitors, SUM(numberOfVisits) numberOfVisits, SUM(pages) pages, SUM(hits) hits, SUM(bandwidth) bandwidth FROM $awstats_db.visitors WHERE $awstats_db.visitors.`year` = $year";
}
else {
	$query = "SELECT uniqueVisitors, numberOfVisits, pages, hits, bandwidth FROM $awstats_db.visitors WHERE $awstats_db.visitors.`month` = $month AND $awstats_db.visitors.`year` = $year";
}
$result_YM = $db->query($query) or die('Query failed:  ' . $db->error);

if ($result_YM->num_rows == 0) {
	echo '@none';
}
else {
	$first = '{';
	$n = 0;
	while ($row_YM = $result_YM->fetch_assoc()) {
		$n++;
		$uniqueVisitors = (int) $row_YM['uniqueVisitors'];
		$numberOfVisits = (int) $row_YM['numberOfVisits'];
		$pages = (int) $row_YM['pages'];
		//hits
		//bandwidth 	
		$first .= '"'.($n-1).'": {';
		$first .= '"uniqueVisitors":                    '.$uniqueVisitors.',';
		$first .= '"numberOfVisits":				    '.$numberOfVisits.',';
		$first .= '"pages":		    	    			'.$pages.'},';
	}
	$first = rtrim($first, ',');
	$first .= '}';

	$marks = [];
	$marks = json_decode($first);														// string to JSON array
	
	// An associative array
	//$json_string = json_encode($marks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
	$json_string = json_encode($marks, JSON_UNESCAPED_UNICODE);							// JSON array into string in order to pass it to the js

	/*********************************************************************
			filetype table
	*********************************************************************/
	$json_stringTwo = '';
	if ($month == 13) {																	// Year
		$query="SELECT `fileType`, `description`, SUM(`fTHits`) `fTHits`, SUM(`hFTPercent`), SUM(`fTBandwidth`), SUM(`bFTPercent`) FROM $awstats_db.`filetype` WHERE $awstats_db.`filetype`.`year` = $year AND $awstats_db.`filetype`.`fileType` NOT IN ('" . implode("','", $notFileTypeArray) . "') GROUP BY $awstats_db.`filetype`.`fileType` ORDER BY $awstats_db.`filetype`.`fTHits` DESC";
	}
	else {
		$query="SELECT `fileType`, `description`, `fTHits`, `hFTPercent`, `fTBandwidth`, `bFTPercent` FROM $awstats_db.`filetype` WHERE `month` = $month AND $awstats_db.`filetype`.`year` = $year AND $awstats_db.`filetype`.`fileType` NOT IN ('" . implode("','", $notFileTypeArray) . "') ORDER BY $awstats_db.`filetype`.`fTHits` DESC";
	}
	$result_filetype = $db->query($query) or die('Query failed:  ' . $db->error);
	if ($result_filetype->num_rows == 0) {
		$second = '@none';
	}
	else {
		$second = '{';
		$n=0;
		while ($row_filetype = $result_filetype->fetch_assoc()) {
			$n++;
			$fileType = $row_filetype['fileType'];
			$description = $row_filetype['description'];
			$hits = (int) $row_filetype['fTHits'];
			$second .= '"'.($n-1).'": {';
			$second .= '"fileType":                    "'.$fileType.'",';
			$second .= '"description":				   "'.$description.'",';
			$second .= '"hits":				   		   '.$hits.'},';
		}
		$second = rtrim($second, ',');
		$second .= '}';
	
		$marksTwo = [];
		$marksTwo = json_decode($second);												// string to JSON array
		
		// An associative array
		//$json_string = json_encode($marks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
		$json_stringTwo = json_encode($marksTwo, JSON_UNESCAPED_UNICODE);				// JSON array into string in order to pass it to the js
	}
	
	if ($second != '@none') {
		$json_string = $json_string . '@' . $json_stringTwo;
	}
	else {
	}
	
	//header('Content-Type: application/json');											// instead of <pre></pre>
	//echo '<pre>'.$json_string.'</pre>';
	echo $ipPages.'^'.$numOfVisits.'^'.$json_string;
}
?>