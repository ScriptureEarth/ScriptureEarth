<?php

$index = 0;
$first = '';
$file_list = [];
$marks = [];

require_once '../include/conn.inc.php';															// connect to the database named 'scripture'
$db = get_my_db();

include 'include/v.key.php';																	// get v and key

include 'include/idx.iso.php';																	// get idx or iso

if ($index == 0) {
	die ('HACK!');
}

if ($index== 1) {
    $stmt_Scriptoria = $db->prepare("SELECT `ISO`, `ROD_Code`, `Variant_Code`, ISO_ROD_index, `subfolder`, `description`, `pre_scriptoria` FROM `SAB_scriptoria` WHERE ISO_ROD_index = ? ORDER BY `ISO`, `ROD_Code`, `Variant_Code`");
    $stmt_Scriptoria->bind_param('i', $idx);													// bind parameters for markers
}
else {
	if ($iso == 'ALL') {
		$stmt_Scriptoria = $db->prepare("SELECT `ISO`, `ROD_Code`, `Variant_Code`, ISO_ROD_index, `subfolder`, `description`, `pre_scriptoria` FROM `SAB_scriptoria` ORDER BY `ISO`, `ROD_Code`, `Variant_Code`");
		//$stmt_Scriptoria->bind_param();												// bind parameters for markers
	}
	elseif ($rod == 'ALL' && $var == 'ALL') {
		$stmt_Scriptoria = $db->prepare("SELECT `ISO`, `ROD_Code`, `Variant_Code`, ISO_ROD_index, `subfolder`, `description`, `pre_scriptoria` FROM `SAB_scriptoria` WHERE `ISO` = ? ORDER BY `ISO`, `ROD_Code`, `Variant_Code`");
		$stmt_Scriptoria->bind_param('s', $iso);												// bind parameters for markers
	}
	elseif ($rod == 'ALL') {
		$stmt_Scriptoria = $db->prepare("SELECT `ISO`, `ROD_Code`, `Variant_Code`, ISO_ROD_index, `subfolder`, `description`, `pre_scriptoria` FROM `SAB_scriptoria` WHERE `ISO` = ? AND `Variant_Code` = ? ORDER BY `ISO`, `ROD_Code`, `Variant_Code`");
		$stmt_Scriptoria->bind_param('ss', $iso, $var);											// bind parameters for markers
	}
	elseif ($var == 'ALL') {
			$stmt_Scriptoria = $db->prepare("SELECT `ISO`, `ROD_Code`, `Variant_Code`, ISO_ROD_index, `subfolder`, `description`, `pre_scriptoria` FROM `SAB_scriptoria` WHERE `ISO` = ? AND `ROD_Code` = ? ORDER BY `ISO`, `ROD_Code`, `Variant_Code`");
			$stmt_Scriptoria->bind_param('ss', $iso, $rod);										// bind parameters for markers
	}
	else {
		$stmt_Scriptoria = $db->prepare("SELECT `ISO`, `ROD_Code`, `Variant_Code`, ISO_ROD_index, `subfolder`, `description`, `pre_scriptoria` FROM `SAB_scriptoria` WHERE `ISO` = ? AND `ROD_Code` = ? AND `Variant_Code` = ? ORDER BY `ISO`, `ROD_Code`, `Variant_Code`");
		$stmt_Scriptoria->bind_param('sss', $iso, $rod, $var);									// bind parameters for markers
	}
}

$stmt_Scriptoria->execute();															        // execute query
$result_Scriptoria = $stmt_Scriptoria->get_result();

$Scriptoria_rows = $result_Scriptoria->num_rows;
if ($Scriptoria_rows == 0) {
	die ('The SAB HTML in the Scriptoria table does not exist. Try a different iso or idx.');
}

$stmt_var = $db->prepare("SELECT Variant_Eng FROM Variants WHERE Variant_Code = ?");

$m=0;
$n=0;

//echo $result_Scriptoria->num_rows . ' total records<br />'; 

