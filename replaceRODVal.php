<?php
	// Called from Scripture_Add.php in JavaScript function ISOShow(str, ROD_Code, Variant_Code); str=ISO and ROD_Code=ROD_Code and Variant_Code=Variant_Code

	// ISO (iso), RODCode (Frod), ChangeCode (Trod), CountryCode, Language, Dialect, Location
	
	/*
		FromRODCode to ToRODCode UPDATED (9/2017):
			scripture_main
			ROD_Dialect
			isop
			LN_English
			LN_Spanish
			LN_Portuguese
			LN_French
			LN_Dutch
			LN_German
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

	if (isset($_GET["iso"])) {
		$iso = trim($_GET["iso"]);
		$iso = preg_replace('/^([a-z]{3})/', '$1', $iso);
		if ($iso == NULL) {
			$count_failed++;
			$messages[] = '�ISO� is empty.';
		}
	}
	else {
		$count_failed++;
		$messages[] = 'No ISO was found.';
	}

	$Frod = trim($_GET['rod']);
	$Trod = trim($_GET['ChangeCode']);

	if ($Frod=="") {
		// Increments the number of failed validations
		$count_failed++;
		// Adds a message to the message queue.
		$messages[] = "Error. From ROD Code is empty.";
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
		if ($result->num_rows <= 0) {																// no Trod
			$query="SELECT * FROM ROD_Dialect WHERE ISO = '$iso' AND ROD_Code = '$Frod'";
			$result=$db->query($query) or die ('Query failed: ' . $db->error . '</body></html>');
			$r = $result->fetch_assoc();
			$iso = $r['ISO'];
			//$ROD_Code = $r['ROD_Code'];
			$Variant_Code = $r['Variant_Code'];
			$ISO_ROD_index = (int)$r['ISO_ROD_index'];
			$ISO_country = $r['ISO_country'];
			$language_name = $r['language_name'];
			$dialect_name = $r['dialect_name'];
			$location = $r['location'];
			$result=$db->query("INSERT INTO ROD_Dialect (iso, ROD_Code, Variant_Code, ISO_ROD_index, ISO_country, language_name, dialect_name, location) VALUES ('$iso', '$Trod', '$Variant_Code', $ISO_ROD_index, '$ISO_country', '$language_name', '$dialect_name', '$location')");
		}
		else {																						// Trod
			$r = $result->fetch_assoc();
			//$iso = $r['ISO'];
			//$ROD_Code = $r['ROD_Code'];
			$Variant_Code = $r['Variant_Code'];
			//$ISO_ROD_index = $r['ISO_ROD_index'];
			//$ISO_country = $r['ISO_country'];
			//$language_name = $r['language_name'];
			$dialect_name = $r['dialect_name'];
			$location = $r['location'];
			$query="UPDATE ROD_Dialect SET Variant_Code = '$Variant_Code', dialect_name = '$dialect_name', location = '$location' WHERE ISO = '$iso' AND ROD_Code = '$Trod'";
			$result=$db->query($query);
			if (!$result) {
				die('Could not update the ROD_Dialect data: ' . $db->error);
			}
		}
		
		$query="UPDATE scripture_main SET ROD_Code = '$Trod' WHERE ISO = '$iso' AND ROD_Code = '$Frod'";
		$result=$db->query($query);
		if (!$result) {
			die('Could not update the "scripture_main": ' . $db->error);
		}
	
		$query="UPDATE isop SET ROD_Code = '$Trod' WHERE ISO = '$iso' AND ROD_Code = '$Frod'";
		$result=$db->query($query);
		
		include './include/nav_ln_array.php';							// Master Array
		foreach($nav_ln_array as $code => $array){
			$query="UPDATE LN_".$array[1]." SET ROD_Code = '$Trod' WHERE ISO = '$iso' AND ROD_Code = '$Frod'";
			$result=$db->query($query);
		}
	
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
		}

		$query="UPDATE PlaylistVideo SET ROD_Code = '$Trod' WHERE ISO = '$iso' AND ROD_Code = '$Frod'";
		$result=$db->query($query);
		if ($db->affected_rows > 0) {
			echo 'PlaylistVideo: Make sure that you rename videa files from ' . $iso . '/video/' . $Frod . ' to ' . $iso . '/video/' . $Trod . '.';
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
			parent.location='Scripture_Add.php?iso=<?php echo $iso ?>&rod=<?php echo $Trod ?>';
		</script>
		<?php
	}
	
	//require 'Scripture_Add.php?iso='.$iso.'&rod='.$Frod;
	// If "exit" was not here, the form page would be appended to the confirmation page.
	// exit;
?>