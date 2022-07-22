<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" 			content="text/html; charset=utf-8" />
<meta name="ObjectType" 					content="Document" />
<meta http-equiv="Window-target" 			content="_top" />
<meta name="Created-by" 					content="Scott Starker" />
<meta name="Maintained-by" 					content="Website" />
<title>Move ISO code and ROD code from old ISO code and ROD code</title>
</head>
<body style="font-family: Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 1.2.em; ">
<?php

/***********************************************************
	- Must run COPY.regular.TO.temp.php first!
	- The following 5 variables need to be assigned!!
************************************************************/

$ISO_from='ixl';
$ROD_Code_from='00000';
$Variant_Code_from='';															// needs to be '' if Variant_Code_from is NULL
$ISO_to=$ISO_from;				// Has to be the same ISO code as the first one!
$ROD_Code_to='04781';
$Variant_Code_to='';															// needs to be '' if Variant_Code_to is NULL

define ('PATHScripture', './');
include PATHScripture . 'include/conn.inc.php';									// connect to the database named 'scripture'
$db = get_my_db();

set_time_limit(0);																// set the Maximum execution time to infinity

/*
scripture_main:
	LN_English, LN_Spanish, LN_Portuguese, LN_French, LN_Dutch, Def_LN, OT_PDF, NT_PDF, FCBH, OT_Audio, NT_Audio, links, other_titles, watch, buy, study, viewer, CellPhone, AddNo, AddTheBibleIn, AddTheScriptureIn, BibleIs, YouVersion, Bibles_org, PlaylistAudio, PlaylistVideo, SAB, eBible

UPDATE only:
alt_lang_names
buy
eBible_list
links
LN_English
LN_Spanish
LN_Portuguese
LN_French
LN_Dutch
watch

SELECT and UPDATE:
CellPhone
NT_Audio_Media
NT_PDF_Media
OT_Audio_Media
OT_PDF_Media
other_titles
PlaylistAudio
PlaylistVideo
Scripture_and_or_Bible
SAB
study
viewer

*/

echo '<h2>Start...</h2>';


$query = "SELECT ISO_ROD_index FROM scripture_main WHERE ISO = '$ISO_to' AND ROD_Code = '$ROD_Code_to'";			// find ISO_ROD_index for scripture_main
$result_from=$db->query($query) or die ('Query failed: ' . $db->error . "</body></html>");
$num_from=$result_from->num_rows;
if ($num_from > 0) {
	echo 'Already has ROD code: ' . $ROD_Code_to . ' in scripture_main!<br /></body></html>';
	return;
}


if ($Variant_Code_from == '') {
	$query = "SELECT ISO_ROD_index, viewer FROM scripture_main WHERE ISO = '$ISO_from' AND ROD_Code = '$ROD_Code_from' AND (Variant_Code IS NULL OR Variant_Code = '')";	// find ISO_ROD_index for scripture_main
}
else {
	$query = "SELECT ISO_ROD_index, viewer FROM scripture_main WHERE ISO = '$ISO_from' AND ROD_Code = '$ROD_Code_from' AND Variant_Code = '$Variant_Code_from'";			// find ISO_ROD_index for scripture_main
}
$result_from=$db->query($query) or die ('Query failed: ' . $db->error . "</body></html>");
$num_from=$result_from->num_rows;
if ($num_from <= 0) {
	echo 'FROM: There are no scripture_main for ISO: ' . $ISO_from . ' ROD code: ' . $ROD_Code_from . '<br /></body></html>';
	return;
}
$row_from = $result_from->fetch_array();
$ISO_ROD_index_from = $row_from['ISO_ROD_index'];
$viewer_from = $row_from['viewer'];


echo 'ISO_from: ' . $ISO_from . ' ROD_Code_from: ' . $ROD_Code_from . ($Variant_Code_from == '' ? '' : ' Variant_Code_from: ' . $Variant_Code_from) . ' ISO_ROD_index_from: ' . $ISO_ROD_index_from . '<br />';
echo 'ISO_to: ' . $ISO_to . ' ROD_Code_to: ' . $ROD_Code_to . ($Variant_Code_to == '' ? '' : ' Variant_Code_to: ' . $Variant_Code_to) . '<br /><br />';


