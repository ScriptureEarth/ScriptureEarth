<?php
// Change PHP.ini from max_input_vars = 1000 to max_input_vars = 3000 because POST has to be set for 3000!

/*************************************************************************************************************************************
 *
 * 			CAREFUL when your making any additions! Any "onclick", "change", etc. that occurs on "input", "a", "div", etc.
 * 			should be placed in "_js/CMS_events.js". Also, in "_js/CMS_events.js" any errors in previous statements will
 * 			not works in any of the satesments then on. It can also help in the Firefox browser (version 79.0+) run
 * 			"Scripture_Edit.php", menu "Tools", "Web developement", and "Toggle Tools". Then menu "Debugger". In the left
 * 			side of the windows click on "Scripture Edit", Localhost", "_js", and "CMS_events.js". Look down the js file
 * 			and find out if there are errors using the "underline" indicator and fix them if there are any. You can also
 * 			use "Scripture_Edit.php" just to make sure that the document.getElementById('...') name is corrent.
 *  		But, BE CAREFUL!
 *
**************************************************************************************************************************************/

include './include/session.php';
global $session;
/* Login attempt */
$retval = $session->checklogin();
if (!$retval) {
	/* Link back to the main page */
	header('Location: login.php');
	exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type"				content="text/html; charset=utf-8" />
<meta http-equiv="Content-Script-Type"		content="text/javascript" />
<meta name="ObjectType" 					content="Document" />
<meta http-equiv="Window-target" 			content="_top" />
<meta name="Created-by" 					content="Scott Starker" />
<title>Scripture Edit</title>
<link type="text/css" rel="stylesheet" href="_css/Scripture_Edit.css" />
<script type="text/javascript" language="javascript" src="_js/jquery-1.10.1.min.js"></script>
<script type="text/javascript" language="JavaScript" src="_js/AddorChange.js?v=1.1.3"></script>
<!-- see the bottom of this html file for CMS_events.js -->
</head>
<body>

<?php
function check_input($value) {
	return trim($value);
}

// To tie the script together and prevent direct access to Edit_Lang_Validation.php and SumbitEditConfirm.php.
define('RIGHT_ON', true);

// To hold error messages
$messages = [];
 
// Default input values (later, sanitized $_POST inputs)
$inputs = ['iso' => ''];
$inputs = ['rod' => ''];
$inputs = ['var' => ''];

include './OT_Books.php';
include './NT_Books.php';
include './include/conn.inc.php';
$db = get_my_db();

// Checks that the form was submitted after Scripture_Edit.php submitted.
if (isset($_POST['btnSubmit'])) {
	// Runs the validation script which only returns to the form page if validation fails.
	require_once './Edit_Lang_Validation.php';
	// Returns from Edit_Lang_Validation.php if the validation failed.
}

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

	$GetName = 'all';
	$which = 'Name';
	$st = 'en';

	$MajorLanguage = "LN_English";
	$SpecificCountry = "countries.English";
	$Scriptname = basename($_SERVER["SCRIPT_NAME"]);
	$counterName = "English";
	$MajorCountryAbbr = "en";

	echo "<div class='content' style='background-color: white; padding: 20px; width: 1020px; height: 100px; margin-left: auto; margin-right: auto; vertical-align: middle; border-radius: 15px; -moz-border-radius: 15px; -webkit-box-shadow: 15px; '>";
	echo "<img style='margin-left: 40px; ' src='images/guyReading.png' /><div style='text-align: center; margin-top: -60px; margin-left: 180px; font-size: 18pt; font-weight: bold; color: black; '>Edit the ScriptureEarth Database</div>";
	echo "</div><br />";
	echo "<div style='background-color: white; padding: 20px; width: 1020px; margin-left: auto; margin-right: auto; border-radius: 15px; -moz-border-radius: 15px; -webkit-box-shadow: 15px; '>";
	echo "<a style='float: right; font-size: small; font-weight: normal; vertical-align: bottom; margin: 10px 10px 0px 0px; ' href='process.php'>[Logout]</a>";
	echo "<a style='float: right; font-size: small; font-weight: normal; vertical-align: bottom; margin: 10px 10px 0px 0px; ' href='Scripture_Add.php'>[Scripture Add]</a>";
	echo "<a style='float: right; font-size: small; font-weight: normal; vertical-align: bottom; margin: 10px 10px 0px 0px; ' href='Scripture_Edit.php'>[Scripture Edit]</a>";

/************************************************
\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/
	if $_GET does NOT have idx
\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/
************************************************/

	if (!isset($_GET["idx"])) {
		?>
        <br />
        <label for='iso_idx'>ISO code or idx to edit: </label>
        <input type="text" id="iso_idx" name="iso_idx" autofocus size='18' maxtlength='4' pattern="([a-z]{3}|0-9]{1,4})" placeholder="3 lowercase or number" title="ISO code or index number" value='' />
        &nbsp;&nbsp;<input type="button" value="OK" id="iso_idx_goto" onClick="iso_idx()" /> 
        <div id='iso_response'></div>
		<?php
		echo "<h2><span style='color: red; font-size: bold; '>Or</span> Choose the 'pencil' to edit</h2>";
		$query = "SELECT DISTINCT * FROM nav_ln ORDER BY ISO, ROD_Code";			// get all of the navigational language names
		$result = $db->query($query);
		/**********************************************************************************************************************
				select the default primary language name to be used by displaying the Countries and indigenous langauge names
		**********************************************************************************************************************/
		// languages
		$db->query('DROP TABLE IF EXISTS LN_Temp');							// Get the names of all of the major languages or else get the default names
		$db->query('CREATE TEMPORARY TABLE LN_Temp (iso VARCHAR(3) NOT NULL, rod VARCHAR(5) NOT NULL, idx INT NULL, LN VARCHAR(50) NOT NULL) ENGINE = MEMORY CHARSET = utf8') or die ('Query failed: ' . $db->error . '</body></html>');

		$stmt = $db->prepare("INSERT INTO LN_Temp (iso, rod, idx, LN) VALUES (?, ?, ?, ?)");
		while($row = $result->fetch_assoc()) {
			$iso = $row['ISO'];									// ISO
			$rod = $row['ROD_Code'];							// ROD_Code
			$var = $row['Variant_Code'];						// Variant_Code
			$idx = $row['ISO_ROD_index'];						// ISO_ROD_index
			
			$ISO_ROD_index = (string)$idx;												// make sure that 00-DBLanguageCountryName.inc.php will work correctly
			include './include/00-DBLanguageCountryName.inc.php';
	
			$stmt->bind_param("ssis", $iso, $rod, $idx, $LN);							// bind parameters for markers
			$stmt->execute();															// execute query
		}
		$stmt->close();
		// Letters
		?>
		<div id='Letters'>
            <table class='languageNames'>
                <tr valign='middle'>
                    <td width='90%'>
                        <?php
                        $Letter = "";
                        $number = 2;
                        $BegLetters=str_replace(' ', '&nbsp;', 'Select the beginning of the Language Name:') . '&nbsp;&nbsp;';
                        $query = 'SELECT DISTINCT UPPER(LEFT(LN, 1)) AS Beg FROM LN_Temp ORDER BY LN';
                        $resultLetter = $db->query($query);
                        while ($row = $resultLetter->fetch_assoc()) {
                            $BegLetter = $row['Beg'];
                            if (!isset($_GET["Beg"]) || $_GET["Beg"] == "" || $_GET["Beg"] == $BegLetter) {
                                $BegLetters=$BegLetters . "<a style='text-decoration: underline; color: red; ' href='#' onclick='Switch(" . $number . ", \"" . $BegLetter . "\")'>" . $BegLetter . "</a>&nbsp;&nbsp;";
                                $Letter = $BegLetter;
                                $_GET['Beg'] = $BegLetter;
                            }
                            else
                                $BegLetters=$BegLetters . "<a style='text-decoration: underline; ' href='#' onclick='Switch(" . $number . ", \"" . $BegLetter . "\")'>" . $BegLetter . "</a>&nbsp;&nbsp;";
                        }
                        if ($_GET["Beg"] == 'all')
                            $BegLetters=$BegLetters . "[<a style='text-decoration: underline; color: red; ' href='#' onclick='Switch(" . $number . ", \"all\")'>All</a>]";
                        else
                            $BegLetters=$BegLetters . "[<a style='text-decoration: underline; ' href='#' onclick='Switch(" . $number . ", \"all\")'>" . "All" . "</a>]";
                        echo "<div id='BeginningLetters' style='margin-top: 10px; margin-bottom: 10px; font-weight: bold; '>$BegLetters</div>";
                        ?>
                    </td>
                    <td width='10%'>&nbsp;
                    </td>
                </tr>
            </table>
		</div>

		<?php
		$resultLetter->free();
		// switch
		// language name and ISO code here
		// The width and padding-left are what changes the spaces around the words.
		// When doing a Switch() Netscape 9 drops the table down a 1/2 inch. I don't know why.
		?>
		<table class='languageNames' style='width: 1020px; margin: 0px; padding: 0px; '>
            <tr id='languageName'>
            <?php
                echo "<th width='6%' class='secondHeader'>Edit:</th>";
                echo "<th width='32%' class='secondHeaderSelection'>Language Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='images/downTriangle.png' /></th>";
                echo "<th width='34%' class='secondHeader'>Alternate Language Names:</th>";
                echo "<th width='20%' class='secondHeader'><a id='one' title='Click to sort' href='#' onclick='Switch(1, \"$Letter\")'>ISO ROD Code<br />Variant Code:</a></th>";
                echo "<th width='8%' class='secondHeader'>Country:</th>";
            ?>
            </tr>
            <tr id='languageCode'>
            <?php
                echo "<th width='6%' class='secondHeader'>Edit:</th>";
                echo "<th width='28%' class='secondHeader'><a id='two' title='Click to sort.' href='#' onclick='Switch(2, \"$Letter\")'>Language Name:</a></th>";
                echo "<th width='31%' class='secondHeader'>Alternate Language Names:</th>";
                echo "<th width='15%' class='secondHeaderSelection'>ISO ROD Code<br />Variant Code:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='images/downTriangle.png' /></th>";
                echo "<th width='20%' class='secondHeader'>Country:</th>";
            ?>
            </tr>
		</table>

		<div id="wait" style="display:none; position:absolute; top:45%; left:50%; padding:2px; "><img src="images/wait.gif" width="64" height="64" /></div>

		<?php
		// order by language name or ISO code
		if ($which == 'Name') {
			if ($Letter != '')
				$query="SELECT DISTINCT LN_Temp.LN, scripture_main.* FROM LN_Temp, scripture_main WHERE scripture_main.ISO_ROD_index = LN_Temp.idx AND LN_Temp.LN LIKE '$Letter%' ORDER BY LN_Temp.LN";
			else
				$query="SELECT DISTINCT LN_Temp.LN, scripture_main.* FROM LN_Temp, scripture_main WHERE scripture_main.ISO_ROD_index = LN_Temp.idx ORDER BY LN_Temp.LN";
		}
		else {	// $which == 'Code'
			$query="SELECT DISTINCT LN_Temp.LN, scripture_main.* FROM LN_Temp, scripture_main WHERE scripture_main.ISO_ROD_index = LN_Temp.idx ORDER BY LN_Temp.iso, LN_Temp.rod";
		}
		$result = $db->query($query);
		$num=$result->num_rows;
		echo "<div id='NamesLang' class='callR'>";

		/**********************************************************************************************************************
				display the langauge names for this country
		***********************************************************************************************************************/
	    echo "<div id='CT'>";
		echo "<table id='CountryTable'>";
		$query='SELECT alt_lang_name FROM alt_lang_names WHERE ISO_ROD_index = ?';				// alt_lang_names
		$stmt_alt=$db->prepare($query);															// create a prepared statement
		$query = 'SELECT Variant_Eng FROM Variants WHERE Variant_Code = ?';
		$stmt_Var=$db->prepare($query);															// create a prepared statement
		$query='SELECT countries.English FROM ISO_countries, countries WHERE ISO_countries.ISO_ROD_index = ? AND ISO_countries.ISO_countries = countries.ISO_Country ORDER BY countries.English';
		$stmt_ISO_countries=$db->prepare($query);												// create a prepared statement
		$i=0;
		while ($r = $result->fetch_assoc()) {
			if ($i % 2)
				$color = "f8fafa";
			else
				$color = "EEF1F2";
			$iso = $r['ISO'];
			$rod = $r['ROD_Code'];
			$var = $r['Variant_Code'];															// Variant_Code to the language name
			$idx = $r['ISO_ROD_index'];
			$LN  = $r['LN'];
			// Cross Site Scripting (XSS) attack happens where client side code (usually JavaScript) gets injected into the output of your PHP script. The next line cleans it up.
			$LN = htmlspecialchars($LN, ENT_QUOTES, 'UTF-8');
			echo "<tr valign='middle' style='color: black; background-color: #$color; margin: 0px; padding: 0px; '>";
			echo "<td width='6%' style='cursor: pointer; ' onclick='parent.location=\"Scripture_Edit.php?idx=$idx\"'><img style='margin-bottom: 3px; margin-left: 13px; cursor: hand; ' src='images/pencil_edit.png' /></td>";
			echo "<td width='28%' style='background-color: #$color; margin: 0px; padding: 3px 5px 3px 5px; border-width: thin; border-style: none; border-color: #$color; '>$LN</td>";
			$stmt_alt->bind_param("i", $idx);													// bind parameters for markers								// 
			$stmt_alt->execute();																// execute query
			$result_alt = $stmt_alt->get_result();												// instead of bind_result (used for only 1 record):
			$num_alt=$result_alt->num_rows;
			if ($result_alt && $num_alt > 0) {
				echo "<td width='31%' style='background-color: #$color; margin: 0px; padding: 3px 5px 3px 5px; border-width: thin; border-style: none; border-color: #$color; '>";
				$i_alt=0;
				while ($row_alt = $result_alt->fetch_assoc()) {
					if ($i_alt != 0) {															// 0 is the first one
						echo ', ';
					}
					$alt_lang_name = $row_alt['alt_lang_name'];
					// Cross Site Scripting (XSS) attack happens where client side code (usually JavaScript) gets injected into the output of your PHP script. The next line cleans it up.
					$alt_lang_name = htmlspecialchars($alt_lang_name, ENT_QUOTES, 'UTF-8');
					echo $alt_lang_name;
					$i_alt++;
				}
				echo '</td>';
			}
			else
				echo "<td width='31%'style='margin: 0px; padding: 3px 5px 3px 5px; border-width: thin; border-style: none; border-color: #$color; '>&nbsp;</td>";
	
			$VD = '';
			if (!is_null($var) && $var != '') {
				$stmt_Var->bind_param("s", $var);												// bind parameters for markers								// 
				$stmt_Var->execute();															// execute query
				$resultVar = $stmt_Var->get_result();											// instead of bind_result (used for only 1 record):
				$numVar=$resultVar->num_rows;
				if ($resultVar && $numVar > 0) {
					$VD_Temp = $resultVar->fetch_assoc();
					$VD = $VD_Temp['Variant_Eng'];
				}
			}		
			echo "<td width='15%' style='margin: 0px; padding: 3px 5px 3px 5px; border-width: thin; border-style: none; border-color: #$color; '>" . $iso . " " . $rod;
			if ($VD != '') {
				echo "<br /><span style='font-style: italic; font-size: 8pt; '>($VD)</span>";
			}
			echo '</td>';
	
			$stmt_ISO_countries->bind_param("i", $idx);											// bind parameters for markers
			$stmt_ISO_countries->execute();														// execute query
			$result_ISO_countries = $stmt_ISO_countries->get_result();							// instead of bind_result (used for only 1 record):
			$temp_ISO_countries = $result_ISO_countries->fetch_assoc();
			$Eng_country = str_replace("'", "&#x27;", $temp_ISO_countries['English']);			// name of the country in the language version
			while ($temp_ISO_countries = $result_ISO_countries->fetch_assoc()) {
				$Eng_country = $Eng_country.', '.str_replace("'", "&#x27;", $temp_ISO_countries['English']);		// name of the country in the language version
			}
			$result_ISO_countries->free();
			echo "<td width='20%'style='margin: 0px; padding: 3px 5px 3px 5px; border-width: thin; border-style: none; border-color: #$color; '>$Eng_country</td>";
			echo '</tr>';
			$i++;
		}
		$stmt_alt->close();
		$stmt_Var->close();
		$stmt_ISO_countries->close();
		echo '</table>';
		echo '</div>';
		echo '</div>';
		/* Explicitly destroy the table */
		$db->query('DROP TABLE LN_Temp');
		$result->free();
		echo "<div id='count' style='margin: 40px; font-size: 14pt; color: navy; font-weight: bold; '>Total languages are $num</div>";
	}

/************************************************
\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\
	if $_GET does have idx
\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/\/
************************************************/

	elseif (isset($_GET['idx'])) {
		$idx = check_input($_GET['idx']);
		if (!is_numeric($idx)) {
			echo '<script type="text/javascript" language="javascript">
					location.replace("process.php");
					document.write ("Hacker!");
				</script>'; 
		}
		if (count($messages) > 0) {
			echo '<br />';
			echo 'Please correct these errors:<br />';
			// Displays a list of error messages
			echo '<ul style="color: red; "><li>'.implode('</li><li>', $messages).'</li></ul>';
		}

		if (!isset($_SESSION['nav_ln_array'])) {
			$_SESSION['nav_ln_array'] = [];
			$ln_query = "SELECT `translation_code`, `name`, `nav_fileName`, `ln_number`, `language_code`, `ln_abbreviation` FROM `translations` ORDER BY `translation_code`";
			$ln_result=$db->query($ln_query) or die ('Query failed:  ' . $db->error . '</body></html>');
			if ($ln_result->num_rows == 0) {
				die ('<div style="background-color: white; color: red; font-size: 16pt; padding-top: 20px; padding-bottom: 20px; margin-top: 200px; ">' . translate('The translation_code is not found.', $st, 'sys') . '</div></body></html>');
			}
		
			while ($ln_row = $ln_result->fetch_array()){
				$ln_temp[0] = $ln_row['translation_code'];
				$ln_temp[1] = $ln_row['name'];
				$ln_temp[2] = $ln_row['nav_fileName'];
				$ln_temp[3] = $ln_row['ln_number'];
				$ln_temp[4] = $ln_row['ln_abbreviation'];
				$_SESSION['nav_ln_array'][$ln_row['language_code']] = $ln_temp;
			}
		}

		$query="SELECT * FROM nav_ln WHERE ISO_ROD_index = $idx";			// boolean for navigational languagae names
		$ln_result=$db->query($query) or die ('navigational language name is not found. ' . $db->error . '</body></html>');
		$ln_row = $ln_result->fetch_assoc();
		$def_LN = $ln_row['Def_LN'];										// default langauge (a 2 digit number for the national langauge)
		$nav_ln_row = $ln_row;												// the whole row including ISO, etc.
		foreach ($nav_ln_row as $code => $array) {							// delete lines that don't begin with "LN_"
			if (substr($code, 0, 3) != 'LN_') {
				unset($nav_ln_row[$code]);
			}
		}
		foreach ($_SESSION['nav_ln_array'] as $code => $array){				// build language name array to be used later
			${"LN_".$array[1]} = $nav_ln_row['LN_'.$array[1]];				// boolean
			${$array[1]."_lang_name"} = '';
			if (${"LN_".$array[1]}) {										// if = 1
				$query="SELECT LN_".$array[1]." FROM LN_".$array[1]." WHERE ISO_ROD_index = $idx";
				$result_LN=$db->query($query);
				if ($result_LN->num_rows > 0) {
					$temp_LN = $result_LN->fetch_assoc();
					${$array[1]."_lang_name"} = $temp_LN['LN_'.$array[1]];	// build language name array from language table
					// Cross Site Scripting (XSS) attack happens where client side code (usually JavaScript) gets injected into the output of your PHP script. The next line cleans it up.
					${$array[1]."_lang_name"} = htmlspecialchars(${$array[1]."_lang_name"}, ENT_QUOTES, 'UTF-8');
				}
			}
		}
		
		$query="SELECT DISTINCT * FROM scripture_main WHERE ISO_ROD_index = $idx";
		$result=$db->query($query) or die ('Query failed: ' . $db->error . '</body></html>');
		if ($db->error) {
			die ("'scripture_main' ISO_ROD_index is not found.<br />" . $db->error . '</body></html>');
		}
		$SM_row = $result->fetch_assoc();
		$iso = $SM_row['ISO'];									// ISO
		$rod = $SM_row['ROD_Code'];								// ROD_Code
		$var = $SM_row['Variant_Code'];							// Variant_Code to the language name
		$AddNo = $SM_row['AddNo'];								// boolean
		$AddTheBibleIn = $SM_row['AddTheBibleIn'];				// boolean
		$AddTheScriptureIn = $SM_row['AddTheScriptureIn'];		// boolean
		$BibleIs = $SM_row['BibleIs'];							// 1, 2 or 3
		?>

		<br />
		<form name='myForm' action='Scripture_Edit.php?idx=<?php echo $idx; ?>' method='post'>
		<div class='enter' style='color: navy; font-weight: bold; '>ISO ROD Code: <?php echo $iso . " " . $rod; ?>&nbsp;&nbsp;&nbsp;&nbsp;(idx: <?php echo $idx; ?>)
        <?php
		$VD = '';
		if (!is_null($var) && $var != '') {
			$query = "SELECT Variant_Eng FROM Variants WHERE Variant_Code = '$var'";
			$resultVar=$db->query($query) or die ('Query failed: ' . $db->error . '</body></html>');
			$numVar=$resultVar->num_rows;
			if ($resultVar && $numVar > 0) {
				$VD_Temp = $resultVar->fetch_assoc();
				$VD = $VD_Temp['Variant_Eng'];
			}
		}		
		if ($VD != '') {
			echo ' Variant_Code: <span style="font-style: italic; ">' . $VD . '</span>';
		}
		?>
        </div>
        
        <input type='hidden' name='idx' id='idx' value='<?php echo $idx; ?>' />
        <input type='hidden' name='iso' id='iso' value='<?php echo $iso; ?>' />
        <input type='hidden' name='rod' id='rod' value='<?php echo $rod; ?>' />
		<input type='hidden' name='var' id='var' value='<?php echo $var; ?>' />
		<input type='hidden' name='viewerer' id='viewerer' value='<?php
			if (isset($_POST['viewerer'])) {
				if ($_POST['viewerer'] == "on")
					echo "on";
				else
					echo "off";
			}
		?>' />
		<input type='hidden' name='rtler' id='rtler' value='<?php
			if (isset($_POST['rtler'])) {
				if ($_POST['rtler'] == "on")
					echo "on";
				else
					echo "off";
			}
		?>' />
		<input type='hidden' name='eBibleer' id='eBibleer' value='<?php
			if (isset($_POST['eBibleer'])) {
				if ($_POST['eBibleer'] == "on")
					echo "on";
				else
					echo "off";
			}
		?>' />

		<?php
/************************************************
	Countries
*************************************************/
			$Eng_country = '';
			$query="SELECT countries.English, countries.ISO_Country FROM countries, ISO_countries WHERE ISO_countries.ISO_ROD_index = $idx AND ISO_countries.ISO_countries = countries.ISO_Country ORDER BY countries.English";
			$result=$db->query($query);
			$num=$result->num_rows;
			if ($result && $num > 0) {
				$temp_Country = $result->fetch_assoc();
				$Eng_country = $temp_Country['English'];
				$Eng_country=str_replace("'","&#x27;",$Eng_country);					// for input tag
				$ISO_Country = $temp_Country['ISO_Country'];							// save it till almost through with this page of the script
			}
		?>
		<br />
		<div class='enter' style='font-weight: bold; '>COUNTRIES</div>
		<table width="100%" cellpadding="0" cellspacing="0" name="tableEngCountries" id="tableEngCountries">
			<tr>
				<td width="53%">
					<span style='font-size: 10pt; '>In English, enter the <span style='font-size: 12pt; font-weight: bold; '>COUNTRY(IES)</span> in which this Language is indigenous:</span>
				</td>
				<td width="30%">
					<input type='text' name='Eng_country-1' id='Eng_country-1' autofocus style='color: navy; ' size='60' value="<?php if (isset($_POST['Eng_country-1'])) echo $_POST['Eng_country-1']; else echo $Eng_country; ?>" />
				</td>
				<td width="17%" style="text-align: right; ">
					<input id="addRowTableCountry" style="font-size: 9pt; " type="button" value="Add" />
					<input id="removeRowTableCountry" style="font-size: 9pt; " type="button" value="Remove" />
				</td>
			</tr>
			<?php
			$i = 2;
			if (isset($_POST['Eng_country-'.(string)$i])) {
				while (isset($_POST['Eng_country-'.(string)$i])) {
					echo "<tr>";
						echo "<td width='53%'>";
							echo "&nbsp;";
						echo "</td>";
						echo "<td width='30%'>";
							// In HTML tags like "input" tags the "value" attributes text are not to have '. The PHP htmlentities function changes ' to &#39; (an HTML character) so it works.
							echo "<input type='text' name='Eng_country-$i' id='Eng_country-$i' style='color: navy; ' size='60' value='" . htmlentities($_POST['Eng_country-'.(string)$i], ENT_QUOTES) . "' />";
						echo "</td>";
						echo "<td width='17%'>";
							echo "&nbsp;";
						echo "</td>";
					echo "</tr>";
					$i++;
				}
			}
			elseif ($num > 1) {
				$y = $i - 1;
				while ($y < $num) {
					$temp_Country = $result->fetch_assoc();
					${'Eng_country-$i'} = $temp_Country['English'];
					echo "<tr>";
						echo "<td width='53%'>";
							echo "&nbsp;";
						echo "</td>";
						echo "<td width='30%'>";
							// In HTML tags like "input" tags the "value" attributes text are not to have '. The PHP htmlentities function changes ' to &#39; (an HTML character) so it works.
							echo "<input type='text' name='Eng_country-$i' id='Eng_country-$i' style='color: navy; ' size='60' value='" . htmlentities(${'Eng_country-$i'}, ENT_QUOTES) . "' />";
						echo "</td>";
						echo "<td width='17%'>";
							echo "&nbsp;";
						echo "</td>";
					echo "</tr>";
					$y++;
					$i++;
				}
				$result->free();
			}
			else {
			}
/************************************************
	Navigational Language Names
*************************************************/
			?>
		</table>
		<br /><br />

		<?php
		foreach ($_SESSION['nav_ln_array'] as $code => $array){
			$html = "<div class='enter' style='font-size: 10pt; '>In <span style='font-size: 12pt; font-weight: bold; '>".strtoupper($array[1])."</span>, enter the Language Name: <input type='text' name='".$array[1]."_lang_name' id='".$array[1]."_lang_name' size='35' style='color: navy; font-weight: bold; ' value=\"switch\" /></div>";
			if (isset($_POST[$array[1].'_lang_name'])){
				$result = str_replace('switch', $_POST[$array[1].'_lang_name'], $html);
			} else {
				$result = str_replace('switch', ${$array[1].'_lang_name'}, $html);
			}
			echo $result;
		}

/************************************************
	Default Navigational Language Name
*************************************************/
		?>
		<br />
		<p>Select the default major langauge <span style="font-size: 10pt; ">(i.e. the major language from above)</span>: 
		<select name="DefaultLang" id="DefaultLang">
		<?php
		if (isset($_POST['DefaultLang'])) { 
			foreach ($_SESSION['nav_ln_array'] as $code => $array){
				$html = "<option value=\"".$array[1]."Lang\" switch >".$array[1]."</option>";
				if ($_POST['DefaultLang'] == $array[1].'Lang'){
					$result = str_replace('switch', " selected='yes'", $html);
				} else {
					$result = str_replace('switch', '', $html);
				}
				echo $result;
			}
		}
		else {
			foreach ($_SESSION['nav_ln_array'] as $code => $array){
				$html = "<option value=\"".$array[1]."Lang\" switch >".$array[1]."</option>";
				if ($def_LN == $array[3]){
					$result = str_replace('switch', " selected='yes'", $html);
				} else {
					$result = str_replace('switch', '', $html);
				}
				echo $result;
			}
		}
		?>
		</select>
		</p>
		<br />

		<?php
/************************************************
	alternate language names
*************************************************/
		$i=1;
		$num = 0;
		if (isset($_POST['txtAltNames-'.(string)$i])) {
			
		}
		else {
			$query="SELECT alt_lang_name FROM alt_lang_names WHERE ISO_ROD_index = $idx";
			$result1=$db->query($query);
			$num=$result1->num_rows;
			if ($result1 && $num > 0) {
				$tempAlt = $result1->fetch_assoc();
				${'txtAltNames-$i'} = $tempAlt['alt_lang_name'];
			}
			else
				${'txtAltNames-$i'} = '';
		}
		?>
		<table width="100%" cellpadding="0" cellspacing="0" name="tableAltNames" id="tableAltNames">
			<tr>
				<td width="53%" style="padding-left: 3px; ">
					Enter the Alternate Language Name(s)<span style="font-size: 9pt; "><br />(only one Language Name per line)</span>:
				</td>
				<td width="26%" style="padding-left: 3px; ">
					<input type='text' name='txtAltNames-1' id='txtAltNames-1' style='color: navy; ' size='50' onclick='ALNidx(1)' value="<?php if (isset($_POST['txtAltNames-1'])) echo $_POST['txtAltNames-1']; else echo ${'txtAltNames-$i'}; ?>" />
				</td>
                <td width="4%" style="text-align: right; ">
                    <div onclick="moveUpDownALN('tableAltNames', 'up')" style="cursor: pointer; "><img src="images/up.png" width="24" height="20" /></div>
                    <div onclick="moveUpDownALN('tableAltNames', 'down')" style="cursor: pointer; "><img src="images/down.png" width="24" height="18" /></div>
                </td>
				<td width="17%" style="text-align: right; ">
					<input id="addRowTableAlt" style="font-size: 9pt; " type="button" value="Add" />
					<input id="removeRowTableAlt" style="font-size: 9pt; " type="button" value="Remove" />
				</td>
			</tr>
			<?php
			$i = 2;
			if (isset($_POST['txtAltNames-'.(string)$i])) {
				while (isset($_POST['txtAltNames-'.(string)$i])) {
					echo "<tr>";
						echo "<td width='53%'>";
							echo "&nbsp;";
						echo "</td>";
						echo "<td width='26%'>";
							echo "<input type='text' name='txtAltNames-$i' id='txtAltNames-$i' style='color: navy; ' size='50' onclick='ALNidx($i)' value='" . $_POST['txtAltNames-'.(string)$i] . "' />";
						echo "</td>";
						echo "<td width='21%' colspan='2'>";
							echo "&nbsp;";
						echo "</td>";
					echo "</tr>";
					$i++;
				}
			}
			elseif ($num > 1) {
				$y = $i - 1;
				while ($y < $num) {
					$tempAlt = $result1->fetch_assoc();
					${'txtAltNames-$i'} = stripslashes($tempAlt['alt_lang_name']);
					echo "<tr>";
						echo "<td width='53%'>";
							echo "&nbsp;";
						echo "</td>";
						echo "<td width='26%'>";
							echo "<input type='text' name='txtAltNames-$i' id='txtAltNames-$i' style='color: navy; ' size='50' onclick='ALNidx($i)' value=\"" . ${'txtAltNames-$i'} . "\" />";
						echo "</td>";
						echo "<td width='21%' colspan='2'>";
							echo "&nbsp;";
						echo "</td>";
					echo "</tr>";
					$y++;
					$i++;
				}
				$result1->free();
			}
			else {
			
			}
			?>
		</table>
        <br /><br />

        <?php
/************************************************
	wording?
*************************************************/
		if (isset($_POST['GroupAdd'])) {
			?>
            <input type='radio' name='GroupAdd' value='AddNo' checked <?php echo ($_POST['GroupAdd'] == 'AddNo' ? ' checked' : '') ?> /> No "The Bible In" or "The Scripture In".<br />
            <input type='radio' name='GroupAdd' value='AddTheBibleIn' <?php echo ($_POST['GroupAdd'] == 'AddTheBibleIn' ? ' checked' : '') ?> /> "The Bible In" added to the specific name of the language on the top of the screen.<br />
            <input type='radio' name='GroupAdd' value='AddTheScriptureIn' <?php echo ($_POST['GroupAdd'] == 'AddTheScriptureIn' ? ' checked' : '') ?> /> "The Scripture In" added to the specific name of the language on the top of the screen.<br /><br />
			<?php
        }
		else {
			if ($AddNo) {
				?>
                <input type='radio' name='GroupAdd' value='AddNo' checked /> No "The Bible In" or "The Scripture In".<br />
                <input type='radio' name='GroupAdd' value='AddTheBibleIn' /> "The Bible In" added to the specific name of the language on the top of the screen.<br />
                <input type='radio' name='GroupAdd' value='AddTheScriptureIn' /> "The Scripture In" added to the specific name of the language on the top of the screen.<br /><br />
				<?php
			}
			if ($AddTheBibleIn) {
				?>
                <input type='radio' name='GroupAdd' value='AddNo' /> No "The Bible In" or "The Scripture In".<br />
                <input type='radio' name='GroupAdd' value='AddTheBibleIn' checked /> "The Bible In" added to the specific name of the language on the top of the screen.<br />
                <input type='radio' name='GroupAdd' value='AddTheScriptureIn' /> "The Scripture In" added to the specific name of the language on the top of the screen.<br /><br />
				<?php
			}
			if ($AddTheScriptureIn) {
				?>
                <input type='radio' name='GroupAdd' value='AddNo' /> No "The Bible In" or "The Scripture In".<br />
                <input type='radio' name='GroupAdd' value='AddTheBibleIn' /> "The Bible In" added to the specific name of the language on the top of the screen.<br />
                <input type='radio' name='GroupAdd' value='AddTheScriptureIn' checked /> "The Scripture In" added to the specific name of the language on the top of the screen.<br /><br />
				<?php
			}
		}
/************************************************
	isop
*************************************************/
		echo '<br />What is the isoP code for this minority language if it needs one (&ldquo;<span style="color: navy; font-weight: bold; ">'.$iso.'</span>&rdquo; plus 4 maximum capital letters or numbers)?&nbsp;';
		if (isset($_POST['isopText'])) {
			?>
			<input type='text' style='color: navy; ' size='6' name='isopText' id='isopText' value="<?php if (isset($_POST['isopText'])) echo $_POST['isopText']; else echo ''; ?>" />
			<?php
		}
		else {
			$query = "SELECT isop FROM isop WHERE ISO_ROD_index = $idx";
			$resultisop=$db->query($query) or die ('Query failed: ' . $db->error . '</body></html>');
			if ($resultisop->num_rows > 0) {
				$isop_Temp = $resultisop->fetch_assoc();
				$isop = $isop_Temp['isop'];
				?>
                <input type='text' style='color: navy; ' size='6' name='isopText' id='isopText' value="<?php echo $isop; ?>" />
                <?php
			}
			else {
				?>
				<input type='text' style='color: navy; ' size='6' name='isopText' id='isopText' value='' />
				<?php
			}
		}
        ?>

		<br /><br />
        <hr align="center" width="90%" color="#0066CC" />
        <br />
        
		<?php
/************************************************
	OT PDF books
*************************************************/
		$whole_Bible = '';
		$complete_Scripture = '';
        if (isset($_POST['whole_Bible']) || isset($_POST['Scripture_Bible_Filename'])) {
			
		}
		else {
			$whole_Bible = '';
			$Scripture_Bible_Filename = '';
			$query="SELECT Item, Scripture_Bible_Filename FROM Scripture_and_or_Bible WHERE ISO_ROD_index = $idx";
			$result1=$db->query($query);
			$num=$result1->num_rows;
			if ($result1 && $num > 0) {
				while ($r = $result1->fetch_assoc()) {
					$Item = $r['Item'];
					if ($Item == 'B') {																	// "B"ible
						$whole_Bible = $r['Scripture_Bible_Filename'];
					}
					else {																				// else = "S"cripture
						$complete_Scripture = $r['Scripture_Bible_Filename'];
					}
				}
			}
			$result1->free();
		}
		?>
        Enter the PDF file name of the whole Bible in this language:
        <input type='text' name='whole_Bible' id='whole_Bible' style='color: navy; ' size='40' value="<?php if (isset($_POST['whole_Bible'])) echo $_POST['whole_Bible']; else echo ${'whole_Bible'}; ?>" />
        <br /><br />
        <span style='font-size: 11pt; '>Enter the PDF file name of the complete Scripture publication (although NOT the OT nor NT) in this language:</span>
        <input type='text' name='complete_Scripture' id='complete_Scripture' style='color: navy; ' size='40' value="<?php if (isset($_POST['complete_Scripture'])) echo $_POST['complete_Scripture']; else echo ${'complete_Scripture'}; ?>" />

		<br /><br />
        <hr align="center" width="90%" color="#0066CC" />
        <br />

		<?php
		if ($SM_row['OT_PDF']) {
			$query="SELECT * FROM OT_PDF_Media WHERE ISO_ROD_index = $idx AND OT_PDF = 'OT'";
			$result1=$db->query($query);
			$num=$result1->num_rows;
			if ($result1 && $num > 0) {
				$r = $result1->fetch_assoc();
				$OT_PDF_Filename = $r['OT_PDF_Filename'];
				$OT_name = $OT_PDF_Filename;
			}
			else {
				$OT_name = '';
			}
			$result1->free();
			?>
			<div class='enter'>PDF file name of the OT in this language: <input type='text' name='OT_name' id='OT_name' size='40' value="<?php echo $OT_name ?>" /></div>
			<?php
		}
		else {
			?>
			<div class='enter'>PDF file name of the OT in this language: <input type='text' name='OT_name' id='OT_name' size='40' value="<?php if (isset($_POST['OT_name'])) echo $_POST['OT_name']; else echo ''; ?>" /></div>
			<?php
		}
		?>
		<br />
		
		<?php
		$num = 0;
		if (isset($_POST['OT_PDF_Book-1']) || isset($_POST["OT_PDF_appendix"]) || isset($_POST["OT_PDF_glossary"])) {		//else {
			?>
			<input type='hidden' name='OT_PDF_Button' id='OT_PDF_Button' value='No' />
            <div id='OT_Off_Books'>		<!-- The id has to the same because of function classChange in AddorChange.js! -->
            	<input type='button' id='Open_OT_PDFs' value='Open OT PDFs' /> Are there any of the books in the Old Testament in PDF?<br />
			</div>
			<div class='enter' id='OT_Books'>		<!-- The id has to the same because of function classChange in AddorChange.js! -->
				<input type='button' id='Close_OT_PDF' name='Close_OT_PDF' value="Close OT PDFs" /> Here are the books that ocurr in the Old Testament in PDF:<br />
				<input type='button' id='OT_PDF_Books' value='All PDF OT Books' /><span style='font-size: 10pt; font-weight: bold; '> Enter the PDF filename for Genesis and click on this button to have all of the rest of the OT filled in.</span><br />
				<input type='button' id='No_OT_PDF_Books' value='No PDF OT Books' /><span style='font-size: 10pt; font-weight: bold; '> Delete the PDF filename for Genesis and click on this button to have none of the rest of the OT deleted.</span>
				<br />
				<div id='All_OT_Books_Div'>
					<div id='None_OT_Books_Div'>
						<table id="OT_PDF_Table" width="100%">
							<?php
							for ($i=0; $i < 39; $i++) {
								$item_from_array = $OT_array[2][$i];
								if ($i % 2)
									$color = "ffffff";
								else
									$color = "f0f4f0";
								echo "<tr style='background-color: #$color;'><td width='30%'>";
								echo "&nbsp;&nbsp;<input type='checkbox' name='OT_PDF_Book-$i' id='OT_PDF_Book-$i'" . (isset($_POST['OT_PDF_Book-'.(string)$i]) ? ' checked' : '' ) . " />&nbsp;$item_from_array";
								echo "</td><td width='70%'>";
								echo "OT PDF Filename:&nbsp;<input type='text' name='OT_PDF_Filename-$i' id='OT_PDF_Filename-$i' size='50' value='" . (isset($_POST['OT_PDF_Filename-'.(string)$i]) ? $_POST['OT_PDF_Filename-'.(string)$i] : '' ) . "' />";
								echo "</td></tr>";
							}
							echo "<tr valign='bottom' style='background-color: #fff;'><td width='30%'>";
							echo "<br />";
							echo "&nbsp;&nbsp;<input type='checkbox' name='OT_PDF_appendix' id='OT_PDF_appendix'" . (isset($_POST['OT_PDF_appendix']) ? ' checked' : '' ) . " />&nbsp;OT Appendix";
							echo "</td><td width='70%'>";
							echo "OT PDF Filename:&nbsp;<input type='text' name='OT_PDF_Filename_appendix' id='OT_PDF_Filename_appendix' size='50' value='" . (isset($_POST['OT_PDF_Filename_appendix']) ? $_POST['OT_PDF_Filename_appendix'] : '' ) . "' />";
							echo "</td></tr>";
							echo "<tr valign='bottom' style='background-color: #f0f4f0;'><td width='30%'>";
							echo "&nbsp;&nbsp;<input type='checkbox' name='OT_PDF_glossary' id='OT_PDF_glossary'" . (isset($_POST['OT_PDF_glossary']) ? ' checked' : '' ) . " />&nbsp;OT Glossary";
							echo "</td><td width='70%'>";
							echo "OT PDF Filename:&nbsp;<input type='text' name='OT_PDF_Filename_glossary' id='OT_PDF_Filename_glossary' size='50' value='" . (isset($_POST['OT_PDF_Filename_glossary']) ? $_POST['OT_PDF_Filename_glossary'] : '' ) . "' />";
							echo "</td></tr>";
							?>
						</table>
					</div>
				</div>
			</div>
			<?php
		}
		else {		// (mysql_result($result,0,'OT_PDF')) {
			$query="SELECT * FROM OT_PDF_Media WHERE ISO_ROD_index = $idx AND OT_PDF != 'OT' ORDER BY (OT_PDF+0)";			// turns strings into numbers // [AND NT_PDF NOT REGEXP '[[:<:]][[:digit:]]{3,3}' works but doesn't do 200, etc. only 0 - 99]
			$result1=$db->query($query);
			$num=$result1->num_rows;
			if ($result1 && $num > 0) {
				?>
				<input type='hidden' name='OT_PDF_Button' id='OT_PDF_Button' value='No' />
                <div id='OT_Off_Books'>		<!-- The id has to the same because of function classChange in AddorChange.js! -->
					<input type='button' id='Open_OT_PDFs' value='Open OT PDFs' /> Are there any of the books in the Old Testament in PDF?<br />
				</div>
                <div class='enter' id='OT_Books'>		<!-- The id has to the same because of function classChange in AddorChange.js! -->
					<input type='button' id='Close_OT_PDF' name='Close_OT_PDF' value="Close OT PDFs" /> Here are the books that occur in the Old Testament in PDF:<br />
					<input type='button' id='OT_PDF_Books' value='All PDF OT Books' /><span style='font-size: 10pt; font-weight: bold; '> Enter the PDF filename for Genesis and click on this button to have all of the rest of the OT filled in.</span><br />
					<input type='button' id='No_OT_PDF_Books' value='No PDF OT Books' /><span style='font-size: 10pt; font-weight: bold; '> Delete the PDF filename for Genesis and click on this button to have none of the rest of the OT deleted.</span>
					<br />
					<div id='All_OT_Books_Div'>
						<div id='None_OT_Books_Div'>
							<table id="OT_PDF_Table" width="100%">
								<?php
									$i = 0;
									$j = 0;
									$OT_appendix = -1;					// must be initialized to -1!
									$OT_glossary = -1;					// must be initialized to -1!
									$temp_t = 0;
									$temp = 0;
									while ($i < $num) {
										$r = $result1->fetch_assoc();
										$temp_t = $r['OT_PDF'];
										if (preg_match("/^[0-9][0-9][0-9]$/", $temp_t)) {
											if ($temp_t == 100) $OT_appendix = $i;
											if ($temp_t == 101) $OT_glossary = $i;
											$i++;
											continue;
										}
										$temp = $temp_t;
										for (; $j <= $temp; $j++) {
											$item_from_array = $OT_array[2][$j];
											if ($j % 2)
												$color = "ffffff";
											else
												$color = "f0f4f0";
											echo "<tr style='background-color: #$color;'><td width='30%'>";
											if ($j == $temp) {
												echo "&nbsp;&nbsp;<input type='checkbox' name='OT_PDF_Book-$j' id='OT_PDF_Book-$j' checked />&nbsp;$item_from_array";
												echo "</td><td width='70%'>";
												${'OT_PDF_Filename-$i'} = $r['OT_PDF_Filename'];	// $i is the actual OT_PDF_Filename in the row (ISO)!
												$temp_OT_PDF_Filename = ${'OT_PDF_Filename-$i'};
												echo "OT PDF Filename:&nbsp;<input type='text' name='OT_PDF_Filename-$j' id='OT_PDF_Filename-$j' size='50' value='$temp_OT_PDF_Filename' />";
											}
											else {
												echo "&nbsp;&nbsp;<input type='checkbox' name='OT_PDF_Book-$j' id='OT_PDF_Book-$j' />&nbsp;$item_from_array";
												echo "</td><td width='70%'>";
												echo "OT PDF Filename:&nbsp;<input type='text' name='OT_PDF_Filename-$j' id='OT_PDF_Filename-$j' size='50' value='' />";
											}
											echo "</td></tr>";
										}
										$i++;
									}
									$temp++;
									for (; $temp < 39; $temp++) {
										$item_from_array = $OT_array[2][$temp];
										if ($temp % 2)
											$color = "ffffff";
										else
											$color = "f0f4f0";
										echo "<tr style='background-color: #$color;'><td width='30%'>";
										echo "&nbsp;&nbsp;<input type='checkbox' name='OT_PDF_Book-$temp' id='OT_PDF_Book-$temp' />&nbsp;$item_from_array";
										echo "</td><td width='70%'>";
										echo "OT PDF Filename:&nbsp;<input type='text' name='OT_PDF_Filename-$temp' id='OT_PDF_Filename-$temp' size='50' value='' />";
										echo "</td></tr>";
									}
									echo "<tr valign='bottom' style='background-color: #fff;'><td width='30%'>";
									echo "<br />";
									if ($OT_appendix != -1) {
										echo "&nbsp;&nbsp;<input type='checkbox' name='OT_PDF_appendix' id='OT_PDF_appendix' checked />&nbsp;OT Appendix";
										echo "</td><td width='70%'>";
										$result1->data_seek($OT_appendix);
										$r = $result1->fetch_assoc();
										$OT_PDF_Filename_appendix = $r['OT_PDF_Filename'];
										echo "OT PDF Filename:&nbsp;<input type='text' name='OT_PDF_Filename_appendix' id='OT_PDF_Filename_appendix' size='50' value='$OT_PDF_Filename_appendix' />";
									}
									else {
										echo "&nbsp;&nbsp;<input type='checkbox' name='OT_PDF_appendix' id='OT_PDF_appendix' />&nbsp;OT Appendix";
										echo "</td><td width='70%'>";
										echo "OT PDF Filename:&nbsp;<input type='text' name='OT_PDF_Filename_appendix' id='OT_PDF_Filename_appendix' size='50' value='' />";
									}
									echo "</td></tr>";
									echo "<tr valign='bottom' style='background-color: #f0f4f0;'><td width='30%'>";
									if ($OT_glossary != -1) {
										echo "&nbsp;&nbsp;<input type='checkbox' name='OT_PDF_glossary' id='OT_PDF_glossary' checked />&nbsp;OT Glossary";
										echo "</td><td width='70%'>";
										$result1->data_seek($OT_glossary);
										$r = $result1->fetch_assoc();
										$OT_PDF_Filename_glossary = $r['OT_PDF_Filename'];
										echo "OT PDF Filename:&nbsp;<input type='text' name='OT_PDF_Filename_glossary' id='OT_PDF_Filename_glossary' size='50' value='$OT_PDF_Filename_glossary' />";
									}
									else {
										echo "&nbsp;&nbsp;<input type='checkbox' name='OT_PDF_glossary' id='OT_PDF_glossary' />&nbsp;OT Glossary";
										echo "</td><td width='70%'>";
										echo "OT PDF Filename:&nbsp;<input type='text' name='OT_PDF_Filename_glossary' id='OT_PDF_Filename_glossary' size='50' value='' />";
									}
									echo "</td></tr>";
								?>
							</table>
						</div>
					</div>
				</div>
				<?php
			}
			else {
				?>
				<input type='hidden' name='OT_PDF_Button' id='OT_PDF_Button' value='No' />
                <div id='OT_Off_Books'>		<!-- The id has to the same because of function classChange in AddorChange.js! -->
					<input type='button' id='Open_OT_PDFs' value='Open OT PDFs' /> Are there any of the books in the Old Testament in PDF?<br />
				</div>
                <div class='enter' id='OT_Books'>		<!-- The id has to the same because of function classChange in AddorChange.js! -->
					<input type='button' id='Close_OT_PDF' name='Close_OT_PDF' value="Close OT PDFs" /> Here are the books that ocurr in the Old Testament in PDF:<br />
					<input type='button' id='OT_PDF_Books' value='All PDF OT Books' /><span style='font-size: 10pt; font-weight: bold; '> Enter the PDF filename for Genesis and click on this button to have all of the rest of the OT filled in.</span><br />
					<input type='button' id='No_OT_PDF_Books' value='No PDF OT Books' /><span style='font-size: 10pt; font-weight: bold; '> Delete the PDF filename for Genesis and click on this button to have none of the rest of the OT deleted.</span>
					<br />
					<div id='All_OT_Books_Div'>
						<div id='None_OT_Books_Div'>
							<table id="OT_PDF_Table" width="100%">
								<?php
								for ($i=0; $i < 39; $i++) {
									$item_from_array = $OT_array[2][$i];
									if ($i % 2)
										$color = "ffffff";
									else
										$color = "f0f4f0";
									echo "<tr style='background-color: #$color;'><td width='30%'>";
									echo "&nbsp;&nbsp;<input type='checkbox' name='OT_PDF_Book-$i' id='OT_PDF_Book-$i' />&nbsp;$item_from_array";
									echo "</td><td width='70%'>";
									echo "OT PDF Filename:&nbsp;<input type='text' name='OT_PDF_Filename-$i' id='OT_PDF_Filename-$i' size='50' value='' />";
									echo "</td></tr>";
								}
								echo "<tr valign='bottom' style='background-color: #fff;'><td width='30%'>";
								echo "<br />";
								echo "&nbsp;&nbsp;<input type='checkbox' name='OT_PDF_appendix' id='OT_PDF_appendix' />&nbsp;OT Appendix";
								echo "</td><td width='70%'>";
								echo "OT PDF Filename:&nbsp;<input type='text' name='OT_PDF_Filename_appendix' id='OT_PDF_Filename_appendix' size='50' value='' />";
								echo "</td></tr>";
								echo "<tr valign='bottom' style='background-color: #f0f4f0;'><td width='30%'>";
								echo "&nbsp;&nbsp;<input type='checkbox' name='OT_PDF_glossary' id='OT_PDF_glossary' />&nbsp;OT Glossary";
								echo "</td><td width='70%'>";
								echo "OT PDF Filename:&nbsp;<input type='text' name='OT_PDF_Filename_glossary' id='OT_PDF_Filename_glossary' size='50' value='' />";
								echo "</td></tr>";
								?>
							</table>
						</div>
					</div>
				</div>
				<?php
			}
			if ($num > 0) {
				$result1->free();
			}
		}
		?>
		<br />

		<?php
/************************************************
	NT PDF books
*************************************************/
		if ($SM_row['NT_PDF']) {
			$query="SELECT * FROM NT_PDF_Media WHERE ISO_ROD_index = $idx AND NT_PDF = 'NT'";
			$result1=$db->query($query);
			$num=$result1->num_rows;
			if ($result1 && $num > 0) {
				$r = $result1->fetch_assoc();
				$NT_PDF_Filename = $r['NT_PDF_Filename'];
				$NT_name = $NT_PDF_Filename;
			}
			else {
				$NT_name = '';
			}
			$result1->free();
			?>
			<div class='enter'>PDF file name of the NT in this language: <input type='text' name='NT_name' id='NT_name' size='40' value="<?php echo $NT_name ?>" /></div>
			<?php
		}
		else {
			?>
			<div class='enter'>PDF file name of the NT in this language: <input type='text' name='NT_name' id='NT_name' size='40' value="<?php if (isset($_POST['NT_name'])) echo $_POST['NT_name']; else echo ''; ?>" /></div>
			<?php
		}
		?>
		<br />
		
		<?php
		if (isset($_POST['NT_PDF_Book-1']) || isset($_POST["NT_PDF_appendix"]) || isset($_POST["NT_PDF_glossary"])) {		//else {
			?>
			<input type='hidden' name='PDF_Button' id='PDF_Button' value='No' />
			<div id="NT_Off_Books">		<!-- The id has to the same because of function classChange in AddorChange.js! -->
				<input type='button' id='Open_NT_PDFs' value='Open NT PDFs' /> Are there any of the books in the New Testament in PDF?<br />
            </div>
            <div class='enter' id='NT_Books'>		<!-- The id has to the same because of function classChange in AddorChange.js! -->
				<input type='button' id='Close_NT_PDF' name='Close_NT_PDF' value="Close NT PDFs" /> Here are the books that ocurr in the New Testament in PDF:<br />
				<input type='button' id='NT_PDF_Books' value='All PDF NT Books' /><span style='font-size: 10pt; font-weight: bold; '> Enter the PDF filename for Matthew and click on this button to have all of the rest of the NT filled in.</span><br />
				<input type='button' id='No_NT_PDF_Books' value='No PDF NT Books' /><span style='font-size: 10pt; font-weight: bold; '> Delete the PDF filename for Matthew and click on this button to have none of the rest of the NT deleted.</span>
				<br />
				<div id='All_Books_Div'>
					<div id='None_Books_Div'>
						<table id="NT_PDF_Table" width="100%">
							<?php
							for ($i=0; $i < 27; $i++) {
								$item_from_array = $NT_array[2][$i];
								if ($i % 2)
									$color = "ffffff";
								else
									$color = "f0f4f0";
								echo "<tr style='background-color: #$color;'><td width='30%'>";
								echo "&nbsp;&nbsp;<input type='checkbox' name='NT_PDF_Book-$i' id='NT_PDF_Book-$i'" . (isset($_POST['NT_PDF_Book-'.(string)$i]) ? ' checked' : '' ) . " />&nbsp;$item_from_array";
								echo "</td><td width='70%'>";
								echo "NT PDF filename:&nbsp;<input type='text' name='NT_PDF_Filename-$i' id='NT_PDF_Filename-$i' size='50' value='" . (isset($_POST['NT_PDF_Filename-'.(string)$i]) ? $_POST['NT_PDF_Filename-'.(string)$i] : '' ) . "' />";
								echo "</td></tr>";
							}
							echo "<tr valign='bottom' style='background-color: #fff;'><td width='30%'>";
							echo "<br />";
							echo "&nbsp;&nbsp;<input type='checkbox' name='NT_PDF_appendix' id='NT_PDF_appendix'" . (isset($_POST['NT_PDF_appendix']) ? ' checked' : '' ) . " />&nbsp;NT Appendix";
							echo "</td><td width='70%'>";
							echo "NT PDF Filename:&nbsp;<input type='text' name='NT_PDF_Filename_appendix' id='NT_PDF_Filename_appendix' size='50' value='" . (isset($_POST['NT_PDF_Filename_appendix']) ? $_POST['NT_PDF_Filename_appendix'] : '' ) . "' />";
							echo "</td></tr>";
							echo "<tr valign='bottom' style='background-color: #f0f4f0;'><td width='30%'>";
							echo "&nbsp;&nbsp;<input type='checkbox' name='NT_PDF_glossary' id='NT_PDF_glossary'" . (isset($_POST['NT_PDF_glossary']) ? ' checked' : '' ) . " />&nbsp;NT Glossary";
							echo "</td><td width='70%'>";
							echo "NT PDF Filename:&nbsp;<input type='text' name='NT_PDF_Filename_glossary' id='NT_PDF_Filename_glossary' size='50' value='" . (isset($_POST['NT_PDF_Filename_glossary']) ? $_POST['NT_PDF_Filename_glossary'] : '' ) . "' />";
							echo "</td></tr>";
							?>
						</table>
					</div>
				</div>
			</div>
			<?php
		}
		else {		// (SM_row['NT_PDF']) {
			$query="SELECT * FROM NT_PDF_Media WHERE ISO_ROD_index = $idx AND NT_PDF != 'NT' ORDER BY (NT_PDF+0)";			// turns strings into numbers // [AND NT_PDF NOT REGEXP '[[:<:]][[:digit:]]{3,3}' works but doesn't do 200, etc. only 0 - 99]
			$result1=$db->query($query);
			$num = $result1->num_rows;
			if ($result1 && $num > 0) {
				?>
				<input type='hidden' name='PDF_Button' id='PDF_Button' value='No' />
				<div id="NT_Off_Books">		<!-- The id has to the same because of function classChange in AddorChange.js! -->
					<input type='button' id='Open_NT_PDFs' value='Open NT PDFs' /> Are there any of the books in the New Testament in PDF?<br />
				</div>
                <div class='enter' id='NT_Books'>		<!-- The id has to the same because of function classChange in AddorChange.js! -->
					<input type='button' id='Close_NT_PDF' name='Close_NT_PDF' value="Close NT PDFs" /> Here are the books that ocurr in the New Testament in PDF:<br />
					<input type='button' id='NT_PDF_Books' value='All PDF NT Books' /><span style='font-size: 10pt; font-weight: bold; '> Enter the PDF filename for Matthew and click on this button to have all of the rest of the NT filled in.</span><br />
					<input type='button' id='No_NT_PDF_Books' value='No PDF NT Books' /><span style='font-size: 10pt; font-weight: bold; '> Delete the PDF filename for Matthew and click on this button to have none of the rest of the NT deleted.</span>
					<br />
					<div id='All_Books_Div'>
						<div id='None_Books_Div'>
							<table id="NT_PDF_Table" width="100%">
								<?php
									$i = 0;
									$j = 0;
									$NT_appendix = -1;					// must be initialized to -1!
									$NT_glossary = -1;					// must be initialized to -1!
									$temp_t = 0;
									$temp = 0;
									while ($i < $num) {
										$r = $result1->fetch_assoc();
										$temp_t = $r['NT_PDF'];
										if (preg_match("/^[0-9][0-9][0-9]$/", $temp_t)) {
											if ($temp_t == 200) $NT_appendix = $i;
											if ($temp_t == 201) $NT_glossary = $i;
											$i++;
											continue;
										}
										$temp = $temp_t;
										for (; $j <= $temp; $j++) {
											$item_from_array = $NT_array[2][$j];
											if ($j % 2)
												$color = "ffffff";
											else
												$color = "f0f4f0";
											echo "<tr style='background-color: #$color;'><td width='30%'>";
											if ($j == $temp) {
												echo "&nbsp;&nbsp;<input type='checkbox' name='NT_PDF_Book-$j' id='NT_PDF_Book-$j' checked />&nbsp;$item_from_array";
												echo "</td><td width='70%'>";
												${'NT_PDF_Filename-$i'} = $r['NT_PDF_Filename'];	// $i is the actual NT_PDF_Filename in the row (ISO)!
												$temp_NT_PDF_Filename = ${'NT_PDF_Filename-$i'};
												echo "NT PDF filename:&nbsp;<input type='text' name='NT_PDF_Filename-$j' id='NT_PDF_Filename-$j' size='50' value='$temp_NT_PDF_Filename' />";
											}
											else {
												echo "&nbsp;&nbsp;<input type='checkbox' name='NT_PDF_Book-$j' id='NT_PDF_Book-$j' />&nbsp;$item_from_array";
												echo "</td><td width='70%'>";
												echo "NT PDF Filename:&nbsp;<input type='text' name='NT_PDF_Filename-$j' id='NT_PDF_Filename-$j' size='50' value='' />";
											}
											echo "</td></tr>";
										}
										$i++;
									}
									$temp++;
									for (; $temp < 27; $temp++) {
										$item_from_array = $NT_array[2][$temp];
										if ($temp % 2)
											$color = "ffffff";
										else
											$color = "f0f4f0";
										echo "<tr style='background-color: #$color;'><td width='30%'>";
										echo "&nbsp;&nbsp;<input type='checkbox' name='NT_PDF_Book-$temp' id='NT_PDF_Book-$temp' />&nbsp;$item_from_array";
										echo "</td><td width='70%'>";
										echo "NT PDF filename:&nbsp;<input type='text' name='NT_PDF_Filename-$temp' id='NT_PDF_Filename-$temp' size='50' value='' />";
										echo "</td></tr>";
									}
									echo "<tr valign='bottom' style='background-color: #fff;'><td width='30%'>";
									echo "<br />";
									if ($NT_appendix != -1) {
										echo "&nbsp;&nbsp;<input type='checkbox' name='NT_PDF_appendix' id='NT_PDF_appendix' checked />&nbsp;NT Appendix";
										echo "</td><td width='70%'>";
										$result1->data_seek($NT_appendix);
										$r = $result1->fetch_assoc();
										$NT_PDF_Filename_appendix = $r['NT_PDF_Filename'];
										echo "NT PDF Filename:&nbsp;<input type='text' name='NT_PDF_Filename_appendix' id='NT_PDF_Filename_appendix' size='50' value='$NT_PDF_Filename_appendix' />";
									}
									else {
										echo "&nbsp;&nbsp;<input type='checkbox' name='NT_PDF_appendix' id='NT_PDF_appendix' />&nbsp;NT Appendix";
										echo "</td><td width='70%'>";
										echo "NT PDF Filename:&nbsp;<input type='text' name='NT_PDF_Filename_appendix' id='NT_PDF_Filename_appendix' size='50' value='' />";
									}
									echo "</td></tr>";
									echo "<tr valign='bottom' style='background-color: #f0f4f0;'><td width='30%'>";
									if ($NT_glossary != -1) {
										echo "&nbsp;&nbsp;<input type='checkbox' name='NT_PDF_glossary' id='NT_PDF_glossary' checked />&nbsp;NT Glossary";
										echo "</td><td width='70%'>";
										$result1->data_seek($NT_glossary);
										$r = $result1->fetch_assoc();
										$NT_PDF_Filename_glossary = $r['NT_PDF_Filename'];
										echo "NT PDF Filename:&nbsp;<input type='text' name='NT_PDF_Filename_glossary' id='NT_PDF_Filename_glossary' size='50' value='$NT_PDF_Filename_glossary' />";
									}
									else {
										echo "&nbsp;&nbsp;<input type='checkbox' name='NT_PDF_glossary' id='NT_PDF_glossary' />&nbsp;NT Glossary";
										echo "</td><td width='70%'>";
										echo "NT PDF Filename:&nbsp;<input type='text' name='NT_PDF_Filename_glossary' id='NT_PDF_Filename_glossary' size='50' value='' />";
									}
									echo "</td></tr>";
								?>
							</table>
						</div>
					</div>
				</div>
				<?php
			}
			else {
				?>
				<input type='hidden' name='PDF_Button' id='PDF_Button' value='No' />
				<div id="NT_Off_Books">		<!-- The id has to the same because of function classChange in AddorChange.js! -->
					<input type='button' id='Open_NT_PDFs' value='Open NT PDFs' /> Are there any of the books in the New Testament in PDF?<br />
				</div>
                <div class='enter' id='NT_Books'>		<!-- The id has to the same because of function classChange in AddorChange.js! -->
					<input type='button' id='Close_NT_PDF' name='Close_NT_PDF' value="Close NT PDFs" /> Here are the books that ocurr in the New Testament in PDF:<br />
					<input type='button' id='NT_PDF_Books' value='All PDF NT Books' /><span style='font-size: 10pt; font-weight: bold; '> Enter the PDF filename for Matthew and click on this button to have all of the rest of the NT filled in.</span><br />
					<input type='button' id='No_NT_PDF_Books' value='No PDF NT Books' /><span style='font-size: 10pt; font-weight: bold; '> Delete the PDF filename for Matthew and click on this button to have none of the rest of the NT deleted.</span>
					<br />
					<div id='All_Books_Div'>
						<div id='None_Books_Div'>
							<table id="NT_PDF_Table" width="100%">
								<?php
								for ($i=0; $i < 27; $i++) {
									$item_from_array = $NT_array[2][$i];
									if ($i % 2)
										$color = "ffffff";
									else
										$color = "f0f4f0";
									echo "<tr style='background-color: #$color;'><td width='30%'>";
									echo "&nbsp;&nbsp;<input type='checkbox' name='NT_PDF_Book-$i' id='NT_PDF_Book-$i' />&nbsp;$item_from_array";
									echo "</td><td width='70%'>";
									echo "NT PDF filename:&nbsp;<input type='text' name='NT_PDF_Filename-$i' id='NT_PDF_Filename-$i' size='50' value='' />";
									echo "</td></tr>";
								}
								echo "<tr valign='bottom' style='background-color: #fff;'><td width='30%'>";
								echo "<br />";
								echo "&nbsp;&nbsp;<input type='checkbox' name='NT_PDF_appendix' id='NT_PDF_appendix' />&nbsp;NT Appendix";
								echo "</td><td width='70%'>";
								echo "NT PDF Filename:&nbsp;<input type='text' name='NT_PDF_Filename_appendix' id='NT_PDF_Filename_appendix' size='50' value='' />";
								echo "</td></tr>";
								echo "<tr valign='bottom' style='background-color: #f0f4f0;'><td width='30%'>";
								echo "&nbsp;&nbsp;<input type='checkbox' name='NT_PDF_glossary' id='NT_PDF_glossary' />&nbsp;NT Glossary";
								echo "</td><td width='70%'>";
								echo "NT PDF Filename:&nbsp;<input type='text' name='NT_PDF_Filename_glossary' id='NT_PDF_Filename_glossary' size='50' value='' />";
								echo "</td></tr>";
								?>
							</table>
						</div>
					</div>
				</div>
				<?php
			}
			if ($num > 0) {
				$result1->free();
			}
		}
		?>

		<br />
        <hr align="center" width="90%" color="#0066CC" />
        <br />

		<?php

/*************************************************
	OT audio books
**************************************************/
		// is there $_POST?
		if (isset($_POST['OT_Audio_Index-0-0'])) {																			// if there are error then display the $_POST's
			?>
			<input type='hidden' name='OT_Audio_Button' id='OT_Audio_Button' value='No' />
			<div id="OT_Off_Audio">		<!-- The id has to the same because of function classChange in AddorChange.js! -->
				<input type='button' id='Open_OT_audio' value='Open OT audio' /> Are there any of the books in the Old Testament in audio (mp3) by chapter?<br />
			</div>
            <div class='enter' id='OT_Audio'>		<!-- The id has to the same because of function classChange in AddorChange.js! -->
				<input type='button' id='Close_OT_audio' value='Close OT audio' /> Here are the books in the Old Testament in audio (mp3) by chapters:<br />
				<input type='button' id='OT_Audio_Chapters' value='All Audio OT Chapters' /><span style='font-size: 9pt; font-weight: bold; '> Enter the audio filename for Genesis chapter 1 and click on this button to have all of the rest of the OT filled in.</span><br />
				<input type='button' id='No_OT_Audio_Chapters' value='No Audio OT Chapters' /><span style='font-size: 9pt; font-weight: bold; '> Delete the audio filename for Genesis chapter 1 and click on this button to have none of the rest of the OT deleted.</span>
				<br />
				<div id='All_OT_Audio_Div'>
					<div id='None_OT_Audio_Div'>
						<table id='OT_Audio_Table' width="100%">
							<?php
								// I need the names of the files
								for ($i = 0; $i < 39; $i++) {
									$item_from_array = $OT_array[2][$i];
									$item2_from_array = $OT_array[1][$i];
									echo "<tr style='vertical-align: top; '>";
									echo "<td width='10%' style='padding: 12px; '>";
									echo "&nbsp;$item_from_array:<br />";
									if ($item2_from_array > 1) {
										echo "<input style='font-size: 8pt; ' type='button' id='One_OT_Audio_Chapters-$i' value='Audio OT Chapters in $item_from_array' onclick='One_OT_Audio_Chapters($i)' />";
										echo "<br /><span style='font-size: 8pt; '>Enter the OT audio filename for $item_from_array chapter 1 and click on this button to have all of the rest of $item_from_array filled in.</span>";
										echo "<br /><br /><input style='font-size: 8pt; ' type='button' id='One_No_OT_Audio_Chapters-$i' value='No Audio OT Chapters in $item_from_array' onclick='One_No_OT_Audio_Chapters($i)' />";
										echo "<br /><span style='font-size: 8pt; '>Delete the OT audio filename for $item_from_array chapter 1 and click on this button to have none of the rest of $item_from_array filled in.</span>";
									}
									echo "</td>";
									echo "<td width='90%' style='line-height: 18px; padding: 12px; '>";
									echo "<table id='OT_Audio_Table3-$i' width='100%'>";
									echo "<tr>";
									for ($z = 0; $z < $item2_from_array; $z++) {
										if (($z % 3) == 0 && $z != 0) {
											echo "</tr><tr>";
										}
										$y = $z + 1;
										echo "<td width='10%'>";
										// $item_from_array-$y doesn't work. The only thing you get is the number!
										echo "<input style='font-size: 9pt; ' type='checkbox' name='OT_Audio_Index-$i-$z' id='OT_Audio_Index-$i-$z'" . (isset($_POST['OT_Audio_Index-'.(string)$i.'-'.(string)$z]) ? ' checked' : '') . " /><span style='font-size: 9pt; ' >&nbsp;$y&nbsp;</span>";
										echo "</td><td width='20%'>";
										echo "<input style='font-size: 9pt; text-align: left; ' type='text' onclick='document.getElementById(\"OT_Audio_Index-$i-$z\").checked = true;' name='OT_Audio_Filename-$i-$z' id='OT_Audio_Filename-$i-$z' size='19' value='" . (isset($_POST['OT_Audio_Filename-'.(string)$i.'-'.(string)$z]) ? $_POST['OT_Audio_Filename-'.(string)$i.'-'.(string)$z] : '' ) . "' />";
										echo "</td>";
									}
									if (($z % 3) != 0) {
										$y = 0;
										while ((($z + $y) % 3) != 0) {
											echo "<td width='10%'>&nbsp;</td>";
											echo "<td width='20%'>&nbsp;</td>";
											$y++;
										}
									}
									echo "</tr></table>";
									echo "</td></tr>";
								}
							?>
						</table>
					</div>
				</div>
			</div>
			<?php
		}
		// is 'OT_Audio' true?
		elseif ($SM_row['OT_Audio']) {
			$query="SELECT * FROM OT_Audio_Media WHERE ISO_ROD_index = $idx ORDER BY (OT_Audio_Book+0), (OT_Audio_Chapter+0)";		// turns strings into numbers
			$result1=$db->query($query);
			$num=$result1->num_rows;
			if ($result1 && $num > 0) {
				?>
				<input type='hidden' name='OT_Audio_Button' id='OT_Audio_Button' value='No' />
				<div id="OT_Off_Audio">		<!-- The id has to the same because of function classChange in AddorChange.js! -->
 					<input type='button' id='Open_OT_audio' value='Open OT audio' /> Are there any of the books in the Old Testament in audio (mp3) by chapter?<br />
				</div>
                <div class='enter' id='OT_Audio'>		<!-- The id has to the same because of function classChange in AddorChange.js! -->
					<input type='button' id='Close_OT_audio' value='Close OT audio' /> Here are the books in the Old Testament in audio (mp3) by chapters:<br />
					<input type='button' id='OT_Audio_Chapters' value='All Audio OT Chapters' /><span style='font-size: 9pt; font-weight: bold; '> Enter the audio filename for Genesis chapter 1 and click on this button to have all of the rest of the OT filled in.</span><br />
					<input type='button' id='No_OT_Audio_Chapters' value='No Audio OT Chapters' /><span style='font-size: 9pt; font-weight: bold; '> Delete the audio filename for Genesis chapter 1 and click on this button to have none of the rest of the OT deleted.</span>
					<br />
					<div id='All_OT_Audio_Div'>
						<div id='None_OT_Audio_Div'>
							<table id='OT_Audio_Table' width="100%">
								<?php
								$i = 0;
								$j = 0;
								$book_num_sel = 0;																// initial $book_num_sel
								$chap_num_sel = 0;																// initial $chap_num_sel
								while ($r = $result1->fetch_assoc()) {											// $num is the number of the ISO rows
									if ($book_num_sel < $r['OT_Audio_Book']) {									// is variable $book_num_sel < OT book number selected by "OT_Audio_Media" table
										// if "<" then each of this OT books that are empty
										// go back 1 in OT_Audio_Media table (?)
										$result1->data_seek($i);									// DO NOT DELETE $i BECAUSE IT HAS TO BE HERE FOR data_seek!!!!!
										$temp_book_num = $r['OT_Audio_Book'] - 1;
										for (; $book_num_sel <= $temp_book_num; $book_num_sel++) {				// each of the OT books that are empty
											$item_from_array = $OT_array[2][$book_num_sel];						// name of the OT book
											$item2_from_array = $OT_array[1][$book_num_sel];					// max. chapter number for the OT book
											echo "<tr style='vertical-align: top; '>";
											echo "<td width='10%' style='padding: 12px; '>";
											echo "&nbsp;$item_from_array:<br />";
											if ($item2_from_array > 1) {
												echo "<input style='font-size: 8pt; ' type='button' id='One_OT_Audio_Chapters-$book_num_sel' value='Audio OT Chapters in $item_from_array' onclick='One_OT_Audio_Chapters($book_num_sel)' />";
												echo "<br /><span style='font-size: 8pt; '>Enter the OT audio filename for $item_from_array chapter 1 and click on this button to have all of the rest of $item_from_array filled in.</span>";
												echo "<br /><br /><input style='font-size: 8pt; ' type='button' id='One_No_OT_Audio_Chapters-$book_num_sel' value='No Audio OT Chapters in $item_from_array' onclick='One_No_OT_Audio_Chapters($book_num_sel)' />";
												echo "<br /><span style='font-size: 8pt; '>Delete the OT audio filename for $item_from_array chapter 1 and click on this button to have none of the rest of $item_from_array filled in.</span>";
											}
											echo "</td>";
											echo "<td width='90%' style='line-height: 18px; padding: 12px; '>";
											echo "<table id='OT_Audio_Table3-$book_num_sel' width='100%'>";
											echo "<tr>";
											for ($z = 0; $z < $item2_from_array; $z++) {						// max. chapter number for the book
												if (($z % 3) == 0 && $z != 0) {
													echo "</tr><tr>";
												}
												$y = $z + 1;
												echo "<td width='10%'>";
												// $item_from_array-$y doesn't work. The only thing you get is the number!
												echo "<input style='font-size: 9pt; ' type='checkbox' name='OT_Audio_Index-$book_num_sel-$z' id='OT_Audio_Index-$book_num_sel-$z' /><span style='font-size: 9pt; ' >&nbsp;$y&nbsp;</span>";
												echo "</td><td width='20%'>";
												echo "<input style='font-size: 9pt; text-align: left; ' type='text' onclick='document.getElementById(\"OT_Audio_Index-$book_num_sel-$z\").checked = true;' name='OT_Audio_Filename-$book_num_sel-$z' id='OT_Audio_Filename-$book_num_sel-$z' size='19' value='' />";
												echo "</td>";
											}
											if (($z % 3) != 0) {
												$y = 0;
												while ((($z + $y) % 3) != 0) {
													echo "<td width='10%'>&nbsp;</td>";
													echo "<td width='20%'>&nbsp;</td>";
													$y++;
												}
											}
											echo "</tr></table>";
											echo "</td></tr>";
										}
									}
									else {
										// if "<" is not true then each of the OT book contain a filename
										$book_num_sel = $r['OT_Audio_Book'];
										$item_from_array = $OT_array[2][$book_num_sel];
										$item2_from_array = $OT_array[1][$book_num_sel];
										echo "<tr style='vertical-align: top; '>";
										echo "<td width='10%' style='padding: 12px; '>";
										echo "&nbsp;$item_from_array:<br />";
										if ($item2_from_array > 1) {
											echo "<input style='font-size: 8pt; ' type='button' id='One_OT_Audio_Chapters-$book_num_sel' value='Audio OT Chapters in $item_from_array' onclick='One_OT_Audio_Chapters($book_num_sel)' />";
											echo "<br /><span style='font-size: 8pt; '>Enter the OT audio filename for $item_from_array chapter 1 and click on this button to have all of the rest of $item_from_array filled in.</span>";
											echo "<br /><br /><input style='font-size: 8pt; ' type='button' id='One_No_OT_Audio_Chapters-$book_num_sel' value='No Audio OT Chapters in $item_from_array' onclick='One_No_OT_Audio_Chapters($book_num_sel)' />";
											echo "<br /><span style='font-size: 8pt; '>Delete the OT audio filename for $item_from_array chapter 1 and click on this button to have none of the rest of $item_from_array filled in.</span>";
										}
										echo "</td>";
										echo "<td width='90%' style='line-height: 18px; padding: 12px; '>";
										echo "<table id='OT_Audio_Table3-$book_num_sel' width='100%'>";
										echo "<tr>";
										$w=0;
										$z=0;
										$y=0;
										// while ($z < $item2_from_array) {										// $z < max. chapter number of this book
										while (true) {															// the above works, too
											$chap_num_sel = $r['OT_Audio_Chapter'] - 1;							// chapter number selected
											$OT_Audio_Filename = $r['OT_Audio_Filename'];						// chapter filename selected
											for (; ($w <= $chap_num_sel) && ($chap_num_sel <= $item2_from_array); $w++) {	// if empty chapter number is <= the selected chapter number AND the selected chapter number is <= the max. chapter number for the book
												if (($w % 3) == 0 && $w != 0) {
													echo "</tr><tr>";
												}
												$y = $w + 1;
												echo "<td width='10%'>";
												if ($w == $chap_num_sel) {
													echo "<input style='font-size: 9pt; ' type='checkbox' name='OT_Audio_Index-$book_num_sel-$w' id='OT_Audio_Index-$book_num_sel-$w' checked /><span style='font-size: 9pt; ' >&nbsp;$y&nbsp;</span>";
													echo "</td><td width='20%'>";
													echo "<input style='font-size: 9pt; text-align: left; ' type='text' onclick='document.getElementById(\"OT_Audio_Index-$book_num_sel-$w\").checked = true;' name='OT_Audio_Filename-$book_num_sel-$w' id='OT_Audio_Filename-$book_num_sel-$w' size='19' value='$OT_Audio_Filename' />";
												}
												else {
													echo "<input style='font-size: 9pt; ' type='checkbox' name='OT_Audio_Index-$book_num_sel-$w' id='OT_Audio_Index-$book_num_sel-$w' /><span style='font-size: 9pt; ' >&nbsp;$y&nbsp;</span>";
													echo "</td><td width='20%'>";
													echo "<input style='font-size: 9pt; text-align: left; ' type='text' onclick='document.getElementById(\"OT_Audio_Index-$book_num_sel-$w\").checked = true;' name='OT_Audio_Filename-$book_num_sel-$w' id='OT_Audio_Filename-$book_num_sel-$w' size='19' value='' />";
												}
												echo "</td>";
											}
											$i++;
											$z = $w;
											if ($z >= $item2_from_array) {										// max. chapter number of this book
												break;
											}
											if ($i >= $num) {													// if the max. chapter number for the book if >= the number of the ISO from the database
												break;
											}
											$r = $result1->fetch_assoc();
											if ($r['OT_Audio_Book'] > $book_num_sel) {							// if the book increases to another book then break
												//go back 1 in database
												$result1->data_seek($i);							// DO NOT DELETE $i BECAUSE IT HAS TO BE HERE FOR data_seek!!!!!
												break;
											}
										}
										for ($z; $z < $item2_from_array; $z++) {								// if any chapters are left, make them blank
											if (($z % 3) == 0 && $z != 0) {
												echo "</tr><tr>";
											}
											$y = $z + 1;
											echo "<td width='10%'>";
											echo "<input style='font-size: 9pt; ' type='checkbox' name='OT_Audio_Index-$book_num_sel-$z' id='OT_Audio_Index-$book_num_sel-$z' /><span style='font-size: 9pt; ' >&nbsp;$y&nbsp;</span>";
											echo "</td><td width='20%'>";
											echo "<input style='font-size: 9pt; text-align: left; ' type='text' onclick='document.getElementById(\"OT_Audio_Index-$book_num_sel-$z\").checked = true;' name='OT_Audio_Filename-$book_num_sel-$z' id='OT_Audio_Filename-$book_num_sel-$z' size='19' value='' />";
											echo "</td>";
										}
										if (($z % 3) != 0) {
											$y = 0;
											while ((($z + $y) % 3) != 0) {
												echo "<td width='10%'>&nbsp;</td>";
												echo "<td width='20%'>&nbsp;</td>";
												$y++;
											}
										}
										echo "</tr></table>";
										echo "</td></tr>";
										$book_num_sel++;
									}
								}
								// if any books are left, make them blank
								for ($w = $book_num_sel; $w < 39; $w++) {
									$item_from_array = $OT_array[2][$w];
									$item2_from_array = $OT_array[1][$w];
									echo "<tr style='vertical-align: top; '>";
									echo "<td width='10%' style='padding: 12px; '>";
									echo "&nbsp;$item_from_array:<br />";
									if ($item2_from_array > 1) {
										echo "<input style='font-size: 8pt; ' type='button' id='One_OT_Audio_Chapters-$w' value='Audio OT Chapters in $item_from_array' onclick='One_OT_Audio_Chapters($w)' />";
										echo "<br /><span style='font-size: 8pt; '>Enter the OT audio filename for $item_from_array chapter 1 and click on this button to have all of the rest of $item_from_array filled in.</span>";
										echo "<br /><br /><input style='font-size: 8pt; ' type='button' id='One_No_OT_Audio_Chapters-$w' value='No Audio OT Chapters in $item_from_array' onclick='One_No_OT_Audio_Chapters($w)' />";
										echo "<br /><span style='font-size: 8pt; '>Delete the OT audio filename for $item_from_array chapter 1 and click on this button to have none of the rest of $item_from_array filled in.</span>";
									}
									echo "</td>";
									echo "<td width='90%' style='line-height: 18px; padding: 12px; '>";
									echo "<table id='OT_Audio_Table3-$w' width='100%'>";
									echo "<tr>";
									for ($z = 0; $z < $item2_from_array; $z++) {
										if (($z % 3) == 0 && $z != 0) {
											echo "</tr><tr>";
										}
										$y = $z + 1;
										echo "<td width='10%'>";
										// $item_from_array-$y doesn't work. The only thing you get is the number!
										echo "<input style='font-size: 9pt; ' type='checkbox' name='OT_Audio_Index-$w-$z' id='OT_Audio_Index-$w-$z' /><span style='font-size: 9pt; ' >&nbsp;$y&nbsp;</span>";
										echo "</td><td width='20%'>";
										echo "<input style='font-size: 9pt; text-align: left; ' type='text' onclick='document.getElementById(\"OT_Audio_Index-$w-$z\").checked = true;' name='OT_Audio_Filename-$w-$z' id='OT_Audio_Filename-$w-$z' size='19' value='' />";
										echo "</td>";
									}
									if (($z % 3) != 0) {
										$y = 0;
										while ((($z + $y) % 3) != 0) {
											echo "<td width='10%'>&nbsp;</td>";
											echo "<td width='20%'>&nbsp;</td>";
											$y++;
										}
									}
									echo "</tr></table>";
									echo "</td></tr>";
								}
								?>
							</table>
						</div>
					</div>
				</div>
				<?php
			}
			if ($num > 0) {
				$result1->free();
			}
		}
		// is 'OT_Audio' false?
		else {																			// if not then make all of the books and chapters blank
			?>
			<input type='hidden' name='OT_Audio_Button' id='OT_Audio_Button' value='No' />
            <div id='OT_Off_Audio'>		<!-- The id has to the same because of function classChange in AddorChange.js! -->
				<input type='button' id='Open_OT_audio' value='Open OT audio' /> Are there any of the books in the Old Testament in audio (mp3) by chapter?<br />
			</div>
            <div class='enter' id='OT_Audio'>		<!-- The id has to the same because of function classChange in AddorChange.js! -->
				<input type='button' id="Close_OT_audio" value="Close OT audio" /> Here are the books in the Old Testament in audio (mp3) by chapters:<br />
				<input type='button' id='OT_Audio_Chapters' value='All Audio OT Chapters' /><span style='font-size: 9pt; font-weight: bold; '> Enter the audio filename for Genesis chapter 1 and click on this button to have all of the rest of the OT filled in.</span><br />
				<input type='button' id='No_OT_Audio_Chapters' value='No Audio OT Chapters' /><span style='font-size: 9pt; font-weight: bold; '> Delete the audio filename for Genesis chapter 1 and click on this button to have none of the rest of the OT deleted.</span>
				<br />
				<div id='All_OT_Audio_Div'>
					<div id='None_OT_Audio_Div'>
						<table id='OT_Audio_Table' width="100%">
							<?php
								// I need the names of the files
								for ($book_num_sel = 0; $book_num_sel < 39; $book_num_sel++) {
									$item_from_array = $OT_array[2][$book_num_sel];
									$item2_from_array = $OT_array[1][$book_num_sel];
									echo "<tr style='vertical-align: top; '>";
									echo "<td width='10%' style='padding: 12px; '>";
									echo "&nbsp;$item_from_array:<br />";
									if ($item2_from_array > 1) {
										echo "<input style='font-size: 8pt; ' type='button' id='One_OT_Audio_Chapters-$book_num_sel' value='Audio OT Chapters in $item_from_array' onclick='One_OT_Audio_Chapters($book_num_sel)' />";
										echo "<br /><span style='font-size: 8pt; '>Enter the OT audio filename for $item_from_array chapter 1 and click on this button to have all of the rest of $item_from_array filled in.</span>";
										echo "<br /><br /><input style='font-size: 8pt; ' type='button' id='One_No_OT_Audio_Chapters-$book_num_sel' value='No Audio OT Chapters in $item_from_array' onclick='One_No_OT_Audio_Chapters($book_num_sel)' />";
										echo "<br /><span style='font-size: 8pt; '>Delete the OT audio filename for $item_from_array chapter 1 and click on this button to have none of the rest of $item_from_array filled in.</span>";
									}
									echo "</td>";
									echo "<td width='90%' style='line-height: 18px; padding: 12px; '>";
									echo "<table id='OT_Audio_Table3-$book_num_sel' width='100%'>";
									echo "<tr>";
									for ($z = 0; $z < $item2_from_array; $z++) {
										if (($z % 3) == 0 && $z != 0) {
											echo "</tr><tr>";
										}
										$y = $z + 1;
										echo "<td width='10%'>";
										// $item_from_array-$y doesn't work. The only thing you get is the number!
										echo "<input style='font-size: 9pt; ' type='checkbox' name='OT_Audio_Index-$book_num_sel-$z' id='OT_Audio_Index-$book_num_sel-$z' /><span style='font-size: 9pt; ' >&nbsp;$y&nbsp;</span>";
										echo "</td><td width='20%'>";
										echo "<input style='font-size: 9pt; text-align: left; ' type='text' onclick='document.getElementById(\"OT_Audio_Index-$book_num_sel-$z\").checked = true;' name='OT_Audio_Filename-$book_num_sel-$z' id='OT_Audio_Filename-$book_num_sel-$z' size='19' value='' />";
										echo "</td>";
									}
									if (($z % 3) != 0) {
										$y = 0;
										while ((($z + $y) % 3) != 0) {
											echo "<td width='10%'>&nbsp;</td>";
											echo "<td width='20%'>&nbsp;</td>";
											$y++;
										}
									}
									echo "</tr></table>";
									echo "</td></tr>";
								}
							?>
						</table>
					</div>
				</div>
			</div>
		<?php
		}
		?>
		<br />
		
		<?php
/*************************************************
	NT audio books
**************************************************/
		if (isset($_POST['NT_Audio_Index-0-0'])) {																// if there are error then display the $_POST's
			?>
			<input type='hidden' name='Audio_Button' id='Audio_Button' value='No' />
            <div id='NT_Off_Audio'>		<!-- The id has to the same because of function classChange in AddorChange.js! -->
				<input type='button' id='Open_NT_audio' value='Open NT audio' /> Are there any of the books in the New Testament in audio (mp3) by chapter?<br />
			</div>
            <div class='enter' id='NT_Audio'>		<!-- The id has to the same because of function classChange in AddorChange.js! -->
				<input type='button' id="Close_NT_audio" value="Close NT audio" /> Here are the books in the New Testament in audio (mp3) by chapters:<br />
				<input type='button' id='NT_Audio_Chapters' value='All Audio NT Chapters' /><span style='font-size: 9pt; font-weight: bold; '> Enter the audio filename for Matthew chapter 1 and click on this button to have all of the rest of the NT filled in.</span><br />
				<input type='button' id='No_NT_Audio_Chapters' value='No Audio NT Chapters' /><span style='font-size: 9pt; font-weight: bold; '> Delete the audio filename for Matthew chapter 1 and click on this button to have none of the rest of the NT deleted.</span>
				<br />
				<div id='All_Audio_Div'>
					<div id='None_Audio_Div'>
						<table id='NT_Audio_Table' width="100%">
							<?php
								// I need the names of the files
								for ($i = 0; $i < 27; $i++) {
									$item_from_array = $NT_array[2][$i];
									$item2_from_array = $NT_array[1][$i];
									echo "<tr style='vertical-align: top; '>";
									echo "<td width='10%' style='padding: 12px; '>";
									echo "&nbsp;$item_from_array:<br />";
									if ($item2_from_array > 1) {
										echo "<input style='font-size: 8pt; ' type='button' id='One_NT_Audio_Chapters-$i' value='Audio NT Chapters in $item_from_array' onclick='One_NT_Audio_Chapters($i)' />";
										echo "<br /><span style='font-size: 8pt; '>Enter the audio filename for $item_from_array chapter 1 and click on this button to have all of the rest of $item_from_array filled in.</span>";
										echo "<br /><br /><input style='font-size: 8pt; ' type='button' id='One_No_NT_Audio_Chapters-$i' value='No Audio NT Chapters in $item_from_array' onclick='One_No_NT_Audio_Chapters($i)' />";
										echo "<br /><span style='font-size: 8pt; '>Delete the NT audio filename for $item_from_array chapter 1 and click on this button to have none of the rest of $item_from_array filled in.</span>";
									}
									echo "</td>";
									echo "<td width='90%' style='line-height: 18px; padding: 12px; '>";
									echo "<table id='NT_Audio_Table3-$i' width='100%'>";
									echo "<tr>";
									for ($z = 0; $z < $item2_from_array; $z++) {
										if (($z % 3) == 0 && $z != 0) {
											echo "</tr><tr>";
										}
										$y = $z + 1;
										echo "<td width='10%'>";
										// $item_from_array-$y doesn't work. The only thing you get is the number!
										echo "<input style='font-size: 9pt; ' type='checkbox' name='NT_Audio_Index-$i-$z' id='NT_Audio_Index-$i-$z'" . (isset($_POST['NT_Audio_Index-'.(string)$i.'-'.(string)$z]) ? ' checked' : '') . " /><span style='font-size: 9pt; ' >&nbsp;$y&nbsp;</span>";
										echo "</td><td width='20%'>";
										echo "<input style='font-size: 9pt; text-align: left; ' type='text' onclick='document.getElementById(\"NT_Audio_Index-$i-$z\").checked = true;' name='NT_Audio_Filename-$i-$z' id='NT_Audio_Filename-$i-$z' size='19' value='" . (isset($_POST['NT_Audio_Filename-'.(string)$i.'-'.(string)$z]) ? $_POST['NT_Audio_Filename-'.(string)$i.'-'.(string)$z] : '' ) . "' />";
										echo "</td>";
									}
									if (($z % 3) != 0) {
										$y = 0;
										while ((($z + $y) % 3) != 0) {
											echo "<td width='10%'>&nbsp;</td>";
											echo "<td width='20%'>&nbsp;</td>";
											$y++;
										}
									}
									echo "</tr></table>";
									echo "</td></tr>";
								}
							?>
						</table>
					</div>
				</div>
			</div>
			<?php
		}
		elseif ($SM_row['NT_Audio']) {																			// scripture_main table
			$query="SELECT * FROM NT_Audio_Media WHERE ISO_ROD_index = $idx ORDER BY (NT_Audio_Book+0), (NT_Audio_Chapter+0)";		// turns strings into numbers
			$result1=$db->query($query);
			$num=$result1->num_rows;
			if ($result1 && $num > 0) {																			// NT_Audio_Media table
				?>
				<input type='hidden' name='Audio_Button' id='Audio_Button' value='No' />
            	<div id='NT_Off_Audio'>		<!-- The id has to the same because of function classChange in AddorChange.js! -->
					<input type='button' id='Open_NT_audio' value='Open NT audio' /> Are there any of the books in the New Testament in audio (mp3) by chapter?<br />
				</div>
                <div class='enter' id='NT_Audio'>		<!-- The id has to the same because of function classChange in AddorChange.js! -->
					<input type='button' id="Close_NT_audio" value="Close NT audio" /> Here are the books in the New Testament in audio (mp3) by chapters:<br />
					<input type='button' id='NT_Audio_Chapters' value='All Audio NT Chapters' /><span style='font-size: 9pt; font-weight: bold; '> Enter the audio filename for Matthew chapter 1 and click on this button to have all of the rest of the NT filled in.</span><br />
					<input type='button' id='No_NT_Audio_Chapters' value='No Audio NT Chapters' /><span style='font-size: 9pt; font-weight: bold; '> Delete the audio filename for Matthew chapter 1 and click on this button to have none of the rest of the NT deleted.</span>
					<br />
					<div id='All_Audio_Div'>
						<div id='None_Audio_Div'>
							<table id='NT_Audio_Table' width="100%">
								<?php
								$i = 0;
								$j = 0;
								$book_num_sel = 0;
								$chap_num_sel = 0;
								while ($r = $result1->fetch_assoc()) {											// $num is the number of the ISO rows
									if ($book_num_sel < $r['NT_Audio_Book']) {									// book number selected
										// go back 1 in database
										$result1->data_seek($i);									// DO NOT DELETE $i BECAUSE IT HAS TO BE HERE FOR data_seek!!!!!
										$temp_book_num = $r['NT_Audio_Book'] - 1;
										for (; $book_num_sel <= $temp_book_num; $book_num_sel++) {				// each of the books that are empty
											$item_from_array = $NT_array[2][$book_num_sel];						// name of the book
											$item2_from_array = $NT_array[1][$book_num_sel];					// max. chapter number for the book
											echo "<tr style='vertical-align: top; '>";
											echo "<td width='10%' style='padding: 12px; '>";
											echo "&nbsp;$item_from_array:<br />";
											if ($item2_from_array > 1) {
												echo "<input style='font-size: 8pt; ' type='button' id='One_NT_Audio_Chapters-$book_num_sel' value='Audio NT Chapters in $item_from_array' onclick='One_NT_Audio_Chapters($book_num_sel)' />";
												echo "<br /><span style='font-size: 8pt; '>Enter the audio filename for $item_from_array chapter 1 and click on this button to have all of the rest of $item_from_array filled in.</span>";
												echo "<br /><br /><input style='font-size: 8pt; ' type='button' id='One_No_NT_Audio_Chapters-$book_num_sel' value='No Audio NT Chapters in $item_from_array' onclick='One_No_NT_Audio_Chapters($book_num_sel)' />";
												echo "<br /><span style='font-size: 8pt; '>Delete the NT audio filename for $item_from_array chapter 1 and click on this button to have none of the rest of $item_from_array filled in.</span>";
											}
											echo "</td>";
											echo "<td width='90%' style='line-height: 18px; padding: 12px; '>";
											echo "<table id='NT_Audio_Table3-$book_num_sel' width='100%'>";
											echo "<tr>";
											for ($z = 0; $z < $item2_from_array; $z++) {						// max. chapter number for the book
												if (($z % 3) == 0 && $z != 0) {
													echo "</tr><tr>";
												}
												$y = $z + 1;
												echo "<td width='10%'>";
												echo "<input style='font-size: 9pt; ' type='checkbox' name='NT_Audio_Index-$book_num_sel-$z' id='NT_Audio_Index-$book_num_sel-$z' /><span style='font-size: 9pt; ' >&nbsp;$y&nbsp;</span>";
												echo "</td><td width='20%'>";
												echo "<input style='font-size: 9pt; text-align: left; ' type='text' onclick='document.getElementById(\"NT_Audio_Index-$book_num_sel-$z\").checked = true;' name='NT_Audio_Filename-$book_num_sel-$z' id='NT_Audio_Filename-$book_num_sel-$z' size='19' value='' />";
												echo "</td>";
											}
											if (($z % 3) != 0) {
												$y = 0;
												while ((($z + $y) % 3) != 0) {
													echo "<td width='10%'>&nbsp;</td>";
													echo "<td width='20%'>&nbsp;</td>";
													$y++;
												}
											}
											echo "</tr></table>";
											echo "</td></tr>";
										}
									}
									else {
										$book_num_sel = $r['NT_Audio_Book'];
										$item_from_array = $NT_array[2][$book_num_sel];							// name of the book
										$item2_from_array = $NT_array[1][$book_num_sel];						// max. chapter number of this book
										echo "<tr style='vertical-align: top; '>";
										echo "<td width='10%' style='padding: 12px; '>";
										echo "&nbsp;$item_from_array:<br />";
										if ($item2_from_array > 1) {
											echo "<input style='font-size: 8pt; ' type='button' id='One_NT_Audio_Chapters-$book_num_sel' value='Audio NT Chapters in $item_from_array' onclick='One_NT_Audio_Chapters($book_num_sel)' />";
											echo "<br /><span style='font-size: 8pt; '>Enter the audio filename for $item_from_array chapter 1 and click on this button to have all of the rest of $item_from_array filled in.</span>";
											echo "<br /><br /><input style='font-size: 8pt; ' type='button' id='One_No_NT_Audio_Chapters-$book_num_sel' value='No Audio NT Chapters in $item_from_array' onclick='One_No_NT_Audio_Chapters($book_num_sel)' />";
											echo "<br /><span style='font-size: 8pt; '>Delete the NT audio filename for $item_from_array chapter 1 and click on this button to have none of the rest of $item_from_array filled in.</span>";
										}
										echo "</td>";
										echo "<td width='90%' style='line-height: 18px; padding: 12px; '>";
										echo "<table id='NT_Audio_Table3-$book_num_sel' width='100%'>";
										echo "<tr>";
										$w=0;
										$z=0;
										$y=0;
										// while ($z < $item2_from_array) {										// $z < max. chapter number of this book
										while (true) {															// the above works, too
											$chap_num_sel = $r['NT_Audio_Chapter'] - 1;							// chapter number selected
											$NT_Audio_Filename = $r['NT_Audio_Filename'];						// chapter filename selected
											for (; ($w <= $chap_num_sel) && ($chap_num_sel <= $item2_from_array); $w++) {	// if empty chapter number is <= the selected chapter number AND the selected chapter number is <= the max. chapter number for the book
												if (($w % 3) == 0 && $w != 0) {
													echo "</tr><tr>";
												}
												$y = $w + 1;
												echo "<td width='10%'>";
												if ($w == $chap_num_sel) {
													echo "<input style='font-size: 9pt; ' type='checkbox' name='NT_Audio_Index-$book_num_sel-$w' id='NT_Audio_Index-$book_num_sel-$w' checked /><span style='font-size: 9pt; ' >&nbsp;$y&nbsp;</span>";
													echo "</td><td width='20%'>";
													echo "<input style='font-size: 9pt; text-align: left; ' type='text' onclick='document.getElementById(\"NT_Audio_Index-$book_num_sel-$w\").checked = true;' name='NT_Audio_Filename-$book_num_sel-$w' id='NT_Audio_Filename-$book_num_sel-$w' size='19' value='$NT_Audio_Filename' />";
												}
												else {
													echo "<input style='font-size: 9pt; ' type='checkbox' name='NT_Audio_Index-$book_num_sel-$w' id='NT_Audio_Index-$book_num_sel-$w' /><span style='font-size: 9pt; ' >&nbsp;$y&nbsp;</span>";
													echo "</td><td width='20%'>";
													echo "<input style='font-size: 9pt; text-align: left; ' type='text' onclick='document.getElementById(\"NT_Audio_Index-$book_num_sel-$w\").checked = true;' name='NT_Audio_Filename-$book_num_sel-$w' id='NT_Audio_Filename-$book_num_sel-$w' size='19' value='' />";
												}
												echo "</td>";
											}
											$i++;
											$z = $w;
											if ($z >= $item2_from_array) {										// max. chapter number of this book
												break;
											}
											if ($i >= $num) {													// if the max. chapter number for the book if >= the number of the ISO from the database
												break;
											}
											$r = $result1->fetch_assoc();
											if ($r['NT_Audio_Book'] > $book_num_sel) {							// if the book increases to another book then break
												//go back 1 in database
												$result1->data_seek($i);							// DO NOT DELETE $i BECAUSE IT HAS TO BE HERE FOR data_seek!!!!!
												break;
											}
										}
										for ($z; $z < $item2_from_array; $z++) {								// if any chapters are left, make them blank
											if (($z % 3) == 0 && $z != 0) {
												echo "</tr><tr>";
											}
											$y = $z + 1;
											echo "<td width='10%'>";
											echo "<input type='checkbox' style='font-size: 9pt; ' name='NT_Audio_Index-$book_num_sel-$z' id='NT_Audio_Index-$book_num_sel-$z' /><span style='font-size: 9pt; ' >&nbsp;$y&nbsp;</span>";
											echo "</td><td width='20%'>";
											echo "<input type='text' style='font-size: 9pt; text-align: left; ' onclick='document.getElementById(\"NT_Audio_Index-$book_num_sel-$z\").checked = true;' name='NT_Audio_Filename-$book_num_sel-$z' id='NT_Audio_Filename-$book_num_sel-$z' size='19' value='' />";
											echo "</td>";
										}
										if (($z % 3) != 0) {
											$y = 0;
											while ((($z + $y) % 3) != 0) {
												echo "<td width='10%'>&nbsp;</td>";
												echo "<td width='20%'>&nbsp;</td>";
												$y++;
											}
										}
										echo "</tr></table>";
										echo "</td></tr>";
										$book_num_sel++;
									}
								}
								for ($w = $book_num_sel; $w < 27; $w++) {										// if any books are left, make them blank
									$item_from_array = $NT_array[2][$w];
									$item2_from_array = $NT_array[1][$w];
									echo "<tr style='vertical-align: top; '>";
									echo "<td width='10%' style='padding: 12px; '>";
									echo "&nbsp;$item_from_array:<br />";
									if ($item2_from_array > 1) {
										echo "<input type='button' style='font-size: 8pt; ' id='One_NT_Audio_Chapters-$w' value='Audio NT Chapters in $item_from_array' onclick='One_NT_Audio_Chapters($w)' />";
										echo "<br /><span style='font-size: 8pt; '>Enter the audio filename for $item_from_array chapter 1 and click on this button to have all of the rest of $item_from_array filled in.</span>";
										echo "<br /><br /><input style='font-size: 8pt; ' type='button' id='One_No_NT_Audio_Chapters-$w' value='No Audio NT Chapters in $item_from_array' onclick='One_No_NT_Audio_Chapters($w)' />";
										echo "<br /><span style='font-size: 8pt; '>Delete the NT audio filename for $item_from_array chapter 1 and click on this button to have none of the rest of $item_from_array filled in.</span>";
									}
									echo "</td>";
									echo "<td width='90%' style='line-height: 18px; padding: 12px; '>";
									echo "<table id='NT_Audio_Table3-$w' width='100%'>";
									echo "<tr>";
									for ($z = 0; $z < $item2_from_array; $z++) {
										if (($z % 3) == 0 && $z != 0) {
											echo "</tr><tr>";
										}
										$y = $z + 1;
										echo "<td width='10%'>";
										// $item_from_array-$y doesn't work. The only thing you get is the number!
										echo "<input type='checkbox' style='font-size: 9pt; ' name='NT_Audio_Index-$w-$z' id='NT_Audio_Index-$w-$z' /><span style='font-size: 9pt; ' >&nbsp;$y&nbsp;</span>";
										echo "</td><td width='20%'>";
										echo "<input type='text' style='font-size: 9pt; text-align: left; ' onclick='document.getElementById(\"NT_Audio_Index-$w-$z\").checked = true;' name='NT_Audio_Filename-$w-$z' id='NT_Audio_Filename-$w-$z' size='19' value='' />";
										echo "</td>";
									}
									if (($z % 3) != 0) {
										$y = 0;
										while ((($z + $y) % 3) != 0) {
											echo "<td width='10%'>&nbsp;</td>";
											echo "<td width='20%'>&nbsp;</td>";
											$y++;
										}
									}
									echo "</tr></table>";
									echo "</td></tr>";
								}
								?>
							</table>
						</div>
					</div>
				</div>
				<?php
			}
			if ($num > 0) {
				$result1->free();
			}
		}
		else {																			// if not then make all of the books and chapters blank
			?>
			<input type='hidden' name='Audio_Button' id='Audio_Button' value='No' />
            <div id='NT_Off_Audio'>		<!-- The id has to the same because of function classChange in AddorChange.js! -->
				<input type='button' id='Open_NT_audio' value='Open NT audio' /> Are there any of the books in the New Testament in audio (mp3) by chapter?<br />
			</div>
            <div class='enter' id='NT_Audio'>		<!-- The id has to the same because of function classChange in AddorChange.js! -->
				<input type='button' id="Close_NT_audio" value="Close NT audio" /> Here are the books in the New Testament in audio (mp3) by chapters:<br />
				<input type='button' id='NT_Audio_Chapters' value='All Audio NT Chapters' /><span style='font-size: 9pt; font-weight: bold; '> Enter the audio filename for Matthew chapter 1 and click on this button to have all of the rest of the NT filled in.</span><br />
				<input type='button' id='No_NT_Audio_Chapters' value='No Audio NT Chapters' /><span style='font-size: 9pt; font-weight: bold; '> Delete the audio filename for Matthew chapter 1 and click on this button to have none of the rest of the NT deleted.</span>
				<br />
				<div id='All_Audio_Div'>
					<div id='None_Audio_Div'>
						<table id='NT_Audio_Table' width="100%">
							<?php
								// I need the names of the files
								for ($book_num_sel = 0; $book_num_sel < 27; $book_num_sel++) {
									$item_from_array = $NT_array[2][$book_num_sel];
									$item2_from_array = $NT_array[1][$book_num_sel];
									echo "<tr style='vertical-align: top; '>";
									echo "<td width='10%' style='padding: 12px; '>";
									echo "&nbsp;$item_from_array:<br />";
									if ($item2_from_array > 1) {
										echo "<input style='font-size: 8pt; ' type='button' id='One_NT_Audio_Chapters-$book_num_sel' value='Audio NT Chapters in $item_from_array' onclick='One_NT_Audio_Chapters($book_num_sel)' />";	//'NT_Audio_testing($book_num_sel)' />";	//
										echo "<br /><span style='font-size: 8pt; '>Enter the audio filename for $item_from_array chapter 1 and click on this button to have all of the rest of $item_from_array filled in.</span>";
										echo "<br /><br /><input style='font-size: 8pt; ' type='button' id='One_No_NT_Audio_Chapters-$book_num_sel' value='No Audio NT Chapters in $item_from_array' onclick='One_No_NT_Audio_Chapters($book_num_sel)' />";
										echo "<br /><span style='font-size: 8pt; '>Delete the NT audio filename for $item_from_array chapter 1 and click on this button to have none of the rest of $item_from_array filled in.</span>";
									}
									echo "</td>";
									echo "<td width='90%' style='line-height: 18px; padding: 12px; '>";
									echo "<table id='NT_Audio_Table3-$book_num_sel' width='100%'>";
									echo "<tr>";
									for ($z = 0; $z < $item2_from_array; $z++) {
										if (($z % 3) == 0 && $z != 0) {
											echo "</tr><tr>";
										}
										$y = $z + 1;
										echo "<td width='10%'>";
										echo "<input style='font-size: 9pt; ' type='checkbox' name='NT_Audio_Index-$book_num_sel-$z' id='NT_Audio_Index-$book_num_sel-$z' /><span style='font-size: 9pt; ' >&nbsp;$y&nbsp;</span>";
										echo "</td><td width='20%'>";
										echo "<input style='font-size: 9pt; text-align: left; ' type='text' onclick='document.getElementById(\"NT_Audio_Index-$book_num_sel-$z\").checked = true;' name='NT_Audio_Filename-$book_num_sel-$z' id='NT_Audio_Filename-$book_num_sel-$z' size='19' value='' />";
										echo "</td>";
									}
									if (($z % 3) != 0) {
										$y = 0;
										while ((($z + $y) % 3) != 0) {
											echo "<td width='10%'>&nbsp;</td>";
											echo "<td width='20%'>&nbsp;</td>";
											$y++;
										}
									}
									echo "</tr></table>";
									echo "</td></tr>";
								}
							?>
						</table>
					</div>
				</div>
			</div>
		<?php
		}
		?>

		<br />
        <hr align="center" width="90%" color="#0066CC" />
        <br />
        
		<?php
/*************************************************
	SAB - Scriture Apps Buidler (table SAB) HTML
*************************************************/
	/*
		$SAB (bitwise):
			decimal		binary		meaning
			1			000001		NT Synchronized text and audio
			2			000010		OT Synchronized text and audio
			4			000100		NT Synchronized audio where available
			8			001000		OT Synchronized audio where available
			16			010000		NT View text only
			32			100000		OT View text only
			
			Scriptoria needs help on audio
	*/
	?>
        <div>Synchronized text and audio (Scripture Apps Builder) HTMLs:</div>
		<table valign="bottom" style="margin-top: 10px; " cellpadding="0" cellspacing="0" width="100%">
        <thead>
			<tr valign="bottom" style="color: navy; font-size: 8pt; line-height: 10pt; height: 30px; ">
				<td width="13%">&nbsp;
				</td>
				<td width="13%" style="padding-left: 3px; ">
					SE subfolder under 'sab/' <!--span style="font-weight: bold; font-size: 9pt; ">AND</span> all of the HTML files that go under the subfolder-->
				</td>
				<td width="24%" style="padding-left: 3px; ">
					<b>OR</b> URL (not on the SE server)
				</td>
				<td width="24%" style="padding-left: 3px; ">
					Description <i>(optional)</i>
				</td>
				<td width="36%" colspan="2" style="padding-left: 3px; ">
					&nbsp;	<!--remove: Pre-Scriptoria HTML files-->
				</td>
			</tr>
		</thead>
        <?php
        $numSAB_scriptoria = 0;
		
		if (isset($_POST['txtSABsubfolder-1'])) {										// if data comes from "Edit_Lang_Validation.php"
            ${'txtSABsubfolder-1'} = $_POST['txtSABsubfolder-1'];
            ${'txtSABurl-1'} = $_POST['txtSABurl-1'];
            ${'txtSABdescription-1'} = $_POST['txtSABdescription-1'];
            ${'txtSABpreScriptoria-1'} = $_POST['txtSABpreScriptoria-1'];
		}
		elseif ($SM_row['SAB'] >= 1) {													// if data comes from sab_scriptoria table
            $query="SELECT `url`, `subfolder`, `description`, `pre_scriptoria` FROM SAB_scriptoria WHERE ISO_ROD_index = $idx";
            $resultSAB_scriptoria=$db->query($query);
            $numSAB_scriptoria = $resultSAB_scriptoria->num_rows;
			if ($numSAB_scriptoria > 0) {
				$tempSAB_scriptoria = $resultSAB_scriptoria->fetch_assoc();
				${'txtSABpreScriptoria-1'} = $tempSAB_scriptoria['pre_scriptoria'];
				if (${'txtSABpreScriptoria-1'} !== '') {
					${'txtSABsubfolder-1'} = ${'txtSABpreScriptoria-1'};
            		${'txtSABurl-1'} = '';
					${'txtSABsubFirstPath-1'} = 'sab';
				}
				else {
					${'txtSABsubfolder-1'} = $tempSAB_scriptoria['subfolder'];
				}
            	${'txtSABurl-1'} = $tempSAB_scriptoria['url'];
				${'txtSABdescription-1'} = $tempSAB_scriptoria['description'];
			 }
			 else {
				$SM_row['SAB'] = 0;
				${'txtSABsubfolder-1'}='';
            	${'txtSABurl-1'}='';
				${'txtSABdescription-1'}='';
				${'txtSABpreScriptoria-1'}='';
				${'txtSABsubFirstPath-1'}='sab';				 
			 }
        }
        else {																			// if data is doesn't exist
            ${'txtSABsubfolder-1'}='';
            ${'txtSABurl-1'}='';
            ${'txtSABdescription-1'}='';
            ${'txtSABpreScriptoria-1'}='';
			${'txtSABsubFirstPath-1'}='sab';
        }
		${'txtSABsubFirstPath-1'} = '';
		if (${'txtSABpreScriptoria-1'} !== '') {										// if data is in preScriptoria-1 (old)
            ${'txtSABurl-1'}='';
			${'txtSABsubFirstPath-1'} = 'sab';
			${'txtSABsubfolder-1'} = ${'txtSABpreScriptoria-1'};
		}
		elseif (${'txtSABsubfolder-1'} !== '' && strpos(${'txtSABsubfolder-1'}, '/')) {								// if there is data in subfolder-1
			${'txtSABsubFirstPath-1'} = substr(${'txtSABsubfolder-1'}, 0, strpos(${'txtSABsubfolder-1'}, '/'));
			${'txtSABsubfolder-1'} = substr(${'txtSABsubfolder-1'}, strpos(${'txtSABsubfolder-1'}, '/')+1, -1);		// remove first "path" and remove last "/"
		}
			else {		// url != ''
		}
		?>
		<tbody name="tableSABHTMLEdit" id="tableSABHTMLEdit">
			<tr valign="top" style="line-height: 10pt; ">
				<td width="13%" style="font-size: 10pt; ">
					<div style="margin-top: 10px; ">Enter "SAB HTMLs":</div>For example:
				</td>
				<td width="13%">
					<input type='text' style='color: navy; ' size='13' name='txtSABsubfolder-1' id='txtSABsubfolder-1' value="<?php echo ${'txtSABsubfolder-1'}; ?>" />
					<input type='hidden' name='txtSABsubFirstPath-1' id='txtSABsubFirstPath-1' value="<?php echo ${'txtSABsubFirstPath-1'}; ?>" />
                    <br /><span style="font-size: 10pt; margin-left: 3px; ">tuo <b>or</b> tuoB <b>or</b> tuo2019</span>
				</td>
				<td width="24%">
					<input type='text' style='color: navy; ' size='31' name='txtSABurl-1' id='txtSABurl-1' value="<?php echo ${'txtSABurl-1'}; ?>" />
                    <br /><span style="font-size: 10pt; margin-left: 1px; ">https://...</span>
				</td>
				<td width="24%">
					<input type='text' style='color: navy; ' size='31' name='txtSABdescription-1' id='txtSABdescription-1' value="<?php echo ${'txtSABdescription-1'}; ?>" />
                    <br /><span style="font-size: 10pt; margin-left: 1px; ">- Brazil <b>or</b> version 2019</span>
				</td>
				<td width="16%">
					&nbsp;
					<input type='hidden' name='txtSABpreScriptoria-1' id='txtSABpreScriptoria-1' value="<?php echo ${'txtSABpreScriptoria-1'}; ?>" />
					<!--input type='text' style='color: black; ' size='12' name='txtSABpreScriptoria-1' id='txtSABpreScriptoria-1' value="< ?php echo ${'txtSABpreScriptoria-1'}; ?>" />
                    <br /><span style="font-size: 10pt; margin-left: 1px; ">tuo (if pre-Scriptoria<br />HTML files)</span-->
				</td>
                <td width="20%" style="text-align: right; vertical-align: top; ">
                    <input id='addSABHTMLEdit' style="font-size: 9pt; " type="button" onClick="addRowToTableSABHTMLEdit()" value="Add" />
                    <input id='removeSABHTMLEdit' style="font-size: 9pt; " type="button" onClick="removeRowFromTable('tableSABHTMLEdit')" value="Remove" />
                </td>
			</tr>
            <?php
			$i = 2;
			if (isset($_POST['txtSABsubfolder-'.(string)$i])) {
				while (isset($_POST['txtSABsubfolder-'.(string)$i])) {
					if ($_POST['txtpreScriptoria-'.(string)$i] === '') {
						${"txtSABsubfolder-$i"} = $_POST['txtSABsubfolder-'.(string)$i];
						if (strpos(${"txtSABsubfolder-$i"}, '/')) {
							${"txtSABsubFirstPath-$i"} = substr(${"txtSABsubfolder-$i"}, 0, strpos(${"txtSABsubfolder-$i"}, '/'));		// save first "path"
							${"txtSABsubfolder-$i"} = substr(${"txtSABsubfolder-$i"}, strpos(${"txtSABsubfolder-$i"}, '/')+1, -1);		// remove first "path" and remove last "/"
						}
					}
					else {
						${"txtSABsubfolder-$i"} = 'sab/';
						${"txtSABsubFirstPath-$i"} = 'sab';
					}
					echo "<tr valign='bottom' style='line-height: 10pt; '>";
						echo "<td width='13%'>";
							echo "&nbsp;";
						echo "</td>";
						echo "<td width='13%'>";
							echo "<input type='text' name='txtSABsubfolder-$i' id='txtSABsubfolder-$i' style='color: navy; ' size='15' value='".${"txtSABsubfolder-$i"}."' />";
						echo "</td>";
						echo "<td width='24%'>";
							echo "<input type='text' name='txtSABurl-$i' id='txtSABurl-$i' style='color: navy; ' size='31' value='" . ( isset($_POST['txtSABurl-'.(string)$i]) ? $_POST['txtSABurl-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='24%'>";
							echo "<input type='text' name='txtSABdescription-$i' id='txtSABdescription-$i' style='color: navy; ' size='31' value='" . ( isset($_POST['txtSABdescription-'.(string)$i]) ? $_POST['txtSABdescription-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='16%'>";
							echo '&nbsp;';
							//echo "<input type='text' readonly name='txtSABpreScriptoria-$i' id='txtSABpreScriptoria-$i' style='color: navy; ' size='15' value='" . ( isset($_POST['txtSABpreScriptoria-'.(string)$i]) ? $_POST['txtSABpreScriptoria-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='20%'>";
							echo "&nbsp;";
						echo "</td>";
					echo "</tr>";
					$i++;
				}
			}
			else {
				if ($numSAB_scriptoria > 1) {
					while ($tempSAB_scriptoria = $resultSAB_scriptoria->fetch_assoc()) {
						${"txtSABsubfolder-$i"} = $tempSAB_scriptoria['subfolder'];
						${"txtSABurl-$i"} = $tempSAB_scriptoria['url'];
						${"txtSABdescription-$i"} = $tempSAB_scriptoria['description'];
						${"txtSABpreScriptoria-$i"} = $tempSAB_scriptoria['pre_scriptoria'];
						${"txtSABsubFirstPath-$i"} = '';
						if (${"txtSABurl-$i"} == '') {
							if (${"txtSABpreScriptoria-$i"} == '' && strpos(${"txtSABsubfolder-$i"}, '/')) {
								${"txtSABsubFirstPath-$i"} = substr(${"txtSABsubfolder-$i"}, 0, strpos(${"txtSABsubfolder-$i"}, '/'));		// save first "path"
								${"txtSABsubfolder-$i"} = substr(${"txtSABsubfolder-$i"}, strpos(${"txtSABsubfolder-$i"}, '/')+1, -1);		// remove first "path" and remove last "/"
							}
							else {
								${"txtSABsubfolder-$i"} = 'sab/';
							}
						}
						else {
							${"txtSABsubfolder-$i"} = '';
							${"txtSABpreScriptoria-$i"} = '';
						}
						echo "<tr valign='bottom' style='line-height: 10pt; '>";
							echo "<td width='13%'>";
								echo "&nbsp;";
							echo "</td>";
							echo "<td width='13%'>";
								echo "<input type='text' name='txtSABsubfolder-$i' id='txtSABsubfolder-$i' style='color: navy; ' size='15' value='" . ${"txtSABsubfolder-$i"} . "' />";
								echo "<input type='hidden' name='txtSABsubFirstPath-$1' id='txtSABsubFirstPath-$i' value='".${"txtSABsubFirstPath-$i"}."' />";
							echo "</td>";
							echo "<td width='24%'>";
								echo "<input type='text' name='txtSABurl-$i' id='txtSABurl-$i' style='color: navy; ' size='31' value='" . ${"txtSABurl-$i"} . "' />";
							echo "</td>";
							echo "<td width='24%'>";
								echo "<input type='text' name='txtSABdescription-$i' id='txtSABdescription-$i' style='color: navy; ' size='31' value='" . ${"txtSABdescription-$i"} . "' />";
							echo "</td>";
							echo "<td width='16%'>";
								echo '&nbsp;';
								//echo "<input type='text' readonly name='txtSABpreScriptoria-$i' id='txtSABpreScriptoria-$i' style='color: navy; ' size='12' value='" . ${"txtSABpreScriptoria-$i"} . "' />";
							echo "</td>";
							echo "<td width='20%'>";
								echo "&nbsp;";
							echo "</td>";
						echo "</tr>";
						$i++;
					}
				}
				if ($numSAB_scriptoria > 0) {
					$resultSAB_scriptoria->free();
				}
			}
		?>
		</tbody>
		</table>
        <br />
		
		<?php       
/*************************************************
	Bible.is
**************************************************/
		?>
		<table valign="bottom" cellpadding="0" cellspacing="0" width="100%">
        <thead>
			<tr valign="bottom" style="color: navy; font-size: 8pt; line-height: 10pt; height: 30px; ">
				<td width="11%">&nbsp;
				</td>
				<td width="40%" style="padding-left: 3px; ">
					URL Link
				</td>
				<td width="24%" style="padding-left: 3px; ">
					Title or Version <i>(optional)</i>
				</td>
				<td width="25%" colspan="2" style="padding-left: 3px; ">
					Which icon?
				</td>
			</tr>
		</thead>
		<?php
        $num = 0;
		if (isset($_POST['txtLinkBibleIsURL-1'])) {
			if ($_POST['txtLinkBibleIs-1'] == 'BibleIsDefault-1') $_POST['BibleIsDefault-1']=1; else $_POST['BibleIsDefault-1']=0;
			if ($_POST['txtLinkBibleIs-1'] == 'BibleIsText-1') $_POST['BibleIsText-1']=2; else $_POST['BibleIsText-1']=0;
			if ($_POST['txtLinkBibleIs-1'] == 'BibleIsAudio-1') $_POST['BibleIsAudio-1']=3; else $_POST['BibleIsAudio-1']=0;
			if ($_POST['txtLinkBibleIs-1'] == 'BibleIsVideo-1') $_POST['BibleIsVideo-1']=4; else $_POST['BibleIsVideo-1']=0;
		}
		elseif ($SM_row['BibleIs']) {
            $query="SELECT * FROM links WHERE ISO_ROD_index = $idx AND NOT BibleIs = 0";
            $result1=$db->query($query);
            $num=$result1->num_rows;
			$tempLinks = $result1->fetch_assoc();
            ${'txtLinkBibleIsURL-1'} = $tempLinks['URL'];
            ${'txtLinkBibleIsTitle-1'} = $tempLinks['company_title'];
			${'txtLinkBibleIs-1'} = $tempLinks['BibleIs'];
			$temp1 = ${'txtLinkBibleIs-1'};
			if ($temp1 == 1) ${'BibleIsDefault-1'}=1; else ${'BibleIsDefault-1'}=0;
			if ($temp1 == 2) ${'BibleIsText-1'}=2; else ${'BibleIsText-1'}=0;
			if ($temp1 == 3) ${'BibleIsAudio-1'}=3; else ${'BibleIsAudio-1'}=0;
			if ($temp1 == 4) ${'BibleIsVideo-1'}=4; else ${'BibleIsVideo-1'}=0;
        }
        else {
            ${'txtLinkBibleIsURL-1'}='';
            ${'txtLinkBibleIsTitle-1'}='';
            ${'txtLinkBibleIs-1'}='BibleIsVideo';
			${'BibleIsDefault-1'}=0;
			${'BibleIsText-1'}=0;
			${'BibleIsAudio-1'}=0;
			${'BibleIsVideo-1'}=4;
        }
        ?>
		<tbody name="tableBibleIs" id="tableBibleIs">
			<tr valign="bottom" style="line-height: 10pt; ">
				<td width="11%" style="font-size: 10pt; ">
					<div style="margin-bottom: 6px; ">Enter "Bible.is":</div>For example:
				</td>
				<td width="40%">
					<input type='text' style='color: navy; ' size='54' name='txtLinkBibleIsURL-1' id='txtLinkBibleIsURL-1' value="<?php if (isset($_POST['txtLinkBibleIsURL-1'])) echo $_POST['txtLinkBibleIsURL-1']; else echo ${'txtLinkBibleIsURL-1'}; ?>" />
                    <br /><span style="font-size: 10pt; margin-left: 3px; ">https://live.bible.is/bible/[FCBH code]/[book]/[chapter]</span>
				</td>
				<td width="24%">
					<input type='text' style='color: navy; ' size='30' name='txtLinkBibleIsTitle-1' id='txtLinkBibleIsTitle-1' value="<?php if (isset($_POST['txtLinkBibleIsTitle-1'])) echo $_POST['txtLinkBibleIsTitle-1']; else echo ${'txtLinkBibleIsTitle-1'}; ?>" />
                    <br /><span style="font-size: 10pt; margin-left: 1px; ">-NT version 2008</span>
				</td>
				<td width="8%">
                    <!--
                        Default
                        Text
                        Audio
                        Video
                    -->
                    <select name="txtLinkBibleIs-1" id="txtLinkBibleIs-1" style='color: navy; '>
                        <option value="BibleIsDefault-1" <?php echo ( isset($_POST['BibleIsDefault-1']) ? ($_POST['BibleIsDefault-1'] == 1 ? " selected='selected'" : "") : (${'BibleIsDefault-1'} == 1 ? " selected='selected'" : '' ) ) ?>>Default</option>
                        <option value="BibleIsText-1" <?php echo ( isset($_POST['BibleIsText-1']) ? ($_POST['BibleIsText-1'] == 2 ? " selected='selected'" : "") : (${'BibleIsText-1'} == 2 ? " selected='selected'" : '' ) ) ?>>Text</option>
                        <option value="BibleIsAudio-1" <?php echo ( isset($_POST['BibleIsAudio-1']) ? ($_POST['BibleIsAudio-1'] == 3 ? " selected='selected'" : "") : (${'BibleIsAudio-1'} == 3 ? " selected='selected'" : '' ) ) ?>>Audio</option>
                        <option value="BibleIsVideo-1" <?php echo ( isset($_POST['BibleIsVideo-1']) ? ($_POST['BibleIsVideo-1'] == 4 ? " selected='selected'" : "") : (${'BibleIsVideo-1'} == 4 ? " selected='selected'" : '' ) ) ?>>Video</option>
                    </select>
                    <br /><span style="font-size: 10pt; margin-left: 1px; ">Video</span>
				</td>
                <td width="17%" style="text-align: right; ">
                    <input style="font-size: 9pt; " type="button" id="addBibleIs" value="Add" />
                    <input style="font-size: 9pt; " type="button" id="removeBibleIs" value="Remove" />
                    <br />&nbsp;
                </td>
                </td>
			</tr>
			<?php
			$i = 2;
			if (isset($_POST['txtLinkBibleIsURL-'.(string)$i])) {
				while (isset($_POST['txtLinkBibleIsURL-'.(string)$i])) {
					echo "<tr valign='bottom' style='line-height: 10pt; '>";
						echo "<td width='11%'>";
							echo "&nbsp;";
						echo "</td>";
						echo "<td width='40%'>";
							echo "<input type='text' name='txtLinkBibleIsURL-$i' id='txtLinkBibleIsURL-$i' style='color: navy; ' size='53' value='" . ( isset($_POST['txtLinkBibleIsURL-'.(string)$i]) ? $_POST['txtLinkBibleIsURL-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='24%'>";
							echo "<input type='text' name='txtLinkBibleIsTitle-$i' id='txtLinkBibleIsTitle-$i' style='color: navy; ' size='30' value='" . ( isset($_POST['txtLinkBibleIsTitle-'.(string)$i]) ? $_POST['txtLinkBibleIsTitle-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='8%'>";
							${'BibleIsDefault-$i'}=1;
							${'BibleIsText-$i'}=1;
							${'BibleIsAudio-$i'}=1;
							${'BibleIsVideo-$i'}=1;
							if ($_POST['txtLinkBibleIs-'.(string)$i] == 'BibleIsDefault-'.$i) { ${'BibleIsDefault-$i'}=1; }
							if ($_POST['txtLinkBibleIs-'.(string)$i] == 'BibleIsText-'.$i) { ${'BibleIsText-$i'}=2; }
							if ($_POST['txtLinkBibleIs-'.(string)$i] == 'BibleIsAudio-'.$i) { ${'BibleIsAudio-$i'}=3; }
							if ($_POST['txtLinkBibleIs-'.(string)$i] == 'BibleIsVideo-'.$i) { ${'BibleIsVideo-$i'}=4; }
							?>
							<select name="txtLinkBibleIs-<?php echo $i ?>" id="txtLinkBibleIs-<?php echo $i ?>" style='color: navy; '>
								<option value="BibleIsDefault-<?php echo $i ?>" <?php echo ( ${'BibleIsDefault-$i'} == 1 ? " selected='selected'" : '' ) ?>>Default</option>
								<option value="BibleIsText-<?php echo $i ?>" <?php echo ( ${'BibleIsText-$i'} == 2 ? " selected='selected'" : '' ) ?>>Text</option>
								<option value="BibleIsAudio-<?php echo $i ?>" <?php echo ( ${'BibleIsAudio-$i'} == 3 ? " selected='selected'" : '' ) ?>>Audio</option>
								<option value="BibleIsVideo-<?php echo $i ?>" <?php echo ( ${'BibleIsVideo-$i'} == 4 ? " selected='selected'" : '' ) ?>>Video</option>
							</select>
							<?php
						echo "</td>";
						echo "<td width='17%'>";
							echo "&nbsp;";
						echo "</td>";
					echo "</tr>";
					$i++;
				}
			}
			else {
				if ($num > 1) {
					while ($tempLinks = $result1->fetch_assoc()) {
						${'txtLinkBibleIsURL-$i'} = $tempLinks['URL'];
						${'txtLinkBibleIsTitle-$i'} = $tempLinks['company_title'];						
						${'txtLinkBibleIs-$i'} = $tempLinks['BibleIs'];						
						$temp1 = ${'txtLinkBibleIs-$i'};
						if ($temp1 == 1) ${'BibleIsDefault-$i'}=1; else ${'BibleIsDefault-$i'}=0;
						if ($temp1 == 2) ${'BibleIsText-$i'}=2; else ${'BibleIsText-$i'}=0;
						if ($temp1 == 3) ${'BibleIsAudio-$i'}=3; else ${'BibleIsAudio-$i'}=0;
						if ($temp1 == 4) ${'BibleIsVideo-$i'}=4; else ${'BibleIsVideo-$i'}=0;
						echo "<tr valign='bottom' style='line-height: 10pt; '>";
							echo "<td width='11%'>";
								echo "&nbsp;";
							echo "</td>";
							echo "<td width='40%'>";
								echo "<input type='text' name='txtLinkBibleIsURL-$i' id='txtLinkBibleIsURL-$i' style='color: navy; ' size='52' value='" . ${'txtLinkBibleIsURL-$i'} . "' />";
							echo "</td>";
							echo "<td width='24%'>";
								echo "<input type='text' name='txtLinkBibleIsTitle-$i' id='txtLinkBibleIsTitle-$i' style='color: navy; ' size='30' value='" . ${'txtLinkBibleIsTitle-$i'} . "' />";
							echo "</td>";
							echo "<td width='8%'>";
								?>
								<select name="txtLinkBibleIs-<?php echo $i ?>" id="txtLinkBibleIs-<?php echo $i ?>" style='color: navy; '>
									<option value="BibleIsDefault-<?php echo $i ?>" <?php echo ( ${'BibleIsDefault-$i'} == 1 ? " selected='selected'" : '' ) ?>>Default</option>
									<option value="BibleIsText-<?php echo $i ?>" <?php echo ( ${'BibleIsText-$i'} == 2 ? " selected='selected'" : '' ) ?>>Text</option>
									<option value="BibleIsAudio-<?php echo $i ?>" <?php echo ( ${'BibleIsAudio-$i'} == 3 ? " selected='selected'" : '' ) ?>>Audio</option>
									<option value="BibleIsVideo-<?php echo $i ?>" <?php echo ( ${'BibleIsVideo-$i'} == 4 ? " selected='selected'" : '' ) ?>>Video</option>
								</select>
								<?php
							echo "</td>";
							echo "<td width='17%'>";
								echo "&nbsp;";
							echo "</td>";
						echo "</tr>";
						$i++;
					}
				}
				if ($num > 0) {
					$result1->free();
				}
			}
		?>
		</tbody>
		</table>
        <br />

		<?php
/*************************************************
	Bible.is Gospel Films
**************************************************/
		?>
		<table valign="bottom" cellpadding="0" cellspacing="0" width="100%">
		<thead>
			<tr valign="bottom" style="color: navy; font-size: 8pt; line-height: 10pt; height: 30px; ">
				<td width="11%">&nbsp;
				</td>
				<td width="40%" style="padding-left: 3px; ">
					URL Link
				</td>
				<td width="49%" colspan="2" style="padding-left: 3px; ">
					Which Gospel?
				</td>
			</tr>
		</thead>
		<?php
		$num = 0;
		if (isset($_POST['txtLinkBibleIsGospelFilmURL-1'])) {
			${'txtLinkBibleIsGospelFilmURL-1'} = $_POST['txtLinkBibleIsGospelFilmURL-1'];
			${'txtLinkBibleIsGospel-1'} = $_POST['txtLinkBibleIsGospel-1'];
		}
		elseif ($SM_row['BibleIsGospelFilm']) {
			$query="SELECT * FROM links WHERE ISO_ROD_index = $idx AND BibleIsGospelFilm = 1";
			$result1=$db->query($query);
			$num=$result1->num_rows;
			$tempLinks = $result1->fetch_assoc();
			${'txtLinkBibleIsGospelFilmURL-1'} = $tempLinks['URL'];
			${'txtLinkBibleIsGospel-1'} = $tempLinks['company_title'];
		}
		else {
			${'txtLinkBibleIsGospelFilmURL-1'}='';
			${'txtLinkBibleIsGospel-1'}='';
		}
		?>
		<tbody name="tableBibleIsGospelFilm" id="tableBibleIsGospelFilm">
			<tr valign="bottom" style="line-height: 10pt; ">
				<td width="11%" style="font-size: 10pt; ">
					<div style="margin-bottom: 6px; ">Enter "Bible.is Gospel Film":</div>For example:
				</td>
				<td width="40%">
					<input type='text' style='color: navy; ' size='54' name='txtLinkBibleIsGospelFilmURL-1' id='txtLinkBibleIsGospelFilmURL-1' value="<?php if (isset($_POST['txtLinkBibleIsGospelFilmURL-1'])) echo $_POST['txtLinkBibleIsGospelFilmURL-1']; else echo ${'txtLinkBibleIsGospelFilmURL-1'}; ?>" />
					<br /><span style="font-size: 10pt; margin-left: 3px; ">https://www.youtube.com/playlist?list=[Google address]</span>
				</td>
				<td width="32%">
					<input type='text' style='color: navy; ' size='30' name='txtLinkBibleIsGospel-1' id='txtLinkBibleIsGospel-1' value="<?php if (isset($_POST['txtLinkBibleIsGospel-1'])) echo $_POST['txtLinkBibleIsGospel-1']; else echo ${'txtLinkBibleIsGospel-1'}; ?>" />
					<br /><span style="font-size: 10pt; margin-left: 1px; "> - Gospel of [which Gospel]</span>
				</td>
				<td width="17%" style="text-align: right; ">
					<input style="font-size: 9pt; " type="button" id="addBibleIsGospelFilm" value="Add" />
					<input style="font-size: 9pt; " type="button" id="removeBibleIsGospelFilm" value="Remove" />
					<br />&nbsp;
				</td>
				</td>
			</tr>
			<?php
			$i = 2;
			if (isset($_POST['txtLinkBibleIsGospelFilmURL-'.(string)$i])) {
				while (isset($_POST['txtLinkBibleIsGospelFilmURL-'.(string)$i])) {
					echo "<tr valign='bottom' style='line-height: 10pt; '>";
						echo "<td width='11%'>";
							echo "&nbsp;";
						echo "</td>";
						echo "<td width='40%'>";
							echo "<input type='text' name='txtLinkBibleIsGospelFilmURL-$i' id='txtLinkBibleIsGospelFilmURL-$i' style='color: navy; ' size='53' value='" . ( isset($_POST['txtLinkBibleIsGospelFilmURL-'.(string)$i]) ? $_POST['txtLinkBibleIsGospelFilmURL-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='32%'>";
							echo "<input type='text' name='txtLinkBibleIsGospel-$i' id='txtLinkBibleIsGospel-$i' style='color: navy; ' size='30' value='" . ( isset($_POST['txtLinkBibleIsGospel-'.(string)$i]) ? $_POST['txtLinkBibleIsGospel-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='17%'>";
							echo "&nbsp;";
						echo "</td>";
					echo "</tr>";
					$i++;
				}
			}
			else {
				if ($num > 1) {
					while ($tempLinks = $result1->fetch_assoc()) {
						${'txtLinkBibleIsGospelFilmURL-$i'} = $tempLinks['URL'];
						${'txtLinkBibleIsGospel-$i'} = $tempLinks['company_title'];						
						echo "<tr valign='bottom' style='line-height: 10pt; '>";
							echo "<td width='11%'>";
								echo "&nbsp;";
							echo "</td>";
							echo "<td width='40%'>";
								echo "<input type='text' name='txtLinkBibleIsGospelFilmURL-$i' id='txtLinkBibleIsGospelFilmURL-$i' style='color: navy; ' size='52' value='" . ${'txtLinkBibleIsGospelFilmURL-$i'} . "' />";
							echo "</td>";
							echo "<td width='32%'>";
								echo "<input type='text' name='txtLinkBibleIsGospel-$i' id='txtLinkBibleIsGospel-$i' style='color: navy; ' size='30' value='" . ${'txtLinkBibleIsGospel-$i'} . "' />";
							echo "</td>";
							echo "<td width='17%'>";
								echo "&nbsp;";
							echo "</td>";
						echo "</tr>";
						$i++;
					}
				}
				if ($num > 0) {
					$result1->free();
				}
			}
		?>
		</tbody>
		</table>
		<br />

		<?php
/*************************************************
	YouVersion (Bible.com) - Read
**************************************************/
		?>      

		<table width="100%" valign="bottom" cellpadding="0" cellspacing="0">
            <thead>
                <tr valign="bottom" style="color: navy; font-size: 8pt; line-height: 10pt; height: 30px; ">
                    <td width="14%">&nbsp;
                    </td>
                    <td width="12%" style="padding-left: 3px; ">
                        Words preceding Text
                    </td>
                    <td width="11%" style="padding-left: 3px; ">
                        Text for the website
                    </td>
                    <td width="44%" style="padding-left: 3px; ">
                        URL
                    </td>
                    <td width="19%">&nbsp;
                    </td>
                </tr>
            </thead>
            <?php
			$i=1;
			$num = 0;
            $YouVersion_URL = '';
            if (isset($_POST['txtLinkYouVersionName-1'])) {
                
            }
            elseif ($SM_row['YouVersion']) {
                $query="SELECT * FROM links WHERE ISO_ROD_index = $idx AND YouVersion = 1";
                $result1=$db->query($query);
                $num=$result1->num_rows;
                $r = $result1->fetch_assoc();
                ${'txtLinkYouVersionName-1'}=$r['company'];
                ${'txtLinkYouVersionTitle-1'}=$r['company_title'];
                ${'txtLinkYouVersionURL-1'}=$r['URL'];
            }
            else {
                ${'txtLinkYouVersionName-1'}="";
                ${'txtLinkYouVersionTitle-1'}="";
                ${'txtLinkYouVersionURL-1'}="";
            }
            ?>
            <tbody id="tableYouVersion" name="tableYouVersion">
                <tr valign="top" style="line-height: 10pt; ">
                    <td width="14%" style="font-size: 10pt; ">
                        <div style="margin-top: 10px; ">Enter "YouVersion":</div>For example:
                    </td>
                    <td width="12%">
                        <input type='text' style='color: navy; ' size='13' name='txtLinkYouVersionName-1' id='txtLinkYouVersionName-1' value="<?php if (isset($_POST['txtLinkYouVersionName-1'])) echo $_POST['txtLinkYouVersionName-1']; else echo ${'txtLinkYouVersionName-1'}; ?>" />
                        <br /><span style="font-size: 10pt; ">Read on</span>
                    </td>
                    <td width="11%">
                        <input type='text' style='color: navy; ' size='20' name='txtLinkYouVersionTitle-1' id='txtLinkYouVersionTitle-1' value="<?php if (isset($_POST['txtLinkYouVersionTitle-1'])) echo $_POST['txtLinkYouVersionTitle-1']; else echo ${'txtLinkYouVersionTitle-1'}; ?>" />
                        <br /><span style="font-size: 10pt; margin-left: 1px; ">YouVersion.com</span>
                    </td>
                    <td width="44%">
                        <input type='text' style='color: navy; ' size='60' name='txtLinkYouVersionURL-1' id='txtLinkYouVersionURL-1' value="<?php if (isset($_POST['txtLinkYouVersionURL-1'])) echo $_POST['txtLinkYouVersionURL-1']; else echo ${'txtLinkYouVersionURL-1'}; ?>" />
                        <br /><span style="font-size: 10pt; margin-left: 3px; ">http://www.bible.com/bible/[YouVersion code]/[book].[chp]</span>
                    </td>
					<td width="19%" style="text-align: right; vertical-align: top; ">
                        <input style="font-size: 9pt; " type="button" id="addYouVer" value="Add" />
                        <input style="font-size: 9pt; " type="button" id="removeYouVer" value="Remove" />
					</td>
                </tr>
			<?php
			$i = 2;
			if (isset($_POST['txtLinkYouVersionURL-'.(string)$i])) {
				while (isset($_POST['txtLinkYouVersionURL-'.(string)$i])) {
					echo "<tr valign='bottom' style='line-height: 10pt; '>";
						echo "<td width='14%'>";
							echo "&nbsp;";
						echo "</td>";
						echo "<td width='12%'>";
							echo "<input type='text' style='color: navy; ' size='13' name='txtLinkYouVersionName-".(string)$i."' id='txtLinkYouVersionName-".(string)$i."' value='" . ( isset($_POST['txtLinkYouVersionName-'.(string)$i]) ? $_POST['txtLinkYouVersionName-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='11%'>";
							echo "<input type='text' style='color: navy; ' size='20' name='txtLinkYouVersionTitle-".(string)$i."' id='txtLinkYouVersionTitle-".(string)$i."' value='" . ( isset($_POST['txtLinkYouVersionTitle-'.(string)$i]) ? $_POST['txtLinkYouVersionTitle-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='44%'>";
							echo "<input type='text' style='color: navy; ' size='60' name='txtLinkYouVersionURL-".(string)$i."' id='txtLinkYouVersionURL-".(string)$i."' value='" . ( isset($_POST['txtLinkYouVersionURL-'.(string)$i]) ? $_POST['txtLinkYouVersionURL-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='19%'>";
							echo "&nbsp;";
						echo "</td>";
					echo "</tr>";
					$i++;
				}
			}
			else {
				if ($num > 1) {
					while ($r = $result1->fetch_assoc()) {
						${'txtLinkYouVersionName-$i'}=$r['company'];
						${'txtLinkYouVersionTitle-$i'}=$r['company_title'];
						${'txtLinkYouVersionURL-$i'}=$r['URL'];
						echo "<tr valign='bottom' style='line-height: 10pt; '>";
							echo "<td width='14%'>";
								echo "&nbsp;";
							echo "</td>";
							echo "<td width='12%'>";
								echo "<input type='text' style='color: navy; ' size='13' name='txtLinkYouVersionName-".(string)$i."' id='txtLinkYouVersionName-".(string)$i."' value='" . ${'txtLinkYouVersionName-$i'} . "' />";
							echo "</td>";
							echo "<td width='11%'>";
								echo "<input type='text' style='color: navy; ' size='20' name='txtLinkYouVersionTitle-".(string)$i."' id='txtLinkYouVersionTitle-".(string)$i."' value='" . ${'txtLinkYouVersionTitle-$i'} . "' />";
							echo "</td>";
							echo "<td width='44%'>";
								echo "<input type='text' style='color: navy; ' size='60' name='txtLinkYouVersionURL-".(string)$i."' id='txtLinkYouVersionURL-".(string)$i."' value='" . ${'txtLinkYouVersionURL-$i'} . "' />";
							echo "</td>";
							echo "<td width='19%'>";
								echo "&nbsp;";
							echo "</td>";
						echo "</tr>";
						$i++;
					}
				}
			}
			?>
            </tbody>
		</table>
		<br />

		<?php
/*************************************************
	Bible.org - Study
**************************************************/
		?>
		<table width="100%" valign="bottom" cellpadding="0" cellspacing="0">
            <thead>
                <tr valign="bottom" style="color: navy; font-size: 8pt; line-height: 10pt; height: 30px; ">
                    <td width="14%">&nbsp;
                    </td>
                    <td width="12%" style="padding-left: 3px; ">
                        Words preceding Text
                    </td>
                    <td width="11%" style="padding-left: 3px; ">
                        Text for the website
                    </td>
                    <td width="44%" style="padding-left: 3px; ">
                        URL
                    </td>
                    <td width="19%">&nbsp;
                    </td>
                </tr>
            </thead>
            <?php
			$i=1;
			$num = 0;
            $Biblesorg_URL = "";
            if (isset($_POST['txtLinkBiblesorgName-1'])) {
                
            }
            elseif ($SM_row['Bibles_org']) {
                $query="SELECT * FROM links WHERE ISO_ROD_index = $idx AND `Bibles_org` = 1";
                $result1=$db->query($query);
                $num=$result1->num_rows;
				$r = $result1->fetch_assoc();
                ${'txtLinkBiblesorgName-1'}=$r['company'];
                ${'txtLinkBiblesorgTitle-1'}=$r['company_title'];
                ${'txtLinkBiblesorgURL-1'}=$r['URL'];
            }
            else {
                ${'txtLinkBiblesorgName-1'}="";
                ${'txtLinkBiblesorgTitle-1'}="";
                ${'txtLinkBiblesorgURL-1'}="";
            }
            ?>
            <tbody id="tableBiblesorg" name="tableBiblesorg">
                <tr valign="top" style="line-height: 10pt; ">
                    <td width="14%" style="font-size: 10pt; ">
                        <div style="margin-top: 8px; ">Enter "Bibles.org":</div>For example:
                    </td>
                    <td width="12%">
                        <input type='text' style='color: navy; ' size='13' name='txtLinkBiblesorgName-1' id='txtLinkBiblesorgName-1' value="<?php if (isset($_POST['txtLinkBiblesorgName-1'])) echo $_POST['txtLinkBiblesorgName-1']; else echo ${'txtLinkBiblesorgName-1'}; ?>" />
                        <br /><span style="font-size: 10pt; ">Study on</span>
                    </td>
                    <td width="11%">
                        <input type='text' style='color: navy; ' size='20' name='txtLinkBiblesorgTitle-1' id='txtLinkBiblesorgTitle-1' value="<?php if (isset($_POST['txtLinkBiblesorgTitle-1'])) echo $_POST['txtLinkBiblesorgTitle-1']; else echo ${'txtLinkBiblesorgTitle-1'}; ?>" />
                        <br /><span style="font-size: 10pt; margin-left: 1px; ">Bibles.org</span>
                    </td>
                    <td width="44%">
                        <input type='text' style='color: navy; ' size='60' name='txtLinkBiblesorgURL-1' id='txtLinkBiblesorgURL-1' value="<?php if (isset($_POST['txtLinkBiblesorgURL-1'])) echo $_POST['txtLinkBiblesorgURL-1']; else echo ${'txtLinkBiblesorgURL-1'}; ?>" />
                        <br /><span style="font-size: 10pt; margin-left: 3px; ">http://www.Bibles.org/[Bibles.org code]/[book]/[chp]</span>
                    </td>
                    <td width="19%" style="text-align: right; vertical-align: top; ">
                        <input style="font-size: 9pt; " type="button" id="addBiblesorg" value="Add" />
                        <input style="font-size: 9pt; " type="button" id="removeBiblesorg" value="Remove" />
                    </td>
                </tr>
			<?php
			$i = 2;
			if (isset($_POST['txtLinkBiblesorgURL-'.(string)$i])) {
				while (isset($_POST['txtLinkBiblesorgURL-'.(string)$i])) {
					echo "<tr valign='bottom' style='line-height: 10pt; '>";
						echo "<td width='14%'>";
							echo "&nbsp;";
						echo "</td>";
						echo "<td width='12%'>";
							echo "<input type='text' style='color: navy; ' size='13' name='txtLinkBiblesorgName-".(string)$i."' id='txtLinkBiblesorgName-".(string)$i."' value='" . ( isset($_POST['txtLinkBiblesorgName-'.(string)$i]) ? $_POST['txtLinkBiblesorgName-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='11%'>";
							echo "<input type='text' style='color: navy; ' size='20' name='txtLinkBiblesorgTitle-".(string)$i."' id='txtLinkBiblesorgTitle-".(string)$i."' value='" . ( isset($_POST['txtLinkBiblesorgTitle-'.(string)$i]) ? $_POST['txtLinkBiblesorgTitle-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='44%'>";
							echo "<input type='text' style='color: navy; ' size='60' name='txtLinkBiblesorgURL-".(string)$i."' id='txtLinkBiblesorgURL-".(string)$i."' value='" . ( isset($_POST['txtLinkBiblesorgURL-'.(string)$i]) ? $_POST['txtLinkBiblesorgURL-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='19%'>";
							echo "&nbsp;";
						echo "</td>";
					echo "</tr>";
					$i++;
				}
			}
			else {
				if ($num > 1) {
					while ($r = $result1->fetch_assoc()) {
						${'txtLinkBiblesorgName-$i'}=$r['company'];
						${'txtLinkBiblesorgTitle-$i'}=$r['company_title'];
						${'txtLinkBiblesorgURL-$i'}=$r['URL'];
						echo "<tr valign='bottom' style='line-height: 10pt; '>";
							echo "<td width='14%'>";
								echo "&nbsp;";
							echo "</td>";
							echo "<td width='12%'>";
								echo "<input type='text' style='color: navy; ' size='13' name='txtLinkBiblesorgName-".(string)$i."' id='txtLinkBiblesorgName-".(string)$i."' value='" . ${'txtLinkBiblesorgName-$i'} . "' />";
							echo "</td>";
							echo "<td width='11%'>";
								echo "<input type='text' style='color: navy; ' size='20' name='txtLinkBiblesorgTitle-".(string)$i."' id='txtLinkBiblesorgTitle-".(string)$i."' value='" . ${'txtLinkBiblesorgTitle-$i'} . "' />";
							echo "</td>";
							echo "<td width='44%'>";
								echo "<input type='text' style='color: navy; ' size='60' name='txtLinkBiblesorgURL-".(string)$i."' id='txtLinkBiblesorgURL-".(string)$i."' value='" . ${'txtLinkBiblesorgURL-$i'} . "' />";
							echo "</td>";
							echo "<td width='19%'>";
								echo "&nbsp;";
							echo "</td>";
						echo "</tr>";
						$i++;
					}
				}
			}
			?>
            </tbody>
		</table>
		<br />

		<?php
/*************************************************
	GRN (Global Recordings Network)
**************************************************/
		?>
		<table width="100%" valign="bottom" cellpadding="0" cellspacing="0">
            <thead>
                <tr valign="bottom" style="color: navy; font-size: 8pt; line-height: 10pt; height: 30px; ">
                    <td width="14%">&nbsp;
                    </td>
                    <td width="11%" style="padding-left: 3px; ">
                        Text for the website
                    </td>
                    <td width="12%" style="padding-left: 3px; ">
                        Words preceding Text
                    </td>
                    <td width="44%" style="padding-left: 3px; ">
                        URL
                    </td>
                    <td width="19%">&nbsp;
                    </td>
                </tr>
            </thead>
            <?php
			$i=1;
			$num = 0;
            $GRN_URL = "";
            if (isset($_POST['txtLinkGRNName-1'])) {
                
            }
            elseif ($SM_row['GRN']) {
                $query="SELECT * FROM links WHERE ISO_ROD_index = $idx AND GRN = 1";
                $resultl=$db->query($query);
                $num=$resultl->num_rows;
				$r = $resultl->fetch_assoc();
                ${'txtLinkGRNName-1'}=$r['company'];
                ${'txtLinkGRNTitle-1'}=$r['company_title'];
                ${'txtLinkGRNURL-1'}=$r['URL'];
            }
            else {
                ${'txtLinkGRNName-1'}="";
                ${'txtLinkGRNTitle-1'}="";
                ${'txtLinkGRNURL-1'}="";
            }
            ?>
            <tbody id="tableGRN" name="tableGRN">
                <tr valign="top" style="line-height: 10pt; ">
                    <td width="14%" style="font-size: 10pt; ">
                        <div style="margin-top: 8px; ">Enter "GRN":</div>For example:
                    </td>
                    <td width="11%">
                        <input type='text' style='color: navy; ' size='20' name='txtLinkGRNTitle-1' id='txtLinkGRNTitle-1' value="<?php if (isset($_POST['txtLinkGRNTitle-1'])) echo $_POST['txtLinkGRNTitle-1']; else echo ${'txtLinkGRNTitle-1'}; ?>" />
                        <br /><span style="font-size: 10pt; margin-left: 1px; ">Audio recordings</span>
                    </td>
                    <td width="12%">
                        <input type='text' style='color: navy; ' size='13' name='txtLinkGRNName-1' id='txtLinkGRNName-1' value="<?php if (isset($_POST['txtLinkGRNName-1'])) echo $_POST['txtLinkGRNName-1']; else echo ${'txtLinkGRNName-1'}; ?>" />
                        <br /><span style="font-size: 10pt; ">Global Recordings Network</span>
                    </td>
                    <td width="44%">
                        <input type='text' style='color: navy; ' size='60' name='txtLinkGRNURL-1' id='txtLinkGRNURL-1' value="<?php if (isset($_POST['txtLinkGRNURL-1'])) echo $_POST['txtLinkGRNURL-1']; else echo ${'txtLinkGRNURL-1'}; ?>" />
                        <br /><span style="font-size: 10pt; margin-left: 3px; ">https://globalrecordings.net/en/language/[GRN code]</span>
                    </td>
                    <td width="19%" style="text-align: right; vertical-align: top; ">
                        <input style="font-size: 9pt; " type="button" id="addGRN" value="Add" />
                        <input style="font-size: 9pt; " type="button" id="removeGRN" value="Remove" />
                    </td>
                </tr>
			<?php
			$i = 2;
			if (isset($_POST['txtLinkGRNURL-'.(string)$i])) {
				while (isset($_POST['txtLinkGRNURL-'.(string)$i])) {
					echo "<tr valign='bottom' style='line-height: 10pt; '>";
						echo "<td width='14%'>";
							echo "&nbsp;";
						echo "</td>";
						echo "<td width='11%'>";
							echo "<input type='text' style='color: navy; ' size='20' name='txtLinkGRNTitle-".(string)$i."' id='txtLinkGRNTitle-".(string)$i."' value='" . ( isset($_POST['txtLinkGRNTitle-'.(string)$i]) ? $_POST['txtLinkGRNTitle-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='12%'>";
							echo "<input type='text' style='color: navy; ' size='13' name='txtLinkGRNName-".(string)$i."' id='txtLinkGRNName-".(string)$i."' value='" . ( isset($_POST['txtLinkGRNName-'.(string)$i]) ? $_POST['txtLinkGRNName-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='44%'>";
							echo "<input type='text' style='color: navy; ' size='60' name='txtLinkGRNURL-".(string)$i."' id='txtLinkGRNURL-".(string)$i."' value='" . ( isset($_POST['txtLinkGRNURL-'.(string)$i]) ? $_POST['txtLinkGRNURL-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='19%'>";
							echo "&nbsp;";
						echo "</td>";
					echo "</tr>";
					$i++;
				}
			}
			else {
				if ($num > 1) {
					while ($r = $result1->fetch_assoc()) {
						${'txtLinkGRNName-$i'}=$r['company'];
						${'txtLinkGRNTitle-$i'}=$r['company_title'];
						${'txtLinkGRNURL-$i'}=$r['URL'];
						echo "<tr valign='bottom' style='line-height: 10pt; '>";
							echo "<td width='14%'>";
								echo "&nbsp;";
							echo "</td>";
							echo "<td width='11%'>";
								echo "<input type='text' style='color: navy; ' size='20' name='txtLinkGRNTitle-".(string)$i."' id='txtLinkGRNTitle-".(string)$i."' value='" . ${'txtLinkGRNTitle-$i'} . "' />";
							echo "</td>";
							echo "<td width='12%'>";
								echo "<input type='text' style='color: navy; ' size='13' name='txtLinkGRNName-".(string)$i."' id='txtLinkGRNName-".(string)$i."' value='" . ${'txtLinkGRNName-$i'} . "' />";
							echo "</td>";
							echo "<td width='44%'>";
								echo "<input type='text' style='color: navy; ' size='60' name='txtLinkGRNURL-".(string)$i."' id='txtLinkGRNURL-".(string)$i."' value='" . ${'txtLinkGRNURL-$i'} . "' />";
							echo "</td>";
							echo "<td width='19%'>";
								echo "&nbsp;";
							echo "</td>";
						echo "</tr>";
						$i++;
					}
				}
			}
			?>
            </tbody>
		</table>
		<br /><br />

		<?php
/*************************************************
	checkbox for viewer
*************************************************/
        if (isset($_POST['viewerer'])) {				// only will show if 'viewer' is checked! If it is un-checked $_POST['viewer'] doesn't have anything!
			?>
			<input type='checkbox' name='viewer' id='viewer' <?php echo (isset($_POST['viewer']) && $_POST['viewer'] == 'on' ? ' checked' : '') ?> /> Does this language have the Study online viewer (USFM) files?<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type='text' style='color: navy; ' size='3' name='viewerText' id='viewerText' value="<?php if (isset($_POST['viewerText'])) echo $_POST['viewerText']; else echo ''; ?>" />
			<?php
        }
		elseif ($SM_row['viewer']) {
			$query="SELECT viewer_ROD_Variant FROM viewer WHERE ISO_ROD_index = $idx";
			$resultViewer=$db->query($query);
			$viewerText = '';
			if ($resultViewer->num_rows > 0) {
				$r = $resultViewer->fetch_assoc();
				$viewerText = $r['viewer_ROD_Variant'];
			}
			$resultViewer->free();
			?>
			<input type='checkbox' name='viewer' id='viewer' checked /> Does this language have the Study online viewer (USFM) files?<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type='text' style='color: navy; ' size='3' name='viewerText' id='viewerText' value="<?php echo $viewerText; ?>" />
			<?php
		}
		else {
			?>
			<input type='checkbox' name='viewer' id='viewer' /> Does this language have the Study online viewer (USFM) files?<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type='text' style='color: navy; ' size='3' name='viewerText' id='viewerText' value='' />
			<?php
		}
		?>

		&nbsp;<span style='font-size: 10pt; '>Rarely used. Only when there is more the 1 ROD Code and Variant code with the same ISO code. In order to use this, the letter(s) before the ".sfm" in this text box
        indicate which files are to be used for this collection. For example, you enter a "W" in the text box you will then have to put a "W" in all of the filenames before the extension
        (i.e., 41-MATaoj.sfm to 41-MATaoj<span style="color: red; ">W</span>.sfm)</span>
        <br /><br />&nbsp;&nbsp;&nbsp;&nbsp;
        
		<?php
/*************************************************
	checkbox for right-to-left
*************************************************/
		if (isset($_POST['rtler'])) {
			?>
			<input type='checkbox' name='rtl' id='rtl' <?php echo (isset($_POST['rtl']) && $_POST['rtl'] == 'on' ? ' checked' : '') ?> /> Is the language right-to-left?
			<?php
        }
		else {
			$query="SELECT rtl FROM viewer WHERE ISO_ROD_index = $idx";
			$resultViewer=$db->query($query);
			$numViewer=$resultViewer->num_rows;
			if ($resultViewer && $numViewer > 0) {
				$tempViewer = $resultViewer->fetch_assoc();
				if ($tempViewer['rtl']) {
					?>
					<input type='checkbox' name='rtl' id='rtl' checked /> Is the language right-to-left?
					<?php
				}
				else {
					?>
					<input type='checkbox' name='rtl' id='rtl' /> Is the language right-to-left?
					<?php
				}
			}
			else {
				?>
				<input type='checkbox' name='rtl' id='rtl' /> Is the language right-to-left?
				<?php
			}
			$resultViewer->free();
		}
		echo ' (Only for "Study online viewer".)<br /><br />';
		
/*************************************************
	cell phones
**************************************************/
		?>
		<table valign="bottom" cellpadding="0" cellspacing="0" width="100%">
           <thead style='text-align: left; vertical-align: bottom; '>
			<tr valign="bottom" style="color: navy; font-size: 8pt; line-height: 11pt; height: 30px; ">
				<td width="19%">&nbsp;
				</td>
				<td width="16%" style="padding-left: 3px; ">
					Cell Phone Title
				</td>
				<td width="23%" style="padding-left: 3px; ">
					Cell Phone Filename
				</td>
				<td width="23%" style="padding-left: 3px; ">
					<i>optional info if needed</i>
				</td>
				<td width="19%">&nbsp;
				</td>
			</tr>
		  </thead>
		<?php
		$i=1;
		$num = 0;
		if (isset($_POST['txtCellPhoneFile-1'])) {
			if ($_POST['txtCellPhoneTitle-1'] == 'CPJava-1') ${'CPJava-$i'}=1; else ${'CPJava-$i'}=0;
			if ($_POST['txtCellPhoneTitle-1'] == 'CPAndroid-1') ${'CPAndroid-$i'}=1; else ${'CPAndroid-$i'}=0;
			if ($_POST['txtCellPhoneTitle-1'] == 'CPiPhone-1') ${'CPiPhone-$i'}=1; else ${'CPiPhone-$i'}=0;
			//if ($_POST['txtCellPhoneTitle-1'] == 'CPWindows-1') ${'CPWindows-$i'}=1; else ${'CPWindows-$i'}=0;
			//if ($_POST['txtCellPhoneTitle-1'] == 'CPBlackberry-1') ${'CPBlackberry-$i'}=1; else ${'CPBlackberry-$i'}=0;
			//if ($_POST['txtCellPhoneTitle-1'] == 'CPStandard-1') ${'CPStandard-$i'}=1; else ${'CPStandard-$i'}=0;
			if ($_POST['txtCellPhoneTitle-1'] == 'CPAndroidApp-1') ${'CPAndroidApp-$i'}=1; else ${'CPAndroidApp-$i'}=0;
			if ($_POST['txtCellPhoneTitle-1'] == 'CPiOSAssetPackage-1') ${'CPiOSAssetPackage-$i'}=1; else ${'CPiOSAssetPackage-$i'}=0;
		}
		elseif ($SM_row['CellPhone']) {
			$query="SELECT * FROM CellPhone WHERE ISO_ROD_index = $idx";
			$result1=$db->query($query);
			$num=$result1->num_rows;
			$r = $result1->fetch_assoc();
			${'txtCellPhoneTitle-$i'}=1;
			$temp1 = $r['Cell_Phone_Title'];
			if ($temp1 == 'GoBible (Java)') ${'CPJava-$i'}=1; else ${'CPJava-$i'}=0;
			if ($temp1 == 'MySword (Android)') ${'CPAndroid-$i'}=1; else ${'CPAndroid-$i'}=0;
			if ($temp1 == 'iPhone') ${'CPiPhone-$i'}=1; else ${'CPiPhone-$i'}=0;
			//if ($temp1 == 'Windows') ${'CPWindows-$i'}=1; else ${'CPWindows-$i'}=0;
			//if ($temp1 == 'Blackberry') ${'CPBlackberry-$i'}=1; else ${'CPBlackberry-$i'}=0;
			//if ($temp1 == 'Standard Cell Phone') ${'CPStandard-$i'}=1; else ${'CPStandard-$i'}=0;
			if ($temp1 == 'Android App') ${'CPAndroidApp-$i'}=1; else ${'CPAndroidApp-$i'}=0;
			if ($temp1 == 'iOS Asset Package') ${'CPiOSAssetPackage-$i'}=1; else ${'CPiOSAssetPackage-$i'}=0;
			${'txtCellPhoneFile-$i'}=$r['Cell_Phone_File'];
			${'txtCellPhoneOptional-$i'}=$r['optional'];
		}
		else {
			${'txtCellPhoneTitle-$i'}=1;
			${'CPJava-$i'}=0;
			${'CPAndroid-$i'}=0;
			${'CPiPhone-$i'}=0;
			//${'CPWindows-$i'}=0;
			//${'CPBlackberry-$i'}=0;
			//${'CPStandard-$i'}=0;
			${'CPAndroidApp-$i'}=1;
			${'CPiOSAssetPackage-$i'}=0;
			${'txtCellPhoneFile-$i'}='';
			${'txtCellPhoneOptional-$i'}='';
		}
		?>
		<tbody name="tableCellPhone" id="tableCellPhone">
			<tr valign="bottom" style="line-height: 10pt; ">
				<td width="19%">
					<span style="font-size: 10pt; ">Enter Cell Phone<br />Module:</span>
				</td>
				<td width="16%">
                    <!--
                        GoBible (Java)
                        MySword (Android)
                        iPhone
                        Windows
                        Blackberry
                        Standard Cell Phone
                        Android App
                        iOS Asset Package
                    -->
                    <select name="txtCellPhoneTitle-1" id="txtCellPhoneTitle-1" style='color: navy; '>
                        <option value="CPJava-1" <?php echo ( ${'CPJava-$i'} == 1 ? " selected='selected'" : "") ?>>GoBible (Java)</option>
                        <option value="CPAndroid-1" <?php echo ( ${'CPAndroid-$i'} == 1 ? " selected='selected'" : "") ?>>MySword (Android)</option>
                        <option value="CPiPhone-1" <?php echo ( ${'CPiPhone-$i'} == 1 ? " selected='selected'" : "") ?>>iPhone</option>
                        <!--option value="CPWindows-1" < ?php echo ( ${'CPWindows-$i'} == 1 ? " selected='selected'" : "") ?>>Windows</option-->
                        <!--option value="CPBlackberry-1" < ?php echo ( ${'CPBlackberry-$i'} == 1 ? " selected='selected'" : "") ?>>Blackberry</option-->
                        <!--option value="CPStandard-1" < ?php echo ( ${'CPStandard-$i'} == 1 ? " selected='selected'" : "") ?>>Standard Cell Phone</option-->
                        <option value="CPAndroidApp-1" <?php echo ( ${'CPAndroidApp-$i'} == 1 ? " selected='selected'" : "") ?>>Android App (apk)</option>
                        <option value="CPiOSAssetPackage-1" <?php echo ( ${'CPiOSAssetPackage-$i'} == 1 ? " selected='selected'" : "") ?>>iOS Asset Package</option>
                    </select>
                    <br /><span style="font-size: 10pt; ">&nbsp;GoBible (Java)</span>
				</td>
				<td width="23%">
					<input type='text' style='color: navy; ' size='35' name='txtCellPhoneFile-1' id='txtCellPhoneFile-1' value="<?php if (isset($_POST['txtCellPhoneFile-1'])) echo $_POST['txtCellPhoneFile-1']; else echo ${'txtCellPhoneFile-$i'}; ?>" />
                    <br /><span style="font-size: 10pt; ">&nbsp;[ISO code][which testament].jar</span>
				</td>
				<td width="23%">
					<input type='text' style='color: navy; ' size='35' name='txtCellPhoneOptional-1' id='txtCellPhoneOptional-1' value="<?php if (isset($_POST['txtCellPhoneOptional-1'])) echo $_POST['txtCellPhoneOptional-1']; else echo ${'txtCellPhoneOptional-$i'}; ?>" />
                    <br /><span style="font-size: 10pt; ">&nbsp;</span>
				</td>
				<td width="19%" style="text-align: right; vertical-align: top; ">
					<input style="font-size: 9pt; " type="button" id="addCell" value="Add" />
					<input style="font-size: 9pt; " type="button" id="removeCell" value="Remove" />
				</td>
			</tr>
			<?php
			$i = 2;
			if (isset($_POST['txtCellPhoneFile-'.(string)$i])) {
				while (isset($_POST['txtCellPhoneFile-'.(string)$i])) {
					echo "<tr valign='bottom' style='line-height: 10pt; '>";
						echo "<td width='19%'>";
							echo "&nbsp;";
						echo "</td>";
						echo "<td width='16%'>";
							//echo "<input type='text' name='txtCellPhoneTitle-$i' id='txtCellPhoneTitle-$i' style='color: navy; ' size='39' value='" . ( isset($_POST['txtCellPhoneTitle-'.(string)$i]) ? $_POST['txtCellPhoneTitle-'.(string)$i] : '' ) . "' />";
							if ($_POST['txtCellPhoneTitle-'.(string)$i] == 'CPJava-'.$i) ${'CPJava-$i'}=1; else ${'CPJava-$i'}=0;
							if ($_POST['txtCellPhoneTitle-'.(string)$i] == 'CPAndroid-'.$i) ${'CPAndroid-$i'}=1; else ${'CPAndroid-$i'}=0;
							if ($_POST['txtCellPhoneTitle-'.(string)$i] == 'CPiPhone-'.$i) ${'CPiPhone-$i'}=1; else ${'CPiPhone-$i'}=0;
							//if ($_POST['txtCellPhoneTitle-'.(string)$i] == 'CPWindows-'.$i) ${'CPWindows-$i'}=1; else ${'CPWindows-$i'}=0;
							//if ($_POST['txtCellPhoneTitle-'.(string)$i] == 'CPBlackberry-'.$i) ${'CPBlackberry-$i'}=1; else ${'CPBlackberry-$i'}=0;
							//if ($_POST['txtCellPhoneTitle-'.(string)$i] == 'CPStandard-'.$i) ${'CPStandard-$i'}=1; else ${'CPStandard-$i'}=0;
							if ($_POST['txtCellPhoneTitle-'.(string)$i] == 'CPAndroidApp-'.$i) ${'CPAndroidApp-$i'}=1; else ${'CPAndroidApp-$i'}=0;
							if ($_POST['txtCellPhoneTitle-'.(string)$i] == 'CPiOSAssetPackage-'.$i) ${'CPiOSAssetPackage-$i'}=1; else ${'CPiOSAssetPackage-$i'}=0;
							?>
							<select name="txtCellPhoneTitle-<?php echo $i ?>" id="txtCellPhoneTitle-<?php echo $i ?>" style='color: navy; '>
								<option value="CPJava-<?php echo $i ?>" <?php echo ( ${'CPJava-$i'} == 1 ? " selected='selected'" : '' ) ?>>GoBible (Java)</option>
								<option value="CPAndroid-<?php echo $i ?>" <?php echo ( ${'CPAndroid-$i'} == 1 ? " selected='selected'" : '' ) ?>>MySword (Android)</option>
								<option value="CPiPhone-<?php echo $i ?>" <?php echo ( ${'CPiPhone-$i'} == 1 ? " selected='selected'" : '' ) ?>>iPhone</option>
								<!--option value="CPWindows-< ?php echo $i ?>" < ?php echo ( ${'CPWindows-$i'} == 1 ? " selected='selected'" : '' ) ?>>Windows</option-->
								<!--option value="CPBlackberry-< ?php echo $i ?>" < ?php echo ( ${'CPBlackberry-$i'} == 1 ? " selected='selected'" : '' ) ?>>Blackberry</option-->
								<!--option value="CPStandard-< ?php echo $i ?>" < ?php echo ( ${'CPStandard-$i'} == 1 ? " selected='selected'" : '' ) ?>>Standard Cell Phone</option-->
								<option value="CPAndroidApp-<?php echo $i ?>" <?php echo ( ${'CPAndroidApp-$i'} == 1 ? " selected='selected'" : '' ) ?>>Android App (apk)</option>
								<option value="CPiOSAssetPackage-<?php echo $i ?>" <?php echo ( ${'CPiOSAssetPackage-$i'} == 1 ? " selected='selected'" : '' ) ?>>iOS Asset Package</option>
							</select>
							<?php
						echo "</td>";
						echo "<td width='23%'>";
							echo "<input type='text' name='txtCellPhoneFile-$i' id='txtCellPhoneFile-$i' style='color: navy; ' size='35' value='" . ( isset($_POST['txtCellPhoneFile-'.(string)$i]) ? $_POST['txtCellPhoneFile-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='23%'>";
							echo "<input type='text' name='txtCellPhoneOptional-$i' id='txtCellPhoneOptional-$i' style='color: navy; ' size='35' value='" . ( isset($_POST['txtCellPhoneOptional-'.(string)$i]) ? $_POST['txtCellPhoneOptional-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='19%'>";
							echo "&nbsp;";
						echo "</td>";
					echo "</tr>";
					$i++;
				}
			}
			else {
				//for (; $i <= $num; $i++) {															// $i = 2!!!!!!!!!!!!
				if ($num > 1) {
					while ($r = $result1->fetch_assoc()) {
						//${'txtCellPhoneTitle-$i'}=mysql_result($result1,$i-1,'Cell_Phone_Title');
						${'txtCellPhoneTitle-$i'}=1;
						$temp1 = $r['Cell_Phone_Title'];
						if ($temp1 == 'GoBible (Java)') ${'CPJava-$i'}=1; else ${'CPJava-$i'}=0;
						if ($temp1 == 'MySword (Android)') ${'CPAndroid-$i'}=1; else ${'CPAndroid-$i'}=0;
						if ($temp1 == 'iPhone') ${'CPiPhone-$i'}=1; else ${'CPiPhone-$i'}=0;
						//if ($temp1 == 'Windows') ${'CPWindows-$i'}=1; else ${'CPWindows-$i'}=0;
						//if ($temp1 == 'Blackberry') ${'CPBlackberry-$i'}=1; else ${'CPBlackberry-$i'}=0;
						//if ($temp1 == 'Standard Cell Phone') ${'CPStandard-$i'}=1; else ${'CPStandard-$i'}=0;
						if ($temp1 == 'Android App') ${'CPAndroidApp-$i'}=1; else ${'CPAndroidApp-$i'}=0;
						if ($temp1 == 'iOS Asset Package') ${'CPiOSAssetPackage-$i'}=1; else ${'CPiOSAssetPackage-$i'}=0;
						${'txtCellPhoneFile-$i'}=$r['Cell_Phone_File'];
						${'txtCellPhoneOptional-$i'}=$r['optional'];
						echo "<tr valign='bottom' style='line-height: 10pt; '>";
							echo "<td width='19%'>";
								echo "&nbsp;";
							echo "</td>";
							echo "<td width='16%'>";
								?>
								<select name="txtCellPhoneTitle-<?php echo $i ?>" id="txtCellPhoneTitle-<?php echo $i ?>" style='color: navy; '>
									<option value="CPJava-<?php echo $i ?>" <?php echo ( ${'CPJava-$i'} == 1 ? " selected='selected'" : '' ) ?>>GoBible (Java)</option>
									<option value="CPAndroid-<?php echo $i ?>" <?php echo ( ${'CPAndroid-$i'} == 1 ? " selected='selected'" : '' ) ?>>MySword (Android)</option>
									<option value="CPiPhone-<?php echo $i ?>" <?php echo ( ${'CPiPhone-$i'} == 1 ? " selected='selected'" : '' ) ?>>iPhone</option>
									<!--option value="CPWindows-< ?php echo $i ?>" < ?php echo ( ${'CPWindows-$i'} == 1 ? " selected='selected'" : '' ) ?>>Windows</option-->
									<!--option value="CPBlackberry-< ?php echo $i ?>" < ?php echo ( ${'CPBlackberry-$i'} == 1 ? " selected='selected'" : '' ) ?>>Blackberry</option-->
									<!--option value="CPStandard-< ?php echo $i ?>" < ?php echo ( ${'CPStandard-$i'} == 1 ? " selected='selected'" : '' ) ?>>Standard Cell Phone</option-->
									<option value="CPAndroidApp-<?php echo $i ?>" <?php echo ( ${'CPAndroidApp-$i'} == 1 ? " selected='selected'" : '' ) ?>>Android App (apk)</option>
									<option value="CPiOSAssetPackage-<?php echo $i ?>" <?php echo ( ${'CPiOSAssetPackage-$i'} == 1 ? " selected='selected'" : '' ) ?>>iOS Asset Package</option>
								</select>
								<?php
							echo "</td>";
							echo "<td width='23%'>";
								echo "<input type='text' name='txtCellPhoneFile-$i' id='txtCellPhoneFile-$i' style='color: navy; ' size='35' value='" . ${'txtCellPhoneFile-$i'} . "' />";
							echo "</td>";
							echo "<td width='23%'>";
								echo "<input type='text' name='txtCellPhoneOptional-$i' id='txtCellPhoneOptional-$i' style='color: navy; ' size='35' value='" . ${'txtCellPhoneOptional-$i'} . "' />";
							echo "</td>";
							echo "<td width='19%'>";
								echo "&nbsp;";
							echo "</td>";
						echo "</tr>";
						$i++;
					}
				}
				if ($num > 0) {
					$result1->free();
				}
			}
			
/*************************************************
	watch
**************************************************/
			?>
          </tbody>
		</table>
		<br />

		<table valign="bottom" cellpadding="0" cellspacing="0" width="100%">
        	<thead>
			<tr valign="bottom" style="color: navy; font-size: 8pt; line-height: 7pt; height: 30px; ">
				<td width="15%">&nbsp;</td>
				<td width="20%" style="padding-left: 3px; ">Organization <i>(optional)</i></td>
				<td width="20%" style="padding-left: 3px; ">Resource Description</td>
				<td width="19%" style="padding-left: 3px; ">URL Link</td>
				<td width="6%" style="text-align: center; padding-left: 3px; ">JESUS Film</td>
				<td width="4%" style="text-align: center; padding-left: 3px; ">YouTube</td>
				<td width="16%">&nbsp;</td>
			</tr>
            </thead>
            <?php
            $i=1;
            $num = 0;
            if (isset($_POST['txtWatchWebSource-'.(string)$i])) {
                
            }
            elseif ($SM_row['watch']) {
                $query="SELECT * FROM watch WHERE ISO_ROD_index = $idx";
                $result1=$db->query($query);
                $num=$result1->num_rows;
                $r = $result1->fetch_assoc();
                ${'txtWatchWebSource-1'}=$r['organization'];
                ${'txtWatchResource-1'}=$r['watch_what'];
                ${'txtWatchURL-1'}=$r['URL'];
                ${'txtWatchJesusFilm-1'}=$r['JesusFilm'];
                ${'txtWatchYouTube-1'}=$r['YouTube'];
            }
            else {
                ${'txtWatchWebSource-1'}="";
                ${'txtWatchResource-1'}="";
                ${'txtWatchURL-1'}="";
                ${'txtWatchJesusFilm-1'}="";
                ${'txtWatchYouTube-1'}="";
            }
            ?>
            <tbody name="tableWatch" id="tableWatch">
			<tr valign="bottom" style="line-height: 10pt; ">
				<td width="15%">
					<span style="font-size: 9pt; ">Enter “Watches”:</span><br /><span style="font-size: 8pt; ">(one line per Watch)</span>
                    <br /><span style="font-size: 10pt; ">For example:</span>
				</td>
				<td width="20%">
					<input type='text' style='color: navy; ' size='26' name='txtWatchWebSource-1' id='txtWatchWebSource-1' value="<?php if (isset($_POST['txtWatchWebSource-1'])) echo $_POST['txtWatchWebSource-1']; else echo ${'txtWatchWebSource-1'}; ?>" />
                    <br /><span style="font-size: 10pt; ">Inspirational Films</span>
				</td>
				<td width="20%">
					<input type='text' style='color: navy; ' size='26' name='txtWatchResource-1' id='txtWatchResource-1' value="<?php if (isset($_POST['txtWatchResource-1'])) echo $_POST['txtWatchResource-1']; else echo ${'txtWatchResource-1'}; ?>" />
                    <br /><span style="font-size: 10pt; ">View the JESUS Film</span>
				</td>
				<td width="19%">
					<input type='text' style='color: navy; ' size='29' name='txtWatchURL-1' id='txtWatchURL-1' value="<?php if (isset($_POST['txtWatchURL-1'])) echo $_POST['txtWatchURL-1']; else echo ${'txtWatchURL-1'}; ?>" />
                    <br /><span style="font-size: 9pt; ">http://media.inspirationalfilms.com?id=...</span>
				</td>
				<td width="6%" style='text-align: center; '>
					<input type='checkbox' style='color: navy; ' name='txtWatchJesusFilm-1' id='txtWatchJesusFilm-1' <?php echo (isset($_POST['txtWatchJesusFilm-1']) ? " checked='checked'" : (isset(${'txtWatchJesusFilm-1'}) && (${'txtWatchJesusFilm-1'}==1) ? " checked='checked'" : '')); ?> />
                    <br /><span style="font-size: 10pt; font-family: 'Times New Roman'; ">&#9745;</span>
   				</td>
				<td width="4%" style='text-align: center; '>
					<input type='checkbox' style='color: navy; margin-right: 10px; ' name='txtWatchYouTube-1' id='txtWatchYouTube-1' <?php echo (isset($_POST['txtWatchYouTube-1']) ? " checked='checked'" : (isset(${'txtWatchYouTube-1'}) && (${'txtWatchYouTube-1'}==1) ? " checked='checked'" : '')); ?> />
                    <br /><span style="font-size: 10pt; margin-right: 6px; ">&#9744;</span>
   				</td>
				<td width="16%" style="text-align: right; ">
					<input style="font-size: 9pt; " type="button" id="addWatch" value="Add" />
					<input style="font-size: 9pt; " type="button" id="removeWatch" value="Remove" />
                    <br /><span style="font-size: 10pt; ">&nbsp;</span>
				</td>
			</tr>
			<?php
			$i = 2;
			if (isset($_POST['txtWatchWebSource-'.(string)$i]) || isset($_POST['txtWatchWebSource-'.(string)$i]) || isset($_POST['txtWatchURL-'.(string)$i])) {
				while (isset($_POST['txtWatchResource-'.(string)$i]) || isset($_POST['txtWatchResource-'.(string)$i]) || isset($_POST['txtWatchURL-'.(string)$i])) {
					echo "<tr valign='bottom' style='line-height: 10pt; '>";
						echo "<td width='15%'>";
							echo "&nbsp;";
						echo "</td>";
						echo "<td width='20%'>";
							echo "<input type='text' name='txtWatchWebSource-$i' id='txtWatchWebSource-$i' style='color: navy; ' size='26' value='" . ( isset($_POST['txtWatchWebSource-'.(string)$i]) ? $_POST['txtWatchWebSource-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='20%'>";
							echo "<input type='text' name='txtWatchResource-$i' id='txtWatchResource-$i' style='color: navy; ' size6' value='" . ( isset($_POST['txtWatchResource-'.(string)$i]) ? $_POST['txtWatchResource-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='19%'>";
							echo "<input type='text' name='txtWatchURL-$i' id='txtWatchURL-$i' style='color: navy; ' size='29' value='" . ( isset($_POST['txtWatchURL-'.(string)$i]) ? $_POST['txtWatchURL-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='6%' style='text-align: center; '>";
                			if (isset($_POST['txtWatchJesusFilm-$i'])) $WatchJesusFilm = $_POST['txtWatchJesusFilm-$i']; else $WatchJesusFilm = ${'txtWatchJesusFilm-$i'};
							echo "<input type='checkbox' name='txtWatchJesusFilm-$i' id='txtWatchJesusFilm-$i' style='color: navy; text-align: center; ' value='$WatchJesusFilm'";
							if ($WatchJesusFilm) echo " checked='checked'";
							echo " />";
						echo "</td>";
						echo "<td width='4%' style='text-align: center; '>";
                			if (isset($_POST['txtWatchYouTube-$i'])) $WatchYouTube = $_POST['txtWatchYouTube-$i']; else $WatchYouTube = ${'txtWatchYouTube-$i'};
							echo "<input type='checkbox' name='txtWatchYouTube-$i' id='txtWatchYouTube-$i' style='color: navy; text-align: center; ' value='$WatchYouTube'";
							if ($WatchYouTube) echo " checked='checked'";
							echo " />";
						echo "</td>";
						echo "<td width='16%'>";
							echo "&nbsp;";
						echo "</td>";
					echo "</tr>";
					$i++;
				}
			}
			else {
				if ($num > 1) {
					while ($r = $result1->fetch_assoc()) {
						${'txtWatchWebSource-$i'}=$r['organization'];
						${'txtWatchResource-$i'}=$r['watch_what'];
						${'txtWatchURL-$i'}=$r['URL'];
						${'txtWatchJesusFilm-$i'}=$r['JesusFilm'];
						${'txtWatchYouTube-$i'}=$r['YouTube'];
						echo "<tr valign='bottom' style='line-height: 10pt; '>";
							echo "<td width='15%'>";
								echo "&nbsp;";
							echo "</td>";
							echo "<td width='20%'>";
								echo "<input type='text' name='txtWatchWebSource-$i' id='txtWatchWebSource-$i' style='color: navy; ' size='26' value='" . ${'txtWatchWebSource-$i'} . "' />";
							echo "</td>";
							echo "<td width='20%'>";
								echo "<input type='text' name='txtWatchResource-$i' id='txtWatchResource-$i' style='color: navy; ' size='26' value='" . ${'txtWatchResource-$i'} . "' />";
							echo "</td>";
							echo "<td width='19%'>";
								echo "<input type='text' name='txtWatchURL-$i' id='txtWatchURL-$i' style='color: navy; ' size='26' value='" . ${'txtWatchURL-$i'} . "' />";
							echo "</td>";
							echo "<td width='6%' style='text-align: center; '>";
								echo "<input type='checkbox' name='txtWatchJesusFilm-$i' id='txtWatchJesusFilm-$i' style='color: navy; '";
								if (${'txtWatchJesusFilm-$i'}==1) echo " checked='checked'";
								echo " />";
							echo "</td>";
							echo "<td width='4%' style='text-align: center; '>";
								echo "<input type='checkbox' name='txtWatchYouTube-$i' id='txtWatchYouTube-$i' style='color: navy; '";
								if (${'txtWatchYouTube-$i'}==1) echo " checked='checked'";
								echo " />";
							echo "</td>";
							echo "<td width='16%'>";
								echo "&nbsp;";
							echo "</td>";
						echo "</tr>";
						$i++;
					}
				}
				if ($num > 0) {
					$result1->free();
				}
			}
			?>
            </tbody>
		</table>
		<br />

		<?php
/*************************************************
	Studies -- theWord
**************************************************/
		?>
		<table valign="bottom" cellpadding="0" cellspacing="0" width="100%">
       	  <thead style='text-align: center; vertical-align: bottom; '>
			<tr valign="bottom" style="color: navy; font-size: 8pt; line-height: 7pt; height: 30px; ">
				<td width="100px">&nbsp;
				</td>
				<td width="113px">
					Scripture<br />Description
				</td>
                <td width="132px">
                	Which<br />Testament?
                </td>
                <td width="156px">
                	Which<br />alphabet?
                </td>
				<td width="82px">
					Scripture<br />URL
				</td>
				<td width="113px">
					Statement<br />between the two
				</td>
				<td width="61px">
					Other Website<br />Description
				</td>
                <td width='116px'>
                	Other Website<br />URL
                </td>
                <td width='145px'>&nbsp;
                </td>
			</tr>
		</thead>
		<?php
		$i=1;
		$num = 0;
		if (isset($_POST['txtScriptureDescription-'.(string)$i])) {
			if ($_POST['txtTestament-1'] == 'SNT-1') $_POST['SNT-1']=1; else $_POST['SNT-1']=0;
			if ($_POST['txtTestament-1'] == 'SOT-1') $_POST['SOT-1']=1; else $_POST['SOT-1']=0;
			if ($_POST['txtTestament-1'] == 'SBible-1') $_POST['SBible-1']=1; else $_POST['SBible-1']=0;
			if ($_POST['txtAlphabet-1'] == 'SStandAlphabet-1') $_POST['SStandAlphabet-1']=1; else $_POST['SStandAlphabet-1']=0;
			if ($_POST['txtAlphabet-1'] == 'STradAlphabet-1') $_POST['STradAlphabet-1']=1; else $_POST['STradAlphabet-1']=0;
			if ($_POST['txtAlphabet-1'] == 'SNewAlphabet-1') $_POST['SNewAlphabet-1']=1; else $_POST['SNewAlphabet-1']=0;
		}
		elseif ($SM_row['study']) {
			$query="SELECT * FROM study WHERE ISO_ROD_index = $idx";
			$result1=$db->query($query);
			$num=$result1->num_rows;
			$r = $result1->fetch_assoc();
			${'txtScriptureDescription-$i'}=$r['ScriptureDescription'];
			${'txtTestament-$i'}=1;
			${'txtAlphabet-$i'}=1;
			${'txtScriptureURL-$i'}=$r['ScriptureURL'];
			${'txtStatement-$i'}=$r['statement'];
			${'txtOthersiteDescription-$i'}=$r['othersiteDescription'];
			${'txtOthersiteURL-$i'}=$r['othersiteURL'];
			$temp1 = $r['Testament'];
			if ($temp1 == 'New Testament') ${'SNT-$i'}=1; else ${'SNT-$i'}=0;
			if ($temp1 == 'Old Testament') ${'SOT-$i'}=1; else ${'SOT-$i'}=0;
			if ($temp1 == 'Bible') ${'SBible-$i'}=1; else ${'SBible-$i'}=0;
			$temp1 = $r['alphabet'];
			if ($temp1 == 'Standard alphabet') ${'SStandAlphabet-$i'}=1; else ${'SStandAlphabet-$i'}=0;
			if ($temp1 == 'Traditional alphabet') ${'STradAlphabet-$i'}=1; else ${'STradAlphabet-$i'}=0;
			if ($temp1 == 'New alphabet') ${'SNewAlphabet-$i'}=1; else ${'SNewAlphabet-$i'}=0;
		}
		else {
			${'txtScriptureDescription-$i'}="";
			${'txtTestament-$i'}=1;
			${'SNT-$i'}=1;
			${'SOT-$i'}=0;
			${'SBible-$i'}=0;
			${'txtAlphabet-$i'}=1;
			${'SStandAlphabet-$i'}=1;
			${'STradAlphabet-$i'}=0;
			${'SNewAlphabet-$i'}=0;
			${'txtScriptureURL-$i'}="";
			${'txtStatement-$i'}="";
			${'txtOthersiteDescription-$i'}="";
			${'txtOthersiteURL-$i'}="";
		}
		?>
		<tbody name="tableStudy" id="tableStudy">
			<tr valign="bottom" style="line-height: 10pt; vertical-align: top; ">
				<td width="100px">
					<span style="font-size: 10pt; ">Enter Studies:</span><br /><span style="font-size: 7pt; ">(one line per Study)</span>
                    <br /><span style="font-size: 10pt; ">For example:</span>
				</td>
				<td width="113px">
					<input type='text' style='color: navy; ' size='14' name='txtScriptureDescription-1' id='txtScriptureDescription-1' value="<?php if (isset($_POST['txtScriptureDescription-1'])) echo $_POST['txtScriptureDescription-1']; else echo ${'txtScriptureDescription-$i'}; ?>" />
                    <br /><span style="font-size: 8pt; ">Download New<br />Testament</span>
				</td>
				<td width="132px">
                    <!--
                    	New Testament
                        Old Testament
                        Bible
                    -->
                    <select name="txtTestament-1" id="txtTestament-1" style='color: navy; '>
                        <option value="SNT-1" <?php echo ( isset($_POST['SNT-1']) ? ($_POST['SNT-1'] == 1 ? " selected='selected'" : "") : (${'SNT-$i'} == 1 ? " selected='selected'" : '' ) ) ?>>New Testament</option>
                        <option value="SOT-1" <?php echo ( isset($_POST['SOT-1']) ? ($_POST['SOT-1'] == 1 ? " selected='selected'" : "") : (${'SOT-$i'} == 1 ? " selected='selected'" : '' ) ) ?>>Old Testament</option>
                        <option value="SBible-1" <?php echo ( isset($_POST['SBible-1']) ? ($_POST['SBible-1'] == 1 ? " selected='selected'" : "") : (${'SBible-$i'} == 1 ? " selected='selected'" : '' ) ) ?>>Bible</option>
                    </select>
                   <br /><span style="font-size: 10pt; ">New Testament</span>
				</td>
				<td width="156px">
                    <!--
                    	Standard alphabet
                        Traditional alphabet
                        New alphabet
                    -->
                    <select name="txtAlphabet-1" id="txtAlphabet-1" style='color: navy; '>
                        <option value="SStandAlphabet-1" <?php echo ( isset($_POST['SStandAlphabet-1']) ? ($_POST['SStandAlphabet-1'] == 1 ? " selected='selected'" : "") : (${'SStandAlphabet-$i'} == 1 ? " selected='selected'" : '' ) ) ?>>Standard alphabet</option>
                        <option value="STradAlphabet-1" <?php echo ( isset($_POST['STradAlphabet-1']) ? ($_POST['STradAlphabet-1'] == 1 ? " selected='selected'" : "") : (${'STradAlphabet-$i'} == 1 ? " selected='selected'" : '' ) ) ?>>Traditional alphabet</option>
                        <option value="SNewAlphabet-1" <?php echo ( isset($_POST['SNewAlphabet-1']) ? ($_POST['SNewAlphabet-1'] == 1 ? " selected='selected'" : "") : (${'SNewAlphabet-$i'} == 1 ? " selected='selected'" : '' ) ) ?>>New alphabet</option>
                    </select>
                    <br /><span style="font-size: 10pt; ">Standard alphabet</span>
				</td>
				<td width="82px">
					<input type='text' style='color: navy; ' size='6' name='txtScriptureURL-1' id='txtScriptureURL-1' value="<?php if (isset($_POST['txtScriptureURL-1'])) echo $_POST['txtScriptureURL-1']; else echo ${'txtScriptureURL-$i'}; ?>" />
                    <br /><span style="font-size: 10pt; ">zzz.zz.exe</span>
				</td>
				<td width="113px">
					<input type='text' style='color: navy; ' size='13' name='txtStatement-1' id='txtStatement-1' value="<?php if (isset($_POST['txtStatement-1'])) echo $_POST['txtStatement-1']; else echo ${'txtStatement-$i'}; ?>" />
                    <br /><span style="font-size: 7pt; ">for use with the Bible study software</span>
				</td>
				<td width="61px">
					<input type='text' style='color: navy; ' size='5' name='txtOthersiteDescription-1' id='txtOthersiteDescription-1' value="<?php if (isset($_POST['txtOthersiteDescription-1'])) echo $_POST['txtOthersiteDescription-1']; else echo ${'txtOthersiteDescription-$i'}; ?>" />
                    <br /><span style="font-size: 10pt; ">The Word</span>
				</td>
				<td width="116px">
					<input type='text' style='color: navy; ' size='14' name='txtOthersiteURL-1' id='txtOthersiteURL-1' value="<?php if (isset($_POST['txtOthersiteURL-1'])) echo $_POST['txtOthersiteURL-1']; else echo ${'txtOthersiteURL-$i'}; ?>" />
                    <br /><span style="font-size: 8pt; ">http://www.theword.gr/...</span>
				</td>
				<td width="145px" style="text-align: right; ">
					<input style="font-size: 9pt; " type="button" id="addStudy" value="Add" />
					<input style="font-size: 9pt; " type="button" id="removeStudy" value="Remove" />
                    <br /><span style="font-size: 10pt; ">&nbsp;</span>
				</td>
			</tr>
			<?php
			$i = 2;
			if (isset($_POST['txtScriptureDescription-'.(string)$i]) || isset($_POST['txtScriptureURL-'.(string)$i]) || isset($_POST['txtOthersiteDescription-'.(string)$i])) {
				while (isset($_POST['txtScriptureDescription-'.(string)$i]) || isset($_POST['txtScriptureURL-'.(string)$i]) || isset($_POST['txtOthersiteDescription-'.(string)$i])) {
					echo "<tr valign='bottom' style='line-height: 10pt; '>";
						echo "<td width='100px'>";
							echo "&nbsp;";
						echo "</td>";
						echo "<td width='113px'>";
							echo "<input type='text' name='txtScriptureDescription-$i' id='txtScriptureDescription-$i' style='color: navy; ' size='14' value='" . ( isset($_POST['txtScriptureDescription-'.(string)$i]) ? $_POST['txtScriptureDescription-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='132px'>";
							if ($_POST['txtTestament-'.(string)$i] == 'SNT-'.$i) ${'SNT-$i'}=1; else ${'SNT-$i'}=0;
							if ($_POST['txtTestament-'.(string)$i] == 'SOT-'.$i) ${'SOT-$i'}=1; else ${'SOT-$i'}=0;
							if ($_POST['txtTestament-'.(string)$i] == 'SBible-'.$i) ${'SBible-$i'}=1; else ${'SBible-$i'}=0;
							?>
							<select name="txtTestament-<?php echo $i ?>" id="txtTestament-<?php echo $i ?>" style='color: navy; '>
								<option value="SNT-<?php echo $i ?>" <?php echo ( ${'SNT-$i'} == 1 ? " selected='selected'" : '' ) ?>>New Testament</option>
								<option value="SOT-<?php echo $i ?>" <?php echo ( ${'SOT-$i'} == 1 ? " selected='selected'" : '' ) ?>>Old Testament</option>
								<option value="SBible-<?php echo $i ?>" <?php echo ( ${'SBible-$i'} == 1 ? " selected='selected'" : '' ) ?>>Bible</option>
							</select>
                            <?php
						echo "</td>";
						echo "<td width='156px'>";
							if ($_POST['txtAlphabet-'.(string)$i] == 'SStandAlphabet-'.$i) $_POST['SStandAlphabet-'.(string)$i]=1; else $_POST['SStandAlphabet-'.(string)$i]=0;
							if ($_POST['txtAlphabet-'.(string)$i] == 'STradAlphabet-'.$i) $_POST['STradAlphabet-'.(string)$i]=1; else $_POST['STradAlphabet-'.(string)$i]=0;
							if ($_POST['txtAlphabet-'.(string)$i] == 'SNewAlphabet-'.$i) $_POST['SNewAlphabet-'.(string)$i]=1; else $_POST['SNewAlphabet-'.(string)$i]=0;
							?>
							<select name="txtAlphabet-<?php echo $i ?>" id="txtAlphabet-<?php echo $i ?>" style='color: navy; '>
								<option value="SStandAlphabet-<?php echo $i ?>" <?php echo ( ${'SStandAlphabet-$i'} == 1 ? " selected='selected'" : '' ) ?>>Standard alphabet</option>
								<option value="STradAlphabet-<?php echo $i ?>" <?php echo ( ${'STradAlphabet-$i'} == 1 ? " selected='selected'" : '' ) ?>>Traditional alphabet</option>
								<option value="SNewAlphabet-<?php echo $i ?>" <?php echo ( ${'SNewAlphabet-$i'} == 1 ? " selected='selected'" : '' ) ?>>New alphabet</option>
							</select>
                            <?php
						echo "</td>";
						echo "<td width='82px'>";
							echo "<input type='text' name='txtScriptureURL-$i' id='txtScriptureURL-$i' style='color: navy; ' size='6' value='" . ( isset($_POST['txtScriptureURL-'.(string)$i]) ? $_POST['txtScriptureURL-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='113px'>";
							echo "<input type='text' name='txtStatement-$i' id='txtStatement-$i' style='color: navy; ' size='13' value='" . ( isset($_POST['txtStatement-'.(string)$i]) ? $_POST['txtStatement-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='61px'>";
							echo "<input type='text' name='txtOthersiteDescription-$i' id='txtOthersiteDescription-$i' style='color: navy; ' size='5' value='" . ( isset($_POST['txtOthersiteDescription-'.(string)$i]) ? $_POST['txtOthersiteDescription-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='116px'>";
							echo "<input type='text' name='txtOthersiteURL-$i' id='txtOthersiteURL-$i' style='color: navy; ' size='14' value='" . ( isset($_POST['txtOthersiteURL-'.(string)$i]) ? $_POST['txtOthersiteURL-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='145px'>";
							echo "&nbsp;";
						echo "</td>";
					echo "</tr>";
					$i++;
				}
			}
			else {
				if ($num > 1) {
					while ($r = $result1->fetch_assoc()) {
						${'txtScriptureDescription-$i'}=$r['ScriptureDescription'];
						${'txtTestament-$i'}=1;
						$temp1 = $r['Testament'];
						if ($temp1 == 'New Testament') ${'SNT-$i'}=1; else ${'SNT-$i'}=0;
						if ($temp1 == 'Old Testament') ${'SOT-$i'}=1; else ${'SOT-$i'}=0;
						if ($temp1 == 'Bible') ${'SBible-$i'}=1; else ${'SBible-$i'}=0;
						${'txtAlphabet-$i'}=1;
						$temp1 = $r['alphabet'];
						if ($temp1 == 'Standard alphabet') ${'SStandAlphabet-$i'}=1; else ${'SStandAlphabet-$i'}=0;
						if ($temp1 == 'Traditional alphabet') ${'STradAlphabet-$i'}=1; else ${'STradAlphabet-$i'}=0;
						if ($temp1 == 'New alphabet') ${'SNewAlphabet-$i'}=1; else ${'SNewAlphabet-$i'}=0;
						${'txtScriptureURL-$i'}=$r['ScriptureURL'];
						${'txtStatement-$i'}=$r['statement'];
						${'txtOthersiteDescription-$i'}=$r['othersiteDescription'];
						${'txtOthersiteURL-$i'}=$r['othersiteURL'];
						echo "<tr valign='bottom' style='line-height: 10pt; '>";
							echo "<td width='100px'>";
								echo "&nbsp;";
							echo "</td>";
							echo "<td width='113px'>";
								echo "<input type='text' name='txtScriptureDescription-$i' id='txtScriptureDescription-$i' style='color: navy; ' size='14' value='" . ${'txtScriptureDescription-$i'} . "' />";
							echo "</td>";
							echo "<td width='132px'>";
								?>
								<select name="txtTestament-<?php echo $i ?>" id="Testament-<?php echo $i ?>" style='color: navy; '>
									<option value="SNT-<?php echo $i ?>" <?php echo ( ${'SNT-$i'} == 1 ? " selected='selected'" : '' ) ?>>New Testament</option>
									<option value="SOT-<?php echo $i ?>" <?php echo ( ${'SOT-$i'} == 1 ? " selected='selected'" : '' ) ?>>Old Testament</option>
									<option value="SBible-<?php echo $i ?>" <?php echo ( ${'SBible-$i'} == 1 ? " selected='selected'" : '' ) ?>>Bible</option>
								</select>
								<?php
							echo "</td>";
							echo "<td width='156px'>";
								?>
								<select name="txtAlphabet-<?php echo $i ?>" id="txtAlphabet-<?php echo $i ?>" style='color: navy; '>
									<option value="SStandAlphabet-<?php echo $i ?>" <?php echo ( ${'SStandAlphabet-$i'} == 1 ? " selected='selected'" : '' ) ?>>Standard alphabet</option>
									<option value="STradAlphabet-<?php echo $i ?>" <?php echo ( ${'STradAlphabet-$i'} == 1 ? " selected='selected'" : '' ) ?>>Traditional alphabet</option>
									<option value="SNewAlphabet-<?php echo $i ?>" <?php echo ( ${'SNewAlphabet-$i'} == 1 ? " selected='selected'" : '' ) ?>>New alphabet</option>
								</select>
								<?php
							echo "</td>";
							echo "<td width='82px'>";
								echo "<input type='text' name='txtScriptureURL-$i' id='txtScriptureURL-$i' style='color: navy; ' size='6' value='" . ${'txtScriptureURL-$i'} . "' />";
							echo "</td>";
							echo "<td width='113px'>";
								echo "<input type='text' name='txtStatement-$i' id='txtStatement-$i' style='color: navy; ' size='13' value='" . ${'txtStatement-$i'} . "' />";
							echo "</td>";
							echo "<td width='61px'>";
								echo "<input type='text' name='txtOthersiteDescription-$i' id='txtOthersiteDescription-$i' style='color: navy; ' size='5' value='" . ${'txtOthersiteDescription-$i'} . "' />";
							echo "</td>";
							echo "<td width='116px'>";
								echo "<input type='text' name='txtOthersiteURL-$i' id='txtOthersiteURL-$i' style='color: navy; ' size='14' value='" . ${'txtOthersiteURL-$i'} . "' />";
							echo "</td>";
							echo "<td width='145px'>";
								echo "&nbsp;";
							echo "</td>";
						echo "</tr>";
						$i++;
					}
				}
				if ($num > 0) {
					$result1->free();
				}
			}
/*************************************************
	Other books
**************************************************/
			?>
        	</tbody>
		</table>
		<br />
		
		<table valign="bottom" cellpadding="0" cellspacing="0" width="100%">
        	<thead valign="bottom">
                <tr valign="bottom" style="color: navy; font-size: 8pt; line-height: 7pt; height: 20px; ">
                    <td width="15%" style="color: black; font-size: 1em; line-height: 10pt; ">
                        <span style='font-size: 10pt; '>Enter the Other Books:</span>
                    </td>
                    <td width="13%" style="padding-left: 3px; ">
                        Book Title
                    </td>
                    <td width="13%" style="padding-left: 3px; ">
                        Brief Summary
                    </td>
                    <td width="13%" style="padding-left: 3px; ">
                        PDF Filename
                    </td>
                    <td width="13%" style="padding-left: 3px; ">
                        <b>OR</b> Audio (mp3) Filename
                    </td>
                    <td width="33%" colspan="3" style="padding-left: 3px; ">
                        <b>OR</b> Download Video (mp4) Filename
                    </td>
                </tr>
            </thead>
		<?php
		$i=1;
		$num = 0;
		if (isset($_POST['txtOther-'.(string)$i])) {
			
		}
		elseif ($SM_row['other_titles']) {
			$query="SELECT * FROM other_titles WHERE ISO_ROD_index = $idx";
			$result1=$db->query($query);
			$num=$result1->num_rows;
			$r = $result1->fetch_assoc();
			${'txtOther-$i'}=$r['other'];
			${'txtOtherTitle-$i'}=$r['other_title'];										// this is a "Summary" and not an actual "Title"!
			${'txtOtherPDF-$i'}=$r['other_PDF'];
			${'txtOtherAudio-$i'}=$r['other_audio'];
			${'txtDownload_video-$i'} = $r['download_video'];
		}
		else {
			${'txtOther-$i'}='';
			${'txtOtherTitle-$i'}='';
			${'txtOtherPDF-$i'}='';
			${'txtOtherAudio-$i'}='';
			${'txtDownload_video-$i'}='';
		}
		?>
		<tbody valign="bottom" name="tableOtherBooks" id="tableOtherBooks">
			<tr valign="bottom" style="line-height: 10pt; ">
            	<td width="15%"><span style="font-size: 8pt; ">(one line per Other Book)</span><br /><span style="font-size: 10pt; ">For example:</span>
                </td>
				<td width="13%">
					<input type='text' style='color: navy; ' size='17' name='txtOther-1' id='txtOther-1' onclick='Otheridx(1)' value="<?php if (isset($_POST['txtOther-1'])) echo $_POST['txtOther-1']; else echo ${'txtOther-$i'}; ?>" />
                    <br /><span style="font-size: 10pt; ">OT Selections</span>
				</td>
				<td width="13">
					<input type='text' style='color: navy; ' size='18' name='txtOtherTitle-1' id='txtOtherTitle-1' onclick='Otheridx(1)' value="<?php if (isset($_POST['txtOtherTitle-1'])) echo $_POST['txtOtherTitle-1']; else echo ${'txtOtherTitle-$i'}; ?>" />
                    <br /><span style="font-size: 7pt; ">Selections from the Old Testament</span>
				</td>
				<td width="13%">
					<input type='text' style='color: navy; ' size='18' name='txtOtherPDF-1' id='txtOtherPDF-1' onclick='Otheridx(1)' value="<?php if (isset($_POST['txtOtherPDF-1'])) echo $_POST['txtOtherPDF-1']; else echo ${'txtOtherPDF-$i'}; ?>" />
                    <br /><span style="font-size: 10pt; ">00-POT[ISO]-web.pdf</span>
				</td>
				<td width="13%">
					<input type='text' style='color: navy; ' size='18' name='txtOtherAudio-1' id='txtOtherAudio-1' onclick='Otheridx(1)' value="<?php if (isset($_POST['txtOtherAudio-1'])) echo $_POST['txtOtherAudio-1']; else echo ${'txtOtherAudio-$i'}; ?>" />
                    <br /><span style="font-size: 10pt; ">&nbsp;</span>
				</td>
				<td width="13%">
					<input type='text' style='color: navy; ' size='18' name='txtDownload_video-1' id='txtDownload_video-1' onclick='Otheridx(1)' value="<?php if (isset($_POST['txtDownload_video-1'])) echo $_POST['txtDownload_video-1']; else echo ${'txtDownload_video-$i'}; ?>" />
                    <br /><span style="font-size: 10pt; ">&nbsp;</span>
				</td>
				<td width="4%" style="text-align: right; ">
					<div onclick="moveUpDownOther('tableOtherBooks', 'up')" style="cursor: pointer; "><img src="images/up.png" width="24" height="20" /></div>
					<div onclick="moveUpDownOther('tableOtherBooks', 'down')" style="cursor: pointer; margin-top: 3px; "><img src="images/down.png" width="24" height="18" /></div>
				</td>
				<td width="16%" style="text-align: right; ">
					<input style="font-size: 9pt; " type="button" id="addOther" value="Add" />
					<input style="font-size: 9pt; " type="button" id="removeOther" value="Remove" />
                    <br /><span style="font-size: 10pt; ">&nbsp;</span>
				</td>
			</tr>
			<?php
			$i = 2;
			if (isset($_POST['txtOther-'.(string)$i]) || isset($_POST['txtOtherTitle-'.(string)$i]) || isset($_POST['txtOtherPDF-'.(string)$i]) || isset($_POST['txtOtherAudio-'.(string)$i]) || isset($_POST['txtDownload_video-'.(string)$i])) {
				while (isset($_POST['txtOther-'.(string)$i]) || isset($_POST['txtOtherTitle-'.(string)$i]) || isset($_POST['txtOtherPDF-'.(string)$i]) || isset($_POST['txtOtherAudio-'.(string)$i]) || isset($_POST['txtDownload_video-'.(string)$i])) {
					echo "<tr valign='bottom' style='line-height: 10pt; '>";
						echo "<td width='15%'>";
							echo "&nbsp;";
						echo "</td>";
						echo "<td width='13%'>";
							echo "<input type='text' name='txtOther-$i' id='txtOther-$i' style='color: navy; ' size='17' onclick='Otheridx($i)' value='" . (isset($_POST['txtOther-'.(string)$i]) ? $_POST['txtOther-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='13%'>";
							echo "<input type='text' name='txtOtherTitle-$i' id='txtOtherTitle-$i' style='color: navy; ' size='18' onclick='Otheridx($i)' value='" . (isset($_POST['txtOtherTitle-'.(string)$i]) ? $_POST['txtOtherTitle-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='13%'>";
							echo "<input type='text' name='txtOtherPDF-$i' id='txtOtherPDF-$i' style='color: navy; ' size='18' onclick='Otheridx($i)' value='" . (isset($_POST['txtOtherPDF-'.(string)$i]) ? $_POST['txtOtherPDF-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='13%'>";
							echo "<input type='text' name='txtOtherAudio-$i' id='txtOtherAudio-$i' style='color: navy; ' size='18' onclick='Otheridx($i)' value='" . (isset($_POST['txtOtherAudio-'.(string)$i]) ? $_POST['txtOtherAudio-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='13%'>";
							echo "<input type='text' name='txtDownload_video-$i' id='txtDownload_video-$i' style='color: navy; ' size='18' onclick='Otheridx($i)' value='" . (isset($_POST['txtDownload_video-'.(string)$i]) ? $_POST['txtDownload_video-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='20%' colspan='2'>";
							echo "&nbsp;";
						echo "</td>";
					echo "</tr>";
					$i++;
				}
			}
			else {
				if ($num > 1) {
					while ($r = $result1->fetch_assoc()) {
						${'txtOther-$i'}=$r['other'];
						${'txtOtherTitle-$i'}=$r['other_title'];
						${'txtOtherPDF-$i'}=$r['other_PDF'];
						${'txtOtherAudio-$i'}=$r['other_audio'];
						${'txtDownload_video-$i'}=$r['download_video'];
						echo "<tr valign='bottom' style='line-height: 10pt; '>";
							echo "<td width='15%'>";
								echo "&nbsp;";
							echo "</td>";
							echo "<td width='13%'>";
								echo "<input type='text' name='txtOther-$i' id='txtOther-$i' style='color: navy; ' size='17' onclick='Otheridx($i)' value='" . ${'txtOther-$i'}. "' />";
							echo "</td>";
							echo "<td width='13%'>";
								echo "<input type='text' name='txtOtherTitle-$i' id='txtOtherTitle-$i' style='color: navy; ' size='18' onclick='Otheridx($i)' value='" . ${'txtOtherTitle-$i'} . "' />";
							echo "</td>";
							echo "<td width='13%'>";
								echo "<input type='text' name='txtOtherPDF-$i' id='txtOtherPDF-$i' style='color: navy; ' size='18' onclick='Otheridx($i)' value='" . ${'txtOtherPDF-$i'} . "' />";
							echo "</td>";
							echo "<td width='13%'>";
								echo "<input type='text' name='txtOtherAudio-$i' id='txtOtherAudio-$i' style='color: navy; ' size='18' onclick='Otheridx($i)' value='" . ${'txtOtherAudio-$i'} . "' />";
							echo "</td>";
							echo "<td width='13%'>";
								echo "<input type='text' name='txtDownload_video-$i' id='txtDownload_video-$i' style='color: navy; ' size='18' onclick='Otheridx($i)' value='" . ${'txtDownload_video-$i'} . "' />";
							echo "</td>";
							echo "<td width='20%' colspan='2'>";
								echo "&nbsp;";
							echo "</td>";
						echo "</tr>";
						$i++;
					}
				}
				if ($num > 0) {
					$result1->free();
				}
			}
/*************************************************
	Buy
**************************************************/
			?>
        </tbody>
		</table>

		<table valign="bottom" cellpadding="0" cellspacing="0" width="100%">
        <thead>
			<tr valign="bottom" style="color: navy; font-size: 8pt; line-height: 7pt; height: 30px; ">
				<td width="13%">&nbsp;
				</td>
				<td width="22%" style="padding-left: 3px; ">
					Web Source
				</td>
				<td width="22%" style="padding-left: 3px; ">
					Resource Description
				</td>
				<td width="43%" colspan="2" style="padding-left: 3px; ">
					URL Link
				</td>
			</tr>
		</thead>
		<?php
		$i=1;
		$num = 0;
		if (isset($_POST['txtBuyWebSource-'.(string)$i])) {
			
		}
		elseif ($SM_row['buy']) {
			$query="SELECT * FROM buy WHERE ISO_ROD_index = $idx";
			$result1=$db->query($query);
			$num=$result1->num_rows;
			$r = $result1->fetch_assoc();
			${'txtBuyWebSource-$i'}=$r['organization'];
			${'txtBuyResource-$i'}=$r['buy_what'];
			${'txtBuyURL-$i'}=$r['URL'];
		}
		else {
			${'txtBuyWebSource-$i'}="";
			${'txtBuyResource-$i'}="";
			${'txtBuyURL-$i'}="";
		}
		?>
		<tbody name="tableBuy" id="tableBuy">
			<tr valign="bottom" style="line-height: 10pt; ">
				<td width="13%">
					<span style="font-size: 10pt; ">Enter Buy:</span><br /><span style="font-size: 8pt; ">(one line per Buy)</span>
                    <br /><span style="font-size: 10pt; ">For example:</span>
				</td>
				<td width="22%">
					<input type='text' style='color: navy; ' size='28' name='txtBuyWebSource-1' id='txtBuyWebSource-1' value="<?php if (isset($_POST['txtBuyWebSource-1'])) echo $_POST['txtBuyWebSource-1']; else echo ${'txtBuyWebSource-$i'}; ?>" />
                    <br /><span style="font-size: 10pt; ">Virtual Storehouse</span>
				</td>
				<td width="22%">
					<input type='text' style='color: navy; ' size='28' name='txtBuyResource-1' id='txtBuyResource-1' value="<?php if (isset($_POST['txtBuyResource-1'])) echo $_POST['txtBuyResource-1']; else echo ${'txtBuyResource-$i'}; ?>" />
                    <br /><span style="font-size: 10pt; ">New Testament</span>
				</td>
				<td width="27%">
					<input type='text' style='color: navy; ' size='34' name='txtBuyURL-1' id='txtBuyURL-1' value="<?php if (isset($_POST['txtBuyURL-1'])) echo $_POST['txtBuyURL-1']; else echo ${'txtBuyURL-$i'}; ?>" />
                    <br /><span style="font-size: 9pt; ">http://www.virtualstorehouse.org/...</span>
				</td>
				<td width="16%" style="text-align: right; ">
					<input style="font-size: 9pt; " type="button" id="addBuy" value="Add" />
					<input style="font-size: 9pt; " type="button" id="removeBuy" value="Remove" />
                    <br /><span style="font-size: 10pt; ">&nbsp;</span>
				</td>
			</tr>
			<?php
			$i = 2;
			if (isset($_POST['txtBuyWebSource-'.(string)$i]) || isset($_POST['txtBuyResource-'.(string)$i]) || isset($_POST['txtBuyURL-'.(string)$i])) {
				while (isset($_POST['txtBuyWebSource-'.(string)$i]) || isset($_POST['txtBuyResource-'.(string)$i]) || isset($_POST['txtBuyURL-'.(string)$i])) {
					echo "<tr valign='bottom' style='line-height: 10pt; '>";
						echo "<td width='13%'>";
							echo "&nbsp;";
						echo "</td>";
						echo "<td width='22%'>";
							echo "<input type='text' name='txtBuyWebSource-$i' id='txtBuyWebSource-$i' style='color: navy; ' size='28' value='" . ( isset($_POST['txtBuyWebSource-'.(string)$i]) ? $_POST['txtBuyWebSource-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='22%'>";
							echo "<input type='text' name='txtBuyResource-$i' id='txtBuyResource-$i' style='color: navy; ' size='28' value='" . ( isset($_POST['txtBuyResource-'.(string)$i]) ? $_POST['txtBuyResource-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='27%'>";
							echo "<input type='text' name='txtBuyURL-$i' id='txtBuyURL-$i' style='color: navy; ' size='34' value='" . ( isset($_POST['txtBuyURL-'.(string)$i]) ? $_POST['txtBuyURL-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='16%'>";
							echo "&nbsp;";
						echo "</td>";
					echo "</tr>";
					$i++;
				}
			}
			else {
				if ($num > 1) {
					while ($r = $result1->fetch_assoc()) {
						${'txtBuyWebSource-$i'}=$r['organization'];
						${'txtBuyResource-$i'}=$r['buy_what'];
						${'txtBuyURL-$i'}=$r['URL'];
						echo "<tr valign='bottom' style='line-height: 10pt; '>";
							echo "<td width='13%'>";
								echo "&nbsp;";
							echo "</td>";
							echo "<td width='22%'>";
								echo "<input type='text' name='txtBuyWebSource-$i' id='txtBuyWebSource-$i' style='color: navy; ' size='28' value='" . ${'txtBuyWebSource-$i'} . "' />";
							echo "</td>";
							echo "<td width='22%'>";
								echo "<input type='text' name='txtBuyResource-$i' id='txtBuyResource-$i' style='color: navy; ' size='28' value='" . ${'txtBuyResource-$i'} . "' />";
							echo "</td>";
							echo "<td width='27%'>";
								echo "<input type='text' name='txtBuyURL-$i' id='txtBuyURL-$i' style='color: navy; ' size='34' value='" . ${'txtBuyURL-$i'} . "' />";
							echo "</td>";
							echo "<td width='16%'>";
								echo "&nbsp;";
							echo "</td>";
						echo "</tr>";
						$i++;
					}
				}
				if ($num > 0) {
					$result1->free();
				}
			}
/*************************************************
	Links
**************************************************/
			?>
        </tbody>
		</table>
		<br />
		
		<table valign="bottom" cellpadding="0" cellspacing="0" width="100%">
        <thead>
			<tr valign="bottom" style="color: navy; font-size: 8pt; line-height: 7pt; height: 30px; ">
				<td width="12%">&nbsp;
				</td>
				<td width="21%" style="padding-left: 3px; ">
					Resource Description
				</td>
				<td width="21%" style="padding-left: 3px; ">
					Web Source
				</td>
				<td width="22%" style="padding-left: 3px; ">
					URL Link
				</td>
				<td width="24%" colspan="2" style="padding-left: 3px; ">
					Icon
				</td>
			</tr>
		</thead>
		<?php
		$i=1;
		$num = 0;
		if (isset($_POST['txtLinkCompany-1'])) {
			if ($_POST['linksIcon-1'] == 'linksOther-1') $_POST['linksOther-1']=1; else $_POST['linksOther-1']=0;
			//if ($_POST['linksIcon-1'] == 'linksBuy-1') $_POST['linksBuy-1']=1; else $_POST['linksBuy-1']=0;
			if ($_POST['linksIcon-1'] == 'linksMap-1') $_POST['linksMap-1']=1; else $_POST['linksMap-1']=0;
			if ($_POST['linksIcon-1'] == 'linksGooglePlay-1') $_POST['linksGooglePlay-1']=1; else $_POST['linksGooglePlay-1']=0;
			$_POST['linksOther'] = $_POST['linksOther-1'];
			//$_POST['linksBuy'] = $_POST['linksBuy-1'];									// to be tested
			$_POST['linksMap'] = $_POST['linksMap-1'];									// to be tested
			$_POST['linksGooglePlay'] = $_POST['linksGooglePlay-1'];					// to be tested
		}
		elseif ($SM_row['links']) {
			$query="SELECT * FROM links WHERE ISO_ROD_index = $idx AND BibleIs = 0 AND BibleIsGospelFilm = 0 AND YouVersion = 0 AND Bibles_org = 0 AND GRN = 0 AND email = 0";
			$result1=$db->query($query);
			$num=$result1->num_rows;
			if ($r = $result1->fetch_assoc()) {
				${'txtLinkCompany-1'}=$r['company'];
				${'txtLinkCompanyTitle-1'}=stripslashes($r['company_title']);
				${'txtLinkURL-1'}=$r['URL'];
				//${'linksBuy-1'}=$r['buy'];
				${'linksMap-1'}=$r['map'];
				${'linksGooglePlay-1'}=$r['GooglePlay'];
				//if (${'linksBuy-1'} == 1 || ${'linksMap-1'} == 1 || ${'linksGooglePlay-1'} == 1) {
				if (${'linksMap-1'} == 1 || ${'linksGooglePlay-1'} == 1) {
					${'linksOther-1'}=0;
					${'linksOther'}=0;													// to be tested
				}
				else {
					${'linksOther-1'}=1;
					${'linksOther'}=1;													// to be tested
				}
			}
			else {
				${'txtLinkCompany-1'}='';
				${'txtLinkCompanyTitle-1'}='';
				${'txtLinkURL-1'}='';
				${'linksOther-1'}=0;
				//${'linksBuy-1'}=0;
				${'linksMap-1'}=0;
				${'linksGooglePlay-1'}=0;
			}
			//${'linksBuy'}=${'linksBuy-1'};												// to be tested
			${'linksMap'}=${'linksMap-1'};												// to be tested
			${'linksGooglePlay'}=${'linksGooglePlay-1'};								// to be tested
		}
		else {
			${'txtLinkCompany-1'}='';
			${'txtLinkCompanyTitle-1'}='';
			${'txtLinkURL-1'}='';
			${'linksOther-1'}=0;
			//${'linksBuy-1'}=0;
			${'linksMap-1'}=0;
			${'linksGooglePlay-1'}=0;
			${'linksOther'}=0;															// to be tested
			//${'linksBuy'}=0;															// to be tested
			${'linksMap'}=0;															// to be tested
			${'linksGooglePlay'}=0;														// to be tested
		}
		?>
		<tbody name="tableLinks" id="tableLinks">
			<tr valign="bottom" style="line-height: 10pt; ">
				<td width="12%">
					<span style="font-size: 10pt; ">Enter Links:</span><br /><span style="font-size: 8pt; ">(one line per Link)</span>
                    <br /><span style="font-size: 10pt; ">For example:</span>
				</td>
				<td width="21%">
					<input type='text' style='color: navy; ' size='25' name='txtLinkCompanyTitle-1' id='txtLinkCompanyTitle-1' value="<?php if (isset($_POST['txtLinkCompanyTitle-1'])) echo $_POST['txtLinkCompanyTitle-1']; else echo ${'txtLinkCompanyTitle-1'}; ?>" />
                    <br /><span style="font-size: 10pt; ">language of Brazil</span>
				</td>
				<td width="21%">
					<input type='text' style='color: navy; ' size='25' name='txtLinkCompany-1' id='txtLinkCompany-1' value="<?php if (isset($_POST['txtLinkCompany-1'])) echo $_POST['txtLinkCompany-1']; else echo ${'txtLinkCompany-1'}; ?>" />
                    <br /><span style="font-size: 10pt; ">Google map</span>
				</td>
				<td width="22%">
                	<input type='text' style='color: navy; ' size='27' name='txtLinkURL-1' id='txtLinkURL-1' value="<?php if (isset($_POST['txtLinkURL-1'])) echo $_POST['txtLinkURL-1']; else echo ${'txtLinkURL-1'}; ?>" />
                    <br /><span style="font-size: 9pt; ">http://maps.google.com/maps/...</span>
                </td>
				<td width="8%">
                    <select name="linksIcon-1" id="linksIcon-1" style='color: navy; '>
                        <option value="linksOther-1" <?php echo ( isset($_POST['linksOther-1']) ? ($_POST['linksOther-1'] == 1 ? " selected='selected'" : "") : (${'linksOther-1'} == 1 ? " selected='selected'" : '' ) ) ?>>Other</option>
                        <!--option value="linksBuy-1" < ?php echo ( isset($_POST['linksBuy-1']) ? ($_POST['linksBuy-1'] == 1 ? " selected='selected'" : "") : (${'linksBuy-1'} == 1 ? " selected='selected'" : '' ) ) ?>>Buy</option-->
                        <option value="linksMap-1" <?php echo ( isset($_POST['linksMap-1']) ? ($_POST['linksMap-1'] == 1 ? " selected='selected'" : "") : (${'linksMap-1'} == 1 ? " selected='selected'" : '' ) ) ?>>Map</option>
                        <option value="linksGooglePlay-1" <?php echo ( isset($_POST['linksGooglePlay-1']) ? ($_POST['linksGooglePlay-1'] == 1 ? " selected='selected'" : "") : (${'linksGooglePlay-1'} == 1 ? " selected='selected'" : '' ) ) ?>>Google Play</option>
                    </select>
                    <span style="font-size: 10pt; ">Map</span>
                </td>
				<td width="16%" style="text-align: right; ">
					<input style="font-size: 9pt; " type="button" id="addLinks" value="Add" />
					<input style="font-size: 9pt; " type="button" id="removeLinks" value="Remove" />
                    <br /><span style="font-size: 10pt; ">&nbsp;</span>
				</td>
			</tr>
			<?php
			$i = 2;
			if (isset($_POST['txtLinkCompany-'.(string)$i]) || isset($_POST['txtLinkCompanyTitle-'.(string)$i]) || isset($_POST['txtLinkURL-'.(string)$i])) {
				while (isset($_POST['txtLinkCompany-'.(string)$i]) || isset($_POST['txtLinkCompanyTitle-'.(string)$i]) || isset($_POST['txtLinkURL-'.(string)$i])) {
					echo "<tr valign='bottom' style='line-height: 10pt; '>";
						echo "<td width='12%'>";
							echo "&nbsp;";
						echo "</td>";
						echo "<td width='21%'>";
							echo "<input type='text' name='txtLinkCompanyTitle-$i' id='txtLinkCompanyTitle-$i' style='color: navy; ' size='25' value='" . ( isset($_POST['txtLinkCompanyTitle-'.(string)$i]) ? $_POST['txtLinkCompanyTitle-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='21%'>";
							echo "<input type='text' name='txtLinkCompany-$i' id='txtLinkCompany-$i' style='color: navy; ' size='25' value='" . ( isset($_POST['txtLinkCompany-'.(string)$i]) ? $_POST['txtLinkCompany-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='22%'>";
							echo "<input type='text' name='txtLinkURL-$i' id='txtLinkURL-$i' style='color: navy; ' size='27' value='" . ( isset($_POST['txtLinkURL-'.(string)$i]) ? $_POST['txtLinkURL-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='8%'>";
							if ($_POST['linksIcon-'.(string)$i] == 'linksOther-'.$i) ${'linksOther-$i'}=1; else ${'linksOther-$i'}=0;
							//if ($_POST['linksIcon-'.(string)$i] == 'linksBuy-'.$i) ${'linksBuy-$i'}=1; else ${'linksBuy-$i'}=0;
							if ($_POST['linksIcon-'.(string)$i] == 'linksMap-'.$i) ${'linksMap-$i'}=1; else ${'linksMap-$i'}=0;
							if ($_POST['linksIcon-'.(string)$i] == 'linksGooglePlay-'.$i) ${'linksGooglePlay-$i'}=1; else ${'linksGooglePlay-$i'}=0;
							?>
                            <select name="linksIcon-<?php echo $i ?>" id="linksIcon-<?php echo $i ?>" style='color: navy; '>
                                <option value="linksOther-<?php echo $i ?>" <?php echo ( isset($_POST['linksOther-'.(string)$i]) ? ($_POST['linksOther-'.(string)$i] == 1 ? " selected='selected'" : '') : (${'linksOther-$i'}==1 ? " selected='selected'" : '' ) ) ?>>Other</option>
                                <!--option value="linksBuy-< ?php echo $i ?>" < ?php echo ( isset($_POST['linksBuy-'.(string)$i]) ? ($_POST['linksBuy-'.(string)$i] == 1 ? " selected='selected'" : '') : (${'linksBuy-$i'}==1 ? " selected='selected'" : '' ) ) ?>>Buy</option-->
                                <option value="linksMap-<?php echo $i ?>" <?php echo ( isset($_POST['linksMap-'.(string)$i]) ? ($_POST['linksMap-'.(string)$i] == 1 ? " selected='selected'" : '') : (${'linksMap-$i'}==1 ? " selected='selected'" : '' ) ) ?>>Map</option>
                                <option value="linksGooglePlay-<?php echo $i ?>" <?php echo ( isset($_POST['linksGooglePlay-'.(string)$i]) ? ($_POST['linksGooglePlay-'.(string)$i] == 1 ? " selected='selected'" : '') : (${'linksGooglePlay-$i'}==1 ? " selected='selected'" : '' ) ) ?>>Google Play</option>
                            </select>
                           	<?php
						echo "</td>";
						echo "<td width='16%'>";
							echo "&nbsp;";
						echo "</td>";
					echo "</tr>";
					$i++;
				}
			}
			else {
				if ($num > 1) {
					while ($r = $result1->fetch_assoc()) {
						${'txtLinkCompany-$i'}=$r['company'];
						${'txtLinkCompanyTitle-$i'}=stripslashes($r['company_title']);
						${'txtLinkURL-$i'}=$r['URL'];
						//${'linksBuy-$i'}=$r['buy'];
						${'linksMap-$i'}=$r['map'];
						${'linksGooglePlay-$i'}=$r['GooglePlay'];
						//if (${'linksBuy-$i'} == "1" || ${'linksMap-$i'} == "1" || ${'linksGooglePlay-$i'} == "1" )
						if (${'linksMap-$i'} == "1" || ${'linksGooglePlay-$i'} == "1" )
							${'linksOther-$i'}="0";
						else
							${'linksOther-$i'}="1";
						echo "<tr valign='bottom' style='line-height: 10pt; '>";
							echo "<td width='12%'>";
								echo "&nbsp;";
							echo "</td>";
							echo "<td width='21%'>";
								echo "<input type='text' name='txtLinkCompanyTitle-$i' id='txtLinkCompanyTitle-$i' style='color: navy; ' size='25' value='" . ${'txtLinkCompanyTitle-$i'} . "' />";
							echo "</td>";
							echo "<td width='21%'>";
								echo "<input type='text' name='txtLinkCompany-$i' id='txtLinkCompany-$i' style='color: navy; ' size='25' value='" . ${'txtLinkCompany-$i'} . "' />";
							echo "</td>";
							echo "<td width='22%'>";
								echo "<input type='text' name='txtLinkURL-$i' id='txtLinkURL-$i' style='color: navy; ' size='27' value='" . ${'txtLinkURL-$i'} . "' />";
							echo "</td>";
							echo "<td width='8%'>";
								?>
								<select name="linksIcon-<?php echo $i ?>" id="linksIcon-<?php echo $i ?>" style='color: navy; '>
									<option value="linksOther-<?php echo $i ?>" <?php echo ( ${'linksOther-$i'}==1 ? " selected='selected'" : '' ) ?>>Other</option>
									<!--option value="linksBuy-< ?php echo $i ?>" < ?php echo ( ${'linksBuy-$i'}==1 ? " selected='selected'" : '' ) ?>>Buy</option-->
									<option value="linksMap-<?php echo $i ?>" <?php echo ( ${'linksMap-$i'}==1 ? " selected='selected'" : '' ) ?>>Map</option>
									<option value="linksGooglePlay-<?php echo $i ?>" <?php echo ( ${'linksGooglePlay-$i'}==1 ? " selected='selected'" : '' ) ?>>Google Play</option>
								</select>
								<?php
							echo "</td>";
							echo "<td width='16%'>";
								echo "&nbsp;";
							echo "</td>";
						echo "</tr>";
						$i++;
					}
				}
				if ($num > 0) {
					$result1->free();
				}
			}
/*************************************************
	Audio Playlist
**************************************************/
			?>
        </tbody>
		</table>
		<br />

		<table valign="bottom" cellpadding="0" cellspacing="0" width="100%">
       	  <thead style='text-align: center; vertical-align: bottom; '>
			<tr valign="bottom" style="color: navy; font-size: 8pt; line-height: 7pt; height: 30px; ">
				<td width="13%">&nbsp;
				</td>
				<td width="30%">
                	Listen "to title on the screen"
				</td>
				<td width="41%">
					txt filename
				</td>
				<td width="16%">&nbsp;
				</td>
			</tr>
          </thead>
		<?php
		$i=1;
		$num = 0;
		if (isset($_POST['txtPlaylistAudioTitle-'.(string)$i])) {
			
		}
		elseif ($SM_row['PlaylistAudio']) {
			$query="SELECT * FROM PlaylistAudio WHERE ISO_ROD_index = $idx";
			$result1=$db->query($query);
			$num=$result1->num_rows;
			$r = $result1->fetch_assoc();
			${'txtPlaylistAudioTitle-$i'}=$r['PlaylistAudioTitle'];
			${'txtPlaylistAudioFilename-$i'}=$r['PlaylistAudioFilename'];
		}
		else {
			${'txtPlaylistAudioTitle-$i'}="";
			${'txtPlaylistAudioFilename-$i'}="";
		}
		?>
		<tbody name="tableAudioPlaylist" id="tableAudioPlaylist">
			<tr valign="bottom" style="line-height: 10pt; ">
				<td width="13%">
					<span style="font-size: 10pt; ">Enter mp3 playlist:</span>
                    <br /><span style="font-size: 10pt; ">For example:</span>
				</td>
				<td width="30%">
					<input type='text' style='color: navy; ' size='40' name='txtPlaylistAudioTitle-1' id='txtPlaylistAudioTitle-1' value="<?php if (isset($_POST['txtPlaylistAudioTitle-1'])) echo $_POST['txtPlaylistAudioTitle-1']; else echo ${'txtPlaylistAudioTitle-$i'}; ?>" />
                    <br /><span style="font-size: 10pt; ">Old Testament Summary</span>
				</td>
				<td width="41%">
					<input type='text' style='color: navy; ' size='60' name='txtPlaylistAudioFilename-1' id='txtPlaylistAudioFilename-1' value="<?php if (isset($_POST['txtPlaylistAudioFilename-1'])) echo $_POST['txtPlaylistAudioFilename-1']; else echo ${'txtPlaylistAudioFilename-$i'}; ?>" />
                    <br /><span style="font-size: 10pt; ">OTS-audio-zai.txt</span>
				</td>
				<td width="16%" style="text-align: right; ">
					<input style="font-size: 9pt; " type="button" id="addPLAudio" value="Add" />
					<input style="font-size: 9pt; " type="button" id="removePLAudio" value="Remove" />
                    <br /><span style="font-size: 10pt; ">&nbsp;</span>
				</td>
			</tr>
			<?php
			$i = 2;
			if (isset($_POST['txtPlaylistAudioTitle-'.(string)$i]) || isset($_POST['txtPlaylistAudioFilename-'.(string)$i])) {
				while (isset($_POST['txtPlaylistAudioTitle-'.(string)$i]) || isset($_POST['txtPlaylistAudioFilename-'.(string)$i])) {
					echo "<tr valign='bottom' style='line-height: 10pt; '>";
						echo "<td width='13%'>";
							echo "&nbsp;";
						echo "</td>";
						echo "<td width='30%'>";
							echo "<input type='text' name='txtPlaylistAudioTitle-$i' id='txtPlaylistAudioTitle-$i' style='color: navy; ' size='40' value='" . ( isset($_POST['txtPlaylistAudioTitle-'.(string)$i]) ? $_POST['txtPlaylistAudioTitle-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='41%'>";
							echo "<input type='text' name='txtPlaylistAudioFilename-$i' id='txtPlaylistAudioFilename-$i' style='color: navy; ' size='60' value='" . ( isset($_POST['txtPlaylistAudioFilename-'.(string)$i]) ? $_POST['txtPlaylistAudioFilename-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='16%'>";
							echo "&nbsp;";
						echo "</td>";
					echo "</tr>";
					$i++;
				}
			}
			else {
				if ($num > 1) {
					while ($r = $result1->fetch_assoc()) {
						${'txtPlaylistAudioTitle-$i'}=$r['PlaylistAudioTitle'];
						${'txtPlaylistAudioFilename-$i'}=$r['PlaylistAudioFilename'];
						echo "<tr valign='bottom' style='line-height: 10pt; '>";
							echo "<td width='13%'>";
								echo "&nbsp;";
							echo "</td>";
							echo "<td width='30%'>";
								echo "<input type='text' name='txtPlaylistAudioTitle-$i' id='txtPlaylistAudioTitle-$i' style='color: navy; ' size='40' value='" . ${'txtPlaylistAudioTitle-$i'} . "' />";
							echo "</td>";
							echo "<td width='41%'>";
								echo "<input type='text' name='txtPlaylistAudioFilename-$i' id='txtPlaylistAudioFilename-$i' style='color: navy; ' size='60' value='" . ${'txtPlaylistAudioFilename-$i'} . "' />";
							echo "</td>";
							echo "<td width='16%'>";
								echo "&nbsp;";
							echo "</td>";
						echo "</tr>";
						$i++;
					}
				}
				if ($num > 0) {
					$result1->free();
				}
			}
/*************************************************
	Video Playlist
**************************************************/
			?>
		</tbody>
		</table>
		<br />

		<table valign="bottom" cellpadding="0" cellspacing="0" width="100%">
		<thead style='text-align: center; vertical-align: bottom; '>
			<tr valign="bottom" style="color: navy; font-size: 8pt; line-height: 7pt; height: 30px; ">
				<td width="13%">&nbsp;
				</td>
				<td width="30%" style="padding-left: 3px; ">View or Download "the title on the screen"
				</td>
				<td width="31%" style="padding-left: 3px; ">
					txt filename
				</td>
				<td width="10%">&nbsp;
				</td>
				<td width="16%">&nbsp;
				</td>
			</tr>
		</thead>
		<?php
		$i=1;
		$num = 0;
		if (isset($_POST['txtPlaylistVideoTitle-'.(string)$i])) {
			if ($_POST['PlaylistVideoDownloadIcon-1'] == 'PlaylistVideoView-1') $_POST['PlaylistVideoView-1']=1; else $_POST['PlaylistVideoView-1']=0;
			if ($_POST['PlaylistVideoDownloadIcon-1'] == 'PlaylistVideoDownload-1') $_POST['PlaylistVideoDownload-1']=1; else $_POST['PlaylistVideoDownload-1']=0;
		}
		elseif ($SM_row['PlaylistVideo']) {
			$query="SELECT * FROM PlaylistVideo WHERE ISO_ROD_index = $idx";
			$result1=$db->query($query);
			$num=$result1->num_rows;
			$r = $result1->fetch_assoc();
			${'txtPlaylistVideoTitle-1'}=$r['PlaylistVideoTitle'];
			${'txtPlaylistVideoFilename-1'}=$r['PlaylistVideoFilename'];
			if ($r['PlaylistVideoDownload'] == 1) {
				${'PlaylistVideoView-1'} = 0;
				${'PlaylistVideoDownload-1'} = 1;
			}
			else {
				${'PlaylistVideoView-1'} = 1;
				${'PlaylistVideoDownload-1'} = 0;
			}
		}
		else {
			${'txtPlaylistVideoTitle-1'}="";
			${'txtPlaylistVideoFilename-1'}="";
			${'PlaylistVideoView-1'}=1;
			${'PlaylistVideoDownload-1'}=0;
		}
		?>
		<tbody name="tableVideoPlaylist" id="tableVideoPlaylist">
			<tr valign="bottom" style="line-height: 10pt; ">
				<td width="13%">
					<span style="font-size: 10pt; ">Enter video playlist:</span>
                    <br /><span style="font-size: 10pt; ">For example:</span>
				</td>
				<td width="30%">
					<input type='text' style='color: navy; ' size='40' name='txtPlaylistVideoTitle-1' id='txtPlaylistVideoTitle-1' value="<?php if (isset($_POST['txtPlaylistVideoTitle-1'])) echo $_POST['txtPlaylistVideoTitle-1']; else echo ${'txtPlaylistVideoTitle-1'}; ?>" />
                    <br /><span style="font-size: 10pt; ">Luke video</span>
				</td>
				<td width="31%">
					<input type='text' style='color: navy; ' size='40' name='txtPlaylistVideoFilename-1' id='txtPlaylistVideoFilename-1' value="<?php if (isset($_POST['txtPlaylistVideoFilename-1'])) echo $_POST['txtPlaylistVideoFilename-1']; else echo ${'txtPlaylistVideoFilename-1'}; ?>" />
                    <br /><span style="font-size: 10pt; ">Luke-video-crj.txt</span>
				</td>
				<td width="10%">
                    <select name="PlaylistVideoDownloadIcon-1" id="PlaylistVideoDownloadIcon-1" style='color: navy; '>
                        <option value="PlaylistVideoView-1" <?php echo ( isset($_POST['PlaylistVideoView-1']) ? ($_POST['PlaylistVideoView-1'] == 1 ? " selected='selected'" : '') : (${'PlaylistVideoView-1'} == 1 ? " selected='selected'" : '') ) ?>>View</option>
                        <option value="PlaylistVideoDownload-1" <?php echo ( isset($_POST['PlaylistVideoDownload-1']) ? ($_POST['PlaylistVideoDownload-1'] == 1 ? " selected='selected'" : '') : (${'PlaylistVideoDownload-1'} == 1 ? " selected='selected'" : '') ) ?>>Download</option>
                    </select>
                    <br /><span style="font-size: 10pt; ">View</span>
                </td>
				<td width="16%" style="text-align: right; ">
					<input style="font-size: 9pt; " type="button" id="addPLVideo" value="Add" />
					<input style="font-size: 9pt; " type="button" id="removePLVideo" value="Remove" />
                    <br /><span style="font-size: 10pt; ">&nbsp;</span>
				</td>
			</tr>
			<?php
			$i = 2;
			if (isset($_POST['txtPlaylistVideoTitle-'.(string)$i]) || isset($_POST['txtPlaylistVideoFilename-'.(string)$i])) {
				while (isset($_POST['txtPlaylistVideoTitle-'.(string)$i]) || isset($_POST['txtPlaylistVideoFilename-'.(string)$i])) {
					echo "<tr valign='bottom' style='line-height: 10pt; '>";
						echo "<td width='13%'>";
							echo "&nbsp;";
						echo "</td>";
						echo "<td width='30%'>";
							echo "<input type='text' name='txtPlaylistVideoTitle-$i' id='txtPlaylistVideoTitle-$i' style='color: navy; ' size='40' value='" . ( isset($_POST['txtPlaylistVideoTitle-'.(string)$i]) ? $_POST['txtPlaylistVideoTitle-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='31%'>";
							echo "<input type='text' name='txtPlaylistVideoFilename-$i' id='txtPlaylistVideoFilename-$i' style='color: navy; ' size='40' value='" . ( isset($_POST['txtPlaylistVideoFilename-'.(string)$i]) ? $_POST['txtPlaylistVideoFilename-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='10%'>";
							if ($_POST['PlaylistVideoDownloadIcon-'.(string)$i] == 'PlaylistVideoView-'.$i) ${'PlaylistVideoView-$i'}=1; else ${'PlaylistVideoView-$i'}=0;
							if ($_POST['PlaylistVideoDownloadIcon-'.(string)$i] == 'PlaylistVideoDownload-'.$i) ${'PlaylistVideoDownload-$i'}=1; else ${'PlaylistVideoDownload-$i'}=0;
							?>
                            <select name="PlaylistVideoDownloadIcon-<?php echo $i ?>" id="PlaylistVideoDownloadIcon-<?php echo $i ?>" style='color: navy; '>
                                <option value="PlaylistVideoView-<?php echo $i ?>" <?php echo ( isset($_POST['PlaylistVideoView-'.(string)$i]) ? ($_POST['PlaylistVideoView-'.(string)$i] == 1 ? " selected='selected'" : '') : (${'PlaylistVideoView-$i'}==1 ? " selected='selected'" : '' ) ) ?>>View</option>
                                <option value="PlaylistVideoDownload-<?php echo $i ?>" <?php echo ( isset($_POST['PlaylistVideoDownload-'.(string)$i]) ? ($_POST['PlaylistVideoDownload-'.(string)$i] == 1 ? " selected='selected'" : '') : (${'PlaylistVideoDownload-$i'}==1 ? " selected='selected'" : '' ) ) ?>>Download</option>
                            </select>
                            <?php
						echo "</td>";
						echo "<td width='16%'>";
							echo "&nbsp;";
						echo "</td>";
					echo "</tr>";
					$i++;
				}
			}
			else {
				//for (; $i <= $num; $i++) {
				if ($num > 1) {
					while ($r = $result1->fetch_assoc()) {
						${'txtPlaylistVideoTitle-$i'}=$r['PlaylistVideoTitle'];
						${'txtPlaylistVideoFilename-$i'}=$r['PlaylistVideoFilename'];
						if ($r['PlaylistVideoDownload'] == 1) {
							${'PlaylistVideoView-$i'} = 0;
							${'PlaylistVideoDownload-$i'} = 1;
						}
						else {
							${'PlaylistVideoView-$i'} = 1;
							${'PlaylistVideoDownload-$i'} = 0;
						}
						echo "<tr valign='bottom' style='line-height: 10pt; '>";
							echo "<td width='13%'>";
								echo "&nbsp;";
							echo "</td>";
							echo "<td width='30%'>";
								echo "<input type='text' name='txtPlaylistVideoTitle-$i' id='txtPlaylistVideoTitle-$i' style='color: navy; ' size='40' value='" . ${'txtPlaylistVideoTitle-$i'} . "' />";
							echo "</td>";
							echo "<td width='33%'>";
								echo "<input type='text' name='txtPlaylistVideoFilename-$i' id='txtPlaylistVideoFilename-$i' style='color: navy; ' size='40' value='" . ${'txtPlaylistVideoFilename-$i'} . "' />";
							echo "</td>";
							echo "<td width='8%'>";
								?>
								<select name="PlaylistVideoDownloadIcon-<?php echo $i ?>" id="PlaylistVideoDownloadIcon-<?php echo $i ?>" style='color: navy; '>
									<option value="PlaylistVideoView-<?php echo $i ?>" <?php echo ( ${'PlaylistVideoView-$i'}==1 ? " selected='selected'" : '' ) ?>>View</option>
									<option value="PlaylistVideoDownload-<?php echo $i ?>" <?php echo ( ${'PlaylistVideoDownload-$i'}==1 ? " selected='selected'" : '' ) ?>>Download</option>
								</select>
								<?php
							echo "</td>";
							echo "<td width='16%'>";
								echo "&nbsp;";
							echo "</td>";
						echo "</tr>";
						$i++;
					}
				}
				if ($num > 0) {
					$result1->free();
				}
			}
			?>
        </tbody>
		</table>
		<br />
        
		<?php
/*************************************************
	"Scripture Resources from eBible.org" checkbox
**************************************************/
		if (isset($_POST['eBibleer'])) {
			?>
			<input type='checkbox' name='eBible' id='eBible' <?php echo (isset($_POST['eBible']) && $_POST['eBible'] == 'on' ? ' checked' : '') ?> /> Does this have the "Scripture Resources from eBible.org" URL?
			<?php
        }
		else {
			?>
			<input type='checkbox' name='eBible' id='eBible' <?php echo ($SM_row['eBible'] == 1 ? ' checked' : '') ?> /> Does this have the "Scripture Resources from eBible.org" URL?
			<?php
		}
		echo '<br />';
/*************************************************
	"SIL link" checkbox
**************************************************/
		if (isset($_POST['SILlink'])) {
			?>
            <br />
			<input type='checkbox' name='SILlink' id='SILlink' <?php echo (isset($_POST['SILlink']) && $_POST['SILlink'] == 'on' ? ' checked' : '') ?> /> Does this have the "SIL link" URL?
			<?php
        }
		else {
			?>
            <br />
			<input type='checkbox' name='SILlink' id='SILlink' <?php echo ($SM_row['SILlink'] == 1 ? ' checked' : '') ?> /> Does this have the "SIL link" URL?
			<?php
		}
		echo '<br />';
/*************************************************
	Email links
**************************************************/
		?>
		<table width="100%" valign="bottom" cellpadding="0" cellspacing="0">
            <thead>
                <tr valign="bottom" style="color: navy; font-size: 8pt; line-height: 10pt; height: 30px; ">
                    <td width="16%">&nbsp;
                    </td>
                    <td width="41%" style="padding-left: 3px; ">
						Before Email
                    </td>
                    <td width="27%" style="padding-left: 3px; ">
						Email address link
                    </td>
                    <td width="16%">&nbsp;
                    </td>
                </tr>
            </thead>
            <?php
			$i=1;

			$query="SELECT * FROM links WHERE ISO_ROD_index = $idx AND email = 1";
			$result_email=$db->query($query) or die ('Query failed: ' . $db->error . '</body></html>');
			if ($db->error) {
				die ("'email' ISO_ROD_index is not found.<br />" . $db->error . '</body></html>');
			}
			$email_item = 0;
			if ($result_email->num_rows > 0) {
				$email_item = 1;
			}

            if (isset($_POST['txtEmailAddress-1'])) {

            }
            elseif ($email_item == 1) {
				$row_email = $result_email->fetch_assoc();
                ${'txtEmailTitle-1'}=$row_email['company_title'];
                ${'txtEmailAddress-1'}=$row_email['URL'];
            }
            else {
                ${'txtEmailTitle-1'}="";
                ${'txtEmailAddress-1'}="";
            }
            ?>
            <tbody id="tableEmail" name="tableEmail">
                <tr valign="top" style="line-height: 10pt; ">
                    <td width="16%" style="font-size: 10pt; ">
                        <div style="margin-top: 8px; ">Enter Email link:</div>For example:
                    </td>
                    <td width="41%">
                        <input type='text' style='color: navy; ' size='70' name='txtEmailTitle-1' id='txtEmailTitle-1' value="<?php if (isset($_POST['txtEmailTitle-1'])) echo $_POST['txtEmailTitle-1']; else echo ${'txtEmailTitle-1'}; ?>" />
                        <br /><span style="font-size: 10pt; ">To buy a printed New Testament in this language in Cameroon, please write to </span>
                    </td>
                    <td width="27%">
                        <input type='text' style='color: navy; ' size='32' name='txtEmailAddress-1' id='txtEmailAddress-1' value="<?php if (isset($_POST['txtEmailAddress-1'])) echo $_POST['txtEmailAddress-1']; else echo ${'txtEmailAddress-1'}; ?>" />
                        <br /><span style="font-size: 10pt; margin-left: 3px; "> library_cameroon@sil.org</span>
                    </td>
                    <td width="16%" style="text-align: right; vertical-align: top; ">
                        <input style="font-size: 9pt; " type="button" id="addEmail" value="Add" />
                        <input style="font-size: 9pt; " type="button" id="removeEmail" value="Remove" />
                    </td>
                </tr>
			<?php
			$i = 2;
			if (isset($_POST['txtEmailAddress-'.(string)$i])) {
				while (isset($_POST['txtEmailAddress-'.(string)$i])) {
					echo "<tr valign='bottom' style='line-height: 10pt; '>";
						echo "<td width='16%'>";
							echo "&nbsp;";
						echo "</td>";
						echo "<td width='41%'>";
							echo "<input type='text' style='color: navy; ' size='70' name='txtEmailTitle-".(string)$i."' id='txtEmailTitle-".(string)$i."' value='" . ( isset($_POST['txtEmailTitle-'.(string)$i]) ? $_POST['txtEmailTitle-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='27%'>";
							echo "<input type='text' style='color: navy; ' size='32' name='txtEmailAddress-".(string)$i."' id='txtEmailAddress-".(string)$i."' value='" . ( isset($_POST['txtEmailAddress-'.(string)$i]) ? $_POST['txtEmailAddress-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='16%'>";
							echo "&nbsp;";
						echo "</td>";
					echo "</tr>";
					$i++;
				}
			}
			else {
				if ($result_email->num_rows > 1) {
					while ($row_email = $result_email->fetch_assoc()) {
						${'txtEmailTitle-$i'}=$row_email['company_title'];
						${'txtEmailAddress-$i'}=$row_email['URL'];
						echo "<tr valign='bottom' style='line-height: 10pt; '>";
							echo "<td width='16%'>";
								echo "&nbsp;";
							echo "</td>";
							echo "<td width='41%'>";
								echo "<input type='text' style='color: navy; ' size='70' name='txtEmailTitle-".(string)$i."' id='txtEmailTitle-".(string)$i."' value='" . ${'txtEmailTitle-$i'} . "' />";
							echo "</td>";
							echo "<td width='27%'>";
								echo "<input type='text' style='color: navy; ' size='32' name='txtEmailAddress-".(string)$i."' id='txtEmailAddress-".(string)$i."' value='" . ${'txtEmailAddress-$i'} . "' />";
							echo "</td>";
							echo "<td width='16%'>";
								echo "&nbsp;";
							echo "</td>";
						echo "</tr>";
						$i++;
					}
				}
			}
			?>
            </tbody>
		</table>
		<br />

		<br />
		<div style='text-align: center; padding: 10px; '><input type='submit' name='btnSubmit' value='<?php echo "Submit to the\r\nDatabase"; ?>' /></div>
		</form>
	<?php
	}

	else
		die ("Reference is not found.</body></html>");
	echo "</div>";
	echo "<br />";
	echo "<div style='text-align: center; background-color: #333333; margin: 0px auto 0px auto; padding: 20px; width: 1020px; border-radius: 15px; -moz-border-radius: 15px; -webkit-box-shadow: 15px; '>";
	echo "<div class='nav' style='font-weight: normal; color: white; font-size: 10pt; '><sup>©</sup>2009 - ".date('Y')." <span style='color: #99FF99; '>ScriptureEarth.org</span></div>";
	echo "</div>";
	$db->close();
?>

<?php
if (isset($GetName)) {
// Country Table switches from language names and ISO and vica versa
?>

<script type="text/javascript"> 
// Switch between Language Name or Language Code.
// This function NEEDS to be at the bottom or less $GetName will be undefined!
function Switch(number, Beg) {
	// GetName is the name of the country(ies)
	var GN = "<?php echo $GetName; ?>";
	Beg = (typeof Beg !== 'undefined' && Beg !== "") ? Beg : 'all';
	var which = '';
	$("#wait").css("display","block");
	if (number == 1) {
		document.getElementById('languageName').style.display = 'none';
		document.getElementById('languageCode').style.display = 'block';
		which = 'Code';
		Beg = Beg.toLowerCase();
	}
	else {
		document.getElementById('languageCode').style.display = 'none';
		document.getElementById('languageName').style.display = 'block';
		which = 'Name';
		if (Beg != 'all')
			Beg = Beg.toUpperCase();
	}

	// setup and execute 00z-BegList.php
	var ajaxCountryRequest;  // The variable that makes Ajax possible!
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxCountryRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxCountryRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxCountryRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				alert("Your browser cannot suppost AJAX!");
				return false;
			}
		}
	}
	ajaxCountryRequest.onreadystatechange=function() {
		if (ajaxCountryRequest.readyState==4 && ajaxCountryRequest.status==200) {
			if (Beg != 'all') {
				var response = ajaxCountryRequest.responseText.split("~||~");
				document.getElementById("CT").innerHTML=response[0];
				document.getElementById("Letters").innerHTML=response[1];
				document.getElementById("count").innerHTML=response[2];
			}
			else {
				if (GN != 'all')
					document.getElementById("CT").innerHTML=ajaxCountryRequest.responseText;
				else {
					var response = ajaxCountryRequest.responseText.split("~||~");
					document.getElementById("CT").innerHTML=response[0];
					document.getElementById("Letters").innerHTML=response[1];
					document.getElementById("count").innerHTML=response[2];
				}
			}
		}
	}
	ajaxCountryRequest.open("GET", "00-BegList.Edit.php?st=<?php echo $st; ?>&MajorLanguage=<?php echo $MajorLanguage; ?>&SpecificCountry=<?php echo $SpecificCountry; ?>&Scriptname=<?php echo $Scriptname; ?>&b=" + Beg + "&gn=" + GN + "&n="+number, true);
	ajaxCountryRequest.send(null);
	$("#wait").css("display","none");
}
</script>

<?php
}
?>

<script type="text/javascript" src="_js/CMS_events.js?v=1.0.3"></script>
</body>
</html>