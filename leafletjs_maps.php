<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type"				content="text/html; charset=utf-8" />
<meta name="ObjectType" 					content="Document" />
<meta http-equiv="Window-target" 			content="_top" />
<meta name="Created-by" 					content="Scott Starker" />
<title>leafletjs map builder</title>
</head>
<body>
<h1>Start...</h1>
<?php
// Problem: languagae name location on the language name selects more ISOs than normal. A lot of them are ignored (211 and 226)

require_once './include/conn.inc.php';							// connect to the database named 'scripture'
$db = get_my_db();

ini_set('max_execution_time', 0);

// top of this html file
$first_a = <<<STRT
<!DOCTYPE html>
<html>
<head>

STRT;

$first_c =
<<<STRT

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="shortcut icon" type="../../image/x-icon" href="favicon.ico" />
    <link rel="stylesheet" href="../../_css/leaflet.css" />
    <script src="../../_js/leaflet.min.js"></script>
</head>
<body>
<div id="mapid" style="width: 600px; height: 400px; margin: auto; margin-right: auto; margin-top: 100px; "></div>
<script>

STRT;

$first_e =
<<<STRT


// blue icon is the default

	var myRedIcon = L.icon({
		iconUrl: '../../images/myRedIcon.png'
	});

	var myPurpleIcon = L.icon({
		iconUrl: '../../images/myPurpleIcon.png'
	});

	L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
		maxZoom: 16,
		attribution: 'Map languages: � <a href="https://www.scriptureearth.org/00i-Scripture_Index.php">Scripture Earth</a>, ' +
			'Map data: � <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
			'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
			'Imagery: � <a href="https://www.mapbox.com/">Mapbox</a>',
		id: 'mapbox/streets-v11'
	}).addTo(mymap);
	
STRT;

$end =
<<<END

	var popup = L.popup();
</script>
</body>
</html>
END;

$query="SELECT ISO FROM LN_English WHERE (ISO_ROD_index IS NOT NULL OR ISO_ROD_index <> FALSE) AND ISO = ?";		// select the ISO from LN_English to $maps_array
$stmt_ISO=$db->prepare($query);														// create a prepared statement
$query="SELECT LN_English FROM LN_English WHERE ISO = ?";							// select the language name from LN_English to $maps_array
$stmt_LN=$db->prepare($query);														// create a prepared statement
$query="SELECT latitude, longitude, name, hid FROM leafletjs_maps WHERE hid = ?";	// select the latitude, longitude, name, hid from leafletjs_maps to $lat_long_array and $save_lat_long
$stmt_lat_long=$db->prepare($query);												// create a prepared statement

$enter = '';
$i = 0;
$previous_CC = '';
$previous_CName = '';
$maps_array = [];
$lat_long_array = [];
$save_lat_long = [];
$family = 0;
$family_array = [];
$previou_ISO = '';
$t = 0;
$previousPartOfLanguageLatLong = '';

