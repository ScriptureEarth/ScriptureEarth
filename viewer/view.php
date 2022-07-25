<?php 

/******************************************************************************/
/* single book viewing screen                                                 */
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

//include 'config.php';
include '../include/conn.inc.php';
$db = get_my_db();
include "../translate/functions.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
       "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" dir="ltr">
<head>
<meta content="text/html; charset=UTF-8" http-equiv="content-type">
<title></title>
<meta name="robots" content="noindex, nofollow">
<link rel="SHORTCUT ICON" href="../favicon.ico" />
<link type="text/css" rel="stylesheet" href="style.css" />
</head>
<body>

<?php
$bookDescription = [];
$book = [];
$MajorLanguage = '';

// php.ini will NOT display error messages
ini_set("display_errors", 0);

// get list of languages
//$isos = scandir('../data');
//$languageArray = array();
/*foreach($isos as $iso)
{
 if($iso!='.' && $iso!='..')
 {
  if(file_exists('../data/'.$_GET['iso'].'/viewer'))
  {
   $query  = 
   "SELECT LN_English FROM LN_English
    WHERE ISO  = \"".$iso."\"
    LIMIT 1";
   $result_st = mysql_query($query) or die (mysql_error());
   $myrow_st  = mysql_fetch_array($result_st);
   $languageArray[$iso] = $myrow_st['LN_English'];
  }
 }
}
*/

function check_input($value) {						// used for ' and " that find it in the input
	$value = trim($value);
    /* Automatic escaping is highly deprecated, but many sites do it anyway. */
	// Stripslashes
	//if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
	  $value = stripslashes($value);
	//}
	// Quote if not a number
	if (!is_numeric($value)) {
		$db = get_my_db();
		$value = $db->real_escape_string($value);
	}
	return $value;
}

if (!isset($_POST['st']) && !isset($_GET['st'])) {
	die('‘st’ is empty.</body></html>');
}
if (!isset($_POST['st'])) {$_POST['st']=$_GET['st'];}
$st = $_POST['st'];
$st = preg_replace('/^([a-z]{3})/', '$1', $st);
if ($st == NULL) {
	die('‘st’ is empty.</body></html>');
}

if (!isset($_POST['iso']) && !isset($_GET['iso'])) {
	die('‘iso’ is empty.</body></html>');
}
if (!isset($_POST['iso'])) {$_POST['iso']=$_GET['iso'];}
$_POST['iso'] = preg_replace('/^([a-z]{3})/', '$1', $_POST['iso']);
if ($_POST['iso'] == NULL) {
	die('‘ISO’ ' . translate('is empty', $st, 'sys') . '.</body></html>');
}

$query = "SELECT ISO FROM scripture_main WHERE ISO = '".substr($_POST['iso'], 0, 3)."'";
$result_st = $db->query($query) or die ($db->error);
if ($result_st->num_rows == 0) {
	die('There is no ' . substr($_POST['iso'], 0, 3) . ' in the database.</body></html>');
}

