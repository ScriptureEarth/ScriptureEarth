<?php
/*
	This takes a VERY long time! At least more than one day!
	
	This script seems to have a problem running on the server so run on the local harddrive and then copy to the server.

	This is the first PHP to run. The next is to run leafletjs_maps-insert-qqq.php.
	
	This script reads from:
		ISO_Lang_Countries table
		countries table
		LN_English table
		leafletjs_maps table
		subgroups table
	 
	This script writes to:
		file_put_contents('maps/[CC]/[ISO].htm', ...) html files
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
<?php

echo '<h2 style="color: green; ">Starting...</h2>';

require_once './include/conn.inc.php';							// connect to the database named 'scripture'
$db = get_my_db();

if (!is_dir('maps')) {
	mkdir('maps');
}

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

/************************************************************************************************************************
	Create SELECT: ISO_Lang_Countrie, countries, LN_English, leafletjs_maps, and subgroups tables
************************************************************************************************************************/
if (isset($_GET['cc']) && $cc = $_GET['cc']) {
	$stmt_AllCC=$db->prepare("SELECT DISTINCT `ISO_Country` FROM `ISO_Lang_Countries` WHERE `ISO_Country` = '$cc' ORDER BY `ISO_Country`");					// All DISTICT cc field from ISO_Lang_Countries table
}
else {
	$stmt_AllCC=$db->prepare("SELECT DISTINCT `ISO_Country` FROM `ISO_Lang_Countries` ORDER BY `ISO_Country`");					// All DISTICT cc field from ISO_Lang_Countries table
}

$stmt_Country=$db->prepare("SELECT `ISO`, `ISO_Country` FROM `ISO_Lang_Countries` WHERE `ISO_Country` = ? ORDER BY `ISO`");	// All ISOs per country

$stmt_CountryEnglish=$db->prepare("SELECT `English` FROM `countries` WHERE `ISO_Country`= ?");								// get a country with ISO_Country (CC)
$stmt_ISO=$db->prepare("SELECT `ISO` FROM `LN_English` WHERE `ISO_ROD_index` IS NOT NULL AND `ISO` = ?");					// select the ISO from LN_English to $maps_array
$stmt_LN=$db->prepare("SELECT `LN_English` FROM `LN_English` WHERE `ISO` = ?");												// select the language name from LN_English to $maps_array

$stmt_lat_long=$db->prepare("SELECT `latitude`, `longitude`, `name`, `hid` FROM `leafletjs_maps` WHERE `hid` = ? AND `latitude` IS NOT NULL AND `longitude` IS NOT NULL");	// select the latitude, longitude, name, hid from leafletjs_maps to $lat_long_array and $save_lat_long

$stmt_getSubgroup=$db->prepare("SELECT ISO, subgroup FROM `subgroups` WHERE `ISO` = ?");									// select `subgroup` from the `subgroups` table in ISO

$stmt_ISO_Country=$db->prepare("SELECT DISTINCT `ISO` FROM `ISO_Lang_Countries` WHERE `ISO_Country` = ? AND `ISO` <> ? ORDER BY `ISO`");	// get ISO codes from CC using ISO_Lang_Countries table
//$stmt_ISO_Subgroup=$db->prepare("SELECT DISTINCT `ISO` FROM `subgroups` WHERE `subgroup` = ? AND `countryCodes` LIKE ? AND `ISO` <> '' ORDER BY `ISO`");	// get ISO codes from subgroup using subgroups table
$stmt_ISO_Subgroup=$db->prepare("SELECT DISTINCT `ISO` FROM `subgroups` WHERE `subgroup` = ? AND `ISO` <> '' ORDER BY `ISO`");	// get ISO codes from subgroup using subgroups table

/************************************************************************************************************************
	Create variables
************************************************************************************************************************/
$CC = '';
$ISO = '';
$mainISO = '';

$stmt_AllCC->execute();												// execute query for All DISTICT cc field from ISO_Lang_Countries table
$result_AllCC = $stmt_AllCC->get_result();							// get the CC fields
if ($result_AllCC->num_rows == 0) {									// if CC field is not in `ISO_Lang_Countrie` table then exit
	exit;
}

