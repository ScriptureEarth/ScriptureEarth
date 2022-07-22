<?php
/*
All tales have ISO, ROD_Code, Variant_Code, and ISO_ROD_index

Old Testament audio player downloadable (mp3) - OT_Audio_Media table
    OT_Audio_Book (number)
    OT_Audio_Filename
    OT_Audio_Chapter (number)

New Testament audio player downloadable (mp3) - NT_Audio_Media table
    NT_Audio_Book (number)
    NT_Audio_Filename
    NT_Audio_Chapter (number)

Audio playlist downloadable - PlaylistAudio table
    PlaylistAudioTitle
	PlaylistAudioFilename (txt)

Video playlist downloadable (mp4) - PlaylistVideo table - PlaylistVideoDownload = 1
    PlaylistVideoTitle
    PlaylistVideoFilename (txt)

other_tables table - download_video IS NOT NULL AND download_video <> ''
    other
    other_title
    download_video

The Word - study table
    Testament
    alphabet
    ScriptureURL
    othersiteURL
*/

$index = 0;
$first = '';
$marks = [];
$json_string = '';

include ('../OT_Books.php');							// $OT_array
include ('../NT_Books.php');							// $NT_array
define ('OT_EngBook', 2);
define ('NT_EngBook', 2);
define ('OT_Abbrev', 5);
define ('NT_Abbrev', 5);

require_once '../include/conn.inc.php';															// connect to the database named 'scripture'
$db = get_my_db();

include 'include/v.key.php';																	// get v and key

include 'include/idx.iso.php';																	// get idx or iso

if ($index == 0) {
	die ('HACK!');
}

//echo $index . '<br />';
//echo  $iso . '; rod=' . $rod . '; var=' . $var . '<br />';

if ($index == 1) {
    $stmt_main = $db->prepare("SELECT * FROM `scripture_main` WHERE ISO_ROD_index = ? AND (`OT_Audio` = 1 OR `NT_Audio` = 1 OR `PlaylistAudio` = 1 OR `PlaylistVideo` = 1 OR `other_titles` = 1 OR `study` = 1)");
    $stmt_main->bind_param('i', $idx);															// bind parameters for markers
}
else {
	if ($rod == 'ALL' && $var == 'ALL') {
		$stmt_main = $db->prepare("SELECT * FROM `scripture_main` WHERE `ISO` = ? AND (`OT_Audio` = 1 OR `NT_Audio` = 1 OR `PlaylistAudio` = 1 OR `PlaylistVideo` = 1 OR `other_titles` = 1 OR `study` = 1) ORDER BY `ROD_Code`, `Variant_Code`");
		$stmt_main->bind_param('s', $iso);														// bind parameters for markers
	}
	elseif ($rod == 'ALL') {
		$stmt_main = $db->prepare("SELECT * FROM `scripture_main` WHERE `ISO` = ? AND `Variant_Code` = ? AND (`OT_Audio` = 1 OR `NT_Audio` = 1 OR `PlaylistAudio` = 1 OR `PlaylistVideo` = 1 OR `other_titles` = 1 OR `study` = 1) ORDER BY `ROD_Code`, `Variant_Code`");
		$stmt_main->bind_param('ss', $iso, $var);												// bind parameters for markers
	}
	elseif ($var == 'ALL') {
			$stmt_main = $db->prepare("SELECT * FROM `scripture_main` WHERE `ISO` = ? AND `ROD_Code` = ? AND (`OT_Audio` = 1 OR `NT_Audio` = 1 OR `PlaylistAudio` = 1 OR `PlaylistVideo` = 1 OR `other_titles` = 1 OR `study` = 1) ORDER BY `ROD_Code`, `Variant_Code`");
			$stmt_main->bind_param('ss', $iso, $rod);											// bind parameters for markers
	}
	else {
		$stmt_main = $db->prepare("SELECT * FROM `scripture_main` WHERE `ISO` = ? AND `ROD_Code` = ? AND `Variant_Code` = ? AND (`OT_Audio` = 1 OR `NT_Audio` = 1 OR `PlaylistAudio` = 1 OR `PlaylistVideo` = 1 OR `other_titles` = 1 OR `study` = 1) ORDER BY `ROD_Code`, `Variant_Code`");
		$stmt_main->bind_param('sss', $iso, $rod, $var);										// bind parameters for markers
	}
}

$stmt_main->execute();															        		// execute query
$result_main = $stmt_main->get_result();