$query="SELECT ISO_Lang_Countries.ISO, ISO_Lang_Countries.ISO_Country, countries.English FROM ISO_Lang_Countries, countries WHERE countries.ISO_Country = ISO_Lang_Countries.ISO_Country ORDER BY ISO_Lang_Countries.ISO_Country";
$result=$db->query($query);
while ($row = $result->fetch_array()) {
	$ISO=$row['ISO'];														// ISO
	$ISO_Country=$row['ISO_Country'];										// ISO_Country - ZZ
	$English_Country=$row['English'];										// English Country name
	if ($i == 0) {
		$i = 1;
		$previous_CC = $ISO_Country;
		$previous_CName = $English_Country;
	}
	else {
		if ($ISO_Country != $previous_CC) {									// when previous country doesn't equal the new country
		
			/******************************************************************************
			*
			*		Write the html files for all of the ISOs on one Country.
			*
			******************************************************************************/
		
			/*****************************************************************
			*		get the arrays of $maps_array, $lat_long_value, and $save_lat_long
			*****************************************************************/
			if (!is_dir('leafletjs_maps/'.$previous_CC)) {
				mkdir('leafletjs_maps/'.$previous_CC);
			}

			/**********************************************************************
			*
			*		add all of the lat.'s and long.'s to all of the ISOs of this country
			*
			***********************************************************************/
			$temp = count($maps_array[0])-1;								// the previous column of the $maps_array
			for ($z=0; $z < count($maps_array); $z++) {						// add all of the lat.'s and long.'s to all of the ISOs of this country
				$ISO_map = array_keys($maps_array[$z]);						// create $key_maps_array from $maps_array only in (0 => key1, 1 => key2, etc.)
				$family = 0;
				$family_array = [];
				$previou_ISO = '';
				$t = 0;
				$previousPartOfLanguageLatLong = '';
				
				/*************************************************************
				*
				*		add all of the $lat_long_array through one ISO
				*
				*************************************************************/
				foreach($lat_long_array as $k => $lat_long_value) {			// loop through $lat_long_array
					$key_maps_array = array_keys($maps_array[$k]);			// create $key_maps_array from $maps_array only in (0 => key1, 1 => key2, etc.)
					$L_ISO = $key_maps_array[0];							// get ISO
					$value_maps_array = array_values($maps_array[$k]);		// create $value_maps_array from $maps_array only in (0 => value1, 1 => value2, etc.)
					$L_LN = $value_maps_array[0];							// get language name
					$stmt_ISO->bind_param('s', $L_ISO);						// bind parameters for markers
					$stmt_ISO->execute();									// execute query
					$result_ISO = $stmt_ISO->get_result();
					
					if ($L_ISO == $ISO_map[0]) {							// if ISO = ISO array
						if ($result_ISO->num_rows == 0) {					// if ISO = LN_English table ISO
							$lat_long = "	L.marker([$lat_long_value], {icon: myRedIcon}).addTo(mymap)\n";
							$lat_long .= "	.bindPopup(\"<b>$L_LN - ISO 639-3: $L_ISO</b>\")\n";
						} 
						else {
							$lat_long = "	L.marker([$lat_long_value], {icon: myRedIcon}).addTo(mymap)\n";
							$lat_long .= "	.bindPopup(\"<b>$L_LN - ISO 639-3: $L_ISO</b><br />ScriptureEarth (<a href='https://www.scriptureearth.org/00i-Scripture_Index.php?iso=$L_ISO'>$L_LN</a>)\")\n";
						}
					}
					else {
						if ($result_ISO->num_rows == 0) {
							$lat_long = "	L.marker([$lat_long_value]).addTo(mymap)\n";
							$lat_long .= "	.bindPopup(\"<b>$L_LN - ISO 639-3: $L_ISO</b>\")\n";
						}
						else {
							$lat_long = "	L.marker([$lat_long_value]).addTo(mymap)\n";
							$lat_long .= "	.bindPopup(\"<b>$L_LN - ISO 639-3: $L_ISO</b><br />ScriptureEarth (<a href='https://www.scriptureearth.org/00i-Scripture_Index.php?iso=$L_ISO'>$L_LN</a>)\")\n";
						}
					}
					array_push($maps_array[$z], $lat_long);
				}
			}

			
			/*************************************************************************
			*
			*		Write the html files for all of the ISOs on one country.
			*
			*************************************************************************/
			
			$enter = '';
			$temp_value_array = [];
			foreach($maps_array as $key => $value) {										// country html files output. $maps_array[z][y] = individual ISO with all of the lat. and long. there
				$L_ISO = array_keys($value)[0];												// ISO and more
				for ($ISO_index=0; $ISO_index < count($value)-1; $ISO_index++) {			// for each ISO for one country
					if (strpos($value[$ISO_index], '{icon: myRedIcon}).addTo(mymap)')) {
						//$enter .= $value[$ISO_index];
						$J_LN = '';
						// /s modifier a dot (.) metacharacter in the pattern matches all characters, including newlines.
						// The /u modifier makes both the pattern and subject be interpreted as UTF-8 but the captured offsets are still counted in bytes.
						// But try (*UTF8) before the RegEx pattern which I havn't done now.
						// select language name by deleting everything around it!
						$J_LN = preg_replace('/(.+\s+\.bindPopup\("[\<b\>]{0,3})/su', "", $value[$ISO_index]);
						$J_LN = preg_replace('/[^-](- ISO 639-3: [a-z]{3}.*)/su', "", $J_LN);
						$temp_value_array = [];
						$match = [];
						preg_match_all('/(\w+)[-\,\(\)]?/u', $J_LN, $match);				// get the word $J_LN
						foreach ($match[1] as $temp) {
							if (preg_match('/^(on|the|and|of|south|north|northwest|northeast|Northwestern|Southwestern|Northeastern|Southeastern|southwest|southeast|southern|northern|Eastern|Western|central|Norte|sur|Sureste|Valley|river|Noroeste|Highland|Standard|Modern|de|del|Sta|santa|san|la|Alta|[0-9]+|Dos|west|east|^.)$/i', $temp)) continue;
							$temp_value_array[] = $temp;									// words from value
						}
						continue;
					}
					
					for ($latlong_index=0; $latlong_index < count($value)-1; $latlong_index++) {		// iterate all the way through latitude and longitude
						if (strpos($value[$ISO_index], '{icon: myRedIcon}).addTo(mymap)')) continue;	// if myRedIcon continue
						
						$temp_J_LN = '';
						// select language name by deleting everything around it!
						$temp_J_LN = preg_replace('/(.+\s+\.bindPopup\("[\<b\>]{0,3})/su', "", $value[$latlong_index]);
						$temp_J_LN = preg_replace('/[^-](- ISO 639-3: [a-z]{3}.*)/su', "", $temp_J_LN);
						preg_match_all('/(\w+)[-\,\(\)]?/u', $temp_J_LN, $match);			// get the word $value[$latlong_index]
						$temp_latlong_array = [];
						foreach ($match[1] as $temp) {
							if (preg_match('/^(on|the|and|of|south|north|northwest|northeast|Northwestern|Southwestern|Northeastern|Southeastern|southwest|southeast|southern|northern|Eastern|Western|central|Norte|sur|Sureste|Valley|river|Noroeste|Highland|Standard|Modern|de|del|Sta|santa|san|la|Alta|[0-9]+|Dos|west|east|^.)$/i', $temp)) continue;
							$temp_latlong_array[] = $temp;									// words from value
						}
						if ($temp_value_array === $temp_latlong_array) {					// if arrays = each other
							//$enter .= $value[$ISO_index];
							continue;
						}
						$array_result = [];
						$array_result = array_intersect($temp_value_array, $temp_latlong_array);		// compare two arrays
						if (empty($array_result)) {
						
						}
						else {
							$value[$latlong_index] = str_replace("]).addTo(mymap)", "], {icon: myPurpleIcon}).addTo(mymap)", $value[$latlong_index]);
						}
					}
				}		// end for
				
				$enter = '';
				$b=0;
				foreach($value as $k => $I_ISO) {
					if ($b == 0) {
						$b=1;
						continue;
					}
					$enter .= $I_ISO;
				}

				$first_b = $first_a . "	<title>Language map of ".$previous_CName." - Leaflet</title>";							// write out just 1 ISO
				$first_d = $first_b . $first_c . "	var mymap = L.map('mapid').setView([".$save_lat_long[$key]."], 9);";
				$first = $first_d  . $first_e;
				//file_put_contents('leafletjs_maps/'.$previous_CName.'/'.$L_ISO.'.html', $first, LOCK_EX);
				//file_put_contents('leafletjs_maps/'.$previous_CName.'/'.$L_ISO.'.html', $enter, FILE_APPEND | LOCK_EX);
				// bottom of this html file
				//file_put_contents('leafletjs_maps/'.$previous_CName.'/'.$L_ISO.'.html', $end, FILE_APPEND | LOCK_EX);
				file_put_contents('leafletjs_maps/'.$previous_CC.'/'.$L_ISO.'.html', $first, LOCK_EX);
				file_put_contents('leafletjs_maps/'.$previous_CC.'/'.$L_ISO.'.html', $enter, FILE_APPEND | LOCK_EX);
				// bottom of this html file
				file_put_contents('leafletjs_maps/'.$previous_CC.'/'.$L_ISO.'.html', $end, FILE_APPEND | LOCK_EX);
				$first = '';
				$enter = '';
			}
			$maps_array = [];
			$lat_long_array = [];
			$save_lat_long = [];
			$previous_CC = $ISO_Country;
			$previous_CName = $English_Country;
		}
	}

	/**************************************************************************************************
	*
	*		save $latitude, $longitude in an array
	*
	***************************************************************************************************/

	$stmt_lat_long->bind_param('s', $ISO);									// bind parameters for markers
	$stmt_lat_long->execute();												// execute query
	$result_map = $stmt_lat_long->get_result();
	if ($result_map->num_rows == 0) {										// if lataude etc. is not in leafletjs table then continue
		continue;
	}
	$r = $result_map->fetch_array();										// add the lat. and long. to $lat_long_array
	$latitude=$r['latitude'];
	$longitude=$r['longitude'];
	array_push($lat_long_array, "$latitude, $longitude");
	
	$hid=$r['hid'];
	if ($ISO == $hid) {
		$save_lat_long[] = "$latitude, $longitude";							// save $latitude, $longitude for this ISO
	}
	
	$stmt_LN->bind_param('s', $ISO);										// bind parameters for markers
	$stmt_LN->execute();													// execute query
	$result_LN = $stmt_LN->get_result();
	if ($result_LN->num_rows == 0) {
		$LN=$r['name'];
		$maps_array[] = array($ISO => $LN);									// these next two are similar?
	}
	else {
		$row_LN = $result_LN->fetch_array();
		$LN=$row_LN['LN_English'];
		$maps_array[] = array($ISO => $LN);									// these next two are similar?
	}
}



