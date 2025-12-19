<?php
// Created by Scott Starker - 11/2025
/*
	from AWStatsScripts.js:
        AWStatsSections.php?s=1&m="+month+"&y="+year
        AWStatsSections.php?s=2&m="+month+"&y="+year
        AWStatsSections.php?s=3&m="+month+"&y="+year
        AWStatsSections.php?s=4&m="+month+"&y="+year
*/

if (isset($_GET['s'])) $section = (int)$_GET['s']; else { die('Did you make a mistake?'); }
if ($section != 1 && $section != 2 && $section != 3 && $section != 4) { die('Did you make a mistake?'); }											// only section 1 is allowed for now
if (isset($_GET['m'])) $month = (int)$_GET['m']; else { die('Did you make a mistake?'); }
if ($month != 1 && $month != 2 && $month != 3 && $month != 4 && $month != 5 && $month != 6 && $month != 7 && $month != 8 && $month != 9 && $month != 10 && $month != 11 && $month != 12 && $month != 13) { die('Did you make a mistake?'); }	// only months 1-12 or 13 (year) are allowed
if (isset($_GET['y'])) $year = (int)$_GET['y']; else { die('Did you make a mistake?'); }
if ($year < 2020 || $year > 2100) { die('Did you make a mistake?'); }														// only years 2000-2100 are allowed

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
require_once './include/conn.inc.AWStats.php';											    // connect to the AWStats database
$db = get_my_AWStatsDB();																    // connect to the AWStats database named 'awstats_gui_log' or 'se_awstats_gui_log'

if ($section == 1) {																		// browsers table
    /*********************************************************************
            browsers table
    *********************************************************************/
    if ($month == 13) {																		// a year				
        $query="SELECT `browser`, `bPages`, `pBPercent` FROM $awstats_db.`browsers` WHERE $awstats_db.`browsers`.`year` = $year GROUP BY $awstats_db.`browsers`.browser ORDER BY $awstats_db.`browsers`.`pBPercent` DESC";
    }
    else {
        $query="SELECT `browser`, `bPages`, `pBPercent` FROM $awstats_db.`browsers` WHERE $awstats_db.`browsers`.`month` = $month AND $awstats_db.`browsers`.`year` = $year ORDER BY $awstats_db.`browsers`.`pBPercent` DESC";
    }
    $result_browsers = $db->query($query) or die('Query failed:  ' . $db->error . '</body></html>');

    if ($result_browsers->num_rows == 0) {
        echo 'none';
    }
    else {
        $bChange = '{';
        $n = 0;
        while ($row_browsers = $result_browsers->fetch_assoc()) {
            $n++;
            $browser = $row_browsers['browser'];
            $bPages = (int) $row_browsers['bPages'];
            $pBPercent = (int) $row_browsers['pBPercent'];

            $bChange .= '"'.($n-1).'": {';
            $bChange .= '"browser":                       	    "'.$browser.'",';
            $bChange .= '"pages":				        	    '.$bPages.',';
            $bChange .= '"percent":		    	                '.$pBPercent.'},';
        }
        $bChange = rtrim($bChange, ',');
        $bChange .= '}';

        $marksBrowser = [];
        $marksBrowser = json_decode($bChange);												// string to JSON array
        header('Content-Type: application/json');											// instead of <pre></pre>
        // An associative array
        //$json_string = json_encode($marks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $json_string_Browser = json_encode($marksBrowser, JSON_UNESCAPED_UNICODE);			// JSON array into string in order to pass it to the js
        //echo '<pre>'.$json_string.'</pre>';
        echo $json_string_Browser;
    }
}

