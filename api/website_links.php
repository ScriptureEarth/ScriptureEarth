<?php
/*
links table have ISO, ROD_Code, Variant_Code, and ISO_ROD_index

links table - map = 0 AND buy = 0 AND BibleIs = 0 AND YouVersion = 0 AND `Bibles_org` = 0 AND `GooglePlay` = 0 AND `GRN` = 0 AND `email` = 0
	company (text)
    company_title (text)
	URL (https)

    Kalaam (Kalaam field = 1)
	OneStory (company)
	Facebook (company)
	iTunes (company)
	Other Links (company)
	Deaf Bibles (company)
	Papua New Guinea (company)
*/

$index = 0;
$first = '';
$marks = [];

require_once '../include/conn.inc.php';															// connect to the database named 'scripture'
$db = get_my_db();

include 'include/v.key.php';																	// get v and key

include 'include/idx.iso.php';																	// get idx or iso

if ($index == 0) {
	die ('HACK!');
}

if ($index== 1) {
    $stmt_links = $db->prepare("SELECT `ISO`, `ROD_Code`, `Variant_Code`, ISO_ROD_index, `company`, `company_title`, `URL` FROM `links` WHERE ISO_ROD_index = ? AND map = 0 AND buy = 0 AND BibleIs = 0 AND YouVersion = 0 AND `Bibles_org` = 0 AND `GooglePlay` = 0 AND `GRN` = 0 AND `email` = 0 ORDER BY `ISO`, `ROD_Code`, `Variant_Code`");
    $stmt_links->bind_param('i', $idx);															// bind parameters for markers
}
else {
	if ($iso == 'ALL') {
		$stmt_links = $db->prepare("SELECT `ISO`, `ROD_Code`, `Variant_Code`, ISO_ROD_index, `company`, `company_title`, `URL` FROM `links` WHERE map = 0 AND buy = 0 AND BibleIs = 0 AND YouVersion = 0 AND `Bibles_org` = 0 AND `GooglePlay` = 0 AND `GRN` = 0 AND `email` = 0 ORDER BY `ISO`, `ROD_Code`, `Variant_Code`");
		//$stmt_links->bind_param();														// bind parameters for markers
	}
	elseif ($rod == 'ALL' && $var == 'ALL') {
		$stmt_links = $db->prepare("SELECT `ISO`, `ROD_Code`, `Variant_Code`, ISO_ROD_index, `company`, `company_title`, `URL` FROM `links` WHERE `ISO` = ? AND map = 0 AND buy = 0 AND BibleIs = 0 AND YouVersion = 0 AND `Bibles_org` = 0 AND `GooglePlay` = 0 AND `GRN` = 0 AND `email` = 0 ORDER BY `ISO`, `ROD_Code`, `Variant_Code`");
		$stmt_links->bind_param('s', $iso);														// bind parameters for markers
	}
	elseif ($rod == 'ALL') {
		$stmt_links = $db->prepare("SELECT `ISO`, `ROD_Code`, `Variant_Code`, ISO_ROD_index, `company`, `company_title`, `URL` FROM `links` WHERE `ISO` = ? AND `Variant_Code` = ? AND map = 0 AND buy = 0 AND BibleIs = 0 AND YouVersion = 0 AND `Bibles_org` = 0 AND `GooglePlay` = 0 AND `GRN` = 0 AND `email` = 0 ORDER BY `ISO`, `ROD_Code`, `Variant_Code`");
		$stmt_links->bind_param('ss', $iso, $var);												// bind parameters for markers
	}
	elseif ($var == 'ALL') {
			$stmt_links = $db->prepare("SELECT `ISO`, `ROD_Code`, `Variant_Code`, ISO_ROD_index, `company`, `company_title`, `URL` FROM `links` WHERE `ISO` = ? AND `ROD_Code` = ? AND map = 0 AND buy = 0 AND BibleIs = 0 AND YouVersion = 0 AND `Bibles_org` = 0 AND `GooglePlay` = 0 AND `GRN` = 0 AND `email` = 0 ORDER BY `ISO`, `ROD_Code`, `Variant_Code`");
			$stmt_links->bind_param('ss', $iso, $rod);											// bind parameters for markers
	}
	else {
		$stmt_links = $db->prepare("SELECT `ISO`, `ROD_Code`, `Variant_Code`, ISO_ROD_index, `company`, `company_title`, `URL` FROM `links` WHERE `ISO` = ? AND `ROD_Code` = ? AND `Variant_Code` = ? AND map = 0 AND buy = 0 AND BibleIs = 0 AND YouVersion = 0 AND `Bibles_org` = 0 AND `GooglePlay` = 0 AND `GRN` = 0 AND `email` = 0 ORDER BY `ISO`, `ROD_Code`, `Variant_Code`");
		$stmt_links->bind_param('sss', $iso, $rod, $var);										// bind parameters for markers
	}
}

$stmt_links->execute();															        		// execute query
$result_links = $stmt_links->get_result();

$links_rows = $result_links->num_rows;
if ($links_rows == 0) {
	die ('The links table does not exist for website links. Try a different iso or idx.');
}

$stmt_var = $db->prepare("SELECT Variant_Eng FROM Variants WHERE Variant_Code = ?");

$m=0;

//echo $result_links->num_rows . ' total records<br />'; 

$first = '{';
while ($row_links = $result_links->fetch_assoc()) {
	$idx = (int)$row_links['ISO_ROD_index'];
	$iso = $row_links['ISO'];
	$rod = $row_links['ROD_Code'];
	$var = $row_links['Variant_Code'];
	$Variant_name = '';
	if ($var != '') {
		$stmt_var->bind_param('s', $var);														// bind parameters for markers
		$stmt_var->execute();																	// execute query
		$result_temp = $stmt_var->get_result();
		$row_temp = $result_temp->fetch_assoc();
		$Variant_name = $row_temp['Variant_Eng'];
	}
	$organization = $row_links['company'];
	$title = $row_links['company_title'];
	$URL = $row_links['URL'];

	$m++;																						// id
	$first .= '"'.($m-1).'": ';
	$first .= '{"type":                     "Website Links",';
	$first .= '"id":                        "'.$m.'",';
	$first .= '"attributes": {';
	$first .= '"iso":                       "'.$iso.'",';
	$first .= '"rod":				        "'.$rod.'",';
	$first .= '"var_code":		    	    "'.$var.'",';
	$first .= '"var_name":					"'.$Variant_name.'",';
	$first .= '"iso_query_string":	        "iso='.$iso;
	if ($rod != '00000') {
		$first .= '&rod='.$rod;
	}
	if ($var != '') {
		$first .= '&var='.$var;
	}
	$first .= '",';
	$first .= '"idx":		                '.$idx.',';
	$first .= '"idx_query_string":          "idx='.$idx.'"';	
	$first .= '},';
	$first .= '"website_link": {';

	$first .= '"organization":				"'.$organization.'",';
	$first .= '"title":						"'.$title.'",';
	$first .= '"URL":						"'.$URL.'"';

	$first .= '}},';
}
$first = rtrim($first, ',');																	// all done with isos
$first .= '}';

//echo $first;
//exit;

$marks = json_decode($first);

header('Content-Type: application/json');														// instead of <pre></pre>
// An associative array
$json_string = json_encode($marks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
//echo '<pre>'.$json_string.'</pre>';
echo $json_string;

?>