<?php
	include("conn.php");
	$ISO_ROD_index_SE = $_GET["ISO_ROD_index_SE"];
	$convertUrlQuery = $_SERVER['QUERY_STRING'];		// Everything after the filename of the URL.
	preg_match('/.*[^&]&URLJESUSHTML=(.*)&.*/', $convertUrlQuery, $matches);
	$URLJESUSHTML = $matches[1];
	$URLJESUSHTML = str_replace("&amp;", "&", $URLJESUSHTML);
	$query="UPDATE watch SET URL = '$URLJESUSHTML' WHERE ISO_ROD_index = '$ISO_ROD_index_SE' AND JesusFilm = 1";
	$result=mysql_query($query);
	if (!$result) {
		die('Could not update the data in "watch": ' . mysql_error());
	}
	$response = $URLJESUSHTML;
	echo $response;
?>