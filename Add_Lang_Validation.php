<?php
	// This script cannot be accessed directly.
	if ( ! (defined('RIGHT_ON') && RIGHT_ON === true)) {
		@include_once '403.php';
		exit;
	}

	$iso = '';
 
	if (isset($_POST["iso"])) {
		$iso = $_POST["iso"];
	}
	else {
		die('Die!</body></html>');
	}

	if (strlen($iso) == 3) {
		function check_input($value) {
			return str_replace("'", "ꞌ", trim($value));	// for input tag (single quote "'" to glottal stop "ꞌ")
		}

		include("OT_Books.php");
		include("NT_Books.php");

		// The number of failed validations
		$count_failed = 0;

		if (isset($_POST["rod"])) {
			$rod = $_POST["rod"];
		}
		else {
			$rod = '00000';
		}
		if (isset($_POST["var"])) {
			$var = $_POST["var"];							// Variant_Code to the language name
		}
		else {
			$var = '';
		}
		
		// connect to the database 
		include './include/conn.inc.php';
		$db = get_my_db();

		$query="SELECT ISO FROM scripture_main WHERE ISO = '$iso' AND ROD_Code = '$rod' AND Variant_Code = '$var'";	// see if there is a scripture_main table record
		$result=$db->query($query);
		if (!$result) {
			// Increments the number of failed validations
			$count_failed++;
			// Adds a message to the message queue.
			$messages[] = "The '$iso', '$rod' and '$var' you entered exists. You may want to try the 'Edit' script if you want to do this.";
		}
		else {
			// If other validations fail, this will be used to repopulate the form
			$inputs['iso'] = $iso;
			$inputs['rod'] = $rod;
			$inputs['var'] = $var;							// Variant_Code to the language name
			
// Countries
			$inputs['Eng_country-1'] = check_input($_POST["Eng_country-1"]);
			$inputs['ISO_countries'] = 0;
		
			$i = 1;
			if ($inputs['Eng_country-1'] == '') {
				$count_failed++;
				$messages[] = "The English name of the Country in which the Language is indigenous is blank.";
			}
			else {
				while (isset($_POST["Eng_country-".(string)$i])) {
					$inputs["Eng_country-".(string)$i] = check_input($_POST["Eng_country-".(string)$i]);
					$i++;
				}
			}

// Specific Language Names for the navigational Language Names
//		"No Language Names are found."
			$no_ln_missing = 0;
			foreach ($_SESSION['nav_ln_array'] as $code => $array){									// $array[1] = English, Chinese, etc.
				$inputs[$array[1].'_lang_name'] = check_input($_POST[$array[1]."_lang_name"]);
				if ($inputs[$array[1].'_lang_name'] != '') {
					$inputs['LN_'.$array[1].'Bool'] = 1;
				}
				else {
					$inputs['LN_'.$array[1].'Bool'] = 0;
					$no_ln_missing++;
				}
			}
			if ($no_ln_missing == count($_SESSION['nav_ln_array'])) {
				$count_failed++;
				$messages[] = "No Language Names are found.";
			}

//		"The Country isn't found: ".$temp
			$z = 1;
			if ($inputs['Eng_country-1'] != '') {													// see countries section
				$query="SELECT ISO_Country FROM countries WHERE English=?";
				$stmt=$db->prepare($query);															// create a prepared statement
				while ($z < $i) {																	// $i is up under the countries section
					$temp=$inputs["Eng_country-".(string)$z];
					$stmt->bind_param("s", $temp);													// bind parameters for markers
					$stmt->execute();																// execute query
					$result = $stmt->get_result();													// instead of bind_result (used for only 1 record):
					$num=$result->num_rows;
					if ($result && $num > 0) {
						$r = $result->fetch_assoc();
						$inputs['ISO_Country-'.(string)$z] = $r['ISO_Country'];
					}
					else {
						$count_failed++;
						$messages[] = "The Country isn't found: ".$temp;
					}
					$z++;
				}
				$stmt->close();
				$inputs['ISO_countries'] = --$z;
			}

//		"The ENGLISH Language Name is empty."
			if (!$inputs['LN_'.$_SESSION['nav_ln_array']['en'][1].'Bool']) {
				$count_failed++;
				$messages[] = "The ENGLISH Language Name is empty.";
			}
			
//		"The ".$array[1]." default language is not associated with the ".$array[1]." Metadata language name."
			$DefaultLang = $_POST["DefaultLang"];
			foreach ($_SESSION['nav_ln_array'] as $code => $array){
				if ($DefaultLang == $array[1]."Lang") {
					$inputs['DefLangName'] = $array[3];
					if (!$inputs['LN_'.$array[1].'Bool']) {
						$count_failed++;
						$messages[] = "The ".$array[1]." default language is not associated with the ".$array[1]." Metadata language name.";
					}
				}
			}

// alt name
  			$i = 1;
			while (isset($_POST["txtAltNames-".(string)$i])) {
				if (!empty($_POST["txtAltNames-".(string)$i])) {
					$inputs["txtAltNames-".(string)$i] = $_POST["txtAltNames-".(string)$i];
				}
				$i++;
			}

// which title
			$inputs["AddNo"] = 0;
			$inputs["AddTheBibleIn"] = 0;
			$inputs["AddTheScriptureIn"] = 0;
			if (isset($_POST['GroupAdd'])) {															// radio button = checked
				if ($_POST['GroupAdd'] == "AddNo") $inputs["AddNo"] = 1;
				if ($_POST['GroupAdd'] == "AddTheBibleIn") $inputs["AddTheBibleIn"] = 1;
				if ($_POST['GroupAdd'] == "AddTheScriptureIn") $inputs["AddTheScriptureIn"] = 1;
			}

// isop
			$inputs["isop"] = 0;
			$inputs["isopText"] = '';
			if (isset($_POST['isopText']) && trim($_POST['isopText']) != '') {
				$inputs["isopText"] = trim($_POST["isopText"]);
				$inputs["isop"] = 1;
				if (strlen($inputs["isopText"]) < 4) {
					$count_failed++;
					$messages[] = "Error. isoP is/are under 4 character(s).";
				}
				$beg_isop = preg_replace('/^([a-z]{3}).*/', '$1', $inputs["isopText"]);
				if ($beg_isop != $inputs["iso"]) {
					$count_failed++;
					$messages[] = "'$beg_isop' is not the same as '".$inputs["iso"]."'.";
				}
			}

// Bible.is
			$i = 1;
			$BibleIsIndex = 1;
			$inputs["BibleIs"] = 0;
			while (isset($_POST["txtLinkBibleIsURL-".(string)$i])) {
				if (check_input($_POST["txtLinkBibleIsURL-".(string)$i]) != "") $inputs["BibleIs"] = 1;
				if (empty($_POST["txtLinkBibleIsURL-".(string)$i])) {
				}
				$inputs["txtLinkBibleIsTitle-".(string)$i] = check_input($_POST["txtLinkBibleIsTitle-".(string)$i]);
				$inputs["txtLinkBibleIsURL-".(string)$i] = check_input($_POST["txtLinkBibleIsURL-".(string)$i]);
				$inputs["txtLinkBibleIs-".(string)$i] = check_input($_POST["txtLinkBibleIs-".(string)$i]);
				if ($_POST["txtLinkBibleIs-".(string)$i] == 'BibleIsDefault-'.$i) $inputs["BibleIsDefault-$BibleIsIndex"] = 1; else $inputs["BibleIsDefault-$BibleIsIndex"] = 0;
				if ($_POST["txtLinkBibleIs-".(string)$i] == 'BibleIsText-'.$i) $inputs["BibleIsText-$BibleIsIndex"] = 2; else $inputs["BibleIsText-$BibleIsIndex"] = 0;
				if ($_POST["txtLinkBibleIs-".(string)$i] == 'BibleIsAudio-'.$i) $inputs["BibleIsAudio-$BibleIsIndex"] = 5; else $inputs["BibleIsAudio-$BibleIsIndex"] = 0;
				if ($_POST["txtLinkBibleIs-".(string)$i] == 'BibleIsVideo-'.$i) $inputs["BibleIsVideo-$BibleIsIndex"] = 7; else $inputs["BibleIsVideo-$BibleIsIndex"] = 0;
				if ($_POST["txtLinkBibleIs-".(string)$i] == 'BibleIsTextAudio-'.$i) $inputs["BibleIsTextAudio-$BibleIsIndex"] = 3; else $inputs["BibleIsTextAudio-$BibleIsIndex"] = 0;
				if ($_POST["txtLinkBibleIs-".(string)$i] == 'BibleIsTextVideo-'.$i) $inputs["BibleIsTextVideo-$BibleIsIndex"] = 8; else $inputs["BibleIsTextVideo-$BibleIsIndex"] = 0;
				if ($_POST["txtLinkBibleIs-".(string)$i] == 'BibleIsAudioVideo-'.$i) $inputs["BibleIsAudioVideo-$BibleIsIndex"] = 6; else $inputs["BibleIsAudioVideo-$BibleIsIndex"] = 0;
				if ($_POST["txtLinkBibleIs-".(string)$i] == 'BibleIsTextAudioVideo-'.$i) $inputs["BibleIsTextAudioVideo-$BibleIsIndex"] = 4; else $inputs["BibleIsTextAudioVideo-$BibleIsIndex"] = 0;
				$BibleIsIndex++;
				$i++;
			}

// Bible.is Gospel Film
			$i = 1;
			$BibleIsGospelFilmIndex = 1;
			$inputs["BibleIsGospelFilm"] = 0;
			while (isset($_POST["txtLinkBibleIsGospelFilmURL-".(string)$i])) {
				if (check_input($_POST["txtLinkBibleIsGospelFilmURL-".(string)$i]) != "") $inputs["BibleIsGospelFilm"] = 1;
				if (empty($_POST["txtLinkBibleIsGospelFilmURL-".(string)$i])) {
				}
				$inputs["txtLinkBibleIsGospelFilmURL-".(string)$i] = check_input($_POST["txtLinkBibleIsGospelFilmURL-".(string)$i]);
				$inputs["txtLinkBibleIsGospel-".(string)$i] = check_input($_POST["txtLinkBibleIsGospel-".(string)$i]);
				$BibleIsGospelFilmIndex++;
				$i++;
			}

// SAB
			$inputs["SAB"] = 0;
			$i = 1;
			while (isset($_POST["txtSABsubfolderAdd-".(string)$i])) {
				if (check_input($_POST["txtSABsubfolderAdd-1"] != "") || check_input($_POST["txtSABurlAdd-1"] != "")) $inputs["SAB"] = 1;
				$inputs["txtSABsubfolderAdd-".(string)$i] = check_input($_POST["txtSABsubfolderAdd-".(string)$i]);
				$inputs["txtSABdescriptionAdd-".(string)$i] = check_input($_POST["txtSABdescriptionAdd-".(string)$i]);
				$inputs["txtSABurlAdd-".(string)$i] = check_input($_POST["txtSABurlAdd-".(string)$i]);
				$i++;
			}

// whole Bible PDF
			$inputs["Bible_PDF"] = 0;
			if (check_input($_POST["whole_Bible"]) != '') {
				$inputs['whole_Bible'] = check_input($_POST["whole_Bible"]);
				$inputs["Bible_PDF"] = 1;
			}
			else {
				$inputs['whole_Bible'] = "";
			}

// complete Scripture PDF
			$inputs["complete_Scripture_PDF"] = 0;
			if (check_input($_POST["complete_Scripture"]) != '') {
				$inputs['complete_Scripture'] = check_input($_POST["complete_Scripture"]);
				$inputs['ScriptureDescription'] = check_input($_POST["ScriptureDescription"]);
				$inputs["complete_Scripture_PDF"] = 1;
			}
			else {
				$inputs['complete_Scripture'] = '';
				$inputs['ScriptureDescription'] = '';
			}

// OT PDF
			$inputs["OT_PDF"] = 0;
			if (check_input($_POST["OT_name"]) != '') {
				$inputs['OT_name'] = check_input($_POST["OT_name"]);
				$inputs["OT_PDF"] = 1;
				for ($i = 0; $i < 39; $i++) {
					$inputs["OT_PDF_Filename-".(string)$i] = '';
				}
				$inputs["OT_PDF_Filename_appendix"] = '';
				$inputs["OT_PDF_Filename_glossary"] = '';
			}
			else {
				$inputs['OT_name'] = '';
			}
			for ($i = 0; $i < 39; $i++) {
				$inputs["OT_PDF_Book-".$i] = $i;
				if (check_input($_POST["OT_PDF_Filename-".(string)$i]) != "") $inputs["OT_PDF"] = 1;
				$item_from_array = $OT_array[2][$i];		// English book name
				if (isset($_POST["OT_PDF_Book-".(string)$i]) && check_input($_POST["OT_PDF_Filename-".(string)$i]) == "") {
					$count_failed++;
					$messages[] = "OT PDF filename for " . $item_from_array . " is blank.";
				}
				if (!isset($_POST["OT_PDF_Book-".(string)$i]) && check_input($_POST["OT_PDF_Filename-".(string)$i]) != "") {
					$count_failed++;
					$messages[] = "Check box OT PDF for " .$item_from_array . " is blank.";
				}
				$inputs["OT_PDF_Filename-".(string)$i] = check_input($_POST["OT_PDF_Filename-".(string)$i]);
			}
			$inputs["OT_PDF_appendix"] = 100;
			if (check_input($_POST["OT_PDF_Filename_appendix"]) != "") $inputs["OT_PDF"] = 1;
			if (isset($_POST["OT_PDF_appendix"]) && check_input($_POST["OT_PDF_Filename_appendix"]) == "") {
				$count_failed++;
				$messages[] = "OT PDF filename for 'OT Appendix' is blank.";
			}
			if (!isset($_POST["OT_PDF_appendix"]) && check_input($_POST["OT_PDF_Filename_appendix"]) != "") {
				$count_failed++;
				$messages[] = "Check box OT PDF for 'OT Appendix' is blank.";
			}
			$inputs["OT_PDF_Filename_appendix"] = check_input($_POST["OT_PDF_Filename_appendix"]);
			$inputs["OT_PDF_glossary"] = 101;
			if (check_input($_POST["OT_PDF_Filename_glossary"]) != "") $inputs["OT_PDF"] = 1;
			if (isset($_POST["OT_PDF_glossary"]) && check_input($_POST["OT_PDF_Filename_glossary"]) == "") {
				$count_failed++;
				$messages[] = "OT PDF filename for 'OT Glossary' is blank.";
			}
			if (!isset($_POST["OT_PDF_glossary"]) && check_input($_POST["OT_PDF_Filename_glossary"]) != "") {
				$count_failed++;
				$messages[] = "Check box OT PDF for 'OT Glossary' is blank.";
			}
			$inputs["OT_PDF_Filename_glossary"] = check_input($_POST["OT_PDF_Filename_glossary"]);

// NT PDF
			$inputs["NT_PDF"] = 0;
			if (check_input($_POST["NT_name"]) != "") {
				$inputs['NT_name'] = check_input($_POST["NT_name"]);
				$inputs["NT_PDF"] = 1;
				for ($i = 0; $i < 27; $i++) {
					$inputs["NT_PDF_Filename-".(string)$i] = "";
				}
				$inputs["NT_PDF_Filename_appendix"] = "";
				$inputs["NT_PDF_Filename_glossary"] = "";
			}
			else {
				$inputs['NT_name'] = "";
			}
				for ($i = 0; $i < 27; $i++) {
					$inputs["NT_PDF_Book-".$i] = $i;
					if (check_input($_POST["NT_PDF_Filename-".(string)$i]) != "") $inputs["NT_PDF"] = 1;
					$item_from_array = $NT_array[2][$i];		// English book name
					if (isset($_POST["NT_PDF_Book-".(string)$i]) && check_input($_POST["NT_PDF_Filename-".(string)$i]) == "") {
						$count_failed++;
						$messages[] = "PDF filename for " . $item_from_array . " is blank.";
					}
					if (!isset($_POST["NT_PDF_Book-".(string)$i]) && check_input($_POST["NT_PDF_Filename-".(string)$i]) != "") {
						$count_failed++;
						$messages[] = "Check box PDF for " .$item_from_array . " is blank.";
					}
					$inputs["NT_PDF_Filename-".(string)$i] = check_input($_POST["NT_PDF_Filename-".(string)$i]);
				}
			$inputs["NT_PDF_appendix"] = 200;
			if (check_input($_POST["NT_PDF_Filename_appendix"]) != "") $inputs["NT_PDF"] = 1;
			if (isset($_POST["NT_PDF_appendix"]) && check_input($_POST["NT_PDF_Filename_appendix"]) == "") {
				$count_failed++;
				$messages[] = "NT PDF filename for 'NT Appendix' is blank.";
			}
			if (!isset($_POST["NT_PDF_appendix"]) && check_input($_POST["NT_PDF_Filename_appendix"]) != "") {
				$count_failed++;
				$messages[] = "Check box NT PDF for 'NT Appendix' is blank.";
			}
			$inputs["NT_PDF_Filename_appendix"] = check_input($_POST["NT_PDF_Filename_appendix"]);
			$inputs["NT_PDF_glossary"] = 201;
			if (check_input($_POST["NT_PDF_Filename_glossary"]) != "") $inputs["NT_PDF"] = 1;
			if (isset($_POST["NT_PDF_glossary"]) && check_input($_POST["NT_PDF_Filename_glossary"]) == "") {
				$count_failed++;
				$messages[] = "NT PDF filename for 'NT Glossary' is blank.";
			}
			if (!isset($_POST["NT_PDF_glossary"]) && check_input($_POST["NT_PDF_Filename_glossary"]) != "") {
				$count_failed++;
				$messages[] = "Check box NT PDF for 'NT Glossary' is blank.";
			}
			$inputs["NT_PDF_Filename_glossary"] = check_input($_POST["NT_PDF_Filename_glossary"]);

// OT Audio
			$inputs["OT_Audio"] = 0;
			for ($i = 0; $i < 39; $i++) {					// number of books in the OT
				$item_from_array = $OT_array[2][$i];		// English book name
				$item2_from_array = $OT_array[1][$i];		// how many chapers in each book
				$inputs["OT_Audio_Book-".(string)$i] = $i;
				for ($z = 0; $z < $item2_from_array; $z++) {
					$y = $z + 1;
					$inputs["OT_Audio_Chapter-".(string)$i."-".(string)$z] = $y;
					if (check_input($_POST["OT_Audio_Filename-".(string)$i."-".(string)$z]) != "") $inputs["OT_Audio"] = 1;
					if (isset($_POST["OT_Audio_Index-".(string)$i."-".(string)$z]) && check_input($_POST["OT_Audio_Filename-".(string)$i."-".(string)$z]) == "") {
						$count_failed++;
						$messages[] = "OT Audio filename for " . $item_from_array . " chapter " . $y . " is blank.";
					}
					if (!isset($_POST["OT_Audio_Index-".(string)$i."-".(string)$z]) && check_input($_POST["OT_Audio_Filename-".(string)$i."-".(string)$z]) != "") {
						$count_failed++;
						$messages[] = "Check box for OT audio of " . $item_from_array . " chapter " . $y . " is blank.";
					}
					$inputs["OT_Audio_Filename-".(string)$i."-".(string)$z] = check_input($_POST["OT_Audio_Filename-".(string)$i."-".(string)$z]);
				}
			}

// NT Audio
			$inputs["NT_Audio"] = 0;
			for ($i = 0; $i < 27; $i++) {					// number of books in the NT
				$item_from_array = $NT_array[2][$i];		// English book name
				$item2_from_array = $NT_array[1][$i];		// how many chapers in each book
				$inputs["NT_Audio_Book-".(string)$i] = $i;
				for ($z = 0; $z < $item2_from_array; $z++) {
					$y = $z + 1;
					$inputs["NT_Audio_Chapter-".(string)$i."-".(string)$z] = $y;
					if (check_input($_POST["NT_Audio_Filename-".(string)$i."-".(string)$z]) != "") $inputs["NT_Audio"] = 1;
					if (isset($_POST["NT_Audio_Index-".(string)$i."-".(string)$z]) && check_input($_POST["NT_Audio_Filename-".(string)$i."-".(string)$z]) == "") {
						$count_failed++;
						$messages[] = "Audio filename for " . $item_from_array . " chapter " . $y . " is blank.";
					}
					if (!isset($_POST["NT_Audio_Index-".(string)$i."-".(string)$z]) && check_input($_POST["NT_Audio_Filename-".(string)$i."-".(string)$z]) != "") {
						$count_failed++;
						$messages[] = "Check box for audio of " . $item_from_array . " chapter " . $y . " is blank.";
					}
					$inputs["NT_Audio_Filename-".(string)$i."-".(string)$z] = check_input($_POST["NT_Audio_Filename-".(string)$i."-".(string)$z]);
				}
			}

// Read - YouVersion
			$i = 1;
			$YouVersionIndex = 1;
			$inputs["YouVersion"] = 0;
			while (isset($_POST['txtLinkYouVersionName-'.(string)$i])) {
				if (check_input($_POST['txtLinkYouVersionName-'.(string)$i]) != "") $inputs["YouVersion"] = 1;
				if (empty($_POST['txtLinkYouVersionName-'.(string)$i])) {
					if ((check_input($_POST['txtLinkYouVersionTitle-'.(string)$i]) != "") || (check_input($_POST['txtLinkYouVersionURL-'.(string)$i]) != "")) {
						$count_failed++;
						$messages[] = "YouVersion $i is blank.";
					}
				}
				$inputs["txtLinkYouVersionName-$YouVersionIndex"] = check_input($_POST["txtLinkYouVersionName-".(string)$i]);
				$inputs["txtLinkYouVersionTitle-$YouVersionIndex"] = check_input($_POST["txtLinkYouVersionTitle-".(string)$i]);
				$inputs["txtLinkYouVersionURL-$YouVersionIndex"] = check_input($_POST["txtLinkYouVersionURL-".(string)$i]);
				$YouVersionIndex++;
				$i++;
			}

// Study - Bibles.org
			$i = 1;
			$BiblesorgIndex = 1;
			$inputs["Biblesorg"] = 0;
			while (isset($_POST['txtLinkBiblesorgName-'.(string)$i])) {
				if (check_input($_POST["txtLinkBiblesorgName-".(string)$i]) != "") $inputs["Biblesorg"] = 1;
				if (empty($_POST["txtLinkBiblesorgName-".(string)$i])) {
					if ((check_input($_POST["txtLinkBiblesorgTitle-".(string)$i]) != "") || (check_input($_POST["txtLinkBiblesorgURL-".(string)$i]) != "")) {
						$count_failed++;
						$messages[] = "Bibles.org $i is blank.";
					}
				}
				$inputs["txtLinkBiblesorgName-$BiblesorgIndex"] = check_input($_POST["txtLinkBiblesorgName-".(string)$i]);
				$inputs["txtLinkBiblesorgTitle-$BiblesorgIndex"] = check_input($_POST["txtLinkBiblesorgTitle-".(string)$i]);
				$inputs["txtLinkBiblesorgURL-$BiblesorgIndex"] = check_input($_POST["txtLinkBiblesorgURL-".(string)$i]);
				$BiblesorgIndex++;
				$i++;
			}

// GRN
			$i = 1;
			$GRNIndex = 1;
			$inputs["GRN"] = 0;
			while (isset($_POST['txtLinkGRNName-'.(string)$i])) {
				if (check_input($_POST["txtLinkGRNName-".(string)$i]) != "") $inputs["GRN"] = 1;
				if (empty($_POST["txtLinkGRNName-".(string)$i])) {
					if ((check_input($_POST["txtLinkGRNTitle-".(string)$i]) != "") || (check_input($_POST["txtLinkGRNURL-".(string)$i]) != "")) {
						$count_failed++;
						$messages[] = "GRN $i is blank.";
					}
				}
				$inputs["txtLinkGRNName-$GRNIndex"] = check_input($_POST["txtLinkGRNName-".(string)$i]);
				$inputs["txtLinkGRNTitle-$GRNIndex"] = check_input($_POST["txtLinkGRNTitle-".(string)$i]);
				$inputs["txtLinkGRNURL-$GRNIndex"] = check_input($_POST["txtLinkGRNURL-".(string)$i]);
				$GRNIndex++;
				$i++;
			}

// CellPhone
			$i = 1;
			$CellPhoneIndex = 1;
			$inputs["CellPhone"] = 0;
			while (isset($_POST['txtCellPhoneFile-'.(string)$i])) {
				if (check_input($_POST['txtCellPhoneFile-'.(string)$i]) == "") {
				}
				else {
					$inputs["CellPhone"] = 1;
					if ($_POST["txtCellPhoneTitle-".(string)$i] == 'CPJava-'.$i) $inputs["CPJava-$CellPhoneIndex"] = 1; else $inputs["CPJava-$CellPhoneIndex"] = 0;
					if ($_POST["txtCellPhoneTitle-".(string)$i] == 'CPAndroid-'.$i) $inputs["CPAndroid-$CellPhoneIndex"] = 1; else $inputs["CPAndroid-$CellPhoneIndex"] = 0;
					if ($_POST["txtCellPhoneTitle-".(string)$i] == 'CPiPhone-'.$i) $inputs["CPiPhone-$CellPhoneIndex"] = 1; else $inputs["CPiPhone-$CellPhoneIndex"] = 0;
					if ($_POST["txtCellPhoneTitle-".(string)$i] == 'CPAndroidApp-'.$i) $inputs["CPAndroidApp-$CellPhoneIndex"] = 1; else $inputs["CPAndroidApp-$CellPhoneIndex"] = 0;
					if ($_POST["txtCellPhoneTitle-".(string)$i] == 'CPiOSAssetPackage-'.$i) $inputs["CPiOSAssetPackage-$CellPhoneIndex"] = 1; else $inputs["CPiOSAssetPackage-$CellPhoneIndex"] = 0;
					if ($_POST["txtCellPhoneTitle-".(string)$i] == 'CPePub-'.$i) $inputs["CPePub-$CellPhoneIndex"] = 1; else $inputs["CPePub-$CellPhoneIndex"] = 0;
					$inputs["txtCellPhoneFile-$CellPhoneIndex"] = check_input($_POST["txtCellPhoneFile-".(string)$i]);
					$inputs["txtCellPhoneOptional-$CellPhoneIndex"] = check_input($_POST["txtCellPhoneOptional-".(string)$i]);
					$CellPhoneIndex++;
				}
				$i++;
			}

// watch
  			$i = 1;
			$inputs["watch"] = 0;
			while (isset($_POST["txtWatchURL-$i"])) {
				if (check_input($_POST["txtWatchURL-$i"]) != "") $inputs["watch"] = 1;
				if (empty($_POST["txtWatchURL-$i"])) {
					if ((check_input($_POST["txtWatchResource-$i"]) != "") || (check_input($_POST["txtWatchURL-$i"]) != "")) {
						$count_failed++;
						$messages[] = "Watch #" . $i . " is empty.";
					}
				}
				$inputs["txtWatchWebSource-".(string)$i] = check_input($_POST["txtWatchWebSource-".(string)$i]);
				$inputs["txtWatchResource-".(string)$i] = check_input($_POST["txtWatchResource-".(string)$i]);
				$inputs["txtWatchURL-".(string)$i] = check_input($_POST["txtWatchURL-".(string)$i]);
				$inputs["txtWatchJesusFilm-".(string)$i] = 0;
				if (isset($_POST["txtWatchJesusFilm-".(string)$i])) {
					if ($_POST["txtWatchJesusFilm-".(string)$i] == 'on') $inputs["txtWatchJesusFilm-".(string)$i] = 1;		// checkbox = checked
				}
				$inputs["txtWatchYouTube-".(string)$i] = 0;
				if (isset($_POST["txtWatchYouTube-".(string)$i])) {
					if ($_POST["txtWatchYouTube-".(string)$i] == 'on') $inputs["txtWatchYouTube-".(string)$i] = 1;			// checkbox = checked
				}
				if ($inputs["txtWatchJesusFilm-".(string)$i] == 1 && $inputs["txtWatchYouTube-".(string)$i] == 1) {
					$count_failed++;
					$messages[] = "Watch: Use 'Jesus Film' or 'YouTube' ONLY on line # " . $i;
				}
				$i++;
			}

// viewer
			$inputs["viewer"] = 0;
			$inputs["viewerText"] = "";
			$inputs["rtl"] = 0;
			if (isset($_POST["viewer"])) {
				if ($_POST["viewer"] == 'on') {
					$inputs["viewer"] = 1;		// checkbox = checked
				}
				if ($_POST["viewerText"] != "" && $_POST["viewer"] == "on")
					$inputs["viewerText"] = check_input($_POST["viewerText"]);
			}
			if (isset($_POST["rtl"])) {
				if ($_POST["rtl"] == 'on') {
					$inputs["rtl"] = 1;			// checkbox = checked
					$inputs["viewer"] = 1;		// checkbox = checked
				}
			}

// study
			$i = 1;
			$inputs["study"] = 0;
			while (isset($_POST["txtScriptureDescription-".(string)$i])) {
				if (check_input($_POST["txtScriptureDescription-".(string)$i]) != "") $inputs["study"] = 1;
				if (empty($_POST["txtScriptureDescription-".(string)$i])) {
					if ((check_input($_POST["txtScriptureURL-".(string)$i]) != "") || (check_input($_POST["txtStatement-".(string)$i]) != "") || (check_input($_POST["txtOthersiteDescription-".(string)$i]) != "") || (check_input($_POST["txtOthersiteURL-".(string)$i]) != "")) {
						$count_failed++;
						$messages[] = "Study #" . $i . " is blank.";
					}
				}
				$inputs["txtScriptureDescription-$i"] = check_input($_POST["txtScriptureDescription-".(string)$i]);
				$inputs["txtScriptureURL-$i"] = check_input($_POST["txtScriptureURL-".(string)$i]);
				$inputs["txtStatement-$i"] = check_input($_POST["txtStatement-".(string)$i]);
				if ($_POST["txtTestament-".(string)$i] == 'SNT-'.$i) $inputs["SNT-$i"] = 1; else $inputs["SNT-$i"] = 0;
				if ($_POST["txtTestament-".(string)$i] == 'SOT-'.$i) $inputs["SOT-$i"] = 1; else $inputs["SOT-$i"] = 0;
				if ($_POST["txtTestament-".(string)$i] == 'SBible-'.$i) $inputs["SBible-$i"] = 1; else $inputs["SBible-$i"] = 0;
				if ($_POST["txtAlphabet-".(string)$i] == 'SStandAlphabet-'.$i) $inputs["SStandAlphabet-$i"] = 1; else $inputs["SStandAlphabet-$i"] = 0;
				if ($_POST["txtAlphabet-".(string)$i] == 'STradAlphabet-'.$i) $inputs["STradAlphabet-$i"] = 1; else $inputs["STradAlphabet-$i"] = 0;
				if ($_POST["txtAlphabet-".(string)$i] == 'SNewAlphabet-'.$i) $inputs["SNewAlphabet-$i"] = 1; else $inputs["SNewAlphabet-$i"] = 0;
				$inputs["txtOthersiteDescription-$i"] = check_input($_POST["txtOthersiteDescription-".(string)$i]);
				$inputs["txtOthersiteURL-$i"] = check_input($_POST["txtOthersiteURL-".(string)$i]);
				$i++;
			}

// other titles
  			$i = 1;
			$inputs["other_titles"] = 0;
			while (isset($_POST["txtOther-".(string)$i]) && !empty($_POST['txtOther-'.(string)$i])) {
				if (!empty($_POST["txtOther-".(string)$i])) $inputs["other_titles"] = 1;
				if (!empty($_POST['txtOther-'.(string)$i])) {
					if (empty($_POST['txtOtherTitle-'.(string)$i])) {										// this is a "Summary" and not an actual "Title"!
						$count_failed++;
						$messages[] = 'Other Summary #' . $i . ' is blank.';
					}
					if (empty($_POST['txtOtherPDF-'.(string)$i]) && empty($_POST['txtOtherAudio-'.(string)$i]) && empty($_POST['txtDownload_video-'.(string)$i])) {
						$count_failed++;
						$messages[] = 'One of the Filenames is not chosen on #' . $i . ' on the Other.';
					}
					if (!empty($_POST['txtOtherPDF-'.(string)$i]) && !empty($_POST['txtOtherAudio-'.(string)$i])) {
						$count_failed++;
						$messages[] = 'Other PDF and Other Audio have Filenames in #'.$i.'. Only one Filename has to be here.';
					}
					if (!empty($_POST['txtOtherPDF-'.(string)$i]) && !empty($_POST['txtDownload_video-'.(string)$i])) {
						$count_failed++;
						$messages[] = 'Other PDF and Other Download Video have Filenames in #'.$i.'. Only one Filename has to be here.';
					}
					if (!empty($_POST['txtOtherAudio-'.(string)$i]) && !empty($_POST['txtDownload_video-'.(string)$i])) {
						$count_failed++;
						$messages[] = 'Other Audio and Other Download Video have Filenames in #'.$i.'. Only one Filename has to be here.';
					}
				}
				$inputs["txtOther-".(string)$i] = check_input($_POST["txtOther-".(string)$i]);
				$inputs["txtOtherTitle-".(string)$i] = check_input($_POST["txtOtherTitle-".(string)$i]);
				$inputs["txtOtherPDF-".(string)$i] = check_input($_POST["txtOtherPDF-".(string)$i]);
				$inputs["txtOtherAudio-".(string)$i] = check_input($_POST["txtOtherAudio-".(string)$i]);
				$inputs["txtDownload_video-".(string)$i] = check_input($_POST["txtDownload_video-".(string)$i]);
				$i++;
			}

// buy
  			$i = 1;
			$inputs["buy"] = 0;
			while (isset($_POST["txtBuyWebSource-".(string)$i])) {
				if (check_input($_POST["txtBuyWebSource-".(string)$i]) != "") $inputs["buy"] = 1;
				if (empty($_POST["txtBuyWebSource-".(string)$i])) {
					if ((check_input($_POST["txtBuyResource-".(string)$i]) != "") || (check_input($_POST["txtBuyURL-".(string)$i]) != "")) {
						$count_failed++;
						$messages[] = "Buy #" . $i . " is blank.";
					}
				}
				$inputs["txtBuyWebSource-".(string)$i] = check_input($_POST["txtBuyWebSource-".(string)$i]);
				$inputs["txtBuyResource-".(string)$i] = check_input($_POST["txtBuyResource-".(string)$i]);
				$inputs["txtBuyURL-".(string)$i] = check_input($_POST["txtBuyURL-".(string)$i]);
				$i++;
			}

// links: buy, map, GooglePlay, and Kalamm
  			$i = 1;
			//$inputs["links"] = 0;
			while (isset($_POST["txtLinkCompany-".(string)$i])) {
				if (check_input($_POST["txtLinkCompany-".(string)$i]) != "") $inputs["links"] = 1;
				if (empty($_POST["txtLinkCompany-".(string)$i])) {
					if ((check_input($_POST["txtLinkCompanyTitle-".(string)$i]) != "") || (check_input($_POST["txtLinkURL-".(string)$i]) != "")) {
						$count_failed++;
						$messages[] = "Link #" . $i . " is blank.";
					}
				}
				$inputs["txtLinkCompany-".(string)$i] = check_input($_POST["txtLinkCompany-".(string)$i]);
				$inputs["txtLinkCompanyTitle-".(string)$i] = check_input($_POST["txtLinkCompanyTitle-".(string)$i]);
				$inputs["txtLinkURL-".(string)$i] = check_input($_POST["txtLinkURL-".(string)$i]);
				if ($_POST["linksIcon-".(string)$i] == 'linksOther-'.$i) $inputs["linksOther-$i"] = 1; else $inputs["linksOther-$i"] = 0;
				//if ($_POST["linksIcon-".(string)$i] == 'linksBuy-'.$i) $inputs["linksBuy-$i"] = 1; else $inputs["linksBuy-$i"] = 0;
				if ($_POST["linksIcon-".(string)$i] == 'linksMap-'.$i) $inputs["linksMap-$i"] = 1; else $inputs["linksMap-$i"] = 0;
				if ($_POST["linksIcon-".(string)$i] == 'linksGooglePlay-'.$i) $inputs["linksGooglePlay-$i"] = 1; else $inputs["linksGooglePlay-$i"] = 0;
				if ($_POST["linksIcon-".(string)$i] == 'linksKalaam-'.$i) $inputs["linksKalaam-$i"] = 1; else $inputs["linksKalaam-$i"] = 0;
				$i++;
			}

// links: email
			$i = 1;
			$inputs['email'] = 0;
			while (isset($_POST['txtEmailTitle-'.(string)$i]) || isset($_POST['txtEmailAddress-'.(string)$i])) {
				if (check_input($_POST['txtEmailAddress-'.(string)$i]) != "") $inputs['email'] = 1;
				if (empty($_POST['txtEmailAddress-'.(string)$i])) {
					if ((check_input($_POST['txtEmailTitle-'.(string)$i]) != "") || (check_input($_POST['txtEmailAddress-'.(string)$i]) != "")) {
						$count_failed++;
						$messages[] = "Email #" . $i . " is blank.";
					}
				}
				$inputs["txtEmailTitle-".(string)$i] = check_input($_POST["txtEmailTitle-".(string)$i]);
				$inputs["txtEmailAddress-".(string)$i] = check_input($_POST["txtEmailAddress-".(string)$i]);
				$i++;
			}

// Audio Playlist
  			$i = 1;
			$inputs["AudioPlaylist"] = 0;
			while (isset($_POST["txtPlaylistAudioTitle-".(string)$i])) {
				if (check_input($_POST["txtPlaylistAudioTitle-".(string)$i]) != "" && check_input($_POST["txtPlaylistAudioFilename-".(string)$i]) != "") $inputs["AudioPlaylist"] = 1;
				if (empty($_POST["txtPlaylistAudioTitle-".(string)$i]) || empty($_POST["txtPlaylistAudioFilename-".(string)$i])) {
					if ((check_input($_POST["txtPlaylistAudioTitle-$i"]) != "") || (check_input($_POST["txtPlaylistAudioFilename-$i"]) != "")) {
						$count_failed++;
						$messages[] = "Audio Platlist #" . $i . " is blank.";
					}
				}
				$inputs["txtPlaylistAudioTitle-".(string)$i] = check_input($_POST["txtPlaylistAudioTitle-".(string)$i]);
				$inputs["txtPlaylistAudioFilename-".(string)$i] = check_input($_POST["txtPlaylistAudioFilename-".(string)$i]);
				$i++;
			}

// Video Playlist
  			$i = 1;
			$inputs["VideoPlaylist"] = 0;
			while (isset($_POST["txtPlaylistVideoTitle-".(string)$i])) {
				if (check_input($_POST["txtPlaylistVideoTitle-".(string)$i]) != "" && check_input($_POST["txtPlaylistVideoFilename-".(string)$i]) != "") $inputs["VideoPlaylist"] = 1;
				if (empty($_POST["txtPlaylistVideoTitle-".(string)$i]) || empty($_POST["txtPlaylistVideoFilename-".(string)$i])) {
					if ((check_input($_POST["txtPlaylistVideoTitle-$i"]) != "") || (check_input($_POST["txtPlaylistVideoFilename-$i"]) != "")) {
						$count_failed++;
						$messages[] = "View Video or Download Video Platlist #" . $i . " is blank.";
					}
				}
				$inputs["txtPlaylistVideoTitle-".(string)$i] = check_input($_POST["txtPlaylistVideoTitle-".(string)$i]);
				$inputs["txtPlaylistVideoFilename-".(string)$i] = check_input($_POST["txtPlaylistVideoFilename-".(string)$i]);
				if ($_POST["PlaylistVideoDownloadIcon-".(string)$i] == 'PlaylistVideoView-'.$i) $inputs["PlaylistVideoView-$i"] = 1; else $inputs["PlaylistVideoView-$i"] = 0;
				if ($_POST["PlaylistVideoDownloadIcon-".(string)$i] == 'PlaylistVideoDownload-'.$i) $inputs["PlaylistVideoDownload-$i"] = 1; else $inputs["PlaylistVideoDownload-$i"] = 0;
				$i++;
			}

// eBible
			$_POST['eBible'] = 'off';
			$inputs['eBible'] = 0;
			/* not needed (5/2024)
			if (isset($_POST['eBible'])) {
				if ($_POST['eBible'] == 'on') {
					$inputs['eBible'] = 1;			// checkbox = checked
				}
			}
			*/

// SIL link
			$inputs['SILlink'] = 0;
			if (isset($_POST['SILlink'])) {
				if ($_POST['SILlink'] == 'on') {
					$inputs['SILlink'] = 1;			// checkbox = checked
				}
			}
// SIL List end
		}
	}
	else {
		// Increments the number of failed validations
		$count_failed++;
		// Adds a message to the message queue.
		$messages[] = 'The ISO you entered is the wrong length.';
	}

	// If there are no failures, the inputs passed validation
	if ($count_failed == 0) {
		require_once 'SubmitAddConfirm.php';
		// If exit was not here, the form page would be appended to the confirmation page.
		exit;
	}

// The form page (right where Scripture_Add.php called Add_Lang_Validation.php) will continue to be processed now because the validation failed.
?>