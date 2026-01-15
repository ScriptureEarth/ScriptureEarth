<?php
	// Called from Scripture_Add.php in JavaScript function ISOShow(str, ROD_Code, Variant_Code); str=ISO and ROD_Code=ROD_Code and Variant_Code=Variant_Code
	// replaceRODVal.php?iso=" + iso + "&rod=" + ROD_Code + "&ChangeCode=" + ChangeCode

	// ISO (iso), RODCode (Frod), ChangeCode (Trod), CountryCode, Language, Dialect, Location
	
	/*
		FromRODCode to ToRODCode UPDATED (1/2026):
			scripture_main
			nav_ln
			ROD_Dialect
			isop
			all navigational languages
			ISO_countries
			alt_lang_names
			OT_PDF_Media
			OT_Audio_Media
			NT_PDF_Media
			NT_Audio_Media
			watch
			buy
			study
			other_titles
			links
			CellPhone
			PlaylistAudio
			PlaylistVideo
			SAB
			Scripture_and_or_Bible
			viewer
			PlaylistVideo
			PlaylistAudio
	*/

	// The number of failed validations
	$count_failed = 0;

	$audioSet = 0;
	$videoSet = 0;

	if (isset($_GET["iso"])) {
		$iso = trim($_GET["iso"]);
		$iso = preg_replace('/^([a-z]{3})/', '$1', $iso);
		if ($iso == NULL) {
			$count_failed++;
			$messages[] = '“ISO” is empty.';
		}
	}
	else {
		$count_failed++;
		$messages[] = 'No ISO was found.';
	}

	if (isset($_GET["rod"])) {
		$Frod = trim($_GET['rod']);
		$Frod = preg_replace('/^([0-9a-zA-Z]{1,5})/', '$1', $Frod);
		if ($Frod == NULL) {
			// Increments the number of failed validations
			$count_failed++;
			// Adds a message to the message queue.
			$messages[] = "Error. From ROD Code is empty.";
		}
	}
	else {
		$count_failed++;
		$messages[] = 'No ISO was found.';
	}
	
	if (isset($_GET["ChangeCode"])) {
		$Trod = trim($_GET['ChangeCode']);
		$Trod = preg_replace('/^([0-9a-zA-Z]{1,5})/', '$1', $Trod);
		if ($Trod == NULL) {
			// Increments the number of failed validations
			$count_failed++;
			// Adds a message to the message queue.
			$messages[] = "Error. From ROD Code is empty.";
		}
	}
	else {
		$count_failed++;
		$messages[] = 'No ISO was found.';
	}

	// connect to the database 
	include './include/conn.inc.php';
	$db = get_my_db();

	$query="SELECT ROD_Code FROM ROD_Dialect WHERE ISO = '$iso' AND ROD_Code = '$Frod'";
	$result=$db->query($query);
	if (!$result) {
		$count_failed++;
		$messages[] = "Error. The From ROD Code does not exists.";
	}
		
	// If there are no failures, the inputs passed validation
	if ($count_failed == 0) {
		// require_once 'SubmitAddConfirm.php';
		
		/*
				Confirmation
		*/
		
		$query="SELECT * FROM ROD_Dialect WHERE ISO = '$iso' AND ROD_Code = '$Trod'";
		$result=$db->query($query) or die ('Query failed: ' . $db->error . '</body></html>');
		if ($result->num_rows === 0) {																// no - To rod (ChangeCode)
			$query="SELECT * FROM ROD_Dialect WHERE ISO = '$iso' AND ROD_Code = '$Frod'";
			$resultROD=$db->query($query) or die ('Query failed: ' . $db->error . '</body></html>');
			$r = $resultROD->fetch_assoc();
			//$iso = $r['ISO'];
			//$ROD_Code = $r['ROD_Code'];
			$Variant_Code = $r['Variant_Code'];
			$ISO_ROD_index = (int)$r['ISO_ROD_index'];
			$ISO_country = $r['ISO_country'];
			$language_name = $r['language_name'];
			$dialect_name = $r['dialect_name'];
			$location = $r['location'];
			$result=$db->query("INSERT INTO ROD_Dialect (iso, ROD_Code, Variant_Code, ISO_ROD_index, ISO_country, language_name, dialect_name, `location`) VALUES ('$iso', '$Trod', '$Variant_Code', $ISO_ROD_index, '$ISO_country', '$language_name', '$dialect_name', '$location')");
		}
		else {																						// yes - To rod (ChangeCode)
			$r = $result->fetch_assoc();
			//$iso = $r['ISO'];
			//$ROD_Code = $r['ROD_Code'];
			$Variant_Code = $r['Variant_Code'];
			//$ISO_ROD_index = $r['ISO_ROD_index'];
			//$ISO_country = $r['ISO_country'];
			//$language_name = $r['language_name'];
			$dialect_name = $r['dialect_name'];
			$location = $r['location'];
			$query="UPDATE ROD_Dialect SET Variant_Code = '$Variant_Code', dialect_name = '$dialect_name', `location` = '$location' WHERE ISO = '$iso' AND ROD_Code = '$Trod'";
			$result=$db->query($query);
			if (!$result) {
				die('Could not update the ROD_Dialect data: ' . $db->error);
			}
		}

		/****************************************************************************************************
		 * 
		 * 		Update all of the ROD_Code from FromRODCode to ToRODCode
		 * 
		 ****************************************************************************************************/

		$query="UPDATE scripture_main SET ROD_Code = '$Trod' WHERE ISO = '$iso' AND ROD_Code = '$Frod'";
		$result=$db->query($query);
		if (!$result) {
			die('Could not update the "scripture_main": ' . $db->error);
		}
	
		$query="UPDATE isop SET ROD_Code = '$Trod' WHERE ISO = '$iso' AND ROD_Code = '$Frod'";
		$result=$db->query($query);

		$query="UPDATE nav_ln SET ROD_Code = '$Trod' WHERE ISO = '$iso' AND ROD_Code = '$Frod'";
		$result=$db->query($query);
		
		$nav_LN_names = [];											// save all of the LN_... natianal language names
		//$k=1;
		$res=$db->query("SHOW COLUMNS FROM nav_ln WHERE Field LIKE 'LN_%'");
		while ($row_LN = $res->fetch_assoc()) {
			if (preg_match('/^LN_/', $row_LN['Field'])) {
				$query="UPDATE ".$row_LN['Field']." SET ROD_Code = '$Trod' WHERE ISO = '$iso' AND ROD_Code = '$Frod'";
				$result=$db->query($query);
				//$nav_LN_names[$k++] = $row_LN['Field'];			// $nav_LN_names see below
			}
		}
		//foreach($_SESSION['nav_ln_array'] as $code => $array){
		//	$query="UPDATE LN_".$array[1]." SET ROD_Code = '$Trod' WHERE ISO = '$iso' AND ROD_Code = '$Frod'";
		//	$result=$db->query($query);
		//}
	
		$query="UPDATE ISO_countries SET ROD_Code = '$Trod' WHERE ISO = '$iso' AND ROD_Code = '$Frod'";
		$result=$db->query($query);
		
		$query="UPDATE alt_lang_names SET ROD_Code = '$Trod' WHERE ISO = '$iso' AND ROD_Code = '$Frod'";
		$result=$db->query($query);
	
		$query="UPDATE OT_PDF_Media SET ROD_Code = '$Trod' WHERE ISO = '$iso' AND ROD_Code = '$Frod'";
		$result=$db->query($query);

		$query="UPDATE OT_Audio_Media SET ROD_Code = '$Trod' WHERE ISO = '$iso' AND ROD_Code = '$Frod'";
		$result=$db->query($query);
	
		$query="UPDATE NT_PDF_Media SET ROD_Code = '$Trod' WHERE ISO = '$iso' AND ROD_Code = '$Frod'";
		$result=$db->query($query);

		$query="UPDATE NT_Audio_Media SET ROD_Code = '$Trod' WHERE ISO = '$iso' AND ROD_Code = '$Frod'";
		$result=$db->query($query);

		$query="UPDATE watch SET ROD_Code = '$Trod' WHERE ISO = '$iso' AND ROD_Code = '$Frod'";
		$result=$db->query($query);

		$query="UPDATE buy SET ROD_Code = '$Trod' WHERE ISO = '$iso' AND ROD_Code = '$Frod'";
		$result=$db->query($query);

		$query="UPDATE study SET ROD_Code = '$Trod' WHERE ISO = '$iso' AND ROD_Code = '$Frod'";
		$result=$db->query($query);

		$query="UPDATE other_titles SET ROD_Code = '$Trod' WHERE ISO = '$iso' AND ROD_Code = '$Frod'";
		$result=$db->query($query);

		$query="UPDATE links SET ROD_Code = '$Trod' WHERE ISO = '$iso' AND ROD_Code = '$Frod'";
		$result=$db->query($query);

		$query="UPDATE CellPhone SET ROD_Code = '$Trod' WHERE ISO = '$iso' AND ROD_Code = '$Frod'";
		$result=$db->query($query);

		$query="UPDATE PlaylistAudio SET ROD_Code = '$Trod' WHERE ISO = '$iso' AND ROD_Code = '$Frod'";
		$result=$db->query($query);
		if ($db->affected_rows > 0) {
			echo 'PlaylistAudio: Make sure that you rename audio files from ' . $iso . '/audio/' . $Frod . ' to ' . $iso . '/audio/' . $Trod . '.';
			$audio = 1;
		}

		$query="UPDATE PlaylistVideo SET ROD_Code = '$Trod' WHERE ISO = '$iso' AND ROD_Code = '$Frod'";
		$result=$db->query($query);
		if ($db->affected_rows > 0) {
			echo 'PlaylistVideo: Make sure that you rename videa files from ' . $iso . '/video/' . $Frod . ' to ' . $iso . '/video/' . $Trod . '.';
			$video = 1;
		}

		$query="UPDATE SAB SET ROD_Code = '$Trod' WHERE ISO = '$iso' AND ROD_Code = '$Frod'";
		$result=$db->query($query);

		$query="UPDATE Scripture_and_or_Bible SET ROD_Code = '$Trod' WHERE ISO = '$iso' AND ROD_Code = '$Frod'";
		$result=$db->query($query);

		$query="UPDATE viewer SET ROD_Code = '$Trod' WHERE ISO = '$iso' AND ROD_Code = '$Frod'";
		$result=$db->query($query);
		
		// require "'Scripture_Add.php?ISO='.$iso.'&RODCode='.$Trod";		WON'T WORK!
		?>
		<script type="text/javascript" language="javascript">
			<?php
			if ($audio) {
			?>
				alert('PlaylistAudio: Make sure that you rename audio files from <?php echo $iso . '/audio/' . $Frod . ' to ' . $iso . '/audio/' . $Trod; ?>.');
			<?php
			}
			if ($video) {
			?>
				alert('PlaylistVideo: Make sure that you rename videa files from <?php echo $iso . '/video/' . $Frod . ' to ' . $iso . '/video/' . $Trod; ?>.');
			<?php
			}
			?>
			window.open('Scripture_Add.php?iso=<?php echo $iso ?>&rod=<?php echo $Trod ?>', '_parent');
		</script>
		<?php
	}
	
	//require 'Scripture_Add.php?iso='.$iso.'&rod='.$Frod;
	// If "exit" was not here, the form page would be appended to the confirmation page.
	// exit;
?>