<?php
	$idx = $row['ISO_ROD_index'];

	foreach ($LNames as $LN) {
		${"LN_".$LN} = '';														// e.g., $LN_English = '';	
		// e.g., if ($row['LN_English'] == 1) {
		//			$stmt_English = $db->prepare("SELECT LN_English FROM LN_English WHERE ISO_ROD_index = ?");	// create a prepared statement
		//			$stmt_English->bind_param('i', $idx);						// bind parameters for markers
		//			$stmt_English->execute();									// execute query
		//			$result_LN = $stmt_English->get_result();
		//			if ($result_LN->num_rows > 0) {
		//				$row_temp=$result_LN->fetch_assoc();
		//				$LN_English=trim($row_temp['LN_English']);
		//			}
		//		}
		if ($row['LN_'.$LN] == 1) {
			${"stmt_".$LN}->bind_param('i', $idx);									// bind parameters for markers
			${"stmt_".$LN}->execute();												// execute query
			$result_LN = ${"stmt_".$LN}->get_result();
			if ($result_LN->num_rows > 0) {
				$row_temp=$result_LN->fetch_assoc();
				${"LN_".$LN}=trim($row_temp['LN_'.$LN]);							// e.g., $LN_English=trim($row_temp['LN_English']);
			}
		}
	}
?>