// Last step for the last country
if (!is_dir('leafletjs_maps/'.$ISO_Country)) {
	mkdir('leafletjs_maps/'.$ISO_Country);
}

$temp = count($maps_array[0])-1;											// the previous column of the $maps_array
for ($z=0; $z < count($maps_array); $z++) {									// add all of the lat.'s and long.'s to all of the ISOs of this country
	$ISO_map = array_keys($maps_array[$z]);									// create $key_maps_array from $maps_array only in (0 => key1, 1 => key2, etc.)
	foreach($lat_long_array as $k => $lat_long_value) {
		$key_maps_array = array_keys($maps_array[$k]);						// create $key_maps_array from $maps_array only in (0 => key1, 1 => key2, etc.)
		$L_ISO = $key_maps_array[0];
		$value_maps_array = array_values($maps_array[$k]);					// create $value_maps_array from $maps_array only in (0 => value1, 1 => value2, etc.)
		$L_LN = $value_maps_array[0];
		$stmt_ISO->bind_param('s', $L_ISO);									// bind parameters for markers
		$stmt_ISO->execute();												// execute query
		$result_ISO = $stmt_ISO->get_result();
		if ($L_ISO == $ISO_map[0]) {
			if ($result_ISO->num_rows == 0) {
				$lat_long = "	L.marker([$lat_long_value], {icon: myRedIcon}).addTo(mymap)\n";
				$lat_long .= "	.bindPopup(\"<b>$L_LN - ISO 639-3: $L_ISO</b>\")\n";
			} 
			else {
				$lat_long = "	L.marker([$lat_long_value], {icon: myRedIcon}).addTo(mymap)\n";
				$lat_long .= "	.bindPopup(\"<b>$L_LN - ISO 639-3: $L_ISO</b><br />ScriptureEarth (<a href='https://www.scriptureearth.org/00i-Scripture_Index.php?iso=$L_ISO'>$L_LN</a>)\")\n";
			}
		}
		else {
			if ($result_ISO->num_rows == 0) {
				$lat_long = "	L.marker([$lat_long_value]).addTo(mymap)\n";
				$lat_long .= "	.bindPopup(\"<b>$L_LN - ISO 639-3: $L_ISO</b>\")\n";
			}
			else {
				$lat_long = "	L.marker([$lat_long_value]).addTo(mymap)\n";
				$lat_long .= "	.bindPopup(\"<b>$L_LN - ISO 639-3: $L_ISO</b><br />ScriptureEarth (<a href='https://www.scriptureearth.org/00i-Scripture_Index.php?iso=$L_ISO'>$L_LN</a>)\")\n";
			}
		}
		array_push($maps_array[$z], $lat_long);
	}
}

