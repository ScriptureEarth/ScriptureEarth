<?php
// The html tags must not be above and below this php section because the server displays the document and not saves the document!

// Usage: 00-AudioSaveZip.php"+"?T=OT&st="+st+"&iso="+iso+"&rod="+rod+"&Books="+OT.substring(0, OT.length-1) or
//        00-AudioSaveZip.php"+"?T=NT&st="+st+"&iso="+iso+"&rod="+rod+"&Books="+NT.substring(0, NT.length-1)

include ('./OT_Books.php');							// $OT_array
include ('./NT_Books.php');							// $NT_array
include ('./include/conn.inc.php');					// connect to the database named 'scripture'
$db = get_my_db();
include ('./translate/functions.php');

$st = 'eng';
if (isset($_GET['st'])) {
	$st = $_GET['st'];
	if (!preg_match('/^([a-z]{3})$/', $st)) {
		die('`st` is more than 3 characters!</body></html>');
	}
}

define ('OT_EngBook', 2);
define ('NT_EngBook', 2);

define ('OT_Abbrev', 5);
define ('NT_Abbrev', 5);

function OT_Test($PDF, $OT_Index) {					// returns true if the 
	global $OT_array;								// from NT_Books.php
	
	$a_index = 0;
	foreach ($OT_array[$OT_Index] as $a) {
		if ($PDF == $a_index) return true;
		$a_index++;
	}
	return false;
}
function NT_Test($PDF, $NT_Index) {					// returns true if the 
	global $NT_array;								// from NT_Books.php
	
	$a_index = 0;
	foreach ($NT_array[$NT_Index] as $a) {
		if ($PDF == $a_index) return true;
		$a_index++;
	}
	return false;
}

if (isset($_GET['iso'])) {
	$iso = $_GET['iso'];
	if (!preg_match('/^([a-z]{3})$/', $iso)) {
		die('`ISO` is more than 3 characters!</body></html>');
	}
}
else
	die(translate('No ISO was found.', $st, 'sys'));
	
if (isset($_GET['rod'])) {
	$rod = $_GET['rod'];
	if (!preg_match('/^([a-zA-Z0-9]{1,5})$/', $rod)) {
		die('`ROD_Code` is more than 5 characters!</body></html>');
	}
}
else
	$rod = '00000';

$Testament = '';
if (isset($_GET['T'])) {
    $Testament = $_GET['T'];
	if (!preg_match('/^(OT|NT)$/', $Testament)) {
		die('`Testament` is not Old or New Testament!</body></html>');
	}
}
else
	die(translate('No Testament was found.', $st, 'sys'));

if (isset($_GET['Books'])) {													// numbers of the books
	$Books = $_GET['Books'];
	if (!preg_match('/^([, 0-9]+)$/', $Books)) {
		die('`Books` were not just numbers!</body></html>');
	}
}
else
	die(translate('There were no selected audio files.', $st, 'sys'));

$dirname = './data/'.$iso.'/audio/';

/*********************************************************************************************************************
	 ============================================== start AudioSaveZip ===============================================
*********************************************************************************************************************/
$Abbrev_Books = [];
$Selected_Book_Numbers = explode(',', $Books);									// numbers of the books
if ($Testament == 'NT') {
	for ($index = 0; $index < count($Selected_Book_Numbers); $index++) {		// count all selected books in the NT
		if ($Selected_Book_Numbers[$index] > 26) {
			echo 'Skipped. The selected book number is greater than the number of books in the NT: '.$Selected_Book_Numbers[$index].'<br />';
			continue;
		}
	file_put_contents('AudioSaveZip.txt', 'line 98 iso: '.$iso.'; NT Books (should be books by cammas): #'.$Books."#\n", FILE_APPEND | LOCK_EX);
	file_put_contents('AudioSaveZip.txt', 'line 99: NT (0-26): #'.$Selected_Book_Numbers[$index].'#; Book Abbrev: #'.$NT_abbrev_array[$Selected_Book_Numbers[$index]]."#\n", FILE_APPEND | LOCK_EX);
		$Abbrev_Books[] = $NT_abbrev_array[$Selected_Book_Numbers[$index]];		// all selected abbreviated books in the NT
	}
}
elseif ($Testament == 'OT') {
	for ($index = 0; $index < count($Selected_Book_Numbers); $index++) {		// count all selected books in the OT
		if ($Selected_Book_Numbers[$index] > 38) {
			echo 'Skipped. The selected book number is greater than the number of books in the OT: '.$Selected_Book_Numbers[$index].'<br />';
			continue;
		}
	file_put_contents('AudioSaveZip.txt', 'line 109: iso: '.$iso.'; OT Books (should be books by cammas): #'.$Books."#\n", FILE_APPEND | LOCK_EX);
	file_put_contents('AudioSaveZip.txt', 'line 110: OT (0-38): #'.$Selected_Book_Numbers[$index].'#; Book Abbrev: #'.$OT_abbrev_array[$Selected_Book_Numbers[$index]]."#\n", FILE_APPEND | LOCK_EX);
		$Abbrev_Books[] = $OT_abbrev_array[$Selected_Book_Numbers[$index]];		// all selected abbreviated books in the OT
	}
}
else {
	die('It is not suppose to happen. Testament is empty.');
}
//print_r($Selected_Book_Numbers);
//echo "<br />";
//print_r($Abbrev_Books);
if (empty($Abbrev_Books)) {
	die('Books don"t match up!');
}

