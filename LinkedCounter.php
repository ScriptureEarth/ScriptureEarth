<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bible.is, JesusFilm, etc. go to links counter</title>
</head>
<body>
<?php
	//LinkedCounter.php:
	$filename = $_GET['LC'];
	if (preg_match('/^([-_A-Za-z\.\/]+)$/', $filename)) {
		if (file_exists($filename)) {
			$string = file_get_contents($filename, FILE_USE_INCLUDE_PATH);
			$count = intval($string);
			$count++;
			file_put_contents($filename, $count, FILE_USE_INCLUDE_PATH);
		}
		else {
			file_put_contents($filename, 1, FILE_USE_INCLUDE_PATH);
		}
	}
?>
</body>
</html>