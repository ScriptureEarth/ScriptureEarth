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
		echo "<img src='images/00cmn-ScriptureEarth_header.jpg' style='position: relative; top: 0px; z-index: 1; width: 30%;' />";
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
<h2>版权</h2>
<p>© <?php echo date('Y'); ?> SIL国际</p>
<p>该ScriptureEarth.org 网站由SIL国际管理。 其贡献组织在每个产品上注明了个人版权和许可信息。</p>
<?php
			break;
		case "TC":
?>
<script type="text/javascript" language="javascript">
	document.title = "Terms and Conditions";
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
	document.title = "Privacy Policy";
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
	document.title = "Help";
</script>
<h2>帮助</h2>
<p style="margin-bottom: -15px; "><strong>首选浏览器:</strong></p>
<ul type="disc">
	<li>Firefox</li>
	<li>Chrome</li>
	<li>Opera</li>
	<li>Internet Explorer</li>
</ul>
<p style="margin-bottom: -15px; "><strong>本网站有潜在问题的浏览器:</strong></p>
<ul type="disc">
	<li>Safari（某些功能需要允许弹出窗口。)</li>
</ul>
<?php
			break;
		case "CU":
?>
<script type="text/javascript" language="javascript">
	document.title = "Contact/Links";
</script>
<h2 style='margin-left: 0; '>联系/链接</h2>
<div style='margin-top: 30px; margin-bottom: 40px; margin-left: 5px; font-size: 120%; '>
	<div>
    <strong><span id="docs-internal-guid-bc86aad7-7fff-a134-23aa-11e47547ca1a"><img src="https://lh3.googleusercontent.com/FX0TXNvzTLQ4ZZ5r8fQM24RFe_aghVg1EvAUvKA6Y-GHYu2W_PoGENclOwVMRyaRutJW2jdiQfxcOhK2mAEEI1X2O4zKlvETN5fVjEtjCEI0QB_BJyNenxPdneuWnvciopicVmCw" alt="SIL International" width="32" height="32" /></span> SIL 国际</strong><br />
		<a href="https://www.sil.org/">www.sil.org</a><br />
		如有问题或反馈，请联系。<br />
    	<a href="mailto:info&#64;ScriptureEarth.org">info&#64;ScriptureEarth.org</a>
    </div>
</div>

<hr>

<h3 style='margin-top: 30px; margin-left: 0; '>我们的一些合作事工</h3>

<div class='clearfix'>
    <div class='contacts'>
      <strong><span id="docs-internal-guid-20da3ac7-7fff-3a3f-83b7-0669ad24e42d"><img src="https://lh3.googleusercontent.com/IU4KXtCaasavRkLvdD9U8B1t7cQhu5rBPUwGOl478-pgTqWyxHD3OK0n7_YyUHVKaG9t3ETWnWXE_H2t7028NhtPJ5eYWVwcmfj4h-WfKMv3wjkUpSyHNc1kQaUVQZwjE5jEkKyn" alt="Fath Comes By Hearing" width="32" height="32" /></span>信靠听从 / 和散那</strong><br />
        <a href="https://www.faithcomesbyhearing.com/">https://www.faithcomesbyhearing.com</a>
    </div>
    <div class='contacts'>
      <strong><span id="docs-internal-guid-eea2892e-7fff-27ea-cc30-72d01eb1a879"><img src="https://lh4.googleusercontent.com/1x5jphztN6V7Nr_lgsDR__X-bZ5z685pwhr0y_1yqAn_T4Xv9bOLxpGQti7tueeU8_lRthECNH-f_5KHIcwUsWWJ8iaJXHPOIwqtpOo7YK8y0-VE0QU5bpMozOKWyAq2AnrbLQL0" alt="Jesus Film Media" width="32" height="32" /></span> 耶稣电影媒体</strong><br />
        <a href="https://jesusfilmmedia.org/">https://jesusfilmmedia.org</a>
    </div>
</div>

