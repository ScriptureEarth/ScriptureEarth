<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Portuguesa Language Setup</title>
<meta http-equiv="Content-Type"  content="text/html; charset=utf-8" />
<meta http-equiv="Window-target" content="_top" />
<meta name="ObjectType"          content="Document" />
<meta name="ROBOTS"              content="NOINDEX" />
</head>
<body>
<?php
function check_input($value) {						// used for ' and " that find it in the input
	$value = trim($value);
    /* Automatic escaping is highly deprecated, but many sites do it anyway. */
	// Stripslashes
	if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
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
<title>Scripture Earth Portuguesa Language Setup</title>
<meta http-equiv="Content-Type" 			content="text/html; charset=utf-8" />
<meta name="ObjectType" 					content="Document" />
<meta http-equiv="Window-target" 			content="_top" />
<meta name="Description" lang="en-US" 		content="
	Neste site, você encontra a Bíblia/NT em [language name] em PDF e áudio (MP3),
	pode assistir a vídeos (o Filme Jesus, etc.), comprar (impressão sob demanda),
	estudar (A Palavra), acessar outros livros e links nas línguas indígenas das Américas.
  " />
<meta name="Keywords" lang="en-US" 			content="
	línguas indígenas modernas, as Américas, língua materna, línguas nativas,
	texto, PDF, áudio, MP3, assista, o filme Jesus, módulos de estudo Bíblico,
	compre, impressão sob demanda, compra on-line, loja, estude, A Palavra,
	Bíblia, compre o livro on-line, Novo Testamento, NT, Velho Testamento, VT,
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
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;·&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Áudio (<a href="http://www.faithcomesbyhearing.com/ambassador/free-audio-bible-download">Faith Comes By Hearing</a>)<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;·&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Vídeo (<a href="http://www.inspirationalfilms.com/av/watch.html">The JESUS Film</a>)<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;·&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Módulos de Estudo Bíblico (<a href="http://www.theword.gr/">The Word</a>)<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;·&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Compre o livro on-line (<a href="http://www.virtualstorehouse.org/">Virtual Storehouse</a>)</span><br /><br />
<span style="color: #003366; font-size: 11pt; "><span style="font-size: 14pt; font-weight: bold; ">Clique</span> aqui para encontrar o Novo Testamento ou Bíblia completa nas seguintes línguas:</span><br />';
$fileFourthPart = '';
$fileFifthPart = '</div>
</body>
</html>';

	if ($Display) {
		echo "<div style='background-color: white; padding: 20px; width: 800px; margin-left: auto; margin-right: auto; '>";
		echo "<h2 style='text-align: center; margin: 0px; color: navy; '>Scripture Earth Portuguesa Language Setup</h2><br /><br />";
	}
	
	$query = 'SELECT * FROM scripture_main ORDER BY ISO, ROD_Code';
	$result=$db->query($query) or die ('Query failed: ' . $db->error . '</body></html>');
	if (!$result) {
		die ("Cannot SELECT from 'scripture_main'. " . $db->error . '</body></html>');
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
		$def_LN=$row['Def_LN'];							// default langauge (a 2 digit number for the national langauge)

		if (!$LN_Portuguese) {							// if the Portuguese then the default langauge
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
				default:
					echo "Isn't supposed to happen! The default language isn't here.";
					break;
			}
		}
		else {
			//$query="SELECT LN_Portuguese FROM LN_Portuguese WHERE LN_Portuguese.ISO = '$ISO' AND LN_Portuguese.ROD_Code = '$ROD_Code'";
			//$result_LN=$db->query($query);
			$stmt_LN_Portuguese->bind_param('ss', $ISO, $ROD_Code);									// bind parameters for markers								// 
			$stmt_LN_Portuguese->execute();															// execute query
			$result_LN_Portuguese = $stmt_LN_Portuguese->get_result();									// instead of bind_result (used for only 1 record):
			$r = $result_LN_Portuguese->fetch_array();
			$LN=$r['LN_Portuguese'];
		}
		$LN = check_input($LN);							// check_input: in order to make the INSERT work right
		//$result_Temp = $db->query("INSERT INTO LN_Temp (ISO, ROD_Code, Variant_Code, LN) VALUES ('$ISO', '$ROD_Code', '$Variant_Code', '$LN')");
		$stmt_LN_Temp->bind_param('ssss', $ISO, $ROD_Code, $Variant_Code, $LN);							// bind parameters for markers								// 
		$stmt_LN_Temp->execute();																		// execute query
		//$i++;
	}

	// Create 'Portuguese.htm'
	$filename = 'Portuguese.htm';
	$handle = fopen($filename,'w');		// Open for writing only; place the file pointer at the beginning of the file and truncate the file to zero length. If the file does not exist, attempt to create it. 
	fwrite($handle, $fileFirstPart);
	$j=0;

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
		"<th width='28%'>Língua:</th>" . PHP_EOL .
		"<th width='31%'>Nome alternativo da língua:</th>" . PHP_EOL .
		"<th width='15%'>ISO:</th>" . PHP_EOL .
		"<th width='26%'>País:</th>" . PHP_EOL .
		'</tr>' . PHP_EOL;
	$query='SELECT alt_lang_name FROM alt_lang_names WHERE ISO = ? AND ROD_Code = ? AND Variant_Code = ?';		// alt_lang_names
	$stmt_alt=$db->prepare($query);																		// create a prepared statement
	$query='SELECT countries.Portuguese FROM ISO_countries, countries WHERE ISO_countries.ISO = ? AND ISO_countries.ROD_Code = ? AND ISO_countries.ISO_countries = countries.ISO_Country ORDER BY countries.Portuguese';
	$stmt_countries_Por=$db->prepare($query);															// create a prepared statement
	while ($row = $result->fetch_array()) {
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
			"<td width='28%' style='background-color: #$color; margin: 0px; padding: 3px 5px 3px 5px; border-width: thin; border-style: none; border-color: #$color; '><a href='../../00p-Escrituras_Indice.php?sortby=lang&name=$ISO&ROD_Code=$ROD_Code&Variant_Code=$Variant_Code'>$LN</a></td>" . PHP_EOL;
		//$alt_lang_names=$row['scripture_main.alt_lang_names");
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

		//$query="SELECT countries.Portuguese FROM ISO_countries, countries WHERE ISO_countries.ISO = '$ISO' AND ISO_countries.ROD_Code = '$ROD_Code' AND ISO_countries.ISO_countries = countries.ISO_Country ORDER BY countries.Portuguese";
		//$result_ISO_countries=$db->query($query);
		//$num_ISO_countries=$result_ISO_countries->num_rows;
		$stmt_countries_Por->bind_param('ss', $ISO, $ROD_Code);											// bind parameters for markers
		$stmt_countries_Por->execute();																	// execute query
		$result_ISO_countries = $stmt_countries_Por->get_result();										// instead of bind_result (used for only 1 record):
		//$num_ISO_countries=$result_ISO_countries->num_rows;
		$r_ISO_C = $result_ISO_countries->fetch_array();
		$Port_country = $r_ISO_C['Portuguese'];						// first name of the country in the language version
		while ($r_ISO_C = $result_ISO_countries->fetch_array()) {
			$Port_country = $Port_country.', '.$r_ISO_C['Portuguese'];	// name of the country in the language version
		}
		if ($Display) {
			//echo "<td width='20%' style='background-color: #$color; margin: 0px; padding: 3px 5px 3px 5px; border-width: thin; border-style: none; border-color: #$color; '>$Eng_country</td>";
			echo "<td width='26%' style='margin: 0px; padding: 3px 5px 3px 5px; border-width: thin; border-style: none; border-color: #$color; '>$Port_country</td>";
			echo '</tr>';
		}
		$fileFourthPart .= "<td width='26%' style='margin: 0px; padding: 3px 5px 3px 5px; border-width: thin; border-style: none; border-color: #$color; '>$Port_country</td>" . PHP_EOL .
			'</tr>' . PHP_EOL;

		// 	$fileSecondPart
		$Temp2 = $LN;
		if ($Temp != '')
			$Temp2 .= ', ' . $Temp;
		$Temp2 .= ', ' . $ISO;
		if ($ROD_Code != '00000')
			$Temp2 .= ', ' . $ROD_Code;
		fwrite($handle, $Temp2 . PHP_EOL);

		// Do it!
		// $fileFourthPart .= '<a href="' . $ISO . $ROD_Code . '.htm">' . $ISO . $ROD_Code . '</a><br />' . PHP_EOL;
		/*
		$fileCreate = str_replace('#zzz#', $ISO, $fileCreate);
		$fileCreate = str_replace('#qqqqq#', $ROD_Code, $fileCreate);
		$fileCreate = str_replace('#llllllllll#', $LN, $fileCreate);
		$Temp = $ISO . ', ' . $LN . ', ' . $Port_country;
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

	/* Explicitly destroy the table */
	$db->query('DROP TABLE LN_Temp');
?>
</body>
</html>
