<!DOCTYPE html>
<html>
<head>
<title><?php echo $title_text = 'Scripture Earth: Des ressources bibliques dans des milliers de langues'; ?></title>
<meta property="og:title" 					content="Language page of Scripture Earth" />
<meta property="og:type" 					content="website" />
<meta property="og:url" 					content="https://scriptureearth.org/00fra.php" />
<meta property="og:image"			 		content="https://www.scriptureearth.org/images/SEThumbnail.jpg" />
<!--meta http-equiv="Content-Type" 			content="text/html; charset=utf-8" />
<meta name="viewport" 						content="width=device-width, initial-scale=1" /-->
<meta name="Description" 					content="
	Ce site donne accès à la Bible (Écritures de l'Ancien Testament et du Nouveau Testament) en langues vernaculaires:
	en formats texte, audio et vidéo à télécharger sur votre appareil ou à lire en ligne. Consultez les téléchargements,
	le logiciel d'étude biblique, les applications mobiles ou commandez votre copie papier.
" />
<meta name="Keywords" 						content="
	langues vernaculaires modernes, Amériques, monde, langue du coeur, langue maternelle, Bible.is, visualiseur en ligne,
    téléchargement, langues vernaculaires, texte, PDF, audio, MP3, MP4, mp4, iPod, iPhone, téléphone portable, smartphone,
    iPad , tablette, android, montre, vue, film de Jésus, Luc vidéo, acheter, impression à la demande, achat en ligne,
    librairie, étude, Word, Bible, Nouveau Testament, NT, Ancien Testament, OT, Écriture, carte, mobile app
" />
<style>
	div.fra-header {
		background-image: url('./images/00fra-BackgroundFistPage.jpg');
	}
	ul.ulFrench {
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
		div.fra-header {
			background-position: center;
			position: relative;
			top: -54px;
			background-image: url('./images/00fra-BackgroundFistPage-mobile.jpg');
		}
		ul.ulFrench {
			font-weight: normal;
			font-size: 90%;
			/*margin-left: -20px;
			margin-right: 0;*/
		}
    }
</style>
<script type="text/javascript" language="javascript">
	const MajorLang = "Fra";
	const Major_OT_array = ["Genèse", "Exode", "Lévitique", "Nombres", "Deutéronome", "Josué", "Juges", "Ruth", "1 Samuel", "2 Samuel", "1 Rois", "2 Rois", "1 Chroniques", "2 Chroniques", "Esdras", "Néhémie", "Esther", "Job", "Psaume", "Proverbes", "Ecclésiaste", "Cantique des Cantiqu", "Ésaïe", "Jérémie", "Lamentations", "Ézéchiel", "Daniel", "Osée", "Joël", "Amos", "Abdias", "Jonas", "Michée", "Nahum", "Habacuc", "Sophonie", "Aggée", "Zacharie", "Malachie"];
    const Major_NT_array = ["Matthieu", "Marc", "Luc", "Jean", "Actes", "Romains", "1 Corinthiens", "2 Corinthiens", "Galates", "Éphésiens", "Philippiens", "Colossiens", "1 Thessaloniciens", "2 Thessaloniciens", "1 Timothée", "2 Timothée", "Tite", "Philémon", "Hébreux", "Jacques", "1 Pierre", "2 Pierre", "1 Jean", "2 Jean", "3 Jean", "Jude", "Apocalypse"];
</script>
	<?php
		$st = 'fra';
		if (isset($_GET['st'])) {
			$st = $_GET['st'];
			$test = preg_match('/^[a-z]{3}/', $st);
			if ($test === 0) {
				die ("<body><br />$st " . translate('wasn’t found.', $st, 'sys') . "</body></html>");
			}
		}

		$direction = 'ltr';
		$Variant_major = 'Variant_Fre';
		$MajorLanguage = "LN_French";
		$SpecificCountry = "French";
		$counterName = "French";
		//$Scriptname = end(explode('/', $_SERVER["SCRIPT_NAME"]));
		$Scriptname = basename($_SERVER["SCRIPT_NAME"]);
		$FacebookCountry = "fr_CA";
		$MajorCountryAbbr = "fr";
		
		define ("OT_EngBook", 6);							// French Bible book names
		define ("NT_EngBook", 6);
	
		include ('./00-MainScript.inc.php');				// THE MAIN SCRIPT!!!!!
	?>
</body>
</html>