<?php
include("include/session.php");
global $session;
/* Login attempt */
$retval = $session->checklogin();
if (!$retval) {
	echo "<br /><div style='text-align: center; font-size: 16pt; font-weight: bold; padding: 10px; color: navy; background-color: #dddddd; '>You are not logged in!</div>";
	/* Link back to main */
	header("Location: login.php");
	exit;
}
/*
		To delete the ISO, ROD Code, and Variant using "ISO_ROD_index" (11/29/17):
	Which record(s)?									table:
	Scripture main record								scripture_main
	National Langauge name record						nav_ln
	ISO countries										ISO_countries
	Interest											interest
	Goto Interest										GotoInterest
	alternate language names							alt_lang_names
	Major language name is English						LN_English
	Major language name is Spanish						LN_Spanish
	Major language name is Portuguese					LN_Portuguese
	Major language name is French						LN_French
	Major language name is Dutch						LN_Dutch
	Major language name is German						LN_German
	Major language name is Chinese						LN_Chinese
	Bible.is, YouVersion, Bibles.org, GooglePlay		links
	Scripture App Builder (SAB)							SAB
	Scripture or Bible									Scripture_and_or_Bible
	OT PDF												OT_PDF_Media
	NT PDF												NT_PDF_Media
	OT Audio											OT_Audio_Media
	NT Audio											NT_Audio_Media
	Viewer												viewer
	Cell Phone											CellPhone
	Study												study
	Watch												watch
	Other titles										other_titles
	Boughten											buy
	Playlist Video										PlaylistVideo
	Playlist Audio										PlaylistAudio
	//eBible list											eBible_list
*/
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Scripture Delete</title>
<style type="text/css">
	div.nav {
		border-top: solid 1px gray;
		border-bottom: solid 1px gray;
		padding-top: 9px;
		padding-bottom: 7px;
		font-weight: bold;
		vertical-align: middle;
		font-size: 11pt;
	}
	div.nav a {
		text-decoration: none;
		color: #006699;
	}
	div.nav a:hover {
		text-decoration: underline;
	}
	h2 {
		margin-top: 30pt;
		margin-bottom: 12pt;
	}
</style>
<script type="text/javascript" language="javascript1.2">
//<!--
	function del(ISO, ROD_Code, ISO_ROD_index) {
		var answer = confirm("This is you LAST try! Are you SURE you want to delete "+ISO+" "+ROD_Code+" from the Datebase?");
		if (answer) {
			//window.location = "http://www.videogamedeals.com";
			parent.location="Scripture_QDelete.php?QDelete="+ISO_ROD_index+"&ISO="+ISO+"&ROD_Code="+ROD_Code;
		}
		else {
			parent.location='Scripture_QDelete.php';
		}
	}
//-->
</script>
</head>
<body style="background-color: #069; margin: 14pt; font-family: Arial, Helvetica, sans-serif; width: 1020px; margin-left: auto; margin-right: auto; ">

<?php
//header("Content-type: text/html; charset=utf-8");

define ("OT_EngBook", 2);
define ("NT_EngBook", 2);

include ("OT_Books.php");
include ("NT_Books.php");
include './include/conn.inc.php';
$db = get_my_db();

function OT_Test($PDF, $OT_Index) {
	global $OT_array;
	
	$a_index = 0;
	foreach ($OT_array[$OT_Index] as $a) {
		if ($PDF == $a_index) return true;
		$a_index++;
	}
	return false;
}

function NT_Test($PDF, $NT_Index) {
	global $NT_array;
	
	$a_index = 0;
	foreach ($NT_array[$NT_Index] as $a) {
		if ($PDF == $a_index) return true;
		$a_index++;
	}
	return false;
}

function check_input($value) {						// used for ' and " that find it in the input
	$value = trim($value);
	if (is_string($value)) {
		$value = implode("", explode("\\", $value));	// get rid of e.g. "\\\\\\\\\\\"
		$value = stripslashes($value);
	}
	$db = get_my_db();
	// Quote if not a number
	if (!is_numeric($value)) {
	  $value = $db->real_escape_string($value);
	}
	return $value;
}

$nav_LN_names = [];											// save all of the LN_... natianal language names
$k=1;
$res=$db->query("SHOW COLUMNS FROM nav_ln");				// the following values are ['Field'], ['Type'], ['Collation'], ['Null'], and ['Key']
while ($row_LN = $res->fetch_assoc()){
	if (preg_match('/^LN_/', $row_LN['Field'])) {
		$nav_LN_names[$k++] = $row_LN['Field'];				// $nav_LN_names see below
	}
}

echo "<div style='background-color: white; padding: 20px; width: 1020px; text-align: center; margin-left: auto; margin-right: auto; '>";
echo "<img src='images/ScriptureEarth.jpg' />";
echo "</div></br />";

