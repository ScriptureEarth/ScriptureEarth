<?php 

/******************************************************************************/
/* mutliple book viewing screen                                               */
/******************************************************************************/
/*  Developed by:  Ken Sladaritz                                              */
/*                 Marshall Computer Service                                  */
/*                 2660 E End Blvd S, Suite 122                               */
/*                 Marshall, TX 75672                                         */
/*                 ken@marshallcomputer.net                                   */
/*                                                                            */
/*  Modified by:   Scott Starker                                              */
/*                 scott_starker@sil.org                                      */
/******************************************************************************/

if (isset($_GET['st'])) {
	$st = $_GET['st'];
	$st = preg_replace('/^([a-z]{3})/', '$1', $st);
	if ($st == NULL) {
		die('Hack!');
	}
}
else {
	 die('Hack!');
}

if (isset($_GET["iso"])) {
	$ISO = $_GET["iso"];
	$ISO = preg_replace('/^([a-z]{3})/', '$1', $ISO);
	if ($ISO == NULL) {
		die('Hack!');
	}
}
else {
	die('Hack!');
}

if (isset($_GET['ROD_Code'])) {
	$ROD_Code = $_GET['ROD_Code'];
	$ROD_Code = preg_replace('/^([a-zA-Z0-9]{0,5})/', '$1', $ROD_Code);
	if ($ROD_Code == NULL) {
		die('Hack!');
	}
}
else {
	die('Hack!');
}

if (isset($_GET['Variant_Code'])) {
	$Variant_Code = $_GET['Variant_Code'];
	if ($Variant_Code != '') {
		$Variant_Code = preg_replace('/^([a-z]?)/', '$1', $Variant_Code);
		if ($Variant_Code == NULL) {
			die('Hack!');
		}
	}
}
else {
	die('Hack!');
}

if (isset($_GET['rtl'])) {
	$rtl = $_GET['rtl'];
	$rtl = preg_replace('/^(0|1)/', '$1', $rtl);
	if ($rtl != '0' && $rtl != '1' && $rtl != NULL) {
		die('Hack!');
	}
}
else {
	 die('Hack!');
}

if (isset($_GET['ROD_Var'])) {
	$ROD_Var = $_GET['ROD_Var'];
	if ($ROD_Var != '') {
		$ROD_Var = preg_replace('/^([-a-zA-Z0-9]{0,15})/', '$1', $ROD_Var);
		if ($ROD_Var == NULL) {
			die('Hack!');
		}
	}
}
else {
	die('Hack!');
}

echo "
<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Frameset//EN\"
   \"http://www.w3.org/TR/html4/frameset.dtd\">
<HTML>
<HEAD>
<TITLE>Scripture viewer</TITLE>
<LINK REL=\"SHORTCUT ICON\" HREF=\"../favicon.ico\">
</HEAD>
	<FRAMESET id=\"mainFrame\" name=\"mainFrame\" cols=\"100%,0%\">
		<FRAME name=\"frame1\" src=\"view.php?iso=".$_GET['iso']."&ROD_Code=".$_GET['ROD_Code']."&Variant_Code=".$_GET['Variant_Code']."&ROD_Var=".$_GET['ROD_Var']."&rtl=".$_GET['rtl']."&st=".$_GET['st']."\" scrolling=\"no\">
		<FRAME name=\"frame2\" src=\"view.php?iso=".$_GET['iso']."&ROD_Code=".$_GET['ROD_Code']."&Variant_Code=".$_GET['Variant_Code']."&ROD_Var=".$_GET['ROD_Var']."&rtl=".$_GET['rtl']."&st=".$_GET['st']."\" scrolling=\"no\">
		<NOFRAMES>
			<p>translate('This browser does not support frames.', st, 'sys')</p>
		</NOFRAMES>
	</FRAMESET>
</HTML>
";

?>