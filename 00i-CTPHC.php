<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" 			content="text/html; charset=utf-8" />
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
	font-size: 120%;
}
td p {
	margin: 20px 0 0 0;
}
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
	/*background-image: url(images/background_top.png);
	background-repeat: repeat-x;*/
}
div.container {
	width: 90%;  /* using 20px less than a full 800px width allows for browser chrome and avoids a horizontal scroll bar */
	background-color: white;
	margin: 0 auto 0 auto; /* the auto margins (in conjunction with a width) center the page */
	padding-bottom: -20px;
	text-align: left; /* this overrides the text-align: center on the body element. */
	/*border-top: solid 2px black;
	border-left: solid 2px black;
	border-right: solid 2px black;*/
}
</style>
<script type="text/javascript" language="javascript" src="_js/jquery-1.3.2.js"></script>
</head>
<body>
<?php
	/* variables of 00z-CTHC.php:
		'i', 'e', 'p', 'f', 'd', or 'de'" the major language
		'I': 'CR', 'TC', 'P', 'H', and 'CU': section to be display
		'Window': 'Window', 'I'm not sure what this is': this is always 'Window''
	*/
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
		echo "<img src='images/00eng-ScriptureEarth_header.jpg' style='position: relative; top: 0px; z-index: 1; width: 30%;' />";
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
<p>The <em>ScriptureEarth.org</em> website is managed by SIL International. Individual copyright and licensing information is indicated on each product by its contributing organization.</p>
<?php
			break;
		case "TC":
?>
<script type="text/javascript" language="javascript">
	document.title = "Terms and Conditions";
</script>
<h2>Terms and Conditions</h2>
<p>Welcome to our website. If you continue to browse and use this website, you are agreeing to comply with and be bound by the following terms and conditions of use which, together with our privacy policy, govern SIL International’s relationship with you in relation to this website. If you disagree with any part of these terms and conditions, please do not use our website.</p>
<p>The term ‘SIL International’ or ‘us’ or ‘we’ refers to the owner of the website whose registered office is 7500 West Camp Wisdom Road, Dallas TX.</p>
<p>The terms ‘you’ and ‘your’ refer to the user or viewer of our website.</p>
<p>When you use this website you agree to the following terms of use:</p>
<ul>
<li>The content of the pages of this website is for your general information and use only. It is subject to change without notice.</li>
<li>Neither we nor any third parties provide any warranty or guarantee as to the accuracy, timeliness, performance, completeness or suitability of the information and materials found or offered on this website for any particular purpose. You acknowledge that such information and materials may contain inaccuracies or errors and we expressly exclude liability for any such inaccuracies or errors to the fullest extent permitted by law.</li>
<li>Your use of any information or materials on this website is entirely at your own risk, for which we shall not be liable. It shall be your own responsibility to ensure that any products, services or information available through this website meet your specific requirements.</li>
<li>This website contains material which we are authorized to post. This material includes, but is not limited to, the design, layout, look, appearance and graphics. Reproduction is prohibited other than in accordance with the copyright  and licensing designated on each product.</li>
<li>All other names, logos, product and service names, designs, and slogans on ScriptureEarth  are the trademarks of their respective owners.</li>
<li>Unauthorised use of this website may give rise to a claim for damages and/or be a criminal offence.</li>
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
<p>When you browse this site or contact Wycliffe Canada via this site, we will not collect personal information about you unless you provide that information voluntarily. If you supply your postal or email address, you will receive only the information for which you provided the address.</p>
<p>Where required, personal information may be forwarded to SIL International’s partner organizations in order to provide a response to your request or comments.</p>
<p>If you provide non-public personal information (such as a name, address, email address or telephone number) via this site, SIL International will only use such information for the purpose stated on the page where it is collected.</p>
<p>SIL International does not send unsolicited or &ldquo;spam&rdquo; email and does not sell, rent, or trade its email lists to third parties.</p>
<p>In all cases, we will disclose information consistent with applicable laws and regulations if required.</p>
<h3>Links</h3>
<p>ScriptureEarth contains links to other websites. These links provide you with relevant resources. A link to a document or site does not necessarily imply that SIL International:</p>
<ul>
 <li>endorses the organization(s) or person(s) providing them,</li>
 <li>agrees with the ideas expressed, or</li>
 <li>attests to the correctness, factuality, appropriateness, or legality of the contents.</li>
</ul>
<p>SIL International is also not responsible for the privacy policies or practices of these websites.</p>
<?php
			break;
		case "H":
