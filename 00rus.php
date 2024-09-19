<!DOCTYPE html>
<html>
<head>
<title><?php echo $title_text = 'Scripture Earth: Ресурсы Священных Писаний на тысячах языков'; ?></title>
<meta property="og:title" 					content="Language page of Scripture Earth" />
<meta property="og:type" 					content="website" />
<meta property="og:url" 					content="https://scriptureearth.org/00rus.php" />
<meta property="og:image"			 		content="https://www.scriptureearth.org/images/SEThumbnail.jpg" />
<!--meta http-equiv="Content-Type" 			content="text/html; charset=utf-8" />
<meta name="viewport" 						content="width=device-width, initial-scale=1" /-->
<meta name="Description" lang="en-US"		content="
    Этот сайт предоставляет доступ к Библии (Писаниям Ветхого Завета и Нового Завета) на языках коренных народов:
    текстовые, аудио- и видеоформаты для загрузки на свое устройство или чтения онлайн. Ознакомьтесь с загрузками,
    программным обеспечением для изучения Библии, мобильными приложениями или закажите печатную версию.
" />
<meta name="Keywords" lang="en-US"			content="
    современные коренные языки, мир, язык сердца, родной язык, Bible.is, онлайн-просмотрщик, загрузка, родные языки,
    текст, PDF, аудио, MP3, mp3, MP4, mp4, iPod, iPhone, мобильный телефон, смартфон, iPad, планшет, android, смотреть,
    просматривать, фильм «Иисус», видео Евангелия от Луки, купить, распечатать по запросу, онлайн-покупка, книжный магазин,
    изучение, Слово, Библия, Новый Завет, NT, Ветхий Завет, OT, Писание, карта, приложение, мобильное приложение
" />
<style>
	div.rus-header {
		background-image: url('./images/00rus-BackgroundFistPage.jpg');
	}
	ul.ulRussian {
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
		div.rus-header {
			background-position: center;
			position: relative;
			top: -54px;
		}
		div.rus-header {
			background-image: url('./images/00rus-BackgroundFistPage-mobile.jpg');
			/* This ensures your background image is center-positioned vertically and horizontally 
			background-position: center;*/
			/* This ensures your background image doesn’t tile */
			/*background-repeat: no-repeat;*/
			/* This makes your background image responsive and rescale according to the viewport or container size 
			background-size: cover;
			position: relative;
			top: -54px;*/
		}
    }
</style>
<script type="text/javascript" language="javascript">
	const MajorLang = "Rus";
	const Major_OT_array = ["португальский","испанский","Бытие","Исход","Левит","Числа","Второзаконие","Иисус Навин","Судьи","Руфь","1-я книга Царств","2-я книга Царств","3-я книга Царств","4-я книга Царств","1-я книга Паралипоменон","2-я книга Паралипоменон","Ездра","Неемия","Есфирь","Иов","Псалтирь","Притчи","Екклесиаст","Песнь песней","Исаия","Иеремия","Плач Иеремии","Иезекииль","Даниил","Осия","Иоиль","Амос","Авдий","Иона","Михей","Наум","Аввакум","Софония","Аггей","Захария","Малачи"];
    const Major_NT_array = ["От Матфея","От Марка","От Луки","От Иоанна","Деяния","Послание римлянам","1-е посл. коринфянам","2-е посл. коринфянам","Послание галатам","Послание эфесянам","Послание филиппийцам","Послание колоссянам","1-е посл. фессалоникийцам","2-е посл. фессалоникийцам","1-е посл. Тимофею","2-е посл. Тимофею","Послание Титу","Послание Филимону","Послание евреям","Послание евреям","1-е посл. Петра","2-е посл. Петра","1-е посл. Иоанна","2-е посл. Иоанна","2-е посл. Иоанна","Послание Иуды","Откровение"];
</script>
	<?php
	$st = 'rus';
	if (isset($_GET['st'])) {
		$st = $_GET['st'];
		$test = preg_match('/^[a-z]{3}/', $st);
		if ($test === 0) {
			die ("<body><br />$st wasn’t found.</body></html>");
		}
	}
	
	$Variant_major = 'Variant_Rus';
	$SpecificCountry = 'Russian';
	$counterName = 'Russian';
	$MajorLanguage = 'LN_Russian';
	//$Scriptname = '00rus.php';
	//$Scriptname = end(explode('/', $_SERVER["SCRIPT_NAME"]));
	$Scriptname = basename($_SERVER["SCRIPT_NAME"]);
	// to change language button go to https://developers.facebook.com/docs/plugins/like-button or http://www.visualmagnetic.com/html/fb-like-83-languages/#notes
	$FacebookCountry = 'ru_RU';
	$MajorCountryAbbr = 'ru';
	
	define ('OT_EngBook', 11);							// Russian Bible book names
	define ('NT_EngBook', 11);
	
	include ('./00-MainScript.inc.php');				// THE MAIN SCRIPT!!!!!
	?>
</body>
</html>
