<?php
// The html tags must not above and below this php section because the server displays the document and not saves the document!

// Usage: 00-PlaylistAudioSaveZip.php"+"?T=OT&st="+st+"&iso="+iso+"&ROD_Code="+ROD_Code+"&Books="+OT.substring(0, OT.length-1) or
//        00-PlaylistAudioSaveZip.php"+"?T=NT&st="+st+"&iso="+iso+"&ROD_Code="+ROD_Code+"&Books="+NT.substring(0, NT.length-1)

/*
	None of the 'echo' work because of the header(...)!!!!!
*/

include ("./include/conn.inc.php");								// connect to the database named 'scripture'
include ("./translate/functions.php");

$st = "eng";
if (isset($_GET["st"])) {
	$st = $_GET["st"];
	if (!preg_match('/^([a-z]{3})$/', $st)) {
		die ('“st” is empty.</body></html>');
	}
}

if (isset($_GET["iso"])) {
	$iso = $_GET["iso"];
	if (!preg_match('/^([a-z]{3})$/', $iso)) {
		die ('“ISO” ' . translate('is empty', $st, 'sys') . '.</body></html>');
	}
}
else
	die(translate('No ISO was found.', $st, 'sys'));

$dirname = './data/'.$iso.'/audio/';

if (isset($_GET['Books'])) {
	$Books = $_GET['Books'];
	if (!preg_match('/^([0-9a-zñA-ZÑ., _|()-]+)$/', $Books)) {
		die('Books were not just numbers!</body></html>');
	}
}
else
	die(translate('There were no selected audio playlist files.', $st, 'sys'));
	
// 187.148.228.80 - - [03/Oct/2014:11:23:20 -0600] "GET /data/ngu/PDF/47-1COngu-web.pdf HTTP/1.1" 206 33125 "http://www.scriptureearth.org/data/ngu/PDF/47-1COngu-web.pdf"
$SE_LogPath = 'log/';
$CRLF = "\r\n";
if ($_SERVER['REMOTE_ADDR'] != '127.0.0.1' && $_SERVER['REMOTE_ADDR'] != '::1') {
	$SE_LogPath = 'log/';
	$CRLF = "\n";
}
$data = $_SERVER['REMOTE_ADDR'] . ' - - [' . date("d/M/Y:h:i:s") . ' -0500] "GET data/' . $iso . '/audioPL/zipped.zip HTTP/1.1" 206 1024 "https://www.scriptureearth.org/data/' . $iso . '/audioPL/zipped.zip" "Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.143 Safari/537.36"' . $CRLF;
file_put_contents($SE_LogPath . "zip-access.log", $data, FILE_USE_INCLUDE_PATH | FILE_APPEND | LOCK_EX); 

// insert the new zip file here = $file

$Selected_Book_Numbers = explode("|", $Books);									// numbers of the books

//echo $Books . "<br /><br />";
//print_r($Selected_Book_Numbers);
//echo "<br />";
//print_r($Abbrev_Books);

/*********************************************************************************************************
    Stream the ZIP straight to the browser. Nothing is written to disk, so there
    are no temporary files to copy in or clean up afterwards. Source files are
    read directly from ./data/<iso>/audio/ and deflate-compressed as they are
    sent. Spaces in the source names become underscores inside the archive, as
    before.
 *********************************************************************************************************/
require_once("./include/ZipStreamer.php");

// Download filename offered to the browser.
$Zip_Filename = str_replace(" ", "", microtime());
$Zip_Filename = str_replace(".", "", $Zip_Filename);
$Zip_Filename = "AudioPlaylist_".$Zip_Filename.".zip";

set_time_limit(0);											// no time limit for big archives

$zip = new ZipStreamer($Zip_Filename, false);				// false = store (no compression); audio is already compressed
$zip->setComment(translate('Downloaded from ScriptureEarth.org.', $st, 'sys'));
foreach ($Selected_Book_Numbers as $file) {
	$file_path = preg_replace('/\s/i', '_', $file);			// name stored inside the archive
	$zip->addFile($dirname . $file, $file_path);			// read directly from ./data/<iso>/audio/
}
$zip->finish();

// Completed: 187.148.228.80 - - [03/Oct/2014:11:23:20 -0600] "GET /data/ngu/PDF/47-1COngu-web.pdf HTTP/1.1" 206 33125 "http://www.scriptureearth.org/data/ngu/PDF/47-1COngu-web.pdf"
$data = 'Completed: ' . $_SERVER['REMOTE_ADDR'] . ' - - [' . date("d/M/Y:h:i:s") . ' -0500] "GET data/' . $iso . '/audio/zipped.zip HTTP/1.1" 200 1024 "https://www.scriptureearth.org/data/' . $iso . '/audio/zipped.zip" "Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.143 Safari/537.36"' . $CRLF;
file_put_contents($SE_LogPath . "zip-access.log", $data, FILE_USE_INCLUDE_PATH | FILE_APPEND | LOCK_EX);
?>