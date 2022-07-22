<?php
function get_my_db() {
	static $db;
	
	if (!$db) {
		// set the database connection variables
		// The OOP is different than the procedual code. The port needs to be seperate from $dbHost and put in mysqli (3306).
		$dbHost = 'db5000048376.hosting-data.io';
		$dbUser = 'dbu117935';
		$dbPass = 'Biblia/20?LSm19';
		$dbDatabase = 'dbs43253';
		
		//connect to the database 
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
