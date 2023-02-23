<?php

$index = 0;
$first = '';
$marks = [];
$json_string = '';

require_once '../include/conn.inc.php';															// connect to the database named 'scripture'
$db = get_my_db();

include 'include/v.key.php';																	// get v and key

include 'include/idx.iso.php';																	// get idx or iso

if ($index == 0) {
	die ('HACK!');
}

if ($index == 1) {
    $stmt_main = $db->prepare("SELECT * FROM `scripture_main` WHERE ISO_ROD_index = ?");
    $stmt_main->bind_param('i', $idx);															// bind parameters for markers
}
else {
	if ($rod == 'ALL' && $var == 'ALL') {
		$stmt_main = $db->prepare("SELECT * FROM `scripture_main` WHERE `ISO` = ? ORDER BY `ROD_Code`, `Variant_Code`");
		$stmt_main->bind_param('s', $iso);														// bind parameters for markers
	}
	elseif ($rod == 'ALL') {
		$stmt_main = $db->prepare("SELECT * FROM `scripture_main` WHERE `ISO` = ? AND `Variant_Code` = ? ORDER BY `ROD_Code`, `Variant_Code`");
		$stmt_main->bind_param('ss', $iso, $var);												// bind parameters for markers
	}
	elseif ($var == 'ALL') {
			$stmt_main = $db->prepare("SELECT * FROM `scripture_main` WHERE `ISO` = ? AND `ROD_Code` = ? ORDER BY `ROD_Code`, `Variant_Code`");
			$stmt_main->bind_param('ss', $iso, $rod);											// bind parameters for markers
	}
	else {
		$stmt_main = $db->prepare("SELECT * FROM `scripture_main` WHERE `ISO` = ? AND `ROD_Code` = ? AND `Variant_Code` = ? ORDER BY `ROD_Code`, `Variant_Code`");
		$stmt_main->bind_param('sss', $iso, $rod, $var);										// bind parameters for markers
	}
}

$stmt_main->execute();															        		// execute query
$result_main = $stmt_main->get_result();

/*
texts:
    NT_PDF_Media:
        0:		“[first NT SE text]”
        1:		“[second NT SE text]”
        2:		“[… NT SE text]”
    OT_PDF_Media:
        0:		“[first OT SE text]”
        1:		“[second OT SE text]”
        2:		“[… OT SE text]”
    Scripture_and_or_Bible
    others:
        other_titles (other_PDF - PDF)
        other_titles (other_PDF - epub)
audio:
    NT_PDF_Audio:
        0:		“[first NT SE audio]”
        1:		“[second NT SE audio]”
        2:		“[… NT SE audio]”
    OT_PDF_Audio:
        other_titles (other_audio)
        0:		“[first OT SE audio]”
        1:		“[second OT SE audio]”
        2:		“[… OT SE audio]”
videos:
    other_titles (download_video = mp4)
    subfolder video ?
audio_playlist:
    0:  PlaylistAudio (txt)
    1:  PlaylistAudio (txt)
    2:  PlaylistAudio (txt)
video_playlist:
    0:  PlaylistVideo (txt)
    1:  PlaylistVideo (txt)
    2:  PlaylistVideo (txt)
study (theWord.gr)
viewer

NT_PDF_Media:	NT_PDF [NT or number],	NT_PDF_Filename 	
OT_PDF_Media:	OT_PDF [OT or number],	OT_PDF_Filename 	
Scripture_and_or_Bible: Item [B or S],	Scripture_Bible_Filename
NT_Audio_Media: NT_Audio_Book [number],	NT_Audio_Filename,	NT_Audio_Chapter [number]
OT_Audio_Media: OT_Audio_Book [number],	OT_Audio_Filename,	OT_Audio_Chapter [number]
other_titles:   other,	other_title,	other_PDF,	other_audio,	download_video
PlaylistAudio:  PlaylistAudioTitle,	PlaylistAudioFilename
PlaylistVideo:  PlaylistVideoTitle,	PlaylistVideoFilename,	PlaylistVideoDownload [0 or 1]
study:          ScriptureDescription,	Testament,	alphabet,	ScriptureURL [always],	statement,	othersiteDescription,	othersiteURL,	DownloadFromWebsite
viewer: viewer_ROD_Variant,	rtl [0 or 1]
*/

