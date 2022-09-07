<?php
/*
	*********************************************************************************************
		Get the major language name to display in the middle of the windows eventually.
		called from php and AJAX!
		
		00-MainScript.inc.php
		Scripture_Edit.php
	*********************************************************************************************
*/
// Created by Scott Starker
// Updated by Scott Starker, Lærke Roager

if (!isset($MajorLanguage)) die('1a) Hacked!');
if (!isset($ISO_ROD_index)) die('1b) Hacked!');
if (preg_match('/^[0-9]+$/', $ISO_ROD_index)) {
}
else {
	die('1c) Hacked!');
}

if (!isset($row["$MajorLanguage"])) {				// is $row["$MajorLanguage"] NOT set
	$query="SELECT $MajorLanguage, Def_LN FROM nav_ln WHERE ISO_ROD_index = '$ISO_ROD_index'";
	$result_temp=$db->query($query);
	if ($result_temp->num_rows > 0) {
		$row_temp=$result_temp->fetch_assoc();
		$ML=$row_temp["$MajorLanguage"];			// $ML = boolean
		$def_LN=$row_temp['Def_LN'];				// default langauge (a number that points to the national langauge name)
	}
	else {
		die('2) Hacked!');
	}
}
else {
	$ML=$row["$MajorLanguage"];						// $ML = boolean
	$def_LN=$row['Def_LN'];							// default langauge (a number that points to the national langauge name)
}

if (!$ML) {									// if the national langauge name is 0 then the default langauge name is used
	$ML = $def_LN;
	if (isset($_SESSION['nav_ln_array']) || !empty($_SESSION['nav_ln_array'])) {		// from PHP
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}
		foreach ($_SESSION['nav_ln_array'] as $code => $array){
			if ($array[3] == $def_LN){
				$query="SELECT LN_".$array[1]." FROM LN_".$array[1]." WHERE ISO_ROD_index = '$ISO_ROD_index'";
				$result_LN=$db->query($query);
				if ($result_LN->num_rows > 0){
					$row_temp=$result_LN->fetch_assoc();
					$LN=$row_temp['LN_'.$array[1]];
				}
				break;
			}
		}
	}
	else {
		$temp_ln = explode(', ', $ln_result);		// from AJAX
		foreach ($temp_ln as $code => $array){
			if ($code+1 == $def_LN){
				$query="SELECT ".$array." FROM ".$array." WHERE ISO_ROD_index = '$ISO_ROD_index'";
				$result_LN=$db->query($query);
				if ($result_LN->num_rows > 0){
					$row_temp=$result_LN->fetch_assoc();
					$LN=$row_temp[$array];
				}
				break;
			}
			break;
		}
	}
}
else {												// points directly to $MajorLanguage
	$query="SELECT `$MajorLanguage` FROM `$MajorLanguage` WHERE ISO_ROD_index = '$ISO_ROD_index'";
	$result_LN=$db->query($query) or die('Error querying database.');
	if (!$result_LN) {
		echo 'Query to show fields from table failed!<br />';
	}	
	if ($row_temp=$result_LN->fetch_assoc()) {
		$LN=$row_temp["$MajorLanguage"];
	}
	else {
		echo ("Error: $MajorLanguage; ISO ROD index: $ISO_ROD_index. Is there any national language name tables entry??<br />");
	}
}
?>