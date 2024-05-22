<?php
if(session_status() === PHP_SESSION_NONE) @session_start();

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
<!-- Touch Icons - iOS and Android 2.1+ 180x180 pixels in size. -->
<link rel="apple-touch-icon-precomposed" href="./icons/apple-touch-icon-precomposed.png">
<!-- Firefox, Chrome, Safari, IE 11+ and Opera. 196x196 pixels in size. -->
<link rel="icon" href="./icons/favicon.png">
<link rel="manifest" href="./manifest.webmanifest" /> <!-- The browser should behave when the PWA installs on the user's desktop or mobile device. -->
<link rel="apple-touch-icon" href="./icons/apple-touch-icon.png" /> <!-- iOS mobile icon -->
<meta name="apple-mobile-web-app-title" content="Scripture Earth" /> <!-- title for iOS mobile icon -->
<link rel="icon" sizes="192x192" href="./icons/nice-highres.png" /> <!-- Android mobile icon -->
<meta name="application-name" content="Scripture Earth" /> <!-- title for Android mobile icon -->
<link rel="icon" href="./icons/favicon.png">
<link rel="manifest" href="./manifest.webmanifest" /> <!-- The browser should behave when the PWA installs on the user's desktop or mobile device. -->
<link rel="apple-touch-icon" href="./icons/apple-touch-icon.png" /> <!-- iOS mobile icon -->
<meta name="apple-mobile-web-app-title" content="Scripture Earth" /> <!-- title for iOS mobile icon -->
<link rel="icon" sizes="192x192" href="./icons/nice-highres.png" /> <!-- Android mobile icon -->
<meta name="application-name" content="Scripture Earth" /> <!-- title for Android mobile icon -->
<!--link rel="stylesheet" type='text/css'		href="button.css" /-->
<link rel="stylesheet" type='text/css' href="JQuery/css/style.css" />
<link rel="stylesheet" type='text/css' href="JQuery/css/style.css" />
<!-- link rel="stylesheet" type="text/css" 	href="_css/Scripture_Index.css" /-->
<link rel="stylesheet" type="text/css" href="_css/SpecificLanguage.css?v=0.0.3" />
<link rel='stylesheet' type='text/css' href='_css/00-Scripture.css?v=1.0.5' />
<link rel='stylesheet' type='text/css' href='_css/00-SEmobile.css?v=0.0.2' />
<!--link rel='stylesheet' type='text/css' 	href='_css/CountryTable.css' /-->
<!--link rel='stylesheet' type='text/css' href='_css/jplayer.BlueMonday.css' /-->
<link rel='stylesheet' type='text/css' href='_css/jplayer.blue.monday.min.css?v=0.0.3' /> <!-- Playlist Video -->
<link rel='stylesheet' type='text/css' href='_css/jplayer.playlist.BlueMonday.css' /> <!-- Playlist Audio -->
<link rel="stylesheet" type='text/css' href="JQuery/css/jquery-ui-1.12.1.css" />
<!--script type="text/javascript" language="javascript" src="_js/jquery-1.10.1.min.js"></script-->
<script type="text/javascript" language="javascript" src="JQuery/js/jquery-1.12.4.min.js"></script>
<script type="text/javascript" language="javascript" src="JQuery/js/jquery-ui-1.12.1.min.js"></script>
<script type="text/javascript" language="javascript" src="_js/jquery.jplayer-2.9.2.min.js"></script>
<script type="text/javascript" language="javascript" src="_js/jplayer.playlist.min.js"></script>
<script type="text/javascript" language="javascript" src="_js/user_events.js?v=1.0.2"></script>
<script type="text/javascript" language="javascript" src="_js/SpecificLanguage.js?v=1.0.5"></script>
<script type='text/javascript' language='javascript1.2' src="_js/00-SpecificLanguage.js?v=1.0.8"></script>
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
<!--link rel='stylesheet' type='text/css' href='_css/CountryLangIndivlang-m.css' /-->

