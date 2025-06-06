<?php
/*
	This is the second script. Run this AFTER the first script (leafletjs_maps-createHTM.php) has run. 

	This script inserts ROD code into leafletjs map builder based on the country(ies) code.
	The query must have iso, rod, latitude in decimal, longitude in decimal (?iso=[iso]&rod=[rod]&lat=[latitude in decimal]&long=[longitude in decimal])

	?iso=azb&rod=07458&lat=35.4742&long=44.3855
*/
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type"				content="text/html; charset=utf-8" />
<meta name="ObjectType" 					content="Document" />
<meta http-equiv="Window-target" 			content="_top" />
<meta name="Created-by" 					content="Scott Starker" />
<title>This script inserts ROD code into leafletjs map builder.</title>
</head>
<body>
<h1>Start...</h1>
<?php
if (isset($_GET['iso'])) $iso = $_GET['iso']; else { die('You must have an ISO.'); }
if (isset($_GET['rod'])) $rod = $_GET['rod']; else { die('You must have a ROD code.'); }
if (isset($_GET['lat'])) $lat = $_GET['lat']; else { die('You must have a latitude in decimal.'); }
if (isset($_GET['long'])) $long = $_GET['long']; else { die('You must have a longitude in decimal.'); }

if (!preg_match("/^[a-z]{3}$/", $iso)) { die('iso: You must have 3 lowercase letters.'); }
if (!preg_match("/^[A-z0-9]{1,5}$/", $rod)) { die('rod: You must have 1 to 5 letters and/or numbers.'); }
if (preg_match("/['\"]/", $lat)) { die('lat: You must have a latitude in decimal.'); }
if (preg_match("/['\"]/", $long)) { die('long: You must have a longitude in decimal.'); }

require_once './include/conn.inc.php';										// connect to the database named 'scripture'
$db = get_my_db();

ini_set('max_execution_time', 0);

$query="SELECT ISO FROM LN_English WHERE ISO_ROD_index IS NOT NULL AND ISO = ? AND ROD_Code = ?";	// select the ISO from LN_English to $maps_array
$stmt_ISO=$db->prepare($query);												// create a prepared statement
$query="SELECT LN_English FROM LN_English WHERE ISO_ROD_index IS NOT NULL AND ISO = ? AND ROD_Code = ?";	// select the language name from LN_English to $maps_array
$stmt_LN=$db->prepare($query);												// create a prepared statement
$query="SELECT latitude, longitude, `name`, hid FROM leafletjs_maps WHERE hid = ? AND latitude IS NOT NULL AND longitude IS NOT NULL";
$stmt_lat_long=$db->prepare($query);										// create a prepared statement

$stmt_LN->bind_param('ss', $iso, $rod);										// bind parameters for markers
$stmt_LN->execute();														// execute query
$result_LN = $stmt_LN->get_result();
if ($result_LN->num_rows == 0) { die('The langauge name not found in LN_English table.'); }
$row_LN = $result_LN->fetch_array();
$LN=$row_LN['LN_English'];													// LN_English from LN_English table

$query="SELECT latitude, longitude, `name`, hid FROM leafletjs_maps WHERE hid = '$iso' AND rod = '$rod' AND latitude IS NOT NULL AND longitude IS NOT NULL";
$result=$db->query($query);
if ($result->num_rows == 0) {
	$query="INSERT INTO leafletjs_maps SELECT * FROM leafletjs_maps WHERE hid = '$iso' AND latitude IS NOT NULL AND longitude IS NOT NULL";
	$db->query($query);
	$query="UPDATE leafletjs_maps SET latitude = $lat, longitude = $long, `name` = '$LN', rod = '$rod' WHERE index_leafletjs = LAST_INSERT_ID()";
	$db->query($query);
}

$ISO_Country = '';
$lat_long = '';
$lines = '';
$filesArray = [];
$fileArray = '';
$upOne = '';
$key = 0;
$current = '';

$query="SELECT ISO_Country FROM ISO_Lang_Countries WHERE ISO = '$iso'";
$result=$db->query($query);
if ($result->num_rows == 0) {
	die("ISO_Lang_Countries doesn't have [$iso].");
}

