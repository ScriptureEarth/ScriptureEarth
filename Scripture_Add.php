<?php
// Change PHP.ini from max_input_vars = 1000 to max_input_vars = 3000 because POST has to be set for 3000!

include './include/session.php';
global $session;
/* Login attempt */
$retval = $session->checklogin();
if (!$retval) {
	echo "<br /><div style='text-align: center; font-size: 16pt; font-weight: bold; padding: 10px; color: navy; background-color: #dddddd; '>You are not logged in!</div>";
	/* Link back to main */
	header('Location: login.php');
	exit;
}
// <input type='hidden'...> must be place underneath the form

/*************************************************************************************************************************************
*
* 			CAREFUL when your making any additions! Any "onclick", "change", etc. that occurs on "input", "a", "div", etc.
* 			should be placed in "_js/CMS_events.js". Also, in "_js/CMS_events.js" any errors in previous statements will
* 			not works in any of the satesments then on. It can also help in the Firefox browser (version 79.0+) run
* 			"Scripture_Edit.php", menu "Tools", "Web developement", and "Toggle Tools". Then menu "Debugger". In the left
* 			side of the windows click on "Scripture Add", Localhost", "_js", and "CMS_events.js". Look down the js file
* 			and find out if there are errors using the "underline" indicator and fix them if there are any. You can also
* 			use "Scripture_Add.php" just to make sure that the document.getElementById('...') name is corrent.
*			But, BE CAREFUL!
*
**************************************************************************************************************************************/

// To tie the script together and prevent direct access to Add_Lang_Validation.php and SumbitConfirmation.php.
define('RIGHT_ON', true);
 
// To hold error messages
$messages = [];
 
// Default input values (later, sanitized $_POST inputs)
$inputs = ['iso' => ''];

// Master list of languages for the site to run in
if (empty($_SESSION['nav_ln_array'])) {
	require_once './include/conn.inc.php';							// connect to the database named 'scripture'
	$db = get_my_db();
	$_SESSION['nav_ln_array'] = [];
	$query = "SELECT `translation_code`, `name`, `nav_fileName`, `ln_number`, `language_code`, `ln_abbreviation` FROM `translations` ORDER BY `ln_number`";
	$result_ln=$db->query($query) or die ('Query failed:  ' . $db->error . '</body></html>');
	if ($result_ln->num_rows == 0) {
		die ('<div style="background-color: white; color: red; font-size: 16pt; padding-top: 20px; padding-bottom: 20px; margin-top: 200px; ">' . translate('The translation_code is not found.', $st, 'sys') . '</div></body></html>');
	}

	while ($ln_row = $result_ln->fetch_array()){
		$ln_temp[0] = $ln_row['translation_code'];
		$ln_temp[1] = $ln_row['name'];
		$ln_temp[2] = $ln_row['nav_fileName'];
		$ln_temp[3] = $ln_row['ln_number'];
		$ln_temp[4] = $ln_row['ln_abbreviation'];
		$_SESSION['nav_ln_array'][$ln_row['language_code']] = $ln_temp;
	}

	$db->close();
}
 
// Checks that the form was submitted after Scripture_Add.php submitted.
if (isset($_POST['btnSubmit'])) {
	// Runs the validation script which only returns to the form page if validation fails.
	require_once 'Add_Lang_Validation.php';
	// Returns from Add_Lang_Validation.php if the validation failed.
}

// Debug for max_input_vars != 3000
// One method to prevent an SQL Injection Attack!

include ('./OT_Books.php');			// include the books of the OT
include ('./NT_Books.php');			// include the books of the NT
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type"				content="text/html; charset=utf-8">
<meta name="ObjectType" 					content="Document" />
<meta http-equiv="Window-target" 			content="_top" />
<meta name="Created-by" 					content="Scott Starker" />
<meta name="Updated-by"                     content="Scott Starker, Lærke Roager" />
<title>Scripture Add</title>
<link type="text/css" rel="stylesheet" href="_css/Scripture_Add.css" />
<script type="text/javascript" language="javascript" src="_js/Scripture_Add.js?v=1.0.3"></script>
<script type="text/javascript" language="javascript" src="_js/AddorChange.js?v=1.1.1"></script>
<script>
	//let ALNindex = 1;
	//let Otherindex = 1;
</script>
<!-- see the bottom of this html file for CMS_events.js -->
</head>
<body>

<div class='content' style='background-color: white; padding: 20px; width: 1020px; height: 100px; margin-left: auto; margin-right: auto; vertical-align: middle; border-radius: 15px; -moz-border-radius: 15px; -webkit-box-shadow: 15px; '>
		<img style='margin-left: 40px; ' src='images/guyReading.png' /><div style="text-align: center; margin-top: -60px; margin-left: 180px; font-size: 18pt; font-weight: bold; color: black; ">Add to the ScriptureEarth Database</div>
	</div><br />
	<div style='background-color: white; padding: 20px; width: 1020px; margin-left: auto; margin-right: auto; border-radius: 15px; -moz-border-radius: 15px; -webkit-box-shadow: 15px; '>
		<a style='float: right; font-size: small; font-weight: normal; vertical-align: bottom; margin: 10px 10px 0px 0px; ' href='process.php'>[Logout]</a>
		<a style='float: right; font-size: small; font-weight: normal; vertical-align: bottom; margin: 10px 10px 0px 0px; ' href='Scripture_Edit.php'>[Scripture Edit]</a>
		<br />
        
		<?php
			if (count($messages) > 0) {
				echo 'Please correct these errors:<br />';
				// Displays a list of error messages
				echo '<ul style="color: red"><li>'.implode('</li><li>', $messages).'</li></ul>';
			}
			echo "<br />";
		?>
		
		<form name='myForm' action='Scripture_Add.php' method='post'>
        <input type='hidden' name='rod' id='rod' value="<?php echo isset($rod) ? $rod : $rod = '00000' ?>" />
        <input type='hidden' name='variant' id='variant' value="<?php echo isset($var) ? $var : $var = '' ?>" />
        <!-- onBlur="ISOShow(this.value)" -->
        <!-- AJAX is here. -->
        <!-- showResult(this.value) in Scripture_Add.js -->
		<div class='enter' style='font-weight: bold; '>Enter the ISO Code: <input type="text" id="iso" name="iso" size="2" onKeyUp="showResult(this.value)" style="color: navy; font-weight: bold; font-size: 12pt; " value="<?php if (isset($_POST['iso'])) echo $_POST['iso'] ?>" /></div>
        <br /><br /><br /><div id="livesearch" style="display: none; "></div><br /><br />

<!-- /************************************************
	Countries
*************************************************/-->
        <div id="Countrys" name="Countrys">
		<div class='enter' style='clear: both; font-weight: bold; '>COUNTRIES</div>
			<table width="100%" cellpadding="0" cellspacing="0" name="tableEngCountries" id="tableEngCountries">
				<tr>
					<td width="53%">
						<span style='font-size: 10pt; '>In English, enter the <span style='font-size: 11pt; font-weight: bold; '>COUNTRY(IES)</span> in which the Language is indigenous:</span>
					</td>
					<td width="30%">
						<input type='text' name='Eng_country-1' id='Eng_country-1' size='60' value="<?php if (isset($_POST['Eng_country-1'])) echo $_POST['Eng_country-1'] ?>" />
					</td>
					<td width="17%" style="text-align: right; ">
						<input id="addRowTableCountry" style="font-size: 9pt; " type="button" value="Add" />
						<input id="removeRowTableCountry" style="font-size: 9pt; " type="button" value="Remove" />
					</td>
				</tr>
				<?php
					$i = 2;
					while (isset($_POST['Eng_country-'.(string)$i])) {
						echo "<tr>";
							echo "<td width='53%'>";
								echo "&nbsp;";
							echo "</td>";
							echo "<td width='30%'>";
								echo "<input type='text' name='Eng_country-$i' id='Eng_country-$i' style='color: navy; ' size='60' value='" . htmlentities($_POST['Eng_country-'.(string)$i], ENT_QUOTES) . "' />";
							echo "</td>";
							echo "<td width='17%'>";
								echo "&nbsp;";
							echo "</td>";
						echo "</tr>";
						$i++;
					}
				?>
			</table>
			<br /><br />
<!-- /*********************************************************************
	Specific Language Name for the navigational Language Names
***********************************************************************/-->
			<?php						// $array[1] = English, Chinese, etc.
			foreach ($_SESSION['nav_ln_array'] as $code => $array){
				$html = "<div class='MajorLang'>In <span>".strtoupper($array[1])."</span>, enter the Language Name: <input type='text' name='".$array[1]."_lang_name' id='".$array[1]."_lang_name' size='35' value=\"switch\" /></div>";
				if (isset($_POST[$array[1].'_lang_name'])){
					$result = str_replace('switch', $_POST[$array[1].'_lang_name'], $html);
				} else {
					$result = str_replace('switch', '', $html);
				}
				echo $result;
			} ?>
			<br />
<!-- /*********************************************************************
	default navigational Langauge
***********************************************************************/-->
			<p>Select the default navigational langauge <span style="font-size: 10pt; ">(i.e. the major language from above)</span>: 
			<select name="DefaultLang" id="DefaultLang">
				<?php					// $array[1] = English, Chinese, etc.
				foreach ($_SESSION['nav_ln_array'] as $code => $array){
					$html = '<option value="'.$array[1].'Lang" switch>'.$array[1].'</option>';
					if (isset($_POST['DefaultLang'])){
						if (substr($_POST['DefaultLang'], 0, -4) == $array[1]){
							$result = str_replace("switch", " selected='yes'", $html);
						} else {
							$result = str_replace("switch", "", $html);
						}
					} else {
						if ($code == "es"){
							$result = str_replace("switch", " selected='yes'", $html);
						} else {
							$result = str_replace("switch", "", $html);
						}
					}
					echo $result;
				} ?>
			</select>
			</p>
            <br />
<!-- /************************************************
	Alternate Language Name(s)
**************************************************/-->
			<table width="100%" cellpadding="0" cellspacing="0" name="tableAltNames" id="tableAltNames">
				<tr>
					<td width="53%">
						Enter the Alternate Language Name(s)<span style="font-size: 9pt; "><br />(only one Language Name per line)</span>:
					</td>
					<td width="26%">
						<input type='text' name='txtAltNames-1' id='txtAltNames-1' style='color: navy; ' size='50' onClick="ALNidx(1)" value="<?php if (isset($_POST['txtAltNames-1'])) echo htmlspecialchars($_POST['txtAltNames-1'], ENT_QUOTES, 'UTF-8'); ?>" />
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
					while (isset($_POST['txtAltNames-'.(string)$i])) {
						$alt_lang_name = $_POST['txtAltNames-'.(string)$i];
						$alt_lang_name = htmlspecialchars($alt_lang_name, ENT_QUOTES, 'UTF-8');
						echo "<tr>";
							echo "<td width='53%'>";
								echo "&nbsp;";
							echo "</td>";
							echo "<td width='26%'>";
								echo "<input type='text' name='txtAltNames-$i' id='txtAltNames-$i' style='color: navy; ' size='50' onclick='ALNidx($i)' value='" . $alt_lang_name . "' />";
							echo "</td>";
							echo "<td width='21%' colspan='2'>";
								echo "&nbsp;";
							echo "</td>";
						echo "</tr>";
						$i++;
					}
				?>
			</table>

            <br /><br />
            <input type='radio' name='GroupAdd' value='AddNo' checked <?php if (isset($_POST['GroupAdd'])) echo ($_POST['GroupAdd'] == 'AddNo' ? ' checked' : '') ?> /> No "The Bible In" or "The Scripture In".<br />
            <input type='radio' name='GroupAdd' value='AddTheBibleIn' <?php if (isset($_POST['GroupAdd'])) echo ($_POST['GroupAdd'] == 'AddTheBibleIn' ? ' checked' : '') ?> /> "The Bible In" added to the specific name of the language on the top of the screen.<br />
            <input type='radio' name='GroupAdd' value='AddTheScriptureIn' <?php if (isset($_POST['GroupAdd'])) echo ($_POST['GroupAdd'] == 'AddTheScriptureIn' ? ' checked' : '') ?> /> "The Scripture In" added to the specific name of the language on the top of the screen.<br />
        </div>

		<br /><br />

		<?php
