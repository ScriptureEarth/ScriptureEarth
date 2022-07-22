<?php

$first = '';
$marks = [];

require_once '../include/conn.inc.php';															// connect to the database named 'scripture'
$db = get_my_db();

include 'include/v.key.php';																	// get v and key

$LN = '';
if (isset($_GET['ln'])) {
	$LN = $_GET['ln'];
	if (strlen($LN) < 3) {
		die ('Language name is less that four letters');
	}
}
else {
    die ('HACK!');
}

$stmt_iso = $db->prepare("SELECT * FROM scripture_main ORDER BY ISO, ROD_Code, Variant_Code");
$stmt_country = $db->prepare("SELECT ISO_countries, English FROM countries, ISO_countries WHERE ISO_countries.ISO_ROD_index = ? AND ISO_countries.ISO_countries = countries.ISO_Country");
$stmt_alt = $db->prepare("SELECT alt_lang_name FROM alt_lang_names WHERE ISO_ROD_index = ?");
$stmt_var = $db->prepare("SELECT Variant_Eng FROM Variants WHERE Variant_Code = ?");
//$stmt_SAB = $db->prepare("SELECT COUNT(*) AS SAB_temp FROM SAB WHERE ISO_ROD_index = ? AND SAB_Audio = ?");
$stmt_English = $db->prepare("SELECT LN_English FROM LN_English WHERE ISO_ROD_index = ?");
/*
$stmt_Spanish = $db->prepare("SELECT LN_Spanish FROM LN_Spanish WHERE ISO_ROD_index = ?");
$stmt_Portuguese = $db->prepare("SELECT LN_Portuguese FROM LN_Portuguese WHERE ISO_ROD_index = ?");
$stmt_French = $db->prepare("SELECT LN_French FROM LN_French WHERE ISO_ROD_index = ?");
$stmt_Dutch = $db->prepare("SELECT LN_Dutch FROM LN_Dutch WHERE ISO_ROD_index = ?");
$stmt_German = $db->prepare("SELECT LN_German FROM LN_German WHERE ISO_ROD_index = ?");
*/

$stmt_iso->execute();															            // execute query
$result_iso = $stmt_iso->get_result();

if ($result_iso->num_rows <= 0) {
	die ('scripture_main table does not exixt.');
}

$m=0;

$first = '{';
while ($row = $result_iso->fetch_assoc()) {
    $alt_count = 0;
    $alt = [];
    $country_count = 0;
    $country_name = [];
    $country_code = [];

    $iso = $row['ISO'];
    $rod = $row['ROD_Code'];
    $var = $row['Variant_Code'];
    $idx = $row['ISO_ROD_index'];

    $var_name = '';
    if ($var != '') {
        $stmt_var->bind_param('s', $var);
        $stmt_var->execute();														            // execute query
        $result_var = $stmt_var->get_result();
        $row_var = $result_var->fetch_assoc();
        $var_name=trim($row_var['Variant_Eng']);
    }

    $stmt_English->bind_param('i', $idx);									                // bind parameters for markers
    $stmt_English->execute();														        // execute query
    $result_LN = $stmt_English->get_result();
    if ($result_LN->num_rows > 0) {
        $row_temp=$result_LN->fetch_assoc();
        $stmt_alt->bind_param('i', $idx);										    		// bind parameters for markers
        $stmt_alt->execute();													    		// execute query
        $result_temp = $stmt_alt->get_result();
        $LN_English=trim($row_temp['LN_English']);
        if (preg_match("/(^|[- \(]+)$LN/i", $LN_English)) {                                 // start of line or words (ignor  "-", and "("))
            $m++;
            $ln_OR_alt = 'ln';
            if ($result_temp->num_rows > 0) {
                while ($row_alt = $result_temp->fetch_assoc()) {
                    $alt_count++;
                    $alt[] = $row_alt['alt_lang_name'];
                }
            }
            include 'include/print_partial_ln.php';
        }
        elseif ($result_temp->num_rows > 0) {
            $alt_temp=0;
            while ($row_alt = $result_temp->fetch_assoc()) {
                $alt_count++;
                $alt[] = $temp = $row_alt['alt_lang_name'];
                if (preg_match("/(^|[- \(]+)$LN/i", $temp)) {                               // start of line or words (ignor  "-", and "("))
                    $alt_temp=1;
                }
            }
            if ($alt_temp == 1) {
                $m++;
                $ln_OR_alt = 'alt';
                include 'include/print_partial_ln.php';
            }
       }
    }

    
/*
    $SAB_temp = (int)$row['SAB'];
    $SAB_Audio = 0;
    $SAB_Text = 0;
    $SAB_Video = 0;
    if ($SAB_temp === 1) {
        $SAB_temp = 1;
        $stmt_SAB->bind_param('ii', $idx, $SAB_temp);										// bind parameters for markers
        $stmt_SAB->execute();																// execute query
        $result_temp = $stmt_SAB->get_result();
        $row_temp = $result_temp->fetch_assoc();
        $SAB_Audio = $row_temp['SAB_temp'];
        $SAB_temp = 0;
        $stmt_SAB->bind_param('ii', $idx, $SAB_temp);										// bind parameters for markers
        $stmt_SAB->execute();																// execute query
        $result_temp = $stmt_SAB->get_result();
        $row_temp = $result_temp->fetch_assoc();
        $SAB_Text = $row_temp['SAB_temp'];
    }
*/
        

}
$first = rtrim($first, ',');
$first .= '}';

//echo $first . '<br /><br />';		// It works as a JSON!!!!

$marks = [];

//var_dump(json_decode($first));
//echo '<br /><br />';
//echo json_encode(json_decode($first), JSON_FORCE_OBJECT);

$marks = json_decode($first);

//var_dump($marks);
    
header('Content-Type: application/json');														// instead of <pre></pre>
// An associative array
$json_string = json_encode($marks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
//echo '<pre>'.$json_string.'</pre>';
echo $json_string;

?>