<?php
/* variables of 00zzz-CTPHC.php:
		'I': 'CR', 'TC', 'P', 'H', and 'CU': section to be display
	   $st variables:
		eng, deu, cmn, nld, spa, fra, por
	*/
?>
<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<title></title>
	<style type="text/css">
		div.contacts {
			float: left;
			width: 46%;
		}

		* {
			box-sizing: border-box;
		}

		body {
			/*font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;*/
			font-family: Chivo, 'Gill Sans', Tahoma, Geneva, Verdana, sans-serif;
			font-size: 120%;
			background-color: white;
			margin: 0;
			padding: 0;
		}

		h3,
		p,
		ul,
		li {
			margin: 20px 40px;
		}

		li {
			margin-top: 6px;
			margin-bottom: 6px;
		}

		h2 {
			color: #980000;
			font-size: 17pt;
			margin: 20px 40px;
		}

		h3 {
			color: #980000;
			font-size: 13pt;
			margin-top: 40px;
			font-size: 110%;
		}

		td p {
			margin: 20px 0 0 0;
		}

		tr {
			vertical-align: top;
		}

		div.contacts {
			margin-left: 40px;
			margin-right: 5px;
			margin-top: 10px;
			margin-bottom: 14px;
		}

		div.clearfix::after {
			content: "";
			clear: both;
			display: table;
		}
	</style>
	<!--script type="text/javascript" language="javascript" src="_js/jquery-1.3.2.js"></script-->
</head>

