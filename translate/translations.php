<?php

/*
	0) Create the translations table (see below).
	1) You will need to have the script phrases in English in all the php files in the 'build_phrases()' (see below).
	2) Run this script (translations.php).
	3) The script creates the English language table and displays the English phrases.
	4) Fill out the whole page. Eg.
		Translation language code: dut
		Translation language name: Dutch
		...
	5) Click on 'Accept Record' to save the record.
	6) All of the phrases in English will be displayed.
	7) Click on 'Translate all Records'.
	8) Make the additions in the 'Dutch' column.
	when you have finished all of the records
	9) Click on 'Accept All Records' to save the dutch records.
	10) To display Dutch in other scripts: include "../translate/functions.php";
	11) Place $s t = "dut"; in the script you want to display Dutch AFTER include "../translate/functions.php";.
	12) Place translat e('phrase in English', $s t, 'sys') wherever you want to display Dutch.
*/

// Be very care in that the translate function in phrase has to begin and end with ' and
// there must be a space in the middle of , and $s t.
// Don't use any preceding and ending spaces in 'phrase'.
// For example: translat e('phrase in English', $s t, 'sys')

/******************************************************************************/
/* system translations                                                        */
/******************************************************************************/
/*  Developed by:  Ken Sladaritz                                              */
/*                 Marshall Computer Service                                  */
/*                 2660 E End Blvd S, Suite 122                               */
/*                 Marshall, TX 75672                                         */
/*                 ken@marshallcomputer.net                                   */
/*																			  */
/*	Documentation by:  Scott Starker										  */
/*					   scott_starker@sil.org								  */
/******************************************************************************/

/*
Creates the translations table of all of the languages.

CREATE TABLE `scripture`.`translations` ( 
`translation_code` varchar(3) NOT NULL ,
`name` varchar(50) NOT NULL ,
`google_code` varchar(10) NOT NULL ,
`google_keyboard` varchar(20) NOT NULL ,
`language_direction` varchar(3) NOT NULL ,
PRIMARY KEY (`translation_code`) 
) ENGINE=MYISAM DEFAULT CHARSET = latin1;

*/

include "functions.php";

// directories to search for scripts
$query  = "UPDATE translations_eng SET active = '0'";
mysql_query($query) or die (mysql_error());
echo "<div style='font-size: 14pt; font-weight: bold; '>Beginning the subfolder '../00-...' and '../00i-...':</div>";
build_phrases('../');
echo "<div style='font-size: 14pt; font-weight: bold; '>Ending the subfolder '../'.</div>";
//echo "<div style='font-size: 14pt; font-weight: bold; '>Beginning the subfolder 'translate'...</div>";
//build_phrases('../translate/');
//echo "<div style='font-size: 14pt; font-weight: bold; '>Ending the subfolder 'translate'.</div>";
echo "<div style='font-size: 14pt; font-weight: bold; '>Beginning the subfolder '../viewer', '../Feedback' and '../include':</div>";
build_phrases('../viewer/');
build_phrases('../Feedback/');
build_phrases('../include/');
echo "<div style='font-size: 14pt; font-weight: bold; '>Ending the subfolder '../viewer', '../Feedback' and '../include'.</div>";
echo "<br />";

// Fixes the encoding to utf8
function fixEncoding($in_str) {
	$cur_encoding = mb_detect_encoding($in_str);
	if($cur_encoding == "UTF-8" && mb_check_encoding($in_str,"UTF-8")) {
		return $in_str;
	} else {
		return utf8_encode($in_str);
	}
}

