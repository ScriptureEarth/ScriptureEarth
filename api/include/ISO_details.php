<?php
$iso = $row['ISO'];
$rod = $row['ROD_Code'];
$var = $row['Variant_Code'];
$idx = $row['ISO_ROD_index'];
$AddNo = (int)$row['AddNo'];
$AddTheBibleIn=$row['AddTheBibleIn'];
$AddTheScriptureIn=$row['AddTheScriptureIn'];

$Variant_name = '';
if ($var != '') {
	$stmt_var->bind_param('s', $var);													// bind parameters for markers
	$stmt_var->execute();																// execute query
	$result_temp = $stmt_var->get_result();
	$row_temp = $result_temp->fetch_assoc();
	$Variant_name = $row_temp['Variant_Eng'];
}

$country_count = 0;
$country_name = [];
$country_code = [];
//$query="SELECT ISO_countries, English FROM countries, ISO_countries WHERE ISO_countries.ISO_ROD_index = $idx AND ISO_countries.ISO_countries = countries.ISO_Country";
$stmt_country->bind_param('i', $idx);													// bind parameters for markers
$stmt_country->execute();																// execute query
$result_temp = $stmt_country->get_result();
if ($result_temp->num_rows > 0) {
	$country_count = $result_temp->num_rows;											// 0 or 1
	while ($row_temp = $result_temp->fetch_assoc()) {
		$country_name[] = $row_temp['English'];
		$country_code[] = $row_temp['ISO_countries'];
	}
}

$alt_ln = 0;
$alt = [];
//	$query="SELECT alt_lang_name FROM alt_lang_names WHERE ISO_ROD_index = $idx";
//	$result_temp = $db->query($query);
$stmt_alt->bind_param('i', $idx);														// bind parameters for markers
$stmt_alt->execute();																	// execute query
$result_temp = $stmt_alt->get_result();
if ($result_temp->num_rows > 0) {
	$alt_ln = $result_temp->num_rows;													// 0 or 1
	while ($row_alt = $result_temp->fetch_assoc()) {
		$alt[] = $row_alt['alt_lang_name'];
	}
}

$OT_PDF = (int)$row['OT_PDF'];
if ($OT_PDF >= 1) {
//	$query="SELECT COUNT(*) AS OT_PDF_temp FROM OT_PDF_Media WHERE ISO_ROD_index = $idx";
//	$result_temp = $db->query($query);
	$stmt_OT_PDF->bind_param('i', $idx);												// bind parameters for markers
	$stmt_OT_PDF->execute();															// execute query
	$result_temp = $stmt_OT_PDF->get_result();
	$row_temp = $result_temp->fetch_assoc();
	$OT_PDF = $row_temp['OT_PDF_temp'];
}

$NT_PDF = (int)$row['NT_PDF'];
if ($NT_PDF >= 1) {
//	$query="SELECT COUNT(*) AS NT_PDF_temp FROM NT_PDF_Media WHERE ISO_ROD_index = $idx";
//	$result_temp = $db->query($query);
	$stmt_NT_PDF->bind_param('i', $idx);												// bind parameters for markers
	$stmt_NT_PDF->execute();															// execute query
	$result_temp = $stmt_NT_PDF->get_result();
	$row_temp = $result_temp->fetch_assoc();
	$NT_PDF = $row_temp['NT_PDF_temp'];
}

//$FCBH = (int)$row['FCBH'];								// not needed

$OT_Audio = (int)$row['OT_Audio'];
if ($OT_Audio >= 1) {
//	$query="SELECT COUNT(*) AS OT_Audio_temp FROM OT_Audio_Media WHERE ISO_ROD_index = $idx";
//	$result_temp = $db->query($query);
	$stmt_OT_Audio->bind_param('i', $idx);												// bind parameters for markers
	$stmt_OT_Audio->execute();															// execute query
	$result_temp = $stmt_OT_Audio->get_result();
	$row_temp = $result_temp->fetch_assoc();
	$OT_Audio = $row_temp['OT_Audio_temp'];
}

$NT_Audio = (int)$row['NT_Audio'];
if ($NT_Audio >= 1) {
//	$query="SELECT COUNT(*) AS NT_Audio_temp FROM NT_Audio_Media WHERE ISO_ROD_index = $idx";
//	$result_temp = $db->query($query);
	$stmt_NT_Audio->bind_param('i', $idx);												// bind parameters for markers
	$stmt_NT_Audio->execute();															// execute query
	$result_temp = $stmt_NT_Audio->get_result();
	$row_temp = $result_temp->fetch_assoc();
	$NT_Audio = $row_temp['NT_Audio_temp'];
}

$SAB_temp = (int)$row['SAB'];				// 0 - 128
$SAB_Audio = 0;
$SAB_Text = 0;
$SAB_Video = 0;
if ($SAB_temp == 1) {
//	$query="SELECT COUNT(*) AS SAB_temp FROM SAB WHERE ISO_ROD_index = $idx AND SAB_Audio = 1";
//	$result_temp = $db->query($query);
	$SAB_temp = 1;
	$stmt_SAB->bind_param('ii', $idx, $SAB_temp);										// bind parameters for markers
	$stmt_SAB->execute();																// execute query
	$result_temp = $stmt_SAB->get_result();
	$row_temp = $result_temp->fetch_assoc();
	$SAB_Audio = $row_temp['SAB_temp'];
//	$query="SELECT COUNT(*) AS SAB_temp FROM SAB WHERE ISO_ROD_index = $idx AND SAB_Audio = 0";
//	$result_temp = $db->query($query);
	$SAB_temp = 0;
	$stmt_SAB->bind_param('ii', $idx, $SAB_temp);										// bind parameters for markers
	$stmt_SAB->execute();																// execute query
	$result_temp = $stmt_SAB->get_result();
	$row_temp = $result_temp->fetch_assoc();
	$SAB_Text = $row_temp['SAB_temp'];
}

