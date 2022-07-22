<?php 

/******************************************************************************/
/*  Developed by:  Ken Sladaritz                                              */
/*                 Marshall Computer Service                                  */
/*                 2660 E End Blvd S, Suite 122                               */
/*                 Marshall, TX 75672                                         */
/*                 ken@marshallcomputer.net                                   */
/*	Updated by:    Scott Starker                                              */
/*                 SIL Mexico branch                                          */
/*                 Catalina, AZ  85739                                        */
/*                 Scott_Starker@sil.org                                      */
/******************************************************************************/

//require_once '../include/conn.inc.php';
@ include_once './include/conn.inc.php';
if (!function_exists('get_my_db')) {
	@ include_once '../include/conn.inc.php';			// Because of the "view.php".
}
/*
$db = get_my_db();

// get preferred system translation
//$st = 'eng';
if (isset($_GET['st'])) {$st=$_GET['st'];}
$st = preg_replace('/^([a-z]{3})$/', '$1', $st);
if ($st === NULL) {
	die('HACK!</body></html>');
}

$query   = "SELECT * FROM translations WHERE translation_code = '$st' LIMIT 1";
$result  = $db->query($query) or die ($db->error);
$myrow   = $result->fetch_array();
$st_dir  = $myrow['language_direction'];
$preferred_google_code = $myrow['google_code'];
$preferred_google_keyboard = $myrow['google_keyboard'];
*/

// translate phrase
function translate($phrase, string $st=null, $sys) {
	if ($st == null) $st = 'eng';
	$myrow = [];
	$st = preg_replace('/^([a-z]{3}).*/', '$1', $st);
	$db = get_my_db();
	if ($st!='eng') {
		$query  = "SELECT * FROM translations_eng WHERE phrase = '$phrase'";
		$result = $db->query($query) or die ($db->error);
		if ($result->num_rows > 0) {
			$myrow  = $result->fetch_array();
			$query  = "SELECT * FROM translations_".$st." WHERE id = ".$myrow['id'];
			$result = $db->query($query) or die (translate('Query failed:', $st, 'sys') . ' ' . $db->error . '.');
			if ($result->num_rows > 0) {
				$myrow = $result->fetch_array();
				$phrase = $myrow['phrase'];
			}
			//if (isset($myrow['phrase'])) { $phrase = $myrow['phrase']; }
		}
	}
	$phrase = str_replace("'", "`", $phrase);
	return $phrase;
}    

?>