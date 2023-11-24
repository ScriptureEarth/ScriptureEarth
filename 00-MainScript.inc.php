<?php
if (session_status() == PHP_SESSION_NONE) {
	// Start the session
	session_start();
}

/*
	Can't use <div id="langBackground" in FireFox 84.0.1 with cursor: pointer; inside the id because it is a bug.
	Also, <div id="langBackground_'.$st.'" won't at all. See Web Developer, Toogle Tools on Tools.
*/

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<meta name="ObjectType" content="Document" />
<meta http-equiv="Window-target" content="_top" />
<meta name="Created-by" content="Scott Starker" />
<meta name="Updated-by" content="Scott Starker, Lærke Roager" />
<meta name="Maintained-by" content="Website" />
<meta name="Approved-by" content="Bill Dyck, Access Coordinator" />
<meta name="Copyright" content="6.2009 - <?php echo date("Y"); ?>" /> <!-- auto_copyright("2009") -->
<!-- For IE 9 and below. ICO should be 32x32 pixels in size -->
<!--[if IE]><link rel="shortcut icon" href="path/to/favicon.ico"><![endif]-->
<!-- Touch Icons - iOS and Android 2.1+ 180x180 pixels in size. -->
<link rel="apple-touch-icon-precomposed" href="./icons/apple-touch-icon-precomposed.png">
<!-- Firefox, Chrome, Safari, IE 11+ and Opera. 196x196 pixels in size. -->
<link rel="icon" href="./icons/favicon.png">
<link rel="manifest" href="./manifest.webmanifest" /> <!-- The browser should behave when the PWA installs on the user's desktop or mobile device. -->
<link rel="apple-touch-icon" href="./icons/apple-touch-icon.png" /> <!-- iOS mobile icon -->
<meta name="apple-mobile-web-app-title" content="Scripture Earth" /> <!-- title for iOS mobile icon -->
<link rel="icon" sizes="192x192" href="./icons/nice-highres.png" /> <!-- Android mobile icon -->
<meta name="application-name" content="Scripture Earth" /> <!-- title for Android mobile icon -->
<!--link rel="stylesheet" type='text/css'		href="button.css" /-->
<link rel="stylesheet" type='text/css' href="JQuery/css/style.css" />
<!-- link rel="stylesheet" type="text/css" 	href="_css/Scripture_Index.css" /-->
<link rel="stylesheet" type="text/css" href="_css/SpecificLanguage.css" />
<link rel='stylesheet' type='text/css' href='_css/00-Scripture.css?v=1.0.2' />
<link rel='stylesheet' type='text/css' href='_css/00-SEmobile.css' />
<!--link rel='stylesheet' type='text/css' 	href='_css/CountryTable.css' /-->
<!--link rel='stylesheet' type='text/css' href='_css/jplayer.BlueMonday.css' /-->
<link rel='stylesheet' type='text/css' href='_css/jplayer.blue.monday.min.css?v=0.0.3' />
<link rel='stylesheet' type='text/css' href='_css/jplayer.playlist.BlueMonday.css' />
<link rel="stylesheet" type='text/css' href="JQuery/css/jquery-ui-1.12.1.css" />
<!--script type="text/javascript" language="javascript" src="_js/jquery-1.10.1.min.js"></script-->
<script type="text/javascript" language="javascript" src="JQuery/js/jquery-1.12.4.min.js"></script>
<script type="text/javascript" language="javascript" src="JQuery/js/jquery-ui-1.12.1.min.js"></script>
<script type="text/javascript" language="javascript" src="_js/jquery.jplayer-2.9.2.min.js"></script>
<script type="text/javascript" language="javascript" src="_js/jplayer.playlist.min.js"></script>
<script type="text/javascript" language="javascript" src="_js/user_events.js?v=1.0.2"></script>
<script type="text/javascript" language="javascript" src="_js/SpecificLanguage.js?v=1.0.5"></script>
<script type='text/javascript' language='javascript1.2' src="_js/00-SpecificLanguage.js?v=1.0.8"></script>
<!--script type='text/javascript' language='javascript'	src="_js/LangSearch.js?v=1.0.3"></script-->
<!--link rel='stylesheet' type='text/css' 	href='_css/boilerplate.css' /-->
<link rel='stylesheet' type='text/css' href='_css/FGL.css' />
<link rel='stylesheet' type='text/css' href='_css/jplayer-m.css' />
<link rel='stylesheet' type='text/css' href='_css/CountryLangIndivlang-m.css' />

