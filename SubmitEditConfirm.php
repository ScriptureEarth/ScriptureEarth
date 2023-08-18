<?php
	// This page cannot be accessed directly
	if ( ! (defined('RIGHT_ON') && RIGHT_ON === true)) {
		@include_once '403.php';
		exit;
	}

	/*************************************************************************************************************************************
	*
	* 			CAREFUL when your making any additions! Any "onclick", "change", etc. that occurs on "input", "a", "div", etc.
	* 			should be placed in "_js/CMS_events.js". Also, in "_js/CMS_events.js" any errors in previous statements will
	* 			not works in any of the satesments then on. It can also help in the Firefox browser (version 79.0+) run
	* 			"Scripture_Edit.php", menu "Tools", "Web developement", and "Toggle Tools". Then menu "Debugger". In the left
	* 			side of the windows click on "Scripture Edit", Localhost", "_js", and "CMS_events.js". Look down the js file
	* 			and find out if there are errors using the "underline" indicator and fix them if there are any. You can also
	* 			use "Scripture_Edit.php" just to make sure that the document.getElementById('...') name is corrent.
	* 			There no stements in "_js/CMS_events.js" (8/2020) in "SubmitEditConfirm.php".
	*			But, BE CAREFUL!
	*
	**************************************************************************************************************************************/
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Edit Submit Confirmation Update Page</title>
</head>
<body style="background-color: #069;  margin-left: auto; margin-right: auto; font-family: Arial, Helvetica, sans-serif; ">
	<div style='background-color: white; padding: 20px; width: 1020px; height: 100px; margin-left: auto; margin-right: auto; vertical-align: middle; border-radius: 15px; -moz-border-radius: 15px; -webkit-box-shadow: 15px; '>
	<img style='margin-left: 40px; ' src='images/guyReading.png' /><div style='text-align: center; margin-top: -60px; margin-left: 180px; font-size: 18pt; font-weight: bold; color: black; '>Edit the ScriptureEarth Database</div>
	</div></br />
<?php
	//include './include/conn.inc.php';				// This include is commented out on purpose!
	$db = get_my_db();
	
	echo "<div style='background-color: white; padding: 20px; width: 1020px; margin-left: auto; margin-right: auto; border-radius: 15px; -moz-border-radius: 15px; -webkit-box-shadow: 15px; '>";
//Change here??
	
	$query="UPDATE scripture_main SET Variant_Code = '$inputs[var]', OT_PDF = '$inputs[OT_PDF]', NT_PDF = '$inputs[NT_PDF]', FCBH = 0, OT_Audio = '$inputs[OT_Audio]', NT_Audio = '$inputs[NT_Audio]', links = '$inputs[links]', other_titles = '$inputs[other_titles]', watch = '$inputs[watch]', buy = '$inputs[buy]', study = '$inputs[study]', viewer = '$inputs[viewer]', CellPhone  = '$inputs[CellPhone]', AddNo = '$inputs[AddNo]', AddTheBibleIn = '$inputs[AddTheBibleIn]', AddTheScriptureIn = '$inputs[AddTheScriptureIn]', BibleIs = '$inputs[BibleIs]', BibleIsGospelFilm = '$inputs[BibleIsGospelFilm]', `Bibles_org` = '$inputs[Biblesorg]', YouVersion = '$inputs[YouVersion]', PlaylistAudio = '$inputs[AudioPlaylist]', PlaylistVideo = '$inputs[VideoPlaylist]', SAB = '$inputs[SAB]', eBible = '$inputs[eBible]', SILlink = '$inputs[SILlink]', `GRN` = '$inputs[GRN]' WHERE ISO_ROD_index = $inputs[idx]";
	$result=$db->query($query);
	if (!$result) {
		die('Could not update the data in "scripture_main": ' . $db->error);
	}

// nav_ln table
	$ln_result = '';
	foreach($_SESSION['nav_ln_array'] as $code => $array){
		$temp = 'LN_'.$array[1].'Bool';
		$ln_result .= "LN_".$array[1]." = '$inputs[$temp]', ";
	}
	$query="UPDATE nav_ln SET Variant_Code = '$inputs[var]', ".$ln_result."Def_LN = '$inputs[DefLangName]' WHERE ISO_ROD_index = $inputs[idx]";
	$result=$db->query($query);
	if (!$result) {
		die('Could not update the data in "nav_ln": ' . $db->error);
	}

// navigational language names - LN
	foreach ($_SESSION['nav_ln_array'] as $code => $array){
		if ($inputs['LN_'.$array[1].'Bool']) {
			$query="DELETE FROM LN_".$array[1]." WHERE ISO_ROD_index = $inputs[idx]";
			$db->query($query);
			$temp = '';
			$temp = $inputs[$array[1].'_lang_name'];
			$temp = str_replace("'", "ꞌ", $temp);								// apostrophe (') to saltillo glyph (ꞌ - U+A78C)
			$query="INSERT INTO `LN_$array[1]` (ISO, ROD_Code, Variant_Code, ISO_ROD_index, `LN_$array[1]`) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $inputs[idx], '$temp')";
			$result=$db->query($query);
			if (!$result) {
				echo 'Could not insert the data in "LN_'.$array[1].'": ' . $db->error;
			}
		}
	}

// ISO countries
	$i=1;
	$query="DELETE FROM ISO_countries WHERE ISO_ROD_index = $inputs[idx]";
	$db->query($query);
	$query="INSERT INTO ISO_countries (ISO, ROD_Code, Variant_Code, ISO_ROD_index, ISO_countries) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $inputs[idx], ?)";
	$stmt=$db->prepare($query);
	while ($i <= $inputs['ISO_countries']) {
		$temp = 'ISO_Country-'.(string)$i;
		$stmt->bind_param("s", $inputs[$temp]);													// bind parameters for markers
		$stmt->execute();																		// execute query
		$i++;
	}
	$stmt->close();
	
// alt_lang_names
	$query="DELETE FROM alt_lang_names WHERE ISO_ROD_index = $inputs[idx]";
	$db->query($query);
	$i = 1;
	$query="SELECT * FROM alt_lang_names WHERE ISO_ROD_index = ?";								// reject duplicate entries
	$stmt_alt=$db->prepare($query);
	$query="INSERT INTO alt_lang_names SET ISO = '$inputs[iso]', ROD_Code = '$inputs[rod]', Variant_Code = '$inputs[var]', ISO_ROD_index = $inputs[idx], alt_lang_name = ?";
	$stmt=$db->prepare($query);
	while (isset($inputs["txtAltNames-".(string)$i])) {
		$stmt_alt->bind_param("i", $inputs['idx']);												// bind parameters for markers
		$stmt_alt->execute();																	// execute query
		$result_alt = $stmt_alt->get_result();													// instead of bind_result (used for only 1 record):
		$bool_ISO = false;
		while ($r = $result_alt->fetch_assoc()) {
			if ($r['alt_lang_name'] == $inputs["txtAltNames-".$i]) {							// compare
				$bool_ISO = true;
				break;
			}
		}
		if (!$bool_ISO) {
			$temp = "txtAltNames-".(string)$i;
			//$temp = htmlspecialchars($temp, ENT_QUOTES, 'UTF-8');
			$temp = stripslashes($inputs[$temp]);
			$stmt->bind_param("s", $temp);														// bind parameters for markers								// 
			$result=$stmt->execute();															// execute query
			if (!$result) {
				echo 'Could not insert the data "alt_lang_names": ' . $db->error;
			}
		}
		$i++;
	}
	$stmt_alt->close();
	$stmt->close();
	
