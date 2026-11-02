<?php
if ($_SERVER['REQUEST_URI'][-1] == '?') {													// last charcter is a question mark
	// if the last character is a question mark then remove it.
	// This happens when the user clicks on the "Search" button
	// and the URL has a question mark at the end.
	echo "<script>window.open('".substr($_SERVER['REQUEST_URI'], 0, -1)."', '_self');</script>";
	exit;
}

if (session_status() === PHP_SESSION_NONE) @session_start();

/*
	$st=
		1 - eng
		2 - spa
		3 - por
		4 - fra
		5 - nld
		6 - deu
		7 - cmn
		8 - kor
		9 - rus
		10 - arb
*/

/*
	Can't use <div id="langBackground" in FireFox 84.0.1 with cursor: pointer; inside the id because it is a bug.
	Also, <div id="langBackground_'.$st.'" won't at all. See Web Developer, Toogle Tools on Tools.
*/

?>
<meta http-equiv="Content-Type" 		content="text/html; charset=utf-8" />
<meta name="viewport" 					content="width=device-width, initial-scale=1, maximum-scale=1" />
<meta name="ObjectType" 				content="Document" />
<meta http-equiv="Window-target" 		content="_top" />
<meta name="Created-by" 				content="Scott Starker" />
<meta name="Updated-by" 				content="Scott Starker, Lærke Roager" />
<meta name="Maintained-by" 				content="Website" />
<meta name="Approved-by" 				content="Bill Dyck, Access Coordinator" />
<meta name="Copyright"					content="6.2009 - <?php echo date("Y"); ?>" />		<!-- auto_copyright("2009") -->
<!-- For IE 9 and below. ICO should be 32x32 pixels in size -->
<!--[if IE]><link rel="shortcut icon" href="path/to/favicon.ico"><![endif]-->
<!-- Touch Icons - iOS and Android 2.1+ 180x180 pixels in size. -->
<link rel="apple-touch-icon-precomposed" href="./icons/apple-touch-icon-precomposed.png">
<!-- Firefox, Chrome, Safari, IE 11+ and Opera. 196x196 pixels in size. -->
<link rel="icon"						href="icons/favicon.png" />
<link rel="manifest" 					href="manifest.webmanifest" />						<!-- The browser should behave when the PWA installs on the user's desktop or mobile device. -->
<link rel="apple-touch-icon" 			href="icons/apple-touch-icon.png" />				<!-- iOS mobile icon -->
<meta name="apple-mobile-web-app-title" content="Scripture Earth" />						<!-- title for iOS mobile icon -->
<link rel="icon" sizes="192x192" 		href="icons/nice-highres.png" />					<!-- Android mobile icon -->
<meta name="application-name" 			content="Scripture Earth" />						<!-- title for Android mobile icon -->
<link rel='stylesheet' type='text/css' href='_css/00-Scripture.css?v=1.1.3' />
<link rel='stylesheet' type='text/css' href='_css/00-SEmobile.css?v=0.0.8' />
<link rel='stylesheet' type='text/css' href='_css/jplayer.blue.monday.min.css?v=0.0.3' />	<!-- Playlist Video -->
<link rel='stylesheet' type='text/css' href='_css/jplayer.playlist.BlueMonday.css' />		<!-- Playlist Audio -->
<link rel="stylesheet" type='text/css' href="JQuery/css/jquery-ui-1.12.1.css" />
<link rel="stylesheet" type='text/css' href="./_css/leaflet.css" />
<link rel="stylesheet" type='text/css' href="./_css/leaflet.fullscreen.css" />
<script type="text/javascript" language="javascript" src="./_js/leaflet.min.js"></script>
<script type="text/javascript" language="javascript" src="./_js/Leaflet.fullscreen.min.js"></script>
<script type="text/javascript" language="javascript" src="JQuery/js/jquery-1.12.4.min.js"></script>
<script type="text/javascript" language="javascript" src="JQuery/js/jquery-ui-1.12.1.min.js"></script>
<script type="text/javascript" language="javascript" src="_js/jquery.jplayer-2.9.2.min.js"></script>
<script type="text/javascript" language="javascript" src="_js/jplayer.playlist.min.js"></script>
<script type="text/javascript" language="javascript" src="_js/user_events.js?v=1.0.3"></script>
<script type='text/javascript' language='javascript1.2' src="_js/00-Scripture.js?v=0.0.3"></script>
<!--script type='text/javascript' language='javascript'	src="_js/LangSearch.js?v=1.0.3"></script-->
<link rel='stylesheet' type='text/css' href='_css/FGL.css' />
<link rel='stylesheet' type='text/css' href='_css/jplayer-m.css' />

<style>
	<?php
	// This has to stay in 00-MainScript.inc.php!
	if ($direction == 'ltr') {
		?>
		/* left to right */
		html, body, * {
			direction: ltr;
			font: 100% Verdana, Arial, Helvetica, sans-serif;
		}
		table {
			font-family: Arial, Helvetica, sans-serif;
		}
		tr, td {
			text-align: left;
		}
		#listCountriesID > button {
			background-position: right;
			text-align: left;
		}
		input[type=text] {
			background-position: right;
		}
		#submenu > li {
			text-align: left;
		}
		#AboutOffOn {
			text-align: left;
		}
		#AboutOffOn > li {
			margin-left: 84px;
			margin-bottom: 8px;
		}
		div.autonymLanguageNames,
		div.alternativeLanguageNames,
		div.Country,
		div.languageCode {
			font-family: Arial, Helvetica, sans-serif;
			text-align: left;
			margin-left: 20px;
		}
		div.OTAudio,
		div.NTAudio {
			float: left;
		}
		/* end left to right */
		<?php
	}
	else {
		?>
		/* right to left */
		html, body, * {
			direction: rtl;
			/*unicode-bidi: bidi-override;*/
			font: 100% 'Calibri', 'Gill Sans', 'Gill Sans MT', 'Trebuchet MS', sans-serif;
		}
		table {
			direction: rtl;
			font-family: 'Calibri', 'Gill Sans', 'Gill Sans MT', 'Trebuchet MS', sans-serif;
		}
		tr, td {
			text-align: right;						/* the three row boxes AND the icon texts in the specific languages */
		}
		/*#AID {
			text-align: right;						/* third row box * /
		} */
		#listCountriesID > button {
			background-position: left;				/* third row icon */
			text-align: right;						/* third row box */
		}
		input[type=text] {							/* first and second icon */
			background-position: left;
		}
		#submenu > li {
			text-align: right;
		}
		#AboutOffOn {
			text-align: right;
		}
		#AboutOffOn > li {
			margin-right: 34px;
			margin-bottom: 8px;
		}
		div.autonymLanguageNames,
		div.alternativeLanguageNames,
		div.Country,
		div.languageCode {
			font-family: 'Calibri', 'Gill Sans', 'Gill Sans MT', 'Trebuchet MS', sans-serif;
			text-align: right;
			margin-left: 20px;
		}
		div.OTAudio,
		div.NTAudio {
			float: right;
		}
		/* end right to left */
		<?php
	}
	?>
	.leaflet-popup-content { white-space: nowrap; width: auto !important; }
	/* Center text and remove popup arrow for cleaner look */
	.leaflet-popup-content-wrapper {
		text-align: center;
	}
	.centered-tooltip .leaflet-tooltip-text {
		text-align: center;
		font-weight: normal;
	}
	/* Center text and remove popup arrow for cleaner look */
	.leaflet-popup-content-wrapper {
		text-align: center;
	}
	.leaflet-popup-tip {
		opacity: 0; /* hides the triangle pointer */
	}
