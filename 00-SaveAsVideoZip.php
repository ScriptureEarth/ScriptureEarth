<?php
// The html tags must not above and below this php section because the server displays the document and not saves the document!

// Usage: 00-SaveAsVideoZip.php"+"?st="+st+"&iso="+iso+"&saveAsVideo="+saveAsVideo

include ('./translate/functions.php');

$st = 'eng';
if (isset($_GET['st'])) {
	$st = $_GET['st'];
	$st = preg_replace('/^([a-z]{3})/', '$1', $st);
	if ($st == NULL) {
		die('‘st’ is empty.</body></html>');
	}
}

if (isset($_GET['iso'])) {
	$iso = $_GET['iso'];
	$iso = preg_replace('/^([a-z]{3})/', '$1', $iso);
	if ($iso == NULL) {
		die('‘ISO’ ' . translate('is empty', $st, 'sys') . '.</body></html>');
	}
}
else
	die(translate('No ISO was found.', $st, 'sys'));

if (isset($_GET['saveAsVideo'])) {
	$saveAsVideo = $_GET['saveAsVideo'];
	//$iso = preg_replace('/^([a-z]{3})/', '$1', $iso);
	if ($saveAsVideo == NULL) {
		die('‘saveAsVideo’ ' . translate('is empty', $st, 'sys') . '.</body></html>');
	}
}
else
	die(translate('No saveAsVideo was found.', $st, 'sys'));

$dirname = './data/'.$iso.'/video/';

// insert the new zip file here = $file

$SE_LogPath = "";
$CRLF = "\r\n";
// $_SERVER['REMOTE_ADDR'] is the IP address from which the user is viewing the current page. 
if ($_SERVER['REMOTE_ADDR'] != '127.0.0.1' && $_SERVER['REMOTE_ADDR'] != '::1') {
	$SE_LogPath = "log/";
	$CRLF = "\n";
}
// 187.148.228.80 - - [03/Oct/2014:11:23:20 -0600] User has only 1 in the animation video. "GET /data/ngu/video/zipped.zip HTTP/1.1" 206 33125 "http://www.scriptureearth.org/data/ngu/video/zipped.zip"
$data = $_SERVER['REMOTE_ADDR'] . ' - - [' . date("d/M/Y:h:i:s") . ' -0500] User has only 1 mp4 file in the animation video. "GET data/' . $iso . '/video/zipped.zip HTTP/1.1" 206 1024 "data/' . $iso . '/video/zipped.zip" "Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.143 Safari/537.36"' . $CRLF;
// write $data to $SE_LogPath . "zip-access.log"
file_put_contents($SE_LogPath . "zip-access.log", $data, FILE_USE_INCLUDE_PATH | FILE_APPEND | LOCK_EX); 
	
$dir = opendir($dirname) or die("There is no video folder under ‘$iso’.</body></html>");
  
if (file_exists($saveAsVideo)) {
	$file = $saveAsVideo;
}
else {
	die('Error! ‘saveAsVideo’ is not found!</body></html>');
}

/*********************************************************************************************************
    Stream the ZIP straight to the browser. Nothing is written to disk, so there
    is no temporary file to clean up afterwards. The source video is read
    directly and deflate-compressed as it is sent.
 *********************************************************************************************************/
require_once('./include/ZipStreamer.php');

// Download filename offered to the browser.
$Zip_Filename = str_replace(' ', '', microtime());
$Zip_Filename = str_replace('.', '', $Zip_Filename);
$Zip_Filename = $iso.'_Video_'.$Zip_Filename.'.zip';

set_time_limit(0);									// no time limit for big archives

$zip = new ZipStreamer($Zip_Filename, false);				// false = store (no compression); video is already compressed
$zip->setComment(translate('Downloaded from ScriptureEarth.org.', $st, 'sys'));
$zip->addFile($file, basename($file));				// $file = validated $saveAsVideo
$zip->finish();

// Completed: 187.148.228.80 - - [03/Oct/2014:11:23:20 -0600] "GET /data/ngu/PDF/47-1COngu-web.pdf HTTP/1.1" 206 33125 "http://www.scriptureearth.org/data/ngu/PDF/47-1COngu-web.pdf"
$data = 'Completed: ' . $_SERVER['REMOTE_ADDR'] . ' - - [' . date("d/M/Y:h:i:s") . ' -0500] "GET data/' . $iso . '/video/zipped.zip HTTP/1.1" 200 1024 "data/' . $iso . '/video/zipped.zip" "Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.143 Safari/537.36"' . $CRLF;
file_put_contents($SE_LogPath . "zip-access.log", $data, FILE_USE_INCLUDE_PATH | FILE_APPEND | LOCK_EX);
?>