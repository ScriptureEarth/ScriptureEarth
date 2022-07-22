<?php
//InMotion Hosting
function get_my_db() {
    static $db;

    if (!$db) {
	// The OOP is different than the procedual code. The port needs to be seperate from $dbHost and put in mysqli (3306).
	/* set the database connection variables */
	/* In terminal
	type: mysql
	type: GRANT ALL ON seadmin_scripture.* TO 'seadmin_scripture'@'localhost' IDENTIFIED BY 'lzDH=?&Yo5,9';
		type "quit"
		Just execute this 1 time for each machine and your good to go!
	*/
	// the next 2 lines are for the SE InMotion Hosting server
//dbhost: se@localhost
		$dbHost = 'localhost';
		$dbUser = 'se_scripture';
		$dbPass = 'lzDH=?&Yo5,9';
		$dbDatabase = 'se_scripture';
		
		/* connect to the database */
		@ $db = new mysqli($dbHost, $dbUser, $dbPass, $dbDatabase);
		if ($db->connect_errno) {
			die('Connection could not be established.');
		}
		
		/* change character set to utf8 */
		$db->set_charset("utf8");
	}
	return $db;
}
?>
