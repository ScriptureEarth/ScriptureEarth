<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Index Scripture</title>
<link rel="stylesheet" type="text/css" href="../button.css" />
<style type="text/css">
body {
	font: 100% Verdana, Arial, Helvetica, sans-serif;
	background-color: black;
	margin: 20px; /* it's good practice to zero the margin and padding of the body element to account for differing browser defaults */
	padding: 0;
	text-align: center; /* this centers the container in IE 5* browsers. The text is then set to the left aligned default in the #container selector */
	/*background-image: url('images/00i-BackgroundFistPage.jpg');*/
	/*height: 700px;  You must set a specified height */
	/*background-position: center;  Center the image */
	/* background-repeat: no-repeat; Do not repeat the image */
}
.oneColElsCtr #container {
	/*width: 46em;*/
	margin: 0 auto; /* the auto margins (in conjunction with a width) center the page */
	text-align: center;
}
.oneColElsCtr #mainContent {
	padding: 0; /* remember that padding is the space inside the div box and margin is the space outside the div box */
	margin: 0;
}
#background {
    max-width: 100%;
    height: auto;
	/*text-align: center;*/
 	background-position: center;  /* Center the image */
	background-repeat: no-repeat;  /* Do not repeat the image */
	position: relative;
	width: 720px;
	z-index: -15;
}

h3 {
	margin-top: 8px;
	margin-bottom: 8px;
}
.enter > div {
	margin-bottom: 20px;
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
.pick {
	color: navy;
}
.pickCountry:hover {
	color: #A82120;
	background-color: #FFFFCC;
	font-weight: bold;
	cursor: pointer;
}
.pickCountry {
	color: white;
	line-height: 40px;
	width: 400px;
	margin-left: auto;
	margin-right: auto;
	margin-top: 0;
	margin-bottom: 0;  
}
#listCountriesID > button {
	border: solid 2px #33628d;
	/*font-size: 1em;*/
	vertical-align: middle;
	
    width: 60%;
    box-sizing: border-box;
    /*border: 2px solid #ccc;*/
    border-radius: 12px;
    font-size: 1.5em;
    background-color: #4079b0;
    color: white;
    background-image: url('images/listCountry.png');
    background-position: 10px 10px; 
    background-repeat: no-repeat;
    padding: 12px 20px 12px 20px;
	background-position: right;
	text-align: left;
}
.enter {
	margin-top: -630px;
	/*font-weight: bold;*/
	width: 1000px;
	margin-left: auto;
	margin-right: auto;
}
input[type=text] {
	border: solid 2px #33628d;
	/*font-size: 1em;*/
	vertical-align: middle;
	
    width: 60%;
    box-sizing: border-box;
    /*border: 2px solid #ccc;*/
    border-radius: 12px;
    font-size: 1.5em;
    background-color: #4079b0;
    color: white;
    background-image: url('images/search.png');
    background-position: 10px 10px; 
    background-repeat: no-repeat;
    padding: 12px 20px 12px 20px;
	background-position: right;
}
::placeholder {
    color: #ccc;
    opacity: 1; /* Firefox */
}

:-ms-input-placeholder { /* Internet Explorer 10-11 */
   color: #ccc;
}

::-ms-input-placeholder { /* Microsoft Edge */
   color: #ccc;
}

fieldset {
	border: 0;
}
label {
	display: block;
	margin: 30px 0 0 0;
}
.overflow {
	height: 200px;
}

#salutation {
    background-color: #4079b0;
    color: white;
}
option {
	color: white;
	background-color: #4079b0;
	text-align: left;
	margin: 0;
	font-size: .8em;
}
select {
	color: white;
	background-color: #4079b0;
}
.OpaqueWhite {
	height: 276px;
	margin-top: -266px;
	width: 65%;
	background-color: white;
	background-repeat: no-repeat;
	background-attachment: fixed;
	background-position: center top;
	border-radius: 25px;
	opacity: 0.5;
	margin-right: auto;
	margin-left: auto;
	position: relative;
	z-index: -5;
}
ul.ulEnglish, ul.ulSpanish, ul.ulPortuguese, ul.ulDutch, ul.ulFrench {
	/*padding-left: 230px;*/		/* use padding-left and width to make the words correct position */
	display: block;
	text-align: center;
	font-size: 1em;
	font-weight: bold;
	margin-top: -570px;
	/*clear: both;*/
}
li.aboutText {
	display: block;
	margin-top: 20px;
	padding: 0;
}
a.aboutWord {
	color: white;
	text-decoration: none;
}
a.aboutWord:hover {
	color: red;
}

