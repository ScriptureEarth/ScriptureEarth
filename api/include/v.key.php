<?php
if (isset($_GET['key'])) {																		// key
	$key = $_GET['key'];
	$query="SELECT * FROM api_users WHERE `key` = '$key'";
	$result=$db->query($query) or die ('Query failed: ' . $db->error . '</body></html>');
	if ($result->num_rows <= 0) {
		//ob_start();
		header('HTTP/1.0 403 Forbidden');
		//echo 'This is an error';
		//exit;
		die ('<div style="background-color: white; color: red; font-size: 16pt; padding-top: 20px; padding-bottom: 20px; margin-left: 200px; margin-top: 200px; ">The key is in error.</div></body></html>');
	}
}
else {
	header('HTTP/1.0 401 Unauthorized');
	die ('HACK!');
}
if (isset($_GET['v'])) {																		// version
	$v = (float)$_GET['v'];
	if ($v != .5 && $v != 1 && $v != 2) {																	// version = 1
		header('HTTP/1.0 403 Forbidden');
		die ('<div style="background-color: white; color: red; font-size: 16pt; padding-top: 20px; padding-bottom: 20px; margin-left: 200px; margin-top: 200px; ">The version is in error.</div></body></html>');
	}
}
else {
	header('HTTP/1.0 401 Unauthorized');
	die ('HACK!');
}
?>