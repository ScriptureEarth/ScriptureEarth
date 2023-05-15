<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type"				content="text/html; charset=utf-8" />
<meta name="ObjectType" 					content="Document" />
<meta http-equiv="Window-target" 			content="_top" />
<meta name="Created-by" 					content="Scott Starker" />
<title>AJAX - Create html subpage for eBible items</title>
<style type="text/css">
	html, body {
		font: 100% Verdana, Arial, Helvetica, sans-serif;
		/*background-color: white;		/* #AEB2BE */
		/*background-image: url(../images/background.png);*/
		height: 100%;
		margin: 0; 			/* it's good practice to zero the margin and padding of the body element to account for differing browser defaults */
		padding: 0;
		text-align: center; /* this centers the container in IE 5* browsers. The text is then set to the left aligned default in the #container selector */
		color: #000000;
	}
	a, a:hover, a:link, a:active {
		color: navy;
		text-decoration: none;
		border-style: none;
	}
	span.lineAction {
		color: crimson;
		text-decoration: underline;	
	}
	.selectOption {
		color: navy;
		font-weight: bold;
		font-size: .9em;
		font-family: Verdana, Arial, Helvetica, sans-serif;
	}
</style>
</head>
<body>
<?php
// eBibleItems.php?URL=ebible.org/fraLSG&st=eng&mobile=0&eBibleCount=0
if (isset($_GET["URL"])) {
		$URL = $_GET["URL"];
	}
	else
		die('No ‘URL’ was found.');
	if (isset($_GET["st"])) {
		$st = $_GET["st"];
		$st = preg_replace('/^([a-z]{3})/', '$1', $st);
		if ($st == NULL) {
			die ('‘st’ is empty.</body></html>');
		}
	}
	else
		die('No ‘st’ was found.');
	if (isset($_GET["mobile"])) {
		$mobile = $_GET["mobile"];
		$mobile = preg_replace('/^([0-1])/', '$1', $mobile);
		if ($mobile == NULL) {
			die ('‘mobile’ is empty.</body></html>');
		}
	}
	else
		$mobile = 0;
	if (isset($_GET["eBibleCount"])) {
		$eBibleCount = $_GET["eBibleCount"];
		$eBibleCount = preg_replace('/^([0-9]+)/', '$1', $eBibleCount);
		if ($eBibleCount == NULL) {
			die ('‘eBibleCount’ is empty.</body></html>');
		}
	}
			
	$inScript = '';
	$epub = '';
	$mobi = '';
	$sword = '';
	$PDFline = '';
	$vernacularTitle = '';

	include ('./translate/functions.php');								// translation function
	
	// Remote file url
	$remoteFile = "https://$URL";
	// Initialize cURL
	$ch = curl_init($remoteFile);
	curl_setopt($ch, CURLOPT_NOBODY, true);
	curl_exec($ch);
	$responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
	// Check the response code
	if (!$responseCode == 200) {
		echo 'URL not found';
		return;
	}

	require_once './include/conn.inc.php';														// connect to the database named 'scripture'
	$db = get_my_db();

	$query="SELECT description FROM eBible_list WHERE translationId = ?";
	$stmt=$db->prepare($query);
	
	$homepage = @file_get_contents("https://$URL");						// get the HTML from the eBible.org
	$convert = explode("\n", $homepage);								// create array separate by new line
	for ($i=0; $i<count($convert); $i++) {
		if (preg_match('/\<title\>(.*)\<\/title\>/i', $convert[$i], $match)) {
			//$vernacularTitle = trim(preg_replace("/\<title\>(.*)\<\/title\>/i", $convert[$i], $match));
			if (substr($URL, strripos($URL, "/")+1, 3) == 'grc') {								// get sub string (in reverse order) if <title> isn't distigishable from other ROD Codes
				$temp = substr($URL, strripos($URL, "/")+1);
				$stmt->bind_param('s', $temp);													// bind parameters for markers
				$stmt->execute();																// execute query
				$result = $stmt->get_result();													// instead of bind_result (used for only 1 record):
				if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
					$vernacularTitle = trim($row['description']);
				}
				else {
					$vernacularTitle = trim($match[1]);
				}
			}
			else {
				$vernacularTitle = trim($match[1]);
			}
			echo $vernacularTitle . '|';
			continue;
		}
		/*
		<div class="toc">epub3: <a href="http://eBible.org/epub/aai.epub">aai.epub</a></div>
		<div class="toc">Kindle mobi: <a href="http://eBible.org/epub/aai.mobi">aai.mobi</a></div>
		<div class="toc"><a href="http://PNGScriptures.org/pdf/aai/" target="_blank">PDF</a></div>
		<div class="toc"><a href="http://ebible.org/study/?w1=bible&t1=local%3AAAIWBT&v1=MT1_1" target="_blank">inScript</a></div>
		<div Class="toc"><a href="ftp://ebible.org/pub/sword/zip/aai2009eb.zip">Crosswire Sword module</a></div>
		*/
		if (preg_match("/['\"]toc['\"]/i", $convert[$i])) {
			if (preg_match("/inScript/i", $convert[$i])) {
				preg_match("/href=(['\"][^'\"].*['\"])/i", $convert[$i], $matches);
				$inScript = '<div>&nbsp;&nbsp;•&nbsp;<a href=' . $matches[1] . ' target="_blank"><span class="lineAction">'.translate('Browser', $st, 'sys').'</span> - inScript.org</a></div>';
			}
			if (preg_match("/\.epub/i", $convert[$i])) {
				preg_match("/href=(['\"].*\.epub['\"])/i", $convert[$i], $matches);
				//$epub = '<div><a href=' . $matches[1] . '><span class="lineAction">'.translate('epub format', $st, 'sys').'</span></a></div>';
				$epub = $matches[1];
			}
			if (preg_match("/\.mobi/i", $convert[$i])) {
				preg_match("/href=(['\"].*\.mobi['\"])/i", $convert[$i], $matches);
				//$mobi = '<div><a href=' . $matches[1] . '><span class="lineAction">'.translate('Kindle format', $st, 'sys').'</span></a></div>';
				$mobi = $matches[1];
			}
			if (preg_match("/sword/i", $convert[$i])) {
				preg_match("/href=(['\"][^'\"].*['\"])/i", $convert[$i], $matches);
				//$sword = '<div><a href=' . $matches[1] . '><span class="lineAction">'.translate('Crosswire Sword format', $st, 'sys').'</span></a></div>';
				$sword = $matches[1];
			}
			if (preg_match("/pdf/i", $convert[$i])) {
				// http://zURLz/pdf/zISOz/;
				preg_match("/href=['\"](.*)\/['\"]/i", $convert[$i], $matches);
				$PDFline = $matches[1];										// save the line for the next steps
			}
		}
	}
	
	if ($PDFline != '') {
		echo "<br /><form name='eBible_list_$eBibleCount'>";
		//if (file_exists($PDFline)) {										// only works on the SE server
		$file_headers = @get_headers($PDFline);
		if (preg_match('/404 Not Found/', $file_headers[0])) {
			//echo "The file $PDFline does not exist.";
		}
		else if (preg_match('/302 Found/', $file_headers[0]) && preg_match('/404 Not Found/', $file_headers[7])) {
			//echo "The file $PDFline does not exist and so the script has been redirected to a custom 404 page.";
		}
		else {
			// echo "The file $PDFline exists";
			$PDFpage = file_get_contents($PDFline);							// get the HTML PDF from the eBible.org
			$convertPDF = explode("\n", $PDFpage);							// create array separate by new line
			echo '&nbsp;&nbsp;•&nbsp;<span class="lineAction">'.translate('Read', $st, 'sys').'</span> - '.translate('PDFs:', $st, 'sys');
			if ($mobile == 1) {
				echo "<br />";
			}
			else {
				echo " ";
			}
			echo "<select class='selectOption' name='list_eBible' onchange='if (this.options[this.selectedIndex].text != \"".translate('Choose One...', $st, 'sys')."\") { window.open(this.options[this.selectedIndex].value, \"_blank\"); }'>";
			echo '<option class="selectOption">'.translate('Choose One...', $st, 'sys').'</option>';
			for ($j=0; $j<count($convertPDF); $j++) {
				if (preg_match("/\.pdf['\"]/i", $convertPDF[$j])) {
					if (preg_match("/point/i", $convertPDF[$j])) continue; 
					$pages = '';
					$title = '';
					if (preg_match("/page/i", $convertPDF[$j])) {
						preg_match("/([0-9]*) page/i", $convertPDF[$j], $matches);				// pages
						$pages = $matches[1];
						preg_match("/\.pdf (.*) \(?[0-9]* page/i", $convertPDF[$j], $matches);		// title
						$title = $matches[1];
					}
					else {
						preg_match("/\.pdf (.*)/i", $convertPDF[$j], $matches);					// title
						$title = $matches[1];
					}
					$pageSize = '';
					if (preg_match("/(\(.*\))/", $title)) {
						preg_match("/\((.*)\)/", $title, $matches);								// any ()?
		//				$pageSize = $matches[1];
		//				preg_match("/(.*) \(.*\)/", $title, $matches);
						$title = $matches[1];													// replace title with the ()
					}
		//			$title = utf8_encode($title);
					preg_match("/href=['\"](.*\.pdf)['\"]/i", $convertPDF[$j], $matches);		// the link which will take you to the title page
					echo '<option class="selectOption" value="' . $PDFline . '/' . $matches[1] . '">' . $title . ' ' . ($pageSize != '' ? $pageSize . ' ' : '') . ($pages != '' ? '(' . $pages . ' ' . translate('pages', $st, 'sys') . ')' : '') . '</option>';
					/*
					<li><a href='aai_all.pdf'>aai_all.pdf TUR GEWASIN O BAIBASIT BOUBUN (letter size) 362 pages</a></li>
					<li><a href='aai_a4.pdf'>aai_a4.pdf TUR GEWASIN O BAIBASIT BOUBUN (A4 size) 398 pages</a></li>
					<li><a href='aai_prt.pdf'>aai_prt.pdf TUR GEWASIN O BAIBASIT BOUBUN (6 in x 9 in monochrome) 401 pages</a></li>
					<li><a href='aai_book.pdf'>aai_book.pdf TUR GEWASIN O BAIBASIT BOUBUN (135mm x 211 mm color) 331 pages</a></li>
					<li><a href='aai_MAT.pdf'>aai_MAT.pdf Matthew 121 pages</a></li>
					<li><a href='aai_MRK.pdf'>aai_MRK.pdf Mark 70 pages</a></li>
					<li><a href='aai_LUK.pdf'>aai_LUK.pdf Luke 125 pages</a></li>
					<li><a href='aai_JHN.pdf'>aai_JHN.pdf John 86 pages</a></li>
					<li><a href='aai_ACT.pdf'>aai_ACT.pdf Acts 112 pages</a></li>
					<li><a href='aai_ROM.pdf'>aai_ROM.pdf Romans 52 pages</a></li>
					<li><a href='aai_1CO.pdf'>aai_1CO.pdf 1 Corinthians 51 pages</a></li>
					<li><a href='aai_2CO.pdf'>aai_2CO.pdf 2 Corinthians 32 pages</a></li>
					<li><a href='aai_GAL.pdf'>aai_GAL.pdf Galatians 20 pages</a></li>
					<li><a href='aai_EPH.pdf'>aai_EPH.pdf Ephesians 20 pages</a></li>
					<li><a href='aai_PHP.pdf'>aai_PHP.pdf Philippians 15 pages</a></li>
					<li><a href='aai_COL.pdf'>aai_COL.pdf Colossians 15 pages</a></li>
					<li><a href='aai_1TH.pdf'>aai_1TH.pdf 1 Thessalonians 13 pages</a></li>
					<li><a href='aai_2TH.pdf'>aai_2TH.pdf 2 Thessalonians 8 pages</a></li>
					<li><a href='aai_1TI.pdf'>aai_1TI.pdf 1 Timothy 15 pages</a></li>
					<li><a href='aai_2TI.pdf'>aai_2TI.pdf 2 Timothy 12 pages</a></li>
					<li><a href='aai_TIT.pdf'>aai_TIT.pdf Titus 8 pages</a></li>
					<li><a href='aai_PHM.pdf'>aai_PHM.pdf Philemon 5 pages</a></li>
					<li><a href='aai_HEB.pdf'>aai_HEB.pdf Hebrews 41 pages</a></li>
					<li><a href='aai_JAS.pdf'>aai_JAS.pdf James 15 pages</a></li>
					<li><a href='aai_1PE.pdf'>aai_1PE.pdf 1 Peter 17 pages</a></li>
					<li><a href='aai_2PE.pdf'>aai_2PE.pdf 2 Peter 11 pages</a></li>
					<li><a href='aai_1JN.pdf'>aai_1JN.pdf 1 John 15 pages</a></li>
					<li><a href='aai_2JN.pdf'>aai_2JN.pdf 2 John 3 pages</a></li>
					<li><a href='aai_3JN.pdf'>aai_3JN.pdf 3 John 4 pages</a></li>
					<li><a href='aai_JUD.pdf'>aai_JUD.pdf Jude 6 pages</a></li>
					<li><a href='aai_REV.pdf'>aai_REV.pdf Revelation 59 pages</a></li>
					<li><a href='aai_XXD.pdf'>aai_XXD.pdf Read the New Testament 15 pages</a></li>
					<li><a href='aai_GLO.pdf'>aai_GLO.pdf glossary 13 pages</a></li>
					*/
				}
			}
			echo '</select>';
		}
		echo '<br />&nbsp;&nbsp;•&nbsp;<span class="lineAction">'.translate('Download', $st, 'sys').'</span> - '.translate('Modules', $st, 'sys').':';
		if ($mobile == 1) {
			echo "<br />";
		}
		else {
			echo " ";
		}
		echo "<select class='selectOption' name='modules_eBible' onchange='if (this.options[this.selectedIndex].text != \"".translate('Choose One...', $st, 'sys')."\") { window.open(this.options[this.selectedIndex].value, \"_blank\"); }'>";
		echo '<option class="selectOption">'.translate('Choose One...', $st, 'sys').'</option>';
		if ($epub != '') {
			echo '<option class="selectOption" value=' . $epub . '>' . translate('epub format', $st, 'sys').'</option>';
		}
		if ($mobi != '') {
			echo '<option class="selectOption" value=' . $mobi . '>' . translate('Kindle format', $st, 'sys').'</option>';
		}
		if ($sword != '') {
			echo '<option class="selectOption" value=' . $sword . '>' . translate('Crosswire Sword format', $st, 'sys').'</option>';
		}
		echo '</select>';
		echo '</form>';
		echo $inScript;
	}
	echo "<div>&nbsp;&nbsp;•&nbsp;<a href='https://$URL/'". ' target="_blank"><span class="lineAction">'.translate('Go to', $st, 'sys').'</span> - eBible.org</a></div>';
?>
</body>
</html>