a {
	color: navy;
	text-decoration: none;
}
</style>
<link rel="stylesheet" href="../blueButton.css">
<link rel="stylesheet" href="../JQuery/css/style.css">
<link rel="stylesheet" href="../JQuery/css/jquery-ui-1.12.1.css">
<script type="text/javascript" src="../JQuery/js/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="../JQuery/js/jquery-ui-1.12.1.min.js"></script>

</head>

<body class="oneColElsCtr">

<img id="background" src='../images/00i-BackgroundFistPage.jpg' />

<?php
// get "number" == 2
// get name = 'ZZ"
// get st

$number = '';
if (isset($_GET["number"])) {
	$number = $_GET["number"];
	//echo $number;
	// Cross Site Scripting (XSS) attack happens where client side code (usually JavaScript) gets injected into the output of your PHP script. The next line cleans it up.
	//$number = htmlspecialchars($number, ENT_QUOTES, 'UTF-8');
	$test = preg_match('/^(1-2)/', $number, $matches);
	if ($test === 0) {
		$number = 1;
	}
	else {
		$number = $matches[1];
	}
}
else {
	$number = 2;
}

$GetName = '';						// GetName = "ZZ"
if (isset($_GET["name"])) {
	$GetName = $_GET["name"];
}
else {
	 die('Specific country ID is missing. Hack!');
}

$MajorLanguage = '';
$Variant_major = '';
$SpecificCountry = '';

$st = '';
if (isset($_GET["st"])) {
	$st = $_GET["st"];
}
else {
	 die('Major Language ID is missing. Hack!');
}

switch ($st) {
	case 'nld':
		$MajorLanguage = 'LN_Dutch';
		$Variant_major = 'Variant_Dut';
		$Scriptname = '00d-Bijbel_Indice.php';
		$SpecificCountry = 'Dutch';
		$FacebookCountry = "en_US";
		$MajorCountryAbbr = "en";
		break;
	case 'spa':
		$MajorLanguage = 'LN_Spanish';
		$Variant_major = 'Variant_Spa';
		$Scriptname = '00e-Escrituras_Indice.php';
		$SpecificCountry = 'Spanish';
		$FacebookCountry = "en_US";
		$MajorCountryAbbr = "en";
		break;
	case 'fra':
		$MajorLanguage = 'LN_French';
		$Variant_major = 'Variant_Fre';
		$Scriptname = '00f-Ecritures_Indice.php';
		$SpecificCountry = 'French';
		$FacebookCountry = "en_US";
		$MajorCountryAbbr = "en";
		break;
	case 'eng':
		$MajorLanguage = 'LN_English';
		$Variant_major = 'Variant_Eng';
		$Scriptname = '00i_Scripture_Index.php';
		$SpecificCountry = 'English';
		$FacebookCountry = "en_US";
		$MajorCountryAbbr = "en";
		break;
	case 'por':
		$MajorLanguage = 'LN_Portuguese';
		$Variant_major = 'Variant_Por';
		$Scriptname = '00p-Escrituras_Indice.php';
		$SpecificCountry = 'Portuguese';
		$FacebookCountry = "en_US";
		$MajorCountryAbbr = "en";
		break;
	default:
		$response = '"st" never found.';
		exit();
}

include ('../translate/functions.php');														// translation function

require_once './conn.inc.php';																// connect to the database named 'scripture'
$db = get_my_db();

$query="SELECT DISTINCT scripture_main.*, countries.$SpecificCountry FROM scripture_main, countries, ISO_countries WHERE ISO_countries.ISO_countries = '$GetName' AND scripture_main.ISO_ROD_index = ISO_countries.ISO_ROD_index AND ISO_countries.ISO_countries = countries.ISO_Country ORDER BY scripture_main.ISO";
$result=$db->query($query);
//$num=$result->num_rows;

