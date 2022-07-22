<?php
if (isset($GetName)) {
// Country Table switches from language names and ISO and vica versa
?>

<script type="text/javascript"> 
<!--
// Switch between Language Name or Language Code.
// This function NEEDS to be at the bottom or less $GetName will be undefined!
function Switch(number) {
	// GetName is the name of the ISO country(ies)
	var GN = "<?php echo $GetName; ?>";
	var Beg = 'all';
	var which = '';
	$("#wait").css("display","block");
	if (number == 1) {
		document.getElementById('languageName').style.display = 'none';
		document.getElementById('languageCode').style.display = 'block';
		which = 'Code';
	}
	else {
		document.getElementById('languageCode').style.display = 'none';
		document.getElementById('languageName').style.display = 'block';
		which = 'Name';
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
			document.getElementById("CT").innerHTML=ajaxCountryRequest.responseText;
		}
	}
	ajaxCountryRequest.open("GET", "00-BegList-m.php?st=<?php echo $st; ?>&MajorLanguage=<?php echo $MajorLanguage; ?>&SpecificCountry=<?php echo $SpecificCountry; ?>&Scriptname=<?php echo $Scriptname; ?>&b=" + Beg + "&gn=" + GN + "&n="+number, true);
	ajaxCountryRequest.send(null);
	$("#wait").css("display","none");
}
-->
</script>

<?php
}
?>