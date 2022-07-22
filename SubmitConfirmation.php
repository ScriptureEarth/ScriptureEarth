<?php
	// This page cannot be accessed directly
	if ( ! (defined('RIGHT_ON') && RIGHT_ON === true)) {
		@include_once '403.php';
		exit;
	}
	 
	//define ("PATHScripture", "");
	include("OT_Books.php");
	include("NT_Books.php");
	//global $NT_array;		// from NT_Books.php
	include("conn.php");
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Submit Confirmation Insertion Page</title>
</head>
<body style="background-color: #42458c; margin: 14pt; font-family: Arial, Helvetica, sans-serif; ">
<?php
	echo "<div style='background-color: white; padding: 20px; width: 800px; margin-left: auto; margin-right: auto; '>";
	echo "<img src='images/ScriptureEarth.jpg' />";
	echo "</div></br />";
	
	echo "<div style='background-color: white; padding: 20px; width: 800px; margin-left: auto; margin-right: auto; '>";
	$query="INSERT INTO scripture_main (ISO, ISO_5digits, LN_English, LN_Spanish, LN_Portuguese, LN_French, LN_Dutch, def_LN, OT_PDF, NT_PDF, FCBH, OT_Audio, NT_Audio, links, other_titles, watch, buy, study) VALUES ('$inputs[ISO]', '$inputs[ISO_5digits]',  '$inputs[LN_EnglishBool]', '$inputs[LN_SpanishBool]', '$inputs[LN_PortugueseBool]', '$inputs[LN_FrenchBool]', '$inputs[LN_DutchBool]', '$inputs[DefLangName]', '$inputs[OT_PDF]', '$inputs[NT_PDF]', '$inputs[FCBH]', '$inputs[OT_Audio]','$inputs[NT_Audio]', '$inputs[links]', '$inputs[other_titles]', '$inputs[watch]', '$inputs[buy]', '$inputs[study]')";
	$result=mysql_query($query);
	if (!$result) {
		die('Could not insert the data in "scripture_main": ' . mysql_error());
	}

if ($inputs['LN_EnglishBool']) {
	$query="DELETE FROM LN_English WHERE ISO = '$inputs[ISO]' AND ISO_5digits = '$inputs[ISO_5digits]'";
	$result=mysql_query($query);
	$query="INSERT INTO LN_English (ISO, ISO_5digits, LN_English) VALUES ('$inputs[ISO]', '$inputs[ISO_5digits]', '$inputs[English_lang_name]')";
	$result=mysql_query($query);
	if (!$result) {
		die('Could not insert the data in "LN_English": ' . mysql_error());
	}
}

if ($inputs['LN_SpanishBool']) {
	$query="DELETE FROM LN_Spanish WHERE ISO = '$inputs[ISO]' AND ISO_5digits = '$inputs[ISO_5digits]'";
	$result=mysql_query($query);
	$query="INSERT INTO LN_Spanish (ISO, ISO_5digits, LN_Spanish) VALUES ('$inputs[ISO]', '$inputs[ISO_5digits]', '$inputs[Spanish_lang_name]')";
	$result=mysql_query($query);
	if (!$result) {
		die('Could not insert the data in "LN_Spanish": ' . mysql_error());
	}
}

if ($inputs['LN_PortugueseBool']) {
	$query="DELETE FROM LN_Portuguese WHERE ISO = '$inputs[ISO]' AND ISO_5digits = '$inputs[ISO_5digits]'";
	$result=mysql_query($query);
	$query="INSERT INTO LN_Portuguese (ISO, ISO_5digits, LN_Portuguese) VALUES ('$inputs[ISO]', '$inputs[ISO_5digits]', '$inputs[Portuguese_lang_name]')";
	$result=mysql_query($query);
	if (!$result) {
		die('Could not insert the data in "LN_Portuguese": ' . mysql_error());
	}
}