</style>

<?php
if (!isset($st) || !isset($Variant_major) || !isset($MajorLanguage) || !isset($SpecificCountry) || !isset($counterName)) {
	die('Suspicious behavior!');
}

/*
	The following files are included in this php:
		./include/00-SpecificLanguage.inc.php
		./include/00-CountryTable.inc.php
		./00-CountriesList.php
		./00-CellPhoneModule.php
		./00-DownloadStudy.php
		./00-DownloadPDF.php
		./00-AudioSaveZip.php
		./00-BegList.php
		./include/00-MainPHPFunctions.inc.php
		./include/00-MajorLanguageBannerText.inc.php
		./include/00-MajorLanguageChoiceSelected.inc.php
		./include/00-MajorLanguageVariantCode.inc.php
*/

include './OT_Books.php';										// $OT_array
include './NT_Books.php';										// $NT_array
include './translate/functions.php';							// translation function
include './include/00-MainPHPFunctions.inc.php';				// main PHP functions

$ln_result = '';

require_once './include/conn.inc.php';							// connect to the database named 'scripture'
$db = get_my_db();

//session_unset();

if (!isset($_SESSION['MajorLanguage'])) {
	$_SESSION['MajorLanguage'] = $MajorLanguage;				// e.g., "LN_French"
	$_SESSION['Variant_major'] = $Variant_major;				// e.g., 'Variant_Fre'
	$_SESSION['SpecificCountry'] = $SpecificCountry;			// e.g., "French"
	$_SESSION['counterName'] = $counterName;					// e.g., "French"
	$_SESSION['Scriptname'] = $Scriptname;						// = basename($_SERVER["SCRIPT_NAME"])
	$_SESSION['FacebookCountry'] = $FacebookCountry;			// e.g., "fr_CA"
	$_SESSION['MajorCountryAbbr'] = $MajorCountryAbbr;			// e.g., "fr"
}

// master list of the naviagational languages
if (!isset($_SESSION['nav_ln_array'])) {
	$_SESSION['nav_ln_array'] = [];
	$ln_temp_var = '';
	$ln_query = 'SELECT `translation_code`, `name`, `nav_fileName`, `ln_number`, `language_code`, `ln_abbreviation` FROM `translations` ORDER BY `name`';
	$ln_result_temp = $db->query($ln_query) or die('Query failed:  ' . $db->error . '</body></html>');
	if ($ln_result_temp->num_rows == 0) {
		die('<div style="background-color: white; color: red; font-size: 16pt; padding-top: 20px; padding-bottom: 20px; margin-top: 200px; ">' . translate('The translation_code is not found.', $st, 'sys') . '</div>');
	}
	while ($ln_row = $ln_result_temp->fetch_array()) {
		$ln_temp[0] = $ln_row['translation_code'];				// e.g., 'eng' [3 lower case letters]
		$ln_temp[1] = $ln_row['name'];							// e.g., 'English' [name of the navigational language]
		$ln_temp[2] = $ln_row['nav_fileName'];					// e.g., '00eng.php' [00[3 lower case letters].php]
		$ln_temp[3] = $ln_row['ln_number'];						// e.g., 1
		$ln_temp[4] = $ln_row['ln_abbreviation'];				// e.g., 'i'
		$_SESSION['nav_ln_array'][$ln_row['language_code']] = $ln_temp;		// e.g., 'en' [2 lower case letters]
		$ln_temp_var .= 'LN_' . $ln_temp[1] . ', ';				// must have a space (' ') here
	}
	$ln_result = $ln_temp_var;
	$_SESSION['ln_result'] = $ln_result;						// LN_English, LN_Spanish, LN_Portuguese, ...
}

/*
	*************************************************************************************************************
		Internet?
	*************************************************************************************************************
*/
$Internet = 0;		// localhost is 127.0.0.1 but '192.168.x.x' should be not-on-the-Internet because it's URL is part of the stand-alone server.
$Internet = (substr($_SERVER['REMOTE_ADDR'], 0, 7) != '192.168' ? 1 : 0);

$asset = 0;
if (isset($_GET['asset'])) {
	$asset = (int)$_GET['asset'];
	if ($asset != 0 && $asset != 1) {
		die('asset is not valid.</body></html>');
	}
}
?>

<style>
	@media only screen and (max-width: 480px) {
		/* (max-width: 412px) for Samsung S8+ 2/20/2019 */
		div.colAlt2::before,
		div.countryAlt2::before,
		div.moreThanAlt2::before {
			content: "<?php echo translate('Alternate Language Names', $st, 'sys'); ?>: ";
		}
	}
</style>

<script language="javascript" type="application/javascript">
	$(function() {
		$("#sM").selectmenu({
			width: 150
		});
	});

	function setTitle(text) {
		document.title = 'Scripture Earth: ' + text;
	}

	let macroLanguage = 'ara, aym, aze, bal, bua, bik, bnc, chm, cre, den, din, doi, est, fas, ful, gba, gon, grb, grn, hai, hbs, hmn, iku, ipk, jrb, kau, kln, kok, kom, kon, kpe, kur, lah, lav, luy, man, mlg, mon, msa, mwr, nep, ori, orm, pus, que, raj, rom, sqi, srd, swa, syr, tmh, uzb, zap, zha, zho, zza';
</script>

</head>