<div class='clearfix'>
    <div class='contacts'>
      <strong><span id="docs-internal-guid-76877d7e-7fff-a9c9-9380-5b362591d0b4"><img src="https://lh4.googleusercontent.com/ndDblEivE6ozAW6FSijVOPVwdkqbKKNA8W2nvqmfNjOJq1JDI_DFCvjijy6wPd_2bBtKKoFOONKWYMbKp80f-VmAAIU3yZy-avTTehy6O3lUPeDakcEvYGwfjrbManZSXvj9BLz4" alt="Global Recording Network" width="16" height="16" /></span> 全球录音网络</strong><br />
		<a href="https://globalrecordings.net/en">https://globalrecordings.net/en</a>
    </div>
    <div class='contacts'>
      <strong><span id="docs-internal-guid-e302363c-7fff-7417-822a-804f73a094f2"><img src="https://lh4.googleusercontent.com/4yfU8AzOJIBRMgiDDsM2QsvB4z8HTLRqvX6vLJxNA0ridGfSKL-06MHGzOe-UsApHwCMEfkXNaqSmzF9TrFr0lmGtnLvK5G5pGa1dqPUeNTmckoncJN_oc-OqlCf6-Ud0PgTXPmN" alt="YouVersion" width="32" height="32" /></span> 你的版本(新国际圣经版本)</strong><br />
        <a href="https://www.youversion.com/">https://www.youversion.com/</a>
	</div>
</div>

<div class='clearfix'>
    <div class='contacts'>
      <strong><span id="docs-internal-guid-e772ecae-7fff-e0f8-9212-f273d3257f9d"><img src="https://lh5.googleusercontent.com/8hDCv_re5i2j6Y-E3uItGwbt8fEPdZVltJZ3CaFXd5Y2oF3lXwLjC_dNPpy3-e7VwCD0TCR4nRIQzLEOrFigguYb7nC9wt-DYfrw6Uiu1nZfcUTdk44wv9R8e5hOJMSb8tvT-SKf" alt="Biblica" width="16" height="16" /></span>《圣经》(Biblica)</strong><br />
		<a href="https://www.biblica.com/">https://www.biblica.com/</a>
    </div>
    <div class='contacts'>
      <strong><img src="./images/Find.Bible.jpg" alt="Find a Bible" width="30" height="30" /> 寻找圣经</strong><br />
        <a href="https://find.bible/">https://find.bible/</a>
	</div>
</div>

<p>Wycliffe</p>

<div class='clearfix'>
    <div class='contacts'>
      <strong><span id="docs-internal-guid-4b027175-7fff-6f34-cc1d-5a5b499a7416"><img src="https://lh5.googleusercontent.com/dJeED-jZKLjNC5hlGuHGZrYflhLF-gO51BpeV664YT32QYxtYovr-ceCc7P6KNGZdjglEz6eD4D1PmoDTPcR1HzxkGgIXzfSCAf84bNXBi1boEo4ordozz_Hmwv5uWIO7mMyLW2U" alt="Wycliffe Global Alliance" width="32" height="32" /></span> 威克里夫全球联盟</strong><br />
		<a href="https://www.wycliffe.net">https://www.wycliffe.net</a>
    </div>
    <div class='contacts'>
        <strong>&nbsp;</strong><br />
        &nbsp;
	</div>
</div>

<div class='clearfix'>
    <div class='contacts'>
      <strong><span id="docs-internal-guid-30839761-7fff-e970-6ad4-c9a2d4997197"><img src="https://lh4.googleusercontent.com/qSUDwTM4rWxSFbXzhUj4_JtCtS_5Qv0MNXn9xpBrUBcSM2z4q3ZJ1KYNSTJ6BQn7uMopfxY8hWgh1JY9OQOZlc85WFB01JNU14Lkp0nylsXJXBK_Ks-0cPo4b5jPtzS1bTfBpOgG" alt="Wycliffe USA" width="32" height="32" /></span> 美国威克里夫</strong><br />
		<a href="https://www.wycliffe.org/">https://www.wycliffe.org/</a>
    </div>
    <div class='contacts'>
      <strong><span id="docs-internal-guid-ede0800a-7fff-5e04-4ea0-78399096fe38"><img src="https://lh6.googleusercontent.com/rb8KYiNpurOliu5g5MOg3Pu21GrIMy2LeLJByPV4idEhBmJ2r79L9_5y3XgMyA_2umXVBIXRMbHYBrBbqdi6SxFFX3eZ0L6S_A6ojWB-LNqEK4mG_rHBZqo6XPoZq11Yir8ihBrg" alt="Wycliffe UK" width="32" height="32" /></span> 英国威克里夫</strong><br />
        <a href="https://www.wycliffe.org.uk/">https://www.wycliffe.org.uk/</a>
    </div>
</div>

