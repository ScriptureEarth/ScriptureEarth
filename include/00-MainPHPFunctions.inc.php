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
	if (preg_match("/^(All|AllML|EnglishML|SpanishML|PortugueseML|DutchML|FrenchML|GermanML|ChineseML|KoreanML)_?([A-Z]{2}_[a-z]{3}|[A-Z]{2}|_?[a-z]{3}|)_?Counter/", $c)) {		// => ZZ_zzz or _?zzz
		$filename = "counter/" . $c . ".dat";
		if (file_exists($filename)) {
			$count = file($filename);					// doesn't need fclose. reading an array.
			settype($count[0], "integer");				// string to integer
			$count[0]++;								// add a 1
			settype($count[0], "string");				// integer to string
			$exist_count = fopen($filename, "w");
			fputs($exist_count, $count[0]);
			fclose($exist_count);
			if ($display)
				echo ("<div class='counter_Scripture'>" . $count[0] . '&nbsp;' . translate('visits', $st, 'sys') . "</div>");
		}
		else {
			$new_file = fopen($filename, "w");
			fputs($new_file, "1");
			fclose($new_file);
			if ($display)
				echo ("<div class='counter_Scripture'>" . translate('1 visit', $st, 'sys') . "</div>");
		}
	}
	else {
		die('HACKED!');									// a hacker uses a MySQL command or something else!
	}
}


?>