<body>
	<?php
	if (!isset($_GET["I"])) {
		die("'Item' is not found.</body></html>");
	}
	$CTPHC = $_GET["I"];

	//echo '<div style="width: 100%; background-color: black; ">';
	//echo "<img src='images/00deu-ScriptureEarth_header.jpg' style='position: relative; top: 0px; z-index: 1; width: 30%; ' />";
	//echo '</div>';

	switch ($CTPHC) {
		case "CR":
	?>
			<script type="text/javascript" language="javascript">
				document.title = "Copyright";
			</script>
			<h2>Copyright</h2>
			<p>© <?php echo date('Y'); ?> SIL International</p>
			<p>Die <em>ScriptureEarth.org</em> Website wird von SIL International betrieben. Produktspezifische Copyright- und Lizenzinformationen werden von jeder beitragenden Organisation auf dem betreffenden Produkt angegeben.</p>
			<p>Der Zweck dieser Website ist es, den Zugang zu Schrift Produkten zu verschaffen Sprachen der Welt. Individuelle Copyright- und Lizenzinformationen werden auf jedem Produkt von der beitragenden Organisation angegeben.</p>
			<p>Einige der Medienformate auf der Website umfassen:
			<ul>
				<li>video</li>
				<li>audio-Text</li>
				<li>online zu lesen (manchmal mit Follow-along Audio)</li>
				<li>PDFs</li>
				<li>mobile Anwendungen</li>
				<li>links zu Kauf gedruckten Bibeln und andere Ressourcen</li>
			</ul>
			</p>
		<?php
			break;
		case "TC":
		?>
			<script type="text/javascript" language="javascript">
				document.title = "Geschäftsbedingungen";
			</script>
			<h2>Geschäftsbedingungen</h2>
			<p>Willkommen auf unserer Webseite! Wenn Sie diese Internetseite besuchen und nutzen, erklären Sie sich damit einverstanden, die folgenden Nutzungsbedingungen einzuhalten und an diese gebunden zu sein. Die Nutzungsbedingungen regeln, zusammen mit unserer Datenschutzrichtlinie, die Beziehung zwischen SIL International und Ihnen in Bezug auf diese Webseite. Wenn Sie mit einem Teil dieser Allgemeinen Geschäftsbedingungen nicht einverstanden sind, verwenden Sie unsere Webseite bitte nicht.</p>
			<p>Der Begriff "SIL International" oder "wir" oder "uns" bezieht sich auf den Inhaber der Webseite mit Sitz in 7500 West Camp Wisdom Road, Dallas, TX.</p>
			<p>Die Begriffe "Sie" und "Ihr" beziehen sich auf den Benutzer oder Betrachter unserer Webseite.</p>
			<p>Wenn Sie diese Internetseite nutzen, stimmen Sie den folgenden Nutzungsbedingungen zu:</p>
			<ul>
				<li>Der Inhalt dieser Internetseite dient ausschließlich Ihrer allgemeinen Information und Verwendung. Änderungen des Inhalts sind vorbehalten.</li>
				<li>Weder wir, noch Dritte, geben eine Garantie oder Gewährleistung für die Richtigkeit, Aktualität, Funktion, Vollständigkeit oder Eignung der auf dieser Webseite gefundenen oder angebotenen Informationen und Materialien für einen bestimmten Zweck. Sie erkennen an, dass die Informationen und Materialien Ungenauigkeiten oder Fehler enthalten können, und wir schließen ausdrücklich die Haftung für solche Ungenauigkeiten oder Fehler aus, soweit dies gesetzlich zulässig ist.</li>
				<li>Die Verwendung von Informationen oder Materialien auf dieser Webseite erfolgt auf eigenes Risiko, für das wir keine Haftung übernehmen. Es liegt in Ihrer eigenen Verantwortung, sicherzustellen, dass alle auf dieser Webseite verfügbaren Produkte, Dienstleistungen oder Informationen Ihren spezifischen Anforderungen entsprechen.</li>
				<li>Diese Webseite enthält Material, zu dessen Veröffentlichung wir berechtigt sind. Dieses Material umfasst unter anderem Design, Layout, Aussehen, Erscheinungsbild und Grafiken. Die Vervielfältigung ist nur gemäß den für jedes Produkt angegebenen Urheberrechten und Lizenzen gestattet.</li>
				<li>Alle anderen Namen, Logos, Produkt- und Servicenamen, Designs und Slogans auf ScriptureEarth sind Marken ihrer jeweiligen Eigentümer.</li>
				<li>Die unbefugte Nutzung dieser Webseite kann zu Schadensersatzansprüchen führen und / oder eine Straftat darstellen.</li>
				<li>Diese Webseite enthält Links zu anderen Internetseiten. Diese Links dienen Ihrem Interesse und stellen zusätzliche Informationen bereit. Die Links bedeuten nicht, dass wir die verlinkte(n) Webseite(n) unterstützen. Wir übernehmen keine Verantwortung für den Inhalt der verlinkten Webseiten.</li>
			</ul>
		<?php
			break;
		case "P":
		?>
			<script type="text/javascript" language="javascript">
				document.title = "Datenschutz";
			</script>
			<h2>Datenschutz</h2>
			<p>ScriptureEarth verwendet keine "cookie" -Technologie. Die Website verfolgt daher keine Benutzerdaten oder Nutzungsmuster.</p>
			<h3>Sammeln und Verwenden persönlicher Informationen</h3>
			<p>Wenn Sie diese Website besuchen oder SIL International über diese Website kontaktieren, werden wir keine persönlichen Informationen über Sie sammeln, es sei denn, Sie geben diese Informationen freiwillig an. Wenn Sie Ihre Post- oder E-Mail-Adresse über unsere Feedback-Mechanismen angeben, erhalten Sie nur die Informationen, für die Sie die Adresse angegeben haben.</p>
			<p>Bei Bedarf können personenbezogene Daten an die Partnerorganisationen von SIL International weitergeleitet werden, um auf Ihre Anfrage oder Kommentare zu antworten.</p>
			<p>Wenn Sie über diese Website nicht öffentliche, personenbezogene Daten (wie Name, Adresse, E-Mail-Adresse oder Telefonnummer) angeben, verwendet SIL International diese Daten nur für den auf der Seite, auf der sie erfasst werden, angegebenen Zweck.</p>
			<p>SIL International sendet keine unerwünschten oder "Spam" -E-Mails und verkauft, vermietet oder vertreibt seine E-Mail-Listen nicht an Dritte.</p>
			<p>In jedem Fall werden wir Informationen offenlegen, die den geltenden Gesetzen und Vorschriften entsprechen.</p>
			<h3>Links</h3>
			<p>ScriptureEarth enthält Links zu anderen Websites. Diese Websites stellen Ihnen relevante Ressourcen zur Verfügung. Ein Link zu einem Dokument oder einer Website bedeutet nicht unbedingt, dass SIL International:</p>
			<ul>
				<li>die Organisation (en) oder Person (en) unterstützt, die sie bereitstellt</li>
				<li>den geäußerten Ideen zustimmt oder</li>
				<li>die Korrektheit, Wahrheit, Angemessenheit oder Legalität dieser Inhalte bestätigt</li>
			</ul>
			<p>SIL International ist auch nicht verantwortlich für die Datenschutzrichtlinien oder -praktiken dieser Websites.</p>
		<?php
			break;
		case "H":
		?>
			<script type="text/javascript" language="javascript">
				document.title = "Hilfe";
			</script>
			<h2>Hilfe</h2>
			<p>
				Die untenstehende Grafik zeigt, wie Sie die Startseite verwenden können, um eine bestimmte Sprache zu finden.
				Immer wenn der Benutzer eines der Suchfelder eingibt oder \"Liste nach Land\" auswählt,
				erscheint eine oder mehrere Auswahlmöglichkeiten. Das gewünschte Element kann aus der Liste ausgewählt werden.
			</p>
			<div style="text-align: center; margin-right: auto; margin-left: auto; margin-top: 30px; margin-bottom: 40px; ">
				<img src='./images/00de-AboutExplanation.jpg' style='height: 80%; width: 80%; ' />
			</div>
		<?php
			break;
		case "CU":
		?>
			<script type="text/javascript" language="javascript">
				document.title = "Links";
			</script>
			<!--h2>Links</h2-->
			<br />

			<div class='clearfix' style='margin-top: 20px; margin-bottom: 40px; margin-left: 20px; font-size: 120%; '>
				<div class='contacts'>
					<strong>Kontakt für Fragen und Feedback:</strong><br />
					<img src='images/app-icon.jpg' alt="feedback" style='margin-bottom: -6px; ' width="32" height="32" />
					<a href="mailto:info&#64;ScriptureEarth.org">info&#64;ScriptureEarth.org</a><br /><br />
					<img src="./images/sil-icon.jpg" alt="SIL International" width="32" height="32" /><strong> SIL International</strong><br />
					<a href="https://www.sil.org/">www.sil.org</a>
				</div>
			</div>

			<hr>

			<h3>Einige unserer mitarbeitenden Partner</h3>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/FaithComesByHearingIcon.png" alt="Faith Comes By Hearing / Hosanna" width="32" /><strong>Faith Comes By Hearing / Hosanna</strong><br />
					<a href="https://www.faithcomesbyhearing.com/">https://www.faithcomesbyhearing.com</a>
				</div>
				<div class='contacts'>
					<img src="./images/JesusFilmMediaIcon.png" alt="Jesus Film Media" width="32" height="32" /><strong> Jesus Film Media</strong><br />
					<a href="https://jesusfilmmedia.org/">https://jesusfilmmedia.org</a>
				</div>
			</div>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/eBible_icon.png" alt="eBible" width="30" height="30" /><strong> eBible</strong><br />
					<a href='https://ebible.org/'>https://ebible.org/</a><br />
				</div>
				<div class='contacts'>
					<img src="./images/YouVersionIcon.png" alt="YouVersion" width="32" height="32" /><strong> YouVersion</strong><br />
					<a href="https://www.youversion.com/">https://www.youversion.com/</a>
				</div>
			</div>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/BiblicaIcon.png" alt="Biblica" width="30" /><strong> Biblica</strong><br />
					<a href="https://www.biblica.com/">https://www.biblica.com/</a>
				</div>
				<div class='contacts'>
					<img src="./images/Find.Bible.jpg" alt="Find a Bible" width="30" height="30" /><strong> Find a Bible</strong><br />
					<a href="https://find.bible/">https://find.bible/</a>
				</div>
			</div>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/VinaIcon.png" alt="Viña Studios" width="30" height="30" /><strong> Viña Studios</strong><br />
					<a href='https://www.vinyastudios.org/en'>https://www.vinyastudios.org/en/</a><br />
					<a href='https://deditos.org/'>https://deditos.org/</a>
				</div>
				<div class='contacts'>
					<img src="./images/GlobalRecordingsNetworkIcon.png" alt="Global Recordings Network" width="20" /><strong> Global Recordings Network</strong><br />
					<a href="https://globalrecordings.net/en">https://globalrecordings.net/en</a>
				</div>
			</div>

			<h3>Wycliffe</h3>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/WycliffeGlobalAllianceIcon.png" alt="Wycliffe Global Alliance" width="32" height="32" /><strong> Wycliffe Global Alliance</strong><br />
					<a href="https://www.wycliffe.net">https://www.wycliffe.net</a>
				</div>
			</div>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/WycliffeUSAIcon.png" alt="Wycliffe USA" width="50" /><strong> Wycliffe USA</strong><br />
					<a href="https://www.wycliffe.org/">https://www.wycliffe.org/</a>
				</div>
				<div class='contacts'>
					<br />
					<img src="./images/WycliffeUKIcon.png" alt="Wycliffe UK" width="30" /><strong> Wycliffe UK</strong><br />
					<a href="https://www.wycliffe.org.uk/">https://www.wycliffe.org.uk/</a>
				</div>
			</div>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/WycliffeCanadaIcon.png" alt="Wycliffe Canada" width="32" height="32" /><strong>Wycliffe Canada</strong><br />
					<a href="https://www.wycliffe.ca">https://www.wycliffe.ca</a>
				</div>
				<div class='contacts'>
					<img src="./images/WycliffeAustraliaIcon.png" alt="Wycliffe Australia" width="32" height="32" /><strong> Wycliffe Australia</strong><br />
					<a href="https://wycliffe.org.au">https://wycliffe.org.au</a>
				</div>
			</div>

			<h3>Bibelgesellschaften</h3>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/AmericanBibleSocietyIcon.png" alt="American Bible Society" width="32" /><strong> American Bible Society</strong><br />
					<a href="https://www.americanbible.org/">https://www.americanbible.org</a>
				</div>
				<div class='contacts'>
					<img src="./images/CanadianBibleSocietyIcon.png" alt="Canadian Bible Society" width="32" height="31" /><strong> Canadian Bible Society</strong><br />
					<a href="https://www.biblesociety.ca/">https://www.biblesociety.ca</a>
				</div>
			</div>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/BibleSocietyOfBrazilIcon.png" alt="Bible Society of Brazil" width="32" height="32" /><strong> Bible Society of Brazil</strong><br />
					<a href="https://sbb.org.br/">https://sbb.org.br/</a>
				</div>
			</div>

			<h3>Liga Bibel</h3>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/LaLegaBiblicaIcon.png" alt="Liga Bíblica México" height="32" /><strong>Liga Bíblica México</strong><br />
					<a href="https://www.laligabiblica.org.mx">https://www.laligabiblica.org.mx</a>
				</div>
				<div class='contacts'>
					<img src="./images/BibleLeagueUSAIcon.png" alt="Liga Bibel (USA)" width="32" height="32" /><strong>Liga Bibel (USA)</strong><br />
					<a href="https://www.bibleleague.org/">https://www.bibleleague.org</a>
				</div>
			</div>

			<h3>Other Websites</h3>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/MegaVoive_icon.png" alt="MegaVoice" height="32" /><strong> MegaVoice</strong><br />
					<a href="https://megavoice.com/">https://megavoice.com/</a>
				</div>
			</div>

			<br />
		<?php
			break;
		default: 				// CR, TC, P, H and CU
			die("The 'item' is not found.</body></html>");
	}
	?>
</body>

</html>