if ($inputs['LN_FrenchBool']) {
	$query="DELETE FROM LN_French WHERE ISO = '$inputs[ISO]' AND ISO_5digits = '$inputs[ISO_5digits]'";
	$result=mysql_query($query);
	$query="INSERT INTO LN_French (ISO, ISO_5digits, LN_French) VALUES ('$inputs[ISO]', '$inputs[ISO_5digits]', '$inputs[French_lang_name]')";
	$result=mysql_query($query);
	if (!$result) {
		die('Could not insert the data in "LN_French": ' . mysql_error());
	}
}

if ($inputs['LN_DutchBool']) {
	$query="DELETE FROM LN_Dutch WHERE ISO = '$inputs[ISO]' AND ISO_5digits = '$inputs[ISO_5digits]'";
	$result=mysql_query($query);
	$query="INSERT INTO LN_Dutch (ISO, ISO_5digits, LN_Dutch) VALUES ('$inputs[ISO]', '$inputs[ISO_5digits]', '$inputs[Dutch_lang_name]')";
	$result=mysql_query($query);
	if (!$result) {
		die('Could not insert the data in "LN_Dutch": ' . mysql_error());
	}
}

$i=1;
while ($i <= $inputs['ISO_countries']) {
	$temp = 'ISO_Country-'.(string)$i;
	$query="INSERT INTO ISO_countries (ISO, ISO_5digits, ISO_countries) VALUES ('$inputs[ISO]', '$inputs[ISO_5digits]', '$inputs[$temp]')";
	$result=mysql_query($query);
	if (!$result) {
		die('Could not insert the data in "ISO_countries": ' . mysql_error());
	}
	$i++;
}
	
$i = 1;
while (isset($inputs["txtAltNames-".(string)$i])) {
	$query="SELECT * FROM alt_lang_names WHERE ISO = '$inputs[ISO]' AND ISO_5digits = '$inputs[ISO_5digits]'";
	$result=mysql_query($query);
	$row = mysql_numrows($result);
	$bool_ISO = false;
	for ($j = 0; $j < $row; $j++) {
		if (mysql_result($result, $j, 'alt_lang_name') == $inputs["txtAltNames-".(string)$i]) {
			$bool_ISO = true;
			break;
		}
	}
	if (!$bool_ISO) {
		$temp = "txtAltNames-".(string)$i;
		$query="INSERT INTO alt_lang_names (ISO, ISO_5digits, alt_lang_name) VALUES ('$inputs[ISO]', '$inputs[ISO_5digits]', '$inputs[$temp]')";
		$result=mysql_query($query);
		if (!$result) {
			die('Could not insert the data "alt_lang_names": ' . mysql_error());
		}
	}
	$i++;
}

if ($inputs['OT_PDF']) {
	if ($inputs['OT_name'] != "") {
		$query="INSERT INTO OT_PDF_Media (ISO, ISO_5digits, OT_PDF, OT_PDF_Filename) VALUES ('$inputs[ISO]', '$inputs[ISO_5digits]', 'OT', '$inputs[OT_name]')";
		$result=mysql_query($query);
		if (!$result) {
			die('Could not insert the data "OT_name": ' . mysql_error());
		}
	}
	for ($i = 0; $i < 39; $i++) {
		if ($inputs["OT_PDF_Filename-".(string)$i] != "") {
			$temp1 = "OT_PDF_Book-".(string)$i;
			$temp2 = "OT_PDF_Filename-".(string)$i;
			$query="INSERT INTO OT_PDF_Media (ISO, ISO_5digits, OT_PDF, OT_PDF_Filename) VALUES ('$inputs[ISO]', '$inputs[ISO_5digits]', '$inputs[$temp1]', '$inputs[$temp2]')";
			$result=mysql_query($query);
			if (!$result) {
				die('Could not insert the data "OT_PDF_Media": ' . mysql_error());
			}
		}
	}
}

