<?php

$index = 0;
$first = '';
$marks = [];

require_once '../include/conn.inc.php';															// connect to the database named 'scripture'
$db = get_my_db();

include 'include/v.key.php';																	// get v and key

include 'include/idx.iso.php';																	// get idx or iso

$cc = '';
$rel = '';
if ($index == 0) {																				// or language language and alternate language names
	// retrieve all of the language names
	if (isset($_GET['pln'])) {
		$languageName = $_GET['pln'];
		$index = 3;																				// $index = 3;
	}
	elseif (isset($_GET['cc'])) {
		$cc = $_GET['cc'];
		$index = 4;
		if (isset($_GET['rel'])) {
			// Country code
			$rel = strtolower(trim($_GET['rel']));
			if ($rel != 'ios' && $rel != 'android') {
				die ('You made a mistake.');
			}
		}
	}
	else {
		die ('HACK!');
	}
}

if ($cc != '') {
	if ($rel == 'ios') {
		$stmt_CellPhone = $db->prepare("SELECT `ISO_countries`.`ISO`, `ISO_countries`.`ROD_Code`, `ISO_countries`.`Variant_Code`, `ISO_countries`.ISO_ROD_index, `Cell_Phone_Title`, `Cell_Phone_File`, `optional` FROM `ISO_countries`, `CellPhone` WHERE `ISO_countries`.`ISO_countries` = '$cc' AND `ISO_countries`.`ISO_ROD_index` = `CellPhone`.`ISO_ROD_index` AND `CellPhone`.`Cell_Phone_Title` = 'iOS Asset Package' ORDER BY `ISO_countries`.`ISO`, `ISO_countries`.`ROD_Code`, `ISO_countries`.`Variant_Code`");
	}
	elseif ($rel == 'android') {
		$stmt_CellPhone = $db->prepare("SELECT `ISO_countries`.`ISO`, `ISO_countries`.`ROD_Code`, `ISO_countries`.`Variant_Code`, `ISO_countries`.ISO_ROD_index, `Cell_Phone_Title`, `Cell_Phone_File`, `optional` FROM `ISO_countries`, `CellPhone` WHERE `ISO_countries`.`ISO_countries` = '$cc' AND `ISO_countries`.`ISO_ROD_index` = `CellPhone`.`ISO_ROD_index` AND `CellPhone`.`Cell_Phone_Title` = 'Android App' ORDER BY `ISO_countries`.`ISO`, `ISO_countries`.`ROD_Code`, `ISO_countries`.`Variant_Code`");
	}
	else {
		$stmt_CellPhone = $db->prepare("SELECT `ISO_countries`.`ISO`, `ISO_countries`.`ROD_Code`, `ISO_countries`.`Variant_Code`, `ISO_countries`.ISO_ROD_index, `Cell_Phone_Title`, `Cell_Phone_File`, `optional` FROM `ISO_countries`, `CellPhone` WHERE `ISO_countries`.`ISO_countries` = '$cc' AND `ISO_countries`.`ISO_ROD_index` = `CellPhone`.`ISO_ROD_index` AND (`CellPhone`.`Cell_Phone_Title` = 'Android App' OR `CellPhone`.`Cell_Phone_Title` = 'iOS Asset Package') ORDER BY `ISO_countries`.`ISO`, `ISO_countries`.`ROD_Code`, `ISO_countries`.`Variant_Code`");
	}
}
$stmt_var = $db->prepare("SELECT Variant_Eng FROM Variants WHERE Variant_Code = ?");
$stmt_English = $db->prepare("SELECT LN_English FROM LN_English WHERE ISO_ROD_index = ?");

