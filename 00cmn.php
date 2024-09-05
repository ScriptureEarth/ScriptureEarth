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
		background-image: url('./images/00i-topBanerComp.png');
		height: 136px;
		text-align: right;
	}
	div.cmn-header {
		/* Chinese */
		background-image: url('./images/00cmn-BackgroundFistPage.jpg');
	}
	ul.ulChinese {
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
		div.cmn-header {
			background-position: center;
			position: relative;
			top: -54px;
		}
		div.cmn-header {
			background-image: url('./images/00cmn-BackgroundFistPage-mobile.jpg');
		}
    }
</style>
<script type="text/javascript" language="javascript">
	const MajorLang = "Chi";
	const Major_OT_array = ["创世记", "出埃及记", "利未记", "民数记", "申命记", "约书亚记", "士師记", "路得记", "撒母耳记上", "撒母耳记下", "列王纪上", "列王纪下", "历代志上", "历代志下", "以斯拉记", "尼希米记", "以斯帖记", "约伯记", "诗篇", "箴言", "传道书", "雅歌", "以赛亚书", "耶利米书", "耶利米哀歌", "以西结书", "但以理书", "何西阿书", "约珥书", "阿摩司书", "俄巴底亚书", "约拿书", "弥迦书", "那鸿书", "哈巴谷书", "西番雅书", "哈该书", "撒迦利亚书", "玛拉基书"];
    const Major_NT_array = ["马太福音", "马可福音", "路加福音", "约翰福音", "使徒行传", "罗马书", "哥林多前书", "哥林多后书", "加拉太书", "以弗所书", "腓立比书", "歌罗西书", "帖撒罗尼迦前书", "帖撒罗尼迦后书", "提摩太前书", "提摩太后书", "提多书", "腓利门书", "希伯来书", "雅各书", "彼得前书", "彼得后书", "约翰1书", "约翰2书", "约翰3书", "犹大书", "启示录"];
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