if ($inputs['NT_PDF']) {
	if ($inputs['NT_name'] != "") {
		$query="INSERT INTO pdf_media (ISO, ISO_5digits, PDF, PDF_filename) VALUES ('$inputs[ISO]', '$inputs[ISO_5digits]', 'NT', '$inputs[NT_name]')";
		$result=mysql_query($query);
		if (!$result) {
			die('Could not insert the data "NT_name": ' . mysql_error());
		}
	}
	for ($i = 0; $i < 27; $i++) {
		if ($inputs["NT_PDF_Filename-".(string)$i] != "") {
			$temp1 = "NT_PDF_Book-".(string)$i;
			$temp2 = "NT_PDF_Filename-".(string)$i;
			$query="INSERT INTO pdf_media (ISO, ISO_5digits, PDF, PDF_filename) VALUES ('$inputs[ISO]', '$inputs[ISO_5digits]', '$inputs[$temp1]', '$inputs[$temp2]')";
			$result=mysql_query($query);
			if (!$result) {
				die('Could not insert the data "pdf_media": ' . mysql_error());
			}
		}
	}
}

if ($inputs['OT_Audio']) {
	for ($i = 0; $i < 39; $i++) {
		$item2_from_array = $OT_array[1][$i];		// how many chapers in each book
		for ($z = 0; $z < $item2_from_array; $z++) {
			if ($inputs["OT_Audio_Filename-".(string)$i . "-" . (string)$z] != "") {
				$y = $z + 1;
				$temp1 = "OT_Audio_Book-".(string)$i;
				$temp2 = "OT_Audio_Filename-".(string)$i . "-" . (string)$z;
				$temp3 = "OT_Audio_Chapter-".(string)$i . "-" . (string)$z;
				$query="INSERT INTO OT_Audio_Media (ISO, ISO_5digits, OT_Audio_Book, OT_Audio_Filename, OT_Audio_Chapter) VALUES ('$inputs[ISO]', '$inputs[ISO_5digits]', '$inputs[$temp1]', '$inputs[$temp2]', '$inputs[$temp3]')";
				$result=mysql_query($query);
				if (!$result) {
					die('Could not insert the data "OT_Audio_Media": ' . mysql_error());
				}
			}
		}
	}
}

if ($inputs['NT_Audio']) {
	for ($i = 0; $i < 27; $i++) {
		$item2_from_array = $NT_array[1][$i];		// how many chapers in each book
		for ($z = 0; $z < $item2_from_array; $z++) {
			if ($inputs["NT_Audio_Filename-".(string)$i . "-" . (string)$z] != "") {
				$y = $z + 1;
				$temp1 = "NT_Audio_Book-".(string)$i;
				$temp2 = "NT_Audio_Filename-".(string)$i . "-" . (string)$z;
				$temp3 = "NT_Audio_Chapter-".(string)$i . "-" . (string)$z;
				$query="INSERT INTO audio_media (ISO, ISO_5digits, audio_book, audio_filename, audio_chapter) VALUES ('$inputs[ISO]', '$inputs[ISO_5digits]', '$inputs[$temp1]', '$inputs[$temp2]', '$inputs[$temp3]')";
				$result=mysql_query($query);
				if (!$result) {
					die('Could not insert the data "audio_media": ' . mysql_error());
				}
			}
		}
	}
}

if ($inputs['watch']) {
	$i = 1;
	while (isset($inputs["txtWatchWebSource-".(string)$i])) {
		$temp1 = "txtWatchWebSource-".(string)$i;
		$temp2 = "txtWatchResource-".(string)$i;
		$temp3 = "txtWatchURL-".(string)$i;
		$query="INSERT INTO watch (ISO, ISO_5digits, organization, watch_what, URL) VALUES ('$inputs[ISO]', '$inputs[ISO_5digits]', '$inputs[$temp1]', '$inputs[$temp2]', '$inputs[$temp3]')";
		$result=mysql_query($query);
		if (!$result) {
			die('Could not insert the data "watch": ' . mysql_error());
		}
		$i++;
	}
}

if ($inputs['buy']) {
	$i = 1;
	while (isset($inputs["txtBuyWebSource-".(string)$i])) {
		$temp1 = "txtBuyWebSource-".(string)$i;
		$temp2 = "txtBuyResource-".(string)$i;
		$temp3 = "txtBuyURL-".(string)$i;
		$query="INSERT INTO buy (ISO, ISO_5digits, organization, buy_what, URL) VALUES ('$inputs[ISO]', '$inputs[ISO_5digits]', '$inputs[$temp1]', '$inputs[$temp2]', '$inputs[$temp3]')";
		$result=mysql_query($query);
		if (!$result) {
			die('Could not insert the data "buy": ' . mysql_error());
		}
		$i++;
	}
}

