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
* 			side of the windows click on "Scripture Add", Localhost", "_js", and "CMS_events.js". Look down the js file
* 			and find out if there are errors using the "underline" indicator and fix them if there are any. You can also
* 			use "Scripture_Add.php" just to make sure that the document.getElementById('...') name is corrent.
* 			There no stements in "_js/CMS_events.js" (8/2020) in "SubmitAddConfirm.php".
*			But, BE CAREFUL!
*
**************************************************************************************************************************************/

	//define ("PATHScripture", "");
	include("OT_Books.php");
	// $OT_array;							// from OT_Books.php
	include("NT_Books.php");
	// $NT_array;							// from NT_Books.php
	//include './include/conn.inc.php';
	//$db = get_my_db();
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Add Submit Confirmation Insertion Page</title>
</head>
<body style="background-color: #069; margin: 14pt; font-family: Arial, Helvetica, sans-serif; ">
<?php
	echo "<div style='background-color: white; padding: 20px; width: 1020px; margin-left: auto; margin-right: auto; border-radius: 15px; -moz-border-radius: 15px; -webkit-box-shadow: 15px; '>";
	echo '<div style="text-align: center; ">';
	echo "<img src='images/ScriptureEarth.jpg' />";
	echo '</div>';
	echo "</div></br />";
	
	echo "<div style='background-color: white; padding: 20px; width: 1020px; margin-left: auto; margin-right: auto; border-radius: 15px; -moz-border-radius: 15px; -webkit-box-shadow: 15px; '>";
//Change this???
	$ln_result = '';
	$ln_string = '';
	foreach($_SESSION['nav_ln_array'] as $code => $array){
		$ln_result .= "LN_".$array[1].", ";
		$ln_string .= "'$inputs[LN_".$array[1]."Bool]', ";
	}
	$query="INSERT INTO scripture_main (ISO, ROD_Code, Variant_Code, ".$ln_result."Def_LN, OT_PDF, NT_PDF, FCBH, OT_Audio, NT_Audio, links, other_titles, watch, buy, study, viewer, CellPhone, AddNo, AddTheBibleIn, AddTheScriptureIn, BibleIs, YouVersion, Bibles_org, PlaylistAudio, PlaylistVideo, SAB, eBible, SILlink, GRN) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', ".$ln_string."'$inputs[DefLangName]', '$inputs[OT_PDF]', '$inputs[NT_PDF]', 0, '$inputs[OT_Audio]','$inputs[NT_Audio]', '$inputs[links]', '$inputs[other_titles]', '$inputs[watch]', '$inputs[buy]', '$inputs[study]', '$inputs[viewer]', '$inputs[CellPhone]', '$inputs[AddNo]', '$inputs[AddTheBibleIn]', '$inputs[AddTheScriptureIn]', '$inputs[BibleIs]', '$inputs[YouVersion]', '$inputs[Biblesorg]', '$inputs[AudioPlaylist]', '$inputs[VideoPlaylist]', '$inputs[SAB]', '$inputs[eBible]', '$inputs[SILlink]', '$inputs[GRN]')";
	$result=$db->query($query);
	if (!$result) {
		die('Could not insert the data in "scripture_main": ' . $db->error);
	}

	// **********************************************
	// retrieves the last auto number (idx)
	// **********************************************
	$idx = $db->insert_id;							// retrieves the last auto number (idx)

// major languages - LN

	foreach ($_SESSION['nav_ln_array'] as $code => $array){
		if ($inputs['LN_'.$array[1].'Bool']) {
			$query="DELETE FROM LN_".$array[1]." WHERE ISO_ROD_index = $idx";
			$db->query($query);
			$temp = str_replace("'", "ꞌ", $inputs[$array[1].'_lang_name']);								// apostrophe (') to saltillo glyph (ꞌ - U+A78C)
			$query="INSERT INTO LN_".$array[1]." (ISO, ROD_Code, Variant_Code, ISO_ROD_index, LN_".$array[1].") VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, '$temp')";
			$result=$db->query($query);
			if (!$result) {
				echo 'Could not insert the data in "LN_'.$array[1].'": ' . $db->error;
			}
		}
	}
	
// ISO countries
	$i=1;
	$query="DELETE FROM ISO_countries WHERE ISO = '$inputs[iso]' AND ROD_Code = '$inputs[rod]' AND Variant_Code = '$inputs[var]' AND ISO_ROD_index IS NULL";
	$db->query($query);
	$query="INSERT INTO ISO_countries (ISO, ROD_Code, Variant_Code, ISO_ROD_index, ISO_countries) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, ?)";
	$stmt_countries=$db->prepare($query);
	while ($i <= $inputs['ISO_countries']) {
		$temp = 'ISO_Country-'.(string)$i;
		//$query="INSERT INTO ISO_countries (ISO, ROD_Code, Variant_Code, ISO_ROD_index, ISO_countries) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, '$inputs[$temp]')";
		//$result=$db->query($query);
		$stmt_countries->bind_param("s", $inputs[$temp]);											// bind parameters for markers								// 
		$result = $stmt_countries->execute();														// execute query
		if (!$result) {
			die('Could not insert the data in "ISO_countries": ' . $db->error);
		}
		$i++;
	}
	$stmt_countries->close();

