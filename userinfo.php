<?php
/**
 * UserInfo.php
 *
 * This page is for users to view their account information
 * with a link added for them to edit the information.
 *
 * Written by: Jpmaster77 a.k.a. The Grandmaster of C++ (GMC)
 * Last Updated: August 26, 2004
 */
include("include/session.php");
?>

<html>
<title>Login Script</title>
<body style="background-color: #003366; margin: 14pt; font-family: Geneva, Arial, Helvetica, sans-serif; ">
<div style="background-color: white; padding: 20px; width: 800px; margin-left: auto; margin-right: auto; ">
<?php
/* Requested Username error checking */
$req_user = trim($_GET['user']);
if(!$req_user || strlen($req_user) == 0 ||
   !preg_match("/^([0-9a-z])+$/i", $req_user) ||					// eregi is DEPRECATED in PHP 5.3.0, and REMOVED in PHP 7.0.0.  -- Scott Starker - 4/18/17
   !$database->usernameTaken($req_user)){
   die("Username not registered");
}

/* Logged in user viewing own account */
if(strcmp($session->username,$req_user) == 0){
   echo "<h1 style='text-align: center; '>My Account</h1>";
}
/* Visitor not viewing own account */
else{
   echo "<h1 style='text-align: center; '>User Info</h1>";
}

/* Display requested user information */
$req_user_info = $database->getUserInfo($req_user);

/* Username */
echo "<b>Username: ".$req_user_info['username']."</b><br>";

/* Email */
echo "<b>Email:</b> ".$req_user_info['email']."<br>";

/**
 * Note: when you add your own fields to the users table
 * to hold more information, like homepage, location, etc.
 * they can be easily accessed by the user info array.
 *
 * $session->user_info['location']; (for logged in users)
 *
 * ..and for this page,
 *
 * $req_user_info['location']; (for any user)
 */

/* If logged in user viewing own account, give link to edit */
if(strcmp($session->username,$req_user) == 0){
   echo "<br><a href=\"useredit.php\">Edit Account Information</a><br>";
}

/* Link back to main */
echo "<br><span style='text-align: center; '>Back To [<a href=\"login.php\">Login</a>]</span><br>";

?>
</div>
</body>
</html>