?>
<script type="text/javascript" language="javascript">
	document.title = "Help";
</script>
<h2>Help</h2>
<p style="margin-bottom: -15px; "><strong>Preferred Browsers:</strong></p>
<ul type="disc">
	<li>Firefox</li>
	<li>Chrome</li>
	<li>Opera</li>
	<li>Internet Explorer</li>
</ul>
<p style="margin-bottom: -15px; "><strong>Browsers with potential problems for this site:</strong></p>
<ul type="disc">
	<li>Safari (Some functions require that pop-up windows be allowed.)</li>
</ul>
<?php
			break;
		case "CU":
?>
<script type="text/javascript" language="javascript">
	document.title = "Contact/Links";
</script>
<h2 style='margin-left: 0; '>Contact/Links</h2>
<div style='margin-top: 30px; margin-bottom: 40px; margin-left: 5px; font-size: 120%; '>
	<div>
    <strong><span id="docs-internal-guid-bc86aad7-7fff-a134-23aa-11e47547ca1a"><img src="https://lh3.googleusercontent.com/FX0TXNvzTLQ4ZZ5r8fQM24RFe_aghVg1EvAUvKA6Y-GHYu2W_PoGENclOwVMRyaRutJW2jdiQfxcOhK2mAEEI1X2O4zKlvETN5fVjEtjCEI0QB_BJyNenxPdneuWnvciopicVmCw" alt="SIL International" width="32" height="32" /></span> SIL International</strong><br />
		<a href="https://www.sil.org/">www.sil.org</a><br />
		For questions or to give feedback contact:<br />
    	<a href="mailto:info&#64;ScriptureEarth.org">info&#64;ScriptureEarth.org</a>
    </div>
</div>

<hr>

<h3 style='margin-top: 30px; margin-left: 0; '>Some of our Collaborators</h3>

<div class='clearfix'>
    <div class='contacts'>
      <strong><span id="docs-internal-guid-20da3ac7-7fff-3a3f-83b7-0669ad24e42d"><img src="https://lh3.googleusercontent.com/IU4KXtCaasavRkLvdD9U8B1t7cQhu5rBPUwGOl478-pgTqWyxHD3OK0n7_YyUHVKaG9t3ETWnWXE_H2t7028NhtPJ5eYWVwcmfj4h-WfKMv3wjkUpSyHNc1kQaUVQZwjE5jEkKyn" alt="Fath Comes By Hearing" width="32" height="32" /></span>Faith Comes By Hearing / Hosanna</strong><br />
        <a href="https://www.faithcomesbyhearing.com/">https://www.faithcomesbyhearing.com</a>
    </div>
    <div class='contacts'>
      <strong><span id="docs-internal-guid-eea2892e-7fff-27ea-cc30-72d01eb1a879"><img src="https://lh4.googleusercontent.com/1x5jphztN6V7Nr_lgsDR__X-bZ5z685pwhr0y_1yqAn_T4Xv9bOLxpGQti7tueeU8_lRthECNH-f_5KHIcwUsWWJ8iaJXHPOIwqtpOo7YK8y0-VE0QU5bpMozOKWyAq2AnrbLQL0" alt="Jesus Film Media" width="32" height="32" /></span> Jesus Film Media</strong><br />
        <a href="https://jesusfilmmedia.org/">https://jesusfilmmedia.org</a>
    </div>
</div>

<div class='clearfix'>
    <div class='contacts'>
      <strong><span id="docs-internal-guid-76877d7e-7fff-a9c9-9380-5b362591d0b4"><img src="https://lh4.googleusercontent.com/ndDblEivE6ozAW6FSijVOPVwdkqbKKNA8W2nvqmfNjOJq1JDI_DFCvjijy6wPd_2bBtKKoFOONKWYMbKp80f-VmAAIU3yZy-avTTehy6O3lUPeDakcEvYGwfjrbManZSXvj9BLz4" alt="Global Recording Network" width="16" height="16" /></span> Global Recordings Network</strong><br />
		<a href="https://globalrecordings.net/en">https://globalrecordings.net/en</a>
    </div>
    <div class='contacts'>
      <strong><span id="docs-internal-guid-e302363c-7fff-7417-822a-804f73a094f2"><img src="https://lh4.googleusercontent.com/4yfU8AzOJIBRMgiDDsM2QsvB4z8HTLRqvX6vLJxNA0ridGfSKL-06MHGzOe-UsApHwCMEfkXNaqSmzF9TrFr0lmGtnLvK5G5pGa1dqPUeNTmckoncJN_oc-OqlCf6-Ud0PgTXPmN" alt="YouVersion" width="32" height="32" /></span> YouVersion</strong><br />
        <a href="https://www.youversion.com/">https://www.youversion.com/</a>
	</div>
