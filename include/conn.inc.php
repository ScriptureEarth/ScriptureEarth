<?php

function get_my_db() {
	static $db;
	
	if (!$db) {
		$dbHost = getenv('DB_HOST');
		$dbUser = getenv('DB_USER');
        $dbPort = (int) getenv('DB_PORT');
        if (empty($dbPort)) {
            $dbPort = 3306;
        }

        $dbPassFile = getenv('PASSWORD_FILE_PATH');
		$dbPass = trim(file_get_contents($dbPassFile));
		$dbDatabase = getenv('DB_SE_DATABASE');
		//connect to the database

		$db = new mysqli($dbHost, $dbUser, $dbPass, $dbDatabase, $dbPort);
		if ($db->connect_errno) {
			die('Connection could not be established.');
		}
		/* change character set to utf8 */
		$db->set_charset("utf8");
	}
	return $db;
}
?>