echo "<div style='background-color: white; padding: 20px; width: 1020px; margin-left: auto; margin-right: auto; '>";
echo "<h2 style='text-align: center; margin: 0px; color: black; '>Delete a record from the Database</h2>";
if (!isset($_GET["ISO_ROD_index"]) && !isset($_GET["QDelete"])) {
	echo "<br /><br />";
	$query = "SELECT DISTINCT * FROM nav_ln";
	$result=$db->query($query) or die ("Query failed: " . $db->error . "</body></html>");
	if (!$result || ($result->num_rows < 1)) {
		die ("'nav_ln' is not found.</body></html>");
	}

	$db->query("DROP TABLE IF EXISTS LN_Temp");				// Get the names of all of the English languages or else get the default names
	$result_Temp = $db->query("CREATE TEMPORARY TABLE LN_Temp (ISO VARCHAR(3) NOT NULL, ROD_Code VARCHAR(5) NOT NULL, ISO_ROD_index INT NULL, LN VARCHAR(50) NOT NULL) ENGINE = MEMORY CHARSET = utf8")  or die ("Query failed: " . $db->error . "</body></html>");
	$i=0;
	$num=$result->num_rows;
	while ($row = $result->fetch_assoc()) {					// nav_ln table
		$ISO=$row['ISO'];									// ISO
		$ROD_Code=$row['ROD_Code'];							// ROD_Code
		$ISO_ROD_index=$row['ISO_ROD_index'];				// ISO_ROD_index

		$def_LN=$row['Def_LN'];										// default langauge (a 2 digit number for the national langauge)
		if (!$row['LN_English']) {									// = LN_English
			$query="SELECT $nav_LN_names[$def_LN] FROM $nav_LN_names[$def_LN] WHERE ISO_ROD_index = '$ISO_ROD_index'";
			$result_LN=$db->query($query);
			$row_LN = $result_LN->fetch_assoc();
			$LN=$row_LN[$nav_LN_names[$def_LN]];
		}
		else {
			$query="SELECT LN_English FROM LN_English WHERE ISO_ROD_index = '$ISO_ROD_index'";
			$result_LN=$db->query($query);
			$row_LN = $result_LN->fetch_assoc();
			$LN=trim($row_LN['LN_English']);
		}
		$LN = check_input($LN);
		$result_Temp = $db->query("INSERT INTO LN_Temp (ISO, ROD_Code, ISO_ROD_index, LN) VALUES ('$ISO', '$ROD_Code', '$ISO_ROD_index', '$LN')");
	}

	echo "<div style='text-align: center; font-weight: bold; '>Select the beginning of the Language Name:";
	$query = "SELECT DISTINCT LEFT(LN, 1) FROM LN_Temp ORDER BY LN";
	$result=$db->query($query) or die ("Query failed: " . $db->error . "</body></html>");
	if (!$result || ($result->num_rows < 1)) {
		die ("'LN_Temp' is not found.</body></html>");
	}
	$result=$db->query($query);
	while ($row = $result->fetch_array()) {
		echo "&nbsp;&nbsp;<a href='Scripture_QDelete.php?sortby=lang&search=$row[0]'>$row[0]</a>";
	}
	if (isset($_GET["name"]) || (!isset($_GET["name"]) && !isset($_GET["sortby"]))) {		// == 'all'
		echo "</div>";
		echo "<h2>Click on a Language Name</h2>";
		$query="SELECT DISTINCT LN_Temp.LN, scripture_main.* FROM LN_Temp, scripture_main WHERE LN_Temp.ISO_ROD_index = scripture_main.ISO_ROD_index ORDER BY LN_Temp.LN";
	}
	else {
		echo "&nbsp;&nbsp;<a href='Scripture_QDelete.php?sortby=lang&name=all'>[all]</a>";
		echo "</div>";
		echo "<h2>Click on a Language Name that starts with ".$_GET['search']."</h2>";
		$query="SELECT DISTINCT LN_Temp.LN, scripture_main.* FROM LN_Temp, scripture_main WHERE LN_Temp.ISO_ROD_index = scripture_main.ISO_ROD_index AND LN_Temp.LN LIKE '".$_GET['search']."%' ORDER BY LN_Temp.LN";
	}
	$result = $db->query($query);
	$num=$result->num_rows;

	$i=0;
	echo "<table border='0' style='width: 1020px; margin: 0px; padding: 0px; '>";
	echo "<tr valign='bottom' style='text-align: left; color: black; margin: 0px; padding: 0px; '>";
	echo "<th width='30%'>Language Name:</th>";
	echo "<th width='35%'>Alternate Language Name(s):</th>";
	echo "<th width='15%'>Language Code:</th>";
	echo "<th width='20%'>Country(ies):</th>";
	while ($row = $result->fetch_assoc()) {
		$i++;
		if ($i % 2)
			$color = "ffffff";
		else
			$color = "f0f4f0";
		$ISO = $row['ISO'];
		$ROD_Code = $row['ROD_Code'];
		$ISO_ROD_index=$row['ISO_ROD_index'];							// ISO_ROD_index
		$LN = $row['LN'];
		echo "<tr valign='bottom' style='color: black; background-color: #$color; margin: 0px; padding: 0px; '>";
		echo "<td width='30%' style='background-color: #$color; margin: 0px; padding: 3px 5px 3px 5px; border-width: thin; border-style: none; border-color: #$color; '><a href='Scripture_QDelete.php?ISO_ROD_index=$ISO_ROD_index'>$LN</a></td>";
		//$alt_lang_names=$row['scripture_main.alt_lang_names");
		//if ($alt_lang_names > 0) {
		$query_alt="SELECT alt_lang_name FROM alt_lang_names WHERE ISO_ROD_index = '$ISO_ROD_index'";	// alt_lang_names
		$result_alt=$db->query($query_alt);
		if ($result_alt) {
			$num_alt=$result_alt->num_rows;
			echo "<td width='35%' style='background-color: #$color; margin: 0px; padding: 3px 5px 3px 5px; border-width: thin; border-style: none; border-color: #$color; '>";
			$i_alt=0;
			while ($i_alt < $num_alt) {
				if ($i_alt <> 0) {
					echo ", ";
				}
				$row_alt = $result_alt->fetch_assoc();
				$alt_lang_name=trim($row_alt['alt_lang_name']);
				echo "$alt_lang_name";
				$i_alt++;
			}
			echo "</td>";
		}
		else
			echo "<td width='35%'style='margin: 0px; padding: 3px 5px 3px 5px; border-width: thin; border-style: none; border-color: #$color; '>&nbsp;</td>";

		$ISO=trim($row['ISO']);											// ISO
		$ROD_Code=trim($row['ROD_Code']);								// ROD_Code
		echo "<td width='15%'style='margin: 0px; padding: 3px 5px 3px 5px; border-width: thin; border-style: none; border-color: #$color; '>$ISO $ROD_Code</td>";

		$query="SELECT countries.English FROM ISO_countries, countries WHERE ISO_countries.ISO_ROD_index = '$ISO_ROD_index' AND ISO_countries.ISO_countries = countries.ISO_Country ORDER BY countries.English";
		$result_ISO_countries=$db->query($query);
		$num_ISO_countries=$result_ISO_countries->num_rows;
		$row_country = $result_ISO_countries->fetch_assoc();
		$Eng_country = trim($row_country['English']);					// name of the country in the language version
		while ($row_country = $result_ISO_countries->fetch_assoc()) {
			$Eng_country = $Eng_country.', '.trim($row_country['English']);		// name of the country in the language version
		}
		//echo "<td width='20%' style='background-color: #$color; margin: 0px; padding: 3px 5px 3px 5px; border-width: thin; border-style: none; border-color: #$color; '>$Eng_country</td>";
		echo "<td width='20%'style='margin: 0px; padding: 3px 5px 3px 5px; border-width: thin; border-style: none; border-color: #$color; '>$Eng_country</td>";
		echo "</tr>";
		$i++;
	}
	echo "</table>";
	/* Explicitly destroy the table */
	$db->query("DROP TABLE LN_Temp"); 
}
else if (isset($_GET["ISO_ROD_index"])) {
	$ISO_ROD_index = $_GET["ISO_ROD_index"];
	//$ISO = str_replace("%20", " ", $_GET["ISO"]);
	//trim whitespace from variable
	//$ISO = trim($ISO);
	//$search = preg_replace(‘/\s+/’, ‘ ‘, $search); 
	//if ($ISO == NULL OR $ISO == "%") {
	if ($ISO_ROD_index == NULL) {
		die ("'ISO_ROD_index' is empty.</body></html>");
	}
	else {
		$query = "SELECT DISTINCT * FROM nav_ln WHERE ISO_ROD_index = '$ISO_ROD_index'";
		$result=$db->query($query) or die ("Query failed: " . $db->error . "</body></html>");
		if (!$result || ($result->num_rows < 1)) {
			die ("'$ISO_ROD_index' is not found.</body></html>");
		}
		$selected=$result->num_rows;
		--$selected;
		$row = $result->fetch_assoc();
		$ISO = $row['ISO'];
		$ROD_Code = $row['ROD_Code'];
		echo "<h3>Are you sure you want to delete '$ISO $ROD_Code' from the database<br />(but not from the SE 'data' folder)?</h3>";
		//echo "<form action='Scripture_QDelete.php?Delete=".$ISO."'>";
		echo "<form>";
		echo "<div style='text-align: right; '>";
		echo "<input type='button' value='Do it!' onclick='del(\"$ISO\", \"$ROD_Code\", \"$ISO_ROD_index\")' />";
		echo "<input type='reset' value='Reset' onclick='parent.location=\"Scripture_QDelete.php\"' />";
		echo "</div>";
		echo "</form>";	

		$def_LN=$row['Def_LN'];										// default langauge (a 2 digit number for the national langauge)
		if (!$row['LN_English']) {									// = LN_English
			$query="SELECT $nav_LN_names[$def_LN] FROM $nav_LN_names[$def_LN] WHERE ISO_ROD_index = '$ISO_ROD_index'";
			$result_LN=$db->query($query);
			$row_LN = $result_LN->fetch_assoc();
			$LN=trim($row_LN[$nav_LN_names[$def_LN]]);
		}
		else {
			$query="SELECT LN_English FROM LN_English WHERE ISO_ROD_index = '$ISO_ROD_index'";
			$result_LN=$db->query($query);
			$row_LN = $result_LN->fetch_assoc();
			$LN=trim($row_LN['LN_English']);
		}
		echo "<br /><br /><div style='text-align: center; color: navy; font-size: 18pt; font-weight: bold; '>$LN</div><br />";		// the national language

		// alt_lang_name
		$query_alt="SELECT alt_lang_name FROM alt_lang_names WHERE ISO_ROD_index = '$ISO_ROD_index'";
		$result_alt=$db->query($query_alt);
		$num_alt=$result_alt->num_rows;
		if ($result_alt && $num_alt > 0) {
			echo "<div style='text-align: left; color: black; font-size: 11pt; font-weight: normal; '>Alternative Language Names: ";
			$i_alt=0;
			echo "<span style='color: navy; font-size: 11pt; font-weight: normal; '>";
			while ($i_alt < $num_alt) {
				if ($i_alt <> 0) {
					echo ", ";
				}
				$row_alt=$result_alt->fetch_assoc();
				$alt_lang_name=trim($row_alt['alt_lang_name']);
				echo "$alt_lang_name";
				$i_alt++;
			}
			echo "</span></div>";
		}
		
		// Country
		$query="SELECT countries.English FROM ISO_countries, countries WHERE ISO_countries.ISO_ROD_index = '$ISO_ROD_index' AND ISO_countries.ISO_countries = countries.ISO_Country";
		$result_ISO_countries=$db->query($query);
		$num_ISO_countries=$result_ISO_countries->num_rows;
		$row_ISO_countries = $result_ISO_countries->fetch_assoc();
		$Eng_country = trim($row_ISO_countries['English']);					// name of the country in the language version
		while ($row_ISO_countries = $result_ISO_countries->fetch_assoc()) {
			$Eng_country = $Eng_country.', '.trim($row_ISO_countries['English']);					// name of the country in the language version
		}
		echo "<div style='text-align: left; color: black; font-size: 11pt; font-weight: normal; '>Country: <span style='color: navy; font-size: 11pt; '>$Eng_country</span></div>";

		echo "<div style='text-align: left; color: black; font-size: 11pt; font-weight: normal; '>ISO Code: <span style='color: navy; font-size: 11pt; font-weight: normal; '>$ISO</span></div>";

		echo "<div style='text-align: left; color: black; font-size: 11pt; font-weight: normal; '>ROD Code: <span style='color: navy; font-size: 11pt; font-weight: normal; '>$ROD_Code</span></div>";
		
		
		$query="SELECT DISTINCT * FROM scripture_main WHERE ISO_ROD_index = '$ISO_ROD_index'";
		$result=$db->query($query);
		$row = $result->fetch_assoc();

		$media_type_PDF=$row['OT_PDF'];
		if ($media_type_PDF) {
			echo "<br />";
			echo "<div style='color: black; font-size: 15pt; font-weight: bold; '>OT Scripture in PDF</div>";
			echo "<div style='color: navy; font-size: 12pt; font-weight: normal; '><em>Click a book to read it:</em></div>";
			$OT_Found = 0;
			$query="SELECT * FROM OT_PDF_Media WHERE ISO_ROD_index = '$ISO_ROD_index' AND OT_PDF = 'OT'";
			$result1=$db->query($query);
			if (!$result1) {
				die('Could not insert the data "OT_PDF_Media": ' .$db->error);
			}
			else {
				$num=$result1->num_rows;
				if ($num > 0) {
					$row_OT_PDF = $resultl->fetch_assoc();
					$OT_PDF_Filename = trim($row_OT_PDF['OT_PDF_Filename']);
					echo "The whole <a href='data/$ISO/PDF/$OT_PDF_Filename' target='_blank'>Old Testament</a>";
					$OT_Found = 1;
				}
			}
			$query="SELECT * FROM OT_PDF_Media WHERE ISO_ROD_index = '$ISO_ROD_index' AND OT_PDF != 'OT'";
			$result1=$db->query($query);
			$num=$result1->num_rows;
			if ($num > 0) {
				if ($OT_Found) {
					echo " or<br />";
				}
				$i=0;
				$a_index = 0;
				foreach ($OT_array[2] as $a) {
					$query_array="SELECT * FROM OT_PDF_Media WHERE ISO_ROD_index = '$ISO_ROD_index' AND OT_PDF = '$a_index'";
					$result_array=$db->query($query_array);
					if (!$result_array) {
						//die('Could not insert the data "NT_PDF_Media": ' . $result_array->error());
					}
					else {
						$num=$result_array->num_rows;
						if ($num > 0) {
							$row_array = $result_array->fetch_assoc();
							$OT_PDF_Filename = trim($row_array['OT_PDF_Filename']);
							$a = str_replace(" ", "&nbsp;", $a);
							if (!empty($OT_PDF_Filename)) {
								echo " &nbsp;&nbsp;<a href='data/$ISO/PDF/$OT_PDF_Filename' target='_blank'>$a</a>";
							}
						}
					}
					$a_index++;
				}
			}
			echo "<br />";
		}

		$media_type_PDF=$row['NT_PDF'];
		if ($media_type_PDF) {
			echo "<br />";
			echo "<div style='color: black; font-size: 15pt; font-weight: bold; '>NT Scripture in PDF</div>";
			echo "<div style='color: navy; font-size: 12pt; font-weight: normal; '><em>Click a book to read it:</em></div>";
			$NT_Found = 0;
			$query="SELECT * FROM NT_PDF_Media WHERE ISO_ROD_index = '$ISO_ROD_index' AND NT_PDF = 'NT'";
			$result1=$db->query($query);
			if (!$result1) {
				die('Could not insert the data "NT_PDF_Media": ' . $db->error);
			}
			else {
				$num=$result1->num_rows;
				if ($num > 0) {
					$row_NT_PDF = $result1->fetch_assoc();
					$NT_PDF_Filename = trim($row_NT_PDF['NT_PDF_Filename']);
					echo "The whole <a href='data/$ISO/PDF/$NT_PDF_Filename' target='_blank'>New Testament</a>";
					$NT_Found = 1;
				}
			}
			$query="SELECT * FROM NT_PDF_Media WHERE ISO_ROD_index = '$ISO_ROD_index' AND NT_PDF != 'NT'";
			$result1=$db->query($query);
			$num=$result1->num_rows;
			if ($num > 0) {
				if ($NT_Found) {
					echo " or<br />";
				}
				$i=0;
				$a_index = 0;
				foreach ($NT_array[2] as $a) {
					$query_array="SELECT * FROM NT_PDF_Media WHERE ISO_ROD_index = '$ISO_ROD_index' AND NT_PDF = '$a_index'";
					$result_array=$db->query($query_array);
					if (!$result_array) {
						//die('Could not insert the data "NT_PDF_Media": ' . $result_array->error());
					}
					else {
						$num=$result_array->num_rows;
						if ($num > 0) {
							$row_array = $result_array->fetch_assoc();
							$NT_PDF_Filename = trim($row_array['NT_PDF_Filename']);
							$a = str_replace(" ", "&nbsp;", $a);
							if (!empty($NT_PDF_Filename)) {
								echo " &nbsp;&nbsp;<a href='data/$ISO/PDF/$NT_PDF_Filename' target='_blank'>$a</a>";
							}
						}
					}
					$a_index++;
				}
			}
			echo "<br />";
		}

		$media_type_audio=$row['OT_Audio'];
		if ($media_type_audio) {
			echo "<br /><br />";
			$OT_Found = 0;
			$query="SELECT * FROM OT_Audio_Media WHERE ISO_ROD_index = '$ISO_ROD_index' AND media_type_audio = 'OT'";
			$result2=$db->query($query);
			if (isset($result2)) {
				echo "<div style='color: black; font-size: 15pt; font-weight: bold; '>OT Scripture in audio (mp3)</div>";
				$OT_Found = 1;
			}
			$query="SELECT * FROM OT_Audio_Media WHERE ISO_ROD_index = '$ISO_ROD_index'";
			$result2=$db->query($query);
			$num=$result2->num_rows;
			if ($result2 && $num > 0) {
				echo "<div style='color: navy; font-size: 12pt; font-weight: normal; '><em>Click a chapter number to listen to it:</em></div>";
				if ($OT_Found) {
					echo "<span style='color: navy; '>Old Testament</span><br />";
					$a_index = 0;
					foreach ($OT_array[2] as $a) {
						$query_array="SELECT * FROM OT_Audio_Media WHERE ISO_ROD_index = '$ISO_ROD_index' AND OT_Audio_Book = '$a_index' AND (OT_Audio_Filename is not null AND trim(OT_Audio_Filename) <> '')";
						$result_array=$db->query($query_array);
						$num_array=$result_array->num_rows;
						if ($result_array && $num_array > 0) {
							echo "&nbsp;&nbsp;$a: &nbsp;";
							while ($row_array = $result_array->fetch_assoc()) {
								$OT_Audio_Filename = trim($row_array['OT_Audio_Filename']);
								if (!empty($OT_Audio_Filename)) {
									$OT_Audio_Chapter = trim($row_array['OT_Audio_Chapter']);
									echo "&nbsp;<a style='font-size: 11pt; ' href='data/$ISO/audio/$OT_Audio_Filename' target='_blank'>$OT_Audio_Chapter</a> &nbsp;";
								}
							}
							echo "<br />";
						}
						$a_index++;
					}
				}
				$i=0;
				while ($row_OT_Audio = $result2->fetch_assoc()) {
					$OT_Audio_Book=trim($row_OT_Audio['OT_Audio_Book']);
					if ($OT_Audio_Book != "OT") {
						if ($OT_Found && OT_Test($OT_Audio_Book, 2)) {
						//echo "";
						}
						else echo "$OT_Audio_Book<br />";
					}
				}
			}
			echo "<br />";
		}

		$media_type_audio=$row['NT_Audio'];
		if ($media_type_audio) {
			echo "<br />";
			$NT_Found = 0;
			$query="SELECT * FROM NT_Audio_Media WHERE ISO_ROD_index = '$ISO_ROD_index' AND media_type_audio = 'NT'";
			$result2=$db->query($query);
			if (isset($result2)) {
				echo "<div style='color: black; font-size: 15pt; font-weight: bold; '>NT Scripture in audio (mp3)</div>";
				$NT_Found = 1;
			}
			$query="SELECT * FROM NT_Audio_Media WHERE ISO_ROD_index = '$ISO_ROD_index'";
			$result2=$db->query($query);
			$num=$result2->num_rows;
			if ($result2 && $num > 0) {
				echo "<div style='color: navy; font-size: 12pt; font-weight: normal; '><em>Click a chapter number to listen to it:</em></div>";
				if ($NT_Found) {
					echo "<span style='color: navy; '>New Testament</span><br />";
					$a_index = 0;
					foreach ($NT_array[2] as $a) {
						$query_array="SELECT * FROM NT_Audio_Media WHERE ISO_ROD_index = '$ISO_ROD_index' AND NT_Audio_Book = '$a_index' AND (NT_Audio_Filename is not null AND trim(NT_Audio_Filename) <> '')";
						$result_array=$db->query($query_array);
						$num_array=$result_array->num_rows;
						if ($result_array && $num_array > 0) {
							//$NT_Audio_Book = trim(mysql_result($result_array,0,"NT_Audio_Book"));
							//$NT_Audio_Book = str_replace(" ", "&nbsp;", $NT_Audio_Book);
							echo "&nbsp;&nbsp;$a: &nbsp;";
							$i=0;
							while ($row_NT_Audio = $result_array->fetch_assoc()) {
								$NT_Audio_Filename = trim($row_NT_Audio['NT_Audio_Filename']);
								if (!empty($NT_Audio_Filename)) {
									$NT_Audio_Chapter = trim($row_NT_Audio['NT_Audio_Chapter']);
									echo "&nbsp;<a style='font-size: 11pt; ' href='data/$ISO/audio/$NT_Audio_Filename' target='_blank'>$NT_Audio_Chapter</a> &nbsp;";
								}
								$i++;
							}
							echo "<br />";
						}
						$a_index++;
					}
					//echo "<br />";
					//Mateo&nbsp;&nbsp;Marcos&nbsp;&nbsp;Lucas&nbsp;&nbsp;Juan&nbsp;&nbsp;Hechos&nbsp;&nbsp;Romanos&nbsp;&nbsp;1 Corintios&nbsp;&nbsp;2 Corintios&nbsp;&nbsp;Gálatas&nbsp;&nbsp;Efesios&nbsp;&nbsp;Filipenses&nbsp;&nbsp;Colosenses&nbsp;&nbsp;1 Tesalonicenses&nbsp;&nbsp;2 Tesalonicenses&nbsp;&nbsp;1 Timoteo&nbsp;&nbsp;2 Timoteo&nbsp;&nbsp;Tito&nbsp;&nbsp;Filemón&nbsp;&nbsp;Hebreos&nbsp;&nbsp;Santiago&nbsp;&nbsp;1 Pedro&nbsp;&nbsp;2 Pedro&nbsp;&nbsp;1 Juan&nbsp;&nbsp;2 Juan&nbsp;&nbsp;3 Juan&nbsp;&nbsp;Judas&nbsp;&nbsp;Apocalipsis";
				}
				$i=0;
				while ($row_NT_Audio = $result2->fetch_assoc()) {
					$NT_Audio_Book=trim($row_NT_Audio['NT_Audio_Book']);
					if ($NT_Audio_Book != "NT") {
						if ($NT_Found && NT_Test($NT_Audio_Book, 2)) {
						//echo "";
						}
						else echo "$NT_Audio_Book<br />";
					}
					$i++;
				}
			}
			echo "<br />";
		}

		$watch=$row['watch'];
		if ($watch) {
			echo "<br />";
			$query="SELECT * FROM watch WHERE ISO_ROD_index = '$ISO_ROD_index'";
			$result2=$db->query($query);
			$num=$result2->num_rows;
			if ($result2 && $num > 0) {
				//echo "<br />";
				echo "<div style='color: black; font-size: 15pt; font-weight: bold; '>Watch:</div>";
				while ($row_watch = $result2->fetch_assoc()) {
					$WatchWebSource=trim($row_watch['organization']);
					$WatchResource=trim($row_watch['watch_what']);
					$WebURL=trim($row_watch['URL']);
					echo "&nbsp;&nbsp;$WatchWebSource:";
					if (!empty($WebURL)) echo "&nbsp;&nbsp;<a href='$WebURL' target='_blank'>$WatchResource</a>";
					echo "<br />";
				}
			}
		}

		$buy=$row['buy'];
		if ($buy) {
			echo "<br />";
			$query="SELECT * FROM buy WHERE ISO_ROD_index = '$ISO_ROD_index'";
			$result2=$db->query($query);
			$num=$result2->num_rows;
			if ($result2 && $num > 0) {
				//echo "<br />";
				echo "<div style='color: black; font-size: 15pt; font-weight: bold; '>Buy:</div>";
				while ($row_buy = $result2->fetch_assoc()) {
					$BuyWebSource=trim($row_buy['organization']);
					$BuyResource=trim($row_buy['buy_what']);
					$BuyURL=trim($row_buy['URL']);
					echo "&nbsp;&nbsp;$BuyWebSource:";
					if (!empty($BuyURL)) echo "&nbsp;&nbsp;<a href='$BuyURL' target='_blank'>$BuyResource</a>";
					echo "<br />";
				}
			}
		}

		$study=$row['study'];
		if ($study) {
			echo "<br />";
			$query="SELECT * FROM study WHERE ISO_ROD_index = '$ISO_ROD_index'";
			$result2=$db->query($query);
			$num=$result2->num_rows;
			if ($result2 && $num > 0) {
				//echo "<br />";
				echo "<div style='color: black; font-size: 15pt; font-weight: bold; '>Study:</div>";
				while ($row_study = $result2->fetch_assoc()) {
					$ScriptureDescription=trim($row_study['ScriptureDescription']);
					$ScriptureURL=trim($row_study['ScriptureURL']);
					echo "&nbsp;&nbsp;<a href='#' alt='Download $ISO $ROD_Code NT' onclick='Study(\"$ISO\", \"$ScriptureURL\")'>$ScriptureDescription</a>&nbsp;";
					$statement=trim($row_study['statement']);
					echo $statement;
					$othersiteDescription=trim($row_study['othersiteDescription']);
					$othersiteURL=trim($row_study['othersiteURL']);
					echo "&nbsp;<a href='$othersiteURL' target='_blank'>$othersiteDescription</a>";
					echo "<br />";
				}
			}
		}

		$other_titles=$row['other_titles'];
		if ($other_titles) {
			echo "<br />";
			$query="SELECT * FROM other_titles WHERE ISO_ROD_index = '$ISO_ROD_index'";
			$result2=$db->query($query);
			$num=$result2->num_rows;
			if ($result2 && $num > 0) {
				echo "<div style='color: black; font-size: 15pt; font-weight: bold; '>Other Titles:</div>";
				while ($row_other_titles = $result2->fetch_assoc()) {
					$other=trim($row_other_titles['other']);
					$other_title=trim($row_other_titles['other_title']);
					$other_PDF=trim($row_other_titles['other_PDF']);
					$other_audio=trim($row_other_titles['other_audio']);
					echo "&nbsp;&nbsp;$other:&nbsp;$other_title";
					if (!empty($other_PDF)) echo "&nbsp;&nbsp;<a href='data/$ISO/PDF/$other_PDF' target='_blank'>Read</a>";
					if (!empty($other_audio)) echo "&nbsp;&nbsp;<a href='data/$ISO/audio/$other_audio' target='_blank'>Listen</a>";
					echo "<br />";
				}
				//echo "<br />";
			}
		}

		$links=$row['links'];
		if ($links) {
			echo "<br />";
			$query="SELECT * FROM links WHERE ISO_ROD_index = '$ISO_ROD_index'";
			$result2=$db->query($query);
			$num=$result2->num_rows;
			if ($result2 && $num > 0) {
				//echo "<br />";
				echo "<div style='color: black; font-size: 15pt; font-weight: bold; '>Links:</div>";
				while ($row_links = $result2->fetch_assoc()) {
					$company_title=trim($row_links['company_title']);
					$company=trim($row_links['company']);
					$URL=trim($row_links['URL']);
					echo "&nbsp;&nbsp;$company_title:";
					if (!empty($URL)) echo "&nbsp;&nbsp;<a href='$URL' target='_blank'>$company</a>";
					echo "<br />";
				}
			}
		}
	
		$SAB=$row['SAB'];
		if ($SAB) {
			echo "<br />";
			$query="SELECT * FROM SAB WHERE ISO_ROD_index = '$ISO_ROD_index'";
			$result2=$db->query($query);
			$num=$result2->num_rows;
			if ($result2 && $num > 0) {
				echo "<div style='color: black; font-size: 15pt; font-weight: bold; '>Scripture App Builder (SAB) (mp3 and text)</div>";
				$i=0;
				while ($row_SAB = $result2->fetch_assoc()) {
					$i++;
					$Book_Chapter_HTML = trim($row_SAB['Book_Chapter_HTML']);
					echo "$ISO/SAB/$Book_Chapter_HTML&nbsp;&nbsp;";
					if ($i % 5 == 0) { echo '<br />'; }
				}
			}
		}

		$viewer=$row['viewer'];
		if ($viewer) {
			echo "<br />";
			$query="SELECT * FROM viewer WHERE ISO_ROD_index = '$ISO_ROD_index'";
			$result2=$db->query($query);
			$num=$result2->num_rows;
			if ($result2 && $num > 0) {
				//echo "<br />";
				echo "<div style='color: black; font-size: 15pt; font-weight: bold; '>Viewer:</div>";
				while ($row_viewer = $result2->fetch_assoc()) {
					$viewer_ROD_Variant = trim($row_viewer['viewer_ROD_Variant']);
					echo $viewer_ROD_Variant;
				}
			}
		}
		
		$CellPhone=$row['CellPhone'];
		if ($CellPhone) {
			echo "<br />";
			$query="SELECT * FROM CellPhone WHERE ISO_ROD_index = '$ISO_ROD_index'";
			$result2=$db->query($query);
			$num=$result2->num_rows;
			if ($result2 && $num > 0) {
				//echo "<br />";
				echo "<div style='color: black; font-size: 15pt; font-weight: bold; '>Cell Phone:</div>";
				while ($row_CellPhone = $result2->fetch_assoc()) {
					$Cell_Phone_Title = trim($row_CellPhone['Cell_Phone_Title']);
					$Cell_Phone_File = trim($row_CellPhone['Cell_Phone_File']);
					echo 'Cell Phone Filename: ' . $Cell_Phone_File . ' -> ' . $Cell_Phone_Title . '<br />';
				}
			}
		}
		
		$PlaylistVideo=$row['PlaylistVideo'];
		if ($PlaylistVideo) {
			echo "<br />";
			$query="SELECT * FROM PlaylistVideo WHERE ISO_ROD_index = '$ISO_ROD_index'";
			$result2=$db->query($query);
			$num=$result2->num_rows;
			if ($result2 && $num > 0) {
				//echo "<br />";
				echo "<div style='color: black; font-size: 15pt; font-weight: bold; '>Playlist Video:</div>";
				while ($row_PlaylistVideo = $result2->fetch_assoc()) {
					$PlaylistVideoTitle = trim($row_PlaylistVideo['PlaylistVideoTitle']);
					$PlaylistVideoFilename = trim($row_PlaylistVideo['PlaylistVideoFilename']);
					echo 'Video Filename: ' . $PlaylistVideoFilename . ' -> ' . $PlaylistVideoTitle . '&nbsp;&nbsp;';
				}
			}
			echo "<br />";
		}
		
		$PlaylistAudio=$row['PlaylistAudio'];
		if ($PlaylistAudio) {
			echo "<br />";
			$query="SELECT * FROM PlaylistAudio WHERE ISO_ROD_index = '$ISO_ROD_index'";
			$result2=$db->query($query);
			$num=$result2->num_rows;
			if ($result2 && $num > 0) {
				//echo "<br />";
				echo "<div style='color: black; font-size: 15pt; font-weight: bold; '>Playlist Audio:</div>";
				while ($row_PlaylistAudio = $result2->fetch_assoc()) {
					$PlaylistAudioTitle = trim($row_PlaylistAudio['PlaylistAudioTitle']);
					$PlaylistAudioFilename = trim($row_PlaylistAudio['PlaylistAudioFilename']);
					echo 'Audio Filename: ' . $PlaylistAudioFilename . ' -> ' . $PlaylistAudioTitle . '&nbsp;&nbsp;';
				}
			}
			echo "<br />";
		}
		
		/*
		$eBible=$row['eBible'];
		if ($eBible) {
			echo "<br />";
			$query="SELECT translationId, vernacularTitle FROM eBible_list WHERE ISO_ROD_index = '$ISO_ROD_index'";
			$result2=$db->query($query);
			$num=$result2->num_rows;
			if ($result2 && $num > 0) {
				//echo "<br />";
				echo "<div style='color: black; font-size: 15pt; font-weight: bold; '>eBible List:</div>";
				while ($row_eBible = $result2->fetch_assoc()) {
					$translationId = trim($row_eBible['translationId']);
					$vernacularTitle = trim($row_eBible['vernacularTitle']);
					echo 'Publication URL: ' . $translationId . ' -> ' . $vernacularTitle . '&nbsp;&nbsp;';
				}
			}
			echo "<br />";
		*/
	}
}
else if (isset($_GET["QDelete"])) {
	$ISO_ROD_index = $_GET["QDelete"];
	$ISO=$_GET["ISO"];											// ISO
	$ROD_Code=$_GET["ROD_Code"];								// ROD_Code
	$query = "DELETE FROM scripture_main WHERE ISO_ROD_index = '$ISO_ROD_index'";
	$db->query($query);
	$query = "DELETE FROM nav_ln WHERE ISO_ROD_index = '$ISO_ROD_index'";
	$db->query($query);
	$query = "DELETE FROM ISO_countries WHERE ISO_ROD_index = '$ISO_ROD_index'";
	$db->query($query);
	$query = "DELETE FROM alt_lang_names WHERE ISO_ROD_index = '$ISO_ROD_index'";
	$db->query($query);
	$query = "DELETE FROM Scripture_and_or_Bible WHERE ISO_ROD_index = '$ISO_ROD_index'";
	$db->query($query);
	$query = "DELETE FROM OT_PDF_Media WHERE ISO_ROD_index = '$ISO_ROD_index'";
	$db->query($query);
	$query = "DELETE FROM NT_PDF_Media WHERE ISO_ROD_index = '$ISO_ROD_index'";
	$db->query($query);
	$query = "DELETE FROM OT_Audio_Media WHERE ISO_ROD_index = '$ISO_ROD_index'";
	$db->query($query);
	$query = "DELETE FROM NT_Audio_Media WHERE ISO_ROD_index = '$ISO_ROD_index'";
	$db->query($query);
	$query = "DELETE FROM watch WHERE ISO_ROD_index = '$ISO_ROD_index'";
	$db->query($query);
	$query = "DELETE FROM buy WHERE ISO_ROD_index = '$ISO_ROD_index'";
	$db->query($query);
	$query = "DELETE FROM study WHERE ISO_ROD_index = '$ISO_ROD_index'";
	$db->query($query);
	$query = "DELETE FROM other_titles WHERE ISO_ROD_index = '$ISO_ROD_index'";
	$db->query($query);
	$query = "DELETE FROM links WHERE ISO_ROD_index = '$ISO_ROD_index'";
	$db->query($query);
	$query = "DELETE FROM interest WHERE ISO_ROD_index = '$ISO_ROD_index'";
	$db->query($query);
	$query = "DELETE FROM GotoInterest WHERE ISO_ROD_index = '$ISO_ROD_index'";
	$db->query($query);
	$query = "DELETE FROM LN_English WHERE ISO_ROD_index = '$ISO_ROD_index'";
	$db->query($query);
	$query = "DELETE FROM LN_Spanish WHERE ISO_ROD_index = '$ISO_ROD_index'";
	$db->query($query);
	$query = "DELETE FROM LN_Portuguese WHERE ISO_ROD_index = '$ISO_ROD_index'";
	$db->query($query);
	$query = "DELETE FROM LN_French WHERE ISO_ROD_index = '$ISO_ROD_index'";
	$db->query($query);
	$query = "DELETE FROM LN_Dutch WHERE ISO_ROD_index = '$ISO_ROD_index'";
	$db->query($query);
	$query = "DELETE FROM LN_German WHERE ISO_ROD_index = '$ISO_ROD_index'";
	$db->query($query);
	$query = "DELETE FROM LN_Chinese WHERE ISO_ROD_index = '$ISO_ROD_index'";
	$db->query($query);
	$query = "DELETE FROM SAB WHERE ISO_ROD_index = '$ISO_ROD_index'";
	$db->query($query);
	$query = "DELETE FROM viewer WHERE ISO_ROD_index = '$ISO_ROD_index'";
	$db->query($query);
	$query = "DELETE FROM CellPhone WHERE ISO_ROD_index = '$ISO_ROD_index'";
	$db->query($query);
	$query = "DELETE FROM PlaylistVideo WHERE ISO_ROD_index = '$ISO_ROD_index'";
	$db->query($query);
	$query = "DELETE FROM PlaylistAudio WHERE ISO_ROD_index = '$ISO_ROD_index'";
	$db->query($query);
	//$query = "DELETE FROM eBible_list WHERE ISO_ROD_index = '$ISO_ROD_index'";
	//$db->query($query);
	echo "<h3>'$ISO $ROD_Code' has been deleted from the database (but not from the SE 'data' folder).</h3>";
	echo "<form>";
	echo "<input type='reset' value='Go back to the Delete script' onclick='parent.location=\"Scripture_QDelete.php\"' />";
	echo "</form>";	
}
else
	die ("Reference is not found.</body></html>");

echo "</div>";
echo "<br />";
echo "<div style='text-align: center; background-color: #333333; margin: 0px auto 0px auto; padding: 20px; width: 1020px; '>";
//echo "<img src='images/top_wbtc_logo.gif' />";
echo "<div class='nav' style='font-weight: normal; color: white; font-size: 10pt; '><sup>©</sup>2009 - ".date('Y')." ScriptureEarth.org</div>";
echo "</div>";
//mysql_close();
?>

</body>
</html>