<?php
/***************************************************************************************************************************

	I must log in to PuTTY (SEAdimn, Load, Open, Psalm139:14) and then execute 'sudo bash ISODataStats.sh' every month.
	  ====

***************************************************************************************************************************/
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Statistics for the dates/months/years/ISO codes from SE</title>
<script type="application/javascript">

var ISOs = [];
var CCs = [];
var ISOLink = [];

function data() {
	var select = document.getElementById('Year');
	// return the value of the selected option
	var Year = select.options[select.selectedIndex].value;
	var select = document.getElementById('Month');
	// return the value of the selected option
	var Month = select.options[select.selectedIndex].value;
	var select = document.getElementById('Country');
	// return the value of the selected option
	var Country = select.options[select.selectedIndex].value;
	var select = document.getElementById('ISO');
	// return the value of the selected option
	var ISO = select.options[select.selectedIndex].text;
	window.location.assign("ISODateStats.php?Year="+Year+"&Month="+Month+"&Country="+Country+"&ISO="+ISO+"&Num=1");
}

function CountryISOs() {
	var selCountry = document.getElementById('Country');
	var ISO_country = selCountry.value;
	var English = selCountry[selCountry.selectedIndex].text;
	var sel = document.getElementById('ISO');
	sel.innerHTML = '';
	var option = document.createElement("option");
	if (English.substring(0, 4) === 'All ') {
		option.value = 'All ISOs';
		option.text = 'All ISOs';
	}
	else {
		option.value = 'Approp';
		option.text = 'All ' + English + ' ISOs';
	}
	option.style = 'color: navy; ';
	sel.appendChild(option);
	if (English.substring(0, 4) === 'All ') {
		for (var i = 0; i < ISOs.length; i++) {
			var option = document.createElement("option");
			option.value = ISOs[i];
			option.text = ISOs[i];
			option.style = 'color: navy; ';
			sel.appendChild(option);
		}
	}
	else {
		for (var key in CCs) {
			if (CCs.hasOwnProperty(key)) {
				if (CCs[key][ISO_country]) {
// console.log(CCs[key][ISO_country]);
					var option = document.createElement("option");
					option.value = CCs[key][ISO_country];
					option.text = CCs[key][ISO_country];
					option.style = 'color: navy; ';
					sel.appendChild(option);
				}
			}
		}
	}
}

function linkes() {
	//var select = document.getElementById('Year');
	// return the value of the selected option
	//var Year = select.options[select.selectedIndex].value;
	//var select = document.getElementById('MonthLink');
	// return the value of the selected option
	//var Month = select.options[select.selectedIndex].value;
	var select = document.getElementById('CountryLink');
	// return the value of the selected option
	var Country = select.options[select.selectedIndex].value;
	var select = document.getElementById('ISOLink');
	// return the value of the selected option
	var ISO = select.options[select.selectedIndex].text;
	window.location.assign("ISODateStats.php?Country="+Country+"&ISO="+ISO+"&Num=2");
}

