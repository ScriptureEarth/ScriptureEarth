<?php
function get_my_db() {
    static $db;

    if (!$db) {
/* 
	In Windows 7 machine under Apache:
		In DOS, cd \xampplite\xampplite\mysql\bin
		and type "mysql --user=root"
		at "mysql> "
		strike though (type "GRANT ALL ON scripture.* TO 'root'@'localhost' IDENTIFIED BY 'mmljrev22';" // password here)
		type: alter user 'root'@'localhost' IDENTIFIED BY 'mmljrev22';
		type: FLUSH PRIVILEGES;
		at "mysql> "
		type "quit;"
		Just execute this 1 time for each machine and your good to go!
*/
	//set the database connection variables
	// The OOP is different than the procedual code. The port needs to be seperate from $dbHost and put in mysqli (3306).
	// localhost needs to be 127.0.0.1 for php 5.3+!
	// the next 2 lines are for the local computers
	$dbHost = '127.0.0.1';
	$dbUser = 'root';
	//$dbUser = 'pma';
	//$dbPass = 'mmljrev22';					// password here
	$dbPass = '';					// password here
	//$dbPass = 'root';					// password here
	$dbDatabase = 'scripture';
	
	//connect to the database 
	@ $db = new mysqli($dbHost, $dbUser, $dbPass, $dbDatabase, 3306);
	if ($db->connect_errno) {
		die('Connection could not be established.');
	}
	
	/* change character set to utf8 */
	$db->set_charset("utf8");
	// $db->query("SET NAMES 'utf8'"); 		// is not recommended (MySQL 5.3+)
	}
	return $db;
}
// d:
// cd \Users\Scott\Documents\xampp\mysql\bin
?>