<body>
	<div class="gridContainer clearfix">
		<div id="div1" class="fluid">
			<?php
			/*************************************************************************************************************
            	Main program
            *************************************************************************************************************/
			if (isset($_GET['sortby']) && (isset($_GET['name'])) || isset($_GET['iso']) || isset($_GET['ISO_ROD_index']) || isset($_GET['idx'])) {		// if (sortby and name (or iso)) or search
				/*  ******************************************************************************************************
				/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\
					(sortby = "lang" && iso/name = [ISO]) || idx/ISO_ROD_index = [0-9]{1,5}
				/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\
				******************************************************************************************************  */
				if ((isset($_GET['sortby']) && $_GET['sortby'] == 'lang') || isset($_GET['iso']) || isset($_GET['ISO_ROD_index']) || isset($_GET['idx'])) {
					if (!isset($_GET['name']) && !isset($_GET['iso']) && !isset($_GET['ISO_ROD_index']) && !isset($_GET['idx'])) {
						die('You made a mistake!</body></html>');
					}
					else {
						$query = '';
						if (!isset($asset)) {
							$asset = 0;
						}
						if (isset($_GET['ISO_ROD_index']) || isset($_GET['idx'])) {
							//$ISO_ROD_index = $_GET['ISO_ROD_index'];
							$ISO_ROD_index = isset($_GET['ISO_ROD_index']) ? $_GET['ISO_ROD_index'] : $_GET['idx'];
							//$ISO_ROD_index = htmlspecialchars($ISO_ROD_index, ENT_QUOTES, 'UTF-8');
							$ISO_ROD_index = strval(intval($ISO_ROD_index));			// returns a string as an integer  
							if ($ISO_ROD_index == '0') {								// if $ISO_ROD_index has a letter at the beginning then intval returns 0
								die('You made a mistake!</body></html>');
							}
							// asset
							if ($asset == 1) {
								$query = "SELECT DISTINCT nav_ln.*, $SpecificCountry, countries.ISO_Country, `CellPhone`.`Cell_Phone_File`, `CellPhone`.`optional` FROM nav_ln, countries, ISO_countries, CellPhone WHERE countries.ISO_Country = ISO_countries.ISO_countries AND ISO_countries.ISO = nav_ln.ISO AND nav_ln.ISO_ROD_index = '$ISO_ROD_index' AND `nav_ln`.`ISO_ROD_index` = `CellPhone`.`ISO_ROD_index` AND `CellPhone`.`Cell_Phone_Title` = 'iOS Asset Package'";
							} else {
								$query = "SELECT DISTINCT nav_ln.*, $SpecificCountry, countries.ISO_Country FROM nav_ln, countries, ISO_countries WHERE countries.ISO_Country = ISO_countries.ISO_countries AND ISO_countries.ISO = nav_ln.ISO AND nav_ln.ISO_ROD_index = '$ISO_ROD_index'";
							}
						}
						else {
							$ISO = isset($_GET['name']) ? $_GET['name'] : $_GET['iso'];
							$ISO = str_replace('%20', ' ', $ISO);						// change %20 (internet space) to space
							$ISO = trim($ISO);											// trim whitespace from variable
							if ($ISO == '' || $ISO == '%' || $ISO == NULL) {
								die('‘ISO’ ' . translate('is empty', $st, 'sys') . '.</body></html>');
							}
							// Cross Site Scripting (XSS) attack happens where client side code (usually JavaScript) gets injected into the output of your PHP script. The next line cleans it up.
							$ISO = htmlspecialchars($ISO, ENT_QUOTES, 'UTF-8');
							if (preg_match('/^([a-z]{3})/', $ISO, $matches)) {
								$ISO = $matches[1];
							} else {
								die('You made a mistake!</body></html>');
							}
							if (isset($_GET['ROD_Code']) || isset($_GET['rod'])) {
								//$ROD_Code = $_GET['ROD_Code'];
								$ROD_Code = isset($_GET['ROD_Code']) ? $_GET['ROD_Code'] : $_GET['rod'];
								// Cross Site Scripting (XSS) attack happens where client side code (usually JavaScript) gets injected into the output of your PHP script. The next line cleans it up.
								$ROD_Code = htmlspecialchars($ROD_Code, ENT_QUOTES, 'UTF-8');
								preg_match('/^([a-zA-Z0-9]{0,5})/', $ROD_Code, $matches);
								$ROD_Code = $matches[1];
							}
							if (isset($_GET['Variant_Code']) || isset($_GET['var'])) {
								//$Variant_Code = $_GET['Variant_Code'];
								$Variant_Code = isset($_GET['Variant_Code']) ? $_GET['Variant_Code'] : $_GET['var'];
								$Variant_Code = trim($Variant_Code);
								if ($Variant_Code != NULL) {
									// Cross Site Scripting (XSS) attack happens where client side code (usually JavaScript) gets injected into the output of your PHP script. The next line cleans it up.
									$Variant_Code = htmlspecialchars($Variant_Code, ENT_QUOTES, 'UTF-8');
									if (preg_match('/^([a-z])/', $Variant_Code, $matches)) {
										$Variant_Code = $matches[1];
									} else {
										die('You made a mistake!</body></html>');
									}
								}
							}
							// asset
							if ($asset == 1) {
								if (isset($ISO_ROD_index)) {
									$resultTest = $db->query("SELECT nav_ln.ISO FROM nav_ln, `CellPhone` WHERE `nav_ln`.`ISO_ROD_index` = '$ISO_ROD_index' AND `nav_ln`.`ISO_ROD_index` = `CellPhone`.`ISO_ROD_index` AND `CellPhone`.`Cell_Phone_Title` = 'iOS Asset Package'");
									$query = "SELECT `nav_ln`.*, $SpecificCountry, `countries`.`ISO_Country`, `CellPhone`.`Cell_Phone_File`, `CellPhone`.`optional` FROM `nav_ln`, `countries`, `ISO_countries`, `CellPhone` WHERE `countries`.`ISO_Country` = `ISO_countries`.`ISO_countries` AND `ISO_countries`.`ISO_ROD_index` = `nav_ln`.`ISO_ROD_index` AND `nav_ln`.`ISO_ROD_index` = '$ISO_ROD_index' AND `nav_ln`.`ISO_ROD_index` = `CellPhone`.`ISO_ROD_index` AND `CellPhone`.`Cell_Phone_Title` = 'iOS Asset Package'";
								} elseif (!isset($ROD_Code) && !isset($Variant_Code)) {
									$resultTest = $db->query("SELECT nav_ln.ISO FROM nav_ln, `CellPhone` WHERE nav_ln.ISO = '$ISO' AND `nav_ln`.`ISO` = `CellPhone`.`ISO` AND `CellPhone`.`Cell_Phone_Title` = 'iOS Asset Package'");
									$query = "SELECT DISTINCT `nav_ln`.*, $SpecificCountry, `countries`.`ISO_Country`, `CellPhone`.`Cell_Phone_File`, `CellPhone`.`optional` FROM `nav_ln`, `countries`, `ISO_countries`, `CellPhone` WHERE `countries`.`ISO_Country` = `ISO_countries`.`ISO_countries` AND `ISO_countries`.`ISO` = `nav_ln`.`ISO` AND `nav_ln`.`ISO` = '$ISO' AND `nav_ln`.`ISO` = `CellPhone`.`ISO` AND `CellPhone`.`Cell_Phone_Title` = 'iOS Asset Package'";
								} elseif (isset($ROD_Code) && !isset($Variant_Code)) {
									$resultTest = $db->query("SELECT nav_ln.ISO FROM nav_ln, CellPhone WHERE nav_ln.ISO = '$ISO' AND nav_ln.ROD_Code = '$ROD_Code' AND `nav_ln`.`ISO` = `CellPhone`.`ISO` AND `CellPhone`.`Cell_Phone_Title` = 'iOS Asset Package' AND nav_ln.ROD_Code = `CellPhone`.`ROD_Code`");
									$query = "SELECT DISTINCT nav_ln.*, $SpecificCountry, countries.ISO_Country, `CellPhone`.Cell_Phone_File, `CellPhone`.optional FROM nav_ln, countries, ISO_countries, CellPhone WHERE countries.ISO_Country = ISO_countries.ISO_countries AND ISO_countries.ISO = nav_ln.ISO AND nav_ln.ISO = '$ISO' AND nav_ln.ROD_Code = '$ROD_Code' AND `nav_ln`.`ISO` = `CellPhone`.`ISO` AND `CellPhone`.`Cell_Phone_Title` = 'iOS Asset Package'";
								} elseif (!isset($ROD_Code) && isset($Variant_Code)) {
									$resultTest = $db->query("SELECT nav_ln.ISO FROM nav_ln, CellPhone WHERE nav_ln.ISO = '$ISO' AND nav_ln.Variant_Code = '$Variant_Code' AND `nav_ln`.`ISO` = `CellPhone`.`ISO` AND `CellPhone`.`Cell_Phone_Title` = 'iOS Asset Package' AND nav_ln.Variant_Code = `CellPhone`.`Variant_Code`");
									$query = "SELECT DISTINCT nav_ln.*, $SpecificCountry, countries.ISO_Country, `CellPhone`.Cell_Phone_File, `CellPhone`.optional FROM nav_ln, countries, ISO_countries, CellPhone WHERE countries.ISO_Country = ISO_countries.ISO_countries AND ISO_countries.ISO = nav_ln.ISO AND nav_ln.ISO = '$ISO' AND (nav_ln.Variant_Code = '$Variant_Code' OR isnull(nav_ln.Variant_Code)) AND `nav_ln`.`ISO` = `CellPhone`.`ISO` AND `CellPhone`.`Cell_Phone_Title` = 'iOS Asset Package'";
								} else {
									$resultTest = $db->query("SELECT nav_ln.ISO FROM nav_ln, CellPhone WHERE nav_ln.ISO = '$ISO' AND nav_ln.ROD_Code = '$ROD_Code' AND nav_ln.Variant_Code = '$Variant_Code' AND `nav_ln`.`ISO` = `CellPhone`.`ISO` AND `CellPhone`.`Cell_Phone_Title` = 'iOS Asset Package' AND nav_ln.ROD_Code = `CellPhone`.`ROD_Code` AND nav_ln.Variant_Code = `CellPhone`.`Variant_Code`");
									$query = "SELECT DISTINCT nav_ln.*, $SpecificCountry, countries.ISO_Country, `CellPhone`.Cell_Phone_File, `CellPhone`.optional FROM nav_ln, countries, ISO_countries, CellPhone WHERE countries.ISO_Country = ISO_countries.ISO_countries AND ISO_countries.ISO = nav_ln.ISO AND nav_ln.ISO = '$ISO' AND nav_ln.ROD_Code = '$ROD_Code' AND (nav_ln.Variant_Code = '$Variant_Code' OR isnull(nav_ln.Variant_Code)) AND `nav_ln`.`ISO` = `CellPhone`.`ISO` AND `CellPhone`.`Cell_Phone_Title` = 'iOS Asset Package'";
								}
							}
							else {
								if (isset($ISO_ROD_index)) {
									$resultTest = $db->query("SELECT ISO FROM nav_ln WHERE `ISO_ROD_index` = '$ISO_ROD_index'");
									$query = "SELECT `nav_ln`.*, $SpecificCountry, `countries`.`ISO_Country` FROM `nav_ln`, `countries`, `ISO_countries` WHERE `countries`.`ISO_Country` = `ISO_countries`.`ISO_countries` AND `ISO_countries`.`ISO_ROD_index` = `nav_ln`.`ISO_ROD_index` AND `nav_ln`.`ISO_ROD_index` = '$ISO_ROD_index'";
								} elseif (!isset($ROD_Code) && !isset($Variant_Code)) {
									$resultTest = $db->query("SELECT ISO FROM nav_ln WHERE ISO = '$ISO'");
									$query = "SELECT DISTINCT `nav_ln`.*, $SpecificCountry, `countries`.`ISO_Country` FROM `nav_ln`, `countries`, `ISO_countries` WHERE `countries`.`ISO_Country` = `ISO_countries`.`ISO_countries` AND `ISO_countries`.`ISO` = `nav_ln`.`ISO` AND `nav_ln`.`ISO` = '$ISO'";
								} elseif (isset($ROD_Code) && !isset($Variant_Code)) {
									$resultTest = $db->query("SELECT ISO FROM nav_ln WHERE ISO = '$ISO' AND ROD_Code = '$ROD_Code'");
									$query = "SELECT DISTINCT `nav_ln`.*, $SpecificCountry, `countries`.`ISO_Country` FROM `nav_ln`, `countries`, `ISO_countries` WHERE `countries`.`ISO_Country` = `ISO_countries`.`ISO_countries` AND `ISO_countries`.`ISO` = `nav_ln`.`ISO` AND `nav_ln`.`ISO` = '$ISO' AND `nav_ln`.`ROD_Code` = '$ROD_Code'";
								} elseif (!isset($ROD_Code) && isset($Variant_Code)) {
									$resultTest = $db->query("SELECT ISO FROM nav_ln WHERE ISO = '$ISO' AND Variant_Code = '$Variant_Code'");
									$query = "SELECT DISTINCT `nav_ln`.*, $SpecificCountry, `countries`.`ISO_Country` FROM `nav_ln`, `countries`, `ISO_countries` WHERE `countries`.`ISO_Country` = `ISO_countries`.`ISO_countries` AND `ISO_countries`.`ISO` = `nav_ln`.`ISO` AND `nav_ln`.`ISO` = '$ISO' AND (`nav_ln`.`Variant_Code` =  '$Variant_Code' OR isnull(`nav_ln`.`Variant_Code`))";
								} else {
									$resultTest = $db->query("SELECT ISO FROM nav_ln WHERE ISO = '$ISO' AND ROD_Code = '$ROD_Code' AND Variant_Code = '$Variant_Code'");
									$query = "SELECT DISTINCT `nav_ln`.*, $SpecificCountry, `countries`.`ISO_Country` FROM `nav_ln`, `countries`, `ISO_countries` WHERE `countries`.`ISO_Country` = `ISO_countries`.`ISO_countries` AND `ISO_countries`.`ISO` = `nav_ln`.`ISO` AND `nav_ln`.`ISO` = '$ISO' AND `nav_ln`.`ROD_Code` = '$ROD_Code' AND (`nav_ln`.`Variant_Code` =  '$Variant_Code' OR isnull(`nav_ln`.`Variant_Code`))";
								}
							}
							if ($resultTest->num_rows > 1) {														// in case someone does ?sortby=lang&name=[ZZZ] and there is more than one ROD Code
								/*
								*************************************************************************************************************
									more than 1 ROD Code/Variant code
								*************************************************************************************************************
								*/
								// here:  AND `nav_ln`.`ISO` = `CellPhone`.`ISO` AND `CellPhone`.`Cell_Phone_Title` = 'iOS Asset Package'
								include './00-moreThanOneRODCode.php';
								return;
							} elseif ($resultTest->num_rows === 0) {
								die('<div style="background-color: white; color: red; font-size: 16pt; padding-top: 20px; padding-bottom: 20px; margin-top: 200px; ">' . translate('The ISO language code is not found.', $st, 'sys') . '</div></body></html>');
							} else {
							}				// ($resultTest->num_rows == 1)
						}
						?>
						<!-- Facebook: Like Button, Send Button -->
						<div id="fb-root"></div>
						<script>
							(function(d, s, id) {
								var js, fjs = d.getElementsByTagName(s)[0];
								if (d.getElementById(id)) return;
								js = d.createElement(s);
								js.id = id;
								js.src = "https://connect.facebook.net/<?php echo $FacebookCountry; ?>/all.js#xfbml=1";
								fjs.parentNode.insertBefore(js, fjs);
							} (document, "script", "facebook-jssdk"));
						</script>
						<?php
						/******************************************************************************************************************
							select the default primary language name to be used by displaying the Countries and indigenous langauge names
						******************************************************************************************************************/
						$result = $db->query($query) or die(translate('Query failed:', $st, 'sys') . ' ' . $db->error . '</body></html>');
						if ($result->num_rows === 0) {
							die('<div style="background-color: white; color: red; font-size: 16pt; padding-top: 20px; padding-bottom: 20px; margin-top: 200px; ">' . translate('The ISO language code is not found.', $st, 'sys') . '</div></body></html>');
						}
						$row = $result->fetch_array();
						$ISO_ROD_index = $row['ISO_ROD_index'];
						$ISO = trim($row['ISO']);
						$ROD_Code = trim($row['ROD_Code']);
						$Variant_Code = trim($row['Variant_Code']);
						$GetName = trim($row['ISO_Country']);																				// 2 UPPER CASE letters indicating the coutry the ISO is from
						$countryTemp = $SpecificCountry;
						if (strpos("$SpecificCountry", '.')) $countryTemp = substr("$SpecificCountry", strpos("$SpecificCountry", '.') + 1);	// In case there's a "." in the "country"
						$country = trim($row["$countryTemp"]);																				// name of the country in the language version
						$URL = '';
						$optional = '';
						if ($asset == 1) {
							$URL = $row['Cell_Phone_File'];
							$optional = $row['optional'];
						}
						//$i=0;			// used in 00-DBLanguageCountryName.inc.php include
						include('./include/00-DBLanguageCountryName.inc.php');																// Get the variant language name. $row must be set! The 'return' value is $LN.

						echo '<div class="countryBlackTopImage"></div>';		// black image at the very top window
						/* <div id="background_header" style="background-image: url('../images/00<?php echo $st; ?>-ScriptureEarth_header.jpg'); "><div style="cursor: pointer; " onclick="window.open('<?php echo $Scriptname; ?>', '_self')"><img id="empty" src="./images/empty.png" /></div></div> <!-- ScriptureEarth and the Earth image -->
						<div id="background" style="background-image: url('../images/background_earth.jpg'); "></div> <!-- ScriptureEarth and the Earth image --> */

						/* *************************************************************************************
							display ScriptureEarth.org image
						************************************************************************************* */
						echo '<div id="langBackground" style="margin-top: -12px; ">';
						echo "<span style='cursor: pointer; ' onclick='window.open(\"$Scriptname\", \"_self\")'><img style='min-width: 400px; max-width: 500px; ' src='images/00" . $st . "-ScriptureEarth_header.jpg' class='langHeader' alt='" . translate('Scripture Resources in Thousands of Languages', $st, 'sys') . "' /></span>";									// just the ScriptureEarth.org icon
						echo '</div>';
						
						/* *************************************************************************************
							execute the include file which lists all of the indigenous languages
						***************************************************************************************/
						// Cross Site Scripting (XSS) attack happens where client side code (usually JavaScript) gets injected into the output of your PHP script. The next line cleans it up.
						$LN = htmlspecialchars($LN, ENT_QUOTES, 'UTF-8');
						?>

						<div class="threeMenus">
							<?php
							/* ------------------------------------------------------------------------------------------
								display 'English', 'Spanish', ... drop-down menu, help button, and hamburger menu
							------------------------------------------------------------------------------------------ */
							?>
							<form id="myForm" class="formNavAndHelp" action="#">
								<?php
								/* -----------------------------------------------------------------------------------------
									display select a language menu
								-------------------------------------------------------------------------------------------- */
								//	Changed to work with the master array -- Lærke
								//	Modified to (condition) ? value1 : value2 -- Scott
								?>
								<select id="sL" onchange="langChange('<?php echo $ISO_ROD_index; ?>', '<?php echo $LN; ?>', '<?php echo $ISO; ?>')">
									<?php
									foreach ($_SESSION['nav_ln_array'] as $tempArray) {
										echo "<option value='$tempArray[2]" . ($asset == 1 ? '?asset=1' : '') . '\'' . ($st == $tempArray[0] ? ' selected=\'selected\'' : '') . ">" . translate($tempArray[1], $tempArray[0], 'sys') . '</option>';
									}
									?>
								</select>

								<?php
								if ($asset === 0) {
									/* -----------------------------------------------------------------------------------------
										display help button
									-------------------------------------------------------------------------------------------- */
									?>
									<a href='#' id='helpMenu' class='helpSelection' onclick="helpClick();"><img src='./images/iconHelp.png' alt="<?php echo translate('help', $st, 'sys'); ?>" style='margin-left: 0; margin-right: -8px; margin-bottom: -10px; ' width="32" height="32" /></a>

									<?php
									/* -----------------------------------------------------------------------------------------
										display ☰ hamburger menu
									----------------------------------------------------------------------------------------- */
									?>
									<input type="checkbox" id="togglerID" class="toggler toogleLanguage">
									<div class="hamburger">
										<div></div>
									</div>
									<!--  document.querySelectorAll('div.hamburger')[0] => get div.hamburger -->
									<div class="menu">
										<div>
											<ul id="submenu" class="menuDivUlLanguage">
												<li><a href='#' onclick="window.open('<?php echo $Scriptname; ?>', '_self')"><?php echo translate('Home', $st, 'sys'); ?></a></li>
												<li><a href='#' onclick="aboutSection('H');"><?php echo translate('Help', $st, 'sys'); ?></a></li>
												<li><a id='aboutArrow' style="cursor: pointer; margin-left: -16px; " onclick="AboutOO()">▸<?php echo translate('About', $st, 'sys'); ?></a></li>
												<div id="AboutOffOn" style="display: none; ">
													<li><a href='#' onclick="aboutSection('CR');"><?php echo translate('Copyright', $st, 'sys'); ?></a></li>
													<li><a href='#' onclick="aboutSection('CU');"><?php echo translate('Content providers and partners', $st, 'sys'); ?></a></li>
													<li><a href='#' onclick="aboutSection('TC');"><?php echo translate('Terms and Conditions', $st, 'sys'); ?></a></li>
													<li><a href='#' onclick="aboutSection('P');"><?php echo translate('Privacy Policy', $st, 'sys'); ?></a></li>
												</div>
												<li><a href='#' onclick="menuSet = 0; window.open('./Feedback/Feedback.php?st=<?php echo $st; ?>')"><?php echo translate('Contact Us', $st, 'sys'); ?></a></li>
												<?php if ($st == 'eng') { ?>
													<li><a href='#' onclick="menuSet = 0; window.open('https://give.sil.org/give/531194/#!/donation/checkout')"><?php echo translate('Donate', $st, 'sys'); ?></a></li>
												<?php }
												if ($st == 'eng' || $st == 'spa') { ?>
													<li><a href='#' onclick="menuSet = 0; window.open('./promotionMaterials/promotion.php?st=<?php echo $st; ?>')"><?php echo translate('Promotion Materials', $st, 'sys'); ?></a></li>
												<?php } ?>
											</ul>
										</div>
									</div>
								<?php
								}
								?>
							</form>
						</div>

						<iframe id="myFrame" allowfullscreen="true" frameborder="0" marginheight="0" marginwidth="0" style="display: block; height: 100%; width: 80%; overflow:hidden; border: none; display: none; margin:0; padding:0; position: absolute; top: 200px; bottom: 0; right: 10%; left: 10%; z-index: 10; background-color: white; border: 5px solid black; box-shadow: 20px 20px 10px black, 0 0 400px black, 0 0 400px navy; " src=""></iframe>

						<?php
							// asset
							if ($asset == 1) {
								echo "<div style='background-color: white; color: navy; font-size: 16pt; padding-top: 20px; padding-bottom: 20px; margin-top: 200px; cursor: pointer; ' onclick='iOSLanguage(\"$st\", $ISO_ROD_index, \"$LN\", \"$URL\")'>Tap $LN ".($optional != '' ? $optional : '')." [$ISO] $country</div>";
								return;
							}

							// ********************************************************************************************************
							// /\/\/\/\/\/\/\/\/\/\/\/\/\/\//\/\/\/\/\/\/\/\/\/\/\/\/\/\//\/\/\/\/\/\/\/\/\/\/\/\/\/\//\/\/\/\/\/\/\/\/
							include('./include/00-SpecificLanguage.inc.php');				// Specific minority language display
							// /\/\/\/\/\/\/\/\/\/\/\/\/\/\//\/\/\/\/\/\/\/\/\/\/\/\/\/\//\/\/\/\/\/\/\/\/\/\/\/\/\/\//\/\/\/\/\/\/\/\/
							// ********************************************************************************************************

							// display counter
							$ISOorROD = $ISO != 'qqq' ? $ISO : $ROD_Code;
							echo "<script>console.log('ISO: $ISO, counterName: $counterName, GetName: $GetName, ISOorROD: $ISOorROD');</script>";
							Counter('AllCounter', false);									// Total website counter, don't display
							Counter('AllMLCounter', false);									// All of the major languages counter, don't display
							Counter('All_' . $ISOorROD . '_Counter', false);						// All of the ISO counter, don't display
							Counter('All_' . $GetName . '_' . $ISOorROD . '_Counter', false);	// All of the Country and the varient language counter, don't display
							Counter($counterName . 'MLCounter', false);						// All of the major language counter, don't display
							Counter($counterName . 'ML_' . $GetName . '_Counter', false);	// All of the major language and the Country counter, don't display
						?>

						<div style="position: relative; top: 90px; ">
							<div class="langCounter">
								<?php
								Counter($counterName . "ML_" . $GetName . "_" . $ISOorROD . "_Counter", true);		// All of the major language and the Country and the varient language counter, display
								?>
							</div>

							<?php
							if ($Internet) {
								// Facebook: Like Button, Send Button
								// <iframe src="https://www.facebook.com/plugins/like.php?href=https%3A%2F%2FScriptureEarth.org/$Scriptname?sortby=lang&name=$ISO&ROD_Code=$ROD_Code&Variant_Code=$Variant_Code&width=450&layout=standard&action=like&size=small&show_faces=false&share=true&height=35&appId=167214120125396" width="450" height="35" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
								echo '<div class="FaceBk" style="margin-top: 30px; margin-left: auto; margin-right: auto; ">';
							?>
								<!-- Your FB like button code -->
								<!-- https://developers.facebook.com/docs/plugins/like-button -->
								<!-- data-width default is 450px -->
								<div class="fb-like" data-href="https://ScriptureEarth.org/<?php echo $Scriptname . "?iso=" . $ISO . "&rod=" . $ROD_Code . "&var=" . $Variant_Code . "; " ?>" data-width="600px" data-layout="standard" data-action="like" data-size="small" data-share="true" data-show-faces="false">
								</div>
							<?php
								//echo "<fb:like style='' href='https://ScriptureEarth.org/$Scriptname?iso=$ISO&rod=$ROD_Code&var=$Variant_Code&width=376&height=200' send='true' width='450' show_faces='false' font='arial'></fb:like>";
								echo '</div>';
							}
							?>
						</div>

						<?php // display copyright ?>
							<div id='copyright' style='top: 140px; '>
								<div id='aboutLang' onclick="aboutSection('CR'); ">© <?php echo date('Y') . ' ' .  translate('About this site', $st, 'sys'); ?></div>
							</div>
						<?php
					}
				}
				/*  ******************************************************************************************************
				/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\
					sortby = country
				/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\
				******************************************************************************************************  */
				if (isset($_GET['sortby']) && $_GET['sortby'] == 'country') {
					?>
					<script>
						menuSet = 1;
					</script>
					<?php
					$GetName = trim($_GET['name']);											// 2 uppercase letters for the country code (table countries.ISO_Country) or 'all':
					if (preg_match('/^(all)/i', $GetName)) {
						//header("Location: https://www.ScriptureEarth.org/$Scriptname");	// Redirect browser
						echo '<script type="text/javascript">';
						echo 'window.location.href="https://www.ScriptureEarth.org/' . $Scriptname . '";';
						echo '</script>';
						// Make sure that code below does not get executed when we redirect.
						exit;
					}
					// Cross Site Scripting (XSS) attack happens where client side code (usually JavaScript) gets injected into the output of your PHP script. The next line cleans it up.
					//$GetName = htmlspecialchars($GetName, ENT_QUOTES, 'UTF-8');
					if (!preg_match('/^([A-Z]{2})/', $GetName, $matches)) {
						die("<br />$GetName " . translate('wasn’t found.<br />(The ‘country name’ was changed to a ‘country code’.<br />Did you use a bookmark with this browser?)', $st, 'sys') . "</body></html>");
					}
					$GetName = $matches[1];													// 2 uppercase letters for the country (table countries.ISO_Country) or 'all':
					// server does this
					if ($GetName == NULL) {
						die("<br />$GetName " . translate('is empty.', $st, 'sys') . '</body></html>');
					}

					$asset = 0;
					if (isset($_GET['asset'])) {
						$asset = $_GET['asset'];
						if ($asset != 0 && $asset != 1) {
							die('asset is not valid.</body></html>');
						}
					}

					// "$country" = "$SpecificCountry" (full country name)
					$query = "SELECT DISTINCT $SpecificCountry FROM countries ORDER BY ISO_Country";
					$result = $db->query($query);
					if ($result->num_rows == 0) {
						die("<br />$GetName " . translate('wasn’t found.<br />(The ‘country name’ was changed to a ‘country code’.<br />Did you use a bookmark with this browser?)', $st, 'sys') . "</body></html>");
					}
					$r = $result->fetch_array();
					$countryTemp = $SpecificCountry;
					if (strpos("$SpecificCountry", '.')) $countryTemp = substr("$SpecificCountry", strpos("$SpecificCountry", '.') + 1);			// In case there's a "." in the "country"
					$country = trim($r["$countryTemp"]);								// name of the full country if there is one

					if ($asset === 0) {
					?>
						<div id="background_header" style="background-image: url('../images/00<?php echo $st; ?>-ScriptureEarth_header.jpg'); "><div style="cursor: pointer; " onclick="window.open('<?php echo $Scriptname; ?>', '_self')"><img id="empty" style="min-width: 450px; max-width: 550px; " src="./images/empty.png" /></div></div> <!-- ScriptureEarth and the Earth image -->
						<div id="background" style="background-image: url('../images/background_earth.jpg'); "></div> <!-- ScriptureEarth and the Earth image -->
					<?php
					}
					else {
						echo '<div id="background" style="background-image: url(\'../images/background_earth.jpg\'); opacity: 0; "></div>';	// ScriptureEarth and the Earth image
					}
					?>
					<!-- The id="background_header" in the next line is the error! -->
					<!-- div id="background_header" style="background-image: url('../images/00< ?php echo $st; ?>-ScriptureEarth_header.jpg'); cursor: pointer; " onclick="window.open('< ?php echo $Scriptname; ?>', '_self')"><img id="empty" src="./images/empty.png" /></div> < !-- ScriptureEarth and the Earth image -->

					<div class="threeMenus">
						<?php
						/* ----------------------------------------------------------------------------------------------
							display 'English', 'Spanish', ... drop-down select menu, help button, and hamburger menu
       					---------------------------------------------------------------------------------------------- */
						?>
						
						<form id="myForm" class="formNavAndHelp" action="#">
							<?php
							/* -----------------------------------------------------------------------------------------
								display select a language menu
							-------------------------------------------------------------------------------------------- */
							//	Changed to work with the master array -- Lærke
							//	Modified to (condition) ? value1 : value2 -- Scott
							?>
							<select id='sC' onchange="countryChange('<?php echo $GetName; ?>', <?php echo $asset; ?>)">
								<?php
								foreach ($_SESSION['nav_ln_array'] as $tempArray) {
									echo "<option value='$tempArray[2]" . ($asset == 1 ? '?asset=1' : '') . '\'' . ($st == $tempArray[0] ? ' selected=\'selected\'' : '') . ">" . translate($tempArray[1], $tempArray[0], 'sys') . '</option>';
								}
								?>
							</select>

							<?php
							if ($asset === 0) {
								/* -----------------------------------------------------------------------------------------
									display help button
								-------------------------------------------------------------------------------------------- */
								?>
								<a href='#' id='helpMenu' class='helpSelection' onclick="helpClick()"><img src='./images/iconHelp.png' alt="help" style='margin-left: 0; margin-right: -8px; margin-bottom: -10px; ' width="32" height="32" /></a>

								<?php
								/* -----------------------------------------------------------------------------------------
									display ☰ hamburger menu
								----------------------------------------------------------------------------------------- */
								?>
								<input type="checkbox" id="togglerID" class="toggler">
								<div class="hamburger">
									<div></div>
								</div>
								<!--  document.querySelectorAll('div.hamburger')[0]  get div.hamburger -->
								<div class="menu">
									<div>
										<ul id="submenu">
											<li><a href='#' onclick="window.open('<?php echo $Scriptname; ?>', '_self')"><?php echo translate('Home', $st, 'sys'); ?></a></li>
											<li><a href='#' onclick="aboutSection('H');"><?php echo translate('Help', $st, 'sys'); ?></a></li>
											<li><a id='aboutArrow' style="cursor: pointer; margin-left: -16px; " onclick="AboutOO()">▸<?php echo translate('About', $st, 'sys'); ?></a></li>
											<div id="AboutOffOn" style="display: none; ">
												<li><a href='#' onclick="aboutSection('CR');"><?php echo translate('Copyright', $st, 'sys'); ?></a></li>
												<li><a href='#' onclick="aboutSection('CU');"><?php echo translate('Content providers and partners', $st, 'sys'); ?></a></li>
												<li><a href='#' onclick="aboutSection('TC');"><?php echo translate('Terms and Conditions', $st, 'sys'); ?></a></li>
												<li><a href='#' onclick="aboutSection('P');"><?php echo translate('Privacy Policy', $st, 'sys'); ?></a></li>
											</div>
											<li><a href='#' onclick="menuSet = 0; window.open('./Feedback/Feedback.php?st=<?php echo $st; ?>')"><?php echo translate('Contact Us', $st, 'sys'); ?></a></li>
											<?php if ($st == 'eng') { ?>
												<li><a href='#' onclick="menuSet = 0; window.open('https://give.sil.org/campaign/814239/donate')"><?php echo translate('Donate', $st, 'sys'); ?></a></li>
											<?php }
											if ($st == 'eng' || $st == 'spa') { ?>
												<li><a href='#' onclick="menuSet = 0; window.open('./promotionMaterials/promotion.php?st=<?php echo $st; ?>')"><?php echo translate('Promotion Materials', $st, 'sys'); ?></a></li>
											<?php } ?>
										</ul>
									</div>
								</div>
							<?php
							}
							?>
						</form>
					</div>

					<iframe id="myFrame" allowfullscreen="true" frameborder="0" marginheight="0" marginwidth="0" style="display: block; height: 100%; width: 80%; overflow:hidden; border: none; display: none; margin:0; padding:0; position: absolute; top: 200px; bottom: 0; right: 10%; left: 10%; z-index: 10; background-color: white; border: 5px solid black; box-shadow: 20px 20px 10px black, 0 0 400px black, 0 0 400px navy; " src=""></iframe>

					<br style='clear: both; padding-top: 20px; ' />

					<?php
					// top: -700 problem here 4/3/19
					$which = 'Name';
					/* *************************************************************************************
							Country Table
					************************************************************************************* */
					// ***********************************************************************************
					// asset
					include('./include/00-CountryTable.inc.php');
					// ***********************************************************************************
					?>

					<?php // display counter
					Counter("AllCounter", false);											// Total website counter, don't display
					Counter("AllMLCounter", false);											// All of the major languages counter, don't display
					if ($GetName == 'all') {
						Counter($counterName . "MLCounter", true);							// All of the major language counter, display
					}
					else {
						Counter($counterName . "MLCounter", false);
						Counter($counterName . "ML_" . $GetName . "_Counter", false);		// All of the major language and the Country language counter, display
					}
				}
			}
			/*  *********************************************************************************************************
			/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/
					"nothing" so start over
			/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/
			********************************************************************************************************** */
			else {
				if ($asset === 0) {
				?>
					<div id="background_header" style="background-image: url('../images/00<?php echo $st; ?>-ScriptureEarth_header.jpg'); "><div style="cursor: pointer; " onclick="window.open('<?php echo $Scriptname; ?>', '_self')"><img id="empty" src="./images/empty.png" /></div></div> <!-- ScriptureEarth and the Earth image -->
					<div id="background" style="background-image: url('../images/background_earth.jpg'); "></div> <!-- ScriptureEarth and the Earth image -->
				<?php
				}
				else {
					echo '<div id="background" style="background-image: url(\'../images/background_earth.jpg\'); opacity: 0; "></div>';	// ScriptureEarth and the Earth image
				}
				?>
				<!-- div style="position: absolute; top: 0; left: 20%; width: 35%; "> < !-- "empty" "window" over "Scripture Earth" if you click on it the script links to "00i-Scripture_Index.org" -- >
					<div style="position: relative; top: 0; left: 0; z-index: 10; cursor: pointer; " onclick="window.open('< ?php echo $Scriptname; ?>', '_self')"><img id="empty" src="./images/empty.png" /></div>
				</div -->

				<div class="threeMenus">
					<?php
					/* -----------------------------------------------------------------------------------------------
						display 'English', 'Spanish', ... drop-down select menu, help button, and hamburger menu
       				----------------------------------------------------------------------------------------------- */
					?>
					<form id="myForm" class="formNavAndHelp" action="#">
						<?php
						/* -----------------------------------------------------------------------------------------
							display select a language menu
						-------------------------------------------------------------------------------------------- */
						//	Changed to work with the master array -- Lærke
						//	Modified to (condition) ? value1 : value2 -- Scott
						?>
						<select id='navLang' onchange="menuChange()">
							<?php
							foreach ($_SESSION['nav_ln_array'] as $tempArray) {
								echo "<option value='$tempArray[2]" . ($asset == 1 ? '?asset=1' : '') . '\'' . ($st == $tempArray[0] ? ' selected=\'selected\'' : '') . ">" . translate($tempArray[1], $tempArray[0], 'sys') . '</option>';
							}
							?>
						</select>

						<?php
						if ($asset === 0) {
							/* -----------------------------------------------------------------------------------------
								display help button
							-------------------------------------------------------------------------------------------- */
							?>
							<a href='#' id='helpMenu' class='helpSelection' onclick="helpClick()"><img src='./images/iconHelp.png' alt="help" width="32" height="32" /></a>

							<?php
							/* -----------------------------------------------------------------------------------------
								display ☰ hamburger menu
							-------------------------------------------------------------------------------------------- */
							?>
							<input type="checkbox" id="togglerID" class="toggler">
							<div class="hamburger">
								<div></div>
							</div>
							<?php // document.querySelectorAll('div.hamburger')[0] => get div.hamburger ?>
							<div class="menu">
								<div>
									<ul id="submenu">
										<li><a href='#' onclick="window.open('<?php echo $Scriptname; ?>', '_self')"><?php echo translate('Home', $st, 'sys'); ?></a></li>
										<li><a href='#' onclick="aboutSection('H');"><?php echo translate('Help', $st, 'sys'); ?></a></li>
										<li><a id='aboutArrow' style="cursor: pointer; margin-left: -16px; " onclick="AboutOO()">▸<?php echo translate('About', $st, 'sys'); ?></a></li>
										<div id="AboutOffOn" style="display: none; ">
											<li><a href='#' onclick="aboutSection('CR');"><?php echo translate('Copyright', $st, 'sys'); ?></a></li>
											<li><a href='#' onclick="aboutSection('CU');"><?php echo translate('Content providers and partners', $st, 'sys'); ?></a></li>
											<li><a href='#' onclick="aboutSection('TC');"><?php echo translate('Terms and Conditions', $st, 'sys'); ?></a></li>
											<li><a href='#' onclick="aboutSection('P');"><?php echo translate('Privacy Policy', $st, 'sys'); ?></a></li>
										</div>
										<li><a href='#' onclick="menuSet = 0; window.open('./Feedback/Feedback.php?st=<?php echo $st; ?>')"><?php echo translate('Contact Us', $st, 'sys'); ?></a></li>
										<?php if ($st == 'eng') { ?>
											<li><a href='#' onclick="menuSet = 0; window.open('https://give.sil.org/give/531194/#!/donation/checkout')"><?php echo translate('Donate', $st, 'sys'); ?></a></li>
										<?php }
										if ($st == 'eng' || $st == 'spa') { ?>
											<li><a href='#' onclick="menuSet = 0; window.open('./promotionMaterials/promotion.php?st=<?php echo $st; ?>')"><?php echo translate('Promotion Materials', $st, 'sys'); ?></a></li>
										<?php } ?>
									</ul>
								</div>
							</div>
						<?php
						}
						?>
					</form>
				</div>

				<iframe id="myFrame" allowfullscreen="true" frameborder="0" marginheight="0" marginwidth="0" style="display:none; height:100%; width:80%; overflow:hidden; border:none; margin:0; padding:0; position:absolute; top:200px; bottom:0; right:10%; left:10%; z-index:10; background-color:white; " src=""></iframe>

				<div class='topEnter'>
					<div class='enter'>
						<div style='border: none; padding: 0; margin-bottom: 32px; '>
							<span style='border: none; border-radius: 30px 30px 0px 0px; background-color:rgba(256,256,256,0.5); margin: 0; padding-left: 26px; padding-right: 26px; padding-top: 4px; padding-bottom: 0px; font-size: 120%; color: #AD1C2B; '><?php echo translate('Search for Scripture by:', $st, 'sys'); ?></span>
						</div>

						<?php /* -----------------------------------------------------------------------------------
								AJAX is down 2 lines here (showLanguage()).
								showLanguage(this.value) in LangSearch.js
								after 3 letter display the languages/alternate languages/ISO button
                    	-------------------------------------------------------------------------------------------- */ ?>
						<div id="showLanguageID" name="showLanguageID">
							<input type="text" id="ID" placeholder="<?php echo translate('Language (or code)', $st, 'sys'); ?>" onfocus="submenuBlur()" onKeyUp="showLanguage(this.value, '<?php echo $st; ?>', <?php echo $Internet; ?>, '<?php echo $MajorLanguage; ?>', '<?php echo $Variant_major; ?>', '<?php echo $SpecificCountry; ?>', <?php echo $asset; ?>)" value="" />
						</div>

						<?php // display the first letter(s) of the countries button ?>
						<div id="showCountryID" name="showCountryID">
							<input type="text" id="CID" autocomplete="off" placeholder="<?php echo translate('Country', $st, 'sys'); ?>" onKeyUp="showCountry(this.value, '<?php echo $st; ?>', <?php echo $Internet; ?>, '<?php echo $SpecificCountry; ?>', <?php echo $asset; ?>)" value="" />
						</div>

						<div id="listCountriesID" name="listCountriesID">
							<?php // display all of the countries button ?>
							<button id="AID" onclick="AllCountries('<?php echo $Scriptname; ?>', '<?php echo $st ?>', '<?php echo $SpecificCountry; ?>', <?php echo $Internet; ?>, <?php echo $asset; ?>)"><?php echo translate('List by Country', $st, 'sys'); ?></button>
							
							<?php // display all the countries list. 'hide' at first ?>
							<div id="countryList" style="margin-top: 0; "></div>
						</div>

						<?php // display transducent opaque 'image' ?>
						<div id="whiteOpaque" class="OpaqueWhite"></div>
					</div>
				</div>

				<script>
					document.getElementById("ID").value = '';
					document.getElementById("ID").focus();
					document.getElementById("CID").value = '';
				</script>

				<?php // language search display ?>
				<p id="LangSearch"></p>

				<?php // country search display ?>
				<p id="CountSearch"></p>

				<br />

				<?php // display all countries ?>
				<div id='showSearchCountry' style='width: 480px; display: none; '>
					<div><?php echo translate('Countries', $st, 'sys'); ?>:</div>
					<div id="CountrySearch"></div>
				</div>

				<?php // display copyright
				if ($asset === 0) {
					echo '<div id="copyright"><div>SIL Global</div></div>';
				}
			}
			?>
		</div>
	</div>

	<script>
		let menuSet = 0;

		function menuChange(idx = null) {			// idx = number or 2 charcter uppercase of country
			let Scriptname = document.getElementById("navLang").value;
			if (idx === null) {
				window.open(Scriptname, "_self");
			}
			else {
				if (typeof idx == 'number') {
					window.open(Scriptname + '?idx=' + idx, "_self");
				}
				else {
					window.open(Scriptname + '?sortby=country&name=' + idx, "_self");
				}
			}
		}

		function helpClick() {
			//let iframe = document.getElementsByTagName('iframe')[0];
			let iframe = document.getElementById("myFrame");
			iframe.src = "./00<?php echo $st; ?>-CTPHC.php?I=H";
			iframe.style.display = 'block';
			menuSet = 1;
		}

		function aboutSection(id) {
			// document.getElementById("togglerID").checked == true
			document.getElementById('togglerID').click(); // click on toggler (up above)
			//let iframe = document.getElementsByTagName('iframe')[0];
			let iframe = document.getElementById("myFrame");
			iframe.src = "./00<?php echo $st; ?>-CTPHC.php?I=" + id;
			iframe.style.display = 'block';
			menuSet = 1;
		}

		function AboutOO() {
			if (document.getElementById("AboutOffOn").style.display == "none") {
				document.getElementById("AboutOffOn").style.display = "block";
			} else {
				document.getElementById("AboutOffOn").style.display = "none";
			}
			document.getElementById("aboutArrow").innerHTML = "▾<?php echo translate('About', $st, 'sys'); ?>";
			menuSet = 0;
		}

		window.onclick = () => { // click on anywhere on the screen
			//console.log('Page clicked');
			let iframe = document.getElementById("myFrame");
			if (iframe.src != '' && menuSet == 0) {
				iframe.style.display = 'none';
				iframe.src = '';
				//document.getElementById("submenu").style.display = 'flex';
				menuSet = 1;
			} else {
				menuSet = 0;
			}
		}
	</script>

	<?php // This script HAS to be down here for the major language dropdown box to work! ?>
	<script type="text/javascript" language="javascript" src="_js/LangSearch.js?v=1.3.9"></script>