/*
	*********************************************************************************************************************
		select the default major language name to be used by displaying the Countries and indigenous langauge names
	*********************************************************************************************************************
*/
$db->query("DROP TABLE IF EXISTS LN_Temp");				// Get the names of all of the major languages or else get the default names
$db->query("CREATE TEMPORARY TABLE LN_Temp (ISO VARCHAR(3) NOT NULL, ROD_Code VARCHAR(5) NOT NULL, ISO_ROD_index INT NULL, LN VARCHAR(50) NOT NULL) ENGINE = MEMORY CHARSET = utf8") or die (translate('Query failed:', $st, 'sys') . ' ' . $db->error . "</body></html>");
//$i=0;
$stmt = $db->prepare('INSERT INTO LN_Temp (ISO, ROD_Code, ISO_ROD_index, LN) VALUES (?, ?, ?, ?)');			// create a prepared statement
while ($row = $result->fetch_array()) {
	$country=$row["$SpecificCountry"];
	$ISO=$row['ISO'];																		// ISO
	$ROD_Code=$row['ROD_Code'];																// ROD_Code
	$Variant_Code=$row['Variant_Code'];														// Variant_Code
	$ISO_ROD_index=$row['ISO_ROD_index'];													// ISO_ROD_index

	include ('./00-DBLanguageCountryName.inc.php');

	//$db->query("INSERT INTO LN_Temp (ISO, ROD_Code, ISO_ROD_index, LN) VALUES ('$ISO', '$ROD_Code', '$ISO_ROD_index', '$LN')");
	$stmt->bind_param("ssis", $ISO, $ROD_Code, $ISO_ROD_index, $LN);						// bind parameters for markers								// 
	$stmt->execute();																		// execute query
	//$i++;
}
$stmt->close();																				// close statement

?>
<table style='width: 80%; margin-left: auto; margin-right: auto; margin-top: -635px; margin-bottom: 0px; text-align: left; '>
    <thead>
        <tr style='height: 50px; '>
			<?php
            echo '<th style="color: black; background-color: white; text-align: center; font-size: 1.4em; heigth: 100px; " colspan="4">'.$country.'</tr>';
            // language name and ISO code here
            // The width and padding-left are what changes the spaces around the words.
            // When doing a Switch() Netscape 9 drops the table down a 1/2 inch. I don't know why.
            ?>
        </tr>
        <tr id='languageName' style="color: #000082; background-color: white; text-align: center; font-weight: bold; font-size: 1.1em; height: 40px; ">
        <?php
            echo "<th width='30%' class='secondHeaderSelection' style='font-size: .95em; vertical-align: middle; '>".translate('Language Name', $st, 'sys').":&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='../images/downTriangle.png' /></th>";
            echo "<th width='35%' class='secondHeader' style='font-size: .88em; '>".translate('Alternate Language Names', $st, 'sys').":</th>";
            echo "<th width='15%' class='secondHeader' style='font-size: .92em; '><a id='one' title='".translate('Click to sort.', $st, 'sys')."' href='#' onmouseup='Switch(1)'>".translate('ISO', $st, 'sys').":</a></th>";
            echo "<th width='20%' class='secondHeader' style='font-size: .88em; '>".translate('Country', $st, 'sys').":</th>";
        ?>
        </tr>
        <tr id='languageCode' style="color: #000082; background-color: white; text-align: center; font-weight: bold; font-size: 1.1em; height: 40px; display: none; ">
        <?php
            echo "<th width='30%' class='secondHeader' style='font-size: .95em; vertical-align: middle; '><a id='two' title='".translate('Click to sort.', $st, 'sys')."' href='#' onmouseup='Switch(2)'>".translate('Language Name', $st, 'sys').":</a></th>";
            echo "<th width='35%' class='secondHeader' style='font-size: .88em; '>".translate('Alternate Language Names', $st, 'sys').":</th>";
            echo "<th width='15%' class='secondHeaderSelection' style='font-size: .92em; '>".translate('ISO', $st, 'sys').":&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='../images/downTriangle.png' /></th>";
            echo "<th width='20%' class='secondHeader' style='font-size: .88em; '>".translate('Country', $st, 'sys').":</th>";
        ?>
        </tr>
    </thead>
</table>

<?php
if ($number == 1) {		// $which == 'Name'
	$query="SELECT DISTINCT LN_Temp.LN, scripture_main.* FROM LN_Temp, scripture_main WHERE scripture_main.ISO_ROD_index = LN_Temp.ISO_ROD_index ORDER BY LN_Temp.ISO, LN_Temp.ROD_Code";
}
else {	// $which == 'Code'
	$query="SELECT DISTINCT LN_Temp.LN, scripture_main.* FROM LN_Temp, scripture_main WHERE scripture_main.ISO_ROD_index = LN_Temp.ISO_ROD_index ORDER BY LN_Temp.LN";
}
$result = $db->query($query);
$num=$result->num_rows;
?>
    
