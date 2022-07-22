<!DOCTYPE html>
<html>
<head>
<title><?php echo $title_text = 'Scripture Earth: Hilfen zum Bibelstudium in tausenden von Sprachen'; ?></title>
<meta property="og:title" 					content="Language page of Scripture Earth" />
<meta property="og:type" 					content="website" />
<meta property="og:url" 					content="https://scriptureearth.org/00de-Sprachindex.php" />
<meta property="og:image"			 		content="https://www.scriptureearth.org/images/SEThumbnail.jpg" />
<!--meta http-equiv="Content-Type" 			content="text/html; charset=utf-8" />
<meta name="viewport" 						content="width=device-width, initial-scale=1" /-->
<meta name="Description" lang="de"			content="
	Diese Webseite macht die Bibel (die Heilige Schrift des Alten und Neuen Testaments) in indigenen Sprachen zugänglich:
	im Text-, Audio- und Videoformat, zum Herunterladen oder zum Lesen online. Laden Sie Schriften herunter,
    benutzen Sie die Software zum Bibelstudium oder die mobilen Apps, oder bestellen sie gedruckte Bibeln oder Bibelteile.
" />
<meta name="Keywords" lang="de"				content="
    modern indigenous languages, Americas, world, heart language, Bible.is, online viewer,
    native languages, text, PDF, audio, MP3, mp3, MP4, mp4, iPod, iPhone, cell phone, smartphone, iPad, tablet, android,
    watch, Jesus Film, Luke video, buy, print-on-demand, online purchase, bookstore, study, The Word,
    Bible, New Testament, NT, Old Testament, OT, Scripture, map
" />
<style type="text/css">
	/* this version of classes are for German only! */
	div.ZtopBannerImage {
		background-image: url(images/00i-topBanerComp.png);
		height: 136px;
		text-align: right;
	}
</style>
<script type="text/javascript" language="javascript">
	var MajorLang = "Deu";
</script>
	<?php
	$st = 'deu';
	if (isset($_GET['st'])) {
		$st = $_GET['st'];
		$test = preg_match('/^[a-z]{3}/', $st);
		if ($test === 0) {
			die ("<body><br />$st wasn’t found.</body></html>");
		}
	}
	
	$Variant_major = 'Variant_Deu';
	$SpecificCountry = 'German';
	$counterName = "German";
	$MajorLanguage = "LN_German";
	$Scriptname = basename($_SERVER["SCRIPT_NAME"]);
	$FacebookCountry = "de_DE";
	$MajorCountryAbbr = "de";
	
	define ("OT_EngBook", 8);							// German Bible book names
	define ("NT_EngBook", 8);
	
	include ('./00-MainScript.inc.php');				// THE MAIN SCRIPT!!!!!
	?>

</body>
</html>