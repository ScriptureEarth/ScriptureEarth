<!DOCTYPE html>
<html>
<head>
<title>All SE Languages Report</title>
<meta http-equiv="Content-Type"  content="text/html; charset=utf-8" />
<meta http-equiv="Window-target" content="_top" />
<meta name="ObjectType"          content="Document" />
<meta name="ROBOTS"              content="NOINDEX" />
</head>
<body>
<?php
$SABtemp = 0;
$y = 0;
/********************************************************************************************************************************************************************
		Creates 'AllLanguages.csv'

		If AllEnglishLanguagesReport.php?number=1 then write "1" in all of the numbers instead of writing https://zzzzzzzzzzzzzzzzzzzzzzzzzzzzzz to the csv file
********************************************************************************************************************************************************************/

$N = 0;
if (isset($_GET['number'])) {
	$num = $_GET['number'];
	if (preg_match('/^[0-1]/', $num)) {
		$N = (int)$num;
	}
	else {
		die ("<br />the number must be 0 or 1</body></html>");
	}
}
else {
	die('Hack!');
}

echo '<p style="color: blue; font-weight: bold; ">Start...</p>';
/************************************************************************************************
	declared variables
*************************************************************************************************/
$map_array = [];						// declare the array here because later on do a array_push
$itunes_array = [];
$App_array = [];
$iOS_array = [];
$GoBible_array = [];
$MySword_array = [];
$itunes_array = [];
$buy_array = [];
$BibleIs_array = [];
$YouVersion_array = [];
//$Bibles_org_array = [];
$GooglePlay_array = [];
$GRN_array = [];
$PlaylistAudio_array = [];
$PlaylistGenesis_array = [];
$PlaylistActs_array = [];
$PlaylistScriptAnim_array = [];
$PlaylistJohnAnim_array = [];
$PlaylistGodsStory_array = [];
$PlaylistJesus_array = [];
$PlaylistJohn_array = [];
$PlaylistLuke_array = [];
$PlaylistMagdalena_array = [];
$PlaylistSamaritan_array = [];
$Children_array = [];
$fish_array = [];
$History_array = [];
$LastDay_array = [];
$study_array = [];
$SAB_array = [];
$india_array = [];
$ibt_array = [];
$oneStory_array = [];

function check_input($value) {						// used for ' and " that find it in the input
	$value = trim($value);
    /* Automatic escaping is highly deprecated, but many sites do it anyway. */
	// Stripslashes
	//if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
	  $value = stripslashes($value);
	//}
	// Quote if not a number
	if (!is_numeric($value)) {
		$db = get_my_db();
		$value = $db->real_escape_string($value);
	}
	return $value;
}

include '../../include/conn.inc.php';
$db = get_my_db();