function cmp($a, $b) {
    //echo 'a= ' . $a . '; b= ' . $b . '<br />';
    preg_match('/[^- _]([A-Za-z]+)[0-9]/', $a, $match);
    $book_a = $match[1];
    preg_match('/[^- _]([A-Za-z]+)[0-9]/', $b, $match);
    $book_b = $match[1];

    $chapter_a = '';
    $test = preg_match('/[- _][A-Za-z]+([0-9_\.-]+?)(-[A-Za-z]|-640.mp4$|.mp4$)/', $a, $match);
    if ($test) {
        $chapter_a =  $match[1];
    }
    else {
        $test = preg_match('/[- _][A-Za-z]+([0-9_]+[a-c]?-[0-9_]+[a-c]?)(-[A-Za-z]|-640.mp4$|.mp4$)/', $a, $match);
        $chapter_a = $match[1];
    }

    $chapter_b = '';
    $test = preg_match('/[- _][A-Za-z]+([0-9_\.-]+?)(-[A-Za-z]|-640.mp4$|.mp4$)/', $b, $match);
    if ($test) {
        $chapter_b =  $match[1];
    }
    else {
        $test = preg_match('/[- _][A-Za-z]+([0-9_]+[a-c]?-[0-9_]+[a-c]?)(-[A-Za-z]|-640.mp4$|.mp4$)/', $b, $match);
        $chapter_b = $match[1];
    }

    return (($book_a . $chapter_a) < ($book_b . $chapter_b)) ? -1 : 1;
}

$stmt_NT_PDF = $db->prepare("SELECT NT_PDF, NT_PDF_Filename FROM NT_PDF_Media WHERE ISO_ROD_index = ? ORDER BY LENGTH(NT_PDF), NT_PDF");    // natural sort ORDER BY
$stmt_OT_PDF = $db->prepare("SELECT OT_PDF, OT_PDF_Filename FROM OT_PDF_Media WHERE ISO_ROD_index = ? ORDER BY LENGTH(OT_PDF), OT_PDF");    // natural sort ORDER BY
$stmt_SB = $db->prepare("SELECT Item, Scripture_Bible_Filename FROM Scripture_and_or_Bible WHERE ISO_ROD_index = ?");
$stmt_NT_Audio = $db->prepare("SELECT NT_Audio_Book, NT_Audio_Filename, NT_Audio_Chapter FROM NT_Audio_Media WHERE ISO_ROD_index = ? ORDER BY LENGTH(NT_Audio_Book), NT_Audio_Book, LENGTH(NT_Audio_Chapter), NT_Audio_Chapter");    // natural sort ORDER BY
$stmt_OT_Audio = $db->prepare("SELECT OT_Audio_Book, OT_Audio_Filename, OT_Audio_Chapter FROM OT_Audio_Media WHERE ISO_ROD_index = ? ORDER BY LENGTH(OT_Audio_Book), OT_Audio_Book, LENGTH(OT_Audio_Chapter), OT_Audio_Chapter");    // natural sort ORDER BY
$stmt_Other_PDF = $db->prepare("SELECT other, other_title, other_PDF FROM other_titles WHERE ISO_ROD_index = ? AND (other_PDF != '' AND other_PDF IS NOT NULL) ORDER BY other, other_title");
$stmt_Other_Audio = $db->prepare("SELECT other, other_title, other_audio FROM other_titles WHERE ISO_ROD_index = ? AND (other_audio != '' AND other_audio IS NOT NULL) ORDER BY other, other_title");
$stmt_Other_Video = $db->prepare("SELECT other, other_title, download_video FROM other_titles WHERE ISO_ROD_index = ? AND (download_video != '' AND download_video IS NOT NULL) ORDER BY other, other_title");
$stmt_PAudio = $db->prepare("SELECT PlaylistAudioTitle, PlaylistAudioFilename FROM PlaylistAudio WHERE ISO_ROD_index = ? ORDER BY PlaylistAudioTitle");
$stmt_PVideo = $db->prepare("SELECT PlaylistVideoTitle, PlaylistVideoFilename, PlaylistVideoDownload FROM PlaylistVideo WHERE ISO_ROD_index = ? ORDER BY PlaylistVideoTitle");
$stmt_Study = $db->prepare("SELECT ScriptureDescription, Testament, alphabet, ScriptureURL, `statement`, othersiteDescription, othersiteURL, DownloadFromWebsite FROM study WHERE ISO_ROD_index = ?");
$stmt_Viewer = $db->prepare("SELECT viewer_ROD_Variant,	rtl FROM viewer WHERE ISO_ROD_index = ?");
$stmt_var = $db->prepare("SELECT Variant_Eng FROM Variants WHERE Variant_Code = ?");