// isop
	if ($inputs["isop"] === 0) {
		$db->query("DELETE FROM isop WHERE ISO_ROD_index = ".$inputs['idx']);
	}
	else {
		$query = "SELECT * FROM isop WHERE ISO_ROD_index = ".$inputs['idx'];
		$result_isop=$db->query($query);
		if ($result_isop->num_rows == 0) {
			if (!$db->query("INSERT INTO isop (ISO, ROD_Code, Variant_Code, ISO_ROD_index, isop) VALUES ('".$inputs['iso']."', '".$inputs['rod']."', '".$inputs['var']."', ".$inputs['idx'].", '".$inputs['isopText']."')")) {
				echo "INSERT Error description: " . $db -> error .'<br />';
			}
		}
		else {
			if (!$db->query("UPDATE isop SET isop = '".$inputs['isopText']."' WHERE ISO_ROD_index = ".$inputs['idx'])) {
				echo "UPDATE Error description: " . $db -> error .'<br />';
			}
		}
	}
	
// links: BibleIs
	$query="DELETE FROM links WHERE ISO_ROD_index = $inputs[idx] AND BibleIs > 0";
	$result=$db->query($query);
	if ($inputs['BibleIs']) {
		$i = 1;
		$query="INSERT INTO links (ISO, ROD_Code, Variant_Code, ISO_ROD_index, company, company_title, `URL`, BibleIs) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $inputs[idx], 'Bible.is', ?, ?, ?)";
		$stmt_links=$db->prepare($query);
		while (isset($inputs["txtLinkBibleIsURL-".(string)$i])) {
			$temp3 = "txtLinkBibleIsURL-".(string)$i;
			$temp2 = "txtLinkBibleIsTitle-".(string)$i;
			$temp4 = $inputs["BibleIsDefault-".(string)$i] + $inputs["BibleIsText-".(string)$i] + $inputs["BibleIsAudio-".(string)$i] + $inputs["BibleIsVideo-".(string)$i];		// only one is set
			/*if ($inputs["BibleIsNT-".(string)$i] == 1) $temp4 = 1;
			if ($inputs["BibleIsOT-".(string)$i] == 1) $temp4 = 2;
			if ($inputs["BibleIsBible-".(string)$i] == 1) $temp4 = 3;
			if ($inputs["BiblePortions-".(string)$i] == 1) $temp4 = 4;*/
			$stmt_links->bind_param("ssi", $inputs[$temp2], $inputs[$temp3], $temp4);									// bind parameters for markers
			$result=$stmt_links->execute();																				// execute query
			if (!$result) {
				echo 'Could not update the data "Bible.is links": ' . $db->error;
			}
			$i++;
		}
		$stmt_links->close();
	}

// links: BibleIs Gospel Film
	$query="DELETE FROM links WHERE ISO_ROD_index = $inputs[idx] AND BibleIsGospelFilm = 1";
	$result=$db->query($query);
	if ($inputs["BibleIsGospelFilm"]) {
		$i = 1;
		$query="INSERT INTO links (ISO, ROD_Code, Variant_Code, ISO_ROD_index, company, company_title, `URL`, BibleIsGospelFilm) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $inputs[idx], 'Bible.is Gospel Film', ?, ?, 1)";
		$stmt_links=$db->prepare($query);
		while (isset($inputs["txtLinkBibleIsGospelFilmURL-".(string)$i])) {
			$temp2 = "txtLinkBibleIsGospel-".(string)$i;
			$temp3 = "txtLinkBibleIsGospelFilmURL-".(string)$i;
			$stmt_links->bind_param("ss", $inputs[$temp2], $inputs[$temp3]);											// bind parameters for markers
			$result=$stmt_links->execute();																				// execute query
			if (!$result) {
				echo 'Could not update the data "Bible.is Gospel Film" links: ' . $db->error;
			}
			$i++;
		}
		$stmt_links->close();
	}