switch ($st) {
	case "eng":
		$MajorLanguage = "LN_English";
		$bookDescription = array(
		 '1CH'=>'1 Chronicles',
		 '1CO'=>'1 Corinthians',
		 '1JN'=>'1 John',
		 '1KI'=>'1 Kings',
		 '1PE'=>'1 Peter',
		 '1SA'=>'1 Samuel',
		 '1TH'=>'1 Thessalonians',
		 '1TI'=>'1 Timothy',
		 '2CH'=>'2 Chronicles',
		 '2CO'=>'2 Corinthians',
		 '2JN'=>'2 John',
		 '2KI'=>'2 Kings',
		 '2PE'=>'2 Peter',
		 '2SA'=>'2 Samuel',
		 '2TH'=>'2 Thessalonians',
		 '2TI'=>'2 Timothy',
		 '3JN'=>'3 John',
		 'ACT'=>'Acts',
		 'AMO'=>'Amos',
		 'COL'=>'Colossians',
		 'DAN'=>'Daniel',
		 'DEU'=>'Deuteronomy',
		 'ECC'=>'Ecclesiastes',
		 'EPH'=>'Ephesians',
		 'EST'=>'Esther',
		 'EXO'=>'Exodus',
		 'EZK'=>'Ezekiel',
		 'EZR'=>'Ezra',
		 'GAL'=>'Galatians',
		 'GEN'=>'Genesis',
		 'HAB'=>'Habakkuk',
		 'HAG'=>'Haggai',
		 'HEB'=>'Hebrews',
		 'HOS'=>'Hosea',
		 'ISA'=>'Isaiah',
		 'JAS'=>'James',
		 'JDG'=>'Judges',
		 'JER'=>'Jeremiah',
		 'JHN'=>'John',
		 'JOB'=>'Job',
		 'JOL'=>'Joel',
		 'JON'=>'Jonah',
		 'JOS'=>'Joshua',
		 'JUD'=>'Jude',
		 'LAM'=>'Lamentations',
		 'LEV'=>'Leviticus',
		 'LUK'=>'Luke',
		 'MAL'=>'Malachi',
		 'MAT'=>'Matthew',
		 'MIC'=>'Micah',
		 'MRK'=>'Mark',
		 'NAM'=>'Nahum',
		 'NEH'=>'Nehemiah',
		 'NUM'=>'Numbers',
		 'OBA'=>'Obadiah',
		 'PHM'=>'Philemon',
		 'PHP'=>'Philippians',
		 'PRO'=>'Proverbs',
		 'PSA'=>'Psalms',
		 'REV'=>'Revelation',
		 'ROM'=>'Romans',
		 'RUT'=>'Ruth',
		 'SNG'=>'Song of Solomon',
		 'TIT'=>'Titus',
		 'ZEC'=>'Zechariah',
		 'ZEP'=>'Zephaniah',
		 'WAP'=>'Apocrypha',
		 'WBA'=>'Bible with Apocrypha',
		 'WBI'=>'Bible',
		 'WNT'=>'New Testament',
		 'WOA'=>'Old Testament with Apocrypha',
		 'WOT'=>'Old Testament',
		 'GLO'=>'Glossary',
		 'BAK'=>'Glossary',
		 'IDX'=>'Topical index'
		 );
		break;
	case "spa":
		$MajorLanguage = "LN_Spanish";
		$bookDescription = array(
		 '1CH'=>'1 Crónicas',
		 '1CO'=>'1 Corintios',
		 '1JN'=>'1 Juan',
		 '1KI'=>'1 Reyes',
		 '1PE'=>'1 Pedro',
		 '1SA'=>'1 Samuel',
		 '1TH'=>'1 Tesalonicenses',
		 '1TI'=>'1 Timoteo',
		 '2CH'=>'2 Crónicas',
		 '2CO'=>'2 Corintios',
		 '2JN'=>'2 Juan',
		 '2KI'=>'2 Reyes',
		 '2PE'=>'2 Pedro',
		 '2SA'=>'2 Samuel',
		 '2TH'=>'2 Tesalonicenses',
		 '2TI'=>'2 Timoteo',
		 '3JN'=>'3 Juan',
		 'ACT'=>'Hechos',
		 'AMO'=>'Amós',
		 'COL'=>'Colosenses',
		 'DAN'=>'Daniel',
		 'DEU'=>'Deuteronomio',
		 'ECC'=>'Eclesiastés',
		 'EPH'=>'Efesios',
		 'EST'=>'Ester',
		 'EXO'=>'Éxodo',
		 'EZK'=>'Ezequiel',
		 'EZR'=>'Esdras',
		 'GAL'=>'Gálatas',
		 'GEN'=>'Génesis',
		 'HAB'=>'Habacuc',
		 'HAG'=>'Hageo',
		 'HEB'=>'Hebreos',
		 'HOS'=>'Oseas',
		 'ISA'=>'Isaías',
		 'JAS'=>'Santiago',
		 'JDG'=>'Jueces',
		 'JER'=>'Jeremías',
		 'JHN'=>'Juan',
		 'JOB'=>'Job',
		 'JOL'=>'Joel',
		 'JON'=>'Jonás',
		 'JOS'=>'Josué',
		 'JUD'=>'Judas',
		 'LAM'=>'Lamentaciones',
		 'LEV'=>'Levítico',
		 'LUK'=>'Lucas',
		 'MAL'=>'Malaquías',
		 'MAT'=>'Mateo',
		 'MIC'=>'Miqueas',
		 'MRK'=>'Marcos',
		 'NAM'=>'Nahúm',
		 'NEH'=>'Nehemías',
		 'NUM'=>'Números',
		 'OBA'=>'Abdías',
		 'PHM'=>'Filemón',
		 'PHP'=>'Filipenses',
		 'PRO'=>'Proverbios',
		 'PSA'=>'Salmos',
		 'REV'=>'Apocalipsis',
		 'ROM'=>'Romanos',
		 'RUT'=>'Rut',
		 'SNG'=>'Cantares',
		 'TIT'=>'Tito',
		 'ZEC'=>'Zacarías',
		 'ZEP'=>'Sofonías',
		 'WAP'=>'Apocrypha',
		 'WBA'=>'Bible with Apocrypha',
		 'WBI'=>'Bible',
		 'WNT'=>'New Testament',
		 'WOA'=>'Old Testament with Apocrypha',
		 'WOT'=>'Old Testament',
		 'GLO'=>'Glossary',
		 'BAK'=>'Glossary',
		 'IDX'=>'Topical index'
		 );
		break;
	case "por":
		$MajorLanguage = "LN_Portuguese";
		$bookDescription = array(
		 '1CH'=>'1 Crônicas',
		 '1CO'=>'1 Coríntios',
		 '1JN'=>'1 João',
		 '1KI'=>'1 Reis',
		 '1PE'=>'1 Pedro',
		 '1SA'=>'1 Samuel',
		 '1TH'=>'1 Tessalonicenses',
		 '1TI'=>'1 Timóteo',
		 '2CH'=>'2 Crônicas',
		 '2CO'=>'2 Coríntios',
		 '2JN'=>'2 João',
		 '2KI'=>'2 Reis',
		 '2PE'=>'2 Pedro',
		 '2SA'=>'2 Samuel',
		 '2TH'=>'2 Tessalonicenses',
		 '2TI'=>'2 Timóteo',
		 '3JN'=>'3 João',
		 'ACT'=>'Atos',
		 'AMO'=>'Amós',
		 'COL'=>'Colossenses',
		 'DAN'=>'Daniel',
		 'DEU'=>'Deuteronômio',
		 'ECC'=>'Eclesiastes',
		 'EPH'=>'Efésios',
		 'EST'=>'Ester',
		 'EXO'=>'Éxodo',
		 'EZK'=>'Ezequiel',
		 'EZR'=>'Esdras',
		 'GAL'=>'Gálatas',
		 'GEN'=>'Gênesis',
		 'HAB'=>'Habacuque',
		 'HAG'=>'Ageu',
		 'HEB'=>'Hebreus',
		 'HOS'=>'Oséias',
		 'ISA'=>'Isaías',
		 'JAS'=>'Tiago',
		 'JDG'=>'Juízes',
		 'JER'=>'Jeremias',
		 'JHN'=>'João',
		 'JOB'=>'Jó',
		 'JOL'=>'Joel',
		 'JON'=>'Jonas',
		 'JOS'=>'Josué',
		 'JUD'=>'Judas',
		 'LAM'=>'Lamentaçôes de Jeremias',
		 'LEV'=>'Levítico',
		 'LUK'=>'Lucas',
		 'MAL'=>'Malaquias',
		 'MAT'=>'Mateus',
		 'MIC'=>'Miquéias',
		 'MRK'=>'Marcos',
		 'NAM'=>'Naum',
		 'NEH'=>'Neemias',
		 'NUM'=>'Números',
		 'OBA'=>'Obadias',
		 'PHM'=>'Filemón',
		 'PHP'=>'Filipenses',
		 'PRO'=>'Provérbios',
		 'PSA'=>'Salmos',
		 'REV'=>'Apocalipse',
		 'ROM'=>'Romanos',
		 'RUT'=>'Rute',
		 'SNG'=>'Cantares de Salomâo',
		 'TIT'=>'Tito',
		 'ZEC'=>'Zacarias',
		 'ZEP'=>'Sofonias',
		 'WAP'=>'Apocrypha',
		 'WBA'=>'Bible with Apocrypha',
		 'WBI'=>'Bible',
		 'WNT'=>'New Testament',
		 'WOA'=>'Old Testament with Apocrypha',
		 'WOT'=>'Old Testament',
		 'GLO'=>'Glossary',
		 'BAK'=>'Glossary',
		 'IDX'=>'Topical index'
		 );
		break;
	case "fre":
		$MajorLanguage = "LN_French";
		$bookDescription = array(
		 '1CH'=>'1 Chroniques',
		 '1CO'=>'1 Corinthiens',
		 '1JN'=>'1 Jean',
		 '1KI'=>'1 Rois',
		 '1PE'=>'1 Pierre',
		 '1SA'=>'1 Samuel',
		 '1TH'=>'1 Thessaloniciens',
		 '1TI'=>'1 Timothée',
		 '2CH'=>'2 Chroniques',
		 '2CO'=>'2 Corinthiens',
		 '2JN'=>'2 Jean',
		 '2KI'=>'2 Rois',
		 '2PE'=>'2 Pierre',
		 '2SA'=>'2 Samuel',
		 '2TH'=>'2 Thessaloniciens',
		 '2TI'=>'2 Timothée',
		 '3JN'=>'3 Jean',
		 'ACT'=>'Actes',
		 'AMO'=>'Amos',
		 'COL'=>'Colossiens',
		 'DAN'=>'Daniel',
		 'DEU'=>'Deutéronome',
		 'ECC'=>'Ecclésiaste',
		 'EPH'=>'Éphésiens',
		 'EST'=>'Esther',
		 'EXO'=>'Exode',
		 'EZK'=>'Ézéchiel',
		 'EZR'=>'Esdras',
		 'GAL'=>'Galates',
		 'GEN'=>'Genèse',
		 'HAB'=>'Habacuc',
		 'HAG'=>'Aggée',
		 'HEB'=>'Hébreux',
		 'HOS'=>'Osée',
		 'ISA'=>'Ésaïe',
		 'JAS'=>'Jacques',
		 'JDG'=>'Juges',
		 'JER'=>'Jérémie',
		 'JHN'=>'Jean',
		 'JOB'=>'Job',
		 'JOL'=>'Joël',
		 'JON'=>'Jonas',
		 'JOS'=>'Josué',
		 'JUD'=>'Jude',
		 'LAM'=>'Lamentations',
		 'LEV'=>'Lévitique',
		 'LUK'=>'Luc',
		 'MAL'=>'Malachie',
		 'MAT'=>'Matthieu',
		 'MIC'=>'Michée',
		 'MRK'=>'Marc',
		 'NAM'=>'Nahum',
		 'NEH'=>'Néhémie',
		 'NUM'=>'Nombres',
		 'OBA'=>'Abdias',
		 'PHM'=>'Philémon',
		 'PHP'=>'Philippiens',
		 'PRO'=>'Proverbes',
		 'PSA'=>'Psaume',
		 'REV'=>'Apocalypse',
		 'ROM'=>'Romains',
		 'RUT'=>'Ruth',
		 'SNG'=>'Cantique des Cantiqu',
		 'TIT'=>'Tite',
		 'ZEC'=>'Zacharie',
		 'ZEP'=>'Sophonie',
		 'WAP'=>'Apocrypha',
		 'WBA'=>'Bible with Apocrypha',
		 'WBI'=>'Bible',
		 'WNT'=>'New Testament',
		 'WOA'=>'Old Testament with Apocrypha',
		 'WOT'=>'Old Testament',
		 'GLO'=>'Glossary',
		 'BAK'=>'Glossary',
		 'IDX'=>'Topical index'
		 );
		break;
	case "nld":
		$MajorLanguage = "LN_Dutch";
		$bookDescription = array(
		 '1CH'=>'1 Kronieken',
		 '1CO'=>'1 Corinthiërs',
		 '1JN'=>'1 Johannes',
		 '1KI'=>'1 Koningen',
		 '1PE'=>'1 Petrus',
		 '1SA'=>'1 Samuel',
		 '1TH'=>'1 Thessalonicenzen',
		 '1TI'=>'1 Timotheüs',
		 '2CH'=>'2 Kronieken',
		 '2CO'=>'2 Corinthiërs',
		 '2JN'=>'2 Johannes',
		 '2KI'=>'2 Koningen',
		 '2PE'=>'2 Petrus',
		 '2SA'=>'2 Samuel',
		 '2TH'=>'2 Thessalonicenzen',
		 '2TI'=>'2 Timotheüs',
		 '3JN'=>'3 Johannes',
		 'ACT'=>'Handelingen',
		 'AMO'=>'Amos',
		 'COL'=>'Colossenzen',
		 'DAN'=>'Daniël',
		 'DEU'=>'Deuteronomium',
		 'ECC'=>'Prediker',
		 'EPH'=>'Efeziërs',
		 'EST'=>'Esther',
		 'EXO'=>'Exodus',
		 'EZK'=>'Ezechiël',
		 'EZR'=>'Ezra',
		 'GAL'=>'Galaten',
		 'GEN'=>'Genesis',
		 'HAB'=>'Habakuk',
		 'HAG'=>'Haggaï',
		 'HEB'=>'Hebreeën',
		 'HOS'=>'Hosea',
		 'ISA'=>'Jesaja',
		 'JAS'=>'Jakobus',
		 'JDG'=>'Richtere',
		 'JER'=>'Jeremia',
		 'JHN'=>'Johannes',
		 'JOB'=>'Job',
		 'JOL'=>'Joël',
		 'JON'=>'Jona',
		 'JOS'=>'Jozua',
		 'JUD'=>'Judas',
		 'LAM'=>'Klaagliederen',
		 'LEV'=>'Leviticus',
		 'LUK'=>'Lukas',
		 'MAL'=>'Maleachi',
		 'MAT'=>'Mattheüs',
		 'MIC'=>'Micha',
		 'MRK'=>'Markus',
		 'NAM'=>'Nahum',
		 'NEH'=>'Nehemia',
		 'NUM'=>'Numberi',
		 'OBA'=>'Obadja',
		 'PHM'=>'Filémon',
		 'PHP'=>'Filippenzen',
		 'PRO'=>'Spreuken',
		 'PSA'=>'Psalmen',
		 'REV'=>'Openbaring',
		 'ROM'=>'Romeinen',
		 'RUT'=>'Ruth',
		 'SNG'=>'Hooglied',
		 'TIT'=>'Titus',
		 'ZEC'=>'Zacharia',
		 'ZEP'=>'Zefanja',
		 'WAP'=>'Apocrypha',
		 'WBA'=>'Bible with Apocrypha',
		 'WBI'=>'Bible',
		 'WNT'=>'New Testament',
		 'WOA'=>'Old Testament with Apocrypha',
		 'WOT'=>'Old Testament',
		 'GLO'=>'Glossary',
		 'BAK'=>'Glossary',
		 'IDX'=>'Topical index'
		 );
		break;
	case "deu":
		$MajorLanguage = "LN_German";
		$bookDescription = array(
		'1CH'=>'1 Chronik',
		'1CO'=>'1 Korinther',
		'1JN'=>'1 Johannes',
		'1KI'=>'1 Könige',
		'1PE'=>'1 Petrus',
		'1SA'=>'1 Samuel',
		'1TH'=>'1 Thessalonicher',
		'1TI'=>'1 Timotheus',
		'2CH'=>'2 Chronik',
		'2CO'=>'2 Korinther',
		'2JN'=>'2 Johannes',
		'2KI'=>'2 Könige',
		'2PE'=>'2 Petrus',
		'2SA'=>'2 Samuel',
		'2TH'=>'2 Thessalonicher',
		'2TI'=>'2 Timotheus',
		'3JN'=>'3 Johannes',
		'ACT'=>'Apostelgeschichte',
		'AMO'=>'Amos',
		'COL'=>'Kolosser',
		'DAN'=>'Daniel',
		'DEU'=>'Deuteronomium',
		'ECC'=>'Prediger',
		'EPH'=>'Epheser',
		'EST'=>'Ester',
		'EXO'=>'Exodus',
		'EZK'=>'Ezechiel',
		'EZR'=>'Esra',
		'GAL'=>'Galater',
		'GEN'=>'Genesis',
		'HAB'=>'Habakuk',
		'HAG'=>'Haggai',
		'HEB'=>'Hebräer',
		'HOS'=>'Hosea',
		'ISA'=>'Jesaja',
		'JAS'=>'Jakobus',
		'JDG'=>'Richter',
		'JER'=>'Jeremia',
		'JHN'=>'Johannes',
		'JOB'=>'Ijob',
		'JOL'=>'Joël',
		'JON'=>'Jona',
		'JOS'=>'Josua',
		'JUD'=>'Judas',
		'LAM'=>'Klagelieder',
		'LEV'=>'Levitikus',
		'LUK'=>'Lukas',
		'MAL'=>'Maleachi',
		'MAT'=>'Matthäus',
		'MIC'=>'Micha',
		'MRK'=>'Markus',
		'NAM'=>'Nahum',
		'NEH'=>'Nehemia',
		'NUM'=>'Numeri',
		'OBA'=>'Obadja',
		'PHM'=>'Philemon',
		'PHP'=>'Philipper',
		'PRO'=>'Sprichwörter',
		'PSA'=>'Psalmen',
		'REV'=>'Offenbarung des Johannes',
		'ROM'=>'Römer',
		'RUT'=>'Rut',
		'SNG'=>'Lied Salomos',
		'TIT'=>'Titus',
		'ZEC'=>'Sacharja',
		'ZEP'=>'Zefanja',
		'WAP'=>'Apocrypha',
		'WBA'=>'Bible with Apocrypha',
		'WBI'=>'Bible',
		'WNT'=>'New Testament',
		'WOA'=>'Old Testament with Apocrypha',
		'WOT'=>'Old Testament',
		'GLO'=>'Glossary',
		'BAK'=>'Glossary',
		'IDX'=>'Topical index'
		);
		break;
	default:
		echo 'This isn’t suppossed to happen (view - switch code).';
}

