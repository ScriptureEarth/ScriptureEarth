<?php
/* variables of 00zzz-CTPHC.php:
		'I': 'CR', 'TC', 'P', 'H', and 'CU': section to be display
	   $st variables:
		eng, deu, cmn, nld, spa, fra, por, kor
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
			<h2>저작권</h2>
			<p>© <?php echo date('Y'); ?> SIL International</p>
			<p><em>ScriptureEarth.org</em> 웹사이트는 SIL International이 관리합니다. 소수 민족 언어 공동체와 함께하는 SIL의 섬김은 모든 사람이 하나님의 형상대로 창조되었으며, 언어와 문화는 하나님의 창조에 담긴 풍성함의 일부라는 믿음에서 출발합니다.</p>
			<p>이 사이트는 전 세계 언어로 발행되거나 출시된 성경 매체에 관한 정보를 제공하고 이용 방법을 안내하기 위함입니다. 개별 저작권 및 라이선스 정보는 각 매체의 저작에 공헌한 기관의 표시를 따른 것입니다.</p>
			<p>스크립처어스 웹사이트는 다음과 같은 매체를 포함하고 있습니다:
			<ul type="disc">
				<li>비디오</li>
				<li>오디오</li>
				<li>오프라인에서 읽을 수 있는 텍스트(PDF)</li>
				<li>온라인에서 읽을 수 있는 텍스트(때로는 따라읽기 오디오 포함)</li>
				<li>모바일 앱</li>
				<li>인쇄된 성경 및 기타 자료를 구매할 수 있는 링크</li>
			</ul>
			</p>
		<?php
			break;
		case "H":
		?>
			<script type="text/javascript" language="javascript">
				document.title = "Help";
			</script>
			<h2>도움</h2>
			<p>
            아래 그래픽은 홈페이지에서 특정 언어를 찾는 방법을 보여줍니다. 사용자가 검색 상자 중 하나에 입력하거나 '국가별 목록'을 선택할 때마다 하나 이상의 선택 항목이 표시됩니다. 목록에서 원하는 항목을 선택하십시오.</p>
			<div style="text-align: center; margin-right: auto; margin-left: auto; margin-top: 30px; margin-bottom: 40px; ">
				<img src='./images/00kor-helpExplanation.jpg' style='height: 90%; width: 90%; ' />
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
					<strong>궁금한 점이 있거나 피드백을 보내시려면 아래의 채널로 문의하십시오:</strong><br />
					<img src='./images/app-icon.jpg' alt="feedback" style='margin-bottom: -6px; ' width="32" height="32" />
					<a href="mailto:info&#64;ScriptureEarth.org">info&#64;ScriptureEarth.org</a><br /><br />
					<img src="./images/sil-icon.jpg" alt="SIL International" width="32" height="32" /><strong> SIL 인터내셔널</strong><br />
					<a href="https://www.sil.org/">www.sil.org</a>
				</div>
			</div>

			<hr>

			<h3>협력 기관 중 일부</h3>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/FaithComesByHearingIcon.png" alt="Fath Comes By Hearing" width="32" /><strong>Faith Comes By Hearing / Hosanna / Bible.is (믿음은 들음에서 온다) / 호산나</strong><br />
					<a href="https://www.faithcomesbyhearing.com/">https://www.faithcomesbyhearing.com</a>
				</div>
				<div class='contacts'>
					<img src="./images/JesusFilmMediaIcon.png" alt="Jesus Film Media" width="32" height="32" /><strong>&nbsp;Jesus Film Media (예수 필름 미디어)</strong><br />
					<a href="https://jesusfilmmedia.org/">https://jesusfilmmedia.org</a>
				</div>
			</div>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/eBible_icon.png" alt="eBible" width="30" height="30" /><strong> eBible (전자성경)</strong><br />
					<a href='https://ebible.org/'>https://ebible.org/</a><br />
				</div>
				<div class='contacts'>
					<img src="./images/YouVersionIcon.png" alt="YouVersion" width="32" height="32" /><strong> YouVersion (유버전)</strong><br />
					<a href="https://www.youversion.com/">https://www.youversion.com/</a>
				</div>
			</div>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/BiblicaIcon.png" alt="Biblica" width="30" /><strong> Biblica (비블리카)</strong><br />
					<a href="https://www.biblica.com/">https://www.biblica.com/</a>
				</div>
				<div class='contacts'>
					<img src="./images/Find.Bible.jpg" alt="Find a Bible" width="30" height="30" /><strong> Find a Bible (성경 찾기)</strong><br />
					<a href="https://find.bible/">https://find.bible/</a>
				</div>
			</div>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/VinaIcon.png" alt="Viña Studios" width="30" height="30" /><strong> Viña Studios (비냐 스튜디오)</strong><br />
					<a href='https://www.vinyastudios.org/en'>https://www.vinyastudios.org/en/</a><br />
					<a href='https://deditos.org/'>https://deditos.org/</a>
				</div>
				<div class='contacts'>
					<img src="./images/GlobalRecordingsNetworkIcon.png" alt="Global Recording Network" width="20" /><strong> Global Recordings Network (글로벌 리코딩 네트워크)</strong><br />
					<a href="https://globalrecordings.net/en">https://globalrecordings.net/en</a>
				</div>
			</div>

			<h3>Wycliffe (위클리프)</h3>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/WycliffeGlobalAllianceIcon.png" alt="Wycliffe Global Alliance" width="32" height="32" /><strong> Wycliffe Global Alliance (위클리프 국제 연대)</strong><br />
					<a href="https://www.wycliffe.net">https://www.wycliffe.net</a>
				</div>
			</div>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/WycliffeUSAIcon.png" alt="Wycliffe USA" width="50" /><strong> 위클리프 미국</strong><br />
					<a href="https://www.wycliffe.org/">https://www.wycliffe.org/</a>
				</div>
				<div class='contacts'>
					<br />
					<img src="./images/WycliffeUKIcon.png" alt="Wycliffe UK" width="30" /><strong> 위클리프 영국</strong><br />
					<a href="https://www.wycliffe.org.uk/">https://www.wycliffe.org.uk/</a>
				</div>
			</div>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/WycliffeCanadaIcon.png" alt="Wycliffe Canada" width="32" height="32" /><strong> 위클리프 캐나다</strong><br />
					<a href="https://www.wycliffe.ca">https://www.wycliffe.ca</a>
				</div>
				<div class='contacts'>
					<img src="./images/WycliffeAustraliaIcon.png" alt="Wycliffe Australia" width="32" height="32" /><strong> 위클리프 호주</strong><br />
					<a href="https://wycliffe.org.au">https://wycliffe.org.au</a>
				</div>
			</div>

			<h3>성서 공회</h3>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/AmericanBibleSocietyIcon.png" alt="Amercain Bible Society" width="32" /><strong> 미국 성서 공회</strong><br />
					<a href="https://www.americanbible.org/">https://www.americanbible.org</a>
				</div>
				<div class='contacts'>
					<img src="./images/CanadianBibleSocietyIcon.png" alt="Canadian Bible Society" width="32" height="31" /><strong> 캐나다 성서 공회</strong><br />
					<a href="https://www.biblesociety.ca/">https://www.biblesociety.ca</a>
				</div>
			</div>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/BibleSocietyOfBrazilIcon.png" alt="Bible Society of Brazil" width="32" height="32" /><strong> 브라질 성서 공회</strong><br />
					<a href="https://sbb.org.br/">https://sbb.org.br/</a>
				</div>
			</div>

			<h3>Bible League (바이블 리그)</h3>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/LaLegaBiblicaIcon.png" alt="Liga Bíblica México" height="32" /><strong> 리가 비블리카 멕시코</strong><br />
					<a href="https://www.laligabiblica.org.mx">https://www.laligabiblica.org.mx</a>
				</div>
				<div class='contacts'>
					<img src="./images/BibleLeagueUSAIcon.png" alt="Bible League (USA)" width="32" height="32" /><strong> 바이블 리그 미국</strong><br />
					<a href="https://www.bibleleague.org/">https://www.bibleleague.org</a>
				</div>
			</div>

			<h3>기타 웹사이트</h3>

			<div class='clearfix'>
				<div class='contacts'>
					<img src="./images/MegaVoive_icon.png" alt="MegaVoice" height="32" /><strong> MegaVoice (메가 보이스)</strong><br />
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
			<h2>이용약관</h2>
			<p>웹사이트 방문을 환영합니다. 본 웹사이트를 계속 탐색하고 사용하는 경우, 귀하는 개인정보 보호정책과 함께 본 웹사이트와 관련하여 SIL International과 귀하 사이의 관계를 규율하는 다음 이용 약관을 준수하고 이에 구속되는 데 동의하는 것으로 간주됩니다. 본 이용 약관의 일부에 동의하지 않는 경우 이 웹사이트를 이용할 수 없습니다.</p>
			<p>'SIL International', '당사'  또는 '우리'라는 용어는 등록 사무소를 7500 West Camp Wisdom Road, Dallas TX, USA에 둔 웹사이트의 소유자를 지칭합니다.</p>
			<p>'귀하'라는 용어는 이 웹사이트의 사용자 또는 뷰어를 의미합니다.</p>
			<p>이 웹사이트를 이용하면 다음 이용 약관에 동의하는 것입니다:</p>
			<ul>
				<li>이 웹사이트 페이지의 콘텐츠는 일반적인 정보 제공 및 사용만을 위한 것입니다. 사전 통지 없이 변경될 수 있습니다.</li>
				<li>당사 또는 제3자는 본 웹사이트에서 발견되거나 제공되는 정보 및 자료의 정확성, 적시성, 성능, 완전성 또는 특정 목적에 대한 적합성에 대해 어떠한 보증이나 보장을 제공하지 않습니다. 귀하는 그러한 정보 및 자료에 부정확성 또는 오류가 있을 수 있음을 인정하며, 당사는 법이 허용하는 최대 한도 내에서 그러한 부정확성 또는 오류에 대한 책임을 명시적으로 지지 않습니다.</li>
				<li>본 웹사이트의 정보나 자료를 사용하는 것은 전적으로 귀하의 책임이며, 당사는 이에 대해 책임을 지지 않습니다. 본 웹사이트를 통해 제공되는 모든 매체, 서비스 또는 정보가 귀하의 특정 요구 사항을 충족하는지 확인하는 것은 귀하의 책임입니다.</li>
				<li>본 웹사이트에는 당사가 게시할 수 있는 권한이 있는 자료가 포함되어 있습니다. 이 자료에는 디자인, 레이아웃, 모양, 외관 및 그래픽이 포함되지만 이에 국한되지 않습니다. 각 제품에 지정된 저작권 및 라이선스에 따르는 것 이외의 복제는 금지됩니다.</li>
				<li>스크립처어스에 있는 기타 모든 이름, 로고, 제품 및 서비스 이름, 디자인, 슬로건은 해당 소유자의 상표입니다.</li>
				<li>이 웹사이트를 무단으로 사용하면 손해배상 청구가 제기되거나 형사상 범죄가 될 수 있습니다.</li>
				<li>이 웹사이트에는 다른 웹사이트로 연결되는 링크가 포함되어 있습니다. 이러한 링크는 사용자의 편의를 위해 추가 정보를 제공하기 위해 제공됩니다. 이러한 링크는 당사가 해당 웹사이트를 보증한다는 것을 의미하지 않습니다. 당사는 링크된 웹사이트의 콘텐츠에 대해 어떠한 책임도 지지 않습니다.</li>
			</ul>
		<?php
			break;
		case "P":
		?>
			<script type="text/javascript" language="javascript">
				document.title = "Privacy Policy";
			</script>
			<h2>개인 정보 보호 정책</h2>
			<p>스크립처어스는 “쿠키” 기술을 사용하지 않습니다. 따라서 이 사이트는 사용자나 사용 패턴을 추적하지 않습니다.</p>
			<h3>개인정보 수집 및 사용</h3>
			<p>귀하가 이 사이트를 검색하거나 이 사이트를 통해 SIL International에 연락할 때, 당사는 귀하가 자발적으로 해당 정보를 제공하지 않는 한 귀하에 대한 개인정보를 수집하지 않습니다. 우편 또는 이메일 주소를 제공하는 경우 해당 주소를 제공한 정보만 수신하게 됩니다.</p>
			<p>필요한 경우, 귀하의 요청이나 의견에 대한 응답을 제공하기 위해 개인정보가 SIL International의 협력 단체에 전달될 수 있습니다.</p>
			<p>본 사이트를 통해 비공개 개인정보(예: 이름, 주소, 이메일 주소 또는 전화번호)를 제공하는 경우, SIL International은 해당 정보를 수집한 페이지에 명시된 목적으로만 해당 정보를 사용합니다.</p>
			<p>SIL International은 원치 않는 이메일 또는 “스팸” 이메일을 보내지 않으며 이메일 목록을 제3자에게 판매, 대여 또는 거래하지 않습니다.</p>
			<p>모든 경우에 당사는 관련 법률 및 규정에 따라 요구되는 때에 한하여 정보를 공개합니다.</p>
			<h3>링크</h3>
			<p>스크립처어스에는 다른 웹사이트로 연결되는 링크가 포함되어 있습니다. 이러한 링크는 관련 리소스를 제공합니다. 문서나 사이트에 대한 링크가 SIL International이 다음 사실을 반드시 동의하거나 보증한다는 것을 의미하지 않습니다.</p>
			<ul>
				<li>해당 문서나 사이트를 제공하는 조직 또는 개인에 관한 보증</li>
				<li>표현된 아이디어에 관한 동의</li>
				<li>콘텐츠의 정확성, 사실성, 적절성 또는 적법성에 관한 보증</li>
			</ul>
			<p>또한 SIL International은 이러한 웹사이트의 개인정보 보호정책 또는 관행에 대해 책임을 지지 않습니다.</p>
	<?php
			break;
		default: 				// CR, TC, P, H and CU
			die("The 'item' is not found.</body></html>");
	}
	?>
</body>

</html>