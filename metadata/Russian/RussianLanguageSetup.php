<!DOCTYPE html>
<html>
<head>
<title>Russian Language Setup</title>
<meta http-equiv="Content-Type"  content="text/html; charset=utf-8" />
<meta http-equiv="Window-target" content="_top" />
<meta name="ObjectType"          content="Document" />
<meta name="ROBOTS"              content="NOINDEX" />
</head>
<body>
<?php
/*
The XML file for
Tom Van Wynen
Webmaster, Wycliffe Global Alliance
<?xml version="1.0" standalone="yes"?>
<scripture-earth-data>
	<language>
		<iso_code>acc</iso_code>
		<rod_code>00000</rod_code>
		<variant_code></variant_code>
		<language_name>Achi' de Cubulco</language_name>
	</language>
	<language>
		<iso_code>acr</iso_code>
		<rod_code>00000</rod_code>
		<variant_code>a</variant_code>
		<language_name>Achí, Rabinal</language_name>
	</language>
</scripture-earth-data>
*/

/************************************************************************************************
	declared variables
*************************************************************************************************/
$map_array[0][0] = '00000';		// declare the array here because later on do a array_push
$map_array[0][1] = '000';
$map_array[0][2] = '00000';
$ma = 0;

function check_input($value) {						// used for ' and " that find it in the input
	$value = trim($value);
	if (is_string($value)) {
		$value = implode("", explode("\\", $value));	// get rid of e.g. "\\\\\\\\\\\"
		$value = stripslashes($value);
	}
	// Quote if not a number
	if (!is_numeric($value)) {
		$db = get_my_db();
		$value = $db->real_escape_string($value);
	}
	return $value;
}

if (isset($_GET['noDisplay'])) {
	if ($_GET['noDisplay'] == 1)
		$Display = 0;
	else
		$Display = 1;
}
else
	$Display = 1;

include '../../include/conn.inc.php';
$db = get_my_db();

$fileFirstPart = 
'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Scripture Earth English Language Setup</title>
<meta http-equiv="Content-Type" 			content="text/html; charset=utf-8" />
<meta name="ObjectType" 					content="Document" />
<meta http-equiv="Window-target" 			content="_top" />
<meta name="Description" lang="en-US" 		content="
		Этот сайт предоставляет доступ к Библии (Писаниям Ветхого Завета и Нового Завета) на языках коренных народов:
		текстовые, аудио- и видеоформаты для загрузки на свое устройство или чтения онлайн. Ознакомьтесь с загрузками,
		программным обеспечением для изучения Библии, мобильными приложениями или закажите печатную версию.
	" />
<meta name="Keywords" lang="en-US" 			content="
		современные коренные языки, мир, язык сердца, родной язык, Bible.is, онлайн-просмотрщик, загрузка, родные языки,
		текст, PDF, аудио, MP3, mp3, MP4, mp4, iPod, iPhone, мобильный телефон, смартфон, iPad, планшет, android, смотреть,
		просматривать, фильм «Иисус», видео Евангелия от Луки, купить, распечатать по запросу, онлайн-покупка, книжный магазин,
		изучение, Слово, Библия, Новый Завет, NT, Ветхий Завет, OT, Писание, карта, приложение, мобильное приложение
	';
