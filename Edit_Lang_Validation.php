<?php
	// This script cannot be accessed directly.
	if ( ! (defined('RIGHT_ON') && RIGHT_ON === true)) {
		@include_once '403.php';
		exit;
	}
	 
	// The number of failed validations
	$count_failed = 0;
	$inputs['iso'] = check_input($_POST["iso"]);
	$inputs['rod'] = check_input($_POST["rod"]);
	$inputs['var'] = check_input($_POST["var"]);
	$inputs['idx'] = check_input($_POST["idx"]);
	$inputs["links"] = 0;
	
// Countries
	$inputs['English_lang_name'] = check_input($_POST["English_lang_name"]);
	$inputs['Eng_country-1'] = check_input($_POST["Eng_country-1"]);
	if ($inputs['English_lang_name'] != '') $inputs['LN_EnglishBool'] = 1; else $inputs['LN_EnglishBool'] = 0;
	$inputs['ISO_countries'] = 0;

	$i = 1;
	if ($inputs['Eng_country-1'] == '') {
		$count_failed++;
		$messages[] = 'The English name of the Country is blank.';
	}
	else {
		while (isset($_POST["Eng_country-$i"])) {
			$inputs["Eng_country-$i"] = check_input($_POST["Eng_country-$i"]);
			$i++;
		}
	}