// SAB
	/*
		$SAB (bitwise):
			decimal		binary		meaning
			1			000001		NT Synchronized text and audio
			2			000010		OT Synchronized text and audio
			4			000100		NT Synchronized audio where available
			8			001000		OT Synchronized audio where available
			16			010000		NT View text only
			32			100000		OT View text only
			
			Scriptoria needs help on audio
	*/
	$db->query("DELETE FROM SAB WHERE ISO_ROD_index = $inputs[idx]");
	$db->query("DELETE FROM SAB_scriptoria WHERE ISO_ROD_index = $inputs[idx]");
	if ($inputs['SAB'] >= 1) {
		$i = 1;
		$query="INSERT INTO SAB_scriptoria (ISO, ROD_Code, Variant_Code, ISO_ROD_index, `url`, `subfolder`, `description`, `pre_scriptoria`, `SAB_number`) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $inputs[idx], ?, ?, ?, ?, ?)";
		$stmt_SAB_scriptoria=$db->prepare($query);
		//		while (isset($inputs["txtSABsubfolder-".(string)$i]) && trim($inputs["txtSABsubfolder-".(string)$i]) != '') {		//strlen(trim($inputs["txtSABsubFirstPath-".(string)$i]) >= 4)) {			// $inputs["txtSABsubFirstPath-".(string)$i]) = "sab" by default
		while (isset($inputs["txtSABsubfolder-".(string)$i])) {		//strlen(trim($inputs["txtSABsubFirstPath-".(string)$i]) >= 4)) {			// $inputs["txtSABsubFirstPath-".(string)$i]) = "sab" by default
			$SABdescription = "txtSABdescription-".(string)$i;
			$SABurl = "txtSABurl-".(string)$i;
			$SABpreScriptoria = "txtSABpreScriptoria-".(string)$i;
			//if ($inputs[$SABpreScriptoria] !== '') {
				// see Edit_Lang_Validation.php
			//}
			//else {
				$SABsubfolder = "txtSABsubfolder-".(string)$i;
				//$SABsubFirstPath = "txtSABsubFirstPath-".(string)$i;
				//$inputs[$SABsubfolder] = $inputs[$SABsubFirstPath] . $inputs[$SABsubfolder];
			//}
			$stmt_SAB_scriptoria->bind_param("ssssi", $inputs[$SABurl], $inputs[$SABsubfolder], $inputs[$SABdescription], $inputs[$SABpreScriptoria], $i);		// bind parameters for markers
			$resultSAB_scriptoria=$stmt_SAB_scriptoria->execute();														// execute query
			if (!$resultSAB_scriptoria) {
				echo 'Could not update the data "sab_scriptoria" table: ' . $db->error;
			}
			else {
				$SAB_Path = '';
				if ($inputs[$SABpreScriptoria] != '') {																	// field set with preScriptoria
					$SAB_Path = './data/'.$inputs['iso'].'/sab/';
					// SAB OT
					$book_number = 0;
					$OT_Error_Books = 0;
					$SAB_Error_Chapter = '';
					$book_OT = '';
					$SAB_count = 0;
					$SAB_OT_Book_Count = 39;
					$query="INSERT INTO SAB (ISO, ROD_Code, Variant_Code, ISO_ROD_index, Book_Chapter_HTML, SAB_Book, SAB_Chapter, SAB_Audio, SAB_number) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $inputs[idx], ?, ?, ?, ?, ?)";
					$stmt_SAB=$db->prepare($query);
					for ($BookChap = 0; $BookChap <= 38; $BookChap++) {
						$book_OT = $OT_array[5][$BookChap];							// $NT_abbrev_array from NT_Books.php = Book
						$chapters = $OT_array[1][$BookChap]; 						// $NT_How_Many_Chapters_array from NT_Books.php = maximum number for chapters in that Book
						$book_number++;
						$SAB_count = 0;
						for ($chapter = 1; $chapter <= $chapters+0; $chapter++) {
							$filename = $inputs[$SABpreScriptoria].'-'.($book_number < 10 ? '0'.(string)$book_number : (string)$book_number).'-'.$book_OT.'-'.($chapter > 99 ? (string)$chapter : ($chapter < 10 ? '00'.(string)$chapter : '0'.(string)$chapter)).'.html';
							//if (file_exists($SAB_Path.$filename)) {
							//$file_headers = @get_headers($SAB_Path . $filename);							// Fetches all 9 of the headers sent by the server in response to an HTTP request.
							//if ($file_headers[0] != 'HTTP/1.1 404 Not Found' && $file_headers[0] != 'HTTP/1.1 302 Moved Temporarily') {
							if (file_exists($SAB_Path.$filename)) {
								$SAB_Read = @file_get_contents($SAB_Path . $filename, FILE_USE_INCLUDE_PATH);			// How to handle the warning of file_get_contents: '@' in front of the call to file_get_contents
								$OT_Error_Books = 1;
								// scan though SAB html and find out if there is an mp3
								if (preg_match("/\.(mp3|3gp)['\"]/i", $SAB_Read)) {
									$audio = 1;
									$stmt_SAB->bind_param("siiii", $filename, $book_number, $chapter, $audio, $i);		// bind parameters for markers
									if ($SAB_count == 0) {
										$SAB_OT_Book_Count--;
										$SAB_count = 1;
									}
								}
								else {
									$SAB_count = 1;
									$audio = 0;
									$stmt_SAB->bind_param("siiii", $filename, $book_number, $chapter, $audio, $i);		// bind parameters for markers
								}
								$result=$stmt_SAB->execute();															// execute query
								if (!$result) {
									echo 'Could not insert the data for table "SAB": ' . $db->error;
								}
								$SAB_Read = '';
							}
							//else {
			//					$SAB_Error_Chapter .= 'SAB: ' . $SAB_Path . $filename . ' does not exist. If it should exist did you make a copy of the HTML file to the server?<br />';
							//	$OT_Error_Books = 1;		// only if all of the OT chapters are not found would this get set to 0
							//}
						}
					}
					if ($OT_Error_Books == 1) {
						if ($SAB_OT_Book_Count == 0) {			// 2 (binary) - OT Synchronized text and audio
							$SAB_OT_Book_Count = 2;
						}
						else if ($SAB_OT_Book_Count == 39) {	// 32 (binary) - OT View text only
							$SAB_OT_Book_Count = 32;
						}
						else {									// 8 (binary) - OT Synchronized audio where available
							$SAB_OT_Book_Count = 8;
						}
					}
					else {
						$SAB_OT_Book_Count = 0;
					}
			
					// SAB NT
					$book_number = 0;
					$SAB_Book_Count = 0;
					$NT_Error_Books = 0;
					$SAB_Error_Chapter = '';
					$book_NT = '';
					$SAB_count = 0;
					$SAB_NT_Book_Count = 27;
					for ($BookChap = 0; $BookChap <= 26; $BookChap++) {
						$book_NT = $NT_array[5][$BookChap];							// $NT_abbrev_array from NT_Books.php = Book
						$chapters = $NT_array[1][$BookChap]; 						// $NT_How_Many_Chapters_array from NT_Books.php = maximum number for chapters in that Book
						$book_number++;
						$SAB_count = 0;
						for ($chapter = 1; $chapter <= $chapters+0; $chapter++) {
							$filename = $inputs[$SABpreScriptoria].'-'.(string)($book_number+40).'-'.$book_NT.'-'.($chapter < 10 ? '00'.(string)$chapter : '0'.(string)$chapter).'.html';
							if (file_exists($SAB_Path.$filename)) {
							//$file_headers = @get_headers($SAB_Path . $filename);							// Fetches all 9 of the headers sent by the server in response to an HTTP request.
							//if ($file_headers[0] != 'HTTP/1.1 404 Not Found' && $file_headers[0] != 'HTTP/1.1 302 Moved Temporarily') {
							//if (FALSE !== ($SAB_Read = @file_get_contents($SAB_Path . $filename, FILE_USE_INCLUDE_PATH))) {		// How to handle the warning of file_get_contents: '@' in front of the call to file_get_contents
								$SAB_Read = @file_get_contents($SAB_Path . $filename, FILE_USE_INCLUDE_PATH);
								$NT_Error_Books = 1;
								$temp = $book_number + 40;
								// scan though SAB html and find out if there is an mp3
								if (preg_match("/\.(mp3|3gp)['\"]/i", $SAB_Read)) {
									$audio = 1;
									$stmt_SAB->bind_param("siiii", $filename, $temp, $chapter, $audio, $i);				// bind parameters for markers
									if ($SAB_count == 0) {
										$SAB_NT_Book_Count--;
										$SAB_count = 1;
									}
								}
								else {
									$SAB_count = 1;
									$audio = 0;
									$stmt_SAB->bind_param("siiii", $filename, $temp, $chapter, $audio, $i);				// bind parameters for markers
								}
								$result=$stmt_SAB->execute();															// execute query
								if (!$result) {
									echo 'Could not insert the data for table "SAB": ' . $db->error;
								}
								$SAB_Read = '';
							}
							//else {
			//					$SAB_Error_Chapter .= 'SAB: ' . $SAB_Path . $filename . ' does not exist. If it should exist did you made a copy of the HTML file to the server?<br />';
							//	$NT_Error_Books = 1;		// only if all of the NT chapters are not found would this get set to 0
							//}
						}
					}
					$stmt_SAB->close();
					
					if ($NT_Error_Books == 1) {
						$SAB_Book_Count = 0;
						if ($SAB_NT_Book_Count == 0) {			// 1 (binary) - NT Synchronized text and audio
							$SAB_Book_Count = $SAB_OT_Book_Count + 1;
						}
						else if ($SAB_NT_Book_Count == 27) {	// 16 (binary) - NT View text only
							$SAB_Book_Count = $SAB_OT_Book_Count + 16;
						}
						else {									// 4 (binary) - NT Synchronized audio where available
							$SAB_Book_Count = $SAB_OT_Book_Count + 4;
						}
					}
					else {
						$SAB_Book_Count = $SAB_OT_Book_Count;
					}
					// This is where OT and NT gets the field SAB UPDATEd
					$db->query("UPDATE scripture_main SET SAB = $SAB_Book_Count WHERE ISO_ROD_index = $inputs[idx]");
				}
				elseif ($inputs[$SABsubfolder] != '') {																									// sw.js does exist therefore the html files are new ( >= 8/2020) Scritporia s3 (AWS)
					$SAB_Path = './data/'.$inputs['iso'].'/'.$inputs[$SABsubfolder];
					$query="INSERT INTO SAB (ISO, ROD_Code, Variant_Code, ISO_ROD_index, Book_Chapter_HTML, SAB_Book, SAB_Chapter, SAB_Audio, SAB_number) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $inputs[idx], ?, ?, ?, 0, ?)";
					$stmt_SAB=$db->prepare($query);
					$SAB_array = glob($SAB_Path.'*.html');
					if (empty($SAB_array) === false) {																	// there are html files here
						foreach ($SAB_array as $SAB_record) {															// $SAB_array = glob($SAB_Path.'*.html'). e.g. "tuoC-02-GEN-001.html"
							$SAB_record = substr($SAB_record, strrpos($SAB_record, '/')+1);								// gets rids of directories. strrpos - returns the poistion of the last occurrence of the substring
							if (preg_match('/-([0-9]+)-[A-Z0-9][A-Z]{2}-/', $SAB_record, $match)) {
							}
							else {
								continue;
							}
							$book_number = (int)$match[1];
							preg_match('/-([0-9]+)\.html/', $SAB_record, $match);
							$chapter = (int)$match[1];
							$stmt_SAB->bind_param("siii", $SAB_record, $book_number, $chapter, $i);						// bind parameters for markers
							$stmt_SAB->execute();
						}
					}
					else {
						echo '<h3>No HTML files found in '.$SAB_Path.'. Be sure you uploaded the HTML files from you\'re comptuer to the SE server AND then re-run the Edit of CMS again.</h3>';
					}
				}
				else {			// url is here so don't do the books
				}
			}
			$i++;
		}
	}

