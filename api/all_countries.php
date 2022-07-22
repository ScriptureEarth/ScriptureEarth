<?php

$index = 0;
$marks = [];

require_once '../include/conn.inc.php';															// connect to the database named 'scripture'
$db = get_my_db();

include 'include/v.key.php';																	// get v and key

$SpecificCountry = 'English';
if (isset($_GET['ml'])) {
	$SpecificCountry = $_GET['ml'];
    // ISO_Country
	if ($SpecificCountry == 'English' || $SpecificCountry == 'Spanish' || $SpecificCountry == 'Portuguese' || $SpecificCountry == 'French' || $SpecificCountry == 'Dutch' || $SpecificCountry == 'German') {
	}
    else {
		die ('HACK!');
    }
}

$query="SELECT DISTINCT ISO_Country, $SpecificCountry FROM countries, ISO_countries WHERE countries.ISO_Country = ISO_countries.ISO_countries ORDER BY $SpecificCountry";														// create a prepared statement
$result=$db->query($query) or die (translate('Query failed:', $st, 'sys') . ' ' . $db->error . '</body></html>');

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