function CountryISOLink() {
	var selCountryLink = document.getElementById('CountryLink');
	var ISO_country_Link = selCountryLink.value;
	var English_Link = selCountryLink[selCountryLink.selectedIndex].text;
	var selLink = document.getElementById('ISOLink');
	selLink.innerHTML = '';
	var optionLink = document.createElement("option");
	if (English_Link.substring(0, 4) === 'All ') {
		optionLink.value = 'All ISOs';
		optionLink.text = 'All ISOs';
	}
	else {
		optionLink.value = 'Approp';
		optionLink.text = 'All ' + English_Link + ' ISOs';
	}
	optionLink.style = 'color: navy; ';
	selLink.appendChild(optionLink);
	if (English_Link.substring(0, 4) === 'All ') {
		for (var i = 0; i < ISOLink.length; i++) {
			var optionLink = document.createElement("option");
			optionLink.value = ISOLink[i];
			optionLink.text = ISOLink[i];
			optionLink.style = 'color: navy; ';
			selLink.appendChild(optionLink);
		}
	}
	else {
		for (var key in CCs) {
			if (CCs.hasOwnProperty(key)) {
				if (CCs[key][ISO_country_Link]) {
// console.log(CCs[key][ISO_country_Link]);
					var optionLink = document.createElement("option");
					optionLink.value = CCs[key][ISO_country_Link];
					optionLink.text = CCs[key][ISO_country_Link];
					optionLink.style = 'color: navy; ';
					selLink.appendChild(optionLink);
				}
			}
		}
	}
}
</script>
<style type="text/css">
	select {
		font-size: 13pt; 
	}
	option {
		font-size: 13pt; 
	}
	#chartKey {
		width: 400px;
		height: 449px;
		background-color: #369;
		position: fixed;
		z-index: 10;
		top: 100px;
		right: 0px;
	}
	#chartKey div {
		overflow: hidden;
		text-align: left;
		padding-left: 14px;
		color: white;
		font-size: 11pt;
		font-weight: normal;
		width: 380px;
		height: 435px;
		border: 1px solid red;
		position: relative;
		top: 6px;
		left: 5px;
	}
</style>
</head>
<body style='font-size: 14pt; text-align: center; font-family: Arial, Helvetica, sans-serif; '>
<?php

/************************************'*************************************************************************************

			Statistics for the dates/months/years/ISO codes from SE.

**************************************************************************************************************************/

require_once 'include/conn.inc.php';																// connect to the database named 'scripture'
$db = get_my_db();

