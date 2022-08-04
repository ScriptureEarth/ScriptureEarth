<?php
/*
	*********************************************************************************************
		Get the major language name to display in the middle of the windows eventually.
	*********************************************************************************************
*/
// Created by Scott Starker
// Updated by Scott Starker, Lærke Roager

if (!isset($MajorLanguage)) die('1) Hacked!');
if (!isset($row["$MajorLanguage"])) {
//echo 'ZZZZZZ<br />';
	$query="SELECT $MajorLanguage, Def_LN FROM nav_ln WHERE ISO_ROD_index = '$ISO_ROD_index'";
	$result_temp=$db->query($query);
	if ($result_temp->num_rows > 0) {
		$row_temp=$result_temp->fetch_assoc();
		$ML=$row_temp["$MajorLanguage"];			// $ML = boolean
		$def_LN=$row_temp['Def_LN'];				// default langauge (a 2 digit number for the national langauge)
	}
	else {
		die('2) Hacked!');
	}
}
else {
	$ML=$row["$MajorLanguage"];						// $ML = boolean
	$def_LN=$row['Def_LN'];							// default langauge (a 2 digit number for the national langauge)
//	echo "<br /><br />& ". $MajorLanguage.'&   &'. $ML . ' & ' . $row["$MajorLanguage"] . ' & & '. $row['Def_LN']." <br /><br />";
}
//echo "<br /><br />% ". $MajorLanguage.'%   %'. $ML . "%<br /><br />";
if (!$ML) {											// if the country doesn't exist then the major default langauge name
//	Why is this????
	if (session_status() === PHP_SESSION_NONE) {
	session_start();
	}
//	print_r($_SESSION['nav_ln_array']);
//	echo '<br />';
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
//echo '<br /><br />SELECT<br /><br />';
//echo "<br /><br />% ". $MajorLanguage.'%   % ISO_ROD_index: '. $ISO_ROD_index . "%<br /><br />";
	$query="SELECT $MajorLanguage FROM $MajorLanguage WHERE ISO_ROD_index = '$ISO_ROD_index'";
	$result_LN=$db->query($query);
	//echo $ISO . "<br />";
	if ($result_LN->num_rows > 0) {
		$row_temp=$result_LN->fetch_assoc();
		$LN=$row_temp["$MajorLanguage"];
	}
	else {
		die('3) Hacked!');
	}
}
?>