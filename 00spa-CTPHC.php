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
	//echo "<img src='images/00spa-ScriptureEarth_header.jpg' style='position: relative; top: 0px; z-index: 1; width: 30%;' />";
	//echo '</div>';

	switch ($CTPHC) {
		case "CR":
	?>
			<script type="text/javascript" language="javascript">
				document.title = "Derechos de autor de la página";
			</script>
			<h2>Derechos de autor de la página</h2>
			<p>© <?php echo date('Y'); ?> SIL International</p>
			<p>El <em>ScriptureEarth.org</em> sitio web administrado por SIL Internacional. La información individual sobre derechos de autor y licencias se indica en cada producto según la organización colaboradora.</p>
			<p>El propósito de este sitio es brindar acceso a productos de las Escrituras para los idiomas del mundo. La información individual sobre derechos de autor y licencias se indica en cada producto por su organización colaboradora.</p>
			<p>Algunos de los formatos multimedia en el sitio web incluyen:
			<ul type="disc">
				<li>video</li>
				<li>audio</li>
				<li>texto para leer en línea (a veces con audio simultáneo)</li>
				<li>archivos PDF</li>
				<li>aplicaciones móviles</li>
				<li>enlaces para comprar o imprimir Biblias y otros recursos</li>
			</ul>
			</p>
		<?php
			break;
		case "TC":
		?>
			<script type="text/javascript" language="javascript">
				document.title = "Términos y Complementos";
			</script>
			<h2>Términos y Complementos</h2>
			<p>Bienvenido a nuestro sitio web. Si continúa navegando y utilizando este sitio web, acepta cumplir y estar sujeto a los siguientes términos y condiciones de uso que, junto con nuestra política de privacidad, rigen la relación de SIL International con usted en respecto a este sitio web. Si no está de acuerdo con alguna parte de estos términos y condiciones, no utilice nuestro sitio web.</p>
			<p>El término “SIL International”, “nuestro” o “nosotros'” se refiere al propietario del sitio web cuya oficina registrada se encuentra en 7500 West Camp Wisdom Road, Dallas TX.</p>
			<p>Los términos “usted” y “su” se refieren al usuario o visitante de nuestro sitio web.</p>
			<p>Cuando utiliza este sitio web, acepta los siguientes términos de uso:</p>
			<ul>
				<li>El contenido de las páginas de este sitio web es para su información general y uso exclusivo. Está sujeto a cambios sin previo aviso.</li>
				<li>Ni nosotros ni terceros ofrecemos garantía alguna en cuanto a la precisión, puntualidad, rendimiento, integridad o idoneidad de la información y los materiales que se encuentran u ofrecen en este sitio web para un propósito en particular. Si usted reconoce que dicha información y materiales pudieran contener inexactitudes o errores; excluimos expresamente la responsabilidad por tales inexactitudes o errores en la máxima medida permitida por la ley.</li>
				<li>El uso de cualquier información o material de este sitio web es bajo su propio riesgo, por lo que no seremos responsables. Será su responsabilidad asegurarse de que cualquier producto, servicio o información disponible a través de este sitio web cumpla con sus requisitos específicos.</li>
				<li>Este sitio web contiene material que estamos autorizados a publicar. Este material incluye, pero no se limita a, el diseño, disposición, aspecto, apariencia y gráficos. La reproducción está prohibida salvo de conformidad con los derechos de autor y las licencias designadas en cada producto.</li>
				<li>Uso no autorizado. Todos los demás nombres, logotipos, nombres de productos y servicios, diseños y lemas en ScriptureEarth son marcas comerciales de sus respectivos propietarios.</li>
				<li>El uso no autorizado de este sitio web puede dar lugar a un reclamo por daños o constituir un delito.</li>
				<li>Este sitio web incluye enlaces a otros sitios web. Estos enlaces se proporcionan para su conveniencia y para ofrecer más información. No significan que respaldamos los sitios web. No tenemos ninguna responsabilidad por el contenido de los sitios web vinculados.</li>
			</ul>
		<?php
			break;
		case "P":
		?>
			<script type="text/javascript" language="javascript">
				document.title = "Privacidad";
			</script>
			<h2>Privacidad</h2>
			<p>ScriptureEarth no utiliza tecnología de "cookies". Por lo tanto, el sitio no rastrea usuarios o patrones de uso.</p>
			<h3>Recopilación y uso de información personal</h3>
			<p>Cuando navega por este sitio web o se pone en contacto con SIL International a través de este sitio, no recopilaremos información personal sobre usted a menos que proporcione esa información voluntariamente. Si da su dirección postal o de correo electrónico a través de nuestros mecanismos de retroalimentación, solo recibirá la información para la que proporcionó la dirección.</p>
			<p>Cuando sea necesario, la información personal se puede enviar a las organizaciones asociadas de SIL International con el fin de ofrecer una respuesta a su solicitud o comentarios.</p>
			<p>Si proporciona información personal no pública (como un nombre, dirección postal, dirección de correo electrónico o número de teléfono) a través de este sitio, SIL International solo utilizará dicha información para el propósito indicado en la página donde se recopila.</p>
			<p>SIL International no envía correos electrónicos no solicitados o "spam" y no vende, alquila ni intercambia sus listas de correo electrónico a terceros.</p>
			<p>En todos los casos, divulgaremos información de conformidad con las leyes y regulaciones aplicables si es necesario.</p>
			<h3>Enlaces</h3>
			<p>ScriptureEarth contiene enlaces con otros sitios web. Estos enlaces le ofrecen recursos relevantes. Un enlace a un documento o sitio no implica necesariamente que SIL International:</p>
			<ul>
				<li>respalda a las organizaciones o personas que los proporciona</li>
				<li>está de acuerdo con las ideas expresadas o</li>
				<li>da fe de la veracidad, objetividad, idoneidad o legalidad de los contenidos.</li>
			</ul>
			<p>SIL International tampoco es responsable de las políticas o prácticas de privacidad de estos sitios web.</p>
		<?php
			break;
		case "H":
		?>
			<script type="text/javascript" language="javascript">
				document.title = "Ayuda";
			</script>
			<h2>Ayuda</h2>
			<p>
				La gráfica de abajo muestra la manera correcta de usar la página de inicio para encontrar una lengua determinada.
				Cuando el usario escribe algo en una de las casillas de búsqueda, o escoge entre la “Lista de países”, aparecerá
				una o más posibles respuestas. Luego se puede escoger el país que se desea buscar.
			</p>
			<div style="text-align: center; margin-right: auto; margin-left: auto; margin-top: 30px; margin-bottom: 40px; ">
				<img src='./images/00e-AboutExplanation.jpg' style='height: 80%; width: 80%; ' />
			</div>
		<?php
			break;
		case "CU":
		?>
			<script type="text/javascript" language="javascript">
				document.title = "Enlaces";
			</script>
			<!-- h2>Enlaces</h2 -->
			<br />

			<div class='clearfix' style='margin-top: 20px; margin-bottom: 40px; margin-left: 20px; font-size: 120%; '>
				<div class='contacts'>
					<strong>Para preguntas o comentarios, comuníquese con:</strong><br />
					<img src='./images/app-icon.jpg' alt="feedback" style='margin-bottom: -6px; ' width="32" height="32" />
					<a href="mailto:info&#64;ScriptureEarth.org">info&#64;ScriptureEarth.org</a><br /><br />
					<img src="./images/SILInternationalIcon.jpg" alt="SIL International" width="32" height="32" /><strong> SIL International</strong><br />
					<a href="https://www.sil.org/">www.sil.org</a>
				</div>
			</div>

			<hr>

			<h3>Algunos de nuestros colaboradores</h3>

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
					<img src="./images/GlobalRecordingsNetworkIcon.png" alt="Global Recordings Network" width="20" /><strong> Global Recordings Network</strong><br />
					<a href="https://globalrecordings.net/en">https://globalrecordings.net/en</a>
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

			<h3>Sociedades Bíblicas</h3>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/AmericanBibleSocietyIcon.png" alt="Sociedad Bíblica Americana" width="32" /><strong> Sociedad Bíblica Americana</strong><br />
					<a href="https://www.americanbible.org/">https://www.americanbible.org</a>
				</div>
				<div class='contacts'>
					<img src="./images/CanadianBibleSocietyIcon.png" alt="Sociedad Bíblica Canadiense" width="32" height="31" /><strong> Sociedad Bíblica Canadiense</strong><br />
					<a href="https://www.biblesociety.ca/">https://www.biblesociety.ca</a>
				</div>
			</div>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/BibleSocietyOfBrazilIcon.png" alt="Sociedad Bíblica de Brasil" width="32" height="32" /><strong> Sociedad Bíblica de Brasil</strong><br />
					<a href="https://sbb.org.br/">https://sbb.org.br/</a>
				</div>
			</div>

			<h3>Ligas Bíblicas</h3>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/LaLegaBiblicaIcon.png" alt="Liga Bíblica México" height="32" /><strong>Liga Bíblica México</strong><br />
					<a href="https://www.laligabiblica.org.mx">https://www.laligabiblica.org.mx</a>
				</div>
				<div class='contacts'>
					<img src="./images/BibleLeagueUSAIcon.png" alt="Liga Bíblica (EE.UU.)" width="32" height="32" /><strong>Liga Bíblica (EE.UU.)</strong><br />
					<a href="https://www.bibleleague.org/">https://www.bibleleague.org</a>
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