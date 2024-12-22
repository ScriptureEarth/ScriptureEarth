<!DOCTYPE html>
<html lang="ar">
<head>
<title><?php echo $title_text = 'Scripture Earth: مصادر للوصول إلى ترجمات كاملة وجزئية للكتاب المقدس بآلاف اللغات'; ?></title>
<meta property="og:title" 					content="Language page of Scripture Earth" />
<meta property="og:type" 					content="website" />
<meta property="og:url" 					content="https://scriptureearth.org/00arb.php" />
<meta property="og:image"			 		content="https://www.scriptureearth.org/images/SEThumbnail.jpg" />
<!--meta http-equiv="Content-Type" 			content="text/html; charset=utf-8" />
<meta name="viewport" 						content="width=device-width, initial-scale=1" /-->
<meta name="Description" lang="en-US"		content="
    يتيح هذا الموقع الكتاب المقدس (بعهديه القديم والجديد أو أجزاء منهما) بلغات محلية مختلفة في صيغ نص، وتسجيل، وفيديو. يمكنك تنزيلها على جهازك أو القراءة على الإنترنت. قم بزيارة القسم المختص بالتنزيلات، وبرنامج دراسة الكتاب المقدس، وتطبيقات الأجهزة المحمولة، أو اطلب شراء نسخة مطبوعة من الكتاب المقدس بلغتك المختارة.
" />
<meta name="Keywords" lang="en-US"			content="
    لغات محلية معاصرة، العالم، اللغة الأقرب، اللغة الأم، الكتاب المقدس.is، عارض الإنترنت، تنزيل، لغات أصلية، نص، ملف PDF، تسجيل صوتي MP3، تسجيل صوتي mp3، تسجيل صوتي MP4، تسجيل صوتي mp4، جهاز iPod، جهاز آيفون، هاتف خلوي، هاتف ذكي، آيباد، تابليت، أندرويد، شاهد، عرض، فيلم يسوع، فيديو لوقا، شراء، طباعة حسب الطلب، شراء على الإنترنت، مكتبة، دراسة، الكلمة المقدسة، الكتاب المقدس، العهد الجديد، العهد الجديد، العهد القديم، العهد القديم، أجزاء الكتاب المقدس، خريطة، تطبيق، تطبيق المحمول
" />
<style>
	div.arb-header {
		background-image: url('./images/00arb-BackgroundFistPage.jpg');
	}
	ul.ulArabic {
		/*padding-left: 230px;*/
		/* use padding-left and width to make the words correct position */
		/*display: block;
		display: inline;*/
		text-align: center;
		font-size: .86em;
		font-weight: bold;
		/*margin-top: -180px;*/
		/*clear: both;*/
		margin-left: -40px;
	}
	@media only screen and (max-width: 480px) {
		/* (max-width: 412px) for Samsung S8+ 2/20/2019 */
		div.arb-header {
			position: relative;
			top: -54px;
			background-image: url('./images/00arb-BackgroundFistPage-mobile.jpg');
			/* This ensures your background image is center-positioned vertically and horizontally*/
			background-position: center;
			/* This ensures your background image doesn’t tile */
			/*background-repeat: no-repeat;*/
			/* This makes your background image responsive and rescale according to the viewport or container size*/
			/*background-size: cover;*/
		}
		ul.ulArabic {
			font-weight: normal;
			font-size: 90%;
			/*margin-left: -20px;
			margin-right: 0;*/
		}
    }
</style>
<script type="text/javascript" language="javascript">
	const MajorLang = "Arb";
	const Major_OT_array = ["تكوين","خروج","لاويين","عدد","تثنية","يشوع","قضاة","راعوث","صموئيل الأول","صوئيل الثاني","ملوك الأول","ملوك الثاني","أخبار الأيام الأول","أخبار الأيام الثاني","عزرا","نحميا","أستير","أيوب","مزامير","أمثال","الجامعة","نشيد الأنشاد","إشعياء","إرميا","مراثي إرميا","حزقيال","دانيال","هوشع","يوئيل","عاموس","عوبديا","يونان","ميخا","ناحوم","حبقوق","صفنيا","حجي","زكريا","ملاخي"];
    const Major_NT_array = ["متى","مرقس","لوقا","يوحنا","أعمال الرسل","رومية","كورنثوس الأولى","كورنثوس الثانية","غلاطية","أفسس","فيلبي","كولوسي","تسالونيكي الأولى","تسالونيكي الثانية","تيموثاوس الأولى","تيموثاوس الثانية","تيطس","فليمون","عبرانيين","يعقوب","بطرس الأولى","بطرس الثانية","يوحنا الأولى","يوحنا الثانية","يوحنا الثالثة","يهوذا","رؤيا يوحنا اللاهوتي"];
</script>
	<?php
	$st = 'arb';
	if (isset($_GET['st'])) {
		$st = $_GET['st'];
		$test = preg_match('/^[a-z]{3}/', $st);
		if ($test === 0) {
			die ("<body><br />$st wasn’t found.</body></html>");
		}
	}
	
	$direction = 'rtl';
	$Variant_major = 'Variant_Ara';
	$SpecificCountry = 'Arabic';
	$counterName = 'Arabic';
	$MajorLanguage = 'LN_Arabic';
	//$Scriptname = '00arb.php';
	//$Scriptname = end(explode('/', $_SERVER["SCRIPT_NAME"]));
	$Scriptname = basename($_SERVER["SCRIPT_NAME"]);
	// to change language button go to https://developers.facebook.com/docs/plugins/like-button or http://www.visualmagnetic.com/html/fb-like-83-languages/#notes
	$FacebookCountry = 'ar_AB';
	$MajorCountryAbbr = 'ar';
	
	define ('OT_EngBook', 12);							// English Bible book names
	define ('NT_EngBook', 12);
	
	include ('./00-MainScript.inc.php');				// THE MAIN SCRIPT!!!!!
	?>
</body>
</html>
