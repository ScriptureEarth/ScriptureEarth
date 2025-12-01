<?php
/*
	This script seems to have a problem running on the server so run on the local harddrive and then copy to the server.

	The is the first PHP to run. The next is to run leafletjs_maps-insertROD_Code.php.
	
	This script reads from ISO_Lang_Countries, countries, LN_English, and leafletjs_maps tables.
	
	This script writes to file_put_contents('maps/[CC]/[ISO].htm', ...)
*/
?>
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
			width: 800px;
			/*width: 800px;*/
			height: 580px;
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
		attribution: 'language names: <a href="https://www.scriptureearth.org/00eng.php">Scripture Earth</a>, ' +
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

$stmt_subfamily=$db->prepare("SELECT ISO, ROD_Code, Variant_Code, ISO_ROD_index, subfamily, LN_English, countryCodes FROM `subfamilies` WHERE `multipleCountries` = 1 ORDER BY `ISO`");
//$stmt_subfamily->bind_param('s', $ISO);											// bind parameters for markers from the `subfamilies` table for the ISO WHERE multipleCountries = 1 AND `ISO` = ? (only 1 ISO)
$stmt_subfamily->execute();													// execute query
$result_subfamily = $stmt_subfamily->get_result();
//if ($result_subfamily->num_rows > 0) {										// if ISO is found in the `subfamilies` table
while ($row_subfamily = $result_subfamily->fetch_array()) {
	$temp = $row_subfamily['ISO'];
	$ISOArray[] = $row_subfamily['ISO'];
	$ROD_CodeArray[$temp] = $row_subfamily['ROD_Code'];
	$Variant_CodeArray[$temp] = $row_subfamily['Variant_Code'];
	$ISO_ROD_indexArray[$temp] = $row_subfamily['ISO_ROD_index'];
	$subfamilyArray[$temp] = $row_subfamily['subfamily'];							// get the subfamily from the `subfamilies` table
	$LN_EnglishArray[$temp] = $row_subfamily['LN_English'];
	$countryCodesArray[$temp] = $row_subfamily['countryCodes'];				// get the countryCodes from the `subfamilies` table
}
$stmt_ISO=$db->prepare("SELECT `ISO` FROM `LN_English` WHERE `ISO_ROD_index` IS NOT NULL AND `ISO` = ?");	// select the ISO from LN_English to $maps_array
$stmt_LN=$db->prepare("SELECT `LN_English` FROM `LN_English` WHERE `ISO` = ?");		// select the language name from LN_English to $maps_array
$stmt_lat_long=$db->prepare("SELECT `latitude`, `longitude`, `name`, `hid` FROM `leafletjs_maps` WHERE `hid` = ? AND `latitude` IS NOT NULL AND `longitude` IS NOT NULL");	// select the latitude, longitude, name, hid from leafletjs_maps to $lat_long_array and $save_lat_long
$stmt_subfamilieselect=$db->prepare("SELECT ISO, ROD_Code, Variant_Code, ISO_ROD_index, subfamily, LN_English, countryCodes FROM `subfamilies` WHERE `subfamily` = ? AND `multipleCountries` = 1 AND `ISO` <> ''");	// select the subfamily from the `subfamily` table for the ISO

$enter = '';																// output
$subfamily_files = '';														// output
$maps_array = [];															// key->ISO; value->LN from countries table
$lat_long_array = [];														// key->ISO; value->latitude & longitude `leafletjs_maps` table
$save_lat_long = [];														// key->ISO; value->latitude & longitude `leafletjs_maps` table
$s_lat_long = '';															// myRedIcon string = latitude & longitude
$previous_CC = '';															// previous ISO Country [CC]
$previous_CName = '';														// previous English country name
$subfamily_array = [];														// subfamily array
$match = [];																// preg_match
$i = 0;																		// boolean
$y = 0;																		// index

