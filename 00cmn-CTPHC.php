<?php
/* variables of 00zzz-CTPHC.php:
		'I': 'CR', 'TC', 'P', 'H', and 'CU': section to be display
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
	//echo "<img src='images/00cmn-ScriptureEarth_header.jpg' style='position: relative; top: 0px; z-index: 1; width: 30%;' />";
	//echo '</div>';

	switch ($CTPHC) {
		case "CR":
	?>
			<script type="text/javascript" language="javascript">
				document.title = "版权";
			</script>
			<h2>版权</h2>
			<p>© <?php echo date('Y'); ?> SIL国际</p>
			<p>该ScriptureEarth.org 网站由SIL国际管理。 其贡献组织在每个产品上注明了个人版权和许可信息。</p>
			<p>SIL为少数民族语言社区提供服务的动机是本于这信念：所有人都是按照上帝的形象创造的，而语言和文化是上帝创造的丰富内容的一部分。</p>
			<p>本网站的目的是为全世界的语言提供经文产品的使用。每个产品的版权和许可信息都由其贡献机构注明。</p>
			<p>网站上的一些媒体格式包括。
			<ul>
				<li>视频</li>
				<li>音频</li>
				<li>在线阅读的文本（有时还配有随声附和）。</li>
				<li>PDFs</li>
				<li>移动应用程序</li>
				<li>购买印刷版圣经和其他资源的链接</li>
			</ul>
			</p>
		<?php
			break;
		case "TC":
		?>
			<script type="text/javascript" language="javascript">
				document.title = "条款和条件";
			</script>
			<h2>条款和条件</h2>
			<p>欢迎到访我们的网站。如果您继续浏览和使用本网站，即表示您同意遵守以下使用条款和条件，并受其约束，这些条款和条件以及我们的隐私政策将管理SIL国际公司与您在本网站方面的关系。如果您不同意这些条款和条件的任何部分，请不要使用我们的网站。</p>
			<p>SIL国际公司 "或 "我们 "或 "我们 "是指网站的所有者，其注册地址为7500 West Camp Wisdom Road, Dallas TX。</p>
			<p>术语'您'和'您的'是指我们网站的用户或浏览者。</p>
			<p>当您使用本网站时，您同意以下使用条款。</p>
			<ul>
				<li>本网站的网页内容只为您提供一般信息和使用。它可能会在没有通知的情况下发生变化。</li>
				<li>我们或任何第三方都不对本网站上发现或提供的信息和材料的准确性、及时性、性能、完整性或对任何特定目的的适用性提供任何担保或保证。您承认这些信息和材料可能包含不准确或错误，在法律允许的最大范围内，我们明确地排除对任何此类不准确或错误的责任。</li>
				<li>您使用本网站上的任何信息或材料的风险完全由您自己承担，我们对此不承担任何责任。您应自行负责确保通过本网站提供的任何产品、服务或信息符合您的具体要求。</li>
				<li>本网站包含我们被授权发布的材料。这些材料包括但不限于设计、布局、外观和图形。除按照每个产品上指定的版权和许可外，禁止复制。</li>
				<li>ScriptureEarth上的所有其他名称、标识、产品和服务名称、设计和口号都是其各自所有者的商标。</li>
				<li>未经授权使用本网站可能会引起索赔和/或成为刑事控诉。</li>
				<li>本网站包括其他网站的链接是为了方便您提供进一步的信息。它们并不表示我们认可这些网站。我们对链接网站的内容不承担任何责任。</li>
			</ul>
		<?php
			break;
		case "P":
		?>
			<script type="text/javascript" language="javascript">
				document.title = "隐私政策";
			</script>
			<h2>隐私政策</h2>
			<p>ScriptureEarth不使用 "cookie "技术。因此，本网站不会跟踪用户或使用模式。</p>
			<h3>收集和使用个人信息</h3>
			<p>当你浏览本网站我们不会收集你的个人信息，除非你自愿提供这些信息。如果您提供了您的邮政或电子邮件地址，您将只收到您所提供的地址的信息。</p>
			<p>如有需要，个人信息可能会被转发给SIL国际的合作伙伴组织，以便对您的请求或意见作出回应。</p>
			<p>如果您通过本网站提供非公开的个人信息（如姓名、地址、电子邮件地址或电话号码），SIL国际公司将只将这些信息用于收集信息的页面上所述的目的。</p>
			<p>SIL国际公司不发送未经请求的或 "垃圾邮件"，也不向第三方出售、出租或交易其电子邮件名单。</p>
			<p>在所有情况下，如果需要，我们将按照适用的法律和法规披露信息。</p>
			<h3>链接</h3>
			<p>ScriptureEarth包含其他网站的链接。这些链接为你提供了相关的资源。链接到一个文件或网站并不一定意味着SIL国际会:</p>
			<ul>
				<li>认可提供这些链接的组织或个人。</li>
				<li>同意其表达的观点，或</li>
				<li>证明其内容的正确性、事实性、适当性或合法性。</li>
			</ul>
			<p>SIL国际也不对这些网站的隐私政策或做法负责。</p>
		<?php
			break;
		case "H":
		?>
			<script type="text/javascript" language="javascript">
				document.title = "帮助";
			</script>
			<h2>帮助</h2>
			<p>
				下图显示如何使用主页来寻找一种特定的语言。
				每当用户在其中一个搜索框中输入或选择 \"按国家列出 \"时，会出现一个或多个选择。可以从列表中选择所需的项目。
			</p>
			<div style="text-align: center; margin-right: auto; margin-left: auto; margin-top: 30px; margin-bottom: 40px; ">
				<img src='./images/00cmn-AboutExplanation.jpg' style='height: 80%; width: 80%; ' />
			</div>
		<?php
			break;
		case "CU":
		?>
			<script type="text/javascript" language="javascript">
				document.title = "链接";
			</script>
			<!-- h2>链接</h2 -->
			<br />

			<div class='clearfix' style='margin-top: 30px; margin-bottom: 40px; margin-left: 5px; font-size: 120%; '>
				<div class='contacts'>
					<strong>如有问题或反馈，请联系。</strong><br />
					<img src='images/app-icon.jpg' alt="feedback" style='margin-bottom: -6px; ' width="32" height="32" />
					<a href="mailto:info&#64;ScriptureEarth.org">info&#64;ScriptureEarth.org</a><br /><br />
					<img src="./images/SILInternationalIcon.jpg" alt="SIL 国际" width="32" height="32" /><strong> SIL 国际</strong><br />
					<a href="https://www.sil.org/">www.sil.org</a>
				</div>
			</div>

			<hr>

			<h3>我们的一些合作事工</h3>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/FaithComesByHearingIcon.png" alt="信靠听从 / 和散那" width="32" /><strong>信靠听从 / 和散那</strong><br />
					<a href="https://www.faithcomesbyhearing.com/">https://www.faithcomesbyhearing.com</a>
				</div>
				<div class='contacts'>
					<img src="./images/JesusFilmMediaIcon.png" alt="耶稣电影媒体" width="32" height="32" /><strong> 耶稣电影媒体</strong><br />
					<a href="https://jesusfilmmedia.org/">https://jesusfilmmedia.org</a>
				</div>
			</div>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/GlobalRecordingsNetworkIcon.png" alt="全球录音网络" width="20" /><strong> 全球录音网络</strong><br />
					<a href="https://globalrecordings.net/en">https://globalrecordings.net/en</a>
				</div>
				<div class='contacts'>
					<img src="./images/YouVersionIcon.png" alt="你的版本(新国际圣经版本)" width="32" height="32" /><strong> 你的版本(新国际圣经版本)</strong><br />
					<a href="https://www.youversion.com/">https://www.youversion.com/</a>
				</div>
			</div>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/BiblicaIcon.png" alt="《圣经》(Biblica)" width="30" /><strong> 《圣经》(Biblica)</strong><br />
					<a href="https://www.biblica.com/">https://www.biblica.com/</a>
				</div>
				<div class='contacts'>
					<img src="./images/Find.Bible.jpg" alt="寻找圣经" width="30" height="30" /><strong> 寻找圣经</strong><br />
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

			<h3>威克里夫</h3>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/WycliffeGlobalAllianceIcon.png" alt="威克里夫全球联盟" width="32" height="32" /><strong> 威克里夫全球联盟</strong><br />
					<a href="https://www.wycliffe.net">https://www.wycliffe.net</a>
				</div>
			</div>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/WycliffeUSAIcon.png" alt="美国威克里夫" width="50" /><strong> 美国威克里夫</strong><br />
					<a href="https://www.wycliffe.org/">https://www.wycliffe.org/</a>
				</div>
				<div class='contacts'>
					<br />
					<img src="./images/WycliffeUKIcon.png" alt="英国威克里夫" width="30" /><strong> 英国威克里夫</strong><br />
					<a href="https://www.wycliffe.org.uk/">https://www.wycliffe.org.uk/</a>
				</div>
			</div>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/WycliffeCanadaIcon.png" alt="加拿大威克里夫" width="32" height="32" /><strong>加拿大威克里夫</strong><br />
					<a href="https://www.wycliffe.ca">https://www.wycliffe.ca</a>
				</div>
				<div class='contacts'>
					<img src="./images/WycliffeAustraliaIcon.png" alt="澳大利亚威克里夫" width="32" height="32" /><strong> 澳大利亚威克里夫</strong><br />
					<a href="https://wycliffe.org.au">https://wycliffe.org.au</a>
				</div>
			</div>

			<h3>圣经协会</h3>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/AmericanBibleSocietyIcon.png" alt="美国圣经协会" width="32" /><strong> 美国圣经协会</strong><br />
					<a href="https://www.americanbible.org/">https://www.americanbible.org</a>
				</div>
				<div class='contacts'>
					<img src="./images/CanadianBibleSocietyIcon.png" alt="加拿大圣经协会" width="32" height="31" /><strong> 加拿大圣经协会</strong><br />
					<a href="https://www.biblesociety.ca/">https://www.biblesociety.ca</a>
				</div>
			</div>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/BibleSocietyOfBrazilIcon.png" alt="巴西圣经协会" width="32" height="32" /><strong> 巴西圣经协会</strong><br />
					<a href="https://sbb.org.br/">https://sbb.org.br/</a>
				</div>
			</div>

			<h3>圣经联盟</h3>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/LaLegaBiblicaIcon.png" alt="墨西哥圣经联盟" height="32" /><strong> 墨西哥圣经联盟</strong><br />
					<a href="https://www.laligabiblica.org.mx">https://www.laligabiblica.org.mx</a>
				</div>
				<div class='contacts'>
					<img src="./images/BibleLeagueUSAIcon.png" alt="圣经联盟(美国)" width="32" height="32" /><strong>圣经联盟(美国)</strong><br />
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