<?php
if (empty($_SERVER['QUERY_STRING'])) {
    // No query string, redirect to the default page
    header('location:00nld.php');       // the PHP query string from the URL
    exit;
}
header('location:00nld.php?' . $_SERVER['QUERY_STRING']);       // the PHP query string from the URL
exit;
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type"  content="text/html" />
<meta http-equiv="Window-target" content="_top" />
<meta name="ObjectType"          content="Document" />
<meta name="ROBOTS"              content="NOINDEX" />
<script>
    //window.location.replace("00nld.php" + window.location.search + window.location.hash);
</script>
</head>
<body>
</body>
</html>
