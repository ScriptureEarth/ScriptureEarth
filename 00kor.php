<!DOCTYPE html>
<html>
<head>
<title><?php echo $title_text = 'Scripture Earth: 수천 가지 언어로 제공되는 성경 자료'; ?></title>
<meta property="og:title" 					content="Language page of Scripture Earth" />
<meta property="og:type" 					content="website" />
<meta property="og:url" 					content="https://scriptureearth.org/00kor.php" />
<meta property="og:image"			 		content="https://www.scriptureearth.org/images/SEThumbnail.jpg" />
<!--meta http-equiv="Content-Type" 			content="text/html; charset=utf-8" />
<meta name="viewport" 						content="width=device-width, initial-scale=1" /-->
<meta name="Description" lang="ko-KR"		content="
    이 사이트를 통해 토착 언어로 된 성경(구약과 신약 성경)을 이용할 수 있습니다. 문서로 된 본문, 오디오 및 비디오 형식을 장치에 다운로드하거나
    온라인으로 읽을 수 있습니다. 다운로드, 성경 연구 소프트웨어, 모바일 앱을 확인하거나 인쇄본을 주문하세요.
" />
<meta name="Keywords" lang="ko-KR"			content="
    현대의 토착민 언어, 세계, 가슴에 와닿는 언어, 모국어, Bible.is, 온라인 뷰어, 다운로드, 모국어, 텍스트, PDF, 오디오, MP3, mp3, MP4, mp4,
    iPod, iPhone, 휴대폰, 스마트폰, iPad, 태블릿 , android, 시청, 보기, 예수 영화, 누가복음 비디오, 구매, 주문형 인쇄, 온라인 구매, 서점, 연구,
    말씀, 성경, 신약성경, 신약, 구약성경, 구약, 성서, 지도, 앱, 모바일 앱
" />
<style>
    div.kor-header {
        /* Korean */
        background-image: url('./images/00kor-BackgroundFistPage.jpg');
    }
    ul.ulKorean {
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
        div.kor-header {
            background-position: center;
            position: relative;
            top: -54px;
            background-image: url('./images/00kor-BackgroundFistPage-mobile.jpg');
        }
		ul.ulKorean {
			font-weight: normal;
			font-size: 90%;
			/*margin-left: -20px;
			margin-right: 0;*/
		}
    }
</style>
<script type="text/javascript" language="javascript">
	const MajorLang = "Kor";
	const Major_OT_array = ["창세기", "출애굽기", "레위기", "민수기", "신명기", "여호수아", "사사기", "룻기", "사무엘상", "사무엘하", "열왕기상", "열왕기하", "역대상", "역대하", "에스라", "느헤미야", "에스더", "욥기", "시편", "잠언", "전도서", "아가", "이사야", "예레미야", "예레미야애가", "에스겔", "다니엘", "호세아", "요엘", "아모스", "오바댜", "요나", "미가", "나훔", "하박국", "스바냐", "학개", "스가랴", "말라기"];
    const Major_NT_array = ["마태복음", "마가복음", "누가복음", "요한복음", "사도행전", "로마서", "고린도전서", "고린도후서", "갈라디아서", "에베소서", "빌립보서", "골로새서", "데살로니가전서", "데살로니가후서", "디모데전서", "디모데후서", "디도서", "빌레몬서", "히브리서", "야고보서", "베드로전서", "베드로후서", "요한1서", "요한2서", "요한3서", "유다서", "요한계시록"];
</script>
	<?php
		$st = 'kor';
		if (isset($_GET['st'])) {
			$st = $_GET['st'];
			$test = preg_match('/^[a-z]{3}/', $st);
			if ($test === 0) {
				die ("<body><br />$st wasn’t found.</body></html>");
			}
		}
		
		$direction = 'ltr';
		$Variant_major = 'Variant_Kor';
		$SpecificCountry = 'Korean';
		$counterName = 'Korean';
		$MajorLanguage = 'LN_Korean';
		//$Scriptname = '00kor.php';
		//$Scriptname = end(explode('/', $_SERVER["SCRIPT_NAME"]));
		$Scriptname = basename($_SERVER["SCRIPT_NAME"]);
		// to change language button go to https://developers.facebook.com/docs/plugins/like-button or http://www.visualmagnetic.com/html/fb-like-83-languages/#notes
		$FacebookCountry = 'ko_KR';
		$MajorCountryAbbr = 'ko';
		
		define ('OT_EngBook', 10);							// Koren Bible book names
		define ('NT_EngBook', 10);
		
		include ('./00-MainScript.inc.php');				// THE MAIN SCRIPT!!!!!
	?>
</body>
</html>