// whole Bible PDF
	$query="DELETE FROM Scripture_and_or_Bible WHERE ISO_ROD_index = $inputs[idx]";
	$result=$db->query($query);
	if (!$result) {
		echo 'Could not insert the data in "Scripture_and_or_Bible": ' . $db->error;
	}
	if ($inputs['Bible_PDF']) {
		if ($inputs['whole_Bible'] != "") {
			$query="INSERT INTO Scripture_and_or_Bible SET ISO = '$inputs[iso]', ROD_Code = '$inputs[rod]', Variant_Code = '$inputs[var]', ISO_ROD_index = $inputs[idx], Item = 'B', Scripture_Bible_Filename = '$inputs[whole_Bible]'";
			$result=$db->query($query);
			if (!$result) {
				echo 'Could not update the data "Scripture_and_or_Bible": ' . $db->error;
			}
		}
	}

// complete Scripture PDF
	if ($inputs['complete_Scripture_PDF']) {
		if ($inputs['complete_Scripture'] != "") {
			$query="INSERT INTO Scripture_and_or_Bible SET ISO = '$inputs[iso]', ROD_Code = '$inputs[rod]', Variant_Code = '$inputs[var]', ISO_ROD_index = $inputs[idx], Item = 'S', Scripture_Bible_Filename = '$inputs[complete_Scripture]', `description` = '$inputs[ScriptureDescription]'";
			$result=$db->query($query);
			if (!$result) {
				echo 'Could not update the data "Scripture_and_or_Bible": ' . $db->error;
			}
		}
	}

// OT_PDF_Media
	$query="DELETE FROM OT_PDF_Media WHERE ISO_ROD_index = $inputs[idx]";
	$result=$db->query($query);
	if ($inputs['OT_PDF']) {
		if ($inputs['OT_name'] != "") {
			$query="INSERT INTO OT_PDF_Media SET ISO = '$inputs[iso]', ROD_Code = '$inputs[rod]', Variant_Code = '$inputs[var]', ISO_ROD_index = $inputs[idx], OT_PDF = 'OT', OT_PDF_Filename = '$inputs[OT_name]'";
			$result=$db->query($query);
			if (!$result) {
				echo 'Could not insert the data "OT_name": ' . $db->error;
			}
		}
		$query="INSERT INTO OT_PDF_Media (ISO, ROD_Code, Variant_Code, ISO_ROD_index, OT_PDF, OT_PDF_Filename) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $inputs[idx], ?, ?)";
		$stmt_OT=$db->prepare($query);
		for ($i = 0; $i < 39; $i++) {
			if ($inputs["OT_PDF_Filename-$i"] != "") {
				$temp1 = "OT_PDF_Book-$i";
				$temp2 = "OT_PDF_Filename-$i";
				$stmt_OT->bind_param("ss", $inputs[$temp1], $inputs[$temp2]);						// bind parameters for markers
				$result=$stmt_OT->execute();														// execute query
				if (!$result) {
					echo 'Could not update the data "OT_PDF_Media": ' . $db->error;
				}
			}
		}
		if ($inputs["OT_PDF_Filename_appendix"] != "") {
			$temp1 = "OT_PDF_appendix";
			$temp2 = "OT_PDF_Filename_appendix";
			$query="INSERT INTO OT_PDF_Media (ISO, ROD_Code, Variant_Code, ISO_ROD_index, OT_PDF, OT_PDF_Filename) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $inputs[idx], '$inputs[$temp1]', '$inputs[$temp2]')";
			$result=$db->query($query);
			if (!$result) {
				echo 'Could not insert the data "OT_PDF_Media": ' . $db->error;
			}
		}
		if ($inputs["OT_PDF_Filename_glossary"] != "") {
			$temp1 = "OT_PDF_glossary";
			$temp2 = "OT_PDF_Filename_glossary";
			$query="INSERT INTO OT_PDF_Media (ISO, ROD_Code, Variant_Code, ISO_ROD_index, OT_PDF, OT_PDF_Filename) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $inputs[idx], '$inputs[$temp1]', '$inputs[$temp2]')";
			$result=$db->query($query);
			if (!$result) {
				echo 'Could not insert the data "OT_PDF_Media": ' . $db->error;
			}
		}
	}
	
// NT_PDF_Media
	$query="DELETE FROM NT_PDF_Media WHERE ISO_ROD_index = $inputs[idx]";
	$result=$db->query($query);
	if ($inputs['NT_PDF']) {
		if ($inputs['NT_name'] != "") {
			$query="INSERT INTO NT_PDF_Media SET ISO = '$inputs[iso]', ROD_Code = '$inputs[rod]', Variant_Code = '$inputs[var]', ISO_ROD_index = $inputs[idx], NT_PDF = 'NT', NT_PDF_Filename = '$inputs[NT_name]'";
			$result=$db->query($query);
			if (!$result) {
				echo 'Could not insert the data "NT_name": ' . $db->error;
			}
		}
		$query="INSERT INTO NT_PDF_Media (ISO, ROD_Code, Variant_Code, ISO_ROD_index, NT_PDF, NT_PDF_Filename) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $inputs[idx], ?, ?)";
		$stmt_NT=$db->prepare($query);
		for ($i = 0; $i < 27; $i++) {
			if ($inputs["NT_PDF_Filename-$i"] != "") {
				$temp1 = "NT_PDF_Book-$i";
				$temp2 = "NT_PDF_Filename-$i";
				$stmt_NT->bind_param("ss", $inputs[$temp1], $inputs[$temp2]);						// bind parameters for markers
				$result=$stmt_NT->execute();														// execute query
				if (!$result) {
					echo 'Could not insert the data "NT_PDF_Media": ' . $db->error;
				}
			}
		}
		if ($inputs["NT_PDF_Filename_appendix"] != "") {
			$temp1 = "NT_PDF_appendix";
			$temp2 = "NT_PDF_Filename_appendix";
			$query="INSERT INTO NT_PDF_Media (ISO, ROD_Code, Variant_Code, ISO_ROD_index, NT_PDF, NT_PDF_Filename) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $inputs[idx], '$inputs[$temp1]', '$inputs[$temp2]')";
			$result=$db->query($query);
			if (!$result) {
				echo 'Could not insert the data "NT_PDF_Media": ' . $db->error;
			}
		}
		if ($inputs["NT_PDF_Filename_glossary"] != "") {
			$temp1 = "NT_PDF_glossary";
			$temp2 = "NT_PDF_Filename_glossary";
			$query="INSERT INTO NT_PDF_Media (ISO, ROD_Code, Variant_Code, ISO_ROD_index, NT_PDF, NT_PDF_Filename) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $inputs[idx], '$inputs[$temp1]', '$inputs[$temp2]')";
			$result=$db->query($query);
			if (!$result) {
				echo 'Could not insert the data "NT_PDF_Media": ' . $db->error;
			}
		}
	}
	
