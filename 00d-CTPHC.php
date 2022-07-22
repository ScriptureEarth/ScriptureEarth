<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" 						content="width=device-width, initial-scale=1, maximum-scale=1" />
<title></title>
<style type="text/css">
@media only screen and (max-width: 480px) {							/* (max-width: 412px) for Samsung S8+ 2/20/2019 */
	div.contacts {
		float: none;
		width: 100%;
	}
}

@media only screen and (min-width: 481px) {
	div.contacts {
		float: left;
		width: 46%;
	}
}

* {
  box-sizing: border-box;
}
body {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 1em;
}
td p {margin: 20px 0 0 0; }
tr {
	vertical-align: top;
}
h2 {
	margin-bottom: 0px;
}
li {
	margin-top: 2px;
	margin-bottom: 2px;
}
div.contacts {
	margin-left: 5px;
	margin-right: 5px;
	margin-top: 10px;
	margin-bottom: 14px;
}
div.clearfix::after {
  content: "";
  clear: both;
  display: table;
}
#all {
	margin: 0; /* it's good practice to zero the margin and padding of the body element to account for differing browser defaults */
	padding: 20px 0 0 0; /* it's good practice to zero the margin and padding of the body element to account for differing browser defaults */
	background-color: white;
}
div.container {
	width: 90%;  /* using 20px less than a full 800px width allows for browser chrome and avoids a horizontal scroll bar */
	background-color: white;
	margin: 0 auto 0 auto; /* the auto margins (in conjunction with a width) center the page */
	padding-bottom: -20px;
	text-align: left; /* this overrides the text-align: center on the body element. */
}
</style>
<script type="text/javascript" language="javascript" src="_js/jquery-1.3.2.js"></script>
</head>
<body>
<?php
	if (!isset($_GET["I"])) {
		die ("'Item' is not found.</body></html>");
	}
	$CTPHC = $_GET["I"];

	if (isset($_GET["Window"])) {
		$Window = $_GET["Window"];
		if ($Window != "Window") {
			die ("'Window' is not valid.</body></html>");
		}
		echo "<style type='text/css'>
			body {
				font: 100% Verdana, Arial, Helvetica, sans-serif;
				background-color: white;
				margin: 0;				/* it's good practice to zero the margin and padding of the body element to account for differing browser defaults */
				text-align: center;		/* this centers the container in IE 5* browsers. The text is then set to the left aligned default in the #container selector */
			}
			h2, h3, p, ul, li {
				margin: 20px;
			}
			h2 {
				color: darkred;
			}
			h3 {
				
			}
		</style>";
		echo '<div style="width: 100%; background-color: black; ">';
			echo "<img src='images/00dut-ScriptureEarth_header.jpg' style='position: relative; top: 0px; z-index: 1; width: 30%; ' />";
		echo '</div>';
		echo "<div id='all'>";
			echo "<div class='container'>";
	}

	switch ($CTPHC) {
		case "CR":
?>
<script type="text/javascript" language="javascript">
	document.title = "Copyright pagina";
</script>
<h2>Copyright pagina</h2>
<p>© <?php echo date('Y'); ?> SIL International</p>
<p>De <em>ScriptureEarth.org</em> website wordt door SIL International beheerd. Individuele copyright- en licentie-informatie wordt op elk mediaproduct aangegeven door de organisatie die aan het product verbonden is.</p>
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
			break;
		case "CU":
?>
<script type="text/javascript" language="javascript">
	document.title = "Contact/Links";
</script>
<h2 style='margin-left: 0; '>Contact/Links</h2>
<div style='margin-top: 30px; margin-bottom: 40px; margin-left: 5px; font-size: 120%; '>
	<div>
      <strong><span id="docs-internal-guid-9a8db584-7fff-df01-2632-4cfe182522fc"><img src="https://lh3.googleusercontent.com/FX0TXNvzTLQ4ZZ5r8fQM24RFe_aghVg1EvAUvKA6Y-GHYu2W_PoGENclOwVMRyaRutJW2jdiQfxcOhK2mAEEI1X2O4zKlvETN5fVjEtjCEI0QB_BJyNenxPdneuWnvciopicVmCw" alt="" width="32" height="32" /></span> SIL International</strong><br />
		<a href="https://www.sil.org/">www.sil.org</a><br />
		Voor vragen of commentaar kunt u contact opnemen met:<br />
    	<a href="mailto:info&#64;ScriptureEarth.org">info&#64;ScriptureEarth.org</a>
    </div>
</div>

<hr>

<h3 style='margin-top: 30px; margin-left: 0; '>Enkele van de met ons samenwerkende organisaties</h3>

<div class='clearfix'>
    <div class='contacts'>
      <strong><span id="docs-internal-guid-1eee7ee4-7fff-d9b2-ce8d-1d6b590c9115"><img src="https://lh3.googleusercontent.com/IU4KXtCaasavRkLvdD9U8B1t7cQhu5rBPUwGOl478-pgTqWyxHD3OK0n7_YyUHVKaG9t3ETWnWXE_H2t7028NhtPJ5eYWVwcmfj4h-WfKMv3wjkUpSyHNc1kQaUVQZwjE5jEkKyn" alt="" width="32" height="32" /></span>Faith Comes By Hearing / Hosanna</strong><br />
        <a href="https://www.faithcomesbyhearing.com/">https://www.faithcomesbyhearing.com</a>
    </div>
    <div class='contacts'>
      <strong><span id="docs-internal-guid-da3c2eb4-7fff-ee17-5652-ddf27c457dc2"><img src="https://lh4.googleusercontent.com/1x5jphztN6V7Nr_lgsDR__X-bZ5z685pwhr0y_1yqAn_T4Xv9bOLxpGQti7tueeU8_lRthECNH-f_5KHIcwUsWWJ8iaJXHPOIwqtpOo7YK8y0-VE0QU5bpMozOKWyAq2AnrbLQL0" alt="" width="32" height="32" /></span> Jesus Film Media</strong><br />
        <a href="https://jesusfilmmedia.org/">https://jesusfilmmedia.org</a>
    </div>
</div>

<div class='clearfix'>
    <div class='contacts'>
      <strong><span id="docs-internal-guid-3e3aa6cf-7fff-1458-1921-36a139b0cd16"><img src="https://lh4.googleusercontent.com/ndDblEivE6ozAW6FSijVOPVwdkqbKKNA8W2nvqmfNjOJq1JDI_DFCvjijy6wPd_2bBtKKoFOONKWYMbKp80f-VmAAIU3yZy-avTTehy6O3lUPeDakcEvYGwfjrbManZSXvj9BLz4" alt="" width="16" height="16" /></span> Global Recordings Network</strong><br />
		<a href="https://globalrecordings.net/en">https://globalrecordings.net/en</a>
    </div>
    <div class='contacts'>
      <strong><span id="docs-internal-guid-7d9f3e48-7fff-454a-d8af-7ded1fe47bd2"><img src="https://lh4.googleusercontent.com/4yfU8AzOJIBRMgiDDsM2QsvB4z8HTLRqvX6vLJxNA0ridGfSKL-06MHGzOe-UsApHwCMEfkXNaqSmzF9TrFr0lmGtnLvK5G5pGa1dqPUeNTmckoncJN_oc-OqlCf6-Ud0PgTXPmN" alt="" width="32" height="32" /></span> YouVersion</strong><br />
        <a href="https://www.youversion.com/">https://www.youversion.com/</a>
	</div>
</div>

<div class='clearfix'>
    <div class='contacts'>
      <strong><span id="docs-internal-guid-7922d555-7fff-39c8-4ea2-8ae65903b68d"><img src="https://lh5.googleusercontent.com/8hDCv_re5i2j6Y-E3uItGwbt8fEPdZVltJZ3CaFXd5Y2oF3lXwLjC_dNPpy3-e7VwCD0TCR4nRIQzLEOrFigguYb7nC9wt-DYfrw6Uiu1nZfcUTdk44wv9R8e5hOJMSb8tvT-SKf" alt="" width="16" height="16" /></span>Biblica</strong><br />
		<a href="https://www.biblica.com/">https://www.biblica.com/</a>
    </div>
    <div class='contacts'>
      <strong><img src="./images/Find.Bible.jpg" alt="Find a Bible" width="30" height="30" /> Find a Bible</strong><br />
        <a href="https://find.bible/">https://find.bible/</a>
	</div>
</div>

<p>Wycliffe</p>

<div class='clearfix'>
    <div class='contacts'>
      <strong><span id="docs-internal-guid-ca50ed15-7fff-576a-858b-33abaef797ad"><img src="https://lh5.googleusercontent.com/dJeED-jZKLjNC5hlGuHGZrYflhLF-gO51BpeV664YT32QYxtYovr-ceCc7P6KNGZdjglEz6eD4D1PmoDTPcR1HzxkGgIXzfSCAf84bNXBi1boEo4ordozz_Hmwv5uWIO7mMyLW2U" alt="" width="32" height="32" /></span> Wycliffe Global Alliance</strong><br />
		<a href="https://www.wycliffe.net">https://www.wycliffe.net</a>
    </div>
    <div class='contacts'>
        <strong>&nbsp;</strong><br />
        &nbsp;
	</div>
</div>

<div class='clearfix'>
    <div class='contacts'>
      <strong><span id="docs-internal-guid-37c8976d-7fff-2043-c44b-c9417f1511de"><img src="https://lh4.googleusercontent.com/qSUDwTM4rWxSFbXzhUj4_JtCtS_5Qv0MNXn9xpBrUBcSM2z4q3ZJ1KYNSTJ6BQn7uMopfxY8hWgh1JY9OQOZlc85WFB01JNU14Lkp0nylsXJXBK_Ks-0cPo4b5jPtzS1bTfBpOgG" alt="" width="32" height="32" /></span> Wycliffe USA</strong><br />
		<a href="https://www.wycliffe.org/">https://www.wycliffe.org/</a>
    </div>
    <div class='contacts'>
      <strong><span id="docs-internal-guid-1aa02fc3-7fff-1f9a-838e-cea0711ce942"><img src="https://lh6.googleusercontent.com/rb8KYiNpurOliu5g5MOg3Pu21GrIMy2LeLJByPV4idEhBmJ2r79L9_5y3XgMyA_2umXVBIXRMbHYBrBbqdi6SxFFX3eZ0L6S_A6ojWB-LNqEK4mG_rHBZqo6XPoZq11Yir8ihBrg" alt="" width="32" height="32" /></span> Wycliffe UK</strong><br />
        <a href="https://www.wycliffe.org.uk/">https://www.wycliffe.org.uk/</a>
    </div>
</div>

<div class='clearfix'>
    <div class='contacts'>
      <strong><span id="docs-internal-guid-3d21aaa5-7fff-fc79-b949-ac65bcbb5759"><img src="https://lh6.googleusercontent.com/P-Ygrtq0d4is2FSzSxzhiLo3mgd3T9EbLViUVPC7pRBlCA308HLUIDGCgWfT5mNERST2gmwzGxW19dtqqOB9iDMNekQm6MtRVTLWrb5K3ilzI2GLRGgEd7_AmMxatRODOHkAhzSu" alt="" width="32" height="32" /></span>Wycliffe Canada</strong><br />
        <a href="https://www.wycliffe.ca">https://www.wycliffe.ca</a>
    </div>
	<div class='contacts'>
      <strong><span id="docs-internal-guid-c57c6850-7fff-f1e7-7c27-8d9f2730b882"><img src="https://lh4.googleusercontent.com/YpAcZXVJesIGXgtlUW46nKjmikue66X3mauioNX_TYVmIEE8AROvobwaqOVo8c1tph0xlxWnpsE8N_S5t2W0rxd7y4h1x1hJC8gMHwF8Lij1tgfx3NjGWkkb8TjjeLmjm-mhLpL6" alt="" width="32" height="32" /></span> Wycliffe Australia</strong><br />
        <a href="https://wycliffe.org.au">https://wycliffe.org.au</a>
	</div>
</div>

<p>Bible Societies</p>

<div class='clearfix'>
    <div class='contacts'>
      <strong><span id="docs-internal-guid-bffa80f7-7fff-d907-a6e0-610efc657b62"><img src="https://lh5.googleusercontent.com/DsS__7UVIGJO6cIb8omTlM_UuZ87opWpWgUvofk33YCPFWOBAq4bHN4N-eLAee1Uyl2eBDr_J1Z49OqY4G_HUDBOfmLWudlfqG0xBdpHmwXDRK9dLnVP-MyprV0q2iQmqhtcNwGA" alt="" width="16" height="16" /></span> American Bible Society</strong><br />
        <a href="https://www.americanbible.org/">https://www.americanbible.org</a>
    </div>
    <div class='contacts'>
      <strong><span id="docs-internal-guid-ef0d4bc8-7fff-b9b3-16d1-0d1e4e838a36"><img src="https://lh3.googleusercontent.com/85PmYxqksM0C8XtbN2k4M5GJxZRmje1fZY34dJ6KaccC7E-JkHnEHQqsFn5l-_dse8KJBJkKQIa0E8OC_RTd8X4VJAYJJgD34fF23hIAqdbZTdMQHyAW6xoUWvEuPVxbd2unEKI7" alt="" width="32" height="31" /></span> Canadian Bible Society</strong><br />
        <a href="https://www.biblesociety.ca/">https://www.biblesociety.ca</a>
    </div>
</div>

<div class='clearfix'>
    <div class='contacts'>
      <strong><span id="docs-internal-guid-edfea179-7fff-bd30-ad32-788f4f517f5f"><img src="https://lh3.googleusercontent.com/lCR5veYj-iNSurfS_LLlABpFeNh6LdKL6cC9C51mb7F64P-yBoFDe8puJTqA2fBLNYTZpy8xXEfVPmJuqVTHYyxYXYgln8q9-YrywNbHSiYLYBAGK080O7Uocxcs5mOP7xd7GLCW" alt="" width="32" height="32" /></span>Bible Society of Brazil</strong><br />
        <a href="https://sbb.org.br/">https://sbb.org.br/</a>
    </div>
    <div class='contacts'>
        <strong>&nbsp;</strong><br />
        &nbsp;
	</div>
</div>

<p>Bible League</p>

<div class='clearfix'>
    <div class='contacts'>
        <strong>Liga Bíblica México</strong><br />
        <a href="https://www.laligabiblica.org.mx">https://www.laligabiblica.org.mx</a>
    </div>
    <div class='contacts'>
      <strong><span id="docs-internal-guid-1897ed0f-7fff-ac69-c003-1e4b7e173e6e"><img src="https://lh5.googleusercontent.com/BNpZGBWoDZzlPXBN02U7h9xIH_MwZBQxy9WuydrfEt6l7xlYyIzzI359hcV6EQqmeZKiFmPcV4gPSFJUAaUscJyto9P6-AOaueP8oBrI44pfQx7d-uxS0UkJf2mYGvxldpQ7yyAJ" alt="" width="32" height="32" /></span>Bible League (USA)</strong><br />
        <a href="https://www.bibleleague.org/">https://www.bibleleague.org</a>
    </div>
</div>

<br />
<?php
			break;
		default: 				// CR, TC, P, H and CU
			die ("The 'item' is not found.</body></html>");
	}
	
	if (isset($Window) && $Window == "Window") {
		echo "</div>";
		echo "</div>";
	}
?>
</body>
</html>