elseif ($section == 2) {																	// duration table
    /*********************************************************************
            duration table
    *********************************************************************/
    if ($month == 13) {																		// a year				
        $query="SELECT `zeroSecThirtySec`, `zeroSecThirtySecPre`, `thirtySecTwoMin`, `thirtySecTwoMinPre`, `twoMinFiveMin`, `twoMinFiveMinPre`, `fiveMinFifthteenMin`, `fiveMinFifthteenMinPre`, `fifthteenMinThirtyMin`, `fifthteenMinThirtyMinPre`, `thirtyMinOneHour`, `thirtyMinOneHourPre`, `oneHourPlus`, `oneHourPlusPre` FROM $awstats_db.`duration` WHERE $awstats_db.`duration`.`year` = $year ORDER BY $awstats_db.`duration`.`oneHourPlus` DESC";
    }
    else {
        $query="SELECT `zeroSecThirtySec`, `zeroSecThirtySecPre`, `thirtySecTwoMin`, `thirtySecTwoMinPre`, `twoMinFiveMin`, `twoMinFiveMinPre`, `fiveMinFifthteenMin`, `fiveMinFifthteenMinPre`, `fifthteenMinThirtyMin`, `fifthteenMinThirtyMinPre`, `thirtyMinOneHour`, `thirtyMinOneHourPre`, `oneHourPlus`, `oneHourPlusPre` FROM $awstats_db.`duration` WHERE $awstats_db.`duration`.`month` = $month AND $awstats_db.`duration`.`year` = $year";
    }
    $result_durations = $db->query($query) or die('Query failed:  ' . $db->error . '</body></html>');

    if ($result_durations->num_rows == 0) {
        echo 'none';
    }
    else {
        $dChange = '{';
        $n = 0;
        while ($row_durations = $result_durations->fetch_assoc()) {
            $n++;
            $zeroSecThirtySec = (int) $row_durations['zeroSecThirtySec'];
            $zeroSecThirtySecPre = $row_durations['zeroSecThirtySecPre'];
            $thirtySecTwoMin = (int) $row_durations['thirtySecTwoMin'];
            $thirtySecTwoMinPre = $row_durations['thirtySecTwoMinPre'];
            $twoMinFiveMin = (int) $row_durations['twoMinFiveMin'];
            $twoMinFiveMinPre = $row_durations['twoMinFiveMinPre'];
            $fiveMinFifthteenMin = (int) $row_durations['fiveMinFifthteenMin'];
            $fiveMinFifthteenMinPre = $row_durations['fiveMinFifthteenMinPre'];
            $fifthteenMinThirtyMin = (int) $row_durations['fifthteenMinThirtyMin'];
            $fifthteenMinThirtyMinPre = $row_durations['fifthteenMinThirtyMinPre'];
            $thirtyMinOneHour = (int) $row_durations['thirtyMinOneHour'];
            $thirtyMinOneHourPre = $row_durations['thirtyMinOneHourPre'];
            $oneHourPlus = (int) $row_durations['oneHourPlus'];
            $oneHourPlusPre = $row_durations['oneHourPlusPre'];

            $dChange .= '"'.($n-1).'": {';
            $dChange .= '"zeroSecThirtySec":			        '.$zeroSecThirtySec.',';
            $dChange .= '"zeroSecThirtySecPre":		            "'.$zeroSecThirtySecPre.'",';
            $dChange .= '"thirtySecTwoMin":			            '.$thirtySecTwoMin.',';
            $dChange .= '"thirtySecTwoMinPre":		            "'.$thirtySecTwoMinPre.'",';
            $dChange .= '"twoMinFiveMin":			            '.$twoMinFiveMin.',';
            $dChange .= '"twoMinFiveMinPre":		            "'.$twoMinFiveMinPre.'",';
            $dChange .= '"fiveMinFifthteenMin":		            '.$fiveMinFifthteenMin.',';
            $dChange .= '"fiveMinFifthteenMinPre":	            "'.$fiveMinFifthteenMinPre.'",';
            $dChange .= '"fifthteenMinThirtyMin":	            '.$fifthteenMinThirtyMin.',';
            $dChange .= '"fifthteenMinThirtyMinPre":            "'.$fifthteenMinThirtyMinPre.'",';
            $dChange .= '"thirtyMinOneHour":			        '.$thirtyMinOneHour.',';
            $dChange .= '"thirtyMinOneHourPre":		            "'.$thirtyMinOneHourPre.'",';
            $dChange .= '"oneHourPlus":				            '.$oneHourPlus.',';
            $dChange .= '"oneHourPlusPre":			            "'.$oneHourPlusPre.'"},';
        }
        $dChange = rtrim($dChange, ',');
        $dChange .= '}';

        $marksDuration = [];
        $marksDuration = json_decode($dChange);												// string to JSON array
        header('Content-Type: application/json');											// instead of <pre></pre>
        // An associative array
        //$json_string = json_encode($marks, JSON_PRETTY_PRINT
        $json_string_Duration = json_encode($marksDuration, JSON_UNESCAPED_UNICODE);		// JSON array into string in order to pass it to the js
        //echo '<pre>'.$json_string.'</pre>';
        echo $json_string_Duration;
    }
}

