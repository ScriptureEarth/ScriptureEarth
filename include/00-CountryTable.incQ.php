<?php
// Created by Scott Starker

// get "number" == 2

$number = '';
if (isset($_GET["number"])) {
	$number = $_GET["number"];
	//echo $number;
	// Cross Site Scripting (XSS) attack happens where client side code (usually JavaScript) gets injected into the output of your PHP script. The next line cleans it up.
	//$number = htmlspecialchars($number, ENT_QUOTES, 'UTF-8');
	$test = preg_match('/^([1-2])/', $number, $matches);
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

$GetName = '';																				// GetName = "ZZ"
if (isset($_GET["name"])) {
	$GetName = $_GET["name"];
	$test = preg_match('/^([A-Z]{2})/', $GetName, $matches);
	if ($test === 0) {
		die('Specific country ID is missing. Hack!');
	}
	$GetName = $matches[1];
}
else {
	 die('Specific country ID is missing. Hack!');
}

$query="SELECT DISTINCT scripture_main.*, $SpecificCountry FROM scripture_main, countries, ISO_countries WHERE ISO_countries.ISO_countries = '$GetName' AND scripture_main.ISO_ROD_index = ISO_countries.ISO_ROD_index AND ISO_countries.ISO_countries = countries.ISO_Country ORDER BY scripture_main.ISO";
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

	include ('./include/00-DBLanguageCountryName.inc.php');

	//$db->query("INSERT INTO LN_Temp (ISO, ROD_Code, ISO_ROD_index, LN) VALUES ('$ISO', '$ROD_Code', '$ISO_ROD_index', '$LN')");
	$stmt->bind_param("ssis", $ISO, $ROD_Code, $ISO_ROD_index, $LN);						// bind parameters for markers								// 
	$stmt->execute();																		// execute query
	//$i++;
}
$stmt->close();																				// close statement

?>
<!--body class="oneColElsCtr"-->

<!--img id="background" src='../images/00i-BackgroundFistPage.jpg' /-->

