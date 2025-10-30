<?php
// local AWStats log
function get_my_AWStatsDB() {
	static $AWStatsDB;
	
	if (!$AWStatsDB) {
		$dbHost = getenv('DB_HOST');
		$dbUser = getenv('DB_USER');
        $dbPort = getenv('DB_PORT');
        if (empty($dbPort)) {
            $dbPort = 3306;
        }

        $dbPassFile = getenv('PASSWORD_FILE_PATH');
		$dbPass = trim(file_get_contents($dbPassFile));
		$dbDatabase = getenv('DB_AWSTATS_DATABASE');
		//connect to the database 
		$AWStatsDB = new mysqli($dbHost, $dbUser, $dbPass, $dbDatabase, $dbPort);
		if ($AWStatsDB->connect_errno) {
			die('Connection could not be established.');
		}
		/* change character set to utf8 */
		$AWStatsDB->set_charset("utf8");
	}
	return $AWStatsDB;
}
?>
