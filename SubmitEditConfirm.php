<?php
	// This page cannot be accessed directly

//use PhpMyAdmin\Console;

function console_log($data) {
	$html = '';
	$coll = '';
	if (is_array($data) || is_object($data)) {
		$coll = json_encode($data);
	}
	else {
		$coll = $data;
	}
	$html = "<script id='console_log'>console.log('PHP: $coll');</script>";
	echo($html);
}

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
			$temp4 = $inputs["BibleIsDefault-".(string)$i] + $inputs["BibleIsText-".(string)$i] + $inputs["BibleIsAudio-".(string)$i] + $inputs["BibleIsVideo-".(string)$i] + $inputs["BibleIsTextAudio-".(string)$i] + $inputs["BibleIsTextVideo-".(string)$i] + $inputs["BibleIsAudioVideo-".(string)$i] + $inputs["BibleIsTextAudioVideo-".(string)$i];		// only one is set
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
		column SAB_Audio is booleon
		column SAB_number: The same ISO/ROD_Code/Variant_Code/ISO_ROD_index but diffenent "subfolder."			
	*/
	if ($inputs['SAB'] == 0) {
		$db->query("DELETE FROM SAB WHERE ISO_ROD_index = $inputs[idx]");
		$db->query("DELETE FROM SAB_scriptoria WHERE ISO_ROD_index = $inputs[idx]");
	}
	else {
		if (substr($_SERVER['REMOTE_ADDR'], 0, 8) != '168.148.') {	//127.0.0.') {														// Is the script local?
			$db->query("DELETE FROM SAB_scriptoria WHERE ISO_ROD_index = $inputs[idx]");
			//$query="UPDATE SAB_scriptoria SET `url` = ?, `subfolder` = ?, `description` = ? WHERE ISO_ROD_index = $inputs[idx] AND SAB_number = ?";
			//$stmt_SAB_scriptoria=$db->prepare($query);

			$SABTemp = 1;
			while (isset($inputs["txtSABurl-".(string)$SABTemp]) || isset($inputs["txtSABsubfolder-".(string)$SABTemp])) {												// maximum value of $i
				//console_log('while: url: ' . $inputs["txtSABurl-".(string)$SABTemp] . ' subfolder: ' . $inputs["txtSABsubfolder-".(string)$SABTemp]);
				$SABTemp++;
			}

			for ($i = 1; $i < $SABTemp; $i++) {		//strlen(trim($inputs["txtSABsubFirstPath-".(string)$i]) >= 4)) {	// $inputs["txtSABsubFirstPath-".(string)$i]) = "sab" by default
				$SABurl = "txtSABurl-".(string)$i;
				$SABsubfolder = "txtSABsubfolder-".(string)$i;
				$SABdescription = "txtSABdescription-".(string)$i;
				// console_log('url: ' . $inputs["txtSABurl-".(string)$i] . ' ! ' . $SABurl . ' ' . $SABdescription . ' ' . $SABsubfolder);
				//console_log("idx: $inputs[idx] url: " . $inputs[$SABurl] . ' description: ' . $inputs[$SABdescription] . ' subfolder: ' . $inputs[$SABsubfolder]);
				$query = "INSERT INTO SAB_scriptoria (ISO, ROD_Code, Variant_Code, ISO_ROD_index, `url`, subfolder, `description`, pre_scriptoria, SAB_number) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $inputs[idx], '$inputs[$SABurl]', '$inputs[$SABsubfolder]', '$inputs[$SABdescription]', '', $i)";
				$db->query($query) or die ('Query failed: ' . $db->error . '</body></html>');
				if ($inputs[$SABsubfolder] != '') {
					$SAB_Path = './data/'.$inputs['iso'].'/'.$inputs[$SABsubfolder];
					if (!is_dir($SAB_Path)) {
						echo 'No path to '.$SAB_Path.' in SAB. Skipped the INSERTs/UPDATEs.<br />';
						$i++;
						continue;
					}
					$SAB_array = glob($SAB_Path."*.html", GLOB_MARK | GLOB_NOCHECK | GLOB_NOESCAPE | GLOB_NOSORT);			// all HTML files
					if (count($SAB_array) === 0) {																			// there are html files here
						echo '<h3>No HTML files found in '.$SAB_Path.'. Be sure you uploaded the HTML files from you\'re comptuer to the SE server AND then re-run the Edit of CMS again.</h3>';
					}
					else {
						/*$query="SELECT ISO_ROD_index FROM scripture_main WHERE ISO_ROD_index = $inputs[idx]";
						$result=$db->query($query) or die ('Query failed: ' . $db->error . '</body></html>');
						if ($result->num_rows === 0) {
							echo 'ISO ROD index not found.<br />';
							continue;
						}
						$row = $result->fetch_assoc();*/
						$ISO = $inputs['iso'];
						$ROD_Code = $inputs['rod'];
						$Variant_Code = $inputs['var'];
						$ISO_ROD_index = $inputs['idx'];
						//echo $ISO . ' ' . $ROD_Code . ' ' .$Variant_Code . ' ' . $ISO_ROD_index . ' %<br />';
						// in SAB table
						// Already have SAB_Book ($book_number), SAB_Chapter ($chapter), Book_Chapter_HTML ("$SAB_record"), ISO ("$inputs[iso]"), ROD_Code ("$inputs[rod]"), Variant_Code ("$inputs[var]"), ISO_ROD_index ($ISO_ROD_index)
						$query="SELECT SAB_Audio, SAB_number, SABDate, SABSize FROM SAB WHERE ISO_ROD_index = $ISO_ROD_index AND Book_Chapter_HTML = ? AND SAB_Book = ? AND SAB_Chapter = ? AND SAB_number = $i LIMIT 1";		// 1 chapter
						$stmt_SAB_SELECT=$db->prepare($query);

						// INSERT in SAB table
						$query="INSERT INTO SAB (ISO, ROD_Code, Variant_Code, ISO_ROD_index, Book_Chapter_HTML, SAB_Book, SAB_Chapter, SAB_Audio, SAB_number, SABDate, SABSize, deleteSAB) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $ISO_ROD_index, ?, ?, ?, 0, $i, CONVERT(?, datetime), ?, 0)";
						$stmt_SAB_INSERT=$db->prepare($query);
						
						// UPDATE SAB table SET SABDate and SABSize
						$query="UPDATE SAB SET SABDate = CONVERT(?, datetime), SABSize = ?, deleteSAB = 0 WHERE ISO_ROD_index = $ISO_ROD_index AND Book_Chapter_HTML = ? AND SAB_Book = ? AND SAB_Chapter = ? AND SAB_number = $i";
						$stmt_SAB_UPDATE=$db->prepare($query);

						// UPDATE SAB table SET deleteSAB = 0
						$query="UPDATE SAB SET deleteSAB = 0 WHERE ISO_ROD_index = $ISO_ROD_index AND Book_Chapter_HTML = ? AND SAB_Book = ? AND SAB_Chapter = ? AND SAB_number = $i";
						$stmt_SAB_UPDATE_Delete=$db->prepare($query);

						$query="SELECT SABDate, SABSize FROM SAB WHERE ISO = ? AND ISO_ROD_index = ? AND Book_Chapter_HTML = ? AND SAB_number = $i";
						$stmt_match_SELECT=$db->prepare($query);

						$query="SELECT ISO FROM SAB WHERE ISO_ROD_index = $ISO_ROD_index AND SAB_number = $i LIMIT 1";	// used later
						$result_empty=$db->query($query) or die (translate('Query failed:', $st, 'sys') . ' ' . $db->error . '</body></html>');

						$ISOPlus = substr($inputs[$SABsubfolder], 4, -1);												// 'sab/[ISOPlus]/'
						$query="UPDATE SAB SET deleteSAB = 1 WHERE Book_Chapter_HTML <> 'index.html' AND Book_Chapter_HTML <> 'about.partial.html' AND Book_Chapter_HTML LIKE '%".$ISOPlus."-%' AND ISO_ROD_index = $ISO_ROD_index AND SAB_number = $i";			// bind parameters for markers
						$db->query($query) or die ('Query failed: ' . $db->error . '</body></html>');
						foreach ($SAB_array as $SAB_record) {															// all HTML files
							if ($SAB_record == './data/'.$ISO.'/'.$inputs[$SABsubfolder].'index.html') continue;
							if ($SAB_record == './data/'.$ISO.'/'.$inputs[$SABsubfolder].'about.partial.html') continue;
							$fDate =  date("Y-m-d H:i", filemtime($SAB_record));										// was last changed; leading 0s; data convert the file date to a string
							$fDate .= ':00';
							clearstatcache();																			// Clear cache and check filesize again
							$fSize =  filesize($SAB_record);															// server

							$SAB_record = substr($SAB_record, strrpos($SAB_record, '/')+1);								// IMPORTANT! Gets rids of directories just before the html name. strrpos - returns the poistion of the last occurrence of the substring
							if (!preg_match('/(-|^)([0-9]+)-/', $SAB_record, $match)) {									// match the book from the html file
								echo $SAB_record . ' does not match the book for the html file. DELETEd from SAB table.<br />';
								continue;																				// continue with a new html file
							}
							$book_number = (int)$match[2];																// book_number = match
							
							if (!preg_match('/-([0-9]+)\.html/', $SAB_record, $match)) {								// match the chapter from the html file
								echo $SAB_record . ' does not match the chapter for the html file. DELETEd from SAB table.<br />';
								continue;																				// continue with a new html file
							}
							$chapter = (int)$match[1];																	// chapter = match

							if ($result_empty->num_rows === 0) {														// INSERT the file to SAB table the SAB table is empty
								$stmt_SAB_INSERT->bind_param("siisi", $SAB_record, $book_number, $chapter, $fDate, $fSize);		// bind parameters for markers
								$stmt_SAB_INSERT->execute() or trigger_error($stmt_SAB_INSERT->error, E_USER_ERROR);	// execute query
								//echo 'SAB table is empty so copy all of the files into SAB table.<br />';
								continue;																				// continue with a new html file
							}

							//echo 'Book_Chapter_HTML: ' . $SAB_record . ' book_number: ' . $book_number . ' chapter: ' . $chapter . '<br />';
							$stmt_match_SELECT->bind_param("sis", $ISO, $ISO_ROD_index, $SAB_record);					// Is Book_Chapter_HTML ($SAB_record) in SAB table?
							$stmt_match_SELECT->execute();																// execute query
							$result_match_SELECT = $stmt_match_SELECT->get_result();									// instead of bind_result (used for only 1 record):
							if ($result_match_SELECT->num_rows === 0) {
								//echo 'SAB_record: ' . $SAB_record . '. Not found in DB. So, INSERT it into DB.<br />';
								$stmt_SAB_INSERT->bind_param("siisi", $SAB_record, $book_number, $chapter, $fDate, $fSize);		// bind parameters for markers
								$stmt_SAB_INSERT->execute() or trigger_error($stmt_SAB_INSERT->error, E_USER_ERROR);	// execute query
								//echo $SAB_record . ' is not in SAB table so INSERT the file book, chapter, date, and size into into the SAB table.<br />';
								continue;
							}
							//echo $SAB_record . ' is in SAB table.<br />';

							$rowMatch = $result_match_SELECT->fetch_assoc();
							// "Y-m-d H:i:00"
							$DBDate = $rowMatch['SABDate'];
							$DBSize = $rowMatch['SABSize'];
							//echo 'file date: ' . $fDate . ' DB date: ' . $DBDate . ' file size: ' . $fSize . ' DB size: ' . $DBSize . '<br />';
							if ($fDate == $DBDate && $fSize == $DBSize) {												// Running: in takes about 20 seconds
								$stmt_SAB_UPDATE_Delete->bind_param("sii", $SAB_record, $book_number, $chapter);		// bind parameters for markers
								$stmt_SAB_UPDATE_Delete->execute() or trigger_error($stmt_SAB_UPDATE_Delete->error, E_USER_ERROR);	// execute query
								//echo 'Date and time are the same, so UPDATE delete = 0<br />';
							}
							else {
								//echo 'No match between Date and time.<br />';
								$stmt_SAB_SELECT->bind_param("sii", $SAB_record, $book_number, $chapter);				// Is Book_Chapter_HTML (i.e., SAB_record) in SAB? Either INSERT or UPDATE
								$stmt_SAB_SELECT->execute();															// execute query
								$result_SAB_SELECT = $stmt_SAB_SELECT->get_result();									// instead of bind_result (used for only 1 record):
								if ($result_SAB_SELECT->num_rows === 0) {
									//echo 'SAB_record: ' . $SAB_record . '. Not found in DB. So, INSERT it into DB.<br />';
									$stmt_SAB_INSERT->bind_param("siisi", $SAB_record, $book_number, $chapter, $fDate, $fSize);		// bind parameters for markers
									$stmt_SAB_INSERT->execute() or trigger_error($stmt_SAB_INSERT->error, E_USER_ERROR);	// execute query
									//echo 'Book_Chapter_HTML (i.e., SAB_record) in SAB? INSERT the date and time into SAB tables<br />';
									//echo '<h3 style="color: darkred; ">INSERT SAB_record: ' . $SAB_record . ' Date: ' . $fDate . ' Time: ' . $fSize . ' ISO_ROD_index: ' . "$inputs[idx]" . ' subfolder: ' . $SABsubfolder . '</h3>';
								}
								else {
									//echo 'SAB_record ' . $SAB_record . ': UPDATE ' . $fDate . ' ' . $fSize . ' ' . $book_number . ' ' . $chapter . '<br />';
									$stmt_SAB_UPDATE->bind_param("sisii", $fDate, $fSize, $SAB_record, $book_number, $chapter);		// bind parameters for markers
									$stmt_SAB_UPDATE->execute() or trigger_error($stmt_SAB_UPDATE->error, E_USER_ERROR);	// execute query
									//echo 'Book_Chapter_HTML (i.e., SAB_record) in SAB? UPDATE the date and time into SAB tables<br />';
								}
							}
							$query="SELECT ISO FROM SAB WHERE ISO_ROD_index = $ISO_ROD_index AND SAB_number = $i AND deleteSAB = 1";
							$result_temp=$db->query($query) or die ('Query failed: ' . $db->error . '</body></html>');
							if ($result_temp->num_rows != 0) {
								//echo 'Gobal DELETE WHERE deleteSAB = 1<br />';
								// DELETE FROM SAB WHERE deleteSAB = 1
								$query="DELETE FROM SAB WHERE ISO_ROD_index = $ISO_ROD_index AND SAB_number = $i AND deleteSAB = 1";
								$db->query($query) or die ('Query failed: ' . $db->error . '</body></html>');
							}
						}
					}
				}
			}
		}
		else {
			echo '</h3>You are running the script on a local host. You have to re-run this script from a remote host (i.e., InMotion Hosting)<br />';
			echo 'in oder to INSERT/UPDATE the SAB table.</h3>';
		}
	}
