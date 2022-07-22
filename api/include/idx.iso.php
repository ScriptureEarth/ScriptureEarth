<?php
if (isset($_GET['idx'])) {																		// ISO_ROD_Code
	$idx = (int)$_GET['idx'];
	$temp = preg_match('/^([0-9]*)/', $idx, $match);
	if ($temp == 0) {
		die ('HACK!');
	}
	$idx = (int)$match[1];
	$index = 1;																					// $index = 1
}
elseif (isset($_GET['iso'])) {																	// or ISO
	$iso = $_GET['iso'];
	if ($iso == 'ALL') {
		$rod = 'ALL';
		$var = 'ALL';
	}
	else {
		$temp = preg_match('/^([a-z]{3})/', $iso, $match);
		if ($temp == 0) {
			die ('HACK!');
		}
		$iso = $match[1];
		if (isset($_GET['rod'])) {																	// ROD_Code
			$rod = $_GET['rod'];
			$temp = preg_match('/^([0-9a-zA-Z]{0,5})/', $rod, $match);
			if ($temp == 0) {
				$rod = '00000';
			}
			else {
				$rod = $match[1];
			}
		}
		else {
			$rod = 'ALL';
		}
		if (isset($_GET['var'])) {																	// Variant_Code
			$var = $_GET['var'];
			$temp = preg_match('/^([a-zA-Z])/', $var, $match);
			if ($temp == 0) {
				$var = '';
			}
			else {
				$var = $match[1];
			}
		}
		else {
			$var = 'ALL';
		}
	}
	$index = 2;																					// $index = 2;
}
?>