<?php
function get_my_db() {
    static $db;

    if (!$db) {
/* 
	In Windows 7 machine under Apache:
		In DOS, cd \xampplite\xampplite\mysql\bin
		and type "mysql --user=root"
		at "mysql> "
		type "GRANT ALL ON ilvmeico_literacy.* TO 'root'@'localhost' IDENTIFIED BY 'TtQi3QUjtGimeqK';" // password here
		at "mysql> "
		type "quit"
		Just execute this 1 time for each machine and your good to go!
*/
	//set the database connection variables
	// The OOP is different than the procedual code. The port needs to be seperate from $dbHost and put in mysqli (2222).
	// localhost needs to be 127.0.0.1 for php 5.3+!
	// the next 2 lines are for the local computers
	$dbHost = 'localhost';
	$dbUser = 'root';
	$dbPass = 'TtQi3QUjtGimeqK';					// password here
	$dbDatabase = 'ilvmeico_literacy';
	
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