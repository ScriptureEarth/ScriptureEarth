<!DOCTYPE html>
<html>
<head>
<title><?php echo $title_text = 'Scripture Earth: 数千种语言的经文资源'; ?></title>
<meta property="og:title" 					content="Language page of Scripture Earth" />
<meta property="og:type" 					content="website" />
<meta property="og:url" 					content="https://scriptureearth.org/00cmn.php" />
<meta property="og:image"			 		content="https://www.scriptureearth.org/images/SEThumbnail.jpg" />
<!--meta http-equiv="Content-Type" 			content="text/html; charset=utf-8" />
<meta name="viewport" 						content="width=device-width, initial-scale=1" /-->
<meta name="Description" lang="zh-Hans"		content="
    这个网站提供土著语言的圣经（旧约和新约中的经文）：文本、音频和视频格式，可以下载到你的设备或在线阅读。
    查看下载、读经软件、移动应用程序，或订购你的硬拷贝。
" />
<meta name="Keywords" lang="zh-Hans"			content="
    现代土著语言，美洲，世界，心语，母语，Bible.is，在线查看，下载，母语，文本，PDF，音频，MP3，MP4，mp4，
    iPod，iPhone，手机，智能手机，iPad，平板电脑，安卓，观看，查看，耶稣电影，路加视频，购买，按需印刷，
    在线购买，书店，学习，The Word，圣经，新约，NT，旧约，OT，经文，地图，移动应用程序
" />
<style type="text/css">
	/* this version of classes are for Chinese only! */
	div.topBannerImage {
		background-image: url(images/00i-topBanerComp.png);
		height: 136px;
		text-align: right;
	}
</style>
<script type="text/javascript" language="javascript">
	var MajorLang = "Chi";
</script>
	<?php
	$st = 'cmn';
	if (isset($_GET['st'])) {
		$st = $_GET['st'];
		$test = preg_match('/^[a-z]{3}/', $st);
		if ($test === 0) {
			die ("<body><br />$st wasn’t found.</body></html>");
		}
	}
	
	$Variant_major = 'Variant_Chi';
	$SpecificCountry = 'Chinese';
	$counterName = 'Chinese';
	$MajorLanguage = 'LN_Chinese';
	//$Scriptname = '00cmn.php';
	$Scriptname = basename($_SERVER["SCRIPT_NAME"]);
	// to change language button go to https://developers.facebook.com/docs/plugins/like-button or http://www.visualmagnetic.com/html/fb-like-83-languages/#notes
	$FacebookCountry = 'zh-Hans';
	$MajorCountryAbbr = 'zh';
	
	define ('OT_EngBook', 9);						// Chinese Bible book names
	define ('NT_EngBook', 9);
	
	include ('./00-MainScript.inc.php');				// THE MAIN SCRIPT!!!!!
	?>

</body>
</html>