$db->query("UPDATE alt_lang_names ISO = '$ISO_to', ROD_Code = '$ROD_Code_to' WHERE ISO_ROD_index = $ISO_ROD_index_from");		// Add ISO_ROD_index_to
$db->query("UPDATE buy SET ISO = '$ISO_to', ROD_Code = '$ROD_Code_to' WHERE ISO_ROD_index = $ISO_ROD_index_from");					// Add ISO_ROD_index_to
$db->query("UPDATE links SET ISO = '$ISO_to', ROD_Code = '$ROD_Code_to' WHERE ISO_ROD_index = $ISO_ROD_index_from");					// Add ISO_ROD_index_to
$db->query("UPDATE LN_English SET ISO = '$ISO_to', ROD_Code = '$ROD_Code_to' WHERE ISO_ROD_index = $ISO_ROD_index_from");			// Add ISO_ROD_index_to
$db->query("UPDATE LN_Spanish SET ISO = '$ISO_to', ROD_Code = '$ROD_Code_to' WHERE ISO_ROD_index = $ISO_ROD_index_from");			// Add ISO_ROD_index_to
$db->query("UPDATE LN_Portuguese SET ISO = '$ISO_to', ROD_Code = '$ROD_Code_to' WHERE ISO_ROD_index = $ISO_ROD_index_from");			// Add ISO_ROD_index_to
$db->query("UPDATE LN_French SET ISO = '$ISO_to', ROD_Code = '$ROD_Code_to' WHERE ISO_ROD_index = $ISO_ROD_index_from");				// Add ISO_ROD_index_to
$db->query("UPDATE LN_Dutch SET ISO = '$ISO_to', ROD_Code = '$ROD_Code_to' WHERE ISO_ROD_index = $ISO_ROD_index_from");				// Add ISO_ROD_index_to
$db->query("UPDATE eBible_list SET ISO = '$ISO_to', ROD_Code = '$ROD_Code_to' WHERE ISO_ROD_index = $ISO_ROD_index_from");			// Add ISO_ROD_index_to
$db->query("UPDATE watch SET ISO = '$ISO_to', ROD_Code = '$ROD_Code_to' WHERE ISO_ROD_index = $ISO_ROD_index_from");					// Add ISO_ROD_index_to


// CellPhone
$query="SELECT ISO, ROD_Code FROM CellPhone WHERE ISO_ROD_index = $ISO_ROD_index_from";
$result_temp = $db->query($query);
if ($result_temp->num_rows) {
	$db->query("UPDATE CellPhone SET ISO = '$ISO_to', ROD_Code = '$ROD_Code_to', Variant_Code = IF(Variant_Code IS NULL, NULL, '$Variant_Code_to') WHERE ISO_ROD_index = $ISO_ROD_index_from");		// Add ISO_ROD_index_to
	echo "<span style='color: red; font-weight: bold; '>Moved " . $ROD_Code_from . "/study/ to " . $ROD_Code_to . "/study/ in the CellPhone table.</span><br />";
}

// NT_Audio_Media
$query="SELECT ISO, ROD_Code FROM NT_Audio_Media WHERE ISO_ROD_index = $ISO_ROD_index_from";
$result_temp = $db->query($query);
if ($result_temp->num_rows) {
	$db->query("UPDATE NT_Audio_Media SET ISO = '$ISO_to', ROD_Code = '$ROD_Code_to', Variant_Code = IF(Variant_Code IS NULL, NULL, '$Variant_Code_to') WHERE ISO_ROD_index = $ISO_ROD_index_from");		// Add ISO_ROD_index_to
	echo "<span style='color: red; font-weight: bold; '>Moved all of " . $ROD_Code_from . "/audio/ to " . $ROD_Code_to . "/audio/ in the NT_Audio_Media table.</span><br />";
}

