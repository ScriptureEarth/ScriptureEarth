<?php

$index = 0;
$marks = [];

require_once '../include/conn.inc.php';															// connect to the database named 'scripture'
$db = get_my_db();

include 'include/v.key.php';																	// get v and key

$SpecificCountry = 'English';
if (isset($_GET['ml'])) {
	$SpecificCountry = $_GET['ml'];
    /*************************************************************************************************************
                get major language names
    **************************************************************************************************************/
    //$LNames = ["English","Spanish","Portuguese","Dutch","French","German","Chinese","Korean","Russian","Arabic",etc.];
    $LNames = [];																		// save all of the LN_... natianal language names
    $res=$db->query("SHOW COLUMNS FROM nav_ln WHERE `Field` LIKE 'LN_%'");										// the following values are ['Field'], ['Type'], ['Collation'], ['Null'], and ['Key']
    while ($row_LN = $res->fetch_assoc()) {
        $LNames[] = substr($row_LN['Field'], 3);									    // Language Names - 'LN_'
    }
    // ISO_Country
	if (in_array($SpecificCountry, $LNames, true)) {
	}
    else {
		$marks = json_decode('{"error": "A navigational language is not found."}');
		header('Content-Type: application/json');
		echo json_encode($marks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
		exit;
    }
}

$rel = '';
if (isset($_GET['rel'])) {
    // Country code
    $rel = strtolower(trim($_GET['rel']));
    if ($rel != 'ios' && $rel != 'android') {
		$marks = json_decode('{"error": "The value of the parameter \'rel\' should be either \'ios\' or \'android\'. Please check your URL and try again."}');
		header('Content-Type: application/json');
		echo json_encode($marks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
		exit;
    }
}

if ($rel == 'ios') {
    $query = "SELECT DISTINCT `ISO_Country`, $SpecificCountry FROM `countries`, `ISO_countries`, `CellPhone` WHERE `countries`.`ISO_Country` = `ISO_countries`.`ISO_countries` AND `ISO_countries`.`ISO_ROD_index` = `CellPhone`.`ISO_ROD_index` AND `CellPhone`.`Cell_Phone_Title` = 'iOS Asset Package' ORDER BY $SpecificCountry";	// create a prepared statement
}
elseif ($rel == 'android') {
    $query = "SELECT DISTINCT `ISO_Country`, $SpecificCountry FROM `countries`, `ISO_countries`, `CellPhone` WHERE `countries`.`ISO_Country` = `ISO_countries`.`ISO_countries` AND `ISO_countries`.`ISO_ROD_index` = `CellPhone`.`ISO_ROD_index` AND `CellPhone`.`Cell_Phone_Title` = 'Android App' ORDER BY $SpecificCountry";			// create a prepared statement
}
else {
    $query = "SELECT DISTINCT `ISO_Country`, $SpecificCountry FROM `countries`, `ISO_countries` WHERE `countries`.`ISO_Country` = `ISO_countries`.`ISO_countries` ORDER BY $SpecificCountry";	// create a prepared statement
}

$result=$db->query($query) or die (translate('Query failed:', $st, 'sys') . ' ' . $db->error);

$m=1;
$first = '{';
while ($row = $result->fetch_array()) {
    $Country = trim($row[$SpecificCountry]);
    $country_Code = $row['ISO_Country'];
    $first .= '"'.($m-1).'": ';
    $first .= '{"type":                         "Countries",';
    $first .= '"id":                            "'.$m.'",';
    $first .= '"'.$SpecificCountry.'_country":  "'.$Country.'",';
    $first .= '"country_code":                  "'.$country_Code.'"';
    $first .= '},';
    $m++;
}
$first = rtrim($first, ',');
$first .= '}';

$marks = [];
$marks = json_decode($first);

header('Content-Type: application/json');														// instead of <pre></pre>
// An associative array
$json_string = json_encode($marks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
//echo '<pre>'.$json_string.'</pre>';
echo $json_string;

?>