$query="SELECT `ISO_Lang_Countries`.`ISO`, `ISO_Lang_Countries`.`ISO_Country`, `countries`.`English` FROM `ISO_Lang_Countries`, `countries` WHERE `countries`.`ISO_Country` = `ISO_Lang_Countries`.`ISO_Country` ORDER BY `ISO_Lang_Countries`.`ISO_Country`";
$result=$db->query($query);
while ($row = $result->fetch_array()) {										// all 1 ISO and its country
	$ISO=$row['ISO'];														// [ISO]
	$ISO_Country=$row['ISO_Country'];										// ISO_Country [CC]
	$English_Country=$row['English'];										// English country name
	
	if ($i === 0) {															// the first record only
		$i = 1;																// boolean
		$previous_CC = $ISO_Country;										// previous ISO Country [CC]
		$previous_CName = $English_Country;									// previous English country name
		$subfamily_array = [];												// subfamily array
	}

	/**************************************************************************************************
	*
	*		Write the htm files for all of the ISOs on one country [CC].
	*
	**************************************************************************************************/
	elseif ($ISO_Country != $previous_CC) {									// when previous country doesn't equal the new country
		if (!is_dir('maps/'.$previous_CC)) {								// save the ISO_Country until further on
			mkdir('maps/'.$previous_CC);
		}

		/*********************************************************************************************
		*
		*		add all of the latitudes and longitudes to all of the ISOs of this country
		*
		*		$maps_array is the ISOs and language names
		*		$lat_long_array is the ISOs and latitudes and longitudes
		*
		*********************************************************************************************/
		//$temp = count($maps_array[0])-1;									// the previous column of the $maps_array
		$subfamily_array = [];
		$subfamily_files = '';
		$key_maps_array = array_keys($maps_array);							// create $key_maps_array from $maps_array only in (0 => ISO, 1 => ISO, etc.)
						//echo '<h3 style="color: navy; ">Country Code: '.$previous_CC.'; new count: '.count($maps_array).'</h3>';
		$value_maps_array = array_values($maps_array);						// create $value_maps_array from $maps_array only in (0 => LN, 1 => LN, etc.) from ISO and (LN_English or subfamilies) form countries table
		for ($z=0; $z < count($lat_long_array); $z++) {						// add all of the lat.'s and long.'s to all of the ISOs of this country
			$key_lat_long = array_keys($lat_long_array);					// create $key_lat_long from $lat_long_array only in (0 => ISO, 1 => ISO, etc.)
			$value_lat_long = array_values($lat_long_array);				// create $value_lat_long from $lat_long_array only in (0 => lat_long, 1 => lat_long, etc.)
			//echo '<br />140<br />';
			//print_r($key_maps_array);
			$enter = '';
			$temp_value_array = [];
			//echo '<br />144: lat_long_array:<br />';
			//print_r($lat_long_array);
			//echo '<h3 style="color: blue; ">count($lat_long_array): '.count($lat_long_array).'</h3>';
echo '<h2 style="color: blue; ">Country Code: '.$previous_CC.'; count: '.count($maps_array).'</h2>';
			for ($y=0; $y < count($lat_long_array); $y++) {					// add all of the lat.'s and long.'s to all of the ISOs of this country
/*if ($previous_CC === 'ER') {
echo '0) lat_long_array:<br />';
print_r($lat_long_array);
echo '<br />';
}*/
				$L_ISO = $key_lat_long[$y];									// ISO and more
				$L_LN = $value_maps_array[$y];								// get language name
				//echo 'y: '.$y.' $L_ISO: '.$L_ISO.' $L_LN: '.$L_LN.'<br />';
//echo '<h2>Country Code: '.$previous_CC.'; L_ISO: '.$L_ISO.'.htm'.'; L_LN: '.$L_LN.'; $y: '.$y.'</h2>';
				/*************************************************************************
				*
				*		Add myRedIcon icon
				*
				*************************************************************************/
				$stmt_ISO->bind_param('s', $L_ISO);							// bind parameters for markers
				$stmt_ISO->execute();										// execute query
				$result_ISO = $stmt_ISO->get_result();
				//echo '$key_lat_long[$y]: '.$value_lat_long[$y].'<br />';
				preg_match("/L.marker\(\[([-0-9\., ]+)\]\)\.addTo/", $value_lat_long[$y], $match);	// lat and long
				$s_lat_long = $match[1];									// save lat and long
				if (empty($result_ISO->num_rows) || $result_ISO->num_rows == 0) {
					$lat_long = "	L.marker([$s_lat_long], {icon: myRedIcon}).addTo(mymap)\n";
					$lat_long .= "	.bindPopup(\"<b>$L_LN - ISO 639-3: $L_ISO</b>\").openPopup();\n";
				} 
				else {
					$lat_long = "	L.marker([$s_lat_long], {icon: myRedIcon}).addTo(mymap)\n";
					$lat_long .= "	.bindPopup(\"<b>$L_LN - ISO 639-3: $L_ISO</b><br />ScriptureEarth (<a target='_top' href='https://www.scriptureearth.org/00eng?iso=$L_ISO'>$L_LN</a>)\").openPopup();\n";
				}
				$lat_long_array[$L_ISO] = $lat_long;
				//$key_lat_long = array_keys($lat_long_array);				// create $key_lat_long from $lat_long_array only in (0 => ISO, 1 => ISO, etc.)
				$value_lat_long = array_values($lat_long_array);			// create $value_lat_long from $lat_long_array only in (0 => lat_long, 1 => lat_long, etc.)
				// select language name by deleting everything around it!
				$temp_value_array = [];
				$match = [];
				//preg_match_all('/(\w+)[-\,\(\)]?/u', $L_LN, $match);		// get the words $L_LN
				preg_match_all('/(\w+)/u', $L_LN, $match);					// get the words $L_LN
				foreach ($match[1] as $temp) {
					if ($temp == $previous_CName) continue;
					if (preg_match('/^(on|the|and|of|south|north|northwest|northeast|Northwestern|Southwestern|Northeastern|Southeastern|southwest|southeast|southern|northern|Eastern|Western|central|Norte|sur|Sureste|Valley|river|Noroeste|Highland|Standard|Modern|de|del|Sta|santa|san|la|Alta|[0-9]+|Dos|west|east|^.)$/i', $temp)) continue;
					$temp_value_array[] = $temp;							// get word
				}
				//echo '<br />first => 180: $temp_value_array:<br />';
			
				/*************************************************************************
				*
				*		Add myPurpleIcon icons
				*
				*************************************************************************/
				//echo '<br />188: lat_long_array:<br />';
				//print_r($lat_long_array);
				// $lat_long_array = array of $lat_long_array[$ISO] = $lat_long from `leafletjs_maps` table
				// $value_lat_long = array of '...addTo(mymap)...'
				// $value_maps_array = array of LN
				// $latlong_index index for $value_lat_long array and $value_maps_array
				// $temp_latlong_array = array of words in LN
				// $temp_value_array = array of words in LN
/*if ($L_ISO === 'acw') {
echo '<h2 style="color: darkblue; ">L_ISO (key_lat_long[$y]): '.$L_ISO.'; L_LN (value_maps_array[$y]): '.$L_LN.'</h2>';
}*/
				/*************************************************************************
				*		just looks through the $lat_long_array to see if there are any subfamilies
				*************************************************************************/
				for ($latlong_index=0; $latlong_index < count($lat_long_array); $latlong_index++) {		// iterate all the way through latitude and longitude
/*if ($L_ISO === 'acw') {
echo 'lat_long_array:<br />';
print_r($lat_long_array);
echo '<br />';
}*/
					//echo $value_lat_long[$latlong_index] . '<br />';
					if (strpos($value_lat_long[$latlong_index], '{icon: myRedIcon}).addTo(mymap)')) continue;	// if myRedIcon continue
					$J_LN = $value_maps_array[$latlong_index];				// get language name
/*if ($L_ISO === 'acw') {
echo '<h3 style="color: purple; ">J_LN: '.$J_LN.'</h3>';
}*/
					// select language name by deleting everything around it!
					$match = [];
					$temp_latlong_array = [];
					//preg_match_all('/(\w+)[-\,\(\)]?/u', $J_LN, $match);	// get the words $J_LN
					preg_match_all('/(\w+)/u', $J_LN, $match);				// get the words $J_LN
					foreach ($match[1] as $temp) {
						if ($temp == $previous_CName) continue;
						if (preg_match('/^(on|the|and|of|south|north|northwest|northeast|Northwestern|Southwestern|Northeastern|Southeastern|southwest|southeast|southern|northern|Eastern|Western|central|Norte|sur|Sureste|Valley|river|Noroeste|Highland|Standard|Modern|de|del|Sta|santa|san|la|Alta|[0-9]+|Dos|west|east|^.)$/i', $temp)) continue;
						$temp_latlong_array[] = $temp;						// get word from LN
					}
					//if ($temp_value_array === $temp_latlong_array) {		// if arrays for LN of words = each other
						//continue;
					//}
/*if ($L_ISO === 'acw') {
echo '<h3 style="color: blue; ">J_LN: '.$J_LN.'</h3>';
}*/
					//echo '<br />second => 206: $temp_latlong_array:<br />';
//echo '<h3 style="color: red; ">$temp_value_array != $temp_latlong_array!; J_LN (value_maps_array[$latlong_index]): '.$J_LN.'</h2>';
//echo 'temp_value_array: <br />';
//print_r($temp_value_array);
//echo '<br />temp_latlong_array: <br />';
//print_r($temp_latlong_array);
//echo '<br />';
					//$array_result = [];
					//$array_result = array_intersect($temp_value_array, $temp_latlong_array);		// compare two arrays
					$o = 0;
					foreach($temp_value_array as $mmain) {					// compare words with interated words
/*if ($L_ISO === 'acw') {
echo '<p style="color: brown; ">mmain: '.$mmain.'</p>';
}*/
						foreach($temp_latlong_array as $mcur) {
//if ($L_ISO === 'bcc') {
//	echo '<h2 style="color: darkgreen; ">ISO: '.$L_ISO.'</h2>';
//	print_r($temp_value_array);
//}
/*if ($L_ISO === 'acw') {
echo '<p style="color: green; ">mcur: '.$mcur.'</p>';
}*/
							/*if ($mmain == $mcur) {							// match so myPurpleIcon!
								$o = 1;
								break 2;
							}*/
							if ($mmain == $mcur) {							// match so myPurpleIcon!
//echo '<h3>mmain: '.$mmain.' == mcur: '.$mcur.'<br />';
//echo 'L_LN: '.$L_LN.'; J_LN: '.$J_LN.'</h3>';
								if (strpos($L_LN, ',') && strpos($J_LN, ',')) {
									if (substr($L_LN, 0, strpos($L_LN, ',')) == substr($J_LN, 0, strpos($J_LN, ','))) {
										$o = 1;
										break 2;							// break all of the way back to 2 foreach
									}
								}
								else {
									$o = 1;
									break 2;								// break all of the way back to 2 foreach
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
/*if ($L_ISO === 'acw') {
echo '<h3 style="color: orange; ">'.$J_LN.'; Country Code: '.$previous_CC.'<br />';
echo 'value_lat_long[$latlong_index]: '.$value_lat_long[$latlong_index].'<br />';
echo 'lat_long_array[$key_lat_long[$latlong_index]]: '.$lat_long_array[$key_lat_long[$latlong_index]].'</h3>';
}*/
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
							subfamilies table
				*************************************************************************/
				// e.g.,:
				//  	ISO 	ROD_Code 	Variant_Code 	ISO_ROD_index 	subfamily 	LN_English 	multipleCountries 	countryCodes
				// 1 											0				Adi 				1 					CN IN
				// 2 	adi 	00000 							2075 			Adi 	Adi 		1 					CN IN
				// 3 	adl 	00000 							1714 			Adi 	Adi, Galo 	1 					IN
				$subfamily_files = '';
				$subfamily_array = [];
/*if ($L_ISO === 'acw') {
echo 'L_ISO: '.$L_ISO.'<br />';
print_r($key_maps_array);
echo '<br />';
}*/
				if (in_array($L_ISO, $key_maps_array)) {								// is ISO in $key_maps_array (ISO)?
					$stmt_subfamilieselect->bind_param('s', $subfamilyArray[$L_ISO]);		// bind parameters for markers from the `subfamilies` table for the subfamily
					$stmt_subfamilieselect->execute();										// execute query
					$result_subfamilieselect = $stmt_subfamilieselect->get_result();
					if ($result_subfamilieselect->num_rows > 0) {							// if subfamily is found in the `subfamily` table
						//echo '<p style="color: green; ">in_array ISO: '.$L_ISO.'; subfamily: '.$subfamilyArray[$L_ISO].'</p>';
						while ($row_subfamilieselect = $result_subfamilieselect->fetch_array()) {	// get the subfamily from the `subfamilies` table for the ISO
								$subfamilieselectISO = $row_subfamilieselect['ISO'];
/*if ($L_ISO === 'acw') {
echo 'subfamilieselectISO: '.$subfamilieselectISO.'<br />';
}*/
							if (!in_array($subfamilieselectISO, $key_maps_array)) {		// is subfamilies table by subfamily ISO NOT in the $key_maps_array
								if (in_array($subfamilieselectISO, $subfamily_array)) {
									continue;
								}
								$subfamilieselectLN = $row_subfamilieselect['LN_English'];
								$subfamily_array[] = $subfamilieselectISO;					// save array ISO
								$maps_array[$subfamilieselectISO] = $subfamilieselectLN;
								//echo '<span style="color: red; ">ISO: '.$subfamilieselectISO.'; Language Name: '.$subfamilieselectLN.'</span><br />';

								// get the latitude and longitude from the `leafletjs_maps` table for the ISO
								$latitude = '';
								$longitude = '';
								$stmt_lat_long->bind_param('s', $subfamilieselectISO);		// bind parameters for markers from the `leafletjs_maps` table for the ISO
								$stmt_lat_long->execute();								// execute query
								$result_map = $stmt_lat_long->get_result();				// get the latitude and longtude of the ISO
								if ($result_map->num_rows == 0) {						// if latitude etc. is not in `leafletjs_map` table then continues
									continue;
								}
								$r = $result_map->fetch_array();						// get the latitude and longitude from the `leafletjs_maps` table for the ISO
								$latitude=$r['latitude'];
								$longitude=$r['longitude'];
								//echo '<span style="color: purple; ">latitude: '.$latitude.'; longitude: '.$longitude.'</span><br />';
								
								$stmt_ISO->bind_param('s', $subfamilieselectISO);			// bind parameters for markers from the `LN_English` table for the ISO WHERE ISO_ROD_index IS NOT NULL
								$stmt_ISO->execute();									// execute query
								$result_ISO = $stmt_ISO->get_result();					// get the `LN_English` table for the ISO
								if ($result_ISO->num_rows == 0) {
									$lat_long = "	L.marker(["."$latitude, $longitude"."], {icon: myPurpleIcon}).addTo(mymap)\n";
									$lat_long .= "	.bindPopup(\"<b>$subfamilieselectLN - ISO 639-3: $subfamilieselectISO</b>\");\n";
								} 
								else {
									$lat_long = "	L.marker(["."$latitude, $longitude"."], {icon: myPurpleIcon}).addTo(mymap)\n";
									$lat_long .= "	.bindPopup(\"<b>$subfamilieselectLN - ISO 639-3: $subfamilieselectISO</b><br />ScriptureEarth (<a target='_top' href='https://www.scriptureearth.org/00eng.php?iso=$subfamilieselectISO'>$subfamilieselectLN</a>)\");\n";
								}
								$subfamily_files .= $lat_long;
								//echo '<span style="color: brown; ">$subfamilieselectISO: '.$subfamilieselectISO.'; $lat_long_array[$subfamilieselectISO]: '.$lat_long_array[$subfamilieselectISO].'</span><br />';
							}
						}
						//$save_lat_long = $lat_long_array;							// lat_long template
					}
				}
				/*************************************************************************
							end subfamilies table
				*************************************************************************/
				
				/*************************************************************************
				*
				*		Write the htm files for all of the ISOs on one country.
				*
				*************************************************************************/
				//echo '252: lat_long_array:<br />';
				//print_r($lat_long_array);
				$enter = '';
				$b=0;
				foreach($lat_long_array as $k => $I_ISO) {								// get string for body
					$enter .= $I_ISO;
				}

				$first_b = $first_a . "	<title>Language map of ".$previous_CName." - Leaflet</title>";		// write out just 1 ISO
				$first_d = $first_b . $first_c . "	var mymap = L.map('mapid').setView([".$s_lat_long."], 8);";		// 8 = zoom in the maps
				$first = $first_d  . $first_e;
				//file_put_contents('maps/'.$previous_CName.'/'.$L_ISO.'.html', $first, LOCK_EX);
				//file_put_contents('maps/'.$previous_CName.'/'.$L_ISO.'.html', $enter, FILE_APPEND | LOCK_EX);
				//file_put_contents('maps/'.$previous_CName.'/'.$L_ISO.'.html', $end, FILE_APPEND | LOCK_EX);
				// top of this htm file
				file_put_contents('maps/'.$previous_CC.'/'.$L_ISO.'.htm', $first, LOCK_EX);
				// subfamily_files
				if ($subfamily_files != '') {
					file_put_contents('maps/'.$previous_CC.'/'.$L_ISO.'.htm', $subfamily_files, FILE_APPEND | LOCK_EX);
				}
				// body of this htm file
				file_put_contents('maps/'.$previous_CC.'/'.$L_ISO.'.htm', $enter, FILE_APPEND | LOCK_EX);
				// bottom of this htm file
				file_put_contents('maps/'.$previous_CC.'/'.$L_ISO.'.htm', $end, FILE_APPEND | LOCK_EX);

				$first = '';
				$enter = '';
				//$key_maps_array = [];													// create $key_maps_array from $maps_array only in (0 => ISO, 1 => ISO, etc.)
				//$value_maps_array = [];												// create $value_maps_array from $maps_array only in (0 => LN, 1 => LN, etc.)
				$lat_long_array = $save_lat_long;										// lat_long template
				$key_lat_long = array_keys($lat_long_array);							// IMPORTANT! array_keys AND array_arrays must be AGIAN set to $lat_long_array
				$value_lat_long = array_values($lat_long_array);
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
	*		first, save $latitude, $longitude in an array
	*
	***************************************************************************************************/
	$stmt_lat_long->bind_param('s', $ISO);									// bind parameters for markers from the `leafletjs_maps` table for the ISO
	$stmt_lat_long->execute();												// execute query
	$result_map = $stmt_lat_long->get_result();								// get the latitude and longtude of the ISO
	if ($result_map->num_rows == 0) {										// if latitude etc. is not in leafletjs table then continues
/*if ($L_ISO === 'acw') {
echo '$result_map - no record for '.$ISO.'<br />';
}*/
		continue;
	}

	/**************************************************************************************************
			get latitude and longitude
	***************************************************************************************************/
	$r = $result_map->fetch_array();										// get the latitude and longitude from the `leafletjs_maps` table for the ISO
	$latitude=$r['latitude'];
	$longitude=$r['longitude'];
	//$hid=$r['hid'];
	//if ($ISO == $hid) {
		//// ?
	//}
	
	/**************************************************************************************************
			add the LN to $maps_array[$ISO]
	***************************************************************************************************/
	$stmt_LN->bind_param('s', $ISO);										// bind parameters for markers from the LN_English table for the ISO
	$stmt_LN->execute();													// execute query
	$result_LN = $stmt_LN->get_result();
	if ($result_LN->num_rows === 0) {
		$LN=$r['name'];														// $LN is the language name for the `leafletjs_maps` table
	}
	else {
		$row_LN = $result_LN->fetch_array();								// LN_English table
		$LN=$row_LN['LN_English'];											// $LN is the language name for the `LN_English` table
	}
	$maps_array[$ISO] = $LN;												// push the ISO and language name ($LN) into the $maps_array

	/**************************************************************************************************
			add phrase record to $lat_long_array[$ISO] = $lat_long ($latitude, $longitude, $LN, $ISO)
	***************************************************************************************************/
	$stmt_ISO->bind_param('s', $ISO);										// bind parameters for markers from the `LN_English` table for the ISO WHERE ISO_ROD_index IS NOT NULL
	$stmt_ISO->execute();													// execute query
	$result_ISO = $stmt_ISO->get_result();
	if ($result_ISO->num_rows === 0) {
		$lat_long = "	L.marker(["."$latitude, $longitude"."]).addTo(mymap)\n";
		$lat_long .= "	.bindPopup(\"<b>$LN - ISO 639-3: $ISO</b>\");\n";
	}
	else {
		$lat_long = "	L.marker(["."$latitude, $longitude"."]).addTo(mymap)\n";
		$lat_long .= "	.bindPopup(\"<b>$LN - ISO 639-3: $ISO</b><br />ScriptureEarth (<a target='_top' href='https://www.scriptureearth.org/00eng.php?iso=$ISO'>$LN</a>)\");\n";
	}
	$lat_long_array[$ISO] = $lat_long;										// add the latitude and longitude to $lat_long_array
/*if ($ISO === 'acw') {
echo 'lat_long_array:<br />';
print_r($lat_long_array);
echo '<br />';
}*/

	$save_lat_long[$ISO] = $lat_long;										// save the latitude and longitude to $save_long_array

	// get the next latitudes and longitudes to $lat_long_array until the next country
}


// Last step for the last country
if (!is_dir('maps/'.$ISO_Country)) {
	mkdir('maps/'.$ISO_Country);
}

/********************************************************************************
*
*		add all of the lat.'s and long.'s to all of the ISOs of this country
*
********************************************************************************/
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
			$lat_long .= "	.bindPopup(\"<b>$L_LN - ISO 639-3: $L_ISO</b><br />ScriptureEarth (<a target='_top' href='https://www.scriptureearth.org/00eng.php?iso=$L_ISO'>$L_LN</a>)\").openPopup();\n";
		}
		$lat_long_array[$L_ISO] = $lat_long;
		//$key_lat_long = array_keys($lat_long_array);				// create $key_lat_long from $lat_long_array only in (0 => ISO, 1 => ISO, etc.)
		$value_lat_long = array_values($lat_long_array);			// create $value_lat_long from $lat_long_array only in (0 => lat_long, 1 => lat_long, etc.)
		// select language name by deleting everything around it!
		$temp_value_array = [];
		$match = [];
		preg_match_all('/(\w+)/u', $L_LN, $match);		// get the words $L_LN
		foreach ($match[1] as $temp) {
			if ($temp == $previous_CName) continue;
			if (preg_match('/^(on|the|and|of|south|north|northwest|northeast|Northwestern|Southwestern|Northeastern|Southeastern|southwest|southeast|southern|northern|Eastern|Western|central|Norte|sur|Sureste|Valley|river|Noroeste|Highland|Standard|Modern|de|del|Sta|santa|san|la|Alta|[0-9]+|Dos|west|east|^.)$/i', $temp)) continue;
			$temp_value_array[] = $temp;							// get word
		}
		//echo '<br />first => 180: $temp_value_array:<br />';
	
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
			preg_match_all('/(\w+)/u', $J_LN, $match);	// get the words $J_LN
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
		*		Write the htm files for all of the ISOs on one country.
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
		$first_d = $first_b . $first_c . "	var mymap = L.map('mapid').setView([".$s_lat_long."], 8);";
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