<?php
/**
 * Register.php
 * 
 * Displays the registration form if the user needs to sign-up,
 * or lets the user know, if he's already logged in, that he
 * can't register another name.
 *
 * Written by: Jpmaster77 a.k.a. The Grandmaster of C++ (GMC)
 * Last Updated: August 19, 2004
 */
include("include/session.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Registration Page</title>
</head>
<body style="background-color: white; margin: 14pt; font-family: Geneva, Arial, Helvetica, sans-serif; ">
<div style="background-color: white; padding: 20px; width: 800px; margin-left: auto; margin-right: auto; ">

<?php
/**
 * The user is already logged in, not allowed to register.
 */
if($session->logged_in){
   echo "<h1 style='text-align: center; '>Registered</h1>";
   echo "<p>We're sorry <b>$session->username</b> but you've already registered. "
       ."<a href=\"login.php\">Main</a>.</p>";
}
/**
 * The user has submitted the registration form and the
 * results have been processed.
 */
else if(isset($_SESSION['regsuccess'])){
   /* Registration was successful */
   if($_SESSION['regsuccess']){
      echo "<h1>Registered!</h1>";
      echo "<p>Thank you <b>".$_SESSION['reguname']."</b>. Your information has been added to the database. "
          ."You may now <a href=\"login.php\">log in</a>.</p>";
   }
   /* Registration failed */
   else{
      echo "<h1 style='text-align: center; '>Registration Failed</h1>";
      echo "<p>We're sorry but an error has occurred and your registration for the username <b>".$_SESSION['reguname']."</b> "
          ."could not be completed.<br>Please try again at a later time.</p>";
   }
   unset($_SESSION['regsuccess']);
   unset($_SESSION['reguname']);
}
/**
 * The user has not filled out the registration form yet.
 * Below is the page with the sign-up form, the names
 * of the input fields are important and should not
 * be changed.
 */
else{
	echo "<h1 style='text-align: center; '>Register</h1>";
	if($form->num_errors > 0){
	   echo "<font size=\"2\" color=\"#ff0000\">".$form->num_errors." error(s) found</font>";
	}
	?>
	<form action="process.php" method="POST">
	<table width="100%" align="left" border="0" cellspacing="0" cellpadding="3">
	<tr>
	<td width="10%">Username:</td>
	<td width="15%"><input type="text" name="user" maxlength="30" value="<?php echo $form->value("user"); ?>"></td>
	<td width="75%"><?php echo $form->error("user"); ?></td>
	</tr>
	
	<tr>
	<td>Password:</td>
	<td><input type="password" name="pass" maxlength="30" value="<?php echo $form->value("pass"); ?>"></td>
	<td><?php echo $form->error("pass"); ?></td>
	</tr>
	
	<tr>
	<td>Email:</td>
	<td><input type="text" name="email" maxlength="50" value="<?php echo $form->value("email"); ?>"></td>
	<td><?php echo $form->error("email"); ?></td>
	</tr>
	
	<tr>
	<td colspan="2" align="right">
	<input type="hidden" name="subjoin" value="1">
	<input type="submit" value="Join"></td>
	<td>&nbsp;</td>
	</tr>
	
	<tr>
	<td colspan="3" align="center"><a href="login.php">Back to Login</a></td>
	</tr>
	</table>
	</form>
	<br />
	<?php
}
?>

</div>
</body>
</html>
