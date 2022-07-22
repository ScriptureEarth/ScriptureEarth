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
		die ('‘st’ is empty.</body></html>');
	}
}

if (isset($_GET["iso"])) {
	$iso = $_GET["iso"];
	if (!preg_match('/^([a-z]{3})$/', $iso)) {
		die ('‘ISO’ ' . translate('is empty', $st, 'sys') . '.</body></html>');
	}
}
else
	die(translate('No ISO was found.', $st, 'sys'));

$dirname = './data/'.$iso.'/audio/';

if (isset($_GET['Books'])) {
	$Books = $_GET['Books'];
	if (!preg_match('/^([0-9a-zA-Z._-]+)$/', $Books)) {
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

// delete all files more than 2 days from now
$todays_date = getdate();
$todays_date_timestamp = mktime(0,0,0,$todays_date['mon'],$todays_date['mday'],$todays_date['year']);
$aFiles = glob('zipfiles/*');
if (is_array($aFiles)) {
	foreach ($aFiles AS $filename) {
		if ($todays_date_timestamp >= (filemtime($filename) + 86400)) {		// 86400 is 24 hours in seconds
			//echo 'delete: ' . $filename . '<br />';
			unlink($filename);
		}
	}
}

// Create the object
$zip = new ZipArchive();

// Creating zip file
$Zip_Filename = str_replace(" ", "", microtime());
$Zip_Filename = str_replace(".", "", $Zip_Filename);
$Zip_Filename = "AudioPlaylist_".$Zip_Filename.".zip";
$archive_file_name = "./zipfiles/" . $Zip_Filename;
//echo "zipfiles/" . $Zip_Filename."<br />";

// create the file and throw the error if unsuccessful
if ($zip->open($archive_file_name, ZIPARCHIVE::CREATE) !== TRUE) {
	echo (translate('Cannot open', $st, 'sys').' $archive_file_name.</body></html>');
	die();
}

//echo "<div style='font-size: 14pt; margin-top: 50px; margin-left: 100px; '>Creating the zip file.</div>";
//echo "<br />Starting the creation of the zip file:<br />";
//flush();

//add each files of $file_name array to archive
foreach($Selected_Book_Numbers as $file) {
	//if copy is successful
	$file_path = preg_replace('/\s/i', '_', $file);
	//$file = preg_replace('/\s/i', '%20', $file);
	// In order for copy to work properly the spaces (i.e. " ") have to be converted to %20!
	if (@copy($dirname . $file, './zipfiles/'.$file_path)) {	// copy from './data/'.$iso.'/audio/'.$file to './zipfiles/'.$file_path
		// File copied from remote!
		$zip->addFile('./zipfiles/'.$file_path, $file_path);	// add './zipfiles/'.$file to the zip archive file (addFile remote server files will NOT work!)
	}
	//if addFile fails
	else {
		$errors = error_get_last();
		echo "COPY ERROR: " . $errors['type'];
		echo "<br />" . $errors['message'];
		//sleep(4);											// sleep for 4 seconds
	}
	//echo ". ";
	//flush();
	//echo "$temp<br />";
}

//echo "<br /><br />Writing the zip file...<br />";
//flush();

set_time_limit(60);											// The maximum execution time in seconds. If set to zero, no time limit is imposed.

$zip->setArchiveComment(translate('Downloaded from ScriptureEarth.org.', $st, 'sys'));

// Close the zip file.
$zip->close();

// ********************************************************************************************************
//       delete copy 'destination' files
// ********************************************************************************************************
foreach ($Selected_Book_Numbers as $file) {
	$file_path = preg_replace('/\s/i', '_', $file);
	//	$temp = basename($file_path);
	if (file_exists('./zipfiles/'.$file_path)) {
		unlink('./zipfiles/'.$file_path);
	}
}

$file = $Zip_Filename;

$file_real = "./zipfiles/" . $file;
$ip = $_SERVER['REMOTE_ADDR'];

//echo "<br />Creation of the 'header's for download.<br />";
//flush();

// Check to see if the download script was called
if (basename($_SERVER['PHP_SELF']) == '00-PlaylistAudioSaveZip.php'){
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
            // Fix IE bug [0]
            $header_file = (strstr($_SERVER['HTTP_USER_AGENT'], 'MSIE')) ? preg_replace('/\./', '%2e', $file, substr_count($file, '.') - 1) : $file;
			
            // Prepare headers
			ob_start();											// Creates an output buffer.
			
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
			die(translate('Requested audio file does not exist.', $st, 'sys'));
		}
		// Completed: 187.148.228.80 - - [03/Oct/2014:11:23:20 -0600] "GET /data/ngu/PDF/47-1COngu-web.pdf HTTP/1.1" 206 33125 "http://www.scriptureearth.org/data/ngu/PDF/47-1COngu-web.pdf"
		$data = 'Completed: ' . $_SERVER['REMOTE_ADDR'] . ' - - [' . date("d/M/Y:h:i:s") . ' -0500] "GET data/' . $iso . '/audio/zipped.zip HTTP/1.1" 200 1024 "https://www.scriptureearth.org/data/' . $iso . '/audio/zipped.zip" "Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.143 Safari/537.36"' . $CRLF;
		file_put_contents($SE_LogPath . "zip-access.log", $data, FILE_USE_INCLUDE_PATH | FILE_APPEND | LOCK_EX); 
    }
}
?>