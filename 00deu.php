<!DOCTYPE html>
<html>
<head>
<title><?php echo $title_text = 'Scripture Earth: Hilfen zum Bibelstudium in tausenden von Sprachen'; ?></title>
<meta property="og:title" 					content="Language page of Scripture Earth" />
<meta property="og:type" 					content="website" />
<meta property="og:url" 					content="https://scriptureearth.org/00deu.php" />
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
<style>
	div.deu-header {
		/* German */
		background-image: url('./images/00deu-BackgroundFistPage.jpg');
	}
	ul.ulGerman {
		/*padding-left: 230px;*/
		/* use padding-left and width to make the words correct position */
		/*display: block;
		display: inline;*/
		text-align: center;
		font-size: .86em;
		font-weight: bold;
		/*margin-top: -180px;*/
		/*clear: both;*/
		margin-left: -40px;
	}
	@media only screen and (max-width: 480px) {
		/* (max-width: 412px) for Samsung S8+ 2/20/2019 */
		div.deu-header {
			background-position: center;
			position: relative;
			top: -54px;
			background-image: url('./images/00deu-BackgroundFistPage-mobile.jpg');
		}
		ul.ulGerman {
			font-weight: normal;
			font-size: 90%;
			/*margin-left: -20px;
			margin-right: 0;*/
		}
    }
</style>
<script type="text/javascript" language="javascript">
	const MajorLang = "Deu";
	const Major_OT_array = ["Genesis", "Exodus", "Levitikus", "Numeri", "Deuteronomium", "Josua", "Richter", "Rut", "1 Samuel", "2 Samuel", "1 Könige", "2 Könige", "1 Chronik", "2 Chronik", "Esra", "Nehemia", "Ester", "Ijob", "Psalmen", "Sprichwörter", "Prediger", "Lied Salomos", "Jesaja", "Jeremia", "Klagelieder", "Ezechiel", "Daniel", "Hosea", "Joël", "Amos", "Obadja", "Jona", "Micha", "Nahum", "Habakuk", "Zefanja", "Haggai", "Sacharja", "Maleachi"];
    const Major_NT_array = ["Matthäus", "Markus", "Lukas", "Johannes", "Apostelgeschichte", "Römer", "1 Korinther", "2 Korinther", "Galater", "Epheser", "Philipper", "Kolosser", "1 Thessalonicher", "2 Thessalonicher", "1 Timotheus", "2 Timotheus", "Titus", "Philemon", "Hebräer", "Jakobus", "1 Petrus", "2 Petrus", "1 Johannes", "2 Johannes", "3 Johannes", "Judas", "Offenbarung des Johannes"];
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
	
	$direction = 'ltr';
	$Variant_major = 'Variant_Ger';
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