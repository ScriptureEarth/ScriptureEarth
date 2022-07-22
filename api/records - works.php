<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JSON - ISO</title>
</head>
<body>
<?php

//use function PHPSTORM_META\map;

$index = 0;
$marks = [];
//$temp_array = [];

if (isset($_GET['key'])) {																		// key
	$key = (int)$_GET['key'];
	if ($key != 51243) {
		die ('HACK!');
	}
}
if (isset($_GET['v'])) {																		// version
	$v = (float)$_GET['v'];
	if ($v != .5) {																				// version = 1
		die ('HACK!');
	}
}

if (isset($_GET['iso_rod_index'])) {															// ISO_ROD_Code
	$ISO_ROD_index = (int)$_GET['iso_rod_index'];
	$temp = preg_match('/^([0-9]*)/', $ISO_ROD_index, $match);
	if ($temp == 0) {
		die ('HACK!');
	}
	$ISO_ROD_index = (int)$match[1];
	$index = 1;																					// $index = 1
}
elseif (isset($_GET['iso'])) {																	// or ISO
	$iso = $_GET['iso'];
	$temp = preg_match('/^([a-z]{3})/', $iso, $match);
	if ($temp == 0) {
		die ('HACK!');
	}
	$iso = $match[1];
	if (isset($_GET['rod'])) {
		$rod = $_GET['rod'];
		$temp = preg_match('/^([0-9a-zA-Z]{0,5})/', $iso_rod_index, $match);
		if ($temp == 0) {
			$rod = '00000';
		}
		else {
			$rod = $match[1];
		}
	}
	else {
		$rod = '00000';
	}
	if (isset($_GET['variant'])) {
		$variant = $_GET['variant'];
		$temp = preg_match('/^([a-zA-Z])/', $variant, $match);
		if ($temp == 0) {
			$variant = '';
		}
		else {
			$variant = $match[1];
		}
	}
	else {
		$variant = '';
	}
	$index = 2;																					// $index = 2;
}
else {																							// or language language and alternate language names
	// retrieve all of the language names
	if (isset($_GET['ln'])) {
		$languageName = $_GET['ln'];
		$index = 3;																				// $index = 3;
	}
	else {
		die ('HACK!');
	}
}

require_once '../include/conn.inc.php';															// connect to the database named 'scripture'
$db = get_my_db();


$stmt_iso = $db->prepare("SELECT * FROM scripture_main WHERE ISO = ?");
$stmt_main = $db->prepare("SELECT * FROM scripture_main WHERE ISO_ROD_index = ?");
$stmt_alt = $db->prepare("SELECT alt_lang_name FROM alt_lang_names WHERE ISO_ROD_index = ?");
$stmt_OT_PDF = $db->prepare("SELECT COUNT(*) AS OT_PDF_temp FROM OT_PDF_Media WHERE ISO_ROD_index = ?");
$stmt_NT_PDF = $db->prepare("SELECT COUNT(*) AS NT_PDF_temp FROM NT_PDF_Media WHERE ISO_ROD_index = ?");
$stmt_OT_Audio = $db->prepare("SELECT COUNT(*) AS OT_Audio_temp FROM OT_Audio_Media WHERE ISO_ROD_index = ?");
$stmt_NT_Audio = $db->prepare("SELECT COUNT(*) AS NT_Audio_temp FROM NT_Audio_Media WHERE ISO_ROD_index = ?");
$stmt_SAB = $db->prepare("SELECT COUNT(*) AS SAB_temp FROM SAB WHERE ISO_ROD_index = ? AND SAB_Audio = ?");
$stmt_links = $db->prepare("SELECT LOWER(company) as company_temp, map, YouVersion, GooglePlay FROM links WHERE ISO_ROD_index = ? AND (map >= 1 OR YouVersion >= 1 OR GooglePlay >= 1 OR company = 'website' OR company = 'webpage')");
$stmt_CellPhone = $db->prepare("SELECT Cell_Phone_Title FROM CellPhone WHERE ISO_ROD_index = ?");
$stmt_PlaylistVideo = $db->prepare("SELECT PlaylistVideoDownload FROM PlaylistVideo WHERE ISO_ROD_index = ?");
$stmt_English = $db->prepare("SELECT LN_English FROM LN_English WHERE ISO_ROD_index = ?");
$stmt_Spanish = $db->prepare("SELECT LN_Spanish FROM LN_Spanish WHERE ISO_ROD_index = ?");
$stmt_Portuguese = $db->prepare("SELECT LN_Portuguese FROM LN_Portuguese WHERE ISO_ROD_index = ?");
$stmt_French = $db->prepare("SELECT LN_French FROM LN_French WHERE ISO_ROD_index = ?");
$stmt_Dutch = $db->prepare("SELECT LN_Dutch FROM LN_Dutch WHERE ISO_ROD_index = ?");
$stmt_German = $db->prepare("SELECT LN_German FROM LN_German WHERE ISO_ROD_index = ?");
$stmt_iso_languages = $db->prepare("SELECT DISTINCT ISO_ROD_index, ISO, ROD_Code, Variant_Code, LN_Dutch, LN_Spanish, LN_French, LN_English, LN_Portuguese, LN_German, Def_LN FROM scripture_main ORDER BY ISO");
$stmt_alt1 = $db->prepare("SELECT DISTINCT ISO_ROD_index FROM alt_lang_names WHERE alt_lang_name REGEXP '[[:<:]]?'");
//$stmt_alt2 = $db->prepare("SELECT DISTINCT ISO_ROD_index FROM alt_lang_names WHERE alt_lang_name REGEXP '(^| )?' AND ISO_ROD_index NOT IN (".implode(',', ?).")");		// won't quick work under MariaDB 10.1.44