/************************************************************************************************************************

	main program: All SELECT DISTINCT `ISO_Country` FROM `ISO_Lang_Countries` ORDER BY `ISO_Country`
	
************************************************************************************************************************/
// SELECT DISTINCT `ISO_Country` FROM `ISO_Lang_Countries` ORDER BY `ISO_Country`	// All DISTICT cc field from ISO_Lang_Countries table
while ($rowAllCC = $result_AllCC->fetch_array()) {					// All CCs
	$CC = $rowAllCC['ISO_Country'];									// iterate through all countries
	$stmt_Country->bind_param('s', $CC);							// bind parameters for DISTICT cc field
	$stmt_Country->execute();										// execute query
	$result_Country = $stmt_Country->get_result();
	if ($result_Country->num_rows === 0) {
		echo '<h3 style="color: red; ">' . $CC . ' country is not found. Continuing...</h3>';
		continue;
	}
	
	if (!is_dir('maps/'.$CC)) {										// save the ISO_Country
		mkdir('maps/'.$CC);
	}	
	
	/******************************************************************************************************
	*
	*		get the CCs (country codes)
	*
	*******************************************************************************************************/
	// SELECT `ISO`, `ISO_Country` FROM `ISO_Lang_Countries` WHERE `ISO_Country` = ? ORDER BY `ISO`		// all the main ISO fields for this CC field from ISO_Lang_Countries table
	while ($row_Country = $result_Country->fetch_array()) {			// get all the main ISO fields from the `ISO_Lang_Countries` table
		$resultsCountry = [];
		$resultsSubgroup = [];
		//$mainIndex = 0;
		//$index = 1;
		$lat_long = '';
		$fileISO = '';
		$red_lat_long = '';
		$numberCountry = 1;
		$numberSubgroup = 0;
		$subgroup = '';
		
		echo '<h3 style="color: blue; ">Beginning Numbers</h3>';
		
		//$mainIndex++;												// number of main index ISOs
		//if ($mainIndex == 1) {									// All ISOs for this country in $results array
			$ISO = $row_Country['ISO'];
			$resultsCountry[] = $ISO;								// this is imporant!
			echo "<div style='color: darkred; '>All language Dist_ISO_Country: $ISO</div>";
			if ($mainISO != $ISO) {
				//	SELECT `ISO` FROM `ISO_Lang_Countries` WHERE `ISO_Country` = ? AND `ISO` <> ? ORDER BY `ISO`
				$stmt_ISO_Country->bind_param('ss', $CC, $ISO);			// bind parameters for markers from the ISO_Lang_Countries table for the ISO_Country
				$stmt_ISO_Country->execute();							// execute query
				$result_ISO_Country = $stmt_ISO_Country->get_result();
				while ($row_ISO_Country = $result_ISO_Country->fetch_array()) {
					$resultsCountry[] = $row_ISO_Country['ISO'];		// save ISO in results Country array
					$numberCountry++;
					//echo "<div style='color: darkred; '>All language Dist_ISO_Country: ".$row_ISO_Country['ISO']."</div>";
				}
				$mainISO = $ISO;
			}
			echo "<div style='color: darkred; '>Total Language number: ".$numberCountry."</div>";

			// SELECT `ISO` FROM `subgroups` WHERE `subgroup` = ? AND `countryCodes` NOT LIKE ? AND `ISO` <> '' ORDER BY `ISO`
			$stmt_getSubgroup->bind_param('s', $ISO);
			$stmt_getSubgroup->execute();							// execute query
			$result_getSubgroup = $stmt_getSubgroup->get_result();
			if ($result_getSubgroup->num_rows > 0) {
				$row_getSubgroup = $result_getSubgroup->fetch_array();
				$subgroup = $row_getSubgroup['subgroup'];
				//$temp = '%'.$CC.'%';								// Country Code (I'm not sure if I want to do this.) I agree!
				//$stmt_ISO_Subgroup->bind_param('ss', $subgroup, $temp);	// bind parameters for markers from the LN_English table for the ISO
				$stmt_ISO_Subgroup->bind_param('s', $subgroup);		// bind parameters for markers from the LN_English table for the ISO
				$stmt_ISO_Subgroup->execute();						// execute query
				$result_ISO_Subgroup = $stmt_ISO_Subgroup->get_result();
				if ($result_ISO_Subgroup->num_rows > 0) {
					echo "<div style='color: darkgreen; font-size: 14pt; font-weight: bold; '>subgroup: ".$subgroup."</div>";
					while ($row_ISO_Subgroup = $result_ISO_Subgroup->fetch_array()) {
						$tempISO = $row_ISO_Subgroup['ISO'];
						if (in_array($tempISO, $resultsCountry) === true) {
							//echo 'country. Before deleting ['.$tempISO.']:<br />';
							//print_r($resultsCountry);
							//echo '<br />';
							$y=0;									// delete an Country array element
							foreach ($resultsCountry as $x) {
								if ($x == $tempISO) {
									break;
								}
								$y++;
							}
							//unset($resultsCountry[$y]);			// does NOT reindexes
							array_splice($resultsCountry, $y, 1);	// delete and reindexes automatically
							$numberCountry--;
//							echo 'country. After deleting ['.$tempISO.']:<br />';
							//print_r($resultsCountry);
							//echo '<br />';
							$resultsSubgroup[] = $tempISO;			// save ISO in Subgroup results array
							//echo "<div style='color: darkgreen; '>subgroup Dist_ISO_Subgroup: $tempISO</div>";
//							echo 'subgroup. Now '.$tempISO.':<br />';
							//print_r($resultsSubgroup);
							//echo '<br />';
						}
						else {
							$resultsSubgroup[] = $row_ISO_Subgroup['ISO'];
							//echo "<div style='color: darkgreen; '>subgroup Dist_ISO_Subgroup: ".$row_ISO_Subgroup['ISO']."</div>";
						}
						$numberSubgroup++;
					}
					echo "<div style='color: darkgreen; '>Total subgroup Dist_ISO_Subgroup: ".$numberSubgroup."</div>";
				}
			}
			echo "<h3 style='color: orange; '>All Total Language number: ".$numberCountry + $numberSubgroup."<br />";
			echo "CC= $CC; ISO = $ISO</h3>";
		//}
		// print_r($resultsSubgroup);
		// echo '<br />';

		$results = array_merge($resultsCountry, $resultsSubgroup);	// marge the $results array 
		//echo 'All the sub ISOs for '.$ISO.':<br />';
		//print_r($results);
		//echo '<br />';
		
		$fileISO = $ISO;											// main ISO = $fileISO is the Red icon and the filename below
		
		/******************************************************************************************************
		*
		*		individual ISO code; sub ISO codes from here. An ISO code filename composed of ISO codes in the country and subgroups
		*
		*******************************************************************************************************/
		foreach ($results as $ISO) {								// get the ISO field from the `ISO_Lang_Countries` table for CC (including subgroup!)
			/**************************************************************************************************
					get latitude and longitude
			***************************************************************************************************/
			$stmt_lat_long->bind_param('s', $ISO);					// bind parameters for markers from the `leafletjs_maps` table for the ISO
			$stmt_lat_long->execute();								// execute query
			$result_lat_long = $stmt_lat_long->get_result();		// get the latitude and longtude of the ISO
			if ($result_lat_long->num_rows === 0) {					// if latitude etc. is not in leafletjs table then continues
				continue;
			}
			$r = $result_lat_long->fetch_array();					// get the latitude and longitude from the `leafletjs_maps` table for the ISO
			$latitude=$r['latitude'];
			$longitude=$r['longitude'];
			$ll = $latitude . ', ' . $longitude;

			/**************************************************************************************************
					get the LN FROM `LN_English`
			***************************************************************************************************/
			$stmt_LN->bind_param('s', $ISO);						// bind parameters for markers from the LN_English table for the ISO
			$stmt_LN->execute();									// execute query
			$result_LN = $stmt_LN->get_result();
			if ($result_LN->num_rows === 0) {
				$LN=$r['name'];										// $LN is the language name for the `leafletjs_maps` table
			}
			else {
				$row_LN = $result_LN->fetch_array();				// LN_English table
				$LN=$row_LN['LN_English'];							// $LN is the language name for the `LN_English` table
			}
			
//			echo "CC=$CC; ISO=$ISO; LN=$LN; LL=$ll<br /";
			
//			if ($mainIndex == $index) {
			if ($fileISO == $ISO) {									// $fileISO = Red icon
				//$index++;
				//$fileISO = $ISO;
				$red_lat_long = $ll;
				
				echo '<h2 style="color: red; ">Creating the Red teardrop for ['.$ISO.']: '.$LN.'</h2>';
				/*******************************************************************************************************
				*
				*		Add myRedIcon icon
				*
				********************************************************************************************************/
				$stmt_ISO->bind_param('s', $ISO);					// bind parameters for markers
				$stmt_ISO->execute();								// execute query
				$result_ISO = $stmt_ISO->get_result();
				if ($result_ISO->num_rows === 0) {
					$lat_long .= "	L.marker([$ll], {icon: myRedIcon}).addTo(mymap)\n";
					$lat_long .= "	.bindPopup(\"<b>$LN - ISO 639-3: $ISO</b>\").openPopup();\n";
				} 
				else {
					$lat_long .= "	L.marker([$ll], {icon: myRedIcon}).addTo(mymap)\n";
					$lat_long .= "	.bindPopup(\"<b>$LN - ISO 639-3: $ISO</b><br />ScriptureEarth (<a target='_top' href='https://www.scriptureearth.org/00eng.php?iso=$ISO'>$LN</a>)\").openPopup();\n";
				}
			}
			else {
				if (in_array($ISO, $resultsSubgroup)) {
					//echo "<div style='color: green; '>subgroup: $subgroup</div>";
					/**************************************************************************************************
							the ISO IS in the subgroups table
					***************************************************************************************************/
//					echo '<div style="color: purple; ">Creating purple teardrop for ['.$ISO.']: '.$LN.'</div>';
					/**************************************************************************************************
					*
					*		Add myPurpleIcon icons
					*
					***************************************************************************************************/
					/**************************************************************************************************
								subgroups table
					***************************************************************************************************/
					// e.g.,:
					//  	ISO 	ROD_Code 	Variant_Code 	ISO_ROD_index 	subgroup 	LN_English 	multipleCountries 	countryCodes
					// 1 											0				Adi 				1 					CN IN
					// 2 	adi 	00000 							2075 			Adi 	Adi 		1 					CN IN
					// 3 	adl 	00000 							1714 			Adi 	Adi, Galo 	1 					IN
					
					/**************************************************************************************************
							get the ISO FROM `LN_English`
					***************************************************************************************************/
					$stmt_ISO->bind_param('s', $ISO);					// bind parameters for markers from the `LN_English` table for the ISO WHERE ISO_ROD_index IS NOT NULL
					$stmt_ISO->execute();								// execute query
					$result_ISO = $stmt_ISO->get_result();				// get the `LN_English` table for the ISO
					if ($result_ISO->num_rows == 0) {
						$lat_long .= "	L.marker([$ll], {icon: myPurpleIcon}).addTo(mymap)\n";
						$lat_long .= "	.bindPopup(\"<b>$LN - ISO 639-3: $ISO</b>\");\n";
					} 
					else {
						//while ($row_ISO = $result_ISO->fetch_array()) {	// LN_English table
							//$s_ISO = $row_ISO['ISO'];					// ISO is the language name for the `LN_English` table
							//$LN = $row_ISO['LN_English'];				// LN_English is the language name for the `LN_English` table
							$lat_long .= "	L.marker([$ll], {icon: myPurpleIcon}).addTo(mymap)\n";
							$lat_long .= "	.bindPopup(\"<b>$LN - ISO 639-3: $ISO</b><br />ScriptureEarth (<a target='_top' href='https://www.scriptureearth.org/00eng.php?iso=$ISO'>$LN</a>)\");\n";
						//}
					}
				}
				elseif (in_array($ISO, $resultsCountry)) {
//		print_r($resultsCountry);
//		echo '<br />';
					//echo "<div style='color: darkblue; '>ISOs: $ISO</div>";
					//echo "<div style='color: red; '>Blue: $ISO</div>";
					/**************************************************************************************************
							the ISO is NOT in the subgroups table
					***************************************************************************************************/
//					echo '<div style="color: blue; ">Creating blue teardrop for ['.$ISO.']: '.$LN.'</div>';
					/**************************************************************************************************
					*
					*		Add myBlueIcon icon
					*
					***************************************************************************************************/
					/**************************************************************************************************
							get the ISO FROM `LN_English`
					***************************************************************************************************/
					$stmt_ISO->bind_param('s', $ISO);					// bind parameters for markers from the `LN_English` table for the ISO WHERE ISO_ROD_index IS NOT NULL
					$stmt_ISO->execute();								// execute query
					$result_ISO = $stmt_ISO->get_result();
					if ($result_ISO->num_rows === 0) {
						$lat_long .= "	L.marker([$ll]).addTo(mymap)\n";
						$lat_long .= "	.bindPopup(\"<b>$LN - ISO 639-3: $ISO</b>\");\n";
					}
					else {
						$lat_long .= "	L.marker([$ll]).addTo(mymap)\n";
						$lat_long .= "	.bindPopup(\"<b>$LN - ISO 639-3: $ISO</b><br />ScriptureEarth (<a target='_top' href='https://www.scriptureearth.org/00eng.php?iso=$ISO'>$LN</a>)\");\n";
					}
				}
				else {
					echo "<h1 style='color: black; '>This isn't supposed to happen!</h1>";
					continue;
				}
			}
			
			/*********************************************************************************************************
			*
			*		Write the htm files for all of the ISOs on one country.
			*
			**********************************************************************************************************/
			$stmt_CountryEnglish->bind_param('s', $CC);						// bind parameters for markers from the `countries` table
			$stmt_CountryEnglish->execute();								// execute query
			$result_CountryEnglish = $stmt_CountryEnglish->get_result();	// get the `countries` table for ISO_Country
			if ($result_CountryEnglish->num_rows === 0) {
				echo "<h1 style='color: black; fonr-weight: bold; '>The English language name does not exist: $ISO<\h1>";
				$first_b = $first_a . "	<title>Language map of ZZZZZZZZZZZZZZZZ - Leaflet</title>";	// write out just 1 ISO
			}
			else {
				$row_CountryEnglish = $result_CountryEnglish->fetch_array();	// English field
				$first_b = $first_a . "	<title>Language map of ".$row_CountryEnglish['English']." - Leaflet</title>";	// write out just 1 ISO
			}
			$first_d = $first_b . $first_c . "	var mymap = L.map('mapid').setView([$red_lat_long], 8);";	// 8 = zoom in the maps
			$first = $first_d  . $first_e;
			// top of this htm file
			file_put_contents('maps/'.$CC.'/'.$fileISO.'.htm', $first, LOCK_EX);
			// Red, Purple, and Blue teardrops
			file_put_contents('maps/'.$CC.'/'.$fileISO.'.htm', $lat_long, FILE_APPEND | LOCK_EX);
			// bottom of this htm file
			file_put_contents('maps/'.$CC.'/'.$fileISO.'.htm', $end, FILE_APPEND | LOCK_EX);
		}
		echo '<h3 style="color: blue; ">End</h3><br />';
	}
}

echo '<h2 style="color: blue; ">Ending.</h2>';

function removeDiacritics($txt) {
    $transliterationTable = [
        'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
        'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
        'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
        'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
        'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
        'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
        'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r'];
	return strtr($txt, $transliterationTable);
}    // or, return str_replace(array_keys($transliterationTable), array_values($transliterationTable), $txt);

?>
<h1>End</h1>
</body>
</html>