/************************************************
	isop
*************************************************/
		echo 'What is the isoP code for this minority language if it needs one (&ldquo;<span style="color: navy; font-weight: bold; ">[ISO Code]</span>&rdquo; plus 4 maximum capital letters or numbers)?&nbsp;';
		if (isset($_POST['isopText'])) {
			?>
			<input type='text' style='color: navy; ' size='6' name='isopText' id='isopText' value="<?php if (isset($_POST['isopText'])) echo $_POST['isopText']; else echo ''; ?>" />
			<?php
		}
		else {
			?>
			<input type='text' style='color: navy; ' size='6' name='isopText' id='isopText' value='' />
			<?php
		}
        ?>

		<br /><br />
        <hr align="center" width="90%" color="#0066CC" />
        <br />
        
		<?php
/************************************************
	Whole Bible PDF and complete Scripture publication PDF
*************************************************/
		?>
		<div class='enter'>Enter the PDF file name of the whole Bible in this language: <input type='text' name='whole_Bible' id='whole_Bible' size='35' value="<?php if (isset($_POST['whole_Bible'])) echo $_POST['whole_Bible'] ?>" /></div>
        <br />
        
		<div class='enter'><span style='font-size: 11pt; '>Enter the PDF file name of the complete Scripture publication (although NOT the OT nor NT) in this language: </span><input type='text' name='complete_Scripture' id='complete_Scripture' size='35' value="<?php if (isset($_POST['complete_Scripture'])) echo $_POST['complete_Scripture'] ?>" /></div>
		
		<br />
        <hr align="center" width="90%" color="#0066CC" />
        <br />

		<?php
/************************************************
	OT and NT PDFs
*************************************************/
		?>
		<div class='enter'>Enter the PDF file name of the OT in this language: <input type='text' name='OT_name' id='OT_name' size='35' value="<?php if (isset($_POST['OT_name'])) echo $_POST['OT_name'] ?>" /></div>
		<br />
		<input type='hidden' name='OT_PDF_Button' id='OT_PDF_Button' value='No' />
        <div id='OT_Off_Books'>		<!-- The id has to the same because of function classChange in AddorChange.js! -->
			<input type='button' id='Open_OT_PDFs' value='Open OT PDFs' /> Are there any of the books in the Old Testament in PDF?<br />
		</div>
        <div class='enter' id='OT_Books'>		<!-- The id has to the same because of function classChange in AddorChange.js! -->
			<input type='button' id='Close_OT_PDF' value='Close OT PDFs' /> Here are the books that occur in the Old Testament in PDF:<br />
			<input type='button' id='OT_PDF_Books' value='All PDF OT Books' /><span style='font-size: 10pt; font-weight: bold; '> Enter the PDF filename for Genesis and click on this button to have all of the rest of the OT filled in.</span><br />
			<input type='button' id='No_OT_PDF_Books' value='No PDF OT Books' /><span style='font-size: 10pt; font-weight: bold; '> Delete the PDF filename for Genesis and click on this button to have none of the rest of the OT deleted.</span>
			<br />
			<div id='All_OT_Books_Div'>
				<div id='None_OT_Books_Div'>
					<table id='OT_PDF_Table' width='100%'>
						<?php
							for ($i = 0; $i < 39; $i++) {
								$item_from_array = $OT_array[2][$i];
								if ($i % 2)
									$color = 'ffffff';
								else
									$color = 'f0f4f0';
								echo "<tr style='background-color: #$color;'><td width='30%'>";
								echo "&nbsp;&nbsp;<input type='checkbox' name='OT_PDF_Book-$i' id='OT_PDF_Book-$i'" . (isset($_POST['OT_PDF_Book-'.(string)$i]) ? ' checked' : '') . " />&nbsp;$item_from_array";
								echo "</td><td width='70%'>";
								echo "PDF filename:&nbsp;<input type='text' name='OT_PDF_Filename-$i' id='OT_PDF_Filename-$i' size='50' value='" . (isset($_POST['OT_PDF_Filename-'.(string)$i]) ? $_POST['OT_PDF_Filename-'.(string)$i] : '') . "' />";
								echo "</td></tr>";
							}
							echo "<tr valign='bottom' style='background-color: #fff;'><td width='30%'>";
							echo '<br />';
							echo "&nbsp;&nbsp;<input type='checkbox' name='OT_PDF_appendix' id='OT_PDF_appendix'" . (isset($_POST['OT_PDF_appendix']) ? ' checked' : '') . " />&nbsp;OT Appendix";
							echo '</td><td width="70%">';
							echo "PDF filename:&nbsp;<input type='text' name='OT_PDF_Filename_appendix' id='OT_PDF_Filename_appendix' size='50' value='" . (isset($_POST['OT_PDF_Filename_appendix']) ? $_POST['OT_PDF_Filename_appendix'] : '') . "' />";
							echo '</td></tr>';
							echo "<tr valign='bottom' style='background-color: #f0f4f0;'><td width='30%'>";
							echo "&nbsp;&nbsp;<input type='checkbox' name='OT_PDF_glossary' id='OT_PDF_glossary'" . (isset($_POST['OT_PDF_glossary']) ? ' checked' : '') . " />&nbsp;OT Glossary";
							echo '</td><td width="70%">';
							echo "PDF filename:&nbsp;<input type='text' name='OT_PDF_Filename_glossary' id='OT_PDF_Filename_glossary' size='50' value='" . (isset($_POST['OT_PDF_Filename_glossary']) ? $_POST['OT_PDF_Filename_glossary'] : '') . "' />";
							echo '</td></tr>';
						?>
					</table>
				</div>
			</div>
		</div>
        
        <br />

        <div class='enter'>Enter the PDF file name of the NT in this language: <input type='text' name='NT_name' id='NT_name' size='35' value="<?php if (isset($_POST['NT_name'])) echo $_POST['NT_name'] ?>" /></div>
		<br />
		<input type='hidden' name='PDF_Button' id='PDF_Button' value='No' />
        <div id='NT_Off_Books'>		<!-- The id has to the same because of function classChange in AddorChange.js! -->
			<input type='button' id='Open_NT_PDFs' value='Open NT PDFs' zonclick="classChange('NT_Books', 'DisplayBlock', 'PDF_Button'); " /> Are there any of the books in the New Testament in PDF?<br />
		</div>
        <div class='enter' id='NT_Books'>		<!-- The id has to the same because of function classChange in AddorChange.js! -->
			<input type='button' id='Close_NT_PDF' value='Close NT PDFs' /> Here are the books that ocurr in the New Testament in PDF:<br />
			<input type='button' id='NT_PDF_Books' value='All PDF NT Books' /><span style='font-size: 10pt; font-weight: bold; '> Enter the PDF filename for Matthew and click on this button to have all of the rest of the NT filled in.</span><br />
			<input type='button' id='No_NT_PDF_Books' value='No PDF NT Books' /><span style='font-size: 10pt; font-weight: bold; '> Delete the PDF filename for Matthew and click on this button to have none of the rest of the NT deleted.</span>
			<br />
			<div id='All_Books_Div'>
				<div id='None_Books_Div'>
					<table id='NT_PDF_Table' width='100%'>
						<?php
							for ($i = 0; $i < 27; $i++) {
								$item_from_array = $NT_array[2][$i];
								if ($i % 2)
									$color = 'ffffff';
								else
									$color = 'f0f4f0';
								echo "<tr style='background-color: #$color;'><td width='30%'>";
								echo "&nbsp;&nbsp;<input type='checkbox' name='NT_PDF_Book-$i' id='NT_PDF_Book-$i'" . (isset($_POST['NT_PDF_Book-'.(string)$i]) ? ' checked' : '') . " />&nbsp;$item_from_array";
								echo '</td><td width="70%">';
								echo "PDF filename:&nbsp;<input type='text' name='NT_PDF_Filename-$i' id='NT_PDF_Filename-$i' size='50' value='" . (isset($_POST['NT_PDF_Filename-'.(string)$i]) ? $_POST['NT_PDF_Filename-'.(string)$i] : '') . "' />";
								echo '</td></tr>';
							}
							echo "<tr valign='bottom' style='background-color: #fff;'><td width='30%'>";
							echo '<br />';
							echo "&nbsp;&nbsp;<input type='checkbox' name='NT_PDF_appendix' id='NT_PDF_appendix'" . (isset($_POST['NT_PDF_appendix']) ? ' checked' : '') . " />&nbsp;NT Appendix";
							echo '</td><td width="70%">';
							echo "PDF filename:&nbsp;<input type='text' name='NT_PDF_Filename_appendix' id='NT_PDF_Filename_appendix' size='50' value='" . (isset($_POST['NT_PDF_Filename_appendix']) ? $_POST['NT_PDF_Filename_appendix'] : '') . "' />";
							echo '</td></tr>';
							echo "<tr valign='bottom' style='background-color: #f0f4f0;'><td width='30%'>";
							echo "&nbsp;&nbsp;<input type='checkbox' name='NT_PDF_glossary' id='NT_PDF_glossary'" . (isset($_POST['NT_PDF_glossary']) ? ' checked' : '') . " />&nbsp;NT Glossary";
							echo "</td><td width='70%'>";
							echo "PDF filename:&nbsp;<input type='text' name='NT_PDF_Filename_glossary' id='NT_PDF_Filename_glossary' size='50' value='" . (isset($_POST['NT_PDF_Filename_glossary']) ? $_POST['NT_PDF_Filename_glossary'] : '') . "' />";
							echo '</td></tr>';
						?>
					</table>
				</div>
			</div>
		</div>

		<br />
        <hr align="center" width="90%" color="#0066CC" />
        <br />

		<?php