// OT_Audio_Media
	$query="DELETE FROM OT_Audio_Media WHERE ISO_ROD_index = $inputs[idx]";
	$result=$db->query($query);
	if ($inputs['OT_Audio']) {
		$query="INSERT INTO OT_Audio_Media (ISO, ROD_Code, Variant_Code, ISO_ROD_index, OT_Audio_Book, OT_Audio_Filename, OT_Audio_Chapter) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $inputs[idx], ?, ?, ?)";
		$stmt_OT=$db->prepare($query);
		for ($i = 0; $i < 39; $i++) {
			$item2_from_array = $OT_array[1][$i];		// how many chapers in each book
			for ($z = 0; $z < $item2_from_array; $z++) {
				if ($inputs["OT_Audio_Filename-".$i."-".$z] != "") {
					$y = $z + 1;
					$temp1 = "OT_Audio_Book-".$i;
					$temp2 = "OT_Audio_Filename-".$i."-".$z;
					$temp3 = "OT_Audio_Chapter-".$i."-".$z;
					$stmt_OT->bind_param("isi", $inputs[$temp1], $inputs[$temp2], $inputs[$temp3]);	// bind parameters for markers								// 
					$result=$stmt_OT->execute();													// execute query
					if (!$result) {
						echo 'Could not insert the data "OT_Audio_Media" (book: ' . $temp1 . ' ' . 'chapter: ' . $temp3 . '): ' . $db->error;
					}
				}
			}
		}
		$stmt_OT->close();
	}
	
// NT_Audio
	$query="DELETE FROM NT_Audio_Media WHERE ISO_ROD_index = $inputs[idx]";
	$result=$db->query($query);
	if ($inputs['NT_Audio']) {
		$query="INSERT INTO NT_Audio_Media (ISO, ROD_Code, Variant_Code, ISO_ROD_index, NT_Audio_Book, NT_Audio_Filename, NT_Audio_Chapter) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $inputs[idx], ?, ?, ?)";
		$stmt_NT=$db->prepare($query);
		for ($i = 0; $i < 27; $i++) {
			$item2_from_array = $NT_array[1][$i];		// how many chapers in each book
			for ($z = 0; $z < $item2_from_array; $z++) {
				if ($inputs["NT_Audio_Filename-".$i."-".$z] != "") {
					$y = $z + 1;
					$temp1 = "NT_Audio_Book-".$i;
					$temp2 = "NT_Audio_Filename-".$i."-".$z;
					$temp3 = "NT_Audio_Chapter-".$i."-".$z;
					$stmt_NT->bind_param("isi", $inputs[$temp1], $inputs[$temp2], $inputs[$temp3]);		// bind parameters for markers
					$result=$stmt_NT->execute();														// execute query
					if (!$result) {
						echo 'Could not insert the data "NT_Audio_Media" (book: ' . $temp1 . ' ' . 'chapter: ' . $temp3 . '): ' . $db->error;
					}
				}
			}
		}
		$stmt_NT->close();
	}
	
// links: Read: YouVersion
	$query="DELETE FROM links WHERE ISO_ROD_index = $inputs[idx] AND YouVersion = 1";
	$result=$db->query($query);
	if ($inputs['YouVersion']) {
		$i = 1;
		$query="INSERT INTO links (ISO, ROD_Code, Variant_Code, ISO_ROD_index, company, company_title, `URL`, YouVersion) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $inputs[idx], ?, ?, ?, 1)";
		$stmt_links=$db->prepare($query);
		while (isset($inputs["txtLinkYouVersionName-$i"])) {
			$temp1 = "txtLinkYouVersionName-$i";
			$temp2 = "txtLinkYouVersionTitle-$i";
			$temp3 = "txtLinkYouVersionURL-$i";
			$stmt_links->bind_param("sss", $inputs[$temp1], $inputs[$temp2], $inputs[$temp3]);		// bind parameters for markers
			$result=$stmt_links->execute();															// execute query
			if (!$result) {
				echo 'Could not update the data "YouVersion links": ' . $db->error;
			}
			$i++;
		}
		$stmt_links->close();
	}
	
// links: Study - Bibles_org
	$query="DELETE FROM links WHERE ISO_ROD_index = $inputs[idx] AND Bibles_org = 1";
	$result=$db->query($query);
	if ($inputs['Biblesorg']) {
		$i = 1;
		$query="INSERT INTO links (ISO, ROD_Code, Variant_Code, ISO_ROD_index, company, company_title, URL, `Bibles_org`) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $inputs[idx], ?, ?, ?, 1)";
		$stmt_links=$db->prepare($query);
		while (isset($inputs["txtLinkBiblesorgName-$i"])) {
			$temp1 = "txtLinkBiblesorgName-$i";
			$temp2 = "txtLinkBiblesorgTitle-$i";
			$temp3 = "txtLinkBiblesorgURL-$i";
			$stmt_links->bind_param("sss", $inputs[$temp1], $inputs[$temp2], $inputs[$temp3]);		// bind parameters for markers
			$result=$stmt_links->execute();															// execute query
			if (!$result) {
				echo 'Could not update the data "Bibles.org links": ' . $db->error;
			}
			$i++;
		}
		$stmt_links->close();
	}
	
// links: GRN
	$query="DELETE FROM links WHERE ISO_ROD_index = $inputs[idx] AND GRN = 1";
	$result=$db->query($query);
	if ($inputs['GRN']) {
		$i = 1;
		$query="INSERT INTO links (ISO, ROD_Code, Variant_Code, ISO_ROD_index, company, company_title, URL, `GRN`) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $inputs[idx], ?, ?, ?, 1)";
		$stmt_links=$db->prepare($query);
		while (isset($inputs["txtLinkGRNName-$i"])) {
			$temp1 = "txtLinkGRNName-$i";
			$temp2 = "txtLinkGRNTitle-$i";
			$temp3 = "txtLinkGRNURL-$i";
			$stmt_links->bind_param("sss", $inputs[$temp1], $inputs[$temp2], $inputs[$temp3]);		// bind parameters for markers
			$result=$stmt_links->execute();															// execute query
			if (!$result) {
				echo 'Could not update the data "GRN links": ' . $db->error;
			}
			$i++;
		}
		$stmt_links->close();
	}

