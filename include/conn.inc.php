<?php

function get_my_db() {
	static $SEDb;
	
	if (!$SEDb) {
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

		$SEDb = new mysqli($dbHost, $dbUser, $dbPass, $dbDatabase, $dbPort);
		if ($SEDb->connect_errno) {
			die('Connection could not be established.');
		}
		/* change character set to utf8 */
		$SEDb->set_charset("utf8");
	}
	return $SEDb;
}
?>
