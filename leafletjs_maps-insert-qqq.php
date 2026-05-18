<?php
/*
	copy() WILL NOT WORK! PHP 8.2.12 local computer

	This is the second script. Run this AFTER the first script (leafletjs_maps-createHTML.php) has run. 

	This script inserts [qqq] into leafletjs map builder based on the country(ies) code.
	
	leafletjs_maps-qqq.tsv contians: ISO, ROD_Code, ISO_ROD_index, LN_English, country, latitude, and longitude
*/
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type"				content="text/html; charset=utf-8" />
<meta name="ObjectType" 					content="Document" />
<meta http-equiv="Window-target" 			content="_top" />
<meta name="Created-by" 					content="Scott Starker" />
<title>This script inserts [qqq] into leafletjs map builder.</title>
</head>
<body>
<h1>Start...</h1>
<?php

$ISO_Country = '';
$lat_long = '';
$lines = '';
$filesArray = [];
$fileArray = '';
$upOne = '';
$key = 0;
$current = '';

require_once './include/conn.inc.php';												// connect to the database named 'scripture'
$db = get_my_db();

ini_set('max_execution_time', 0);

$query="SELECT ISO FROM LN_English WHERE ISO_ROD_index IS NOT NULL AND ISO = ? AND ROD_Code = ?";	// select the ISO from LN_English to $maps_array
$stmt_ISO=$db->prepare($query);														// create a prepared statement
$query="SELECT LN_English FROM LN_English WHERE ISO_ROD_index IS NOT NULL AND ISO = ? AND ROD_Code = ?";	// select the language name from LN_English to $maps_array
$stmt_LN=$db->prepare($query);														// create a prepared statement
$query="SELECT latitude, longitude, `name`, hid FROM leafletjs_maps WHERE hid = ? AND latitude IS NOT NULL AND longitude IS NOT NULL";
$stmt_lat_long=$db->prepare($query);												// create a prepared statement

// maps-qqq.tsv
// each line contents: ISO, ROD_Code, ISO_ROD_index, LN_English, country, latitude, and longitude
$fileRows = file('leafletjs_maps-qqq.tsv', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);	// Open the file in an array
$i=0;
foreach ($fileRows as $fileRow) {
	if ($i === 0) {																	// skip 1st line
		$i=1;
		continue;
	}
	$fr = explode("\t", $fileRow);													// split by tab
	$ISO[] = $fr[0];
	$ROD_Code[] = $fr[1];
	//echo '$ROD_Code='.$fr[1].'<br />';
	$ISO_ROD_index[] = $fr[2];
	$LN_English[] = $fr[3];
	$country[] = $fr[4];
	$latitude[] = $fr[5];
	$longitude[] = $fr[6];
}