if ($inputs['study']) {
	$i = 1;
	while (isset($inputs["txtScriptureDescription-".(string)$i])) {
		$temp1 = "txtScriptureDescription-".(string)$i;
		$temp2 = "txtScriptureURL-".(string)$i;
		$temp3 = "txtStatement-".(string)$i;
		$temp4 = "txtOthersiteDescription-".(string)$i;
		$temp5 = "txtOthersiteURL-".(string)$i;
		$query="INSERT INTO study (ISO, ISO_5digits, ScriptureDescription, ScriptureURL, statement, othersiteDescription, othersiteURL) VALUES ('$inputs[ISO]', '$inputs[ISO_5digits]', '$inputs[$temp1]', '$inputs[$temp2]', '$inputs[$temp3]', '$inputs[$temp4]', '$inputs[$temp5]')";
		$result=mysql_query($query);
		if (!$result) {
			die('Could not update the data "study": ' . mysql_error());
		}
		$i++;
	}
}

if ($inputs['other_titles']) {
	$i = 1;
	while (isset($inputs["txtOther-".(string)$i])) {
		$temp1 = "txtOther-".(string)$i;
		$temp2 = "txtOtherTitle-".(string)$i;
		$temp3 = "txtOtherPDF-".(string)$i;
		$temp4 = "txtOtherAudio-".(string)$i;
		$query="INSERT INTO other_titles (ISO, ISO_5digits, other, other_title, other_PDF, other_audio) VALUES ('$inputs[ISO]', '$inputs[ISO_5digits]', '$inputs[$temp1]', '$inputs[$temp2]', '$inputs[$temp3]', '$inputs[$temp4]')";
		$result=mysql_query($query);
		if (!$result) {
			die('Could not insert the data "other-titles": ' . mysql_error());
		}
		$i++;
	}
}

if ($inputs['links']) {
	$i = 1;
	while (isset($inputs["txtLinkCompany-".(string)$i])) {
		$temp1 = "txtLinkCompany-".(string)$i;
		$temp2 = "txtLinkCompanyTitle-".(string)$i;
		$temp3 = "txtLinkURL-".(string)$i;
		$query="INSERT INTO links (ISO, ISO_5digits, company, company_title, URL) VALUES ('$inputs[ISO]', '$inputs[ISO_5digits]', '$inputs[$temp1]', '$inputs[$temp2]', '$inputs[$temp3]')";
		$result=mysql_query($query);
		if (!$result) {
			die('Could not insert the data "links": ' . mysql_error());
		}
		$i++;
	}
}

	echo "<h1 style='text-align: center; '>You successfully completed<br />";
    /*
     * It is safe to echo $_POST['txtName'] here because
     * it has (supposedly) passed validation, but it is
     * better to use the sanitized $inputs array.
     */
	echo "'".$inputs['ISO']."' '".$inputs['ISO_5digits']."'!";
	echo "</h1>";
	echo "<form>";
	echo "<INPUT TYPE='reset' VALUE='Go back to Add script' OnClick='parent.location=\"Scripture_Add.php\"' />";
	echo "</form>";	
	echo "</div>";
	echo "<br />";
	echo "<div style='text-align: center; background-color: #333333; margin: 0px auto 0px auto; padding: 20px; width: 800px; '>";
	echo "<img src='images/top_wbtc_logo.gif' />";
	echo "<br /><br /><div class='nav' style='font-weight: normal; color: white; font-size: 10pt; '><sup>©</sup>2009 - ".date('Y')." <a href='https://www.wycliffe.ca'>Wycliffe Bible Translators of Canada</a> Inc.</div>";
	echo "</div>";
	unset($inputs);    // This deletes the whole array
	mysql_close();
?>
</body>
</html>