if ($index == 1) {																			// idx
	$query = "SELECT * FROM scripture_main, nav_ln WHERE `scripture_main`.`ISO_ROD_index` = $idx AND `scripture_main`.`ISO_ROD_index` = `nav_ln`.`ISO_ROD_index`";
	$result=$db->query($query) or die ('Query failed: ' . $db->error . '</body></html>');
	if ($result->num_rows === 0) {
		die ('<div style="background-color: white; color: red; font-size: 16pt; padding-top: 20px; padding-bottom: 20px; margin-top: 200px; ">The ISO/ROD index is not found.</div></body></html>');
	}
	$row = $result->fetch_array();

	$iso = $row['ISO'];
	$rod = $row['ROD_Code'];
	$var = $row['Variant_Code'];
	$idx = $row['ISO_ROD_index'];

	$Variant_name = '';
	if ($var != '') {
		$stmt_var->bind_param('s', $var);													// bind parameters for markers
		$stmt_var->execute();																// execute query
		$result_temp = $stmt_var->get_result();
		$row_temp = $result_temp->fetch_assoc();
		$Variant_name = $row_temp['Variant_Eng'];
	}
	
	$stmt_English->bind_param('i', $idx);													// bind parameters for markers
	$stmt_English->execute();																// execute query
	$result_LN = $stmt_English->get_result();
	$row_temp=$result_LN->fetch_assoc();
	$LN_English=trim($row_temp['LN_English']);

	$m = 1;
	$first = '{';
	$first .= '"'.($m-1).'": ';
	$first .= '{"type": "iso",';
	$first .= '"id": "'.$m.'",';
	$first .= '"attributes": {';
	$first .= '"iso": "'.$iso.'"';
	$first .= '},';
	$first .= '"relationships":';
	$first .= '{';
	$first .= '"rod":				"'.$rod.'",';
	$first .= '"var_code":		   	"'.$var.'",';
	$first .= '"var_name":			"'.$Variant_name.'",';
	$first .= '"iso_query_string":	"iso='.$iso;
	if ($rod != '00000') {
		$first .= '&rod='.$rod;
	}
	if ($var != '') {
		$first .= '&var='.$var;
	}
	$first .= '",';
	$first .= '"idx":		        '.$idx.',';
	$first .= '"idx_query_string":	"idx='.$idx.'",';
	$first .= '"language_name": {';
	$first .= '"English":			"'.$LN_English.'",';
	$first .= '"minority":			""';
	$first .= '}';
	$first .= '}},';
	$first = rtrim($first, ',');
	$first .= '}';

	$marks = [];
	$marks = json_decode($first);
}
elseif ($index == 2) {																		// iso/rod/var
	$query = "SELECT * FROM scripture_main, nav_ln WHERE scripture_main.ISO = '$iso' " . ($rod == 'ALL' ? '' : "AND scripture_main.ROD_Code = '$rod' ") . ($var == 'ALL' ? '' : "AND scripture_main.Variant_Code = '$var'") . " AND `scripture_main`.`ISO_ROD_index` = `nav_ln`.`ISO_ROD_index`";
	$result=$db->query($query) or die ('Query failed:' . $db->error . '</body></html>');
	if ($result->num_rows === 0) {
		die ('<div style="background-color: white; color: red; font-size: 16pt; padding-top: 20px; padding-bottom: 20px; margin-top: 200px; ">The ISO language code is not found.</div></body></html>');
	}

	$m = 0;
	$first = '{';
	while ($row = $result->fetch_array()) {
		$m++;

		$iso = $row['ISO'];
		$rod = $row['ROD_Code'];
		$var = $row['Variant_Code'];
		$idx = $row['ISO_ROD_index'];

		$Variant_name = '';
		if ($var != '') {
			$stmt_var->bind_param('s', $var);												// bind parameters for markers
			$stmt_var->execute();															// execute query
			$result_temp = $stmt_var->get_result();
			$row_temp = $result_temp->fetch_assoc();
			$Variant_name = $row_temp['Variant_Eng'];
		}
		
		$stmt_English->bind_param('i', $idx);												// bind parameters for markers
		$stmt_English->execute();															// execute query
		$result_LN = $stmt_English->get_result();
		$row_temp=$result_LN->fetch_assoc();
		$LN_English=trim($row_temp['LN_English']);

		$first .= '"'.($m-1).'": ';
		$first .= '{"type": "iso",';
		$first .= '"id": "'.$m.'",';
		$first .= '"attributes": {';
		$first .= '"iso": "'.$iso.'"';
		$first .= '},';
		$first .= '"relationships":';
		$first .= '{';
		$first .= '"rod":				"'.$rod.'",';
		$first .= '"var_code":		   	"'.$var.'",';
		$first .= '"var_name":			"'.$Variant_name.'",';
		$first .= '"iso_query_string":	"iso='.$iso;
		if ($rod != '00000') {
			$first .= '&rod='.$rod;
		}
		if ($var != '') {
			$first .= '&var='.$var;
		}
		$first .= '",';
		$first .= '"idx":		        '.$idx.',';
		$first .= '"idx_query_string":	"idx='.$idx.'",';
		$first .= '"language_name": {';
		$first .= '"English":			"'.$LN_English.'",';
		$first .= '"minority":			""';
		$first .= '}';
		$first .= '}},';
	}
	$first = rtrim($first, ',');
	$first .= '}';

	$marks = [];
	$marks = json_decode($first);
}
elseif ($index == 4) {																		// $cc = country code
	$stmt_CellPhone->execute();																// execute query
	$result_CellPhone = $stmt_CellPhone->get_result();
	$temp = [];
	if ($result_CellPhone->num_rows > 0) {
		$reIdx = 0;
		$m = 0;
		$de = 0;
		$first = '{';
		while ($row=$result_CellPhone->fetch_assoc()) {
			$m++;
			$de++;
			
			$Cell_Phone_Title=trim($row['Cell_Phone_Title']);
			$Cell_Phone_File=trim($row['Cell_Phone_File']);
			$Cell_Phone_File = str_replace('\/\/', '//', $Cell_Phone_File);
			$optional=trim($row['optional']);
			
			$idx = (int)$row['ISO_ROD_index'];
			
			if ($reIdx == $idx) {															// if iOS or android is the same?
				$first = rtrim($first, '}}}},');
				$first .= '},';
				if ($rel == 'ios') {
					$first .= '"'.($de-1).'": {';
					$first .= '"title":			"'.$Cell_Phone_Title.'",';
					$first .= '"file":			"'.$Cell_Phone_File.'",';
					$first .= '"optional":		"'.$optional.'"';
					$first .= '}';
				}
				elseif ($rel == 'android') {
					$first .= '"'.($de-1).'": {';
					$first .= '"title":			"'.$Cell_Phone_Title.'",';
					$first .= '"file":			"'.$Cell_Phone_File.'",';
					$first .= '"optional":		"'.$optional.'"';
					$first .= '}';
				}
				else {
					if (str_starts_with($Cell_Phone_File, 'asset:')) {
						$first .= '"'.($de-1).'": {';
					}
					else {
						$first .= '"'.($de-1).'": {';
					}
					$first .= '"title":			"'.$Cell_Phone_Title.'",';
					$first .= '"file":			"'.$Cell_Phone_File.'",';
					$first .= '"optional":		"'.$optional.'"';
					$first .= '}';
				}
				$first .= '}}}},';
				continue;
			}
			
			$iso = $row['ISO'];
			$rod = $row['ROD_Code'];
			$var = $row['Variant_Code'];

			$Variant_name = '';
			if ($var != '') {
				$stmt_var->bind_param('s', $var);											// bind parameters for markers
				$stmt_var->execute();														// execute query
				$result_temp = $stmt_var->get_result();
				$row_temp = $result_temp->fetch_assoc();
				$Variant_name = $row_temp['Variant_Eng'];
			}
		
			$stmt_English->bind_param('i', $idx);											// bind parameters for markers
			$stmt_English->execute();														// execute query
			$result_LN = $stmt_English->get_result();
			$row_temp = $result_LN->fetch_assoc();
			$LN_English = trim($row_temp['LN_English']);
			
			$first .= '"'.($m-1).'": ';
			$first .= '{"type": "iso",';
			$first .= '"id": "'.$m.'",';
			$first .= '"attributes": {';
			$first .= '"iso": "'.$iso.'"';
			$first .= '},';
			$first .= '"relationships": {';
			$first .= '"rod":				"'.$rod.'",';
			$first .= '"var_code":		   	"'.$var.'",';
			$first .= '"var_name":			"'.$Variant_name.'",';
			$first .= '"iso_query_string":	"iso='.$iso;
			if ($rod != '00000') {
				$first .= '&rod='.$rod;
			}
			if ($var != '') {
				$first .= '&var='.$var;
			}
			$first .= '",';
			$first .= '"idx":		        '.$idx.',';
			$first .= '"idx_query_string":	"idx='.$idx.'",';
			$first .= '"language_name": {';
			$first .= '"English":			"'.$LN_English.'",';
			$first .= '"minority":			""';
			$first .= '},';
			$first .= '"device": {';
			if ($rel == 'ios') {
				if ($reIdx != $idx) {														// if idx is the same?
					$first = rtrim($first, '}}}},');
					$de = 1;
					$first .= '"ios": { "'.($de-1).'": {';
					$reIdx = $idx;
				}
				else {
					$first .= ',';
					$first .= '"'.($de-1).'": {';
					$de++;
				}
			}
			elseif ($rel == 'android') {
				if ($reIdx != $idx) {														// if idx is the same?
					$first = rtrim($first, '}}}},');
					$de = 1;
					$first .= '"android": { "'.($de-1).'": {';
					$reIdx = $idx;
				}
				else {
					$first .= ',';
					$first .= '"'.($de-1).'": {';
					$de++;
				}
			}
			else {
				if (str_starts_with($Cell_Phone_File, 'asset:')) {
					if ($reIdx != $idx) {													// if idx is the same?
						$first = rtrim($first, '}}}},');
						$de = 1;
						$first .= '"ios": { "'.($de-1).'": {';
						$reIdx = $idx;
					}
					else {
						$first .= ',';
						$first .= '"'.($de-1).'": {';
						$de++;
					}
				}
				else {
					if ($reIdx != $idx) {													// if idx is the same?
						$first = rtrim($first, '}}}},');
						$de = 1;
						$first .= '"android": { "'.($de-1).'": {';
						$reIdx = $idx;
					}
					else {
						$first .= ',';
						$first .= '"'.($de-1).'": {';
						$de++;
					}
				}
			}
			$first .= '"title":			"'.$Cell_Phone_Title.'",';
			$first .= '"file":			"'.$Cell_Phone_File.'",';
			$first .= '"optional":		"'.$optional.'"';
			$first .= '}}}}},';																// pretend it's all done
		}
		$first = rtrim($first, ',');
		$first .= '}';

		$marks = [];
		$marks = json_decode($first);
	}
	else {
		echo 'There were no records in the database!';
	}
}
else {
	
}

