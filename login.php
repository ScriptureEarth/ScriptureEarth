<?php
/**
 * Login.php
 *
 * Like on most sites
 * the login form doesn't just have to be on the main page,
 * but re-appear on subsequent pages, depending on whether
 * the user has logged in or not.
 *
 * Written by: Jpmaster77 a.k.a. The Grandmaster of C++ (GMC)
 * Last Updated: August 26, 2004
 */
include("include/session.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Login Script</title>
<style>
body { margin: 0; }
.topnav {
	overflow: hidden;
	background-color: white;
	font-size: 13pt;
}
/*Strip the ul of padding and list styling*/
ul {
    list-style-type:none;
    margin:0;
    padding:0;
}
/*Create a horizontal list with spacing*/
li {
    display:inline-block;
    float: left;
}
li a {
	background-color: #E0E0E0;
	float: left;
	display: block;
	color: #0000A0;
	text-align: center;
	padding: 10px 12px;
	margin-left: 6px;
	margin-right: 6px;
	margin-top: 24px;
	margin-bottom: 24px;  
	text-decoration: none;
	border: none;
}
li a:hover {
  background-color: #0000A0;
  color: white;
}
li ul {
	display: none;
    padding: 0;
	margin: 0;
	position: absolute;
	top: 201px;
	height: 0px !important;
}
li ul li {
    display: block;
    float: none;
}
/*Prevent text wrapping*/
li ul li a {
    width: auto;
    min-width: 100px;
    padding: 8px 12px;
	margin-left: 10px;
	background-color: #D5D5FF;
	font-size: 12pt;
	margin-top: 18px;
	margin-bottom: 24px;
	border: none;
}
/*Display the dropdown on hover*/
ul li a:hover + .hidden, .hidden:hover {
    display: block;
}
</style>
</head>
<body style="background-color: #069; margin: 14pt; font-family: Geneva, Arial, Helvetica, sans-serif; ">
<div style="background-color: white; padding: 20px; width: 800px; margin-left: auto; margin-right: auto; border-radius: 15px; -moz-border-radius: 15px; -webkit-box-shadow: 15px; ">
<?php
/**
 * User has already logged in, so display relavent links, including
 * a link to the admin center if the user is an administrator.
 */
if($session->logged_in) {
	echo "<h1 style='text-align: center; '>Logged In</h1>";
	echo "Welcome <b>$session->username</b>. You are logged in.<br /><br />";
	echo "<div class='topnav'>";
		echo "<ul>";
			echo "<li><a href='Scripture_Add.php'>Add to the Database</a></li>";
			echo "<li><a href='Scripture_Edit.php'>Edit the Database</a></li>";
			echo "<li><a href='Scripture_Examine.php'>Examine Scriptoria</a></li>";
			echo "<li><a style='cursor: context-menu; ' href='#'>Search for a ...</a>";
			echo "<ul class='hidden'>";
			echo "<li><a href='JesusFilmAPI.php?video=JesusFilm'>... Jesus Film API videos</a></li>";
			//echo "<li><a style='margin-top: -30px; ' href='JesusFilmAPI.php?video=Magdalena'>... Magdalena video</a></li>";
			echo "</ul></li>";
			echo "<li><a href=\"process.php\">Logout</a></li>";
		echo "</ul>";
	echo "</div>";
	if($session->isAdmin()){
		echo "<div class='topnav'>";
		echo "<ul><li><a href=\"admin/admin.php\">Admin Center</a></li>";
		echo "<li><a href='Scripture_QDelete.php'>Delete record from the Database</a></li>";
		echo "</ul>";
		echo "</div>";
	}
	echo "<div class='topnav'>";
	echo "<ul>";
	echo "<li><a href=\"userinfo.php?user=$session->username\">My Account</a></li>";
	echo "<li><a href=\"useredit.php\">Edit Account</a></li>";
	echo "</ul>";
	echo "</div>";
}
else {
	echo "<h1 style='text-align: center; '>Login</h1>";
	/**
	 * User not logged in, display the login form.
	 * If user has already tried to login, but errors were
	 * found, display the total number of errors.
	 * If errors occurred, they will be displayed.
	 */
	if($form->num_errors > 0) {
	   echo "<font size=\"2\" color=\"#ff0000\">".$form->num_errors." error(s) found</font>";
	}
	?>
	<form action="process.php" method="POST">
	<table width="100%" style="text-align: left; " border="0" cellspacing="0" cellpadding="3">
		<tr>
			<td width="10%">Username:</td>
			<td width="26%"><input type="text" name="user" autofocus maxlength="30" value="<?php echo $form->value("user"); ?>"></td>
			<td width="64%"><?php echo $form->error("user"); ?></td>
		</tr>
		
		<tr>
			<td>Password:</td>
			<td>
				<div class="input-container">
					<input type="password" name="pass" placeholder="Password" required="on" maxlength="30" value="<?php echo $form->value("pass"); ?>">
					<span class="material-icons visibility" style="font-size: 94%; ">show</span>
				</div>
			</td>
			<td><?php echo $form->error("pass"); ?></td>
		</tr>
	
		<tr>
			<td style="padding-top: 24px; " colspan="3"><input type="checkbox" name="remember" <?php if($form->value("remember") != ""){ echo "checked"; } ?>>
				<span style="font-size: 90%; ">Remember me next time</span> &nbsp;&nbsp;&nbsp;&nbsp;
				<input type="hidden" name="sublogin" value="1" />
				<input type="submit" value="Login" />
			</td>
		</tr>
		
	</table>
	</form>
	
	<script>
		const visibilityToggle1 = document.querySelectorAll('.visibility')[0];
		visibilityToggle1.style.cursor = "pointer";
		const input1 = document.querySelectorAll('.input-container input')[0];
		var pass = true;

		visibilityToggle1.addEventListener('click', function() {
			if (pass) {
				input1.setAttribute('type', 'text');
				visibilityToggle1.innerHTML = 'hide';
			} else {
				input1.setAttribute('type', 'password');
				visibilityToggle1.innerHTML = 'show';
			}
			pass = !pass;
		});
	</script>

	<br />
	<?php
}
/**
	
        <tr>
            <td colspan="3" align="left"><br>Not registered? <a href="register.php">Sign-Up</a></td>
        </tr>
		
		<tr>
			<td colspan="3" align="left"><br><font size="2">[<a href="forgotpass.php">Forgot Password?</a>]</font></td>
		</tr>

* Tells how many registered members
 * there are, how many users currently logged in and viewing site,
 * and how many guests viewing site. Active users are displayed,
 * with link to their user information.
 */
echo "<div style=\"text-align: center; \"><br /><br />";
echo "<b>Total Members:</b> ".$database->getNumMembers()."<br>";
echo "There are $database->num_active_users registered members and ";
echo "$database->num_active_guests guests viewing the site.</div><br>";
include("include/view_active.php");
?>

</div>
</body>
</html>