/************************************************
	OT and NT audio
*************************************************/
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
							for ($i = 0; $i < 39; $i++) {
								$item_from_array = $OT_array[2][$i];
								$item2_from_array = $OT_array[1][$i];
								echo "<tr style='vertical-align: top; '>";
								echo "<td width='10%' style='padding: 12px; '>";
								echo "&nbsp;$item_from_array:<br />";
								//echo "<input style='font-size: 8pt; ' type='button' id='OT_Audio_On-$i' value='Click On' onclick='Audio_On_Or_Off(\"table3-$i\", true)' />";
								//echo "&nbsp;&nbsp;<input style='font-size: 8pt; ' type='button' id='OT_Audio_None-$i' value='Click Off' onclick='Audio_On_Or_Off(\"table3-$i\", false)' /><br />";
								if ($item2_from_array > 1) {
									echo "<input style='font-size: 8pt; ' type='button' id='One_OT_Audio_Chapters-$i' value='Audio OT Chapters in $item_from_array' onclick='One_OT_Audio_Chapters($i)' />";
									echo "<br /><span style='font-size: 8pt; '>Enter the audio filename for $item_from_array chapter 1 and click on this button to have all of the rest of $item_from_array filled in.</span>";
								}
								echo '</td>';
								echo "<td width='90%' style='line-height: 18px; padding: 12px; '>";
								//echo "table3-$i<br />";
								echo "<table id='OT_Audio_Table3-$i' width='100%'>";
								echo '<tr>';
								for ($z = 0; $z < $item2_from_array; $z++) {
									if (($z % 3) == 0 && $z != 0) {
										echo '</tr><tr>';
									}
									$y = $z + 1;
									echo "<td width='10%'>";
									// $item_from_array_$y doesn't work. The only thing you get is the number!
									echo "<input style='font-size: 9pt; ' type='checkbox' name='OT_Audio_Index-$i-$z' id='OT_Audio_Index-$i-$z'" . (isset($_POST['OT_Audio_Index-'.(string)$i.'-'.(string)$z]) ? ' checked' : '') . " /><span style='font-size: 9pt; ' >&nbsp;$y&nbsp;</span>";
									echo "</td><td width='20%'>";
									echo "<input style='font-size: 9pt; text-align: left; ' type='text' onclick='document.getElementById(\"OT_Audio_Index-$i-$z\").checked = true;' name='OT_Audio_Filename-$i-$z' id='OT_Audio_Filename-$i-$z' size='19' value='" . ( isset($_POST['OT_Audio_Filename-'.(string)$i.'-'.(string)$z]) ? $_POST['OT_Audio_Filename-'.(string)$i.'-'.(string)$z] : '' ) . "' />";
									echo '</td>';
								}
								if (($z % 3) != 0) {
									$y = 0;
									while ((($z + $y) % 3) != 0) {
										echo "<td width='10%'>&nbsp;</td>";
										echo "<td width='20%'>&nbsp;</td>";
										$y++;
									}
								}
								echo '</tr></table>';
								echo '</td></tr>';
							}
						?>
					</table>
				</div>
			</div>
		</div>
		<br />
		<input type='hidden' name='Audio_Button' id='Audio_Button' value='No' />
        <div id='NT_Off_Audio'>		<!-- The id has to the same because of function classChange in AddorChange.js! -->
			<input type='button' id='Open_NT_audio' value='Open NT audio' /> Are there any of the books in the New Testament in audio (mp3) by chapter?<br />
		</div>
        <div class='enter' id='NT_Audio'>		<!-- The id has to the same because of function classChange in AddorChange.js! -->
			<input type='button' id="Close_NT_audio" value="Close NT audio" /> Here are the books in the New Testament in audio (mp3) by chapters:<br />
			<input type='button' id='NT_Audio_Chapters' value='All Audio NT Chapters' /><span style='font-size: 9pt; font-weight: bold; '> Enter the audio filename for Matthew chapter 1 and click on this button to have all of the rest of the NT filled in.</span><br />
			<input type='button' id='No_NT_Audio_Chapters' value='No Audio NT Chapters' /><span style='font-size: 9pt; font-weight: bold; '> Delete the audio filename for Genesis chapter 1 and click on this button to have none of the rest of the OT deleted.</span>
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
									// $item_from_array_$y doesn't work. The only thing you get is the number!
									echo "<input style='font-size: 9pt; ' type='checkbox' name='NT_Audio_Index-$i-$z' id='NT_Audio_Index-$i-$z'" . (isset($_POST['NT_Audio_Index-'.(string)$i.'-'.(string)$z]) ? ' checked' : '') . " /><span style='font-size: 9pt; ' >&nbsp;$y&nbsp;</span>";
									echo "</td><td width='20%'>";
									echo "<input style='font-size: 9pt; text-align: left; ' type='text' onclick='document.getElementById(\"NT_Audio_Index-$i-$z\").checked = true;' name='NT_Audio_Filename-$i-$z' id='NT_Audio_Filename-$i-$z' size='19' value='" . ( isset($_POST['NT_Audio_Filename-'.(string)$i.'-'.(string)$z]) ? $_POST['NT_Audio_Filename-'.(string)$i.'-'.(string)$z] : '' ) . "' />";
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

/************************************************
	SAB - Scriture Apps Buidler (table SAB) HTML
*************************************************/
		?>
					</table>
				</div>
			</div>
		</div>
        
		<br />
        <hr align="center" width="90%" color="#0066CC" />
        <br />
        
        <div>Synchronized text and audio (Scripture Apps Builder) HTMLs:</div>
		<table valign="bottom" style="margin-top: 10px; " cellpadding="0" cellspacing="0" width="100%">
        <thead>
			<tr valign="bottom" style="color: navy; font-size: 8pt; line-height: 10pt; ">
				<td width="13%">&nbsp;
				</td>
				<td width="13%" style="padding-left: 3px; ">
					subfolder under 'sab' <span style="font-weight: bold; font-size: 9pt; ">AND</span><br />all of the HTML files that go<br />under the subfolder
				</td>
				<td width="32%" style="padding-left: 3px; ">
					URL <i>(URL or subfolder)</i>
				</td>
				<td width="42%" colspan="2" style="padding-left: 3px; ">
					Description <i>(optional)</i>
				</td>
			</tr>
		</thead>
		<tbody name="tableSABHTMLAdd" id="tableSABHTMLAdd">
			<tr valign="bottom" style="line-height: 10pt; ">
				<td width="13%" style="font-size: 10pt; ">
					<div style="margin-top: 10px; ">Enter "SAB HTMLs":</div>For example:
				</td>
				<td width="13%">
					<input type='text' style='color: navy; ' size='15' name='txtSABsubfolderAdd-1' id='txtSABsubfolderAdd-1' value="<?php if (isset($_POST['txtSABsubfolderAdd-1'])) echo $_POST['txtSABsubfolderAdd-1']; ?>" />
                    <br /><span style="font-size: 10pt; margin-left: 3px; ">tuo or tuoB or tuo2019</span>
				</td>
				<td width="32%">
					<input type='text' style='color: navy; ' size='41' name='txtSABurlAdd-1' id='txtSABurlAdd-1' value="<?php if (isset($_POST['txtSABurlAdd-1'])) echo $_POST['txtSABurlAdd-1']; ?>" />
                    <span style="font-size: 10pt; margin-left: 1px; ">https://...</span>
				</td>
				<td width="22%">
					<input type='text' style='color: navy; ' size='41' name='txtSABdescriptionAdd-1' id='txtSABdescriptionAdd-1' value="<?php if (isset($_POST['txtSABdescriptionAdd-1'])) echo $_POST['txtSABdescriptionAdd-1']; ?>" />
                    <br /><span style="font-size: 10pt; margin-left: 1px; ">- Brazil or version 2019</span>
				</td>
                <td width="20%" style="text-align: right; vertical-align: top; ">
                    <input id='addSABHTMLAdd' style="font-size: 9pt; " onClick="addRowToTableSABHTMLAdd()" type="button" value="Add" />
                    <input id='removeSABHTMLAdd' style="font-size: 9pt; " onClick="removeRowFromTable('tableSABHTMLAdd')" type="button" value="Remove" />
                </td>
			</tr>
            <?php
			$i = 2;
			while (isset($_POST['txtSABsubfolderAdd-'.(string)$i])) {
				echo "<tr valign='bottom' style='line-height: 10pt; '>";
					echo "<td width='13%' style='font-size: 10pt; '>&nbsp;";
					echo '</td>';
					echo "<td width='13%'>";
						echo "<input type='text' style='color: navy; ' size='15' name='txtSABsubfolderAdd-$i' id='txtSABsubfolderAdd-$i' value='" . $_POST['txtSABsubfolderAdd-' . (string)$i] . "' />";
					echo "</td>";
					echo '<td width="32%">';
						echo "<input type='text' style='color: navy; ' size='41' name='txtSABurlAdd-$i' id='txtSABurlAdd-$i' value='" . $_POST['txtSABurlAdd-' . (string)$i] . "' />";
					echo '</td>';
					echo '<td width="22%">';
						echo "<input type='text' style='color: navy; ' size='41' name='txtSABdescriptionAdd-$i' id='txtSABdescriptionAdd-$i' value='" . $_POST['txtSABdescriptionAdd-' . (string)$i] . "' />";
					echo '</td>';
                	echo "<td width='20%'>";
						echo "&nbsp;";
					echo "</td>";
				echo "</tr>";
				$i++;
            }
            ?>
        </tbody>
		</table>
        <br />

		<?php
