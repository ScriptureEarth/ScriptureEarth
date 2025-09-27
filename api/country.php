<?php

$index = 0;
$marks = [];

require_once '../include/conn.inc.php';															// connect to the database named 'scripture'
$db = get_my_db();

include 'include/v.key.php';																	// get v and key

$cc = '';
$country = '';
if (isset($_GET['country'])) {
	$country = $_GET['country'];
	//if ($country != ) {
	//	die ('HACK!');
	//}
}
elseif (isset($_GET['cc'])) {
    $cc = $_GET['cc'];
    if (preg_match('/^[A-Z][A-Z]$/', $cc)) {
    }
    else {
        die ('HACK!');
    }
}
else {
    die ('HACK!');
}

$query = "SELECT ISO_country, English FROM countries WHERE English = '$country' OR ISO_Country = '$cc'";
$result=$db->query($query) or die ('Query failed: ' . $db->error . '</body></html>');
if ($result->num_rows <= 0) {
    die ('<div style="background-color: white; color: red; font-size: 16pt; padding-top: 20px; padding-bottom: 20px; margin-top: 200px; ">The '.$country.' is not found.</div></body></html>');
}
$r = $result->fetch_assoc();
$iso_countries = $r['ISO_country'];
$Eng_country = $r['English'];

$query = "SELECT * FROM ISO_countries WHERE ISO_countries = '$iso_countries' ORDER BY ISO, ROD_Code, Variant_Code";
$result=$db->query($query) or die ('Query failed: ' . $db->error . '</body></html>');
if ($result->num_rows <= 0) {
    die ('<div style="background-color: white; color: red; font-size: 16pt; padding-top: 20px; padding-bottom: 20px; margin-top: 200px; ">The '.$iso_countries.' index is not found.</div></body></html>');
}

$stmt_English = $db->prepare("SELECT LN_English FROM LN_English WHERE ISO_ROD_index = ?");
$stmt_alt = $db->prepare("SELECT DISTINCT alt_lang_name FROM alt_lang_names WHERE ISO_ROD_index = ?");
$stmt_var = $db->prepare("SELECT Variant_Eng FROM Variants WHERE Variant_Code = ?");

$m=0;
$first = '{';
while ($row = $result->fetch_assoc()) {
    $iso = $row['ISO'];
    $rod = $row['ROD_Code'];
    $var = $row['Variant_Code'];
    $Variant_name = '';
    if ($var != '') {
        $stmt_var->bind_param('s', $var);													// bind parameters for markers
        $stmt_var->execute();																// execute query
        $result_temp = $stmt_var->get_result();
        $row_temp = $result_temp->fetch_assoc();
        $Variant_name = $row_temp['Variant_Eng'];
    }
    $idx = (int)$row['ISO_ROD_index'];
    $country_Code = $row['ISO_countries'];

    $alt_ln = 0;
    $alt = '';
    $stmt_alt->bind_param('i', $idx);												            // bind parameters for markers
    $stmt_alt->execute();																    	// execute query
    $result_alt = $stmt_alt->get_result();
    if ($result_alt->num_rows > 0) {
        $alt_ln = $result_alt->num_rows;													    // 0 or 1
        while ($row_alt = $result_alt->fetch_assoc()) {
            $alt .= $row_alt['alt_lang_name'] . ', ';
        }
        $alt = rtrim($alt, ', ');
    }
    
    //$query = "SELECT LN_English FROM LN_English WHERE ISO_ROD_index = $idx";
    $stmt_English->bind_param('i', $idx);							                	        // bind parameters for markers
	$stmt_English->execute();													                // execute query
	$result_LN = $stmt_English->get_result();
    if ($result_LN->num_rows <= 0) {
        die ('<div style="background-color: white; color: red; font-size: 16pt; padding-top: 20px; padding-bottom: 20px; margin-top: 200px; ">The '.$iso.' is not found.</div></body></html>');
    }
    $row_LN = $result_LN->fetch_assoc();
    $LN_English = $row_LN['LN_English'];
    $m++;

    $first .= '"'.($m-1).'": ';
    $first .= '{"type":                     "Country",';
    $first .= '"id":                        "'.$m.'",';
    $first .= '"english_country":           "'.$Eng_country.'",';
    $first .= '"country_code":              "'.$country_Code.'",';
    $first .= '"relationships": {';
    $first .= '"iso":                       "'.$iso.'",';
    $first .= '"rod":				        "'.$rod.'",';
    $first .= '"var_code":		    	    "'.$var.'",';
    $first .= '"var_name":			        "'.$Variant_name.'",';
    $first .= '"iso_query_string":	        "&iso='.$iso;
    if ($rod != '00000') {
        $first .= '&rod='.$rod;
    }
    if ($var != '') {
        $first .= '&var='.$var;
    }
    $first .= '",';
    $first .= '"idx":		                '.$idx.',';
    $first .= '"idx_query_string":          "&idx='.$idx.'",';
    $first .= '"english_language_name":     "'.$LN_English.'",';
    $first .= '"alternate_language_number":		'.$alt_ln.',';                                  // how many
    $first .= '"alternate_language_names":		"'.$alt.'"';
    $first .= '}},';
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
