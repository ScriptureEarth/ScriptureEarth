<?php
// The html tags must not above and below this php section because the server displays the document and not saves the document!

// Usage: 00i-AudioSaveZip.php"+"?T=OT&ISO="+ISO+"&ROD_Code="+ROD_Code+"&Books="+OT.substring(0, OT.length-1) or
//        00i-AudioSaveZip.php"+"?T=NT&ISO="+ISO+"&ROD_Code="+ROD_Code+"&Books="+NT.substring(0, NT.length-1)

// Path to downloadable files (will not be revealed to users so they will never know your file's real address)
define ("PATHScripture", "");
include (PATHScripture . "OT_Books.php");			// $OT_array
include (PATHScripture . "NT_Books.php");			// $NT_array
include("conn.php");

define ("OT_EngBook", 2);
define ("NT_EngBook", 2);

define ("OT_Abbrev", 5);
define ("NT_Abbrev", 5);

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

if (isset($_GET["ISO"])) {
	$ISO = $_GET["ISO"];
}
else
	die("No ISO was found.");

$hiddenPath = "data/".$ISO."/audio/";

// VARIABLES
if (isset($_GET['T'])) {
    $Testament = $_GET['T'];
}
else
	die("No Testament was found.");

if (isset($_GET['Books'])) {
	$Books = $_GET['Books'];
}
else
	die("There were no selected audio files.");

// insert the new zip file here = $file

$Abbrev_Books = array();
$Selected_Book_Numbers = explode(",", $Books);									// numbers of the books
if ($Testament == "NT") {
	for ($index = 0; $index < count($Selected_Book_Numbers); $index++) {		// count all selected books
		$Abbrev_Books[] = $NT_abbrev_array[$Selected_Book_Numbers[$index]];		// all selected abbreviated books
	}
}
else {
	for ($index = 0; $index < count($Selected_Book_Numbers); $index++) {
		$Abbrev_Books[] = $OT_abbrev_array[$Selected_Book_Numbers[$index]];
	}
}

  $desired_extension = 'mp3'; //extension we're looking for
  $dirname = $hiddenPath;
	
  $dir = opendir($dirname) or die("There is no audio folder under '$ISO'.<br />");
  $files = array();
  while (false != ($file = readdir($dir))) {		// reads the $dir 1 file at a time
    if (($file != ".") && ($file != "..")) {
      $fileChunks = explode(".", $file);			// file name of: zzzzz . qqq
      if ($fileChunks[1] == $desired_extension) {	// the 2nd $filChucks leaves the extension (qqq)
		$files[] = $file;					// $files = zzzzz.qqq
      }
    }
  }
  closedir($dir);

if ($files[0] == null) {
	echo ("Error! files[0] is null!<br />");
	die();
}

// delete all files more than 2 days from now
$todays_date = getdate();
$todays_date_timestamp = mktime(0,0,0,$todays_date['mon'],$todays_date['mday'],$todays_date['year']);
$aFiles = glob('zipfiles/*');
if (is_array($aFiles)) {
	foreach ($aFiles AS $filename) {
		if ($todays_date_timestamp >= (filemtime($filename) + 86400)) {		// 86400 is 24 hours in seconds
			unlink($filename);
		}
	}
}

natcasesort($files);		// Natural order sorting (case-insensitive)
$filenames = array();

for ($f = 0; $f < count($files); $f++) {		// all of the audio files in the directory
	$z = 0;
	for ($index = 0; $index < count($Abbrev_Books); $index++) {		// count of the selected audio files
		$b = 0;
		if ($Testament == "NT") {
			$Chapters = $NT_How_Many_Chapters_array[$Selected_Book_Numbers[$index]];		// number of chapters in a book
		}
		else {
			$Chapters = $OT_How_Many_Chapters_array[$Selected_Book_Numbers[$index]];
		}
		$Chptrs = 0;
		while (preg_match("/".$Abbrev_Books[$index]."/i", $files[$f])) {		// RegEx of all of the files for the selected abbreviated book
			$z = 1;
			$filenames[] = $files[$f];
			$f++;
			$Chptrs++;
			if ($Chptrs >= $Chapters) break;
		}
		if ($z == 1) {
			$f--;
			break;
		}
    }
}

natcasesort($filenames);		// Natural order sorting (case-insensitive)

// Creating zip file.

// create the object
$zip = new ZipArchive();

$Zip_Filename = str_replace(" ", "", microtime());
$Zip_Filename = str_replace(".", "", $Zip_Filename);
$Zip_Filename = $Testament."_Books_".$Zip_Filename.".zip";
$archive_file_name = "zipfiles/" . $Zip_Filename;

// create the file and throw the error if unsuccessful
if ($zip->open($archive_file_name, ZIPARCHIVE::CREATE) !== TRUE) {
	echo("Cannot open <$archive_file_name>.\n");
	die();
}

/*
	None of the 'echo' work because of the header(...)!!!!!
*/

//add each files of $file_name array to archive
foreach($filenames as $file) {
	$temp = $hiddenPath . $file;
	$zip->addFile($temp, $file);
}

set_time_limit(60);									// The maximum execution time in seconds. If set to zero, no time limit is imposed.

$zip->setArchiveComment('Downloaded from ScriptureEarth.org.');
$zip->close();

// Downloading the zip file.

$file = $Zip_Filename;

$file_real = "zipfiles/" . $file;
$ip = $_SERVER['REMOTE_ADDR'];

// Check to see if the download script was called
if (basename($_SERVER['PHP_SELF']) == '00i-AudioSaveZip.php'){
    if ($_SERVER['QUERY_STRING'] != null){
        // HACK ATTEMPT CHECK
        // Make sure the request isn't escaping to another directory
		// [strpos($file, '/') > 0 is not good because the filename  has a path]
        if (substr($file, 0, 1) == '.' || strpos($file, '..') > 0 || substr($file, 0, 1) == '/') { // || strpos($file, '/') > 0){
            // Display hack attempt error
            die("Hack attempt detected!");
        }
        // If requested file exists
        if (file_exists($file_real)){
            // Get extension of requested file
			$extension = strtolower(substr(strrchr($file, "."), 1));
			//echo "extension= " . $extension . "<br />";
            // Determine correct MIME type
            switch($extension){
                case "zip":     $type = "application/x-zip-compressed";  break;
				//case "zip":     $type = "application/zip";				 break;
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
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Content-Description: File Transfer");
            header("Content-Type: " . $type);
            header("Content-Disposition: attachment; filename=\"" . $header_file . "\";");


//header('Content-Disposition: attachment; filename="'.$name.'"');
/* The three lines below basically make the download non-cacheable. */
header("Cache-control: private");
header('Pragma: private');
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Accept-Ranges: bytes");
header("Content-Transfer-Encoding: binary");
header("Content-Length: " . filesize($file_real));

@ob_end_clean(); //turn off output buffering to decrease cpu usage

// required for IE, otherwise Content-Disposition may be ignored
if (ini_get('zlib.output_compression'))
	ini_set('zlib.output_compression', 'Off');

// Send file for download
            if ($stream = fopen($file_real, 'rb')){
                while(!feof($stream) && connection_status() == 0){
                    //reset time limit for big files
                    set_time_limit(0);					// The maximum execution time in seconds. If set to zero, no time limit is imposed.
                    //print(fread($stream, 1024*8));
					print(fread($stream, 1*(1024*1024)));
                    flush();
                }
                fclose($stream);
            }
			unlink($file_real);
        }
		else {
            // Requested file does not exist (File not found)
            echo("Requested audio file ($file_real) does not exist.");
			die();
        }
    }
}
?>