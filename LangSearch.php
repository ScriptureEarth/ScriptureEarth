<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Automatic Varaint Language Change</title>
<script type="text/javascript" language="javascript1.2" src="_js/LangSearch_Draft.js"></script>
<style type="text/css">
#manualTranslation {
	width: 1000px;
	margin-left: auto;
	margin-right: auto;
	clear: both;
	margin-top: -36px;
	/*float: right;*/
}
/* On IE8 the height is wrong for the localhost and is correct for Internet! */
.languageChoices {
	text-align: right;
	font-weight: bold;
	margin-right: 160px;
}
.languageChoiceSelected {
	font-weight: bold;
	color: #080860;
	background-color: #D2DFFA;
	vertical-align: middle;
	/*display: inline;*/
	font-size: .8em;
	margin: -5px -2px 0 3px;
	padding: 0 20px 0 3px;
	border: 0px solid black;
	line-height: 1.1em;
	/* Netscape 9: 1.2em */
	height: 2.2em;
	/* padding: 1px 19px 1px 10px; */
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
.languageChoiceDefault {
	color: #D2DFFA;
	background-color: #080860;
	vertical-align: middle;
	padding-left: 8px;
	border: 0px solid black;
	/*display: inline;*/
}
h3 {
	margin-top: 8px;
	margin-bottom: 8px;
}
div {
	margin-bottom: 10px;
}
p {
	margin: 0;
	padding: 0;
	
}
.pick:hover {
	color: #A82120;
	background-color: #FFFFCC;
	font-weight: bold;
	cursor: pointer;
}
button {
	font-size: 1em;
}
</style>
</head>
<body>

<?php
	$st = 'eng';
	if (isset($_GET['st'])) {
		$st = $_GET['st'];
		$test = preg_match('/^[a-z]{3}/', $st);
		if ($test === 0) {
			die ("<body><br />$st " . translate('wasn’t found.', $st, 'sys') . "</body></html>");
		}
	}
	
	include ('translate/functions.php');			// translation function
	
	switch ($st) {
		case 'nld':
			$MajorLanguage = 'LN_Dutch';
			$Variant_major = 'Variant_Dut';
			$SpecificCountry = 'Dutch';
			$Scriptname = '00d-Bijbel_Indice.php';
			break;
		case 'spa':
			$MajorLanguage = 'LN_Spanish';
			$Variant_major = 'Variant_Spa';
			$SpecificCountry = 'Spanish';
			$Scriptname = '00e-Escrituras_Indice.php';
			break;
		case 'fre':
			$MajorLanguage = 'LN_French';
			$Variant_major = 'Variant_Fre';
			$SpecificCountry = 'French';
			$Scriptname = '00f-Ecritures_Indice.php';
			break;
		case 'eng':
			$MajorLanguage = 'LN_English';
			$Variant_major = 'Variant_Eng';
			$SpecificCountry = 'English';
			$Scriptname = '00i-Scripture_Index.php';
			break;
		case 'por':
			$MajorLanguage = 'LN_Portuguese';
			$Variant_major = 'Variant_Por';
			$SpecificCountry = 'Portuguese';
			$Scriptname = '00p-Escrituras_Indice.php';
			break;
		case 'deu':
			$MajorLanguage = 'LN_German';
			$Variant_major = 'Variant_Ger';
			$SpecificCountry = 'German';
			$Scriptname = '00de-Sprachindex.php';
			break;
		default:
			$response = '"st" never found.';
			exit();
	}
?>

<div style='width: 1000px; margin-left: auto; margin-right: auto; '>
    <div style='text-align: center; padding-top: 1px; padding-bottom: 1px '>
        <img src='images/banBack.png' />
    </div>
</div>

<div id="manualTranslation">
    <form class="languageChoices">
    <select class="languageChoiceSelected" onchange="send(this)">	<!-- 'this' is the 'option' of the 'select' -->
        <?php
            include './include/00-MajorLanguageChoiceSelected.inc.php';			// connect to the database named 'scripture'
        ?>
    </select>
    </form>
</div>

<!-- AJAX is here. -->
<!-- showLanguage(this.value) in autoLanguage.js and myFuncttranslate('Home', $st, 'sys')ion(this.value, '$st') in autoLanguage.js -->
<div class='enter' style='font-weight: bold; width: 1000px; margin-left: auto; margin-right: auto; '>
    <div id="showLanguageID" name="showLanguageID" style="margin-left: auto; margin-right: auto; text-align: center; "><input type="text" id="ID" size="28" placeholder="&nbsp;<?php echo translate('Language...', $st, 'sys'); ?>" onkeyup="showLanguage(this.value, '<?php echo $st; ?>')" style="border-top: solid 2px; border-left: solid 2px; border-right: none; color: navy; font-size: 1em; vertical-align: middle; " value="" /><img src="images/searchIcon.png" style="border-top: solid 2px; border-bottom: solid thin #eee; vertical-align: middle; " width="25" height="24" /></div>
	<div id="showCountryID" name="showCountryID" style="margin-left: auto; margin-right: auto; text-align: center; "><input type="text" id="CID" size="28" placeholder="&nbsp;<?php echo translate('Country...', $st, 'sys'); ?>" onkeyup="showCountry(this.value, '<?php echo $st; ?>')" style="border-top: solid 2px; border-left: solid 2px; border-right: none; color: navy; font-size: 1em; vertical-align: middle; " value="" /><img src="images/searchIcon.png" style="border-top: solid 2px; border-bottom: solid thin #eee; vertical-align: middle; " width="25" height="24" /></div>
	<div id="listLanguagesID" name="listLanguagesID" style="margin-left: auto; margin-right: auto; text-align: center; "><button onclick="myLanguage('<?php echo $Scriptname; ?>')" style="color: navy; "> <?php echo translate('Language List', $st, 'sys'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/listIcon.png" width="24" height="22" style="vertical-align: middle; " /></button></div>
    <div id="listCountriesID" name="listCountriesID" style="margin-left: auto; margin-right: auto; text-align: center; "><button onclick="myCountry('<?php echo $Scriptname; ?>')" style="color: navy; "> <?php echo translate('Country List', $st, 'sys'); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/listIcon.png" width="24" height="22" style="vertical-align: middle; " /></button></div>
</div>

<script>
	document.getElementById("ID").value = '';
	document.getElementById("ID").focus();
	document.getElementById("CID").value = '';
</script>

<p id="LangSearch"></p>
<p id="CountSearch"></p>
<br />
<div class='enter' id='showSearchCountry' style='display: none; width: 1000px; margin-left: auto; margin-right: auto; '>
	<span style='font-weight: bold; '><?php echo translate('Countries searched', $st, 'sys'); ?>:</span><p id="CountrySearch"></p>
</div>

</body>
</html>