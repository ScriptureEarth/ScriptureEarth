<?php
/*
	*********************************************************************************************
		Get the major language name to display in the middle of the windows eventually.
	*********************************************************************************************
*/
// Updated by Lærke Roager

if (!isset($MajorLanguage)) die('Hacked!');
if (!isset($row["$MajorLanguage"])) {
	$query="SELECT $MajorLanguage, Def_LN FROM nav_ln WHERE ISO_ROD_index = '$ISO_ROD_index'";
	$result_temp=$db->query($query);
	if ($result_temp->num_rows > 0) {
		$row_temp=$result_temp->fetch_assoc();
		$ML=$row_temp["$MajorLanguage"];						// $ML = boolean
		$def_LN=$row_temp['Def_LN'];							// default langauge (a 2 digit number for the national langauge)
	}
	else {
		die('Hacked!');
	}
}
else {
	$ML=$row["$MajorLanguage"];						// $ML = boolean
	$def_LN=$row['Def_LN'];							// default langauge (a 2 digit number for the national langauge)
}
if (!$ML) {											// if the country doesn't exist then the major default langauge name
	foreach ($_SESSION['nav_ln_array'] as $code => $nav_ln_temp_array){
		if ($nav_ln_temp_array[3] == $def_LN){
			$query="SELECT LN_".$nav_ln_temp_array[1]." FROM LN_".$nav_ln_temp_array[1]." WHERE ISO_ROD_index = '$ISO_ROD_index'";
			$result_LN=$db->query($query);
			$row_temp=$result_LN->fetch_assoc();
			$LN=trim($row_temp['LN_'.$nav_ln_temp_array[1]]);
		}
	}
}
else {
	$query="SELECT $MajorLanguage FROM $MajorLanguage WHERE ISO_ROD_index = '$ISO_ROD_index'";
	$result_LN=$db->query($query);
	//echo $ISO . "<br />";
	if ($result_LN->num_rows > 0) {
		$row_temp=$result_LN->fetch_assoc();
		$LN=trim($row_temp["$MajorLanguage"]);
	}
	else {
		die('Hacked!');
	}
}
?>