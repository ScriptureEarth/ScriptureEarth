// JavaScript Document

// Get the HTTP Object
function getHTTPObject() { // get the AJAX object; can be used more than once
    try {
        // IE 7+, Opera 8.0+, Firefox, Safari
        return new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer browsers
        try {
            return new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                return new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {
                // Something went wrong
                alert("XML HTTP Request is not able to be set. Maybe the version of the web browser is old?");
                return null;
            }
        }
    }
}

function showResult(str) { // the AJAX for the live search on the ISO input
    if (str.length === 0) { // if the string length is 0 then clear out the livesearch display
        document.getElementById("livesearch").innerHTML = "";
        document.getElementById("livesearch").style.border = "0px";
        document.getElementById("Countrys").innerHTML = "";
        document.getElementById("txtLinkURL-1").innerHTML = "";
        return;
    }
    if (str.length >= 4) { // ISO only allows the string length to be 3
        str = str.substring(0, str.length - 1);
        document.getElementById("iso").value = document.getElementById("iso").value.substring(0, document.getElementById("iso").value.length - 1);
        alert("Only 3 alphabetic characters are allowed!");
        return;
    }
    str = str.toLowerCase(); // ISO to be lower case...
    document.getElementById("iso").value = document.getElementById("iso").value.toLowerCase(); // and ISO input
    document.getElementById("txtLinkURL-1").value = 'https://joshuaproject.net/languages/' + str;
    var re = /[a-z]/;
    var foundArray = re.exec(str.substring(str.length - 1)); // the last character of the ISO
    if (!foundArray) { // is the value of the last character of the ISO isn't a - z then it returns
        document.getElementById("iso").value = document.getElementById("iso").value.substring(0, document.getElementById("iso").value.length - 1);
        alert(str.substring(str.length - 1) + " is an invalid character. Use an alphabetic character.");
        str = str.substring(0, str.length - 1);
        if (str.length === 0) {
            document.getElementById("livesearch").innerHTML = "";
            document.getElementById("livesearch").style.border = "0px";
        }
        return;
    }
    xmlhttp = getHTTPObject(); // the ISO object (see JavaScript function getHTTPObject() above)
    if (xmlhttp === null) {
        return;
    }
    ////////////////////////////////////////////////////////////
    var url = "livesearch.php";
    ////////////////////////////////////////////////////////////
    url = url + "?iso=" + str;
    url = url + "&sid=" + Math.random();
    xmlhttp.open("GET", url, true); // open the AJAX object with livesearch.php
    xmlhttp.send(null);
    xmlhttp.onreadystatechange = function() { // the function that returns for AJAZ object
        if (xmlhttp.readyState === 4) { // if the readyState = 4 then livesearch is displayed
            document.getElementById("livesearch").innerHTML = xmlhttp.responseText;
            /*document.getElementById("livesearch").style.border = "3px solid #669933";
            document.getElementById("livesearch").style.padding = "2px 4px 2px 4px";*/
            document.getElementById("livesearch").style.display = "inline";
            if (str.length === 3) {
                // -----------
                ISOShow(str);
                // -----------
                return;
            } else {
                if (document.getElementById("Countrys").innerHTML.substring(0, 6) === "<span ") document.getElementById("Countrys").innerHTML = ""; // ISOShow.php line 11					
            }
        }
    };
}

function ISOShow(str, rod, variant) { // the AJAX for filling in the English_lang_names, etc. (see function above)
    ISOxmlhttp = getHTTPObject();
    if (ISOxmlhttp === null) {
        return;
    }
    ////////////////////////////////////////////////////////////
    var url = "ISOShow.php";
    ////////////////////////////////////////////////////////////
    url = url + "?iso=" + str;
    rod = typeof(rod) !== 'undefined' ? rod : '00000';
    variant = typeof(variant) !== 'undefined' ? variant : '';
    if (rod !== '00000') url = url + "&rod=" + rod;
    if (variant !== '') url = url + "&var=" + variant;
    url = url + "&sid=" + Math.random();
    document.getElementById("rod").value = rod; // Very important! The ROD code must be updated here.
    document.getElementById('variant').value = variant; // Very important! The Variant code must be updated here.
    ISOxmlhttp.open("GET", url, true);
    ISOxmlhttp.send(null);
    ISOxmlhttp.onreadystatechange = function() {
        if (ISOxmlhttp.readyState === 4) {
            var tempArray = new Array();
            tempArray = ISOxmlhttp.responseText.split("|");
            if (tempArray.length === 1) {
                if (tempArray[0].substring(0, 6) === "<span ") document.getElementById("response").innerHTML = ""; // ISOShow.php line 11
                document.getElementById("Countrys").innerHTML = tempArray[0];
            } else {
                var liveSearchDisplay = "";
                var CountrysDisplay = "";
                for (i = 0; i < tempArray.length; i++) {
                    if (tempArray[i].substring(0, 11) === "livesearch:") {
                        var temp = tempArray[i].substring(11);
                        /*if (document.getElementById("livesearch").innerHTML.substring(document.getElementById("livesearch").innerHTML.length - 11) == "ISO.</span>") {
                        	temp = document.getElementById("livesearch").innerHTML + " " + temp;
                        	document.getElementById("livesearch").innerHTML = "";
                        }*/
                        liveSearchDisplay += " " + temp;
                    } else {
                        CountrysDisplay += tempArray[i];
                    }
                }
                document.getElementById("Countrys").innerHTML = CountrysDisplay;
                document.getElementById("livesearch").innerHTML = liveSearchDisplay;
                //					document.getElementById("livesearch").innerHTML = document.getElementById("livesearch").innerHTML.substr(0, document.getElementById("livesearch").innerHTML.search(/\//)+5);	// straingly, the following line won't work with the present line on the same line!
                //					document.getElementById("livesearch").innerHTML = document.getElementById("livesearch").innerHTML + " " + liveSearchDisplay;
            }
        }
    };
}