<table id='countryTable'>
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
            echo "<th width='30%' class='secondHeaderSelection' style='font-size: .95em; vertical-align: middle; '>".translate('Language Name', $st, 'sys')."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='../images/downTriangle.png' /></th>";
            echo "<th width='40%' class='secondHeader' style='font-size: .92em; '>".translate('Alternate Language Names', $st, 'sys')."</th>";
            echo "<th width='10%' class='secondHeader' style='font-size: .92em; cursor: pointer; ' onmouseup='Switch(1)'>".translate('Code', $st, 'sys')."</th>";
            echo "<th width='20%' class='secondHeader' style='font-size: .92em; '>".translate('Country', $st, 'sys')."</th>";
        ?>
        </tr>
        <tr id='languageCode' style="color: #000082; background-color: white; text-align: center; font-weight: bold; font-size: 1.1em; height: 40px; display: none; ">
        <?php
            echo "<th width='30%' class='secondHeader' style='font-size: .92em; vertical-align: middle; cursor: pointer; ' onmouseup='Switch(2)'>".translate('Language Name', $st, 'sys')."</th>";
            echo "<th width='40%' class='secondHeader' style='font-size: .92em; '>".translate('Alternate Language Names', $st, 'sys')."</th>";
            echo "<th width='10%' class='secondHeaderSelection' style='font-size: .95em; '>".translate('Code', $st, 'sys')."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='../images/downTriangle.png' /></th>";
            echo "<th width='20%' class='secondHeader' style='font-size: .92em; '>".translate('Country', $st, 'sys')."</th>";
        ?>
        </tr>
    </thead>
    <tbody id="CT">
		<?php
        if ($number == 1) {		// $which == 'Name'
            $query="SELECT DISTINCT LN_Temp.LN, scripture_main.* FROM LN_Temp, scripture_main WHERE scripture_main.ISO_ROD_index = LN_Temp.ISO_ROD_index ORDER BY LN_Temp.ISO, LN_Temp.ROD_Code";
        }
        else {	// $which == 'Code'
            $query="SELECT DISTINCT LN_Temp.LN, scripture_main.* FROM LN_Temp, scripture_main WHERE scripture_main.ISO_ROD_index = LN_Temp.ISO_ROD_index ORDER BY LN_Temp.LN";
        }
        $result = $db->query($query);
        $num=$result->num_rows;
        /*
            *************************************************************************************************************
                display the langauge names for this country
            *************************************************************************************************************
        */
        //	the 'table' is caused by a buy in Firefox 63.0.1 (11/7/2018) thus I added the last 3 items 
        ?>
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
            echo "<tr style='background-color: rgba(".$color."); height: 50px; border-top: thin solid black; '>";
				// language
                echo "<td width='30%' class='pick' style='padding-left: 10px; padding-right: 10px; height: 40px; ' onclick='location.href=\"./".$Scriptname."?sortby=lang&name=$ISO&ISO_ROD_index=$ISO_ROD_index\"'>$LN</td>";
                
				// alternate language names
				//$query_alt="SELECT alt_lang_name FROM alt_lang_names WHERE ISO_ROD_index = '$ISO_ROD_index'";			// alt_lang_names
                //$result_alt=$db->query($query_alt);
                $stmt_alt->bind_param("i", $ISO_ROD_index);											// bind parameters for markers								// 
                $stmt_alt->execute();																// execute query
                $result_alt = $stmt_alt->get_result();												// instead of bind_result (used for only 1 record):
                $alt_lang_names = '';
                if ($result_alt) {
                    $num_alt=$result_alt->num_rows;
                    echo "<td width='40%' style='padding-left: 10px; padding-right: 10px; '>";
					$alt_item = '';
                    $i_alt=0;
                    while ($row_temp = $result_alt->fetch_array()) {
                        if ($i_alt > 0) {
                            $alt_item .= ', ';
                        }
                        $alt_lang_name=trim($row_temp['alt_lang_name']);
                        // Cross Site Scripting (XSS) attack happens where client side code (usually JavaScript) gets injected into the output of your PHP script. The next line cleans it up.
                        $alt_lang_name = htmlspecialchars($alt_lang_name, ENT_QUOTES, 'UTF-8');
                        $alt_item .= $alt_lang_name;
                        //$alt_lang_names .= $alt_lang_name;
                        $i_alt++;
                    }
					if ($i_alt < 11) {
						echo "<div id='alt' style='display: inline; font-size: .95em; '>$alt_item</div>";
					}
					else {
						echo "<textarea rows='2' readonly style='font-size: .92em; width: 100%; height: 100%; border: none; background-color: rgba(".$color."); '>$alt_item</textarea>";
					}
                    echo "</td>";
                }
                else
                    echo "<td width='40%'>&nbsp;</td>";
					
				// ISO
                //$ISO=trim($row['scripture_main.ISO"));											// ISO
                //$ROD_Code=trim($row['scripture_main.ROD_Code"));									// ROD_Code
                //$ISO_ROD_index=trim($row['scripture_main.ISO_ROD_index"));						// ISO_ROD_index
                echo "<td width='10%' class='pick' style='padding-left: 10px; padding-right: 10px;' onclick='location.href=\"./".$Scriptname."?sortby=lang&name=$ISO&ISO_ROD_index=$ISO_ROD_index\"'>$ISO";
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
                        include ("./include/00-MajorLanguageVariantCode.inc.php");
                        echo "<br /><span style='font-style: italic; font-size: 8pt; '>($VD)</span>";
                    }
                    $resultVar->free();
                }		
                echo "</td>";
				
				// Country(ies)
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
                $country = '<a class="indivCountry" href="./'.$Scriptname.'?sortby=country&name=' . trim($row_ISO_countries["ISO_countries"]) . '">' . trim($row_ISO_countries["$countryTemp"]) . '</a>';
                $Country_Count = 1;
                while ($row_ISO_countries = $result_ISO_countries->fetch_array()) {
                    $countryTextarea = $countryTextarea . ', ' . trim($row_ISO_countries["$countryTemp"]);
                    $country = $country . ', <a class="indivCountry" href="./'.$Scriptname.'?sortby=country&name=' . trim($row_ISO_countries["ISO_countries"]) . '">' . trim($row_ISO_countries["$countryTemp"]) . '</a>';			// name of the country in the language version
                    $Country_Count++;
                }
                echo "<td width='20%' style='padding-left: 10px; padding-right: 10px;'>";
                if ($Country_Count < 5) {
                    echo "<span style='font-size: .9em; '>$country</span>";
                }
                else {
                    echo "<textarea rows='2' readonly style='width: 100%; height: 100%; border: none; background-color: rgba(".$color."); '>$countryTextarea</textarea>";
                }
                echo "</td>";
            echo "</tr>";
            $i++;
        }
        ?>
    </tbody>
</table>

<?php
//$result_ISO_countries->free();
//$result_alt->free();
$result->free();
$stmt_alt->close();
$stmt_Var->close();
$stmt_ISO_countries->close();
$db->query("DROP TABLE LN_Temp");
?>
    
<script type="text/javascript">
<!--
// Switch between Language Name or Language Code.
// This function NEEDS to be at the bottom of the PHP file (or less) $GetName will be undefined!

var pqwBrowser = $.pgwBrowser();													// detects the users browser

function Switch(number) {															// number = 1 or 2 from Switch from 00-CountryTable.inc.php
	// GetName is the name of the country(ies) in ZZ
	var GN = "<?php echo $GetName; ?>";
	$("#wait").css("display","block");
	if ($('#languageCode').css("display") == 'none') {
		$('#languageName').hide();
		$('#languageCode').show();
	}
	else {
		$('#languageCode').hide();
		$('#languageName').show();
	}
	// setup and execute 00z-BegList.php
	var ajaxCountryRequest;  														// The variable that makes Ajax possible!
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
			document.getElementById("CT").innerHTML=ajaxCountryRequest.responseText;
			$(document).ready(function(){
		    });
		}
	}
	ajaxCountryRequest.open("GET", "00_BegList.php?st=<?php echo $st; ?>&MajorLanguage=<?php echo $MajorLanguage; ?>&SpecificCountry=<?php echo $SpecificCountry; ?>&Scriptname=<?php echo $Scriptname; ?>&gn=" + GN + "&n="+number, true);
	ajaxCountryRequest.send(null);
	$("#wait").css("display","none");
}
</script>
