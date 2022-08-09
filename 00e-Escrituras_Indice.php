<!DOCTYPE html>
<html>
<head>
<title><?php echo $title_text = 'Scripture Earth: Recursos de las Escrituras en miles de lenguas'; ?></title>
<meta property="og:title" 					content="Language page of Scripture Earth" />
<meta property="og:type" 					content="website" />
<meta property="og:url" 					content="https://scriptureearth.org/00e-Escrituras_Indice.php" />
<meta property="og:image"			 		content="https://www.scriptureearth.org/images/SEThumbnail.jpg" />
<!--meta http-equiv="Content-Type" 			content="text/html; charset=utf-8" />
<meta name="viewport" 						content="width=device-width, initial-scale=1" /-->
<meta name="Description" lang="es-MX"		content="
    Este sitio proporciona acceso a la Biblia (Escritura en el Antiguo Testamento y
    el Nuevo Testamento) ver en el texto (PDF), audio (MP3), (la película Jesús, etc),
    comprar (impresión bajo demanda), estudio (The Word), otros libros y enlaces
    en las lenguas indígenas de las Américas.
" />
<meta name="Keywords" lang="es-MX"			content="
    languas indígenas moderna, Américas, lengua materna, lenguas nativas, texto, PDF, audio, MP3,
    ver, la película Jesús, comprar, impresión bajo demanda, de compra en línea, una librería,
    el estudio, The Word, la Biblia, Nuevo Testamento, NT, Antiguo Testamento, OT,
    lenguas autóctonas
" />
<style type="text/css">
    /* this version of classes are for English only! */
    div.topBannerImage {
        background-image: url(images/00i-topBanerComp.png);
        height: 136px;
        text-align: right;
    }
</style>
<script type="text/javascript" language="javascript">
	var MajorLang = "Span";
</script>
	<?php
		$st = 'spa';
		if (isset($_GET['st'])) {
			$st = $_GET['st'];
			$test = preg_match('/^[a-z]{3}/', $st);
			if ($test === 0) {
				die ("<body><br />$st " . translate('wasn’t found.', $st, 'sys') . "</body></html>");
			}
		}

		$Variant_major = 'Variant_Spa';
		$MajorLanguage = "LN_Spanish";
		$SpecificCountry = "Spanish";
		$counterName = "Spanish";
		//$Scriptname = end(explode('/',$_SERVER['SCRIPT_NAME']));
		$Scriptname = basename($_SERVER["SCRIPT_NAME"]);
		$FacebookCountry = "es_LA";
		$MajorCountryAbbr = "es";
		
		define ("OT_EngBook", 3);							// Spanish Bible book names
		define ("NT_EngBook", 3);
		
		include ('./00-MainScript.inc.php');				// THE MAIN SCRIPT!!!!!
	?>

</body>
</html>