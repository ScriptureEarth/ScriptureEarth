<?php

$first = '';
$marks = [];

require_once '../include/conn.inc.php';															// connect to the database named 'scripture'
$db = get_my_db();

include 'include/v.key.php';																	// get v and key

$stmt_iso = $db->prepare("SELECT * FROM scripture_main, nav_ln WHERE scripture_main.ISO_ROD_index = nav_ln.ISO_ROD_index ORDER BY scripture_main.ISO, scripture_main.ROD_Code, scripture_main.Variant_Code");
//$stmt_main = $db->prepare("SELECT * FROM scripture_main WHERE ISO_ROD_index = ?");
$stmt_var = $db->prepare("SELECT Variant_Eng FROM Variants WHERE Variant_Code = ?");
$stmt_country = $db->prepare("SELECT ISO_countries, English FROM countries, ISO_countries WHERE ISO_countries.ISO_ROD_index = ? AND ISO_countries.ISO_countries = countries.ISO_Country");
$stmt_alt = $db->prepare("SELECT alt_lang_name FROM alt_lang_names WHERE ISO_ROD_index = ?");
$stmt_OT_PDF = $db->prepare("SELECT COUNT(*) AS OT_PDF_temp FROM OT_PDF_Media WHERE ISO_ROD_index = ?");
$stmt_NT_PDF = $db->prepare("SELECT COUNT(*) AS NT_PDF_temp FROM NT_PDF_Media WHERE ISO_ROD_index = ?");
$stmt_OT_Audio = $db->prepare("SELECT COUNT(*) AS OT_Audio_temp FROM OT_Audio_Media WHERE ISO_ROD_index = ?");
$stmt_NT_Audio = $db->prepare("SELECT COUNT(*) AS NT_Audio_temp FROM NT_Audio_Media WHERE ISO_ROD_index = ?");
$stmt_SAB = $db->prepare("SELECT COUNT(*) AS SAB_temp FROM SAB WHERE ISO_ROD_index = ? AND SAB_Audio = ?");
$stmt_links = $db->prepare("SELECT LOWER(company) as company_temp, map, BibleIs, BibleIsGospelFilm, YouVersion, GooglePlay, GRN FROM links WHERE ISO_ROD_index = ? AND (map >= 1 OR YouVersion >= 1 OR GooglePlay >= 1 OR company = 'website' OR company = 'webpage')");
$stmt_CellPhone = $db->prepare("SELECT Cell_Phone_Title FROM CellPhone WHERE ISO_ROD_index = ?");
$stmt_PlaylistVideo = $db->prepare("SELECT PlaylistVideoDownload FROM PlaylistVideo WHERE ISO_ROD_index = ?");
$stmt_English = $db->prepare("SELECT LN_English FROM LN_English WHERE ISO_ROD_index = ?");
$stmt_Spanish = $db->prepare("SELECT LN_Spanish FROM LN_Spanish WHERE ISO_ROD_index = ?");
$stmt_Portuguese = $db->prepare("SELECT LN_Portuguese FROM LN_Portuguese WHERE ISO_ROD_index = ?");
$stmt_French = $db->prepare("SELECT LN_French FROM LN_French WHERE ISO_ROD_index = ?");
$stmt_Dutch = $db->prepare("SELECT LN_Dutch FROM LN_Dutch WHERE ISO_ROD_index = ?");
$stmt_German = $db->prepare("SELECT LN_German FROM LN_German WHERE ISO_ROD_index = ?");
//$stmt_iso_languages = $db->prepare("SELECT * FROM scripture_main ORDER BY ISO");

$stmt_iso->execute();															                // execute query
$result_iso = $stmt_iso->get_result();

if ($result_iso->num_rows <= 0) {
	die ('scripture_main table does not exixt.');
}

$m=0;

$first = '{';

while ($row = $result_iso->fetch_assoc()) {
    $m++;

    include('include/ISO_details.php');

    include('include/LN_details.php');

    include('include/print.php');
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