if ($index == 1) {
	$query = "SELECT * FROM scripture_main WHERE ISO_ROD_index = $ISO_ROD_index";
	$result=$db->query($query) or die ('Query failed: ' . $db->error . '</body></html>');
	if ($result->num_rows <= 0) {
		die ('<div style="background-color: white; color: red; font-size: 16pt; padding-top: 20px; padding-bottom: 20px; margin-top: 200px; ">The ISO/ROD index is not found.</div></body></html>');
	}
	$row = $result->fetch_array();
	$ISO = trim($row['ISO']);
	$ROD_Code = trim($row['ROD_Code']);
	$Variant_Code = trim($row['Variant_Code']);
	$LN_Dutch_check = $row['LN_Dutch'];
	$LN_Spanish_check = $row['LN_Spanish'];
	$LN_French_check = $row['LN_French'];
	$LN_English_check = $row['LN_English'];
	$LN_Portuguese_check = $row['LN_Portuguese'];
	$LN_German_check = $row['LN_German'];
	$AddNo = (int)$row['AddNo'];
	$AddTheBibleIn=$row['AddTheBibleIn'];
	$AddTheScriptureIn=$row['AddTheScriptureIn'];

	$alt_ln = 0;
//			$query="SELECT alt_lang_name FROM alt_lang_names WHERE ISO_ROD_index = $ISO_ROD_index";
//			$result_temp = $db->query($query);
	$stmt_alt->bind_param('i', $ISO_ROD_index);													// bind parameters for markers
	$stmt_alt->execute();																		// execute query
	$result_temp = $stmt_alt->get_result();
	if ($result_temp->num_rows > 0) {
		$alt_ln = $result_temp->num_rows;
	}

	$OT_PDF = (int)$row['OT_PDF'];
	if ($OT_PDF >= 1) {
//				$query="SELECT COUNT(*) AS OT_PDF_temp FROM OT_PDF_Media WHERE ISO_ROD_index = $ISO_ROD_index";
//				$result_temp = $db->query($query);
		$stmt_OT_PDF->bind_param('i', $ISO_ROD_index);											// bind parameters for markers
		$stmt_OT_PDF->execute();																// execute query
		$result_temp = $stmt_OT_PDF->get_result();
		$row_temp = $result_temp->fetch_assoc();
		$OT_PDF = $row_temp['OT_PDF_temp'];
	}

	$NT_PDF = (int)$row['NT_PDF'];
	if ($NT_PDF >= 1) {
//				$query="SELECT COUNT(*) AS NT_PDF_temp FROM NT_PDF_Media WHERE ISO_ROD_index = $ISO_ROD_index";
//				$result_temp = $db->query($query);
		$stmt_NT_PDF->bind_param('i', $ISO_ROD_index);											// bind parameters for markers
		$stmt_NT_PDF->execute();																// execute query
		$result_temp = $stmt_NT_PDF->get_result();
		$row_temp = $result_temp->fetch_assoc();
		$NT_PDF = $row_temp['NT_PDF_temp'];
	}

	//$FCBH = (int)$row['FCBH'];								// not needed
	
	$OT_Audio = (int)$row['OT_Audio'];
	if ($OT_Audio >= 1) {
//				$query="SELECT COUNT(*) AS OT_Audio_temp FROM OT_Audio_Media WHERE ISO_ROD_index = $ISO_ROD_index";
//				$result_temp = $db->query($query);
		$stmt_OT_Audio->bind_param('i', $ISO_ROD_index);										// bind parameters for markers
		$stmt_OT_Audio->execute();																// execute query
		$result_temp = $stmt_OT_Audio->get_result();
		$row_temp = $result_temp->fetch_assoc();
		$OT_Audio = $row_temp['OT_Audio_temp'];
	}

	$NT_Audio = (int)$row['NT_Audio'];
	if ($NT_Audio >= 1) {
//				$query="SELECT COUNT(*) AS NT_Audio_temp FROM NT_Audio_Media WHERE ISO_ROD_index = $ISO_ROD_index";
//				$result_temp = $db->query($query);
		$stmt_NT_Audio->bind_param('i', $ISO_ROD_index);										// bind parameters for markers
		$stmt_NT_Audio->execute();																// execute query
		$result_temp = $stmt_NT_Audio->get_result();
		$row_temp = $result_temp->fetch_assoc();
		$NT_Audio = $row_temp['NT_Audio_temp'];
	}

	$SAB_temp = (int)$row['SAB'];
	$SAB_Audio = 0;
	$SAB_Text = 0;
	$SAB_Video = 0;
	if ($SAB_temp === 1) {
//				$query="SELECT COUNT(*) AS SAB_temp FROM SAB WHERE ISO_ROD_index = $ISO_ROD_index AND SAB_Audio = 1";
//				$result_temp = $db->query($query);
		$SAB_temp = 1;
		$stmt_SAB->bind_param('ii', $ISO_ROD_index, $SAB_temp);									// bind parameters for markers
		$stmt_SAB->execute();																	// execute query
		$result_temp = $stmt_SAB->get_result();
		$row_temp = $result_temp->fetch_assoc();
		$SAB_Audio = $row_temp['SAB_temp'];
//				$query="SELECT COUNT(*) AS SAB_temp FROM SAB WHERE ISO_ROD_index = $ISO_ROD_index AND SAB_Audio = 0";
//				$result_temp = $db->query($query);
		$SAB_temp = 0;
		$stmt_SAB->bind_param('ii', $ISO_ROD_index, $SAB_temp);									// bind parameters for markers
		$stmt_SAB->execute();																	// execute query
		$result_temp = $stmt_SAB->get_result();
		$row_temp = $result_temp->fetch_assoc();
		$SAB_Text = $row_temp['SAB_temp'];
	}

	$links = (int)$row['links'];
	$map = 0;
	$YouVersion = 0;
	$GooglePlay = 0;																			// GooglePlay!
	$websites = 0;
	if ($links === 1) {
//				$query="SELECT LOWER(company) as company_temp, map, YouVersion, GooglePlay FROM links WHERE ISO_ROD_index = $ISO_ROD_index AND (map >= 1 OR YouVersion >= 1 OR GooglePlay >= 1 OR company = 'website' OR company = 'webpage')";
//				$result_temp = $db->query($query);
		$stmt_links->bind_param('i', $ISO_ROD_index);											// bind parameters for markers
		$stmt_links->execute();																	// execute query
		$result_temp = $stmt_links->get_result();
		while ($row_temp = $result_temp->fetch_assoc()) {
			$map_temp = $row_temp['map'];
			$YouVersion_temp = $row_temp['YouVersion'];
			$GooglePlay_temp = $row_temp['GooglePlay'];
			$company_temp = $row_temp['company_temp'];
			if ($map_temp >= 1) {
				$map++;
			}
			if ($YouVersion_temp >= 1) {
				$YouVersion++;
			}
			if ($GooglePlay_temp >= 1) {
				$GooglePlay++;
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
	$WindowsCellNum = 0;
	$BlackberryNum = 0;
	$StandardCellNum = 0;
	$AdroidAppCellNum = 0;
	$AppleAppCellNum = 0;
	if ($CellPhone === 1) {
//				$query="SELECT Cell_Phone_Title FROM CellPhone WHERE ISO_ROD_index = $ISO_ROD_index";
//				$result_temp = $db->query($query);
		$stmt_CellPhone->bind_param('i', $ISO_ROD_index);										// bind parameters for markers
		$stmt_CellPhone->execute();																// execute query
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
					case "Windows":
						$WindowsCellNum++;
						break;
					case "Blackberry":
						$BlackberryNum++;
						break;
					case "Standard":
						$StandardCellNum++;
						break;
					case "Android App":
						$AdroidAppCellNum++;
						break;
					case "Apple App";
						$AppleAppCellNum++;
						break;		
					default:
						echo "This is not suppose to happen.<br />";
				}
			}
		}
	}

	$AddNo = (int)$row['AddNo'];
	$AddTheBibleIn = (int)$row['AddTheBibleIn'];
	$AddTheScriptureIn = (int)$row['AddTheScriptureIn'];
	$BibleIs = (int)$row['BibleIs'];
	$YouVersion = (int)$row['YouVersion'];
	$Bibles_org = (int)$row['Bibles_org'];
	$PlaylistAudio = (int)$row['PlaylistAudio'];

	$PlaylistVideo = 0;
	$PlaylistVideoDownload = 0;
	$PlaylistVideo_temp = (int)$row['PlaylistVideo'];
	if ($PlaylistVideo_temp >= 1) {
//				$query="SELECT PlaylistVideoDownload FROM PlaylistVideo WHERE ISO_ROD_index = $ISO_ROD_index";
//				$result_temp = $db->query($query);
		$stmt_PlaylistVideo->bind_param('i', $ISO_ROD_index);									// bind parameters for markers
		$stmt_PlaylistVideo->execute();															// execute query
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

//			$query="SELECT LN_English FROM LN_English WHERE ISO_ROD_index = $ISO_ROD_index";
//			$result_temp = $db->query($query);
	$stmt_English->bind_param('i', $ISO_ROD_index);												// bind parameters for markers
	$stmt_English->execute();																	// execute query
	$result_temp = $stmt_English->get_result();
	if ($result_temp->num_rows <= 0) {
		$LN_English = '';
	}
	else {
		$row_temp = $result_temp->fetch_assoc();
		$LN_English = $row_temp['LN_English'];
	}
//			$query="SELECT LN_Spanish FROM LN_Spanish WHERE ISO_ROD_index = $ISO_ROD_index";
//			$result_temp = $db->query($query);
	$stmt_Spanish->bind_param('i', $ISO_ROD_index);												// bind parameters for markers
	$stmt_Spanish->execute();																	// execute query
	$result_temp = $stmt_Spanish->get_result();
	if ($result_temp->num_rows <= 0) {
		$LN_Spanish = '';
	}
	else {
		$row_temp = $result_temp->fetch_assoc();
		$LN_Spanish = $row_temp['LN_Spanish'];
	}
//			$query="SELECT LN_Portuguese FROM LN_Portuguese WHERE ISO_ROD_index = $ISO_ROD_index";
//			$result_temp = $db->query($query);
	$stmt_Portuguese->bind_param('i', $ISO_ROD_index);											// bind parameters for markers
	$stmt_Portuguese->execute();																// execute query
	$result_temp = $stmt_Portuguese->get_result();
	if ($result_temp->num_rows <= 0) {
		$LN_Portuguese = '';
	}
	else {
		$row_temp = $result_temp->fetch_assoc();
		$LN_Portuguese = $row_temp['LN_Portuguese'];
	}
//			$query="SELECT LN_French FROM LN_French WHERE ISO_ROD_index = $ISO_ROD_index";
//			$result_temp = $db->query($query);
	$stmt_French->bind_param('i', $ISO_ROD_index);												// bind parameters for markers
	$stmt_French->execute();																	// execute query
	$result_temp = $stmt_French->get_result();
	if ($result_temp->num_rows <= 0) {
		$LN_French = '';
	}
	else {
		$row_temp = $result_temp->fetch_assoc();
		$LN_French = $row_temp['LN_French'];
	}
//			$query="SELECT LN_Dutch FROM LN_Dutch WHERE ISO_ROD_index = $ISO_ROD_index";
//			$result_temp = $db->query($query);
	$stmt_Dutch->bind_param('i', $ISO_ROD_index);												// bind parameters for markers
	$stmt_Dutch->execute();																		// execute query
	$result_temp = $stmt_Dutch->get_result();
	if ($result_temp->num_rows <= 0) {
		$LN_Dutch = '';
	}
	else {
		$row_temp = $result_temp->fetch_assoc();
		$LN_Dutch = $row_temp['LN_Dutch'];
	}
//			$query="SELECT LN_German FROM LN_German WHERE ISO_ROD_index = $ISO_ROD_index";
//			$result_temp = $db->query($query);
	$stmt_German->bind_param('i', $ISO_ROD_index);												// bind parameters for markers
	$stmt_German->execute();																	// execute query
	$result_temp = $stmt_German->get_result();
	if ($result_temp->num_rows <= 0) {
		$LN_German = '';
	}
	else {
		$row_temp = $result_temp->fetch_assoc();
		$LN_German = $row_temp['LN_German'];
	}

	$marks[] = ["links" => ["self" => "https://ScriptureEarth.org"]];
	$marks[] = ["data" => ["ISO"=>$ISO, "ROD code"=>$ROD_Code, "variant code"=>$Variant_Code, "ISO_ROD_index"=>$ISO_ROD_index, "OT PDF"=>$OT_PDF, "NT PDF"=>$NT_PDF, "OT Audio"=>$OT_Audio, "NT Audio"=>$NT_Audio, "links"=>$links, "other titles"=>$other_titles, "watch"=>$watch, "buy"=>$buy, "study"=>$study, "viewer"=>$viewer, "Cell Phone"=>$CellPhone, "Bible.is"=>$BibleIs, "You Version"=>$YouVersion, "Bibles.org"=>$Bibles_org, "Playlist Audio"=>$PlaylistAudio, "Playlist Video"=>$PlaylistVideo, "SAB Audio"=>$SAB_Audio, "SAB Text"=>$SAB_Text, "eBible"=>$eBible, "SIL link"=>$SILlink, "Global Recaords Network"=>$GRN]];
}
elseif ($index == 2) {
	$query = "SELECT * FROM scripture_main WHERE ISO = '$iso' AND ROD_Code = '$rod' AND Variant_Code = '$variant'";
	$result=$db->query($query) or die ('Query failed:' . $db->error . '</body></html>');
	if ($result->num_rows <= 0) {
		die ('<div style="background-color: white; color: red; font-size: 16pt; padding-top: 20px; padding-bottom: 20px; margin-top: 200px; ">The ISO language code is not found.</div></body></html>');
	}
	//$temp_array = [];
	$m = 0;
	//$first = '{"links": {"self": "https://ScriptureEarth.org"},';		// must HAVE " around the strings!
	//$first .= '"data": {';
	$first = '{';
	while ($row = $result->fetch_array()) {
		$m++;
		$ISO = trim($row['ISO']);
		$ROD_Code = trim($row['ROD_Code']);
		$Variant_Code = trim($row['Variant_Code']);
		$ISO_ROD_index = (int)$row['ISO_ROD_index'];
		$LN_Dutch_check = $row['LN_Dutch'];
		$LN_Spanish_check = $row['LN_Spanish'];
		$LN_French_check = $row['LN_French'];
		$LN_English_check = $row['LN_English'];
		$LN_Portuguese_check = $row['LN_Portuguese'];
		$LN_German_check = $row['LN_German'];
		$AddNo = (int)$row['AddNo'];
		$AddTheBibleIn=$row['AddTheBibleIn'];
		$AddTheScriptureIn=$row['AddTheScriptureIn'];

		$alt_ln = 0;
//			$query="SELECT alt_lang_name FROM alt_lang_names WHERE ISO_ROD_index = $ISO_ROD_index";
//			$result_temp = $db->query($query);
		$stmt_alt->bind_param('i', $ISO_ROD_index);												// bind parameters for markers
		$stmt_alt->execute();																	// execute query
		$result_temp = $stmt_alt->get_result();
		if ($result_temp->num_rows > 0) {
			$alt_ln = $result_temp->num_rows;
		}

		$OT_PDF = (int)$row['OT_PDF'];
		if ($OT_PDF >= 1) {
//				$query="SELECT COUNT(*) AS OT_PDF_temp FROM OT_PDF_Media WHERE ISO_ROD_index = $ISO_ROD_index";
//				$result_temp = $db->query($query);
			$stmt_OT_PDF->bind_param('i', $ISO_ROD_index);										// bind parameters for markers
			$stmt_OT_PDF->execute();															// execute query
			$result_temp = $stmt_OT_PDF->get_result();
			$row_temp = $result_temp->fetch_assoc();
			$OT_PDF = $row_temp['OT_PDF_temp'];
		}

		$NT_PDF = (int)$row['NT_PDF'];
		if ($NT_PDF >= 1) {
//				$query="SELECT COUNT(*) AS NT_PDF_temp FROM NT_PDF_Media WHERE ISO_ROD_index = $ISO_ROD_index";
//				$result_temp = $db->query($query);
			$stmt_NT_PDF->bind_param('i', $ISO_ROD_index);										// bind parameters for markers
			$stmt_NT_PDF->execute();															// execute query
			$result_temp = $stmt_NT_PDF->get_result();
			$row_temp = $result_temp->fetch_assoc();
			$NT_PDF = $row_temp['NT_PDF_temp'];
		}

		//$FCBH = (int)$row['FCBH'];								// not needed
		
		$OT_Audio = (int)$row['OT_Audio'];
		if ($OT_Audio >= 1) {
//				$query="SELECT COUNT(*) AS OT_Audio_temp FROM OT_Audio_Media WHERE ISO_ROD_index = $ISO_ROD_index";
//				$result_temp = $db->query($query);
			$stmt_OT_Audio->bind_param('i', $ISO_ROD_index);									// bind parameters for markers
			$stmt_OT_Audio->execute();															// execute query
			$result_temp = $stmt_OT_Audio->get_result();
			$row_temp = $result_temp->fetch_assoc();
			$OT_Audio = $row_temp['OT_Audio_temp'];
		}

		$NT_Audio = (int)$row['NT_Audio'];
		if ($NT_Audio >= 1) {
//				$query="SELECT COUNT(*) AS NT_Audio_temp FROM NT_Audio_Media WHERE ISO_ROD_index = $ISO_ROD_index";
//				$result_temp = $db->query($query);
			$stmt_NT_Audio->bind_param('i', $ISO_ROD_index);									// bind parameters for markers
			$stmt_NT_Audio->execute();															// execute query
			$result_temp = $stmt_NT_Audio->get_result();
			$row_temp = $result_temp->fetch_assoc();
			$NT_Audio = $row_temp['NT_Audio_temp'];
		}

		$SAB_temp = (int)$row['SAB'];
		$SAB_Audio = 0;
		$SAB_Text = 0;
		$SAB_Video = 0;
		if ($SAB_temp === 1) {
//				$query="SELECT COUNT(*) AS SAB_temp FROM SAB WHERE ISO_ROD_index = $ISO_ROD_index AND SAB_Audio = 1";
//				$result_temp = $db->query($query);
			$SAB_temp = 1;
			$stmt_SAB->bind_param('ii', $ISO_ROD_index, $SAB_temp);								// bind parameters for markers
			$stmt_SAB->execute();																// execute query
			$result_temp = $stmt_SAB->get_result();
			$row_temp = $result_temp->fetch_assoc();
			$SAB_Audio = $row_temp['SAB_temp'];
//				$query="SELECT COUNT(*) AS SAB_temp FROM SAB WHERE ISO_ROD_index = $ISO_ROD_index AND SAB_Audio = 0";
//				$result_temp = $db->query($query);
			$SAB_temp = 0;
			$stmt_SAB->bind_param('ii', $ISO_ROD_index, $SAB_temp);								// bind parameters for markers
			$stmt_SAB->execute();																// execute query
			$result_temp = $stmt_SAB->get_result();
			$row_temp = $result_temp->fetch_assoc();
			$SAB_Text = $row_temp['SAB_temp'];
		}

		$links = (int)$row['links'];
		$map = 0;
		$YouVersion = 0;
		$GooglePlay = 0;																		// GooglePlay!
		$websites = 0;
		if ($links === 1) {
//				$query="SELECT LOWER(company) as company_temp, map, YouVersion, GooglePlay FROM links WHERE ISO_ROD_index = $ISO_ROD_index AND (map >= 1 OR YouVersion >= 1 OR GooglePlay >= 1 OR company = 'website' OR company = 'webpage')";
//				$result_temp = $db->query($query);
			$stmt_links->bind_param('i', $ISO_ROD_index);										// bind parameters for markers
			$stmt_links->execute();																// execute query
			$result_temp = $stmt_links->get_result();
			while ($row_temp = $result_temp->fetch_assoc()) {
				$map_temp = $row_temp['map'];
				$YouVersion_temp = $row_temp['YouVersion'];
				$GooglePlay_temp = $row_temp['GooglePlay'];
				$company_temp = $row_temp['company_temp'];
				if ($map_temp >= 1) {
					$map++;
				}
				if ($YouVersion_temp >= 1) {
					$YouVersion++;
				}
				if ($GooglePlay_temp >= 1) {
					$GooglePlay++;
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
		$WindowsCellNum = 0;
		$BlackberryNum = 0;
		$StandardCellNum = 0;
		$AdroidAppCellNum = 0;
		$AppleAppCellNum = 0;
		if ($CellPhone === 1) {
//				$query="SELECT Cell_Phone_Title FROM CellPhone WHERE ISO_ROD_index = $ISO_ROD_index";
//				$result_temp = $db->query($query);
			$stmt_CellPhone->bind_param('i', $ISO_ROD_index);									// bind parameters for markers
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
						case "Windows":
							$WindowsCellNum++;
							break;
						case "Blackberry":
							$BlackberryNum++;
							break;
						case "Standard":
							$StandardCellNum++;
							break;
						case "Android App":
							$AdroidAppCellNum++;
							break;
						case "Apple App";
							$AppleAppCellNum++;
							break;		
						default:
							echo "This is not suppose to happen.<br />";
					}
				}
			}
		}

		$AddNo = (int)$row['AddNo'];
		$AddTheBibleIn = (int)$row['AddTheBibleIn'];
		$AddTheScriptureIn = (int)$row['AddTheScriptureIn'];
		$BibleIs = (int)$row['BibleIs'];
		$YouVersion = (int)$row['YouVersion'];
		$Bibles_org = (int)$row['Bibles_org'];
		$PlaylistAudio = (int)$row['PlaylistAudio'];

		$PlaylistVideo = 0;
		$PlaylistVideoDownload = 0;
		$PlaylistVideo_temp = (int)$row['PlaylistVideo'];
		if ($PlaylistVideo_temp >= 1) {
//				$query="SELECT PlaylistVideoDownload FROM PlaylistVideo WHERE ISO_ROD_index = $ISO_ROD_index";
//				$result_temp = $db->query($query);
			$stmt_PlaylistVideo->bind_param('i', $ISO_ROD_index);								// bind parameters for markers
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

//			$query="SELECT LN_English FROM LN_English WHERE ISO_ROD_index = $ISO_ROD_index";
//			$result_temp = $db->query($query);
		$stmt_English->bind_param('i', $ISO_ROD_index);											// bind parameters for markers
		$stmt_English->execute();																// execute query
		$result_temp = $stmt_English->get_result();
		if ($result_temp->num_rows <= 0) {
			$LN_English = '';
		}
		else {
			$row_temp = $result_temp->fetch_assoc();
			$LN_English = $row_temp['LN_English'];
		}
//			$query="SELECT LN_Spanish FROM LN_Spanish WHERE ISO_ROD_index = $ISO_ROD_index";
//			$result_temp = $db->query($query);
		$stmt_Spanish->bind_param('i', $ISO_ROD_index);											// bind parameters for markers
		$stmt_Spanish->execute();																// execute query
		$result_temp = $stmt_Spanish->get_result();
		if ($result_temp->num_rows <= 0) {
			$LN_Spanish = '';
		}
		else {
			$row_temp = $result_temp->fetch_assoc();
			$LN_Spanish = $row_temp['LN_Spanish'];
		}
//			$query="SELECT LN_Portuguese FROM LN_Portuguese WHERE ISO_ROD_index = $ISO_ROD_index";
//			$result_temp = $db->query($query);
		$stmt_Portuguese->bind_param('i', $ISO_ROD_index);										// bind parameters for markers
		$stmt_Portuguese->execute();															// execute query
		$result_temp = $stmt_Portuguese->get_result();
		if ($result_temp->num_rows <= 0) {
			$LN_Portuguese = '';
		}
		else {
			$row_temp = $result_temp->fetch_assoc();
			$LN_Portuguese = $row_temp['LN_Portuguese'];
		}
//			$query="SELECT LN_French FROM LN_French WHERE ISO_ROD_index = $ISO_ROD_index";
//			$result_temp = $db->query($query);
		$stmt_French->bind_param('i', $ISO_ROD_index);											// bind parameters for markers
		$stmt_French->execute();																// execute query
		$result_temp = $stmt_French->get_result();
		if ($result_temp->num_rows <= 0) {
			$LN_French = '';
		}
		else {
			$row_temp = $result_temp->fetch_assoc();
			$LN_French = $row_temp['LN_French'];
		}
//			$query="SELECT LN_Dutch FROM LN_Dutch WHERE ISO_ROD_index = $ISO_ROD_index";
//			$result_temp = $db->query($query);
		$stmt_Dutch->bind_param('i', $ISO_ROD_index);											// bind parameters for markers
		$stmt_Dutch->execute();																	// execute query
		$result_temp = $stmt_Dutch->get_result();
		if ($result_temp->num_rows <= 0) {
			$LN_Dutch = '';
		}
		else {
			$row_temp = $result_temp->fetch_assoc();
			$LN_Dutch = $row_temp['LN_Dutch'];
		}
//			$query="SELECT LN_German FROM LN_German WHERE ISO_ROD_index = $ISO_ROD_index";
//			$result_temp = $db->query($query);
		$stmt_German->bind_param('i', $ISO_ROD_index);											// bind parameters for markers
		$stmt_German->execute();																// execute query
		$result_temp = $stmt_German->get_result();
		if ($result_temp->num_rows <= 0) {
			$LN_German = '';
		}
		else {
			$row_temp = $result_temp->fetch_assoc();
			$LN_German = $row_temp['LN_German'];
		}

		//$temp_array = ["ISO"=>$ISO, "ROD code"=>$ROD_Code, "variant code"=>$Variant_Code, "ISO_ROD_index"=>$ISO_ROD_index, "OT PDF"=>$OT_PDF, "NT PDF"=>$NT_PDF, "FCBH"=>$FCBH, "OT Audio"=>$OT_Audio, "NT Audio"=>$NT_Audio, "links"=>$links, "other titles"=>$other_titles, "watch"=>$watch, "buy"=>$buy, "study"=>$study, "viewer"=>$viewer, "Cell Phone"=>$CellPhone, "Bible.is"=>$BibleIs, "You Version"=>$YouVersion, "Bibles.org"=>$Bibles_org, "Playlist Audio"=>$PlaylistAudio, "Playlist Video"=>$PlaylistVideo, "SAB"=>$SAB, "eBible"=>$eBible, "SIL link"=>$SILlink, "GRN"=>$GRN];
		//$marks[] = $temp_array;																	// add an array to another array
//echo '<br /><br />';
//var_dump($marks);
//echo '<br /><br />';
		//$temp_array = [];
		$first .= '"'.($m-1).'": ';
		$first .= '{"type": "iso",';
		$first .= '"id": "'.$m.'",';
		$first .= '"attributes": {';
		$first .= '"iso": "'.$ISO.'",';
		//$first .= '"iso_sub_types": {';
		//$first .= '"rod_codes":			'.$m.',';
		//$first .= '"Variant_codes":		'.$m;
		//$first .= '},';
		$first .= '"num_nav":			6,';
		$first .= '"navigation": {';
		$first .= '"english":			"00i-Scripture_Index.php",';
		$first .= '"spanish":			"00e-Escrituras_Indice.php",';
		$first .= '"portugues":			"00p-Escrituras_Indice.php",';
		$first .= '"french":			"00f-Ecritures_Indice.php",';
		$first .= '"dutch":				"00d-Bijbel_Indice.php",';
		$first .= '"german":			"00de-Sprachindex.php"';
		$first .= '}';
		$first .= '},';
		$first .= '"relationships":';
		$first .= '{';
		$first .= '"rod":				"'.$ROD_Code.'",';
		$first .= '"variant":			"'.$Variant_Code.'",';
		$first .= '"query_string":		"sortby=lang&name='.$ISO.'&ROD_Code='.$ROD_Code.'&Variant_Code='.$Variant_Code.'",';
		$first .= '"iso_rod_index":		'.$ISO_ROD_index.',';
		$first .= '"language_name": {';
		$first .= '"english":			"'.$LN_English.'",';
		$first .= '"spanish":			"'.$LN_Spanish.'",';
		$first .= '"portuguese":		"'.$LN_Portuguese.'",';
		$first .= '"french":			"'.$LN_French.'",';
		$first .= '"dutch":				"'.$LN_Dutch.'",';
		$first .= '"german":			"'.$LN_German.'",';
		$first .= '"minority":			""';
		$first .= '},';
		$first .= '"alternate_language_names":		'.$alt_ln.',';
		$first .= '"apps": {';
		$first .= '"android":			'.$AdroidAppCellNum.',';								// download from SE
		$first .= '"ios":				'.$AppleAppCellNum;										// download from SE
		$first .= '},';
		$first .= '"sab": {';
		$first .= '"text":				'.$SAB_Text.',';
		$first .= '"audio":				'.$SAB_Audio.',';
		$first .= '"video":				'.$SAB_Video;
		$first .= '},';
		$first .= '"se_media": {';
		$first .= '"text":				'.($OT_PDF + $NT_PDF).',';
		$first .= '"audio": 			'.($OT_Audio + $NT_Audio).',';
		$first .= '"video":				0,';
		$first .= '"playlist_audio":	'.$PlaylistAudio.',';									// .txt
		$first .= '"playlist_video":	'.$PlaylistVideo;										// .txt
		$first .= '},';
		$first .= '"links_media": {';
		$first .= '"text":				'.$GooglePlay.',';
		$first .= '"audio": 			'.$GooglePlay.',';
		$first .= '"video":				'.$GooglePlay.',';
		$first .= '"youversion":		'.$YouVersion;
		$first .= '},';
		$first .= '"se_download_media": {';
		$first .= '"text":				'.($OT_PDF + $NT_PDF).',';
		$first .= '"audio": 			'.($OT_Audio + $NT_Audio).',';
		$first .= '"video":				0,';
		$first .= '"playlist_video":	'.$PlaylistVideoDownload;
		$first .= '},';
		$first .= '"se_other": {';
		$first .= '"GoBible":			'.$GoBibleNum.',';
		$first .= '"MySword":			'.$MySwordNum.',';
		$first .= '"theWord":			'.$study.',';
		$first .= '"viewer":			'.$viewer.',';
		$first .= '"maps":				'.$map.',';
		$first .= '"buy":				'.$buy;
		$first .= '},';
		$first .= '"other_titles":		'.$other_titles.',';
		$first .= '"watch":				'.$watch.',';
		$first .= '"websites":			'.$websites.',';
		$first .= '"eBible":			'.$eBible.',';
		$first .= '"SIL_link":			'.$SILlink.',';
		$first .= '"GRN":				'.$GRN;
		$first .= '}},';
		}
		$first = rtrim($first, ',');
		$first .= '}';

//echo $first . '<br /><br />';		// It works as a JSON!!!!
	$marks = [];
//var_dump(json_decode($first));
//echo '<br /><br />';
//echo json_encode(json_decode($first), JSON_FORCE_OBJECT);
	$marks = json_decode($first);
//var_dump($marks);
	
}
else {
	//$query = "SELECT * FROM scripture_main WHERE ISO_ROD_index = $iso_rod_index";
	//$result=$db->query($query) or die (translate('Query failed:', $st, 'sys') . ' ' . $db->error . '</body></html>');
	$query="SELECT DISTINCT ISO_ROD_index, ISO, ROD_Code, Variant_Code, LN_Dutch, LN_Spanish, LN_French, LN_English, LN_Portuguese, LN_German, Def_LN FROM scripture_main ORDER BY ISO";
	if ($result = $db->query($query)) {
		if ($result->num_rows <= 0) {
			die ('<div style="background-color: white; color: red; font-size: 16pt; padding-top: 20px; padding-bottom: 20px; margin-top: 200px; ">The language name is not found.</div></body></html>');
		}
		$LN = [];
		while ($row = $result->fetch_assoc()) {													// All ISOs + ROD codes + variants
			$ISO_ROD_index = $row['ISO_ROD_index'];
			$LN_Dutch_check = $row['LN_Dutch'];
			$LN_Spanish_check = $row['LN_Spanish'];
			$LN_French_check = $row['LN_French'];
			$LN_English_check = $row['LN_English'];
			$LN_Portuguese_check = $row['LN_Portuguese'];
			$LN_German_check = $row['LN_German'];
			if ($LN_Dutch_check == 1) {
//					$query="SELECT LN_Dutch FROM LN_Dutch WHERE ISO_ROD_index = $ISO_ROD_index";
//					$result_LN=$db->query($query);
				$stmt_Dutch->bind_param('i', $ISO_ROD_index);									// bind parameters for markers
				$stmt_Dutch->execute();															// execute query
				$result_LN = $stmt_Dutch->get_result();
				if ($result_LN->num_rows > 0) {
					$row_temp=$result_LN->fetch_assoc();
					$LN[]=trim($row_temp['LN_Dutch']);
				}
			}
			if ($LN_Spanish_check == 1) {
//					$query="SELECT LN_Spanish FROM LN_Spanish WHERE ISO_ROD_index = $ISO_ROD_index";
//					$result_LN=$db->query($query);
				$stmt_Spanish->bind_param('i', $ISO_ROD_index);									// bind parameters for markers
				$stmt_Spanish->execute();														// execute query
				$result_LN = $stmt_Spanish->get_result();
				if ($result_LN->num_rows > 0) {
					$row_temp=$result_LN->fetch_assoc();
					$LN[]=trim($row_temp['LN_Spanish']);
				}
			}
			if ($LN_French_check == 1) {
//					$query="SELECT LN_French FROM LN_French WHERE ISO_ROD_index = $ISO_ROD_index";
//					$result_LN=$db->query($query);
				$stmt_French->bind_param('i', $ISO_ROD_index);									// bind parameters for markers
				$stmt_French->execute();														// execute query
				$result_LN = $stmt_French->get_result();
				if ($result_LN->num_rows > 0) {
					$row_temp=$result_LN->fetch_assoc();
					$LN[]=trim($row_temp['LN_French']);
				}
			}
			if ($LN_English_check == 1) {
//					$query="SELECT LN_English FROM LN_English WHERE ISO_ROD_index = $ISO_ROD_index";
//					$result_LN=$db->query($query);
				$stmt_English->bind_param('i', $ISO_ROD_index);									// bind parameters for markers
				$stmt_English->execute();														// execute query
				$result_LN = $stmt_English->get_result();
				if ($result_LN->num_rows > 0) {
					$row_temp=$result_LN->fetch_assoc();
					$LN[]=trim($row_temp['LN_English']);
				}
			}
			if ($LN_Portuguese_check == 1) {
//					$query="SELECT LN_Portuguese FROM LN_Portuguese WHERE ISO_ROD_index = $ISO_ROD_index";
//					$result_LN=$db->query($query);
				$stmt_Portuguese->bind_param('i', $ISO_ROD_index);								// bind parameters for markers
				$stmt_Portuguese->execute();													// execute query
				$result_LN = $stmt_Portuguese->get_result();
				if ($result_LN->num_rows > 0) {
					$row_temp=$result_LN->fetch_assoc();
					$LN[]=trim($row_temp['LN_Portuguese']);
				}
			}
			if ($LN_German_check == 1) {
//					$query="SELECT LN_German FROM LN_German WHERE ISO_ROD_index = $ISO_ROD_index";
//					$result_LN=$db->query($query);
				$stmt_German->bind_param('i', $ISO_ROD_index);									// bind parameters for markers
				$stmt_German->execute();														// execute query
				$result_LN = $stmt_German->get_result();
				if ($result_LN->num_rows > 0) {
					$row_temp=$result_LN->fetch_assoc();
					$LN[]=trim($row_temp['LN_German']);
				}
			}

			$LN = array_unique($LN);															// removes duplicate values from an array

			$LN_string = implode(', ', $LN);													// Convert Array To String

			// Author: 'ChickenFeet'
			$temp_LN = CheckLetters($LN_string);												// diacritic removal
			
			$temp_LN = mb_strtolower($temp_LN);													// lower case language name without the diacritics
			
			$test = preg_match("/\b".$languageName.'/ui', $temp_LN, $match);					// match the beginning of the word(s) with TryLanguage from the user

			if ($test === 1) {
				//$query="SELECT * FROM scripture_main WHERE ISO_ROD_index = $ISO_ROD_index";
				$stmt_main->bind_param('i', $ISO_ROD_index);									// bind parameters for markers
				$stmt_main->execute();															// execute query
				if ($result_temp = $stmt_main->get_result()) {
					if ($result_temp->num_rows <= 0) {
						die ('<div style="background-color: white; color: red; font-size: 16pt; padding-top: 20px; padding-bottom: 20px; margin-top: 200px; ">The language name is not found.</div></body></html>');
					}
					$row_temp = $result_temp->fetch_assoc();
					$ISO = trim($row_temp['ISO']);
					$ROD_Code = trim($row_temp['ROD_Code']);
					$Variant_Code = trim($row_temp['Variant_Code']);
					$ISO_ROD_index = (int)$row['ISO_ROD_index'];
					$AddNo = (int)$row['AddNo'];
					$AddTheBibleIn=$row_temp['AddTheBibleIn'];
					$AddTheScriptureIn=$row_temp['AddTheScriptureIn'];
					$OT_PDF = (int)$row_temp['OT_PDF'];
					$NT_PDF = (int)$row_temp['NT_PDF'];
					$FCBH = (int)$row_temp['FCBH'];
					$OT_Audio = (int)$row_temp['OT_Audio'];
					$NT_Audio = (int)$row_temp['NT_Audio'];
					$links = (int)$row_temp['links'];
					$other_titles = (int)$row_temp['other_titles'];
					$watch = (int)$row_temp['watch'];
					$buy = (int)$row_temp['buy'];
					$study = (int)$row_temp['study'];
					$viewer = (int)$row_temp['viewer'];
					$CellPhone = (int)$row_temp['CellPhone'];
					$AddNo = (int)$row_temp['AddNo'];
					$AddTheBibleIn = (int)$row_temp['AddTheBibleIn'];
					$AddTheScriptureIn = (int)$row_temp['AddTheScriptureIn'];
					$BibleIs = (int)$row_temp['BibleIs'];
					$YouVersion = (int)$row_temp['YouVersion'];
					$Bibles_org = (int)$row_temp['Bibles_org'];
					$PlaylistAudio = (int)$row_temp['PlaylistAudio'];
					$PlaylistVideo = (int)$row_temp['PlaylistVideo'];
					$SAB = (int)$row_temp['SAB'];
					$eBible = (int)$row_temp['eBible'];
					$SILlink = (int)$row_temp['SILlink'];
					$GRN = (int)$row_temp['GRN'];
					// "LN"=>$temp_LN, 
					$temp_array = ["Partial Language Name"=>$languageName, "Language"=>$temp_LN, "ISO_ROD_index"=>$ISO_ROD_index, "ISO"=>$ISO, "ROD code"=>$ROD_Code, "variant code"=>$Variant_Code, "ISO_ROD_index"=>$ISO_ROD_index, "OT PDF"=>$OT_PDF, "NT PDF"=>$NT_PDF, "FCBH"=>$FCBH, "OT Audio"=>$OT_Audio, "NT Audio"=>$NT_Audio, "links"=>$links, "other titles"=>$other_titles, "watch"=>$watch, "buy"=>$buy, "study"=>$study, "viewer"=>$viewer, "Cell Phone"=>$CellPhone, "Bible.is"=>$BibleIs, "You Version"=>$YouVersion, "Bibles.org"=>$Bibles_org, "Playlist Audio"=>$PlaylistAudio, "Playlist Video"=>$PlaylistVideo, "SAB"=>$SAB, "eBible"=>$eBible, "SIL link"=>$SILlink, "Global Recaords Network"=>$GRN];
					$marks[] = $temp_array;														// add an array to another array
					$langISOrod[] = $ISO_ROD_index;
					//echo '<br /><br />';
					//print_r($marks);
					//echo '<br /><br />';
					$temp_array = [];
				}
			}
			$LN = [];
		}
	}

	// Try alt_lang_names:
	// REGEXP '[[:<:]]... = in PHP '\b... (word boundries)
echo '<p>Do not have alternate language names done because language names have alreay be done:</p>';
echo '<pre>';
var_dump($langISOrod);
echo '</pre>';
	if (empty($langISOrod)) {
		$query="SELECT DISTINCT ISO_ROD_index FROM alt_lang_names WHERE alt_lang_name REGEXP '[[:<:]]$languageName'";
	}
	else {
		$query="SELECT DISTINCT ISO_ROD_index FROM alt_lang_names WHERE alt_lang_name REGEXP '(^| )$languageName' AND ISO_ROD_index NOT IN (".implode(',', $langISOrod).")";		// won't quick work under MariaDB 10.1.44
	}
	if ($result = $db->query($query)) {
		while ($r = $result->fetch_assoc()) {
			$ISO_ROD_index = $r['ISO_ROD_index'];
			//$query="SELECT * FROM scripture_main WHERE ISO_ROD_index = $ISO_ROD_index";
			//if ($result_SM = $db->query($query)) {
			$stmt_main->bind_param('i', $ISO_ROD_index);										// bind parameters for markers
			$stmt_main->execute();																// execute query
			if ($result_SM = $stmt_main->get_result()) {
				if ($row = $result_SM->fetch_assoc()) {
					//$query="SELECT alt_lang_name FROM alt_lang_names WHERE ISO_ROD_index = $ISO_ROD_index";
					$stmt_alt->bind_param('i', $ISO_ROD_index);									// bind parameters for markers
					$stmt_alt->execute();														// execute query
					if ($result_alt = $stmt_alt->get_result()) {
						if ($result_alt->num_rows > 0) {
							$alt = '';
							while ($row_alt = $result_alt->fetch_assoc()) {
								$alt .= $row_alt['alt_lang_name'] . ', ';
							}
							$alt = rtrim($alt, ', ');

							$ISO = $row['ISO'];
							$ROD_Code = $row['ROD_Code'];
							$Variant_Code = $row['Variant_Code'];
							$AddTheBibleIn=$row['AddTheBibleIn'];
							$AddTheScriptureIn=$row['AddTheScriptureIn'];
							
							$alt_ln = 0;
							//			$query="SELECT alt_lang_name FROM alt_lang_names WHERE ISO_ROD_index = $ISO_ROD_index";
							//			$result_temp = $db->query($query);
									$stmt_alt->bind_param('i', $ISO_ROD_index);												// bind parameters for markers
									$stmt_alt->execute();																	// execute query
									$result_temp = $stmt_alt->get_result();
									if ($result_temp->num_rows > 0) {
										$alt_ln = $result_temp->num_rows;
									}
							
									$OT_PDF = (int)$row['OT_PDF'];
									if ($OT_PDF >= 1) {
							//				$query="SELECT COUNT(*) AS OT_PDF_temp FROM OT_PDF_Media WHERE ISO_ROD_index = $ISO_ROD_index";
							//				$result_temp = $db->query($query);
										$stmt_OT_PDF->bind_param('i', $ISO_ROD_index);										// bind parameters for markers
										$stmt_OT_PDF->execute();															// execute query
										$result_temp = $stmt_OT_PDF->get_result();
										$row_temp = $result_temp->fetch_assoc();
										$OT_PDF = $row_temp['OT_PDF_temp'];
									}
							
									$NT_PDF = (int)$row['NT_PDF'];
									if ($NT_PDF >= 1) {
							//				$query="SELECT COUNT(*) AS NT_PDF_temp FROM NT_PDF_Media WHERE ISO_ROD_index = $ISO_ROD_index";
							//				$result_temp = $db->query($query);
										$stmt_NT_PDF->bind_param('i', $ISO_ROD_index);										// bind parameters for markers
										$stmt_NT_PDF->execute();															// execute query
										$result_temp = $stmt_NT_PDF->get_result();
										$row_temp = $result_temp->fetch_assoc();
										$NT_PDF = $row_temp['NT_PDF_temp'];
									}
							
									//$FCBH = (int)$row['FCBH'];								// not needed
									
									$OT_Audio = (int)$row['OT_Audio'];
									if ($OT_Audio >= 1) {
							//				$query="SELECT COUNT(*) AS OT_Audio_temp FROM OT_Audio_Media WHERE ISO_ROD_index = $ISO_ROD_index";
							//				$result_temp = $db->query($query);
										$stmt_OT_Audio->bind_param('i', $ISO_ROD_index);									// bind parameters for markers
										$stmt_OT_Audio->execute();															// execute query
										$result_temp = $stmt_OT_Audio->get_result();
										$row_temp = $result_temp->fetch_assoc();
										$OT_Audio = $row_temp['OT_Audio_temp'];
									}
							
									$NT_Audio = (int)$row['NT_Audio'];
									if ($NT_Audio >= 1) {
							//				$query="SELECT COUNT(*) AS NT_Audio_temp FROM NT_Audio_Media WHERE ISO_ROD_index = $ISO_ROD_index";
							//				$result_temp = $db->query($query);
										$stmt_NT_Audio->bind_param('i', $ISO_ROD_index);									// bind parameters for markers
										$stmt_NT_Audio->execute();															// execute query
										$result_temp = $stmt_NT_Audio->get_result();
										$row_temp = $result_temp->fetch_assoc();
										$NT_Audio = $row_temp['NT_Audio_temp'];
									}
							
									$SAB_temp = (int)$row['SAB'];
									$SAB_Audio = 0;
									$SAB_Text = 0;
									$SAB_Video = 0;
									if ($SAB_temp === 1) {
							//				$query="SELECT COUNT(*) AS SAB_temp FROM SAB WHERE ISO_ROD_index = $ISO_ROD_index AND SAB_Audio = 1";
							//				$result_temp = $db->query($query);
										$SAB_temp = 1;
										$stmt_SAB->bind_param('ii', $ISO_ROD_index, $SAB_temp);								// bind parameters for markers
										$stmt_SAB->execute();																// execute query
										$result_temp = $stmt_SAB->get_result();
										$row_temp = $result_temp->fetch_assoc();
										$SAB_Audio = $row_temp['SAB_temp'];
							//				$query="SELECT COUNT(*) AS SAB_temp FROM SAB WHERE ISO_ROD_index = $ISO_ROD_index AND SAB_Audio = 0";
							//				$result_temp = $db->query($query);
										$SAB_temp = 0;
										$stmt_SAB->bind_param('ii', $ISO_ROD_index, $SAB_temp);								// bind parameters for markers
										$stmt_SAB->execute();																// execute query
										$result_temp = $stmt_SAB->get_result();
										$row_temp = $result_temp->fetch_assoc();
										$SAB_Text = $row_temp['SAB_temp'];
									}
							
									$links = (int)$row['links'];
									$map = 0;
									$YouVersion = 0;
									$GooglePlay = 0;																		// GooglePlay!
									$websites = 0;
									if ($links === 1) {
							//				$query="SELECT LOWER(company) as company_temp, map, YouVersion, GooglePlay FROM links WHERE ISO_ROD_index = $ISO_ROD_index AND (map >= 1 OR YouVersion >= 1 OR GooglePlay >= 1 OR company = 'website' OR company = 'webpage')";
							//				$result_temp = $db->query($query);
										$stmt_links->bind_param('i', $ISO_ROD_index);										// bind parameters for markers
										$stmt_links->execute();																// execute query
										$result_temp = $stmt_links->get_result();
										while ($row_temp = $result_temp->fetch_assoc()) {
											$map_temp = $row_temp['map'];
											$YouVersion_temp = $row_temp['YouVersion'];
											$GooglePlay_temp = $row_temp['GooglePlay'];
											$company_temp = $row_temp['company_temp'];
											if ($map_temp >= 1) {
												$map++;
											}
											if ($YouVersion_temp >= 1) {
												$YouVersion++;
											}
											if ($GooglePlay_temp >= 1) {
												$GooglePlay++;
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
									$WindowsCellNum = 0;
									$BlackberryNum = 0;
									$StandardCellNum = 0;
									$AdroidAppCellNum = 0;
									$AppleAppCellNum = 0;
									if ($CellPhone === 1) {
							//				$query="SELECT Cell_Phone_Title FROM CellPhone WHERE ISO_ROD_index = $ISO_ROD_index";
							//				$result_temp = $db->query($query);
										$stmt_CellPhone->bind_param('i', $ISO_ROD_index);									// bind parameters for markers
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
													case "Windows":
														$WindowsCellNum++;
														break;
													case "Blackberry":
														$BlackberryNum++;
														break;
													case "Standard":
														$StandardCellNum++;
														break;
													case "Android App":
														$AdroidAppCellNum++;
														break;
													case "Apple App";
														$AppleAppCellNum++;
														break;		
													default:
														echo "This is not suppose to happen.<br />";
												}
											}
										}
									}
							
									$AddNo = (int)$row['AddNo'];
									$AddTheBibleIn = (int)$row['AddTheBibleIn'];
									$AddTheScriptureIn = (int)$row['AddTheScriptureIn'];
									$BibleIs = (int)$row['BibleIs'];
									$YouVersion = (int)$row['YouVersion'];
									$Bibles_org = (int)$row['Bibles_org'];
									$PlaylistAudio = (int)$row['PlaylistAudio'];
							
									$PlaylistVideo = 0;
									$PlaylistVideoDownload = 0;
									$PlaylistVideo_temp = (int)$row['PlaylistVideo'];
									if ($PlaylistVideo_temp >= 1) {
							//				$query="SELECT PlaylistVideoDownload FROM PlaylistVideo WHERE ISO_ROD_index = $ISO_ROD_index";
							//				$result_temp = $db->query($query);
										$stmt_PlaylistVideo->bind_param('i', $ISO_ROD_index);								// bind parameters for markers
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

							$temp_array = ["Partial Language Name"=>$languageName, "Alternate"=>$alt, "ISO_ROD_index"=>$ISO_ROD_index, "ISO"=>$ISO, "ROD code"=>$ROD_Code, "variant code"=>$Variant_Code, "ISO_ROD_index"=>$ISO_ROD_index, "OT PDF"=>$OT_PDF, "NT PDF"=>$NT_PDF, "FCBH"=>$FCBH, "OT Audio"=>$OT_Audio, "NT Audio"=>$NT_Audio, "links"=>$links, "other titles"=>$other_titles, "watch"=>$watch, "buy"=>$buy, "study"=>$study, "viewer"=>$viewer, "Cell Phone"=>$CellPhone, "Bible.is"=>$BibleIs, "You Version"=>$YouVersion, "Bibles.org"=>$Bibles_org, "Playlist Audio"=>$PlaylistAudio, "Playlist Video"=>$PlaylistVideo, "SAB"=>$SAB, "eBible"=>$eBible, "SIL link"=>$SILlink, "Global Recaords Network"=>$GRN];
							$marks[] = $temp_array;																	// add an array to another array
							//echo '<br /><br />';
							//print_r($marks);
							//echo '<br /><br />';
							$temp_array = [];
						}
					}
				}
			}
		}
	}
}

// An associative array
$json_string = json_encode($marks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
echo '<pre>'.$json_string.'</pre>';

function removeDiacritics($txt) {
    $transliterationTable = ['�' => 'a', '�' => 'A', '�' => 'a', '�' => 'A', '�' => 'a', '�' => 'A', '�' => 'a', '�' => 'A', '�' => 'a', '�' => 'A', '�' => 'ae', '�' => 'AE', '�' => 'ae', '�' => 'AE', '�' => 'c', '�' => 'C', '�' => 'D', '�' => 'dh', '�' => 'Dh', '�' => 'e', '�' => 'E', '�' => 'e', '�' => 'E', '�' => 'e', '�' => 'E', '�' => 'e', '�' => 'E', '�' => 'i', '�' => 'I', '�' => 'i', '�' => 'I', '�' => 'i', '�' => 'I', '�' => 'i', '�' => 'I', '�' => 'n', '�' => 'N', '�' => 'o', '�' => 'O', '�' => 'o', '�' => 'O', '�' => 'o', '�' => 'O', '�' => 'o', '�' => 'O', '�' => 'oe', '�' => 'OE', '�' => 'oe', '�' => 'OE', '�' => 's', '�' => 'S', '�' => 'SS', '�' => 'u', '�' => 'U', '�' => 'u', '�' => 'U', '�' => 'u', '�' => 'U', '�' => 'ue', '�' => 'UE', '�' => 'y', '�' => 'Y', '�' => 'y', '�' => 'Y', '�' => 'z', '�' => 'Z'];
	return strtr($txt, $transliterationTable);
}    // or, return str_replace(array_keys($transliterationTable), array_values($transliterationTable), $txt);


// Author: 'ChickenFeet'
function CheckLetters($field){
	// global $letters;										// won't work
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
        11 => "z ź ž ż",
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
</body>
</html>