// NT_PDF_Media
$query="SELECT ISO, ROD_Code FROM NT_PDF_Media WHERE ISO_ROD_index = $ISO_ROD_index_from";
$result_temp = $db->query($query);
if ($result_temp->num_rows) {
	$db->query("UPDATE NT_PDF_Media SET ISO = '$ISO_to', ROD_Code = '$ROD_Code_to', Variant_Code = IF(Variant_Code IS NULL, NULL, '$Variant_Code_to') WHERE ISO_ROD_index = $ISO_ROD_index_from");		// Add ISO_ROD_index_to
	echo "<span style='color: red; font-weight: bold; '>Moved all of " . $ROD_Code_from . "/PDF/ to " . $ROD_Code_to . "/PDF/ in the NT_PDF_Media table.</span><br />";
}

// OT_Audio_Media
$query="SELECT ISO, ROD_Code FROM OT_Audio_Media WHERE ISO_ROD_index = $ISO_ROD_index_from";
$result_temp = $db->query($query);
if ($result_temp->num_rows) {
	$db->query("UPDATE OT_Audio_Media SET ISO = '$ISO_to', ROD_Code = '$ROD_Code_to', Variant_Code = IF(Variant_Code IS NULL, NULL, '$Variant_Code_to') WHERE ISO_ROD_index = $ISO_ROD_index_from");		// Add ISO_ROD_index_to
	echo "<span style='color: red; font-weight: bold; '>Moved all of " . $ROD_Code_from . "/audio/ to " . $ROD_Code_to . "/audio/ in the OT_Audio_Media table.</span><br />";
}

// OT_PDF_Media
$query="SELECT ISO, ROD_Code FROM OT_PDF_Media WHERE ISO_ROD_index = $ISO_ROD_index_from";
$result_temp = $db->query($query);
if ($result_temp->num_rows) {
	$db->query("UPDATE OT_PDF_Media SET ISO = '$ISO_to', ROD_Code = '$ROD_Code_to', Variant_Code = IF(Variant_Code IS NULL, NULL, '$Variant_Code_to') WHERE ISO_ROD_index = $ISO_ROD_index_from");		// Add ISO_ROD_index_to
	echo "<span style='color: red; font-weight: bold; '>Moved all of " . $ROD_Code_from . "/PDF/ to " . $ROD_Code_to . "/PDF/ in the OT_PDF_Media table.</span><br />";
}

// other_titles
//$query="SELECT ISO, ROD_Code FROM other_titles WHERE ISO_ROD_index = $ISO_ROD_index_from";
//$result_temp = $db->query($query);
//if ($result_temp->num_rows) {
//	$db->query("UPDATE other_titles SET ISO = '$ISO_to', ROD_Code = '$ROD_Code_to', Variant_Code = IF(Variant_Code IS NULL, NULL, '$Variant_Code_to') WHERE ISO_ROD_index = $ISO_ROD_index_from");		// Add ISO_ROD_index_to
//	echo "<span style='color: red; font-weight: bold; '>Moved " . $ROD_Code_from . "/audio/ or /PDF/ and to " . $ROD_Code_to . "/audio/ or /PDF/ in the other_titles table.</span><br />";
//}

// PlaylistAudio
//$query="SELECT ISO, ROD_Code FROM PlaylistAudio WHERE ISO_ROD_index = $ISO_ROD_index_from";
//$result_temp = $db->query($query);
//if ($result_temp->num_rows) {
//	$db->query("UPDATE PlaylistAudio SET ISO = '$ISO_to', ROD_Code = '$ROD_Code_to', Variant_Code = IF(Variant_Code IS NULL, NULL, '$Variant_Code_to') WHERE ISO_ROD_index = $ISO_ROD_index_from");		// Add ISO_ROD_index_to
//	echo "<span style='color: red; font-weight: bold; '>Moved " . $ROD_Code_from . "/audio/ to " . $ROD_Code_to . "/audio/ in the PlaylistAudio table.</span><br />";
//}

// PlaylistVideo
$query="SELECT ISO, ROD_Code FROM PlaylistVideo WHERE ISO_ROD_index = $ISO_ROD_index_from";
$result_temp = $db->query($query);
if ($result_temp->num_rows) {
	$db->query("UPDATE PlaylistVideo SET ISO = '$ISO_to', ROD_Code = '$ROD_Code_to', Variant_Code = IF(Variant_Code IS NULL, NULL, '$Variant_Code_to') WHERE ISO_ROD_index = $ISO_ROD_index_from");		// Add ISO_ROD_index_to
	echo "<span style='color: red; font-weight: bold; '>Moved " . $ROD_Code_from . "/video/ to " . $ROD_Code_to . "/video/ in the PlaylistVideo table.</span><br />";
}

