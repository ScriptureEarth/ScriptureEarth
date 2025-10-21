<?php
// local AWStats log
function get_my_AWStatsDB() {
	static $AWStatsDB;
	
	if (!$AWStatsDB) {
		// localhost needs to be 127.0.0.1
		// the next 2 lines are for the local computers
		$dbHost = '127.0.0.1';
		$dbUser = 'root';
		//$dbPass = 'mmljrev22';					// password here
		$dbPass = '';								// password here
		//$dbPass = 'root';							// password here
		$dbDatabase = 'awstats_gui_log';
		//connect to the database 
		$AWStatsDB = new mysqli($dbHost, $dbUser, $dbPass, $dbDatabase, 3306);
		if ($AWStatsDB->connect_errno) {
			die('Connection could not be established.');
		}
		/* change character set to utf8 */
		$AWStatsDB->set_charset("utf8");
	}
	return $AWStatsDB;
}
?>