// find translate phrases in scripts
function build_phrases($dir) {
	$scripts = scandir($dir);									// get a directory of the file in dir
	foreach ($scripts as $script) {								// take 1 filename each from the directory
		if ((strtolower(substr($script,-4))=='.php')) {
			if ($script[0] == 'z' || $script == 'functions.php') {							// find the first character of string
				//echo $script . " skipped" . "<br />";
				continue;
			}
			if (($dir == '../' && substr($script, 0, 4) != '00i-') && ($dir == '../' && substr($script, 0, 3) != '00-')) {
				//echo $script . " skipped" . "<br />";
				continue;
			}
			echo "<b>".$script."</b><br />";
			//$strings = explode("translate(", file_get_contents($dir.$script));	// generate a strings array (explode) for 'translate(' of the file dir.script
			// before it was translate\(['\"].*, *[a-z$][a-z][a-z], *['\"]sys['\"]\)
			preg_match_all("/translate\(['\"][^,]+['\"], [$][a-z][a-z], ['\"]sys['\"]\)/", file_get_contents($dir.$script), $strings);
			//print_r($strings[0]);
			foreach ($strings[0] as $string) {								// get the string from strings
			//print_r($string);
				$string = substr($string, 10);
				//echo $string."<br />";
				//echo $string."&nbsp;".strpos($string, '$st, '."'sys'")."<br />";
				if (strpos($string, '$st, '."'sys'") !== false)	{		// get the string position
					//list($phrase, $nu) = explode(', $st,', $string);	// get phrase as it exists before ', $st,'
					$phrase = strstr($string, ', $st,', TRUE);
					$phrase = trim($phrase, "'");						// trim off the first '
					// skip language names
					$skip = false;
					if (stripos($phrase, '$myrow') !== false) {$skip = true;}
					if (stripos($phrase, '$_POST') !== false) {$skip = true;}
					if (stripos($phrase, '$name') !== false) {$skip = true;}
					if (stripos($phrase, '$translation[') !== false ) {$skip = true;}
					if (!$skip) {
						$phrase=fixEncoding($phrase);
						//$phrase=mysql_real_escape_string($phrase); //for making ' to \'
						//$phrase=addcslashes($phrase, '%_'); //for making % to \% and _ to \_
						echo $phrase."<br />";
						$query  = "SELECT * FROM translations_eng WHERE phrase = \"".$phrase."\" ";
						$result = mysql_query($query) or die (mysql_error());
						$myrow  = mysql_fetch_array($result);
						if($myrow) {
							$query  = "UPDATE translations_eng SET active = '1' WHERE phrase = \"".$phrase."\" ";
							mysql_query($query) or die (mysql_error());
							$query  = "SELECT * FROM translations_eng WHERE phrase = \"".$phrase."\" ";
							$result = mysql_query($query) or die (mysql_error());
							//$num=mysql_num_rows($result);
							//echo mysql_result($result,0,"active");
						}
						else {
							$query  = "INSERT INTO translations_eng SET active = '1', phrase = '$phrase'";
							mysql_query($query) or die (mysql_error());
						}
					}
					else echo $phrase . "skipped<br />";
				}
			}
		}   
	}
}

// html header
echo<<<END
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="text/html; charset=utf-8" http-equiv="content-type" />
<title>translations</title>
<link rel="SHORTCUT ICON" href="../favicon.ico" />
<link type="text/css" rel="stylesheet" href="../viewer/style.css" />
<script src="http://microsofttranslator.com/ajax/v3/widgetv3.ashx" type="text/javascript"></script>
</head>
<body>
<form id='form1' name='form1' action="" method="post">
END;

if (isset($_POST['devent']) && $_POST['devent'] == 'sname') {
	$query = "SELECT * FROM translations WHERE translation_code = \"".$_POST['scode']."\" LIMIT 1";
	$result_st = mysql_query($query) or die (mysql_error());
	$myrow_st  = mysql_fetch_array($result_st);
	$_POST['dcode'] = $myrow_st['translation_code'];
	$_POST['dname'] = $myrow_st['name'];
	$_POST['dgoogle_code'] = $myrow_st['google_code'];
	$_POST['dgoogle_keyboard'] = $myrow_st['google_keyboard'];
	$_POST['dlanguage_direction'] = $myrow_st['language_direction'];
	// language index
	$query = "SELECT * FROM translations_".$_POST['dcode']." WHERE id = 99999";
	$result = mysql_query($query) or die (mysql_error());
	$myrow  = mysql_fetch_array($result);
	$_POST['dcharIndex'] = $myrow['phrase'];
}

if (isset($_POST['devent']) && $_POST['devent'] == "delete" && $_POST['dcode']) {
	$result=@mysql_query ("DELETE FROM translations WHERE translation_code = \"".$_POST['dcode']."\" LIMIT 1");
	$myrow=@mysql_fetch_array($result);
	$_POST['devent'] = "clear";  
	$query = "DROP TABLE `translations_".$_POST['dcode']."`";
	mysql_query($query);		// or die (mysql_error());
	$submit_message = translate('Record deleted successfully', $st, 'sys');
}

if (isset($_POST['devent']) && $_POST['devent'] == "clear") {
	$_POST['dcode'] = '';
	$_POST['dname'] = '';
	$_POST['dcharIndex'] = '';
	$_POST['dgoogle_code'] = '';
	$_POST['dgoogle_keyboard'] = '';
	$_POST['dlanguage_direction'] = '';
}

