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
		@media only screen and (max-width: 480px) {

			/* (max-width: 412px) for Samsung S8+ 2/20/2019 */
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
	//echo "<img src='images/00por-ScriptureEarth_header.jpg' style='position: relative; top: 0px; z-index: 1; width: 30%;' />";
	//echo '</div>';

	switch ($CTPHC) {
		case "CR":
	?>
			<script type="text/javascript" language="javascript">
				document.title = "Copyright";
			</script>
			<h2>Copyright página</h2>
			<span style='font-weight: bold'>A tradução é feita com o Google Translate para levantá-lo rapidamente. Esperamos obter uma tradução humana num futuro próximo.</span><br /><br />
			<p>© <?php echo date('Y'); ?> SIL Internacional</p>
			<p>A <em>ScriptureEarth.org</em> website é administrada por SIL International. As informações de copyright e licenciamento individuais são indicadas em cada produto por sua organização contribuinte.</p>
			<p>O objetivo desta página é dar acesso a produtos das Escrituras nas mais diversas línguas do mundo. As informações sobre direitos autorais e licenciamento individuais estão descritas em cada produto pela devida organização colaboradora.</p>
			<p>Na página podem ser econtrados arquivos de mídia nos seguintes formatos:
			<ul type="disc">
				<li>vídeo</li>
				<li>áudio</li>
				<li>texto para ler online (às vezes com áudio de acompanhamento)</li>
				<li>PDFs</li>
				<li>aplicativos móveis</li>
				<li>links para comprar Bíblias impressas e outros recursos</li>
			</ul>
			</p>
		<?php
			break;
		case "TC":
		?>
			<script type="text/javascript" language="javascript">
				document.title = "Termos e condicionais";
			</script>
			<h2>Termos e Condições</h2>
			<p>Bem-vindo a nossa página. Ao acessar e navegar neste site, você estará de acordo com os seguintes termos e condições de uso que, juntamente com nossa política de privacidade, regem o relacionamento da SIL International com o(s) usuário(s) deste site. Se você discordar plena ou parcialmente com qualquer um destes termos e condições, não use nosso site.</p>
			<p>O termo 'SIL International' ou 'nós' ou 'nosso' refere-se ao proprietário do site, cuja sede social está situada em 7500, West Camp Wisdom Road, Dallas Texas - EUA.</p>
			<p>Os termos 'você' e 'seu' referem-se ao(s) usuário(s) que acessa(m) nosso site.</p>
			<p>Ao usar este site, você concorda com os seguintes termos de uso:</p>
			<ul>
				<li>O conteúdo das páginas deste site é destinado apenas para uso e informação geral, estando sujeito a alteração sem aviso prévio.</li>
				<li>Nem nós, nem terceiros, oferecemos qualquer garantia quanto à exatidão, cronologia, desempenho, integridade ou adequação das informações e materiais encontrados ou oferecidos neste site para qualquer finalidade específica. Você reconhece que tais informações e materiais podem conter imprecisões ou erros, e nós nos excluímos expressamente de qualquer responsabilidade por tais imprecisões ou erros na extensão máxima permitida por lei.</li>
				<li>O uso de quaisquer informações ou de materias constantes neste site é de sua inteira responsabilidade e risco, pelo qual não nos responsabilizamos. É de sua responsabilidade garantir que quaisquer produtos, serviços ou informações disponíveis por meio deste site atendam às suas necessidades específicas.</li>
				<li>Este site contém material que estamos autorizados a publicar. Estes materiais incluem, design, layout, aparência, formato e gráficos, mas não se limita a estes. A reprodução é proibida, exceto se de acordo com os direitos autorais e de licenciamento específicos de cada produto.</li>
				<li>Todos os nomes, logotipos, nomes de produtos e serviços, designs e slogans no ScriptureEarth são marcas registradas de seus respectivos proprietários.</li>
				<li>O uso não autorizado deste site poderá gerar uma ação indenizatória por danos e / ou uma queixa-crime.</li>
				<li>Este site inclui links para outros sites. Esses links são oferecidos para sua conveniência para fornecer informações adicionais. Isto não significa que endossamos este(s) site(s). Não temos responsabilidade pelo conteúdo deste(s) site(s) vinculado(s) ao nosso.</li>
			</ul>
		<?php
			break;
		case "P":
		?>
			<script type="text/javascript" language="javascript">
				document.title = "Privacidade";
			</script>
			<h2>Privacidade</h2>
			<span style='font-weight: bold'>A tradução é feita com o Google Translate para levantá-lo rapidamente. Esperamos obter uma tradução humana num futuro próximo.</span><br /><br />
			<p>ScriptureEarth não usa tecnologia de "cookies". O site, portanto, não rastreia usuários ou uso padrões de.</p>
			<h3>Coletando e usando informações pessoais</h3>
			<p>Quando você navega neste site ou entra em contato com a SIL International por meio deste site, não coletaremos informações pessoais sobre você, a menos que você forneça essas informações voluntariamente. Se você fornecer seu endereço postal ou de e-mail por meio de nossos mecanismos de feedback, receberá apenas as informações para as quais forneceu o endereço.</p>
			<p>Quando necessário, as informações pessoais podem ser encaminhadas às organizações parceiras da SIL International para fornecer uma resposta à sua solicitação ou comentários.</p>
			<p>Se você fornecer informações pessoais não públicas (como nome, endereço, endereço de e-mail ou número de telefone) por meio deste site, a SIL International usará essas informações apenas para os fins declarados na página onde foram coletadas.</p>
			<p>A SIL International não envia e-mail não solicitado ou “spam” e não vende, aluga ou troca suas listas de e-mail com terceiros.</p>
			<p>Em todos os casos, divulgaremos informações consistentes com as leis e regulamentos aplicáveis, se necessário.</p>
			<h3>Links</h3>
			<p>ScriptureEarth contém links para outros sites. Esses links fornecem recursos relevantes. Um link para um documento ou site não implica necessariamente que a SIL International:</p>
			<ul>
				<li>endossa a (s) organização (ões) ou pessoa (s) que os fornece (s)</li>
				<li>concorda com as idéias expressas ou</li>
				<li>atesta a correção, factualidade, adequação ou legalidade dos conteúdos</li>
			</ul>
			<p>SIL International também não é responsável pelas políticas ou práticas de privacidade desses sites.</p>
		<?php
			break;
		case "H":
		?>
			<script type="text/javascript" language="javascript">
				document.title = "Ajuda";
			</script>
			<h2>Ajuda</h2>
			<p>
				O gráfico abaixo mostra como usar a página inicial para encontrar uma língua específica.
				Sempre que o usuário digitar numa das caixas de pesquisa ou selecionar “Listar por país”,
				uma ou mais opções aparecerão. O item procurado poderá ser selecionado na lista.
			</p>
			<div style="text-align: center; margin-right: auto; margin-left: auto; margin-top: 30px; margin-bottom: 40px; ">
				<img src='./images/00por-helpExplanation.jpg' style='height: 80%; width: 80%; ' />
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
					<strong>Para perguntas ou para dar feedback, entre em contato com:</strong><br />
					<img src='./images/app-icon.jpg' alt="feedback" style='margin-bottom: -6px; ' width="32" height="32" />
					<a href="mailto:info&#64;ScriptureEarth.org">info&#64;ScriptureEarth.org</a><br /><br />
					<img src="./images/sil-icon.jpg" alt="SIL International" width="32" height="32" /><strong> SIL International</strong><br />
					<a href="https://www.sil.org/">www.sil.org</a>
				</div>
				<div class='contacts'>
					<strong>&nbsp;</strong><br />
					&nbsp;
				</div>
			</div>

			<hr>

			<h3>Alguns de nossos colaboradores</h3>

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
				<div class='contacts'>
					<strong>&nbsp;</strong><br />
					&nbsp;
				</div>
			</div>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/WycliffeUSAIcon.png" alt="Wycliffe USA" width="50" /><strong> Wycliffe USA</strong><br />
					<a href="https://www.wycliffe.org/">https://www.wycliffe.org/</a>
				</div>
				<div class='contacts'>
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
					<img src="./images/BibleSocietyOfBrazilIcon.png" alt="Sociedade Bíblica do Brasil" width="32" height="32" /><strong> Sociedade Bíblica do Brasil</strong><br />
					<a href="https://sbb.org.br/">https://sbb.org.br/</a>
				</div>
				<div class='contacts'>
					<strong>&nbsp;</strong><br />
					&nbsp;
				</div>
			</div>

			<h3>Liga Da Bíblia</h3>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/LaLegaBiblicaIcon.png" alt="Liga Da Bíblica México" height="32" /><strong>Liga Da Bíblia México</strong><br />
					<a href="https://www.laligabiblica.org.mx">https://www.laligabiblica.org.mx</a>
				</div>
				<div class='contacts'>
					<img src="./images/BibleLeagueUSAIcon.png" alt="Liga Da Bíblia (EUA)" width="32" height="32" /><strong>Liga Da Bíblia (EUA)</strong><br />
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