// get list of languages with field viewer = 1
$language_options = '';
//$query = "SELECT scripture_main.ISO, scripture_main.ROD_Code, scripture_main.Variant_Code, scripture_main.ISO_ROD_index, LN_English.LN_English FROM scripture_main, LN_English WHERE LN_English.ISO_ROD_index = scripture_main.ISO_ROD_index AND scripture_main.viewer = 1 ORDER BY LN_English.LN_English";
$query = "SELECT scripture_main.* FROM scripture_main WHERE scripture_main.viewer = 1";
$result_st = $db->query($query) or die ($db->error);
//$num_st=$result_st->num_rows;
if ($result_st->num_rows == 0) {
	die('There is not any viewing books for ISO.');
}
/*
	*************************************************************************************************************
		select the default primary language name to be used by displaying the Countries and indigenous langauge names
	*************************************************************************************************************
*/
$db->query("DROP TABLE IF EXISTS LN_Temp");							// Get the names of all of the languages or else get the default names
$db->query("CREATE TEMPORARY TABLE LN_Temp (ISO VARCHAR(3) NOT NULL, ROD_Code VARCHAR(5) NOT NULL, ISO_ROD_index INT NULL, LN VARCHAR(50) NOT NULL) ENGINE = MEMORY CHARSET = utf8") or die ("<body>" . translate('Query failed:', $st, 'sys') . ' ' . mysql_error() . "</body></html>");
while ($row = $result_st->fetch_array()) {
	$ISO=$row['ISO'];
	$ROD_Code=$row['ROD_Code'];
	$Variant_Code=$row['Variant_Code'];
	$ISO_ROD_index=$row['ISO_ROD_index'];				// ISO_ROD_index
	$ML=$row["$MajorLanguage"];						// boolean
	//$LN_English=mysql_result($result_st,$i,"scripture_main.LN_English");					// boolean
	//$LN_Spanish=mysql_result($result_st,$i,"scripture_main.LN_Spanish");					// boolean
	//$LN_Portuguese=mysql_result($result_st,$i,"scripture_main.LN_Portuguese");			// boolean
	//$LN_French=mysql_result($result_st,$i,"scripture_main.LN_French");					// boolean
	//$LN_Dutch=mysql_result($result_st,$i,"scripture_main.LN_Dutch");						// boolean
	$def_LN=$row['Def_LN'];							// default langauge (a 2 digit number for the national langauge)
	if ($ML > 0) {																			// if the major language then the default langauge
		switch ($def_LN) {
			case 1:
				$query="SELECT LN_English FROM LN_English WHERE ISO_ROD_index = '$ISO_ROD_index'";
				$result_LN=$db->query($query);
				$r = $result_LN->fetch_array();
				$LN=trim($r['LN_English']);
				break;
			case 2:
				$query="SELECT LN_Spanish FROM LN_Spanish WHERE ISO_ROD_index = '$ISO_ROD_index'";
				$result_LN=$db->query($query);
				$r = $result_LN->fetch_array();
				$LN=trim($r['LN_Spanish']);
				break;
			case 3:
				$query="SELECT LN_Portuguese FROM LN_Portuguese WHERE ISO_ROD_index = '$ISO_ROD_index'";
				$result_LN=$db->query($query);
				$r = $result_LN->fetch_array();
				$LN=trim($r['LN_Portuguese']);
				break;	
			case 4:
				$query="SELECT LN_French FROM LN_French WHERE ISO_ROD_index = '$ISO_ROD_index'";
				$result_LN=$db->query($query);
				$r = $result_LN->fetch_array();
				$LN=trim($r['LN_French']);
				break;	
			case 5:
				$query="SELECT LN_Dutch FROM LN_Dutch WHERE ISO_ROD_index = '$ISO_ROD_index'";
				$result_LN=$db->query($query);
				$r = $result_LN->fetch_array();
				$LN=trim($r['LN_Dutch']);
				break; 	
			case 6:
				$query="SELECT LN_German FROM LN_German WHERE ISO_ROD_index = '$ISO_ROD_index'";
				$result_LN=$db->query($query);
				$r = $result_LN->fetch_array();
				$LN=trim($r['LN_German']);
				break; 	
			default:
				echo translate('This isn’t supposed to happen! The default language isn’t found.', $st, 'sys');
				break;
		}
	}
	else {
		//$query="SELECT $MajorLanguage FROM $MajorLanguage WHERE ISO_ROD_index = '$ISO_ROD_index'";
		$query="SELECT LN_English FROM LN_English WHERE ISO_ROD_index = '$ISO_ROD_index'";
		$result_LN=$db->query($query);
		$r = $result_LN->fetch_array();
		//$LN=trim(mysql_result($result_LN,0,"$MajorLanguage"));
		$LN=trim($r['LN_English']);
	}
	$LN = check_input($LN);
	$db->query("INSERT INTO LN_Temp (ISO, ROD_Code, ISO_ROD_index, LN) VALUES ('$ISO', '$ROD_Code', '$ISO_ROD_index', '$LN')");
}

