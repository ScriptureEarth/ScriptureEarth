<?php

$index = 0;
$marks = [];

require_once '../include/conn.inc.php';															// connect to the database named 'scripture'
$db = get_my_db();

if (isset($_GET['key'])) {																		// key
	$key = $_GET['key'];
	$query="SELECT * FROM api_users WHERE `key` = '$key'";
	$result=$db->query($query) or die ('Query failed: ' . $db->error . '</body></html>');
	if ($result->num_rows <= 0) {
		die ('<div style="background-color: white; color: red; font-size: 16pt; padding-top: 20px; padding-bottom: 20px; margin-left: 200px; margin-top: 200px; ">The key is in error.</div></body></html>');
	}
}
else {
    die ('HACK!');
}
if (isset($_GET['v'])) {																		// version
	$v = (float)$_GET['v'];
	if ($v != .5) {																				// version = 1
		die ('HACK!');
	}
}
else {
    die ('HACK!');
}
if (isset($_GET['cc'])) {																		// country code
	$cc = trim($_GET['cc']);
	if (preg_match('/^[A-Z][A-Z]$/', $cc)) {
	}
	else {
		die ('HACK!');
	}
}
else {
    $cc = '';
}

$stmt_country = $db->prepare("SELECT `ISO`, `ROD_Code`, `Variant_Code`, ISO_ROD_index, `English` FROM `countries`, `ISO_countries` WHERE `countries`.`ISO_Country` = `ISO_countries`.`ISO_countries` AND `ISO_countries`.`ISO_countries` = ? ORDER BY `ISO_countries`.`ISO`, `ISO_countries`.`ROD_Code`, `ISO_countries`.`Variant_Code`");

$m=0;
$first = '{';

$country_name = '';
$country_code = '';
if ($cc != '') {
	$query="SELECT distinct ISO_countries FROM ISO_countries WHERE ISO_countries = '$cc'";
}
else {
	$query="SELECT distinct ISO_countries FROM ISO_countries ORDER BY ISO_countries";
}
$result=$db->query($query) or die ('Query failed: ' . $db->error . '</body></html>');
if ($result->num_rows <= 0) {
	die ('<div style="background-color: white; color: red; font-size: 16pt; padding-top: 20px; padding-bottom: 20px; margin-top: 200px; ">The ISO/ROD index is not found.</div></body></html>');
}
while ($row = $result->fetch_array()) {
	$m++;
	$ISO_countries = $row['ISO_countries'];

	$n = 0;
	//$query="SELECT `ISO`, `ROD_Code`, `Variant_Code`, ISO_ROD_index, `English` FROM `countries`, `ISO_countries` WHERE `countries`.`ISO_Country` = `ISO_countries`.`ISO_countries` AND `ISO_countries`.`ISO_countries` = '$ISO_countries' ORDER BY `ISO_countries`.`ISO`, `ISO_countries`.`ROD_Code`, `ISO_countries`.`Variant_Code`";
	$stmt_country->bind_param('s', $ISO_countries);										// bind parameters for markers
	$stmt_country->execute();															// execute query
	$result_temp = $stmt_country->get_result();
	while ($row_country = $result_temp->fetch_assoc()) {
		if ($n == 0) {
			$first .= '"'.($m-1).'": ';
			$first .= '{"type":                     "Countries",';
			$first .= '"id":                        "'.$m.'",';
			$first .= '"english_country":           "'.$row_country['English'].'",';
			$first .= '"country_code":              "'.$ISO_countries.'",';
			$first .= '"relationships":';
			$first .= '{';
		}
		$n++;
		$ISO = $row_country['ISO'];
		$ROD_Code = $row_country['ROD_Code'];
		$Variant_Code = $row_country['Variant_Code'];
		$ISO_ROD_index = $row_country['ISO_ROD_index'];
		$first .= '"'.($n-1).'": {';
		$first .= '"iso":                       "'.$ISO.'",';
		$first .= '"rod":				        "'.$ROD_Code.'",';
		$first .= '"var":		    	        "'.$Variant_Code.'",';
		$first .= '"iso_query_string":	        "sortby=lang&iso='.$ISO;
		if ($ROD_Code != '00000') {
			$first .= '&rod='.$ROD_Code;
		}
		if ($Variant_Code != '') {
			$first .= '&var='.$Variant_Code;
		}
		$first .= '",';
		$first .= '"idx":		                '.$ISO_ROD_index.',';
		$first .= '"idx_query_string":          "sortby=lang&idx='.$ISO_ROD_index.'"},';	
	}
	$first = rtrim($first, ',');
	$first .= '}},';
}
$first = rtrim($first, ',');
$first .= '}';

//echo $first;

$marks = [];
$marks = json_decode($first);

header('Content-Type: application/json');														// instead of <pre></pre>
// An associative array
$json_string = json_encode($marks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
//echo '<pre>'.$json_string.'</pre>';
echo $json_string;

?>
