<?php
// The html tags must not above and below this php section because the server displays the document and not saves the document!

// Created by Scott Starker

// 	ini_set('memory_limit', '1024M');	about line 300							// memory_limit - 1GB !

// This PHP script must have the following:
// 00-PlaylistDownloadVideoZip.php?st="+st+"&iso="+iso+"&PlaylistVideoFilename="+PlaylistVideoFilename+"&checkBoxes="+CB

include ('./translate/functions.php');

$st = 'eng';
if (isset($_GET['st'])) {
	$st = $_GET['st'];
	if (!preg_match('/^([a-z]{3})$/', $st)) {
		die('‘st’ is empty.</body></html>');
	}
}

if (isset($_GET['iso'])) {
	$iso = $_GET['iso'];
	if (!preg_match('/^([a-z]{3})$/', $iso)) {
		die('‘ISO’ ' . translate('is empty', $st, 'sys') . '.</body></html>');
	}
}
else {
	die('No ISO was found.</body></html>');
}

$dirname = './data/'.$iso.'/video/';
$dir = opendir($dirname) or die(translate('There is no video folder under', $st, 'sys')." ‘$iso’.</body></html>");
	
if (isset($_GET['checkBoxes'])) {
	$CB = $_GET['checkBoxes'];
	if (!preg_match('/^([0-9|]*)$/', $CB)) {
		die('‘checkBoxes’ ' . translate('is empty', $st, 'sys') . '.</body></html>');
	}
}
else
	die('No checkBoxes were found.');

if (isset($_GET['PlaylistVideoFilename'])) {
	$PlaylistVideoFilename = $_GET['PlaylistVideoFilename'];
	if (!preg_match('/^([a-zA-Z0-9._-]*)$/', $PlaylistVideoFilename) || !file_exists('data/'.$iso.'/video/'.$PlaylistVideoFilename)) {
		die('‘PlaylistVideoFilename’ ' . translate('is empty', $st, 'sys') . '.</body></html>');
	}
}
else
	die('No PlaylistVideoFilename was found.</body></html>');

/*********************************************************************************************************
    insert the new zip file
 *********************************************************************************************************/
$SE_LogPath = "log/";
$CRLF = "\r\n";
// $_SERVER['REMOTE_ADDR'] is the IP address from which the user is viewing the current page. 
if ($_SERVER['REMOTE_ADDR'] != '127.0.0.1' && $_SERVER['REMOTE_ADDR'] != '::1') {
	$SE_LogPath = "log/";
	$CRLF = "\n";
}
// 187.148.228.80 - - [03/Oct/2014:11:23:20 -0600] User has [number of OT/NT audio books] OT/NT audio books. "GET /data/ngu/PDF/47-1COngu-web.pdf HTTP/1.1" 206 33125 "http://www.scriptureearth.org/data/ngu/PDF/47-1COngu-web.pdf"
$data = $_SERVER['REMOTE_ADDR'] . ' - - [' . date("d/M/Y:h:i:s") . ' -0500] User has 1 txt video filename. "GET data/' . $iso . '/video/' . $PlaylistVideoFilename . ' HTTP/1.1" 206 1024 "https://www.scriptureearth.org/data/' . $iso . '/video/' . $PlaylistVideoFilename . '" "Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.143 Safari/537.36"' . $CRLF;
// write $data to $SE_LogPath . "zip-access.log"
file_put_contents($SE_LogPath . "zip-access.log", $data, FILE_USE_INCLUDE_PATH | FILE_APPEND | LOCK_EX); 

/*********************************************************************************************************
    get all of the MP4 filenames in the txt file that have the CB numbers
 *********************************************************************************************************/
$files = [];
$MP4_indexes = [];
$MP4_indexes = explode('|', $CB);

$VideoFilenameContents = file_get_contents($dirname.$PlaylistVideoFilename);						// returns a string of the contents of the file
$VideoConvertContents = explode("\n", $VideoFilenameContents);										// create array separate by new line
$VideoConvertWithTab = [];
$filenames = [];

foreach($MP4_indexes as $MP4_index) {
	$VideoConvertWithTab = explode("\t", $VideoConvertContents[(int)$MP4_index+2]);					// split (explode) based on '\t'
	$filenames[] = trim($VideoConvertWithTab[3]);													// just in case a trialing space, \r, or \n is present
}

if ($filenames[0] == null) {
	die(translate('Error! files[0] is null!', $st, 'sys').'</body></html>');
}

/*********************************************************************************************************
    Stream the ZIP straight to the browser. Nothing is written to disk, so there
    are no temporary files to copy in or clean up afterwards. Each MP4 (and its
    matching .srt, when present) is read directly from ./data/<iso>/video/ and
    deflate-compressed as it is sent.
 *********************************************************************************************************/
require_once('./include/ZipStreamer.php');

// creating the download filename offered to the browser
$Zip_Filename = str_replace(' ', '', microtime());
$Zip_Filename = str_replace('.', '', $Zip_Filename);
$Zip_Filename = 'Video_Playlist_Download_'.$iso.'_'.$Zip_Filename.'.zip';

set_time_limit(0);											// no time limit for big archives

$zip = new ZipStreamer($Zip_Filename, false);				// false = store (no compression); video is already compressed
$zip->setComment(translate('Downloaded from ScriptureEarth.org.', $st, 'sys'));
foreach ($filenames as $file) {
	$temp = basename($file);
	$zip->addFile($dirname . $temp, $temp);				// read directly from ./data/<iso>/video/
	// include the matching .srt subtitle file when it exists (addFile skips it otherwise)
	$temp_NotExtension = preg_replace("/(.*)\..*$/", "$1", $temp);
	$zip->addFile($dirname . $temp_NotExtension . '.srt', $temp_NotExtension . '.srt');
}
$zip->finish();

// Completed: 187.148.228.80 - - [03/Oct/2014:11:23:20 -0600] "GET /data/ngu/PDF/47-1COngu-web.pdf HTTP/1.1" 206 33125 "http://www.scriptureearth.org/data/ngu/PDF/47-1COngu-web.pdf"
$data = 'Completed: ' . $_SERVER['REMOTE_ADDR'] . ' - - [' . date("d/M/Y:h:i:s") . ' -0500] "GET data/' . $iso . '/video/' . $PlaylistVideoFilename . ' HTTP/1.1" 200 1024 "https://www.scriptureearth.org/data/' . $iso . '/video/' . $PlaylistVideoFilename . '" "Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.143 Safari/537.36"' . $CRLF;
file_put_contents($SE_LogPath . "zip-access.log", $data, FILE_USE_INCLUDE_PATH | FILE_APPEND | LOCK_EX);
?>