// these 7 are used by Scripture_Add.php
function RODCode(iso, rod) {
    //parent.location='Scripture_Add.php?ISO='+ISO+'&ROD_Code='+ROD_Code;
    ISOShow(iso, rod);
}

function addROD(rod, Add) {
    document.getElementById(rod).style.display = 'none';
    document.getElementById(Add).style.display = 'inline';
}

function replaceROD(rod, Replace) {
    document.getElementById(rod).style.display = 'none';
    document.getElementById(Replace).style.display = 'inline';
}

function addSubmit(rod, Add, iso, CountryCode, CountryName, thisForm) {
    document.getElementById(rod).style.display = 'inline';
    document.getElementById(Add).style.display = 'none';
    if (document.getElementById("formCountryCode")) {
        var CountryCode = document.getElementById("formCountryCode").options[document.getElementById("formCountryCode").selectedIndex].text;
        var CountryName = document.getElementById("formCountryName").options[document.getElementById("formCountryName").selectedIndex].text;
    }
    window.location.href = "addRODVal.php?iso=" + iso + "&rod=" + thisForm.RODCodeValue.value + "&CountryCode=" + CountryCode + "&Location=" + CountryName + "&Language=" + thisForm.Language.value + "&Dialect=" + thisForm.Dialect.value;
}

function addCancel(rod, Add) {
    document.getElementById(rod).style.display = 'inline';
    document.getElementById(Add).style.display = 'none';
}

function replaceSubmit(rod, Replace, iso, ROD_Code, ChangeCode) {
    alert(ChangeCode);
    document.getElementById(rod).style.display = 'inline';
    document.getElementById(Replace).style.display = 'none';
    window.location.href = "replaceRODVal.php?iso=" + iso + "&rod=" + ROD_Code + "&ChangeCode=" + ChangeCode;
}

function replaceCancel(rod, Replace) {
    document.getElementById(rod).style.display = 'inline';
    document.getElementById(Replace).style.display = 'none';
}

function addVariant() {
    document.getElementById('addingVariant').style.display = 'inline';
}

function addVarSubmit(VarValue, VarText) {
    document.getElementById('addingVariant').style.display = 'none';
    // http://www.javascriptkit.com/jsref/select.shtml#section2
    var myselect = document.getElementById("Variant_Descriptions");
    myselect.options[myselect.length] = new Option(VarText, VarValue, false, true); //add a new option to the end of the select tag
    document.getElementById('Variant_Code').value = VarValue;
    //alert (document.getElementById('Variant_Code').value);
    //document.getElementById('variant').innerHTML = "<span style='color: navy; font-weight: bold; '>Success for Variant Code!</span>";
    document.getElementById("livesearch").innerHTML += " <span style='color: navy; font-weight: bold; font-size: 12pt; '>Success for Variant Code!</span>";
}

function addVarCancel() {
    document.getElementById('addingVariant').style.display = 'none';
}

function CountryCodeChange() {
    var x = document.getElementById("formCountryCode").selectedIndex;
    var y = document.getElementById("formCountryCode").options;
    //var w=document.getElementById("formCountryName").selectedIndex;
    var z = document.getElementById("formCountryName").options;
    z[y[x].index].selected = true;
    //alert("Index: " + y[x].index + " is " + y[x].text);
}

function CountryNameChange() {
    //var x=document.getElementById("formCountryCode").selectedIndex;
    var y = document.getElementById("formCountryCode").options;
    var w = document.getElementById("formCountryName").selectedIndex;
    var z = document.getElementById("formCountryName").options;
    y[z[w].index].selected = true;
    //alert("Index: " + y[x].index + " is " + y[x].text);
}