// Specific Language Names for the navigational Language Names
//		"No Language Names are found."
	$no_ln_missing = 0;
	foreach ($_SESSION['nav_ln_array'] as $code => $array){
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
	if ($inputs['Eng_country-1'] != '') {
		$db->query('set names utf8');
		while ($z < $i) {
			$temp = "Eng_country-".$z;
			$temp=$inputs[$temp];
			$query="SELECT ISO_Country FROM countries WHERE English='$temp'";
			$result=$db->query($query);
			if ($result) {
				$temp = 'ISO_Country-'.$z;
				$r = $result->fetch_assoc();
				$inputs[$temp] = $r['ISO_Country'];
			}
			else {
				$count_failed++;
				$messages[] = "The Country isn't found: ".$temp;
			}
			$z++;
		}
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

// Bible names
	$inputs["AddTheBibleIn"] = 0;
	if (isset($_POST["AddTheBibleIn"])) {
		if ($_POST["AddTheBibleIn"] != "") $inputs["AddTheBibleIn"] = 1;		// checkbox = checked
	}

// alterative names
	$i = 1;
	$inputs["alt_lang_names"] = 0;
	while (isset($_POST["txtAltNames-$i"])) {
		if (check_input($_POST["txtAltNames-$i"]) != '') {
			$inputs["txtAltNames-$i"] = check_input($_POST["txtAltNames-$i"]);
			$inputs["alt_lang_names"] = 1;
		}
		$i++;
	}

// which title
	$inputs["AddNo"] = 0;
	$inputs["AddTheBibleIn"] = 0;
	$inputs["AddTheScriptureIn"] = 0;
	if (isset($_POST['GroupAdd'])) {														// radio button = checked
		if ($_POST['GroupAdd'] == "AddNo") $inputs["AddNo"] = 1;
		if ($_POST['GroupAdd'] == "AddTheBibleIn") $inputs["AddTheBibleIn"] = 1;
		if ($_POST['GroupAdd'] == "AddTheScriptureIn") $inputs["AddTheScriptureIn"] = 1;
	}

// isop
	$inputs["isop"] = 0;
	$inputs["isopText"] = '';
	if (isset($_POST['isopText']) && trim($_POST['isopText']) != '') {
		$inputs["isopText"] = check_input(trim($_POST["isopText"]));
		$inputs["isop"] = 1;
		if (strlen($inputs["isopText"]) < 4) {
			$count_failed++;
			$messages[] = "Error. isoP is/are under 4 character(s).";
		}
		$beg_isop = preg_replace('/^([a-z]{3}).*/', '$1', $inputs["isopText"]);
		if ($beg_isop != $inputs['iso']) {
			$count_failed++;
			$messages[] = "'$beg_isop' is not the same as '".$inputs['iso']."'.";
		}
	}

// Bible.is
	$i = 1;
	$BibleIsIndex = 1;
	$inputs["BibleIs"] = 0;
	while (isset($_POST["txtLinkBibleIsURL-".(string)$i])) {
		if (check_input($_POST["txtLinkBibleIsURL-".(string)$i]) != '') $inputs["BibleIs"] = 1;
		if (empty($_POST["txtLinkBibleIsURL-".(string)$i])) {
		}
		else {
			$inputs["txtLinkBibleIsURL-".(string)$i] = check_input($_POST["txtLinkBibleIsURL-".(string)$i]);
			$inputs["txtLinkBibleIsTitle-".(string)$i] = check_input($_POST["txtLinkBibleIsTitle-".(string)$i]);
			$inputs["txtLinkBibleIs-".(string)$i] = check_input($_POST["txtLinkBibleIs-".(string)$i]);
			if ($_POST["txtLinkBibleIs-".(string)$i] == 'BibleIsDefault-'.$i) $inputs["BibleIsDefault-$BibleIsIndex"] = 1; else $inputs["BibleIsDefault-$BibleIsIndex"] = 0;
			if ($_POST["txtLinkBibleIs-".(string)$i] == 'BibleIsText-'.$i) $inputs["BibleIsText-$BibleIsIndex"] = 2; else $inputs["BibleIsText-$BibleIsIndex"] = 0;
			if ($_POST["txtLinkBibleIs-".(string)$i] == 'BibleIsAudio-'.$i) $inputs["BibleIsAudio-$BibleIsIndex"] = 3; else $inputs["BibleIsAudio-$BibleIsIndex"] = 0;
			if ($_POST["txtLinkBibleIs-".(string)$i] == 'BibleIsVideo-'.$i) $inputs["BibleIsVideo-$BibleIsIndex"] = 4; else $inputs["BibleIsVideo-$BibleIsIndex"] = 0;
			$BibleIsIndex++;
		}
		$i++;
	}

// Bible.is Gospel Film
	$i = 1;
	$BibleIsGospelFilmIndex = 1;
	$inputs["BibleIsGospelFilm"] = 0;
	while (isset($_POST["txtLinkBibleIsGospelFilmURL-".(string)$i])) {
		if (check_input($_POST["txtLinkBibleIsGospelFilmURL-".(string)$i]) != '') $inputs["BibleIsGospelFilm"] = 1;
		if (empty($_POST["txtLinkBibleIsGospelFilmURL-".(string)$i])) {
		}
		else {
			$inputs["txtLinkBibleIsGospelFilmURL-".(string)$i] = check_input($_POST["txtLinkBibleIsGospelFilmURL-".(string)$i]);
			$inputs["txtLinkBibleIsGospel-".(string)$i] = check_input($_POST["txtLinkBibleIsGospel-".(string)$i]);
			$BibleIsGospelFilmIndex++;
		}
		$i++;
	}

// SAB

	/*
			SAB_scriptoria
	url		subfolder	description		pre_scriptoria
				sab/

			Scripture_Edit.php
	txtSABurl		txtSABsubfolder		txtSABdescription		txtSABpreScriptoria
	(hidden) txtSABsubFirstPath
	*/
	$inputs["SAB"] = 0;
	$i = 1;
	while (isset($_POST["txtSABsubfolder-".(string)$i]) && (trim($_POST["txtSABsubfolder-".(string)$i]) != '') || (isset($_POST["txtSABurl-".(string)$i]) && (trim($_POST["txtSABurl-".(string)$i]) != ''))) {
		$inputs["SAB"] = 1;
		if (isset($_POST["txtSABsubfolder-".(string)$i]) && (trim($_POST["txtSABsubfolder-".(string)$i]) != '')) {
			$inputs["txtSABurl-".(string)$i] = '';
			$inputs["txtSABdescription-".(string)$i] = check_input($_POST["txtSABdescription-".(string)$i]);
			
			if (isset($_POST["txtSABpreScriptoria-".(string)$i])) {
				$inputs["txtSABpreScriptoria-".(string)$i] = check_input($_POST["txtSABpreScriptoria-".(string)$i]);
			}
			else {
				$inputs["txtSABpreScriptoria-".(string)$i] = '';
			}
			if ($inputs["txtSABpreScriptoria-".(string)$i] !== '') {
				$inputs["txtSABsubfolder-".(string)$i] = 'sab/'.$inputs["txtSABpreScriptoria-".(string)$i];
				$inputs["txtSABsubFirstPath-".(string)$i] = '';
			}
			else {
				$inputs["txtSABsubfolder-".(string)$i] = 'sab/'.$_POST["txtSABsubfolder-".(string)$i].'/';
				$inputs["txtSABsubFirstPath-".(string)$i] = '';
			}
		}
		else {			// else isset($_POST["txtSABurl-".(string)$i]) && (trim($_POST["txtSABurl-".(string)$i]) != '')
			$inputs["txtSABdescription-".(string)$i] = check_input($_POST["txtSABdescription-".(string)$i]);
			$inputs["txtSABurl-".(string)$i] = check_input($_POST["txtSABurl-".(string)$i]);
			$inputs["txtSABsubfolder-".(string)$i] = '';
			$inputs["txtSABpreScriptoria-".(string)$i] = '';
			$inputs["txtSABsubFirstPath-".(string)$i] = '';
		}
		$i++;
	}
	
// Bible PDF
	$inputs["Bible_PDF"] = 0;
	if (check_input($_POST["whole_Bible"]) != "") {
		$inputs['whole_Bible'] = check_input($_POST["whole_Bible"]);
		$inputs["Bible_PDF"] = 1;
	}
	else {
		$inputs['whole_Bible'] = "";
	}

// complete Scripture PDF
	$inputs["complete_Scripture_PDF"] = 0;
	if (check_input($_POST["complete_Scripture"]) != "") {
		$inputs['complete_Scripture'] = check_input($_POST["complete_Scripture"]);
		$inputs["complete_Scripture_PDF"] = 1;
	}
	else {
		$inputs['complete_Scripture'] = "";
	}

// OT_PDF
	$inputs["OT_PDF"] = 0;
	if (check_input($_POST["OT_name"]) != "") {
		$inputs['OT_name'] = check_input($_POST["OT_name"]);
		$inputs["OT_PDF"] = 1;
		for ($i = 0; $i < 39; $i++) {
			$inputs["OT_PDF_Filename-$i"] = "";
		}
		$inputs["OT_PDF_Filename_appendix"] = "";
		$inputs["OT_PDF_Filename_glossary"] = "";
	}
	else {
		$inputs['OT_name'] = "";
	}
	for ($i = 0; $i < 39; $i++) {
		$inputs["OT_PDF_Book-$i"] = $i;
		if (check_input($_POST["OT_PDF_Filename-$i"]) != "") $inputs["OT_PDF"] = 1;
		$item_from_array = $OT_array[2][$i];		// English book name
		if (isset($_POST["OT_PDF_Book-$i"]) && check_input($_POST["OT_PDF_Filename-$i"]) == "") {
			$count_failed++;
			$messages[] = "OT PDF filename for " . $item_from_array . " is blank.";
		}
		if (!isset($_POST["OT_PDF_Book-$i"]) && check_input($_POST["OT_PDF_Filename-$i"]) != "") {
			$count_failed++;
			$messages[] = "Check box OT PDF for " .$item_from_array . " is blank.";
		}
		$inputs["OT_PDF_Filename-$i"] = check_input($_POST["OT_PDF_Filename-$i"]);
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

// NT_PDF
	$inputs["NT_PDF"] = 0;
	if (check_input($_POST["NT_name"]) != "") {
		$inputs['NT_name'] = check_input($_POST["NT_name"]);
		$inputs["NT_PDF"] = 1;
		for ($i = 0; $i < 27; $i++) {
			$inputs["NT_PDF_Filename-$i"] = "";
		}
		$inputs["NT_PDF_Filename_appendix"] = "";
		$inputs["NT_PDF_Filename_glossary"] = "";
	}
	else {
		$inputs['NT_name'] = "";
	}
	for ($i = 0; $i < 27; $i++) {
		$inputs["NT_PDF_Book-$i"] = $i;
		if (check_input($_POST["NT_PDF_Filename-$i"]) != "") $inputs["NT_PDF"] = 1;
		$item_from_array = $NT_array[2][$i];		// English book name
		if (isset($_POST["NT_PDF_Book-$i"]) && check_input($_POST["NT_PDF_Filename-$i"]) == "") {
			$count_failed++;
			$messages[] = "NT PDF filename for " . $item_from_array . " is blank.";
		}
		if (!isset($_POST["NT_PDF_Book-$i"]) && check_input($_POST["NT_PDF_Filename-$i"]) != "") {
			$count_failed++;
			$messages[] = "Check box PDF for " .$item_from_array . " is blank.";
		}
		$inputs["NT_PDF_Filename-$i"] = check_input($_POST["NT_PDF_Filename-$i"]);
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
	
// OT_Audio
	$inputs["OT_Audio"] = 0;
	for ($i = 0; $i < 39; $i++) {					// number of books in the OT
		$item_from_array = $OT_array[2][$i];		// English book name
		$item2_from_array = $OT_array[1][$i];		// how many chapers in each book
		$inputs["OT_Audio_Book-".$i] = $i;
		for ($z = 0; $z < $item2_from_array; $z++) {
			$y = $z + 1;
			$inputs["OT_Audio_Chapter-".$i."-".$z] = $y;
			if (check_input($_POST["OT_Audio_Filename-".$i."-".$z]) != "") $inputs["OT_Audio"] = 1;
			if (isset($_POST["OT_Audio_Index-".$i."-".$z]) && check_input($_POST["OT_Audio_Filename-".$i."-".$z]) == "") {
				$count_failed++;
				$messages[] = "OT Audio filename for " . $item_from_array . " chapter " . $y . " is blank.";
			}
			if (!isset($_POST["OT_Audio_Index-".$i."-".$z]) && check_input($_POST["OT_Audio_Filename-".$i."-".$z]) != "") {
				$count_failed++;
				$messages[] = "Check box for OT audio of " . $item_from_array . " chapter " . $y . " is blank.";
			}
			$inputs["OT_Audio_Filename-".$i."-".$z] = check_input($_POST["OT_Audio_Filename-".$i."-".$z]);
		}
	}

// NT_Audio
	$inputs["NT_Audio"] = 0;
	for ($i = 0; $i < 27; $i++) {					// number of books in the NT
		$item_from_array = $NT_array[2][$i];		// English book name
		$item2_from_array = $NT_array[1][$i];		// how many chapers in each book
		$inputs["NT_Audio_Book-".$i] = $i;
		for ($z = 0; $z < $item2_from_array; $z++) {
			$y = $z + 1;
			$inputs["NT_Audio_Chapter-".$i."-".$z] = $y;
			if ($_POST["NT_Audio_Filename-".$i."-".$z] != "") $inputs["NT_Audio"] = 1;
			if (isset($_POST["NT_Audio_Index-".$i."-".$z]) && $_POST["NT_Audio_Filename-".$i."-".$z] == "") {
				$count_failed++;
				$messages[] = "NT Audio filename for " . $item_from_array . " chapter " . $y . " is blank.";
			}
			if (!isset($_POST["NT_Audio_Index-".$i."-".$z]) && $_POST["NT_Audio_Filename-".$i."-".$z] != "") {
				$count_failed++;
				$messages[] = "Check box for audio of " . $item_from_array . " chapter " . $y . " is blank.";
			}
			$inputs["NT_Audio_Filename-".$i."-".$z] = $_POST["NT_Audio_Filename-".$i."-".$z];
		}
	}
	
// YouVersion
	$i = 1;
	$YouVersionIndex = 1;
	$inputs["YouVersion"] = 0;
	while (isset($_POST["txtLinkYouVersionName-$i"])) {
		if (check_input($_POST["txtLinkYouVersionName-$i"]) != "") $inputs["YouVersion"] = 1;
		if (empty($_POST["txtLinkYouVersionName-$i"])) {
			if ((check_input($_POST["txtLinkYouVersionTitle-$i"]) != "") || (check_input($_POST["txtLinkYouVersionURL-$i"]) != "")) {
				$count_failed++;
				$messages[] = "YouVersion.com $i is blank.";
			}
		}
		$inputs["txtLinkYouVersionName-$YouVersionIndex"] = check_input($_POST["txtLinkYouVersionName-$i"]);
		$inputs["txtLinkYouVersionTitle-$YouVersionIndex"] = check_input($_POST["txtLinkYouVersionTitle-$i"]);
		$inputs["txtLinkYouVersionURL-$YouVersionIndex"] = check_input($_POST["txtLinkYouVersionURL-$i"]);
		$YouVersionIndex++;
		$i++;
	}

// Biblesorg
	$i = 1;
	$BiblesorgIndex = 1;
	$inputs["Biblesorg"] = 0;
	while (isset($_POST["txtLinkBiblesorgName-$i"])) {
		if (check_input($_POST["txtLinkBiblesorgName-$i"]) != "") $inputs["Biblesorg"] = 1;
		if (empty($_POST["txtLinkBiblesorgName-$i"])) {
			if ((check_input($_POST["txtLinkBiblesorgTitle-$i"]) != "") || (check_input($_POST["txtLinkBiblesorgURL-$i"]) != "")) {
				$count_failed++;
				$messages[] = "Bibles.org $i is blank.";
			}
		}
		$inputs["txtLinkBiblesorgName-$BiblesorgIndex"] = check_input($_POST["txtLinkBiblesorgName-$i"]);
		$inputs["txtLinkBiblesorgTitle-$BiblesorgIndex"] = check_input($_POST["txtLinkBiblesorgTitle-$i"]);
		$inputs["txtLinkBiblesorgURL-$BiblesorgIndex"] = check_input($_POST["txtLinkBiblesorgURL-$i"]);
		$BiblesorgIndex++;
		$i++;
	}

// GRN
	$i = 1;
	$inputs["GRN"] = 0;
	while (isset($_POST["txtLinkGRNName-$i"])) {
		if (check_input($_POST["txtLinkGRNName-$i"]) != "") $inputs["GRN"] = 1;
		if (empty($_POST["txtLinkGRNName-$i"])) {
			if ((check_input($_POST["txtLinkGRNTitle-$i"]) != "") || (check_input($_POST["txtLinkGRNURL-$i"]) != "")) {
				$count_failed++;
				$messages[] = "GRN $i is blank.";
			}
		}
		$inputs["txtLinkGRNName-$i"] = check_input($_POST["txtLinkGRNName-$i"]);
		$inputs["txtLinkGRNTitle-$i"] = check_input($_POST["txtLinkGRNTitle-$i"]);
		$inputs["txtLinkGRNURL-$i"] = check_input($_POST["txtLinkGRNURL-$i"]);
		$i++;
	}

// CellPhone
	$i = 1;
	$CellPhoneIndex = 1;
	$inputs["CellPhone"] = 0;
	while (isset($_POST["txtCellPhoneFile-$i"])) {
		if (check_input($_POST["txtCellPhoneFile-$i"]) == "") {
		}
		else {
			$inputs["CellPhone"] = 1;
			if ($_POST["txtCellPhoneTitle-".(string)$i] == 'CPJava-'.$i) $inputs["CPJava-$CellPhoneIndex"] = 1; else $inputs["CPJava-$CellPhoneIndex"] = 0;
			if ($_POST["txtCellPhoneTitle-".(string)$i] == 'CPAndroid-'.$i) $inputs["CPAndroid-$CellPhoneIndex"] = 1; else $inputs["CPAndroid-$CellPhoneIndex"] = 0;
			if ($_POST["txtCellPhoneTitle-".(string)$i] == 'CPiPhone-'.$i) $inputs["CPiPhone-$CellPhoneIndex"] = 1; else $inputs["CPiPhone-$CellPhoneIndex"] = 0;
			if ($_POST["txtCellPhoneTitle-".(string)$i] == 'CPAndroidApp-'.$i) $inputs["CPAndroidApp-$CellPhoneIndex"] = 1; else $inputs["CPAndroidApp-$CellPhoneIndex"] = 0;
			if ($_POST["txtCellPhoneTitle-".(string)$i] == 'CPiOSAssetPackage-'.$i) $inputs["CPiOSAssetPackage-$CellPhoneIndex"] = 1; else $inputs["CPiOSAssetPackage-$CellPhoneIndex"] = 0;
			$inputs["txtCellPhoneFile-$CellPhoneIndex"] = check_input($_POST["txtCellPhoneFile-$i"]);
			$inputs["txtCellPhoneOptional-$CellPhoneIndex"] = check_input($_POST["txtCellPhoneOptional-$i"]);
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
		$inputs["txtWatchWebSource-$i"] = check_input($_POST["txtWatchWebSource-$i"]);
		$inputs["txtWatchResource-$i"] = check_input($_POST["txtWatchResource-$i"]);
		$inputs["txtWatchURL-$i"] = check_input($_POST["txtWatchURL-$i"]);
		$inputs["txtWatchJesusFilm-$i"] = 0;
		if (isset($_POST["txtWatchJesusFilm-$i"])) {
			if ($_POST["txtWatchJesusFilm-$i"] == 'on') $inputs["txtWatchJesusFilm-$i"] = 1;		// checkbox = checked
		}
		$inputs["txtWatchYouTube-$i"] = 0;
		if (isset($_POST["txtWatchYouTube-$i"])) {
			if ($_POST["txtWatchYouTube-$i"] == 'on') $inputs["txtWatchYouTube-$i"] = 1;			// checkbox = checked
		}
		if ($inputs["txtWatchJesusFilm-$i"] == 1 && $inputs["txtWatchYouTube-$i"] == 1) {
				$count_failed++;
				$messages[] = "Watch: Use 'Jesus Film' or 'YouTube' ONLY on line # " . $i;
		}
		$i++;
	}

// viewer
	$inputs["viewerer"] = "off";
	$inputs["viewer"] = 0;
	$inputs["viewerText"] = '';
	if ((isset($_POST["viewerer"]) && $_POST["viewerer"] == "on") || (isset($_POST["viewer"]) && $_POST["viewer"])) {
		$inputs["viewerer"] = 'on';
		$inputs["viewer"] = 1;					// checkbox = checked
		if (isset($_POST["viewerText"]) && $_POST["viewerText"] != '') $inputs["viewerText"] = check_input($_POST["viewerText"]);
	}

// left or right
	$inputs["rtler"] = "off";
	$inputs["rtl"] = 0;
	if ((isset($_POST["rtler"]) && $_POST["rtler"] == "on") || (isset($_POST["rtl"]) && $_POST["rtl"])) {
		$inputs["rtler"] = 'on';			// checkbox = checked
		$inputs["rtl"] = 1;					// checkbox = checked
		$inputs["viewer"] = 1;				// checkbox = checked
	}

// study
	$i = 1;
	$inputs["study"] = 0;
	while (isset($_POST["txtScriptureDescription-$i"])) {
		if (check_input($_POST["txtScriptureDescription-$i"]) != "") $inputs["study"] = 1;
		if (empty($_POST["txtScriptureDescription-$i"])) {
			if ((check_input($_POST["txtScriptureURL-$i"]) != "") || (check_input($_POST["txtStatement-$i"]) != "") || (check_input($_POST["txtOthersiteDescription-$i"]) != "") || (check_input($_POST["txtOthersiteURL-$i"]) != "")) {
				$count_failed++;
				$messages[] = "Study #" . $i . " is blank.";
			}
		}
		$inputs["txtScriptureDescription-$i"] = check_input($_POST["txtScriptureDescription-$i"]);
		$inputs["txtScriptureURL-$i"] = check_input($_POST["txtScriptureURL-$i"]);
		$inputs["txtStatement-$i"] = check_input($_POST["txtStatement-$i"]);
		if ($_POST["txtTestament-".(string)$i] == 'SNT-'.$i) $inputs["SNT-$i"] = 1; else $inputs["SNT-$i"] = 0;
		if ($_POST["txtTestament-".(string)$i] == 'SOT-'.$i) $inputs["SOT-$i"] = 1; else $inputs["SOT-$i"] = 0;
		if ($_POST["txtTestament-".(string)$i] == 'SBible-'.$i) $inputs["SBible-$i"] = 1; else $inputs["SBible-$i"] = 0;
		if ($_POST["txtAlphabet-".(string)$i] == 'SStandAlphabet-'.$i) $inputs["SStandAlphabet-$i"] = 1; else $inputs["SStandAlphabet-$i"] = 0;
		if ($_POST["txtAlphabet-".(string)$i] == 'STradAlphabet-'.$i) $inputs["STradAlphabet-$i"] = 1; else $inputs["STradAlphabet-$i"] = 0;
		if ($_POST["txtAlphabet-".(string)$i] == 'SNewAlphabet-'.$i) $inputs["SNewAlphabet-$i"] = 1; else $inputs["SNewAlphabet-$i"] = 0;
		$inputs["txtOthersiteDescription-$i"] = check_input($_POST["txtOthersiteDescription-$i"]);
		$inputs["txtOthersiteURL-$i"] = check_input($_POST["txtOthersiteURL-$i"]);
		$i++;
	}

// other titles
	$i = 1;
	$inputs["other_titles"] = 0;
	while (isset($_POST['txtOther-'.(string)$i]) && !empty($_POST['txtOther-'.(string)$i])) {
		if (!empty($_POST['txtOther-'.(string)$i])) $inputs["other_titles"] = 1;
		if (!empty($_POST['txtOther-'.(string)$i])) {
			if (empty($_POST['txtOtherTitle-'.(string)$i])) {										// this is a "Summary" and not an actual "Title"!
				$count_failed++;
				$messages[] = 'Brief Summary #' . $i . ' is blank.';
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
		$inputs["txtOther-$i"] = check_input($_POST["txtOther-$i"]);
		$inputs["txtOtherTitle-$i"] = check_input($_POST["txtOtherTitle-$i"]);
		$inputs["txtOtherPDF-$i"] = check_input($_POST["txtOtherPDF-$i"]);
		$inputs["txtOtherAudio-$i"] = check_input($_POST["txtOtherAudio-$i"]);
		$inputs["txtDownload_video-$i"] = check_input($_POST["txtDownload_video-$i"]);
		$i++;
	}

// buy (buy table)
	$i = 1;
	$inputs["buy"] = 0;
	while (isset($_POST["txtBuyWebSource-$i"])) {
		if (check_input($_POST["txtBuyWebSource-$i"]) != "") $inputs["buy"] = 1;
		if (empty($_POST["txtBuyWebSource-$i"])) {
			if ((check_input($_POST["txtBuyResource-$i"]) != "") || (check_input($_POST["txtBuyURL-$i"]) != "")) {
				$count_failed++;
				$messages[] = "Buy #" . $i . " is blank.";
			}
		}
		$inputs["txtBuyWebSource-$i"] = check_input($_POST["txtBuyWebSource-$i"]);
		$inputs["txtBuyResource-$i"] = check_input($_POST["txtBuyResource-$i"]);
		$inputs["txtBuyURL-$i"] = check_input($_POST["txtBuyURL-$i"]);
		$i++;
	}

// links: buy
	//$inputs["links"] = 0;
	$inputs['linksBuy'] = 0;
	$i = 1;
	for (; isset($_POST["txtLinkCompany-$i"]); $i++) {
		if ($_POST["linksIcon-".(string)$i] != 'linksBuy-'.$i) continue;
		if (check_input($_POST["txtLinkCompany-$i"]) != "") $inputs["links"] = 1;
		if (empty($_POST["txtLinkCompany-$i"])) {
			if ((check_input($_POST["txtLinkCompanyTitle-$i"]) != "") || (check_input($_POST["txtLinkURL-$i"]) != "")) {
				$count_failed++;
				$messages[] = "Buy Link #" . $i . " is blank.";
			}
		}
		$inputs["txtLinkCompany-$i"] = check_input($_POST["txtLinkCompany-$i"]);
		$inputs["txtLinkCompanyTitle-$i"] = check_input($_POST["txtLinkCompanyTitle-$i"]);
		$inputs["txtLinkURL-$i"] = check_input($_POST["txtLinkURL-$i"]);
		$inputs["linksBuy-$i"] = 1;
		$inputs['linksBuy'] = 1;
		//if ($_POST["linksIcon-".(string)$i] == 'linksOther-'.$i) $inputs["linksOther-$i"] = 1; else $inputs["linksOther-$i"] = 0;
		//if ($_POST["linksIcon-".(string)$i] == 'linksBuy-'.$i) $inputs["linksBuy-$i"] = 1; else $inputs["linksBuy-$i"] = 0;
		//if ($_POST["linksIcon-".(string)$i] == 'linksMap-'.$i) $inputs["linksMap-$i"] = 1; else $inputs["linksMap-$i"] = 0;
		//if ($_POST["linksIcon-".(string)$i] == 'linksGooglePlay-'.$i) $inputs["linksGooglePlay-$i"] = 1; else $inputs["linksGooglePlay-$i"] = 0;
	}

// links: map
	//$inputs["links"] = 0;
	$inputs['linksMap'] = 0;
	$i = 1;
	for (; isset($_POST["txtLinkCompany-$i"]); $i++) {
		if ($_POST["linksIcon-".(string)$i] != 'linksMap-'.$i) continue;
		if (check_input($_POST["txtLinkCompany-$i"]) != "") $inputs["links"] = 1;
		if (empty($_POST["txtLinkCompany-$i"])) {
			if ((check_input($_POST["txtLinkCompanyTitle-$i"]) != "") || (check_input($_POST["txtLinkURL-$i"]) != "")) {
				$count_failed++;
				$messages[] = "Map Link #" . $i . " is blank.";
			}
		}
		$inputs["txtLinkCompany-$i"] = check_input($_POST["txtLinkCompany-$i"]);
		$inputs["txtLinkCompanyTitle-$i"] = check_input($_POST["txtLinkCompanyTitle-$i"]);
		$inputs["txtLinkURL-$i"] = check_input($_POST["txtLinkURL-$i"]);
		$inputs["linksMap-$i"] = 1;
		$inputs['linksMap'] = 1;
		//if ($_POST["linksIcon-".(string)$i] == 'linksOther-'.$i) $inputs["linksOther-$i"] = 1; else $inputs["linksOther-$i"] = 0;
		//if ($_POST["linksIcon-".(string)$i] == 'linksBuy-'.$i) $inputs["linksBuy-$i"] = 1; else $inputs["linksBuy-$i"] = 0;
		//if ($_POST["linksIcon-".(string)$i] == 'linksMap-'.$i) $inputs["linksMap-$i"] = 1; else $inputs["linksMap-$i"] = 0;
		//if ($_POST["linksIcon-".(string)$i] == 'linksGooglePlay-'.$i) $inputs["linksGooglePlay-$i"] = 1; else $inputs["linksGooglePlay-$i"] = 0;
	}

// links: GooglePlay
	//$inputs["links"] = 0;
	$inputs['linksGooglePlay'] = 0;
	$i = 1;
	for (; isset($_POST["txtLinkCompany-$i"]); $i++) {
		if ($_POST["linksIcon-".(string)$i] != 'linksGooglePlay-'.$i) continue;
		if (check_input($_POST["txtLinkCompany-$i"]) != "") $inputs["links"] = 1;
		if (empty($_POST["txtLinkCompany-$i"])) {
			if ((check_input($_POST["txtLinkCompanyTitle-$i"]) != "") || (check_input($_POST["txtLinkURL-$i"]) != "")) {
				$count_failed++;
				$messages[] = "Google Play Link #" . $i . " is blank.";
			}
		}
		$inputs["txtLinkCompany-$i"] = check_input($_POST["txtLinkCompany-$i"]);
		$inputs["txtLinkCompanyTitle-$i"] = check_input($_POST["txtLinkCompanyTitle-$i"]);
		$inputs["txtLinkURL-$i"] = check_input($_POST["txtLinkURL-$i"]);
		$inputs["linksGooglePlay-$i"] = 1;
		$inputs['linksGooglePlay'] = 1;
		//if ($_POST["linksIcon-".(string)$i] == 'linksOther-'.$i) $inputs["linksOther-$i"] = 1; else $inputs["linksOther-$i"] = 0;
		//if ($_POST["linksIcon-".(string)$i] == 'linksBuy-'.$i) $inputs["linksBuy-$i"] = 1; else $inputs["linksBuy-$i"] = 0;
		//if ($_POST["linksIcon-".(string)$i] == 'linksMap-'.$i) $inputs["linksMap-$i"] = 1; else $inputs["linksMap-$i"] = 0;
		//if ($_POST["linksIcon-".(string)$i] == 'linksGooglePlay-'.$i) $inputs["linksGooglePlay-$i"] = 1; else $inputs["linksGooglePlay-$i"] = 0;
	}

// links: other
	//$inputs["links"] = 0;
	$inputs['linksOther'] = 0;
	$i = 1;
	for (; isset($_POST["txtLinkCompany-$i"]); $i++) {
		if ($_POST["linksIcon-".(string)$i] != 'linksOther-'.$i) continue;
		if (check_input($_POST["txtLinkCompany-$i"]) != "") $inputs["links"] = 1;
		if (empty($_POST["txtLinkCompany-$i"])) {
			if ((check_input($_POST["txtLinkCompanyTitle-$i"]) != "") || (check_input($_POST["txtLinkURL-$i"]) != "")) {
				$count_failed++;
				$messages[] = "Other Link #" . $i . " is blank.";
			}
		}
		$inputs["txtLinkCompany-$i"] = check_input($_POST["txtLinkCompany-$i"]);
		$inputs["txtLinkCompanyTitle-$i"] = check_input($_POST["txtLinkCompanyTitle-$i"]);
		$inputs["txtLinkURL-$i"] = check_input($_POST["txtLinkURL-$i"]);
		$inputs["linksOther-$i"] = 1;
		$inputs['linksOther'] = 1;
		//if ($_POST["linksIcon-".(string)$i] == 'linksOther-'.$i) $inputs["linksOther-$i"] = 1; else $inputs["linksOther-$i"] = 0;
		//if ($_POST["linksIcon-".(string)$i] == 'linksBuy-'.$i) $inputs["linksBuy-$i"] = 1; else $inputs["linksBuy-$i"] = 0;
		//if ($_POST["linksIcon-".(string)$i] == 'linksMap-'.$i) $inputs["linksMap-$i"] = 1; else $inputs["linksMap-$i"] = 0;
		//if ($_POST["linksIcon-".(string)$i] == 'linksGooglePlay-'.$i) $inputs["linksGooglePlay-$i"] = 1; else $inputs["linksGooglePlay-$i"] = 0;
	}

// links: email
	$i = 1;
	$inputs["email"] = 0;
	while (isset($_POST['txtEmailTitle-'.(string)$i]) || isset($_POST['txtEmailAddress-'.(string)$i])) {
		if (check_input($_POST["txtEmailAddress-$i"]) != "") $inputs["email"] = 1;
		if (empty($_POST["txtEmailAddress-$i"])) {
			if ((check_input($_POST["txtEmailTitle-$i"]) != "") || (check_input($_POST["txtEmailAddress-$i"]) != "")) {
				$count_failed++;
				$messages[] = "Email $i is blank.";
			}
		}
		$inputs["txtEmailTitle-$i"] = check_input($_POST["txtEmailTitle-$i"]);
		$inputs["txtEmailAddress-$i"] = check_input($_POST["txtEmailAddress-$i"]);
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
				$messages[] = "Audio Playlist #" . $i . " is blank.";
			}
		}
		$inputs["txtPlaylistAudioTitle-$i"] = check_input($_POST["txtPlaylistAudioTitle-$i"]);
		$inputs["txtPlaylistAudioFilename-$i"] = check_input($_POST["txtPlaylistAudioFilename-$i"]);
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
				$messages[] = "View Video or Download Video Playlist #" . $i . " is blank.";
			}
		}
		$inputs["txtPlaylistVideoTitle-$i"] = check_input($_POST["txtPlaylistVideoTitle-$i"]);
		$inputs["txtPlaylistVideoFilename-$i"] = check_input($_POST["txtPlaylistVideoFilename-$i"]);
		if ($_POST["PlaylistVideoDownloadIcon-".(string)$i] == 'PlaylistVideoView-'.$i) $inputs["PlaylistVideoView-$i"] = 1; else $inputs["PlaylistVideoView-$i"] = 0;
		if ($_POST["PlaylistVideoDownloadIcon-".(string)$i] == 'PlaylistVideoDownload-'.$i) $inputs["PlaylistVideoDownload-$i"] = 1; else $inputs["PlaylistVideoDownload-$i"] = 0;
		$i++;
	}

// eBible
	$inputs["eBibleer"] = "off";
	$inputs["eBible"] = 0;
	if ((isset($_POST["eBibleer"]) && $_POST["eBibleer"] == "on") || (isset($_POST["eBible"]) && $_POST["eBible"])) {
		$inputs["eBibleer"] = 'on';			// checkbox = checked
		$inputs["eBible"] = 1;				// checkbox = checked
	}

// SIL link
	$inputs["SILlinker"] = "off";
	$inputs["SILlink"] = 0;
	if ((isset($_POST["SILlinker"]) && $_POST["SILlinker"] == "on") || (isset($_POST["SILlink"]) && $_POST["SILlink"])) {
		$inputs["SILlinker"] = 'on';		// checkbox = checked
		$inputs["SILlink"] = 1;				// checkbox = checked
	}

	// If there are no failures, the inputs passed validation
	if ($count_failed == 0) {
		require_once 'SubmitEditConfirm.php';
		// If exit was not here, the form page would be appended to the confirmation page.
		exit;
	}

	// The form page (right where Scripture_Edit.php called Edit_Lang_Validation.php) will continue to be processed now because the validation failed.
?>