<?php
if (!isset($st) || !isset($Variant_major) || !isset($MajorLanguage) || !isset($SpecificCountry) || !isset($counterName)) {
	die('Hack!');
}

/*
	The following files are included in this php:
		./include/00-SpecificLanguage.inc.php
		./include/00-CountryTable.inc.php
		00-CountriesList.php
		00-CellPhoneModule.php
		00-DownloadStudy.php
		00-DownloadPDF.php
		00-AudioSaveZip.php
		00-BegList.php
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
	$_SESSION['MajorLanguage'] = $MajorLanguage;
	$_SESSION['Variant_major'] = $Variant_major;
	$_SESSION['SpecificCountry'] = $SpecificCountry;
	$_SESSION['counterName'] = $counterName;
	$_SESSION['Scriptname'] = $Scriptname;
	$_SESSION['FacebookCountry'] = $FacebookCountry;
	$_SESSION['MajorCountryAbbr'] = $MajorCountryAbbr;
}

// master list of the naviagational languages
if (!isset($_SESSION['nav_ln_array'])) {
	$_SESSION['nav_ln_array'] = [];
	$ln_temp_var = '';
	$ln_query = 'SELECT `translation_code`, `name`, `nav_fileName`, `ln_number`, `language_code`, `ln_abbreviation` FROM `translations` ORDER BY `ln_number`';
	$ln_result_temp = $db->query($ln_query) or die('Query failed:  ' . $db->error . '</body></html>');
	if ($ln_result_temp->num_rows == 0) {
		die('<div style="background-color: white; color: red; font-size: 16pt; padding-top: 20px; padding-bottom: 20px; margin-top: 200px; ">' . translate('The translation_code is not found.', $st, 'sys') . '</div></body></html>');
	}
	while ($ln_row = $ln_result_temp->fetch_array()) {
		$ln_temp[0] = $ln_row['translation_code'];
		$ln_temp[1] = $ln_row['name'];
		$ln_temp[2] = $ln_row['nav_fileName'];
		$ln_temp[3] = $ln_row['ln_number'];
		$ln_temp[4] = $ln_row['ln_abbreviation'];
		$_SESSION['nav_ln_array'][$ln_row['language_code']] = $ln_temp;
		$ln_temp_var .= 'LN_' . $ln_temp[1] . ', ';								// must have a space (' ') here
	}
	$ln_result = $ln_temp_var;
	$_SESSION['ln_result'] = $ln_result;
}
/*if (!isset($_SESSION['ln_result'])) {
	$ln_query = "SELECT `name` FROM `translations` ORDER BY `ln_number`";
	$ln_result_temp=$db->query($ln_query) or die ('Query failed:  ' . $db->error . '</body></html>');
	if ($ln_result_temp->num_rows == 0) {
		die ('<div style="background-color: white; color: red; font-size: 16pt; padding-top: 20px; padding-bottom: 20px; margin-top: 200px; ">' . translate('The translation_code is not found.', $st, 'sys') . '</div></body></html>');
	}
	$ln_temp_var = '';
	while ($ln_row = $ln_result_temp->fetch_array()){
		$ln_temp_var .= 'LN_'.$ln_row['name'].', ';
	}
	$ln_result = $ln_temp_var;
	$_SESSION['ln_result'] = $ln_result;
}*/

/*
	*************************************************************************************************************
		Internet?
	*************************************************************************************************************
*/
$Internet = 0;		// localhost is 127.0.0.1 but '192.168.x.x' should be not-on-the-Internet because it's URL is part of the stand-alone server.
$Internet = (substr($_SERVER['REMOTE_ADDR'], 0, 7) != '192.168' ? 1 : 0);

$asset = 0;
if (isset($_GET['asset']) && (int)$_GET['asset'] == 1) $asset = 1;
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
</script>

</head>

