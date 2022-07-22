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
include("../include/session.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Registration Page</title>
</head>
<body style="background-color: white; margin: 14pt; font-family: Geneva, Arial, Helvetica, sans-serif; ">
<div style="background-color: white; padding: 20px; width: 800px; margin-left: auto; margin-right: auto; ">

<?php
/**
 * The user is already logged in, not allowed to register.
 */
if($session->logged_in){
   echo "<h1 style='text-align: center; '>Registrado</h1>";
   echo "<p>Lo siento <b>$session->username</b> ya estás registrado. "
       ."<a href=\"login.php\">Principal</a>.</p>";
}
/**
 * The user has submitted the registration form and the
 * results have been processed.
 */
else if(isset($_SESSION['regsuccess'])){
   /* Registration was successful */
   if($_SESSION['regsuccess']){
      echo "<h1>Registrado!</h1>";
      echo "<p>Gracias <b>".$_SESSION['reguname']."</b>. Tus datos han sido agregados a la base de datos "
          ."Ahora puedes iniciar <a href=\"login.php\">sesión</a>.</p>";
   }
   /* Registration failed */
   else{
      echo "<h1 style='text-align: center; '>Registro no fue exitoso</h1>";
      echo "<p>Perdón, hubo un error. Ahora no pudimos completar el registro para el nombre de usuario. <b>".$_SESSION['reguname']."</b>. "
          ."Por favor intenta más tarde.</p>";
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
	echo "<h1 style='text-align: center; '>Registrar</h1>";
	if($form->num_errors > 0){
	   echo "<font size=\"2\" color=\"#ff0000\">".$form->num_errors." error(es) encontrado</font>";
	}
	?>
	<form action="process.php" method="POST">
	<table width="100%" align="left" border="0" cellspacing="0" cellpadding="3">
	<tr>
	<td width="10%">Nombre de usuario:</td>
	<td width="15%"><input type="text" name="user" maxlength="30" value="<?php echo $form->value("user"); ?>"></td>
	<td width="75%"><?php echo $form->error("user"); ?></td>
	</tr>
	
	<tr>
	<td>Contraseña:</td>
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
	<td colspan="3" align="center"><a href="login.php">Volver al Inicio de sesión</a></td>
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
