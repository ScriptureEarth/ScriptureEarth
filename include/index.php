<?php
// by Jesse Skinner modified by Scott Starker; Parse Accept-Language to detect a user's language; May 2008
$langs = array();
if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
    // break up string into pieces (languages and q factors)
    preg_match_all('/([a-z]{1,8}(-[a-z]{1,8})?)\s*(;\s*q\s*=\s*(1|0\.[0-9]+))?/i', $_SERVER['HTTP_ACCEPT_LANGUAGE'], $lang_parse);
    if (count($lang_parse[1])) {
        $langs = array_combine($lang_parse[1], $lang_parse[4]);		// create a list like "en" => 0.8
        foreach ($langs as $lang => $val) {							// set default to 1 for any without q factor
            if ($val === '') $langs[$lang] = 1;
        }
        arsort($langs, SORT_NUMERIC);								// sort list based on value
    }
	// echo ($_SERVER['HTTP_ACCEPT_LANGUAGE']."<br />");

	// http://webdesign.about.com/od/mobile/a/detect-mobile-devices.htm -- 5 methods to handle cell phone users which I chose WURFL.
	// http://wurfl.sourceforge.net/ -- "WURFL, the Wireless Universal Resource FiLe, is a Device Description Repository (DDR),
	//	i.e. a software component that maps HTTP Request headers to the profile of the HTTP client (Desktop, Mobile Device, Tablet, etc.)
	//	that issued the request."
	// Include the configuration file
	include_once './wurfl-php-1.5.0.2/WURFL/wurfl_config_standard.php';
	
	$wurflInfo = $wurflManager->getWURFLInfo();
	
	if (isset($_GET['ua']) && trim($_GET['ua'])) {
		$ua = $_GET['ua'];
		$requestingDevice = $wurflManager->getDeviceForUserAgent($_GET['ua']);
	}
	else {
		$ua = $_SERVER['HTTP_USER_AGENT'];
		// This line detects the visiting device by looking at its HTTP Request ($_SERVER)
		$requestingDevice = $wurflManager->getDeviceForHttpRequest($_SERVER);
	}
	$mobile = 0;
	if ($requestingDevice->getCapability('can_assign_phone_number') == 'true') {
		$mobile = 1;
	}

	foreach ($langs as $lang => $val) {								// look through sorted list and use first one that matches our languages
		if (strpos($lang, 'en') === 0) {
			// show English site
			$redirectTo = "00i-Scripture_Index.php";
			if ($mobile == 0) 
				$redirectTo .= "?sortby=country&name=all";
			header('Location: ' . $redirectTo, true); // Redirect to target
			exit();
		}
		else if (strpos($lang, 'es') === 0) {
			// show Spanish site
			$redirectTo = "00e-Escrituras_Indice.php";
			if ($mobile == 0) 
				$redirectTo .= "?sortby=country&name=all";
			header('Location: ' . $redirectTo, true); // Redirect to target
			exit();
		}
		else if (strpos($lang, 'pt') === 0) {
			// show Portuguese site
			$redirectTo = "00p-Escrituras_Indice.php";
			if ($mobile == 0) 
				$redirectTo .= "?sortby=country&name=all";
			header('Location: ' . $redirectTo, true); // Redirect to target
			exit();
		}
		else if (strpos($lang, 'fr') === 0) {
			// show French site
			$redirectTo = "00f-Ecritures_Indice.php";
			if ($mobile == 0) 
				$redirectTo .= "?sortby=country&name=all";
			header('Location: ' . $redirectTo, true); // Redirect to target
			exit();
		}
		else if (strpos($lang, 'nl') === 0) {
			// show Dutch site
			$redirectTo = "00d-Bijbel_Indice.php";
			if ($mobile == 0) 
				$redirectTo .= "?sortby=country&name=all";
			header('Location: ' . $redirectTo, true); // Redirect to target
			exit();
		}
	}
}
/*
else {
	echo "run Scripture index.php";
}
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Splash page of Scripture Earth</title>
<style type="text/css">
<!--
body {
	font: 100% Verdana, Arial, Helvetica, sans-serif;
	background-color: #AEB2BE;
	background-image: url(images/background.png);
	margin: 0; /* it's good practice to zero the margin and padding of the body element to account for differing browser defaults */
	text-align: center; /* this centers the container in IE 5* browsers. The text is then set to the left aligned default in the #container selector */
	color: #000000;
}
#all {
	margin: 0; /* it's good practice to zero the margin and padding of the body element to account for differing browser defaults */
	padding: 20px 0 0 0; /* it's good practice to zero the margin and padding of the body element to account for differing browser defaults */
	background-color: #AEB2BE;
	background-image: url(images/background_top.png);
	background-repeat: repeat-x;
}
.oneColFixCtr #container {
	width: 980px;  /* using 20px less than a full 800px width allows for browser chrome and avoids a horizontal scroll bar */
	background-color: #FFFFFF;
	margin: 0 auto 0 auto; /* the auto margins (in conjunction with a width) center the page */
	padding-bottom: -20px;
	text-align: left; /* this overrides the text-align: center on the body element. */
	border-top: solid 2px black;
	border-left: solid 3px black;
	border-right: solid 2px black;
}
a.aEnglish, a.aSpanish, a.aPortuguese, a.aFrench, a.aDutch {
	background-image: url(images/langNavBtn.jpg);
	background-repeat: no-repeat;
	display: block;
	padding: 4px 0px 5px 0px;
	text-align: center;
	vertical-align: middle;
	font-size: 12pt;
	font-weight: bold;
	text-decoration: none;
	color: #080860;
}
a.aEnglish {
	color: white;
}
/* top margin and width of middle text */
div.hoverEnglish, div.hoverSpanish, div.hoverPortuguese, div.hoverFrench, div.hoverDutch {
	float: left;
	width: 640px;
	margin-top: 45px;			/* adjust height */
}
div.hoverSpanish, div.hoverPortuguese, div.hoverFrench, div.hoverDutch {
	display: none;
}
/* right margin of middle text */
div.middleText {
	color: #466884;
	font-size: 11pt;
	font-weight: bold;
	margin: 0 50px 0;
	height: 225px;
}
#bottomBanner {
	width: 980px;				/* width and height of the graphic of the bottom banner */
	height: 80px;
	background-image: url(images/btmBanner.png);
	background-repeat: no-repeat;
	border-left: solid 2px black;
	/*border-bottom: solid 2px black;*/
	clear: left;
	position: relative;
	left: -2px;
	top: 0px;					/* the top position of the banner */
}
#bottomBanner ul {
	margin: 0px 0px 0px 0px;
}
ul.ulEnglish, ul.ulSpanish, ul.ulPortuguese, ul.ulFrench, ul.ulDutch {
	padding-left: 230px;		/* use padding-left and width to make the words correct  */
	width: 750px;
	display: block;
	text-align: center;
	font-size: 10pt;
	font-weight: bold;
	margin: 0px;
	clear: both;
}
ul.ulFrench, ul.ulSpanish {
	font-size: 9pt;
	padding-top: 1px;
}
ul.ulSpanish, ul.ulPortuguese, ul.ulFrench, ul.ulDutch {
	display: none;
}
li.bottomBannerText {
	vertical-align: middle;
	display: inline;
	margin: 0 5px 0 5px;
	padding: 0px 0px 0px 0px;
}
a.bottomBannerWord {
	color: #4b4b4b;
	text-decoration: none;
}
div.counter {
	color: #4b4b4b;
	float: right;
	font-size: 10pt;
	font-weight: normal;
	border: maroon 1px solid;
	background-color: #eeeeee;
	margin: 10px 10px 16px 10px;		/* Firefox: margin: 10px 10px 16px 10px; Netscape: top: -7px; IE8: top: 11px; Safari: top: 11px; Opera: top: 11px bottom: 17px -- vertical words at the bottom */
	position: relative;
	z-index: 1;
	padding: 3px 8px 3px 8px;
}
#google {
	background-color: transparent;
	float: right;
	position: relative;
	top: 0px;
	right: 10px;
	margin-bottom: -30px;
	z-index: 2;
}
/* remember that padding is the space inside the div box and margin is the space outside the div box */
-->
</style>
<script type="text/javascript">
function hoverEnglish() {
	//document.getElementById('canvas').innerHTML = '';
	document.getElementById('aclick').innerHTML = 'click to enter';
	document.getElementById('canvas').style.display = 'none';
	document.getElementById('hoverEnglish').style.display = 'block';
	document.getElementById('hoverSpanish').style.display = 'none';
	document.getElementById('hoverPortuguese').style.display = 'none';
	document.getElementById('hoverFrench').style.display = 'none';
	document.getElementById('hoverDutch').style.display = 'none';
	document.getElementById('ulEnglish').style.display = 'block';
	document.getElementById('ulSpanish').style.display = 'none';
	document.getElementById('ulPortuguese').style.display = 'none';
	document.getElementById('ulFrench').style.display = 'none';
	document.getElementById('ulDutch').style.display = 'none';
	document.getElementById('aEnglish').style.color = 'white';
	document.getElementById('aSpanish').style.color = '#080860';
	document.getElementById('aPortuguese').style.color = '#080860';
	document.getElementById('aFrench').style.color = '#080860';
	document.getElementById('aDutch').style.color = '#080860';
	document.getElementById('E').style.display = 'inline';
	document.getElementById('S').style.display = 'none';
	document.getElementById('P').style.display = 'none';
	document.getElementById('F').style.display = 'none';
	document.getElementById('D').style.display = 'none';
}
function outEnglish() {
	document.getElementById('hoverEnglish').style.display = 'none';
}
function hoverSpanish() {
	//document.getElementById('canvas').innerHTML = '';
	document.getElementById('aclick').innerHTML = 'haga clic para entrar';
	document.getElementById('canvas').style.display = 'none';
	document.getElementById('hoverEnglish').style.display = 'none';
	document.getElementById('hoverSpanish').style.display = 'block';
	document.getElementById('hoverPortuguese').style.display = 'none';
	document.getElementById('hoverFrench').style.display = 'none';
	document.getElementById('hoverDutch').style.display = 'none';
	document.getElementById('ulEnglish').style.display = 'none';
	document.getElementById('ulSpanish').style.display = 'block';
	document.getElementById('ulPortuguese').style.display = 'none';
	document.getElementById('ulFrench').style.display = 'none';
	document.getElementById('ulDutch').style.display = 'none';
	document.getElementById('aEnglish').style.color = '#080860';
	document.getElementById('aSpanish').style.color = 'white';
	document.getElementById('aPortuguese').style.color = '#080860';
	document.getElementById('aFrench').style.color = '#080860';
	document.getElementById('aDutch').style.color = '#080860';
	document.getElementById('E').style.display = 'none';
	document.getElementById('S').style.display = 'inline';
	document.getElementById('P').style.display = 'none';
	document.getElementById('F').style.display = 'none';
	document.getElementById('D').style.display = 'none';
}
function outSpanish() {
	document.getElementById('hoverSpanish').style.display = 'none';
}
function hoverPortuguese() {
	//document.getElementById('canvas').innerHTML = '';
	document.getElementById('aclick').innerHTML = 'estale para entrar';
	document.getElementById('canvas').style.display = 'none';
	document.getElementById('hoverEnglish').style.display = 'none';
	document.getElementById('hoverSpanish').style.display = 'none';
	document.getElementById('hoverPortuguese').style.display = 'block';
	document.getElementById('hoverFrench').style.display = 'none';
	document.getElementById('hoverDutch').style.display = 'none';
	document.getElementById('ulEnglish').style.display = 'none';
	document.getElementById('ulSpanish').style.display = 'none';
	document.getElementById('ulPortuguese').style.display = 'block';
	document.getElementById('ulFrench').style.display = 'none';
	document.getElementById('ulDutch').style.display = 'none';
	document.getElementById('aEnglish').style.color = '#080860';
	document.getElementById('aSpanish').style.color = '#080860';
	document.getElementById('aPortuguese').style.color = 'white';
	document.getElementById('aFrench').style.color = '#080860';
	document.getElementById('aDutch').style.color = '#080860';
	document.getElementById('E').style.display = 'none';
	document.getElementById('S').style.display = 'none';
	document.getElementById('P').style.display = 'inline';
	document.getElementById('F').style.display = 'none';
	document.getElementById('D').style.display = 'none';
}
function outPortuguese() {
	document.getElementById('hoverPortuguese').style.display = 'none';
}
function hoverFrench() {
	//document.getElementById('canvas').innerHTML = '';
	document.getElementById('aclick').innerHTML = 'cliquez pour entrer';
	document.getElementById('canvas').style.display = 'none';
	document.getElementById('hoverEnglish').style.display = 'none';
	document.getElementById('hoverSpanish').style.display = 'none';
	document.getElementById('hoverPortuguese').style.display = 'none';
	document.getElementById('hoverFrench').style.display = 'block';
	document.getElementById('hoverDutch').style.display = 'none';
	document.getElementById('ulEnglish').style.display = 'none';
	document.getElementById('ulSpanish').style.display = 'none';
	document.getElementById('ulPortuguese').style.display = 'none';
	document.getElementById('ulFrench').style.display = 'block';
	document.getElementById('ulDutch').style.display = 'none';
	document.getElementById('aEnglish').style.color = '#080860';
	document.getElementById('aSpanish').style.color = '#080860';
	document.getElementById('aPortuguese').style.color = '#080860';
	document.getElementById('aFrench').style.color = 'white';
	document.getElementById('aDutch').style.color = '#080860';
	document.getElementById('E').style.display = 'none';
	document.getElementById('S').style.display = 'none';
	document.getElementById('P').style.display = 'none';
	document.getElementById('F').style.display = 'inline';
	document.getElementById('D').style.display = 'none';
}
function outFrench() {
	document.getElementById('hoverFrench').style.display = 'none';
}
function hoverDutch() {
	//document.getElementById('canvas').innerHTML = '';
	document.getElementById('aclick').innerHTML = 'klik om binnen te gaan';
	document.getElementById('canvas').style.display = 'none';
	document.getElementById('hoverEnglish').style.display = 'none';
	document.getElementById('hoverSpanish').style.display = 'none';
	document.getElementById('hoverPortuguese').style.display = 'none';
	document.getElementById('hoverFrench').style.display = 'none';
	document.getElementById('hoverDutch').style.display = 'block';
	document.getElementById('ulEnglish').style.display = 'none';
	document.getElementById('ulSpanish').style.display = 'none';
	document.getElementById('ulPortuguese').style.display = 'none';
	document.getElementById('ulFrench').style.display = 'none';
	document.getElementById('ulDutch').style.display = 'block';
	document.getElementById('aEnglish').style.color = '#080860';
	document.getElementById('aSpanish').style.color = '#080860';
	document.getElementById('aPortuguese').style.color = '#080860';
	document.getElementById('aFrench').style.color = '#080860';
	document.getElementById('aDutch').style.color = 'white';
	document.getElementById('E').style.display = 'none';
	document.getElementById('S').style.display = 'none';
	document.getElementById('P').style.display = 'none';
	document.getElementById('F').style.display = 'none';
	document.getElementById('D').style.display = 'inline';
}
function outDutch() {
	document.getElementById('hoverDutch').style.display = 'none';
}
function WycliffeCanadaMouse() {
	window.open("https://www.wycliffe.ca");
}
</script>
<script language="JavaScript" type="text/javascript">
function loadIFrame(ml, CTPHC) {
	var canvas = document.getElementById("canvas");
	canvas.style.display = 'none';
	//canvas.innerHTML = '';
	document.getElementById('hoverEnglish').style.display = 'none';
	document.getElementById('hoverSpanish').style.display = 'none';
	document.getElementById('hoverPortuguese').style.display = 'none';
	document.getElementById('hoverFrench').style.display = 'none';
	document.getElementById('hoverDutch').style.display = 'none';
	canvas.setAttribute("src", "00"+ml+"-CTPHC.php?I="+CTPHC);
	canvas.style.display = 'block';
}
</script>
<script type="text/javascript" src="_js/BrowserFixes.js"></script>
</head>
<body class="oneColFixCtr">