<div id='canvas' style='width: 100%; '>
    <div id='NamesLang' style='width: 80%; margin-left: auto; margin-right: auto; text-align: left; '>
	    <?php

		/*
			*************************************************************************************************************
				display the langauge names for this country
			*************************************************************************************************************
		*/
		//	the 'table' is caused by a buy in Firefox 63.0.1 (11/7/2018) thus I added the last 3 items 
		?>
        <table id='CountryTable' style='display: table; width: 100%; height: 100px; min-height: 100px; '>
        <?php
        $i=0;

        $query = "SELECT alt_lang_name FROM alt_lang_names WHERE ISO_ROD_index = ?";			// alt_lang_names table
        //$result_alt=$db->query($query_alt);
        $stmt_alt = $db->prepare($query);														// create a prepared statement
        $query = "SELECT Variant_Description FROM Variants WHERE Variant_Code = ?";				// Variants table
        //$resultVar=$db->query($query);
        $stmt_Var = $db->prepare($query);														// create a prepared statement
        $query="SELECT $SpecificCountry, ISO_countries FROM ISO_countries, countries WHERE ISO_countries.ISO_ROD_index = ? AND ISO_countries.ISO_countries = countries.ISO_Country ORDER BY $SpecificCountry";
        //$result_ISO_countries=$db->query($query);
        $stmt_ISO_countries = $db->prepare($query);												// create a prepared statement
        
        while ($i < $num) {
			if ($i % 2)
				$color = "255, 255, 255, 1";
			else
				//$color = "f0f4f0";
				$color = "238, 241, 242, 1";
            $r = $result->fetch_array();
            $ISO = $r['ISO'];
            $ROD_Code = $r['ROD_Code'];
            $Variant_Code = $r['Variant_Code'];
            $ISO_ROD_index = $r['ISO_ROD_index'];
            $LN = $r['LN'];
            // Cross Site Scripting (XSS) attack happens where client side code (usually JavaScript) gets injected into the output of your PHP script. The next line cleans it up.
            $LN = htmlspecialchars($LN, ENT_QUOTES, 'UTF-8');
            echo "<tr style='background-color: rgba(".$color.")'>";
				echo "<td width='30%' class='pick' style='padding-left: 10px; padding-right: 10px; height: 40px; ' onclick='location.href=\"./00_SpecificLanguage.inc.php?idx=$ISO_ROD_index&st=$st&SpecificCountry=$SpecificCountry&Scriptname=$Scriptname&MajorCountryAbbr=$MajorCountryAbbr\"'>$LN</td>";
				//$query_alt="SELECT alt_lang_name FROM alt_lang_names WHERE ISO_ROD_index = '$ISO_ROD_index'";			// alt_lang_names
				//$result_alt=$db->query($query_alt);
				$stmt_alt->bind_param("i", $ISO_ROD_index);											// bind parameters for markers								// 
				$stmt_alt->execute();																// execute query
				$result_alt = $stmt_alt->get_result();												// instead of bind_result (used for only 1 record):
				$alt_lang_names = '';
				if ($result_alt) {
					$num_alt=$result_alt->num_rows;
					echo "<td width='35%' style='padding-left: 10px; padding-right: 10px; '>";
					$i_alt=0;
					while ($row_temp = $result_alt->fetch_array()) {
						if ($i_alt != 0) {
							echo ", ";
							//$alt_lang_names .= ", ";
						}
						$alt_lang_name=trim($row_temp['alt_lang_name']);
						// Cross Site Scripting (XSS) attack happens where client side code (usually JavaScript) gets injected into the output of your PHP script. The next line cleans it up.
						$alt_lang_name = htmlspecialchars($alt_lang_name, ENT_QUOTES, 'UTF-8');
						echo "$alt_lang_name";
						//$alt_lang_names .= $alt_lang_name;
						$i_alt++;
					}
					echo "</td>";
				}
				else
					echo "<td width='35%'>&nbsp;</td>";
				//$ISO=trim($row['scripture_main.ISO"));											// ISO
				//$ROD_Code=trim($row['scripture_main.ROD_Code"));									// ROD_Code
				//$ISO_ROD_index=trim($row['scripture_main.ISO_ROD_index"));						// ISO_ROD_index
				echo "<td width='15%' class='pick' style='padding-left: 10px; padding-right: 10px;' onclick='location.href=\"./00_SpecificLanguage.inc.php?sortby=lang&ISO_ROD_index=$ISO_ROD_index&st=$st&SpecificCountry=$SpecificCountry&Scriptname=$Scriptname&MajorCountryAbbr=$MajorCountryAbbr\"'>$ISO";
				$VD = '';
				if (!is_null($Variant_Code) && $Variant_Code != '') {
					//$query = "SELECT Variant_Description FROM Variants WHERE Variant_Code = '$Variant_Code'";
					//$resultVar=$db->query($query) or die (translate('Query failed:', $st, 'sys') . ' ' . $db->error . "</body></html>");
					$stmt_Var->bind_param("s", $Variant_Code);										// bind parameters for markers								// 
					$stmt_Var->execute();															// execute query
					$resultVar = $stmt_Var->get_result();											// instead of bind_result (used for only 1 record):
					if ($resultVar) {
						$rowVar = $resultVar->fetch_array();
						$VD = $rowVar['Variant_Description'];
						include ("./00-MajorLanguageVariantCode.inc.php");
						echo "<br /><span style='font-style: italic; font-size: 8pt; '>($VD)</span>";
					}
					$resultVar->free();
				}		
				echo "</td>";
				//$query="SELECT $SpecificCountry FROM ISO_countries, countries WHERE ISO_countries.ISO_ROD_index = '$ISO_ROD_index' AND ISO_countries.ISO_countries = countries.ISO_Country ORDER BY $SpecificCountry";
				//$result_ISO_countries=$db->query($query);
				$stmt_ISO_countries->bind_param("i", $ISO_ROD_index);								// bind parameters for markers								// 
				$stmt_ISO_countries->execute();														// execute query
				$result_ISO_countries = $stmt_ISO_countries->get_result();							// instead of bind_result (used for only 1 record):
				$row_ISO_countries = $result_ISO_countries->fetch_array();
				//$num_ISO_countries=mysql_num_rows($result_ISO_countries);
				$countryTemp = $SpecificCountry;
				if (strpos("$SpecificCountry", '.')) $countryTemp = substr("$SpecificCountry", strpos("$SpecificCountry", '.')+1);		// In case there's a "." in the "country"
				$countryTextarea = trim($row_ISO_countries["$countryTemp"]);						// name of the country in the language version
				$country = '<a href="./00_CountryTable.inc.php?sortby=country&name=' . trim($row_ISO_countries["ISO_countries"]) . '&st=' . $st . '">' . trim($row_ISO_countries["$countryTemp"]) . '</a>';
				$Country_Count = 1;
				while ($row_ISO_countries = $result_ISO_countries->fetch_array()) {
					$countryTextarea = $countryTextarea . ', ' . trim($row_ISO_countries["$countryTemp"]);
					$country = $country . ', <a href="./00_CountryTable.inc.php?sortby=country&name=' . trim($row_ISO_countries["ISO_countries"]) . '&st=' . $st . '">' . trim($row_ISO_countries["$countryTemp"]) . '</a>';			// name of the country in the language version
					$Country_Count++;
				}
				echo "<td width='20%' style=' padding-left: 10px; padding-right: 10px;'>";
				if ($Country_Count < 5) {
					echo "<span style='font-size: .9em; '>$country</span>";
				}
				else {
					echo "<textarea rows='2' readonly style='width: 100%; height: 100%; border: none; background-color: #$color; '>$countryTextarea</textarea>";
				}
				echo "</td>";
            echo "</tr>";
            $i++;
        }
        ?>
        </table>
	</div>
    <?php
	//$result_ISO_countries->free();
	//$result_alt->free();
	$result->free();
	$stmt_alt->close();
	$stmt_Var->close();
	$stmt_ISO_countries->close();
	$db->query("DROP TABLE LN_Temp");
	?>
</div>
    
<script type="text/javascript">
function Switch(number) {
	if ($('#languageCode').css("display") == 'none') {
		$('#languageName').hide();
		$('#languageCode').show();
	}
	else {
		$('#languageCode').hide();
		$('#languageName').show();
	}
}
</script>
</body>
</html>