$m=0;

$first = '{';
$main_rows = $result_main->num_rows;                                                    // number of rows for PDF OT
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

    $stmt_NT_PDF->bind_param('i', $idx);													    // bind parameters for markers
    $stmt_NT_PDF->execute();																    // execute query
    $result_NT_PDF = $stmt_NT_PDF->get_result();
    $stmt_OT_PDF->bind_param('i', $idx);													    // bind parameters for markers
    $stmt_OT_PDF->execute();																    // execute query
    $result_OT_PDF = $stmt_OT_PDF->get_result();
    $stmt_SB->bind_param('i', $idx);													        // bind parameters for markers
    $stmt_SB->execute();																        // execute query
    $result_SB = $stmt_SB->get_result();
    $stmt_NT_Audio->bind_param('i', $idx);													    // bind parameters for markers
    $stmt_NT_Audio->execute();																    // execute query
    $result_NT_Audio = $stmt_NT_Audio->get_result();
    $stmt_OT_Audio->bind_param('i', $idx);													    // bind parameters for markers
    $stmt_OT_Audio->execute();																    // execute query
    $result_OT_Audio = $stmt_OT_Audio->get_result();
    $stmt_Other_PDF->bind_param('i', $idx);													    // bind parameters for markers
    $stmt_Other_PDF->execute();																    // execute query
    $result_Other_PDF = $stmt_Other_PDF->get_result();
    $stmt_Other_Audio->bind_param('i', $idx);													// bind parameters for markers
    $stmt_Other_Audio->execute();																// execute query
    $result_Other_Audio = $stmt_Other_Audio->get_result();
    $stmt_Other_Video->bind_param('i', $idx);													// bind parameters for markers
    $stmt_Other_Video->execute();																// execute query
    $result_Other_Video = $stmt_Other_Video->get_result();
    $stmt_PAudio->bind_param('i', $idx);													    // bind parameters for markers
    $stmt_PAudio->execute();																    // execute query
    $result_PAudio = $stmt_PAudio->get_result();
    $stmt_PVideo->bind_param('i', $idx);													    // bind parameters for markers
    $stmt_PVideo->execute();																    // execute query
    $result_PVideo = $stmt_PVideo->get_result();
    $stmt_Study->bind_param('i', $idx);													        // bind parameters for markers
    $stmt_Study->execute();																        // execute query
    $result_Study = $stmt_Study->get_result();
    $stmt_Viewer->bind_param('i', $idx);													    // bind parameters for markers
    $stmt_Viewer->execute();																    // execute query
    $result_Viewer = $stmt_Viewer->get_result();

    $m++;																					    // id
    $first .= '"'.($m-1).'": ';
    $first .= '{"type":                     "ScriptureEarth.org Media",';
    $first .= '"id":                        "'.$m.'",';
    $first .= '"attributes": {';
    $first .= '"iso":                       "'.$iso.'",';
    $first .= '"rod":				        "'.$rod.'",';
    $first .= '"var_code":		    	    "'.$var.'",';
    $first .= '"var_name":					"'.$Variant_name.'",';
    $first .= '"iso_query_string":	        "iso='.$iso;
    if ($rod != '00000') {
        $first .= '&rod='.$rod;
    }
    if ($var != '') {
        $first .= '&var='.$var;
    }
    $first .= '",';
    $first .= '"idx":		                '.$idx.',';
    $first .= '"idx_query_string":          "idx='.$idx.'"';	
    $first .= '},';
    $first .= '"relationships": {';

    $first .= '"texts": {';

    $n=0;																					    // count
    $OT_PDF_rows = $result_OT_PDF->num_rows;                                                    // number of rows for PDF OT
    while ($row_OT_PDF = $result_OT_PDF->fetch_assoc()) {
        $OT_PDF = $row_OT_PDF['OT_PDF'];
        $OT_PDF_Filename = $row_OT_PDF['OT_PDF_Filename'];
        // 'ot_pdf_media'
        if ($n == 0) {                                                                          // ot_pdf_media: preceeding the first row
            $first .= '"ot_pdf_media": {';
        }
        $test_replace = preg_replace('/^[a-z0-9-]+-([1-3]?[A-Z]{2,3}).*/', '$1', $OT_PDF_Filename);     // e.g. 01-GENngu-web.pdf"
        $first .= '"'.$test_replace.'": {';
        $first .= '"book_number":						"'.$OT_PDF.'",';
        $first .= '"book_filename":						"data/'.$iso.'/PDF/'.$OT_PDF_Filename.'"';
        $n++;
        if ($OT_PDF_rows == $n) {                                                               // if it is the last row
            $first .= '}},';
            break;
        }
        $first .= '},';
    }
    $n=0;

    $NT_PDF_rows = $result_NT_PDF->num_rows;
    while ($row_NT_PDF = $result_NT_PDF->fetch_assoc()) {
        $NT_PDF = $row_NT_PDF['NT_PDF'];
        $NT_PDF_Filename = $row_NT_PDF['NT_PDF_Filename'];
        // 'nt_pdf_media'
        if ($n == 0) {
            $first .= '"nt_pdf_media": {';
        }
        $test_replace = preg_replace('/^[a-z0-9-]+-([1-3]?[A-Z]{2,3}).*/', '$1', $NT_PDF_Filename);
        $first .= '"'.$test_replace.'": {';
        $first .= '"book_number":						"'.$NT_PDF.'",';
        $first .= '"book_filename":						"data/'.$iso.'/PDF/'.$NT_PDF_Filename.'"';
        $n++;
        if ($NT_PDF_rows == $n) {
            $first .= '}},';
            break;
        }
        $first .= '},';
    }
    $n=0;

    // other, other_title, other_PDF
    $Other_PDF_rows = $result_Other_PDF->num_rows;
    while ($row_Other_PDF = $result_Other_PDF->fetch_assoc()) {
        $other = $row_Other_PDF['other'];
        $other_title = $row_Other_PDF['other_title'];
        $other_PDF = $row_Other_PDF['other_PDF'];
        // other
        if ($n == 0) {
            $first .= '"other_pdf_media": {';
        }
        $first .= '"'.$n.'": {';
        $first .= '"other":						        "'.$other.'",';
        $first .= '"other_title":						"'.$other_title.'",';
        $first .= '"other_pdf":						    "data/'.$iso.'/PDF/'.$other_PDF.'"';
        $n++;
        if ($Other_PDF_rows == $n) {
            $first .= '}},';
            break;
        }
        $first .= '},';
    }
    $n=0;

    $SB_rows = $result_SB->num_rows;
    if ($row_SB = $result_SB->fetch_assoc()) {
        $Item = $row_SB['Item'];
        $Scripture_Bible_Filename = $row_SB['Scripture_Bible_Filename'];
        $first .= '"scripture_bible": {';
        $first .= '"item":						        "'.$Item.'",';
        $first .= '"scripture_bible_filename":			"data/'.$iso.'/PDF/'.$Scripture_Bible_Filename.'"},';
    }

    $first = rtrim($first, ',');                                                                // delete ',' from $first
    $first .= '},';                                                                             // add '},' to end of $first

    $first .= '"audio": {';

    $OT_Audio_rows = $result_OT_Audio->num_rows;
    $temp = '';
    $z = 1;                                                                                     // record count
    while ($row_OT_Audio = $result_OT_Audio->fetch_assoc()) {
        $OT_Audio_Book = $row_OT_Audio['OT_Audio_Book'];
        $OT_Audio_Chapter = $row_OT_Audio['OT_Audio_Chapter'];
        $OT_Audio_Filename = $row_OT_Audio['OT_Audio_Filename'];
        // 'OT_Audio_media'
        if ($temp == '') {
            $first .= '"ot_audio_media": {';
        }
        $test_replace = preg_replace('/^[a-z0-9-]+-([1-3]?[A-Z]{2,3}).*/', '$1', $OT_Audio_Filename);
        if ($test_replace != $temp) {
            if ($n != 0) {
                $n = 0;
                $first = rtrim($first, ',');
                $first .= '},';
            }
            $first .= '"'.$test_replace.'": {';
            //$temp = $test_replace;
        }
        $first .= '"'.$n.'": {';
        $first .= '"book_number":						"'.$OT_Audio_Book.'",';
        $first .= '"book_chapter":						"'.$OT_Audio_Chapter.'",';
        $first .= '"book_filename":						"data/'.$iso.'/audio/'.$OT_Audio_Filename.'"';
        $n++;
        if ($OT_Audio_rows == $z) {
            $first .= '}}},';
            break;
        }
        $z++;                                                                                   // add 1 to record count
        if ($test_replace != $temp) {
            $temp = $test_replace;
        }
        $first .= '},';
    }
    $n=0;

    $NT_Audio_rows = $result_NT_Audio->num_rows;
    $temp = '';
    $z = 1;
    while ($row_NT_Audio = $result_NT_Audio->fetch_assoc()) {
        $NT_Audio_Book = $row_NT_Audio['NT_Audio_Book'];
        $NT_Audio_Chapter = $row_NT_Audio['NT_Audio_Chapter'];
        $NT_Audio_Filename = $row_NT_Audio['NT_Audio_Filename'];
        // 'NT_Audio_media'
        if ($temp == '') {
            $first .= '"nt_audio_media": {';
        }
        $test_replace = preg_replace('/^[a-z0-9-]+-([1-3]?[A-Z]{2,3}).*/', '$1', $NT_Audio_Filename);
        if ($test_replace != $temp) {
            if ($n != 0) {
                $n = 0;
                $first = rtrim($first, ',');
                $first .= '},';
            }
            $first .= '"'.$test_replace.'": {';
            //$temp = $test_replace;
        }
        $first .= '"'.$n.'": {';
        $first .= '"book_number":						"'.$NT_Audio_Book.'",';
        $first .= '"book_chapter":						"'.$NT_Audio_Chapter.'",';
        $first .= '"book_filename":						"data/'.$iso.'/audio/'.$NT_Audio_Filename.'"';
        $n++;
        if ($NT_Audio_rows == $z) {
            $first .= '}}},';
            break;
        }
        $z++;
        if ($test_replace != $temp) {
            $temp = $test_replace;
        }
        $first .= '},';
    }
    $n=0;

    // $result_Other_Audio
    // other, other_title, other_audio
    $Other_audio_rows = $result_Other_Audio->num_rows;
    while ($row_Other_Audio = $result_Other_Audio->fetch_assoc()) {
        $other = $row_Other_Audio['other'];
        $other_title = $row_Other_Audio['other_title'];
        $other_audio = $row_Other_Audio['other_audio'];
        // other
        if ($n == 0) {
            $first .= '"other_audio_media": {';
        }
        $first .= '"'.$n.'": {';
        $first .= '"other":						        "'.$other.'",';
        $first .= '"other_title":						"'.$other_title.'",';
        $first .= '"other_audio":						"data/'.$iso.'/audio/'.$other_audio.'"';
        $n++;
        if ($Other_audio_rows == $n) {
            $first .= '}},';
            break;
        }
        $first .= '},';
    }
    $n=0;

    $first = rtrim($first, ',');
    $first .= '},';

    $first .= '"videos": {';

    // $result_Other_Video
    // other, other_title, download_video
    $Other_video_rows = $result_Other_Video->num_rows;
    while ($row_Other_Video = $result_Other_Video->fetch_assoc()) {
        $other = $row_Other_Video['other'];
        $other_title = $row_Other_Video['other_title'];
        $other_video = $row_Other_Video['download_video'];
        // other
        if ($n == 0) {
            $first .= '"other_video_media": {';
        }
        $first .= '"'.$n.'": {';
        $first .= '"other":						        "'.$other.'",';
        $first .= '"other_title":						"'.$other_title.'",';
        $first .= '"other_video":						"data/'.$iso.'/video/'.$other_video.'"';
        $n++;
        if ($Other_video_rows == $n) {
            $first .= '}},';
            break;
        }
        $first .= '},';
    }
    $n=0;

    // .mp4 ?
    $mp4_filenames_array = glob('../data/'.$iso.'/video/*.mp4');

    if (!empty($mp4_filenames_array)) {                                                         // if $mp4_filenames_array is not empty
        usort($mp4_filenames_array, 'cmp');                                                     // function 'cmp' is above

        foreach ($mp4_filenames_array as $mp4_filename) {
            // *.mp4
            if ($n == 0) {
                $first .= '"mp4": {';
            }
            $first .= '"'.$n.'": {';
            $first .= '"video":						        "'.substr($mp4_filename, 3).'"';
            $n++;
            if (count($mp4_filenames_array) == $n) {
                $first .= '}},';
                break;
            }
            $first .= '},';
        }
        $n=0;
    } 

    $first = rtrim($first, ',');
    $first .= '},';

    // $result_PAudio
    // PlaylistAudio:  PlaylistAudioTitle,	PlaylistAudioFilename
    $PAudio_rows = $result_PAudio->num_rows;
    while ($row_PAudio = $result_PAudio->fetch_assoc()) {
        $PlaylistAudioTitle = $row_PAudio['PlaylistAudioTitle'];
        $PlaylistAudioFilename = $row_PAudio['PlaylistAudioFilename'];
        // PlaylistAudio
        if ($n == 0) {
            $first .= '"playlist_audio": {';
        }
        $first .= '"'.$n.'": {';
        $first .= '"playlist_audio_title":				"'.$PlaylistAudioTitle.'",';
        $first .= '"playlist_audio_filename":			"data/'.$iso.'/video/'.$PlaylistAudioFilename.'"';
        $n++;
        if ($PAudio_rows == $n) {
            $first .= '}},';
            break;
        }
        $first .= '},';
    }
    $n=0;

    // $result_PVideo
    // PlaylistVideo:  PlaylistVideoTitle,	PlaylistVideoFilename,	PlaylistVideoDownload [0 or 1]
    $PVideo_rows = $result_PVideo->num_rows;
    while ($row_PVideo = $result_PVideo->fetch_assoc()) {
        $PlaylistVideoTitle = $row_PVideo['PlaylistVideoTitle'];
        $PlaylistVideoFilename = $row_PVideo['PlaylistVideoFilename'];
        $PlaylistVideoDownload = $row_PVideo['PlaylistVideoDownload'];
        // PlaylistVideo
        if ($n == 0) {
            $first .= '"playlist_video": {';
        }
        $first .= '"'.$n.'": {';
        $first .= '"playlist_video_title":				"'.$PlaylistVideoTitle.'",';
        $first .= '"playlist_video_filename":			"data/'.$iso.'/video/'.$PlaylistVideoFilename.'",';
        $first .= '"PlaylistVideoDownload":				"'.($PlaylistVideoDownload==1 ? 'download' : 'no download').'"';
        $n++;
        if ($PVideo_rows == $n) {
            $first .= '}},';
            break;
        }
        $first .= '},';
    }
    $n=0;

    // $result_Study - theWord website
    // study:          ScriptureDescription,	Testament,	alphabet,	ScriptureURL [always],	statement,	othersiteDescription,	othersiteURL,	DownloadFromWebsite
    $Study_rows = $result_Study->num_rows;
    while ($row_Study = $result_Study->fetch_assoc()) {
        $ScriptureDescription = $row_Study['ScriptureDescription'];
        $ScriptureURL = $row_Study['ScriptureURL'];
        $othersiteURL = $row_Study['othersiteURL'];
        // study
        if ($n == 0) {
            $first .= '"study": {';
        }
        $first .= '"'.$n.'": {';
        $first .= '"the_word":				            "'.$ScriptureDescription.'",';
        $first .= '"operating_system":				    "Windows",';
        $first .= '"filename":				            "'.$ScriptureURL.'",';
        $first .= '"url":			                    "'.$othersiteURL.'"';
        $n++;
        if ($Study_rows == $n) {
            $first .= '}},';
            break;
        }
        $first .= '},';
    }
    $n=0;

    // $result_Viewer
    // viewer: viewer_ROD_Variant,	rtl [0 or 1]
    $viewer = $row_main['viewer'];                                                      // 0 or 1
    if ($viewer) {
        $viewer_ROD_Variant='';
        $rtl = 0;
        $Viewer_rows = $result_Viewer->num_rows;
        if ($row_Viewer = $result_Viewer->fetch_assoc()) {
            $viewer_ROD_Variant = $row_Viewer['viewer_ROD_Variant'];
            $rtl = $row_Viewer['rtl'];
        }
        // viewer
        $first .= '"viewer": {';
        $first .= '"link":				                "viewer/views.php?iso='.$iso.'&ROD_Code='.$rod.'&Variant_Code='.$var.'&ROD_Var='.$viewer_ROD_Variant.'&rtl='.$rtl.'&st=eng"';
        $first .= '},';
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
