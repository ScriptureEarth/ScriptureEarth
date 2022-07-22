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
		die('‘st’ is more than 3 characters!</body></html>');
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
		die('‘ISO’ is more than 3 characters!</body></html>');
	}
}
else
	die(translate('No ISO was found.', $st, 'sys'));
	
if (isset($_GET['rod'])) {
	$rod = $_GET['rod'];
	if (!preg_match('/^([a-zA_Z0-9]{1,5})$/', $rod)) {
		die('‘ROD_Code’ is more than 3 characters!</body></html>');
	}
}
else
	$rod = '00000';

$Testament = '';
if (isset($_GET['T'])) {
    $Testament = $_GET['T'];
	if (!preg_match('/^(OT|NT)$/', $Testament)) {
		die('‘Testament’ is not Old or New Testament!</body></html>');
	}
}
else
	die(translate('No Testament was found.', $st, 'sys'));

if (isset($_GET['Books'])) {													// numbers of the books
	$Books = $_GET['Books'];
	if (!preg_match('/^([, 0-9]+)$/', $Books)) {
		die('Books’ were not just numbers!</body></html>');
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
$j = 0;
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
		$files[$j++] = $temp;
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
		$files[$j++] = $temp;
	file_put_contents('AudioSaveZip.txt', 'line 168: iso: '.$iso.'; NT (0-26): NT_Audio_Filename: #'.$temp."#\n", FILE_APPEND | LOCK_EX);
	}
}
if ($j == 0) {
	die(translate('Error! files[0] is null!', $st, 'sys').'</body></html>');
	//die();
}

/*********************************************************************************************************
    delete all files more than 24 hours from now
 *********************************************************************************************************/
$todays_date = getdate();
$todays_date_timestamp = mktime(0,0,0,$todays_date['mon'],$todays_date['mday'],$todays_date['year']);
clearstatcache();
$aFiles = glob('zipfiles/*');
if (is_array($aFiles)) {
	foreach ($aFiles as $filename) {
		if ($todays_date_timestamp >= (filemtime($filename) + 86400)) {		// 86400 is 24 hours in seconds
			//echo 'delete: ' . $filename . '<br />';
			unlink($filename);
		}
	}
}

/*********************************************************************************************************
    delete same ISO Codes and same filesizes
 *********************************************************************************************************/
clearstatcache();
$aFiles = glob('zipfiles/*');           // after delete(s) get new directory
if (is_array($aFiles)) {
    $ISO_Code = '';
    $filesize = 0;
	$temp = 0;
	foreach ($aFiles as $filename) {
		$temp = strpos($filename, '_');							// strpos = false when not found
		if ($temp !== false) {
    		$ISO_Code_array = [];
			$ISO_Code_array = explode('_', $filename);
			if ($ISO_Code === $ISO_Code_array[1]) {
				if ($filesize === filesize($filename)) {
					//echo 'delete: ' . $filename . '<br />';
					unlink($filename);
				}
				else {
					$filesize = filesize($filename);
				}
			}
			else {
				$ISO_Code = $ISO_Code_array[1];
				$filesize = filesize($filename);
			}
		}
	}
}

$filenames = $files;

// create the object
$zip = new ZipArchive();

// ********************************************************************************************************
//       Creating zip file.
// ********************************************************************************************************
$Zip_Filename = str_replace(' ', '', microtime());
$Zip_Filename = str_replace('.', '', $Zip_Filename);
$Zip_Filename = $Testament.'_'.$iso.'_'.$Zip_Filename.'.zip';
$archive_file_name = 'zipfiles/' . $Zip_Filename;
//echo "zipfiles/" . $Zip_Filename."<br />";
//echo $filenames[0];

// ********************************************************************************************************
//       create the file and throw the error if unsuccessful
// ********************************************************************************************************
if ($zip->open($archive_file_name, ZIPARCHIVE::CREATE) !== TRUE) {
	die(translate('Cannot open', $st, 'sys')." $archive_file_name.</body></html>");
}

