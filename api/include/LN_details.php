<?php
	$idx = $row['ISO_ROD_index'];
	$LN_Dutch_check = $row['LN_Dutch'];
	$LN_Spanish_check = $row['LN_Spanish'];
	$LN_French_check = $row['LN_French'];
	$LN_English_check = $row['LN_English'];
	$LN_Portuguese_check = $row['LN_Portuguese'];
	$LN_German_check = $row['LN_German'];
	$LN_Chinese_check = $row['LN_Chinese'];

	$LN_Dutch = '';
	$LN_Spanish = '';
	$LN_French = '';
	$LN_English = '';
	$LN_Portuguese = '';
	$LN_German = '';
	$LN_Chinese = '';

	if ($LN_Dutch_check == 1) {
//					$query="SELECT LN_Dutch FROM LN_Dutch WHERE ISO_ROD_index = $idx";
		$stmt_Dutch->bind_param('i', $idx);									// bind parameters for markers
		$stmt_Dutch->execute();															// execute query
		$result_LN = $stmt_Dutch->get_result();
		if ($result_LN->num_rows > 0) {
			$row_temp=$result_LN->fetch_assoc();
			$LN_Dutch=trim($row_temp['LN_Dutch']);
		}
	}
	if ($LN_Spanish_check == 1) {
//					$query="SELECT LN_Spanish FROM LN_Spanish WHERE ISO_ROD_index = $idx";
		$stmt_Spanish->bind_param('i', $idx);									// bind parameters for markers
		$stmt_Spanish->execute();														// execute query
		$result_LN = $stmt_Spanish->get_result();
		if ($result_LN->num_rows > 0) {
			$row_temp=$result_LN->fetch_assoc();
			$LN_Spanish=trim($row_temp['LN_Spanish']);
		}
	}
	if ($LN_French_check == 1) {
//					$query="SELECT LN_French FROM LN_French WHERE ISO_ROD_index = $idx";
		$stmt_French->bind_param('i', $idx);									// bind parameters for markers
		$stmt_French->execute();														// execute query
		$result_LN = $stmt_French->get_result();
		if ($result_LN->num_rows > 0) {
			$row_temp=$result_LN->fetch_assoc();
			$LN_French=trim($row_temp['LN_French']);
		}
	}
	if ($LN_English_check == 1) {
//					$query="SELECT LN_English FROM LN_English WHERE ISO_ROD_index = $idx";
		$stmt_English->bind_param('i', $idx);									// bind parameters for markers
		$stmt_English->execute();														// execute query
		$result_LN = $stmt_English->get_result();
		if ($result_LN->num_rows > 0) {
			$row_temp=$result_LN->fetch_assoc();
			$LN_English=trim($row_temp['LN_English']);
		}
	}
	if ($LN_Portuguese_check == 1) {
//					$query="SELECT LN_Portuguese FROM LN_Portuguese WHERE ISO_ROD_index = $idx";
		$stmt_Portuguese->bind_param('i', $idx);								// bind parameters for markers
		$stmt_Portuguese->execute();													// execute query
		$result_LN = $stmt_Portuguese->get_result();
		if ($result_LN->num_rows > 0) {
			$row_temp=$result_LN->fetch_assoc();
			$LN_Portuguese=trim($row_temp['LN_Portuguese']);
		}
	}
	if ($LN_German_check == 1) {
//					$query="SELECT LN_German FROM LN_German WHERE ISO_ROD_index = $idx";
		$stmt_German->bind_param('i', $idx);									// bind parameters for markers
		$stmt_German->execute();														// execute query
		$result_LN = $stmt_German->get_result();
		if ($result_LN->num_rows > 0) {
			$row_temp=$result_LN->fetch_assoc();
			$LN_German=trim($row_temp['LN_German']);
		}
	}
	if ($LN_Chinese_check == 1) {
//					$query="SELECT LN_Chinese FROM LN_Chinese WHERE ISO_ROD_index = $idx";
			$stmt_Chinese->bind_param('i', $idx);									// bind parameters for markers
			$stmt_Chinese->execute();														// execute query
			$result_LN = $stmt_Chinese->get_result();
			if ($result_LN->num_rows > 0) {
				$row_temp=$result_LN->fetch_assoc();
				$LN_Chinese=trim($row_temp['LN_Chinese']);
			}
		}
	?>