$query="SELECT LN_Temp.LN, scripture_main.ISO, scripture_main.ROD_Code, scripture_main.Variant_Code FROM LN_Temp, scripture_main WHERE LN_Temp.ISO_ROD_index = scripture_main.ISO_ROD_index ORDER BY LN_Temp.LN";
$result_st = $db->query($query);
//$num_st=$result_st->num_rows;
while ($row = $result_st->fetch_array()) {
	$ISO=$row['ISO'];
	$ROD_Code=$row['ROD_Code'];
	$Variant_Code=$row['Variant_Code'];
	$ML=$row['LN'];
	if (empty($Variant_Code))
		$Variant_Code == '';
	//$language_options .= "<option value='$ISO'>$ISO ";
	$two = '';
	$three = '';
	$ROD_Var = '';
	if ($ROD_Code != '00000')
		$two = "($ROD_Code) ";
	if ($Variant_Code != '') {
		$query = "SELECT Variant_Description FROM Variants WHERE Variant_Code = '$Variant_Code'";
		$result_Var = $db->query($query) or die ($db->error);
		//$num_Var=$result_Var->num_rows;
		if ($result_Var->num_rows > 0) {
			$r_Var = $result_Var->fetch_array();
			$Variant_Description=$r_Var['Variant_Description'];
			$three = "<span style='font-size: 9pt; font-style: italic; '>($Variant_Description)</span> ";
		}
	}
	$query = "SELECT viewer_ROD_Variant FROM viewer WHERE ISO = '$ISO' AND ROD_Code = '$ROD_Code' AND Variant_Code = '$Variant_Code'";
	$result_Viewer = $db->query($query) or die ($db->error);
	//$num_Viewer=$result_Viewer->num_rows;
	if ($result_Viewer->num_rows > 0) {
		$r_Viewer = $result_Viewer->fetch_array();
		$ROD_Var=$r_Viewer['viewer_ROD_Variant'];
	}
	$one = "<option value='" . $ISO . "~" . $ROD_Code . "~" . $Variant_Code . "~" . $ROD_Var . "'>$ISO ";
	$language_options .= $one . $two . $three . "- $ML</option>";
	//echo $ISO . "~" . $ROD_Code . "~" . $Variant_Code . "~" . $ROD_Var;
}
$db->query('DROP TABLE LN_Temp'); 