$stmt_OT_Audio = $db->prepare("SELECT `OT_Audio_Book`, `OT_Audio_Filename`, `OT_Audio_Chapter` FROM OT_Audio_Media WHERE ISO_ROD_index = ? ORDER BY `OT_Audio_Book`, `OT_Audio_Chapter`");
$stmt_NT_Audio = $db->prepare("SELECT `NT_Audio_Book`, `NT_Audio_Filename`, `NT_Audio_Chapter` FROM NT_Audio_Media WHERE ISO_ROD_index = ? ORDER BY `NT_Audio_Book`, `NT_Audio_Chapter`");
$stmt_PlaylistAudio = $db->prepare("SELECT `PlaylistAudioTitle`, `PlaylistAudioFilename` FROM PlaylistAudio WHERE ISO_ROD_index = ?");
$stmt_PlaylistVideo = $db->prepare("SELECT `PlaylistVideoTitle`, `PlaylistVideoFilename` FROM PlaylistVideo WHERE ISO_ROD_index = ? AND `PlaylistVideoDownload` = 1");
$stmt_other_titles = $db->prepare("SELECT other, other_title, other_PDF, other_audio FROM other_titles WHERE ISO_ROD_index = ? AND (download_video IS NOT NULL AND download_video <> '')");
$stmt_study = $db->prepare("SELECT Testament, alphabet, ScriptureURL, othersiteURL FROM study WHERE ISO_ROD_index = ?");

$m=0;

$main_rows = $result_main->num_rows;                                                            // number of rows for PDF OT
if ($main_rows == 0) {
    die ('idx or iso does not exist in SE.');
}

