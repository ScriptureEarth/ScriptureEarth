<?php
if (isset($_GET["SaveAsVideo"])) {
	$file = $_GET["SaveAsVideo"];
}
else
	die('No ‘SaveAsVideo’ was found.');
//AJAX:
if (file_exists($file)) {
	// Fix IE bug [0]
	//$header_file = (strstr($_SERVER['HTTP_USER_AGENT'], 'MSIE')) ? preg_replace('/\./', '%2e', basename($file), substr_count(basename($file), '.') - 1) : basename($file);
//	header('Content-Type: application/mpg');
    header("Content-Type: application/octet-stream");
    header("Content-Description: File Transfer");
	header('Content-Disposition: attachment; filename="' . basename($file) . '"');
	header('Expires: 0');
//	header('Cache-Control: must-revalidate');
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Accept-Ranges: bytes");
	header("Content-Transfer-Encoding: binary");
	header('Content-Length: ' . (string)find_filesize($file));
	//$file = str_replace("/", "\\", $file);
    // The three lines below basically make the download non-cacheable.
	header("Cache-control: private");
	header('Pragma: private');
	//header('Pragma: public');
	//header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	@ob_end_clean(); //turn off output buffering to decrease cpu usage

	// required for IE, otherwise Content-Disposition may be ignored
	//if (ini_get('zlib.output_compression'))
	//	ini_set('zlib.output_compression', 'Off');
	readfile($file, TRUE);
	// Send file for download
	/*if ($stream = fopen($file, 'rb')){
		while (!feof($stream) && connection_status() == 0){
			//reset time limit for big files
			set_time_limit(0);					// The maximum execution time in seconds. If set to zero, no time limit is imposed.
			//print(fread($stream, 1024*8));
			print(fread($stream, 1*(1024*1024)));
			flush();
		}
		fclose($stream);
	}*/
	echo "<div><a href='#' target='_blank'>$file</a></div>";
	exit;
}
else {
	die('‘SaveAsVideo’ did not exists.');
}

function find_filesize($file) {
    if (substr(PHP_OS, 0, 3) == "WIN") {
        exec('for %I in ("'.$file.'") do @echo %~zI', $output);
        $return = $output[0];
    }
    else {
        $return = filesize($file);
    }
    return $return;
}



/*
            // Fix IE bug [0]
            $header_file = (strstr($_SERVER['HTTP_USER_AGENT'], 'MSIE')) ? preg_replace('/\./', '%2e', $file, substr_count($file, '.') - 1) : $file;
            // Prepare headers
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Content-Description: File Transfer");
            header("Content-Type: video/mpeg");
            header("Content-Disposition: attachment; filename=\"" . $header_file . "\";");


            //header('Content-Disposition: attachment; filename="'.$name.'"');
            /* The three lines below basically make the download non-cacheable. * /
            header("Cache-control: private");
            header('Pragma: private');
            header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");


            //header("Cache-Control: public", false);
            //header("Pragma: public");
            //header("Expires: 0");
			header("Accept-Ranges: bytes");
            header("Content-Transfer-Encoding: binary");
            header("Content-Length: " . filesize($file_real));

            @ob_end_clean(); //turn off output buffering to decrease cpu usage

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
			*/
?>