// CellPhone
	$query="DELETE FROM CellPhone WHERE ISO_ROD_index = $inputs[idx]";
	$result=$db->query($query);
	if ($inputs['CellPhone']) {
		$i = 1;
		$query="INSERT INTO CellPhone (ISO, ROD_Code, Variant_Code, ISO_ROD_index, Cell_Phone_Title, Cell_Phone_File, optional) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $inputs[idx], ?, ?, ?)";
		$stmt_cell=$db->prepare($query);
		while (isset($inputs["txtCellPhoneFile-$i"])) {
			if ($inputs["CPJava-".(string)$i] == 1) $temp1 = "GoBible (Java)";
			if ($inputs["CPAndroid-".(string)$i] == 1) $temp1 = "MySword (Android)";
			if ($inputs["CPiPhone-".(string)$i] == 1) $temp1 = "iPhone";
			//if ($inputs["CPWindows-".(string)$i] == 1) $temp1 = "Windows";
			//if ($inputs["CPBlackberry-".(string)$i] == 1) $temp1 = "Blackberry";
			//if ($inputs["CPStandard-".(string)$i] == 1) $temp1 = "Standard Cell Phone";
			if ($inputs["CPAndroidApp-".(string)$i] == 1) $temp1 = "Android App";
			if ($inputs["CPiOSAssetPackage-".(string)$i] == 1) $temp1 = "iOS Asset Package";
			$temp2 = "txtCellPhoneFile-$i";
			$temp3 = "txtCellPhoneOptional-$i";
			$stmt_cell->bind_param("sss", $temp1, $inputs[$temp2], $inputs[$temp3]);			// bind parameters for markers								// 
			$result=$stmt_cell->execute();														// execute query
			if (!$result) {
				echo 'Could not insert the data "CellPhone": ' . $db->error;
			}
			$i++;
		}
		$stmt_cell->close();
	}
	
// watch
	$query="DELETE FROM watch WHERE ISO_ROD_index = $inputs[idx]";
	$result=$db->query($query);
	if ($inputs['watch']) {
		$i = 1;
		$query="INSERT INTO watch (ISO, ROD_Code, Variant_Code, ISO_ROD_index, organization, watch_what, URL, JesusFilm, YouTube) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $inputs[idx], ?, ?, ?, ?, ?)";
		$stmt_watch=$db->prepare($query);
		while (isset($inputs["txtWatchWebSource-$i"])) {
			$temp1 = "txtWatchWebSource-$i";
			$temp2 = "txtWatchResource-$i";
			$temp3 = "txtWatchURL-$i";
			$temp4 = "txtWatchJesusFilm-$i";
			$temp5 = "txtWatchYouTube-$i";
			$stmt_watch->bind_param('sssii', $inputs[$temp1], $inputs[$temp2], $inputs[$temp3], $inputs[$temp4], $inputs[$temp5]);		// bind parameters for markers
			$result=$stmt_watch->execute();															// execute query
			if (!$result) {
				echo 'Could not insert the data "watch": ' . $db->error;
			}
			$i++;
		}
		$stmt_watch->close();
	}
	
// study
	$query="DELETE FROM study WHERE ISO_ROD_index = $inputs[idx]";
	$result=$db->query($query);
	if ($inputs['study']) {
		$i = 1;
		$query="INSERT INTO study (ISO, ROD_Code, Variant_Code, ISO_ROD_index, ScriptureDescription, Testament, alphabet, ScriptureURL, statement, othersiteDescription, othersiteURL) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $inputs[idx], ?, ?, ?, ?, ?, ?, ?)";
		$stmt_study=$db->prepare($query);
		while (isset($inputs["txtScriptureDescription-$i"])) {
			$temp1 = "txtScriptureDescription-$i";
			$temp2 = "txtScriptureURL-$i";
			$temp3 = "txtStatement-$i";
			$temp4 = "txtOthersiteDescription-$i";
			$temp5 = "txtOthersiteURL-$i";
			if ($inputs["SNT-".(string)$i] == 1) $temp6 = "New Testament";
			if ($inputs["SOT-".(string)$i] == 1) $temp6 = "Old Testament";
			if ($inputs["SBible-".(string)$i] == 1) $temp6 = "Bible";
			if ($inputs["SStandAlphabet-".(string)$i] == 1) $temp7 = "Standard alphabet";
			if ($inputs["STradAlphabet-".(string)$i] == 1) $temp7 = "Traditional alphabet";
			if ($inputs["SNewAlphabet-".(string)$i] == 1) $temp7 = "New alphabet";
			$stmt_study->bind_param("sssssss", $inputs[$temp1], $temp6, $temp7, $inputs[$temp2], $inputs[$temp3], $inputs[$temp4], $inputs[$temp5]);		// bind parameters for markers
			$result=$stmt_study->execute();															// execute query
			if (!$result) {
				echo 'Could not update the data "study": ' . $db->error;
			}
			$i++;
		}
		$stmt_study->close();
	}
	
// viewer
	$query="DELETE FROM viewer WHERE ISO_ROD_index = $inputs[idx]";
	$result=$db->query($query);
	if ($inputs['viewer']) {
		if (($inputs['viewerText'] != '') || ($inputs['rtl'] == 1)) {
			$query="INSERT INTO viewer (ISO, ROD_Code, Variant_Code, ISO_ROD_index, viewer_ROD_Variant, rtl) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $inputs[idx], '$inputs[viewerText]', '$inputs[rtl]')";
			$result=$db->query($query);
			if (!$result) {
				echo 'Could not update the data "viewer_ROD_Variant": ' . $db->error;
			}
		}
	}
	
// other_titles
	$query="DELETE FROM other_titles WHERE ISO_ROD_index = $inputs[idx]";
	$result=$db->query($query);
	if ($inputs['other_titles']) {
		$i = 1;
		$query="INSERT INTO other_titles (ISO, ROD_Code, Variant_Code, ISO_ROD_index, other, other_title, other_PDF, other_audio, download_video) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $inputs[idx], ?, ?, ?, ?, ?)";
		$stmt_other=$db->prepare($query);
		while (isset($inputs["txtOther-$i"])) {
			$temp1 = "txtOther-$i";
			$temp2 = "txtOtherTitle-$i";
			$temp3 = "txtOtherPDF-$i";
			$temp4 = "txtOtherAudio-$i";
			$temp5 = "txtDownload_video-$i";
			$stmt_other->bind_param("sssss", $inputs[$temp1], $inputs[$temp2], $inputs[$temp3], $inputs[$temp4], $inputs[$temp5]);	// bind parameters for markers								// 
			$result=$stmt_other->execute();													// execute query
			if (!$result) {
				echo 'Could not insert the data "other-titles": ' . $db->error;
			}
			$i++;
		}
		$stmt_other->close();
	}
	
// buy (buy table)
	$query="DELETE FROM buy WHERE ISO_ROD_index = $inputs[idx]";
	$result=$db->query($query);
	if ($inputs['buy']) {
		$i = 1;
		$query="INSERT INTO buy (ISO, ROD_Code, Variant_Code, ISO_ROD_index, organization, buy_what, URL) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $inputs[idx], ?, ?, ?)";
		$stmt_buy=$db->prepare($query);
		while (isset($inputs["txtBuyWebSource-$i"])) {
			$temp1 = "txtBuyWebSource-$i";
			$temp2 = "txtBuyResource-$i";
			$temp3 = "txtBuyURL-$i";
			$stmt_buy->bind_param("sss", $inputs[$temp1], $inputs[$temp2], $inputs[$temp3]);	// bind parameters for markers								// 
			$result=$stmt_buy->execute();														// execute query
			if (!$result) {
				echo 'Could not insert the data "buy": ' . $db->error;
			}
			$i++;
		}
		$stmt_buy->close();
	}
	
