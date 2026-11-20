<?php
function OT_Test($PDF, $OT_Index) {						// returns true if the Book is part of the OT
	global $OT_array;									// from OT_Books.php
	
	$a_index = 0;
	foreach ($OT_array[$OT_Index] as $a) {
		if ($PDF == $a_index) return true;
		$a_index++;
	}
	return false;
}

function NT_Test($PDF, $NT_Index) {						// returns true if the Book is part of the NT
	global $NT_array;									// from NT_Books.php
	
	$a_index = 0;
	foreach ($NT_array[$NT_Index] as $a) {
		if ($PDF == $a_index) return true;
		$a_index++;
	}
	return false;
}

function check_input($value) {							// used for ' and " that find it in the input
	$value = trim($value);
	if (is_string($value)) {
		$value = implode("", explode("\\", $value));	// get rid of e.g. "\\\\\\\\\\\"
		$value = stripslashes($value);
	}
	// Quote if not a number
	if (!is_numeric($value)) {
		$db = get_my_db();
		$value = $db->real_escape_string($value);
	}
	return $value;
}

function Counter($c, $display = false) {				// $c = AllCounter or ... counter
	global $st;
	//$pos = strpos($c, ' ');							// $c is not suppossed to have a space within it 
	//if ($pos === false) {								// not found
	if (preg_match("/^(All|AllML|EnglishML|SpanishML|PortugueseML|DutchML|FrenchML|GermanML|ChineseML|KoreanML|RussianML|ArabicML)_?([A-Z]{2}_[a-z]{3}|[A-Z]{2}|[a-z]{3}|[A-Z]{2}[0-9]{2}|[A-Z]{2}_[A-Z]{2}[0-9]{2}|)_?Counter/", $c)) {		// => ZZ_zzz or zzz or ZZ99 or empty
		$filename = "counter/" . $c . ".dat";
		if (file_exists($filename)) {
			clearstatcache(true, $filename);
			$count = fopen($filename, "r+");
			//echo '1 !'.$filename.'!<br />';
			flock($count, LOCK_EX);
			$count_value = (int) fread($count, 1024);
			$count_value++;
			rewind($count);
			fwrite($count, (string) $count_value);
			fflush($count);
			flock($count, LOCK_UN);
			fclose($count);
			if ($display) {
				//echo (string) $count_value . '<br />';
				echo "<div class='counter_Scripture'>" . $count_value . '&nbsp;' . translate('visits', $st, 'sys') . "</div>";
			}
		}
		else {
			$new_file = fopen($filename, "w");
			//echo '2 !'.$filename.'!<br />';
			fwrite($new_file, "1");
			fclose($new_file);
			if ($display) {
				echo "<div class='counter_Scripture'>" . translate('1 visit', $st, 'sys') . "</div>";
			}
		}
	}
	else {
		die('HACKED!');									// a hacker uses a MySQL command or something else!
	}
}


?>