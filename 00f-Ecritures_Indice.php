<!DOCTYPE html>
<html>
<head>
<title><?php echo $title_text = 'Scripture Earth: Des ressources bibliques dans des milliers de langues'; ?></title>
<meta property="og:title" 					content="Language page of Scripture Earth" />
<meta property="og:type" 					content="website" />
<meta property="og:url" 					content="https://scriptureearth.org/00f-Ecritures_Indice.php" />
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
<style type="text/css">
    /* this version of classes are for English only! */
    div.topBannerImage {
        background-image: url(images/00i-topBanerComp.png);
        height: 136px;
        text-align: right;
    }
</style>
<?php
// Start the session
session_start();
?>
<script type="text/javascript" language="javascript">
	var MajorLang = "Fre";
</script>
	<?php
		$st = 'fre';
		if (isset($_GET['st'])) {
			$st = $_GET['st'];
			$test = preg_match('/^[a-z]{3}/', $st);
			if ($test === 0) {
				die ("<body><br />$st " . translate('wasn’t found.', $st, 'sys') . "</body></html>");
			}
		}

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