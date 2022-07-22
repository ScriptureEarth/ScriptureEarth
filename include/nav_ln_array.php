<?php
if (isset($_REQUEST["q"])){
    require_once '../include/conn.inc.php';							// connect to the database named 'scripture'
    $db = get_my_db();
} else {
    require_once './include/conn.inc.php';							// connect to the database named 'scripture'
    $db = get_my_db();
}

// Updated by Lærke Roager

// Master list of languages for the site to run in
$nav_ln_array = [];
$ln_query = "SELECT `translation_code`, `name`, `nav_fileName`, `ln_number`, `language_code`, `ln_abbreviation` FROM `translations` ORDER BY `translation_code`";
$ln_result=$db->query($ln_query) or die ('Query failed:  ' . $db->error . '</body></html>');
if ($ln_result->num_rows == 0) {
	die ('<div style="background-color: white; color: red; font-size: 16pt; padding-top: 20px; padding-bottom: 20px; margin-top: 200px; ">' . translate('The translation_code is not found.', $st, 'sys') . '</div></body></html>');
}

while ($ln_row = $ln_result->fetch_array()){
	$ln_temp[0] = $ln_row['translation_code'];
	$ln_temp[1] = $ln_row['name'];
	$ln_temp[2] = $ln_row['nav_fileName'];
	$ln_temp[3] = $ln_row['ln_number'];
	$ln_temp[4] = $ln_row['ln_abbreviation'];
	$nav_ln_array[$ln_row['language_code']] = $ln_temp;
}

if (isset($_REQUEST["q"])){
    $q = $_REQUEST["q"];

    if ($q !== "") {
        $test = strtolower($q);
        foreach ($nav_ln_array as $code => $array){
            if ($test == $array[0]){
                echo $array[2];
            }
        }
    }
}
?>