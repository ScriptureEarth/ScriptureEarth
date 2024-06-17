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
// This script sdeems to have a prolblem running on the server so run on the local harddrive and then copy to the server.

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
	<style type="text/css">
		div.maps {
			width: 640px;
			/*width: 800px;*/
			height: 480px;
			/*height: 600px;*/
			/*maxWidth: 700px;*/
			margin-left: auto;
			margin-right: auto;
			margin-top: 20px;
		}
	</style>
</head>
<body>
<div id="mapid" class="maps"></div>
<script>

STRT;

$first_e =
<<<STRT


	// blue icon is the default
	L.Icon.Default.iconUrl = '../../images/marker-icon.png';
	L.Icon.Default.shadowUrl = '../../images/marker-shadow.png';

	var myRedIcon = L.icon({
		iconUrl: '../../images/myRedIcon.png',
		shadowUrl: '../../images/marker-shadow.png'
	});

	var myPurpleIcon = L.icon({
		iconUrl: '../../images/myPurpleIcon.png',
		shadowUrl: '../../images/marker-shadow.png'
	});

	L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		maxZoom: 16,
		attribution: 'language names: <a href="https://www.scriptureearth.org/00i-Scripture_Index.php">Scripture Earth</a>, ' +
			'map data: &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a>'
	}).addTo(mymap);

STRT;

$end =
<<<END

	var popup = L.popup();
</script>
</body>
</html>
END;

$query="SELECT ISO FROM LN_English WHERE ISO_ROD_index IS NOT NULL AND ISO = ?";	// select the ISO from LN_English to $maps_array
$stmt_ISO=$db->prepare($query);														// create a prepared statement
$query="SELECT LN_English FROM LN_English WHERE ISO = ?";							// select the language name from LN_English to $maps_array
$stmt_LN=$db->prepare($query);														// create a prepared statement
$query="SELECT latitude, longitude, `name`, hid FROM leafletjs_maps WHERE hid = ? AND latitude IS NOT NULL AND longitude IS NOT NULL";	// select the latitude, longitude, name, hid from leafletjs_maps to $lat_long_array and $save_lat_long
$stmt_lat_long=$db->prepare($query);												// create a prepared statement

$enter = '';
$i = 0;
$previous_CC = '';
$previous_CName = '';
$maps_array = [];
$lat_long_array = [];
$save_lat_long = [];
$s_lat_long = '';
$match = [];

