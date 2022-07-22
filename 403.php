<?php
// This is an optional "Access Denied" page.
// Using a 403 page is somewhat more graceful than exiting with no output.
 
header('HTTP/1.1 403 Forbidden');
?>
<html><head><title>Access Denied</title></head><body></body></html>