// create language options sorted by language
//asort($languageArray);
//$language_options = '';
//foreach($languageArray as $iso=>$language)
//{$language_options .= "<option value=\"".$iso."\">".$iso." - ".$language."</option>";}

if (!isset($_POST['ROD_Code']) && !isset($_GET['ROD_Code'])) {
	die('‘ROD_Code’ ' . translate('is empty', $st, 'sys') . '.</body></html>');
}
if (!isset($_POST['Variant_Code']) && !isset($_GET['Variant_Code'])) {
	die('‘Variant_Code’ ' . translate('is empty', $st, 'sys') . '.</body></html>');
}
if (!isset($_POST['rtl']) && !isset($_GET['rtl'])) {
	die('‘rtl’ ' . translate('is empty', $st, 'sys') . '.</body></html>');
}
if (!isset($_POST['ROD_Var']) && !isset($_GET['ROD_Var'])) {
	die('‘ROD_Var’ ' . translate('is empty', $st, 'sys') . '.</body></html>');
}

if (!isset($_POST['ROD_Code'])) {$_POST['ROD_Code']=$_GET['ROD_Code'];}
$_POST['ROD_Code'] = preg_replace('/^(.{0,5})/', '$1', $_POST['ROD_Code']);

if (!isset($_POST['Variant_Code'])) {$_POST['Variant_Code']=$_GET['Variant_Code'];}
$_POST['Variant_Code'] = preg_replace('/^([a-zA-Z0-9]?)/', '$1', $_POST['Variant_Code']);

if (!isset($_POST['ROD_Var'])) {$_POST['ROD_Var']=$_GET['ROD_Var'];}
$ROD_Var = $_POST['ROD_Var'];
$ROD_Var = preg_replace('/^([-a-zA-Z0-9]{0,15})/', '$1', $ROD_Var);

if (!isset($_POST['rtl'])) {$_POST['rtl']=$_GET['rtl'];}
$rtl = $_POST['rtl'];
$rtl = preg_replace('/^([01])/', '$1', $rtl);
if ($rtl != '0' && $rtl != '1' && $rtl != NULL) {
	die('‘rtl’ is wrong.</body></html>');
}

//echo "1) ROD_Var=" . $ROD_Var . "     ";