$query="SELECT ISO_Lang_Countries.ISO, ISO_Lang_Countries.ISO_Country, countries.English FROM ISO_Lang_Countries, countries WHERE countries.ISO_Country = ISO_Lang_Countries.ISO_Country ORDER BY ISO_Lang_Countries.ISO_Country";
$result=$db->query($query);
while ($row = $result->fetch_array()) {										// 1 ISO and its country
	$ISO=$row['ISO'];														// ISO
	$ISO_Country=$row['ISO_Country'];										// ISO_Country - ZZ
	$English_Country=$row['English'];										// English Country name
	if ($i == 0) {
		$i = 1;
		$previous_CC = $ISO_Country;
		$previous_CName = $English_Country;
	}

	/**************************************************************************************************
	*
	*		Write the htm files for all of the ISOs on one country.
	*
	***************************************************************************************************/
	elseif ($ISO_Country != $previous_CC) {									// when previous country doesn't equal the new country
		if (!is_dir('maps/'.$previous_CC)) {
			mkdir('maps/'.$previous_CC);
		}

		/**********************************************************************
		*
		*		add all of the lat.'s and long.'s to all of the ISOs of this country
		*
		***********************************************************************/
		//$temp = count($maps_array[0])-1;									// the previous column of the $maps_array
		$key_maps_array = array_keys($maps_array);							// create $key_maps_array from $maps_array only in (0 => ISO, 1 => ISO, etc.)
		$value_maps_array = array_values($maps_array);						// create $value_maps_array from $maps_array only in (0 => LN, 1 => LN, etc.)
		for ($z=0; $z < count($lat_long_array); $z++) {						// add all of the lat.'s and long.'s to all of the ISOs of this country
			$key_lat_long = array_keys($lat_long_array);					// create $key_lat_long from $lat_long_array only in (0 => ISO, 1 => ISO, etc.)
			$value_lat_long = array_values($lat_long_array);				// create $value_lat_long from $lat_long_array only in (0 => lat_long, 1 => lat_long, etc.)
			//echo '<br />140<br />';
			//print_r($key_maps_array);
			$enter = '';
			$temp_value_array = [];
			//echo '<br />144: lat_long_array:<br />';
			//print_r($lat_long_array);
			for ($y=0; $y < count($lat_long_array); $y++) {					// add all of the lat.'s and long.'s to all of the ISOs of this country
				$L_ISO = $key_lat_long[$y];									// ISO and more
				$L_LN = $value_maps_array[$y];								// get language name
			
				/*************************************************************************
				*
				*		Add myRedIcon icon
				*
				*************************************************************************/
				$stmt_ISO->bind_param('s', $L_ISO);							// bind parameters for markers
				$stmt_ISO->execute();										// execute query
				$result_ISO = $stmt_ISO->get_result();
				preg_match("/L.marker\(\[([-0-9\., ]+)\]\)\.addTo/", $value_lat_long[$y], $match);	// lat and long
				$s_lat_long = $match[1];									// save lat and long
				if (empty($result_ISO->num_rows) || $result_ISO->num_rows == 0) {
					$lat_long = "	L.marker([$s_lat_long], {icon: myRedIcon}).addTo(mymap)\n";
					$lat_long .= "	.bindPopup(\"<b>$L_LN - ISO 639-3: $L_ISO</b>\").openPopup();\n";
				} 
				else {
					$lat_long = "	L.marker([$s_lat_long], {icon: myRedIcon}).addTo(mymap)\n";
					$lat_long .= "	.bindPopup(\"<b>$L_LN - ISO 639-3: $L_ISO</b><br />ScriptureEarth (<a target='_top' href='https://www.scriptureearth.org/00i-Scripture_Index.php?iso=$L_ISO'>$L_LN</a>)\").openPopup();\n";
				}
				$lat_long_array[$L_ISO] = $lat_long;
				//$key_lat_long = array_keys($lat_long_array);				// create $key_lat_long from $lat_long_array only in (0 => ISO, 1 => ISO, etc.)
				$value_lat_long = array_values($lat_long_array);			// create $value_lat_long from $lat_long_array only in (0 => lat_long, 1 => lat_long, etc.)
				// select language name by deleting everything around it!
				$temp_value_array = [];
				$match = [];
				preg_match_all('/(\w+)[-\,\(\)]?/u', $L_LN, $match);		// get the words $L_LN
				foreach ($match[1] as $temp) {
					if ($temp == $previous_CName) continue;
					if (preg_match('/^(on|the|and|of|south|north|northwest|northeast|Northwestern|Southwestern|Northeastern|Southeastern|southwest|southeast|southern|northern|Eastern|Western|central|Norte|sur|Sureste|Valley|river|Noroeste|Highland|Standard|Modern|de|del|Sta|santa|san|la|Alta|[0-9]+|Dos|west|east|^.)$/i', $temp)) continue;
					$temp_value_array[] = $temp;							// get word
				}
				//echo '<br />first => 180: $temp_value_array:<br />';
				//print_r($temp_value_array);
			
				/*************************************************************************
				*
				*		Add myPurpleIcon icons
				*
				*************************************************************************/
				//echo '<br />188: lat_long_array:<br />';
				//print_r($lat_long_array);
				for ($latlong_index=0; $latlong_index < count($lat_long_array); $latlong_index++) {		// iterate all the way through latitude and longitude
					//echo $value_lat_long[$latlong_index] . '<br />';
					if (strpos($value_lat_long[$latlong_index], '{icon: myRedIcon}).addTo(mymap)')) continue;	// if myRedIcon continue
					$J_LN = $value_maps_array[$latlong_index];				// get language name
					// select language name by deleting everything around it!
					$match = [];
					preg_match_all('/(\w+)[-\,\(\)]?/u', $J_LN, $match);	// get the words $J_LN
					$temp_latlong_array = [];
					foreach ($match[1] as $temp) {
						if ($temp == $previous_CName) continue;
						if (preg_match('/^(on|the|and|of|south|north|northwest|northeast|Northwestern|Southwestern|Northeastern|Southeastern|southwest|southeast|southern|northern|Eastern|Western|central|Norte|sur|Sureste|Valley|river|Noroeste|Highland|Standard|Modern|de|del|Sta|santa|san|la|Alta|[0-9]+|Dos|west|east|^.)$/i', $temp)) continue;
						$temp_latlong_array[] = $temp;						// get word
					}
					if ($temp_value_array == $temp_latlong_array) {			// if arrays = each other
						continue;
					}
					//echo '<br />second => 206: $temp_latlong_array:<br />';
					//print_r($temp_latlong_array);
					//$array_result = [];
					//$array_result = array_intersect($temp_value_array, $temp_latlong_array);		// compare two arrays
					$o = 0;
					foreach($temp_value_array as $mmain) {					// compare myRedIcon words with interated words
						foreach($temp_latlong_array as $mcur) {
							/*if ($mmain == $mcur) {							// match so myPurpleIcon!
								$o = 1;
								break 2;
							}*/
							if ($mmain == $mcur) {							// match so myPurpleIcon!
								if (strpos($L_LN, ',') && strpos($J_LN, ',')) {
									if (substr($L_LN, 0, strpos($L_LN, ',')) == substr($J_LN, 0, strpos($J_LN, ','))) {
										$o = 1;
										break 2;						// break all of the way back to 2 foreach
									}
								}
								else {
									$o = 1;
									break 2;							// break all of the way back to 2 foreach
								}
							}
						}
					}
					//if (empty($array_result)) {
					//	
					//}
					//else {
					if ($o == 1) {
						$lat_long_array[$key_lat_long[$latlong_index]] = str_replace("]).addTo(mymap)", "], {icon: myPurpleIcon}).addTo(mymap)", $value_lat_long[$latlong_index]);
						//echo '$lat_long_array[$key_lat_long[$latlong_index]]: '.$lat_long_array[$key_lat_long[$latlong_index]].'<br />';
						//echo '<p>238: $value_lat_long[$latlong_index]: '.$value_lat_long[$latlong_index].'<br />';
						//echo '239: $lat_long_array[$L_ISO]: '.$lat_long_array[$L_ISO].'</p>';
						$value_lat_long = array_values($lat_long_array);	// create $value_lat_long from $lat_long_array only in (0 => lat_long, 1 => lat_long, etc.)
					}
				}		// end for
				//echo '<br />';
				//echo '<br />244: lat_long_array:<br />';
				//print_r($lat_long_array);
				
				/*************************************************************************
				*
				*		Write the html files for all of the ISOs on one country.
				*
				*************************************************************************/
				//echo '252: lat_long_array:<br />';
				//print_r($lat_long_array);
				$enter = '';
				$b=0;
				foreach($lat_long_array as $k => $I_ISO) {					// get string for body
					$enter .= $I_ISO;
				}

				$first_b = $first_a . "	<title>Language map of ".$previous_CName." - Leaflet</title>";		// write out just 1 ISO
				$first_d = $first_b . $first_c . "	var mymap = L.map('mapid').setView([".$s_lat_long."], 9);";
				$first = $first_d  . $first_e;
				//file_put_contents('maps/'.$previous_CName.'/'.$L_ISO.'.html', $first, LOCK_EX);
				//file_put_contents('maps/'.$previous_CName.'/'.$L_ISO.'.html', $enter, FILE_APPEND | LOCK_EX);
				//file_put_contents('maps/'.$previous_CName.'/'.$L_ISO.'.html', $end, FILE_APPEND | LOCK_EX);
				// top of this htm file
				file_put_contents('maps/'.$previous_CC.'/'.$L_ISO.'.htm', $first, LOCK_EX);
				// body of this htm file
				file_put_contents('maps/'.$previous_CC.'/'.$L_ISO.'.htm', $enter, FILE_APPEND | LOCK_EX);
				// bottom of this htm file
				file_put_contents('maps/'.$previous_CC.'/'.$L_ISO.'.htm', $end, FILE_APPEND | LOCK_EX);

				$first = '';
				$enter = '';
				//$maps_array = [];
				//$key_maps_array = [];											// create $key_maps_array from $maps_array only in (0 => ISO, 1 => ISO, etc.)
				//$value_maps_array = [];										// create $value_maps_array from $maps_array only in (0 => LN, 1 => LN, etc.)
				$lat_long_array = $save_lat_long;							// lat_long template
				$key_lat_long = array_keys($lat_long_array);				// IMPORTANT! array_keys AND array_arrays must be AGIAN set to $lat_long_array
				$value_lat_long = array_values($lat_long_array);
			}
			//echo '<br />';
			$maps_array = [];
			$lat_long_array = [];
			$save_lat_long = [];
			$previous_CC = $ISO_Country;
			$previous_CName = $English_Country;
		}
	}

	/**************************************************************************************************
	*
	*		first, save $latitude, $longitude in an array
	*
	***************************************************************************************************/
	$stmt_lat_long->bind_param('s', $ISO);									// bind parameters for markers
	$stmt_lat_long->execute();												// execute query
	$result_map = $stmt_lat_long->get_result();								// get the latitude and longtude of the ISO
	if ($result_map->num_rows == 0) {										// if latitude etc. is not in leafletjs table then continue
		continue;
	}
	$r = $result_map->fetch_array();										// add the lat. and long. to $lat_long_array
	$latitude=$r['latitude'];
	$longitude=$r['longitude'];
	$hid=$r['hid'];
	if ($ISO == $hid) {
		// ?
	}
	
	$stmt_LN->bind_param('s', $ISO);										// bind parameters for markers
	$stmt_LN->execute();													// execute query
	$result_LN = $stmt_LN->get_result();
	if ($result_LN->num_rows == 0) {
		$LN=$r['name'];
	}
	else {
		$row_LN = $result_LN->fetch_array();
		$LN=$row_LN['LN_English'];
	}
	$maps_array[$ISO] = $LN;												// these next two are similar?

	$stmt_ISO->bind_param('s', $ISO);										// bind parameters for markers
	$stmt_ISO->execute();													// execute query
	$result_ISO = $stmt_ISO->get_result();
	if (empty($result_ISO->num_rows) || $result_ISO->num_rows == 0) {
		$lat_long = "	L.marker(["."$latitude, $longitude"."]).addTo(mymap)\n";
		$lat_long .= "	.bindPopup(\"<b>$LN - ISO 639-3: $ISO</b>\");\n";
	}
	else {
		$lat_long = "	L.marker(["."$latitude, $longitude"."]).addTo(mymap)\n";
		$lat_long .= "	.bindPopup(\"<b>$LN - ISO 639-3: $ISO</b><br />ScriptureEarth (<a target='_top' href='https://www.scriptureearth.org/00i-Scripture_Index.php?iso=$ISO'>$LN</a>)\");\n";
	}
	$lat_long_array[$ISO] = $lat_long;										// lat_long

	$save_lat_long[$ISO] = $lat_long;										// lat_long template
}