if (isset($_POST['dname']) && $_POST['dname'])
{
 if (isset($_POST['devent']) && $_POST['devent'] == "accept") 
 {
  $query  = "SELECT * FROM translations WHERE translation_code = \"".$_POST['dcode']."\" LIMIT 1";
  $result = mysql_query($query) or die (mysql_error());
  $myrow  = mysql_fetch_array($result);
  if ($myrow)
  {
   $query = 
   "UPDATE translations SET
     name                = '".$_POST['dname']."',
     google_code         = '".$_POST['dgoogle_code']."',
     google_keyboard     = '".$_POST['dgoogle_keyboard']."',
     language_direction  = '".$_POST['dlanguage_direction']."'
    WHERE translation_code = \"".$_POST['dcode']."\"
    LIMIT 1";
   mysql_query($query) or die (mysql_error());

   // language index
   $query = 
   "UPDATE translations_".$_POST['dcode']." SET
     phrase = '".$_POST['dcharIndex']."'
     WHERE id = 99999
   ";
   mysql_query($query) or die (mysql_error()); 
  }
 
  if(!$myrow)
  {
   $query = 
   "INSERT INTO translations SET
    translation_code    = '".$_POST['dcode']."',
    name                = '".$_POST['dname']."',
    google_code         = '".$_POST['dgoogle_code']."',
    google_keyboard     = '".$_POST['dgoogle_keyboard']."',
    language_direction  = '".$_POST['dlanguage_direction']."'
   ";
   mysql_query($query) or die (mysql_error()); 

   $query =
   "CREATE TABLE `translations_".$_POST['dcode']."` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,   
    `phrase` TEXT NOT NULL ) TYPE = MYISAM ;
   ";
   mysql_query($query) or die (mysql_error()); 
  }


  // update translated phrases
  foreach($_POST['phrase'] as $id=>$phrase)
  {
    $query  = "SELECT * FROM translations_".$_POST['dcode']." WHERE id = \"".$id."\" ";
    $result = mysql_query($query) or die (mysql_error());
    $myrow  = mysql_fetch_array($result);
    if($myrow)
    {
     if($phrase)
     {
      $query  = "UPDATE translations_".$_POST['dcode']." SET phrase = \"".$phrase."\" WHERE id = \"".$id."\" ";
      $result = mysql_query($query) or die (mysql_error());
     }
     else
     {
      $query = "DELETE FROM translations_".$_POST['dcode']." WHERE id = \"".$id."\" LIMIT 1";
      $result = mysql_query ($query);
     }
    }
    else
    {
     if($phrase and $phrase!=$myrow['phrase'])
     {
      $query  = 
      "INSERT INTO translations_".$_POST['dcode']." SET 
        phrase = \"".$phrase."\", 
        id = \"".$id."\" ";
      $result = mysql_query($query);
     }
    }
  }
  $submit_message = translate('Record updated successfully', $st, 'sys');
  $_POST['dcode'] = '';
  $_POST['dname'] = '';
  $_POST['dcharIndex'] = '';
  $_POST['dgoogle_code'] = '';
  $_POST['dgoogle_keyboard'] = '';
  $_POST['dlanguage_direction'] = '';
 }
}

