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

	//echo '<div style="text-align: center; width: 100%; background-color: black; ">';
	//echo "<img src='images/00eng-ScriptureEarth_header.jpg' style='position: relative; top: 0px; z-index: 1; width: 50%;' />";
	//echo '</div>';

	switch ($CTPHC) {
		case "CR":
		?>
			<script type="text/javascript" language="javascript">
				document.title = "Copyright";
			</script>
			<h2>Copyright</h2>
			<p>© <?php echo date('Y'); ?> SIL Global</p>
			<p>The <em>ScriptureEarth.org</em> website is managed by SIL Global. SIL’s service with ethnolinguistic minority communities is motivated by the belief that all people are created in the image of God, and that languages and cultures are part of the richness of God's creation.</p>
			<p>The purpose of this site is to provide access to Scripture products for the languages of the world. Individual copyright and licensing information is indicated on each product by its contributing organization.</p>
			<p>Some of the media formats on ScriptureEarth's website include:
			<ul type="disc">
				<li>video</li>
				<li>audio</li>
				<li>text to read offline (PDFs)</li>
				<li>text to read online (sometimes with follow-along audio)</li>
				<li>mobile apps</li>
				<li>links to purchase printed Bibles and other resources</li>
			</ul>
			</p>
		<?php
			break;
		case "H":
		?>
			<script type="text/javascript" language="javascript">
				document.title = "Help";
			</script>
			<h2>Help</h2>
			<p>
				The graphic below shows how to use the home page to find a particular language.
				Whenever the user types in one of the search boxes or selects “List by Country” one or more choices will appear.
				The desired item can be selected from the list.
			</p>
			<div style="text-align: center; margin-right: auto; margin-left: auto; margin-top: 30px; margin-bottom: 40px; ">
				<img src='./images/00eng-helpExplanation.jpg' style='height: 90%; width: 90%; ' />
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
					<strong>For questions or to give feedback contact:</strong><br />
					<img src='./images/app-icon.jpg' alt="feedback" style='margin-bottom: -6px; ' width="32" height="32" />
					<a href="mailto:info&#64;ScriptureEarth.org">info&#64;ScriptureEarth.org</a><br /><br />
					<img src="./images/sil-icon.jpg" alt="SIL Global" width="32" height="32" /><strong> SIL Global</strong><br />
					<a href="https://www.sil.org/">www.sil.org</a>
				</div>
			</div>

			<hr>

			<h3>Some of our Collaborators</h3>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/FaithComesByHearingIcon.png" alt="Fath Comes By Hearing" width="32" /><strong>Faith Comes By Hearing / Hosanna / Bible.is</strong><br />
					<a href="https://www.faithcomesbyhearing.com/">https://www.faithcomesbyhearing.com</a>
				</div>
				<div class='contacts'>
					<img src="./images/JesusFilmMediaIcon.png" alt="Jesus Film Media" width="32" height="32" /><strong>&nbsp;Jesus Film Media</strong><br />
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
					<img src="./images/GlobalRecordingsNetworkIcon.png" alt="Global Recording Network" width="20" /><strong> Global Recordings Network</strong><br />
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
					<img src="./images/AmericanBibleSocietyIcon.png" alt="Amercain Bible Society" width="32" /><strong> American Bible Society</strong><br />
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
		case "TC":
		?>
			<script type="text/javascript" language="javascript">
				document.title = "Terms and Conditions";
			</script>
			<h2>Terms and Conditions</h2>
			<p>Welcome to our website. If you continue to browse and use this website, you are agreeing to comply with and be bound by the following terms and conditions of use which, together with our privacy policy, govern SIL Global’s relationship with you in relation to this website. If you disagree with any part of these terms and conditions, please do not use our website.</p>
			<p>The term ‘SIL Global’ or ‘us’ or ‘we’ refers to the owner of the website whose registered office is 7500 West Camp Wisdom Road, Dallas TX.</p>
			<p>The terms ‘you’ and ‘your’ refer to the user or viewer of our website.</p>
			<p>When you use this website you agree to the following terms of use:</p>
			<ul>
				<li>The content of the pages of this website is for your general information and use only. It is subject to change without notice.</li>
				<li>Neither we nor any third parties provide any warranty or guarantee as to the accuracy, timeliness, performance, completeness or suitability of the information and materials found or offered on this website for any particular purpose. You acknowledge that such information and materials may contain inaccuracies or errors and we expressly exclude liability for any such inaccuracies or errors to the fullest extent permitted by law.</li>
				<li>Your use of any information or materials on this website is entirely at your own risk, for which we shall not be liable. It shall be your own responsibility to ensure that any products, services or information available through this website meet your specific requirements.</li>
				<li>This website contains material which we are authorized to post. This material includes, but is not limited to, the design, layout, look, appearance and graphics. Reproduction is prohibited other than in accordance with the copyright and licensing designated on each product.</li>
				<li>All other names, logos, product and service names, designs, and slogans on ScriptureEarth are the trademarks of their respective owners.</li>
				<li>Unauthorized use of this website may give rise to a claim for damages and/or be a criminal offense.</li>
				<li>This website includes links to other websites. These links are provided for your convenience to provide further information. They do not signify that we endorse the website(s). We have no responsibility for the content of the linked website(s).</li>
			</ul>
		<?php
			break;
		case "P":
		?>
			<script type="text/javascript" language="javascript">
				document.title = "Privacy Policy";
			</script>
			<h2>Privacy Policy</h2>
			<p>ScriptureEarth does not use &ldquo;cookie&rdquo; technology. The site therefore does not track users or usage patterns.</p>
			<h3>Collecting and Using Personal Information</h3>
			<p>When you browse this site or contact SIL Global via this site, we will not collect personal information about you unless you provide that information voluntarily. If you supply your postal or email address, you will receive only the information for which you provided the address.</p>
			<p>Where required, personal information may be forwarded to SIL Global’s partner organizations in order to provide a response to your request or comments.</p>
			<p>If you provide non-public personal information (such as a name, address, email address or telephone number) via this site, SIL Global will only use such information for the purpose stated on the page where it is collected.</p>
			<p>SIL Global does not send unsolicited or &ldquo;spam&rdquo; email and does not sell, rent, or trade its email lists to third parties.</p>
			<p>In all cases, we will disclose information consistent with applicable laws and regulations if required.</p>
			<h3>Links</h3>
			<p>ScriptureEarth contains links to other websites. These links provide you with relevant resources. A link to a document or site does not necessarily imply that SIL Global:</p>
			<ul>
				<li>endorses the organization(s) or person(s) providing them,</li>
				<li>agrees with the ideas expressed, or</li>
				<li>attests to the correctness, factuality, appropriateness, or legality of the contents.</li>
			</ul>
			<p>SIL Global is also not responsible for the privacy policies or practices of these websites.</p>
	<?php
			break;
		default: 				// CR, TC, P, H and CU
			die("The 'item' is not found.</body></html>");
	}
	?>
</body>

</html>