<style>
	* {
		margin: 0;
		padding: 0;
	}

	body {
		/*background: #333;*/
		/*background: black;*/
		height: 100vh;
		width: 100vw;
		margin: 0;
		padding: 0;
	}

	.toggler {
		/* ALWAYS KEEPING THE TOGGLER OR THE CHECKBOX ON TOP OF EVERYTHING :  */
		position: absolute;
		z-index: 10;
		/* Can see it though. So, use the "Tools" from the menu of the browse, click on "Browser Tools", click on "Web Developer Tools". */
		/* On the bottom menu click on "Inspector". Find <input id"togglerID" class="toggler" type="checkbox">. */
		top: 110px;							/* top position */
		width: 30px;						/* width of position */
		right: 80px;						/* right position */
		height: 30px;						/* height of position */
		opacity: 0;							/* invisible! */
		cursor: pointer;
	}

	.hamburger {
		position: absolute;
		top: 108px;							/* top of hamburger */
		right: 60px;						/* right of hamburger */
		height: 40px;
		width: 40px;
		margin: 0;
		padding: 0.6rem 0.3rem;
		/* FOR DISPLAYING EVERY ELEMENT IN THE CENTER : */
		display: flex;
		align-items: center;
		justify-content: center;
	}

	/* CREATING THE MIDDLE LINE OF THE HAMBURGER : */
	.hamburger>div {
		/* postition of hamburger */
		position: relative;
		top: -13px;
		right: 4px;							/* right of lines */
		left: -10px;						/* left of lines */
		background-color: white;			/* color of the middle line */
		height: 2px;						/* height of the middle line */
		width: 60%;							/* width  of the three lines */
		transition: all 0.4s ease;
	}

	/* CREATING THE TOP AND BOTTOM LINES : TOP AT -10PX ABOVE THE MIDDLE ONE AND BOTTOM ONE IS 10PX BELOW THE MIDDLE: */
	.hamburger>div::before,
	.hamburger>div::after {
		content: '';
		position: absolute;
		top: -10px;
		right: 0;
		background-color: white;			/* color of the top and bottoms lines */
		width: 100%;						/* width of the top and bottom lines */
		height: 2px;
		transition: all 0.4s ease;
	}

	.hamburger>div::after {
		top: 10px;
		right: 0;
	}

	/* IF THE TOGGLER IS IN ITS CHECKED STATE, THEN SETTING THE BACKGROUND OF THE MIDDLE LAYER TO COMPLETE BLACK AND OPAQUE :  */
	/* A toggled state! No JavaScript! */
	/* If the .toggler:checked is checked the label '.hamburger>div' the CSS gets executed includeing ::before and ::after. */
	.toggler:checked+.hamburger>div {
		background: rgba(0, 0, 0, 0);		/* black so it is invisible */
	}

	.toggler:checked+.hamburger>div::before {
		top: 0;
		transform: rotate(45deg);
		/* background: black; */
		/* half of the color of "X" 
		background: white;*/
	}

	/* AND ROTATING THE TOP AND BOTTOM LINES :  */
	.toggler:checked+.hamburger>div::after {
		top: 0;
		transform: rotate(135deg);
		/*background: black;*/
		/* half of the color of "X" 
		background: white;*/
	}

	/* MAIN MENU WITH THE WHITE BACKGROUND AND THE TEXT :  */
	.menu {
		/*background: white;*/
		/*background-color: rgba(0, 0, 0, 0.7);*/
		margin-left: auto;
		margin-right: 0;				/* right hand side */
		width: 20%;						/* what this the width for??? */
		/*height: 100vh;				/* what this the height for??? */
		/* APPLYING TRANSITION TO THE MENU : */
		/*transition: all 0.4s ease;*/
	}


	/* IF THE TOGGLER IS CHECKED, THEN INCREASE THE WIDTH OF THE MENU TO 30% , CREATING A SMOOTH EFFECT :  */
	.toggler:checked~.menu {
		width: 30%;						/* width of menu */
		/* width: 300px; */
		/* height: 600px;				height: 100vh;*/
	}

	/* STYLING THE LIST :  */
	.menu>div>ul {
		background-color: rgba(0, 0, 0, 0.7);
		/* APPLYING TRANSITION TO THE MENU :  */
		/*transition: all 0.4s ease;*/
		display: flex;
		flex-direction: column;
		position: fixed;
		top: 116px;
		right: 160px;
		/*padding-left: 20px;*/
		width: 280px;
		height: 100vh;
		margin-top: -5px;							/* position of hambuger menu text */
		padding-top: 5px;
		/* over from left side */
		/* HIDDEN INITIALLY  :  */
		visibility: hidden;
	}

	.menu>div>ul>li {
		display: inline flow;
		list-style: none;
		padding: 0.3rem;
		/* line height */
		margin-left: 30px;
		/*margin-right: -100px;*/
		text-align: left;
	}

	.menu>div>ul>li>a {
		color: white;
		text-decoration: none;
		font-size: 1.2rem;
		font-family: Chivo, 'Gill Sans', Tahoma, Geneva, Verdana, sans-serif;
	}

	/* WHEN THE TOGGLER IS CHECKED, CHANGE THE VISIBILITY TO VISIBLE :  */
	.toggler:checked~.menu>div>ul {
		transition: visibility 0.4s ease;
		transition-delay: 0.1s;
		visibility: visible;
	}

	.toggler:checked~.menu>div>ul>li>a:hover {
		/*color: orange;*/
		color: #d36355;
		/* 400 = normal; 700 = bold */
		font-weight: 600;
	}

	.toggler:checked~.menu>div>ul>li>a:after {
		/* won't work */
		background-color: #101010;
	}

	.menu>div>ul>div>li {
		margin-right: -100px;
	}

	.menu>div>ul>div>li>a {
		color: white;
		text-decoration: none;
		font-size: 1.1em;
		font-family: Chivo, 'Gill Sans', Tahoma, Geneva, Verdana, sans-serif;
		margin-left: -26px;
	}

	.toggler:checked~.menu>div>ul>div>li>a:hover {
		color: #d36355;
		/* 400 = normal; 700 = bold */
		font-weight: 600;
	}

	.toggler:checked~.menu>div>ul>div>li>a:after {
		/* won't work */
		background-color: #101010;
	}


	select {
		color: black;
		background-color: rgba(255, 255, 255, 0.6);
		border-radius: 0.3rem;
		margin-top: 10px;
	}

	option {
		color: black;
		background-color: white;
		font-family: Chivo, 'Gill Sans', Tahoma, Geneva, Verdana, sans-serif;
		font-weight: normal;
		font-size: 11pt;
		/*border: 1px solid #e4e4e4;*/
		/* safari */
		appearance: none;
		-webkit-appearance: none;
		-moz-appearance: none;
		/*box-shadow: inset 20px 20px #f00;
		text-align-last: left;*/
	}

	/*option:checked,
	option:hover {		 doesn't work for firefox
		background-color: white;
		/* color: #c0c0c0; * /
		cursor: pointer;
		/*border: 1px solid red;* /
		/*box-shadow: inset 20px 20px #00f;* /
	}*/

	.selectOption {
		/* none "navigational language" "select" tag; from 00-Scripture.css */
		color: black;
		/* background-color: #e4e4e4; 
		background-color: white;*/
		border: 1px solid #111;
		font-weight: normal;
		font-size: 12pt;
		padding: 3px;
		padding-left: 10px;
	}

	#sL, #sC, #navLang {
		/* "select" tag: #sL = "select Language"; $sC = "select Country"; "select nothing" */
		position: absolute;
		z-index: 5;
		top: -6px;
		right: 101px;
		/*color: #4079b0; */
		color: white;
		/* background-color: white;*/
		font-size: 100%;
		border-style: none;
		padding: 3px;
		padding-left: 16px;
	}

	#background_header {
		/* position of icon and text for "country" and "nothing" section; from 00-Scripture.css */
		position: absolute;
		z-index: 5;
		top: 0;
		background-position: top left 100px;		/* top of page */
		background-repeat: no-repeat;				/* Do not repeat the image */
		background-size: 460px;
		/*width: 100%;*/
		width: 450px;								/* this works along side of #empty width */
		/*height: auto;*/
		/*height: 840px;*/
		height: 190px;
		/*max-width: 800px;*/
		/*min-width: 1170px;*/
		margin-top: -4px;
		padding: 0;
		padding-left: 100px;
		/*overflow: auto;*/
	}
	#empty {
		margin-left: 5px;
		min-width: 440px;							/* this works along side of #background_header width */
		height: 80px;
	}

	#background {
		/* position of earth; from 00-Scripture.css */
		position: relative;
		z-index: -20;
		top: 100px;
		background-position: top;					/* top of page */
		background-repeat: no-repeat;				/* Do not repeat the image */
		background-size: 740px;
		/*height: auto;*/
		height: 840px;
		/*width: 720px;*/
		width: 100%;
		margin: 0;
		padding: 0;
		overflow: auto;
	}

	#copyright {
		/* copyright from 00-Scripture.css */
		top: 316px;
		line-height: 0px;
		border: none;
		margin: 0;
		padding: 0;
	}

	@media only screen and (max-width: 1250px) {
		#langBackground {
			/* position of icon and text for the "specific language" section; from 00-Scripture.css */
			padding-bottom: 24px;
		}
	}

	@media only screen and (min-width: 841px) and (max-width: 1100px) {
		#background {
			/* position of earth; from 00-Scripture.css */
			/*background-position: top left 90px;*/
			background-size: 740px;					/* height of 3 input lines */
			margin-top: 30px;						/* top margin of both earth and 3 input lines */
		}
		#copyright {
			/* position of earth; from 00-Scripture.css */
			top: 296px;
		}
	}

	@media only screen and (min-width: 721px) and (max-width: 840px) {
		#background {
			/* position of earth; from 00-Scripture.css */
			background-size: 680px;					/* size of earth */
			height: 820px;							/* height of 3 input lines */
			margin-top: 40px;						/* top margin of both earth and 3 input lines */
		}
	}

	@media only screen and (min-width: 601px) and (max-width: 720px) {
		#background {
			/* position of earth; from 00-Scripture.css */
			background-size: 600px;					/* size of earth */
			height: 800px;							/* height of 3 input lines */
			margin-top: 60px;						/* top margin of both earth and 3 input lines */
		}
	}

	@media only screen and (min-width: 481px) and (max-width: 600px) {
		#background_header {
			/* position of icon and text; from 00-Scripture.css */
			background-position: top left 20px;
			margin-top: -6px;						/* top margin of icon Scipture Earth text */
			background-size: 420px;					/* size of icon Scipture Earth text */
			width: 330px;							/* this works along side of #empty width */
		}
		#empty {
			margin-left: -90px;
			width: 200px;							/* this works along side of #background_header width */
			height: 80px;
		}
		#background {
			/* position of earth; from 00-Scripture.css */
			background-position: top;
			background-size: 480px;					/* size of earth */
			height: 780px;							/* height of 3 input lines */
			margin-top: 90px;						/* top margin of both earth and 3 input lines */
		}
	}

	@media only screen and (max-width: 480px) {
		#background_header {
			/* position of icon and text; from 00-Scripture.css */
			background-position: top -7px left;
			background-size: 410px;					/* size of icon Scipture Earth text */
			width: 300px;							/* this works along side of #empty width */
		}
		#empty {
			margin-left: -150px;
			width: 100px;							/* this works along side of #background_header width */
		}
		#background {
			/* position of earth; from 00-Scripture.css 
			background-position:  top 70px left 78px;*/
			background-size: 430px;					/* size of earth */
			height: 720px;							/* height of 3 input lines */
			margin-top: 80px;						/* top margin of both earth and 3 input lines */
		}
		#copyright {
			/* copyright from 00-Scripture.css */
			top: 160px;
			bottom: 0;
			font-size: 80%;
		}
		#sC {
			/* "select" tag: $sC = "select Language" */
			padding-left: 10px;
			left: 0;
			margin-left: -44px;
			margin-right: 0;
		}
	}