<div class='clearfix'>
    <div class='contacts'>
      <strong><span id="docs-internal-guid-acf6fd9d-7fff-be5e-a9e3-b6c8188ef4f3"><img src="https://lh6.googleusercontent.com/P-Ygrtq0d4is2FSzSxzhiLo3mgd3T9EbLViUVPC7pRBlCA308HLUIDGCgWfT5mNERST2gmwzGxW19dtqqOB9iDMNekQm6MtRVTLWrb5K3ilzI2GLRGgEd7_AmMxatRODOHkAhzSu" alt="Wycliffe Canada" width="32" height="32" /></span>加拿大威克里夫</strong><br />
        <a href="https://www.wycliffe.ca">https://www.wycliffe.ca</a>
    </div>
	<div class='contacts'>
      <strong><span id="docs-internal-guid-447e80c3-7fff-2233-1892-b2a1350bb4b5"><img src="https://lh4.googleusercontent.com/YpAcZXVJesIGXgtlUW46nKjmikue66X3mauioNX_TYVmIEE8AROvobwaqOVo8c1tph0xlxWnpsE8N_S5t2W0rxd7y4h1x1hJC8gMHwF8Lij1tgfx3NjGWkkb8TjjeLmjm-mhLpL6" alt="Wycliffe Australia" width="32" height="32" /></span> 澳大利亚威克里夫</strong><br />
        <a href="https://wycliffe.org.au">https://wycliffe.org.au</a>
	</div>
</div>

<p>圣经协会</p>

<div class='clearfix'>
    <div class='contacts'>
      <strong><span id="docs-internal-guid-2df4f828-7fff-cccf-0d06-0ab94afef10f"><img src="https://lh5.googleusercontent.com/DsS__7UVIGJO6cIb8omTlM_UuZ87opWpWgUvofk33YCPFWOBAq4bHN4N-eLAee1Uyl2eBDr_J1Z49OqY4G_HUDBOfmLWudlfqG0xBdpHmwXDRK9dLnVP-MyprV0q2iQmqhtcNwGA" alt="Amercain Bible Society" width="16" height="16" /></span> 美国圣经协会</strong><br />
        <a href="https://www.americanbible.org/">https://www.americanbible.org</a>
    </div>
    <div class='contacts'>
      <strong><span id="docs-internal-guid-c18192e7-7fff-3341-9439-36849227e2bf"><img src="https://lh3.googleusercontent.com/85PmYxqksM0C8XtbN2k4M5GJxZRmje1fZY34dJ6KaccC7E-JkHnEHQqsFn5l-_dse8KJBJkKQIa0E8OC_RTd8X4VJAYJJgD34fF23hIAqdbZTdMQHyAW6xoUWvEuPVxbd2unEKI7" alt="Canadian Bible Society" width="32" height="31" /></span> 加拿大圣经协会</strong><br />
        <a href="https://www.biblesociety.ca/">https://www.biblesociety.ca</a>
    </div>
</div>

<div class='clearfix'>
    <div class='contacts'>
      <strong><span id="docs-internal-guid-d24ff859-7fff-e1d3-e58d-b8aaaa6ac83b"><img src="https://lh3.googleusercontent.com/lCR5veYj-iNSurfS_LLlABpFeNh6LdKL6cC9C51mb7F64P-yBoFDe8puJTqA2fBLNYTZpy8xXEfVPmJuqVTHYyxYXYgln8q9-YrywNbHSiYLYBAGK080O7Uocxcs5mOP7xd7GLCW" alt="Bible Society of Brazil" width="32" height="32" /></span>巴西圣经协会</strong><br />
        <a href="https://sbb.org.br/">https://sbb.org.br/</a>
    </div>
    <div class='contacts'>
        <strong>&nbsp;</strong><br />
        &nbsp;
	</div>
</div>

<p>圣经联盟</p>

<div class='clearfix'>
    <div class='contacts'>
        <strong>墨西哥圣经联盟</strong><br />
        <a href="https://www.laligabiblica.org.mx">https://www.laligabiblica.org.mx</a>
    </div>
    <div class='contacts'>
      <strong><span id="docs-internal-guid-fa181c87-7fff-6e3e-99bf-ea69193a27d0"><img src="https://lh5.googleusercontent.com/BNpZGBWoDZzlPXBN02U7h9xIH_MwZBQxy9WuydrfEt6l7xlYyIzzI359hcV6EQqmeZKiFmPcV4gPSFJUAaUscJyto9P6-AOaueP8oBrI44pfQx7d-uxS0UkJf2mYGvxldpQ7yyAJ" alt="Bible League (USA)" width="32" height="32" /></span>圣经联盟(美国)</strong><br />
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
