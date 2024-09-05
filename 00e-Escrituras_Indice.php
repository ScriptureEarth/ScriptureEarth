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
<style>
	div.spa-header {
		background-image: url('./images/00spa-BackgroundFistPage.jpg');
	}
	ul.ulSpanish {
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
		div.spa-header {
			background-position: center;
			position: relative;
			top: -54px;
		}
		div.spa-header {
			background-image: url('./images/00spa-BackgroundFistPage-mobile.jpg');
		}
    }
</style>
<script type="text/javascript" language="javascript">
	const MajorLang = "Span";
    const Major_OT_array = ["Génesis", "Éxodo", "Levítico", "Números", "Deuteronomio", "Josué", "Jueces", "Rut", "1 Samuel", "2 Samuel", "1 Reyes", "2 Reyes", "1 Crónicas", "2 Crónicas", "Esdras", "Nehemías", "Ester", "Job", "Salmos", "Proverbios", "Eclesiastés", "Cantares", "Isaías", "Jeremías", "Lamentaciones", "Ezequiel", "Daniel", "Oseas", "Joel", "Amós", "Abdías", "Jonás", "Miqueas", "Nahúm", "Habacuc", "Sofonías", "Hageo", "Zacarías", "Malaquías"];
    const Major_NT_array = ["Mateo", "Marcos", "Lucas", "Juan", "Hechos", "Romanos", "1 Corintios", "2 Corintios", "Gálatas", "Efesios", "Filipenses", "Colosenses", "1 Tesalonicenses", "2 Tesalonicenses", "1 Timoteo", "2 Timoteo", "Tito", "Filemón", "Hebreos", "Santiago", "1 Pedro", "2 Pedro", "1 Juan", "2 Juan", "3 Juan", "Judas", "Apocalipsis"];
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