</div>

<div class='clearfix'>
    <div class='contacts'>
      <strong><span id="docs-internal-guid-e772ecae-7fff-e0f8-9212-f273d3257f9d"><img src="https://lh5.googleusercontent.com/8hDCv_re5i2j6Y-E3uItGwbt8fEPdZVltJZ3CaFXd5Y2oF3lXwLjC_dNPpy3-e7VwCD0TCR4nRIQzLEOrFigguYb7nC9wt-DYfrw6Uiu1nZfcUTdk44wv9R8e5hOJMSb8tvT-SKf" alt="Biblica" width="16" height="16" /></span>Biblica</strong><br />
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
      <strong><span id="docs-internal-guid-4b027175-7fff-6f34-cc1d-5a5b499a7416"><img src="https://lh5.googleusercontent.com/dJeED-jZKLjNC5hlGuHGZrYflhLF-gO51BpeV664YT32QYxtYovr-ceCc7P6KNGZdjglEz6eD4D1PmoDTPcR1HzxkGgIXzfSCAf84bNXBi1boEo4ordozz_Hmwv5uWIO7mMyLW2U" alt="Wycliffe Global Alliance" width="32" height="32" /></span> Wycliffe Global Alliance</strong><br />
		<a href="https://www.wycliffe.net">https://www.wycliffe.net</a>
    </div>
    <div class='contacts'>
        <strong>&nbsp;</strong><br />
        &nbsp;
	</div>
</div>

<div class='clearfix'>
    <div class='contacts'>
      <strong><span id="docs-internal-guid-30839761-7fff-e970-6ad4-c9a2d4997197"><img src="https://lh4.googleusercontent.com/qSUDwTM4rWxSFbXzhUj4_JtCtS_5Qv0MNXn9xpBrUBcSM2z4q3ZJ1KYNSTJ6BQn7uMopfxY8hWgh1JY9OQOZlc85WFB01JNU14Lkp0nylsXJXBK_Ks-0cPo4b5jPtzS1bTfBpOgG" alt="Wycliffe USA" width="32" height="32" /></span> Wycliffe USA</strong><br />
		<a href="https://www.wycliffe.org/">https://www.wycliffe.org/</a>
    </div>
    <div class='contacts'>
      <strong><span id="docs-internal-guid-ede0800a-7fff-5e04-4ea0-78399096fe38"><img src="https://lh6.googleusercontent.com/rb8KYiNpurOliu5g5MOg3Pu21GrIMy2LeLJByPV4idEhBmJ2r79L9_5y3XgMyA_2umXVBIXRMbHYBrBbqdi6SxFFX3eZ0L6S_A6ojWB-LNqEK4mG_rHBZqo6XPoZq11Yir8ihBrg" alt="Wycliffe UK" width="32" height="32" /></span> Wycliffe UK</strong><br />
        <a href="https://www.wycliffe.org.uk/">https://www.wycliffe.org.uk/</a>
    </div>
</div>

<div class='clearfix'>
    <div class='contacts'>
      <strong><span id="docs-internal-guid-acf6fd9d-7fff-be5e-a9e3-b6c8188ef4f3"><img src="https://lh6.googleusercontent.com/P-Ygrtq0d4is2FSzSxzhiLo3mgd3T9EbLViUVPC7pRBlCA308HLUIDGCgWfT5mNERST2gmwzGxW19dtqqOB9iDMNekQm6MtRVTLWrb5K3ilzI2GLRGgEd7_AmMxatRODOHkAhzSu" alt="Wycliffe Canada" width="32" height="32" /></span>Wycliffe Canada</strong><br />
        <a href="https://www.wycliffe.ca">https://www.wycliffe.ca</a>
    </div>
	<div class='contacts'>
      <strong><span id="docs-internal-guid-447e80c3-7fff-2233-1892-b2a1350bb4b5"><img src="https://lh4.googleusercontent.com/YpAcZXVJesIGXgtlUW46nKjmikue66X3mauioNX_TYVmIEE8AROvobwaqOVo8c1tph0xlxWnpsE8N_S5t2W0rxd7y4h1x1hJC8gMHwF8Lij1tgfx3NjGWkkb8TjjeLmjm-mhLpL6" alt="Wycliffe Australia" width="32" height="32" /></span> Wycliffe Australia</strong><br />
        <a href="https://wycliffe.org.au">https://wycliffe.org.au</a>
	</div>