// alt_lang_names
	$query="DELETE FROM alt_lang_names WHERE ISO = '$inputs[iso]' AND ROD_Code = '$inputs[rod]' AND Variant_Code = '$inputs[var]' AND ISO_ROD_index IS NULL";
	$db->query($query);
	$i = 1;
	$query="SELECT * FROM alt_lang_names WHERE ISO_ROD_index = ?";
	$stmt_small=$db->prepare($query);
	$query="INSERT INTO alt_lang_names (ISO, ROD_Code, Variant_Code, ISO_ROD_index, alt_lang_name) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, ?)";
	$stmt_large=$db->prepare($query);
	while (isset($inputs["txtAltNames-".(string)$i])) {
		//$query="SELECT * FROM alt_lang_names WHERE ISO_ROD_index = $idx";
		//$result=$db->query($query);
		$stmt_small->bind_param("i", $idx);												// bind parameters for markers
		$stmt_small->execute();																		// execute query
		$result = $stmt_small->get_result();														// instead of bind_result (used for only 1 record):
		//$row = mysql_num_rows($result);
		$bool_ISO = false;
		while ($r = $result->fetch_assoc()) {
			if ($r['alt_lang_name'] == $inputs["txtAltNames-".(string)$i]) {
				$bool_ISO = true;
				break;
			}
		}
		if (!$bool_ISO) {
			$temp = "txtAltNames-".(string)$i;
			//$query="INSERT INTO alt_lang_names (ISO, ROD_Code, Variant_Code, ISO_ROD_index, alt_lang_name) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, '$inputs[$temp]')";
			//$result=$db->query($query);
			$stmt_large->bind_param("s", $inputs[$temp]);											// bind parameters for markers
			$result=$stmt_large->execute();															// execute query
			if (!$result) {
				echo 'Could not insert the data "alt_lang_names": ' . $db->error;
			}
		}
		$i++;
	}
	$stmt_small->close();
	$stmt_large->close();

// isop
	if ($inputs["isop"] == 1) {
		if (!$db->query("INSERT INTO isop (ISO, ROD_Code, Variant_Code, ISO_ROD_index, isop) VALUES ('".$inputs['iso']."', '".$inputs['rod']."', '".$inputs['var']."', '".$idx."', '".$inputs["isopText"]."')")) {
			echo "INSERT Error description: " . $db -> error .'<br />';
		}
	}

