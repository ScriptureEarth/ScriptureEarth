<?php
/*
	*********************************************************************************************
		Get the major language name to display in the middle of the windows eventually.
	*********************************************************************************************
*/
// Updated by Lærke Roager

require_once './include/conn.inc.php';							// connect to the database named 'scripture'
$db = get_my_db();



if (!isset($MajorLanguage)) die('Hacked!');
$ML=$row["$MajorLanguage"];						// boolean
$def_LN=$row['Def_LN'];							// default langauge (a 2 digit number for the national langauge)
if (!$ML) {										// if the country doesn't exist then the major default langauge name	
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