<?php
function Counter() {
	$filename = "counter/AllCounter.dat";
	if (file_exists($filename)) {
		$count = file($filename);					// doesn't need fclose. reading an array.
		return $count[0];
	}
}
?>

<div id="lblValues"></div>
<div id="all">
    <div id="container">
        <!--div style='float: right; position: relative; top: 4px; right: 35px; margin-bottom: -25px; z-index: 2; font-weight: bold; '>Search Website&nbsp;&nbsp;&nbsp;&nbsp;Go</div-->
        <form action="http://www.scriptureearth.org/results.htm" id="cse-search-box">
          <div id="google">
            <input type="hidden" name="cx" value="009521864724919836289:uld5pgdocle" />
            <input type="hidden" name="cof" value="FORID:10" />
            <input type="hidden" name="ie" value="UTF-8" />
            <input type="text" name="q" size="31" />
            <input type="submit" name="sa" value="Search" />
          </div>
        </form>
        <script type="text/javascript" src="http://www.google.com/cse/brand?form=cse-search-box&lang=en"></script>
        <img src="images/topBannerCompSplash.jpg" style='position: relative; top: 0px; z-index: 1; width: 100%;' />
        <div style="display: inline; clear: both; margin: 0; width: 100%; ">
          <!--img src="images/shadowRt.png" width="17" height="448" style="float: right; position: relative; bottom: 138px; right: -19px; z-index: 2; border-left: solid 2px black; " /-->
          <img style="float: left; " src="images/picHome.jpg" width="152" height="223" />
          <div style="float: left; width: 155px; margin: 0; ">
          	  <div id='aclick' style='text-align: center; position: relative; top: 12px; left: 0px; width: 153px; height: 19px; font-size: 9pt; font-weight: bold; color: #B60000; '>
              	click to enter
              </div>
              <div style="margin: 18px 0px 13px 0px; ">
                <a id="aEnglish" class="aEnglish" href="00i-Scripture_Index.php?sortby=country&name=all" onmouseover="hoverEnglish()">English</a>
              </div>
              <div style="margin: 13px 0; ">
                <a id="aSpanish" class="aSpanish" href="00e-Escrituras_Indice.php?sortby=country&name=all" onmouseover="hoverSpanish()">Español</a>
              </div>
              <div style="margin: 13px 0; ">
                <a id="aPortuguese" class="aPortuguese" href="00p-Escrituras_Indice.php?sortby=country&name=all" onmouseover="hoverPortuguese()">Português</a>
              </div>
              <div style="margin: 13px 0; ">
                <a id="aFrench" class="aFrench" href="00f-Ecritures_Indice.php?sortby=country&name=all" onmouseover="hoverFrench()">Français</a>
              </div>
              <div style="margin: 13px 0; ">
                <a id="aDutch" class="aDutch" href="00d-Bijbel_Indice.php?sortby=country&name=all" onmouseover="hoverDutch()">Nederlands</a>
              </div>
          </div>
      	  <iframe id="canvas" src='#' style="display: none; float: left; margin-top: 20px; margin-left: 35px; width: 600px; height: 350px; ">
             <ilayer id='canvas' src='#' style='display: none; float: left; margin-top: 20px; margin-left: 35px; width: 600px; height: 350px; '>
               <p>Your browser does not support iframes/ilayer.</p>
             </ilayer>
          </iframe>
          <a href="metadata/metadata.htm" style="text-decoration: none; display: none; "></a>
          <div id="hoverEnglish" class="hoverEnglish">
            <div class="middleText">
                There are nearly 600 indigenous languages spoken today throughout the Americas, represented by over
                140 language families. Many of these languages have Bible translation work in progress.<br /><br />
                We dedicate this site to the glory of God and to those who have spent their lives serving these
                people in the task of providing God’s Word in the language that speaks to their heart.
            </div>
          </div>
          <div id="hoverSpanish" class="hoverSpanish">
            <div class="middleText">
				Actualmente en las Américas se hablan casi 600 idiomas indígenas, representados por más de
                140 familias de lenguas. Muchos de estos idiomas ya tienen un proyecto de traducción
                en progreso. Cuando las traducciones esten disponibles, esperamos que usted pueda
                encontrarlos en este sitio web.<br /><br />Dedicamos este sitio a la gloria de Dios y
                a los que han dado sus vidas sirviendo a los hablantes de estos idiomas al traducir
                la Palabra de Dios al idioma que habla mejor a su corazón.
          	</div>
          </div>
          <div id="hoverPortuguese" class="hoverPortuguese">
            <div class="middleText">
                Há aproximadamente 600 línguas nativas faladas hoje nas Américas, representadas por mais de 140 famílias de línguas.
                Muitas delas têm trabalhos de tradução da Bíblia em andamento.<br /><br />Dedicamos este site para a glória de Deus
                e para aqueles que têm gasto suas vidas servindo a estes povos na tarefa de prover a Palavra de Deus nas línguas
                que falam aos seus corações.
             </div>
          </div>
          <div id="hoverFrench" class="hoverFrench">
            <div class="middleText">
				De nos jours, près de 600 langues indigènes sont parlées en Amérique. Elles appartiennent à plus de 140 familles de langues.
                Une traduction de la Bible est en cours dans un grand nombre d’entre elles.<br /><br />
				Ce site est dédié à la gloire de Dieu et à ceux qui consacrent leur vie à apporter la Parole de Dieu dans la langue qui parle
                le plus au cœur de ces personnes.
            </div>
          </div>
          <div id="hoverDutch" class="hoverDutch">
            <div class="middleText">
                Er bestaan bijna 600 inheemse gesproken talen in Noord-, Midden- en Zuid-Amerika die 140
                taalfamilies vertegenwoordigen. In veel van deze talen wordt of is Bijbelvertaalwerk gedaan.<br /><br />
                We dragen deze website op aan de glorie van God en aan degenen die hun leven gewijd hebben
                aan de taak Gods Woord beschikbaar te maken in de taal van het hart.
            </div>
          </div>
        </div>
      <!--div style="" id="mainContent">
      </div-->
      <!--div style="clear: left; position: relative; top: 10px; left: 15px; height: 41px; ">
        <img src="images/WycliffeCanLogo.png" width="163" height="51" />
      </div-->
      <div id="bottomBanner">
        <!--a href="https://www.wycliffe.ca" style="margin: 50px 30px 50px 30px; position: relative; right: 800px; left: 0px; top: 0px; width: 100px; height: 30px; z-index: 2; "></a-->
        <div style="cursor: pointer; display: inline; padding: 0px 0px 60px 250px; " onmouseup="WycliffeCanadaMouse()"></div>
        <div class='counter'>
			<?php
				echo Counter();
			?>
			<div id="E" style="display: inline; "> visits</div>
			<div id="S" style="display: none; "> visitas</div>
			<div id="P" style="display: none; "> visitas</div>
			<div id="F" style="display: none; "> visites</div>
			<div id="D" style="display: none; "> bezoeken</div>
        </div>
        <ul id="ulEnglish" class="ulEnglish">
            <li class="bottomBannerText"><a class="bottomBannerWord" href="#" onmouseup="loadIFrame('i', 'CR')">Copyright</a></li>
            <li class="bottomBannerText">|</li>
            <li class="bottomBannerText"><a class="bottomBannerWord" href="#" onmouseup="loadIFrame('i', 'TC')">Terms and Conditions</a></li>
            <li class="bottomBannerText">|</li>
            <li class="bottomBannerText"><a class="bottomBannerWord" href="#" onmouseup="loadIFrame('i', 'P')">Privacy</a></li>
            <li class="bottomBannerText">|</li>
            <li class="bottomBannerText"><a class="bottomBannerWord" href="#" onmouseup="loadIFrame('i', 'H')">Help</a></li>
            <li class="bottomBannerText">|</li>
            <li class="bottomBannerText"><a class="bottomBannerWord" href="#" onmouseup="loadIFrame('i', 'CU')">Contacts/Links</a></li>
        </ul>
        <ul id="ulSpanish" class="ulSpanish">
            <li class="bottomBannerText"><a class="bottomBannerWord" href="#" onmouseup="loadIFrame('e', 'CR')">Propiedad intelectual</a></li>
            <li class="bottomBannerText">|</li>
            <li class="bottomBannerText"><a class="bottomBannerWord" href="#" onmouseup="loadIFrame('i', 'TC')">Condiciones de utilización</a></li>
            <li class="bottomBannerText">|</li>
            <li class="bottomBannerText"><a class="bottomBannerWord" href="#" onmouseup="loadIFrame('i', 'P')">Privacidad</a></li>
            <li class="bottomBannerText">|</li>
            <li class="bottomBannerText"><a class="bottomBannerWord" href="#" onmouseup="loadIFrame('e', 'H')">Ayuda</a></li>
            <li class="bottomBannerText">|</li>
            <li class="bottomBannerText"><a class="bottomBannerWord" href="#" onmouseup="loadIFrame('i', 'CU')">Contactos/Enlaces</a></li>
        </ul>
        <ul id="ulPortuguese" class="ulPortuguese">
            <li class="bottomBannerText"><a class="bottomBannerWord" href="#" onmouseup="loadIFrame('p', 'CR')">Copirraite</a></li>
            <li class="bottomBannerText">|</li>
            <li class="bottomBannerText"><a class="bottomBannerWord" href="#" onmouseup="loadIFrame('i', 'TC')">Termos e circunstâncias</a></li>
            <li class="bottomBannerText">|</li>
            <li class="bottomBannerText"><a class="bottomBannerWord" href="#" onmouseup="loadIFrame('i', 'P')">Privacidade</a></li>
            <li class="bottomBannerText">|</li>
            <li class="bottomBannerText"><a class="bottomBannerWord" href="#" onmouseup="loadIFrame('i', 'H')">Ajuda</a></li>
            <li class="bottomBannerText">|</li>
            <li class="bottomBannerText"><a class="bottomBannerWord" href="#" onmouseup="loadIFrame('i', 'CU')">Contato-nos</a></li>
        </ul>
        <ul id="ulFrench" class="ulFrench">
            <li class="bottomBannerText"><a class="bottomBannerWord" href="#" onmouseup="loadIFrame('f', 'CR')">Droits d'auteur</a></li>
            <li class="bottomBannerText">|</li>
            <li class="bottomBannerText"><a class="bottomBannerWord" href="#" onmouseup="loadIFrame('i', 'TC')">Conditions d'utilisation</a></li>
            <li class="bottomBannerText">|</li>
            <li class="bottomBannerText"><a class="bottomBannerWord" href="#" onmouseup="loadIFrame('i', 'P')">Confidentialité de l'information</a></li>
            <li class="bottomBannerText">|</li>
            <li class="bottomBannerText"><a class="bottomBannerWord" href="#" onmouseup="loadIFrame('i', 'H')">Aide</a></li>
            <li class="bottomBannerText">|</li>
            <li class="bottomBannerText"><a class="bottomBannerWord" href="#" onmouseup="loadIFrame('i', 'CU')">Nous contacter</a></li>
        </ul>
        <ul id="ulDutch" class="ulDutch">
            <li class="bottomBannerText"><a class="bottomBannerWord" href="#" onmouseup="loadIFrame('d', 'CR')">Auteursrecht</a></li>
            <li class="bottomBannerText">|</li>
            <li class="bottomBannerText"><a class="bottomBannerWord" href="#" onmouseup="loadIFrame('i', 'TC')">Voorwaarden</a></li>
            <li class="bottomBannerText">|</li>
            <li class="bottomBannerText"><a class="bottomBannerWord" href="#" onmouseup="loadIFrame('i', 'P')">Privacy</a></li>
            <li class="bottomBannerText">|</li>
            <li class="bottomBannerText"><a class="bottomBannerWord" href="#" onmouseup="loadIFrame('i', 'H')">Hulp</a></li>
            <li class="bottomBannerText">|</li>
            <li class="bottomBannerText"><a class="bottomBannerWord" href="#" onmouseup="loadIFrame('i', 'CU')">Neem contact op</a></li>
        </ul>
      </div>
    <!-- end #container -->
    </div>
</div>
</body>
</html>
