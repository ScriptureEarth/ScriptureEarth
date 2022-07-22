<?php
	//set the database connection variables 
	$dbHost = "localhost:3306";
	$dbUser = "scripture";
	$dbPass = "mmljrev22";
	$dbDatabase = "scripture";
	
	//connect to the database 
	$db = mysql_connect("$dbHost", "$dbUser", "$dbPass") or die ("Error connecting to database.");
	mysql_select_db("$dbDatabase", $db) or die ("Couldn't select the database.");
	mysql_query("SET NAMES 'utf8'");
?>