$SE_LogPath = "log/";
$CRLF = "\r\n";
// $_SERVER['REMOTE_ADDR'] is the IP address from which the user is viewing the current page. 
if ($_SERVER['REMOTE_ADDR'] != '127.0.0.1' && $_SERVER['REMOTE_ADDR'] != '::1') {
	$SE_LogPath = "log/";
	$CRLF = "\n";
}

// 187.148.228.80 - - [03/Oct/2014:11:23:20 -0600] User has [number of OT/NT audio books] OT/NT audio books. "GET /data/ngu/PDF/47-1COngu-web.pdf HTTP/1.1" 206 33125 "http://www.scriptureearth.org/data/ngu/PDF/47-1COngu-web.pdf"
$data = $_SERVER['REMOTE_ADDR'] . ' - - [' . date("d/M/Y:h:i:s") . ' -0500] User has ' . count($Selected_Book_Numbers) . ' OT/NT audio books. "GET data/' . $iso . '/audio/zipped.zip HTTP/1.1" 206 1024 "https://www.scriptureearth.org/data/' . $iso . '/audio/zipped.zip" "Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.143 Safari/537.36"' . $CRLF;
// write $data to $SE_LogPath . "zip-access.log"
file_put_contents($SE_LogPath . "zip-access.log", $data, FILE_USE_INCLUDE_PATH | FILE_APPEND | LOCK_EX); 

$files = [];
$stingBooks = str_replace(",", "','", $Books);			// gives zzzz','zzzz','zzzz
$stingBooks = "'" . $stingBooks . "'";					// gives 'zzzz','zzzz','zzzz'
if ($Testament == 'OT') {
	$query = "SELECT OT_Audio_Filename, OT_Audio_Book FROM OT_Audio_Media WHERE ISO = '$iso' AND ROD_Code = '$rod' AND OT_Audio_Book IN (".$stingBooks.")";		// "IN" handles this
	$result=$db->query($query) or die (translate('Query failed:', $st, 'sys') . ' ' . $db->error . '</body></html>');
	if ($result->num_rows == 0) {
		die(translate('The ISO language code is not found.', $st, 'sys') . '</body></html>');
	}
	while ($row = $result->fetch_array()) {
		$temp = trim($row["OT_Audio_Filename"]);
		if (!file_exists($dirname.$temp)) {
			continue;
		}
		$files[] = $temp;
	file_put_contents('AudioSaveZip.txt', 'line 153: iso: '.$iso.'; OT (0-38): OT_Audio_Filename: #'.$temp."#\n", FILE_APPEND | LOCK_EX);
	}
}
else {
	$query = "SELECT NT_Audio_Filename, NT_Audio_Book FROM NT_Audio_Media WHERE ISO = '$iso' AND ROD_Code = '$rod' AND NT_Audio_Book IN (".$stingBooks.")";		// "IN" handles this
	$result=$db->query($query) or die (translate('Query failed:', $st, 'sys') . ' ' . $db->error . '</body></html>');
	if ($result->num_rows <= 0) {
		die(translate('The ISO language code is not found.', $st, 'sys') . '</body></html>');
	}
	while ($row = $result->fetch_array()) {
		$temp = trim($row["NT_Audio_Filename"]);
		if (!file_exists($dirname.$temp)) {
			continue;
		}
		$files[] = $temp;
	file_put_contents('AudioSaveZip.txt', 'line 168: iso: '.$iso.'; NT (0-26): NT_Audio_Filename: #'.$temp."#\n", FILE_APPEND | LOCK_EX);
	}
}
if (!$files) {											// if no array files were found
	die(translate('Error! files[0] is null!', $st, 'sys').'</body></html>');
}

//print_r($files);
//echo "<br />";

/*********************************************************************************************************
    Stream the ZIP straight to the browser. Nothing is written to disk, so there
    are no temporary files to copy in or clean up afterwards. The source audio
    files are read directly from ./data/<iso>/audio/ and deflate-compressed as
    they are sent (same compression the old ZipArchive code produced).
 *********************************************************************************************************/
require_once('./include/ZipStreamer.php');

$filenames = $files;

// Download filename offered to the browser.
$Zip_Filename = str_replace(' ', '', microtime());
$Zip_Filename = str_replace('.', '', $Zip_Filename);
$Zip_Filename = $Testament.'_'.$iso.'_'.$Zip_Filename.'.zip';

set_time_limit(0);											// no time limit for big archives

$zip = new ZipStreamer($Zip_Filename, false);				// false = store (no compression); audio is already compressed
$zip->setComment(translate('Downloaded from ScriptureEarth.org.', $st, 'sys'));
foreach ($filenames as $file) {
	$zip->addFile($dirname . $file, $file);				// read directly from ./data/<iso>/audio/
}
$zip->finish();

// Completed: 187.148.228.80 - - [03/Oct/2014:11:23:20 -0600] "GET /data/ngu/PDF/47-1COngu-web.pdf HTTP/1.1" 206 33125 "http://www.scriptureearth.org/data/ngu/PDF/47-1COngu-web.pdf"
$data = 'Completed: ' . $_SERVER['REMOTE_ADDR'] . ' - - [' . date("d/M/Y:h:i:s") . ' -0500] "GET data/' . $iso . '/audio/zipped.zip HTTP/1.1" 200 1024 "https://www.scriptureearth.org/data/' . $iso . '/audio/zipped.zip" "Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.143 Safari/537.36"' . $CRLF;
file_put_contents($SE_LogPath . "zip-access.log", $data, FILE_USE_INCLUDE_PATH | FILE_APPEND | LOCK_EX);
?>