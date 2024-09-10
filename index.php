<?php
session_start();															// Start the session

// by Jesse Skinner modified by Scott Starker; Parse Accept-Language to detect a user's language; May 2008
// Updated by Scott Starker, Lærke Roager

session_destroy();															// destroy entire session 

$langs = [];

$asset = 0;
if (isset($_GET['asset'])) {
	$asset = $_GET['asset'];
	if (!preg_match('/^(0|1)$/', $asset)) {
		die("hack!");
	}
}

include './translate/functions.php';                           		 		// translation function

if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {								// detects a browsers abbreviated language
    // break up string into pieces (languages and q factors)
    preg_match_all('/([a-z]{1,8}(-[a-z]{1,8})?)\s*(;\s*q\s*=\s*(1|0\.[0-9]+))?/i', $_SERVER['HTTP_ACCEPT_LANGUAGE'], $lang_parse);
    if (count($lang_parse[1])) {
        $langs = array_combine($lang_parse[1], $lang_parse[4]);				// create a list like "en" => 0.8
        foreach ($langs as $lang => $val) {									// set default to 1 for any without q factor
            if ($val === '') $langs[$lang] = 1;
        }
        arsort($langs, SORT_NUMERIC);										// sort list based on value
    }
	
	$mobile = 0;															// no mobile (new user interface)

	require_once './include/conn.inc.php';									// connect to the database named 'scripture'
	$db = get_my_db();

	// master list of the naviagational languages
	if (!isset($_SESSION['nav_ln_array'])) {
		$_SESSION['nav_ln_array'] = [];
		$ln_query = "SELECT `translation_code`, `name`, `nav_fileName`, `ln_number`, `language_code`, `ln_abbreviation` FROM `translations` ORDER BY `translation_code`";
		$ln_result=$db->query($ln_query) or die ('Query failed:  ' . $db->error . '</body></html>');
		if ($ln_result->num_rows == 0) {
			die ('<div style="background-color: white; color: red; font-size: 16pt; padding-top: 20px; padding-bottom: 20px; margin-top: 200px; ">' . translate('The translation_code is not found.', $st, 'sys') . '</div></body></html>');
		}
		while ($ln_row = $ln_result->fetch_array()){
			$ln_temp[0] = $ln_row['translation_code'];						// [iso] for the navigational langauges
			$ln_temp[1] = $ln_row['name'];									// English name of the navigational langauges
			$ln_temp[2] = $ln_row['nav_fileName'];							// index PHPs
			$ln_temp[3] = $ln_row['ln_number'];								// based on the languages; 1 to 7 now; English being 1, etc.
			$ln_temp[4] = $ln_row['ln_abbreviation'];						// SE.org abbrevigations for language names; 1 to 3 letters; English being "e"; Chinese being "cmn'
			$_SESSION['nav_ln_array'][$ln_row['language_code']] = $ln_temp;
		}
	}

	$redirectTo = '';
	$ln_code = '';
	foreach($langs as $lang => $val){
		$lang_code = explode("-",$lang)[0];
		if (array_key_exists($lang_code, $_SESSION['nav_ln_array'])){
			$redirectTo = $_SESSION['nav_ln_array'][$lang_code][2];			// assigns the matching site to the language found
			$ln_code = $_SESSION['nav_ln_array'][$lang_code][0];			// assigns the language code to a variable for later use
			break;
		}
	}
	
	if ($redirectTo == '') {
		die('location is empty.');
	}
	
	if (!isset($_GET['name']) && !isset($_GET['iso'])) {
		header('Location: ' . $redirectTo . ($asset == 1 ? '?asset=1' : ''), true);							// Redirect to target
		exit;
	}
	else {
		$iso = '';
		$rod = '00000';
		$var = '';
		$iso = isset($_GET['iso']) ? $_GET['iso'] : $_GET['name'];
		if (preg_match('/^([a-z]{3})/', $iso, $match)) {
			$redirectTo .= '?iso='.$match[1] . ($asset == 1 ? '&asset=1' : '');
		}
		else {
			die('<div style="background-color: white; color: red; font-size: 16pt; padding-top: 20px; padding-bottom: 20px; margin-top: 200px; ">The ISO code is not found. (index.php)</div>');
		}
		if (isset($_GET['rod']) || isset($_GET['ROD_Code'])) {
			$rod = isset($_GET['rod']) ? $_GET['rod'] : $_GET['ROD_Code'];
			if (!preg_match('/^[0-9a-zA-Z]{1,5}$/', $rod)) {
				die('<div style="background-color: white; color: red; font-size: 16pt; padding-top: 20px; padding-bottom: 20px; margin-top: 200px; ">The ROD code is not found. (index.php)</div>');
			}
			$rod = substr($rod, 0, 5);
		}
		if (isset($_GET['var']) || isset($_GET['Variant_Code'])) {
			$var = isset($_GET['var']) ? $_GET['var'] : $_GET['Variant_Code'];
			if (!preg_match('/^[a-z]/', $var)) {
				die('<div style="background-color: white; color: red; font-size: 16pt; padding-top: 20px; padding-bottom: 20px; margin-top: 200px; ">The Variant code is not found. (index.php)</div>');
			}
			$var = substr($var, 0, 1);
		}
		$resultTest=$db->query("SELECT ISO, ROD_Code, Variant_Code, ISO_ROD_index FROM scripture_main WHERE ISO = '$iso'");
		if ($resultTest->num_rows == 1) {
			$row = $resultTest->fetch_assoc();
			$rod = $row['ROD_Code'];
			$var = $row['Variant_Code'];
			$idx = $row['ISO_ROD_index'];
			header('Location: ' . $redirectTo.'&rod='.$rod.'&var='.$var, true); // Redirect to target
			exit();
		}
		elseif ($resultTest->num_rows > 1) {									// in case someone does ?sortby=lang&name=[ZZZ] and there is more than one ROD Code
			header('Location: ' . $redirectTo. ($asset == 1 ? '?asset=1' : '' ), true);							// Redirect to target
			exit;
		}
		else {
			die('This is not suppose to happen.');			
		}
	}
}

