<?php
// AJAX for AddorChange.js function iso_idx()
if (isset($_GET['iso'])) {
	$iso = $_GET['iso'];
	if (preg_match('/^[a-z]{3}$/', $iso)) {
		$MajorLanguage = 'LN_English';
		include './include/conn.inc.php';
		$db = get_my_db();
		$query = "SELECT * FROM scripture_main WHERE ISO = '$iso' ORDER BY ROD_Code, Variant_Code";
		$result = $db->query($query);
		if ($result->num_rows > 0) {
			$query='SELECT alt_lang_name FROM alt_lang_names WHERE ISO_ROD_index = ?';				// alt_lang_names
			$stmt_alt=$db->prepare($query);															// create a prepared statement
			$query = 'SELECT Variant_Eng FROM Variants WHERE Variant_Code = ?';
			$stmt_Var=$db->prepare($query);															// create a prepared statement
			$query='SELECT countries.English FROM ISO_countries, countries WHERE ISO_countries.ISO_ROD_index = ? AND ISO_countries.ISO_countries = countries.ISO_Country ORDER BY countries.English';
			$stmt_ISO_countries=$db->prepare($query);												// create a prepared statement
			$query="SELECT LN_English FROM LN_English WHERE ISO_ROD_index = ?";
			$stmt_LN=$db->prepare($query);
	
			$response = '';
			while($row = $result->fetch_assoc()) {
				$iso = $row['ISO'];																	// ISO
				$rod = $row['ROD_Code'];															// ROD_Code
				$var = $row['Variant_Code'];														// Variant_Code
				$idx = (int)$row['ISO_ROD_index'];													// ISO_ROD_index
				
				$stmt_LN->bind_param("s", $idx);													// bind parameters for markers								// 
				$stmt_LN->execute();																// execute query
				$result_LN = $stmt_LN->get_result();												// instead of bind_result (used for only 1 record):
				$row_temp=$result_LN->fetch_assoc();
				$LN=trim($row_temp['LN_English']);
				// Cross Site Scripting (XSS) attack happens where client side code (usually JavaScript) gets injected into the output of your PHP script. The next line cleans it up.
				$LN = htmlspecialchars($LN, ENT_QUOTES, 'UTF-8');
	
				if ($response != '') { $response .= '|'; }
				$response .= $idx . '~' . $LN . '~';
				$stmt_alt->bind_param("i", $idx);													// bind parameters for markers								// 
				$stmt_alt->execute();																// execute query
				$result_alt = $stmt_alt->get_result();												// instead of bind_result (used for only 1 record):
				$num_alt=$result_alt->num_rows;
				if ($result_alt && $num_alt > 0) {
					$i_alt=0;
					while ($row_alt = $result_alt->fetch_assoc()) {
						if ($i_alt != 0) {															// 0 is the first one
							$response .= ', ';
						}
						$alt_lang_name = $row_alt['alt_lang_name'];
						// Cross Site Scripting (XSS) attack happens where client side code (usually JavaScript) gets injected into the output of your PHP script. The next line cleans it up.
						$alt_lang_name = htmlspecialchars($alt_lang_name, ENT_QUOTES, 'UTF-8');
						$response .= $alt_lang_name;
						$i_alt++;
					}
					$response .= '~';
				}
				else {
					$response .= '' . '~';
				}
				$VD = '';
				if (!is_null($var) && $var != '') {
					$stmt_Var->bind_param("s", $var);												// bind parameters for markers								// 
					$stmt_Var->execute();															// execute query
					$resultVar = $stmt_Var->get_result();											// instead of bind_result (used for only 1 record):
					$numVar=$resultVar->num_rows;
					if ($resultVar && $numVar > 0) {
						$VD_Temp = $resultVar->fetch_assoc();
						$VD = $VD_Temp['Variant_Eng'];
					}
				}
				$response .= $iso . '~' . $rod . '~';
				if ($VD != '') {
					//include './include/00-MajorLanguageVariantCode.inc.php';
					$response .= $VD . '~';
				}
				else {
					$response .= '' . '~';
				}
		
				$stmt_ISO_countries->bind_param("i", $idx);											// bind parameters for markers								// 
				$stmt_ISO_countries->execute();														// execute query
				$result_ISO_countries = $stmt_ISO_countries->get_result();							// instead of bind_result (used for only 1 record):
				$temp_ISO_countries = $result_ISO_countries->fetch_assoc();
				$Eng_country = str_replace("'", "&#x27;", $temp_ISO_countries['English']);			// name of the country in the language version
				while ($temp_ISO_countries = $result_ISO_countries->fetch_assoc()) {
					$Eng_country = $Eng_country.', '.str_replace("'", "&#x27;", $temp_ISO_countries['English']);		// name of the country in the language version
				}
				$response .= $Eng_country;
			}
			$stmt_alt->close();
			$stmt_Var->close();
			$stmt_ISO_countries->close();
			$stmt_LN->close();
			echo $response;
		}
		else {
			echo 'iso does not extist.';
		}
	}
	else {
		echo 'Must be exactly 3 lowercase letters.';
	}
}
?>