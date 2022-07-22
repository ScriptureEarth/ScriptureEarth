<?php
/**
 * Database.php
 * 
 * The Database class is meant to simplify the task of accessing
 * information from the website's database.
 *
 * Written by: Jpmaster77 a.k.a. The Grandmaster of C++ (GMC)
 * Last Updated: August 17, 2004
 */
include("constants.php");

class MySQLDB
{
   var $connection;         //The MySQL database connection
   var $num_active_users;   //Number of active users viewing site
   var $num_active_guests;  //Number of active guests viewing site
   var $num_members;        //Number of signed-up users
   /* Note: call getNumMembers() to access $num_members! */

   /* Class constructor */
   function MySQLDB(){
      /* Make connection to database */
	  	if (defined('DB_PORT')) {
			$this->connection = @new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME, DB_PORT) or die($this->connection->connect_error);
		}
		else {
			$this->connection = @new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME) or die($this->connection->connect_error);
   		}
		if ($this->connection->connect_errno) {
			die('Connection could not be established: ' . $this->connection->connect_errno);
		}
		/* change character set to utf8 */
		$this->connection->set_charset("utf8");
		
//echo 'Success... ' . $this->connection->host_info . "\n";

      /**
       * Only query database to find out number of members
       * when getNumMembers() is called for the first time,
       * until then, default value set.
       */
      $this->num_members = -1;

      if(TRACK_VISITORS){
         /* Calculate number of users at site */
         $this->calcNumActiveUsers();

         /* Calculate number of guests at site */
         $this->calcNumActiveGuests();
      }
   }

   /**
    * confirmUserPass - Checks whether or not the given
    * username is in the database, if so it checks if the
    * given password is the same password in the database
    * for that user. If the user doesn't exist or if the
    * passwords don't match up, it returns an error code
    * (1 or 2). On success it returns 0.
    */
   function confirmUserPass($username, $password){

	  /* Add slashes if necessary (for query) */
	  /* Automatic escaping is highly deprecated, but many sites do it anyway. */
	  //if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
	      $username = addslashes($username);
      //}
	  
	// Quote if not a number
	if (!is_numeric($username)) {
	  $username = $this->connection->real_escape_string($username);
	}

      /* Verify that user is in database */
      $q = "SELECT password FROM ".TBL_USERS." WHERE username = '$username'";
      $result = $this->connection->query($q);
      if(($result->num_rows < 1)){
	  	 /* Indicates username failure */
//echo '1) SELECT Z ' . $result->num_rows . ' Z<br />';
         return 1;
      }

      /* Retrieve password from result, strip slashes */
      $password = stripslashes($password);
      $dbarray = $result->fetch_array();
      $dbarray['password'] = stripslashes($dbarray['password']);
//echo '1) Z ' . $dbarray['password'] . ' Z<br />';
	  if (substr($dbarray['password'], 0, 1) == "$") {												// Scott Starker - 3/27/17
		// Password already converted to password_hash so verify using password_verify.
		if (password_verify($password, $dbarray['password'])) {										// password_verify - 3/27/17
			// verified
		}
		else {
			/* Indicates password failure */
//echo '1) Z ' . $dbarray['password'] . ' Z<br />';
			return 2;
		}
	  }
	  else {
		// User is still using the old password MD5 so update it.
		if (md5($password) == $dbarray['password']) {
			//$db->storePw(password_hash($password));
			/**
			 * increase the default cost for BCRYPT to 12
			 * switched to BCRYPT, which will always be 60 characters
			 */
			$options = [
				'cost' => 12,
			];
			$password_db = password_hash($password, PASSWORD_BCRYPT, $options);						// password_hash - 3/27/17
			/* UDEATE that user is in database */
			$q = "UPDATE ".TBL_USERS." SET password='".$password_db."' WHERE username = '$username'";
			$result = $this->connection->query($q);
			if (!$result) {
				/* Indicates password failure */
//echo '2) Z ' . $dbarray['password'] . ' Z<br />';
				return 2;
			}
		}
		else {
			/* Indicates password failure */
//echo '3) Z ' . $dbarray['password'] . ' Z<br />';
			return 2;
		}
	  }
	  return 0;

      /* Validate that password is correct */
      //if($password == $dbarray['password']){
	  	 /* Success! Username and password confirmed */
         //return 0;
      //}
      //else{
	  	 /* Indicates password failure */
         //return 2;
      //}
   }

   /**
    * confirmUserID - Checks whether or not the given
    * username is in the database, if so it checks if the
    * given userid is the same userid in the database
    * for that user. If the user doesn't exist or if the
    * userids don't match up, it returns an error code
    * (1 or 2). On success it returns 0.
    */
   function confirmUserID($username, $userid){
      /* Add slashes if necessary (for query) */
      if(!get_magic_quotes_gpc()) {
	      $username = addslashes($username);
      }

      /* Verify that user is in database */
      $q = "SELECT userid FROM ".TBL_USERS." WHERE username = '$username'";
      $result = $this->connection->query($q);
      if(($result->num_rows < 1)){
	  	 /* Indicates username failure */
         return 1;
      }

      /* Retrieve userid from result, strip slashes */
      $dbarray = $result->fetch_array();
      $dbarray['userid'] = stripslashes($dbarray['userid']);
      $userid = stripslashes($userid);

      /* Validate that userid is correct */
      if($userid == $dbarray['userid']){
         return 0; //Success! Username and userid confirmed
      }
      else{
         return 2; //Indicates userid invalid
      }
   }
   
   /**
    * usernameTaken - Returns true if the username has
    * been taken by another user, false otherwise.
    */
   function usernameTaken($username){
      if(!get_magic_quotes_gpc()){
         $username = addslashes($username);
      }
      $q = "SELECT username FROM ".TBL_USERS." WHERE username = '$username'";
      $result = $this->connection->query($q);
      return ($result->num_rows > 0);
   }
   
   /**
    * usernameBanned - Returns true if the username has
    * been banned by the administrator.
    */
   function usernameBanned($username){
      if(!get_magic_quotes_gpc()){
         $username = addslashes($username);
      }
      $q = "SELECT username FROM ".TBL_BANNED_USERS." WHERE username = '$username'";
      $result = $this->connection->query($q);
      return ($result->num_rows > 0);
   }
   
   /**
    * addNewUser - Inserts the given (username, password, email)
    * info into the database. Appropriate user level is set.
    * Returns true on success, false otherwise.
    */
   function addNewUser($username, $password, $email){
      $time = time();
      /* If admin sign up, give admin user level */
      if(strcasecmp($username, ADMIN_NAME) == 0){
         $ulevel = ADMIN_LEVEL;
      }
	  else {
         $ulevel = USER_LEVEL;
      }
			/**
		 * increase the default cost for BCRYPT to 12
		 * switched to BCRYPT, which will always be 60 characters
		 */
		$options = [
			'cost' => 12,
		];
		$password_db = password_hash($password, PASSWORD_BCRYPT, $options);						// password_hash - 4/17/17
		$q = "INSERT INTO ".TBL_USERS." VALUES ('$username', '$password_db', '0', $ulevel, '$email', $time)";
	    return $this->connection->query($q);
   }
   
   /**
    * updateUserField - Updates a field, specified by the field
    * parameter, in the user's row of the database.
    */
   function updateUserField($username, $field, $value){
		/* THE NEXT FOUR LINES WILL NOT WORK! Scott Starker - 4/19/17 */
      	 /**
		 * increase the default cost for BCRYPT to 12
		 * switched to BCRYPT, which will always be 60 characters
		 */
		$options = [
			'cost' => 12,
		];
		$value = password_hash($value, PASSWORD_BCRYPT, $options);						// password_hash - 4/17/17
		/* UPDATE that user is in database */
      	$q = "UPDATE ".TBL_USERS." SET ".$field." = '$value' WHERE username = '$username'";
	    return $this->connection->query($q);
   }
   
   /**
    * getUserInfo - Returns the result array from a mysql
    * query asking for all information stored regarding
    * the given username. If query fails, NULL is returned.
    */
   function getUserInfo($username){
      $q = "SELECT * FROM ".TBL_USERS." WHERE username = '$username'";
      $result = $this->connection->query($q);
      /* Error occurred, return given name by default */
      if(($result->num_rows < 1)){
         return NULL;
      }
      /* Return result array */
      $dbarray = $result->fetch_array();
      return $dbarray;
   }
   
   /**
    * getNumMembers - Returns the number of signed-up users
    * of the website, banned members not included. The first
    * time the function is called on page load, the database
    * is queried, on subsequent calls, the stored result
    * is returned. This is to improve efficiency, effectively
    * not querying the database when no call is made.
    */
   function getNumMembers(){
      if($this->num_members < 0){
         $q = "SELECT * FROM ".TBL_USERS;
         $result = $this->connection->query($q);
         $this->num_members = $result->num_rows;
      }
      return $this->num_members;
   }
   
   /**
    * calcNumActiveUsers - Finds out how many active users
    * are viewing site and sets class variable accordingly.
    */
   function calcNumActiveUsers(){
      /* Calculate number of users at site */
      $q = "SELECT * FROM ".TBL_ACTIVE_USERS;
      $result = $this->connection->query($q);
      $this->num_active_users = $result->num_rows;
   }
   
   /**
    * calcNumActiveGuests - Finds out how many active guests
    * are viewing site and sets class variable accordingly.
    */
   function calcNumActiveGuests(){
      /* Calculate number of guests at site */
      $q = "SELECT * FROM ".TBL_ACTIVE_GUESTS;
      $result = $this->connection->query($q);
      $this->num_active_guests = $result->num_rows;
   }
   
   /**
    * addActiveUser - Updates username's last active timestamp
    * in the database, and also adds him to the table of
    * active users, or updates timestamp if already there.
    */
   function addActiveUser($username, $time){
      $q = "UPDATE ".TBL_USERS." SET timestamp = '$time' WHERE username = '$username'";
      $this->connection->query($q);
      if(!TRACK_VISITORS) return;
      $q = "REPLACE INTO ".TBL_ACTIVE_USERS." VALUES ('$username', '$time')";
      $this->connection->query($q);
      $this->calcNumActiveUsers();
   }
   
   /* addActiveGuest - Adds guest to active guests table */
   function addActiveGuest($ip, $time){
      if(!TRACK_VISITORS) return;
      $q = "REPLACE INTO ".TBL_ACTIVE_GUESTS." VALUES ('$ip', '$time')";
      $this->connection->query($q);
      $this->calcNumActiveGuests();
   }
   
   /* These functions are self explanatory, no need for comments */
   
   /* removeActiveUser */
   function removeActiveUser($username){
      if(!TRACK_VISITORS) return;
      $q = "DELETE FROM ".TBL_ACTIVE_USERS." WHERE username = '$username'";
      $this->connection->query($q);
      $this->calcNumActiveUsers();
   }
   
   /* removeActiveGuest */
   function removeActiveGuest($ip){
      if(!TRACK_VISITORS) return;
      $q = "DELETE FROM ".TBL_ACTIVE_GUESTS." WHERE ip = '$ip'";
      $this->connection->query($q);
      $this->calcNumActiveGuests();
   }
   
   /* removeInactiveUsers */
   function removeInactiveUsers(){
      if(!TRACK_VISITORS) return;
      $timeout = time()-USER_TIMEOUT*60;
      $q = "DELETE FROM ".TBL_ACTIVE_USERS." WHERE timestamp < $timeout";
      $this->connection->query($q);
      $this->calcNumActiveUsers();
   }

   /* removeInactiveGuests */
   function removeInactiveGuests(){
      if(!TRACK_VISITORS) return;
      $timeout = time()-GUEST_TIMEOUT*60;
      $q = "DELETE FROM ".TBL_ACTIVE_GUESTS." WHERE timestamp < $timeout";
      $this->connection->query($q);
      $this->calcNumActiveGuests();
   }
   
   /**
    * query - Performs the given query on the database and
    * returns the result, which may be false, true or a
    * resource identifier.
    */
   function query($query){
      return $this->connection->query($query);
   }
};

/* Create database connection */
$database = new MySQLDB;

?>