// initialize english phrases to be translated
// create translation_eng table if it doesnot exist
$query =
"CREATE TABLE IF NOT EXISTS `translations_eng` (
 `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,   
 `phrase` TEXT NOT NULL,   
 `active` VARCHAR(1) NOT NULL ) ENGINE = MYISAM ;
";
mysql_query($query) or die (mysql_error()); 

//$query  = "UPDATE translations_eng SET active = 0";			// doesn't work -- Scott Starker
//$result = mysql_query($query) or die (mysql_error());

$query  = 
"SELECT LN_English FROM LN_English
 WHERE ISO = \"".$_POST['dcode']."\"
 LIMIT 1";
$result_st = mysql_query($query) or die (mysql_error());
$myrow_st  = mysql_fetch_array($result_st);
if(isset($_POST['dname']) && !$_POST['dname']) {$_POST['dname'] = $myrow_st['LN_English'];}

// add language names to translations
$t = array();
$query  = "SELECT * FROM translations ORDER BY name";
$result_t = mysql_query($query) or die (mysql_error());
while ($myrow_t=mysql_fetch_array($result_t))
	{$t[] = $myrow_t['name'];}
$t[] = $_POST['dname'];
print_r($t);
foreach ($t as $name) {
	$query  = "SELECT * FROM translations_eng WHERE phrase = \"".$name."\" ";
	$result = mysql_query($query) or die (mysql_error());
	$myrow  = mysql_fetch_array($result);
	if($myrow) {
		$query  = "UPDATE translations_eng SET active = 1 WHERE phrase = \"".$name."\" ";
		mysql_query($query) or die (mysql_error());
	}
	else {
		$query  = "INSERT INTO translations_eng SET active = 1, phrase = \"".$name."\" ";
		mysql_query($query);
	}
}

// build translation table entries
if(isset($_POST['dcode']) && $_POST['dcode'])
{
 $tr_translations = '';
 $kbd_fields = '';
 if($_POST['dcode']=='eng')
 {
  $tr_translations = 'English is the base language, no translation is required.';  
 }
 else
 { 
  $query  = "SELECT * FROM translations_eng WHERE active = 1";
  $result = mysql_query($query) or die (mysql_error());
  while ($myrow=mysql_fetch_array($result))
  {
   if($_POST['dcode']!='eng')
   {
    $query  = "SELECT * FROM translations_".$_POST['dcode'] ." WHERE id = \"".$myrow['id']."\" ";
    $result_alt = mysql_query($query); // or die (mysql_error());
    $myrow_alt  = mysql_fetch_array($result_alt);

    if($_POST['devent']=='translate' and !$myrow_alt['phrase'])
    {
     $content = file_get_contents('http://ajax.googleapis.com/ajax/services/language/translate?v=1.0&q='.rawurlencode($myrow['phrase']).'&langpair=en%7C'.$_POST['dgoogle_code']);
     $content = json_decode($content);
     $myrow_alt['phrase'] = $content->{'responseData'}->{'translatedText'};
    }
    $tr_translations .= "
    <tr>
     <td>".$myrow['phrase']."</td>
     <td>
      <input id=\"phrase[".$myrow['id']."]\" name=\"phrase[".$myrow['id']."]\" value=\"".$myrow_alt['phrase']."\" size=50 dir=\"".$_POST['dlanguage_direction']."\">
    ";
 
    if($_POST['dgoogle_code'])
    {
    //***************************************************************************
    // Translate button!
    //***************************************************************************
     $tr_translations .= "
      <input type=\"button\" value=\"".translate('Translate', $st, 'sys')."\" onclick=\"translate_this('".$myrow['phrase']."', 'phrase[".$myrow['id']."]', '".$_POST['dgoogle_code']."')\">
     ";
    }

    $tr_translations .= "
     </td>
    </tr>
    ";
    $kbd_fields .= "'phrase[".$myrow['id']."]',";
   }
   else
   {
    $tr_translations .= "<tr><td>". $myrow['phrase']."</td><td>&nbsp;</td></tr>";
   }
  }
  if($tr_translations)
  {
   $tr_translations = " 
   <table style=\"width:100%\" border>
    <tr>
     <th style=\"width:50%\"> ".translate('English', $st, 'sys')." </th>
     <th style=\"width:50%\"> ".translate($_POST['dname'], $st, 'sys')." </th>
    </tr>
    $tr_translations
   </table> 
   ";
  }   
 }
 if($_POST['devent']=='translate') {$submit_message = translate('Translation finished', $st, 'sys');}
}


$sname_options = "";
$query  = "SELECT * FROM translations ORDER BY name";
$result = mysql_query($query) or die (mysql_error());
while ($myrow=mysql_fetch_array($result))
{$sname_options .= "<option value=\"". $myrow['translation_code']."\">".$myrow['translation_code']." ~ ".translate($myrow['name'], $st, 'sys');}


$output = "
<script language='JavaScript'>

f = document.forms[0];

function sname_func() {
	f.devent.value='sname';
	f.submit();
}

function clear_func() {
	f.devent.value='clear';
	f.submit();
}

function translate_func() {
	if (f.dcode.value=='eng') {alert('".translate('Cannot translate the base language.', $st, 'sys')."'); return false;}
	var answer = confirm ('".translate('This function will translate all the blank fields using Google translate API.', $st, 'sys').".\\r\\r".translate('Are you sure?', $st, 'sys')."');
	if (!answer) {return false;}
	f.devent.value='translate';
	f.submit();
}

function delete_func() {
	if (f.dcode.value=='eng') {alert('".translate('Cannot delete the base language.', $st, 'sys')."'); return false;}
	var answer = confirm ('".translate('You are about to permanently delete this record and ALL translations for the selected language.', $st, 'sys').".\\r\\r".translate('Are you sure?', $st, 'sys')."');
	if (!answer) {return false;}
	f.devent.value='delete';
	f.submit();
}

function accept_func() {
	errmsg = ''; 
	if (!f.dcode.value) {errmsg += '".translate('Language code is required.', $st, 'sys')."\\n';}
	if (!f.dname.value) {errmsg += '".translate('Language name is required.', $st, 'sys')."\\n';}
	if (errmsg) {
		alert(errmsg);
		return false;
	}
	f.devent.value='accept';
	f.submit();
}

function dcode_change() {
	f.devent.value='dcode';
	f.submit();
}
";

$output .= "
function onload_func() {
	f.dlanguage_direction.value = '".$_POST['dlanguage_direction']."';
	f.dgoogle_code.value = '".$_POST['dgoogle_code']."';
	f.dgoogle_keyboard.value = '".$_POST['dgoogle_keyboard']."';
";

if(isset($_POST['dgoogle_keyboard']) && $_POST['dgoogle_keyboard']) {
	$output .= "
	  var kbd = new google.elements.keyboard.Keyboard(
	  [google.elements.keyboard.LayoutCode.".strtoupper($_POST['dgoogle_keyboard'])."],
	  ['dcharIndex',".$kbd_fields."]);
	";
 }

$output .= "
}
window.onload = onload_func;

function translate_this(phrase, fld, lc) {
	google.language.translate(phrase, \"en\", lc, function(result) {
		if (!result.error) {
			var translated = document.getElementById(fld);
			translated.value = result.translation;   
		}
	});
}

</script>

<script type=\"text/javascript\" src=\"http://www.google.com/jsapi\"></script> 
<script type=\"text/javascript\">
	google.load(\"language\", \"1\");
	google.load(\"elements\", \"1\", {packages: \"keyboard\"});
</script> 

  <span style=\"height: 400px; \">

  <p><h2>".translate('Manage Available Interface Translations', $st, 'sys')."</h2>
  <table>
   <tr>
    <td> ".translate('Translation language code', $st, 'sys')." </td>
    <td> <input name=\"dcode\" value=\"".$_POST['dcode']."\"  maxLength=3 size=4 onchange=\"dcode_change(); data_change.value='Y';\"> 
     <select name=\"scode\" onchange=sname_func();>
      <option value=\"select\">--".translate('select current language', $st, 'sys')." -- ".$sname_options."
     </select>
    </td>
   </tr> 
   <tr>
    <td> ".translate('Translation language name', $st, 'sys')." </td>
    <td> <input id=\"dname\" name=\"dname\" value=\"".$_POST['dname']."\" size=50 onchange=\"data_change.value='Y'\"> </td>
   </tr> 
   <tr>
    <td> ".translate('Character Index', $st, 'sys')." </td>
    <td> <input id=\"dcharIndex\" name=\"dcharIndex\" value=\"".$_POST['dcharIndex']."\" size=100 onchange=\"data_change.value='Y'\" dir=\"".$_POST['dlanguage_direction']."\"> </td>
   </tr> 
   <tr>
    <td> ".translate('Language direction', $st, 'sys')." </td>
    <td>
     <select name=\"dlanguage_direction\" onchange=\"data_change.value='Y'\">
      <option>
      <option value=\"ltr\"> ltr
      <option value=\"rtl\"> rtl
     </select>
    </td> 
   </tr> 
   <tr> 
    <td> Bing ".translate('language code', $st, 'sys')." </td>
    <td>
     <select name=\"dgoogle_code\" onchange=\"data_change.value='Y'\">
      <option>
      <option value=\"ar\">Arabic
      <option value=\"bg\">Bulgarian
      <option value=\"ca\">Catalan
      <option value=\"zh-CHS\">Chinese_Simplified
      <option value=\"zh-CHT\">Chinese_Traditional
      <option value=\"cs\">Czech
      <option value=\"da\">Danish
      <option value=\"nl\">Dutch
      <option value=\"en\">English
      <option value=\"et\">Estonian
      <option value=\"fi\">Finnish
      <option value=\"fr\">French
      <option value=\"de\">German
      <option value=\"el\">Greek
      <option value=\"ht\">Haitian_Creole
      <option value=\"he\">Hebrew
      <option value=\"hi\">Hindi
      <option value=\"mww\">Hmong_Daw
      <option value=\"hu\">Hungarian
      <option value=\"id\">Indonesian
      <option value=\"it\">Italian
      <option value=\"ja\">Japanese
      <option value=\"tlh\">Klingon
      <option value=\"tlh-Qaak\">Klingon_(pIqaD)
      <option value=\"ko\">Korean
      <option value=\"lv\">Latvian
      <option value=\"lt\">Lithuanian
      <option value=\"ms\">Malay
      <option value=\"mt\">Maltese
      <option value=\"no\">Norwegian
      <option value=\"fa\">Persian
      <option value=\"pl\">Polish
      <option value=\"pt\">Portuguese
      <option value=\"ro\">Romanian
      <option value=\"ru\">Russian
      <option value=\"sk\">Slovak
      <option value=\"sl\">Slovenian
      <option value=\"es\">Spanish
      <option value=\"sv\">Swedish
      <option value=\"th\">Thai
      <option value=\"tr\">Turkish
      <option value=\"uk\">Ukrainian
      <option value=\"ur\">Urdu
      <option value=\"vi\">Vietnamese
      <option value=\"cy\">Welsh
     </select>
    </td>
   </tr>
   </tr> 
    <td> Bing ".translate('keyboard code', $st, 'sys')." </td>
    <td>
     <select name=\"dgoogle_keyboard\" onchange=\"data_change.value='Y'\">
      <option>
      <option value=\"Arabic\">Arabic
      <option value=\"Bulgarian\">Bulgarian
      <option value=\"Catalan\">Catalan
      <option value=\"Chinese_Simplified\">Chinese_Simplified
      <option value=\"Chinese_Traditional\">Chinese_Traditional
      <option value=\"Czech\">Czech
      <option value=\"Danish\">Danish
      <option value=\"Dutch\">Dutch
      <option value=\"English\">English
      <option value=\"Estonian\">Estonian
      <option value=\"Finnish\">Finnish
      <option value=\"French\">French
      <option value=\"German\">German
      <option value=\"Greek\">Greek
      <option value=\"Haitian_Creole\">Haitian_Creole
      <option value=\"Hebrew\">Hebrew
      <option value=\"Hindi\">Hindi
      <option value=\"Hmong_Daw\">Hmong_Daw
      <option value=\"Hungarian\">Hungarian
      <option value=\"Indonesian\">Indonesian
      <option value=\"Italian\">Italian
      <option value=\"Japanese\">Japanese
      <option value=\"Klingon\">Klingon
      <option value=\"Klingon_(pIqaD)\">Klingon_(pIqaD)
      <option value=\"Korean\">Korean
      <option value=\"Latvian\">Latvian
      <option value=\"Lithuanian\">Lithuanian
      <option value=\"Malay\">Malay
      <option value=\"Maltese\">Maltese
      <option value=\"Norwegian\">Norwegian
      <option value=\"Persian\">Persian
      <option value=\"Polish\">Polish
      <option value=\"Portuguese\">Portuguese
      <option value=\"Romanian\">Romanian
      <option value=\"Russian\">Russian
      <option value=\"Slovak\">Slovak
      <option value=\"Slovenian\">Slovenian
      <option value=\"Spanish\">Spanish
      <option value=\"Swedish\">Swedish
      <option value=\"Thai\">Thai
      <option value=\"Turkish\">Turkish
      <option value=\"Ukrainian\">Ukrainian
      <option value=\"Urdu\">Urdu
      <option value=\"Vietnamese\">Vietnamese
      <option value=\"Welsh\">Welsh
     </select>
    </td>
   </tr>
";

if($sec_readonly!='Y')
{
 $output .= "
   <tr>
     <td colspan=2> <br />
      <input type='button' value=\"".translate('Accept Record', $st, 'sys')."\" onclick=accept_func()>
      <input type='button' value=\"".translate('Clear Form', $st, 'sys')."\" onclick=clear_func()>
";

 if($_POST['dcode']!='eng')
 { 
  $output .= " 
      <input type='button' value=\"".translate('Delete all Records', $st, 'sys')."\" onclick=delete_func()>
";

  if($_POST['dgoogle_code'])
  {
  $output .= "
      <input type='button' value=\"".translate('Translate all Records', $st, 'sys')."\" onclick=translate_func()>
";
  }
 }

 $output .= "
      <span style=\"color: brown; \"> ".$submit_message." </span>  
     </td>
   </tr> 
";
}


$output .= "
  </table>
  <p />
  ".$tr_translations."
  </div>
  </span> 
";

echo $output;

//html footer
echo<<<END
<input name="devent" type="hidden">
</form>
</body>
</html>
END;

?>