// links: BibleIs
	if ($inputs['BibleIs']) {
		$i = 1;
		$query="INSERT INTO links (ISO, ROD_Code, Variant_Code, ISO_ROD_index, company, company_title, URL, BibleIs) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, 'Bible.is', ?, ?, ?)";
		$stmt_links=$db->prepare($query);
		while (isset($inputs["txtLinkBibleIsURL-".(string)$i])) {
			$temp3 = "txtLinkBibleIsURL-".(string)$i;
			$temp2 = "txtLinkBibleIsTitle-".(string)$i;
			$temp4 = $inputs["BibleIsDefault-".(string)$i] + $inputs["BibleIsText-".(string)$i] + $inputs["BibleIsAudio-".(string)$i] + $inputs["BibleIsVideo-".(string)$i];		// only one is set
			$stmt_links->bind_param("ssi", $inputs[$temp2], $inputs[$temp3], $temp4);						// bind parameters for markers
			$result=$stmt_links->execute();																	// execute query
			if (!$result) {
				echo 'Could not update the data "Bible.is links": ' . $db->error;
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
	*/
	if ($inputs['SAB']) {
		$i = 1;
		$query="INSERT INTO SAB_scriptoria (ISO, ROD_Code, Variant_Code, ISO_ROD_index, url, subfolder, description, pre_scriptoria, SAB_number) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, ?, ?, ?, '', ?)";
		//$query="INSERT INTO SAB_scriptoria (ISO, ROD_Code, Variant_Code, ISO_ROD_index, url, subfolder, description, pre_scriptoria, SAB_number) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, '', ?, ?, '', ?)";
		$stmt_SAB_scriptoria=$db->prepare($query);
		while (isset($inputs["txtSABsubfolderAdd-".(string)$i])) {
			$SABsubfolder = "txtSABsubfolderAdd-".(string)$i;
			$SABdescription = "txtSABdescriptionAdd-".(string)$i;
			$SABurl = "txtSABurlAdd-".(string)$i;
			$inputs[$SABsubfolder] = 'sab/'.$inputs[$SABsubfolder].'/';
			$stmt_SAB_scriptoria->bind_param("sssi", $inputs[$SABurl], $inputs[$SABsubfolder], $inputs[$SABdescription], $i);		// bind parameters for markers
			$resultSAB_scriptoria=$stmt_SAB_scriptoria->execute();											// execute query
			if (!$resultSAB_scriptoria) {
				echo 'Could not update the data "SAB_scriptoria" table: ' . $db->error;
			}
			
			if (trim($inputs[$SABurl]) == '') {
				if ((is_dir("./data/".$inputs['iso']."/".$inputs[$SABsubfolder]."js") === false)) {
					echo 'WARNING. The HTML files (SAB) are not on the SE server. You need to run Edit when html files are on the SE sever.<br />';
				}
				else {
					$SAB_Path = './data/'.$inputs['iso'].'/'.$inputs[$SABsubfolder];
					$SAB_array = glob($SAB_Path.'*.html');
					if (empty($SAB_array) === false) {															// there are html files here
						if (file_exists($SAB_Path.'sw.js') === false) {											// sw.js doesn't exist therefore the html files are old ( < 8/2020)
						}
						else {																					// sw.js does exist therefore the html files are new ( >= 8/2020) Scritporia s3 (AWS)
							$query="INSERT INTO SAB (ISO, ROD_Code, Variant_Code, ISO_ROD_index, Book_Chapter_HTML, SAB_Book, SAB_Chapter, SAB_Audio, SAB_number) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, ?, ?, ?, 0, ?)";
							$stmt_SAB=$db->prepare($query);
							foreach ($SAB_array as $SAB_record) {												// $SAB_array = glob($SAB_Path.'*.html'). e.g. "tuoC-02-GEN-001.html"
								$SAB_record = substr($SAB_record, strrpos($SAB_record, '/')+1);					// gets rids of directories. strrpos - returns the poistion of the last occurrence of the substring
								if (preg_match('/-([0-9]+)-[A-Z0-9][A-Z]{2}-/', $SAB_record, $match)) {
									//echo $SAB_record . '<br />';
								}
								else {
									continue;
								}
								$book_number = (int)$match[1];
								preg_match('/-([0-9]+)\.html/', $SAB_record, $match);
								$chapter = (int)$match[1];
								$stmt_SAB->bind_param("siii", $SAB_record, $book_number, $chapter, $i);				// bind parameters for markers
								$stmt_SAB->execute();
							}
							$stmt_SAB->close();
						}
					}
				}
			}
			$i++;
		}
		$stmt_SAB_scriptoria->close();
	}

// Scripture_and_or_Bible PDF

	if ($inputs['Bible_PDF']) {
		if ($inputs['whole_Bible'] != "") {
			$query="INSERT INTO Scripture_and_or_Bible SET ISO = '$inputs[iso]', ROD_Code = '$inputs[rod]', Variant_Code = '$inputs[var]', ISO_ROD_index = $idx, Item = 'B', Scripture_Bible_Filename = '$inputs[whole_Bible]'";
			$result=$db->query($query);
			if (!$result) {
				echo 'Could not update the data "Scripture_and_or_Bible": ' . $db->error;
			}
		}
	}

// complete Scripture PDF
	if ($inputs['complete_Scripture_PDF']) {
		if ($inputs['complete_Scripture'] != "") {
			$query="INSERT INTO Scripture_and_or_Bible SET ISO = '$inputs[iso]', ROD_Code = '$inputs[rod]', Variant_Code = '$inputs[var]', ISO_ROD_index = $idx, Item = 'S', Scripture_Bible_Filename = '$inputs[complete_Scripture]'";
			$result=$db->query($query);
			if (!$result) {
				echo 'Could not update the data "Scripture_and_or_Bible": ' . $db->error;
			}
		}
	}

// OT_PDF_Media
	if ($inputs['OT_PDF']) {
		if ($inputs['OT_name'] != "") {
			$query="INSERT INTO OT_PDF_Media (ISO, ROD_Code, Variant_Code, ISO_ROD_index, OT_PDF, OT_PDF_Filename) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, 'OT', '$inputs[OT_name]')";
			$result=$db->query($query);
			if (!$result) {
				echo 'Could not insert the data "OT_name": ' . $db->error;
			}
		}
		$query="INSERT INTO OT_PDF_Media (ISO, ROD_Code, Variant_Code, ISO_ROD_index, OT_PDF, OT_PDF_Filename) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, ?, ?)";
		$stmt_OT=$db->prepare($query);
		for ($i = 0; $i < 39; $i++) {
			if ($inputs["OT_PDF_Filename-".(string)$i] != "") {
				$temp1 = "OT_PDF_Book-".(string)$i;
				$temp2 = "OT_PDF_Filename-".(string)$i;
				//$query="INSERT INTO OT_PDF_Media (ISO, ROD_Code, Variant_Code, ISO_ROD_index, OT_PDF, OT_PDF_Filename) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, '$inputs[$temp1]', '$inputs[$temp2]')";
				//$result=$db->query($query);
				$stmt_OT->bind_param("ss", $inputs[$temp1], $inputs[$temp2]);						// bind parameters for markers
				$result=$stmt_OT->execute();														// execute query
				if (!$result) {
					echo 'Could not update the data "OT_PDF_Media": ' . $db->error;
				}
			}
		}
		$stmt_OT->close();
		if ($inputs["OT_PDF_Filename_appendix"] != "") {
			$temp1 = "OT_PDF_appendix";
			$temp2 = "OT_PDF_Filename_appendix";
			$query="INSERT INTO OT_PDF_Media (ISO, ROD_Code, Variant_Code, ISO_ROD_index, OT_PDF, OT_PDF_Filename) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, '$inputs[$temp1]', '$inputs[$temp2]')";
			$result=$db->query($query);
			if (!$result) {
				echo 'Could not insert the data "OT_PDF_Media": ' . $db->error;
			}
		}
		if ($inputs["OT_PDF_Filename_glossary"] != "") {
			$temp1 = "OT_PDF_glossary";
			$temp2 = "OT_PDF_Filename_glossary";
			$query="INSERT INTO OT_PDF_Media (ISO, ROD_Code, Variant_Code, ISO_ROD_index, OT_PDF, OT_PDF_Filename) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, '$inputs[$temp1]', '$inputs[$temp2]')";
			$result=$db->query($query);
			if (!$result) {
				echo 'Could not insert the data "OT_PDF_Media": ' . $db->error;
			}
		}
	}

// NT_PDF_Media
	if ($inputs['NT_PDF']) {
		if ($inputs['NT_name'] != "") {
			$query="INSERT INTO NT_PDF_Media (ISO, ROD_Code, Variant_Code, ISO_ROD_index, NT_PDF, NT_PDF_Filename) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, 'NT', '$inputs[NT_name]')";
			$result=$db->query($query);
			if (!$result) {
				echo 'Could not insert the data "NT_name": ' . $db->error;
			}
		}
		$query="INSERT INTO NT_PDF_Media (ISO, ROD_Code, Variant_Code, ISO_ROD_index, NT_PDF, NT_PDF_Filename) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, ?, ?)";
		$stmt_NT=$db->prepare($query);
		for ($i = 0; $i < 27; $i++) {
			if ($inputs["NT_PDF_Filename-".(string)$i] != "") {
				$temp1 = "NT_PDF_Book-".(string)$i;
				$temp2 = "NT_PDF_Filename-".(string)$i;
				//$query="INSERT INTO NT_PDF_Media (ISO, ROD_Code, Variant_Code, ISO_ROD_index, NT_PDF, NT_PDF_Filename) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, '$inputs[$temp1]', '$inputs[$temp2]')";
				//$result=$db->query($query);
				$stmt_NT->bind_param("ss", $inputs[$temp1], $inputs[$temp2]);						// bind parameters for markers
				$result=$stmt_NT->execute();														// execute query
				if (!$result) {
					echo 'Could not insert the data "NT_PDF_Media": ' . $db->error;
				}
			}
		}
		$stmt_NT->close();
		if ($inputs["NT_PDF_Filename_appendix"] != "") {
			$temp1 = "NT_PDF_appendix";
			$temp2 = "NT_PDF_Filename_appendix";
			$query="INSERT INTO NT_PDF_Media (ISO, ROD_Code, Variant_Code, ISO_ROD_index, NT_PDF, NT_PDF_Filename) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, '$inputs[$temp1]', '$inputs[$temp2]')";
			$result=$db->query($query);
			if (!$result) {
				echo 'Could not insert the data "NT_PDF_Media": ' . $db->error;
			}
		}
		if ($inputs["NT_PDF_Filename_glossary"] != "") {
			$temp1 = "NT_PDF_glossary";
			$temp2 = "NT_PDF_Filename_glossary";
			$query="INSERT INTO NT_PDF_Media (ISO, ROD_Code, Variant_Code, ISO_ROD_index, NT_PDF, NT_PDF_Filename) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, '$inputs[$temp1]', '$inputs[$temp2]')";
			$result=$db->query($query);
			if (!$result) {
				echo 'Could not insert the data "NT_PDF_Media": ' . $db->error;
			}
		}
	}

// OT_Audio_Media
	if ($inputs['OT_Audio']) {
		$query="INSERT INTO OT_Audio_Media (ISO, ROD_Code, Variant_Code, ISO_ROD_index, OT_Audio_Book, OT_Audio_Filename, OT_Audio_Chapter) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, ?, ?, ?)";
		$stmt_OT=$db->prepare($query);
		for ($i = 0; $i < 39; $i++) {
			$item2_from_array = $OT_array[1][$i];		// how many chapers in each book
			for ($z = 0; $z < $item2_from_array; $z++) {
				if ($inputs["OT_Audio_Filename-".(string)$i . "-" . (string)$z] != "") {
					$y = $z + 1;
					$temp1 = "OT_Audio_Book-".(string)$i;
					$temp2 = "OT_Audio_Filename-".(string)$i . "-" . (string)$z;
					$temp3 = "OT_Audio_Chapter-".(string)$i . "-" . (string)$z;
					//$query="INSERT INTO OT_Audio_Media (ISO, ROD_Code, Variant_Code, ISO_ROD_index, OT_Audio_Book, OT_Audio_Filename, OT_Audio_Chapter) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, '$inputs[$temp1]', '$inputs[$temp2]', '$inputs[$temp3]')";
					//$result=$db->query($query);
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
	if ($inputs['NT_Audio']) {
		$query="INSERT INTO NT_Audio_Media (ISO, ROD_Code, Variant_Code, ISO_ROD_index, NT_Audio_Book, NT_Audio_Filename, NT_Audio_Chapter) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, ?, ?, ?)";
		$stmt_NT=$db->prepare($query);
		for ($i = 0; $i < 27; $i++) {
			$item2_from_array = $NT_array[1][$i];		// how many chapers in each book
			for ($z = 0; $z < $item2_from_array; $z++) {
				if ($inputs["NT_Audio_Filename-".(string)$i . "-" . (string)$z] != "") {
					$y = $z + 1;
					$temp1 = "NT_Audio_Book-".(string)$i;
					$temp2 = "NT_Audio_Filename-".(string)$i . "-" . (string)$z;
					$temp3 = "NT_Audio_Chapter-".(string)$i . "-" . (string)$z;
					//$query="INSERT INTO NT_Audio_Media (ISO, ROD_Code, Variant_Code, ISO_ROD_index, NT_Audio_Book, NT_Audio_Filename, NT_Audio_Chapter) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, '$inputs[$temp1]', '$inputs[$temp2]', '$inputs[$temp3]')";
					//$result=$db->query($query);
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
	if ($inputs['YouVersion']) {
		$i = 1;
		$query="INSERT INTO links (ISO, ROD_Code, Variant_Code, ISO_ROD_index, company, company_title, URL, YouVersion) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, ?, ?, ?, 1)";
		$stmt_links=$db->prepare($query);
		while (isset($inputs["txtLinkYouVersionName-".(string)$i])) {
			$temp1 = "txtLinkYouVersionName-".(string)$i;
			$temp2 = "txtLinkYouVersionTitle-".(string)$i;
			$temp3 = "txtLinkYouVersionURL-".(string)$i;
			//$query="INSERT INTO links (ISO, ROD_Code, Variant_Code, ISO_ROD_index, company, company_title, URL, BibleIs, YouVersion, Bibles_org) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, '$inputs[$temp1]', '$inputs[$temp2]', '$inputs[$temp3]', 0, 1, 0)";
			//$result=$db->query($query);
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
	if ($inputs['Biblesorg']) {
		$i = 1;
		$query="INSERT INTO links (ISO, ROD_Code, Variant_Code, ISO_ROD_index, company, company_title, URL, Bibles_org) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, ?, ?, ?, 1)";
		$stmt_links=$db->prepare($query);
		while (isset($inputs["txtLinkBiblesorgName-".(string)$i])) {
			$temp1 = "txtLinkBiblesorgName-".(string)$i;
			$temp2 = "txtLinkBiblesorgTitle-".(string)$i;
			$temp3 = "txtLinkBiblesorgURL-".(string)$i;
			//$query="INSERT INTO links (ISO, ROD_Code, Variant_Code, ISO_ROD_index, company, company_title, URL, BibleIs, YouVersion, Bibles_org) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, '$inputs[$temp1]', '$inputs[$temp2]', '$inputs[$temp3]', 0, 0, 1)";
			//$result=$db->query($query);
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
	if ($inputs['GRN']) {
		$i = 1;
		$query="INSERT INTO links (ISO, ROD_Code, Variant_Code, ISO_ROD_index, company, company_title, URL, GRN) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, ?, ?, ?, 1)";
		$stmt_links=$db->prepare($query);
		while (isset($inputs["txtLinkGRNName-".(string)$i])) {
			$temp1 = "txtLinkGRNName-".(string)$i;
			$temp2 = "txtLinkGRNTitle-".(string)$i;
			$temp3 = "txtLinkGRNURL-".(string)$i;
			//$query="INSERT INTO links (ISO, ROD_Code, Variant_Code, ISO_ROD_index, company, company_title, URL, BibleIs, YouVersion, GRN) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, '$inputs[$temp1]', '$inputs[$temp2]', '$inputs[$temp3]', 0, 0, 1)";
			//$result=$db->query($query);
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
	if ($inputs['CellPhone']) {
		$i = 1;
		$query="INSERT INTO CellPhone (ISO, ROD_Code, Variant_Code, ISO_ROD_index, Cell_Phone_Title, Cell_Phone_File, optional) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, ?, ?, ?)";
		$stmt_cell=$db->prepare($query);
		while (isset($inputs["txtCellPhoneFile-".(string)$i])) {
			//$temp1 = "txtCellPhoneTitle-".(string)$i;
			if ($inputs["CPJava-".(string)$i] == 1) $temp1 = "GoBible (Java)";
			if ($inputs["CPAndroid-".(string)$i] == 1) $temp1 = "MySword (Android)";
			if ($inputs["CPiPhone-".(string)$i] == 1) $temp1 = "iPhone";
			//if ($inputs["CPWindows-".(string)$i] == 1) $temp1 = "Windows";
			//if ($inputs["CPBlackberry-".(string)$i] == 1) $temp1 = "Blackberry";
			//if ($inputs["CPStandard-".(string)$i] == 1) $temp1 = "Standard Cell Phone";
			if ($inputs["CPAndroidApp-".(string)$i] == 1) $temp1 = "Android App";
			if ($inputs["CPiOSAssetPackage-".(string)$i] == 1) $temp1 = "iOS Asset Package";
			$temp2 = "txtCellPhoneFile-".(string)$i;
			$temp3 = "txtCellPhoneOptional-".(string)$i;
			//$query="INSERT INTO CellPhone (ISO, ROD_Code, Variant_Code, ISO_ROD_index, Cell_Phone_Title, Cell_Phone_File) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, '$temp1', '$inputs[$temp2]')";
			//$result=$db->query($query);
			$stmt_cell->bind_param("sss", $temp1, $inputs[$temp2], $inputs[$temp3]);				// bind parameters for markers
			$result=$stmt_cell->execute();															// execute query
			if (!$result) {
				echo 'Could not insert the data "CellPhone": ' . $db->error;
			}
			$i++;
		}
		$stmt_cell->close();
	}

// watch
	if ($inputs['watch']) {
		$i = 1;
		$query="INSERT INTO watch (ISO, ROD_Code, Variant_Code, ISO_ROD_index, organization, watch_what, URL, JesusFilm, YouTube) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, ?, ?, ?, ?, ?)";
		$stmt_watch=$db->prepare($query);
		while (isset($inputs["txtWatchWebSource-$i"])) {
			$temp1 = "txtWatchWebSource-$i";
			$temp2 = "txtWatchResource-$i";
			$temp3 = "txtWatchURL-$i";
			$temp4 = "txtWatchJesusFilm-$i";
			$temp5 = "txtWatchYouTube-$i";
			//$query="INSERT INTO watch (ISO, ROD_Code, Variant_Code, ISO_ROD_index, organization, watch_what, URL, JesusFilm, YouTube) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, '$inputs[$temp1]', '$inputs[$temp2]', '$inputs[$temp3]', '$inputs[$temp4]', '$inputs[$temp5]')";
			//$result=$db->query($query);
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
	if ($inputs['study']) {
		$i = 1;
		$query="INSERT INTO study (ISO, ROD_Code, Variant_Code, ISO_ROD_index, ScriptureDescription, Testament, alphabet, ScriptureURL, statement, othersiteDescription, othersiteURL) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, ?, ?, ?, ?, ?, ?, ?)";
		$stmt_study=$db->prepare($query);
		while (isset($inputs["txtScriptureDescription-".(string)$i])) {
			$temp1 = "txtScriptureDescription-".(string)$i;
			$temp2 = "txtScriptureURL-".(string)$i;
			$temp3 = "txtStatement-".(string)$i;
			$temp4 = "txtOthersiteDescription-".(string)$i;
			$temp5 = "txtOthersiteURL-".(string)$i;
			if ($inputs["SNT-".(string)$i] == 1) $temp6 = "New Testament";
			if ($inputs["SOT-".(string)$i] == 1) $temp6 = "Old Testament";
			if ($inputs["SBible-".(string)$i] == 1) $temp6 = "Bible";
			if ($inputs["SStandAlphabet-".(string)$i] == 1) $temp7 = "Standard alphabet";
			if ($inputs["STradAlphabet-".(string)$i] == 1) $temp7 = "Traditional alphabet";
			if ($inputs["SNewAlphabet-".(string)$i] == 1) $temp7 = "New alphabet";
			//$query="INSERT INTO study (ISO, ROD_Code, Variant_Code, ISO_ROD_index, ScriptureDescription, ScriptureURL, statement, othersiteDescription, othersiteURL) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, '$inputs[$temp1]', '$inputs[$temp2]', '$inputs[$temp3]', '$inputs[$temp4]', '$inputs[$temp5]')";
			//$query="INSERT INTO study (ISO, ROD_Code, Variant_Code, ISO_ROD_index, ScriptureDescription, Testament, alphabet, ScriptureURL, statement, othersiteDescription, othersiteURL) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, '$inputs[$temp1]', '$temp6', '$temp7', '$inputs[$temp2]', '$inputs[$temp3]', '$inputs[$temp4]', '$inputs[$temp5]')";
			//$result=$db->query($query);
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
	if ($inputs['viewer']) {
		if (($inputs['viewerText'] != '') || ($inputs['rtl'] == 1)) {
			$query="INSERT INTO viewer (ISO, ROD_Code, Variant_Code, ISO_ROD_index, viewer_ROD_Variant, rtl) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, '$inputs[viewerText]', $inputs[rtl])";
			$result=$db->query($query);
			if (!$result) {
				echo 'Could not update the data "viewer_ROD_Variant": ' . $db->error;
			}
		}
	}

// other_titles
	if ($inputs['other_titles']) {
		$i = 1;
		$query="INSERT INTO other_titles (ISO, ROD_Code, Variant_Code, ISO_ROD_index, other, other_title, other_PDF, other_audio, download_video) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, ?, ?, ?, ?, ?)";
		$stmt_other=$db->prepare($query);
		while (isset($inputs["txtOther-".(string)$i])) {
			$temp1 = "txtOther-".(string)$i;
			$temp2 = "txtOtherTitle-".(string)$i;
			$temp3 = "txtOtherPDF-".(string)$i;
			$temp4 = "txtOtherAudio-".(string)$i;
			$temp5 = "txtDownload_video-".(string)$i;
			//$query="INSERT INTO other_titles (ISO, ROD_Code, Variant_Code, ISO_ROD_index, other, other_title, other_PDF, other_audio) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, '$inputs[$temp1]', '$inputs[$temp2]', '$inputs[$temp3]', '$inputs[$temp4]')";
			//$result=$db->query($query);
			$stmt_other->bind_param("sssss", $inputs[$temp1], $inputs[$temp2], $inputs[$temp3], $inputs[$temp4], $inputs[$temp5]);		// bind parameters for markers
			$result=$stmt_other->execute();													// execute query
			if (!$result) {
				echo 'Could not insert the data "other-titles": ' . $db->error;
			}
			$i++;
		}
		$stmt_other->close();
	}

// buy
	if ($inputs['buy']) {
		$i = 1;
		$query="INSERT INTO buy (ISO, ROD_Code, Variant_Code, ISO_ROD_index, organization, buy_what, URL) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, ?, ?, ?)";
		$stmt_buy=$db->prepare($query);
		while (isset($inputs["txtBuyWebSource-".(string)$i])) {
			$temp1 = "txtBuyWebSource-".(string)$i;
			$temp2 = "txtBuyResource-".(string)$i;
			$temp3 = "txtBuyURL-".(string)$i;
			//$query="INSERT INTO buy (ISO, ROD_Code, Variant_Code, ISO_ROD_index, organization, buy_what, URL) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, '$inputs[$temp1]', '$inputs[$temp2]', '$inputs[$temp3]')";
			//$result=$db->query($query);
			$stmt_buy->bind_param("sss", $inputs[$temp1], $inputs[$temp2], $inputs[$temp3]);		// bind parameters for markers
			$result=$stmt_buy->execute();													// execute query
			if (!$result) {
				echo 'Could not insert the data "buy": ' . $db->error;
			}
			$i++;
		}
		$stmt_buy->close();
	}

// links: buy, map, and GooglePlay
	if ($inputs['links']) {
		$i = 1;
		$query="INSERT INTO links (ISO, ROD_Code, Variant_Code, ISO_ROD_index, company, company_title, URL, buy, map, GooglePlay) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, ?, ?, ?, ?, ?, ?)";
		$stmt_links=$db->prepare($query);
		while (isset($inputs["txtLinkCompany-".(string)$i])) {
			$temp1 = "txtLinkCompany-".(string)$i;
			$temp2 = "txtLinkCompanyTitle-".(string)$i;
			$temp3 = "txtLinkURL-".(string)$i;
			$temp4 = "linksBuy-$i";
			$temp5 = "linksMap-$i";
			$temp6 = "linksGooglePlay-$i";
			//$query="INSERT INTO links (ISO, ROD_Code, Variant_Code, ISO_ROD_index, company, company_title, URL, buy, map, GooglePlay, GRN) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, '$inputs[$temp1]', '$inputs[$temp2]', '$inputs[$temp3]', '$inputs[$temp4]', '$inputs[$temp5]', '$inputs[$temp6]')";
			//$result=$db->query($query);
			$stmt_links->bind_param("sssiii", $inputs[$temp1], $inputs[$temp2], $inputs[$temp3], $inputs[$temp4], $inputs[$temp5], $inputs[$temp6]);		// bind parameters for markers
			$result=$stmt_links->execute();														// execute query
			if (!$result) {
				echo 'Could not insert the data "links": ' . $db->error;
			}
			$i++;
		}
		$stmt_links->close();
	}
	
	/* removed 4/27/15 because FCBH no longer supports it.
	// A checked on FCBH only goes through this code. When unchecked the scripture_main takes it over.
	if ($inputs['FCBH']) {
		$query="SELECT * FROM FCBHLanguageList WHERE ISO = '$inputs[iso]' AND ROD_Code = '$inputs[rod]' AND DAM_ID IS NOT NULL";		// AND (Variant_Code = '$inputs[var]' OR '$inputs[var]' IS NULL OR '$inputs[var]' = '')
		$result=$db->query($query);
		if (!$result or (mysql_num_rows($result) == 0)) {
			 echo '<div style="font-size: 14pt; font-weight: bold; text-align: center; ">';
			 echo 'There is an error writing to the FCBH table where DAM_ID is not found.<br />';
			 echo 'Send an email message to <a href=\'mailto:Scott_Starker&#64;sil.org?subject=Add:%20FCBH%20error:%20'.$inputs[iso].',%20'.$inputs[rod].',%20'.$inputs[var].'\'>Scott Starker</a> ';
			 echo 'for him to fix the problem.';
			 echo '</div>';
			 echo "<h1 style='text-align: center; '>Except for the FCBH error,</h1>";
		}
		else {
			$DAM_ID=mysql_result($result,0,"DAM_ID");
			$query="UPDATE FCBHLanguageList SET ISO_ROD_index = $idx WHERE ISO = '$inputs[iso]' AND ROD_Code = '$inputs[rod]' AND DAM_ID = '$DAM_ID'";		// AND (Variant_Code = '$inputs[var]' OR '$inputs[var]' IS NULL OR '$inputs[var]' = '')
			echo $result."<br />";
			$result=$db->query($query);
			if (!$result) {
				die('Could not update the "idx" on "FCBHLanguageList": ' . $db->error);
			}
		}
	}
	*/

// PlaylistAudio
	if ($inputs['AudioPlaylist']) {
		$i = 1;
		$query="INSERT INTO PlaylistAudio (ISO, ROD_Code, Variant_Code, ISO_ROD_index, PlaylistAudioTitle, PlaylistAudioFilename) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, ?, ?)";
		$stmt_Audio=$db->prepare($query);
		while (isset($inputs["txtPlaylistAudioTitle-".(string)$i])) {
			$temp1 = "txtPlaylistAudioTitle-".(string)$i;
			$temp2 = "txtPlaylistAudioFilename-".(string)$i;
			//$query="INSERT INTO PlaylistAudio (ISO, ROD_Code, Variant_Code, ISO_ROD_index, PlaylistAudioTitle, PlaylistAudioFilename) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, '$inputs[$temp1]', '$inputs[$temp2]')";
			//$result=$db->query($query);
			$stmt_Audio->bind_param("ss", $inputs[$temp1], $inputs[$temp2]);				// bind parameters for markers
			$result=$stmt_Audio->execute();													// execute query
			if (!$result) {
				echo 'Could not insert the data "AudioPlaylist": ' . $db->error;
			}
			$i++;
		}
		$stmt_Audio->close();
	}

// PlaylistVideo
	if ($inputs['VideoPlaylist']) {
		$i = 1;
		$query="INSERT INTO PlaylistVideo (ISO, ROD_Code, Variant_Code, ISO_ROD_index, PlaylistVideoTitle, PlaylistVideoFilename, PlaylistVideoDownload) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, ?, ?, ?)";
		$stmt_Video=$db->prepare($query);
		while (isset($inputs["txtPlaylistVideoTitle-".(string)$i])) {
			$temp1 = "txtPlaylistVideoTitle-".(string)$i;
			$temp2 = "txtPlaylistVideoFilename-".(string)$i;
			$temp3 = "PlaylistVideoDownload-".(string)$i;
			//$query="INSERT INTO PlaylistVideo (ISO, ROD_Code, Variant_Code, ISO_ROD_index, PlaylistVideoTitle, PlaylistVideoFilename) VALUES ('$inputs[iso]', '$inputs[rod]', '$inputs[var]', $idx, '$inputs[$temp1]', '$inputs[$temp2]')";
			//$result=$db->query($query);
			$stmt_Video->bind_param("ssi", $inputs[$temp1], $inputs[$temp2], $inputs[$temp3]);	// bind parameters for markers
			$result=$stmt_Video->execute();														// execute query
			if (!$result) {
				echo 'Could not insert the data "Video Playlist": ' . $db->error;
			}
			$i++;
		}
		$stmt_Video->close();
	}

// eBible
	if ($inputs['eBible']) {
		$query="UPDATE eBible_list SET ISO_ROD_index = $idx WHERE languageId = '$inputs[iso]' AND rodCode = '$inputs[rod]'";
		$result=$db->query($query);
		if (!$result) {
			echo 'Could not update the data eBible_list table. '. $iso . ' might not be in eBible_list table. ' . $db->error;
		}
	}
	
	echo "<h2 style='text-align: center; '>You have successfully completed<br />";
	/*
	 * It is safe to echo $_POST['txtName'] here because
	 * it has (supposedly) passed validation, but it is
	 * better to use the sanitized $inputs array.
	 */
	echo "'".$inputs['iso']."' '".$inputs['rod']."' '".$inputs['var']."'!";
	echo "</h2>";
	echo "<form>";
	echo "<input type='reset' value='Go back to Add script' OnClick='parent.location=\"Scripture_Add.php\"' />";
	echo "</form>";	
	echo "</div>";
	echo "<br />";
	echo "<div style='text-align: center; background-color: #333333; margin: 0px auto 0px auto; padding: 20px; width: 1020px; border-radius: 15px; -moz-border-radius: 15px; -webkit-box-shadow: 15px; '>";
	//echo "<img src='images/top_wbtc_logo.gif' />";
	//echo '<br /><br />';
	echo "<div class='nav' style='font-weight: normal; color: white; font-size: 10pt; '><sup>©</sup>2009 - " . date('Y') . " <span style='color: #99FF99; '>ScriptureEarth.org</span></div>";
	echo "</div>";

	// write 404.shtml
	if ($inputs["isop"] == 1) {
		$file_404 = file_get_contents('404.shtml');															// read in string 404.shtml
		$file_array = explode("\n", $file_404);																// array on '\n'
		// insert
		$arrlength = count($file_array);
		for($x=0; $x<$arrlength; $x++) {
			if (strpos($file_array[$x], '(query)')) {													// switch (query) only occurs once in 404.shtml
				$temp1 = "		case '".$inputs["isopText"]."':";
				$temp2 = '			window.location.replace("https://www.ScriptureEarth.org/"+navLang+"?sortby=lang&idx='.$idx.'");		// '.$inputs["iso"].' '.$inputs["rod"].' '.$idx.' '.$inputs["isopText"];
				$temp3 = '			break;';
				array_splice($file_array, $x+1, 0, [$temp1, $temp2, $temp3]);
				break;
			}
		}
		$file_404 = implode("\n", $file_array);
		file_put_contents('404.shtml', $file_404);
	}

	unset($inputs);    			// This deletes the whole array

	$query="SELECT ISO, ROD_Code, Variant_Code, ISO_ROD_index FROM scripture_main ORDER BY ISO, ROD_Code, Variant_Code";		// re-creeate .htaccess (a config file for Apache web server)
	$result=$db->query($query) or die ('Query failed: ' . $db->error . '</body></html>');
	if (!$result) {
		die ("&ldquo;$ISO&rdquo; " . 'is not found.</body></html>');
	}
	$transfer='';
	$filename='.htaccess';
	$handle = fopen($filename,"w");
	fwrite($handle, '# php -- BEGIN cPanel-generated handler, do not edit' . PHP_EOL);
	fwrite($handle, '# Set the “ea-php72” package as the default “PHP” programming language.' . PHP_EOL);
	fwrite($handle, '<IfModule mime_module>' . PHP_EOL);
	fwrite($handle, 'AddType application/x-httpd-ea-php72 .php .php7 .phtml' . PHP_EOL);
	fwrite($handle, '</IfModule>' . PHP_EOL);
	fwrite($handle, '# php -- END cPanel-generated handler, do not edit' . PHP_EOL);
	fwrite($handle, '# php -- BEGIN http to https' . PHP_EOL);
	fwrite($handle, '<IfModule mod_rewrite.c>' . PHP_EOL);
	fwrite($handle, 'RewriteEngine On' . PHP_EOL);
	fwrite($handle, 'RewriteCond %{HTTP_HOST} ^(www\.)?scriptureearth\.org$' . PHP_EOL);
	fwrite($handle, 'RewriteCond %{SERVER_PORT} 80' . PHP_EOL);
	fwrite($handle, 'RewriteCond %{REQUEST_URI} !^/\.well-known/cpanel-dcv/[0-9a-zA-Z_-]+$' . PHP_EOL);
	fwrite($handle, 'RewriteCond %{REQUEST_URI} !^/\.well-known/pki-validation/(?:\ Ballot169)?' . PHP_EOL);
	fwrite($handle, 'RewriteCond %{REQUEST_URI} !^/\.well-known/pki-validation/[A-F0-9]{32}\.txt(?:\ Comodo\ DCV)?$' . PHP_EOL);
	fwrite($handle, 'RewriteRule ^(.*)$ https:\/\/scriptureearth\.org\/$1 [R=301,L]' . PHP_EOL);
	fwrite($handle, '</IfModule>' . PHP_EOL);
	fwrite($handle, '# php -- END http to https' . PHP_EOL);
	fwrite($handle, '# Do NOT make any changes to this file! The changes are all made by SubmitAddConfirm.php.' . PHP_EOL);
	fwrite($handle, '# The content of .htaccess was created by Scott Starker on 4/2016 and 9/2021.' . PHP_EOL);
	while ($r = $result->fetch_array()) {
		$iso=$r['ISO'];
		$rod=$r['ROD_Code'];
		$var=$r['Variant_Code'];
		if (trim($var) != '' && $var != NULL) {
			$transfer=$iso.'-'.$rod.'-'.$var;
		}
		elseif ($rod != '00000') {
			$transfer=$iso.'-'.$rod;
		}
		else {
			$transfer=$iso;
		}
		$tempStr = "Redirect 301 /$transfer /index.php?sortby=lang&iso=$iso";
		if ($rod != '00000') $tempStr .= "&rod=$rod";
		if ($var != '') $tempStr .= "&var=$var";
		fwrite($handle, $tempStr . PHP_EOL);
	}
	fclose($handle);
?>
		
<script type="text/javascript"> 
<!--
/*
	Has to have a "var" before each "window.open" (because the next window would open up before the "w.close() would get executed)
	and must have "setTimeout" (because the script needs 1 second to run).
*/
	var url = "metadata/English/EnglishLanguageSetup.php?noDisplay=1";
	var u = window.open(url, "_blank", "titlebar=no, toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=100, height=100");
	setTimeout(function() { u.close(); }, 1000);
	//w.close();
	url = "metadata/Espanol/EspanolLanguageSetup.php?noDisplay=1";
	var w = window.open(url, "_blank", "titlebar=no, toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=100, height=100");
	setTimeout(function() { w.close(); }, 1000);
	//w.close();
	url = "metadata/Portuguesa/PortuguesaLanguageSetup.php?noDisplay=1";
	var z = window.open(url, "_blank", "titlebar=no, toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=100, height=100");
	setTimeout(function() { z.close(); }, 1000);
	//w.close();
	url = "metadata/Francais/FrancaisLanguageSetup.php?noDisplay=1";
	var x = window.open(url, "_blank", "titlebar=no, toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=100, height=100");
	setTimeout(function() { x.close(); }, 1000);
	//w.close();
	url = "metadata/Nederlands/NederlandsLanguageSetup.php?noDisplay=1";
	var y = window.open(url, "_blank", "titlebar=no, toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=100, height=100");
	setTimeout(function() { y.close(); }, 1000);
	//w.close();
	url = "metadata/Deutsch/DeutschLanguageSetup.php?noDisplay=1";
	var v = window.open(url, "_blank", "titlebar=no, toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=100, height=100");
	setTimeout(function() { v.close(); }, 1000);
	//w.close();
	//url = "metadata/LanguageSetup.php?noDisplay=1";
	//var z = window.open(url, "_blank", "titlebar=no, toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=100, height=100");
	//setTimeout(function() { z.close(); }, 1000);
	//w.close();
//	return false; //cancels href action 
-->
</script>
</body>
</html>