/************************************************
	Bible.is
*************************************************/
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
        else {
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
					<div style="margin-top: 10px; ">Enter "Bible.is":</div>For example:
				</td>
				<td width="40%">
					<input type='text' style='color: navy; ' size='54' name='txtLinkBibleIsURL-1' id='txtLinkBibleIsURL-1' value="<?php if (isset($_POST['txtLinkBibleIsURL-1'])) echo $_POST['txtLinkBibleIsURL-1']; ?>" />
                    <br /><span style="font-size: 10pt; margin-left: 3px; ">https://live.bible.is/bible/[FCBH code]/[book]/[chapter]</span>
				</td>
				<td width="24%">
					<input type='text' style='color: navy; ' size='30' name='txtLinkBibleIsTitle-1' id='txtLinkBibleIsTitle-1' value="<?php if (isset($_POST['txtLinkBibleIsTitle-1'])) echo $_POST['txtLinkBibleIsTitle-1']; ?>" />
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
                        <option value="BibleIsDefault-1" <?php echo ( isset($_POST['BibleIsDefault-1']) ? ($_POST['BibleIsDefault-1'] == 1 ? " selected='selected'" : "") : '' ) ?>>Default</option>
                        <option value="BibleIsText-1" <?php echo ( isset($_POST['BibleIsText-1']) ? ($_POST['BibleIsText-1'] == 2 ? " selected='selected'" : "") : '' ) ?>>Text</option>
                        <option value="BibleIsAudio-1" <?php echo ( isset($_POST['BibleIsAudio-1']) ? ($_POST['BibleIsAudio-1'] == 3 ? " selected='selected'" : "") : '' ) ?>>Audio</option>
                        <option value="BibleIsVideo-1" <?php echo ( isset($_POST['BibleIsVideo-1']) ? ($_POST['BibleIsVideo-1'] == 4 ? " selected='selected'" : "") : '' ) ?>>Video</option>
                    </select>
                    <br /><span style="font-size: 10pt; margin-left: 1px; ">Video</span>
				</td>
                <td width="17%" style="text-align: right; vertical-align: top; ">
                    <input id='addBibleIs' style="font-size: 9pt; " type="button" value="Add" />
                    <input id='removeBibleIs' style="font-size: 9pt; " type="button" value="Remove" />
                </td>
			</tr>
            <?php
			$i = 2;
			while (isset($_POST['txtLinkBibleIsURL-'.(string)$i])) {
				echo "<tr valign='bottom' style='line-height: 10pt; '>";
					echo "<td width='11%' style='font-size: 10pt; '>&nbsp;";
					echo '</td>';
					echo "<td width='40%'>";
						echo "<input type='text' style='color: navy; ' size='49' name='txtLinkBibleIsURL-$i' id='txtLinkBibleIsURL-$i' value='" . $_POST['txtLinkBibleIsURL-' . (string)$i] . "' />";
					echo "</td>";
					echo '<td width="24%">';
						echo "<input type='text' style='color: navy; ' size='47' name='txtLinkBibleIsTitle-$i' id='txtLinkBibleIsTitle-$i' value='" . $_POST['txtLinkBibleIsTitle-' . (string)$i] . "' />";
					echo '</td>';
						echo "<td width='8%'>";
						//echo "<input type='text' name='txtLinkBibleIs-$i' id='txtLinkBibleIs-$i' style='color: navy; ' size='11' value='" . ( isset($_POST['txtLinkBibleIs-'.(string)$i]) ? $_POST['txtLinkBibleIs-'.(string)$i] : '' ) . "' />";
						if ($_POST['BibleIsDefault-'.(string)$i] == 'BibleIsDefault-'.$i) ${'BibleIsDefault-$i'}=1; else ${'BibleIsDefault-$i'}=0;
						if ($_POST['BibleIsText-'.(string)$i] == 'BibleIsText-'.$i) ${'BibleIsText-$i'}=2; else ${'BibleIsText-$i'}=0;
						if ($_POST['BibleIsAudio-'.(string)$i] == 'BibleIsAudio-'.$i) ${'BibleIsAudio-$i'}=3; else ${'BibleIsAudio-$i'}=0;
						if ($_POST['BibleIsVideo-'.(string)$i] == 'BibleIsVideo-'.$i) ${'BibleIsVideo-$i'}=4; else ${'BibleIsVideo-$i'}=0;
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
            ?>
        </tbody>
		</table>
        <br />

		<?php
/************************************************
	Bible.is Gospel Film
*************************************************/
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
		?>
		<tbody name="tableBibleIsGospelFilm" id="tableBibleIsGospelFilm">
			<tr valign="bottom" style="line-height: 10pt; ">
				<td width="11%" style="font-size: 10pt; ">
					<div style="margin-top: 10px; ">Enter "Bible.is Gospel Film":</div>For example:
				</td>
				<td width="40%">
					<input type='text' style='color: navy; ' size='54' name='txtLinkBibleIsGospelFilmURL-1' id='txtLinkBibleIsGospelFilmURL-1' value="<?php if (isset($_POST['txtLinkBibleIsGospelFilmURL-1'])) echo $_POST['txtLinkBibleIsGospelFilmURL-1']; ?>" />
					<br /><span style="font-size: 10pt; margin-left: 3px; ">https://www.youtube.com/playlist?list=[Google address]</span>
				</td>
				<td width="32%">
					<input type='text' style='color: navy; ' size='30' name='txtLinkBibleIsGospel-1' id='txtLinkBibleIsGospel-1' value="<?php if (isset($_POST['txtLinkBibleIsGospel-1'])) echo $_POST['txtLinkBibleIsGospel-1']; ?>" />
					<br /><span style="font-size: 10pt; margin-left: 1px; "> - Gospel of [which Gospel]</span>
				</td>
				<td width="17%" style="text-align: right; vertical-align: top; ">
					<input id='addBibleIsGospelFilm' style="font-size: 9pt; " type="button" value="Add" />
					<input id='removeBibleIsGospelFilm' style="font-size: 9pt; " type="button" value="Remove" />
				</td>
			</tr>
			<?php
			$i = 2;
			while (isset($_POST['txtLinkBibleIsGospelFilmURL-'.(string)$i])) {
				echo "<tr valign='bottom' style='line-height: 10pt; '>";
					echo "<td width='11%' style='font-size: 10pt; '>&nbsp;";
					echo '</td>';
					echo "<td width='40%'>";
						echo "<input type='text' style='color: navy; ' size='53' name='txtLinkBibleIsGospelFilmURL-$i' id='txtLinkBibleIsGospelFilmURL-$i' value='" . $_POST['txtLinkBibleIsGospelFilmURL-' . (string)$i] . "' />";
					echo "</td>";
					echo '<td width="32%">';
						echo "<input type='text' style='color: navy; ' size='30' name='txtLinkBibleIsGospel-$i' id='txtLinkBibleIsGospel-$i' value='" . $_POST['txtLinkBibleIsGospel-' . (string)$i] . "' />";
					echo '</td>';
					echo "<td width='17%'>";
						echo "&nbsp;";
					echo "</td>";
				echo "</tr>";
				$i++;
			}
			?>
		</tbody>
		</table>
		<br />

		<?php
/************************************************
	YouVersion - Read
*************************************************/
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
                        URL Link
                    </td>
                    <td width="19%">&nbsp;
                    </td>
                </tr>
            </thead>
            <tbody id="tableYouVersion" name="tableYouVersion">
                <tr valign="top" style="line-height: 10pt; ">
                    <td width="14%" style="font-size: 10pt; ">
                        <div style="margin-top: 10px; ">Enter "YouVersion":</div>For example:
                    </td>
                    <td width="12%">
                        <input type='text' style='color: navy; ' size='13' name='txtLinkYouVersionName-1' id='txtLinkYouVersionName-1' value="<?php if (isset($_POST['txtLinkYouVersionName-1'])) echo $_POST['txtLinkYouVersionName-1']; ?>" />
                        <br /><span style="font-size: 10pt; ">Read on</span>
                    </td>
                    <td width="11%">
                        <input type='text' style='color: navy; ' size='20' name='txtLinkYouVersionTitle-1' id='txtLinkYouVersionTitle-1' value="<?php if (isset($_POST['txtLinkYouVersionTitle-1'])) echo $_POST['txtLinkYouVersionTitle-1']; ?>" />
                        <br /><span style="font-size: 10pt; margin-left: 1px; ">YouVersion.com</span>
                    </td>
                    <td width="44%">
                        <input type='text' style='color: navy; ' size='60' name='txtLinkYouVersionURL-1' id='txtLinkYouVersionURL-1' value="<?php if (isset($_POST['txtLinkYouVersionURL-1'])) echo $_POST['txtLinkYouVersionURL-1']; ?>" />
                        <br /><span style="font-size: 10pt; margin-left: 3px; ">https://www.bible.com/bible/[YouVersion code]/[book].[chp]</span>
                    </td>
                    <td width="19%" style="text-align: right; vertical-align: top; ">
                        <input style="font-size: 9pt; " type="button" id='addYouVer' value="Add" />
                        <input style="font-size: 9pt; " type="button" id='removeYouVer' value="Remove" />
                    </td>
                </tr>
			<?php
            $i = 2;
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
                        URL Link
                    </td>
                    <td width="19%">&nbsp;
                    </td>
                </tr>
            </thead>
            <tbody id="tableBiblesorg" name="tableBiblesorg">
                <tr valign="top" style="line-height: 10pt; ">
                    <td width="14%" style="font-size: 10pt; ">
                        <div style="margin-top: 10px; ">Enter "Bibles.org":</div>For example:
                    </td>
                    <td width="12%">
                        <input type='text' style='color: navy; ' size='13' name='txtLinkBiblesorgName-1' id='txtLinkBiblesorgName-1' value="<?php if (isset($_POST['txtLinkBiblesorgName-1'])) echo $_POST['txtLinkBiblesorgName-1']; ?>" />
                        <br /><span style="font-size: 10pt; ">Study on</span>
                    </td>
                    <td width="11%">
                        <input type='text' style='color: navy; ' size='20' name='txtLinkBiblesorgTitle-1' id='txtLinkBiblesorgTitle-1' value="<?php if (isset($_POST['txtLinkBiblesorgTitle-1'])) echo $_POST['txtLinkBiblesorgTitle-1']; ?>" />
                        <br /><span style="font-size: 10pt; margin-left: 1px; ">Bibles.org</span>
                    </td>
                    <td width="44%">
                        <input type='text' style='color: navy; ' size='60' name='txtLinkBiblesorgURL-1' id='txtLinkBiblesorgURL-1' value="<?php if (isset($_POST['txtLinkBiblesorgURL-1'])) echo $_POST['txtLinkBiblesorgURL-1']; ?>" />
                        <br /><span style="font-size: 10pt; margin-left: 3px; ">https://www.Bibles.org/[Bibles.org code]/[book]/[chp]</span>
                    </td>
                    <td width="19%" style="text-align: right; vertical-align: top; ">
                        <input style="font-size: 9pt; " type="button" id='addBiblesorg' value="Add" />
                        <input style="font-size: 9pt; " type="button" id='removeBiblesorg' value="Remove" />
                    </td>
                </tr>
			<?php
            $i = 2;
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
			?>
            </tbody>
		</table>
		<br />
        
		<?php
/*************************************************
	GRN
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
                        URL Link
                    </td>
                    <td width="19%">&nbsp;
                    </td>
                </tr>
            </thead>
            <tbody id="tableGRN" name="tableGRN">
                <tr valign="top" style="line-height: 10pt; ">
                    <td width="14%" style="font-size: 10pt; ">
                        <div style="margin-top: 10px; ">Enter "GRN":</div>For example:
                    </td>
                    <td width="11%">
                        <input type='text' style='color: navy; ' size='20' name='txtLinkGRNTitle-1' id='txtLinkGRNTitle-1' value="<?php if (isset($_POST['txtLinkGRNTitle-1'])) echo $_POST['txtLinkGRNTitle-1']; ?>" />
                        <br /><span style="font-size: 10pt; margin-left: 1px; ">Audio recordings</span>
                    </td>
                    <td width="12%">
                        <input type='text' style='color: navy; ' size='13' name='txtLinkGRNName-1' id='txtLinkGRNName-1' value="<?php if (isset($_POST['txtLinkGRNName-1'])) echo $_POST['txtLinkGRNName-1']; ?>" />
                        <br /><span style="font-size: 10pt; ">Global Recordings Network</span>
                    </td>
                    <td width="44%">
                        <input type='text' style='color: navy; ' size='60' name='txtLinkGRNURL-1' id='txtLinkGRNURL-1' value="<?php if (isset($_POST['txtLinkGRNURL-1'])) echo $_POST['txtLinkGRNURL-1']; ?>" />
                        <br /><span style="font-size: 10pt; margin-left: 3px; ">https://globalrecordings.net/en/language/[GRN code]</span>
                    </td>
                    <td width="19%" style="text-align: right; vertical-align: top; ">
                        <input style="font-size: 9pt; " type="button" id="addGRN" value="Add" />
                        <input style="font-size: 9pt; " type="button" id="removeGRN" value="Remove" />
                    </td>
                </tr>
			<?php
            $i = 2;
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
			?>
            </tbody>
		</table>
		<br /><br />
        
		<?php
/************************************************
	checkbox for viewer
*************************************************/
		?>
        <input type='checkbox' name='viewer' id='viewer' <?php echo (isset($_POST['viewer']) ? ' checked' : '') ?> /> Does this language have the Study online viewer (USFM) files?<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		
        <input type='text' style='color: navy; ' size='3' name='viewerText' id='viewerText' value="<?php if (isset($_POST['viewerText'])) echo $_POST['viewerText']; else echo ''; ?>" />
		&nbsp;<span style='font-size: 10pt; '>Rarely used. Only when there is more the 1 ROD Code and Variant code with the same ISO code. In order to use this, the letter(s) before the ".sfm" in this text box
        indicate which files are to be used for this collection. For example, you enter a "W" in the text box you will then have to put a "W" in all of the filenames before the extension
        (i.e., 41-MATaoj.sfm to 41-MATaoj<span style="color: red; ">W</span>.sfm)</span>
        <br /><br />

		<?php
/************************************************
	checkbox for right-to-left
*************************************************/
		?>
        &nbsp;&nbsp;&nbsp;&nbsp;<input type='checkbox' name='rtl' id='rtl' <?php echo (isset($_POST['rtl']) ? ' checked' : '') ?> /> Is the language right-to-left? (Only for "Study online viewer".)
		<br /><br />

		<?php
/************************************************
	cell phones
*************************************************/
		?>
		<table valign="bottom" cellpadding="0" cellspacing="0" width="100%">
          <thead style='text-align: left; vertical-align: bottom; '>
			<tr valign="bottom" style="color: navy; font-size: 8pt; line-height: 11pt; height: 30px; ">
				<td width="19%">&nbsp;
				</td>
				<td width="16%">
					<span style="padding-left: 3px; ">Cell Phone Title</span>
				</td>
				<td width="23%"style="padding-left: 3px; ">
					Cell Phone Filename
				</td>
				<td width="23%"style="padding-left: 3px; ">
					<i>Optional info if needed</i>
				</td>
				<td width="19%">&nbsp;
				</td>
			</tr>
		  </thead>
        <?php
		if (isset($_POST['txtCellPhoneFile-1'])) {
			if ($_POST['txtCellPhoneTitle-1'] == 'CPJava-1') $_POST['CPJava-1']=1;
			if ($_POST['txtCellPhoneTitle-1'] == 'CPAndroid-1') $_POST['CPAndroid-1']=1;
			if ($_POST['txtCellPhoneTitle-1'] == 'CPiPhone-1') $_POST['CPiPhone-1']=1;
			//if ($_POST['txtCellPhoneTitle-1'] == 'CPWindows-1') $_POST['CPWindows-1']=1;
			//if ($_POST['txtCellPhoneTitle-1'] == 'CPBlackberry-1') $_POST['CPBlackberry-1']=1;
			//if ($_POST['txtCellPhoneTitle-1'] == 'CPStandard-1') $_POST['CPStandard-1']=1;
			if ($_POST['txtCellPhoneTitle-1'] == 'CPAndroidApp-1') $_POST['CPAndroidApp-1']=1;
			if ($_POST['txtCellPhoneTitle-1'] == 'CPiOSAssetPackage-1') $_POST['CPiOSAssetPackage-1']=1;
		}
		?>
		<tbody name="tableCellPhone" id="tableCellPhone">
			<tr valign="bottom" style="line-height: 10pt; ">
				<td width="19%">
					<span style="font-size: 10pt; ">Enter Cell Phone<br />Module:</span>
				</td>
				<td width="16%">
					<!--input type='text' style='color: navy; ' size='39' name='txtCellPhoneTitle-1' id='txtCellPhoneTitle-1' value="< ?php if (isset($_POST['txtCellPhoneTitle-1'])) echo $_POST['txtCellPhoneTitle-1']; ?>" /-->
                    <!--br /><span style="font-size: 10pt; "></span-->
                    <!--
                        GoBible (Java)
                        MySword (Android)
                        iPhone
                        Windows
                        Blackberry
                        Standard Cell Phone
                        Android App
                        Apple App
                    -->
                    <select name="txtCellPhoneTitle-1" id="txtCellPhoneTitle-1" style='color: navy; '>
                        <option value="CPJava-1" <?php echo ( isset($_POST['CPJava-1']) ? ($_POST['CPJava-1'] == 1 ? " selected='selected'" : "") : '' ) ?>>GoBible (Java)</option>
                        <option value="CPAndroid-1" <?php echo ( isset($_POST['CPAndroid-1']) ? ($_POST['CPAndroid-1'] == 1 ? " selected='selected'" : "") : '' ) ?>>MySword (Android)</option>
                        <option value="CPiPhone-1" <?php echo ( isset($_POST['CPiPhone-1']) ? ($_POST['CPiPhone-1'] == 1 ? " selected='selected'" : "") : '' ) ?>>iPhone</option>
                        <!--option value="CPWindows-1" < ?php echo ( isset($_POST['CPWindows-1']) ? ($_POST['CPWindows-1'] == 1 ? " selected='selected'" : "") : '' ) ?>>Windows</option-->
                        <!--option value="CPBlackberry-1" < ?php echo ( isset($_POST['CPBlackberry-1']) ? ($_POST['CPBlackberry-1'] == 1 ? " selected='selected'" : "") : '' ) ?>>Blackberry</option-->
                        <!--option value="CPStandard-1" < ?php echo ( isset($_POST['CPStandard-1']) ? ($_POST['CPStandard-1'] == 1 ? " selected='selected'" : "") : '' ) ?>>Standard Cell Phone</option-->
                        <option value="CPAndroidApp-1" <?php echo ( isset($_POST['CPAndroidApp-1']) ? ($_POST['CPAndroidApp-1'] == 1 ? " selected='selected'" : "") : " selected='selected'") ?>>Android App (apk)</option>
                        <option value="CPiOSAssetPackage-1" <?php echo ( isset($_POST['CPiOSAssetPackage-1']) ? ($_POST['CPiOSAssetPackage-1'] == 1 ? " selected='selected'" : "") : ('CPiOSAssetPackage-1' == 1 ? " selected='selected'" : '' ) ) ?>>iOS Asset Package</option>
                    </select>
                    <br /><span style="font-size: 10pt; ">&nbsp;GoBible (Java)</span>
				</td>
				<td width="23%">
					<input type='text' style='color: navy; ' size='35' name='txtCellPhoneFile-1' id='txtCellPhoneFile-1' value="<?php if (isset($_POST['txtCellPhoneFile-1'])) echo $_POST['txtCellPhoneFile-1']; ?>" />
                    <br /><span style="font-size: 10pt; ">&nbsp;zzzNT.jar</span>
				</td>
				<td width="23%">
					<input type='text' style='color: navy; ' size='35' name='txtCellPhoneOptional-1' id='txtCellPhoneOptional-1' value="<?php if (isset($_POST['txtCellPhoneOptional-1'])) echo $_POST['txtCellPhoneOptional-1']; ?>" />
                    <br /><span style="font-size: 10pt; ">&nbsp;</span>
				</td>
				<td width="19%" style="text-align: right; vertical-align: top; ">
					<input style="font-size: 9pt; " type="button" id="addCell" value="Add" />
					<input style="font-size: 9pt; " type="button" id="removeCell" value="Remove" />
				</td>
			</tr>
			<?php
            $i = 2;
            while (isset($_POST['txtCellPhoneFile-'.(string)$i])) {
                echo "<tr valign='bottom' style='line-height: 10pt; '>";
                    echo "<td width='19%'>";
                        echo "&nbsp;";
                    echo "</td>";
                    echo "<td width='16%'>";
						if ($_POST['txtCellPhoneTitle-'.(string)$i] == 'CPJava-'.$i) ${'CPJava-$i'}=1; else ${'CPJava-$i'}=0;
						if ($_POST['txtCellPhoneTitle-'.(string)$i] == 'CPAndroid-'.$i) ${'CPAndroid-$i'}=1; else ${'CPAndroid-$i'}=0;
						if ($_POST['txtCellPhoneTitle-'.(string)$i] == 'CPiPhone-'.$i) ${'CPiPhone-$i'}=1; else ${'CPiPhone-$i'}=0;
						if ($_POST['txtCellPhoneTitle-'.(string)$i] == 'CPAndroidApp-'.$i) ${'CPAndroidApp-$i'}=1; else ${'CPAndroidApp-$i'}=0;
						if ($_POST['txtCellPhoneTitle-'.(string)$i] == 'CPiOSAssetPackage-'.$i) ${'CPiOSAssetPackage-$i'}=1; else ${'CPiOSAssetPackage-$i'}=0;
						?>
          				<select name="txtCellPhoneTitle-<?php echo $i ?>" id="txtCellPhoneTitle-<?php echo $i ?>" style='color: navy; '>
                            <option value="CPJava-<?php echo $i ?>" <?php echo ( isset($_POST['CPJava-'.(string)$i]) ? ($_POST['CPJava-'.(string)$i] == 1 ? " selected='selected'" : '') : (${'CPJava-$i'}==1 ? " selected='selected'" : '' ) ) ?>>GoBible (Java)</option>
                            <option value="CPAndroid-<?php echo $i ?>" <?php echo ( isset($_POST['CPAndroid-'.(string)$i]) ? ($_POST['CPAndroid-'.(string)$i] == 1 ? " selected='selected'" : '') : (${'CPAndroid-$i'}==1 ? " selected='selected'" : '' ) ) ?>>MySword (Android)</option>
                            <option value="CPiPhone-<?php echo $i ?>" <?php echo ( isset($_POST['CPiPhone-'.(string)$i]) ? ($_POST['CPiPhone-'.(string)$i] == 1 ? " selected='selected'" : '') : (${'CPiPhone-$i'}==1 ? " selected='selected'" : '' ) ) ?>>iPhone</option>
                            <option value="CPAndroidApp-<?php echo $i ?>" <?php echo ( isset($_POST['CPAndroidApp-'.(string)$i]) ? ($_POST['CPAndroidApp-'.(string)$i] == 1 ? " selected='selected'" : '') : (${'CPAndroidApp-$i'}==1 ? " selected='selected'" : '' ) ) ?>>Android App (apk)</option>
                            <option value="CPiOSAssetPackage-<?php echo $i ?>" <?php echo ( isset($_POST['CPiOSAssetPackage-'.(string)$i]) ? ($_POST['CPiOSAssetPackage-'.(string)$i] == 1 ? " selected='selected'" : '') : (${'CPiOSAssetPackage-$i'}==1 ? " selected='selected'" : '' ) ) ?>>iOS Asset Package</option>
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
/************************************************
	Watch/View
*************************************************/
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
				<td width="6%" style="padding-left: 3px; text-align: center; ">JESUS Film</td>
				<td width="4%" style="padding-left: 3px; text-align: center; ">YouTube</td>
				<td width='16%'>&nbsp;</td>
			</tr>
		</thead>
		<tbody name="tableWatch" id="tableWatch">
			<tr valign="bottom" style="line-height: 10pt; ">
				<td width="15%">
					<span style="font-size: 9pt; ">Enter “Watches”:</span><br /><span style="font-size: 8pt; ">(one line per Watch)</span>
                    <br /><span style="font-size: 10pt; ">For example:</span>
				</td>
				<td width="20%">
					<input type='text' style='color: navy; ' size='26' name='txtWatchWebSource-1' id='txtWatchWebSource-1' value="<?php if (isset($_POST['txtWatchWebSource-1'])) echo $_POST['txtWatchWebSource-1'] ?>" />
                    <br /><span style="font-size: 10pt; ">Inspirational Films</span>
				</td>
				<td width="20%">
					<input type='text' style='color: navy; ' size='26' name='txtWatchResource-1' id='txtWatchResource-1' value="<?php if (isset($_POST['txtWatchResource-1'])) echo $_POST['txtWatchResource-1'] ?>" />
                    <br /><span style="font-size: 10pt; ">View the JESUS Film</span>
				</td>
				<td width="19%">
					<input type='text' style='color: navy; ' size='29' name='txtWatchURL-1' id='txtWatchURL-1' value="<?php if (isset($_POST['txtWatchURL-1'])) echo $_POST['txtWatchURL-1'] ?>" />
                    <br /><span style="font-size: 9pt; ">https://media.inspirationalfilms.com?id=...</span>
				</td>
				<td width="6%" style='text-align: center; '>
					<input type='checkbox' style='color: navy; ' name='txtWatchJesusFilm-1' id='txtWatchJesusFilm-1' <?php if (isset($_POST['txtWatchJesusFilm-1'])) echo 'checked="checked"' ?> />
                    <br /><span style="font-size: 10pt; font-family: 'Times New Roman'; ">&#9745;</span>
   				</td>
				<td width="4%" style='text-align: center;'>
					<input type='checkbox' style='color: navy; margin-right: 10px; ' name='txtWatchYouTube-1' id='txtWatchYouTube-1' <?php if (isset($_POST['txtWatchYouTube-1'])) echo 'checked="checked"' ?> />
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
				while (isset($_POST['txtWatchWebSource-'.(string)$i]) || isset($_POST['txtWatchResource-'.(string)$i]) || isset($_POST['txtWatchURL-'.(string)$i])) {
					echo "<tr valign='bottom' style='line-height: 10pt; '>";
						echo "<td width='15%'>";
							echo "&nbsp;";
						echo "</td>";
						echo "<td width='20%'>";
							echo "<input type='text' name='txtWatchWebSource-$i' id='txtWatchWebSource-$i' style='color: navy; ' size='26' value='" . ( isset($_POST['txtWatchWebSource-'.(string)$i]) ? $_POST['txtWatchWebSource-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='20%'>";
							echo "<input type='text' name='txtWatchResource-$i' id='txtWatchResource-$i' style='color: navy; ' size='26' value='" . ( isset($_POST['txtWatchResource-'.(string)$i]) ? $_POST['txtWatchResource-'.(string)$i] : '' ) . "' />";
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
/************************************************
	Studies -- theWord
*************************************************/
			?>
        </tbody>
		</table>
		<br />

		<table valign="bottom" cellpadding="0" cellspacing="0" width="100%">
       	  <thead style='text-align: left; vertical-align: bottom; '>
			<tr valign="bottom" style="color: navy; font-size: 8pt; line-height: 7pt; height: 30px; ">
				<td width="100px">&nbsp;
				</td>
				<td width="113px" style="padding-left: 3px; padding-bottom: 5px; ">
					Scripture<br />Description
				</td>
                <td width="132px" style="padding-left: 3px; padding-bottom: 5px; ">
                	Which<br />Testament?
                </td>
                <td width="156px" style="padding-left: 3px; padding-bottom: 5px; ">
                	Which<br />alphabet?
                </td>
				<td width="82px" style="padding-left: 3px; padding-bottom: 5px; ">
					Scripture<br />URL
				</td>
				<td width="113px" style="padding-left: 3px; padding-bottom: 5px; ">
					Statement<br />between the two
				</td>
				<td width="61px" style="padding-left: 3px; padding-bottom: 5px; ">
					Other Website<br />Description
				</td>
                <td width='116px' style="padding-left: 3px; padding-bottom: 5px; ">
                	Other Website URL
                </td>
                <td width='145px'>&nbsp;
                	
                </td>
			</tr>
		</thead>
        <?php
		if (isset($_POST['txtScriptureDescription-1'])) {
			if ($_POST['txtTestament-1'] == 'SNT-1') $_POST['SNT-1']=1;
			if ($_POST['txtTestament-1'] == 'SOT-1') $_POST['SOT-1']=1;
			if ($_POST['txtTestament-1'] == 'SBible-1') $_POST['SBible-1']=1;
			if ($_POST['txtAlphabet-1'] == 'SStandAlphabet-1') $_POST['SStandAlphabet-1']=1;
			if ($_POST['txtAlphabet-1'] == 'STradAlphabet-1') $_POST['STradAlphabet-1']=1;
			if ($_POST['txtAlphabet-1'] == 'SNewAlphabet-1') $_POST['SNewAlphabet-1']=1;
		}
		?>
		<tbody name="tableStudy" id="tableStudy">
			<tr valign="bottom" style="line-height: 10pt; vertical-align: top; ">
				<td width="100px">
					<span style="font-size: 10pt; ">Enter&nbsp;Studies:</span><br /><span style="font-size: 7pt; ">(one line per Study)</span>
                    <br /><span style="font-size: 10pt; ">For&nbsp;example:</span>
				</td>
				<td width="113px">
					<input type='text' style='color: navy; ' size='14' name='txtScriptureDescription-1' id='txtScriptureDescription-1' value="<?php if (isset($_POST['txtScriptureDescription-1'])) echo $_POST['txtScriptureDescription-1'] ?>" />
                    <br /><span style="font-size: 8pt; ">Download New<br />Testament</span>
				</td>
				<td width="132px">
                    <!--
                    	New Testament
                        Old Testament
                        Bible
                    -->
                    <select name="txtTestament-1" id="txtTestament-1" style='color: navy; '>
                        <option value="SNT-1" <?php if (isset($_POST['SNT-1'])) echo ($_POST['SNT-1'] == 1 ? " selected='selected'" : ""); ?>>New Testament</option>
                        <option value="SOT-1" <?php if (isset($_POST['SOT-1'])) echo ($_POST['SOT-1'] == 1 ? " selected='selected'" : ""); ?>>Old Testament</option>
                        <option value="SBible-1" <?php if (isset($_POST['SBible-1'])) echo ($_POST['SBible-1'] == 1 ? " selected='selected'" : ""); ?>>Bible</option>
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
                        <option value="SStandAlphabet-1" <?php if (isset($_POST['SStandAlphabet-1'])) echo ($_POST['SStandAlphabet-1'] == 1 ? " selected='selected'" : ""); ?>>Standard alphabet</option>
                        <option value="STradAlphabet-1" <?php if (isset($_POST['STradAlphabet-1'])) echo ($_POST['STradAlphabet-1'] == 1 ? " selected='selected'" : ""); ?>>Traditional alphabet</option>
                        <option value="SNewAlphabet-1" <?php if (isset($_POST['SNewAlphabet-1'])) echo ($_POST['SNewAlphabet-1'] == 1 ? " selected='selected'" : ""); ?>>New alphabet</option>
                    </select>
                    <br /><span style="font-size: 10pt; ">Standard alphabet</span>
				</td>
				<td width="82px">
					<input type='text' style='color: navy; ' size='6' name='txtScriptureURL-1' id='txtScriptureURL-1' value="<?php if (isset($_POST['txtScriptureURL-1'])) echo $_POST['txtScriptureURL-1'] ?>" />
                    <br /><span style="font-size: 10pt; ">zzz.zz.exe</span>
				</td>
				<td width="113px">
					<input type='text' style='color: navy; ' size='13' name='txtStatement-1' id='txtStatement-1' value="<?php if (isset($_POST['txtStatement-1'])) echo $_POST['txtStatement-1'] ?>" />
                    <br /><span style="font-size: 7pt; ">for use with the Bible study software</span>
				</td>
				<td width="61px">
					<input type='text' style='color: navy; ' size='5' name='txtOthersiteDescription-1' id='txtOthersiteDescription-1' value="<?php if (isset($_POST['txtOthersiteDescription-1'])) echo $_POST['txtOthersiteDescription-1'] ?>" />
                    <br /><span style="font-size: 10pt; ">The Word</span>
				</td>
				<td width="116px">
					<input type='text' style='color: navy; ' size='14' name='txtOthersiteURL-1' id='txtOthersiteURL-1' value="<?php if (isset($_POST['txtOthersiteURL-1'])) echo $_POST['txtOthersiteURL-1'] ?>" />
                    <br /><span style="font-size: 8pt; ">https://www.theword.gr/...</span>
				</td>
				<td width="145px" style="text-align: right; ">
					<input style="font-size: 9pt; " type="button" id="addStudy" value="Add" />
                    <input style="font-size: 9pt; " type="button" id="removeStudy" value="Remove" />
                    <br /><span style="font-size: 10pt; ">&nbsp;</span>
				</td>
			</tr>
			<?php
				$i = 2;
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
							echo '<select name="txtTestament-'.(string)$i.'" id="txtTestament-'.(string)$i.'" style="color: navy; ">';
								echo "<option value='SNT-$i'"; if (isset($_POST['SNT-'.(string)$i])) echo ($_POST['SNT-'.(string)$i] == 1 ? " selected='selected'" : ""); echo ">New Testament</option>";
								echo "<option value='SOT-$i'"; if (isset($_POST['SOT-'.(string)$i])) echo ($_POST['SOT-'.(string)$i] == 1 ? " selected='selected'" : ""); echo ">Old Testament</option>";
								echo "<option value='SBible-$i'"; if (isset($_POST['SBible-'.(string)$i])) echo ($_POST['SBible-'.(string)$i] == 1 ? " selected='selected'" : ""); echo ">Bible</option>";
							echo "</select>";
						   echo "<br /><span style='font-size: 10pt; '>New Testament</span>";
						echo "</td>";
						echo "<td width='156px'>";
							if ($_POST['txtAlphabet-'.(string)$i] == 'SStandAlphabet-'.$i) ${'SStandAlphabet-$i'}=1; else ${'SStandAlphabet-$i'}=0;
							if ($_POST['txtAlphabet-'.(string)$i] == 'STradAlphabet-'.$i) ${'STradAlphabet-$i'}=1; else ${'STradAlphabet-$i'}=0;
							if ($_POST['txtAlphabet-'.(string)$i] == 'SNewAlphabet-'.$i) ${'SNewAlphabet-$i'}=1; else ${'SNewAlphabet-$i'}=0;
							echo "<select name='txtAlphabet-".(string)$i."' id='txtAlphabet-".(string)$i."' style='color: navy; '>";
								echo "<option value='SStandAlphabet-$i'"; if (isset($_POST['SStandAlphabet-'.(string)$i])) echo ($_POST['SStandAlphabet-'.(string)$i] == 1 ? " selected='selected'" : ""); echo ">Standard alphabet</option>";
								echo "<option value='STradAlphabet-$i'"; if (isset($_POST['STradAlphabet-'.(string)$i])) echo ($_POST['STradAlphabet-'.(string)$i] == 1 ? " selected='selected'" : ""); echo ">Traditional alphabet</option>";
								echo "<option value='SNewAlphabet-$i'"; if (isset($_POST['SNewAlphabet-'.(string)$i])) echo ($_POST['SNewAlphabet-'.(string)$i] == 1 ? " selected='selected'" : ""); echo ">New alphabet</option>";
							echo "</select>";
							echo "<br /><span style='font-size: 10pt; '>Standard alphabet</span>";
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
/************************************************
	Other books
*************************************************/
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
		<tbody valign="top" name="tableOtherBooks" id="tableOtherBooks">
			<tr valign="bottom" style="line-height: 10pt; ">
				<td width="15%">
					<span style="font-size: 9pt; ">(one line per Other Book)</span><br /><span style="font-size: 10pt; ">For example:</span>
				</td>
				<td width="13%">
					<input type='text' size='17' name='txtOther-1' id='txtOther-1' value="<?php if (isset($_POST['txtOther-1'])) echo $_POST['txtOther-1'] ?>" />
                    <br /><span style="font-size: 10pt; ">OT Selections</span>
				</td>
				<td width="13%">
					<input type='text' size='18' name='txtOtherTitle-1' id='txtOtherTitle-1' value="<?php if (isset($_POST['txtOtherTitle-1'])) echo $_POST['txtOtherTitle-1'] ?>" />
                    <br /><span style="font-size: 7pt; ">Selections from the Old Testament</span>
				</td>
				<td width="13%">
					<input type='text' size='18' name='txtOtherPDF-1' id='txtOtherPDF-1' value="<?php if (isset($_POST['txtOtherPDF-1'])) echo $_POST['txtOtherPDF-1'] ?>" />
                    <br /><span style="font-size: 10pt; ">00-POTzzz-web.pdf</span>
				</td>
				<td width="13%">
					<input type='text' size='18' name='txtOtherAudio-1' id='txtOtherAudio-1' value="<?php if (isset($_POST['txtOtherAudio-1'])) echo $_POST['txtOtherAudio-1'] ?>" />
                    <br /><span style="font-size: 10pt; ">&nbsp;</span>
				</td>
				<td width="13%">
					<input type='text' size='18' name='txtDownload_video-1' id='txtDownload_video-1' value="<?php if (isset($_POST['txtDownload_video-1'])) echo $_POST['txtDownload_video-1'] ?>" />
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
				while (isset($_POST['txtOther-'.(string)$i]) || isset($_POST['txtOtherTitle-'.(string)$i]) || isset($_POST['txtOtherPDF-'.(string)$i]) || isset($_POST['txtOtherAudio-'.(string)$i])) {
					echo "<tr>";
						echo "<td width='15%'>";
							echo "&nbsp;";
						echo "</td>";
						echo "<td width='13%'>";
							echo "<input type='text' name='txtOther-$i' id='txtOther-$i' style='color: navy; ' size='17' value='" . ( isset($_POST['txtOther-'.(string)$i]) ? $_POST['txtOther-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='13%'>";
							echo "<input type='text' name='txtOtherTitle-$i' id='txtOtherTitle-$i' style='color: navy; ' size='18' value='" . ( isset($_POST['txtOtherTitle-'.(string)$i]) ? $_POST['txtOtherTitle-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='13%'>";
							echo "<input type='text' name='txtOtherPDF-$i' id='txtOtherPDF-$i' style='color: navy; ' size='18' value='" . ( isset($_POST['txtOtherPDF-'.(string)$i]) ? $_POST['txtOtherPDF-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='13%'>";
							echo "<input type='text' name='txtOtherAudio-$i' id='txtOtherAudio-$i' style='color: navy; ' size='18' value='" . ( isset($_POST['txtOtherAudio-'.(string)$i]) ? $_POST['txtOtherAudio-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='13%'>";
							echo "<input type='text' name='txtDownload_video-$i' id='txtDownload_video-$i' style='color: navy; ' size='18' value='" . ( isset($_POST['txtDownload_video-'.(string)$i]) ? $_POST['txtDownload_video-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='20%' colspan='2'>";
							echo "&nbsp;";
						echo "</td>";
					echo "</tr>";
					$i++;
				}
/************************************************
	Buy
*************************************************/
			?>
        </tbody>
		</table>
		<br />		
		
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
				<td width="41%" colspan="2" style="padding-left: 3px; ">
					URL Link
				</td>
			</tr>
		</thead>
		<tbody name="tableBuy" id="tableBuy">
			<tr valign="bottom" style="line-height: 10pt; ">
				<td width="13%">
					<span style="font-size: 10pt; ">Enter Buy:</span><br /><span style="font-size: 8pt; ">(one line per Buy)</span>
                    <br /><span style="font-size: 10pt; ">For example:</span>
				</td>
				<td width="22%">
					<input type='text' style='color: navy; ' size='28' name='txtBuyWebSource-1' id='txtBuyWebSource-1' value="<?php if (isset($_POST['txtBuyWebSource-1'])) echo $_POST['txtBuyWebSource-1'] ?>" />
                    <br /><span style="font-size: 10pt; ">Virtual Storehouse</span>
				</td>
				<td width="22%">
					<input type='text' style='color: navy; ' size='28' name='txtBuyResource-1' id='txtBuyResource-1' value="<?php if (isset($_POST['txtBuyResource-1'])) echo $_POST['txtBuyResource-1'] ?>" />
                    <br /><span style="font-size: 10pt; ">New Testament</span>
				</td>
				<td width="27%">
					<input type='text' style='color: navy; ' size='34' name='txtBuyURL-1' id='txtBuyURL-1' value="<?php if (isset($_POST['txtBuyURL-1'])) echo $_POST['txtBuyURL-1'] ?>" />
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
				while (isset($_POST['txtBuyWebSource-'.(string)$i]) || isset($_POST['txtBuyResource-'.(string)$i]) || isset($_POST['txtBuyURL-'.(string)$i])) {
					echo "<tr>";
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
							echo "<input type='text' name='txtBuyURL-$i' id='txtBuyURL-$i' style='color: navy; ' size='34 value='" . ( isset($_POST['txtBuyURL-'.(string)$i]) ? $_POST['txtBuyURL-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='16%'>";
							echo "&nbsp;";
						echo "</td>";
					echo "</tr>";
					$i++;
				}
/************************************************
	Links
*************************************************/
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
		if (isset($_POST['txtLinkCompany-1'])) {
			if ($_POST['linksIcon-1'] == 'linksOther-1') $_POST['linksOther-1']=1; else $_POST['linksOther-1']=0;
			//if ($_POST['linksIcon-1'] == 'linksBuy-1') $_POST['linksBuy-1']=1; else  $_POST['linksBuy-1']=0;
			if ($_POST['linksIcon-1'] == 'linksMap-1') $_POST['linksMap-1']=1; else $_POST['linksMap-1']=0;
			if ($_POST['linksIcon-1'] == 'linksGooglePlay-1') $_POST['linksGooglePlay-1']=1; else $_POST['linksGooglePlay-1']=0;
		}
		else {
			${'linksOther-1'}=0;
			//${'linksBuy'}=0;
			${'linksMap-1'}=1;
			${'linksGooglePlay-1'}=0;
		}
		$i=1;
		// 12/3/19 - Joshua Project
		//${'linksMap-1'}=1;
		?>
		<tbody name="tableLinks" id="tableLinks">
			<tr valign="bottom" style="line-height: 10pt; ">
				<td width="12%">
					<span style="font-size: 10pt; ">Enter Links:</span><br /><span style="font-size: 8pt; ">(one line per Link)</span>
                    <br /><span style="font-size: 10pt; ">For example:</span>
				</td>
				<td width="21%">
					<!--input type='text' style='color: navy; ' size='25' name='txtLinkCompanyTitle-1' id='txtLinkCompanyTitle-1' value="< ?php if (isset($_POST['txtLinkCompanyTitle-1'])) echo $_POST['txtLinkCompanyTitle-1'] ?>" /-->
					<input type='text' style='color: navy; ' size='25' name='txtLinkCompanyTitle-1' id='txtLinkCompanyTitle-1' value="language map" />
                    <br /><span style="font-size: 10pt; ">language of Brazil</span>
				</td>
				<td width="21%">
					<!--input type='text' style='color: navy; ' size='25' name='txtLinkCompany-1' id='txtLinkCompany-1' value="< ?php if (isset($_POST['txtLinkCompany-1'])) echo $_POST['txtLinkCompany-1'] ?>" /-->
					<input type='text' style='color: navy; ' size='25' name='txtLinkCompany-1' id='txtLinkCompany-1' value="Joshua Project" />
                    <br /><span style="font-size: 10pt; ">Google map</span>
				</td>
				<td width="22%">
					<!--input type='text' style='color: navy; ' size='27' name='txtLinkURL-1' id='txtLinkURL-1' value="< ?php if (isset($_POST['txtLinkURL-1'])) echo $_POST['txtLinkURL-1'] ?>" /-->
					<input type='text' style='color: navy; ' size='27' name='txtLinkURL-1' id='txtLinkURL-1' value="https://joshuaproject.net/languages/" />
                    <br /><span style="font-size: 9pt; ">https://maps.google.com/maps/...</span>
				</td>
				<td width="8%">
                    <div style="text-align: left; ">
                        <select name="linksIcon-1" id="linksIcon-1" style='color: navy; '>
							<?php
							/*
							<option value="linksOther-1" <?php echo ( isset($_POST['linksOther-1']) ? ($_POST['linksOther-1'] == 1 ? " selected='selected'" : '') : (${'linksOther-1'}==1 ? " selected='selected'" : '' ) ) ?>>Other</option>
							<option value="linksMap-1" <?php echo ( isset($POST['linksMap-1']) ? ($_POST['linksMap-1'] == 1 ? " selected='selected'" : '') : (${'linksMap-1'}==1 ? " selected='selected'" : '' ) ) ?>>Map</option>
							<option value="linksGooglePlay-1" <?php echo ( isset($_POST['linksGooglePlay-1']) ? ($_POST['linksGooglePlay-1'] == 1 ? " selected='selected'" : '') : (${'linksGooglePlay-1'}==1 ? " selected='selected'" : '' ) ) ?>>Google Play</option>
							*/
							if (isset($_POST['linksIcon-1'])) {
								if ($_POST['linksIcon-1'] == 'linksOther-1') ${'linksOther-1'}=1; else ${'linksOther-1'}=0;
								if ($_POST['linksIcon-1'] == 'linksMap-1') ${'linksMap-1'}=1; else ${'linksMap-1'}=0;
								if ($_POST['linksIcon-1'] == 'linksGooglePlay-1') ${'linksGooglePlay-1'}=1; else ${'linksGooglePlay-1'}=0;
							}
							else {
								${'linksIcon-1'} = 'linksMap-1';
								${'linksOther-1'} = 0;
								${'linksMap-1'} = 1;
								${'linksGooglePlay-1'} = 0;
							}
							?>	
							<option value="linksOther-1" <?php echo ( isset($_POST['linksIcon-1']) ? ($_POST['linksOther-1'] == 1 ? " selected='selected'" : '') : '') ?>>Other</option>
							<option value="linksMap-1" <?php echo ( isset($_POST['linksIcon-1']) ? ($_POST['linksMap-1'] == 1 ? " selected='selected'" : '') : " selected='selected'" ) ?>>Map</option>
							<option value="linksGooglePlay-1" <?php echo ( isset($_POST['linksIcon-1']) ? ($_POST['linksGooglePlay-1'] == 1 ? " selected='selected'" : '') : '' ) ?>>Google Play</option>
                       </select>
                    </div>
                    <span style="font-size: 10pt; ">&nbsp;&nbsp;Map</span>
                </td>
				<td width="16%" style="text-align: right; ">
					<input style="font-size: 9pt; " type="button" id="addLinks" value="Add" />
					<input style="font-size: 9pt; " type="button" id="removeLinks" value="Remove" />
                    <br /><span style="font-size: 10pt; ">&nbsp;</span>
				</td>
			</tr>
			<?php
			$i=2;
			while (isset($_POST['txtLinkCompany-'.(string)$i]) || isset($_POST['txtLinkCompanyTitle-'.(string)$i]) || isset($_POST['txtLinkURL-'.(string)$i])) {
				echo "<tr>";
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
						<div style="text-align: left; ">
							<select name="linksIcon-<?php echo $i ?>" id="linksIcon-<?php echo $i ?>" style='color: navy; '>
								<option value="linksOther-<?php echo $i ?>" <?php echo ( isset($_POST['linksOther-'.(string)$i]) ? ($_POST['linksOther-'.(string)$i] == 1 ? " selected='selected'" : '') : (${'linksOther-$i'}==1 ? " selected='selected'" : '' ) ) ?>>Other</option>
								<!--option value="linksBuy-< ?php echo $i ?>" < ?php echo ( isset($_POST['linksBuy-'.(string)$i]) ? ($_POST['linksBuy-'.(string)$i] == 1 ? " selected='selected'" : '') : (${'linksBuy-$i'}==1 ? " selected='selected'" : '' ) ) ?>>Buy</option-->
								<option value="linksMap-<?php echo $i ?>" <?php echo ( isset($_POST['linksMap-'.(string)$i]) ? ($_POST['linksMap-'.(string)$i] == 1 ? " selected='selected'" : '') : (${'linksMap-$i'}==1 ? " selected='selected'" : '' ) ) ?>>Map</option>
								<option value="linksGooglePlay-<?php echo $i ?>" <?php echo ( isset($_POST['linksGooglePlay-'.(string)$i]) ? ($_POST['linksGooglePlay-'.(string)$i] == 1 ? " selected='selected'" : '') : (${'linksGooglePlay-$i'}==1 ? " selected='selected'" : '' ) ) ?>>Google Play</option>
							</select>
						</div>
						<?php
					echo "</td>";
					echo "<td width='16%'>";
						echo "&nbsp;";
					echo "</td>";
				echo "</tr>";
				$i++;
			}
/************************************************
	Audio Playlist mp3s
*************************************************/
			?>
        </tbody>
		</table>
		<br />
		
		<table valign="bottom" cellpadding="0" cellspacing="0" width="100%">
       	  <thead style='text-align: left; vertical-align: bottom; '>
			<tr valign="bottom" style="color: navy; font-size: 8pt; line-height: 7pt; height: 30px; ">
				<td width="13%">&nbsp;
				</td>
				<td width="30%" style="padding-left: 3px; ">
                	Listen "to title on the screen"
				</td>
				<td width="41%" style="padding-left: 3px; ">
					txt filename
				</td>
				<td width="16%">&nbsp;
				</td>
			</tr>
          </thead>
          <tbody name="tableAudioPlaylist" id="tableAudioPlaylist">
			<tr valign="bottom" style="line-height: 10pt; ">
				<td width="13%">
					<span style="font-size: 10pt; ">Enter audio playlist:</span>
                    <br /><span style="font-size: 10pt; ">For example:</span>
				</td>
				<td width="30%">
					<input type='text' style='color: navy; ' size='40' name='txtPlaylistAudioTitle-1' id='txtPlaylistAudioTitle-1' value="<?php if (isset($_POST['txtPlaylistAudioTitle-1'])) echo $_POST['txtPlaylistAudioTitle-1'] ?>" />
                    <br /><span style="font-size: 10pt; ">Old Testament Summary</span>
				</td>
				<td width="41%">
					<input type='text' style='color: navy; ' size='60' name='txtPlaylistAudioFilename-1' id='txtPlaylistAudioFilename-1' value="<?php if (isset($_POST['txtPlaylistAudioFilename-1'])) echo $_POST['txtPlaylistAudioFilename-1'] ?>" />
                    <br /><span style="font-size: 9pt; ">OTS-audio-[ISO code].txt</span>
				</td>
				<td width="16%" style="text-align: right; ">
					<input style="font-size: 9pt; " type="button" id="addPLAudio" value="Add" />
					<input style="font-size: 9pt; " type="button" id="removePLAudio" value="Remove" />
                    <br /><span style="font-size: 10pt; ">&nbsp;</span>
				</td>
			</tr>
			<?php
				$i = 2;
				while (isset($_POST['txtPlaylistAudioTitle-'.(string)$i]) || isset($_POST['txtPlaylistAudioFilename-'.(string)$i])) {
					echo "<tr>";
						echo "<td width='13%'>";
							echo "&nbsp;";
						echo "</td>";
						echo "<td width='30%'>";
							echo "<input type='text' name='txtPlaylistAudioTitle-$i' id='txtPlaylistAudioTitle-$i' style='color: navy; ' size='40' value='" . ( isset($_POST['txtPlaylistAudioTitle-'.(string)$i]) ? $_POST['txtPlaylistAudioTitle-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='41%'>";
							echo "<input type='text' name='txtPlaylistAudioFilename-$i' id='txtPlaylistAudioFilename-$i' style='color: navy; ' size='60 value='" . ( isset($_POST['txtPlaylistAudioFilename-'.(string)$i]) ? $_POST['txtPlaylistAudioFilename-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='16%'>";
							echo "&nbsp;";
						echo "</td>";
					echo "</tr>";
					$i++;
				}
/************************************************
	Video Playlist mp3s
*************************************************/
			?>
		</table>
		<br />
		
		<table valign="bottom" cellpadding="0" cellspacing="0" width="100%">
       	  <thead style='text-align: left; vertical-align: bottom; '>
			<tr valign="bottom" style="color: navy; font-size: 8pt; line-height: 7pt; height: 30px; ">
				<td width="13%">&nbsp;
				</td>
				<td width="30%" style="padding-left: 3px; ">
                	View "to the title on the screen"
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
        if (isset($_POST['txtPlaylistVideoTitle-1'])) {
            if ($_POST['PlaylistVideoDownloadIcon-1'] == 'PlaylistVideoView-1') $_POST['PlaylistVideoView-1']=1;
            if ($_POST['PlaylistVideoDownloadIcon-1'] == 'PlaylistVideoDownload-1') $_POST['PlaylistVideoDownload-1']=1;
        }
        ?>
          <tbody name="tableVideoPlaylist" id="tableVideoPlaylist">
			<tr valign="bottom" style="line-height: 10pt; ">
				<td width="13%">
					<span style="font-size: 10pt; ">Enter video playlist:</span>
                    <br /><span style="font-size: 10pt; ">For example:</span>
				</td>
				<td width="30%">
					<input type='text' style='color: navy; ' size='40' name='txtPlaylistVideoTitle-1' id='txtPlaylistVideoTitle-1' value="<?php if (isset($_POST['txtPlaylistVideoTitle-1'])) echo $_POST['txtPlaylistVideoTitle-1'] ?>" />
                    <br /><span style="font-size: 10pt; ">The Luke Video</span>
				</td>
				<td width="31%">
					<input type='text' style='color: navy; ' size='40' name='txtPlaylistVideoFilename-1' id='txtPlaylistVideoFilename-1' value="<?php if (isset($_POST['txtPlaylistVideoFilename-1'])) echo $_POST['txtPlaylistVideoFilename-1'] ?>" />
                    <br /><span style="font-size: 9pt; ">Luke-video-[ISO code].txt</span>
				</td>
				<td width="10%">
                    <select name='PlaylistVideoDownloadIcon-1' id='PlaylistVideoDownloadIcon-1' style='color: navy; '>
                            <option value="PlaylistVideoView-1" <?php echo ( isset($_POST['PlaylistVideoView-1']) ? ($_POST['PlaylistVideoView-1'] == 1 ? " selected='selected'" : "") : ('PlaylistVideoView-1' == 1 ? " selected='selected'" : '' ) ) ?>>View</option>
                            <option value="PlaylistVideoDownload-1" <?php echo ( isset($_POST['PlaylistVideoDownload-1']) ? ($_POST['PlaylistVideoDownload-1'] == 1 ? " selected='selected'" : "") : ('PlaylistVideoDownload-1' == 1 ? " selected='selected'" : '' ) ) ?>>Download</option>
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
				while (isset($_POST['txtPlaylistVideoTitle-'.(string)$i]) || isset($_POST['txtPlaylistVideoFilename-'.(string)$i])) {
					echo "<tr>";
						echo "<td width='13%'>";
							echo "&nbsp;";
						echo "</td>";
						echo "<td width='30%'>";
							echo "<input type='text' name='txtPlaylistVideoTitle-$i' id='txtPlaylistVideoTitle-$i' style='color: navy; ' size='40' value='" . ( isset($_POST['txtPlaylistVideoTitle-'.(string)$i]) ? $_POST['txtPlaylistVideoTitle-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='31%'>";
							echo "<input type='text' name='txtPlaylistVideoFilename-$i' id='txtPlaylistVideoFilename-$i' style='color: navy; ' size='40 value='" . ( isset($_POST['txtPlaylistVideoFilename-'.(string)$i]) ? $_POST['txtPlaylistVideoFilename-'.(string)$i] : '' ) . "' />";
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
			?>
          </tbody>
		</table>
        <br />

	<?php
/************************************************
	Scripture Resources from eBible.org
*************************************************/
	?>
        <input type='checkbox' name='eBible' id='eBible' <?php echo (isset($_POST['eBible']) ? ' checked' : '') ?> /> Is there the "Scripture Resources from eBible.org" URL?
		<br />

	<?php		
/************************************************
	"SIL link" checkbox
*************************************************/
		?>
		<br />
		<input type='checkbox' name='SILlink' id='SILlink' <?php echo (isset($_POST['SILlink']) && $_POST['SILlink'] == 'on' ? ' checked' : '') ?> /> Does this have the "SIL link" URL?
		<br />
		
		<?php		
/************************************************
	Email links
*************************************************/
		?>
		<table valign="bottom" cellpadding="0" cellspacing="0" width="100%">
       	  <thead style='text-align: left; vertical-align: bottom; '>
			<tr valign="bottom" style="color: navy; font-size: 8pt; line-height: 7pt; height: 30px; ">
				<td width="16%">&nbsp;
				</td>
				<td width="41%" style="padding-left: 3px; padding-bottom: 3px; ">
                	Before Email
				</td>
				<td width="27%" style="padding-left: 3px; padding-bottom: 3px; ">
					Email address link
				</td>
				<td width="16%">&nbsp;
				</td>
			</tr>
          </thead>
		  <?php
		  ?>
          <tbody name="tableEmail" id="tableEmail">
			<tr valign="bottom" style="line-height: 10pt; ">
				<td width="16%">
					<span style="font-size: 10pt; ">Enter Email link:</span>
                    <br /><span style="font-size: 10pt; ">For example:</span>
				</td>
				<td width="41%">
					<input type='text' style='color: navy; ' size='70' name='txtEmailTitle-1' id='txtEmailTitle-1' value="<?php if (isset($_POST['txtEmailTitle-1'])) echo $_POST['txtEmailTitle-1'] ?>" />
                    <br /><span style="font-size: 10pt; ">To buy a printed New Testament in this language in Cameroon, please write to </span>
				</td>
				<td width="27%">
					<input type='text' style='color: navy; ' size='32' name='txtEmailAddress-1' id='txtEmailAddress-1' value="<?php if (isset($_POST['txtEmailAddress-1'])) echo $_POST['txtEmailAddress-1'] ?>" />
                    <br /><span style="font-size: 9pt; "> library_cameroon@sil.org</span>
				</td>
				<td width="16%" style="text-align: right; ">
					<input style="font-size: 9pt; " type="button" id="addEmail" value="Add" />
					<input style="font-size: 9pt; " type="button" id="removeEmail" value="Remove" />
                    <br /><span style="font-size: 10pt; ">&nbsp;</span>
				</td>
			</tr>
			<?php
				$i = 2;
				while (isset($_POST['txtEmailTitle-'.(string)$i]) || isset($_POST['txtEmailAddress-'.(string)$i])) {
					echo "<tr>";
						echo "<td width='16%'>";
							echo "&nbsp;";
						echo "</td>";
						echo "<td width='41%'>";
							echo "<input type='text' name='txtEmailTitle-$i' id='txtEmailTitle-$i' style='color: navy; ' size='70' value='" . ( isset($_POST['txtEmailTitle-'.(string)$i]) ? $_POST['txtEmailTitle-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='27%'>";
							echo "<input type='text' name='txtEmailAddress-$i' id='txtEmailAddress-$i' style='color: navy; ' size='32' value='" . ( isset($_POST['txtEmailAddress-'.(string)$i]) ? $_POST['txtEmailAddress-'.(string)$i] : '' ) . "' />";
						echo "</td>";
						echo "<td width='16%'>";
							echo "&nbsp;";
						echo "</td>";
					echo "</tr>";
					$i++;
				}
				?>
          </tbody>
		</table>
        <br />
		<br />

		<div style='text-align: center; padding: 10px; '><input type='submit' name='btnSubmit' value='<?php echo "Submit to the\r\nDatabase"; ?>' /></div>
		</form>
	</div>
	<br />
	<div style='text-align: center; background-color: #333333; margin: 0px auto 0px auto; padding: 20px; width: 1020px; border-radius: 15px; -moz-border-radius: 15px; -webkit-box-shadow: 15px; '>
	<br /><br /-->
    <div class='nav' style='font-weight: normal; color: white; font-size: 10pt; '><sup>©</sup>2009 - <?php echo date('Y'); ?> <span style='color: #99FF99; '>ScriptureEarth.org</span></div>
	</div>
    
	<script type="text/javascript" language="javascript">
		document.getElementById("iso").focus();					// focus on the ISO input
	</script>
    
	<script type="text/javascript" src="_js/CMS_events.js?v=1.0.3"></script>

</body>
</html>