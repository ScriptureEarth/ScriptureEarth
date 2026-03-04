<?php
// This PHP file won't work. It is only included in records.php.

// This PHP file is included in rexords.php. It gets the major language names for the current ISO_ROD_index
// and stores them in the $LNames array. It also gets the alternate language names, if any,
// and stores them in the $alt array. The $LNames array is used to create the "language_name" object
// in the JSON output, while the $alt array is used to create the "alternate_language_names" object in the JSON output.

	$idx = $row['ISO_ROD_index'];
	$LNames = [];
	$LName = '';
	$temp_LName = '';
	$res=$db->query("SHOW COLUMNS FROM nav_ln WHERE `Field` LIKE 'LN_%'");	// the following values are ['Field'], ['Type'], ['Collation'], ['Null'], and ['Key']
	while ($row_temp = $res->fetch_assoc()) {
		$LName = $row_temp['Field'];										// Language Names - full name, e.g., 'LN_English'
		$temp_LName = substr($LName, 3);									// Remove the 'LN_' prefix
		$stmt_temp = $db->prepare("SELECT $LName FROM $LName WHERE ISO_ROD_index = ?");     // prepare statements for all of the LN_... navigatianal language names
		$stmt_temp->bind_param('i', $idx);									// bind parameters for markers
		$stmt_temp->execute();												// execute query
		$result_LN = $stmt_temp->get_result();
		$LNames[$temp_LName] = '';											// e.g., $LN_English='';
		if ($result_LN->num_rows > 0) {
			$row_temp=$result_LN->fetch_assoc();
			$LNames[$temp_LName] = trim($row_temp[$LName]);					// e.g., $LN_English=trim($row_temp['LN_English']);
		}
	}

/*
	$LN_Dutch_check = $row['LN_Dutch'];
	$LN_Spanish_check = $row['LN_Spanish'];
	$LN_French_check = $row['LN_French'];
	$LN_English_check = $row['LN_English'];
	$LN_Portuguese_check = $row['LN_Portuguese'];
	$LN_German_check = $row['LN_German'];
	$LN_Chinese_check = $row['LN_Chinese'];
	$LN_Korean_check = $row['LN_Korean'];
	$LN_Russian_check = $row['LN_Russian'];
	$LN_Arabic_check = $row['LN_Arabic'];

	if ($LN_Dutch_check == 1) {
//					$query="SELECT LN_Dutch FROM LN_Dutch WHERE ISO_ROD_index = $idx";
		$stmt_Dutch->bind_param('i', $idx);												// bind parameters for markers
		$stmt_Dutch->execute();															// execute query
		$result_LN = $stmt_Dutch->get_result();
		if ($result_LN->num_rows > 0) {
			$row_temp=$result_LN->fetch_assoc();
			$LNames['Dutch']=trim($row_temp['LN_Dutch']);
		}
	}
	if ($LN_Spanish_check == 1) {
//					$query="SELECT LN_Spanish FROM LN_Spanish WHERE ISO_ROD_index = $idx";
		$stmt_Spanish->bind_param('i', $idx);											// bind parameters for markers
		$stmt_Spanish->execute();														// execute query
		$result_LN = $stmt_Spanish->get_result();
		if ($result_LN->num_rows > 0) {
			$row_temp=$result_LN->fetch_assoc();
			$LNames['Spanish']=trim($row_temp['LN_Spanish']);
		}
	}
	if ($LN_French_check == 1) {
//					$query="SELECT LN_French FROM LN_French WHERE ISO_ROD_index = $idx";
		$stmt_French->bind_param('i', $idx);											// bind parameters for markers
		$stmt_French->execute();														// execute query
		$result_LN = $stmt_French->get_result();
		if ($result_LN->num_rows > 0) {
			$row_temp=$result_LN->fetch_assoc();
			$LNames['French']=trim($row_temp['LN_French']);
		}
	}
	if ($LN_English_check == 1) {
//					$query="SELECT LN_English FROM LN_English WHERE ISO_ROD_index = $idx";
		$stmt_English->bind_param('i', $idx);											// bind parameters for markers
		$stmt_English->execute();														// execute query
		$result_LN = $stmt_English->get_result();
		if ($result_LN->num_rows > 0) {
			$row_temp=$result_LN->fetch_assoc();
			$LNames['English']=trim($row_temp['LN_English']);
		}
	}
	if ($LN_Portuguese_check == 1) {
//					$query="SELECT LN_Portuguese FROM LN_Portuguese WHERE ISO_ROD_index = $idx";
		$stmt_Portuguese->bind_param('i', $idx);										// bind parameters for markers
		$stmt_Portuguese->execute();													// execute query
		$result_LN = $stmt_Portuguese->get_result();
		if ($result_LN->num_rows > 0) {
			$row_temp=$result_LN->fetch_assoc();
			$LNames['Portuguese']=trim($row_temp['LN_Portuguese']);
		}
	}
	if ($LN_German_check == 1) {
//					$query="SELECT LN_German FROM LN_German WHERE ISO_ROD_index = $idx";
		$stmt_German->bind_param('i', $idx);											// bind parameters for markers
		$stmt_German->execute();														// execute query
		$result_LN = $stmt_German->get_result();
		if ($result_LN->num_rows > 0) {
			$row_temp=$result_LN->fetch_assoc();
			$LNames['German']=trim($row_temp['LN_German']);
		}
	}
	if ($LN_Chinese_check == 1) {
//					$query="SELECT LN_Chinese FROM LN_Chinese WHERE ISO_ROD_index = $idx";
		$stmt_Chinese->bind_param('i', $idx);											// bind parameters for markers
		$stmt_Chinese->execute();														// execute query
		$result_LN = $stmt_Chinese->get_result();
		if ($result_LN->num_rows > 0) {
			$row_temp=$result_LN->fetch_assoc();
			$LNames['Chinese']=trim($row_temp['LN_Chinese']);
		}
	}
	if ($LN_Korean_check == 1) {
//					$query="SELECT LN_Korean FROM LN_Korean WHERE ISO_ROD_index = $idx";
		$stmt_Korean->bind_param('i', $idx);									// bind parameters for markers
		$stmt_Korean->execute();														// execute query
		$result_LN = $stmt_Korean->get_result();
		if ($result_LN->num_rows > 0) {
			$row_temp=$result_LN->fetch_assoc();
			$LNames['Korean']=trim($row_temp['LN_Korean']);
		}
	}
	if ($LN_Russian_check == 1) {
//			$query="SELECT LN_Russian FROM LN_Russian WHERE ISO_ROD_index = $idx";
		$stmt_Russian->bind_param('i', $idx);									// bind parameters for markers
		$stmt_Russian->execute();														// execute query
		$result_LN = $stmt_Russian->get_result();
		if ($result_LN->num_rows > 0) {
			$row_temp=$result_LN->fetch_assoc();
			$LNames['Russian']=trim($row_temp['LN_Russian']);
		}
	}
	if ($LN_Arabic_check == 1) {
//			$query="SELECT LN_Arabic FROM LN_Arabic WHERE ISO_ROD_index = $idx";
		$stmt_Arabic->bind_param('i', $idx);									// bind parameters for markers
		$stmt_Arabic->execute();														// execute query
		$result_LN = $stmt_Arabic->get_result();
		if ($result_LN->num_rows > 0) {
			$row_temp=$result_LN->fetch_assoc();
			$LNames['Arabic']=trim($row_temp['LN_Arabic']);
		}
	*/
?>