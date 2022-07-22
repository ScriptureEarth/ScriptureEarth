<?php
// The html tags must not above and below this php section because the server displays the document and not saves the document!

// Usage: "00-CellPhoneFile.php"+"?T=NT&st="+st+"&iso="+iso+"&ROD_Code="+ROD_Code+"&CellPhoneFile="+CellPhoneFile  

include("./translate/functions.php");								// connect to the database named 'scripture'

$st = "eng";
if (isset($_GET["st"])) {
	$st = $_GET["st"];
	$st = preg_replace('/^([a-z]{3})/', '$1', $st);
	if ($st == NULL) {
		die ('‘st’ is empty.</body></html>');
	}
}

if (isset($_GET["iso"])) {
	$iso = $_GET["iso"];
	$iso = preg_replace('/^([a-z]{3})/', '$1', $iso);
	if ($iso == NULL) {
		die ('‘ISO’ ' . translate('is empty', $st, 'sys') . '.</body></html>');
	}
}
else
	die(translate('No ISO was found.', $st, 'sys'));

if (isset($_GET['CellPhoneFile'])) {
	echo $_GET['CellPhoneFile'] . '<br />';
	$CellPhoneFile = $_GET['CellPhoneFile'];
}
else
	die(translate('No file was found.', $st, 'sys'));
	
$pos = false;
$pos = strpos($CellPhoneFile, '://');										// check to see if "://" is present (https;//zzzzz)
if (!$pos === false) {
	header("location: ".$CellPhoneFile);
	echo "<script type='text/javascript'>";
	echo "window.close();";
	echo "</script>";
	exit();
}

// Path to downloadable files (will not be revealed to users so they will never know your file's real address)
$dirname = "./data/".$iso."/study/";
$ScriptFilename = '00-CellPhoneModule.php';

$file = $CellPhoneFile;
$file_real = $dirname . $file;

$ip = $_SERVER['REMOTE_ADDR'];												// gives the IP address from which the request was sent to our web server

// Check to see if the download script was called
if (basename($_SERVER['PHP_SELF']) == $ScriptFilename) {					// The filename of the currently executing script.
    if ($_SERVER['QUERY_STRING'] != null){									// The query string, if any, via which the web page was accessed. 
        // HACK ATTEMPT CHECK
        // Make sure the request isn't escaping to another directory
		// [strpos($file, '/') > 0 is not good because the filename has a path]
        if (substr($file, 0, 1) == '.' || strpos($file, '..') > 0 || substr($file, 0, 1) == '/') { // || strpos($file, '/') > 0){
            // Display hack attempt error
            die(translate('Hack attempt detected!', $st, 'sys'));
        }
        // If requested file exists
		if (file_exists($file_real)) {
		//$file_headers = @get_headers($file_real);							// Fetches all 9 of the headers sent by the server in response to an HTTP request.
		//if ($file_headers[0] != 'HTTP/1.1 404 Not Found' && $file_headers[0] != 'HTTP/1.1 302 Moved Temporarily') {
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
            // Prepare headers
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Content-Description: File Transfer");
            header("Content-Type: " . $type);
            header("Content-Disposition: attachment; filename=" . $header_file . ";");

			//header('Content-Disposition: attachment; filename="'.$name.'";');
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
//			$head = array_change_key_case(get_headers($file_real, TRUE));		// need to do this because it's a remote server
//			header("Content-Length: " . $head['content-length']);

			@ob_end_clean(); //turn off output buffering to decrease cpu usage
			
			// required for IE, otherwise Content-Disposition may be ignored
			if (ini_get('zlib.output_compression'))
				ini_set('zlib.output_compression', 'Off');

			// Send file for download
            if ($stream = fopen($file_real, 'rb')){
                while(!feof($stream) && connection_status() == 0){
                    //reset time limit for big files
                    set_time_limit(0);										// The maximum execution time in seconds. If set to zero, no time limit is imposed.
                    //print(fread($stream, 1024*8));
					print(fread($stream, 1*(1024*1024)));
                    flush();
                }
                fclose($stream);
            }
        }
		else {
            // Requested file does not exist (File not found)
			//echo $file_headers[0] . '<br />';
			echo $file_real . '<br />';
            echo(translate('Requested file does not exist.', $st, 'sys'));
			die();
        }
    }
}
?>