$enter = '';
$temp_value_array = [];
foreach($maps_array as $key => $value) {										// country html files output. $maps_array[z][y] = individual ISO with all of the lat. and long. there
	$L_ISO = array_keys($value)[0];												// ISO and more
	for ($ISO_index=0; $ISO_index < count($value)-1; $ISO_index++) {			// for each ISO for one country
		if (strpos($value[$ISO_index], '{icon: myRedIcon}).addTo(mymap)')) {
			$J_LN = '';
			// select language name by deleting everything around it!
			$J_LN = preg_replace('/(.+\s+\.bindPopup\("[\<b\>]{0,3})/su', "", $value[$ISO_index]);
			$J_LN = preg_replace('/[^-](- ISO 639-3: [a-z]{3}.*)/su', "", $J_LN);
			$temp_value_array = [];
			$match = [];
			preg_match_all('/(\w+)[-\,\(\)]?/u', $J_LN, $match);				// get the word $J_LN
			foreach ($match[1] as $temp) {
				if (preg_match('/^(on|the|and|of|south|north|northwest|northeast|Northwestern|Southwestern|Northeastern|Southeastern|southwest|southeast|southern|northern|Eastern|Western|central|Norte|sur|Sureste|Valley|river|Noroeste|Highland|Standard|Modern|de|del|Sta|santa|san|la|Alta|[0-9]*|Dos|west|east|^.)$/i', $temp)) continue;
				$temp_value_array[] = $temp;									// words from value
			}
			continue;
		}
		
		for ($latlong_index=0; $latlong_index < count($value)-1; $latlong_index++) {		// iterate all the way through latitude and longitude
			if (strpos($value[$ISO_index], '{icon: myRedIcon}).addTo(mymap)')) continue;	// if myRedIcon continue
			$temp_J_LN = '';
			// select language name by deleting everything around it!
			$temp_J_LN = preg_replace('/(.+\s+\.bindPopup\("[\<b\>]{0,3})/su', "", $value[$latlong_index]);
			$temp_J_LN = preg_replace('/[^-](- ISO 639-3: [a-z]{3}.*)/su', "", $temp_J_LN);
			preg_match_all('/(\w+)[-\,\(\)]?/u', $temp_J_LN, $match);			// get the word $value[$latlong_index]
			$temp_latlong_array = [];
			foreach ($match[1] as $temp) {
				if (preg_match('/^(on|the|and|of|south|north|northwest|northeast|Northwestern|Southwestern|Northeastern|Southeastern|southwest|southeast|southern|northern|Eastern|Western|central|Norte|sur|Sureste|Valley|river|Noroeste|Highland|Standard|Modern|de|del|Sta|santa|san|la|Alta|[0-9]*|Dos|west|east|^.)$/i', $temp)) continue;
				$temp_latlong_array[] = $temp;									// words from value
			}
			if ($temp_value_array === $temp_latlong_array) {					// if arrays = each other
				continue;
			}
			$array_result = [];
			$array_result = array_intersect($temp_value_array, $temp_latlong_array);		// compare two arrays
			if (empty($array_result)) {
			
			}
			else {
				$value[$latlong_index] = str_replace("]).addTo(mymap)", "], {icon: myPurpleIcon}).addTo(mymap)", $value[$latlong_index]);
			}
		}
	}		// end for
	
	$enter = '';
	$b=0;
	foreach($value as $k => $I_ISO) {
		if ($b == 0) {
			$b=1;
			continue;
		}
		$enter .= $I_ISO;
	}
	
	$first_b = $first_a . "	<title>Language map of ".$English_Country." - Leaflet</title>";
	$first_d = $first_b . $first_c . "	var mymap = L.map('mapid').setView([".$save_lat_long[$key]."], 9);";
	$first = $first_d  . $first_e;
	//file_put_contents('leafletjs_maps/'.$English_Country.'/'.$L_ISO.'.html', $first, LOCK_EX);
	//file_put_contents('leafletjs_maps/'.$English_Country.'/'.$L_ISO.'.html', $enter, FILE_APPEND | LOCK_EX);
	// bottom of this html file
	//file_put_contents('leafletjs_maps/'.$English_Country.'/'.$L_ISO.'.html', $end, FILE_APPEND | LOCK_EX);
	file_put_contents('leafletjs_maps/'.$ISO_Country.'/'.$L_ISO.'.html', $first, LOCK_EX);
	file_put_contents('leafletjs_maps/'.$ISO_Country.'/'.$L_ISO.'.html', $enter, FILE_APPEND | LOCK_EX);
	// bottom of this html file
	file_put_contents('leafletjs_maps/'.$ISO_Country.'/'.$L_ISO.'.html', $end, FILE_APPEND | LOCK_EX);
	$first = '';
	$enter = '';
}
?>
<h1>End</h1>
</body>
</html>