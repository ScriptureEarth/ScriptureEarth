<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type"				content="text/html; charset=utf-8" />
<meta name="viewport" 						content="width=device-width, initial-scale=1, maximum-scale=1" />
<meta name="ObjectType" 					content="Document" />
<meta http-equiv="Window-target" 			content="_top" />
<meta name="Created-by" 					content="Scott Starker" />
<meta name="Maintained-by" 					content="Website" />
<meta name="Approved-by" 					content="Bill Dyck, Access Coordinator" />
<meta name="Copyright" 						content="2009 - <?php echo date("Y"); ?>" />		<!-- auto_copyright("2009") -->
<style type="text/css">
	body {
		font: 100% Verdana, Arial, Helvetica, sans-serif;
	}
	ul.ul {
		text-align: center;
		font-size: .86em;
		font-weight: bold;
		margin-left: -40px;
	}
	li.aboutText {
		text-decoration: none;
		display: inline;
		background-color: lightgray;
		padding: 10px 20px;
		border: solid thin black;
		color: #A82120;
		cursor: pointer;
	}
	li.aboutText:hover {
		background-color: #FFFFCC;
	}
</style>
</head>
<body>
	<?php
	if (isset($_GET['st'])) {
		$st = $_GET['st'];
		$test = preg_match('/^[a-z]{3}/', $st, $match);
		if ($test === 0) {
			die ("<br />$st wasn’t found.</body></html>");
		}
		$st = $match[0];
		if ($st != 'eng' && $st != 'spa' && $st != 'por' && $st != 'dut' && $st != 'fre' && $st != 'deu') {
			die ("<br />$st wasn’t found.</body></html>");
		}
	}
	else {
		die ("<br />HACK!</body></html>");
	}
	include '../translate/functions.php';							// translation function
	$ML = "";
	?>
    
    <div style="width: 100%; background-color: black; text-align: center; ">
        <img src='../images/00i-top_header.jpg' style='width: 30%; ' />
    </div>
    <div style="background-color: white; margin-top: 20px; margin-bottom: 20px; ">
        <div style='margin-left: 20px; margin-right: 20px; padding-top: 20px; padding-bottom: 40px; text-align: left; '>
        <?php
		switch ($st) {
			case "eng":
			?>
                <div style='color: #A82120; font-weight: bold; font-size: 1.2em; margin-bottom: 20px; '>
                    About this site
                </div>
                The ScriptureEarth.org website is managed by SIL International <span style='cursor: pointer; color: darkred; text-decoration: underline; ' onClick='window.open("https://www.sil.org")'>(www.sil.org)</span>.
                <br /><br />
                SIL’s service with ethnolinguistic minority communities is motivated by the belief that all people are created in the image of God, and that languages and cultures are part of the richness of God’s creation.
                <br /><br />
                The purpose of this site is to provide access to Scripture products for the languages of the world. Individual copyright and licensing information is indicated on each product by its contributing organization.
                <br /><br />
                Some of the media formats on the website include:
                <ul>
                    <li>video</li>
                    <li>audio</li>
                    <li>text to read online (sometimes with follow-along audio)</li>
                    <li>PDFs</li>
                    <li>mobile apps</li>
                    <li>links to purchase printed Bibles and other resources</li>
                </ul><br />
            <?php
				$ML = "i";
				break;
			case "spa":
			?>
                <div style='color: #A82120; font-weight: bold; font-size: 1.2em; margin-bottom: 20px; '>
                    Acerca de este sitio
                </div>
                La página web ScriptureEarth.org es administrada por SIL International <span style='cursor: pointer; color: darkred; text-decoration: underline; ' onClick='window.open("https://www.sil.org")'>(www.sil.org)</span>.
                <br /><br />
                El servicio que SIL brinda a las comunidades minoritarias etnolingüísticas está motivado por la creencia de que todas las personas fueron creadas a imagen de Dios; que los idiomas y las culturas son parte de la riqueza de la creación de Dios.
                <br /><br />
                El propósito de este sitio es brindar acceso a productos de las Escrituras para los idiomas del mundo. La información individual sobre derechos de autor y licencias se indica en cada producto por su organización colaboradora.
                <br /><br />
                Algunos de los formatos multimedia en el sitio web incluyen:
                <ul>
                	<li>video</li>
                    <li>audio</li>
                    <li>texto para leer en línea (a veces con audio simultáneo)</li>
                    <li>archivos PDF</li>
                    <li>aplicaciones móviles</li>
                    <li>enlaces para comprar o imprimir Biblias y otros recursos</li>
                </ul><br />
            <?php
				$ML = "e";
				break;
			case "por":
			?>
				<div style='color: #A82120; font-weight: bold; font-size: 1.2em; margin-bottom: 20px; '>
					Sobre este site
				</div>
				A página ScriptureEarth.org é mantida pela SIL International. <span style='cursor: pointer; color: darkred; text-decoration: underline; ' onClick='window.open("https://www.sil.org")'>(www.sil.org)</span>
				<br /><br />
				O trabalho da SIL entre as comunidades etnolinguísticas minoritárias é motivado pela fé de que todas as pessoas são criadas à imagem de Deus, e que as respectivas línguas e suas culturas são parte da riqueza da criação de Deus.
				<br /><br />
				O objetivo desta página é dar acesso a produtos das Escrituras nas mais diversas línguas do mundo. As informações sobre direitos autorais e licenciamento individuais estão descritas em cada produto pela devida organização colaboradora.<br /><br />
				Na página podem ser econtrados arquivos de mídia nos seguintes formatos:"+
				<ul>
					<li>vídeo</li>
					<li>áudio</li>
					<li>texto para ler online (às vezes com áudio de acompanhamento)</li>
					<li>PDFs</li>
					<li>aplicativos móveis</li>
					<li>links para comprar Bíblias impressas e outros recursos</li>
				</ul><br />
            <?php
				$ML = "p";
				break;
			case "nld":
			?>
				<div style='color: #A82120; font-weight: bold; font-size: 1.2em; margin-bottom: 20px; '>
					Over deze website
				</div>
				De ScriptureEarth.org website wordt beheerd door SIL International <span style='cursor: pointer; color: darkred; text-decoration: underline; ' onClick='window.open("https://www.sil.org")'>(www.sil.org)</span>.
				<br /><br />
				Het verlangen van SIL International om etno-linguïstische minderheden te ondersteunen is gemotiveerd door het geloof dat alle mensen naar het beeld van God zijn geschapen en dat talen en culturen deel uitmaken van de rijkdom van Gods schepping.
				<br /><br />
				Het doel van deze site is om Bijbelse mediaproducten in zoveel mogelijk talen beschikbaar en toegankelijk te maken. Individuele copyright- en licentie-informatie wordt op elk mediaproduct aangegeven door de organisatie die aan het product verbonden is.
				<br /><br />
				De volgende mediavormen zijn op de website te vinden:
				<ul>
					<li>video</li>
					<li>audio</li>
					<li>tekst online te lezen (soms met begeleidende audio)</li>
					<li>PDFs</li>
					<li>mobiele apps</li>
					<li>links voor de aanschaf van gedrukte bijbels en andere hulpmiddelen</li>
				</ul><br />
            <?php
				$ML = "d";
				break;
			case "fra":
			?>
				<div style='color: #A82120; font-weight: bold; font-size: 1.2em; margin-bottom: 20px; '>
					À propos de ce site
				</div>
				Le site ScriptureEarth.org est géré par SIL International <span style='cursor: pointer; color: darkred; text-decoration: underline; ' onClick='window.open("https://www.sil.org")'>(www.sil.org)</span>.
				<br /><br />
				Le service de SIL auprès des communautés ethno linguistiques minoritaires est motivé par la conviction que tous les êtres humains sont créés à l'image de Dieu, et que les langues et les cultures font partie de la richesse de la création de Dieu.
				<br /><br />
				Le but de ce site est de fournir un accès aux produits bibliques pour les langues du monde. Les informations individuelles sur les droits d'auteur et les licences sont indiquées sur chaque produit par l'organisation qui y contribue.
				<br /><br />
				Parmi les formats de médias proposés sur le site, citons :
				<ul>
					<li>vidéo</li>
					<li>audio</li>
					<li>texte à lire en ligne (parfois avec un suivi audio)</li>
					<li>PDF</li>
					<li>applications mobiles</li>
					<li>des liens pour acheter des Bibles imprimées et d’autres ressources</li>
				</ul><br />
            <?php
				$ML = "f";
				break;
			case "deu":
			?>
				<div style='color: #A82120; font-weight: bold; font-size: 1.2em; margin-bottom: 20px; '>
					Über diese Website
				</div>
				<span style='font-weight: bold'>Die Übersetzung erfolgt mit Google Translate, um es schnell zu bekommen. Wir hoffen, in naher Zukunft eine menschliche Übersetzung zu erhalten.</span><br /><br />
				Die ScriptureEarth.org Website is  von SIL International <span style='cursor: pointer; color: darkred; text-decoration: underline; ' onClick='window.open("https://www.sil.org")'>(www.sil.org)</span> verwaltet.
				<br /><br />
				Der Dienst von SIL an ethno linguistischen Minderheiten Gemeinschaften basiert auf der Überzeugung, dass alle Menschen nach dem Bilde Gottes geschaffen sind und dass Sprachen und Kulturen Teil des Reichtums der Schöpfung Gottes sind.
				<br /><br />
				Der Zweck dieser Website ist es, den Zugang zu Schrift Produkten zu verschaffen Sprachen der Welt. Individuelle Copyright- und Lizenzinformationen werden auf jedem Produkt von der beitragenden Organisation angegeben.
				<br /><br />
				Einige der Medienformate auf der Website umfassen:
				<ul>
					<li>video</li>
					<li>audio-Text</li>
					<li>online zu lesen (manchmal mit Follow-along Audio)</li>
					<li>PDFs</li>
					<li>mobile Anwendungen</li>
					<li>links zu Kauf gedruckten Bibeln und andere Ressourcen</li>
				</ul><br />
            <?php
				$ML = "de";
				break;
			default:
				echo 'This isn’t supposed to happen! The default major language abbreviation isn’t found.';
				break;
		}
			?>
        </div>
    </div>
    
    <ul class="ul">
        <li class="aboutText" onClick="window.open('../00<?php echo $ML; ?>-CTPHC.php?I=CR&amp;Window=Window'); "><?php echo translate('Copyright', $st, 'sys'); ?></li>
        <li class="aboutText" onClick="window.open('../00<?php echo $ML; ?>-CTPHC.php?I=TC&amp;Window=Window'); "><?php echo translate('Terms and Conditions', $st, 'sys'); ?></li>
        <li class="aboutText" onClick="window.open('../00<?php echo $ML; ?>-CTPHC.php?I=P&amp;Window=Window'); "><?php echo translate('Privacy', $st, 'sys'); ?></li>
        <li class="aboutText" onClick="window.open('../00<?php echo $ML; ?>-CTPHC.php?I=CU&amp;Window=Window'); "><?php echo translate('Contacts/Links', $st, 'sys'); ?></li>
    </ul>

</body>
</html>