if (isset($_GET['name']) || isset($_GET['iso'])) {								// not the 5 major languages but 'name' is used
	$redirectTo = "00spa.php";
	$temp = '';
	$temp = isset($_GET['name']) ? '?sortby=lang&name='.$_GET['name'].'&ROD_Code='.$_GET['ROD_Code'].'&Variant_Code='.$_GET['Variant_Code'] : '?iso='.$_GET['iso'].(isset($_GET['rod']) ? '&rod='.$_GET['rod'] : '&rod=').(isset($_GET['var']) ? '&var='.$_GET['var'] : '&var=');
	$redirectTo .= $temp;
	header('Location: ' . $redirectTo. ($asset == 1 ? '?asset=1' : '' ), true); // Redirect to target
	exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta property="og:url" 					content="https://scriptureearth.org/" />
<meta property="og:title" 					content="Language page of Scripture Earth" />
<meta property="og:type" 					content="website" />
<meta property="og:image"			 		content="images/SEThumbnail.jpg" />
<meta http-equiv="Content-Type" 			content="text/html; charset=utf-8" />
<meta name="robots" 						content="noindex" />
<title>Splash page of Scripture Earth</title>
<style type="text/css">
body {
	font: 100% Verdana, Arial, Helvetica, sans-serif;
	background-color: #AEB2BE;
	margin: 0; /* it's good practice to zero the margin and padding of the body element to account for differing browser defaults */
	text-align: center; /* this centers the container in IE 5* browsers. The text is then set to the left aligned default in the #container selector */
	color: #000000;
}
#all {
	margin: 0; /* it's good practice to zero the margin and padding of the body element to account for differing browser defaults */
	padding: 20px 0 0 0; /* it's good practice to zero the margin and padding of the body element to account for differing browser defaults */
	background-color: #AEB2BE;
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
a.alink {
	background-image: url(images/langNavBtn.jpg);
	background-repeat: no-repeat;
	display: block;
	padding: 4px 0px 5px 0px;
	text-align: center;
	font-size: 12pt;
	font-weight: bold;
	text-decoration: none;
	color: #080860;
}
a.eng {
	color: white;
}
/* top margin and width of middle text */
div.hover {
	float: left;
	width: 640px;
	margin-top: 45px;			/* adjust height */
}
/*div.hoverSpanish, div.hoverPortuguese, div.hoverFrench, div.hoverDutch, div.hoverGerman {
	display: none;
} /* why is this here? */
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
ul.list {
	padding-left: 230px;		/* use padding-left and width to make the words correct  */
	width: 750px;
	display: block;
	text-align: center;
	font-size: 10pt;
	font-weight: bold;
	margin: 0px;
	clear: both;
}
/*ul.ulFrench, ul.ulSpanish {
	font-size: 9pt;
	padding-top: 1px;
} /* why is this here? */
/*ul.ulSpanish, ul.ulPortuguese, ul.ulFrench, ul.ulDutch, ul.ulGerman {
	display: none;
} /* why is this here? */
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
/* remember that padding is the space inside the div box and margin is the space outside the div box */
</style>

<script type="text/javascript" language="JavaScript">
	// new generic hover and out function
	function hover() {
		document.getElementById('aclick').innerHTML = <?php translate('click to enter', $st, 'sys'); ?>;
		document.getElementById('canvas').style.display = 'none';
		ln_code = "<?php echo $ln_code?>"
		hover = document.getElementsByClassName('hover');
		for (element of hover){
			element.style.display = 'none';
		}
		hover.getElementsByClassName(ln_code)[0].style.display = 'block';

		list = document.getElementsByClassName('list');
		for (element of list){
			element.style.display = 'none';
		}
		list.getElementsByClassName(ln_code)[0].style.display = 'block';

		alink = document.getElementsByClassName('alink')
		for (element of alink){
			element.style.color = '#080860';
		}
		hover.getElementsByClassName(ln_code)[0].style.color = 'white';

		visit = document.getElementsByClassName('visit')
		for (element of visit){
			element.style.display = 'none';
		}
		visit.getElementsByClassName(ln_code)[0].style.display = 'inline';
	}

	// find the right place to connet. Is it even nessecery?
	function out(){
		hover = document.getElementsByClassName('hover');
		for (element of hover){
			element.style.display = 'none';
		}
	}

	function SILMouse() {
		window.open("https://www.sil.org");
	}

	function loadIFrame(ml, CTPHC) {
		var canvas = document.getElementById("canvas");
		canvas.style.display = 'none';
		//canvas.innerHTML = '';
		hover = document.getElementsByClassName('hover');
		for (element of hover){
			element.style.display = 'none';
		}
		canvas.setAttribute("src", "00"+ml+"-CTPHC.php?I="+CTPHC);
		canvas.style.display = 'block';
	}
</script>

<script type="text/javascript" src="_js/BrowserFixes.js"></script>
</head>
<body class="oneColFixCtr">

<?php
function Counter2() {
	$filename = "counter/AllCounter.dat";
	if (file_exists($filename)) {
		$count = file($filename);					// doesn't need fclose. reading an array.
		return $count[0];
	}
}

$Dummy_Data = [1 => "There are over 3000 indigenous languages spoken today. Many of these languages have Bible translation work in progress.<br /><br />
We dedicate this website to the glory of God and to those who have spent their lives serving these
people in the task of providing God’s Word in the language that speaks to their heart.",
2 => "Actualmente en las Américas se hablan casi 3000 idiomas indígenas. Muchos de estos idiomas ya tienen un proyecto de traducción
en progreso. Cuando las traducciones esten disponibles, esperamos que usted pueda
encontrarlos en este sitio web.<br /><br />Dedicamos este sitio a la gloria de Dios y
a los que han dado sus vidas sirviendo a los hablantes de estos idiomas al traducir
la Palabra de Dios al idioma que habla mejor a su corazón.",
3 => "Há aproximadamente 3000 línguas nativas faladas hoje nas Américass.
Muitas delas têm trabalhos de tradução da Bíblia em andamento.<br /><br />Dedicamos este site para a glória de Deus
e para aqueles que têm gasto suas vidas servindo a estes povos na tarefa de prover a Palavra de Deus nas línguas
que falam aos seus corações.",
4 => "Plus de 3000 langues autochtones vernaculaires sont parlées aujourd'hui. Beaucoup de ces langues ont un travail de traduction
de la Bible en cours.<br /><br />Nous consacrons ce site à la gloire de Dieu et à ceux qui ont passé leur vie à servir ces personnes
dans l’espoir de fournir la Parole de Dieu dans une langue qui parle à leur coeur.",
5 => "Er bestaan bijna 3000 inheemse gesproken talen in Noord-, Midden- en Zuid-Amerika.
In veel van deze talen wordt of is Bijbelvertaalwerk gedaan.<br /><br />
We dragen deze website op aan de glorie van God en aan degenen die hun leven gewijd hebben
aan de taak Gods Woord beschikbaar te maken in de taal van het hart.",
6 => "Es werden heutzutage über 3.000 indigene Sprachen gesprochen. In vielen dieser Sprachen wird die Bibel zur Zeit übersetzt.<br /><br />
Wir haben diese Webseite der Ehre Gotes gewidmet sowie denen, die ihr Leben diesen Menschen gewidmet haben,
indem sie ihnen Gottes Wort in der Sprache zugänglich gemacht haben, die ihre Herzen am besten erreicht.",
7 => "今天有2900多种土著语言。 这些语言中有许多正在进行圣经翻译工作。 我们将这个网站奉献给上帝的荣耀，并献给那些毕生为这些人服务的人们，他们的任务是用他们心中的语言来传达上帝的话语。",
8 => "오늘날 3,000개 이상의 토착 언어가 사용되고 있습니다. 이러한 언어들 중 다수는 성서 번역 작업이 진행 중입니다. 우리는 이 웹사이트를 하나님의 영광을 위해, 그리고 이들을 위해 일생을 바친 사람들에게 바칩니다 자신의 마음에 와 닿는 언어로 하나님의 말씀을 제공하는 임무를 맡은 사람들."];
?>

<div id="lblValues"></div>
<div id="all">
    <div id="container">
        <img src="images/topBannerCompSplash.jpg" style='position: relative; top: 0px; z-index: 1; width: 100%;' />
        <div style="display: inline; clear: both; margin: 0; width: 100%; ">
          <!--img src="images/shadowRt.png" width="17" height="448" style="float: right; position: relative; bottom: 138px; right: -19px; z-index: 2; border-left: solid 2px black; " /-->
          <img style="float: left; " src="images/picHome.jpg" width="152" height="223" />
          <div style="float: left; width: 155px; margin: 0; ">
          	  <div id='aclick' style='text-align: center; position: relative; top: 12px; left: 0px; width: 153px; height: 19px; font-size: 9pt; font-weight: bold; color: #B60000; '>
              	click to enter
              </div>
              <?php 
			  		foreach ($_SESSION['nav_ln_array'] as $code => $array){
						echo '<div style="margin: 13px 0px; ">
						<a id="a'.$array[1].'" class="alink '.$array[0].'" href="'.$array[2].'" onMouseOver="hover()">'.translate($array[1], $array[0], 'sys'). ($asset == 1 ? '?asset=1' : '' ).'</a>
						</div>';
					}
			  ?>
          </div>
      	  <iframe id="canvas" src='#' style="display: none; float: left; margin-top: 20px; margin-left: 35px; width: 600px; height: 350px; ">
             <ilayer id='canvas' src='#' style='display: none; float: left; margin-top: 20px; margin-left: 35px; width: 600px; height: 350px; '>
               <p>Your browser does not support iframes/ilayer.</p>
             </ilayer>
          </iframe>
          <a href="metadata/metadata.htm" style="text-decoration: none; display: none; "></a>
			<?php
				foreach ($_SESSION['nav_ln_array'] as $code => $array){
					echo '<div id="hover'.$array[1].'" class="hover '.$array[0].'">
					<div class="middleText">
						'.$Dummy_Data[$array[3]].'
					</div>
				  </div>';
				}
			?>
        </div>
      <!--div style="" id="mainContent">
      </div-->
      <!--div style="clear: left; position: relative; top: 10px; left: 15px; height: 41px; ">
        <img src="images/WycliffeCanLogo.png" width="163" height="51" />
      </div-->
      <div id="bottomBanner">
        <!--a href="https://www.wycliffe.ca" style="margin: 50px 30px 50px 30px; position: relative; right: 800px; left: 0px; top: 0px; width: 100px; height: 30px; z-index: 2; "></a-->
        <div style="cursor: pointer; display: inline; padding: 0px 0px 60px 250px; " onMouseUp="SILMouse()"></div>
        <div class='counter'>
			<?php
				echo Counter2();
			?>
			<?php
				foreach ($_SESSION['nav_ln_array'] as $code => $array){
					echo '<div class="visit '.$array[0].'" style="display: none; "> '.translate('visits', $array[0], 'sys').'</div>';
				}
			?>
        </div>
		<?php
			foreach ($_SESSION['nav_ln_array'] as $code => $array){
				echo '<ul id="ul'.$array[1].'" class="list '.$array[0].'">
				<li class="bottomBannerText"><a class="bottomBannerWord" href="#" onMouseUp="loadIFrame(\''.$array[4].'\', \'CR\')">'.translate('Copyright', $array[0], 'sys').'</a></li>
				<li class="bottomBannerText">|</li>
				<li class="bottomBannerText"><a class="bottomBannerWord" href="#" onMouseUp="loadIFrame(\''.$array[4].'\', \'TC\')">'.translate('Terms and Conditions', $array[0], 'sys').'</a></li>
				<li class="bottomBannerText">|</li>
				<li class="bottomBannerText"><a class="bottomBannerWord" href="#" onMouseUp="loadIFrame(\''.$array[4].'\', \'P\')">'.translate('Privacy', $array[0], 'sys').'</a></li>
				<li class="bottomBannerText">|</li>
				<li class="bottomBannerText"><a class="bottomBannerWord" href="#" onMouseUp="loadIFrame(\''.$array[4].'\', \'CU\')">'.translate('Contact/Links', $array[0], 'sys').'</a></li>
			</ul>';
			}
				// <li class="bottomBannerText"><a class="bottomBannerWord" href="#" onMouseUp="loadIFrame(\''.$array[4].'\', \'H\')"'.translate('Help', $array[0], 'sys').'></a></li>
				// <li class="bottomBannerText">|</li>
		?>
      </div>
    <!-- end #container -->
    </div>
</div>
</body>
</html>
