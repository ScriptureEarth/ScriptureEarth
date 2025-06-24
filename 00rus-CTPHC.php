<?php
/* variables of 00zzz-CTPHC.php:
		'I': 'CR', 'TC', 'P', 'H', and 'CU': section to be display
	   $st variables:
		eng, deu, cmn, nld, spa, fra, por, kor, rus
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

	//echo '<div style="text-align: center; width: 100%; background-color: black; ">';
	//echo "<img src='images/00eng-ScriptureEarth_header.jpg' style='position: relative; top: 0px; z-index: 1; width: 50%;' />";
	//echo '</div>';

	switch ($CTPHC) {
		case "CR":
		?>
			<script type="text/javascript" language="javascript">
				document.title = "Авторские права";
			</script>
			<h2>Авторские права</h2>
			<p>© <?php echo date('Y'); ?> SIL Global</p>
			<p>Сайт <em>ScriptureEarth.org</em> находится под управлением SIL Global. SIL работает с общинами этнолингвистических меньшинств, руководствуясь убеждением, что все люди созданы по образу и подобию Божьему, а языки и культуры являются частью богатства Божьего творения.</p>
			<p>Цель этого сайта - предоставить доступ к продуктам Священного Писания на языках мира. Информация об авторских правах и лицензировании указывается на каждом продукте организацией, предоставившей его.</p>
			<p>Некоторые из медиаформатов, представленных на сайте ScriptureEarth, включают:
			<ul type="disc">
				<li>видео</li>
				<li>аудио</li>
				<li>текст для чтения в автономном режиме (PDF-файлы)</li>
				<li>текст для чтения онлайн (иногда с аудио сопровождением)</li>
				<li>мобильные приложения</li>
				<li>ссылки для покупки печатных Библий и других ресурсов</li>
			</ul>
			</p>
		<?php
			break;
		case "H":
		?>
			<script type="text/javascript" language="javascript">
				document.title = "Помощь";
			</script>
			<h2>Помощь</h2>
			<p>
            На графике ниже показано, как использовать главную страницу для поиска определенного языка.
            Каждый раз, когда пользователь набирает текст в одном из поисковых полей или выбирает «Список по странам»,
            появляется один или несколько вариантов. Нужный пункт можно выбрать из списка.
			</p>
			<div style="text-align: center; margin-right: auto; margin-left: auto; margin-top: 30px; margin-bottom: 40px; ">
				<img src='./images/00rus-helpExplanation.jpg' style='height: 90%; width: 90%; ' />
			</div>
		<?php
			break;
		case "CU":
		?>
			<script type="text/javascript" language="javascript">
				document.title = "Ссылки";
			</script>
			<!-- h2>Links</h2 -->
			<br />

			<div class='clearfix' style='margin-top: 20px; margin-bottom: 40px; margin-left: 20px; font-size: 120%; '>
				<div class='contacts'>
					<strong>По вопросам и для обратной связи обращайтесь:</strong><br />
					<img src='./images/app-icon.jpg' alt="feedback" style='margin-bottom: -6px; ' width="32" height="32" />
					<a href="mailto:info&#64;ScriptureEarth.org">info&#64;ScriptureEarth.org</a> (Земля Писаний)<br /><br />
					<img src="./images/sil-icon.jpg" alt="SIL Global" width="32" height="32" /><strong> SIL Global</strong><br />
					<a href="https://www.sil.org/">www.sil.org</a>
				</div>
			</div>

			<hr>

			<h3>Некоторые из наших коллабораторов</h3>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/FaithComesByHearingIcon.png" alt="Fath Comes By Hearing" width="32" /><strong>Faith Comes By Hearing / Hosanna / Bible.is</strong><br />(Вера приходит через слух / Осанна)<br />
					<a href="https://www.faithcomesbyhearing.com/">https://www.faithcomesbyhearing.com</a>
				</div>
				<div class='contacts'>
					<img src="./images/JesusFilmMediaIcon.png" alt="Jesus Film Media" width="32" height="32" /><strong>&nbsp;Jesus Film Media</strong><br />(Иисус Фильм Медиа)<br />
					<a href="https://jesusfilmmedia.org/">https://jesusfilmmedia.org</a>
				</div>
			</div>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/eBible_icon.png" alt="eBible" width="30" height="30" /><strong> eBible</strong><br />(звукозаписи)<br />
					<a href='https://ebible.org/'>https://ebible.org/</a><br />
				</div>
				<div class='contacts'>
					<img src="./images/YouVersionIcon.png" alt="YouVersion" width="32" height="32" /><strong> YouVersion</strong><br />(Версия для вас)<br />
					<a href="https://www.youversion.com/">https://www.youversion.com/</a>
				</div>
			</div>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/BiblicaIcon.png" alt="Biblica" width="30" /><strong> Biblica</strong><br />
					<a href="https://www.biblica.com/">https://www.biblica.com/</a>
				</div>
				<div class='contacts'>
					<img src="./images/Find.Bible.jpg" alt="Find a Bible" width="30" height="30" /><strong> Find a Bible</strong><br />(Найти Библию)<br />
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
					<img src="./images/GlobalRecordingsNetworkIcon.png" alt="Global Recording Network" width="20" /><strong> Global Recordings Network</strong><br />(Глобальная сеть звукозаписи)<br />
					<a href="https://globalrecordings.net/en">https://globalrecordings.net/en</a>
				</div>
			</div>

			<h3>Wycliffe (Вайклифф)</h3>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/WycliffeGlobalAllianceIcon.png" alt="Wycliffe Global Alliance" width="32" height="32" /><strong> Wycliffe Global Alliance</strong><br />(Вайклифф Глобальный альянс)<br />
					<a href="https://www.wycliffe.net">https://www.wycliffe.net</a>
				</div>
			</div>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/WycliffeUSAIcon.png" alt="Wycliffe USA" width="50" /><strong> Wycliffe USA</strong><br />(Вайклифф США)<br />
					<a href="https://www.wycliffe.org/">https://www.wycliffe.org/</a>
				</div>
				<div class='contacts'>
					<br />
					<img src="./images/WycliffeUKIcon.png" alt="Wycliffe UK" width="30" /><strong> Wycliffe UK</strong><br />(Вайклифф Великобритания)<br />
					<a href="https://www.wycliffe.org.uk/">https://www.wycliffe.org.uk/</a>
				</div>
			</div>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/WycliffeCanadaIcon.png" alt="Wycliffe Canada" width="32" height="32" /><strong>Wycliffe Canada</strong><br />(Вайклифф Великобритания)<br />
					<a href="https://www.wycliffe.ca">https://www.wycliffe.ca</a>
				</div>
				<div class='contacts'>
					<img src="./images/WycliffeAustraliaIcon.png" alt="Wycliffe Australia" width="32" height="32" /><strong> Wycliffe Australia</strong><br />(Вайклифф Австралия)<br />
					<a href="https://wycliffe.org.au">https://wycliffe.org.au</a>
				</div>
			</div>

			<h3>Библейские общества</h3>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/AmericanBibleSocietyIcon.png" alt="Amercain Bible Society" width="32" /><strong> American Bible Society</strong><br />(Американское библейское общество)<br />
					<a href="https://www.americanbible.org/">https://www.americanbible.org</a>
				</div>
				<div class='contacts'>
					<img src="./images/CanadianBibleSocietyIcon.png" alt="Canadian Bible Society" width="32" height="31" /><strong> Canadian Bible Society</strong><br />(Канадское библейское общество)<br />
					<a href="https://www.biblesociety.ca/">https://www.biblesociety.ca</a>
				</div>
			</div>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/BibleSocietyOfBrazilIcon.png" alt="Bible Society of Brazil" width="32" height="32" /><strong> Bible Society of Brazil</strong><br />(Библейское общество Бразилии)<br />
					<a href="https://sbb.org.br/">https://sbb.org.br/</a>
				</div>
			</div>

			<h3>Библейская лига</h3>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/LaLegaBiblicaIcon.png" alt="Liga Bíblica México" height="32" /><strong>Liga Bíblica México</strong><br />(Библейская лига Мексики)<br />
					<a href="https://www.laligabiblica.org.mx">https://www.laligabiblica.org.mx</a>
				</div>
				<div class='contacts'>
					<img src="./images/BibleLeagueUSAIcon.png" alt="Bible League (USA)" width="32" height="32" /><strong>Bible League (USA)</strong><br />(Библейская лига (США))<br />
					<a href="https://www.bibleleague.org/">https://www.bibleleague.org</a>
				</div>
			</div>

			<h3>Other Websites</h3>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/MegaVoive_icon.png" alt="MegaVoice" height="32" /><strong> MegaVoice</strong><br />(Мега Голос)<br />
					<a href="https://megavoice.com/">https://megavoice.com/</a>
				</div>
			</div>

			<br />
		<?php
			break;
		case "TC":
		?>
			<script type="text/javascript" language="javascript">
				document.title = "Соглашения";
			</script>
			<h2>Соглашения</h2>
			<p>Добро пожаловать на наш сайт. Если вы продолжаете просматривать и использовать этот сайт, вы соглашаетесь соблюдать и быть связанными следующими условиями использования, которые вместе с нашей политикой конфиденциальности регулируют отношения SIL Global с вами в отношении этого сайта. Если вы не согласны с какой-либо частью этих условий и положений, пожалуйста, не пользуйтесь нашим сайтом.</p>
			<p>Термин «SIL Global» или «мы» или «нас» относится к владельцу веб-сайта, зарегистрированный офис которого находится по адресу 7500 West Camp Wisdom Road, Dallas TX.</p>
			<p>Термины «вы» и «ваш» относятся к пользователю или зрителю нашего сайта.</p>
			<p>Используя этот сайт, вы соглашаетесь со следующими условиями использования:</p>
			<ul>
				<li>Содержание страниц этого сайта предназначено только для общего ознакомления и использования. Оно может быть изменено без предварительного уведомления.</li>
				<li>Ни мы, ни третьи лица не предоставляем никаких гарантий в отношении точности, своевременности, производительности, полноты или пригодности информации и материалов, размещенных или предлагаемых на этом сайте, для каких-либо конкретных целей. Вы признаете, что такая информация и материалы могут содержать неточности или ошибки, и мы однозначно исключаем ответственность за любые такие неточности или ошибки в максимально допустимой законом степени.</li>
				<li>Вы используете любую информацию или материалы на этом сайте исключительно на свой страх и риск, за который мы не несем ответственности. Вы сами несете ответственность за то, чтобы любые продукты, услуги или информация, доступные через этот сайт, соответствовали вашим конкретным требованиям.</li>
				<li>Данный сайт содержит материалы, которые мы имеем право размещать. Эти материалы включают, в частности, дизайн, расположение, внешний вид и графику. Воспроизведение запрещено, кроме как в соответствии с авторскими правами и лицензированием, указанными на каждом продукте.</li>
				<li>Все другие названия, логотипы, наименования продуктов и услуг, дизайн и слоганы на ScriptureEarth являются торговыми марками соответствующих владельцев.</li>
				<li>Несанкционированное использование данного веб-сайта может послужить основанием для предъявления иска о возмещении ущерба и/или быть уголовным преступлением.</li>
				<li>Данный сайт содержит ссылки на другие сайты. Эти ссылки предоставляются для вашего удобства с целью получения дополнительной информации. Они не означают, что мы поддерживаем данный сайт (сайты). Мы не несем ответственности за содержание веб-сайтов, на которые ведут ссылки.</li>
			</ul>
		<?php
			break;
		case "P":
		?>
			<script type="text/javascript" language="javascript">
				document.title = "Политика конфиденциальности";
			</script>
			<h2>Политика конфиденциальности</h2>
			<p>ScriptureEarth не использует технологию «cookie». Поэтому сайт не отслеживает пользователей и их использование.</p>
			<h3>Сбор и использование личной информации</h3>
			<p>Когда вы просматриваете этот сайт или связываетесь с SIL Global через этот сайт, мы не будем собирать о вас личную информацию, если вы не предоставите ее добровольно. Если вы укажете свой почтовый адрес или адрес электронной почты, вы получите только ту информацию, для которой вы указали этот адрес.</p>
			<p>При необходимости личная информация может быть передана организациям-партнерам SIL Global для предоставления ответа на ваш запрос или комментарий.</p>
			<p>Если вы предоставляете непубличную личную информацию (например, имя, адрес, адрес электронной почты или номер телефона) через этот сайт, SIL Global будет использовать такую информацию только в целях, указанных на странице, где она была собрана.</p>
			<p>SIL Global не рассылает незапрашиваемую или «спамную» электронную почту и не продает, не сдает в аренду и не обменивает свои списки адресов электронной почты третьим лицам.</p>
			<p>В любом случае мы будем раскрывать информацию в соответствии с действующими законами и правилами, если это потребуется.</p>
			<h3>Ссылки</h3>
			<p>ScriptureEarth содержит ссылки на другие веб-сайты. По этим ссылкам вы можете найти соответствующие ресурсы. Ссылка на документ или сайт не обязательно означает, что SIL Global:</p>
			<ul>
				<li>одобряет организацию (организации) или человека (людей), предоставивших эти ссылки,</li>
				<li>согласна с высказанными идеями или</li>
				<li>подтверждает правильность, фактичность, уместность или законность содержания.</li>
			</ul>
			<p>SIL Global также не несет ответственности за политику конфиденциальности или практику этих сайтов.</p>
	<?php
			break;
		default: 				// CR, TC, P, H and CU
			die("The 'item' is not found.</body></html>");
	}
	?>
</body>

</html>