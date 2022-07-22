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

// Create the object
$zip = new ZipArchive();

// Creating zip file.
$Zip_Filename = str_replace(' ', '', microtime());
$Zip_Filename = str_replace('.', '', $Zip_Filename);
$Zip_Filename = $iso.'_Video_'.$Zip_Filename.'.zip';
$archive_file_name = 'zipfiles/' . $Zip_Filename;
//echo "zipfiles/" . $Zip_Filename."<br />";

// create the file and throw the error if unsuccessful
if ($zip->open($archive_file_name, ZIPARCHIVE::CREATE) !== TRUE) {
	echo (translate('Cannot open', $st, 'sys')." $archive_file_name.</body></html>");
	die();
}

/*
	None of the 'echo' work because of the header(...)!!!!!
*/

// ********************************************************************************************************
//       add the file to the zip file
// ********************************************************************************************************
$zip->addFile($file, basename($file));

set_time_limit(60);									// The maximum execution time in seconds. If set to zero, no time limit is imposed.

$zip->setArchiveComment(translate('Downloaded from ScriptureEarth.org.', $st, 'sys'));

// Close the zip file.
$zip->close();

//echo "The zip file is clossed.<br />";
//flush();

$file = $Zip_Filename;

$file_real = './zipfiles/' . $file;
$ip = $_SERVER['REMOTE_ADDR'];

// Check to see if the download script was called
if (basename($_SERVER['PHP_SELF']) == '00-SaveAsVideoZip.php'){
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

			// Send file for download
            if ($stream = fopen($file_real, 'rb')){
                while (!feof($stream) && connection_status() == 0){
                    //reset time limit for big files
                    set_time_limit(0);					// The maximum execution time in seconds. If set to zero, no time limit is imposed.
                    //print(fread($stream, 1024*8));
					print(fread($stream, 1*(1024*1024)));
                    flush();
                }
                fclose($stream);
            }
			if (file_exists($file_real)) {
				unlink($file_real);
			}
			
			ob_end_flush();									// Flush (send) the output buffer and turn off output buffering.
        }
		else {
            // Requested file does not exist (File not found)
            echo(translate('Requested audio file does not exist.', $st, 'sys'));
			die();
        }
	
        // Completed: 187.148.228.80 - - [03/Oct/2014:11:23:20 -0600] "GET /data/ngu/PDF/47-1COngu-web.pdf HTTP/1.1" 206 33125 "http://www.scriptureearth.org/data/ngu/PDF/47-1COngu-web.pdf"
        $data = 'Completed: ' . $_SERVER['REMOTE_ADDR'] . ' - - [' . date("d/M/Y:h:i:s") . ' -0500] "GET data/' . $iso . '/video/zipped.zip HTTP/1.1" 200 1024 "data/' . $iso . '/video/zipped.zip" "Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.143 Safari/537.36"' . $CRLF;
        file_put_contents($SE_LogPath . "zip-access.log", $data, FILE_USE_INCLUDE_PATH | FILE_APPEND | LOCK_EX); 

    }
}
?>