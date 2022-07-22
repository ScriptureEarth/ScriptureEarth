<?php

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
	$dbHost = "127.0.0.1:3306";
	$dbUser = "root";
	$dbPass = "mmljrev22";					// password here
	$dbDatabase = "scripture";
	
	//connect to the database 
	$db = mysql_connect("$dbHost", "$dbUser", "$dbPass") or die ("Error connecting to database.");
	mysql_select_db("$dbDatabase", $db) or die ("Couldn't select the database.");
	mysql_set_charset("utf-8");
	mysql_query("SET NAMES 'utf8'");
	mysql_query("SET CHARACTER SET utf8");
?>