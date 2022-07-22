<?php
	// ISO, ROD_Code, CountryCode, Language, Dialect, Location

	// The number of failed validations
	$count_failed = 0;

	$ISO = trim($_GET['ISO']);
	$ROD_Code = trim($_GET['ROD_Code']);
	$Variant_Code = trim($_GET['Variant_Code']);
	$Variant_Description = trim($_GET['Variant_Description']);

	if ($ROD_Code=="") {
		// Increments the number of failed validations
		$count_failed++;
		// Adds a message to the message queue.
		$messages[] = "Error. ROD Code item(s) is/are empty.";
	}
	
	// connect to the database 
	include './include/conn.inc.php';
	$db = get_my_db();

	// If there are no failures, the inputs passed validation
	if ($count_failed == 0) {
		// require_once 'SubmitAddConfirm.php';
		// Confirmation
		
		// require "'Scripture_Add.php?ISO='.$ISO.'&RODCode='.$RODCode";		WON'T WORK!
		?>
		<script type="text/javascript" language="javascript">
			parent.location='Scripture_Add.php?ISO=<?php echo $ISO ?>&ROD_Code=<?php echo $ROD_Code ?>&Variant_Code=<?php echo $Variant_Code ?>&Variant_Description=<?php echo $Variant_Description ?>';
		</script>
		<?php
	}
	
	?>
	<script type="text/javascript" language="javascript">
		parent.location='Scripture_Add.php?ISO=<?php echo $ISO ?>&ROD_Code=<?php echo $ROD_Code ?>';
	</script>
	<?php
	// require ('Scripture_Add.php?ISO='.$ISO.'&ROD_Code='.$ROD_Code.'&CountryCode='.$CountryCode.'&Language='.$Language.'&Dialect='.$Dialect.'&Location='.$Location);
	// If exit was not here, the form page would be appended to the confirmation page.
	// exit;
?>