<body>
	<div class="gridContainer clearfix">
		<div id="div1" class="fluid">
			<?php
			/*
            *************************************************************************************************************
                Main program
            *************************************************************************************************************
            
            / * Tablet Layout: 481px to 768px. Inherits styles from: Mobile Layout. * /
            @media screen and (max-width: 481px) {
            }
            
            / * Desktop Layout: 769px to a max of 1232px.  Inherits styles from: Mobile Layout and Tablet Layout. * /
            @media only screen and (min-width: 769px) {
            }
        
        */

			if (isset($_GET['sortby']) && (isset($_GET['name'])) || isset($_GET['iso']) || isset($_GET['ISO_ROD_index']) || isset($_GET['idx'])) {		// if (sortby and name (or iso)) or search
				/*  *****************************************************************************************************
				/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/
					sortby = "lang" and iso/name = [ISO] or idx/ISO_ROD_index = [0-9]{1,5}
				/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/
				*****************************************************************************************************  */
				if ((isset($_GET['sortby']) && $_GET['sortby'] == 'lang') || isset($_GET['iso']) || isset($_GET['ISO_ROD_index']) || isset($_GET['idx'])) {
					if (!isset($_GET['name']) && !isset($_GET['iso']) && !isset($_GET['ISO_ROD_index']) && !isset($_GET['idx'])) {
						die('Die hacker!</body></html>');
					} else {
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
								die('Die hacker!</div></div></body></html>');
							}
							// here check
							if ($asset == 1) {
								$query = "SELECT DISTINCT nav_ln.*, $SpecificCountry, countries.ISO_Country FROM nav_ln, countries, ISO_countries, CellPhone WHERE countries.ISO_Country = ISO_countries.ISO_countries AND ISO_countries.ISO = nav_ln.ISO AND nav_ln.ISO_ROD_index = '$ISO_ROD_index' AND `nav_ln`.`ISO_ROD_index` = `CellPhone`.`ISO_ROD_index` AND `CellPhone`.`Cell_Phone_Title` = 'iOS Asset Package'";
							} else {
								$query = "SELECT DISTINCT nav_ln.*, $SpecificCountry, countries.ISO_Country FROM nav_ln, countries, ISO_countries WHERE countries.ISO_Country = ISO_countries.ISO_countries AND ISO_countries.ISO = nav_ln.ISO AND nav_ln.ISO_ROD_index = '$ISO_ROD_index'";
							}
						} else {
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
								die('Die hacker!</body></html>');
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
										die('Hack!</body></html>');
									}
								}
							}
							// here - check						
							if ($asset == 1) {
								if (!isset($ROD_Code) && !isset($Variant_Code)) {
									$resultTest = $db->query("SELECT nav_ln.ISO FROM nav_ln, CellPhone WHERE nav_ln.ISO = '$ISO' AND `nav_ln`.`ISO` = `CellPhone`.`ISO` AND `CellPhone`.`Cell_Phone_Title` = 'iOS Asset Package'");
									$query = "SELECT DISTINCT nav_ln.*, $SpecificCountry, countries.ISO_Country FROM nav_ln, countries, ISO_countries, CellPhone WHERE countries.ISO_Country = ISO_countries.ISO_countries AND ISO_countries.ISO = nav_ln.ISO AND nav_ln.ISO = '$ISO' AND `nav_ln`.`ISO` = `CellPhone`.`ISO` AND `CellPhone`.`Cell_Phone_Title` = 'iOS Asset Package'";
								} elseif (isset($ROD_Code) && !isset($Variant_Code)) {
									$resultTest = $db->query("SELECT nav_ln.ISO FROM nav_ln, CellPhone WHERE nav_ln.ISO = '$ISO' AND nav_ln.ROD_Code = '$ROD_Code' AND `nav_ln`.`ISO` = `CellPhone`.`ISO` AND `CellPhone`.`Cell_Phone_Title` = 'iOS Asset Package' AND nav_ln.ROD_Code = `CellPhone`.`ROD_Code`");
									$query = "SELECT DISTINCT nav_ln.*, $SpecificCountry, countries.ISO_Country FROM nav_ln, countries, ISO_countries, CellPhone WHERE countries.ISO_Country = ISO_countries.ISO_countries AND ISO_countries.ISO = nav_ln.ISO AND nav_ln.ISO = '$ISO' AND nav_ln.ROD_Code = '$ROD_Code' AND `nav_ln`.`ISO` = `CellPhone`.`ISO` AND `CellPhone`.`Cell_Phone_Title` = 'iOS Asset Package'";
								} elseif (!isset($ROD_Code) && isset($Variant_Code)) {
									$resultTest = $db->query("SELECT nav_ln.ISO FROM nav_ln, CellPhone WHERE nav_ln.ISO = '$ISO' AND nav_ln.Variant_Code = '$Variant_Code' AND `nav_ln`.`ISO` = `CellPhone`.`ISO` AND `CellPhone`.`Cell_Phone_Title` = 'iOS Asset Package' AND nav_ln.Variant_Code = `CellPhone`.`Variant_Code`");
									$query = "SELECT DISTINCT nav_ln.*, $SpecificCountry, countries.ISO_Country FROM nav_ln, countries, ISO_countries, CellPhone WHERE countries.ISO_Country = ISO_countries.ISO_countries AND ISO_countries.ISO = nav_ln.ISO AND nav_ln.ISO = '$ISO' AND (nav_ln.Variant_Code = '$Variant_Code' OR isnull(nav_ln.Variant_Code)) AND `nav_ln`.`ISO` = `CellPhone`.`ISO` AND `CellPhone`.`Cell_Phone_Title` = 'iOS Asset Package'";
								} else {
									$resultTest = $db->query("SELECT nav_ln.ISO FROM nav_ln, CellPhone WHERE nav_ln.ISO = '$ISO' AND nav_ln.ROD_Code = '$ROD_Code' AND nav_ln.Variant_Code = '$Variant_Code' AND `nav_ln`.`ISO` = `CellPhone`.`ISO` AND `CellPhone`.`Cell_Phone_Title` = 'iOS Asset Package' AND nav_ln.ROD_Code = `CellPhone`.`ROD_Code` AND nav_ln.Variant_Code = `CellPhone`.`Variant_Code`");
									$query = "SELECT DISTINCT nav_ln.*, $SpecificCountry, countries.ISO_Country FROM nav_ln, countries, ISO_countries, CellPhone WHERE countries.ISO_Country = ISO_countries.ISO_countries AND ISO_countries.ISO = nav_ln.ISO AND nav_ln.ISO = '$ISO' AND nav_ln.ROD_Code = '$ROD_Code' AND (nav_ln.Variant_Code = '$Variant_Code' OR isnull(nav_ln.Variant_Code)) AND `nav_ln`.`ISO` = `CellPhone`.`ISO` AND `CellPhone`.`Cell_Phone_Title` = 'iOS Asset Package'";
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
								} elseif ($resultTest->num_rows == 0) {
									die('<div style="background-color: white; color: red; font-size: 16pt; padding-top: 20px; padding-bottom: 20px; margin-top: 200px; ">' . translate('The ISO language code is not found.', $st, 'sys') . '</div></body></html>');
								} else {
								}				// ($resultTest->num_rows == 1)
							} else {
								if (!isset($ROD_Code) && !isset($Variant_Code)) {
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

								if ($resultTest->num_rows > 1) {														// in case someone does ?sortby=lang&name=[ZZZ] and there is more than one ROD Code
									/*
									*************************************************************************************************************
										more than 1 ROD Code/Variant code
									*************************************************************************************************************
								*/
									include './00-moreThanOneRODCode.php';
									return;
								} elseif ($resultTest->num_rows == 0) {
									die('<div style="background-color: white; color: red; font-size: 16pt; padding-top: 20px; padding-bottom: 20px; margin-top: 200px; ">' . translate('The ISO language code is not found.', $st, 'sys') . '</div></body></html>');
								} else {
								}			// ($resultTest->num_rows == 1)
							}
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
							}(document, "script", "facebook-jssdk"));
						</script>
						<?php
						/*
						*************************************************************************************************************
							select the default primary language name to be used by displaying the Countries and indigenous langauge names
						*************************************************************************************************************
					*/
						$result = $db->query($query) or die(translate('Query failed:', $st, 'sys') . ' ' . $db->error . '</body></html>');
						if ($result->num_rows <= 0) {
							die('<div style="background-color: white; color: red; font-size: 16pt; padding-top: 20px; padding-bottom: 20px; margin-top: 200px; ">' . translate('The ISO language code is not found.', $st, 'sys') . '</div></body></html>');
						}
						$row = $result->fetch_array();
						$ISO_ROD_index = $row['ISO_ROD_index'];
						$ISO = trim($row['ISO']);
						$ROD_Code = trim($row['ROD_Code']);
						$Variant_Code = trim($row['Variant_Code']);
						$GetName = trim($row['ISO_Country']);																					// 2 UPPER CASE letters indicating the coutry the ISO is from
						$countryTemp = $SpecificCountry;
						if (strpos("$SpecificCountry", '.')) $countryTemp = substr("$SpecificCountry", strpos("$SpecificCountry", '.') + 1);	// In case there's a "." in the "country"
						$country = trim($row["$countryTemp"]);																				// name of the country in the language version
						//$i=0;			// used in 00-DBLanguageCountryName.inc.php include
						include('./include/00-DBLanguageCountryName.inc.php');																// Get the variant language name. $row must be set! The 'return' value is $LN.
						echo '<div id="langBackground" style="cursor: pointer; " onclick="window.open(\'' . $Scriptname . '\', \'_self\')">';
						echo "<img src='images/00" . $st . "-ScriptureEarth_header.jpg' class='langHeader' alt='" . translate('Scripture Resources in Thousands of Languages', $st, 'sys') . "' />";									// just the ScriptureEarth.org icon
						echo '</div>';
						/*
						*************************************************************************************
							execute the include file which lists all of the indigenous languages
						*************************************************************************************
					*/
						// Cross Site Scripting (XSS) attack happens where client side code (usually JavaScript) gets injected into the output of your PHP script. The next line cleans it up.
						$LN = htmlspecialchars($LN, ENT_QUOTES, 'UTF-8');
						?>

						<div class='menuBar'>
							<div class='MajorLanguages'>

								<?php /* ---------------------------------------------------------------------------------
										display home page button
                            ------------------------------------------------------------------------------------------ */ ?>
								<button onClick="window.open('<?php echo $Scriptname; ?>', '_self')"><?php echo translate('Home', $st, 'sys'); ?></button>

								<?php /* ---------------------------------------------------------------------------------
										display 'English', 'Spanish', ... drop-down menu
                            ------------------------------------------------------------------------------------------ */
								// Changed to work with the master array -- Laerke
								?>
								<select id="sL" onchange="langChange('<?php echo $ISO_ROD_index; ?>', '<?php echo $LN; ?>', '<?php echo $ISO; ?>')">
									<?php foreach ($_SESSION['nav_ln_array'] as $code => $array) {
										$html = "<option value='" . $array[2] . ($asset == 1 ? '?asset=1' : '') . "' here>" . translate($array[1], $array[0], 'sys') . "</option>";
										if ($st == $array[0]) {
											$result = str_replace("here", 'selected="selected"', $html);
										} else {
											$result = str_replace("here", '', $html);
										}
										echo $result;
									} ?>
								</select>

							</div>
						</div>

						<?php
						// here check
						if ($asset == 1) {
							echo "<div style='background-color: white; color: navy; font-size: 16pt; padding-top: 20px; padding-bottom: 20px; margin-top: 200px; cursor: pointer; ' onclick='iOSLanguage(\"" . $st . "\", $ISO_ROD_index, \"" . $LN . "\, \"" . $URL . "\")'>$LN ($optional != '' ? $optional : '') | $ISO | $country</div>";
							return;
						}

						// ********************************************************************************************************
						include('./include/00-SpecificLanguage.inc.php');					// Specific minority language display
						// ********************************************************************************************************

						/* ---------------------------------------------------------------------------------------
									display counter
                    ------------------------------------------------------------------------------------------ */
						Counter('AllCounter', false);											// Total website counter, don't display
						Counter('AllMLCounter', false);											// All of the major languages counter, don't display
						Counter('All_' . $ISO . '_Counter', false);									// All of the ISO counter, don't display
						Counter('All_' . $GetName . '_' . $ISO . '_Counter', false);					// All of the Country and the varient language counter, don't display
						Counter($counterName . 'MLCounter', false);								// All of the major language counter, don't display
						Counter($counterName . 'ML_' . $GetName . '_Counter', false);				// All of the major language and the Country counter, don't display
						?>

						<div>
							<div class="langCounter">
								<?php
								Counter($counterName . "ML_" . $GetName . "_" . $ISO . "_Counter", true);		// All of the major language and the Country and the varient language counter, display
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

						<?php /* ---------------------------------------------------------------------------------
									display Feedback button
                    ------------------------------------------------------------------------------------------ */ ?>
						<div id="feedback" style="top: 60px; " onClick="window.open('Feedback/Feedback.php?st=<?php echo $st . '&iso=' . $ISO . '&rod=' . $ROD_Code . '&var=' . $Variant_Code . '&idx=' . $ISO_ROD_index; ?>')">
							<div><?php echo translate('Feedback', $st, 'sys'); ?></div>
						</div>

						<?php /* ---------------------------------------------------------------------------------
									display copyright
                    ------------------------------------------------------------------------------------------ */ ?>
						<div id='copyright' style='top: 140px; '>
							<!--div>© < ?php echo translate('Copyright', $st, 'sys'); ?> < ?php echo date('Y'); ?> ScriptureEarth.org</div-->
							<div id='aboutLang' title="<?php echo translate('Tap to find out more about the purpose and content of the site.', $st, 'sys'); ?>" onClick="aboutLang('<?php echo $st; ?>')">© <?php echo date('Y') . ' ' .  translate('About this site', $st, 'sys'); ?></div>
						</div>
					<?php
					}
				}
				/*  *****************************************************************************************************
				/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/
					sortby = country
				/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/
				*****************************************************************************************************  */
				if (isset($_GET['sortby']) && $_GET['sortby'] == 'country') {
					$GetName = trim($_GET['name']);											// 2 uppercase letters for the country code (table countries.ISO_Country) or 'all':
					if (preg_match('/^(all)/i', $GetName)) {
						//header("Location: https://www.ScriptureEarth.org/$Scriptname");		// Redirect browser
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

					$query = "SELECT DISTINCT $SpecificCountry FROM countries ORDER BY ISO_Country";
					$result = $db->query($query);
					if ($result->num_rows == 0) {
						die("<br />$GetName " . translate('wasn’t found.<br />(The ‘country name’ was changed to a ‘country code’.<br />Did you use a bookmark with this browser?)', $st, 'sys') . "</body></html>");
					}
					$r = $result->fetch_array();
					$countryTemp = $SpecificCountry;
					if (strpos("$SpecificCountry", '.')) $countryTemp = substr("$SpecificCountry", strpos("$SpecificCountry", '.') + 1);			// In case there's a "." in the "country"
					$country = trim($r["$countryTemp"]);								// name of the full country if there is one

					// "$country" = "$SpecificCountry" (full country name)

					/*
					*************************************************************************************
							Country Table
					*************************************************************************************
				*/
					?>

					<!--img id="background" src='./images/00< ?php echo $st ?>-BackgroundFistPage.jpg' alt='< ?php echo translate('Scripture Resources in Thousands of Languages', $st, 'sys'); ?>' /--> <!-- ScripturEarth and the Earth image -->
					<div id="background" class="<?php echo $st; ?>-header"></div> <!-- ScriptureEarth and the Earth image -->

					<div style="position: absolute; top: 0px; left: 0px; width: 100%; "> <!-- "empty" "window" over "Scripture Earth" if you click on it the script links to "00i-Scripture_Index.org" -->
						<div style="position: relative; top: 0px; left: 0px; width: 100%; z-index: 10; cursor: pointer; " onclick="window.open('<?php echo $Scriptname; ?>', '_self')"><img id="empty" src="./images/empty.png" /></div>
					</div>

					<?php /* ---------------------------------------------------------------------------------
							display home page button
                ------------------------------------------------------------------------------------------ */ ?>
					<div id='homeCountry'>
						<button class='homeCountryButton' onclick="window.open('<?php echo $Scriptname . ($asset == 1 ? '?asset=1' : ''); ?>', '_self')"><?php echo translate('Home', $st, 'sys'); ?></button>
					</div>

					<?php /* ---------------------------------------------------------------------------------
							display 'English', 'Spanish', ... drop-down menu
                ------------------------------------------------------------------------------------------ */
					// Changed to work with the master array -- Laerke
					// added $asset -- Scott
					?>
					<div class="FormCountry">
						<form action="#">
							<select id="sC" onchange="countryChange('<?php echo $GetName; ?>', <?php echo $asset; ?>)">
								<?php
								foreach ($_SESSION['nav_ln_array'] as $code => $array) {
									$html = "<option value='" . $array[2] . "' here>" . translate($array[1], $array[0], 'sys') . "</option>";
									if ($st == $array[0]) {
										$result = str_replace("here", 'selected="selected"', $html);
									} else {
										$result = str_replace("here", '', $html);
									}
									echo $result;
								}
								?>
							</select>
						</form>
					</div>

					<br style='clear: both; padding-top: 20px; ' />

					<?php
					// top: -700 problem here 4/3/19
					$which = 'Name';
					// *********************************************************************************
					// here - check
					include('./include/00-CountryTable.inc.php');					// Country table
					// *********************************************************************************
					?>

					<?php /* ---------------------------------------------------------------------------------
							display counter
                ------------------------------------------------------------------------------------------ */ ?>
					<?php
					Counter("AllCounter", false);											// Total website counter, don't display
					Counter("AllMLCounter", false);											// All of the major languages counter, don't display
					if ($GetName == 'all') {
						Counter($counterName . "MLCounter", true);							// All of the major language counter, display
					} else {
						Counter($counterName . "MLCounter", false);
					?>
						<!--div class="countryCounter"-->
						<?php
						Counter($counterName . "ML_" . $GetName . "_Counter", false);		// All of the major language and the Country language counter, display
						?>
						<!--/div-->
					<?php
					}
					?>

					<?php /* ---------------------------------------------------------------------------------
							display Feedback button
                ------------------------------------------------------------------------------------------ */ ?>
					<!--div id="feedback" onclick="window.open('Feedback/Feedback.php?st=< ?php echo $st; ?>')">
					<div>< ?php echo translate('Feedback', $st, 'sys'); ?></div>
				</div-->

					<?php /* ---------------------------------------------------------------------------------
							display copyright
                ------------------------------------------------------------------------------------------ */ ?>
					<!--div id='copyright'>
                    <! --div>© < ?php echo translate('Copyright', $st, 'sys'); ?> < ?php echo date('Y'); ?> ScriptureEarth.org</div- ->
                    <div>© < ?php echo date('Y'); ?> ScriptureEarth.org</div>
				</div-->
				<?php
				}
			} else {
				/*  *****************************************************************************************************
				/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/
					 Nothing. Are 'sortby' and 'name' or 'sortby' country not there? Start over.
				/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/
				*****************************************************************************************************  */
				?>
				<div id="background" class="<?php echo $st; ?>-header"></div> <!-- ScriptureEarth and the Earth image -->

				<div style="position: absolute; top: 0px; left: 0px; width: 100%; "> <!-- "empty" "window" over "Scripture Earth" if you click on it the script links to "00i-Scripture_Index.org" -->
					<div style="position: relative; top: 0px; left: 0px; z-index: 10; cursor: pointer; " onclick="window.open('<?php echo $Scriptname; ?>', '_self')"><img id="empty" src="./images/empty.png" /></div>
				</div>
				<?php /*
			<!-- AJAX is here. -->
			<!-- showLanguage(this.value) in autoLanguage.js and myFuncttranslate('Home', $st, 'sys')ion(this.value, '$st') in autoLanguage.js -->
			*/ ?>

				<div class='topEnter'>
					<div class='enter'>

						<?php /* -----------------------------------------------------------------------------
									after 3 letter display the languages/alternate languages/ISO button
                    -------------------------------------------------------------------------------------- */ ?>
						<div id="showLanguageID" name="showLanguageID">
							<input type="text" id="ID" title="<?php echo translate('Find a language page: type at least 3 letters of the language name or code (ISO 639-3).', $st, 'sys'); ?>" placeholder="<?php echo translate('Language (or code)', $st, 'sys'); ?>" onKeyUp="showLanguage(this.value, '<?php echo $st; ?>', <?php echo $Internet; ?>, '<?php echo $MajorLanguage; ?>', '<?php echo $Variant_major; ?>', '<?php echo $SpecificCountry; ?>', <?php echo $asset; ?>)" value="" />
						</div>

						<?php /* -----------------------------------------------------------------------------
									display the first letter(s) of the countries button
                    -------------------------------------------------------------------------------------- */ ?>
						<div id="showCountryID" name="showCountryID">
							<input type="text" id="CID" autocomplete="off" title="<?php echo translate('Find a country list: type the country name.', $st, 'sys'); ?>" placeholder="<?php echo translate('Country', $st, 'sys'); ?>" onKeyUp="showCountry(this.value, '<?php echo $st; ?>', <?php echo $Internet; ?>, '<?php echo $SpecificCountry; ?>', <?php echo $asset; ?>)" value="" />
						</div>

						<div id="listCountriesID" name="listCountriesID">

							<?php /* -------------------------------------------------------------------------------
										display all of the countries button
                        ---------------------------------------------------------------------------------------- */ ?>
							<button title="<?php echo translate('Tap to get a list of countries available.', $st, 'sys'); ?>" id="AID" onclick="AllCountries('<?php echo $Scriptname; ?>', '<?php echo $st ?>', '<?php echo $SpecificCountry; ?>', <?php echo $Internet; ?>, <?php echo $asset; ?>)"><?php echo translate('List by Country', $st, 'sys'); ?></button>

							<?php /*- ------------------------------------------------------------------------------
										display home page button. 'hide' at first
                        ---------------------------------------------------------------------------------------- */ ?>
							<div id="home">
								<button class="homeAllCountries" onclick="window.open('<?php echo $Scriptname . ($asset == 1 ? '?asset=1' : ''); ?>', '_self')"><?php echo translate('Home', $st, 'sys'); ?></button>
							</div>

							<?php /* -------------------------------------------------------------------------------
										display all the countries list. 'hide' at first
                        ---------------------------------------------------------------------------------------- */ ?>
							<div id="countryList"></div>

						</div>

						<?php /* -----------------------------------------------------------------------------
									display transducent opaque 'image'
                    -------------------------------------------------------------------------------------- */ ?>
						<div id="whiteOpaque" class="OpaqueWhite"></div>

					</div>
				</div>

				<div id="container">
					<div id="mainContent">

						<?php
						if ($asset != 1) {
							/* -----------------------------------------------------------------------------
										display 'About this site' button
						-------------------------------------------------------------------------------------- */ ?>
							<div id='about' class="button" style='border-radius: 12px; ' title="<?php echo translate('Tap to find out more about the purpose and content of the site.', $st, 'sys'); ?>" onClick="about('<?php echo $st; ?>')"><?php echo translate('About this site', $st, 'sys'); ?></div>
						<?php
						}
						/* -----------------------------------------------------------------------------
									display "Home" button. 'show' if 'About this site' button is clicked
                    -------------------------------------------------------------------------------------- */ ?>
						<div id='statements'>
							<button class='homeAbout' onclick="window.open('<?php echo $Scriptname; ?>', '_self')"><?php echo translate('Home', $st, 'sys'); ?></button>
						</div>

						<?php
						if ($asset != 1) {
							/* -----------------------------------------------------------------------------
										sub-menus are displayed if 'About this site' button is clicked
						-------------------------------------------------------------------------------------- */ ?>
							<div class='site'>
								<div style='background-color: white; margin-top: -220px; margin-bottom: 20px; '>
									<output id='results'></output> <!-- Gives the about($st) text. -->
									<?php
									//include './include/00-about_help.inc.php';
									?>

									<br /><br /><br />

									<ul id="ul<?php echo $SpecificCountry; ?>" class="ul<?php echo $SpecificCountry; ?>">
										<?php
										include './include/00-MajorLanguageAbout.inc.php';				// Major language bottom banner menu
										?>
									</ul>
								</div>
							</div>
						<?php
						}
						?>

						<img id="myShadow" class="myShadow" src="./images/shadow2.png" />

						<?php /* -----------------------------------------------------------------------------
									display 'English', 'Spanish', ... drop-down menu
                    -------------------------------------------------------------------------------------- */
						// in the element 'form', display: block = center when there is no 'About' botton
						// Changed to work with the master array -- Laerke
						?>
						<form id="myForm" style="display: <?php echo ($asset == 1 ? 'block; ' : 'inline; ') ?>" action="#">
							<select id="sM" style="font-size: 1em; padding: 6px; " title="<?php echo translate('Click here to choose the interface language.', $st, 'sys'); ?>">
								<?php
								foreach ($_SESSION['nav_ln_array'] as $code => $array) {
									// Scott:
									echo "<option style='text-align-last: left; ' value='$array[2]" . ($asset == 1 ? '?asset=1' : '') . '\'' . ($st == $array[0] ? ' selected=\'selected\'' : '') . ">" . translate($array[1], $array[0], 'sys') . '</option>';
									/*
								// Laerke:
								$html = "<option style='text-align: left; ' value='".$array[2].($asset == 1 ? '?asset=1' : '')."' here>".translate($array[1], $array[0], 'sys')."</option>";
								if ($st == $array[0]){
									$result_nav = str_replace("here",'selected="selected"',$html);
								} else{
									$result_nav = str_replace("here",'',$html);
								}
								echo $result_nav;
								*/
								}
								?>
							</select>
						</form>
						<?php // end #mainContent 
						?>
					</div>
					<?php // end #container 
					?>
				</div>

				<script>
					document.getElementById("ID").value = '';
					document.getElementById("ID").focus();
					document.getElementById("CID").value = '';
				</script>

				<?php // language search display 
				?>
				<p id="LangSearch"></p>

				<?php // country search display 
				?>
				<p id="CountSearch"></p>

				<br />

				<?php // display all countries 
				?>
				<div class='Zenter' id='showSearchCountry' style='width: 480px; display: none; '>
					<div><?php echo translate('Countries', $st, 'sys'); ?>:</div>
					<div id="CountrySearch"></div>
				</div>

				<?php
				if ($asset != 1) {
					/* ---------------------------------------------------------------------------------
							display Feedback button
            ------------------------------------------------------------------------------------------ */ ?>
					<div id="feedback" style="top: 30px; " title="<?php echo translate('Thank you for providing us with your feedback and suggestions.', $st, 'sys'); ?>" onclick="window.open('Feedback/Feedback.php?st=<?php echo $st; ?>')">
						<div><?php echo translate('Feedback', $st, 'sys'); ?></div>
					</div>
				<?php
				}
				?>

				<?php /* ---------------------------------------------------------------------------------
							display copyright
            ------------------------------------------------------------------------------------------ */ ?>
				<div id='copyright' style='top: 120px; '>
					<div>ScriptureEarth.org</div>
				</div>

			<?php
			}
			?>
		</div>
	</div>
	<?php // This script HAS to be down here for the major language dropdown box to work! 
	?>
	<script type="text/javascript" language="javascript" src="_js/LangSearch.js?v=1.2.5"></script>