while ($row = $result->fetch_array()) {										// CC
	$ISO_Country=$row['ISO_Country'];										// ISO_Country - ZZ
	if (file_exists('maps/'.$ISO_Country.'/'.$iso.'_'.$rod.'.htm')) {
		continue;
	}
	if(!@copy('maps/'.$ISO_Country.'/'.$iso.'.htm', 'maps/'.$ISO_Country.'/'.$iso.'_'.$rod.'.htm')) {
		$errors= error_get_last();
		echo "COPY ERROR: ".$errors['type']."\n";
		echo $errors['message']."\n";
		continue;
	}

	echo '<h2>' . $ISO_Country . '</h2>';
	
	$filenames = [];
	$filename = '';
	
	$filenames = glob('maps/'.$ISO_Country.'/*.htm');
	
//	$lines = file($filenames[0], FILE_IGNORE_NEW_LINES | FILE_USE_INCLUDE_PATH);	// array - just the first file
//	if (in_array($iso.'_'.$rod, $lines)) {									// in_array — Checks if a value exists in an array
	$lines = file_get_contents($filenames[0], FILE_USE_INCLUDE_PATH);		// search contact of file - just the first file
	if (str_contains($lines, $iso.'; ROD: '.$rod)) {						// str_contains — Checks if a value exists in an string
		$lines = '';														// just in case there is not 
		continue;
	}

	$current = file_get_contents('maps/'.$ISO_Country.'/'.$iso.'.htm', FILE_USE_INCLUDE_PATH);	// Open the file to get existing content
	$lat_long = "	L.marker([$lat, $long], {icon: myPurpleIcon}).addTo(mymap)\n";	// Append a new $lat_long to the file
	$lat_long .= "	.bindPopup(\"<b>$LN - ISO 639-3: $iso; ROD: $rod</b><br />ScriptureEarth (<a target='_top' href='https://ScriptureEarth.org/00eng.php?iso=$iso&rod=$rod'>$LN</a>)\");\n";
	$current = str_replace('	var popup = L.popup();', $lat_long . '	var popup = L.popup();', $current);
	file_put_contents('maps/'.$ISO_Country.'/'.$iso.'.htm', $current, FILE_USE_INCLUDE_PATH | LOCK_EX);		// Write the contents back to the file

	echo '<h3>Done: maps/'.$ISO_Country.'/'.$iso.'.htm</h3>';

	$current = file_get_contents('maps/'.$ISO_Country.'/'.$iso.'_'.$rod.'.htm', FILE_USE_INCLUDE_PATH);	// read the entire string from a file
	$current = preg_replace('/setView\(\[[-\.0-9]+, [-\.0-9]+\]/', "setView([$lat, $long]", $current, 1);	// preg_replace limit 1
	$current = str_replace('.openPopup()', '', $current);								// replace the file string
	$current = str_replace('icon: myRedIcon', 'icon: myPurpleIcon', $current);			// replace the file string
	$lat_long = "	L.marker([$lat, $long], {icon: myRedIcon}).addTo(mymap)\n";
	$lat_long .= "	.bindPopup(\"<b>$LN - ISO 639-3: $iso; ROD: $rod</b><br />ScriptureEarth (<a target='_top' href='https://ScriptureEarth.org/00eng.php?iso=$iso&rod=$rod'>$LN</a>)\").openPopup();\n";
	$current = str_replace('	var popup = L.popup();', $lat_long . '	var popup = L.popup();', $current);	// replace the file string
	file_put_contents('maps/'.$ISO_Country.'/'.$iso.'_'.$rod.'.htm', $current, FILE_USE_INCLUDE_PATH | LOCK_EX);	// write the entire string to a file

	echo '<h3>Done: maps/'.$ISO_Country.'/'.$iso.'_'.$rod.'.htm</h3>';
	
	foreach ($filenames as $filename) {										// glob filenames one at a time
		if ($filename == 'maps/'.$ISO_Country.'/'.$iso.'.htm' || $filename == 'maps/'.$ISO_Country.'/'.$iso.'_'.$rod.'.htm') { continue; }
		echo $filename . '<br />';
		// put lat and long at the end for each file
		$fileArrays = file($filename, FILE_IGNORE_NEW_LINES | FILE_USE_INCLUDE_PATH);	// file in an array
		foreach ($fileArrays as $key => $fileArray) {						// interate array
			if (str_contains($fileArray, ': '.$iso.'<')) {					// str_contains with array line
				$upOne = $fileArrays[$key - 1];								// array up one
				if (strpos($upOne, 'icon: myPurpleIcon')) {
					$lat_long = "	L.marker([$lat, $long], {icon: myPurpleIcon}).addTo(mymap)\n";
				}
				else {
					$lat_long = "	L.marker([$lat, $long]).addTo(mymap)\n";
				}
				$current = implode("\n", $fileArrays);						// array to $corrent string
				$lat_long .= "	.bindPopup(\"<b>$LN - ISO 639-3: $iso; ROD: $rod</b><br />ScriptureEarth (<a target='_top' href='https://ScriptureEarth.org/00eng.php?iso=$iso&rod=$rod'>$LN</a>)\");\n";
				$current = str_replace('	var popup = L.popup();', $lat_long . '	var popup = L.popup();', $current);	// replace the file string
				file_put_contents($filename, $current, FILE_USE_INCLUDE_PATH | LOCK_EX);	// write the entire string to $filename file
			}
		}
	}
	echo '<br /><br />';
}
?>
<h1>End</h1>
</body>
</html>