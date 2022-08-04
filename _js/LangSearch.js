// Created by Scott Starker
// Updated by Scott Starker, Lærke Roager

/*
	variables are defined in LSearch.php:
		langNotFound = "The language is not found.";
		colLN = "Language Name";
		colAlt = "Alternate Language Names";
		colCode = "code";
		colCountry = "Country";
		
	variables are defined in CSearch.php:
		countryNotFound = "The country is not found."
		colCountries = "Countries"
*/

// Get the HTTP Object
function getHTTPObject() { // get the AJAX object; it can be used more than once
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

function showLanguage(str, st, Internet, asset) { // get the names of the languages
    if (str.length == 0) {
        document.getElementById("LangSearch").innerHTML = '';
        document.getElementById("CountSearch").innerHTML = '';
        $("#showCountryID").show();
        $("#listCountriesID").show();
        $("#mainContent").show();
        $("#whiteOpaque").show();
        $("#feedback").show();
        $("#copyright").show();
        return;
    }
    // saltillo: ꞌ; U+A78C
    var re = /[-. ,'ꞌ()A-Za-záéíóúÑñçãõâêîôûäëöüï]/; // the '-' has to go first
    var foundArray = re.exec(str.substring(str.length - 1)); // the last character of the str
    if (!foundArray) { // is the value of the last character of the str isn't A-Za - z then it returns
        document.getElementById("ID").value = document.getElementById("ID").value.substring(0, document.getElementById("ID").value.length - 1);
        alert(str.substring(str.length - 1) + " is an invalid character. Use an alphabetic character or - , ' ꞌ[saltillo] ( )  [space]");
        str = str.substring(0, str.length - 1);
        if (str.length == 0) {
            document.getElementById("ID").innerHTML = '';
        }
        return;
    }
    if (str.length <= 2) {
        document.getElementById("LangSearch").innerHTML = '';
        document.getElementById("CountSearch").innerHTML = '';
        $("#showSearchCountry").hide();
        $("#showCountryID").hide();
        $("#listCountriesID").hide();
        $("#mainContent").hide();
        $("#whiteOpaque").hide();
        $("#feedback").show();
        $("#copyright").show();
        return;
    }

    // iOS Asset Package
    if (asset == 1) {
        showiOSLanguage(str, st, Internet); // go to showiOSLanguage
        return;
    }

    xmlhttp = getHTTPObject(); // the ISO object (see JavaScript function getHTTPObject() above)
    if (xmlhttp == null) {
        return;
    }
    var color = '';
    var table = '';
    var Country_Total = [];

    lnxmlhttp = getHTTPObject(); // the ISO object (see JavaScript function getHTTPObject() above)
    if (lnxmlhttp == null) {
        return;
    }

    Scriptname = window.location.href;

    /*lnxmlhttp.open("GET", "../include/nav_ln_array.php?q=" + st, true);
    lnxmlhttp.send(null);
    lnxmlhttp.onreadystatechange = function() {
        if (lnxmlhttp.readyState == 4) {
            // Get hold of the array and change scriptname?
            Scriptname = lnxmlhttp.responseText;
        }
    }*/

    /****************************************************************************************************************
    	AJAX - languageSearch.php
    ****************************************************************************************************************/
    var url = "LSearch.php";
    url = url + "?language=" + str;
    url = url + "&st=" + st;
    url = url + "&sid=" + Math.random();
    xmlhttp.open("GET", url, true); // open the AJAX object with livesearch.php
    xmlhttp.send(null);
    xmlhttp.onreadystatechange = function() { // the function that returns for AJAX object
        if (xmlhttp.readyState == 4) { // if the readyState = 4 then livesearch is displayed
            var splits = xmlhttp.responseText.split('<br />'); // Display all of the languages that have 'language' as a part of it.
            document.getElementById("LangSearch").innerHTML = '';
            document.getElementById("CountSearch").innerHTML = '';
            if (splits.length == 1 && splits[0].indexOf('|') === -1) {
                langNotFound = splits[0];
                document.getElementById("LangSearch").innerHTML = '<div style="display: inline; padding: 10px; margin-left: auto; margin-right: auto; color: red; background-color: white; font-size: 1.3em; "> ' + langNotFound + '</div>';
                document.getElementById("CountrySearch").innerHTML = '';
                $("#showSearchCountry").hide();
                return;
            }
            $("#feedback").hide();
            $("#copyright").hide();
            // the 'table' is caused by a buy in Firefox 63.0.1 (11/7/2018) thus I added the last 3 items
            colCountry = splits[splits.length - 1]; // subtract 1 from splits.length
            colCode = splits[splits.length - 2]; // subtract 1 from splits.length
            colAlt = splits[splits.length - 3]; // subtract 1 from splits.length
            colLN = splits[splits.length - 4]; // subtract 1 from splits.length
            table = '<div class="langCol">';
            table += '<div class="colFirst">';
            table += '<p class="colLN1">' + colLN + '</p>';
            table += '<p class="colCountry1">' + colCountry + '</p>';
            table += '<p class="colCode1">' + colCode + '</p>';
            table += '<p class="colAlt1">' + colAlt + '</p>';
            table += '</div>';
            for (var i = 0; i < splits.length - 4; i++) {
                table += "<p style='line-height: 2px; '>&nbsp;</p>"; // empty line between records
                var firstSplit = splits[i].split('|');
                // $LN.'|'.$alt.'|'.$iso.'|'.$country.'|'.$rod.'|'.$VD.'|'.$idx;
                var LN = firstSplit[0];
                var alt = firstSplit[1];
                var iso = firstSplit[2];
                var country = firstSplit[3];
                var rod = firstSplit[4];
                var VD = firstSplit[5];
                var idx = firstSplit[6];
                // Cross Site Scripting (XSS) attack happens where client side code (usually JavaScript) gets injected into the output of your PHP script. The next line cleans it up.
                table += "<div class='colSecond'>";
                table += "<div class='colLN2' onclick='window.open(\"" + Scriptname + "?idx=" + idx + "&language=" + LN + "&iso_code=" + iso + "\", \"_self\")'>" + LN;
                if (VD != '') { table += "<div>(" + VD + ")</div>" };
                table += "</div>";
                table += "<p class='colCountry2'>";
                var countrySplit = country.split(', '); // full country name : ZZ abbreviated country name
                for (var k = 0; k < countrySplit.length; k++) {
                    var tempCountry = countrySplit[k].substring(0, countrySplit[k].length - 3); // full country name (split ':')
                    var tempAbbCountry = countrySplit[k].substring(countrySplit[k].length - 2); // ZZ abbreviated country name (split ':')
                    table += '<span style="font-size: .9em; cursor: pointer; " onclick="window.open(\'./' + Scriptname + '?sortby=country&name=' + tempAbbCountry + '\', \'_self\')">' + tempCountry + '</span>, ';
                }
                table = table.substring(0, table.length - 2); // take out the last ', '
                table += "</p>";
                table += "<div class='colCode2' onclick='window.open(\"" + Scriptname + "?idx=" + idx + "&language=" + LN + "&iso_code=" + iso + "\", \"_self\")'>" + iso + "</div>";
                table += "<div class='colAlt2' onclick='window.open(\"" + Scriptname + "?idx=" + idx + "&language=" + LN + "&iso_code=" + iso + "\", \"_self\")'>" + alt + "</div>";
                table += "</div>";
            }
            table += "<br /><br />";
            table += "<div style='color: #777; font-size: .8em; '>ScriptureEarth.org</div><br />";
            table += "</div>";
            document.getElementById("LangSearch").innerHTML = table;
        }
    }
}

function send(sel) {
    // languageName = 'block'; which = 2
    // languageCode = 'block'; which = 1
    var which = 0;
    try {
        window.open("LangSearch.php?st=" + sel.options[sel.selectedIndex].value.toLowerCase(), "_self");
    } catch (err) {
        window.open("LangSearch.php?st=eng", "_self");
    }
}

function showCountry(str, st, Internet, asset) { // get the names of the country
    if (str.length == 0) {
        document.getElementById("CountSearch").innerHTML = '';
        $("#showLanguageID").show();
        $("#listCountriesID").show();
        $("#mainContent").show();
        $("#whiteOpaque").show();
        return;
    }
    if (str.length == 1) {
        document.getElementById("LangSearch").innerHTML = '';
        $("#showSearchCountry").hide();
        $("#showLanguageID").hide();
        $("#listCountriesID").hide();
        $("#mainContent").hide();
        $("#whiteOpaque").hide();
    }
    var nonLatinScript = 0;
    if (/\p{Script=Han}/u.test(str.substring(str.length - 1)) || /[\u3040-\u30ff\u3400-\u4dbf\u4e00-\u9fff\uf900-\ufaff\uff66-\uff9f]/.test(str.substring(str.length - 1))) { // https://stackoverflow.com/questions/21109011/javascript-unicode-string-chinese-character-but-no-punctuation
        nonLatinScript = 1;
    } else {
        // saltillo: ꞌ; U+A78C
        var re = /[-. ,'ꞌ()A-Za-záéíóúÑñçãõâêîôûäëöüï&]/;
        var foundArray = re.exec(str.substring(str.length - 1)); // the last character of the str
        if (!foundArray) { // is the value of the last character of the str isn't A-Za - z then it returns
            document.getElementById("CID").value = document.getElementById("CID").value.substring(0, document.getElementById("CID").value.length - 1);
            alert(str.substring(str.length - 1) + " is an invalid character. Use an alphabetic character.");
            str = str.substring(0, str.length - 1);
            if (str.length == 0) {
                document.getElementById("CID").innerHTML = "";
            }
            return;
        }
    }

    // iOS Asset Package
    if (asset == 1) {
        showiOSCountry(str, st, Internet); // go to showiOSLanguage
        return;
    }

    Scriptname = window.location.href; // e.g. https://www.scriptureearth.org/00i-Scripture_Index.php, http://localhost:90/00cmn.php, etc.

    /*lnxmlhttp = getHTTPObject(); // the ISO object (see JavaScript function getHTTPObject() above)
    if (lnxmlhttp == null) {
        return;
    }

    lnxmlhttp.open("GET", "../include/nav_ln_array.php?q=" + st, true)
    lnxmlhttp.send(null)
    lnxmlhttp.onreadystatechange = function() {
        if (lnxmlhttp.readyState == 3) {
            // Get hold of the array and change scriptname?
            Scriptname = lnxmlhttp.responseText;
        }
    }*/

    Countryxmlhttp = getHTTPObject(); // the ISO object (see JavaScript function getHTTPObject() above)
    if (Countryxmlhttp == null) {
        return;
    }
    /****************************************************************************************************************
    	AJAX - languageSearch.php
    ****************************************************************************************************************/
    var url = "CSearch.php";
    url = url + "?country=" + str;
    if (st == 'cmn' && nonLatinScript == 0) { // test to see if st = Chinese and if it's Latin
        url = url + "&st=eng";
    } else {
        url = url + "&st=" + st;
    }
    url = url + "&sid=" + Math.random();
    Countryxmlhttp.open("GET", url, true); // open the AJAX object
    Countryxmlhttp.send(null);
    Countryxmlhttp.onreadystatechange = function() { // the function that returns for AJAX object
        if (Countryxmlhttp.readyState == 4) { // if the readyState = 4 then livesearch is displayed
            var splits = Countryxmlhttp.responseText.split('<br />'); // Display all of the languages that have 'language' as a part of it.
            document.getElementById("LangSearch").innerHTML = '';
            document.getElementById("CountrySearch").innerHTML = '';
            if (splits.length == 1 && splits[0].indexOf('|') === -1) {
                countryNotFound = splits[0];
                document.getElementById("CountSearch").innerHTML = '<div style="display: inline; padding: 10px; margin-left: auto; margin-right: auto; color: red; background-color: white; font-size: 1.2em; "> ' + countryNotFound + '</div>';
                return;
            }
            var Country_Total = '';
            colCountries = splits[splits.length - 1]; // subtract 1 from splits.length
            Country_Total = '<div class="countryTitle"><div class="countryTitleLine">' + colCountries + ':</div>';
            for (var i = 0; i < splits.length - 1; i++) {
                var firstSplit = splits[i].split('|'); // split the 2: specific country and two uppercase code for the country
                var Country = firstSplit[0];
                var ISO_Country = firstSplit[1];
                Country_Total += '<div class="pickCountry" onclick="window.open(\'' + Scriptname + '?sortby=country&name=' + ISO_Country + '\', \'_self\')">' + Country + '</div>';
            }
            Country_Total += '</div>';
            document.getElementById("CountSearch").innerHTML = Country_Total;
        }
    }
}

function AllCountries(Scriptname, st, SpecificCountry, Internet, asset) {
    st = st.substr(0, 1).toUpperCase() + st.substr(1, 2);
    document.getElementById("LangSearch").innerHTML = '';
    document.getElementById("CountSearch").innerHTML = '';
    $("#showLanguageID").hide();
    $("#showCountryID").hide();
    $("#mainContent").hide();
    $("#whiteOpaque").hide();

    // iOS Asset Package
    if (asset == 1) {
        AlliOSCountries(Scriptname, st, SpecificCountry, Internet); // go to showiOSLanguage
        return;
    }

    AllCountriesxmlhttp = getHTTPObject(); // the ISO object (see JavaScript function getHTTPObject() above)
    if (AllCountriesxmlhttp == null) {
        return;
    }
    /****************************************************************************************************************
    	AJAX - languageSearch.php
    ****************************************************************************************************************/
    var url = "AllCountries.php";
    url = url + "?SpecificCountry=" + SpecificCountry;
    url = url + "&st=" + st;
    url = url + "&sid=" + Math.random();
    AllCountriesxmlhttp.open("GET", url, true); // open the AJAX object with livesearch.php
    AllCountriesxmlhttp.send(null);
    AllCountriesxmlhttp.onreadystatechange = function() { // the function that returns for AJAX object
        if (AllCountriesxmlhttp.readyState == 4) { // if the readyState = 4 then livesearch is displayed
            var splits = AllCountriesxmlhttp.responseText.split('<br />'); // Display all of the languages that have 'language' as a part of it.
            document.getElementById("countryList").innerHTML = '';
            if (splits.length == 1 && splits[0].indexOf('|') === -1) {
                countryNotFound = splits[0];
                document.getElementById("countryList").innerHTML = '<div style="display: inline; padding: 10px; margin-left: auto; margin-right: auto; color: red; background-color: white; font-size: 1.2em; "> ' + countryNotFound + '</div>';
                return;
            }
            var AllCountries_Total = '';
            for (var i = 0; i < splits.length - 1; i++) {
                var firstSplit = splits[i].split('|'); // split the 2: specific country and two uppercase code for the country
                var Country = firstSplit[0];
                var ISO_Country = firstSplit[1];
                AllCountries_Total += '<div class="pickCountry" onclick="window.open(\'./' + Scriptname + '?sortby=country&name=' + ISO_Country + '\', \'_self\')">' + Country + '</div>';
            }
            AllCountries_Total += '</div>';
            document.getElementById("countryList").innerHTML = AllCountries_Total;
        }
    }
    $("#countryList").show();
    $("#listCountriesID").show();
    $(".homeAllCountries").show();
}

// Web Workers API
var NavLang = "";

function about(st) {
    document.getElementById("LangSearch").innerHTML = '';
    document.getElementById("CountSearch").innerHTML = '';
    $("#showLanguageID").hide();
    $("#showCountryID").hide();
    $("#listCountriesID").hide();
    $("#whiteOpaque").hide();
    $("#countryList").hide();
    $("#myShadow").hide();
    $("#myForm").hide();
    $("#about").hide();
    $(".homeAllCountries").hide();
    $(".site").show();
    $("#statements").show();

    //if (typeof(Worker) !== "undefined") {
    if (NavLang == st) {
        return;
    }

    // Web Workers API
    var w;
    NavLang = st;
    if (typeof(w) == "undefined") {
        w = new Worker("./_js/about_" + st + "_workers.js");
    }
    w.onmessage = function(event) {
        document.getElementById("results").innerHTML = event.data;
    };
}

function aboutLang(st) {
    window.open("include/aboutLang.inc.php?st=" + st, "_self");
}

function loadWindow(ml, CTPHC, Window) {
    window.open("00" + ml + "-CTPHC.php?I=" + CTPHC + "&Window=" + Window);
}

$('#sM').on('selectmenuchange', function() {
    var Scriptname = $('#sM').val();
    window.open(Scriptname, "_self");
});

/*$('#sC').on('selectmenuchange', function() {
	var Scriptname = $('#sC').val();
	window.open(Scriptname, "_self");
});*/

/*$('#sL').on('selectmenuchange', function() {
alert("Z");
	var Scriptname = $('#sL').val();
	window.open(Scriptname, "_self");
});*/

function langChange(idx, LN, ISO) {
    var cL = document.getElementById('sL').value;
    window.open(cL + "?idx=" + idx + "&LN=" + LN + "&ISO=" + ISO, '_self');
}

function countryChange(country) {
    var cC = document.getElementById('sC').value;
    window.open(cC + "?sortby=country&name=" + country, '_self');
}

function RemoveAccents(str) {
    var accents = 'ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëðÇçÐÌÍÎÏìíîïÙÚÛÜùúûüÑñŠšŸÿýŽž';
    var accentsOut = 'AAAAAAaaaaaaOOOOOOooooooEEEEeeeeeCcDIIIIiiiiUUUUuuuuNnSsYyyZz';
    str = str.split('');
    var strLen = str.length;
    var i, x;
    for (i = 0; i < strLen; i++) {
        if ((x = accents.indexOf(str[i])) != -1) {
            str[i] = accentsOut[x];
        }
    }
    return str.join('');
}


// var without_accents = makeSortString("wïthêüÄTrèsBïgüeAk100t");
makeSortString = (function() {
    var translate_re = /[áàâãäåÀÁÂÃÄÅÆçÇÐÐèéêëÈÊË€ìíîïìÌÍÎÏÌñÑòóôõöøÒÓÔÕÖØŒšßŠùúûüÙÚÛÜýÿÝŸžŽ]/g;
    var translate = {
        "á": "a",
        "à": "a",
        "â": "a",
        "ã": "a",
        "ä": "a",
        "å": "a",
        "À": "A",
        "Á": "A",
        "Â": "A",
        "Ã": "A",
        "Ä": "A",
        "Å": "A",
        "Æ": "A",
        "ç": "c",
        "Ç": "C",
        "Ð": "D",
        "Ð": "D",
        "è": "e",
        "é": "e",
        "ê": "e",
        "ë": "e",
        "È": "E",
        "Ê": "E",
        "Ë": "E",
        "€": "E",
        "ì": "i",
        "í": "i",
        "î": "i",
        "ï": "i",
        "ì": "i",
        "Ì": "I",
        "Í": "I",
        "Î": "I",
        "Ï": "I",
        "Ì": "I",
        "ñ": "n",
        "Ñ": "N",
        "ò": "o",
        "ó": "o",
        "ô": "o",
        "õ": "o",
        "ö": "o",
        "ø": "o",
        "Ò": "O",
        "Ó": "O",
        "Ô": "O",
        "Õ": "O",
        "Ö": "O",
        "Ø": "O",
        "Œ": "O",
        "š": "s",
        "ß": "s",
        "Š": "S",
        "ù": "u",
        "ú": "u",
        "û": "u",
        "ü": "u",
        "Ù": "U",
        "Ú": "U",
        "Û": "U",
        "Ü": "U",
        "ý": "y",
        "ÿ": "y",
        "Ý": "Y",
        "Ÿ": "Y",
        "ž": "z",
        "Ž": "Z"
    };
    return function(s) {
        return (s.replace(translate_re, function(match) { return translate[match]; }));
    }
})();


/*****************************************************************************************************************
	iOS -- showiOSLanguage()
*****************************************************************************************************************/
function showiOSLanguage(str, st, Internet) { // get the names of the languages
    if (Internet == 0) {
        alert('ScriptureEarth.org is offline. Therefore, iOS app is not avaiable.');
        return;
    }
    xmlhttp = getHTTPObject(); // the ISO object (see JavaScript function getHTTPObject() above)
    if (xmlhttp == null) {
        return;
    }
    var color = '';
    var table = '';
    var Country_Total = [];
    lnxmlhttp = getHTTPObject(); // the ISO object (see JavaScript function getHTTPObject() above)
    if (lnxmlhttp == null) {
        return;
    }
    Scriptname = '';

    lnxmlhttp.open("GET", "../include/nav_ln_array.php?q=" + st, true)
    lnxmlhttp.send(null)
    lnxmlhttp.onreadystatechange = function() {
            if (lnxmlhttp.readyState == 3) {
                // Get hold of the array and change scriptname?
                Scriptname = lnxmlhttp.responseText;
            }
        }
        /****************************************************************************************************************
        	AJAX - LiOSSearch.php
        ****************************************************************************************************************/
    var url = "LiOSSearch.php";
    url = url + "?language=" + str;
    url = url + "&st=" + st;
    url = url + "&sid=" + Math.random();
    xmlhttp.open("GET", url, true); // open the AJAX object with livesearch.php
    xmlhttp.send(null);
    xmlhttp.onreadystatechange = function() { // the function that returns for AJAX object
        if (xmlhttp.readyState == 4) { // if the readyState = 4 then livesearch is displayed
            var splits = xmlhttp.responseText.split('<br />'); // Display all of the languages that have 'language' as a part of it.
            document.getElementById("LangSearch").innerHTML = '';
            document.getElementById("CountSearch").innerHTML = '';
            if (splits.length == 1 && splits[0].indexOf('|') === -1) {
                langNotFound = splits[0];
                document.getElementById("LangSearch").innerHTML = '<div style="display: inline; padding: 10px; margin-left: auto; margin-right: auto; color: red; background-color: white; font-size: 1.3em; "> ' + langNotFound + '</div>';
                document.getElementById("CountrySearch").innerHTML = '';
                $("#showSearchCountry").hide();
                return;
            }
            $("#feedback").hide();
            $("#copyright").hide();
            // the 'table' is caused by a buy in Firefox 63.0.1 (11/7/2018) thus I added the last 3 items
            colCountry = splits[splits.length - 1]; // subtract 1 from splits.length
            colCode = splits[splits.length - 2]; // subtract 1 from splits.length
            colAlt = splits[splits.length - 3]; // subtract 1 from splits.length
            colLN = splits[splits.length - 4]; // subtract 1 from splits.length
            table = '<div class="langCol">';
            table += '<div class="colFirst">';
            table += '<p class="colLN1">' + colLN + '</p>';
            table += '<p class="colCountry1">' + colCountry + '</p>';
            table += '<p class="colCode1">' + colCode + '</p>';
            table += '<p class="colAlt1">' + colAlt + '</p>';
            table += '</div>';
            for (var i = 0; i < splits.length - 4; i++) {
                table += "<p style='line-height: 2px; '>&nbsp;</p>"; // empty line between records
                var firstSplit = splits[i].split('|');
                // $LN.'|'.$alt.'|'.$iso.'|'.$country.'|'.$rod.'|'.$VD.'|'.$idx;
                var LN = firstSplit[0];
                var alt = firstSplit[1];
                var iso = firstSplit[2];
                var country = firstSplit[3];
                var rod = firstSplit[4];
                var VD = firstSplit[5];
                var idx = firstSplit[6];
                var URL = firstSplit[7];
                // Cross Site Scripting (XSS) attack happens where client side code (usually JavaScript) gets injected into the output of your PHP script. The next line cleans it up.
                table += "<div class='colSecond'>";
                // here - check
                table += "<div class='colLN2' onclick='iOSLanguage(\"" + st + "\"," + idx + ",\"" + LN + "\",\"" + URL + "\")'>" + LN;
                if (VD != '') { table += "<div>(" + VD + ")</div>" };
                table += "</div>";
                table += "<p class='colCountry2'>";
                var countrySplit = country.split(', '); // full country name : ZZ abbreviated country name
                for (var k = 0; k < countrySplit.length; k++) {
                    var tempCountry = countrySplit[k].substring(0, countrySplit[k].length - 3); // full country name (split ':')
                    var tempAbbCountry = countrySplit[k].substring(countrySplit[k].length - 2); // ZZ abbreviated country name (split ':')
                    // here - check
                    //table += '<span style="font-size: .9em; cursor: pointer; " onclick="window.open(\'./' + Scriptname + '?sortby=country&name=' + tempAbbCountry + '\', \'_self\')">' + tempCountry + '</span>, ';
                    table += tempCountry + ', ';
                }
                table = table.substring(0, table.length - 2); // take out the last ', '
                table += "</p>";
                // here - check
                table += "<div class='colCode2' onclick='iOSLanguage(\"" + st + "\"," + idx + ",\"" + LN + "\",\"" + URL + "\")'>" + iso + "</div>";
                // here - check
                table += "<div class='colAlt2' onclick='iOSLanguage(\"" + st + "\"," + idx + ",\"" + LN + "\",\"" + URL + "\")'>" + alt + "</div>";
                table += "</div>";
            }
            table += "<br /><br />";
            table += "<div style='color: #777; font-size: .8em; '>ScriptureEarth.org</div><br />";
            table += "</div>";
            document.getElementById("LangSearch").innerHTML = table;
        }
    }
}

/*****************************************************************************************************************
	iOS -- showiOSCountry(str, st)
*****************************************************************************************************************/
function showiOSCountry(str, st, Internet) { // get the names of the country
    if (Internet == 0) {
        alert('ScriptureEarth in not online. iOS app is not avaiable.');
        return;
    }
    Countryxmlhttp = getHTTPObject(); // the ISO object (see JavaScript function getHTTPObject() above)
    if (Countryxmlhttp == null) {
        return;
    }
    lnxmlhttp = getHTTPObject(); // the ISO object (see JavaScript function getHTTPObject() above)
    if (lnxmlhttp == null) {
        return;
    }
    Scriptname = '';

    lnxmlhttp.open("GET", "../include/nav_ln_array.php?q=" + st, true)
    lnxmlhttp.send(null)
    lnxmlhttp.onreadystatechange = function() {
            if (lnxmlhttp.readyState == 3) {
                // Get hold of the array and change scriptname?
                Scriptname = lnxmlhttp.responseText;
            }
        }
        /****************************************************************************************************************
        	AJAX - CiOSSearch.php
        ****************************************************************************************************************/
    var url = "CiOSSearch.php";
    url = url + "?country=" + str;
    url = url + "&st=" + st;
    url = url + "&sid=" + Math.random();
    Countryxmlhttp.open("GET", url, true); // open the AJAX object
    Countryxmlhttp.send(null);
    Countryxmlhttp.onreadystatechange = function() { // the function that returns for AJAX object
        if (Countryxmlhttp.readyState == 4) { // if the readyState = 4 then livesearch is displayed
            var splits = Countryxmlhttp.responseText.split('<br />'); // Display all of the languages that have 'language' as a part of it.
            document.getElementById("LangSearch").innerHTML = '';
            document.getElementById("CountrySearch").innerHTML = '';
            if (splits.length == 1 && splits[0].indexOf('|') === -1) {
                countryNotFound = splits[0];
                document.getElementById("CountSearch").innerHTML = '<div style="display: inline; padding: 10px; margin-left: auto; margin-right: auto; color: red; background-color: white; font-size: 1.2em; "> ' + countryNotFound + '</div>';
                return;
            }
            var Country_Total = '';
            colCountries = splits[splits.length - 1]; // subtract 1 from splits.length
            Country_Total = '<div class="countryTitle"><div class="countryTitleLine">' + colCountries + ':</div>';
            for (var i = 0; i < splits.length - 1; i++) {
                var firstSplit = splits[i].split('|'); // split the 2: specific country and two uppercase code for the country
                var Country = firstSplit[0];
                var ISO_Country = firstSplit[1];
                // here - check
                Country_Total += '<div class="pickCountry" onclick="window.open(\'./' + Scriptname + '?sortby=country&asset=1&name=' + ISO_Country + '\', \'_self\')">' + Country + '</div>';
            }
            Country_Total += '</div>';
            document.getElementById("CountSearch").innerHTML = Country_Total;
        }
    }
}

/*****************************************************************************************************************
	iOS -- AlliOSCountries()
*****************************************************************************************************************/
function AlliOSCountries(Scriptname, st, SpecificCountry, Internet) {
    if (Internet == 0) {
        alert('ScriptureEarth in not online. iOS app is not avaiable.');
        return;
    }
    AllCountriesxmlhttp = getHTTPObject(); // the ISO object (see JavaScript function getHTTPObject() above)
    if (AllCountriesxmlhttp == null) {
        return;
    }
    /****************************************************************************************************************
    	AJAX - AlliOSCountries.php
    ****************************************************************************************************************/
    var url = "AlliOSCountries.php";
    url = url + "?SpecificCountry=" + SpecificCountry;
    url = url + "&st=" + st;
    url = url + "&sid=" + Math.random();
    AllCountriesxmlhttp.open("GET", url, true); // open the AJAX object
    AllCountriesxmlhttp.send(null);
    AllCountriesxmlhttp.onreadystatechange = function() { // the function that returns for AJAX object
        if (AllCountriesxmlhttp.readyState == 4) { // if the readyState = 4 then livesearch is displayed
            var splits = AllCountriesxmlhttp.responseText.split('<br />'); // Display all of the languages that have 'language' as a part of it.
            document.getElementById("countryList").innerHTML = '';
            if (splits.length == 1 && splits[0].indexOf('|') === -1) {
                countryNotFound = splits[0];
                document.getElementById("countryList").innerHTML = '<div style="display: inline; padding: 10px; margin-left: auto; margin-right: auto; color: red; background-color: white; font-size: 1.2em; "> ' + countryNotFound + '</div>';
                return;
            }
            var AllCountries_Total = '';
            for (var i = 0; i < splits.length - 1; i++) {
                var firstSplit = splits[i].split('|'); // split the 2: specific country and two uppercase code for the country
                var Country = firstSplit[0];
                var ISO_Country = firstSplit[1];
                // here - check
                AllCountries_Total += '<div class="pickCountry" onclick="window.open(\'./' + Scriptname + '?sortby=country&asset=1&name=' + ISO_Country + '\', \'_self\')">' + Country + '</div>';
            }
            AllCountries_Total += '</div>';
            document.getElementById("countryList").innerHTML = AllCountries_Total;
        }
    }
    $("#countryList").show();
    $("#listCountriesID").show();
    $(".homeAllCountries").show();
}

// here function - check
function iOSLanguage(st, idx, LN, URL) {
    if (URL.startsWith("http://") || URL.startsWith("https://")) {
        if (URL.endsWith(".zip")) {
            const link = document.createElement("a");
            //			link.href = 'data:application/zip,'+URL;
            link.href = URL;
            link.download = URL.substr(URL.lastIndexOf('/') + 1);
            link.click();
        } else {
            window.open(URL, '_blank');
        }
    } else if (URL.startsWith("asset://")) {
        //        URL = URL.replace("asset://", "https://");
        const link = document.createElement("a");
        //		link.href = 'data:application/zip,'+URL;
        link.href = URL;
        link.download = URL.substr(URL.lastIndexOf('/') + 1);
        link.click();
    } else {
        alert('This isnt suppose to happen! (LangSearch.js function iOSLanguage)');
    }

    //alert('Asset package was downloaded for '+LN+'.');

    lnxmlhttp = getHTTPObject(); // the ISO object (see JavaScript function getHTTPObject() above)
    if (lnxmlhttp == null) {
        return;
    }
    Scriptname = '';

    lnxmlhttp.open("GET", "../include/nav_ln_array.php?q=" + st, true)
    lnxmlhttp.send(null)
    lnxmlhttp.onreadystatechange = function() {
        if (lnxmlhttp.readyState == 3) {
            // Get hold of the array and change scriptname?
            Scriptname = lnxmlhttp.responseText;
        }
    }

    window.open(Scriptname + '?asset=1', '_self');

    return;
}