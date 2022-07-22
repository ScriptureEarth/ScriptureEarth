<?php
// Change PHP.ini from max_input_vars = 1000 to max_input_vars = 3000 because POST has to be set for 3000!
include './include/session.php';
global $session;
/* Login attempt */
$retval = $session->checklogin();
if (!$retval) {
	echo "<br /><div style='text-align: center; font-size: 16pt; font-weight: bold; padding: 10px; color: navy; background-color: #dddddd; '>You are not logged in!</div>";
	/* Link back to main */
	header("Location: login.php");
	exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Create txt using Jesus Film API with scripture_main table ISOs</title>
<style type="text/css">
	html, body {
		font: 100% Verdana, Arial, Helvetica, sans-serif;
		color: black;
		background-color: lightGrey;
		height: 100%;
		margin: 5px;
		padding: 5px;
	}
	a, a:hover, a:link, a:active {
		color: navy;
		text-decoration: none;
		border-style: none;
	}
</style>
</head>
<body>
<?php
/*
    1. call http://api.arclight.org/v2/media-languages?apiKey=586ff4f28bd3b1.25434678&metadataLanguageTags=en&iso3=amu
    2. do a search for "languageId" and save the number which is "8351"
    3. call https://api.arclight.org/v2/media-components?apiKey=586ff4f28bd3b1.25434678&subTypes=featureFilm&languageIds=8351&metadataLanguageTags=en
    4. do a search for "title" = "JESUS" and if found then save "mediaComponentId" above which is "1_jf-0-0"
    5. call https://api.arclight.org/v2/media-components/1_jf-0-0/languages/8351?apiKey=586ff4f28bd3b1.25434678&metadataLanguageTags=en&platform=web
    6. do a search for "shareUrl" and if found call the linked URL is this case, "https://arc.gt/ghq0i?apiSessionId=58a232fe3e51a8.25642453"
*/

if (isset($_GET['ISO'])) {
	$ISO = $_GET["ISO"];	//$_POST['ISO'];
	if (!preg_match('/^([a-z]{3})$/', $ISO)) {
		die('Die hacker!</body></html>');
	}
	
	require_once 'include/conn.inc.php';								// connect to the database named 'scripture'
	$db = get_my_db();
	
	$languageId = [];													// initialize array
	$mediaComponentId = [];												// initialize array
	$mediaComponentId_mag = [];
	$mediaComponentId_sto = [];
	$languageId_jes = [];												// initialize array
	$languageId_mag = [];												// initialize array
	$languageId_sto = [];												// initialize array
	$LN = [];															// initialize array
	$LN_jes = [];
	$LN_mag = [];
	$LN_sto = [];
	$FileData = 0;

	//require_once 'include/conn.inc.php';								// connect to the database named 'scripture'
	//$db = get_my_db();
	
	$query="SELECT ISO FROM scripture_main WHERE ISO = '$ISO'";
	$result=$db->query($query);
	$num_rows = mysqli_num_rows($result);
	if ($num_rows > 0) {
		$FileData = 1;
	}
	
	try {
		$json = file_get_contents('http://api.arclight.org/v2/media-languages?apiKey=586ff4f28bd3b1.25434678&metadataLanguageTags=en&iso3=' . $ISO);
	}
	catch (customException $e) {
		echo '<br /><div style="color: red; font-size: 16pt; margin-left: 20px; font: 100% Verdana, Arial, Helvetica, sans-serif; ">Jesus Film video for ' . $ISO . ' isn\'t found.</div>';
		$json = FALSE;
	}
	
	if ($json === FALSE) {
		echo '<br /><div style="color: red; font-size: 16pt; margin-left: 20px; font: 100% Verdana, Arial, Helvetica, sans-serif; ">Jesus Film video for ' . $ISO . ' isn\'t found.</div>';
	}
	else {
		$data = json_decode($json, true);											// json_decode is json data
		foreach ($data['_embedded']['mediaLanguages'] as $a => $value) {
			$languageId[$a] = $data['_embedded']['mediaLanguages'][$a]['languageId'];
			$LN[$a] = $data['_embedded']['mediaLanguages'][$a]['name'];
		}
		
		$comma_separated_language = implode(",", $languageId);						// array to one string separated by ','s
		
		$jes = 0;
		$mag = 0;
		$sto = 0;
		
		for ($i=0; $i<count($languageId); $i++) {
			$json = file_get_contents('https://api.arclight.org/v2/media-components?apiKey=586ff4f28bd3b1.25434678&subTypes=featureFilm&languageIds=' . $languageId[$i] . '&metadataLanguageTags=en');
			$data = json_decode($json, true);											// json_decode is json data
			foreach ($data['_embedded']['mediaComponents'] as $a => $value) {			// in case there are more then one ROD_Code
				if ($data['_embedded']['mediaComponents'][$a]['title'] == 'JESUS') {
					$mediaComponentId[$jes] = $data['_embedded']['mediaComponents'][$a]['mediaComponentId'];
					$languageId_jes[$jes] = $languageId[$i];
					$LN_jes[$jes] = $LN[$i];
					$jes++;
				}
				//if ($data['_embedded']['mediaComponents'][$a]['title'] == "Magdalena") {
				if (preg_match('/magdalena/i', $data['_embedded']['mediaComponents'][$a]['title'])) {
					$mediaComponentId_mag[$mag] = $data['_embedded']['mediaComponents'][$a]['mediaComponentId'];
					$languageId_mag[$mag] = $languageId[$i];
					$LN_mag[$mag] = $LN[$i];
					$mag++;
				}
				if ($data['_embedded']['mediaComponents'][$a]['title'] == 'The Story of JESUS for Children') {
					$mediaComponentId_sto[$sto] = $data['_embedded']['mediaComponents'][$a]['mediaComponentId'];
					$languageId_sto[$sto] = $languageId[$i];
					$LN_sto[$sto] = $LN[$i];
					$sto++;
				}
			}
		}
		
		if ($FileData == 1) {
			$handle = fopen('data/' . $ISO . '/JesusFilmAPI_JESUS.txt', "w");		// Open for writing only; placing the file pointer at the end of the file. 
		}
		else {
			$handle = fopen('data/' . $ISO . '-JesusFilmAPI_JESUS.txt', "w");		// Open for writing only; placing the file pointer at the end of the file. 
		}
		for ($i=0; $i<count($mediaComponentId); $i++) {
			//for ($j=0; $j<count($languageId_jes); $j++) {
				$html = '';
				$json = file_get_contents('https://api.arclight.org/v2/media-components/' . $mediaComponentId[$i] . '/languages/' . $languageId_jes[$i] . '?apiKey=586ff4f28bd3b1.25434678&metadataLanguageTags=en&platform=web');
				$data = json_decode($json, true);									// json_decode is json data
				//$html = $data['shareUrl'];
				/*$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $data['shareUrl']);
				curl_setopt($ch, CURLOPT_HEADER, TRUE);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
				$a = curl_exec($ch);*/
				if ($i == 0)
					for ($n = 0; $n < 50; $n++) echo "\r\n";						// clears the screen
//echo $a . '<br />';
				/*if (preg_match('/location: (.+\.html\/.+\.html)/', $a, $r)) {
					$html = trim($r[1]);
				}*/
				/*else {
					echo 'skipped because $html is empty: '.$mediaComponentId[$i].'<br />';
					continue;
				}*/
				$html = 'https://www.jesusfilm.org/watch/jesus.html/' . $LN_jes[$i] . '.html';
				echo '<a href="' . $html . '" target="_blank">JESUS: ' . $ISO . ' : '  . $html . ' : ' . $LN_jes[$i] . ' : ' . $mediaComponentId[$i] . ' : ' . $languageId_jes[$i] . '</a><br />';
				fwrite($handle, '<a href="' . $html . '" target="_blank">JESUS</a> ' . $ISO . ' : ' . $html . ' : ' . $LN_jes[$i] . ' : ' . $mediaComponentId[$i] . ' : ' . $languageId_jes[$i] . PHP_EOL);

				// create JESUSFilm txt files
				
				if (!is_dir('data/' . $ISO)) {
					echo 'data/'. $ISO . ' does not exits. Are you running local?<br />';
					continue;
				}
				
				if ($FileData == 1) {
					$txtFilename = fopen('data/' . $ISO . '/JESUSFilm-' . $ISO . '.en.' . $mediaComponentId[$i] . '.' . $languageId_jes[$i] . '.txt', "w");		// Open for writing only; placing the file pointer at the end of the file. 
				}
				else {
					$txtFilename = fopen('data/' . $ISO . '-JESUSFilm-' . $ISO . '.en.' . $mediaComponentId[$i] . '.' . $languageId_jes[$i] . '.txt', "w");		// Open for writing only; placing the file pointer at the end of the file. 
				}
				$a = 0;
				$template_lines = file('Bible_links/API_JesusFilm_VideoPlaylist/JESUSFilm-template_en.txt');
				foreach ($template_lines as $template_line_num => $template_line) {
					if ($a == 0) {
						$replace = preg_replace('/(.*)\[Language Name\](.*)/', "$1$LN_jes[$i]$2", $template_line);
						$replace = preg_replace('/(.*)\[ISO\](.*)/', "$1[$ISO]$2", $replace);
						$replace = preg_replace('/(.*)(\r\n|\r)$/', "$1\n", $replace);								// change Mac CR to Linux LN
						fwrite($txtFilename, $replace);			// Based on the fact that the check if the filename exists I will do ">>" instead of ">" and a 'dir" and find the size greater that the ones which had only set.
						$a = 1;
					}
					else {
						//$langName = str_replace(', ', '-', $LN_jes[$i]);
						//$langName = preg_replace('/,? /', '-', $LN_jes[$i]);
						//$langName = mb_strtolower($langName,'UTF-8');
//echo $html . '<br />';
						//preg_match('/.+\.html\/(.+)\.html/', $html, $match);
						//$replace = preg_replace('/(.*)\[language name\]\.html/', "$1${langName}.html", $template_line);
						$replace = preg_replace('/(.*)\[language name\]\.html/', "$1$LN_jes[$i].html", $template_line);
						$replace = preg_replace('/(.*)(\r\n|\r)$/', "$1\n", $replace);								// change Mac CR to Linux LN
						fwrite($txtFilename, $replace);
					}
				}
				fclose($txtFilename);
				
				if ($FileData == 1) {
					$txtFilename = fopen('data/' . $ISO . '/JESUSFilm-' . $ISO . '.es.' . $mediaComponentId[$i] . '.' . $languageId_jes[$i] . '.txt', "w");		// Open for writing only; placing the file pointer at the end of the file. 
				}
				else {
					$txtFilename = fopen('data/' . $ISO . '-JESUSFilm-' . $ISO . '.es.' . $mediaComponentId[$i] . '.' . $languageId_jes[$i] . '.txt', "w");		// Open for writing only; placing the file pointer at the end of the file. 
				}
				$a = 0;
				$template_lines = file('Bible_links/API_JesusFilm_VideoPlaylist/JESUSFilm-template_es.txt');
				foreach ($template_lines as $template_line_num => $template_line) {
					if ($a == 0) {
						$replace = preg_replace('/(.*)\[Language Name\](.*)/', "$1$LN_jes[$i]$2", $template_line);
						$replace = preg_replace('/(.*)\[ISO\](.*)/', "$1[$ISO]$2", $replace);
						$replace = preg_replace('/(.*)(\r\n|\r)$/', "$1\n", $replace);								// change Mac CR to Linux LN
						fwrite($txtFilename, $replace);			// Based on the fact that the check if the filename exists I will do ">>" instead of ">" and a 'dir" and find the size greater that the ones which had only set.
						$a = 1;
					}
					else {
						//$langName = str_replace(', ', '-', $LN_jes[$i]);
						//$langName = preg_replace('/,? /', '-', $LN_jes[$i]);
						//$langName = mb_strtolower($langName,'UTF-8');
						//preg_match('/.+\.html\/(.+)\.html/', $html, $match);
						//$replace = preg_replace('/(.*)\[language name\]\.html/', "$1${langName}.html", $template_line);
						$replace = preg_replace('/(.*)\[language name\]\.html/', "$1$LN_jes[$i].html", $template_line);
						$replace = preg_replace('/(.*)(\r\n|\r)$/', "$1\n", $replace);								// change Mac CR to Linux LN
						fwrite($txtFilename, $replace);
					}
				}
				fclose($txtFilename);
				
				if ($FileData == 1) {
					$txtFilename = fopen('data/' . $ISO . '/JESUSFilm-' . $ISO . '.pt.' . $mediaComponentId[$i] . '.' . $languageId_jes[$i] . '.txt', "w");		// Open for writing only; placing the file pointer at the end of the file. 
				}
				else {
					$txtFilename = fopen('data/' . $ISO . '-JESUSFilm-' . $ISO . '.pt.' . $mediaComponentId[$i] . '.' . $languageId_jes[$i] . '.txt', "w");		// Open for writing only; placing the file pointer at the end of the file. 
				}
				$a = 0;
				$template_lines = file('Bible_links/API_JesusFilm_VideoPlaylist/JESUSFilm-template_pt.txt');
				foreach ($template_lines as $template_line_num => $template_line) {
					if ($a == 0) {
						$replace = preg_replace('/(.*)\[Language Name\](.*)/', "$1$LN_jes[$i]$2", $template_line);
						$replace = preg_replace('/(.*)\[ISO\](.*)/', "$1[$ISO]$2", $replace);
						$replace = preg_replace('/(.*)(\r\n|\r)$/', "$1\n", $replace);								// change Mac CR to Linux LN
						fwrite($txtFilename, $replace);			// Based on the fact that the check if the filename exists I will do ">>" instead of ">" and a 'dir" and find the size greater that the ones which had only set.
						$a = 1;
					}
					else {
						//$langName = str_replace(', ', '-', $LN_jes[$i]);
						//$langName = preg_replace('/,? /', '-', $LN_jes[$i]);
						//$langName = mb_strtolower($langName,'UTF-8');
						//preg_match('/.+\.html\/(.+)\.html/', $html, $match);
						//$replace = preg_replace('/(.*)\[language name\]\.html/', "$1${langName}.html", $template_line);
						$replace = preg_replace('/(.*)\[language name\]\.html/', "$1$LN_jes[$i].html", $template_line);
						$replace = preg_replace('/(.*)(\r\n|\r)$/', "$1\n", $replace);								// change Mac CR to Linux LN
						fwrite($txtFilename, $replace);
					}
				}
				fclose($txtFilename);
				
				if ($FileData == 1) {
					$txtFilename = fopen('data/' . $ISO . '/JESUSFilm-' . $ISO . '.fr.' . $mediaComponentId[$i] . '.' . $languageId_jes[$i] . '.txt', "w");		// Open for writing only; placing the file pointer at the end of the file. 
				}
				else {
					$txtFilename = fopen('data/' . $ISO . '-JESUSFilm-' . $ISO . '.fr.' . $mediaComponentId[$i] . '.' . $languageId_jes[$i] . '.txt', "w");		// Open for writing only; placing the file pointer at the end of the file. 
				}
				$a = 0;
				$template_lines = file('Bible_links/API_JesusFilm_VideoPlaylist/JESUSFilm-template_fr.txt');
				foreach ($template_lines as $template_line_num => $template_line) {
					if ($a == 0) {
						$replace = preg_replace('/(.*)\[Language Name\](.*)/', "$1$LN_jes[$i]$2", $template_line);
						$replace = preg_replace('/(.*)\[ISO\](.*)/', "$1[$ISO]$2", $replace);
						$replace = preg_replace('/(.*)(\r\n|\r)$/', "$1\n", $replace);								// change Mac CR to Linux LN
						fwrite($txtFilename, $replace);			// Based on the fact that the check if the filename exists I will do ">>" instead of ">" and a 'dir" and find the size greater that the ones which had only set.
						$a = 1;
					}
					else {
						//$langName = str_replace(', ', '-', $LN_jes[$i]);
						//$langName = preg_replace('/,? /', '-', $LN_jes[$i]);
						//$langName = mb_strtolower($langName,'UTF-8');
						//preg_match('/.+\.html\/(.+)\.html/', $html, $match);
						//$replace = preg_replace('/(.*)\[language name\]\.html/', "$1${langName}.html", $template_line);
						$replace = preg_replace('/(.*)\[language name\]\.html/', "$1$LN_jes[$i].html", $template_line);
						$replace = preg_replace('/(.*)(\r\n|\r)$/', "$1\n", $replace);								// change Mac CR to Linux LN
						fwrite($txtFilename, $replace);
					}
				}
				fclose($txtFilename);
				
				if ($FileData == 1) {
					$txtFilename = fopen('data/' . $ISO . '/JESUSFilm-' . $ISO . '.nl.' . $mediaComponentId[$i] . '.' . $languageId_jes[$i] . '.txt', "w");		// Open for writing only; placing the file pointer at the end of the file. 
				}
				else {
					$txtFilename = fopen('data/' . $ISO . '-JESUSFilm-' . $ISO . '.nl.' . $mediaComponentId[$i] . '.' . $languageId_jes[$i] . '.txt', "w");		// Open for writing only; placing the file pointer at the end of the file. 
				}
				$a = 0;
				$template_lines = file('Bible_links/API_JesusFilm_VideoPlaylist/JESUSFilm-template_nl.txt');
				foreach ($template_lines as $template_line_num => $template_line) {
					if ($a == 0) {
						$replace = preg_replace('/(.*)\[Language Name\](.*)/', "$1$LN_jes[$i]$2", $template_line);
						$replace = preg_replace('/(.*)\[ISO\](.*)/', "$1[$ISO]$2", $replace);
						$replace = preg_replace('/(.*)(\r\n|\r)$/', "$1\n", $replace);								// change Mac CR to Linux LN
						fwrite($txtFilename, $replace);			// Based on the fact that the check if the filename exists I will do ">>" instead of ">" and a 'dir" and find the size greater that the ones which had only set.
						$a = 1;
					}
					else {
						//$langName = str_replace(', ', '-', $LN_jes[$i]);
						//$langName = preg_replace('/,? /', '-', $LN_jes[$i]);
						//$langName = mb_strtolower($langName,'UTF-8');
						//preg_match('/.+\.html\/(.+)\.html/', $html, $match);
						//$replace = preg_replace('/(.*)\[language name\]\.html/', "$1${langName}.html", $template_line);
						$replace = preg_replace('/(.*)\[language name\]\.html/', "$1$LN_jes[$i].html", $template_line);
						$replace = preg_replace('/(.*)(\r\n|\r)$/', "$1\n", $replace);								// change Mac CR to Linux LN
						fwrite($txtFilename, $replace);
					}
				}
				fclose($txtFilename);
				
				if ($FileData == 1) {
					$txtFilename = fopen('data/' . $ISO . '/JESUSFilm-' . $ISO . '.de.' . $mediaComponentId[$i] . '.' . $languageId_jes[$i] . '.txt', "w");		// Open for writing only; placing the file pointer at the end of the file. 
				}
				else {
					$txtFilename = fopen('data/' . $ISO . '-JESUSFilm-' . $ISO . '.de.' . $mediaComponentId[$i] . '.' . $languageId_jes[$i] . '.txt', "w");		// Open for writing only; placing the file pointer at the end of the file. 
				}
				$a = 0;
				$template_lines = file('Bible_links/API_JesusFilm_VideoPlaylist/JESUSFilm-template_de.txt');
				foreach ($template_lines as $template_line_num => $template_line) {
					if ($a == 0) {
						$replace = preg_replace('/(.*)\[Language Name\](.*)/', "$1$LN_jes[$i]$2", $template_line);
						$replace = preg_replace('/(.*)\[ISO\](.*)/', "$1[$ISO]$2", $replace);
						$replace = preg_replace('/(.*)(\r\n|\r)$/', "$1\n", $replace);								// change Mac CR to Linux LN
						fwrite($txtFilename, $replace);			// Based on the fact that the check if the filename exists I will do ">>" instead of ">" and a 'dir" and find the size greater that the ones which had only set.
						$a = 1;
					}
					else {
						//$langName = str_replace(', ', '-', $LN_jes[$i]);
						//$langName = preg_replace('/,? /', '-', $LN_jes[$i]);
						//$langName = mb_strtolower($langName,'UTF-8');
						//preg_match('/.+\.html\/(.+)\.html/', $html, $match);
						//$replace = preg_replace('/(.*)\[language name\]\.html/', "$1${langName}.html", $template_line);
						$replace = preg_replace('/(.*)\[language name\]\.html/', "$1$LN_jes[$i].html", $template_line);
						$replace = preg_replace('/(.*)(\r\n|\r)$/', "$1\n", $replace);								// change Mac CR to Linux LN
						fwrite($txtFilename, $replace);
					}
				}
				fclose($txtFilename);

			//}
		}
		fclose($handle);
		echo '<br />';
		
		if ($FileData == 1) {
			$handle = fopen('data/' . $ISO . '/JesusFilmAPI_Magdalena.txt', "w");		// Open for writing only; placing the file pointer at the end of the file. 
		}
		else {
			$handle = fopen('data/' . $ISO . '-JesusFilmAPI_Magdalena.txt', "w");		// Open for writing only; placing the file pointer at the end of the file. 
		}
		for ($mag=0; $mag<count($mediaComponentId_mag); $mag++) {
			//for ($j=0; $j<count($languageId_mag); $j++) {
				$html = '';
				$json = file_get_contents('https://api.arclight.org/v2/media-components/' . $mediaComponentId_mag[$mag] . '/languages/' . $languageId_mag[$mag] . '?apiKey=586ff4f28bd3b1.25434678&metadataLanguageTags=en&platform=web');
				$data = json_decode($json, true);										// json_decode is json data
				//$html = $data['shareUrl'];
				/*$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $data['shareUrl']);
				curl_setopt($ch, CURLOPT_HEADER, TRUE);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
				$a = curl_exec($ch);*/
				/*if (preg_match('/location: (.+\.html\/.+\.html)/', $a, $r)) {
					$html = trim($r[1]);
				}
				else {
					echo 'skipped because $html is empty: '.$mediaComponentId[$i].'<br />';
					continue;
				}*/
				$html = 'https://www.jesusfilm.org/watch/magdalena.html/' . $LN_mag[$mag] . '.html';
				echo '<a href="' . $html . '" target="_blank">Magdalena: ' . $ISO . ' : ' . $html . ' : ' . $LN_mag[$mag] . ' : ' . $mediaComponentId_mag[$mag] . ' : ' . $languageId_mag[$mag] . '</a><br />';
				fwrite($handle, '<a href="' . $html . '" target="_blank">Magdalena</a> ' . $ISO . ' : ' . $html . ' : ' . $LN_mag[$mag] . ' : ' . $mediaComponentId_mag[$mag] . ' : ' . $languageId_mag[$mag] . PHP_EOL);
			//}
		/*
		}
		fclose($handle);
		if ($FileData == 1) {
			if (filesize('data/' . $ISO . '/JesusFilmAPI_Magdalena.txt') == 0) {
				unlink('data/' . $ISO . '/JesusFilmAPI_Magdalena.txt');
			}
		}
		else {
			if (filesize('data/' . $ISO . '-JesusFilmAPI_Magdalena.txt') == 0) {
				unlink('data/' . $ISO . '-JesusFilmAPI_Magdalena.txt');
			}
		}
		*/
				// create Magdalena txt files
				
				if ($FileData == 1) {
					$txtFilename = fopen('data/' . $ISO . '/Magdalena-' . $ISO . '.en.' . $mediaComponentId_mag[$mag] . '.' . $languageId_mag[$mag] . '.txt', "w");		// Open for writing only; placing the file pointer at the end of the file. 
				}
				else {
					$txtFilename = fopen('data/' . $ISO . '-Magdalena-' . $ISO . '.en.' . $mediaComponentId_mag[$mag] . '.' . $languageId_mag[$mag] . '.txt', "w");		// Open for writing only; placing the file pointer at the end of the file. 
				}
				$a = 0;
				$template_lines = file('Bible_links/API_Magdalena_VideoPlaylist/Magdalena-template_en.txt');
				
				foreach ($template_lines as $template_line_num => $template_line) {
					if ($a == 0) {
						$replace = preg_replace('/(.*)\[Language Name\](.*)/', "$1$LN_mag[$mag]$2", $template_line);
						$replace = preg_replace('/(.*)\[ISO\](.*)/', "$1[$ISO]$2", $replace);
						$replace = preg_replace('/(.*)(\r\n|\r)$/', "$1\n", $replace);								// change Mac CR to Linux LN
						fwrite($txtFilename, $replace);			// Based on the fact that the check if the filename exists I will do ">>" instead of ">" and a 'dir" and find the size greater that the ones which had only set.
						$a = 1;
					}
					else {
						//$langName = str_replace(', ', '-', $LN_mag[$mag]);
						$langName = preg_replace('/,? /', '-', $LN_mag[$mag]);
						$langName = mb_strtolower($langName,'UTF-8');
						//preg_match('/.+\.html\/(.+)\.html/', $html, $match);
						$replace = preg_replace('/(.*)\[language name\]\.html/', "$1${langName}.html", $template_line);
						$replace = preg_replace('/(.*)(\r\n|\r)$/', "$1\n", $replace);								// change Mac CR to Linux LN
						fwrite($txtFilename, $replace);
					}
				}
				fclose($txtFilename);
				
				if ($FileData == 1) {
					$txtFilename = fopen('data/' . $ISO . '/Magdalena-' . $ISO . '.es.' . $mediaComponentId_mag[$mag] . '.' . $languageId_mag[$mag] . '.txt', "w");		// Open for writing only; placing the file pointer at the end of the file. 
				}
				else {
					$txtFilename = fopen('data/' . $ISO . '-Magdalena-' . $ISO . '.es.' . $mediaComponentId_mag[$mag] . '.' . $languageId_mag[$mag] . '.txt', "w");		// Open for writing only; placing the file pointer at the end of the file. 
				}
				$a = 0;
				$template_lines = file('Bible_links/API_Magdalena_VideoPlaylist/Magdalena-template_es.txt');
				foreach ($template_lines as $template_line_num => $template_line) {
					if ($a == 0) {
						$replace = preg_replace('/(.*)\[Language Name\](.*)/', "$1$LN_mag[$mag]$2", $template_line);
						$replace = preg_replace('/(.*)\[ISO\](.*)/', "$1[$ISO]$2", $replace);
						$replace = preg_replace('/(.*)(\r\n|\r)$/', "$1\n", $replace);								// change Mac CR to Linux LN
						fwrite($txtFilename, $replace);			// Based on the fact that the check if the filename exists I will do ">>" instead of ">" and a 'dir" and find the size greater that the ones which had only set.
						$a = 1;
					}
					else {
						//$langName = str_replace(', ', '-', $LN_mag[$mag]);
						$langName = preg_replace('/,? /', '-', $LN_mag[$mag]);
						$langName = mb_strtolower($langName,'UTF-8');
						//preg_match('/.+\.html\/(.+)\.html/', $html, $match);
						$replace = preg_replace('/(.*)\[language name\]\.html/', "$1${langName}.html", $template_line);
						$replace = preg_replace('/(.*)(\r\n|\r)$/', "$1\n", $replace);								// change Mac CR to Linux LN
						fwrite($txtFilename, $replace);
					}
				}
				fclose($txtFilename);
				
				if ($FileData == 1) {
					$txtFilename = fopen('data/' . $ISO . '/Magdalena-' . $ISO . '.pt.' . $mediaComponentId_mag[$mag] . '.' . $languageId_mag[$mag] . '.txt', "w");		// Open for writing only; placing the file pointer at the end of the file. 
				}
				else {
					$txtFilename = fopen('data/' . $ISO . '-Magdalena-' . $ISO . '.pt.' . $mediaComponentId_mag[$mag] . '.' . $languageId_mag[$mag] . '.txt', "w");		// Open for writing only; placing the file pointer at the end of the file. 
				}
				$a = 0;
				$template_lines = file('Bible_links/API_Magdalena_VideoPlaylist/Magdalena-template_pt.txt');
				foreach ($template_lines as $template_line_num => $template_line) {
					if ($a == 0) {
						$replace = preg_replace('/(.*)\[Language Name\](.*)/', "$1$LN_mag[$mag]$2", $template_line);
						$replace = preg_replace('/(.*)\[ISO\](.*)/', "$1[$ISO]$2", $replace);
						$replace = preg_replace('/(.*)(\r\n|\r)$/', "$1\n", $replace);								// change Mac CR to Linux LN
						fwrite($txtFilename, $replace);			// Based on the fact that the check if the filename exists I will do ">>" instead of ">" and a 'dir" and find the size greater that the ones which had only set.
						$a = 1;
					}
					else {
						//$langName = str_replace(', ', '-', $LN_mag[$mag]);
						$langName = preg_replace('/,? /', '-', $LN_mag[$mag]);
						$langName = mb_strtolower($langName,'UTF-8');
						//preg_match('/.+\.html\/(.+)\.html/', $html, $match);
						$replace = preg_replace('/(.*)\[language name\]\.html/', "$1${langName}.html", $template_line);
						$replace = preg_replace('/(.*)(\r\n|\r)$/', "$1\n", $replace);								// change Mac CR to Linux LN
						fwrite($txtFilename, $replace);
					}
				}
				fclose($txtFilename);
				
				if ($FileData == 1) {
					$txtFilename = fopen('data/' . $ISO . '/Magdalena-' . $ISO . '.fr.' . $mediaComponentId_mag[$mag] . '.' . $languageId_mag[$mag] . '.txt', "w");		// Open for writing only; placing the file pointer at the end of the file. 
				}
				else {
					$txtFilename = fopen('data/' . $ISO . '-Magdalena-' . $ISO . '.fr.' . $mediaComponentId_mag[$mag] . '.' . $languageId_mag[$mag] . '.txt', "w");		// Open for writing only; placing the file pointer at the end of the file. 
				}
				$a = 0;
				$template_lines = file('Bible_links/API_Magdalena_VideoPlaylist/Magdalena-template_fr.txt');
				foreach ($template_lines as $template_line_num => $template_line) {
					if ($a == 0) {
						$replace = preg_replace('/(.*)\[Language Name\](.*)/', "$1$LN_mag[$mag]$2", $template_line);
						$replace = preg_replace('/(.*)\[ISO\](.*)/', "$1[$ISO]$2", $replace);
						$replace = preg_replace('/(.*)(\r\n|\r)$/', "$1\n", $replace);								// change Mac CR to Linux LN
						fwrite($txtFilename, $replace);			// Based on the fact that the check if the filename exists I will do ">>" instead of ">" and a 'dir" and find the size greater that the ones which had only set.
						$a = 1;
					}
					else {
						//$langName = str_replace(', ', '-', $LN_mag[$mag]);
						$langName = preg_replace('/,? /', '-', $LN_mag[$mag]);
						$langName = mb_strtolower($langName,'UTF-8');
						//preg_match('/.+\.html\/(.+)\.html/', $html, $match);
						$replace = preg_replace('/(.*)\[language name\]\.html/', "$1${langName}.html", $template_line);
						$replace = preg_replace('/(.*)(\r\n|\r)$/', "$1\n", $replace);								// change Mac CR to Linux LN
						fwrite($txtFilename, $replace);
					}
				}
				fclose($txtFilename);
				
				if ($FileData == 1) {
					$txtFilename = fopen('data/' . $ISO . '/Magdalena-' . $ISO . '.nl.' . $mediaComponentId_mag[$mag] . '.' . $languageId_mag[$mag] . '.txt', "w");		// Open for writing only; placing the file pointer at the end of the file. 
				}
				else {
					$txtFilename = fopen('data/' . $ISO . '-Magdalena-' . $ISO . '.nl.' . $mediaComponentId_mag[$mag] . '.' . $languageId_mag[$mag] . '.txt', "w");		// Open for writing only; placing the file pointer at the end of the file. 
				}
				$a = 0;
				$template_lines = file('Bible_links/API_Magdalena_VideoPlaylist/Magdalena-template_nl.txt');
				foreach ($template_lines as $template_line_num => $template_line) {
					if ($a == 0) {
						$replace = preg_replace('/(.*)\[Language Name\](.*)/', "$1$LN_mag[$mag]$2", $template_line);
						$replace = preg_replace('/(.*)\[ISO\](.*)/', "$1[$ISO]$2", $replace);
						$replace = preg_replace('/(.*)(\r\n|\r)$/', "$1\n", $replace);								// change Mac CR to Linux LN
						fwrite($txtFilename, $replace);			// Based on the fact that the check if the filename exists I will do ">>" instead of ">" and a 'dir" and find the size greater that the ones which had only set.
						$a = 1;
					}
					else {
						//$langName = str_replace(', ', '-', $LN_mag[$mag]);
						$langName = preg_replace('/,? /', '-', $LN_mag[$mag]);
						$langName = mb_strtolower($langName,'UTF-8');
						//preg_match('/.+\.html\/(.+)\.html/', $html, $match);
						$replace = preg_replace('/(.*)\[language name\]\.html/', "$1${langName}.html", $template_line);
						$replace = preg_replace('/(.*)(\r\n|\r)$/', "$1\n", $replace);								// change Mac CR to Linux LN
						fwrite($txtFilename, $replace);
					}
				}
				fclose($txtFilename);
				
				if ($FileData == 1) {
					$txtFilename = fopen('data/' . $ISO . '/Magdalena-' . $ISO . '.de.' . $mediaComponentId_mag[$mag] . '.' . $languageId_mag[$mag] . '.txt', "w");		// Open for writing only; placing the file pointer at the end of the file. 
				}
				else {
					$txtFilename = fopen('data/' . $ISO . '-Magdalena-' . $ISO . '.de.' . $mediaComponentId_mag[$mag] . '.' . $languageId_mag[$mag] . '.txt', "w");		// Open for writing only; placing the file pointer at the end of the file. 
				}
				$a = 0;
				$template_lines = file('Bible_links/API_Magdalena_VideoPlaylist/Magdalena-template_de.txt');
				foreach ($template_lines as $template_line_num => $template_line) {
					if ($a == 0) {
						$replace = preg_replace('/(.*)\[Language Name\](.*)/', "$1$LN_mag[$mag]$2", $template_line);
						$replace = preg_replace('/(.*)\[ISO\](.*)/', "$1[$ISO]$2", $replace);
						$replace = preg_replace('/(.*)(\r\n|\r)$/', "$1\n", $replace);								// change Mac CR to Linux LN
						fwrite($txtFilename, $replace);			// Based on the fact that the check if the filename exists I will do ">>" instead of ">" and a 'dir" and find the size greater that the ones which had only set.
						$a = 1;
					}
					else {
						//$langName = str_replace(', ', '-', $LN_mag[$mag]);
						$langName = preg_replace('/,? /', '-', $LN_mag[$mag]);
						$langName = mb_strtolower($langName,'UTF-8');
						//preg_match('/.+\.html\/(.+)\.html/', $html, $match);
						$replace = preg_replace('/(.*)\[language name\]\.html/', "$1${langName}.html", $template_line);
						$replace = preg_replace('/(.*)(\r\n|\r)$/', "$1\n", $replace);								// change Mac CR to Linux LN
						fwrite($txtFilename, $replace);
					}
				}
				fclose($txtFilename);

			//}
		}
		fclose($handle);
		
		echo '<br />';
		
		if ($FileData == 1) {
			$handle = fopen('data/' . $ISO . '/JesusFilmAPI_Story.txt', "w");		// Open for writing only; placing the file pointer at the end of the file. 
		}
		else {
			$handle = fopen('data/' . $ISO . '-JesusFilmAPI_Story.txt', "w");		// Open for writing only; placing the file pointer at the end of the file. 
		}
		for ($sto=0; $sto<count($mediaComponentId_sto); $sto++) {
			//for ($j=0; $j<count($languageId_sto); $j++) {
				$html = '';
				$json = file_get_contents('https://api.arclight.org/v2/media-components/' . $mediaComponentId_sto[$sto] . '/languages/' . $languageId_sto[$sto] . '?apiKey=586ff4f28bd3b1.25434678&metadataLanguageTags=en&platform=web');
				$data = json_decode($json, true);									// json_decode is json data
				//$html = $data['shareUrl'];
				/*$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $data['shareUrl']);
				curl_setopt($ch, CURLOPT_HEADER, TRUE);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
				$a = curl_exec($ch);*/
				/*if (preg_match('/location: (.+\.html\/.+\.html)/', $a, $r)) {
					$html = trim($r[1]);
				}
				else {
					echo 'skipped because $html is empty: '.$mediaComponentId[$i].'<br />';
					continue;
				}*/
				$html = 'https://www.jesusfilm.org/watch/the-story-of-jesus-for-children.html/' . $LN_sto[$sto] . '.html';
				echo '<a href="' . $html . '" target="_blank">Story: ' . $ISO . ' : '  . $html . ' : ' . $LN_sto[$sto] . ' : ' . $mediaComponentId_sto[$sto] . ' : ' . $languageId_sto[$sto] . '</a><br />';
				fwrite($handle, '<a href="' . $html . '" target="_blank">Story</a> ' . $ISO . ' : ' . $html . ' : ' . $LN_sto[$sto] . ' : ' . $mediaComponentId_sto[$sto] . ' : ' . $languageId_sto[$sto] . PHP_EOL);
			//}
		}
		fclose($handle);
		if ($FileData == 1) {
			if (filesize('data/' . $ISO . '/JesusFilmAPI_Story.txt') == 0) {
				unlink('data/' . $ISO . '/JesusFilmAPI_Story.txt');
			}
		}
		else {
			if (filesize('data/' . $ISO . '-JesusFilmAPI_Story.txt') == 0) {
				unlink('data/' . $ISO . '-JesusFilmAPI_Story.txt');
			}
		}
		
		/* if there is one one ISO then it should be ok to add this (and if it isn't a part of PlaylistVideo)
		$query="SELECT ROD_Code FROM scripture_main WHERE ISO = '$ISO' ORDER BY ROD_Code";
		$result_SM=$db->query($query);
		$num_rows = mysqli_num_rows($result_SM);
		if ($row_SM = $result_SM->fetch_array()) {								// and iterate ISO and Idioma from pueblos_idiomas_mexico table based on 'Languages'
			//$ISO = $row_SM['ISO'];
			$ROD_Code = $row_SM['ROD_Code'];
		}
		*/
    }
		?>
	<form name='myForm' action='#'>
		<br />
		<br />
		<div style='text-align: left; padding: 10px; '>
			<input type="submit" onclick="myOK()" value="OK" /><br />
		</div>
	</form>
	<div style="color: red; font-size: 16pt; margin-left: 20px; position: fixed; top: 450px; font: 100% Verdana, Arial, Helvetica, sans-serif; ">
        You have create a temporary solution. The temporary solution is based on the ISO code however it is the best one.<br />
        The five new txt files are at the subfolder called "data/[ISO code]" for the existing SE ISO codes,<br />
        or the subfolder called "data" for the non existent SE ISO codes. But those Jesus Film API videos don&rsquo;t have the ROD codes which is used by SE.<br />
        Examine the txt files to find out which ROD code to use. Then, rename the txt file and move it into "data/[ISO code]/video" subfolder.<br />
        In renaming the file don&rsquo;t use the ROD code part of the filename if it is no ROD code. In the first line of the txt change the name of the language if need be.<br />
        <br />
        In other words, when you find the ROD code you rename this filename and then move it to the subfolder called "video" underneath the ISO code.<br />
        In the end you will have:<br />
		&nbsp;&nbsp;&nbsp;data/[ISO code]/video/JESUSFilm-[ISO code].en.txt<br />
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;or<br />
        &nbsp;&nbsp;&nbsp;data/[ISO code]/video/JESUSFilm-[ISO code]([-ROD code]([-Variant code))].en.txt<br /><br />
        with each of other 4 navigational languages (es, pl, fr, and nl) in seperate file names.
        etc.
	</div>
	<script>
		function myOK() {
			window.location.assign("login.php");
		}
	</script>
    <?php
}
else {
	?>
    <form name='myForm' action='#'>
        <input type='text' style='color: navy; ' size='3' pattern="[a-z]{3}" title="Type the lowercase ISO code" name='ISO' id='ISO' value="" /> Search for the ISO code 
        <input type="submit" onclick="myISO(document.getElementById('ISO').value)" checked="checked" value="OK"> 
        <input type="button" onclick="myCancel()" value="Go back">
    </form>
    <script>
        function myISO(ISO) {
            document.body.innerHTML = "";
            document.write("<div style='color: red; font-size: 16pt; margin-left: 20px; position: fixed; top: 200px; font: 100% Verdana, Arial, Helvetica, sans-serif; '>Please wait...</div>");
            window.location.assign("JesusFilmAPI.php?ISO=" + ISO);
        }
        function myCancel() {
            window.location.assign("login.php");
        }
        window.onload = function() {
          document.getElementById("ISO").focus();
        };
    </script>
    <?php
	echo '<div style="color: red; font-size: 16pt; margin-left: 20px; position: fixed; top: 450px; font: 100% Verdana, Arial, Helvetica, sans-serif; ">';
	echo 'You are about to create an incomplete solution. This solution is only based on the language ISO code but without the ROD code<br />';
	echo 'since the Jesus Film doesn&rsquo;t have the ROD codes.<br />';
	echo 'This script will search through the whole Jesus Film website (i.e. API)<br />';
	echo 'and find the appropriate video(s). The five new txt files will be at the subfolder called "data/[ISO code]" for the existing SE ISO codes,<br />';
	echo 'or the subfolder called "data" for the non existent SE ISO codes. But those Jesus Film API videos don&rsquo;t have the ROD codes which is used by SE.<br />';
	echo 'You must examine the txt files and find out which ROD code to use. Then, rename the txt file and move it into "data/[ISO code]/video" subfolder.<br />';
	echo 'In renaming the file don&rsquo;t use the ROD code part of the filename if it is no ROD code. In the first line of the txt change the name of the language if need be.<br />';
	echo '<br />';
	echo 'In other words, when you find the ROD code you rename this filename and then move it to the subfolder called "video" underneath the ISO code.<br />';
	echo 'In the end you will have:<br />';
	echo '&nbsp;&nbsp;&nbsp;data/[ISO code]/video/JESUSFilm-[ISO code].en.txt<br />';
	echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;or<br />';
	echo '&nbsp;&nbsp;&nbsp;data/[ISO code]/video/JESUSFilm-[ISO code]([-ROD code]([-Variant code))].en.txt<br /><br />';
    echo 'with each of other 4 navigational languages (es, pl, fr, and nl) in seperate file names.';
	echo '</div>';
}

?>
</body>
</html>