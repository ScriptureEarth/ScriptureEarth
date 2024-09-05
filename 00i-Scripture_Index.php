<!DOCTYPE html>
<html>
<head>
<title><?php echo $title_text = 'Scripture Earth: Scripture Resources in Thousands of Languages'; ?></title>
<meta property="og:title" 					content="Language page of Scripture Earth" />
<meta property="og:type" 					content="website" />
<meta property="og:url" 					content="https://scriptureearth.org/00i-Scripture_Index.php" />
<meta property="og:image"			 		content="https://www.scriptureearth.org/images/SEThumbnail.jpg" />
<!--meta http-equiv="Content-Type" 			content="text/html; charset=utf-8" />
<meta name="viewport" 						content="width=device-width, initial-scale=1" /-->
<meta name="Description" lang="en-US"		content="
    This site provides access to the Bible (Scriptures in Old Testament and New Testament) in indigenous languages: text,
    audio, and video formats to download to your device or read online. Check out the downloads, Bible study software,
    mobile apps, or order your hard copy.
" />
<meta name="Keywords" lang="en-US"			content="
    modern indigenous languages, Americas, world, heart language, mother tongue, Bible.is, online viewer, download,
    native languages, text, PDF, audio, MP3, mp3, MP4, mp4, iPod, iPhone, cell phone, smartphone, iPad, tablet, android,
    watch, view, Jesus Film, Luke video, buy, print-on-demand, online purchase, bookstore, study, The Word,
    Bible, New Testament, NT, Old Testament, OT, Scripture, map, mobile app
" />
<style>
	div.eng-header {
		background-image: url('./images/00eng-BackgroundFistPage.jpg');
	}
	ul.ulEnglish {
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
		div.eng-header {
			background-position: center;
			position: relative;
			top: -54px;
		}
		div.eng-header {
			background-image: url('./images/00eng-BackgroundFistPage-mobile.jpg');
			/* This ensures your background image is center-positioned vertically and horizontally 
			background-position: center;*/
			/* This ensures your background image doesn’t tile */
			/*background-repeat: no-repeat;*/
			/* This makes your background image responsive and rescale according to the viewport or container size 
			background-size: cover;
			position: relative;
			top: -54px;*/
		}
    }
</style>
<script type="text/javascript" language="javascript">
	const MajorLang = "Eng";
	const Major_OT_array = ["Genesis", "Exodus", "Leviticus", "Numbers", "Deuteronomy", "Joshua", "Judges", "Ruth", "1 Samuel", "2 Samuel", "1 Kings", "2 Kings", "1 Chronicles", "2 Chronicles", "Ezra", "Nehemiah", "Esther", "Job", "Psalms", "Proverbs", "Ecclesiastes", "Song of Solomon", "Isaiah", "Jeremiah", "Lamentations", "Ezekiel", "Daniel", "Hosea", "Joel", "Amos", "Obadiah", "Jonah", "Micah", "Nahum", "Habukkuk", "Zephaniah", "Haggai", "Zechariah", "Malachi"];
    const Major_NT_array = ["Matthew", "Mark", "Luke", "John", "Acts", "Romans", "1 Corinthians", "2 Corinthians", "Galatians", "Ephesians", "Philippians", "Colossians", "1 Thessalonians", "2 Thessalonians", "1 Timothy", "2 Timothy", "Titus", "Philemon", "Hebrews", "James", "1 Peter", "2 Peter", "1 John", "2 John", "3 John", "Jude", "Revelation"];
</script>
	<?php
	$st = 'eng';
	if (isset($_GET['st'])) {
		$st = $_GET['st'];
		$test = preg_match('/^[a-z]{3}/', $st);
		if ($test === 0) {
			die ("<body><br />$st wasn’t found.</body></html>");
		}
	}
	
	$Variant_major = 'Variant_Eng';
	$SpecificCountry = 'English';
	$counterName = 'English';
	$MajorLanguage = 'LN_English';
	//$Scriptname = '00i-Scripture_Index.php';
	//$Scriptname = end(explode('/', $_SERVER["SCRIPT_NAME"]));
	$Scriptname = basename($_SERVER["SCRIPT_NAME"]);
	// to change language button go to https://developers.facebook.com/docs/plugins/like-button or http://www.visualmagnetic.com/html/fb-like-83-languages/#notes
	$FacebookCountry = 'en_US';
	$MajorCountryAbbr = 'en';
	
	define ('OT_EngBook', 2);							// English Bible book names
	define ('NT_EngBook', 2);
	
	include ('./00-MainScript.inc.php');				// THE MAIN SCRIPT!!!!!
	?>
</body>
</html>