$arrLength = count($ISO);
for ($i = 0; $i < $arrLength; $i++) {												// qqq ISO files with different CC
	//$iso = $ISO[$i];
	$rod = $ROD_Code[$i];
	//$ISO_ROD_indx = $ISO_ROD_index[$i];
	//$English = $LN_English[$i];
	//$countr = $country[$i];
	$lat = $latitude[$i];
	$long = $longitude[$i];
	
	$iso = 'qqq';
	
	$stmt_LN->bind_param('ss', $iso, $rod);											// bind parameters for markers
	$stmt_LN->execute();															// execute query
	$result_LN = $stmt_LN->get_result();
	if ($result_LN->num_rows == 0) { die('The langauge name not found in LN_English table: '.$iso.' '.$rod); }
	$row_LN = $result_LN->fetch_array();
	$LN=$row_LN['LN_English'];														// LN_English from LN_English table

	/*
	$query="SELECT latitude, longitude, `name`, hid FROM leafletjs_maps WHERE hid = '$iso' AND rod = '$rod' AND latitude IS NOT NULL AND longitude IS NOT NULL";
	$result=$db->query($query);
	if ($result->num_rows == 0) {
		$query="INSERT INTO leafletjs_maps SELECT * FROM leafletjs_maps WHERE hid = '$iso' AND latitude IS NOT NULL AND longitude IS NOT NULL";
		$db->query($query);
		$query="UPDATE leafletjs_maps SET latitude = $lat, longitude = $long, `name` = '$LN', rod = '$rod' WHERE index_leafletjs = LAST_INSERT_ID()";
		$db->query($query);
	}

	$query="SELECT ISO_Country FROM ISO_Lang_Countries WHERE ISO = '$iso'";
	$result=$db->query($query);
	if ($result->num_rows == 0) {
		die("ISO_Lang_Countries doesn't have [$iso].");
	}
	*/
	
	$ISO_Country = substr($rod, 0, 2);												// country code from the 1st two characters from $rod
	$filenames = [];
	$filename = '';
	
	$filenames = glob('maps/'.$ISO_Country.'/*.htm');								// maps/[$ISO_Country=CC]/CCNN/*.htm !
	
	//echo 'ISO_Country: '.$ISO_Country . '; filenames[0]: '.$filenames[0].'<br />';
	// copy() WILL NOT WORK! PHP 8.2.12 local computer
	//echo phpversion() . '<br />';
	//exit;
	$temp1 = $filenames[0];
	$temp2 = './maps/'.$ISO_Country.'/'.$rod.'.htm';
	// if (!file_exists($temp1)) echo $filenames[0] . ' = file doesnt exist!<br />';
	if (!file_exists($temp2)) echo 'maps/'.$ISO_Country . '/' . $rod . '.htm: file doesnt exist.<br />';
	$fileContent = @file_get_contents($temp1);
	// Set destination file to stream handler with write mode
	$destFileStream = fopen($temp2, 'w');
	// Write source file content to destination file path
	fwrite($destFileStream, $fileContent);
	// Close the stream after writing
	fclose($destFileStream);
	//if (!@copy($temp1, $temp2)) {													// copy() the file. copy() WON'T WORK! php.ini
	if (!date("m d Y", filemtime($temp1)) == date("m d Y", filemtime($temp2))) {
		echo 'filenames[0]: '.$filenames[0]. '; maps: maps/'.$ISO_Country.'/'.$rod.'.htm<br />';
		// maps-qqq.tsv => ISO	ROD_Code	ISO_ROD_index	LN_English	country	latitude	longitude
		echo 'qqq	'.$rod.'	'.$ISO_ROD_index[$i].'	'.$LN_English[$i].'	'.$country[$i].'	'.$lat.'	'.$long.'<br /><br />';
		$errors = error_get_last();
		echo 'COPY ERROR: '.$errors['type'].'<br />';
		echo $errors['message'].'<br />';
		continue;
	}
	//$tempROD = substr($filenames[0], strrpos($filenames[0], '/', 0) + 1, -4);		// just the ROD code

	echo '<h2>' . $ISO_Country . ' included in:</h2>';
	
	// just added
	$current = file_get_contents('maps/'.$ISO_Country.'/'.$rod.'.htm', FILE_USE_INCLUDE_PATH);			// read the entire string from a file
	$current = preg_replace('/setView\(\[[-\.0-9]+, [-\.0-9]+\]/', "setView([$lat, $long]", $current, 1);	// preg_replace limit 1
	$current = str_replace('.openPopup()', '', $current);												// replace the file string
	$current = str_replace(', {icon: myRedIcon}', '', $current);										// replace the file string
	$lat_long = "	L.marker([$lat, $long], {icon: myRedIcon}).addTo(mymap)\n";
	$lat_long .= "	.bindPopup(\"<b>$LN - SLI Sign Language: $rod</b><br />ScriptureEarth (<a target='_top' href='https://ScriptureEarth.org/00eng.php?iso=$iso&rod=$rod'>$LN</a>)\").openPopup();\n";
	$current = str_replace('	var popup = L.popup();', $lat_long . '	var popup = L.popup();', $current);	// replace the file string
	file_put_contents('maps/'.$ISO_Country.'/'.$rod.'.htm', $current, FILE_USE_INCLUDE_PATH | LOCK_EX);	// write the entire string to a file

	echo '<h3>maps/'.$ISO_Country.'/'.$rod.'.htm</h3>';
	
	// continue
	foreach ($filenames as $filename) {												// 'maps/'.$ISO_Country.'/*.htm' filenames one at a time
		if ($filename == 'maps/'.$ISO_Country.'/'.$rod.'.htm') { continue; }
		echo $filename . '<br />';
		// put lat and long at the end for each file
		$lat_long = "	L.marker([$lat, $long]).addTo(mymap)\n";
		$lat_long .= "	.bindPopup(\"<b>$LN - SLI Sign Language: $rod</b><br />ScriptureEarth (<a target='_top' href='https://ScriptureEarth.org/00eng.php?iso=$iso&rod=$rod'>$LN</a>)\");\n";
		$current = file_get_contents($filename, FILE_IGNORE_NEW_LINES | FILE_USE_INCLUDE_PATH);	// file in a string
		$current = str_replace('	var popup = L.popup();', $lat_long . '	var popup = L.popup();', $current);	// replace the file string
		file_put_contents($filename, $current, FILE_USE_INCLUDE_PATH | LOCK_EX);	// write the entire string to $filename file
	}
	echo '<br />';
}
?>
<h1>End</h1>
</body>
</html>