$p=0;
$first = '{';
while ($row_Scriptoria = $result_Scriptoria->fetch_assoc()) {
	$idx = (int)$row_Scriptoria['ISO_ROD_index'];
	$iso = $row_Scriptoria['ISO'];
	$rod = $row_Scriptoria['ROD_Code'];
	$var = $row_Scriptoria['Variant_Code'];
	$Variant_name = '';
	if ($var != '') {
		$stmt_var->bind_param('s', $var);														// bind parameters for markers
		$stmt_var->execute();																	// execute query
		$result_temp = $stmt_var->get_result();
		$row_temp = $result_temp->fetch_assoc();
		$Variant_name = $row_temp['Variant_Eng'];
	}
	$subfolder = $row_Scriptoria['subfolder'];
	$description = $row_Scriptoria['description'];
	$pre_scriptoria = $row_Scriptoria['pre_scriptoria'];

	$folder = '';
	if ($pre_scriptoria != '') {
		//$folder = 'sab/'.$pre_scriptoria.'/';
		$folder = 'sab/';
	}
	else {
		$folder = $subfolder;
	}

	if (substr($folder, strlen($folder)-1) == '/') {
		$path = $folder;																		// could be more than one subdirectory
	}
	else {
		$path = 'sab/';
	}

	if (is_dir('../data/'.$iso.'/'.$path) == false) {
		//echo 'is_dir: data/'.$iso.'/'.$path . ' failed<br />';
		continue;
	}
	$file_list = glob('../data/'.$iso.'/'.$path .'*.html');
	if (empty($file_list)) {
		continue;
	}

	natsort($file_list);																		// natural sort

	$p=0;
	$n=0;
	$SAB_AbbreviationTemp = '';
	$pathTemp = '';
	foreach ($file_list as $file_name) {														// e.g. annC-01-GEN-002.html
		$file_name = ltrim(strrchr($file_name, '/'), '/');										// just the filename and not the path
		if (strpos($file_name, 'index.html')) {
			continue;
		}
		$Book_Chapter_HTML = $file_name;
		$SAB_Abbreviation = preg_replace('/[a-zA-Z0-9]+-[0-9]+-([1-3A-Z][A-Z]{2})-[0-9]+\.html/', '\1', $file_name);
		$SAB_Book = (int)preg_replace('/[a-zA-Z0-9]+-([0-9]+)-[1-3A-Z][A-Z]{2}-[0-9]+\.html/', '\1', $file_name);
		$SAB_Chapter = (int)preg_replace('/.*[A-Z]-([0-9]+)\.html/', '\1', $file_name);
		
		if ($path != $pathTemp) {																// if idx doesn't equal to the idx of the last record
			$pathTemp = $path;
			$m++;																				// id
			$first .= '"'.($m-1).'": ';
			$first .= '{"type":                     "SAB",';
			$first .= '"id":                        "'.$m.'",';
			$first .= '"attributes": {';
			$first .= '"iso":                       "'.$iso.'",';
			$first .= '"rod":				        "'.$rod.'",';
			$first .= '"var_code":		    	    "'.$var.'",';
			$first .= '"var_name":					"'.$Variant_name.'",';
			$first .= '"iso_query_string":	        "sortby=lang&iso='.$iso;
			if ($rod != '00000') {
				$first .= '&rod='.$rod;
			}
			if ($var != '') {
				$first .= '&var='.$var;
			}
			$first .= '",';
			$first .= '"idx":		                '.$idx.',';
			$first .= '"idx_query_string":          "sortby=lang&idx='.$idx.'",';	
			$first .= '"path":          			"data/'.$iso.'/'.$path.'"';	
			$first .= '},';
			$first .= '"relationships": {';
		}

		if ($p == 0) {
			$first .= '"audio": {';
		}
		$p=1;

		if ($SAB_Abbreviation != $SAB_AbbreviationTemp) {
			if ($n != 0) {																		// change of book
				$first = rtrim($first, ',');
				$first .= '},';
				$n=0;
			}
			$first .= '"'. $SAB_Abbreviation . '": {';											// display abbreviation book name
			$SAB_AbbreviationTemp = $SAB_Abbreviation;
		}
		$first .= '"'.$n++.'":						"'.$Book_Chapter_HTML . ' chapter: ' . $SAB_Chapter.'",'; 
	}

	$first = rtrim($first, ',');																// finished books
	$first .= '}}}},';
}
$first = rtrim($first, ',');																	// all done with isos
$first .= '}';

//echo $first;
//exit;

$marks = [];
$marks = json_decode($first);

header('Content-Type: application/json');														// instead of <pre></pre>
// An associative array
$json_string = json_encode($marks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
//echo '<pre>'.$json_string.'</pre>';
echo $json_string;

?>