</div>

<p>Bible Societies</p>

<div class='clearfix'>
    <div class='contacts'>
      <strong><span id="docs-internal-guid-2df4f828-7fff-cccf-0d06-0ab94afef10f"><img src="https://lh5.googleusercontent.com/DsS__7UVIGJO6cIb8omTlM_UuZ87opWpWgUvofk33YCPFWOBAq4bHN4N-eLAee1Uyl2eBDr_J1Z49OqY4G_HUDBOfmLWudlfqG0xBdpHmwXDRK9dLnVP-MyprV0q2iQmqhtcNwGA" alt="Amercain Bible Society" width="16" height="16" /></span> American Bible Society</strong><br />
        <a href="https://www.americanbible.org/">https://www.americanbible.org</a>
    </div>
    <div class='contacts'>
      <strong><span id="docs-internal-guid-c18192e7-7fff-3341-9439-36849227e2bf"><img src="https://lh3.googleusercontent.com/85PmYxqksM0C8XtbN2k4M5GJxZRmje1fZY34dJ6KaccC7E-JkHnEHQqsFn5l-_dse8KJBJkKQIa0E8OC_RTd8X4VJAYJJgD34fF23hIAqdbZTdMQHyAW6xoUWvEuPVxbd2unEKI7" alt="Canadian Bible Society" width="32" height="31" /></span> Canadian Bible Society</strong><br />
        <a href="https://www.biblesociety.ca/">https://www.biblesociety.ca</a>
    </div>
</div>

<div class='clearfix'>
    <div class='contacts'>
      <strong><span id="docs-internal-guid-d24ff859-7fff-e1d3-e58d-b8aaaa6ac83b"><img src="https://lh3.googleusercontent.com/lCR5veYj-iNSurfS_LLlABpFeNh6LdKL6cC9C51mb7F64P-yBoFDe8puJTqA2fBLNYTZpy8xXEfVPmJuqVTHYyxYXYgln8q9-YrywNbHSiYLYBAGK080O7Uocxcs5mOP7xd7GLCW" alt="Bible Society of Brazil" width="32" height="32" /></span>Bible Society of Brazil</strong><br />
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
      <strong><span id="docs-internal-guid-fa181c87-7fff-6e3e-99bf-ea69193a27d0"><img src="https://lh5.googleusercontent.com/BNpZGBWoDZzlPXBN02U7h9xIH_MwZBQxy9WuydrfEt6l7xlYyIzzI359hcV6EQqmeZKiFmPcV4gPSFJUAaUscJyto9P6-AOaueP8oBrI44pfQx7d-uxS0UkJf2mYGvxldpQ7yyAJ" alt="Bible League (USA)" width="32" height="32" /></span>Bible League (USA)</strong><br />
        <a href="https://www.bibleleague.org/">https://www.bibleleague.org</a>
    </div>
</div>

<!--div class='clearfix'>
    <div class='contacts'>
        <strong>United Bible Society</strong><br />
        <a href="https://www.unitedbiblesocieties.org/">https://www.unitedbiblesocieties.org/</a>
    </div>
    <div class='contacts'>
        <strong>Find-A-Bible</strong><br />
        <a href="https://find.bible">https://find.bible</a>
    </div>
</div>

<div class='clearfix'>
    <div class='contacts'>
        <strong>Forum of Bible Agencies</strong><br />
        <a href="https://forum-intl.org/">https://forum-intl.org/</a>
    </div>
    <div class='contacts'>
        <strong>Bibles in Your Language</strong><br />
        <a href="http://www.ethnicharvest.org/bibles/">http://www.ethnicharvest.org/bibles/</a><br /><br /><br /><br />
        <strong>MegaVoice</strong><br />
        <a href="https://www.megavoice.com/">https://www.megavoice.com</a>
    </div>
</div>

<div class='clearfix'>
    <div class='contacts'>
        <strong>Ethnologue</strong><br />
        ScriptureEarth.org draws most of its information about alternate language names from the Ethnologue.<br />
        SIL International Publications<br />
        <a href="https://www.ethnologue.com/">https://www.ethnologue.com</a>
    </div>
    <div class='contacts'>&nbsp;
    </div>
</div-->

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