// links: buy
	$query="DELETE FROM links WHERE ISO_ROD_index = $inputs[idx] AND buy = 1";
	$result=$db->query($query);
	if ($inputs['linksBuy']) {																		// test
		$i = 1;
		$query="INSERT INTO links (ISO, ROD_Code, Variant_Code, ISO_ROD_index, company, company_title, `URL`, buy) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $inputs[idx], ?, ?, ?, 1)";
		$stmt_links=$db->prepare($query);
		//while (isset($inputs["txtLinkCompany-$i"]) && $inputs["linksBuy-$i"] == 1) {
		for (; isset($inputs["txtLinkCompany-$i"]); $i++) {
			if (!isset($inputs["linksBuy-$i"])) continue;
			$temp1 = "txtLinkCompany-$i";
			$temp2 = "txtLinkCompanyTitle-$i";
			$temp3 = "txtLinkURL-$i";
			//$temp4 = "linksBuy-$i";
			$stmt_links->bind_param("sss", $inputs[$temp1], $inputs[$temp2], $inputs[$temp3]);		// bind parameters for markers
			$result=$stmt_links->execute();															// execute query
			if (!$result) {
				echo 'Could not insert the data "links buy": ' . $db->error;
			}
			//$i++;
		}
		$stmt_links->close();
	}

// links: map
	$query="DELETE FROM links WHERE ISO_ROD_index = $inputs[idx] AND map = 1";
	$result=$db->query($query);
	if ($inputs['linksMap']) {																		// test
		$i = 1;
		$query="INSERT INTO links (ISO, ROD_Code, Variant_Code, ISO_ROD_index, company, company_title, `URL`, map) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $inputs[idx], ?, ?, ?, 1)";
		$stmt_links=$db->prepare($query);
		//while (isset($inputs["txtLinkCompany-$i"]) && $inputs["linksMap-$i"]) {
		for (; isset($inputs["txtLinkCompany-$i"]); $i++) {
			if (!isset($inputs["linksMap-$i"])) continue;
			$temp1 = "txtLinkCompany-$i";
			$temp2 = "txtLinkCompanyTitle-$i";
			$temp3 = "txtLinkURL-$i";
			//$temp5 = "linksMap-$i";
			$stmt_links->bind_param("sss", $inputs[$temp1], $inputs[$temp2], $inputs[$temp3]);		// bind parameters for markers
			$result=$stmt_links->execute();															// execute query
			if (!$result) {
				echo 'Could not insert the data "links map": ' . $db->error;
			}
			//$i++;
		}
		$stmt_links->close();
	}

// links: GooglePlay
	$query="DELETE FROM links WHERE ISO_ROD_index = $inputs[idx] AND GooglePlay = 1";
	$result=$db->query($query);
	if ($inputs['linksGooglePlay']) {																// test
		$i = 1;
		$query="INSERT INTO links (ISO, ROD_Code, Variant_Code, ISO_ROD_index, company, company_title, `URL`, GooglePlay) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $inputs[idx], ?, ?, ?, 1)";
		$stmt_links=$db->prepare($query);
		//while (isset($inputs["txtLinkCompany-$i"]) && $inputs["linksGooglePlay-$i"]) {
		for (; isset($inputs["txtLinkCompany-$i"]); $i++) {
			if (!isset($inputs["linksGooglePlay-$i"])) continue;	// || $inputs["linksGooglePlay-$i"] == 0 Bill ????
			$temp1 = "txtLinkCompany-$i";
			$temp2 = "txtLinkCompanyTitle-$i";
			$temp3 = "txtLinkURL-$i";
			//$temp6 = "linksGooglePlay-$i";
			$stmt_links->bind_param("sss", $inputs[$temp1], $inputs[$temp2], $inputs[$temp3]);		// bind parameters for markers
			$result=$stmt_links->execute();															// execute query
			if (!$result) {
				echo 'Could not insert the data "links Google Play": ' . $db->error;
			}
			//$i++;
		}
		$stmt_links->close();
	}

// other links
	$query="DELETE FROM links WHERE ISO_ROD_index = $inputs[idx] AND (buy = 0 AND map = 0 AND GooglePlay = 0 AND BibleIs = 0 AND BibleIsGospelFilm = 0 AND YouVersion = 0 AND Bibles_org = 0 AND GRN = 0 AND email = 0)";
	$result=$db->query($query);
	if ($inputs['linksOther']) {																	// test
		$i = 1;
		$query="INSERT INTO links (ISO, ROD_Code, Variant_Code, ISO_ROD_index, company, company_title, `URL`) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $inputs[idx], ?, ?, ?)";
		$stmt_links=$db->prepare($query);
		//while (isset($inputs["txtLinkCompany-$i"]) && (isset($inputs["linksBuy-$i"]) ? 1 : 0) && (isset($inputs["linksMap-$i"]) ? 1 : 0) && (isset($inputs["linksGooglePlay-$i"]) ? 1 : 0) && (isset($inputs["BibleIs-$i"]) ? 1 : 0) && (isset($inputs["YouVersion-$i"]) ? 1 : 0) && (isset($inputs["Bibles_org-$i"]) ? 1 : 0) && (isset($inputs["GRN-$i"]) ? 1 : 0) && (isset($inputs["email-$i"]) ? 1 : 0)) {
		for (; isset($inputs["txtLinkCompany-$i"]); $i++) {
			if (!isset($inputs["linksOther-$i"])) continue;
			$temp1 = "txtLinkCompany-$i";
			$temp2 = "txtLinkCompanyTitle-$i";
			$temp3 = "txtLinkURL-$i";
			$stmt_links->bind_param("sss", $inputs[$temp1], $inputs[$temp2], $inputs[$temp3]);		// bind parameters for markers
			$result=$stmt_links->execute();															// execute query
			if (!$result) {
				echo 'Could not insert the data "links other": ' . $db->error;
			}
			//$i++;
		}
		$stmt_links->close();
	}

// links: email
	$query="DELETE FROM links WHERE ISO_ROD_index = $inputs[idx] AND email = 1";					// otherwise buy, map, and GooglePlay 
	$result=$db->query($query);
	if ($inputs['email']) {
		$i = 1;
		$query="INSERT INTO links (ISO, ROD_Code, Variant_Code, ISO_ROD_index, company, company_title, `URL`, email) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $inputs[idx], '', ?, ?, 1)";
		$stmt_links=$db->prepare($query);
		while (isset($inputs['txtEmailAddress-'.(string)$i])) {
			$temp1 = 'txtEmailTitle-'.(string)$i;
			$temp2 = 'txtEmailAddress-'.(string)$i;
			$stmt_links->bind_param("ss", $inputs[$temp1], $inputs[$temp2]);						// bind parameters for markers
			$result=$stmt_links->execute();															// execute query
			if (!$result) {
				echo 'Could not insert the data "links": ' . $db->error;
			}
			$i++;
		}
		$stmt_links->close();
	}

