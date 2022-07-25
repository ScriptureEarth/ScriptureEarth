<?php
// display all of the language names, ROD codes and variant codes from a major and alternate languages names

	$TryLanguage = $_GET['language'];
	$st = $_GET['st'];
	$response = '';
	$MajorLanguage = '';
	$Variant_major = '';
	
	switch ($st) {
		case 'dut':
			$MajorLanguage = 'LN_Dutch';
			$Variant_major = 'Variant_Dut';
			break;
		case 'spa':
			$MajorLanguage = 'LN_Spanish';
			$Variant_major = 'Variant_Spa';
			break;
		case 'fre':
			$MajorLanguage = 'LN_French';
			$Variant_major = 'Variant_Fre';
			break;
		case 'eng':
			$MajorLanguage = 'LN_English';
			$Variant_major = 'Variant_Eng';
			break;
		case 'por':
			$MajorLanguage = 'LN_Portuguese';
			$Variant_major = 'Variant_Por';
			break;
		default:
			$response = '"st" never found.';
			exit();
	}
	
	if (strlen($TryLanguage) > 2) {
		$hint = 0;
		include './include/conn.inc.php';
		$db = get_my_db();
		
		//$query="SELECT DISTINCT $MajorLanguage, ISO, ROD_Code, Variant_Code, ISO_ROD_index FROM LN_English WHERE ISO_ROD_index IS NOT NULL ORDER BY $MajorLanguage";
		$query="SELECT DISTINCT ISO_ROD_index, ISO, ROD_Code, Variant_Code, LN_English, LN_Spanish, LN_Portuguese, LN_French, LN_Dutch, Def_LN FROM scripture_main";
		if ($result = $db->query($query)) {
			$LN = '';
			while ($row = $result->fetch_assoc()) {
				$ISO_ROD_index = $row['ISO_ROD_index'];
				include './include/00-DBLanguageCountryName.inc.php';								// returns LN
// I NEED TO DO THE ISO !!!!!!!!
				$test = preg_match('/\b'.$TryLanguage.'/i', $LN);
				if ($test === 1) {
					$ISO = $row['ISO'];
					$ROD_Code = $row['ROD_Code'];
					$Variant_Code = $row['Variant_Code'];
					if (is_null($Variant_Code) || $Variant_Code == '') {
						$Variant = '';
					}
					else {
						$resultVar = $db->query("SELECT $Variant_major FROM variants WHERE Variant_Code = '$Variant_Code'");
						$r = $resultVar->fetch_assoc();
						$Variant = $r[$Variant_major];
						$LN = $LN.' ('.$Variant.')';
					}
					$LN = $LN.' [ '.$ISO.($ROD_Code == '00000' ? '' : ' '.$ROD_Code).' ]';
					if ($hint == 0) {
						$response = $LN.'|'.$ISO_ROD_index;
						$hint = 1;
					}
					else {
						$response = $response.'<br />'.$LN.'|'.$ISO_ROD_index;
					}
				}
			}
		}
		
		$query='SELECT DISTINCT alt_lang_name, ISO, ROD_Code, Variant_Code, ISO_ROD_index FROM alt_lang_names WHERE ISO_ROD_index IS NOT NULL ORDER BY alt_lang_name';
		if ($result = $db->query($query)) {
			while ($r = $result->fetch_assoc()) {
				$alt_lang_name = $r['alt_lang_name'];
				$test = preg_match('/\b'.$TryLanguage.'/i', $alt_lang_name);
				if ($test === 1) {
					$ISO_ROD_index = $r['ISO_ROD_index'];
					$ISO = $r['ISO'];
					$ROD_Code = $r['ROD_Code'];
					$Variant_Code = $r['Variant_Code'];
					if (is_null($Variant_Code) || $Variant_Code == '') {
						$Variant = '';
					}
					else {
						$resultVar = $db->query("SELECT $Variant_major FROM variants WHERE Variant_Code = '$Variant_Code'");
						$row = $resultVar->fetch_assoc();
						$Variant = $row[$Variant_major];
						$alt_lang_name = $alt_lang_name.' ('.$Variant.')';
					}
					$alt_lang_name = $alt_lang_name.' [ '.$ISO.($ROD_Code == '00000' ? '' : ' '.$ROD_Code).' ]';
					if ($hint == 0) {
						$response = $alt_lang_name.'|'.$ISO_ROD_index;
						$hint = 1;
					}
					else {
						$response = $response.'<br />'.$alt_lang_name.'|'.$ISO_ROD_index;
					}
				}
			}
		}
		
		if ($hint == 0) {
			$response = ' This language is not found.';
		}
		else {
			$temp = explode('<br />', $response);										
			sort($temp);
			$response = implode('<br />', $temp);
			echo ' Partial language names:<br />'.$response;
		}
	}
	
?>