// Scripture_and_or_Bible
//$query="SELECT ISO, ROD_Code FROM Scripture_and_or_Bible WHERE ISO_ROD_index = $ISO_ROD_index_from";
//$result_temp = $db->query($query);
//if ($result_temp->num_rows) {
//	$db->query("UPDATE Scripture_and_or_Bible SET ISO = '$ISO_to', ROD_Code = '$ROD_Code_to', Variant_Code = IF(Variant_Code IS NULL, NULL, '$Variant_Code_to') WHERE ISO_ROD_index = $ISO_ROD_index_from");		// Add ISO_ROD_index_to
//	echo "<span style='color: red; font-weight: bold; '>Moved " . $ROD_Code_from . "/PDF/ " . $ROD_Code_to . "/PDF/ in the Scripture_and_or_Bible table.</span><br />";
//}

// SAB
$query="SELECT ISO, ROD_Code FROM SAB WHERE ISO_ROD_index = $ISO_ROD_index_from";
$result_temp = $db->query($query);
if ($result_temp->num_rows) {
	$db->query("UPDATE SAB SET ISO = '$ISO_to', ROD_Code = '$ROD_Code_to', Variant_Code = IF(Variant_Code IS NULL, NULL, '$Variant_Code_to') WHERE ISO_ROD_index = $ISO_ROD_index_from");		// Add ISO_ROD_index_to
	echo "<span style='color: red; font-weight: bold; '>Moved " . $ROD_Code_from . "/SAB/ to " . $ROD_Code_to . "/SAB/ in the CellPhone table.</span><br />";
}

// study
$query="SELECT ISO, ROD_Code FROM study WHERE ISO_ROD_index = $ISO_ROD_index_from";
$result_temp = $db->query($query);
if ($result_temp->num_rows) {
	$db->query("UPDATE study SET ISO = '$ISO_to', ROD_Code = '$ROD_Code_to', Variant_Code = IF(Variant_Code IS NULL, NULL, '$Variant_Code_to') WHERE ISO_ROD_index = $ISO_ROD_index_from");		// Add ISO_ROD_index_to
	echo "<span style='color: red; font-weight: bold; '>Moved " . $ROD_Code_from . "/study/ to " . $ROD_Code_to . "/study/ in the study table.</span><br />";
}

// viewer
if ($viewer_from > 0) {
	$query="SELECT ISO, ROD_Code FROM scripture_main WHERE ISO = $ISO_to";
	$result_temp = $db->query($query);
	if ($result_temp->num_rows > 0) {
		echo "<span style='color: red; font-weight: bold; '>More than one $ISO_to in viewer table exists. You may want to insert a number/letter into viewer table with $ISO_to and $ROD_Code_to.</span><br />";
	}
	echo "<span style='color: red; font-weight: bold; '>Moved " . $ROD_Code_from . "/scripture_main/ to " . $ROD_Code_to . "/scripture_main/.</span><br />";
}
$query="SELECT ISO, ROD_Code FROM viewer WHERE ISO_ROD_index = $ISO_ROD_index_from";
$result_temp = $db->query($query);
if ($result_temp->num_rows) {
	$db->query("UPDATE viewer SET ISO = '$ISO_to', ROD_Code = '$ROD_Code_to', Variant_Code = IF(Variant_Code IS NULL, NULL, '$Variant_Code_to') WHERE ISO_ROD_index = $ISO_ROD_index_from");		// Add ISO_ROD_index_to
	echo "<span style='color: red; font-weight: bold; '>Moved " . $ROD_Code_from . "/viewer/ " . $ROD_Code_to . "/viewer/ in the viewer table.</span><br />";
}


// scripture_main
$db->query("UPDATE scripture_main SET ISO = '$ISO_to', ROD_Code = '$ROD_Code_to' WHERE ISO_ROD_index = $ISO_ROD_index_from");					// Add ISO_ROD_index_to


echo '<h2>End.</h2>';

?>
</body>
</html>