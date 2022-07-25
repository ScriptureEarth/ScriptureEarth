<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" 				content="text/html; charset=utf-8" />
<meta name="viewport" 							content="width=device-width, initial-scale=1, maximum-scale=1" />
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
	font-size: 120%;
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
			echo "<img src='images/00fra-ScriptureEarth_header.jpg' style='position: relative; top: 0px; z-index: 1; width: 30%; ' />";
		echo '</div>';
		echo "<div id='all'>";
			echo "<div class='container'>";
	}

	switch ($CTPHC) {
		case "CR":
?>
<script type="text/javascript" language="javascript">
	document.title = "Copyright";
</script>
<h2>Copyright</h2>
<p>© <?php echo date('Y'); ?> SIL International</p>
<p>Le site Web <em>ScriptureEarth.org</em> est géré par SIL International. Les informations individuelles sur les droits d'auteur et les licences sont indiquées sur chaque produit par l'organisation qui y contribue.</p>
<?php
			break;
		case "TC":
?>
<script type="text/javascript" language="javascript">
	document.title = "Termes et conditions";
</script>
<h2>Termes et conditions</h2>
<p>Bienvenue sur notre site Web. Si vous continuez à naviguer et à utiliser ce site Web, vous acceptez de respecter et d'être lié par les conditions d'utilisation suivantes qui, avec notre politique de confidentialité, régissent la relation de SIL International avec vous en ce qui concerne ce site Web. Si vous n'êtes pas d'accord avec une partie de ces termes et conditions, veuillez ne pas utiliser notre site Web.</p>
<p>Le terme « SIL International » ou « nous » fait référence au propriétaire du site Web dont le siège social est situé à 7500 West Camp Wisdom Road, Dallas TX, USA.</p>
<p>Les termes « vous » et « votre » désignent l'utilisateur ou le visiteur de notre site Web.</p>
<p>Lorsque vous utilisez ce site Web, vous acceptez les conditions d'utilisation suivantes :</p>
<ul>
<li>Le contenu des pages de ce site Web est destiné à votre information générale et à votre utilisation uniquement. Il est susceptible d'être modifié sans préavis.</li>
<li>Ni nous ni aucun tiers ne fournissons de garantie quant à l'exactitude, l'actualité, la performance, l'exhaustivité ou l'adéquation des informations et des matériaux trouvés ou offerts sur ce site Web pour un usage particulier. Vous reconnaissez que ces informations et matériels peuvent contenir des inexactitudes ou des erreurs et nous excluons expressément toute responsabilité pour de telles inexactitudes ou erreurs dans toute la mesure permise par la loi.</li>
<li>Votre utilisation de toute information ou matériel sur ce site Web est entièrement à vos propres risques, pour lesquels nous ne serons pas responsables. Il vous incombe de vous assurer que les produits, services ou informations disponibles sur ce site répondent à vos exigences spécifiques.</li>
<li>Ce site Web contient du matériel que nous sommes autorisés à publier. Ce matériel comprend, sans s'y limiter, la conception, la mise en page, l'aspect, l'apparence et les graphiques. La reproduction est interdite, sauf en conformité avec les droits d'auteur et les licences indiquées sur chaque produit.</li>
<li>Tous les autres noms, logos, noms de produits et services, dessins et slogans sur ScriptureEarth sont les marques de leurs propriétaires respectifs.</li>
<li>L'utilisation non autorisée de ce site Web peut donner lieu à une réclamation en dommages et intérêts et / ou constituer une infraction pénale.</li>
<li>Ce site Web comprend des liens vers d'autres sites Web. Ces liens sont fournis pour votre commodité afin de fournir des informations supplémentaires. Ils ne signifient pas que nous approuvons le(s) site(s) Web. Nous n'avons aucune responsabilité quant au contenu du ou des sites Web liés.</li>
</ul>
<?php
			break;
		case "P":
?>
<script type="text/javascript" language="javascript">
	document.title = "Confidentialité";
</script>
<h2>Confidentialité</h2>
<p>ScriptureEarth n'utilise pas la technologie des « cookies ». Le site ne suit donc pas les utilisateurs ou leurs habitudes d'utilisation.</p>
<h2>Collecte et utilisation des informations personnelles</h2>
<p>Lorsque vous naviguez sur ce site Web ou que vous contactez SIL International par le biais de ce site, nous ne recueillons pas d'informations personnelles vous concernant, sauf si vous les fournissez volontairement. Si vous fournissez votre adresse postale ou électronique par le biais de nos mécanismes de retour d'information, vous recevrez uniquement les informations pour lesquelles vous avez fourni l'adresse.</p>
<p>Si nécessaire, les informations personnelles peuvent être transmises aux organisations partenaires de SIL International afin de fournir une réponse à votre demande ou à vos commentaires.</p>
<p>Si vous fournissez des informations personnelles non publiques (telles qu'un nom, une adresse, une adresse électronique ou un numéro de téléphone) via ce site, SIL International n'utilisera ces informations que dans le but indiqué sur la page où elles sont collectées.</p>
<p>SIL International n'envoie pas d'e-mails non sollicités ou de «spam» et ne vend pas, ne loue ni n'échange ses listes de diffusion à des tiers.</p>
<p>Dans tous les cas, nous divulguerons des informations conformément aux lois et réglementations en vigueur si nécessaire.</p>
<h2>Liens</h2>
<p>ScriptureEarth contient des liens vers d'autres sites Web. Ces liens vous permettent d'accéder à des ressources pertinentes. Un lien vers un document ou un site n'implique pas forcément que SIL International :</p>
<ul type="disc">
 <li>approuve l'organisation ou les personnes qui les fournissent,</li>
 <li>est d’accord avec les idées exprimées, ou</li>
 <li>atteste de l'exactitude, des faits, de la pertinence ou de la légalité de leur contenu.</li>
</ul>
<p>SIL International n'est pas non plus responsable des politiques ou pratiques de confidentialité de ces sites Web.</p>
<?php
			break;
		case "H":
?>
<script type="text/javascript" language="javascript">
	document.title = "Help";
</script>
<h2>Aide</h2>
<p style="margin-bottom: -15px; "><strong>Navigateurs préférés :</strong>
</p><ul type="disc">
  <li>Firefox</li>
	<li>Chrome</li>
	<li>Opéra</li>
	<li>Internet Explorer</li>
</ul>
<p style="margin-bottom: -15px; "><strong>Navigateurs avec des problèmes potentiels pour ce site :</strong></p>
<ul type="disc">
  <li>Safari (Certaines fonctions nécessitent que les fenêtres contextuelles soient autorisées.)</li>
</ul>
<?php
			break;
		case "CU":
?>
<script type="text/javascript" language="javascript">
	document.title = "Contacter/Liens";
</script>
<h2 style='margin-left: 0; '>Contacter/Liens</h2>
<div style='margin-top: 30px; margin-bottom: 40px; margin-left: 5px; font-size: 120%; '>
	<div>
      <strong><span id="docs-internal-guid-9a8db584-7fff-df01-2632-4cfe182522fc"><img src="https://lh3.googleusercontent.com/FX0TXNvzTLQ4ZZ5r8fQM24RFe_aghVg1EvAUvKA6Y-GHYu2W_PoGENclOwVMRyaRutJW2jdiQfxcOhK2mAEEI1X2O4zKlvETN5fVjEtjCEI0QB_BJyNenxPdneuWnvciopicVmCw" alt="" width="32" height="32" /></span> SIL International</strong><br />
		<a href="https://www.sil.org/">www.sil.org</a><br />
		Vous souhaitez donner votre avis ou vous avez une demande.<br />Afin de répondre à mieux à votre demande, nous vous invitons à contacter ScriptureEarth :<br />
    	<a href="mailto:info&#64;ScriptureEarth.org">info&#64;ScriptureEarth.org</a>
    </div>
</div>

<hr>

<h3 style='margin-top: 30px; margin-left: 0; '>Certains de nos collaborateurs</h3>

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

<p>Sociétés bibliques</p>

<div class='clearfix'>
    <div class='contacts'>
      <strong><span id="docs-internal-guid-bffa80f7-7fff-d907-a6e0-610efc657b62"><img src="https://lh5.googleusercontent.com/DsS__7UVIGJO6cIb8omTlM_UuZ87opWpWgUvofk33YCPFWOBAq4bHN4N-eLAee1Uyl2eBDr_J1Z49OqY4G_HUDBOfmLWudlfqG0xBdpHmwXDRK9dLnVP-MyprV0q2iQmqhtcNwGA" alt="" width="16" height="16" /></span> Société biblique américaine</strong><br />
        <a href="https://www.americanbible.org/">https://www.americanbible.org</a>
    </div>
    <div class='contacts'>
      <strong><span id="docs-internal-guid-ef0d4bc8-7fff-b9b3-16d1-0d1e4e838a36"><img src="https://lh3.googleusercontent.com/85PmYxqksM0C8XtbN2k4M5GJxZRmje1fZY34dJ6KaccC7E-JkHnEHQqsFn5l-_dse8KJBJkKQIa0E8OC_RTd8X4VJAYJJgD34fF23hIAqdbZTdMQHyAW6xoUWvEuPVxbd2unEKI7" alt="" width="32" height="31" /></span> Société biblique canadienne</strong><br />
        <a href="https://www.biblesociety.ca/">https://www.biblesociety.ca</a>
    </div>
</div>

<div class='clearfix'>
    <div class='contacts'>
      <strong><span id="docs-internal-guid-edfea179-7fff-bd30-ad32-788f4f517f5f"><img src="https://lh3.googleusercontent.com/lCR5veYj-iNSurfS_LLlABpFeNh6LdKL6cC9C51mb7F64P-yBoFDe8puJTqA2fBLNYTZpy8xXEfVPmJuqVTHYyxYXYgln8q9-YrywNbHSiYLYBAGK080O7Uocxcs5mOP7xd7GLCW" alt="" width="32" height="32" /></span>biblique du Brésil</strong><br />
        <a href="https://sbb.org.br/">https://sbb.org.br/</a>
    </div>
    <div class='contacts'>
        <strong>&nbsp;</strong><br />
        &nbsp;
	</div>
</div>

<p>Ligue biblique</p>

<div class='clearfix'>
    <div class='contacts'>
        <strong>Ligue Bíblique México</strong><br />
        <a href="https://www.laligabiblica.org.mx">https://www.laligabiblica.org.mx</a>
    </div>
    <div class='contacts'>
      <strong><span id="docs-internal-guid-1897ed0f-7fff-ac69-c003-1e4b7e173e6e"><img src="https://lh5.googleusercontent.com/BNpZGBWoDZzlPXBN02U7h9xIH_MwZBQxy9WuydrfEt6l7xlYyIzzI359hcV6EQqmeZKiFmPcV4gPSFJUAaUscJyto9P6-AOaueP8oBrI44pfQx7d-uxS0UkJf2mYGvxldpQ7yyAJ" alt="" width="32" height="32" /></span>Biblique Ligue (États-Unis)</strong><br />
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
