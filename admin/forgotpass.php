<?php
/**
 * ForgotPass.php
 *
 * This page is for those users who have forgotten their
 * password and want to have a new password generated for
 * them and sent to the email address attached to their
 * account in the database. The new password is not
 * displayed on the website for security purposes.
 *
 * Note: If your server is not properly setup to send
 * mail, then this page is essentially useless and it
 * would be better to not even link to this page from
 * your website.
 *
 * Written by: Jpmaster77 a.k.a. The Grandmaster of C++ (GMC)
 * Last Updated: August 26, 2004
 */
include("../include/session.php");
?>

<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Forgot Password</title>
<body>

<?php
/**
 * Forgot Password form has been submitted and no errors
 * were found with the form (the username is in the database)
 */
if(isset($_SESSION['forgotpass'])){
   /**
    * New password was generated for user and sent to user's
    * email address.
    */
   if($_SESSION['forgotpass']){
      echo "<h1>Una nueva contraseña ha sido generada</h1>";
      echo "<p>Ya hemos creado una nueva contraseña para ti. Fue enviado a tu correo. "
          ."<a href=\"login.php\">Iniciar sesión</a>.</p>";
   }
   /**
    * Email could not be sent, therefore password was not
    * edited in the database.
    */
   else{
      echo "<h1>Fallo de nueva contraseña</h1>";
      echo "<p>Había en error. No pudimos enviarte el correo con la nueva contraseña. Por eso, tu contraseña no ha sido cambiada. "
          ."<a href=\"login.php\">Iniciar sesión</a>.</p>";
   }
       
   unset($_SESSION['forgotpass']);
}
else{

/**
 * Forgot password form is displayed, if error found
 * it is displayed.
 */
?>

<h1>Forgot Password</h1>
El sitio va a crear una nueva contraseña para ti y la enviará a tu correo. Tú solamente necesatas entrar tu nombre de usuario.<br><br>
<?php echo $form->error("user"); ?>
<form action="process.php" method="POST">
<b>Nombre de usuario:</b> <input type="text" name="user" maxlength="30" value="<?php echo $form->value("user"); ?>">
<input type="hidden" name="subforgot" value="1">
<input type="submit" value="Get New Password">
</form>

<?php
}
?>

</body>
</html>