$links = (int)$row['links'];
$map = 0;
$BibleIs = 0;
$BibleIsGospelFilm = 0;
$YouVersion = 0;
$GooglePlay = 0;																		// GooglePlay!
$Kalaam = 0;
$email = 0;
$AppleStore = 0;
$GRN = 0;
$websites = 0;
if ($links == 1) {
//	$query="SELECT LOWER(company) as company_temp, map, YouVersion, GooglePlay FROM links WHERE ISO_ROD_index = $idx AND (map >= 1 OR YouVersion >= 1 OR GooglePlay >= 1 OR company = 'website' OR company = 'webpage')";
//	$result_temp = $db->query($query);
	$stmt_links->bind_param('i', $idx);													// bind parameters for markers
	$stmt_links->execute();																// execute query
	$result_temp = $stmt_links->get_result();
	while ($row_temp = $result_temp->fetch_assoc()) {
		$map_temp = $row_temp['map'];
		$BibleIs_temp = $row_temp['BibleIs'];
		$BibleIsGospelFilm_temp = $row_temp['BibleIsGospelFilm'];
		$YouVersion_temp = $row_temp['YouVersion'];
		$GooglePlay_temp = $row_temp['GooglePlay'];
		$GRN_temp = $row_temp['GRN'];
		$email_temp = $row_temp['email'];
		$Kalaam_temp = $row_temp['Kalaam'];
		$AppleStore_temp = $row_temp['AppleStore'];
		$company_temp = $row_temp['company_temp'];
		if ($map_temp >= 1) {
			$map++;
		}
		if ($BibleIs_temp >= 1) {
			$BibleIs++;
		}
		if ($BibleIsGospelFilm_temp >= 1) {
			$BibleIsGospelFilm++;
		}
		if ($YouVersion_temp >= 1) {
			$YouVersion++;
		}
		if ($GooglePlay_temp >= 1) {
			$GooglePlay++;
		}
		if ($GRN_temp >= 1) {
			$GRN++;
		}
		if ($email_temp >= 1) {
			$email++;
		}
		if ($Kalaam_temp >= 1) {
			$Kalaam++;
		}
		if ($AppleStore_temp >= 1) {
			$AppleStore++;
		}
		if ($company_temp == "website" || $company_temp == "webpage") {
			$websites++;
		}
	}
}

$other_titles = (int)$row['other_titles'];
$watch = (int)$row['watch'];
$buy = (int)$row['buy'];
$study = (int)$row['study'];
$viewer = (int)$row['viewer'];

$CellPhone = (int)$row['CellPhone'];
$GoBibleNum = 0;
$MySwordNum = 0;
$iPhoneCellNum = 0;
$AndroidAppCellNum = 0;
$AppleAppCellNum = 0;
$ePubCellNum = 0;
if ($CellPhone === 1) {
//	$query="SELECT Cell_Phone_Title FROM CellPhone WHERE ISO_ROD_index = $idx";
//	$result_temp = $db->query($query);
	$stmt_CellPhone->bind_param('i', $idx);												// bind parameters for markers
	$stmt_CellPhone->execute();															// execute query
	$result_temp = $stmt_CellPhone->get_result();
	while ($row_temp = $result_temp->fetch_assoc()) {
		if ($result_temp->num_rows <= 0) {
			// this line has been empty
		}
		else {
			$Cell_Phone_Title = $row_temp['Cell_Phone_Title'];
			switch ($Cell_Phone_Title) {
				case "GoBible (Java)":
					$GoBibleNum++;
					break;
				case "MySword (Android)":
					$MySwordNum++;
					break;
				case "iPhone":
					$iPhoneCellNum++;
					break;
				case "Android App":
					$AndroidAppCellNum++;
					break;
				case "iOS Asset Package";
					$AppleAppCellNum++;
					break;		
				case "ePub";
					$ePubCellNum++;
					break;		
				default:
					echo "This is not suppose to happen.<br />";
			}
		}
	}
}

//$BibleIs = (int)$row['BibleIs'];
//$BibleIsGospelFile = (int)$row['BibleIsGospelFlim'];
//$YouVersion = (int)$row['YouVersion'];
//$Bibles_org = (int)$row['Bibles_org'];
$PlaylistAudio = (int)$row['PlaylistAudio'];

$PlaylistVideo = 0;
$PlaylistVideoDownload = 0;
$PlaylistVideo_temp = (int)$row['PlaylistVideo'];
if ($PlaylistVideo_temp >= 1) {
//	$query="SELECT PlaylistVideoDownload FROM PlaylistVideo WHERE ISO_ROD_index = $idx";
//	$result_temp = $db->query($query);
	$stmt_PlaylistVideo->bind_param('i', $idx);											// bind parameters for markers
	$stmt_PlaylistVideo->execute();														// execute query
	$result_temp = $stmt_PlaylistVideo->get_result();
	while ($row_temp = $result_temp->fetch_assoc()) {
		$PlaylistVideoDownload_temp = $row_temp['PlaylistVideoDownload'];
		if ($PlaylistVideoDownload_temp >= 1) {
			$PlaylistVideoDownload++;
		}
		else {
			$PlaylistVideo++;
		}
	}
}

$eBible = (int)$row['eBible'];
$SILlink = (int)$row['SILlink'];
$GRN = (int)$row['GRN'];
?>