if (isset($_GET['Num'])) {
	$Num = $_GET['Num'];
	if (!preg_match('/^\d$/', $Num)) {																// one number
		die('Hack!');
	}
	
	if ($Num == '1') {
		// Chart Key - position: fixed;
		echo '<div id="chartKey">
			<div>
				<!-- chart key -->
				<span style="font-size: 12pt; font-weight: bold; text-align: center; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Chart Key</span><br /><br />
				html : SE Synchronized text and audio<br />
				pdf : SE PDF<br />
				mp3 : SE audio<br />
				mp4 :  SE short Scripture video download<br />
				sfm/ptx : Viewer files<br />
				txt : Audio Playlist<br />
				en.txt : English Video Playlist<br />
				es.txt : Spanish Video Playlist<br />
				pt.txt : Portuguese Video Playlist<br />
				fr.txt : French Video Playlist<br />
				nl.txt : Dutch Video Playlist<br />
				jad/jar : GoBible (Java) mobile phone file<br />
				bbl.mybible : MySword (Android) mobile phone file<br />
				ot.exe : The Word Windows software<br />
				ot.Setup.exe : The Word Windows software<br />
				nt.exe : The Word Windows software<br />
				nt.Setup.exe : The Word Windows software<br />
				epub : Download epub<br />
				zip : Download SE PDF and SE audio file<br />
				apk : Download the Android App (Google Play)<br />
				webmanifest : Progressive Web Application (PWA)
				<br />
			</div> 
		</div>';
	
		$Year = $_GET['Year'];
		if (!preg_match('/^[0-9]{4}/', $Year)) {
			die('HACK! (1)');
		}
		$Year = substr($Year, 0, 4);
		
		$Month = htmlspecialchars($_GET['Month']);
		if (!preg_match('/^[A-Z][a-z]{2}/', $Month)) {
			die('HACK! (2)');
		}
		$Month = substr($Month, 0, 3);
		
		$ISO = htmlspecialchars($_GET['ISO']);																						// [a-z]{3} or also could be 'All ISOs'
		if (!preg_match('/^([a-z]{3}|All[-_ a-zA-Z0-9]+ISOs)$/', $ISO)) {
			die('HACK! (3)');
		}
		
		$Country = htmlspecialchars($_GET['Country']);																				// [A-Z]{2} or also could be 'All countries'
		if (!preg_match('/^([A-Z]{2}|All countries)$/', $Country)) {
			die('HACK! (4)');
		}
		
		$countryArray = [];
		$multiple = 0;
		$mult = [];
		if (preg_match("/^[a-z]/", $ISO)) {																							// does equal first letter in the ISO code (lower case)
			
		}
		else {		// 'All zzzzzz ISOs'
			if ($Country == 'All countries') {
				$query="SELECT DISTINCT ISO FROM ISO_countries ORDER BY ISO";														// collect all of the ISO codes in All countries in an array ($countryArray)
			}
			else {
				$query="SELECT DISTINCT ISO FROM ISO_countries WHERE '".$Country."' = ISO_countries ORDER BY ISO";					// collect all of the ISO codes in one $Country in an array ($countryArray)
			}
			$result = $db->query($query);
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$countryArray[] = $row['ISO'];
			}
			$multiple = 1;
		}			
		
		$ISO_temp = '';
	
		$array = [];
		$zip = 0;
		
		/*********************************************************************************************************************
			Next 2 lines need to be changed for the SE server.
				This wont work because the permissions can't be used from 'general user':
					first line: "../../../var/log/apache2/ScriptureEarth-access.log*"
					second line: "../../../var/log/apache2/ScriptureEarth-access.log' and "../../../var/log/apache2/ScriptureEarth-access.log.1"
				'general user':
					first line: "data/logged/ScriptureEarth-access.log*"
					second line: 'data/logged/ScriptureEarth-access.log' and 'data/logged/ScriptureEarth-access.log.1'
		**********************************************************************************************************************/
		foreach (glob("data/logged/scriptureearth.org-ssl_log-*.gz") as $filename) {
				$handle = gzopen($filename, 'r');
				$zip = 1;
			//Output a line of the log file until the end is reached
			while (($f = gzgets($handle)) !== false) {												// there's a bug, it seems, that eof doesn't work
				if (strpos($f, 'CFNetwork') !== false || strpos($f, 'robot') !== false || strpos($f, 'Wget') !== false || strpos($f, 'spider') !== false || strpos($f, ' bot') !== false || preg_match("#[Bb]ot[-; .\/]#", $f)) {
					continue;																										// if strlen = 3 the script only allows the ISO to go though
				}
				if (strpos($f, '.png ') !== false || strpos($f, '.js ') !== false || strpos($f, '.css ') !== false || strpos($f, '.ttf ') !== false || strpos($f, '.py ') !== false || strpos($f, '.bak ') !== false || strpos($f, '.msg ') !== false || strpos($f, '.odt ') !== false || strpos($f, '1_jf-0-0') !== false || strpos($f, '.ico ') !== false || strpos($f, '.jpg ') !== false || strpos($f, '.jpeg ') !== false || strpos($f, '.srt ') !== false) {
					continue;
				}
//				if (strlen($ISO) == 3 && $ISO != substr(preg_replace("/.*\/data\/([a-z]{3})\/.*/", '$1', $f), 0, 3)) {				// preg_replace needs to have a "string - 1" when there is a compare!
//					continue;																										// if strlen = 3 the script only allows the ISO to go though
//				}
				
				preg_match("/ \[([0-9]{2})\/([a-zA-Z]{3})\/([0-9]{4}):/", $f, $matches);									// Month and Year
				if (!isset($matches[3])) continue;
				$date = $matches[1];
				$month = $matches[2];
				$year = $matches[3];
				if ($year == $Year - 1) {
					break;
				}
				if ($year != $Year) {																								// not the year
					continue;
				}
				if ($month != $Month) {																								// not the month
					continue;
				}
				
				//if ($ISO == 'All ISOs' || preg_match("/^[a-z]/", $ISO)) {			$ISO == 'All ISOs' needs some work 12/8/17
				if (preg_match("/^[a-z]/", $ISO)) {
					if (preg_match("/.*\/data\/([a-z]{3})\/.*/", $f, $matches)) {
						if (!isset($matches[1])) continue;
						if ($ISO == $matches[1]) {
							$ISO_temp = $ISO;
						}
						else {
							continue;	
						}
					}
					else {
						if (preg_match("/00-CellPhoneModule\.php[a-zA-Z0-9&?=]*ISO=([a-z]{3})&/", $f, $matches)) {
							if (!isset($matches[1])) continue;
							if ($ISO != $matches[1]) {
								continue;	
							}
							$ISO_temp = $ISO;
						}
						else {
							continue;	
						}
					}
				}
				else {		// 'All $Country ISOs'
					$z = 0;
					if (preg_match("/.*\/data\/([a-z]{3})\/.*/", $f, $matches)) {
						if (!isset($matches[1])) continue;
						$ISOcode = $matches[1];																						// ISO code taken from /data/([a-z]{3} using a line from a log
						foreach ($countryArray as $rowISO) {																		// ISO code in the array $countryArray (which has the ISO codes in one $Country in an array ($countryArray))
							if ($rowISO == $ISOcode) {
								$z = 1;
								$ISO_temp = $rowISO;
								break;
							}
						}
					}
					elseif (preg_match("/00-CellPhoneModule\.php[a-zA-Z0-9&?=]*ISO=([a-z]{3})&/", $f, $matches)) {
						if (!isset($matches[1])) continue;
						$ISOcode = $matches[1];
						foreach ($countryArray as $rowISO) {																		// ISO code in the array $countryArray (which has the ISO codes in one $Country in an array ($countryArray))
							if ($rowISO == $ISOcode) {
								$z = 1;
								$ISO_temp = $rowISO;
								break;
							}
						}
					}
					if ($z == 0) {
						continue;
					}
				}
				
				//if (preg_match("/\?/", $f)) {																							// current line has a '?' ?
				//	continue;
				//}

				if (!preg_match("/\/data\/([a-z]{3})\//", $f, $matches)) {
					if (!preg_match("/00-CellPhoneModule\.php[a-zA-Z0-9&?=]*ISO=([a-z]{3})&/", $f, $matches)) {
						continue;
					}
				}

				if (!preg_match("/\/data\/[a-z]{3}\/[^\.]*\.([^ ]*) /", $f, $matches)) {
					if (!preg_match("/\.scriptoria\.[-.a-z0-9]*\/]([a-z]*) /", $f, $matches)) {										// if last character on current line isn't a ' ' go on script
						if (!preg_match("/00-CellPhoneModule\.php[-a-zA-Z0-9&?=_:.\/]*\/([a-z]*) /", $f, $matches)) {				// if last character on current line isn't a ' ' go on script
							continue;
						}
					}
				}
				
				if (!isset($matches[1]) || empty($matches[1])) continue;
				$play = $matches[1];																								// = extention zzz
				
				if ('apk' == substr($play, -3)) {
					$play = 'apk';
				}

				if (trim($play) === '' || preg_match("/[0-9]$/", $play) || preg_match("/^[0-9]/", $play) || preg_match("/=/", $play) || preg_match("/png$/i", $play) || preg_match("/js$/i", $play) || preg_match("/css/i", $play) || preg_match("/ttf$/i", $play) || preg_match("/(\\|\/|\'|\"|\?)/", $play) || preg_match("/py$/i", $play) || preg_match("/bak$/i", $play) || preg_match("/msg$/i", $play) || preg_match("/odt$/i", $play) || preg_match("/^\./", $play) || preg_match("/\.$/", $play) || preg_match("/1_jf-0-0/", $play) || preg_match("/ico$/", $play)) {
					if ($play === 'mp4' || $play === 'mp3') {
						//echo $f . ' #<br />';
					}
					else {
						continue;
					}
				}
				
				$play = strtolower($play);
	
				error_reporting(error_reporting() & ~E_NOTICE );
				$array[$ISO_temp][$play] = $array[$ISO_temp][$play] + 1;															// variant languages (the stats go up by 1)
				if ($multiple == 1) {
					$mult[$play] = $mult[$play] + 1;																				// country languages (the stats go up by 1)
				}
				error_reporting(error_reporting() & E_NOTICE );
			}
			($zip == 0 ? fclose($handle) : gzclose($handle));																		// close log file
		}
		
		ksort($array);																												// sort array by ISO codes ($array[ISO codes][exstessions for ])
		
		echo '<div style="text-align: left; ">';
		echo '<h1>' . $Month . ' ' . $Year . '</h1>';
		if ($Country == 'All countries') {
			echo '<h2>All countries</h2>';
		}
		else {
			$query = "SELECT English FROM countries WHERE ISO_Country = '$Country'";												// $Country is country code
			$result = $db->query($query);
			$row = $result->fetch_array(MYSQLI_ASSOC);
			$English = $row['English'];																								// name is English od $Country
			echo '<h2>' . $English . '</h2>';
		}
		if ($multiple == 1) {
			arsort($mult, SORT_NATURAL);																							// country languages (the stats go up by 1)
			if ($Country == 'All countries') {
				echo '<span style="font-weight: bold; ">Minority Languages of all of the countries</span><br />';
			}
			else {
				echo '<span style="font-weight: bold; ">Minority Languages of ' . $English . '</span><br />';
			}
			foreach ($mult as $key => $val) {
				echo "&nbsp;&nbsp;&nbsp;&nbsp;$key => $val<br />";
			}
			echo '<br />';
		}
		$stmt = $db->prepare("SELECT LN_English FROM LN_English WHERE ISO = ?");
		foreach ($array as $key => $val) {
			if ($Year) {
				$stmt->bind_param("s", $key);								// bind parameters for markers
				$stmt->execute();											// execute query
				$result = $stmt->get_result();								// instead of bind_result (used for only 1 record):
				$row = $result->fetch_array(MYSQLI_ASSOC);
				//$query = "SELECT LN_English FROM LN_English WHERE ISO = '$key'";
				//$result = $db->query($query);
				//$row = $result->fetch_array(MYSQLI_ASSOC);
				$LN_English = $row['LN_English'];
				echo "<span style='font-weight: bold; '>$key - $LN_English:</span><br />";											// echo ISO codes => English name for the variant lamguage name
				foreach ($val as $key2 => $val2) {																					// interate through $array be only get the same ISO code
					echo "&nbsp;&nbsp;&nbsp;&nbsp;$key2 => $val2<br />";
				}
			}
		}
		echo '</div>';
	}
	else {
		$ISO = htmlspecialchars($_GET['ISO']);																						// [a-z]{3} or also could be 'All ISOs' (ISO=All zzz ISOs)
		if (!preg_match('/^([a-z]{3}|All[-_ |a-zA-Z0-9]*ISOs)$/', $ISO)) {
			die('HACK! (1)');
		}
		
		$Country = htmlspecialchars($_GET['Country']);																				// [A-Z]{2} or also could be 'All countries'
		if (!preg_match('/^([A-Z]{2}|All countries)$/', $Country)) {
			die('HACK! (2)');
		}
		$ISO = htmlspecialchars($_GET['ISO']);																						// 
		
		$countryArray = [];
		$multiple = 0;
		if (preg_match("/^[a-z]/", $ISO)) {																							// does equal first letter in the ISO code (lower case)
			$countryArray[] = $ISO;
		}
		else {		// SELECT $Country to get the ISO codes'
			$query="SELECT DISTINCT ISO FROM ISO_countries WHERE '".$Country."' = ISO_countries ORDER BY ISO";						// ISO="Approp" collect all of the ISO codes in one country in an array
			$result = $db->query($query);
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$countryArray[] = $row['ISO'];																						// save the ISO codes into array $countryArray
			}
			$multiple = 1;																											// set $multiple = 1 to show that there are multiple ISO codes
		}			
		
		$ISO_temp = '';
		$mult = [];
		$array = [];

		$line = '';
		foreach($countryArray as $key => $value) {																					// interate through $countryArray (which contains ISO code(s))
			foreach (glob("counter/linkArchive/*".$countryArray[$key].".link") as $file) {											// file open $countryArray[$key].link
				// read the first line and store it into $
				$f = fopen($file, 'r');
				$array[] = substr($file, strlen('counter/linkArchive/')) . '	' . fgets($f);										// read the first line which contians the number for stats
				fclose($f);
			}
		}

		//ksort($array);
		
		echo '<div style="text-align: left; ">';
		$query = "SELECT English FROM countries WHERE ISO_Country = '$Country'";													// $Country is country code
		$result = $db->query($query);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$English = $row['English'];																									// name is English od $Country
		echo '<h2>' . $English . '</h2>';
		if ($multiple == 1) {
			echo '<span style="font-weight: bold; ">Minority Languages of ' . $English . '</span><br />';
			echo '<br />';
		}
		$lastISO = '';
		$stmt = $db->prepare("SELECT LN_English FROM LN_English WHERE ISO = ?");
		foreach ($array as $key => $val) {
			$ISO = preg_replace('/.*([a-z]{3})\.link.*/', '$1', $array[$key]);
			if ($ISO != $lastISO) {
				$lastISO = $ISO;
				$stmt->bind_param("s", $ISO);								// bind parameters for markers
				$stmt->execute();											// execute query
				$result = $stmt->get_result();								// instead of bind_result (used for only 1 record):
				$row = $result->fetch_array(MYSQLI_ASSOC);
				//$query = "SELECT LN_English FROM LN_English WHERE ISO = '$ISO'";													// echo ISO codes => English name for the variant lamguage name
				//$result = $db->query($query);
				//$row = $result->fetch_array(MYSQLI_ASSOC);
				$LN_English = $row['LN_English'];
				echo "<br /><span style='font-weight: bold; '>$ISO - $LN_English:</span><br />";
			}
			echo rtrim(substr($array[$key], 0 , strrpos($array[$key], '	')), '.link') . ' => ' . substr($array[$key], strpos($array[$key], '	')) . '<br />';		// interate through $array by only getting the same ISO code
		}
		if ($lastISO == '' && $multiple == 0) {
			echo 'None were found for ' . $ISO;
		}
		echo '</div>';
	}
}
else {
	$year = date("Y");
	$month = date("m");
	
	// select ISOs into a js array
	$query = "SELECT DISTINCT ISO FROM scripture_main ORDER BY ISO";
	$result = $db->query($query);
	echo '<script type="application/javascript">';
	while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
		// append new value to the array
		?>
			ISOs.push('<?php echo $row['ISO']; ?>');
		<?php
	}

	// select countries and sub ISOs into a js array
	$query="SELECT DISTINCT ISO_countries FROM ISO_countries ORDER BY ISO";
	$result_country = $db->query($query);
	$stmt = $db->prepare("SELECT DISTINCT ISO FROM ISO_countries WHERE ISO_countries = ? ORDER BY ISO");
	while ($row_country = $result_country->fetch_array(MYSQLI_ASSOC)) {
		$CC = $row_country['ISO_countries'];
		$stmt->bind_param("s", $CC);								// bind parameters for markers
		$stmt->execute();											// execute query
		$result = $stmt->get_result();								// instead of bind_result
		//$query="SELECT DISTINCT ISO FROM ISO_countries WHERE '".$CC."' = ISO_countries ORDER BY ISO";
		//$result = $db->query($query);
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			// append new value to the array
			?>
				CCs.push({"<?php echo $CC; ?>": '<?php echo $row['ISO']; ?>'});
			<?php
		}
	}
	
	foreach (glob("counter/linkArchive/*.link") as $filename) {
		$myfile = fopen($filename, "r");
		$filename = substr($filename, strpos($filename, "counter/"));	// save the string of $filename after 'counter/'
			// append new value to the array							// get the first line of $myfile
			?>
				ISOLink.push({"<?php echo $filename; ?>": "<?php echo fgets($myfile); ?>"});
			<?php
		fclose($myfile);
	}
	echo '</script>';
	
	//ksort(CCs);
	
	?>
    <h1 style='color: navy; margin-left: auto; margin-right: auto; '>SE stats</h1>
    <!--h3 style='margin-left: auto; margin-right: auto; '>(Ask Scott for the log files when you need the SE stats for May 2018 and on.)</h3-->
    <h3 style='margin-left: auto; margin-right: auto; '>Please wait after you clicked on 'OK'. There may be a delay before the results are displayed.</h3>
    <h4>This includes September, 2020 and on up to today.</h4>
    <form name='myForm' action="#">																			<!-- Years -->
    	<select name="Year" id="Year">
        	<?php
            for ($varYear = 2020; $varYear <= (int)date("Y"); $varYear++) {
        		echo "<option style='color: navy; ' value='".$varYear."' ".($varYear === ((int)date('Y')) ? 'selected="selected"' : '').">".$varYear."</option>";
			}
			?>
        </select>
        
    	<select name="Month" id="Month">																	<!--  Months -->
        	<option style='color: navy; ' <?php echo ($month == '01' ? 'selected="selected"' : ''); ?> value="Jan">January</option>
        	<option style='color: navy; ' <?php echo ($month == '02' ? 'selected="selected"' : ''); ?> value="Feb">February</option>
        	<option style='color: navy; ' <?php echo ($month == '03' ? 'selected="selected"' : ''); ?> value="Mar">March</option>
        	<option style='color: navy; ' <?php echo ($month == '04' ? 'selected="selected"' : ''); ?> value="Apr">April</option>
        	<option style='color: navy; ' <?php echo ($month == '05' ? 'selected="selected"' : ''); ?> value="May">May</option>
        	<option style='color: navy; ' <?php echo ($month == '06' ? 'selected="selected"' : ''); ?> value="Jun">June</option>
        	<option style='color: navy; ' <?php echo ($month == '07' ? 'selected="selected"' : ''); ?> value="Jul">July</option>
        	<option style='color: navy; ' <?php echo ($month == '08' ? 'selected="selected"' : ''); ?> value="Aug">August</option>
        	<option style='color: navy; ' <?php echo ($month == '09' ? 'selected="selected"' : ''); ?> value="Sep">September</option>
        	<option style='color: navy; ' <?php echo ($month == '10' ? 'selected="selected"' : ''); ?> value="Oct">October</option>
        	<option style='color: navy; ' <?php echo ($month == '11' ? 'selected="selected"' : ''); ?> value="Nov">November</option>
        	<option style='color: navy; ' <?php echo ($month == '12' ? 'selected="selected"' : ''); ?> value="Dec">December</option>
        </select>
        
    	<!-- function 'CountryISOs()' can't go on 'option' but must go on 'select' -->
        <select name="Country" id="Country" onChange='CountryISOs()'>										<!-- Countries  -->
        	<option style='color: navy; ' value='All countries'>All countries</option>
            <?php
				$query = "SELECT DISTINCT ISO_countries.ISO_countries, countries.English FROM ISO_countries, countries WHERE ISO_countries.ISO_countries = countries.ISO_Country ORDER BY countries.English";
				$result = $db->query($query);
				while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
					$ISO_countries = $row['ISO_countries'];
					$English = $row['English'];
					if ($ISO_countries == 'MX') {
						echo "<option style='color: navy; ' selected='selected' value='MX'>Mexico</option>";
					}
					else {
						if ('All ' == substr($English, 0, 4)) {
							$English = substr($English, 4);
							echo "<option style='color: navy; ' value='".$ISO_countries."'>".$English."</option>";
						}
						else {
							echo "<option style='color: navy; ' value='".$ISO_countries."'>".$English."</option>";
						}
					}
				}
			?>
        </select>
        
    	<select name="ISO" id="ISO">																		<!-- ISOs -->
            <?php
				if ($ISO_countries=='All') {
        			echo "<option style='color: navy; ' selected='selected' value='All'>All ISOs</option>";
				}
				else {
        			echo "<option style='color: navy; ' value='Approp'>All Mexico ISOs</option>";
				}
				echo '<script type="application/javascript">';
				if ($ISO_countries=='All') {
					echo 'for (let i = 0; i < ISOs.length; i++) {';
						echo "<option style='color: navy; ' value='+ISOs[i]+'>+ISOs[i]+</option>";
					echo '}';
				}
				else {
					echo 'var sel = document.getElementById(\'Country\');';
					echo 'var ISO_country = sel.options[sel.selectedIndex].value;';
					echo 'var English = sel.options[sel.selectedIndex].text;';
					echo 'CountryISOs();';
				}
				echo '</script>';
			?>
        </select>
        
        <input type="button" value="Ok" onclick='data()' /> 
    </form>
    
    <br />
    <br />
    <br />
    <hr color="#003399" align="center" width="90%" size="2px" />
    <br />
    <br />

    <h1 style='color: navy; margin-left: auto; margin-right: auto; '>Links to websites other than SE</h1>
    <h3 style='margin-left: auto; margin-right: auto; '>These links are <strong>only for the <em>previous</em> month</strong>!</h3>
    <h3 style='margin-left: auto; margin-right: auto; '>Please wait after you clicked on 'OK'. There may be a delay before the results are displayed.</h3>
    <form name='mylink' action="#">
        <select name="CountryLink" id="CountryLink" onchange='CountryISOLink()'>							<!-- Countries  -->
            <?php
				$query = "SELECT DISTINCT ISO_countries.ISO_countries, countries.English FROM ISO_countries, countries WHERE ISO_countries.ISO_countries = countries.ISO_Country ORDER BY countries.English";
				$result = $db->query($query);
				while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
					$ISO_countries_Link = $row['ISO_countries'];
					$English_Link = $row['English'];
					if ($ISO_countries_Link == 'MX') {
						echo "<option style='color: navy; ' selected='selected' value='MX'>Mexico</option>";
					}
					else {
						if ('All ' == substr($English_Link, 0, 4)) {
							$English_Link = substr($English_Link, 4);
							echo "<option style='color: navy; ' value='".$ISO_countries_Link."'>".$English_Link."</option>";
						}
						else {
							echo "<option style='color: navy; ' value='".$ISO_countries_Link."'>".$English_Link."</option>";
						}
					}
				}
			?>
        </select>
        
    	<select name="ISOLink" id="ISOLink">																<!-- ISOs -->
            <?php
				if ($ISO_countries_Link=='All') {
        			echo "<option style='color: navy; ' selected='selected' value='All'>All ISOs</option>";
				}
				else {
        			echo "<option style='color: navy; ' value='Approp'>All Mexico ISOs</option>";
				}
				echo '<script type="application/javascript">';
				if ($ISO_countries_Link=='All') {
					echo 'for (let i = 0; i < ISOLink.length; i++) {';
						echo "<option style='color: navy; ' value='+ISOLink[i]+'>+ISOLink[i]+</option>";
					echo '}';
				}
				else {
					echo 'var selLink = document.getElementById(\'CountryLink\');';
					echo 'var ISO_country_Link = selLink.options[selLink.selectedIndex].value;';
					echo 'var English_Link = selLink.options[selLink.selectedIndex].text;';
					echo 'CountryISOLink();';
				}
				echo '</script>';
			?>
        </select>
        
        <input type="button" value="Ok" onclick='linkes()' /> 
    </form>

    <?php
}
?>
</body>
</html>