$FileString = '';

	$query = 'SELECT * FROM nav_ln ORDER BY ISO, ROD_Code';
	$result_SM=$db->query($query) or die ('Query failed: ' . $db->error . '</body></html>');
	if (!$result_SM) {
		die ("Cannot SELECT from 'nav_ln'. " . $db->error . '</body></html>');
	}
	$num=$result_SM->num_rows;
	
	$db->query('DROP TABLE IF EXISTS LN_Temp');
	$result_Temp = $db->query('CREATE TEMPORARY TABLE LN_Temp (ISO VARCHAR(3) NOT NULL, ROD_Code VARCHAR(5) NOT NULL, Variant_Code VARCHAR(1) NULL, LN VARCHAR(50) NOT NULL) ENGINE = MEMORY CHARSET = utf8')  or die ('Query failed: ' . $db->error . '</body></html>');
	//$i=0;
	
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
	$query='INSERT INTO LN_Temp (ISO, ROD_Code, Variant_Code, LN) VALUES (?, ?, ?, ?)';
	$stmt_LN_Temp=$db->prepare($query);																	// create a prepared statement
	
	while ($row_SM = $result_SM->fetch_array()) {			// scripture_main table
		$ISO=$row_SM['ISO'];								// ISO
		$ROD_Code=$row_SM['ROD_Code'];						// ROD_Code
		$Variant_Code=$row_SM['Variant_Code'];				// Variant_Code
		$LN_English=$row_SM['LN_English'];					// boolean
		$LN_Spanish=$row_SM['LN_Spanish'];					// boolean
		$LN_Portuguese=$row_SM['LN_Portuguese'];			// boolean
		$LN_French=$row_SM['LN_French'];					// boolean
		$LN_Dutch=$row_SM['LN_Dutch'];						// boolean
		$LN_German=$row_SM['LN_German'];					// boolean
		$LN_Chinese=$row_SM['LN_Chinese'];					// boolean
		$def_LN=$row_SM['Def_LN'];							// default langauge (a 2 digit number for the national langauge)
		if (!$LN_English) {									// if the English then the default langauge
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
				default:
					echo "Isn't supposed to happen! The default language isn't here.";
					break;
			}
		}
		else {
			//$query="SELECT LN_English FROM LN_English WHERE LN_English.ISO = '$ISO' AND LN_English.ROD_Code = '$ROD_Code'";
			//$result_LN=$db->query($query);
			$stmt_LN_English->bind_param('ss', $ISO, $ROD_Code);										// bind parameters for markers								// 
			$stmt_LN_English->execute();																// execute query
			$result_LN_English = $stmt_LN_English->get_result();										// instead of bind_result (used for only 1 record):
			if ($result_LN_English->num_rows == 0) {
				echo $db->error;
				echo '<h4 style="color: red; font-weight: bold; ">Unknown language name in English when inserting iso: ['.$ISO . ']; rod: ' . $ROD_Code . '</h4>';
				$LN='_Unknown language name in English';
			}
			else {
				$r = $result_LN_English->fetch_array();
				$LN=$r['LN_English'];
			}
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
	$stmt_LN_Temp->close();
	
	$query='SELECT Variant_Eng FROM Variants WHERE Variant_Code = ?';									// Variant
	$stmt_Variant=$db->prepare($query);																	// create a prepared statement
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
	$query='SELECT company, company_title, URL, map FROM links WHERE ISO = ? AND ROD_Code = ? AND Variant_Code = ? AND buy = 0 AND BibleIs = 0 AND YouVersion = 0 AND Bibles_org = 0 AND GooglePlay = 0 AND GRN = 0';
	$stmt_links=$db->prepare($query);																	// create a prepared statement
	$query='SELECT organization, buy_what, URL FROM buy WHERE ISO = ? AND ROD_Code = ? AND Variant_Code = ?';
	$stmt_links_first_buy=$db->prepare($query);															// create a prepared statement
	$query='SELECT company, company_title, URL FROM links WHERE ISO = ? AND ROD_Code = ? AND Variant_Code = ? AND buy = 1';
	$stmt_links_buy=$db->prepare($query);																// create a prepared statement
	$query='SELECT company, company_title, URL FROM links WHERE ISO = ? AND ROD_Code = ? AND Variant_Code = ? AND BibleIs = 1';
	$stmt_links_BibleIs=$db->prepare($query);															// create a prepared statement
	$query='SELECT company, company_title, URL FROM links WHERE ISO = ? AND ROD_Code = ? AND Variant_Code = ? AND YouVersion = 1';
	$stmt_links_YouVersion=$db->prepare($query);														// create a prepared statement
	$query='SELECT company, company_title, URL FROM links WHERE ISO = ? AND ROD_Code = ? AND Variant_Code = ? AND Bibles_org = 1';
	$stmt_links_Bibles_org=$db->prepare($query);														// create a prepared statement
	$query='SELECT company, company_title, URL FROM links WHERE ISO = ? AND ROD_Code = ? AND Variant_Code = ? AND GooglePlay = 1';
	$stmt_links_GooglePlay=$db->prepare($query);														// create a prepared statement
	$query='SELECT company, company_title, URL FROM links WHERE ISO = ? AND ROD_Code = ? AND Variant_Code = ? AND GRN = 1';
	$stmt_links_GRN=$db->prepare($query);																// create a prepared statement
	$query='SELECT Cell_Phone_Title, Cell_Phone_File, optional FROM CellPhone WHERE ISO = ? AND ROD_Code = ? AND Variant_Code = ?';
	$stmt_links_CellPhone=$db->prepare($query);
	$query='SELECT PlaylistAudioTitle, PlaylistAudioFilename FROM PlaylistAudio WHERE ISO = ? AND ROD_Code = ? AND Variant_Code = ?';
	$stmt_links_PlaylistAudio=$db->prepare($query);
	$query='SELECT PlaylistVideoTitle, PlaylistVideoFilename, PlaylistVideoDownload FROM PlaylistVideo WHERE ISO = ? AND ROD_Code = ? AND Variant_Code = ?';
	$stmt_links_PlaylistVideo=$db->prepare($query);
	$query='SELECT organization, watch_what, URL, YouTube FROM watch WHERE ISO = ? AND ROD_Code = ? AND Variant_Code = ?';
	$stmt_links_watch=$db->prepare($query);
	$query='SELECT DISTINCT ISO, ROD_Code, Variant_Code FROM SAB WHERE ISO = ? AND ROD_Code = ? AND Variant_Code = ?';
	$stmt_links_SAB=$db->prepare($query);
	$query='SELECT COUNT(*) FROM study WHERE ISO = ? AND ROD_Code = ? AND Variant_Code = ?';
	$stmt_links_study=$db->prepare($query);


	$query='SELECT DISTINCT LN_Temp.LN, nav_ln.ISO, nav_ln.ROD_Code, nav_ln.Variant_Code FROM LN_Temp, nav_ln WHERE LN_Temp.ISO = nav_ln.ISO AND LN_Temp.ROD_Code = nav_ln.ROD_Code ORDER BY LN_Temp.LN';
	$result = $db->query($query);
	$num=$result->num_rows;
	
	// Create 'AllLanguages.csv'
	if ($N == 1) {
		$AllLanguages_Handle = fopen("All_SE_Resources_Number_".date("M.Y").".csv", 'w');		// Open for writing only; place the file pointer at the beginning of the file and truncate the file to zero length. If the file does not exist, attempt to create it. 
	}
	else {
		$AllLanguages_Handle = fopen("All_SE_Resources_".date("M.Y").".csv", 'w');		// Open for writing only; place the file pointer at the beginning of the file and truncate the file to zero length. If the file does not exist, attempt to create it. 
	}

	fwrite($AllLanguages_Handle, 'English Language Name	Alternate Language Name	iso	rod	var	URL	Country(ies)	NT PDF count	NT Audio count	NT Partial PDF count	NT Partial Audio count	NT PDF Whole count	NT Audio Whole count	OT PDF count	OT Audio count	OT Partial PDF count	OT Partial Audio count	OT PDF Whole count	OT Audio Whole count	Bible PDF count	Bible Audio count	Scripture App Builder HTML (SE)	Online Viewer (SE)	Google Play (Android app) (SE)	Android App (SE)	iOS (SE)	Buy	BibleIs	YouVersion	GRN	eBible	GoBible (SE)	MySword (Android) (SE)	Playlist Audio (SE)	Jesus Film	Luke Vidoe	John Video	Acts Video	Genesis Video	God\'s Story Video	The Good Samaritan Video	Magdalena Video	John Animation Video (SE)	Scripture Animation Video (SE)	The Last Day Video	Story of Jesus for Children Video	History	5fish	iTunes	One Story	Bibles for India	Bibles for Russia	Maps	'."\r\n");

	while ($row = $result->fetch_array()) {
		$ISO = $row['ISO'];
		$ROD_Code = $row['ROD_Code'];
		$Variant_Code = $row['Variant_Code'];
		$LN = $row['LN'];

		$alt = '';
		$stmt_alt->bind_param('sss', $ISO, $ROD_Code, $Variant_Code);									// bind parameters for markers
		$stmt_alt->execute();																			// execute query
		$result_alt = $stmt_alt->get_result();															// instead of bind_result (used for only 1 record):
		$num=$result_alt->num_rows;
		if ($num > 0) {
			while ($r_alt = $result_alt->fetch_array()) {
				$alt_lang_name=$r_alt['alt_lang_name'];
				if ($alt == '') {
					$alt = $alt_lang_name;
				}
				else {
					$alt = $alt . ', ' . $alt_lang_name;
				}
			}
		}
		
		$temp_ROD_Code = ($ROD_Code=='00000' ? '' : $ROD_Code);
		$temp_ROD_Code_string = ($ROD_Code=='00000' ? '' : '&rod=' . $ROD_Code);
		$temp_Variant_Code_string = ($Variant_Code=='' ? '' : '&var=' . $Variant_Code);
		
		$Variant_Eng = '';
		$stmt_Variant->bind_param('s', $Variant_Code);												// bind parameters for markers from Variant table
		$stmt_Variant->execute();																	// execute query
		$result_Variant = $stmt_Variant->get_result();												// instead of bind_result (used for only 1 record):
		$num_Variant=$result_Variant->num_rows;
		if ($row_Var = $result_Variant->fetch_array()) {
			$Variant_Eng=$row_Var['Variant_Eng'];
		}

		$FileString = "$LN	$alt	$ISO	$temp_ROD_Code	$Variant_Eng	https://www.scriptureearth.org/00i-Scripture_Index.php?sortby=lang&iso=${ISO}${temp_ROD_Code_string}${temp_Variant_Code_string}	";

		$stmt_countries_Eng->bind_param('ss', $ISO, $ROD_Code);										// bind parameters for markers
		$stmt_countries_Eng->execute();																// execute query
		$result_ISO_countries = $stmt_countries_Eng->get_result();									// instead of bind_result (used for only 1 record):
		$num_ISO_countries=$result_ISO_countries->num_rows;
		$Eng_country = '';
		if ($num_ISO_countries >= 1) {
			$r_ISO_C = $result_ISO_countries->fetch_array();
			$Eng_country = $r_ISO_C['English'];							// first name of the country in the language version
			while ($r_ISO_C = $result_ISO_countries->fetch_array()) {
				$Eng_country = $Eng_country.', '.$r_ISO_C['English'];	// name of the country in the language version
			}
		}
		else {
			echo 'No English country for ' . $ISO . ' ' . $ROD_Code . ' ' . $Variant_Code . '<br />';
		}
		$FileString .= "$Eng_country	";

		$stmt_all_SM->bind_param('sss', $ISO, $ROD_Code, $Variant_Code);							// bind parameters for markers from scripture_main table
		$stmt_all_SM->execute();																	// execute query
		$result_main = $stmt_all_SM->get_result();													// instead of bind_result (used for only 1 record):
		$num_main=$result_main->num_rows;
		$rm = $result_main->fetch_array();
		$NT_PDF=$rm['NT_PDF'];							// boolean: NT_PDF
		$OT_PDF=$rm['OT_PDF'];							// boolean: OT_PDF
		$FCBH=$rm['FCBH'];								// boolean: FCBH
		$NT_Audio=$rm['NT_Audio'];						// boolean: NT_Audio
		$OT_Audio=$rm['OT_Audio'];						// boolean: OT_Audio
		$links=$rm['links'];							// boolean: links							// links table: field map: 1, field GooglePlay: 1; field URL: /mysword/, /5fish.mobi/, /itunes', 
		$other_titles=$rm['other_titles'];				// boolean: other_titles					// other_titles table: Field 'other": genesis || g'enesis, hymn || himn || song, old testament || ot selections || ot summary || Antiguo Testamento; Field "other_title": genesis || génesis, hymn || himn, comic book, study, story, old testament || ot selections || ot summary || Antiguo Testamento; Field "other_PDF": epub; other books/videos
		$watch=$rm['watch'];							// boolean: watch							// watch table: Field "watch_what": acts, genesis, luke, good samaritan, jesus for children
		$buy=$rm['buy'];							 	// boolean: buy								// and field "buy" in links table
		$study=$rm['study'];							// boolean: study							// study table: The Word
		$viewer=$rm['viewer'];							// boolean: viewer
		$CellPhone=$rm['CellPhone'];					// boolean: CellPhone						// CellPhone table: Field "Cell_Phone_Title": "Android App", "GoBible (Java)", "MySword (Android)"
		$BibleIs=$rm['BibleIs'];						// boolean: Bible.is
		$YouVersion=$rm['YouVersion'];					// boolean: YouVersion
		$Bibles_org=$rm['Bibles_org'];					// boolean: Bibles_org
		$PlaylistAudio=$rm['PlaylistAudio'];			// boolean: PlaylistAudio
		$PlaylistVideo=$rm['PlaylistVideo'];			// boolean: PlaylistVideo					// PlaylistVideo table: acts || hechos, GÉNESIS || genesis, lucas || luke, diapositives vidéos || john slide || john animation || juan, scripture animation || scripture slide || scripture video || v(i|'i)deos [a-z ] escritura, jesus film || filme JESUS || film jésus || película jesús, magdalena; field "PlaylistVideoDownload": 1 is downloads
		$SAB=$rm['SAB'];
		$eBible=$rm['eBible'];							// boolean: 
		$SILlink=$rm['SILlink'];						// boolean: 
		$GRN=$rm['GRN'];								// boolean: 
		$NT_PDF_count = NULL;
		$OT_PDF_count = NULL;
		$NT_Audio_count = NULL;
		$OT_Audio_count = NULL;
		$NT_Partial_PDF_count = NULL;
		$OT_Partial_PDF_count = NULL;
		$NT_Partial_Audio_count = NULL;
		$OT_Partial_Audio_count = NULL;
		$NT_PDF_Whole = NULL;
		$OT_PDF_Whole = NULL;
		$NT_Audio_Whole = NULL;
		$OT_Audio_Whole = NULL;
		$Bible_PDF_count = NULL;
		$Bible_Audio_count = NULL;
		$SAB_count = NULL;
		//$viewer_count = NULL;
		$eBible_count = NULL;
		$SILlink_count = NULL;
		$GRN_count = NULL;

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
			else {
				if ($NT_PDF_count === 0) {
					$NT_PDF_count = NULL;
					$NT_Partial_PDF_count = NULL;
				}
				else {
					$NT_Partial_PDF_count = $NT_PDF_count;
				}
			}
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
			else {
				if ($OT_PDF_count === 0) {
					$OT_PDF_count = NULL;
					$OT_Partial_PDF_count = NULL;
				}
				else {
					$OT_Partial_PDF_count = $OT_PDF_count;
				}
			}
		}
		
/*		if ($other_titles === 1) {
			if ($NT_PDF_Whole != 1) {
				$NT_Partial_PDF_count = 'unknown';							// 'There are other NT books in the other_titles table as a results it is unknown which books they are.';
			}
			if ($OT_PDF_Whole != 1) {
				$OT_Partial_PDF_count = 'unknown';							// 'There are other OT books in the other_titles table as a results it is unknown which books they are.';
			}
		}
*/
		
		if ($NT_PDF_Whole === 1 && $OT_PDF_Whole === 1)						// Whole Bible
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
			else {
				if ($NT_Audio_count === 0) {
					$NT_Audio_count = NULL;
					$NT_Partial_Audio_count = NULL;
				}
				else {
					$NT_Partial_Audio_count = $NT_Audio_count;
				}
			}
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
			else {
				if ($OT_Audio_count === 0) {
					$OT_Audio_count = NULL;
					$OT_Partial_Audio_count = NULL;
				}
				else {
					$OT_Partial_Audio_count = $OT_Audio_count;
				}
			}
		}

		//if ($other_titles === 1 && ($NT_Audio_Whole != 1 || $OT_Audio_Whole != 1)) {
		//	$NT_Partial_Audio_count = 100;
		//	$OT_Partial_Audio_count = 100;
		//}
		if ($NT_Audio_Whole === 1 && $OT_Audio_Whole === 1)
			$Bible_Audio_count = 1;

		// SAB table: is there
		$stmt_links_SAB->bind_param('sss', $ISO, $ROD_Code, $Variant_Code);					// bind parameters for markers
		$stmt_links_SAB->execute();															// execute query
		$result_links_SAB = $stmt_links_SAB->get_result();									// instead of bind_result (used for only 1 record):
		while ($r_links = $result_links_SAB->fetch_array()) {
			array_push($SAB_array, ['1', $ISO, $ROD_Code, $Variant_Code]);					// add to $SAB_array
			//echo $SABtemp . ': ' . $ISO . ' ' . $ROD_Code . ' ' . $Variant_Code . '<br />';
			$SABtemp++;
		}
		$SAB_count = 0;
		foreach ($SAB_array as $key => $value) {
			$SAB_count++;
		}
		if ($SAB_count == 0) {
			$SAB_count = NULL;
		}
		$SAB_array = [];
		
		if ($viewer == 0) {
			$viewer = NULL;
		}

		$FileString .= "$NT_PDF_count	$NT_Audio_count	$NT_Partial_PDF_count	$NT_Partial_Audio_count	$NT_PDF_Whole	$NT_Audio_Whole	$OT_PDF_count	$OT_Audio_count	$OT_Partial_PDF_count	$OT_Partial_Audio_count	$OT_PDF_Whole	$OT_Audio_Whole	$Bible_PDF_count	$Bible_Audio_count	$SAB_count	$viewer	";

		// buy
		$stmt_links_first_buy->bind_param('sss', $ISO, $ROD_Code, $Variant_Code);					// bind parameters for markers
		$stmt_links_first_buy->execute();															// execute query
		$result_links_first_buy = $stmt_links_first_buy->get_result();								// instead of bind_result (used for only 1 record):
		while ($r_links = $result_links_first_buy->fetch_array()) {
			$organization = $r_links['organization'];
			$URL = $r_links['URL'];
			$buy_what = $r_links['buy_what'];
			array_push($buy_array, [$URL, $organization, $buy_what, $ISO, $ROD_Code, $Variant_Code]);	// add to $buy_array
		}
		// buy = 1
		$stmt_links_buy->bind_param('sss', $ISO, $ROD_Code, $Variant_Code);							// bind parameters for markers
		$stmt_links_buy->execute();																	// execute query
		$result_links_buy = $stmt_links_buy->get_result();											// instead of bind_result (used for only 1 record):
		while ($r_links = $result_links_buy->fetch_array()) {
			$company = $r_links['company'];
			$URL = $r_links['URL'];
			$type = $r_links['company_title'];
			array_push($buy_array, [$URL, $company, $type, $ISO, $ROD_Code, $Variant_Code]);		// add to $buy_array
		}
		$buy = '';
		foreach ($buy_array as $key => $value) {
			if ($N == 1) {
				$buy = (string)((int)$buy + 1);
				continue;
			}
			if ($key > 0) {
				$buy .=  " ## ";
			}
			if ($value[2] != '') {
				$buy .= $value[2] . ': ';
			}
			//$buy .= '('.$value[1] . '): ';
			$buy .= $value[0];
		}
		$buy_array = [];

		// BibleIs = 1
		$stmt_links_BibleIs->bind_param('sss', $ISO, $ROD_Code, $Variant_Code);						// bind parameters for markers
		$stmt_links_BibleIs->execute();																// execute query
		$result_links_BibleIs = $stmt_links_BibleIs->get_result();									// instead of bind_result (used for only 1 record):
		while ($r_links = $result_links_BibleIs->fetch_array()) {
			$company = $r_links['company'];
			$URL = $r_links['URL'];
			$type = $r_links['company_title'];
			array_push($BibleIs_array, [$URL, $company, $type, $ISO, $ROD_Code, $Variant_Code]);	// add to $BibleIs_array
		}
		$BibleIs = '';
		foreach ($BibleIs_array as $key => $value) {
			if ($N == 1) {
				$BibleIs = (string)((int)$BibleIs + 1);
				continue;
			}
			if ($key > 0) {
				$BibleIs .=  " ## ";
			}
			if ($value[2] != '') {
				$BibleIs .= $value[2] . ': ';
			}
			//$BibleIs .= '('.$value[1] . '): ';
			$BibleIs .= $value[0];
		}
		$BibleIs_array = [];

		// YouVersion = 1
		$stmt_links_YouVersion->bind_param('sss', $ISO, $ROD_Code, $Variant_Code);					// bind parameters for markers
		$stmt_links_YouVersion->execute();															// execute query
		$result_links_YouVersion = $stmt_links_YouVersion->get_result();							// instead of bind_result (used for only 1 record):
		while ($r_links = $result_links_YouVersion->fetch_array()) {
			$company = $r_links['company'];
			$URL = $r_links['URL'];
			$type = $r_links['company_title'];
			array_push($YouVersion_array, [$URL, $company, $type, $ISO, $ROD_Code, $Variant_Code]);	// add to $YouVersion_array
		}
		$YouVersion = '';
		$YouVersion_count = 0;
		foreach ($YouVersion_array as $key => $value) {
			if ($N == 1) {
				$YouVersion_count++;
			$y++;
				continue;
			}
			if ($key > 0) {
				$YouVersion .=  " ## ";
			}
			$value[2] = preg_replace('/[- ]*Bible.com \(YouVersion\)[- ]*(.*)?/', '$1', $value[2]);
			if ($value[2] != '') {
				$YouVersion .= $value[2] . ': ';
			}
			//$YouVersion .= '('.$value[1] . '): ';
			$YouVersion .= $value[0];
		}
		if ($YouVersion == '' && $YouVersion_count != 0) {
			$YouVersion = (string)$YouVersion_count;
		}
		$YouVersion_array = [];
		
		// Bibles_org = 1
		//$stmt_links_Bibles_org->bind_param('sss', $ISO, $ROD_Code, $Variant_Code);					// bind parameters for markers
		//$stmt_links_Bibles_org->execute();															// execute query
		//$result_links_Bibles_org = $stmt_links_Bibles_org->get_result();							// instead of bind_result (used for only 1 record):
		//while ($r_links = $result_links_Bibles_org->fetch_array()) {
		//	$company = $r_links['company'];
		//	$URL = $r_links['URL'];
		//	$type = $r_links['company_title'];
		//	array_push($Bibles_org_array, [$URL, $company, $type, $ISO, $ROD_Code, $Variant_Code]);	// add to $Bibles_org_array
		//}
		//$Bibles_org = '';
		//foreach ($Bibles_org_array as $key => $value) {
		//	if ($key > 0) {
		//		$Bibles_org .=  " ## ";
		//	}
		//	$value[2] = preg_replace('/[- ]*Bibles.org[- ]*(.*)?/', '$1', $value[2]);
		//	if ($value[2] != '') {
		//		$Bibles_org .= $value[2] . ': ';
		//	}
			//$Bibles_org .= '('.$value[1] . '): ';
		//	$Bibles_org .= $value[0];
		//}
		//$Bibles_org_array = [];

		// GooglePlay = 1
		$stmt_links_GooglePlay->bind_param('sss', $ISO, $ROD_Code, $Variant_Code);					// bind parameters for markers
		$stmt_links_GooglePlay->execute();															// execute query
		$result_links_GooglePlay = $stmt_links_GooglePlay->get_result();							// instead of bind_result (used for only 1 record):
		while ($r_links = $result_links_GooglePlay->fetch_array()) {
			$company = $r_links['company'];
			$URL = $r_links['URL'];
			$type = $r_links['company_title'];
			array_push($GooglePlay_array, [$URL, $company, $type, $ISO, $ROD_Code, $Variant_Code]);	// add to $GooglePlay_array
		}
		$GooglePlay = '';
		foreach ($GooglePlay_array as $key => $value) {
			if ($N == 1) {
				$GooglePlay = (string)((int)$GooglePlay + 1);
				continue;
			}
			if ($key > 0) {
				$GooglePlay .=  " ## ";
			}
			$value[2] = preg_replace('/[- ]*Android [Aa]pp[- (]*(.*)[)]?/', '$1', $value[2]);
			if ($value[2] != '') {
				$GooglePlay .= $value[2] . ': ';
			}
			//$GooglePlay .= '('.$value[1] . '): ';
			$GooglePlay .= $value[0];
		}
		$GooglePlay_array = [];

		// GRN = 1
		$stmt_links_GRN->bind_param('sss', $ISO, $ROD_Code, $Variant_Code);							// bind parameters for markers
		$stmt_links_GRN->execute();																	// execute query
		$result_links_GRN = $stmt_links_GRN->get_result();											// instead of bind_result (used for only 1 record):
		while ($r_links = $result_links_GRN->fetch_array()) {
			$company = $r_links['company'];
			$URL = $r_links['URL'];
			$type = $r_links['company_title'];
			array_push($GRN_array, [$URL, $company, $type, $ISO, $ROD_Code, $Variant_Code]);		// add to $GRN_array
		}
		$GRN = '';
		foreach ($GRN_array as $key => $value) {
			if ($N == 1) {
				$GRN = (string)((int)$GRN + 1);
				continue;
			}
			if ($key > 0) {
				$GRN .=  " ## ";
			}
			$value[2] = preg_replace('/[- ]*(Audio recordings|Global Recordings Network)[- ]*(.*)?/', '$2', $value[2]);
			if ($value[2] != '') {
				$GRN .= $value[2] . ': ';
			}
			//$GRN .= '('.$value[1] . '): ';
			$GRN .= $value[0];
		}
		$GRN_array = [];

		// CellPhone table: Cell_Phone_Title	 Cell_Phone_File	optional
		// Android App (*.apk), GoBible (Java) (*.jar), MySword (Android) (*.mybible)
		$stmt_links_CellPhone->bind_param('sss', $ISO, $ROD_Code, $Variant_Code);					// bind parameters for markers
		$stmt_links_CellPhone->execute();															// execute query
		$result_links_CellPhone = $stmt_links_CellPhone->get_result();								// instead of bind_result (used for only 1 record):
		while ($r_links = $result_links_CellPhone->fetch_array()) {
			$Cell_Phone_Title = $r_links['Cell_Phone_Title'];
			$Cell_Phone_File = $r_links['Cell_Phone_File'];
			$optional = $r_links['optional'];
			if (preg_match('/\.apk/i', $Cell_Phone_File)) {
				array_push($App_array, [$Cell_Phone_Title, $Cell_Phone_File, $optional, $ISO, $ROD_Code, $Variant_Code]);		// add to $App_array
			}
			elseif (preg_match('/\.jar/i', $Cell_Phone_File)) {
				array_push($GoBible_array, [$Cell_Phone_Title, $Cell_Phone_File, $optional, $ISO, $ROD_Code, $Variant_Code]);	// add to $GoBible_array
			}
			elseif (preg_match('/\.mybible/i', $Cell_Phone_File)) {
				array_push($MySword_array, [$Cell_Phone_Title, $Cell_Phone_File, $optional, $ISO, $ROD_Code, $Variant_Code]);	// add to $MySword_array
			}
			elseif (preg_match('/iOS /', $Cell_Phone_Title)) {
				array_push($iOS_array, [$Cell_Phone_Title, $Cell_Phone_File, $optional, $ISO, $ROD_Code, $Variant_Code]);		// add to $App_array
			}
			else {
				//
			}
		}
		$App = '';
		foreach ($App_array as $key => $value) {
			if ($N == 1) {
				$App = (string)((int)$App + 1);
				continue;
			}
			if ($key > 0) {
				$App .=  " ## ";
			}
			$App .= 'https://www.scriptureearth.org/data/'.$ISO.'/study/'.$value[1];
			if ($value[2] != '') {
				$App .= ': ' . $value[2];
			}
			//$App .= $value[0];
		}
		$App_array = [];
		$GoBible = '';
		foreach ($GoBible_array as $key => $value) {
			if ($N == 1) {
				$GoBible = (string)((int)$GoBible + 1);
				continue;
			}
			if ($key > 0) {
				$GoBible .=  " ## ";
			}
			//$GoBible .= $value[0] . ': ';
			$GoBible .= 'https://www.scriptureearth.org/data/'.$ISO.'/study/'.$value[1];
			//$GoBible .= $value[2];
		}
		$GoBible_array = [];

		$iOS = '';
		foreach ($iOS_array as $key => $value) {
			if ($N == 1) {
				$iOS = (string)((int)$iOS + 1);
				continue;
			}
			if ($key > 0) {
				$iOS .=  " ## ";
			}
			$iOS .= 'https://www.scriptureearth.org/data/'.$ISO.'/study/'.$value[1];
		}
		$iOS_array = [];

		$MySword = '';
		foreach ($MySword_array as $key => $value) {
			if ($N == 1) {
				$MySword = (string)((int)$MySword + 1);
				continue;
			}
			if ($key > 0) {
				$MySword .=  " ## ";
			}
			//$MySword .= $value[0] . ': ';
			$MySword .= 'https://www.scriptureearth.org/data/'.$ISO.'/study/'.$value[1];
			//$MySword .= $value[2];
		}
		$MySword_array = [];
		
		if ($eBible == 0) {
			$eBible = NULL;
		}
		
		$FileString .= "$GooglePlay	$App	$iOS	$buy	$BibleIs	$YouVersion	$GRN	$eBible	$GoBible	$MySword	";

		// PlaylistAudio table: PlaylistAudioTitle	PlaylistAudioFilename (*txt)
		$stmt_links_PlaylistAudio->bind_param('sss', $ISO, $ROD_Code, $Variant_Code);				// bind parameters for markers
		$stmt_links_PlaylistAudio->execute();														// execute query
		$result_links_PlaylistAudio = $stmt_links_PlaylistAudio->get_result();						// instead of bind_result (used for only 1 record):
		while ($r_links = $result_links_PlaylistAudio->fetch_array()) {
			$PlaylistAudioTitle = $r_links['PlaylistAudioTitle'];
			$PlaylistAudioFilename = $r_links['PlaylistAudioFilename'];
			array_push($PlaylistAudio_array, [$PlaylistAudioTitle, $PlaylistAudioFilename, $ISO, $ROD_Code, $Variant_Code]);	// add to $PlaylistAudio_array
		}
		$PlaylistAudio = '';
		foreach ($PlaylistAudio_array as $key => $value) {
			if ($N == 1) {
				$PlaylistAudio = (string)((int)$PlaylistAudio + 1);
				continue;
			}
			if ($key > 0) {
				$PlaylistAudio .=  " ## ";
			}
			//$PlaylistAudio .= $value[2] . ': ';
			//$PlaylistAudio .= '('.$value[1] . '): ';
			$PlaylistAudio .= $value[0];
		}
		$PlaylistAudio_array = [];
		
		$FileString .= "$PlaylistAudio	";
		
		// PlaylistVideo table: PlaylistVideoTitle	PlaylistVideoFilename (*.txt)	PlaylistVideoDownload (0 or 1)
		$stmt_links_PlaylistVideo->bind_param('sss', $ISO, $ROD_Code, $Variant_Code);				// bind parameters for markers
		$stmt_links_PlaylistVideo->execute();														// execute query
		$result_links_PlaylistVideo = $stmt_links_PlaylistVideo->get_result();						// instead of bind_result (used for only 1 record):
		while ($r_links = $result_links_PlaylistVideo->fetch_array()) {
			$PlaylistVideoTitle = $r_links['PlaylistVideoTitle'];
			$PlaylistVideoFilename = $r_links['PlaylistVideoFilename'];
			$PlaylistVideoDownload = $r_links['PlaylistVideoDownload'];
			// Jesus Film	Luke	John	Acts	Genesis	God's Story	Good Samaritan	Magdalena	John Animation	Scripture Animation	
			
			// Genesis: both /genesis/
			if (preg_match('/genesis/i', $PlaylistVideoTitle) || preg_match('/genesis/i', $PlaylistVideoFilename)) {
				array_push($PlaylistGenesis_array, [$PlaylistVideoTitle, $PlaylistVideoFilename, $PlaylistVideoDownload, $ISO, $ROD_Code, $Variant_Code]);		// add to $PlaylistGenesis_array
			}
			// Acts: both /acts/, /hechos/
			elseif (preg_match('/acts/i', $PlaylistVideoTitle) || preg_match('/acts/i', $PlaylistVideoFilename) || preg_match('/hechos/i', $PlaylistVideoTitle) || preg_match('/hechos/i', $PlaylistVideoFilename)) {
				array_push($PlaylistActs_array, [$PlaylistVideoTitle, $PlaylistVideoFilename, $PlaylistVideoDownload, $ISO, $ROD_Code, $Variant_Code]);			// add to $PlaylistActs_array
			}
			// Scripture Animation: PlaylistVideoTitle: /scripture\s*anim/, /(?!juan) escrituras/; PlaylistAudioFilename: /scr.*anim/, /scrslide/
			elseif (preg_match('/scripture\s*anim/i', $PlaylistVideoTitle) || preg_match('/scr.*anim/i', $PlaylistVideoFilename) || preg_match('/(?!juan) escrituras/i', $PlaylistVideoTitle) || preg_match('/scrslide/i', $PlaylistVideoFilename) || preg_match('/scripture.*vid[eo]*s/i', $PlaylistVideoFilename)) {
				array_push($PlaylistScriptAnim_array, [$PlaylistVideoTitle, $PlaylistVideoFilename, $PlaylistVideoDownload, $ISO, $ROD_Code, $Variant_Code]);	// add to $PlaylistScriptAnim_array
			}
			// John Animation: PlaylistVideoTitle: /john\s*anim/, /juan .* escrituras/; PlaylistAudioFilename: /john.*anim/, /johnslide/
			elseif (preg_match('/john\s*anim/i', $PlaylistVideoTitle) || preg_match('/john.*anim/i', $PlaylistVideoFilename) || preg_match('/juan .* escrituras/i', $PlaylistVideoTitle) || preg_match('/johnslide/i', $PlaylistVideoFilename) || preg_match('/john.*vid[eo]*s/i', $PlaylistVideoFilename)) {
				array_push($PlaylistJohnAnim_array, [$PlaylistVideoTitle, $PlaylistVideoFilename, $PlaylistVideoDownload, $ISO, $ROD_Code, $Variant_Code]);		// add to $PlaylistJohnAnim_array
			}
			// John: both /john/, /juan/
			elseif (preg_match('/john/i', $PlaylistVideoTitle) || preg_match('/john/i', $PlaylistVideoFilename) || preg_match('/juan/i', $PlaylistVideoTitle) || preg_match('/juan/i', $PlaylistVideoFilename)) {
				array_push($PlaylistJohn_array, [$PlaylistVideoTitle, $PlaylistVideoFilename, $PlaylistVideoDownload, $ISO, $ROD_Code, $Variant_Code]);			// add to $PlaylistJohn_array
			}
			// Luke: both /luke/, /lucas/
			elseif (preg_match('/luke/i', $PlaylistVideoTitle) || preg_match('/luke/i', $PlaylistVideoFilename) || preg_match('/lucas/i', $PlaylistVideoTitle) || preg_match('/lucas/i', $PlaylistVideoFilename)) {
				array_push($PlaylistLuke_array, [$PlaylistVideoTitle, $PlaylistVideoFilename, $PlaylistVideoDownload, $ISO, $ROD_Code, $Variant_Code]);			// add to $PlaylistLuke_array
			}
			// God's Story: PlaylistVideoTitle: ; PlaylistAudioFilename: /godsstory/
			elseif (preg_match('/godsstory/i', $PlaylistVideoFilename)) {
				array_push($PlaylistGodsStory_array, [$PlaylistVideoTitle, $PlaylistVideoFilename, $PlaylistVideoDownload, $ISO, $ROD_Code, $Variant_Code]);	// add to $PlaylistGodsStory_array
			}
			// Jesus: both /jesus/
			elseif (preg_match('/jesus/i', $PlaylistVideoTitle) || preg_match('/jesus/i', $PlaylistVideoFilename)) {
				array_push($PlaylistJesus_array, [$PlaylistVideoTitle, $PlaylistVideoFilename, $PlaylistVideoDownload, $ISO, $ROD_Code, $Variant_Code]);		// add to $PlaylistJesus_array
			}
			// Magdalena: both /magdalena/
			elseif (preg_match('/magdalena/i', $PlaylistVideoTitle) || preg_match('/magdalena/i', $PlaylistVideoFilename)) {
				array_push($PlaylistMagdalena_array, [$PlaylistVideoTitle, $PlaylistVideoFilename, $PlaylistVideoDownload, $ISO, $ROD_Code, $Variant_Code]);	// add to $PlaylistMagdalena_array
			}
			// The Good Samaritan: both /good\s*samaritan/
			elseif (preg_match('/good\s*samaritan/i', $PlaylistVideoTitle) || preg_match('/good\s*samaritan/i', $PlaylistVideoFilename)) {
				array_push($PlaylistSamaritan_array, [$PlaylistVideoTitle, $PlaylistVideoFilename, $PlaylistVideoDownload, $ISO, $ROD_Code, $Variant_Code]);	// add to $PlaylistSamaritan_array
			}
			else {
				//
			}
		}
		
		// watch table: organization	watch_what	URL	YouTube (0 or 1)
		$stmt_links_watch->bind_param('sss', $ISO, $ROD_Code, $Variant_Code);						// bind parameters for markers
		$stmt_links_watch->execute();																// execute query
		$result_links_watch = $stmt_links_watch->get_result();										// instead of bind_result (used for only 1 record):
		while ($r_links = $result_links_watch->fetch_array()) {
			$organization = $r_links['organization'];
			$watch_what = $r_links['watch_what'];
			$URL = $r_links['URL'];
			$YouTube = $r_links['YouTube'];															// 0 or 1
			// The Story of Jesus for Children: watch_what: /children/
			if (preg_match('/children/i', $watch_what)) {
				array_push($Children_array, [$organization, $watch_what, $URL, $YouTube, $ISO, $ROD_Code, $Variant_Code]);		// add to $Children_array
			}
			// Jesus: organization: /jesus/, URL: /jesus/
			elseif (preg_match('/jesus/i', $organization) || preg_match('/jesus/i', $URL)) {
				array_push($PlaylistJesus_array, [$watch_what, $URL, $YouTube, $ISO, $ROD_Code, $Variant_Code]);				// add to $PlaylistJesus_array
			}
			// 5fish: URL: /5fish/
			elseif (preg_match('/5fish/i', $URL)) {
				array_push($fish_array, [$organization, $watch_what, $URL, $YouTube, $ISO, $ROD_Code, $Variant_Code]);			// add to $fish_array
			}
			// History: watch_what: /historia/
			elseif (preg_match('/historia/i', $watch_what)) {
				array_push($History_array, [$organization, $watch_what, $URL, $YouTube, $ISO, $ROD_Code, $Variant_Code]);		// add to $History_array
			}
			// My Last Day: what_what: /last\s*day/
			elseif (preg_match('/last\s*day/i', $watch_what)) {
				array_push($LastDay_array, [$organization, $watch_what, $URL, $YouTube, $ISO, $ROD_Code, $Variant_Code]);		// add to $LastDay_array
			}
			// Acts: watch_what: /acts/
			elseif (preg_match('/acts/i', $watch_what)) {
				array_push($PlaylistActs_array, [$watch_what, $URL, $YouTube, $ISO, $ROD_Code, $Variant_Code]);					// add to $PlaylistActs_array
			}
			// Genesis: watch_what: /genesis/
			elseif (preg_match('/genesis/i', $watch_what)) {
				array_push($PlaylistGenesis_array, [$watch_what, $URL, $YouTube, $ISO, $ROD_Code, $Variant_Code]);				// add to $PlaylistGenesis_array
			}
			// The Good Samaritan: watch_what: /good\s*samaritan/
			elseif (preg_match('/good\s*samaritan/i', $watch_what)) {
				array_push($PlaylistSamaritan_array, [$watch_what, $URL, $YouTube, $ISO, $ROD_Code, $Variant_Code]);			// add to $PlaylistSamaritan_array
			}
			// Luke: watch_what: /luke/
			elseif (preg_match('/luke/i', $watch_what) || preg_match('/lucas/i', $watch_what)) {
				array_push($PlaylistLuke_array, [$watch_what, $URL, $YouTube, $ISO, $ROD_Code, $Variant_Code]);					// add to $PlaylistLuke_array
			}
			else {
				//
			}
		}

		$PlaylistGenesis = '';
		foreach ($PlaylistGenesis_array as $key => $value) {
			if ($N == 1) {
				$PlaylistGenesis = (string)((int)$PlaylistGenesis + 1);
				continue;
			}
			if ($key > 0) {
				$PlaylistGenesis .=  " ## ";
			}
			//$PlaylistGenesis .= $value[2] . ': ';
			$PlaylistGenesis .= 'https://www.scriptureearth.org/data/'.$ISO.'/video/'.$value[1];
			//$PlaylistGenesis .= $value[0];
		}
		$PlaylistGenesis_array = [];
		
		$PlaylistActs = '';
		foreach ($PlaylistActs_array as $key => $value) {
			if ($N == 1) {
				$PlaylistActs = (string)((int)$PlaylistActs + 1);
				continue;
			}
			if ($key > 0) {
				$PlaylistActs .=  " ## ";
			}
			//$PlaylistActs .= $value[2] . ': ';
			$PlaylistActs .= 'https://www.scriptureearth.org/data/'.$ISO.'/video/'.$value[1];
			//$PlaylistActs .= $value[0];
		}
		$PlaylistActs_array = [];
		
		$PlaylistScriptAnim = '';
		foreach ($PlaylistScriptAnim_array as $key => $value) {
			if ($N == 1) {
				$PlaylistScriptAnim = (string)((int)$PlaylistScriptAnim + 1);
				continue;
			}
			if ($key > 0) {
				$PlaylistScriptAnim .=  " ## ";
			}
			//$PlaylistScriptAnim .= $value[2] . ': ';
			$PlaylistScriptAnim .= 'https://www.scriptureearth.org/data/'.$ISO.'/video/'.$value[1];
			//$PlaylistScriptAnim .= $value[0];
		}
		$PlaylistScriptAnim_array = [];
		
		$PlaylistJohnAnim = '';
		foreach ($PlaylistJohnAnim_array as $key => $value) {
			if ($N == 1) {
				$PlaylistJohnAnim = (string)((int)$PlaylistJohnAnim + 1);
				continue;
			}
			if ($key > 0) {
				$PlaylistJohnAnim .=  " ## ";
			}
			//$PlaylistJohnAnim .= $value[2] . ': ';
			$PlaylistJohnAnim .= 'https://www.scriptureearth.org/data/'.$ISO.'/video/'.$value[1];
			//$PlaylistJohnAnim .= $value[0];
		}
		$PlaylistJohnAnim_array = [];
		
		$PlaylistJohn = '';
		foreach ($PlaylistJohn_array as $key => $value) {
			if ($N == 1) {
				$PlaylistJohn = (string)((int)$PlaylistJohn + 1);
				continue;
			}
			if ($key > 0) {
				$PlaylistJohn .=  " ## ";
			}
			//$PlaylistJohn .= $value[2] . ': ';
			$PlaylistJohn .= '('.$value[1] . '): ';
			$PlaylistJohn .= $value[0];
		}
		$PlaylistJohn_array = [];
		
		$PlaylistLuke = '';
		foreach ($PlaylistLuke_array as $key => $value) {
			if ($N == 1) {
				$PlaylistLuke = (string)((int)$PlaylistLuke + 1);
				continue;
			}
			if ($key > 0) {
				$PlaylistLuke .=  " ## ";
			}
			//$PlaylistLuke .= $value[2] . ': ';
			$PlaylistLuke .= 'https://www.scriptureearth.org/data/'.$ISO.'/video/'.$value[1];
			//$PlaylistLuke .= $value[0];
		}
		$PlaylistLuke_array = [];
		
		$PlaylistGodsStory = '';
		foreach ($PlaylistGodsStory_array as $key => $value) {
			if ($N == 1) {
				$PlaylistGodsStory = (string)((int)$PlaylistGodsStory + 1);
				continue;
			}
			if ($key > 0) {
				$PlaylistGodsStory .=  " ## ";
			}
			//$PlaylistGodsStory .= $value[2] . ': ';
			$PlaylistGodsStory .= 'https://www.scriptureearth.org/data/'.$ISO.'/video/'.$value[1];
			//$PlaylistGodsStory .= $value[0];
		}
		$PlaylistGodsStory_array = [];
		
		$PlaylistJesus = '';
		foreach ($PlaylistJesus_array as $key => $value) {
			if ($N == 1) {
				$PlaylistJesus = (string)((int)$PlaylistJesus + 1);
				continue;
			}
			if ($key > 0) {
				$PlaylistJesus .=  " ## ";
			}
			//$PlaylistJesus .= $value[2] . ': ';
			$PlaylistJesus .= 'https://www.scriptureearth.org/data/'.$ISO.'/video/'.$value[1];
			//$PlaylistJesus .= $value[0];
		}
		$PlaylistJesus_array = [];
		
		$PlaylistMagdalena = '';
		foreach ($PlaylistMagdalena_array as $key => $value) {
			if ($N == 1) {
				$PlaylistMagdalena = (string)((int)$PlaylistMagdalena + 1);
				continue;
			}
			if ($key > 0) {
				$PlaylistMagdalena .=  " ## ";
			}
			//$PlaylistMagdalena .= $value[2] . ': ';
			$PlaylistMagdalena .= 'https://www.scriptureearth.org/data/'.$ISO.'/video/'.$value[1];
			//$PlaylistMagdalena .= $value[0];
		}
		$PlaylistMagdalena_array = [];
		
		$PlaylistSamaritan = '';
		foreach ($PlaylistSamaritan_array as $key => $value) {
			if ($N == 1) {
				$PlaylistSamaritan = (string)((int)$PlaylistSamaritan + 1);
				continue;
			}
			if ($key > 0) {
				$PlaylistSamaritan .=  " ## ";
			}
			//$PlaylistSamaritan .= $value[2] . ': ';
			$PlaylistSamaritan .= 'https://www.scriptureearth.org/data/'.$ISO.'/video/'.$value[1];
			//$PlaylistSamaritan .= $value[0];
		}
		$PlaylistSamaritan_array = [];

		$FileString .= "$PlaylistJesus	$PlaylistLuke	$PlaylistJohn	$PlaylistActs	$PlaylistGenesis	$PlaylistGodsStory	$PlaylistSamaritan	$PlaylistMagdalena	$PlaylistJohnAnim	$PlaylistScriptAnim	";
		
		$Children = '';
		foreach ($Children_array as $key => $value) {
			if ($N == 1) {
				$Children = (string)((int)$Children + 1);
				continue;
			}
			if ($key > 0) {
				$Children .=  " ## ";
			}
			$Children .= $value[2];
			//$Children .= '('.$value[1] . '): ';
			//$Children .= $value[0];
		}
		$Children_array = [];
		
		$fish = '';
		foreach ($fish_array as $key => $value) {
			if ($N == 1) {
				$fish = (string)((int)$fish + 1);
				continue;
			}
			if ($key > 0) {
				$fish .=  " ## ";
			}
			$fish .= $value[2] . ' ';
			$fish .= '('.$value[1] . '): ';
			//$fish .= $value[0];
		}
		$fish_array = [];
		
		$History = '';
		foreach ($History_array as $key => $value) {
			if ($N == 1) {
				$History = (string)((int)$History + 1);
				continue;
			}
			if ($key > 0) {
				$History .=  " ## ";
			}
			$History .= $value[2] . ': ';
			$History .= '('.$value[1] . ')';
			//$History .= $value[0];
		}
		$History_array = [];
		
		$LastDay = '';
		foreach ($LastDay_array as $key => $value) {
			if ($N == 1) {
				$LastDay = (string)((int)$LastDay + 1);
				continue;
			}
			if ($key > 0) {
				$LastDay .=  " ## ";
			}
			$LastDay .= $value[2] . ': ';
			$LastDay .= '('.$value[1] . '): ';
			$LastDay .= $value[0];
		}
		$LastDay_array = [];
		
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
				array_push($map_array, [$URL, $type, $ISO, $ROD_Code]);									// add to $map_array
			}
			elseif (preg_match('/itunes/i', $URL)) {
				array_push($itunes_array, [$URL, $company, $type, $ISO, $ROD_Code, $Variant_Code]);		// add to $itunes_array
			}
			elseif (preg_match('/biblesindia/i', $URL)) {
				// India Bibles - biblesindia
				array_push($india_array, [$URL, $company, $type, $ISO, $ROD_Code, $Variant_Code]);		// add to $india_array
			}
			elseif (preg_match('/onestory/i', $URL)) {
				// Listen to Scripture stories (OneStory) - onestory
				array_push($oneStory_array, [$URL, $company, $type, $ISO, $ROD_Code, $Variant_Code]);	// add to $oneStory_array
			}
			elseif (preg_match('/\/ibt\.org/i', $URL)) {
				// Institute for Bible Translation - /ibt.org
				array_push($ibt_array, [$URL, $company, $type, $ISO, $ROD_Code, $Variant_Code]);		// add to $ibt_array
			}
			else {
				//$link .= '		<link company="' . $company . '" type="' . $type . '" URL="' . $URL . '" />' . PHP_EOL;		// ISO_Langauage.xml
			}
		}
		
		$maps = '';
		foreach ($map_array as $key => $value) {
			if ($N == 1) {
				$maps = (string)((int)$maps + 1);
				continue;
			}
			if ($key > 0) {
				$maps .=  " ## ";
			}
			$maps .= $value[1] . ": ";
			$maps .= $value[0];
		}
		$map_array = [];
		
		$itunes = '';
		foreach ($itunes_array as $key => $value) {
			if ($N == 1) {
				$itunes = (string)((int)$itunes + 1);
				continue;
			}
			if ($key > 0) {
				$itunes .=  " ## ";
			}
			//$itunes .= $value[2] . ' ';
			//$itunes .= '('.$value[1] . '): ';
			$itunes .= $value[0];
		}
		$itunes_array = [];
		
		$india = '';
		foreach ($india_array as $key => $value) {
			if ($N == 1) {
				$india = (string)((int)$india + 1);
				continue;
			}
			if ($key > 0) {
				$india .=  " ## ";
			}
			//$india .= $value[2] . ' ';
			//$india .= '('.$value[1] . '): ';
			$india .= $value[0];
		}
		$india_array = [];
		
		$oneStory = '';
		foreach ($oneStory_array as $key => $value) {
			if ($N == 1) {
				$oneStory = (string)((int)$oneStory + 1);
				continue;
			}
			if ($key > 0) {
				$oneStory .=  " ## ";
			}
			//$oneStory .= $value[2] . ' ';
			//$oneStory .= '('.$value[1] . '): ';
			$oneStory .= $value[0];
		}
		$oneStory_array = [];
		
		$ibt = '';
		foreach ($ibt_array as $key => $value) {
			if ($N == 1) {
				$ibt = (string)((int)$ibt + 1);
				continue;
			}
			if ($key > 0) {
				$ibt .=  " ## ";
			}
			//$ibt .= $value[2] . ' ';
			//$ibt .= '('.$value[1] . '): ';
			$ibt .= $value[0];
		}
		$ibt_array = [];

		$FileString .= "$LastDay	$Children	$History	$fish	$itunes	$oneStory	$india	$ibt	$maps	";
		
		// study table: (The Word) is there
		$stmt_links_study->bind_param('sss', $ISO, $ROD_Code, $Variant_Code);				// bind parameters for markers
		$stmt_links_study->execute();														// execute query
		$result_links_study = $stmt_links_study->get_result();								// instead of bind_result (used for only 1 record):
		while ($r_links = $result_links_study->fetch_array()) {
			//$Testament = $r_links['Testament'];
			//$alphabet = $r_links['alphabet'];
			//$ScriptureURL = $r_links['ScriptureURL'];
			array_push($study_array, ['1', $ISO, $ROD_Code, $Variant_Code]);				// add to $study_array
		}
		
		$study = '';
		foreach ($study_array as $key => $value) {
		}
	
		$FileString .= "\r\n";
	
		fwrite($AllLanguages_Handle, $FileString);
		$FileString = '';
	}
	
	fclose($AllLanguages_Handle);
	
	/* Explicitly destroy the table */
	$db->query('DROP TABLE LN_Temp');
	
echo '<p style="color: blue; font-weight: bold; ">End.</p>';
echo 'SAB: ' .$SABtemp . '<br />';
echo 'YouVersion: ' . $y . '<br />';
?>
</body>
</html>