/*
	None of the 'echo' work because of the header(...)!!!!!
*/
//echo "<div style='font-size: 14pt; margin-top: 50px; margin-left: 100px; '>Creating the zip file.</div>";
//echo "<br />Starting the creation of the zip file:<br />";
//flush();

// ********************************************************************************************************
//      Add each file of MP3 file array to the zip file. It takes some time.
//		If interuupted by user with the "blue" box the script won't get to "unlink('./zipfiles/'.$file)" (see below)!
//		And this zip will stay in the "zipfiles" sub-directory without beging delete.
// ********************************************************************************************************
foreach ($filenames as $file) {
	//$temp = $dirname . $file;
	//if copy is successful
	if (@copy($dirname . $file, './zipfiles/'.$file)) {		// copy from './data/'.$iso.'/audio/'.$file to './zipfiles/'.$file
		// File copied from remote!
		$zip->addFile('./zipfiles/'.$file, $file);			// add './zipfiles/'.$file to the zip archive file (addFile remote server files will NOT work!)
		$zip->setMtimeName($file, mktime(0,0,0,12,25,date("Y")+1));
	}
	//if addFile fails
	else {
		$errors = error_get_last();
		echo "COPY ERROR: " . $errors['type'];
		echo "<br />" . $errors['message'];
		sleep(4);											// sleep for 4 seconds
	}
	//echo "Z ";
	//flush();
	//echo "$temp<br />";
}

//echo "<br /><br />Writing the zip file...<br />";
//flush();

set_time_limit(60);										// The maximum execution time in seconds. If set to zero, no time limit is imposed.

$zip->setArchiveComment(translate('Downloaded from ScriptureEarth.org.', $st, 'sys'));

// Close the zip file.
$zip->close();

// ********************************************************************************************************
//       delete copy 'destination' files (above using @copy) must be after zip closes
// ********************************************************************************************************
foreach ($filenames as $file) {
	if (file_exists('./zipfiles/'.$file)) {
		unlink('./zipfiles/'.$file);
	}
}

//echo "The zip file is clossed.<br />";
//flush();

/*
if (file_exists($archive_file_name))
	echo "Yeah! It exists!<br /><br />";
else
	echo "It does not exist.<br /><br />";
*/

$file = $Zip_Filename;

//$file_real = $dirname . $category . $file;
$file_real = './zipfiles/' . $file;
$ip = $_SERVER['REMOTE_ADDR'];

//echo "<br />Creation of the 'header's for download.<br />";
//flush();