if ($_POST['iso']) {
//	echo "1) iso=" . $_POST['iso'] . "     ";
 $tempRODVar = '';
 if (strpos($_POST['iso'], "~") != 0) {
	$tempRODVar = substr($_POST['iso'], strpos($_POST['iso'], '~'));
//echo "<br />1) tempRODVar=" . $tempRODVar . "     ";
	$_POST['iso'] = substr($_POST['iso'], 0, strpos($_POST['iso'], '~'));
//echo "1) _POST['iso']=" . $_POST['iso'] . "     ";
	$variables = explode("~", $tempRODVar);
	$_POST['ROD_Code'] = $variables[1];
//echo "1) _POST['ROD_Code']=" . $_POST['ROD_Code'] . "     ";
	$_POST['Variant_Code'] = $variables[2];
//echo "1) _POST['Variant_Code']=" . $_POST['Variant_Code'] . "     ";
	$_POST['ROD_Var'] = $variables[3];
//echo "1) _POST['ROD_Var']=" . $_POST['ROD_Var'] . "<br />";
	$ROD_Var = $_POST['ROD_Var'];
	/*if ($_POST['Variant_Code'] != '') {
		$query = "SELECT Variant_Description FROM Variants WHERE Variant_Code = '$Variant_Code'";
		$result_Var = mysql_query($query) or die (mysql_error());
		$num_Var=mysql_num_rows($result_Var);
		$Variant_Description = mysql_result($result_Var,0,"Variant_Description");
	}*/
//echo "1.5) _POST['ROD_Var']=" . $_POST['ROD_Var'] . "     ";
 }

 if (isset($_POST['book']))
 	$firstBook = $_POST['book'];
 else
	$firstBook = 0;
 
 if ($ROD_Var == '') {
	if (is_dir('../data/'.$_POST['iso'].'/viewer')) {
		$books = scandir('../data/'.$_POST['iso'].'/viewer');									// only 1 ISO
		$query = "SELECT ISO FROM scripture_main WHERE ISO = '".$_POST['iso']."'";
		$result_ISO = $db->query($query) or die ($db->error);
		//$num_ISO=$result_ISO->num_rows;
		//$ISO=mysql_result($result_ISO,0,"ISO");
		if ($result_ISO) {
			$bookStrLen = strpos($books[2], ".");					// skipping '.' and '..' get the length of filiename without the extension (i.e. 41MAT[ISO})
	//		echo "books[2]=" . $books[2]."<br />";
			//echo $bookStrLen."<br />";
			foreach ($books as $book) {
				if ($bookStrLen != strpos($book, "."))
					$books = array_diff($books, array($book));		// i.e., array $books minus array $book (delete $book from $books)
			}
			//print_r($books);
		}
	 }
 }
 else {
	 $boks = glob('../data/'.$_POST['iso'].'/viewer/*'.$ROD_Var.'.*');						// only 1 ISO
	 foreach ($boks as $bok) {
		 //echo strrchr($bok, "/");
		 $books[] = substr(strrchr($bok, "/"), 1);
	 }
 }
 
if (empty($books)) {
	die('There is not any viewing books for this ISO.');
}

 //$_POST['ROD_Var'] = '';
 //$_GET['ROD_Var'] = '';
 //$ROD_Var = '';
 //if ($tempRODVar != '')
 //	$_POST['iso'] = $_POST['iso'].$tempRODVar;
 if (strpos($_POST['iso'], "~") == 0)
	 $_POST['iso'] = $_POST['iso'].'~'.$_POST['ROD_Code'].'~'.$_POST['Variant_Code'].'~'.$ROD_Var;
 //print_r($books);
// echo $_POST['iso'];
 $js_bookFilenames = '';
 $js_bookDescriptions = '';
 $book_options = '<span class="selectBoxTitle">'.translate('Select book', $st, 'sys').'</span> &nbsp;&nbsp; ';
 foreach($books as $book) {
	 //echo $book . "<br />";
  if($book!='.' && $book!='..') {
   if(!$firstBook) {/*$_POST['book'] = $book;*/ $firstBook = $book;}
   if (substr($book,2,1) == '-' || substr($book,2,1) == 'y' || substr($book,2,1) == 'q') {			// if book is '-' or 'y' (probably a mistake by the CMS user)
	$b = substr($book,3,3);
   }
   else {
   	$b = substr($book,2,3);
   }
   if($b!='FRT' && $b!='OTH') {
    $js_bookFilenames .= "\"".$book."\",";
    $js_bookDescriptions .= "\"".translate($bookDescription[$b], $st, 'sys')."\",";
    $book_options .= "<a onclick=\"setBook('".$book."','".$bookDescription[$b]."');\">".translate($bookDescription[$b], $st, 'sys')."</a>,&nbsp; ";
   }
  }
 }
}
$js_bookFilenames = rtrim($js_bookFilenames,',');
$js_bookDescriptions = rtrim($js_bookDescriptions,',');

if(!isset($_POST['chapter'])) {$_POST['chapter'] = '1';}
if(!isset($_POST['verse'])) {$_POST['verse'] = '1';}


$output = "
<form id=\"form1\" name=\"form1\" action=\"\" method=\"post\">
 
<script language=\"JavaScript\"> 

 f = document.forms[0];
 var bookFilenames = new Array(".$js_bookFilenames.");
 var bookDescriptions = new Array(".$js_bookDescriptions.");
 var rsFlag = 0;
 var st = '".$st."';
 var rtl = '".$rtl."';
 