// Last step for the last country
if (!is_dir('maps/'.$ISO_Country)) {
	mkdir('maps/'.$ISO_Country);
}

/**********************************************************************
*
*		add all of the lat.'s and long.'s to all of the ISOs of this country
*
***********************************************************************/
//$temp = count($maps_array[0])-1;									// the previous column of the $maps_array
$key_maps_array = array_keys($maps_array);							// create $key_maps_array from $maps_array only in (0 => ISO, 1 => ISO, etc.)
$value_maps_array = array_values($maps_array);						// create $value_maps_array from $maps_array only in (0 => LN, 1 => LN, etc.)
for ($z=0; $z < count($lat_long_array); $z++) {						// add all of the lat.'s and long.'s to all of the ISOs of this country
	$key_lat_long = array_keys($lat_long_array);					// create $key_lat_long from $lat_long_array only in (0 => ISO, 1 => ISO, etc.)
	$value_lat_long = array_values($lat_long_array);				// create $value_lat_long from $lat_long_array only in (0 => lat_long, 1 => lat_long, etc.)
	//echo '<br />140<br />';
	//print_r($key_maps_array);
	$enter = '';
	$temp_value_array = [];
	//echo '<br />144: lat_long_array:<br />';
	//print_r($lat_long_array);
	for ($y=0; $y < count($lat_long_array); $y++) {					// add all of the lat.'s and long.'s to all of the ISOs of this country
		$L_ISO = $key_lat_long[$y];									// ISO and more
		$L_LN = $value_maps_array[$y];								// get language name
	
		/*************************************************************************
		*
		*		Add myRedIcon icon
		*
		*************************************************************************/
		$stmt_ISO->bind_param('s', $L_ISO);							// bind parameters for markers
		$stmt_ISO->execute();										// execute query
		$result_ISO = $stmt_ISO->get_result();
		preg_match("/L.marker\(\[([-0-9\., ]+)\]\)\.addTo/", $value_lat_long[$y], $match);	// lat and long
		$s_lat_long = $match[1];									// save lat and long
		if (empty($result_ISO->num_rows) || $result_ISO->num_rows == 0) {
			$lat_long = "	L.marker([$s_lat_long], {icon: myRedIcon}).addTo(mymap)\n";
			$lat_long .= "	.bindPopup(\"<b>$L_LN - ISO 639-3: $L_ISO</b>\").openPopup();\n";
		} 
		else {
			$lat_long = "	L.marker([$s_lat_long], {icon: myRedIcon}).addTo(mymap)\n";
			$lat_long .= "	.bindPopup(\"<b>$L_LN - ISO 639-3: $L_ISO</b><br />ScriptureEarth (<a target='_top' href='https://www.scriptureearth.org/00i-Scripture_Index.php?iso=$L_ISO'>$L_LN</a>)\").openPopup();\n";
		}
		$lat_long_array[$L_ISO] = $lat_long;
		//$key_lat_long = array_keys($lat_long_array);				// create $key_lat_long from $lat_long_array only in (0 => ISO, 1 => ISO, etc.)
		$value_lat_long = array_values($lat_long_array);			// create $value_lat_long from $lat_long_array only in (0 => lat_long, 1 => lat_long, etc.)
		// select language name by deleting everything around it!
		$temp_value_array = [];
		$match = [];
		preg_match_all('/(\w+)[-\,\(\)]?/u', $L_LN, $match);		// get the words $L_LN
		foreach ($match[1] as $temp) {
			if ($temp == $previous_CName) continue;
			if (preg_match('/^(on|the|and|of|south|north|northwest|northeast|Northwestern|Southwestern|Northeastern|Southeastern|southwest|southeast|southern|northern|Eastern|Western|central|Norte|sur|Sureste|Valley|river|Noroeste|Highland|Standard|Modern|de|del|Sta|santa|san|la|Alta|[0-9]+|Dos|west|east|^.)$/i', $temp)) continue;
			$temp_value_array[] = $temp;							// get word
		}
		//echo '<br />first => 180: $temp_value_array:<br />';
		//print_r($temp_value_array);
	
		/*************************************************************************
		*
		*		Add myPurpleIcon icons
		*
		*************************************************************************/
		//echo '<br />188: lat_long_array:<br />';
		//print_r($lat_long_array);
		for ($latlong_index=0; $latlong_index < count($lat_long_array); $latlong_index++) {		// iterate all the way through latitude and longitude
			//echo $value_lat_long[$latlong_index] . '<br />';
			if (strpos($value_lat_long[$latlong_index], '{icon: myRedIcon}).addTo(mymap)')) continue;	// if myRedIcon continue
			$J_LN = $value_maps_array[$latlong_index];				// get language name
			// select language name by deleting everything around it!
			$match = [];
			preg_match_all('/(\w+)[-\,\(\)]?/u', $J_LN, $match);	// get the words $J_LN
			$temp_latlong_array = [];
			foreach ($match[1] as $temp) {
				if ($temp == $previous_CName) continue;
				if (preg_match('/^(on|the|and|of|south|north|northwest|northeast|Northwestern|Southwestern|Northeastern|Southeastern|southwest|southeast|southern|northern|Eastern|Western|central|Norte|sur|Sureste|Valley|river|Noroeste|Highland|Standard|Modern|de|del|Sta|santa|san|la|Alta|[0-9]+|Dos|west|east|^.)$/i', $temp)) continue;
				$temp_latlong_array[] = $temp;						// get word
			}
			if ($temp_value_array == $temp_latlong_array) {			// if arrays = each other
				continue;
			}
			//echo '<br />second => 206: $temp_latlong_array:<br />';
			//print_r($temp_latlong_array);
			//$array_result = [];
			//$array_result = array_intersect($temp_value_array, $temp_latlong_array);		// compare two arrays
			$o = 0;
			foreach($temp_value_array as $mmain) {					// compare myRedIcon words with interated words
				foreach($temp_latlong_array as $mcur) {
					/*if ($mmain == $mcur) {							// match so myPurpleIcon!
						$o = 1;
						break 2;
					}*/
					if ($mmain == $mcur) {							// match so myPurpleIcon!
						if (strpos($L_LN, ',') && strpos($J_LN, ',')) {
							if (substr($L_LN, 0, strpos($L_LN, ',')) == substr($J_LN, 0, strpos($J_LN, ','))) {
								$o = 1;
								break 2;						// break all of the way back to 2 foreach
							}
						}
						else {
							$o = 1;
							break 2;							// break all of the way back to 2 foreach
						}
					}
				}
			}
			//if (empty($array_result)) {
			//	
			//}
			//else {
			if ($o == 1) {
				$lat_long_array[$key_lat_long[$latlong_index]] = str_replace("]).addTo(mymap)", "], {icon: myPurpleIcon}).addTo(mymap)", $value_lat_long[$latlong_index]);
				//echo '$lat_long_array[$key_lat_long[$latlong_index]]: '.$lat_long_array[$key_lat_long[$latlong_index]].'<br />';
				//echo '<p>238: $value_lat_long[$latlong_index]: '.$value_lat_long[$latlong_index].'<br />';
				//echo '239: $lat_long_array[$L_ISO]: '.$lat_long_array[$L_ISO].'</p>';
				$value_lat_long = array_values($lat_long_array);	// create $value_lat_long from $lat_long_array only in (0 => lat_long, 1 => lat_long, etc.)
			}
		}		// end for
		//echo '<br />';
		//echo '<br />244: lat_long_array:<br />';
		//print_r($lat_long_array);
		
		/*************************************************************************
		*
		*		Write the html files for all of the ISOs on one country.
		*
		*************************************************************************/
		//echo '252: lat_long_array:<br />';
		//print_r($lat_long_array);
		$enter = '';
		$b=0;
		foreach($lat_long_array as $k => $I_ISO) {					// get string for body
			$enter .= $I_ISO;
		}

		$first_b = $first_a . "	<title>Language map of ".$previous_CName." - Leaflet</title>";		// write out just 1 ISO
		$first_d = $first_b . $first_c . "	var mymap = L.map('mapid').setView([".$s_lat_long."], 9);";
		$first = $first_d  . $first_e;
		//file_put_contents('maps/'.$previous_CName.'/'.$L_ISO.'.html', $first, LOCK_EX);
		//file_put_contents('maps/'.$previous_CName.'/'.$L_ISO.'.html', $enter, FILE_APPEND | LOCK_EX);
		//file_put_contents('maps/'.$previous_CName.'/'.$L_ISO.'.html', $end, FILE_APPEND | LOCK_EX);
		// top of this htm file
		file_put_contents('maps/'.$previous_CC.'/'.$L_ISO.'.htm', $first, LOCK_EX);
		// body of this htm file
		file_put_contents('maps/'.$previous_CC.'/'.$L_ISO.'.htm', $enter, FILE_APPEND | LOCK_EX);
		// bottom of this htm file
		file_put_contents('maps/'.$previous_CC.'/'.$L_ISO.'.htm', $end, FILE_APPEND | LOCK_EX);

		$first = '';
		$enter = '';
		//$maps_array = [];
		//$key_maps_array = [];											// create $key_maps_array from $maps_array only in (0 => ISO, 1 => ISO, etc.)
		//$value_maps_array = [];										// create $value_maps_array from $maps_array only in (0 => LN, 1 => LN, etc.)
		$lat_long_array = $save_lat_long;							// lat_long template
		$key_lat_long = array_keys($lat_long_array);				// IMPORTANT! array_keys AND array_arrays must be AGIAN set to $lat_long_array
		$value_lat_long = array_values($lat_long_array);
	}
	//echo '<br />';
	$maps_array = [];
	$lat_long_array = [];
	$save_lat_long = [];
	$previous_CC = $ISO_Country;
	$previous_CName = $English_Country;
}
?>
<h1>End</h1>
</body>
</html>