$first = '{';
while ($row_main = $result_main->fetch_assoc()) {
    $iso = $row_main['ISO'];
    $rod = $row_main['ROD_Code'];
    $var = $row_main['Variant_Code'];
    $Variant_name = '';
    if ($var != '') {
        $stmt_var->bind_param('s', $var);													    // bind parameters for markers
        $stmt_var->execute();																    // execute query
        $result_temp = $stmt_var->get_result();
        $row_temp = $result_temp->fetch_assoc();
        $Variant_name = $row_temp['Variant_Eng'];
    }
    $idx = (int)$row_main['ISO_ROD_index'];

    $stmt_OT_Audio->bind_param('i', $idx);												        // bind parameters for markers
    $stmt_OT_Audio->execute();															        // execute query
    $result_OT_Audio = $stmt_OT_Audio->get_result();
    $stmt_NT_Audio->bind_param('i', $idx);												        // bind parameters for markers
    $stmt_NT_Audio->execute();															        // execute query
    $result_NT_Audio = $stmt_NT_Audio->get_result();
    $stmt_PlaylistAudio->bind_param('i', $idx);													// bind parameters for markers
    $stmt_PlaylistAudio->execute();																// execute query
    $result_PlaylistAudio = $stmt_PlaylistAudio->get_result();
    $stmt_PlaylistVideo->bind_param('i', $idx);													// bind parameters for markers
    $stmt_PlaylistVideo->execute();																// execute query
    $result_PlaylistVideo = $stmt_PlaylistVideo->get_result();
    $stmt_other_titles->bind_param('i', $idx);													// bind parameters for markers
    $stmt_other_titles->execute();																// execute query
    $result_other_titles = $stmt_other_titles->get_result();
    $stmt_study->bind_param('i', $idx);													        // bind parameters for markers
    $stmt_study->execute();																        // execute query
    $result_study = $stmt_study->get_result();

    $OT_Audio=$row_main['OT_Audio'];					// boolean
    $NT_Audio=$row_main['NT_Audio'];				    // boolean
    $PlaylistAudio=$row_main['PlaylistAudio'];			// boolean
    $PlaylistVideo=$row_main['PlaylistVideo'];			// boolean
    $other_titles = $row_main['other_titles'];			// boolean
    $study=$row_main['study'];							// boolean

    $m++;																					    // id
    $first .= '"'.($m-1).'": ';
    $first .= '{"type":                     "SE Downloads",';
    $first .= '"id":                        "'.$m.'",';
    $first .= '"attributes": {';
    $first .= '"iso":                       "'.$iso.'",';
    $first .= '"rod":				        "'.$rod.'",';
    $first .= '"var_code":		    	    "'.$var.'",';
    $first .= '"var_name":					"'.$Variant_name.'",';
    $first .= '"iso_query_string":	        "sortby=lang&iso='.$iso;
    if ($rod != '00000') {
        $first .= '&rod='.$rod;
    }
    if ($var != '') {
        $first .= '&var='.$var;
    }
    $first .= '",';
    $first .= '"idx":		                '.$idx.',';
    $first .= '"idx_query_string":          "sortby=lang&idx='.$idx.'"';	
    $first .= '},';
    $first .= '"relationships": {';

    $n = 0;
    if ($OT_Audio) {
        $OT_Audio_Book_Temp = -1;
        if ($result_OT_Audio->num_rows > 0) {
            $first .= '"OT_Audio": {';
            $first .= '"path":          "/data/'.$iso.'/audio",';
        }
        while ($r_links=$result_OT_Audio->fetch_array(MYSQLI_ASSOC)) {
            $OT_Audio_Book=$r_links['OT_Audio_Book'];
            $OT_Audio_Filename=trim($r_links['OT_Audio_Filename']);
            $OT_Audio_Chapter=$r_links['OT_Audio_Chapter'];
            // 01_GEN_001.mp3, 41-MATjic-01.mp3
            if (preg_match('/[0-9][-_]([A-Z1-3][A-Z]{2})/', $OT_Audio_Filename, $matches)) {        // e.g., GEN
                $BookText = $matches[1];
            }
            else {
                die('The OT book cannot be located: '.$OT_Audio_Filename);
            }
            
            if ($OT_Audio_Book != $OT_Audio_Book_Temp) {
                if ($n != 0) {
                    $first = rtrim($first, ',');
                    $first .= '},'; 
                }
                $key_array = array_search($BookText, $OT_array[OT_Abbrev]);
                $bookRegularText = $OT_array[OT_EngBook][$key_array];
                $first .= '"'.$bookRegularText.' ('.$BookText.')": {';
                $n = 0;
            }
            $n++;
            $first .= '"'.$BookText.' '.$OT_Audio_Chapter.'":       "'.$OT_Audio_Filename.'",';
            if ($OT_Audio_Book != $OT_Audio_Book_Temp) {
                if ($OT_Audio_Book_Temp != 0) {
                }
                $OT_Audio_Book_Temp = $OT_Audio_Book;
            }
        }
        if ($result_OT_Audio->num_rows > 0) {
            $first = rtrim($first, ',');
            $first .= '}},';
        }
    }

    $n = 0;
    if ($NT_Audio) {
        $NT_Audio_Book_Temp = -1;
        if ($result_NT_Audio->num_rows > 0) {
            $first .= '"NT_Audio": {';
            $first .= '"path":          "/data/'.$iso.'/audio",';
        }
        while ($r_links=$result_NT_Audio->fetch_array(MYSQLI_ASSOC)) {
            $NT_Audio_Book=$r_links['NT_Audio_Book'];
            $NT_Audio_Filename=trim($r_links['NT_Audio_Filename']);
            $NT_Audio_Chapter=$r_links['NT_Audio_Chapter'];
            // 01_GEN_001.mp3, 41-MATjic-01.mp3
            if (preg_match('/[0-9][-_]([A-Z1-3][A-Z]{2})/', $NT_Audio_Filename, $matches)) {        // e.g., GEN
                $BookText = $matches[1];
            }
            else {
                die('The NT book cannot be located: '.$NT_Audio_Filename);
            }
            
            if ($NT_Audio_Book != $NT_Audio_Book_Temp) {
                if ($n != 0) {
                    $first = rtrim($first, ',');
                    $first .= '},'; 
                }
                $key_array = array_search($BookText, $NT_array[NT_Abbrev]);
                $bookRegularText = $NT_array[NT_EngBook][$key_array];
                $first .= '"'.$bookRegularText.' ('.$BookText.')": {';
                $n = 0;
            }
            $n++;
            $first .= '"'.$BookText.' '.$NT_Audio_Chapter.'":       "'.$NT_Audio_Filename.'",';
            if ($NT_Audio_Book != $NT_Audio_Book_Temp) {
                if ($NT_Audio_Book_Temp != 0) {
                }
                $NT_Audio_Book_Temp = $NT_Audio_Book;
            }
        }
        if ($result_NT_Audio->num_rows > 0) {
            $first = rtrim($first, ',');
            $first .= '}},';
        }
    }

    $n=0;
//    $PlaylistAudio=$row_main['PlaylistAudio'];			// boolean  `PlaylistAudioTitle`, `PlaylistAudioFilename`
    if ($PlaylistAudio) {
        if ($result_PlaylistAudio->num_rows > 0) {
            $first .= '"PlaylistAudio": {';
            $first .= '"path":          "/data/'.$iso.'/audio",';
        }
        while ($r2 = $result_PlaylistAudio->fetch_array(MYSQLI_ASSOC)) {
            $PlaylistAudioTitle=trim($r2['PlaylistAudioTitle']);
            $PlaylistAudioFilename=trim($r2['PlaylistAudioFilename']);
            $first .= '"'.$n++.'":	{';
            $first .= '"Title":                         "'.$PlaylistAudioTitle.'",';
            $first .= '"Filename":                      "'.$PlaylistAudioFilename.'"';
            $first .= '},';
        }
        if ($result_PlaylistAudio->num_rows > 0) {
            $first = rtrim($first, ',');
            $first .= '},';
        }
    }

    $n=0;
//    $PlaylistVideo=$row_main['PlaylistVideo'];			// boolean      `PlaylistVideoTitle`, `PlaylistVideoFilename`
    if ($PlaylistVideo) {
        if ($result_PlaylistVideo->num_rows > 0) {
            $first .= '"PlaylistVideo": {';
            $first .= '"path":          "/data/'.$iso.'/video",';
        }
        while ($r2 = $result_PlaylistVideo->fetch_array(MYSQLI_ASSOC)) {
            $PlaylistVideoTitle=trim($r2['PlaylistVideoTitle']);
            $PlaylistVideoFilename=trim($r2['PlaylistVideoFilename']);
            $first .= '"'.$n++.'":	{';
            $first .= '"PlaylistVideoTitle":                  "'.$PlaylistVideoTitle.'",';
            $first .= '"PlaylistVideoFilename":               "'.$PlaylistVideoFilename.'"';
            $first .= '},';
        }
        if ($result_PlaylistVideo->num_rows > 0) {
            $first = rtrim($first, ',');
            $first .= '},';
        }
    }

    $n=0;
//    $other_titles = $row_main['other_titles'];						// boolean      other, other_title (downloadable)
    if ($other_titles) {
        if ($result_other_titles->num_rows > 0) {
            $first .= '"other_titles": {';
            $first .= '"path":          			"data/'.$iso.'/'.($PDF!=''?'PDF':'audio').'",';
        }
        while ($r2 = $result_other_titles->fetch_array(MYSQLI_ASSOC)) {
            $other=trim($r2['other']);
            $other_title=trim($r2['other_title']);
            $other_PDF=trim($r2['other_PDF']);
            $other_audio=trim($r2['other_audio']);
            $first .= '"'.$n++.'":	{';
            $first .= '"other":                                 "'.$other.'",';
            $first .= '"other_title":                           "'.$other_title.'",';
            if ($PDF != '') {
                $first .= '"PDF/ePub":					        "'.$PDF.'"';
            }
            else {
                $first .= '"audio":					            "'.$audio.'"';
            }
            $first .= '},';
        }
        if ($result_other_titles->num_rows > 0) {
            $first = rtrim($first, ',');
            $first .= '},';
        }
    }

    $n=0;
//    $study=$row_main['study'];							// boolean      Testament, alphabet, ScriptureURL, othersiteURL
    if ($study) {
        if ($result_study->num_rows > 0) {
            $first .= '"study": {';
            $first .= '"path":          "/data/'.$iso.'/study",';
        }
        if ($r2 = $result_study->fetch_array(MYSQLI_ASSOC)) {
            $Testament=trim($r2['Testament']);
            $alphabet=trim($r2['alphabet']);
            $ScriptureURL=trim($r2['ScriptureURL']);
            $othersiteURL=trim($r2['othersiteURL']);
            $first .= '"'.$n++.'":	{';
            $first .= '"WhichTestament":                        "'.$Testament.'",';
            $first .= '"Alphabet":                              "'.$alphabet.'",';
            $first .= '"TheWordAddOn":                          "'.$ScriptureURL.'",';
            $first .= '"TheWord":                               "'.$othersiteURL.'"';
            $first .= '},';
        }
        if ($result_study->num_rows > 0) {
            $first = rtrim($first, ',');
            $first .= '},';
        }
    }
    $n=0;

    if ($m < $main_rows) {
        $first = rtrim($first, ',');
        $first .= '}},';
    }
}
    
$first = rtrim($first, ',');
$first .= '}}}';

//echo $first;
//exit;

$marks = json_decode($first, true, 4096, JSON_INVALID_UTF8_IGNORE);

//foreach ($marks as $mark) {
//    echo $mark . '<br />';
//}
//var_dump($marks);
//exit;

header('Content-Type: application/json');														// instead of <pre></pre>
// An associative array
$json_string = json_encode($marks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
//echo '<pre>'.$json_string.'</pre>';
echo $json_string;

?>