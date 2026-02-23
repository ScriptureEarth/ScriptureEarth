<?php
if (isset($_GET['key'])) {																		// key
	$key = $_GET['key'];
	$query="SELECT * FROM api_users WHERE `key` = '$key'";
	$result=$db->query($query) or die ('Query failed: ' . $db->error);
	if ($result->num_rows <= 0) {
		//ob_start();
		header('HTTP/1.0 403 Forbidden');
		$marks = json_decode('{"error": "The key is in error."}');
		header('Content-Type: application/json');
		echo json_encode($marks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
		exit;
	}
}
else {
	header('HTTP/1.0 401 Unauthorized');
	$marks = json_decode('{"error": "The key is missing."}');
	header('Content-Type: application/json');
	echo json_encode($marks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
	exit;
}
if (isset($_GET['v'])) {																		// version
	$v = (float)$_GET['v'];
	if ($v != .5 && $v != 1 && $v != 2) {														// version = 1 or 2
		header('HTTP/1.0 403 Forbidden');
		$marks = json_decode('{"error": "The version is in error."}');
		header('Content-Type: application/json');
		echo json_encode($marks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
		exit;
	}
}
else {
	header('HTTP/1.0 401 Unauthorized');
	$marks = json_decode('{"error": "The version is missing."}');
	header('Content-Type: application/json');
	echo json_encode($marks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
	exit;
}
?>