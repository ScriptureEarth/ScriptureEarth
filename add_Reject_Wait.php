<?php
/*
Created by Scottt Starker on 2/2022

MySQL: utf8_general_ci flattens accents as well as lower-case:
You must ensure that all parties (your app, mysql connection, your table or column) have set utf8 as charset.
- header('Content-Type: text/html; charset=utf-8'); (or <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />)
- ensure your mysqli connection use utf8 before any operation:
	- $mysqli->set_charset('utf8')
- create your table or column using utf8_general_ci
*/

/*
	These are defined at the end of $response:
*/

if (isset($_GET['reject']) || isset($_GET['wait'])) { (isset($_GET['reject']) ? $action = 'Reject' : $action = 'Wait'); } else { die('Hack!'); }
if (preg_match('/^([-_a-zA-Z0-9]+)/', $action)) {} else { die('Hack!'); }
if (isset($_GET['idx'])) { $idx = $_GET['idx']; } else { die('Hack!'); }
if (is_numeric($idx)) { $idx = (int)$idx; } else { die('Hack!'); }
if (isset($_GET['type'])) {
	$type = $_GET['type'];
	$type = preg_replace('/^([_a-zA-Z0-9]+)/', '$1', $type);                                 // sab_html, apk, ios, or google_play
	if ($type == NULL) { die('Hack!'); }
}
else { die('Hack!'); }

$response = '';


include './include/conn.inc.php';
$db = get_my_db();

$query = "SELECT * FROM add_resource WHERE idx = $idx AND `type` = '$type' AND (accept = 1 OR reject = 1)";
$result=$db->query($query);
if ($result->num_rows > 0) {
    // Requesting a fix: Are you sure that you want to override this?
    //$db->query("UPDATE add_resource SET reject = 1, wait = 0, accept = 0, toAdd = 0 WHERE idx = $idx AND `type` = '$type' AND (toAdd = 1 OR wait = 1)");
    $response = 'index ' . $idx . ' and type ' . $type . ' has already had the accept/reject field set! Email the webmaster to delete it from add_resource table';
}
else {
    if ($action == 'Reject') {
        if ($db->query("UPDATE add_resource SET reject = 1, wait = 0, accept = 0, toAdd = 0 WHERE idx = $idx AND `type` = '$type' AND (toAdd = 1 OR wait = 1)")) {
            $response = 'UPDATE Reject';
        }
        else {
            $response = 'Could not update the data in "add_resource": ' . $db->error;
        }
    }
    elseif ($action == 'Wait') {
        if ($db->query("UPDATE add_resource SET wait = 1, reject = 0, accept = 0, toAdd = 0 WHERE idx = $idx AND `type` = '$type' AND (toAdd = 1 OR wait = 1)")) {
            $response = 'UPDATE Wait';
        }
        else {
            $response = 'Could not update the data in "add_resource": ' . $db->error;
        }
    }
    else {
        $response = 'This isn\'t suppose to happen!';
    }
}
echo $response;
?>