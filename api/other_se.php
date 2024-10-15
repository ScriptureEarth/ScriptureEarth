<?php
/*
other_titles table have ISO, ROD_Code, Variant_Code, and ISO_ROD_index

other_titles table - download_video IS NULL OR download_video = ''
    other (text)
    other_title (text)
    other_PDF (pdf)
    other_audio (mp3)
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
    $stmt_other_titles = $db->prepare("SELECT `ISO`, `ROD_Code`, `Variant_Code`, ISO_ROD_index, `other`, `other_title`, `other_PDF`, `other_audio` FROM `other_titles` WHERE ISO_ROD_index = ? AND (`download_video` IS NULL OR `download_video` = '') ORDER BY `ISO`, `ROD_Code`, `Variant_Code`");
    $stmt_other_titles->bind_param('i', $idx);															// bind parameters for markers
}
else {
	if ($iso == 'ALL') {
		$stmt_other_titles = $db->prepare("SELECT `ISO`, `ROD_Code`, `Variant_Code`, ISO_ROD_index, `other`, `other_title`, `other_PDF`, `other_audio` FROM `other_titles` WHERE `download_video` IS NULL OR `download_video` = '' ORDER BY `ISO`, `ROD_Code`, `Variant_Code`");
		//$stmt_other_titles->bind_param();														// bind parameters for markers
	}
	elseif ($rod == 'ALL' && $var == 'ALL') {
		$stmt_other_titles = $db->prepare("SELECT `ISO`, `ROD_Code`, `Variant_Code`, ISO_ROD_index, `other`, `other_title`, `other_PDF`, `other_audio` FROM `other_titles` WHERE `ISO` = ? AND (`download_video` IS NULL OR `download_video` = '') ORDER BY `ISO`, `ROD_Code`, `Variant_Code`");
		$stmt_other_titles->bind_param('s', $iso);														// bind parameters for markers
	}
	elseif ($rod == 'ALL') {
		$stmt_other_titles = $db->prepare("SELECT `ISO`, `ROD_Code`, `Variant_Code`, ISO_ROD_index, `other`, `other_title`, `other_PDF`, `other_audio` FROM `other_titles` WHERE `ISO` = ? AND `Variant_Code` = ? AND (`download_video` IS NULL OR `download_video` = '') ORDER BY `ISO`, `ROD_Code`, `Variant_Code`");
		$stmt_other_titles->bind_param('ss', $iso, $var);												// bind parameters for markers
	}
	elseif ($var == 'ALL') {
			$stmt_other_titles = $db->prepare("SELECT `ISO`, `ROD_Code`, `Variant_Code`, ISO_ROD_index, `other`, `other_title`, `other_PDF`, `other_audio` FROM `other_titles` WHERE `ISO` = ? AND `ROD_Code` = ? AND (`download_video` IS NULL OR `download_video` = '') ORDER BY `ISO`, `ROD_Code`, `Variant_Code`");
			$stmt_other_titles->bind_param('ss', $iso, $rod);											// bind parameters for markers
	}
	else {
		$stmt_other_titles = $db->prepare("SELECT `ISO`, `ROD_Code`, `Variant_Code`, ISO_ROD_index, `other`, `other_title`, `other_PDF`, `other_audio` FROM `other_titles` WHERE `ISO` = ? AND `ROD_Code` = ? AND `Variant_Code` = ? AND (`download_video` IS NULL OR `download_video` = '') ORDER BY `ISO`, `ROD_Code`, `Variant_Code`");
		$stmt_other_titles->bind_param('sss', $iso, $rod, $var);										// bind parameters for markers
	}
}

$stmt_other_titles->execute();															        		// execute query
$result_other_titles = $stmt_other_titles->get_result();

$other_titles_rows = $result_other_titles->num_rows;
if ($other_titles_rows == 0) {
	die ('The other_titles table does not exist for that ISO code or index. Try a different iso or idx.');
}

$stmt_var = $db->prepare("SELECT Variant_Eng FROM Variants WHERE Variant_Code = ?");

$m=0;

//echo $result_other_titles->num_rows . ' total records<br />'; 

$first = '{';
while ($row_other_titles = $result_other_titles->fetch_assoc()) {
	$idx = (int)$row_other_titles['ISO_ROD_index'];
	$iso = $row_other_titles['ISO'];
	$rod = $row_other_titles['ROD_Code'];
	$var = $row_other_titles['Variant_Code'];
	$Variant_name = '';
	if ($var != '') {
		$stmt_var->bind_param('s', $var);														// bind parameters for markers
		$stmt_var->execute();																	// execute query
		$result_temp = $stmt_var->get_result();
		$row_temp = $result_temp->fetch_assoc();
		$Variant_name = $row_temp['Variant_Eng'];
	}
	$other = $row_other_titles['other'];
	$title = $row_other_titles['other_title'];
	$PDF = $row_other_titles['other_PDF'];
	$audio = $row_other_titles['other_audio'];

	$m++;																						// id
	$first .= '"'.($m-1).'": ';
	$first .= '{"type":                     "Other SE PDF/ePub and Audio",';
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
	$first .= '"idx_query_string":          "idx='.$idx.'",';
	$first .= '"path":          			"data/'.$iso.'/'.($PDF!=''?'PDF':'audio').'"';
	$first .= '},';
	$first .= '"other_se": {';

	$first .= '"other":				        "'.$other.'",';
	$first .= '"title":						"'.$title.'",';
	if ($PDF != '') {
		$first .= '"PDF/ePub":				"'.$PDF.'"';
	}
	else {
		$first .= '"audio":					"'.$audio.'"';
	}

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