// Check to see if the download script was called
if (basename($_SERVER['PHP_SELF']) == '00-AudioSaveZip.php'){
    if ($_SERVER['QUERY_STRING'] != null){
        // HACK ATTEMPT CHECK
        // Make sure the request isn't escaping to another directory
		// [strpos($file, '/') > 0 is not good because the filename  has a path]
        if (substr($file, 0, 1) == '.' || strpos($file, '..') > 0 || substr($file, 0, 1) == '/') { // || strpos($file, '/') > 0){
            // Display hack attempt error
            die(translate('Hack attempt detected!', $st, 'sys'));
        }
        // If requested file exists
		if (file_exists($file_real)){
            // Get extension of requested file
			$extension = strtolower(substr(strrchr($file, "."), 1));
			//echo "extension= " . $extension . "<br />";
            // Determine correct MIME type
            switch($extension){
                //case "zip":     $type = "application/x-zip-compressed";  break;				// up until 12/18/2021 when going from PHP 7.2 to PHP 7.4
				case "zip":     $type = "application/zip";				 break;
                case "asf":     $type = "video/x-ms-asf";                break;
                case "avi":     $type = "video/x-msvideo";               break;
                case "exe":     $type = "application/octet-stream";      break;
				case "html":    $type = "text/html";      				 break;
				case "htm":     $type = "text/html";      				 break;
                case "mov":     $type = "video/quicktime";               break;
                case "mp3":     $type = "audio/mpeg";                    break;
                case "mpg":     $type = "video/mpeg";                    break;
                case "mpeg":    $type = "video/mpeg";                    break;
				case "pdf":     $type = "application/pdf";      		 break;
				case "php":     $type = "text/plain";					 break;
				case "doc":     $type = "application/msword";      		 break;
				case "xls":     $type = "application/vnd.ms-excel";      break;
				case "ppt":     $type = "application/vnd.ms-powerpoint"; break;
				case "gif":     $type = "image/gif";      				 break;
				case "png":     $type = "image/png";      				 break;
				case "jpeg":    $type = "image/jpg";      				 break;
				case "jpg":     $type = "image/jpg";      				 break;
                case "rar":     $type = "encoding/x-compress";           break;
                case "txt":     $type = "text/plain";                    break;
                case "wav":     $type = "audio/wav";                     break;
                case "wma":     $type = "audio/x-ms-wma";                break;
                case "wmv":     $type = "video/x-ms-wmv";                break;
                default:        $type = "application/force-download";    break;
            }
			
			ob_start();											// Creates an output buffer.
			
            // Fix IE bug [0]
            $header_file = (strstr($_SERVER['HTTP_USER_AGENT'], 'MSIE')) ? preg_replace('/\./', '%2e', $file, substr_count($file, '.') - 1) : $file;
            // Prepare headers
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Content-Description: File Transfer");
            header("Content-Type: " . $type);
            header("Content-Disposition: attachment; filename=\"" . $header_file . "\";");


            //header('Content-Disposition: attachment; filename="'.$name.'"');
            /* The three lines below basically make the download non-cacheable. */
            header("Cache-control: private");
            header('Pragma: private');
            header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");


            //header("Cache-Control: public", false);
            //header("Pragma: public");
            //header("Expires: 0");
			header("Accept-Ranges: bytes");
            header("Content-Transfer-Encoding: binary");
            header("Content-Length: " . filesize($file_real));

            //@ob_end_clean(); //turn off output buffering to decrease cpu usage

            // required for IE, otherwise Content-Disposition may be ignored
            if (ini_get('zlib.output_compression'))
                ini_set('zlib.output_compression', 'Off');

			// ********************************************************************************************************
			//				Send file for 'download' for the user
			// ********************************************************************************************************
ini_set('upload_max_filesize', '1000M');
ini_set('post_max_size', '1000M');
ini_set('memory_limit', '1000M' );							// this one for sure! I don't know what number to put at. At least over 300M
ini_set('max_input_time', 3000);
ini_set('max_execution_time', 3000);
			if ($stream = fopen($file_real, 'rb')){
                while (!feof($stream) && connection_status() == 0){
                    //reset time limit for big files
                    set_time_limit(0);						// The maximum execution time in seconds. If set to zero, no time limit is imposed.
                    //print(fread($stream, 1024*8));
					print(fread($stream, 1*(1024*1024)));
                    flush();
                }
                fclose($stream);
            }
			if (file_exists($file_real)) {
				unlink($file_real);							// delete zip file
			}
			
			ob_end_flush();									// Flush (send) the output buffer and turn off output buffering.
        }
		else {
            // Requested file does not exist (File not found)
            echo(translate('Requested audio file does not exist.', $st, 'sys'));
			die();
        }
	
        // Completed: 187.148.228.80 - - [03/Oct/2014:11:23:20 -0600] "GET /data/ngu/PDF/47-1COngu-web.pdf HTTP/1.1" 206 33125 "http://www.scriptureearth.org/data/ngu/PDF/47-1COngu-web.pdf"
        $data = 'Completed: ' . $_SERVER['REMOTE_ADDR'] . ' - - [' . date("d/M/Y:h:i:s") . ' -0500] "GET data/' . $iso . '/audio/zipped.zip HTTP/1.1" 200 1024 "https://www.scriptureearth.org/data/' . $iso . '/audio/zipped.zip" "Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.143 Safari/537.36"' . $CRLF;
        file_put_contents($SE_LogPath . "zip-access.log", $data, FILE_USE_INCLUDE_PATH | FILE_APPEND | LOCK_EX); 

    }
}
?>