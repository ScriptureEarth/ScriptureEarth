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
	//echo "<img src='images/00nld-ScriptureEarth_header.jpg' style='position: relative; top: 0px; z-index: 1; width: 30%; ' />";
	//echo '</div>';

	switch ($CTPHC) {
		case "CR":
	?>
			<script type="text/javascript" language="javascript">
				document.title = "Copyright pagina";
			</script>
			<h2>Copyright pagina</h2>
			<p>© <?php echo date('Y'); ?> SIL International</p>
			<p>De <em>ScriptureEarth.org</em> website wordt door SIL International beheerd. Individuele copyright- en licentie-informatie wordt op elk mediaproduct aangegeven door de organisatie die aan het product verbonden is.</p>
			<p>Het doel van deze site is om Bijbelse mediaproducten in zoveel mogelijk talen beschikbaar en toegankelijk te maken. Individuele copyright- en licentie-informatie wordt op elk mediaproduct aangegeven door de organisatie die aan het product verbonden is.</p>
			<p>De volgende mediavormen zijn op de website te vinden:
			<ul>
				<li>video</li>
				<li>audio</li>
				<li>tekst online te lezen (soms met begeleidende audio)</li>
				<li>PDFs</li>
				<li>mobiele apps</li>
				<li>links voor de aanschaf van gedrukte bijbels en andere hulpmiddelen</li>
			</ul>
			</p>
		<?php
			break;
		case "TC":
		?>
			<script type="text/javascript" language="javascript">
				document.title = "Algemene voorwaarden";
			</script>
			<h2>Algemene voorwaarden</h2>
			<p>Welkom op onze website. Als u doorgaat met browsen en deze website gebruikt, stemt u ermee in zich te houden aan en gebonden te zijn aan de volgende Algemene Voorwaarden die, samen met onze privacyverklaring SIL International’s relatie met u beheren met betrekking tot deze website.</p>
			<p>Gebruik onze website niet als u het niet eens bent met enig deel van deze algemene voorwaarden.</p>
			<p>De term 'SIL International' of 'ons' of 'wij' verwijst naar de eigenaar van de website waarvan de statutaire zetel is 7500 West Camp Wisdom Road, Dallas TX, USA</p>
			<p>De termen 'u' en 'uw' verwijzen naar de gebruiker of bezoeker van onze website.</p>
			<p>Wanneer u deze website bezoekt, gaat u akkoord met de volgende gebruiksvoorwaarden:</p>
			<ul>
				<li>De inhoud van de pagina's van deze website is alleen voor uw algemene informatie en gebruik. Het kan worden gewijzigd zonder voorafgaande kennisgeving.</li>
				<li>Noch wij, noch derden bieden enige garantie of zekerheid met betrekking tot de nauwkeurigheid, tijdigheid, prestatie, volledigheid of geschiktheid van de informatie en materialen die op deze website worden gevonden of aangeboden voor een bepaald doel. U erkent dat dergelijke informatie en materialen onnauwkeurigheden of fouten kunnen bevatten en wij sluiten uitdrukkelijk aansprakelijkheid uit voor dergelijke onnauwkeurigheden of fouten voor zover de wet dit toestaat.</li>
				<li>Uw gebruik van enige informatie of materiaal op deze website is geheel op eigen risico, waarvoor wij niet aansprakelijk zijn. Het is uw eigen verantwoordelijkheid om ervoor te zorgen dat alle producten, diensten of informatie die via deze website beschikbaar zijn, voldoen aan uw specifieke vereisten.</li>
				<li>Deze website bevat materiaal dat we mogen plaatsen. Dit materiaal omvat, maar is niet beperkt tot, het ontwerp, de lay-out, het uiterlijk, de vormgeving en de afbeeldingen. Reproductie is verboden, behalve in overeenstemming met het copyright en de licentie die op elk product zijn vermeld.</li>
				<li>Alle andere namen, logo's, product- en servicelijnen, ontwerpen en slogans op ScriptureEarth zijn de handelsmerken van hun respectievelijke eigenaren.</li>
				<li>Ongeoorloofd gebruik van deze website kan aanleiding geven tot een vordering van schadevergoeding en / of een strafbaar feit zijn.</li>
				<li>Deze website bevat links naar andere websites. Deze links zijn bedoeld voor uw gemak om meer informatie te verstrekken. Ze betekenen niet dat we de website(s) onderschrijven. Wij hebben geen verantwoordelijkheid voor de inhoud van de gelinkte website(s).</li>
			</ul>
		<?php
			break;
		case "P":
		?>
			<script type="text/javascript" language="javascript">
				document.title = "Privacy";
			</script>
			<h2>Privacy</h2>
			<p>ScriptureEarth maakt geen gebruik van "cookie-technologie”. De site verzamelt dus geen gebruikers- of gebruikspatronen.</p>
			<h3>Verzamelen en gebruiken van persoonlijke informatie</h3>
			<p>Wanneer u op deze website surft of contact opneemt met SIL International via deze site, zullen we geen persoonlijke informatie over u verzamelen, tenzij u die informatie vrijwillig verstrekt. Als u uw post- of e-mailadres opgeeft waar die optie via onze website geboden wordt, ontvangt u alleen de informatie waarvoor u het adres hebt opgegeven.</p>
			<p>Indien nodig kan persoonlijke informatie worden doorgestuurd naar de partnerorganisaties van SIL International om een antwoord te geven op uw verzoek of opmerkingen.</p>
			<p>Als u niet-openbare persoonlijke informatie (zoals een naam, adres, e-mailadres of telefoonnummer) via deze site verstrekt, zal SIL International deze informatie alleen gebruiken voor het doel vermeld op de pagina waar deze wordt verzameld.</p>
			<p>SIL International verstuurt geen ongevraagde e-mail of "spam" e-mail en verkoopt, verhuurt of verhandelt zijn e-maillijsten niet aan derden.</p>
			<p>In alle gevallen zullen we indien nodig informatie vrijgeven in overeenstemming met de toepasselijke wet- en regelgeving.</p>
			<h3>Links</h3>
			<p>ScriptureEarth bevat links naar andere websites. Deze links bieden u relevante bronnen. Een link naar een document of site impliceert niet noodzakelijk dat SIL International:</p>
			<ul>
				<li>de organisatie(s) of persoon (personen) onderschrijft</li>
				<li>de geuite ideeën ondersteunt, of</li>
				<li>instemt met de juistheid, feitelijkheid, geschiktheid of wettigheid van de inhoud</li>
			</ul>
			<p>SIL International is ook niet verantwoordelijk voor het privacybeleid of de praktijken van deze websites.</p>
		<?php
			break;
		case "H":
		?>
			<script type="text/javascript" language="javascript">
				document.title = "Help";
			</script>
			<h2>Help</h2>
			<p>
				De afbeelding hieronder legt uit hoe je via de beginpagina een specifieke taal kan vinden.
				Via de zoekvelden kan je per taal of per land zoeken.
				De optie ‘Lijst per Land’ is een snelle manier om de gewenste informatie te vinden.
			</p>
			<div style="text-align: center; margin-right: auto; margin-left: auto; margin-top: 30px; margin-bottom: 40px; ">
				<img src='./images/00nld-helpExplanation.jpg' style='height: 80%; width: 80%; ' />
			</div>
		<?php
			break;
		case "CU":
		?>
			<script type="text/javascript" language="javascript">
				document.title = "Links";
			</script>
			<!-- h2>Links</h2 -->
			<br />

			<div class='clearfix' style='margin-top: 20px; margin-bottom: 40px; margin-left: 20px; font-size: 120%; '>
				<div class='contacts'>
					<strong>Voor vragen of commentaar kunt u contact opnemen met:</strong><br />
					<img src='./images/app-icon.jpg' alt="feedback" style='margin-bottom: -6px; ' width="32" height="32" />
					<a href="mailto:info&#64;ScriptureEarth.org">info&#64;ScriptureEarth.org</a><br /><br />
					<img src="./images/sil-icon.jpg" alt="SIL International" width="32" height="32" /><strong> SIL International</strong><br />
					<a href="https://www.sil.org/">www.sil.org</a>
				</div>
			</div>

			<hr>

			<h3>Enkele van de met ons samenwerkende organisaties</h3>

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

			<h3>Bible Societies</h3>

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

			<h3>Bible League</h3>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/LaLegaBiblicaIcon.png" alt="Liga Bíblica México" height="32" /><strong>Liga Bíblica México</strong><br />
					<a href="https://www.laligabiblica.org.mx">https://www.laligabiblica.org.mx</a>
				</div>
				<div class='contacts'>
					<img src="./images/BibleLeagueUSAIcon.png" alt="Bible League (USA)" width="32" height="32" /><strong>Bible League (USA)</strong><br />
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