elseif ($section == 3) {																	// ip table
    /*********************************************************************
            ip table
    *********************************************************************/
    if ($month == 13) {																		// a year				
        $query="SELECT `ip`, `ipPages`, `ipBandwidth` FROM $awstats_db.`ip` WHERE $awstats_db.`ip`.`year` = $year GROUP BY $awstats_db.`ip`.`ip` ORDER BY $awstats_db.`ip`.`ipBandwidth` DESC";
    }
    else {
        $query="SELECT `ip`, `ipPages`, `ipBandwidth` FROM $awstats_db.`ip` WHERE $awstats_db.`ip`.`month` = $month AND $awstats_db.`ip`.`year` = $year ORDER BY $awstats_db.`ip`.`ipBandwidth` DESC";
    }
    $result_ip = $db->query($query) or die('Query failed:  ' . $db->error . '</body></html>');

    if ($result_ip->num_rows == 0) {
        echo 'none';
    }
    else {
        $ipChange = '{';
        $n = 0;
        while ($row_ip = $result_ip->fetch_assoc()) {
            $n++;
            $ip = $row_ip['ip'];
            $ipPages = (int) $row_ip['ipPages'];
            $ipBandwidth = (int) $row_ip['ipBandwidth'];
            $ipBandwidth = (int) ($ipBandwidth / 1048576);									// convert bytes to MB

            $ipChange .= '"'.($n-1).'": {';
            $ipChange .= '"ip":                       	        "'.$ip.'",';
            $ipChange .= '"pages":				        	    '.$ipPages.',';
            $ipChange .= '"bandwidth":		    	            '.$ipBandwidth.'},';
        }
        $ipChange = rtrim($ipChange, ',');
        $ipChange .= '}';

        $marksIP = [];
        $marksIP = json_decode($ipChange);												    // string to JSON array
        header('Content-Type: application/json');											// instead of <pre></pre>
        // An associative array
        //$json_string = json_encode($marks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $json_string_IP = json_encode($marksIP, JSON_UNESCAPED_UNICODE);
        //echo '<pre>'.$json_string.'</pre>';
        echo $json_string_IP;
    }
}

elseif ($section == 4) {																	// os table
    /*********************************************************************
            os table
    *********************************************************************/
    if ($month == 13) {																		// a year				
        $query="SELECT `os`, `osPages`, `osPercentOne` FROM $awstats_db.`os` WHERE $awstats_db.`os`.`year` = $year GROUP BY $awstats_db.`os`.`os` ORDER BY $awstats_db.`os`.`osPages` DESC";
    }
    else {
        $query="SELECT `os`, `osPages`, `osPercentOne` FROM $awstats_db.`os` WHERE $awstats_db.`os`.`month` = $month AND $awstats_db.`os`.`year` = $year ORDER BY $awstats_db.`os`.`osPages` DESC";
    }
    $result_os = $db->query($query) or die('Query failed:  ' . $db->error . '</body></html>');

    if ($result_os->num_rows == 0) {
        echo 'none';
    }
    else {
        $osChange = '{';
        $n = 0;
        while ($row_os = $result_os->fetch_assoc()) {
            $n++;
            $os = $row_os['os'];
            $osPages = (int) $row_os['osPages'];
            $osPercentOne = $row_os['osPercentOne'];

            $osChange .= '"'.($n-1).'": {';
            $osChange .= '"os":                       	        "'.$os.'",';
            $osChange .= '"pages":				        	    '.$osPages.',';
            $osChange .= '"percent":		    	            "'.$osPercentOne.'"},';
        }
        $osChange = rtrim($osChange, ',');
        $osChange .= '}';

        $marksOS = [];
        $marksOS = json_decode($osChange);												// string to JSON array
        header('Content-Type: application/json');											// instead of <pre></pre>
        // An associative array
        //$json_string = json_encode($marks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $json_string_OS = json_encode($marksOS, JSON_UNESCAPED_UNICODE);                // JSON array into string in order to pass it to the js
        //echo '<pre>'.$json_string.'</pre>';
        echo $json_string_OS;
    }
}
?>