header('Content-Type: application/json');													// instead of <pre></pre>
// An associative array
$json_string = json_encode($marks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

echo $json_string;

// all done!

function removeDiacritics($txt) {
    $transliterationTable = [
		'à' => 'a', 'À' => 'A', 'á' => 'a', 'Á' => 'A', 'â' => 'a', 'Â' => 'A', 'ä' => 'a', 'Ä' => 'A', 'ā' => 'a', 'Ã' => 'A', 'å' => 'a', 'Å' => 'A', 'æ' => 'ae', 'Æ' => 'AE', 'ǣ' => 'ae', 'Ǣ' => 'AE',
		'ç' => 'c', 'Ç' => 'C',
		'�' => 'D', '�' => 'dh', '�' => 'Dh',
		'é' => 'e', 'É' => 'E', 'è' => 'e', 'È' => 'E', 'ë' => 'e', 'Ë' => 'E', 'ē' => 'e', 'Ê' => 'E',
		'ī' => 'i', '�' => 'I', 'í' => 'i', '�' => 'I', 'ì' => 'i', '�' => 'I', 'ï' => 'i', '�' => 'I',
		'ñ' => 'n', 'Ñ' => 'N',
		'ō' => 'o', '�' => 'O', 'ó' => 'o', '�' => 'O', 'ò' => 'o', '�' => 'O', 'ö' => 'o', '�' => 'O', '�' => 'oe', '�' => 'OE', 'œ' => 'oe', 'Œ' => 'OE',
		'ś' => 's', 'Ś' => 'S', '�' => 'SS',
		'ū' => 'u', '�' => 'U', 'ú' => 'u', '�' => 'U', 'ù' => 'u', '�' => 'U', '�' => 'ue', '�' => 'UE',
		'ŷ' => 'y', 'Ŷ' => 'Y', 'ÿ' => 'y', 'Ÿ' => 'Y',
		'ź' => 'z', 'Ź' => 'Z'
	];
	return strtr($txt, $transliterationTable);
}    // or, return str_replace(array_keys($transliterationTable), array_values($transliterationTable), $txt);


// Author: 'ChickenFeet'
function CheckLetters($field){
    $letters = [
        0 => "a à á â ä æ ã å ā",
        1 => "c ç ć č",
        2 => "e é è ê ë ę ė ē",
        3 => "i ī į í ì ï î",
        4 => "l ł",
        5 => "n ñ ń",
        6 => "o ō ø œ õ ó ò ö ô",
        7 => "s ß ś š",
        8 => "u ū ú ù ü û",
        9 => "w ŵ",
        10 => "y ŷ ÿ",
        11 => "z ź ž ż"
    ];
    foreach ($letters as &$values){
        $newValue = substr($values, 0, 1);
        $values = substr($values, 2, strlen($values));
        $values = explode(' ', $values);
        foreach ($values as &$oldValue){
            while (strpos($field, $oldValue) !== false){
                $field = preg_replace('/' . $oldValue . '/', $newValue, $field, 1);
            }
        }
    }
    return $field;
}
?>
