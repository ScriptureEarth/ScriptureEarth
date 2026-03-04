<?php
	$idx = $row['ISO_ROD_index'];

	/*$stmt_English = $db->prepare("SELECT LN_English FROM LN_English WHERE ISO_ROD_index = ?");
	$stmt_Spanish = $db->prepare("SELECT LN_Spanish FROM LN_Spanish WHERE ISO_ROD_index = ?");
	$stmt_Portuguese = $db->prepare("SELECT LN_Portuguese FROM LN_Portuguese WHERE ISO_ROD_index = ?");
	$stmt_French = $db->prepare("SELECT LN_French FROM LN_French WHERE ISO_ROD_index = ?");
	$stmt_Dutch = $db->prepare("SELECT LN_Dutch FROM LN_Dutch WHERE ISO_ROD_index = ?");
	$stmt_German = $db->prepare("SELECT LN_German FROM LN_German WHERE ISO_ROD_index = ?");
	$stmt_Chinese = $db->prepare("SELECT LN_Chinese FROM LN_Chinese WHERE ISO_ROD_index = ?");
	$stmt_Korean = $db->prepare("SELECT LN_Korean FROM LN_Korean WHERE ISO_ROD_index = ?");
	$stmt_Russian = $db->prepare("SELECT LN_Russian FROM LN_Russian WHERE ISO_ROD_index = ?");
	$stmt_Arabic = $db->prepare("SELECT LN_Arabic FROM LN_Arabic WHERE ISO_ROD_index = ?");*/

	//$res=$db->query("SHOW COLUMNS FROM nav_ln WHERE `Field` LIKE 'LN_%'");	// the following values are ['Field'], ['Type'], ['Collation'], ['Null'], and ['Key']
	//while ($row_temp = $res->fetch_assoc()) {
	//	$fullLName = $row_temp['Field'];									// Language Names - full 
	//	$LName = substr($fullLName, 3);						    			// Language Names - 'LN_'
	//	${"stmt_".$LName} = $db->prepare("SELECT " . $fullLName . " FROM " . $fullLName . " WHERE ISO_ROD_index = ?");

	foreach ($LNames as $key => $LName) {
		${"stmt_".$key}->bind_param('i', $idx);								// bind parameters for markers
		${"stmt_".$key}->execute();											// execute query
		$result_LN = ${"stmt_".$key}->get_result();
		$LNames[$key] = '';													// e.g., $LN_English='';
		if ($result_LN->num_rows > 0) {
			$row_temp=$result_LN->fetch_assoc();
			$LNames[$key] = trim($row_temp['LN_'.$key]);					// e.g., $LN_English=trim($row_temp['LN_English']);
		}
	}

	// e.g., if ($row['LN_English'] == 1) {
	//			$stmt_English = $db->prepare("SELECT LN_English FROM LN_English WHERE ISO_ROD_index = ?");	// create a prepared statement
	//			$stmt_English->bind_param('i', $idx);							// bind parameters for markers
	//			$stmt_English->execute();										// execute query
	//			$result_LN = $stmt_English->get_result();
	//			if ($result_LN->num_rows > 0) {
	//				$row_temp=$result_LN->fetch_assoc();
	//				$LN_English=trim($row_temp['LN_English']);
	//			}
	//		}
	/*foreach ($LN_temps as $LName) {
		$tempLName = substr($LName, 3);										// Remove the 'LN_' prefix
		${"stmt_".$tempLName}->bind_param('i', $idx);						// bind parameters for markers
		${"stmt_".$tempLName}->execute();									// execute query
		$result_LN = ${"stmt_".$tempLName}->get_result();
		$LNames[$tempLName] = '';											// e.g., $LN_English='';
		if ($result_LN->num_rows > 0) {
			$row_temp=$result_LN->fetch_assoc();
			$LNames[$tempLName] = trim($row_temp[$LName]);					// e.g., $LN_English=trim($row_temp['LN_English']);
		}
	}*/
?>