<?php
function get_my_db() {
    static $db;

    if (!$db) {
	// The OOP is different than the procedual code. The port needs to be seperate from $dbHost and put in mysqli (3306).
	/* set the database connection variables */
	// the next 2 lines are for the SE server
		$dbHost = 'localhost';
		$dbUser = 'scripture';
		$dbPass = 'mmljrev22';
		$dbDatabase = 'scripture';
		
		/* connect to the database */
		@ $db = new mysqli($dbHost, $dbUser, $dbPass, $dbDatabase, 3306);
		if ($db->connect_errno) {
			die('Connection could not be established.');
		}
		
		/* change character set to utf8 */
		$db->set_charset("utf8");
	}
	return $db;
}
?>