</style>

<?php
if (!isset($st) || !isset($Variant_major) || !isset($MajorLanguage) || !isset($SpecificCountry) || !isset($counterName)) {
	die('Hack!');
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
	$ln_result_temp = $db->query($ln_query) or die('Query failed:  ' . $db->error . '</body></html>');
	if ($ln_result_temp->num_rows == 0) {
		die('<div style="background-color: white; color: red; font-size: 16pt; padding-top: 20px; padding-bottom: 20px; margin-top: 200px; ">' . translate('The translation_code is not found.', $st, 'sys') . '</div></body></html>');
		die('<div style="background-color: white; color: red; font-size: 16pt; padding-top: 20px; padding-bottom: 20px; margin-top: 200px; ">' . translate('The translation_code is not found.', $st, 'sys') . '</div></body></html>');
	}
	while ($ln_row = $ln_result_temp->fetch_array()) {
	while ($ln_row = $ln_result_temp->fetch_array()) {
		$ln_temp[0] = $ln_row['translation_code'];
		$ln_temp[1] = $ln_row['name'];
		$ln_temp[2] = $ln_row['nav_fileName'];
		$ln_temp[3] = $ln_row['ln_number'];
		$ln_temp[4] = $ln_row['ln_abbreviation'];
		$_SESSION['nav_ln_array'][$ln_row['language_code']] = $ln_temp;
		$ln_temp_var .= 'LN_' . $ln_temp[1] . ', ';								// must have a space (' ') here
		$ln_temp_var .= 'LN_' . $ln_temp[1] . ', ';								// must have a space (' ') here
	}
	$ln_result = $ln_temp_var;
	$_SESSION['ln_result'] = $ln_result;
}

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
			/**************************************************************************************************************
            	Main program
            ***************************************************************************************************************/
			if (isset($_GET['sortby']) && (isset($_GET['name'])) || isset($_GET['iso']) || isset($_GET['ISO_ROD_index']) || isset($_GET['idx'])) {		// if (sortby and name (or iso)) or search
				/*  *****************************************************************************************************
				/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/
					sortby = "lang" and iso/name = [ISO] or idx/ISO_ROD_index = [0-9]{1,5}
				/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/
				******************************************************************************************************  */
				if ((isset($_GET['sortby']) && $_GET['sortby'] == 'lang') || isset($_GET['iso']) || isset($_GET['ISO_ROD_index']) || isset($_GET['idx'])) {
					if (!isset($_GET['name']) && !isset($_GET['iso']) && !isset($_GET['ISO_ROD_index']) && !isset($_GET['idx'])) {
						die('Die hacker!</body></html>');
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
								die('Die hacker!</div></div></body></html>');
							}
							// asset
							if ($asset == 1) {
								$query = "SELECT DISTINCT nav_ln.*, $SpecificCountry, countries.ISO_Country FROM nav_ln, countries, ISO_countries, CellPhone WHERE countries.ISO_Country = ISO_countries.ISO_countries AND ISO_countries.ISO = nav_ln.ISO AND nav_ln.ISO_ROD_index = '$ISO_ROD_index' AND `nav_ln`.`ISO_ROD_index` = `CellPhone`.`ISO_ROD_index` AND `CellPhone`.`Cell_Phone_Title` = 'iOS Asset Package'";
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
							// asset
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
							}
							else {
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
						if ($result->num_rows <= 0) {
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
						//$i=0;			// used in 00-DBLanguageCountryName.inc.php include
						include('./include/00-DBLanguageCountryName.inc.php');																// Get the variant language name. $row must be set! The 'return' value is $LN.

						/* <div id="background_header" style="background-image: url('../images/00<?php echo $st; ?>-ScriptureEarth_header.jpg'); "><div style="cursor: pointer; " onclick="window.open('<?php echo $Scriptname; ?>', '_self')"><img id="empty" src="./images/empty.png" /></div></div> <!-- ScriptureEarth and the Earth image -->
						<div id="background" style="background-image: url('../images/background_earth.jpg'); "></div> <!-- ScriptureEarth and the Earth image --> */
						echo '<div id="langBackground" style="margin-top: -12px; ">';
						echo "<span style='cursor: pointer; ' onclick='window.open(\"".$Scriptname."\", \"_self\")'><img style='min-width: 400px; max-width: 500px; ' src='images/00" . $st . "-ScriptureEarth_header.jpg' class='langHeader' alt='" . translate('Scripture Resources in Thousands of Languages', $st, 'sys') . "' /></span>";									// just the ScriptureEarth.org icon
						echo '</div>';
						
						/* *************************************************************************************
							execute the include file which lists all of the indigenous languages
						***************************************************************************************/
						// Cross Site Scripting (XSS) attack happens where client side code (usually JavaScript) gets injected into the output of your PHP script. The next line cleans it up.
						$LN = htmlspecialchars($LN, ENT_QUOTES, 'UTF-8');
						?>

						<div style="position: absolute; top: -22px; right: 80px; ">
							<?php
							/* -----------------------------------------------------------------------------------------
								display 'English', 'Spanish', ... drop-down menu AND help button
							------------------------------------------------------------------------------------------ */
							// In the element 'form', display: block = center when there is no 'About' botton.
							?>
							<form id="myForm" style="position: relative; top: 83px; right: 115px; width: 170px; display: block; " action="#">
								<?php
								// Changed to work with the master array -- Laerke
								// Modified to (condition) ? value1 : value2 -- Scott
								// <select id='navLang' class="navLangChoice" onchange="menuChange(< ?php echo $ISO_ROD_index; ? >)" title="< ?php echo translate('Click here to choose the interface language.', $st, 'sys'); ? >">
								?>
								<select id="sL" onchange="langChange('<?php echo $ISO_ROD_index; ?>', '<?php echo $LN; ?>', '<?php echo $ISO; ?>')">
									<?php
									foreach ($_SESSION['nav_ln_array'] as $tempArray) {
										echo "<option value='$tempArray[2]" . ($asset == 1 ? '?asset=1' : '') . '\'' . ($st == $tempArray[0] ? ' selected=\'selected\'' : '') . ">" . translate($tempArray[1], $tempArray[0], 'sys') . '</option>';
									}
									?>
								</select>
								<a href='#' id='helpMenu' style='position: relative; z-index: 5; ' onclick="helpClick();"><img src='./images/iconHelp.png' alt="<?php echo translate('help', $st, 'sys'); ?>" style='margin-left: 0; margin-right: -8px; margin-bottom: -10px; ' width="32" height="32" /></a>
							</form>

							<?php
							/* -----------------------------------------------------------------------------------------
								display ☰ hamburger menu
							----------------------------------------------------------------------------------------- */
							?>
							<input type="checkbox" id="togglerID" class="toggler" style="top: 85px; right: 149px; ">
							<div class="hamburger" style='margin-right: 68px; margin-top: -25px; z-index: 5; '>		<!-- style = position of hambuger (position is different from other viewers) -->
								<div></div>
							</div>

							<!--  document.querySelectorAll('div.hamburger')[0]  get div.hamburger -->
							<div class="menu" style="position: relative; z-index: 5; ">
								<div>
									<ul id="submenu" style="top: 100px; ">
										<li><a href='#' onclick="window.open('<?php echo $Scriptname; ?>', '_self')"><?php echo translate('Home', $st, 'sys'); ?></a></li>
										<li><a href='#' onclick="aboutSection('H');"><?php echo translate('Help', $st, 'sys'); ?></a></li>
										<li><a id='aboutArrow' style="cursor: pointer; margin-left: -16px; " onclick="AboutOO()">▸<?php echo translate('About', $st, 'sys'); ?></a></li>
										<div id="AboutOffOn" style="display: none; text-align: left; ">
											<li style="margin-left: 84px; margin-bottom: 8px; "><a href='#' onclick="aboutSection('CR');"><?php echo translate('Copyright', $st, 'sys'); ?></a></li>
											<li style="margin-left: 84px; margin-bottom: 8px; "><a href='#' onclick="aboutSection('CU');"><?php echo translate('Content providers and partners', $st, 'sys'); ?></a></li>
											<li style="margin-left: 84px; margin-bottom: 8px; "><a href='#' onclick="aboutSection('TC');"><?php echo translate('Terms and Conditions', $st, 'sys'); ?></a></li>
											<li style="margin-left: 84px; margin-bottom: 8px; "><a href='#' onclick="aboutSection('P');"><?php echo translate('Privacy Policy', $st, 'sys'); ?></a></li>
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
						</div>

						<iframe id="myFrame" allowfullscreen="true" frameborder="0" marginheight="0" marginwidth="0" style="display: block; height: 100%; width: 80%; overflow:hidden; border: none; display: none; margin:0; padding:0; position: absolute; top: 200px; bottom: 0; right: 10%; left: 10%; z-index: 10; background-color: white; border: 5px solid black; box-shadow: 20px 20px 10px black, 0 0 400px black, 0 0 400px navy; " src=""></iframe>

						<?php
							// asset
							if ($asset == 1) {
								echo "<div style='background-color: white; color: navy; font-size: 16pt; padding-top: 20px; padding-bottom: 20px; margin-top: 200px; cursor: pointer; ' onclick='iOSLanguage(\"" . $st . "\", $ISO_ROD_index, \"" . $LN . "\, \"" . $URL . "\")'>$LN ($optional != '' ? $optional : '') | $ISO | $country</div>";
								return;
							}

							// ********************************************************************************************************
							// /\/\/\/\/\/\/\/\/\/\/\/\/\/\//\/\/\/\/\/\/\/\/\/\/\/\/\/\//\/\/\/\/\/\/\/\/\/\/\/\/\/\//\/\/\/\/\/\/\/\/
							include('./include/00-SpecificLanguage.inc.php');				// Specific minority language display
							// /\/\/\/\/\/\/\/\/\/\/\/\/\/\//\/\/\/\/\/\/\/\/\/\/\/\/\/\//\/\/\/\/\/\/\/\/\/\/\/\/\/\//\/\/\/\/\/\/\/\/
							// ********************************************************************************************************

							// display counter
							Counter('AllCounter', false);									// Total website counter, don't display
							Counter('AllMLCounter', false);									// All of the major languages counter, don't display
							Counter('All_' . $ISO . '_Counter', false);						// All of the ISO counter, don't display
							Counter('All_' . $GetName . '_' . $ISO . '_Counter', false);	// All of the Country and the varient language counter, don't display
							Counter($counterName . 'MLCounter', false);						// All of the major language counter, don't display
							Counter($counterName . 'ML_' . $GetName . '_Counter', false);	// All of the major language and the Country counter, don't display
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
							<div id='copyright' style='top: 50px; '>
								<div id='aboutLang' title="<?php echo translate('Tap to find out more about the purpose and content of the site.', $st, 'sys'); ?>" onClick="aboutLang('<?php echo $st; ?>')">© <?php echo date('Y') . ' ' .  translate('About this site', $st, 'sys'); ?></div>
							</div>
						<?php
					}
				}
				/*  *****************************************************************************************************
				/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/
					sortby = country
				/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/
				******************************************************************************************************  */
				if (isset($_GET['sortby']) && $_GET['sortby'] == 'country') {
					?>
					<script>
						menuSet = 1;
					</script>
					<?php
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
					?>

					<!-- The id="background_header" in te next line is the error! -->
					<!-- div id="background_header" style="background-image: url('../images/00< ?php echo $st; ?>-ScriptureEarth_header.jpg'); cursor: pointer; " onclick="window.open('< ?php echo $Scriptname; ?>', '_self')"><img id="empty" src="./images/empty.png" /></div> < !-- ScriptureEarth and the Earth image -->
					<div id="background_header" style="background-image: url('../images/00<?php echo $st; ?>-ScriptureEarth_header.jpg'); "><div style="cursor: pointer; " onclick="window.open('<?php echo $Scriptname; ?>', '_self')"><img id="empty" style="min-width: 300px; max-width: 550px; " src="./images/empty.png" /></div></div> <!-- ScriptureEarth and the Earth image -->
					<div id="background" style="background-image: url('../images/background_earth.jpg'); "></div> <!-- ScriptureEarth and the Earth image -->

					<div style="position: absolute; top: -20px; right: 80px; ">
						<?php
						/* -----------------------------------------------------------------------------------------
							display 'English', 'Spanish', ... drop-down menu AND help button
       					----------------------------------------------------------------------------------------- */
						// In the element 'form', display: block = center when there is no 'About' botton.
						?>
						
						<form id="myForm" style="position: relative; top: 100px; right: 115px; width: 170px; display: block; " action="#">
							<?php
							// Changed to work with the master array -- Laerke
							// Modified to (condition) ? value1 : value2 -- Scott
							?>
							<select id='sC' style='color: white; ' onchange="countryChange('<?php echo $GetName; ?>', <?php echo $asset; ?>)">
								<?php
								foreach ($_SESSION['nav_ln_array'] as $tempArray) {
									echo "<option value='$tempArray[2]" . ($asset == 1 ? '?asset=1' : '') . '\'' . ($st == $tempArray[0] ? ' selected=\'selected\'' : '') . ">" . translate($tempArray[1], $tempArray[0], 'sys') . '</option>';
								}
								?>
							</select>
							<a href='#' id='helpMenu' style='position: relative; z-index: 5; ' onclick="helpClick()"><img src='./images/iconHelp.png' alt="help" style='margin-left: 0; margin-right: -8px; margin-bottom: -10px; ' width="32" height="32" /></a>
						</form>

						<?php
						/* -----------------------------------------------------------------------------------------
							display ☰ hamburger menu
       					----------------------------------------------------------------------------------------- */
						?>
						<input type="checkbox" id="togglerID" class="toggler" style="top: 100px; right: 149px; ">
						<div class="hamburger" style='margin-right: 68px; margin-top: -9px; z-index: 5; '>
							<div></div>
						</div>

						<!--  document.querySelectorAll('div.hamburger')[0]  get div.hamburger -->
						<div class="menu" style="position: relative; z-index: 5; ">
							<div>
								<ul id="submenu">
									<li><a href='#' onclick="window.open('<?php echo $Scriptname; ?>', '_self')"><?php echo translate('Home', $st, 'sys'); ?></a></li>
									<li><a href='#' onclick="aboutSection('H');"><?php echo translate('Help', $st, 'sys'); ?></a></li>
									<li><a id='aboutArrow' style="cursor: pointer; margin-left: -16px; " onclick="AboutOO()">▸<?php echo translate('About', $st, 'sys'); ?></a></li>
									<div id="AboutOffOn" style="display: none; text-align: left; ">
										<li style="margin-left: 84px; margin-bottom: 8px; "><a href='#' onclick="aboutSection('CR');"><?php echo translate('Copyright', $st, 'sys'); ?></a></li>
										<li style="margin-left: 84px; margin-bottom: 8px; "><a href='#' onclick="aboutSection('CU');"><?php echo translate('Content providers and partnerss', $st, 'sys'); ?></a></li>
										<li style="margin-left: 84px; margin-bottom: 8px; "><a href='#' onclick="aboutSection('TC');"><?php echo translate('Terms and Conditions', $st, 'sys'); ?></a></li>
										<li style="margin-left: 84px; margin-bottom: 8px; "><a href='#' onclick="aboutSection('P');"><?php echo translate('Privacy Policy', $st, 'sys'); ?></a></li>
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
					</div>

					<iframe id="myFrame" allowfullscreen="true" frameborder="0" marginheight="0" marginwidth="0" style="display: block; height: 100%; width: 80%; overflow:hidden; border: none; display: none; margin:0; padding:0; position: absolute; top: 200px; bottom: 0; right: 10%; left: 10%; z-index: 10; background-color: white; border: 5px solid black; box-shadow: 20px 20px 10px black, 0 0 400px black, 0 0 400px navy; " src=""></iframe>

					<br style='clear: both; padding-top: 20px; ' />

					<?php
					// top: -700 problem here 4/3/19
					$which = 'Name';
					/**************************************************************************************
							Country Table
					**************************************************************************************/
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
			/*  *******************************************************************************************************
			/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/
					"nothing" so start over
			/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/
			********************************************************************************************************  */
			else {
				?>
				<div id="background_header" style="background-image: url('../images/00<?php echo $st; ?>-ScriptureEarth_header.jpg'); "><div style="cursor: pointer; " onclick="window.open('<?php echo $Scriptname; ?>', '_self')"><img id="empty" src="./images/empty.png" /></div></div> <!-- ScriptureEarth and the Earth image -->
				<div id="background" style="background-image: url('../images/background_earth.jpg'); "></div> <!-- ScriptureEarth and the Earth image -->

				<!-- div style="position: absolute; top: 0; left: 20%; width: 35%; "> < !-- "empty" "window" over "Scripture Earth" if you click on it the script links to "00i-Scripture_Index.org" -- >
					<div style="position: relative; top: 0; left: 0; z-index: 10; cursor: pointer; " onclick="window.open('< ?php echo $Scriptname; ?>', '_self')"><img id="empty" src="./images/empty.png" /></div>
				</div -->

				<div style="position: absolute; top: -20px; right: 80px; ">
					<?php
					/* -----------------------------------------------------------------------------------------
						display 'English', 'Spanish', ... drop-down menu AND help button
       				-------------------------------------------------------------------------------------------- */
					// In the element 'form', display: block = center when there is no 'About' botton.
					?>
					<form id="myForm" style="position: relative; top: 100px; right: 115px; width: 170px; display: block; " action="#">
						<?php
						// Changed to work with the master array -- Laerke
						// Modified to (condition) ? value1 : value2 -- Scott
						?>
						<select id='navLang' onchange="menuChange()" title="<?php echo translate('Click here to choose the interface language.', $st, 'sys'); ?>">
							<?php
							foreach ($_SESSION['nav_ln_array'] as $tempArray) {
								echo "<option value='$tempArray[2]" . ($asset == 1 ? '?asset=1' : '') . '\'' . ($st == $tempArray[0] ? ' selected=\'selected\'' : '') . ">" . translate($tempArray[1], $tempArray[0], 'sys') . '</option>';
							}
							?>
						</select>
						<a href='#' id='helpMenu' style='position: relative; z-index: 5; ' onclick="helpClick();"><img src='./images/iconHelp.png' alt="help" style='margin-left: 0; margin-right: -8px; margin-bottom: -10px; ' width="32" height="32" /></a>
					</form>

					<?php
					/* -----------------------------------------------------------------------------------------
						display ☰ hamburger menu
       				-------------------------------------------------------------------------------------------- */
					?>
					<input type="checkbox" id="togglerID" class="toggler" style="top: 100px; right: 149px; ">
					<div class="hamburger" style='margin-right: 68px; margin-top: -9px; z-index: 5; '>
						<div></div>
					</div>

					<?php // document.querySelectorAll('div.hamburger')[0]  get div.hamburger ?>
					<div class="menu">
						<div>
							<ul id="submenu">
								<li><a href='#' onclick="window.open('<?php echo $Scriptname; ?>', '_self')"><?php echo translate('Home', $st, 'sys'); ?></a></li>
								<li><a href='#' onclick="aboutSection('H');"><?php echo translate('Help', $st, 'sys'); ?></a></li>
								<li><a id='aboutArrow' style="cursor: pointer; margin-left: -16px; " onclick="AboutOO()">▸<?php echo translate('About', $st, 'sys'); ?></a></li>
								<div id="AboutOffOn" style="display: none; text-align: left; ">
									<li style="margin-left: 84px; margin-bottom: 8px; "><a href='#' onclick="aboutSection('CR');"><?php echo translate('Copyright', $st, 'sys'); ?></a></li>
									<li style="margin-left: 84px; margin-bottom: 8px; "><a href='#' onclick="aboutSection('CU');"><?php echo translate('Content providers and partners', $st, 'sys'); ?></a></li>
									<li style="margin-left: 84px; margin-bottom: 8px; "><a href='#' onclick="aboutSection('TC');"><?php echo translate('Terms and Conditions', $st, 'sys'); ?></a></li>
									<li style="margin-left: 84px; margin-bottom: 8px; "><a href='#' onclick="aboutSection('P');"><?php echo translate('Privacy Policy', $st, 'sys'); ?></a></li>
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
				</div>

				<iframe id="myFrame" allowfullscreen="true" frameborder="0" marginheight="0" marginwidth="0" style="display: block; height: 100%; width: 80%; overflow:hidden; border: none; display: none; margin:0; padding:0; position: absolute; top: 200px; bottom: 0; right: 10%; left: 10%; z-index: 10; background-color: white; " src=""></iframe>

				<div class='topEnter'>
					<div class='enter'>
						<div style='border: none; padding: 0; margin-bottom: 32px; '>
							<span style='border: none; border-radius: 30px 30px 0px 0px; background-color:rgba(256,256,256,0.5); margin: 0; padding-left: 26px; padding-right: 26px; padding-top: 4px; padding-bottom: 0px; font-size: 120%; color: #AD1C2B; '><?php echo translate('Search for Scripture by:', $st, 'sys'); ?></span>
						</div>

						<?php /* -----------------------------------------------------------------------------------
								AJAX is down 2 lines here (showLanguage()).
								showLanguage(this.value) in autoLanguage.js and myFuncttranslate('Home', $st, 'sys')ion(this.value, '$st') in autoLanguage.js -->
								after 3 letter display the languages/alternate languages/ISO button
                    	-------------------------------------------------------------------------------------------- */ ?>
						<div id="showLanguageID" name="showLanguageID">
							<input type="text" id="ID" title="<?php echo translate('Find a language page: type at least 3 letters of the language name or code (ISO 639-3).', $st, 'sys'); ?>" placeholder="<?php echo translate('Language (or code)', $st, 'sys'); ?>" onfocus="submenuBlur()" onKeyUp="showLanguage(this.value, '<?php echo $st; ?>', <?php echo $Internet; ?>, '<?php echo $MajorLanguage; ?>', '<?php echo $Variant_major; ?>', '<?php echo $SpecificCountry; ?>', <?php echo $asset; ?>)" value="" />
						</div>

						<?php // display the first letter(s) of the countries button ?>
						<div id="showCountryID" name="showCountryID">
							<input type="text" id="CID" autocomplete="off" title="<?php echo translate('Find a country list: type the country name.', $st, 'sys'); ?>" placeholder="<?php echo translate('Country', $st, 'sys'); ?>" onKeyUp="showCountry(this.value, '<?php echo $st; ?>', <?php echo $Internet; ?>, '<?php echo $SpecificCountry; ?>', <?php echo $asset; ?>)" value="" />
						</div>

						<div id="listCountriesID" name="listCountriesID">
							<?php // display all of the countries button ?>
							<button title="<?php echo translate('Tap to get a list of countries available.', $st, 'sys'); ?>" id="AID" onclick="AllCountries('<?php echo $Scriptname; ?>', '<?php echo $st ?>', '<?php echo $SpecificCountry; ?>', <?php echo $Internet; ?>, <?php echo $asset; ?>)"><?php echo translate('List by Country', $st, 'sys'); ?></button>
							
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

				<?php // display copyright ?>
				<div id='copyright'>
					<div>ScriptureEarth.org</div>
				</div>

			<?php
			}
			?>
		</div>
	</div>

	<script>
		menuSet = 0;

		function menuChange(idx) {			// idx = number or 2 charcter uppercase of country
			let Scriptname = document.getElementById("navLang").value;
			if (idx === undefined) {
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
	<script type="text/javascript" language="javascript" src="_js/LangSearch.js?v=1.2.6"></script>