<?php
function get_my_db() {
    static $db;

    if (!$db) {
/* 
	In Windows 7 machine under Apache:
		In DOS, cd \xampplite\xampplite\mysql\bin
		and type "mysql --user=root"
		at "mysql> "
		type "GRANT ALL ON scripture.* TO 'root'@'localhost' IDENTIFIED BY 'mmljrev22';" // password here
		at "mysql> "
		type "quit"
		Just execute this 1 time for each machine and your good to go!
*/
	//set the database connection variables
	// localhost needs to be 127.0.0.1 for php 5.3!
	$dbHost = '127.0.0.1:3306';
	$dbUser = 'root';
	$dbPass = 'mmljrev22';					// password here
	$dbDatabase = 'scripture';
	
	//connect to the database 
	@ $db = new mysqli($dbHost, $dbUser, $dbPass, $dbDatabase);
	if ($db->connect_errno) {
		die('Connection could not be established.');
	}
	
	/* change character set to utf8 */
	$db->set_charset("utf8");
	// $db->query("SET NAMES 'utf8'"); 		// is not recommended (MySQL 5.3+)
	}
	return $db;
}
?>