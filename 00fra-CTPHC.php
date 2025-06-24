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
	//echo "<img src='images/00fra-ScriptureEarth_header.jpg' style='position: relative; top: 0px; z-index: 1; width: 30%; ' />";
	//echo '</div>';

	switch ($CTPHC) {
		case "CR":
	?>
			<script type="text/javascript" language="javascript">
				document.title = "Copyright";
			</script>
			<h2>Copyright</h2>
			<p>© <?php echo date('Y'); ?> SIL Global</p>
			<p>Le site Web <em>ScriptureEarth.org</em> est géré par SIL Global. Les informations individuelles sur les droits d'auteur et les licences sont indiquées sur chaque produit par l'organisation qui y contribue.</p>
			<p>Le but de ce site est de fournir un accès aux produits bibliques pour les langues du monde. Les informations individuelles sur les droits d'auteur et les licences sont indiquées sur chaque produit par l'organisation qui y contribue.</p>
			<p>Parmi les formats de médias proposés sur le site, citons :
			<ul>
				<li>vidéo</li>
				<li>audio</li>
				<li>texte à lire en ligne (parfois avec un suivi audio)</li>
				<li>PDF</li>
				<li>applications mobiles</li>
				<li>des liens pour acheter des Bibles imprimées et d’autres ressources</li>
			</ul>
			</p>
		<?php
			break;
		case "TC":
		?>
			<script type="text/javascript" language="javascript">
				document.title = "Termes et conditions";
			</script>
			<h2>Termes et conditions</h2>
			<p>Bienvenue sur notre site Web. Si vous continuez à naviguer et à utiliser ce site Web, vous acceptez de respecter et d'être lié par les conditions d'utilisation suivantes qui, avec notre politique de confidentialité, régissent la relation de SIL Global avec vous en ce qui concerne ce site Web. Si vous n'êtes pas d'accord avec une partie de ces termes et conditions, veuillez ne pas utiliser notre site Web.</p>
			<p>Le terme « SIL Global » ou « nous » fait référence au propriétaire du site Web dont le siège social est situé à 7500 West Camp Wisdom Road, Dallas TX, USA.</p>
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
			<p>Lorsque vous naviguez sur ce site Web ou que vous contactez SIL Global par le biais de ce site, nous ne recueillons pas d'informations personnelles vous concernant, sauf si vous les fournissez volontairement. Si vous fournissez votre adresse postale ou électronique par le biais de nos mécanismes de retour d'information, vous recevrez uniquement les informations pour lesquelles vous avez fourni l'adresse.</p>
			<p>Si nécessaire, les informations personnelles peuvent être transmises aux organisations partenaires de SIL Global afin de fournir une réponse à votre demande ou à vos commentaires.</p>
			<p>Si vous fournissez des informations personnelles non publiques (telles qu'un nom, une adresse, une adresse électronique ou un numéro de téléphone) via ce site, SIL Global n'utilisera ces informations que dans le but indiqué sur la page où elles sont collectées.</p>
			<p>SIL Global n'envoie pas d'e-mails non sollicités ou de «spam» et ne vend pas, ne loue ni n'échange ses listes de diffusion à des tiers.</p>
			<p>Dans tous les cas, nous divulguerons des informations conformément aux lois et réglementations en vigueur si nécessaire.</p>
			<h2>Liens</h2>
			<p>ScriptureEarth contient des liens vers d'autres sites Web. Ces liens vous permettent d'accéder à des ressources pertinentes. Un lien vers un document ou un site n'implique pas forcément que SIL Global :</p>
			<ul type="disc">
				<li>approuve l'organisation ou les personnes qui les fournissent,</li>
				<li>est d’accord avec les idées exprimées, ou</li>
				<li>atteste de l'exactitude, des faits, de la pertinence ou de la légalité de leur contenu.</li>
			</ul>
			<p>SIL Global n'est pas non plus responsable des politiques ou pratiques de confidentialité de ces sites Web.</p>
		<?php
			break;
		case "H":
		?>
			<script type="text/javascript" language="javascript">
				document.title = "Aide";
			</script>
			<h2>Aide</h2>
			<p>
				L’image ci-dessous démontre comment utiliser la page d’accueil pour rechercher une language particulière.
				Lorsqu’on saisit quelque chose dans une boîte de recherche ou que l’on choisit « List by Country »,
				des options apparaîtront. L’option voulue pourra alors être sélectionnée dans la liste.
			</p>
			<div style="text-align: center; margin-right: auto; margin-left: auto; margin-top: 30px; margin-bottom: 40px; ">
				<img src='./images/00fra-helpExplanation.jpg' style='height: 80%; width: 80%; ' />
			</div>
		<?php
			break;
		case "CU":
		?>
			<script type="text/javascript" language="javascript">
				document.title = "Liens";
			</script>
			<!-- h2>Liens</h2 -->
			<br />

			<div class='clearfix' style='margin-top: 20px; margin-bottom: 40px; margin-left: 20px; font-size: 120%; '>
				<div class='contacts'>
					<strong>Vous souhaitez donner votre avis ou vous avez une demande :</strong><br />
					<img src='./images/app-icon.jpg' alt="feedback" style='margin-bottom: -6px; ' width="32" height="32" />
					<a href="mailto:info&#64;ScriptureEarth.org">info&#64;ScriptureEarth.org</a><br /><br />
					<img src="./images/sil-icon.jpg" alt="SIL Global" width="32" height="32" /><strong> SIL Global</strong><br />
					<a href="https://www.sil.org/">www.sil.org</a>
				</div>
			</div>

			<hr>

			<h3>Certains de nos collaborateurs</h3>

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

			<h3>Sociétés bibliques</h3>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/AmericanBibleSocietyIcon.png" alt="Société biblique américaine" width="32" /><strong> Société biblique américaine</strong><br />
					<a href="https://www.americanbible.org/">https://www.americanbible.org</a>
				</div>
				<div class='contacts'>
					<img src="./images/CanadianBibleSocietyIcon.png" alt="Société biblique canadienne" width="32" height="31" /><strong> Société biblique canadienne</strong><br />
					<a href="https://www.biblesociety.ca/">https://www.biblesociety.ca</a>
				</div>
			</div>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/BibleSocietyOfBrazilIcon.png" alt="biblique du Brésil" width="32" height="32" /><strong> biblique du Brésil</strong><br />
					<a href="https://sbb.org.br/">https://sbb.org.br/</a>
				</div>
			</div>

			<h3>Ligue biblique</h3>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/LaLegaBiblicaIcon.png" alt="Ligue Bíblique México" height="32" /><strong>Ligue Bíblique México</strong><br />
					<a href="https://www.laligabiblica.org.mx">https://www.laligabiblica.org.mx</a>
				</div>
				<div class='contacts'>
					<img src="./images/BibleLeagueUSAIcon.png" alt="Biblique Ligue (États-Unis)" width="32" height="32" /><strong>Biblique Ligue (États-Unis)</strong><br />
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