function nextBook(var1)
{
 for(b=0; b<bookDescriptions.length; b++)
 {if(bookDescriptions[b]==document.getElementById(\"book\").value){break;}}
 if(var1=='previous') {if(b>0){b--;}}
 if(var1=='forward')  {if(b<bookDescriptions.length-1){b++;}}
 setBook(bookFilenames[b], bookDescriptions[b]);
}

function setBook(book, description)
{
 f.book.value=description;
//alert(\"description=\" + f.book.value);
 document.getElementById('bookSelection').style.visibility='hidden';

//alert(\"parent.frame1.f.syncedViewing.checked=\" + parent.frame1.f.syncedViewing.checked);
 
 if(!parent.frame1.f.syncedViewing.checked)
 {
  getBook(description, 0);
 }

 if(parent.frame1.f.syncedViewing.checked) 
 {
  parent.frame1.f.book.value=description;
  getBook(description, 1);
 }
 
 if(parent.frame1.f.syncedViewing.checked) 
 {
  parent.frame2.f.book.value=description; 
  getBook(description, 2);
 }
}

function getBook(description, frame)
{
//alert(document.getElementById(\"book\").value);
 for (b=0; b<bookDescriptions.length; b++) {
 	if (bookDescriptions[b] == document.getElementById(\"book\").value) {break;}
 }
 book = bookFilenames[b];
//alert(\"book=\"+book);

  //iso = f.iso.value;
 //alert(\"3) f.iso.value=\"+f.iso.value);
  var tempISORODVar = f.iso.value;
  var variables = new Array();
  variables = tempISORODVar.split('~');
  iso = variables[0];
  var ROD_Code = variables[1];				// i.e., get ~ZZZZZ~
  var Variant_Code = variables[2];			// i.e., get ~Z~
  var ROD_Var = variables[3];				// i.e., get ~ZZZZ
  
  //alert(iso);
  //alert(ROD_Code);
  //alert('#' + Variant_Code + '#');
  //alert(\"3) ROD_Var=\"+ROD_Var);

  if(frame==1)
  {
   for(b=0; b<bookDescriptions.length; b++)
   {if(parent.frame1.bookDescriptions[b]==parent.frame1.f.book.value){break;}}
   book = parent.frame1.bookFilenames[b]; 
   //iso = parent.frame1.f.iso.value;
   tempISORODVar = parent.frame1.f.iso.value;
   variables = new Array();
   variables = tempISORODVar.split('~');
   iso = variables[0];
   ROD_Code = variables[1];				// i.e., get ~ZZZZZ~
   Variant_Code = variables[2];			// i.e., get ~Z~
   ROD_Var = variables[3];				// i.e., get ~ZZZZ
  }

  if(frame==2)
  {
   for(b=0; b<bookDescriptions.length; b++)
   {if(parent.frame2.bookDescriptions[b]==parent.frame2.f.book.value){break;}}
   book = parent.frame2.bookFilenames[b]; 
   //iso = parent.frame2.f.iso.value;
   tempISORODVar = parent.frame2.f.iso.value;
   variables = new Array();
   variables = tempISORODVar.split('~');
   iso = variables[0];
   ROD_Code = variables[1];				// i.e., get ~ZZZZZ~
   Variant_Code = variables[2];			// i.e., get ~Z~
   ROD_Var = variables[3];				// i.e., get ~ZZZZ
  }

   var xmlHttp;
   try {xmlHttp=new XMLHttpRequest();}  // Firefox, Opera 8.0+, Safari
   catch (e)
   {  
    try {xmlHttp=new ActiveXObject(\"Msxml2.XMLHTTP\");}  // Internet Explorer 
    catch (e)
    {try
     {xmlHttp=new ActiveXObject(\"Microsoft.XMLHTTP\");}
     catch (e)
     {alert(\"".translate('Your browser does not support AJAX!', $st, 'sys')."\"); return false;}
    }
   }

    xmlHttp.onreadystatechange=function()
    {
      if(xmlHttp.readyState==4)
      {

       if(frame==0)
       {
        document.getElementById(\"bookContainer\").innerHTML = xmlHttp.responseText;
        resizeBookContainer();
        if(f.chapter)
        {
         f.chapter.value = '".$_POST['chapter']."';
         f.verse.value = '".$_POST['verse']."';
         setChapterOptions(); 
         setVerseOptions();
         setVerseLocation();
        }
       }

       if(frame==1)
       {
        parent.frame1.document.getElementById(\"bookContainer\").innerHTML = xmlHttp.responseText;
        parent.frame1.resizeBookContainer();
        if(parent.frame2.f.chapter)
        {
         parent.frame1.f.chapter.value = '".$_POST['chapter']."';
         parent.frame1.f.verse.value = '".$_POST['verse']."';
         parent.frame1.setChapterOptions(); 
         parent.frame1.setVerseOptions();
         setVerseLocation();
        }
       }

       if(frame==2)
       {
        parent.frame2.document.getElementById(\"bookContainer\").innerHTML = xmlHttp.responseText;
        parent.frame2.document.getElementById('pvContainer').style.visibility=\"hidden\";
        parent.frame2.resizeBookContainer();
        if(parent.frame2.f.chapter)
        {
         parent.frame2.f.chapter.value = '".$_POST['chapter']."';
         parent.frame2.f.verse.value = '".$_POST['verse']."';
         parent.frame2.setChapterOptions(); 
         parent.frame2.setVerseOptions();
         setVerseLocation();
        } 
       }
      }
    }

    url  = \"getBook.php?iso=\"+iso;
    url += \"&ROD_Code=\"+ROD_Code;
    url += \"&Variant_Code=\"+Variant_Code;
	url += \"&ROD_Var=\"+ROD_Var;
	url += \"&st=\"+st;
	url += \"&rtl=\"+rtl;
    url += \"&book=\"+book;
    url += \"&sid=\"+Math.random();
//alert (\"6) url=\" + url);
    xmlHttp.open(\"GET\",url,true);
    xmlHttp.send(null);
}

function setChapterOptions()
{
 chapterVerses = new Array();
 var str = f.chapterVerses.value.split(\",\");  
 for(s=0; s<str.length; s++)
 {chapterVerses[s] = str[s];} 

 var innerText = '<span class=\"selectBoxTitle\">".translate('Select chapter', $st, 'sys')."</span> &nbsp;&nbsp; '; 
 for(s=1; s<=chapterVerses.length-1; s++)
 {innerText += '<a onclick=\"setChapter('+s+');\">'+s+'</a>&nbsp; ';}
 document.getElementById(\"chapterSelection\").innerHTML = innerText;
}

function setVerseOptions()
{
 var innerText = '<span class=\"selectBoxTitle\">".translate('Select verse', $st, 'sys')."</span> &nbsp;&nbsp; '; 
 if(f.chapter)
 {
  for(s=1; s<=chapterVerses[f.chapter.value]; s++)
  {innerText += '<a onclick=\"setVerse('+f.chapter.value+','+s+');\">'+s+'</a>&nbsp; ';}
  document.getElementById(\"verseSelection\").innerHTML = innerText;
 }
}
   
function setChapterLocation()
{ 
 document.getElementById('verseSelection').style.visibility='hidden';
 document.getElementById('chapterSelection').style.visibility='hidden';
 setVerseOptions();
 window.location='#'+f.chapter.value+':1';

 if(parent.frame1.f.syncedViewing.checked) 
 {
  parent.frame1.location='#'+f.chapter.value+':1';;
  parent.frame1.f.chapter.value = f.chapter.value; 
  setVerseOptions();
 }
 if(parent.frame1.f.syncedViewing.checked) 
 {
  parent.frame2.location='#'+f.chapter.value+':1';
  parent.frame2.f.chapter.value = f.chapter.value; 
  setVerseOptions();
 }
}

function setChapter(c)
{
 f.chapter.value=c;
 document.getElementById('chapterSelection').style.visibility='hidden';
 setVerseLocation();
 setVerseOptions();
}

function setVerse(c,v)
{
 f.chapter.value=c;
 f.verse.value=v;
 document.getElementById('verseSelection').style.visibility='hidden';
 setVerseLocation();
}

function setVerseLocation()
{
 document.getElementById('verseSelection').style.visibility='hidden';
 document.getElementById('chapterSelection').style.visibility='hidden';

 window.location='#'+f.chapter.value+':'+f.verse.value;
 setVerseOptions();

 if(parent.frame1.f.syncedViewing.checked)
 {
  parent.frame1.location='#'+f.chapter.value+':'+f.verse.value;
  parent.frame1.f.chapter.value = f.chapter.value;
  parent.frame1.setVerseOptions();
  parent.frame1.f.verse.value = f.verse.value;
 }
 if(parent.frame1.f.syncedViewing.checked)
 {
  parent.frame2.location='#'+f.chapter.value+':'+f.verse.value;
  parent.frame2.f.chapter.value = f.chapter.value;
  parent.frame2.setVerseOptions();
  parent.frame2.f.verse.value = f.verse.value;
 }
}

function setParallelViewing()
{
  parent.frame1.document.getElementById('pvContainer').style.visibility=\"visible\";
  if(parent.frame1.f.parallelViewing.checked)
  {
   parent.document.getElementById('mainFrame').cols = '50%,50%';
   parent.frame1.document.getElementById('svContainer').style.visibility=\"visible\";
   parent.frame2.document.getElementById('svContainer').style.visibility=\"hidden\";
  }
  else
  {
   parent.frame1.f.syncedViewing.checked = false;
   parent.document.getElementById('mainFrame').cols = '100%,0%';
   parent.frame1.document.getElementById('svContainer').style.visibility=\"hidden\";
  }
}

function setSyncedViewing()
{
 if(parent.frame1.f.syncedViewing.checked) 
 {
  parent.frame2.f.book.value=f.book.value; 
  getBook(f.book.value, 2);
 }
 setVerseLocation();
}

function moveText(loc,mv)
{
 document.getElementById('chapterSelection').style.visibility='hidden';
 document.getElementById('verseSelection').style.visibility='hidden';

 if(mv=='backChapter')    {f.chapter.value--; f.verse.value=1;}   
 if(mv=='backVerse')      {f.verse.value--;}   
 if(mv=='forwardVerse')   {f.verse.value++;}   
 if(mv=='forwardChapter') {f.chapter.value++; f.verse.value=1;}

 if(f.verse.value==0)   {f.chapter.value--;}
 if(f.chapter.value==0) {f.chapter.value++;}

 if(f.verse.value==0) {f.verse.value=chapterVerses[f.chapter.value];}
 if(f.verse.value>chapterVerses[f.chapter.value]) {f.chapter.value++; f.verse.value=1;}
 if(f.chapter.value>chapterVerses.length-1) {f.chapter.value--; f.verse.value=chapterVerses[f.chapter.value];} 

 setVerseLocation();
}

window.onresize = function(event) 
{
 if(rsFlag==0)
 {
  resizeBookContainer();
  rsFlag = 1;
 }
} 

function resizeBookContainer()
{
   setTimeout('rsFlag = 0',100);

   var myWidth = 0, myHeight = 0;
   if( typeof( window.innerWidth ) == 'number' )
   {
     //Non-IE
     myWidth = window.innerWidth;
     myHeight = window.innerHeight;
    } else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
     //IE 6+ in 'standards compliant mode'
     myWidth = document.documentElement.clientWidth;
     myHeight = document.documentElement.clientHeight;
    } else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
     //IE 4 compatible
     myWidth = document.body.clientWidth;
     myHeight = document.body.clientHeight;
   }

   if(myWidth>0)
   {
    document.getElementById('bookContainer').style.height=(myHeight-120)+'px';
    document.getElementById('bookContainer').style.width=(myWidth-10)+'px';
    document.getElementById('bookSelection').style.width=(myWidth-170)+'px';
    if(document.getElementById('chapterSelection'))
    {
     document.getElementById('chapterSelection').style.width=(myWidth-170)+'px';
     document.getElementById('verseSelection').style.width=(myWidth-170)+'px';
    }
   }
}

function onload_func() {
	f.iso.value = '".$_POST['iso']."';
//	f.book.value = ' '.#_POST['book'].' ';
	f.book.value = '".(isset($_POST['book']) ? $_POST['book'] : '')."';
	
	if (!f.book.value) {
//	if (".!isset($_POST['book']).") {
		f.book.value = bookDescriptions[0];
		getBook(f.book.value, 0);
	}
	else {
//		f.book.value = ' '.#_POST['book'].' ';
		getBook(f.book.value, 0);
		if (parent.frame1.f.syncedViewing.checked) {
			getBook(f.book.value, 2);
		}
	}
	setParallelViewing();
}

window.onload = onload_func;

</script>

<div style=\"float:left;padding-right:10px;\" onclick=\"parent.window.opener.focus();\">
 <img src=\"/images/logoBig.png\" height=\"60px\">
</div>  

<div>
 <span id=\"pvContainer\" name=\"pvContainer\" style=\"visibility:hidden;\">
 <input id=\"parallelViewing\" name=\"parallelViewing\" type=\"checkbox\" onclick=\"setParallelViewing()\" value=\"checked\" ".(isset($_POST['parallelViewing']) ? $_POST['parallelViewing'] : '').">".translate('Parallel', $st, 'sys')." 
 </span>

 <span id=\"svContainer\" name=\"svContainer\" style=\"visibility:hidden;\">
 <input id=\"syncedViewing\" name=\"syncedViewing\" type=\"checkbox\" onclick=\"setSyncedViewing()\" value=\"checked\" ".(isset($_POST['syncedViewing']) ? $_POST['syncedViewing'] : '').">".translate('Synchronized', $st, 'sys')."
 </span>

 <br />
 <select id=\"iso\" name=\"iso\" onchange=\"book.value=''; submit()\";>
  ".$language_options."
 </select>
 
 <script LANGUAGE='JavaScript'>
 //document.getElementById('iso')
 /*sortSelect('iso');
 	function sortSelect(selElem) {
        var tmpAry = new Array();
        for (var i=0;i<selElem.options.length;i++) {
            tmpAry[i] = new Array();
            tmpAry[i][0] = selElem.options[i].text;
            tmpAry[i][1] = selElem.options[i].value;
        }
        tmpAry.sort();
        while (selElem.options.length > 0) {
            selElem.options[0] = null;
        }
        for (var i=0;i<tmpAry.length;i++) {
            var op = new Option(tmpAry[i][0], tmpAry[i][1]);
            selElem.options[i] = op;
        }
        return;
    }*/
</script>

 <br />
 
 <input style=\"border:0px;\" type=\"button\" value=\"<\" onclick=\"nextBook('previous')\">
 
 <input id=\"book\" name=\"book\" style=\"width:100px;\" readonly
  onClick=\"if(document.getElementById('bookSelection').style.visibility=='visible'){document.getElementById('bookSelection').style.visibility='hidden';}
            else{document.getElementById('bookSelection').style.visibility='visible';}
            if(document.getElementById('chapterSelection')){document.getElementById('chapterSelection').style.visibility='hidden'; document.getElementById('verseSelection').style.visibility='hidden';}\">
 
 <div class=\"selectBox\" id=\"bookSelection\" name=\"bookSelection\" style=\"top:75px; left:110px;\">".$book_options."</div>
 
 <input style=\"border:0px;\" type=\"button\" value=\">\" onclick=\"nextBook('forward')\">&nbsp;
 
 <input style=\"border:0px;\" type=\"button\" value=\"<\" onclick=\"moveText(chapter.value,'backChapter')\">
 
 <input id=\"chapter\" name=\"chapter\" style=\"width:20px;\"
  onchange=\"setChapterLocation();\"
  onClick=\"if(document.getElementById('chapterSelection').style.visibility=='visible'){document.getElementById('chapterSelection').style.visibility='hidden';}
            else{document.getElementById('chapterSelection').style.visibility='visible';} document.getElementById('verseSelection').style.visibility='hidden';
                 document.getElementById('bookSelection').style.visibility='hidden';\">
 
 <div class=\"selectBox\" id=\"chapterSelection\" name=\"chapterSelection\" style=\"top:75px; left:110px;\"></div>
 
 <input style=\"border:0px;\" type=\"button\" value=\">\" onclick=\"moveText(chapter.value,'forwardChapter')\">
 
 :
 
 <input id=\"verse\" name=\"verse\" style=\"width:20px;\"
  onchange=\"setVerseLocation();\"
  onClick=\"if(document.getElementById('verseSelection').style.visibility=='visible'){document.getElementById('verseSelection').style.visibility='hidden';}
            else{document.getElementById('verseSelection').style.visibility='visible';} document.getElementById('chapterSelection').style.visibility='hidden';
                 document.getElementById('bookSelection').style.visibility='hidden';\">

<div class=\"selectBox\" id=\"verseSelection\" name=\"verseSelection\" style=\"top:75px; left:110px;\"></div>

<hr>

<div id=\"bookContainer\" style=\"height:100%;\"></div>

</form>
"; 

echo $output;

// php.ini will display error messages
ini_set("display_errors", 1);

?>

</body>
</html>
