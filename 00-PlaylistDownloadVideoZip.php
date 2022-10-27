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
    delete all files more than 24 hours from now
 *********************************************************************************************************/
$todays_date = getdate();
$todays_date_timestamp = mktime(0,0,0,$todays_date['mon'],$todays_date['mday'],$todays_date['year']);
clearstatcache();
$aFiles = glob('./zipfiles/*');
if (is_array($aFiles)) {
	foreach ($aFiles as $filename) {
		if ($todays_date_timestamp >= (filemtime($filename) + 86400)) {								// 86400 is 24 hours in seconds
			unlink($filename);																		// deletes the $filename from the SE server
		}
	}
}

/*********************************************************************************************************
    delete same ISO Codes and same filesizes
 *********************************************************************************************************/
clearstatcache();
$aFiles = glob('zipfiles/*');           															// after delete(s) get new directory
if (is_array($aFiles)) {
    $ISO_Code = '';
    $filesize = 0;
	$temp = 0;
	foreach ($aFiles as $filename) {
		$temp = strpos($filename, '_');																// strpos = false when not found
		if ($temp !== false) {
			$ISO_Code_array = [];
			$ISO_Code_array = explode('_', $filename);
			if ($ISO_Code === $ISO_Code_array[1]) {
				if ($filesize === filesize($filename)) {
					unlink($filename);																// deletes the $filename from the SE server
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

/*********************************************************************************************************
    creating ZIP
 *********************************************************************************************************/
$zip = new ZipArchive();																			// create the zip object

// creating zip file
$Zip_Filename = str_replace(' ', '', microtime());													// creating string for the zip file
$Zip_Filename = str_replace('.', '', $Zip_Filename);
$Zip_Filename = 'Video_Playlist_Download_'.$iso.'_'.$Zip_Filename.'.zip';
$archive_file_name = './zipfiles/' . $Zip_Filename;
//echo "./zipfiles/" . $Zip_Filename."<br />";

// create the file and throw the error if unsuccessful
if ($zip->open($archive_file_name, ZIPARCHIVE::CREATE) !== TRUE) {
	die(translate('Cannot open', $st, 'sys')." $archive_file_name.</body></html>");
}

/*
	None of the 'echo' works here because of the header(...).
*/
//echo "<div style='font-size: 14pt; margin-top: 50px; margin-left: 100px; '>Creating the zip file.</div>";
//echo "<br />Starting the creation of the zip file:<br />";
//flush();

// ********************************************************************************************************
//      Add each file of MP4 file array to the zip file. It takes some time.
//		If interuupted by user with the "blue" box the script won't get to "unlink('./zipfiles/'.$file)" (see below)!
//		And this zip will stay in the "zipfiles" sub-directory without beging delete.
// ********************************************************************************************************
foreach ($filenames as $file) {
	$temp = basename($file);
	//$temp = $dirname . $file;
	//if copy is successful
	if (@copy($dirname . $temp, './zipfiles/'.$temp)) {		// copy from './data/'.$iso.'/video/'.$file to './zipfiles/'.$file
		// File copied from remote!
		$zip->addFile('./zipfiles/'.$temp, $temp);			// add './zipfiles/'.$file to the zip archive file (addFile remote server files will NOT work!)
		// get not file extension
		$temp_NotExtension = preg_replace("/(.*)\..*$/", "$1", $temp);
		if (@copy($dirname . $temp_NotExtension . '.srt', './zipfiles/' . $temp_NotExtension . '.srt')) {
			// File copied from remote!
			$zip->addFile('./zipfiles/' . $temp_NotExtension . '.srt', $temp_NotExtension . '.srt');
		}
	}
	//if addFile fails
	else {
		$errors = error_get_last();
		echo "COPY ERROR: " . $errors['type'];
		echo "<br />" . $errors['message'];
		sleep(4);											// sleep for 4 seconds
	}
	//echo "numfiles: " . $zip->numFiles . '<br />';
	//echo "status:" . $zip->status . '<br />';
	//flush();
}

//echo "<br /><br />Writing the zip file...<br />";
//flush();

set_time_limit(60);											// The maximum execution time in seconds. If set to zero, no time limit is imposed.

$zip->setArchiveComment(translate('Downloaded from ScriptureEarth.org.', $st, 'sys'));

// Close the zip file.
$zip->close();

// ********************************************************************************************************
//       delete copy 'destination' files (above using @copy) must be after zip closes
// ********************************************************************************************************
foreach ($filenames as $file) {
	$temp = basename($file);
	if (file_exists('./zipfiles/'.$temp)) {
		unlink('./zipfiles/'.$temp);
	}
	// get not file extension
	$temp_NotExtension = preg_replace("/(.*)\..*$/", "$1", $temp);
	if (file_exists('./zipfiles/' . $temp_NotExtension . '.srt')) {
		unlink('./zipfiles/' . $temp_NotExtension . '.srt');
	}
}

$file = $Zip_Filename;
$file_real = './zipfiles/' . $file;
$ip = $_SERVER['REMOTE_ADDR'];

//echo "<br />Creation of the 'header's for download.<br />";
//flush();

/*********************************************************************************************************
    saving the ZIP on local computer
 *********************************************************************************************************/
// check to see if the download script was called
if (basename($_SERVER['PHP_SELF']) == '00-PlaylistDownloadVideoZip.php'){
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

            // Fix IE bug [0]
            $header_file = (strstr($_SERVER['HTTP_USER_AGENT'], 'MSIE')) ? preg_replace('/\./', '%2e', $file, substr_count($file, '.') - 1) : $file;

//			ob_end_clean();
//			ob_end_flush();
			// Prepare headers
//			ob_start();									// breaks if zip file is over 64 MB!

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
            
			//ob_end_clean(); //turn off output buffering to decrease cpu usage

            // required for IE, otherwise Content-Disposition may be ignored
            if (ini_get('zlib.output_compression'))
                ini_set('zlib.output_compression', 'Off');

			// ********************************************************************************************************
			//				Send file for 'download' for the user
			// ********************************************************************************************************
			ini_set('memory_limit', '1024M');								// memory_limit - 1GB !
            if ($stream = fopen($file_real, 'rb')){
                //while (!feof($stream) && connection_status() == 0) {
                    //reset time limit for big files
                    set_time_limit(0);										// The maximum execution time in seconds. If set to zero, no time limit is imposed.
                    //print(fread($stream, 1024*8));
					//print(fread($stream, 1*(1024*1024)));
					print(fread($stream, filesize($file_real)));
					flush();
                //}
                fclose($stream);
            }
			if (file_exists($file_real)) {
				unlink($file_real);
			}

//			ob_end_flush();
        }
		else {
            // Requested file does not exist (File not found)
            die(translate('Requested video file does not exist.', $st, 'sys'));
        }
        // Completed: 187.148.228.80 - - [03/Oct/2014:11:23:20 -0600] "GET /data/ngu/PDF/47-1COngu-web.pdf HTTP/1.1" 206 33125 "http://www.scriptureearth.org/data/ngu/PDF/47-1COngu-web.pdf"
        $data = 'Completed: ' . $_SERVER['REMOTE_ADDR'] . ' - - [' . date("d/M/Y:h:i:s") . ' -0500] "GET data/' . $iso . '/video/' . $PlaylistVideoFilename . ' HTTP/1.1" 200 1024 "https://www.scriptureearth.org/data/' . $iso . '/video/' . $PlaylistVideoFilename . '" "Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.143 Safari/537.36"' . $CRLF;
        file_put_contents($SE_LogPath . "zip-access.log", $data, FILE_USE_INCLUDE_PATH | FILE_APPEND | LOCK_EX); 
    }
}
?>
