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
			direction: rtl;
			float: right;
			width: 46%;
		}

		* {
			box-sizing: border-box;
		}

		body {
			direction: rtl;
			/*unicode-bidi: bidi-override;*/
			font: 100% 'Calibri', 'Gill Sans', 'Gill Sans MT', 'Trebuchet MS', sans-serif;
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
			margin-left: 5px;
			margin-right: 40px;
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
				document.title = "عن الموقع";
			</script>
			<h2>عن الموقع</h2>
			<p>© <?php echo date('Y'); ?> SIL Global</p>
			<p>يُدار موقع اسكريبتشر إيرث <em>ScriptureEarth.org</em> من قِبل مؤسسة خدمة إس آي إل إنترناشونال SIL Global. إن الإيمان بأن جميع البشر مخلوقون على صورة الله وأن جميع لغات العالم تمثل جزءًا من غنى خليقته هو العقيدة المُحركة لعمل هيئة SIL بين الأقليات العرقية الناطقة بلغة مختلفة.</p>
			<p>الغرض من هذا الموقع هو إتاحة منتجات الكتاب المقدس بلغات العالم. وقد أرفقنا بكل منتج حقوق الملكية الفكرية وتراخيص الاستعمال المزود من المؤسسة المسئولة عنه.</p>
			<p>من بين صيغ وسائط الإعلام المتاحة على موقع ScriptureEarth الإلكتروني:
			<ul type="disc">
				<li>فيديو</li>
				<li>تسجيل صوتي</li>
				<li>نص يمكن تنزيله للقراءة من دون إنترنت (صيغة PDF)</li>
				<li>نص للقراءة أثناء الاتصال بالإنترنت (يكون أحيانًا متزامنًا مع تسجيل صوتي يسهل متابعة النص)</li>
				<li>تطبيقات للأجهزة المحمولة</li>
				<li>روابط إلكترونية لشراء الكتب المقدسة وغيرها من المصادر المتاحة</li>
			</ul>
			</p>
		<?php
			break;
		case "H":
		?>
			<script type="text/javascript" language="javascript">
				document.title = "مساعدة";
			</script>
			<h2>مساعدة</h2>
			<p>
			يوضح الشكل التالي كيفية استعمال الصفحة الرئيسية للبحث عن لغة معينة. في كل مرة يبدأ المستخدم في الكتابة في أحد صناديق البحث أو يختار "عرض اللغات حسب الدولة" سيظهر اختيار أو عدة اختيارات حسب توفر اللغات المتطابقة مع كلمة البحث. يمكن اختيار اللغة من القائمة المعروضة.</p>			</p>
			<div style="text-align: center; margin-right: auto; margin-left: auto; margin-top: 30px; margin-bottom: 40px; ">
				<img src='./images/00arb-helpExplanation.jpg' style='height: 90%; width: 90%; ' />
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
					<strong>يرجى إرسال الأسئلة أو الآراء إلى:</strong><br />
					<img src='./images/app-icon.jpg' alt="feedback" style='margin-bottom: -6px; ' width="32" height="32" />
					<a href="mailto:info&#64;ScriptureEarth.org">info&#64;ScriptureEarth.org</a><br /><br />
					<img src="./images/sil-icon.jpg" alt="SIL Global" width="32" height="32" /><strong> SIL Global</strong><br />
					<a href="https://www.sil.org/">www.sil.org</a>
				</div>
			</div>

			<hr>

			<h3>من بين المساهمين بالمحتوى على موقعنا الإلكتروني:</h3>

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

			<h3>دور الكتاب المقدس</h3>

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

			<h3>مواقع إلكترونية أخرى</h3>

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
				document.title = "بنود وشروط";
			</script>
			<h2>بنود وشروط</h2>
			<p>نرحب بزيارتك لموقعنا. بمواصلتك تصفح الموقع واستعماله أنت توافق على التعهد بالالتزام ببنود وشروط الاستعمال التي، جنبًا إلى جنب مع سياسة الخصوصية، تحكم علاقة مؤسسة خدمة SIL Global بك كمستخدم لهذا الموقع. في حالة عدم الموافقة على أي جزء من البنود والشروط، فيرجى عدم استخدام الموقع.</p>
			<p>يشير مصطلح SIL Global أو "نحن" إلى مالك الموقع المُسجل مقره في 7500 West Camp Wisdom Road, Dallas TX.</p>
			<p>المقصود بضمير المخاطب هنا هو الشخص الذي يستخدم الموقع أو يتصفحه.</p>
			<p>باستخدامك لهذا الموقع أنت تتعهد بموافقتك على شروط الاستخدام التالية:</p>
			<ul>
				<li>محتوى صفحات هذا الموقع الإلكتروني مخصص لمعلوماتك واستخدامك العام، وهو عُرضة للتغيير من دون إشعار مسبق.</li>
				<li>لا نضمن نحن أو أي أطراف أخرى دقة المعلومات الموجودة أو المقدمة لأي غرض بعينه على هذا الموقع أو ديمومتها أو مستوى أدائها أو اكتمالها أو استدامتها. كما أنك باستخدامك الموقع تقر بمعرفتك بأن مثل هذه المعلومات أو المواد قد تتضمن أوجه عدم دقة أو أخطاء، ونحن نعلن صراحة عدم مسئوليتنا عن أي أوجه عدم دقة أو خطأ بأقصى قدر يسمح به القانون.</li>
				<li>أنت تتحمل كامل المسئولية عن أي مخاطر ناجمة عن استخدامك للمعلومات أو المواد المقدمة على هذا الموقع، ونحن نخلي مسئوليتنا عن أي من هذه المخاطر. كما أنك تتحمل مسئولية تحري مدى استيفاء أي منتجات أو خدمات أو معلومات مقدمة على هذا الموقع لشروطك المحددة.</li>
				<li>يحتوي هذا الموقع الإلكتروني على مواد حصلنا على تراخيص بنشرها، ومن بين هذه المواد على سبيل المثال لا الحصر، التصميم الفني، النسق الترتيبي، الشكل العام، والمظهر، والصور. غير مسموح بإعادة الإنتاج باستثناء ما يتماشى حقوق الملكية الفكرية والترخيص المحدد لكل مُنتَج.</li>
				<li>كافة الأسماء الأخرى، وغيرها من والماركات التجارية، وأسماء المنتجات والخدمات، والتصميمات الفنية، والشعارات الموجودة على ScriptureEarth هي علامات تجارية مملوكة من أصحابها ذوي الصلة من الهيئات والمؤسسات الأخرى.</li>
				<li>أي استخدام لهذا الموقع الإلكتروني على نحو غير مصرح به يجوز أن يستدعي رفع دعوى تضرر أو جرم جنائي أو كليهما.</li>
				<li>يحتوي هذا الموقع الإلكتروني على روابط بمواقع إلكترونية أخرى. وهذه الروابط مقدمة لتيسير حصولك على معلومات إضافية، ولكنها لا تعني أننا نضفي مصداقية على الموقع أو المواقع الأخرى؛ ولذا، فنحن نخلي أي مسئولية عن محتوى المواقع التي تؤدي إليها تلك الروابط الإلكترونية.</li>
			</ul>
		<?php
			break;
		case "P":
		?>
			<script type="text/javascript" language="javascript">
				document.title = "سياسة الخصوصية";
			</script>
			<h2>سياسة الخصوصية</h2>
			<p>لا يستخدم موقع ScriptureEarth الإلكتروني تقنية ملفات تعريف الارتباط أو ما يعرف بـ "الكوكيز"، وعليه، فالموقع لا يتتبع المستخدمين أو أنماط الاستخدام.</p>
			<h3>جمع المعلومات الشخصية واستخدامها</h3>
			<p>عندما تستخدم هذا الموقع الإلكتروني أو تتصل بخدمة SIL Global عبر هذا الموقع، لن نجمع معلومات شخصية عنك ما لم تشارك هذه المعلومات طواعية. فإن أدخلت عنوانك البريدي أو عنوان البريد الإلكتروني، سنقتصر في استقبالنا على المعلومات التي أدخلت العنوان من أجلها.</p>
			<p>في حالة الطلب يجوز إرسال المعلومات الشخصية إلى مؤسسات خدمة شريكة لـ SIL Global  بغرض الإجابة على طلب أو تعليقات منك كمستخدم.</p>
			<p>إذا قمت بمشاركة معلومات شخصية غير عامة (مثل الاسم، أو العنوان، أو البريد الإلكتروني، رقم الهاتف) عبر هذا الموقع، فإن استخدام SIL Global  لهذه المعلومات سيقتصر على الغرض المذكور على الصفحة التي تم إدخال المعلومات عليها.</p>
			<p>لا ترسل SIL Global  أي رسائل بريد إلكتروني غير مرغوب فيها أو "تطفلية" كما أنها لا تبيع أو تؤجر أو تتبادل مع أطراف أخرى قوائم البريد الإلكتروني.</p>
			<p>في كافة الأحوال سنقوم بالإفصاح عن المعلومات في حالة الضرورة بما يتوافق مع القوانين واللوائح المعمول بها.</p>
			<h3>روابط إلكترونية</h3>
			<p>يحتوي ScriptureEarth على روابط بمواقع إلكترونية أخرى، تزودك هذه الروابط بمصادر ذات صلة. ولكن وجود رابط بموقع أو وثيقة لا يعني بالضرورة أن مؤسسة SIL Global:</p>
			<ul>
				<li>تصادق على المؤسسة (أو المؤسسات) أو الشخص (أو الأشخاص) الذي يقدم مثل ذلك المحتوى</li>
				<li>توافق على الأفكار التي يحتويها الموقع أو الوثيقة الأخرى</li>
				<li>تشهد على صحة المحتويات أو ثبوتيها أو ملاءمتها أو وضعها القانونية</li>
			</ul>
			<p>كما أن SIL Global  تخلي مسئوليتها عن سياسات الخصوصية أو ممارساتها في تلك المواقع الأخرى.</p>
	<?php
			break;
		default: 				// CR, TC, P, H and CU
			die("The 'item' is not found.</body></html>");
	}
	?>
</body>

</html>