$fileSecondPart = '';
$fileThirdPart = '" />
<meta name="Created-by" 					content="Scott Starker" />
<meta name="Maintained-by" 					content="Website" />
<meta name="Approved-by" 					content="Bill Dyck, Access Coordinator" />
<meta name="Copyright" 						content="' . date('Y') . '" />
<style type="text/css">
#container {
	width: 980px;  /* using 20px less than a full 800px width allows for browser chrome and avoids a horizontal scroll bar */
	background-color: #FFFFFF;
	margin: 0 auto 0 auto; /* the auto margins (in conjunction with a width) center the page */
	padding-bottom: -20px;
	text-align: left; /* this overrides the text-align: center on the body element. */
}
</style>
</head>
<body>
<div id="container">
<img src="../../images/topBannerCompSplash.jpg" style="position: relative; top: 0px; z-index: 1; width: 100%; " /><br /><br />
&nbsp;&nbsp;&nbsp;&nbsp;·&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size: 10pt; font-style: italic; ">PDF<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;·&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Audio (<a href="http://www.faithcomesbyhearing.com/ambassador/free-audio-bible-download">Faith Comes By Hearing</a>)<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;·&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Video (<a href="http://www.inspirationalfilms.com/av/watch.html">The JESUS Film</a>)<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;·&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bible Study modules (<a href="http://www.theword.gr/">The Word</a>)<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;·&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Buy the book online (<a href="http://www.virtualstorehouse.org/">Virtual Storehouse</a>)</span><br /><br />
<span style="color: #003366; font-size: 11pt; "><span style="font-size: 14pt; font-weight: bold; ">Click</span> to find <span style="font-size: 12pt; font-weight: bold; ">SCRIPTURE RESOURCES</span> (New Testament or complete Bible) in the following languages…</span><br />';
$fileFourthPart = '';
$fileFifthPart = '</div>
</body>
</html>';

	if ($Display) {
		echo "<div style='background-color: white; padding: 20px; width: 800px; margin-left: auto; margin-right: auto; '>";
		echo "<h2 style='text-align: center; margin: 0px; color: navy; '>Scripture Earth Chinese Language Setup</h2><br /><br />";
	}
	
	$query = 'SELECT * FROM nav_ln ORDER BY ISO, ROD_Code';
	$result=$db->query($query) or die ('Query failed: ' . $db->error . '</body></html>');
	if (!$result) {
		die ("Cannot SELECT from 'nav_ln'. " . $db->error . '</body></html>');
	}
	$db->query('DROP TABLE IF EXISTS LN_Temp');
	$result_Temp = $db->query('CREATE TEMPORARY TABLE LN_Temp (ISO VARCHAR(3) NOT NULL, ROD_Code VARCHAR(5) NOT NULL, Variant_Code VARCHAR(1) NULL, LN VARCHAR(50) NOT NULL) ENGINE = MEMORY CHARSET = utf8')  or die ('Query failed: ' . $db->error . '</body></html>');
	//$i=0;
	$num=$result->num_rows;
	$query='SELECT LN_English FROM LN_English WHERE LN_English.ISO = ? AND LN_English.ROD_Code = ?';
	$stmt_LN_English=$db->prepare($query);																// create a prepared statement
	$query='SELECT LN_Spanish FROM LN_Spanish WHERE LN_Spanish.ISO = ? AND LN_Spanish.ROD_Code = ?';
	$stmt_LN_Spanish=$db->prepare($query);																// create a prepared statement
	$query='SELECT LN_Portuguese FROM LN_Portuguese WHERE LN_Portuguese.ISO = ? AND LN_Portuguese.ROD_Code = ?';
	$stmt_LN_Portuguese=$db->prepare($query);															// create a prepared statement
	$query='SELECT LN_French FROM LN_French WHERE LN_French.ISO = ? AND LN_French.ROD_Code = ?';
	$stmt_LN_French=$db->prepare($query);																// create a prepared statement
	$query='SELECT LN_Dutch FROM LN_Dutch WHERE LN_Dutch.ISO = ? AND LN_Dutch.ROD_Code = ?';
	$stmt_LN_Dutch=$db->prepare($query);																// create a prepared statement
	$query='SELECT LN_German FROM LN_German WHERE LN_German.ISO = ? AND LN_German.ROD_Code = ?';
	$stmt_LN_German=$db->prepare($query);																// create a prepared statement
	$query='SELECT LN_Chinese FROM LN_Chinese WHERE LN_Chinese.ISO = ? AND LN_Chinese.ROD_Code = ?';
	$stmt_LN_Chinese=$db->prepare($query);																// create a prepared statement
	$query='SELECT LN_Korean FROM LN_Korean WHERE LN_Korean.ISO = ? AND LN_Korean.ROD_Code = ?';
	$stmt_LN_Korean=$db->prepare($query);																// create a prepared statement
	$query='SELECT LN_Russian FROM LN_Russian WHERE LN_Russian.ISO = ? AND LN_Russian.ROD_Code = ?';
	$stmt_LN_Russian=$db->prepare($query);																// create a prepared statement
	$query='SELECT LN_Arabic FROM LN_Arabic WHERE LN_Arabic.ISO = ? AND LN_Arabic.ROD_Code = ?';
	$stmt_LN_Arabic=$db->prepare($query);																// create a prepared statement
	$query='INSERT INTO LN_Temp (ISO, ROD_Code, Variant_Code, LN) VALUES (?, ?, ?, ?)';
	$stmt_LN_Temp=$db->prepare($query);																	// create a prepared statement
	
	while ($row = $result->fetch_array()) {
		$ISO=$row['ISO'];								// ISO
		$ROD_Code=$row['ROD_Code'];						// ROD_Code
		$Variant_Code=$row['Variant_Code'];				// Variant_Code
		$LN_English=$row['LN_English'];					// boolean
		$LN_Spanish=$row['LN_Spanish'];					// boolean
		$LN_Portuguese=$row['LN_Portuguese'];			// boolean
		$LN_French=$row['LN_French'];					// boolean
		$LN_Dutch=$row['LN_Dutch'];						// boolean
		$LN_German=$row['LN_German'];					// boolean
		$LN_Chinese=$row['LN_Chinese'];					// boolean
		$LN_Korean=$row['LN_Korean'];					// boolean
		$LN_Russian=$row['LN_Russian'];					// boolean
		$LN_Arabic=$row['LN_Arabic'];					// boolean
		$def_LN=$row['Def_LN'];							// default langauge (a 2 digit number for the national langauge)

		if (!$LN_Russian) {								// if the English then the default langauge
			switch ($def_LN){
				case 1:
					//$query="SELECT LN_English FROM LN_English WHERE LN_English.ISO = '$ISO' AND LN_English.ROD_Code = '$ROD_Code'";
					//$result_LN=$db->query($query);
					$stmt_LN_English->bind_param('ss', $ISO, $ROD_Code);									// bind parameters for markers								// 
					$stmt_LN_English->execute();															// execute query
					$result_LN_English = $stmt_LN_English->get_result();									// instead of bind_result (used for only 1 record):
					$r = $result_LN_English->fetch_array();
					$LN=$r['LN_English'];
					break;
				case 2:
					//$query="SELECT LN_Spanish FROM LN_Spanish WHERE LN_Spanish.ISO = '$ISO' AND LN_Spanish.ROD_Code = '$ROD_Code'";
					//$result_LN=$db->query($query);
					$stmt_LN_Spanish->bind_param('ss', $ISO, $ROD_Code);									// bind parameters for markers								// 
					$stmt_LN_Spanish->execute();															// execute query
					$result_LN_Spanish = $stmt_LN_Spanish->get_result();									// instead of bind_result (used for only 1 record):
					$r = $result_LN_Spanish->fetch_array();
					$LN=$r['LN_Spanish'];
					break;
				case 3:
					//$query="SELECT LN_Portuguese FROM LN_Portuguese WHERE LN_Portuguese.ISO = '$ISO' AND LN_Portuguese.ROD_Code = '$ROD_Code'";
					//$result_LN=$db->query($query);
					$stmt_LN_Portuguese->bind_param('ss', $ISO, $ROD_Code);									// bind parameters for markers								// 
					$stmt_LN_Portuguese->execute();															// execute query
					$result_LN_Portuguese = $stmt_LN_Portuguese->get_result();									// instead of bind_result (used for only 1 record):
					$r = $result_LN_Portuguese->fetch_array();
					$LN=$r['LN_Portuguese'];
					break;	
				case 4:
					//$query="SELECT LN_French FROM LN_French WHERE LN_French.ISO = '$ISO' AND LN_French.ROD_Code = '$ROD_Code'";
					//$result_LN=$db->query($query);
					$stmt_LN_French->bind_param('ss', $ISO, $ROD_Code);									// bind parameters for markers								// 
					$stmt_LN_French->execute();															// execute query
					$result_LN_French = $stmt_LN_French->get_result();									// instead of bind_result (used for only 1 record):
					$r = $result_LN_French->fetch_array();
					$LN=$r['LN_French'];
					break;	
				case 5:
					//$query="SELECT LN_Dutch FROM LN_Dutch WHERE LN_Dutch.ISO = '$ISO' AND LN_Dutch.ROD_Code = '$ROD_Code'";
					//$result_LN=$db->query($query);
					$stmt_LN_Dutch->bind_param('ss', $ISO, $ROD_Code);									// bind parameters for markers								// 
					$stmt_LN_Dutch->execute();															// execute query
					$result_LN_Dutch = $stmt_LN_Dutch->get_result();									// instead of bind_result (used for only 1 record):
					$r = $result_LN_Dutch->fetch_array();
					$LN=$r['LN_Dutch'];
					break; 	
				case 6:
					//$query="SELECT LN_German FROM LN_German WHERE LN_German.ISO = '$ISO' AND LN_German.ROD_Code = '$ROD_Code'";
					//$result_LN=$db->query($query);
					$stmt_LN_German->bind_param('ss', $ISO, $ROD_Code);									// bind parameters for markers								// 
					$stmt_LN_German->execute();															// execute query
					$result_LN_German = $stmt_LN_German->get_result();									// instead of bind_result (used for only 1 record):
					$r = $result_LN_German->fetch_array();
					$LN=$r['LN_German'];
					break; 	
				case 7:
					$stmt_LN_Chinese->bind_param('ss', $ISO, $ROD_Code);									// bind parameters for markers								// 
					$stmt_LN_Chinese->execute();															// execute query
					$result_LN_Chinese = $stmt_LN_Chinese->get_result();									// instead of bind_result (used for only 1 record):
					$r = $result_LN_Chinese->fetch_array();
					$LN=$r['LN_Chinese'];
					break; 	
				case 8:
					$stmt_LN_Korean->bind_param('ss', $ISO, $ROD_Code);									// bind parameters for markers								// 
					$stmt_LN_Korean->execute();															// execute query
					$result_LN_Korean = $stmt_LN_Korean->get_result();									// instead of bind_result (used for only 1 record):
					$r = $result_LN_Korean->fetch_array();
					$LN=$r['LN_Korean'];
					break; 	
				case 9:
					$stmt_LN_Russian->bind_param('ss', $ISO, $ROD_Code);									// bind parameters for markers								// 
					$stmt_LN_Russian->execute();															// execute query
					$result_LN_Russian = $stmt_LN_Russian->get_result();									// instead of bind_result (used for only 1 record):
					$r = $result_LN_Russian->fetch_array();
					$LN=$r['LN_Russian'];
					break; 	
				case 10:
					$stmt_LN_Arabic->bind_param('ss', $ISO, $ROD_Code);									// bind parameters for markers								// 
					$stmt_LN_Arabic->execute();															// execute query
					$result_LN_Arabic = $stmt_LN_Arabic->get_result();									// instead of bind_result (used for only 1 record):
					$r = $result_LN_Arabic->fetch_array();
					$LN=$r['LN_Arabic'];
					break; 	
				default:
					echo "Isn't supposed to happen! The default language isn't here.";
					break;
			}
		}
		else {
			//$query="SELECT LN_Russian FROM LN_Russian WHERE LN_Russian.ISO = '$ISO' AND LN_Russian.ROD_Code = '$ROD_Code'";
			//$result_LN=$db->query($query);
			$stmt_LN_Russian->bind_param('ss', $ISO, $ROD_Code);										// bind parameters for markers								// 
			$stmt_LN_Russian->execute();																// execute query
			$result_LN_Russian = $stmt_LN_Russian->get_result();										// instead of bind_result (used for only 1 record):
			$r = $result_LN_Russian->fetch_array();
			if ($result_LN_Russian->num_rows == 0) {
				echo 'LN is not Russian. ' . $ISO . ' ' . $ROD_Code . '<br />';
				$LN = 'LN is not Russian';
				continue;
			}
			$LN=$r['LN_Russian'];
		}
		$LN = check_input($LN);							// check_input: in order to make the INSERT work right
		//$result_Temp = $db->query("INSERT INTO LN_Temp (ISO, ROD_Code, Variant_Code, LN) VALUES ('$ISO', '$ROD_Code', '$Variant_Code', '$LN')");
		$stmt_LN_Temp->bind_param('ssss', $ISO, $ROD_Code, $Variant_Code, $LN);							// bind parameters for markers								// 
		$stmt_LN_Temp->execute();																		// execute query
		//$i++;
	}
	$stmt_LN_English->close();
	$stmt_LN_Spanish->close();
	$stmt_LN_Dutch->close();
	$stmt_LN_French->close();
	$stmt_LN_Portuguese->close();
	$stmt_LN_German->close();
	$stmt_LN_Chinese->close();
	$stmt_LN_Korean->close();
	$stmt_LN_Russian->close();
	$stmt_LN_Arabic->close();
	$stmt_LN_Temp->close();

	// Create 'Russian.htm'
	$filename = 'Russian.htm';
	$handle = fopen($filename,'w');		// Open for writing only; place the file pointer at the beginning of the file and truncate the file to zero length. If the file does not exist, attempt to create it. 
	fwrite($handle, $fileFirstPart);
	$j=0;

	$handle_ISO = fopen('./ISO_Language.xml','w');		// Open for writing only; place the file pointer at the beginning of the file and truncate the file to zero length. If the file does not exist, attempt to create it. 
	fwrite($handle_ISO, '<?xml version="1.0" standalone="yes"?>' . PHP_EOL);
	fwrite($handle_ISO, '<scripture-earth-data>' . PHP_EOL);

	$query='SELECT DISTINCT LN_Temp.LN, scripture_main.ISO, scripture_main.ROD_Code, scripture_main.Variant_Code FROM LN_Temp, scripture_main WHERE LN_Temp.ISO = scripture_main.ISO AND LN_Temp.ROD_Code = scripture_main.ROD_Code ORDER BY LN_Temp.LN';
	$result = $db->query($query);
	$num=$result->num_rows;
	$i=0;
	if ($Display) {
		echo "<table border='0' style='width: 980px; margin: 0px; padding: 0px; '>";
		echo "<tr valign='bottom' style='text-align: left; color: black; margin: 0px; padding: 0px; '>";
		echo "<th width='28%'>Language Name:</th>";
		echo "<th width='31%'>Alternate Language Name:</th>";
		echo "<th width='15%'>ISO:</th>";
		echo "<th width='26%'>Country:</th>";
	}
	$fileFourthPart .= PHP_EOL . "<table border='0' style='width: 980px; margin: 0px; padding: 0px; '>" . PHP_EOL .
		"<tr valign='bottom' style='text-align: left; color: black; margin: 0px; padding: 0px; '>" . PHP_EOL .
		"<th width='28%'>Language Name:</th>" . PHP_EOL .
		"<th width='31%'>Alternate Language Name:</th>" . PHP_EOL .
		"<th width='15%'>ISO:</th>" . PHP_EOL .
		"<th width='26%'>Country:</th>" . PHP_EOL .
		'</tr>' . PHP_EOL;
	$query='SELECT alt_lang_name FROM alt_lang_names WHERE ISO = ? AND ROD_Code = ? AND Variant_Code = ?';		// alt_lang_names
	$stmt_alt=$db->prepare($query);																		// create a prepared statement
	$query='SELECT countries.English FROM ISO_countries, countries WHERE ISO_countries.ISO = ? AND ISO_countries.ROD_Code = ? AND ISO_countries.ISO_countries = countries.ISO_Country ORDER BY countries.English';
	$stmt_countries_Eng=$db->prepare($query);															// create a prepared statement
	$query='SELECT * FROM scripture_main WHERE ISO = ? AND ROD_Code = ? AND Variant_Code = ?';
	$stmt_all_SM=$db->prepare($query);																	// create a prepared statement
	$query="SELECT COUNT(*) FROM NT_PDF_Media WHERE ISO = ? AND ROD_Code = ? AND Variant_Code = ? AND NT_PDF REGEXP '^[0-9]{1,2}$'";
	$stmt_NT_PDF_Media=$db->prepare($query);															// create a prepared statement
	$query="SELECT COUNT(*) FROM OT_PDF_Media WHERE ISO = ? AND ROD_Code = ? AND Variant_Code = ? AND OT_PDF REGEXP '^[0-9]{1,2}$'";
	$stmt_OT_PDF_Media=$db->prepare($query);															// create a prepared statement
	$query='SELECT COUNT(*) FROM NT_Audio_Media WHERE ISO = ? AND ROD_Code = ? AND Variant_Code = ? AND NT_Audio_Filename IS NOT NULL';	//NT_Audio REGEXP '^[0-9]{1,3}$'";
	$stmt_NT_Audio_Media=$db->prepare($query);															// create a prepared statement
	$query='SELECT COUNT(*) FROM OT_Audio_Media WHERE ISO = ? AND ROD_Code = ? AND Variant_Code = ? AND OT_Audio_Filename IS NOT NULL';	//OT_Audio REGEXP '^[0-9]{1,3}$'";
	$stmt_OT_Audio_Media=$db->prepare($query);															// create a prepared statement
	$query='SELECT company, company_title, URL, map FROM links WHERE ISO = ? AND ROD_Code = ? AND Variant_Code = ? AND buy = 0 AND BibleIs = 0 AND YouVersion = 0 AND Bibles_org = 0';
	$stmt_links=$db->prepare($query);																	// create a prepared statement
	
	while ($row = $result->fetch_array()) {				// scripture_main table
		if ($i % 2)
			$color = 'ffffff';
		else
			$color = 'f0f4f0';
		$ISO = $row['ISO'];
		$ROD_Code = $row['ROD_Code'];
		$Variant_Code = $row['Variant_Code'];
		$LN = $row['LN'];

		if ($Display) {
			echo "<tr valign='bottom' style='color: navy; background-color: #$color; margin: 0px; padding: 0px; '>";
			echo "<td width='28%' style='background-color: #$color; margin: 0px; padding: 3px 5px 3px 5px; border-width: thin; border-style: none; border-color: #$color; '>$LN</td>";
		}
		$fileFourthPart .= "<tr valign='bottom' style='color: navy; background-color: #$color; margin: 0px; padding: 0px; '>" . PHP_EOL .
			"<td width='28%' style='background-color: #$color; margin: 0px; padding: 3px 5px 3px 5px; border-width: thin; border-style: none; border-color: #$color; '><a href='../../00eng.php?iso=$ISO&rod=$ROD_Code&var=$Variant_Code'>$LN</a></td>" . PHP_EOL;
		//$alt_lang_names=$row['scripture_main.alt_lang_names'];
		//if ($alt_lang_names > 0) {
		//$query_alt="SELECT alt_lang_name FROM alt_lang_names WHERE ISO = '$ISO' AND ROD_Code = '$ROD_Code' AND Variant_Code = '$Variant_Code'";				// alt_lang_names
		//$result_alt=$db->query($query_alt);
		$stmt_alt->bind_param('sss', $ISO, $ROD_Code, $Variant_Code);									// bind parameters for markers
		$stmt_alt->execute();																			// execute query
		$result_alt = $stmt_alt->get_result();															// instead of bind_result (used for only 1 record):
		$num=$result_alt->num_rows;
		$alt = '';
		$Temp = '';
		if ($num > 0) {
			if ($Display) {
				echo "<td width='31%' style='background-color: #$color; margin: 0px; padding: 3px 5px 3px 5px; border-width: thin; border-style: none; border-color: #$color; '>";
			}
			$fileFourthPart .= "<td width='31%' style='background-color: #$color; margin: 0px; padding: 3px 5px 3px 5px; border-width: thin; border-style: none; border-color: #$color; '>" . PHP_EOL;
			$i_alt=0;
			$Temp = '';
			while ($r_alt = $result_alt->fetch_array()) {
				if ($i_alt <> 0) {
					$Temp .= ', ';
				}
				$alt_lang_name=$r_alt['alt_lang_name'];
				if ($alt == '') {
					$alt = $alt_lang_name;
				}
				else {
					$alt = $alt . ', ' . $alt_lang_name;
				}
				$i_alt++;
			}
			$Temp = $alt;
			$fileFourthPart .= $Temp;
			if ($Display) {
				echo $Temp;
				echo '</td>';
			}
			$fileFourthPart .= '</td>' . PHP_EOL;
		}
		else {
			if ($Display) {
				echo "<td width='31%' style='margin: 0px; padding: 3px 5px 3px 5px; border-width: thin; border-style: none; border-color: #$color; '>&nbsp;</td>";
			}
			$fileFourthPart .= "<td width='31%'style='margin: 0px; padding: 3px 5px 3px 5px; border-width: thin; border-style: none; border-color: #$color; '>&nbsp;</td>" . PHP_EOL;
		}

		//$ISO=$row['scripture_main.ISO'];							// ISO
		//$ROD_Code=$row['scripture_main.ROD_Code'];				// ROD_Code
		if ($Display) {
			echo "<td width='15%' style='margin: 0px; padding: 3px 5px 3px 5px; border-width: thin; border-style: none; border-color: #$color; '>$ISO</td>";
		}
		$fileFourthPart .= "<td width='15%' style='margin: 0px; padding: 3px 5px 3px 5px; border-width: thin; border-style: none; border-color: #$color; '>$ISO</td>" . PHP_EOL;

		//$query="SELECT countries.English FROM ISO_countries, countries WHERE ISO_countries.ISO = '$ISO' AND ISO_countries.ROD_Code = '$ROD_Code' AND ISO_countries.ISO_countries = countries.ISO_Country ORDER BY countries.English";
		//$result_ISO_countries=$db->query($query);
		//$num_ISO_countries=$result_ISO_countries->num_rows;
		$stmt_countries_Eng->bind_param('ss', $ISO, $ROD_Code);											// bind parameters for markers
		$stmt_countries_Eng->execute();																	// execute query
		$result_ISO_countries = $stmt_countries_Eng->get_result();										// instead of bind_result (used for only 1 record):
		$num_ISO_countries=$result_ISO_countries->num_rows;
		$r_ISO_C = $result_ISO_countries->fetch_array();
		$Eng_country = '';
		if ($num_ISO_countries >= 1) {
			$Eng_country = $r_ISO_C['Russian'];							// first name of the country in the language version
			while ($r_ISO_C = $result_ISO_countries->fetch_array()) {
				$Eng_country = $Eng_country.', '.$r_ISO_C['English'];	// name of the country in the language version
			}
		}
		else {
			echo 'No English country for ' . $ISO . ' ' . $ROD_Code . ' ' . $Variant_Code . '<br />';
		}
		if ($Display) {
			//echo "<td width='20%' style='background-color: #$color; margin: 0px; padding: 3px 5px 3px 5px; border-width: thin; border-style: none; border-color: #$color; '>$Eng_country</td>";
			echo "<td width='26%' style='margin: 0px; padding: 3px 5px 3px 5px; border-width: thin; border-style: none; border-color: #$color; '>$Eng_country</td>";
			echo '</tr>';
		}
		$fileFourthPart .= "<td width='26%' style='margin: 0px; padding: 3px 5px 3px 5px; border-width: thin; border-style: none; border-color: #$color; '>$Eng_country</td>" . PHP_EOL .
			'</tr>' . PHP_EOL;

		// 	$fileSecondPart
		$Temp2 = $LN;
		if ($Temp != '')
			$Temp2 .= ', ' . $Temp;
		$Temp2 .= ', ' . $ISO;
		if ($ROD_Code != '00000')
			$Temp2 .= ', ' . $ROD_Code;
		fwrite($handle, $Temp2 . PHP_EOL);
		
		// *************************************************************************************************************************************
		//
		// Tom Van Wynen (tom_van_wynen@wycliffe.net): wycliffe.net webmaster: He does not want JESUS Film, GRN, maps, YouVersion, etc.
		//  I.e., everything that we don't host: not $FCBH, $links, $watch, $BibleIs, $YouVersion, $Bibles_org, $PlaylistAudio, $PlaylistVideo
		//
		// *************************************************************************************************************************************
		//$query="SELECT * FROM scripture_main WHERE ISO = '$ISO' AND ROD_Code = '$ROD_Code' AND Variant_Code = '$Variant_Code'";
		//$result_main = $db->query($query);
		$stmt_all_SM->bind_param('sss', $ISO, $ROD_Code, $Variant_Code);							// bind parameters for markers
		$stmt_all_SM->execute();																	// execute query
		$result_main = $stmt_all_SM->get_result();													// instead of bind_result (used for only 1 record):
		$num_main=$result_main->num_rows;
		$rm = $result_main->fetch_array();
		$NT_PDF=$rm['NT_PDF'];							// boolean: NT_PDF
		$OT_PDF=$rm['OT_PDF'];							// boolean: OT_PDF
		$FCBH=$rm['FCBH'];								// boolean: FCBH
		$NT_Audio=$rm['NT_Audio'];						// boolean: NT_Audio
		$OT_Audio=$rm['OT_Audio'];						// boolean: OT_Audio
		$links=$rm['links'];							// boolean: links
		$other_titles=$rm['other_titles'];				// boolean: other_titles
		$watch=$rm['watch'];							// boolean: watch
		$buy=$rm['buy'];							 	// boolean: buy
		$study=$rm['study'];							// boolean: study
		$viewer=$rm['viewer'];							// boolean: viewer
		$CellPhone=$rm['CellPhone'];					// boolean: CellPhone
		$BibleIs=$rm['BibleIs'];						// boolean: Bible.is
		$YouVersion=$rm['YouVersion'];					// boolean: YouVersion
		$Bibles_org=$rm['Bibles_org'];					// boolean: Bibles_org
		$PlaylistAudio=$rm['PlaylistAudio'];			// boolean: PlaylistAudio
		$PlaylistVideo=$rm['PlaylistVideo'];			// boolean: PlaylistVideo
		$NT_PDF_count = -1;
		$OT_PDF_count = -1;
		$NT_Audio_count = -1;
		$OT_Audio_count = -1;
		$NT_Partial_PDF_count = -1;
		$OT_Partial_PDF_count = -1;
		$NT_Partial_Audio_count = -1;
		$OT_Partial_Audio_count = -1;
		$NT_PDF_Whole = -1;
		$OT_PDF_Whole = -1;
		$NT_Audio_Whole = -1;
		$OT_Audio_Whole = -1;
		$Bible_PDF_count = -1;
		$Bible_Audio_count = -1;
		if ($NT_PDF == 1 || $OT_PDF == 1 || $NT_Audio == 1 || $OT_Audio == 1 || $other_titles == 1 || $buy == 1 || $study == 1 || $viewer == 1 || $CellPhone == 1) {
			//$query="SELECT COUNT(*) FROM NT_PDF_Media WHERE ISO = '$ISO' AND ROD_Code = '$ROD_Code' AND Variant_Code = '$Variant_Code' AND NT_PDF REGEXP '^[0-9]{1,2}$'";
			//$result_NT_PDF = $db->query($query);
			$stmt_NT_PDF_Media->bind_param('sss', $ISO, $ROD_Code, $Variant_Code);					// bind parameters for markers
			$stmt_NT_PDF_Media->execute();															// execute query
			$result_NT_PDF = $stmt_NT_PDF_Media->get_result();										// instead of bind_result (used for only 1 record):
			//$num_NT_PDF = $result_NT_PDF->num_rows;
			if ($r_NT_PDF = $result_NT_PDF->fetch_array()) {
				$NT_PDF_count = $r_NT_PDF['COUNT(*)'];
				if ($NT_PDF_count === 27)
					$NT_PDF_Whole = 1;
				else
					if ($NT_PDF_count === 0) {
						$NT_PDF_count = -1;
						$NT_Partial_PDF_count = -1;
					}
					else
						$NT_Partial_PDF_count = $NT_PDF_count;
			}
			//$query="SELECT COUNT(*) FROM OT_PDF_Media WHERE ISO = '$ISO' AND ROD_Code = '$ROD_Code' AND Variant_Code = '$Variant_Code' AND OT_PDF REGEXP '^[0-9]{1,2}$'";
			//$result_OT_PDF = $db->query($query);
			$stmt_OT_PDF_Media->bind_param('sss', $ISO, $ROD_Code, $Variant_Code);					// bind parameters for markers
			$stmt_OT_PDF_Media->execute();															// execute query
			$result_OT_PDF = $stmt_OT_PDF_Media->get_result();										// instead of bind_result (used for only 1 record):
			//$num_OT_PDF = $result_OT_PDF->num_rows;
			if ($r_OT_PDF = $result_OT_PDF->fetch_array()) {
				$OT_PDF_count = $r_OT_PDF['COUNT(*)'];
				if ($OT_PDF_count === 39)
					$OT_PDF_Whole = 1;
				else
					if ($OT_PDF_count === 0) {
						$OT_PDF_count = -1;
						$OT_Partial_PDF_count = -1;
					}
					else
						$OT_Partial_PDF_count = $OT_PDF_count;
			}
			if ($other_titles === 1 && ($NT_PDF_Whole != 1 || $OT_PDF_Whole != 1)) {
				$NT_Partial_PDF_count = 100;
				$OT_Partial_PDF_count = 100;
			}
			if ($NT_PDF_Whole === 1 && $OT_PDF_Whole === 1)
				$Bible_PDF_count = 1;
			
			//$query="SELECT COUNT(*) FROM NT_Audio_Media WHERE ISO = '$ISO' AND ROD_Code = '$ROD_Code' AND Variant_Code = '$Variant_Code' AND NT_Audio_Filename IS NOT NULL";	//NT_Audio REGEXP '^[0-9]{1,3}$'";
			//$result_NT_Audio = $db->query($query);
			$stmt_NT_Audio_Media->bind_param('sss', $ISO, $ROD_Code, $Variant_Code);				// bind parameters for markers
			$stmt_NT_Audio_Media->execute();														// execute query
			$result_NT_Audio = $stmt_NT_Audio_Media->get_result();									// instead of bind_result (used for only 1 record):
			//$num_NT_Audio = $result_NT_Audio->num_rows;
			if ($r_NT_Audio = $result_NT_Audio->fetch_array()) {
				$NT_Audio_count = $r_NT_Audio['COUNT(*)'];
				if ($NT_Audio_count === 260)
					$NT_Audio_Whole = 1;
				else
					if ($NT_Audio_count === 0) {
						$NT_Audio_count = -1;
						$NT_Partial_Audio_count = -1;
					}
					else
						$NT_Partial_Audio_count = $NT_Audio_count;
			}
			//$query="SELECT COUNT(*) FROM OT_Audio_Media WHERE ISO = '$ISO' AND ROD_Code = '$ROD_Code' AND Variant_Code = '$Variant_Code' AND OT_Audio_Filename IS NOT NULL";	//OT_Audio REGEXP '^[0-9]{1,3}$'";
			//$result_OT_Audio = $db->query($query);
			$stmt_OT_Audio_Media->bind_param('sss', $ISO, $ROD_Code, $Variant_Code);				// bind parameters for markers
			$stmt_OT_Audio_Media->execute();														// execute query
			$result_OT_Audio = $stmt_OT_Audio_Media->get_result();									// instead of bind_result (used for only 1 record):
			//$num_OT_Audio = $result_OT_Audio->num_rows;
			if ($r_OT_Audio = $result_OT_Audio->fetch_array()) {
				$OT_Audio_count = $r_OT_Audio['COUNT(*)'];
				if ($OT_Audio_count === 929)
					$OT_Audio_Whole = 1;
				else
					if ($OT_Audio_count === 0) {
						$OT_Audio_count = -1;
						$OT_Partial_Audio_count = -1;
					}
					else
						$OT_Partial_Audio_count = $OT_Audio_count;
			}
			$link = '';
			//$query="SELECT company, company_title, URL, map FROM links WHERE ISO = '$ISO' AND ROD_Code = '$ROD_Code' AND Variant_Code = '$Variant_Code' AND buy = 0 AND BibleIs = 0 AND YouVersion = 0 AND Bibles_org = 0";
			//$result_links = $db->query($query);
			$stmt_links->bind_param('sss', $ISO, $ROD_Code, $Variant_Code);							// bind parameters for markers
			$stmt_links->execute();																	// execute query
			$result_links = $stmt_links->get_result();												// instead of bind_result (used for only 1 record):
			//$num_links = $result_links->num_rows;
			while ($r_links = $result_links->fetch_array()) {
				$company = $r_links['company'];
				$URL = $r_links['URL'];
				$type = $r_links['company_title'];
				$map = $r_links['map'];
				if ($company === 'map' || $company === 'mapa' || $map === 1) {
					if (preg_match('/ethnologue/i', $URL)) {																		// map_Langauage.xml
						if (substr($URL, 0, 6) === 'https:') $URL = str_replace('https:', 'http:', $URL);							// replace 'https:' with 'http:'
					}
					array_push($map_array, [$URL, $type, $ISO, $ROD_Code]);														// add to $map_array
					$ma++;
				}
				else {
					$link .= '		<link company="' . $company . '" type="' . $type . '" URL="' . $URL . '" />' . PHP_EOL;			// ISO_Langauage.xml
				}
			}
			
			//if ($other_titles === 1 && ($NT_Audio_Whole != 1 || $OT_Audio_Whole != 1)) {
			//	$NT_Partial_Audio_count = 100;
			//	$OT_Partial_Audio_count = 100;
			//}
			if ($NT_Audio_Whole === 1 && $OT_Audio_Whole === 1)
				$Bible_Audio_count = 1;
			
			fwrite($handle_ISO, '	<language>' . PHP_EOL);
			fwrite($handle_ISO, '		<iso_code>' . $ISO . '</iso_code>' . PHP_EOL);
			fwrite($handle_ISO, '		<rod_code>' . $ROD_Code . '</rod_code>' . PHP_EOL);
			fwrite($handle_ISO, '		<variant_code>' . $Variant_Code . '</variant_code>' . PHP_EOL);
			fwrite($handle_ISO, '		<language_name>' . str_replace('& ', '&amp; ', $LN) . '</language_name>' . PHP_EOL);
			if ($link != '') {
				$link = str_replace('&', '&amp;', $link);
				$link = str_replace('http://www.scriptureearth.org', 'https://www.scriptureearth.org', $link);
				fwrite($handle_ISO, $link);
			}
			fwrite($handle_ISO, '		<content nt_PDF="' . $NT_PDF_count . '" nt_audio="' . $NT_Audio_count . '" nt_partial_PDF="' . $NT_Partial_PDF_count . '" nt_partial_audio="' . $NT_Partial_Audio_count . '" nt_PDF_whole="' . $NT_PDF_Whole . '" nt_audio_whole="' . $NT_Audio_Whole . '" ot_PDF="' . $OT_PDF_count . '" ot_audio="' . $OT_Audio_count . '" ot_partial_PDF="' . $OT_Partial_PDF_count . '" ot_partial_audio="' . $OT_Partial_Audio_count . '" ot_PDF_whole="' . $OT_PDF_Whole . '" ot_audio_whole="' . $OT_Audio_Whole . '" Bible_PDF="' . $Bible_PDF_count . '" Bible_audio="' . $Bible_Audio_count . '" />' . PHP_EOL);
			fwrite($handle_ISO, '	</language>' . PHP_EOL);
		}
		
		// Do it!
		// $fileFourthPart .= '<a href="' . $ISO . $ROD_Code . '.htm">' . $ISO . $ROD_Code . '</a><br />' . PHP_EOL;
		/*
		$fileCreate = str_replace('#zzz#', $ISO, $fileCreate);
		$fileCreate = str_replace('#qqqqq#', $ROD_Code, $fileCreate);
		$fileCreate = str_replace('#llllllllll#', $LN, $fileCreate);
		$Temp = $ISO . ', ' . $LN . ', ' . $Eng_country;
		if ($alt != '') {
			$Temp = $Temp . ', ' . $alt;
		}
		$fileCreate = str_replace('#kkkkkkkkkk#', $Temp, $fileCreate);
		fwrite($handle, $fileCreate);
		*/

		$i++;
	}
	if ($Display) {
		echo '</table>';
		echo '</div>';
	}
	$fileFourthPart .= '</table>';
	
	fwrite($handle, $fileThirdPart);
	
	fwrite($handle, $fileFourthPart);
	
	fwrite($handle, $fileFifthPart);
	
	fclose($handle);
	
	fwrite($handle_ISO, '</scripture-earth-data>');
	fclose($handle_ISO);
	
	// Obtain a list of columns
	foreach ($map_array as $key => $row) {
		$mid[$key]  = $row[0];
	}
	// Sort the data with mid ascending
	// Add $map_array as the last parameter, to sort by the common key
	array_multisort($mid, SORT_ASC, $map_array);
	
	//var_dump($map_array);

	$handle_map = fopen('./map_Language.xml','w');		// Open for writing only; place the file pointer at the beginning of the file and truncate the file to zero length. If the file does not exist, attempt to create it. 
	fwrite($handle_map, '<?xml version="1.0" standalone="yes"?>' . PHP_EOL);
	fwrite($handle_map, '<map-data>' . PHP_EOL);
	$i=1;												// skip first row
	while ($i < $ma) {
		fwrite($handle_map, '	<map>' . PHP_EOL);
		fwrite($handle_map, '		<name>' . $map_array[$i][1] . '</name>' . PHP_EOL);
		fwrite($handle_map, '		<url>' . $map_array[$i][0] . '</url>' . PHP_EOL);
		$temp_URL = $map_array[$i][0];
		$ISO_Temp = '';
		$ROD_Temp = '';
		while ($temp_URL === $map_array[$i][0]) {
			if ($map_array[$i][2] === $ISO_Temp && $map_array[$i][3] === $ROD_Temp) {		// chech to see if ISO and ROD_Code equals the last one
				$i++;
				continue;
			}
			$ISO_Temp = $map_array[$i][2];
			$ROD_Temp = $map_array[$i][3];
			fwrite($handle_map, '		<iso-code>' . $map_array[$i][2] . '</iso-code>' . PHP_EOL);
			fwrite($handle_map, '		<rod-code>' . $map_array[$i][3] . '</rod-code>' . PHP_EOL);
			$i++;
		}
		fwrite($handle_map, '	</map>' . PHP_EOL);
	}
	fwrite($handle_map, '</map-data>');
	fclose($handle_map);

	/* Explicitly destroy the table */
	$db->query('DROP TABLE LN_Temp');
?>
</body>
</html>