// PlaylistAudio
	$query="DELETE FROM PlaylistAudio WHERE ISO_ROD_index = $inputs[idx]";
	$result=$db->query($query);
	if ($inputs['AudioPlaylist']) {
		$i = 1;
		$query="INSERT INTO PlaylistAudio (ISO, ROD_Code, Variant_Code, ISO_ROD_index, PlaylistAudioTitle, PlaylistAudioFilename) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $inputs[idx], ?, ?)";
		$stmt_Audio=$db->prepare($query);
		while (isset($inputs["txtPlaylistAudioTitle-$i"])) {
			$temp1 = "txtPlaylistAudioTitle-$i";
			$temp2 = "txtPlaylistAudioFilename-$i";
			$stmt_Audio->bind_param("ss", $inputs[$temp1], $inputs[$temp2]);						// bind parameters for markers								// 
			$result = $stmt_Audio->execute();														// execute query
			if (!$result) {
				echo 'Could not insert the data "Audio Playlist": ' . $db->error;
			}
			$i++;
		}
		$stmt_Audio->close();
	}

// PlaylistVideo
	$query="DELETE FROM PlaylistVideo WHERE ISO_ROD_index = $inputs[idx]";
	$result=$db->query($query);
	if ($inputs['VideoPlaylist']) {
		$i = 1;
		$query="INSERT INTO PlaylistVideo (ISO, ROD_Code, Variant_Code, ISO_ROD_index, PlaylistVideoTitle, PlaylistVideoFilename, PlaylistVideoDownload) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $inputs[idx], ?, ?, ?)";
		$stmt_Video=$db->prepare($query);
		while (isset($inputs["txtPlaylistVideoTitle-$i"])) {
			$temp1 = "txtPlaylistVideoTitle-$i";
			$temp2 = "txtPlaylistVideoFilename-$i";
			$temp3 = "PlaylistVideoDownload-$i";
			$stmt_Video->bind_param("ssi", $inputs[$temp1], $inputs[$temp2], $inputs[$temp3]);		// bind parameters for markers
			$result = $stmt_Video->execute();														// execute query
			if (!$result) {
				echo 'Could not insert the data "Video Playlist": ' . $db->error;
			}
			$i++;
		}
		$stmt_Video->close();
	}

// FCBH
	// A checked on FCBH only goes through this code. When unchecked the scripture_main takes it over.
	$inputs['FCBH'] = 0;		// FCBH is no longer needed.
	if ($inputs['FCBH']) {
		$query="SELECT * FROM FCBHLanguageList WHERE ISO = '$inputs[iso]' AND ROD_Code = '$inputs[rod]' AND DAM_ID IS NOT NULL"; 	//AND (Variant_Code = '$inputs[var]' OR '$inputs[var]' IS NULL OR '$inputs[var]' = '')
		$result=$db->query($query);
		if (!$result or ($result->num_rows == 0)) {
			 echo '<div style="font-size: 14pt; font-weight: bold; text-align: center; ">';
			 echo 'There is an error writing to the FCBH table where DAM_ID is not found.<br />';
			 echo "Send an email message to <a href=\'mailto:Scott_Starker&#64;sil.org?subject=Edit:%20FCBH%20error:%20'$inputs[iso]',%20'$inputs[rod]',%20'$inputs[var]'\>Scott Starker</a> ";
			 echo 'for him to fix the problem.';
			 echo '</div>';
			 echo "<h1 style='text-align: center; '>Except for the FCBH error,</h1>";
		}
		else {
			$r = $result->fetch_assoc();
			$DAM_ID=$r['DAM_ID'];
			$query="UPDATE FCBHLanguageList SET ISO_ROD_index = $inputs[idx] + 0 WHERE ISO = '$inputs[iso]' AND ROD_Code = '$inputs[rod]' AND DAM_ID = '$DAM_ID'";		// AND (Variant_Code = '$inputs[var]' OR '$inputs[var]' IS NULL OR '$inputs[var]' = '')
			$result=$db->query($query);
			if (!$result) {
				echo 'Could not update the "idx" on "FCBHLanguageList": ' . $db->error;
			}
		}
	}
	
// eBible
	$result=$db->query("SELECT translationId FROM eBible_list WHERE ISO_ROD_index = $inputs[idx]");
	if ($r = $result->fetch_assoc()) {
		$translationId=$r['translationId'];
		$result=$db->query("UPDATE eBible_list SET ISO_ROD_index = NULL WHERE ISO_ROD_index = $inputs[idx]");
		if ($inputs['eBible']) {
			$query="UPDATE eBible_list SET ISO_ROD_index = $inputs[idx] WHERE translationId = '$translationId'";
			$result=$db->query($query);
			if (!$result) {
				echo 'Could not update the data "eBible_list": ' . $db->error;
			}
		}
	}

// completed
	echo "<h2 style='text-align: center; '>You have successfully completed the edit to ";
    /*
     * It is safe to echo $_POST['txtName'] here because
     * it has (supposedly) passed validation, but it is
     * better to use the sanitized $inputs array.
     */
	echo "'".$inputs['iso']."' '".$inputs['rod']."' '".$inputs['var']."'.";
	echo "</h2><br />";
	echo "<form>";
	echo "<input type='reset' value='Go back to the Edit script' onclick='parent.location=\"Scripture_Edit.php\"' />";
	echo "</form>";	
	echo "</div>";
	echo "<br />";

	if ($inputs['isopText'] != '') {																		// the "case" iso text
		// read and write 404.shtml
		$file_404 = file_get_contents('404.shtml');															// read in string 404.shtml
		$file_array = explode("\n", $file_404);																// array on '\n'
		$temp = 'idx='.$inputs['idx'];
		if (array_pos_search($temp, $file_array)) {															// function array_pos_search is below. to search for a substr within an array
			// update
			$arrlength = count($file_array);
			for($x=0; $x<$arrlength; $x++) {
				if (strpos($file_array[$x], $temp)) {
					$temp1 = "		case '".$inputs['isopText']."':";
					$temp2 = '			window.location.replace("https://www.ScriptureEarth.org/"+navLang+"?idx='.$inputs['idx'].'");		// '.$inputs['iso'].' '.$inputs['rod'].' '.$inputs['idx'].' '.$inputs['isopText'];
					array_splice($file_array, $x-1, 2, [$temp1, $temp2]);									// and delete 2
					break;
				}
			}
		}
		else {
			// insert
			$arrlength = count($file_array);
			for($x=0; $x<$arrlength; $x++) {
				if (strpos($file_array[$x], '(query)')) {													// switch (query) only occurs once in 404.shtml
					$temp1 = "		case '".$inputs['isopText']."':";
					$temp2 = '			window.location.replace("https://www.ScriptureEarth.org/"+navLang+"?idx='.$inputs['idx'].'");		// '.$inputs['iso'].' '.$inputs['rod'].' '.$inputs['idx'].' '.$inputs['isopText'];
					$temp3 = '			break;';
					array_splice($file_array, $x+1, 0, [$temp1, $temp2, $temp3]);
					break;
				}
			}
		}
		$file_404 = implode("\n", $file_array);
		file_put_contents('404.shtml', $file_404);
	}
	
	echo "<div style='text-align: center; background-color: #333333; margin: 0px auto 0px auto; padding: 20px; width: 1020px; border-radius: 15px; -moz-border-radius: 15px; -webkit-box-shadow: 15px; '>";
	echo "<div class='nav' style='font-weight: normal; color: white; font-size: 10pt; '><sup>©</sup>2009 - ".date('Y')." <span style='color: #99FF99; '>ScriptureEarth.org</span></div>";
	echo "</div>";
	$db->close();
	
	function array_pos_search($search, $array){
		foreach($array as $index => $value){
			if (strpos($value, $search)){
				return 1;
			}
		}
		return 0;
	}

?>
</body>
</html>