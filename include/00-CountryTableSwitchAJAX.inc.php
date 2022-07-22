<?php
if (isset($GetName)) {																// $GetName = "ZZ"
// Country Table switches from language names and ISO and vica versa
?>

<!-- Detect what version of the browser that is used by the user. -->
<script src="./_js/pgwbrowser.min.js"></script>

<script type="text/javascript"> 
<!--
// Switch between Language Name or Language Code.
// This function NEEDS to be at the bottom of the PHP file (or less) $GetName will be undefined!

var pqwBrowser = $.pgwBrowser();													// detects the users browser

function Switch(number, Beg) {														// number = 1 or 2 from Switch from 00-CountryTable.inc.php
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

	// hack! The best way to the Beg in js so it can be passed from JavaScript function Send(zzz, zzz) in SpecificLanguage.js called by 00-MainScript.inc.php.
	document.getElementById("myBeg").innerHTML = Beg;
	
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
			}
			else {
				if (GN != 'all')
					document.getElementById("CT").innerHTML=ajaxCountryRequest.responseText;
				else {
					var response = ajaxCountryRequest.responseText.split("~||~");
					document.getElementById("CT").innerHTML=response[0];
					document.getElementById("Letters").innerHTML=response[1];
				}
			}
			$(document).ready(function(){
				var divHeight = 0;
				divHeight = document.getElementById("CT").offsetHeight;								// get the height of the Country Table (CT) id (right display)
				divHeight += 369;																	// add the header and footer
				if (pqwBrowser.browser.group === "Explorer") {
					if (divHeight > 720) {
						divHeight -= 32;
						document.getElementById("container").style.height = divHeight + "px";
					}
					else
						document.getElementById("container").style.height = "720px";
				}
				else if (pqwBrowser.browser.group === "Firefox") {
					// Firefox
					if (pqwBrowser.os.group === "Linux") {
						if (divHeight > 733) {
							divHeight -= 2;
							document.getElementById("container").style.height = divHeight + "px";
						}
						else
							document.getElementById("container").style.height = "733px";
					}
					else {
						if (divHeight > 742) {
							divHeight += 7;
							document.getElementById("container").style.height = divHeight + "px";
						}
						else
							document.getElementById("container").style.height = "742px";
					}
				}
				else if (pqwBrowser.browser.group === "Chrome") {
					// Chrome
					if (divHeight > 733) {
						divHeight -= 3;
						document.getElementById("container").style.height = divHeight + "px";
					}
					else
						document.getElementById("container").style.height = "733px";
				}
				else if (pqwBrowser.browser.group === "Opera") {
					// Opera
					if (divHeight > 720) {
						document.getElementById("container").style.height = divHeight + "px";
					}
					else
						document.getElementById("container").style.height = "720px";
				}
				else if (pqwBrowser.browser.group === "Safari") {
					// Safari
					if (divHeight > 720) {
						document.getElementById("container").style.height = divHeight + "px";
					}
					else
						document.getElementById("container").style.height = "720px";
				}
				else if (pqwBrowser.browser.group === "Spartan") {
					// Spartan (Windows 10)
					if (divHeight > 720) {
						document.getElementById("container").style.height = divHeight + "px";
					}
					else
						document.getElementById("container").style.height = "720px";
				}
				else if (navigator.userAgent.toLowerCase().indexOf('navigator') != -1) {
					// Netscape
					if (divHeight > 720) {
						divHeight -= 32;
						document.getElementById("container").style.height = divHeight + "px";
					}
					else
						document.getElementById("container").style.height = "720px";
				}
				else {
					// All of the other browser
					if (divHeight > 729) {
						divHeight -= 5;
						document.getElementById("container").style.height = divHeight + "px";
					}
					else
						document.getElementById("container").style.height = "729px";
				}
				
		   		$("#container").redrawShadow({left: 5, top: 5, blur: 2, opacity: 0.5, color: "black", swap: false});

				// This determines the height of the Country list (on the left side) and displays the height.
				//var CountryTableHeight = document.getElementById("iframeCountryTable").offsetHeight;		// Get the height of the right div of the languages list
				//if ((CountryTableHeight + < ?php echo $iframeCountryTable_BeginningHeight_iframeCountriesList; ?> ) > < ?php echo $iframeCountryTable_iframeCountriesListHeight; ?> ) {														// 498 is the height of the iframe of the iframeCountriesList ID
				//	document.getElementById("iframeCountriesList").style.height = (CountryTableHeight + < ?php echo $iframeCountryTable_BeginningHeight_iframeCountriesList; ?> ) + "px";		// Change the height of the iframe to (CountryTableHeight + 20) + "px"
				//}
				//else
				//	document.getElementById("iframeCountriesList").style.height = < ?php echo $iframeCountryTable_iframeCountriesListHeight; ?> + "px";	// Change the height of the iframe to 498 + "px"
		    });
		}
	}
	ajaxCountryRequest.open("GET", "00-BegList.php?st=<?php echo $st; ?>&MajorLanguage=<?php echo $MajorLanguage; ?>&SpecificCountry=<?php echo $SpecificCountry; ?>&Scriptname=<?php echo $Scriptname; ?>&b=" + Beg + "&gn=" + GN + "&n="+number, true);
	ajaxCountryRequest.send(null);
	$("#wait").css("display","none");
}
-->
</script>

<?php
}
?>