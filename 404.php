<!DOCTYPE html>
<htm>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>404 Not Found</title>
</head>
<body>
<h1>Not Found (404)</h1>
The requested URL<br />

<?php
//echo $_SERVER['SERVER_NAME'];
//echo $_SERVER['SCRIPT_URI'];
//echo $_SERVER['REQUEST_URI'];
echo '1) ' . $_SERVER['PHP_SELF'] . '<br />';
echo '2) ' . $_SERVER['GATEWAY_INTERFACE'] . '<br />';
echo '3) ' . $_SERVER['SERVER_ADDR'] . '<br />';
echo '4) ' . $_SERVER['SERVER_NAME'] . '<br />';
echo '5) ' . $_SERVER['SERVER_SOFTWARE'] . '<br />';
echo '6) ' . $_SERVER['SERVER_PROTOCOL'] . '<br />';
echo '7) ' . $_SERVER['REQUEST_METHOD'] . '<br />';
echo '8) ' . $_SERVER['REQUEST_TIME'] . '<br />';
echo '9) ' . $_SERVER['QUERY_STRING'] . '<br />';
echo '10) ' . $_SERVER['HTTP_ACCEPT'] . '<br />';
echo '11) ' . $_SERVER['HTTP_ACCEPT_CHARSET'] . '<br />';
echo '12) ' . $_SERVER['HTTP_HOST'] . '<br />';
echo '13) ' . $_SERVER['HTTP_REFERER'] . '<br />';
echo '14) ' . $_SERVER['HTTPS'] . '<br />';
echo '15) ' . $_SERVER['REMOTE_ADDR'] . '<br />';
echo '16) ' . $_SERVER['REMOTE_HOST'] . '<br />';
echo '17) ' . $_SERVER['REMOTE_PORT'] . '<br />';
echo '18) ' . $_SERVER['SCRIPT_FILENAME'] . '<br />';
echo '19) ' . $_SERVER['SERVER_ADMIN'] . '<br />';
echo '20) ' . $_SERVER['SERVER_PORT'] . '<br />';
echo '21) ' . $_SERVER['SERVER_SIGNATURE'] . '<br />';
echo '22) ' . $_SERVER['PATH_TRANSLATED'] . '<br />';
echo '23) ' . $_SERVER['SCRIPT_NAME'] . '<br />';
echo '24) ' . $_SERVER['SCRIPT_URI'] . '<br />';
?>

was not found on the ScriptureEarth.org server.

</body>
</html>