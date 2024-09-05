<!DOCTYPE html>
<html>
<head>
<title><?php echo $title_text = 'Scripture Earth: Las Escrituras índice'; ?></title>
<meta property="og:title" 					content="Language page of Scripture Earth" />
<meta property="og:type" 					content="website" />
<meta property="og:url" 					content="https://scriptureearth.org/00p-Escrituras_Indice.php" />
<meta property="og:image"			 		content="https://www.scriptureearth.org/images/SEThumbnail.jpg" />
<!--meta http-equiv="Content-Type" 			content="text/html; charset=utf-8" />
<meta name="viewport" 						content="width=device-width, initial-scale=1" /-->
<meta name="Description" 					content="
    Este site fornece acesso à Bíblia (Escrituras no Antigo Testamento e Novo Testamento)
    relógio em texto (PDF), áudio (MP3), (o filme Jesus, etc), comprar (print-on-demand),
    estudo (The Word), outros livros e links nas línguas indígenas das Américas.
" />
<meta name="Keywords" 						content="
    languagess indígenas modernas, das Américas, a linguagem do coração, as línguas nativas,
    texto, PDF, áudio, relógio, MP3, filme Jesus, comprar, print-on-demand, compras on-line,
    livraria, estudar, The Word, a Bíblia, no Novo Testamento, NT, Antigo Testamento, OT
" />
<style>
	div.por-header {
		background-image: url('./images/00por-BackgroundFistPage.jpg');
	}
	ul.ulPortuguese {
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
		div.por-header {
			background-position: center;
			position: relative;
			top: -54px;
		}
		div.por-header {
			background-image: url('./images/00por-BackgroundFistPage-mobile.jpg');
		}
    }
</style>
<script type="text/javascript" language="javascript">
	const MajorLang = "Port";
	const Major_OT_array = ["Gênesis", "Êxodo", "Levítico", "Números", "Deuteronômio", "Josué", "Juízes", "Rute", "1 Samuel", "2 Samuel", "1 Reis", "2 Reis", "1 Crônicas", "2 Crônicas", "Ezdras", "Neemias", "Esther", "Jó", "Salmos", "Provérbios", "Eclesiastes", "Cantares de Salomão", "Isaías", "Jeremias", "Lamentações", "Ezequiel", "Daniel", "Oséias", "Joel", "Amós", "Obadias", "Jonas", "Miquéias", "Naum", "Habacuque", "Sofonias", "Ageu", "Zacarias", "Malaquias"];
    const Major_NT_array = ["Mateus", "Marcos", "Lucas", "João", "Atos", "Romanos", "1 Coríntios", "2 Coríntios", "Gálatas", "Efésios", "Filipenses", "Colossenses", "1 Tessalonicenses", "2 Tessalonicenses", "1 Timóteo", "2 Timóteo", "Tito", "Filemón", "Hebreus", "Tiago", "1 Pedro", "2 Pedro", "1 João", "2 João", "3 João", "Judas", "Apocalipse"];
</script>
	<?php
		$st = 'por';
		if (isset($_GET['st'])) {
			$st = $_GET['st'];
			$test = preg_match('/^[a-z]{3}/', $st);
			if ($test === 0) {
				die ("<body><br />$st " . translate('wasn’t found.', $st, 'sys') . "</body></html>");
			}
		}

		$Variant_major = 'Variant_Por';
		$MajorLanguage = "LN_Portuguese";
		$SpecificCountry = "Portuguese";
		$counterName = "Portuguese";
		//$Scriptname = end(explode('/', $_SERVER["SCRIPT_NAME"]));
		$Scriptname = basename($_SERVER["SCRIPT_NAME"]);
		$FacebookCountry = "pt_BR";
		$MajorCountryAbbr = "pt";
		
		define ("OT_EngBook", 4);							// Portuguese Bible book names
		define ("NT_EngBook", 4);
	
		include './00-MainScript.inc.php';					// THE MAIN SCRIPT!!!!!
	?>

</body>
</html>