<?php
	// ISO (iso), ROD_Code (rod), CountryCode, Language, Dialect (the ISO's languaage name), Location

	// The number of failed validations
	$count_failed = 0;

	if (isset($_GET['iso'])) $iso = trim($_GET['iso']); else $iso = '';
	if (isset($_GET['rod'])) $rod = trim($_GET['rod']); else $rod = '';
	if (isset($_GET['CountryCode'])) $CountryCode = trim($_GET['CountryCode']); else $CountryCode = '';
	if (isset($_GET['Language'])) $Language = trim($_GET['Language']); else $Language = '';
	if (isset($_GET['Dialect'])) $Dialect = trim($_GET['Dialect']); else $Dialect = '';
	if (isset($_GET['Location'])) $Location = trim($_GET['Location']); else $Location = '';
	

	if ($iso=='' || $rod=="" || $CountryCode=="" || $Language=="" || $Location=="" || $Dialect=="") {
		// Increments the number of failed validations
		$count_failed++;
		// Adds a message to the message queue.
		die("Error. ROD Code item(s) is/are empty.");
	}
	
	$iso = strtolower(substr($iso, 0, 3));
	$rod = preg_replace("/^([0-9a-zA-Z]{1,5}).*/", "$1", $rod);
	$CountryCode = strtoupper(substr($CountryCode, 0, 2));

	// connect to the database 
	include './include/conn.inc.php';
	$db = get_my_db();

	$query="SELECT ISO_Country FROM countries WHERE ISO_Country = '$CountryCode'";
	$result=$db->query($query);
	$num = $result->num_rows;
	if (!$result || $num <= 0) {
		$count_failed++;
		die("Error. Country Code was not found.");
	}
	
	$query="SELECT ROD_Code FROM ROD_Dialect WHERE ISO = '$iso' AND ROD_Code = '$rod'";
	$result=$db->query($query);
	$num = $result->num_rows;
	if ($result && $num > 0) {
		$count_failed++;
		die("Error. The ROD Code already exists.");
	}
		
	// If there are no failures, the inputs passed validation
	if ($count_failed == 0) {
		// Confirmation
        $Location = $db->real_escape_string($Location);
		$query="INSERT INTO ROD_Dialect (ISO, ROD_Code, Variant_Code, ISO_country, language_name, dialect_name, location) VALUES ('$iso', '$rod', '', '$CountryCode', '$Language', '$Dialect', '$Location')";
		$result=$db->query($query);
		if ($db->affected_rows > 0) {
			?>
			<script type="text/javascript" language="javascript">
				top.location='Scripture_Add.php?iso=<?php echo $iso ?>&rod=<?php echo $rod ?>&CountryCode=<?php echo $CountryCode ?>&Language=<?php echo $Language ?>&Dialect=<?php echo $Dialect ?>&Location=<?php echo $Location ?>';
				// echo '<option style="font-size: 10pt; font-weight: bold; color: navy; " value="'.$rod.'" selected>'.$rod.' '.$Dialect.'; '.$Location.'</option>';		// wont work
			</script>
			<?php
			exit(0);
		}
		else {
			// die('Could not insert the ROD_Dialect data: ' . $db->error);
			die("Could not insert the ROD_Dialect table data: " . $db->error);
		}
	}
	
	?>
	<script type="text/javascript" language="javascript">
		parent.location='Scripture_Add.php?iso=<?php echo $iso ?>&rod=<?php echo $rod ?>&CountryCode=<?php echo $CountryCode ?>&Language=<?php echo $Language ?>&Dialect=<?php echo $Dialect ?>&Location=<?php echo $Location ?>';
	</script>
	<?php
	// require ('Scripture_Add.php?iso='.$iso.'&rod='.$rod.'&CountryCode='.$CountryCode.'&Language='.$Language.'&Dialect='.$Dialect.'&Location='.$Location);
	// If exit was not here, the form page would be appended to the confirmation page.
	// exit(0);
?>