console_log('SAB done');

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
			if ($inputs["CPAndroidApp-".(string)$i] == 1) $temp1 = "Android App";
			if ($inputs["CPiOSAssetPackage-".(string)$i] == 1) $temp1 = "iOS Asset Package";
			if ($inputs["CPePub-".(string)$i] == 1) $temp1 = "ePub";
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
	if ($inputs['linksBuy']) {
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
	if ($inputs['linksMap']) {
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
	if ($inputs['linksGooglePlay']) {
		$i = 1;
		$query="INSERT INTO links (ISO, ROD_Code, Variant_Code, ISO_ROD_index, company, company_title, `URL`, GooglePlay) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $inputs[idx], ?, ?, ?, 1)";
		$stmt_links=$db->prepare($query);
		//while (isset($inputs["txtLinkCompany-$i"]) && $inputs["linksGooglePlay-$i"]) {
		for (; isset($inputs["txtLinkCompany-$i"]); $i++) {
			if (!isset($inputs["linksGooglePlay-$i"])) continue;	// || $inputs["linksGooglePlay-$i"] == 0 Bill ????
			$temp1 = "txtLinkCompany-$i";
			$temp2 = "txtLinkCompanyTitle-$i";
			$temp3 = "txtLinkURL-$i";
			$stmt_links->bind_param("sss", $inputs[$temp1], $inputs[$temp2], $inputs[$temp3]);		// bind parameters for markers
			$result=$stmt_links->execute();															// execute query
			if (!$result) {
				echo 'Could not insert the data "links Google Play": ' . $db->error;
			}
		}
		$stmt_links->close();
	}
// links: Kalaam
	$query="DELETE FROM links WHERE ISO_ROD_index = $inputs[idx] AND Kalaam = 1";
	$result=$db->query($query);
	if ($inputs['linksKalaam']) {
		$i = 1;
		$query="INSERT INTO links (ISO, ROD_Code, Variant_Code, ISO_ROD_index, company, company_title, `URL`, Kalaam) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $inputs[idx], ?, ?, ?, 1)";
		$stmt_links=$db->prepare($query);
		//while (isset($inputs["txtLinkCompany-$i"]) && $inputs["linksKalaam-$i"]) {
		for (; isset($inputs["txtLinkCompany-$i"]); $i++) {
			if (!isset($inputs["linksKalaam-$i"])) continue;	// || $inputs["linksKalaam-$i"] == 0 Bill ????
			$temp1 = "txtLinkCompany-$i";
			$temp2 = "txtLinkCompanyTitle-$i";
			$temp3 = "txtLinkURL-$i";
			$stmt_links->bind_param("sss", $inputs[$temp1], $inputs[$temp2], $inputs[$temp3]);		// bind parameters for markers
			$result=$stmt_links->execute();															// execute query
			if (!$result) {
				echo 'Could not insert the data "links Kalaam Media": ' . $db->error;
			}
		}
		$stmt_links->close();
	}

// other links
	$query="DELETE FROM links WHERE ISO_ROD_index = $inputs[idx] AND (buy = 0 AND map = 0 AND GooglePlay = 0 AND BibleIs = 0 AND BibleIsGospelFilm = 0 AND YouVersion = 0 AND Bibles_org = 0 AND GRN = 0 AND email = 0 AND Kalaam = 0)";
	$result=$db->query($query);
	if ($inputs['linksOther']) {
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
		if (!$result || ($result->num_rows === 0)) {
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
	/* not needed (5/2024)
	if ($inputs['eBible']) {
		$result=$db->query("SELECT translationId FROM eBible_list WHERE ISO_ROD_index = $inputs[idx]");
		if ($result->num_rows > 0) {
			$r = $result->fetch_assoc();
			//$translationId=$r['translationId'];
			//$result=$db->query("UPDATE eBible_list SET ISO_ROD_index = NULL WHERE ISO_ROD_index = $inputs[idx]");
			//$query="UPDATE eBible_list SET ISO_ROD_index = $inputs[idx] WHERE translationId = '$translationId'";
			//$result=$db->query($query);
			//if (!$result) {
			//	echo 'Could not update the data "eBible_list": ' . $db->error;
			//}
		}
	}*/
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