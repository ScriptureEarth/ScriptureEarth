// JavaScript Document
// SpecificLanguage.js
// Created by Scott Starker

let ZipFilesOT = 0;
function OTAudioClick(a_index, Books) { // check box name, the book
    if (document.getElementById("OT_audio_" + a_index).checked) {
        ZipFilesOT += Books;
    } else {
        ZipFilesOT -= Books;
    }
    ZipFilesOT = Math.round(ZipFilesOT * 100) / 100; // rounded just does integers!
    if (ZipFilesOT <= 0.049) {
        $("#OT_Download_MB").hide();
    } else {
        $("#OT_Download_MB").show();
        document.getElementById("OT_Download_MB").innerHTML = "~" + ZipFilesOT + " MB&nbsp;";
    }
}

let ZipFilesNT = 0;
function NTAudioClick(a_index, Books) { // check box name, the book
    if (document.getElementById("NT_audio_" + a_index).checked) {
        ZipFilesNT += Books;
    } else {
        ZipFilesNT -= Books;
    }
    ZipFilesNT = Math.round(ZipFilesNT * 100) / 100; // rounded just does integers!
    if (ZipFilesNT <= 0.049) {
        $("#NT_Download_MB").hide();
    } else {
        $("#NT_Download_MB").show();
        document.getElementById("NT_Download_MB").innerHTML = "~" + ZipFilesNT + " MB&nbsp;";
    }
}

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

function send(sel, GN) {
    //SwitchArray = sel.options[sel.selectedIndex].value.split("|");
    //number = SwitchArray[1];
    //BegLetter = SwitchArray[2];
    // hack! The best way to the Beg in js so it can be passed from JavaScript function Send(zzz, zzz) in SpecificLanguage.js called by 00-MainScript.inc.php.
    let Beg = document.getElementById('myBeg').innerHTML;
    // languageName = 'block'; which = 2
    // languageCode = 'block'; which = 1
    let which = 0;
    if (document.getElementById('languageCode').style.display == 'block') {
        which = 1;
    } else {
        which = 2;
    }

    lnxmlhttp = getHTTPObject(); // the ISO object (see JavaScript function getHTTPObject() above)
    if (lnxmlhttp == null) {
        return;
    }
    Scriptname = '';

    lnxmlhttp.open("GET", "../include/nav_ln_array.php?q=" + sel.options[sel.selectedIndex].value, true)
    lnxmlhttp.send(null)
    lnxmlhttp.onreadystatechange = function() {
        if (lnxmlhttp.readyState == 3) {
            // Get hold of the array and change scriptname?
            window.open(lnxmlhttp.responseText + "?sortby=country&name=" + GN + "&number=" + which + "&Beg=" + Beg, "_self");
        }
    }
}

function langSend(sel, iso, rod, variant) {
    lnxmlhttp = getHTTPObject(); // the ISO object (see JavaScript function getHTTPObject() above)
    if (lnxmlhttp == null) {
        return;
    }
    Scriptname = '';

    lnxmlhttp.open("GET", "../include/nav_ln_array.php?q=" + sel.options[sel.selectedIndex].value, true)
    lnxmlhttp.send(null)
    lnxmlhttp.onreadystatechange = function() {
        if (lnxmlhttp.readyState == 3) {
            // Get hold of the array and change scriptname?
            window.open(lnxmlhttp.responseText + "?sortby=lang&iso=" + iso + "&rod=" + rod + "&var=" + variant, "_self");
        }
    }
}

function sendCountries_m(sel) {
    lnxmlhttp = getHTTPObject(); // the ISO object (see JavaScript function getHTTPObject() above)
    if (lnxmlhttp == null) {
        return;
    }
    Scriptname = '';

    lnxmlhttp.open("GET", "../include/nav_ln_array.php?q=" + sel.options[sel.selectedIndex].value, true)
    lnxmlhttp.send(null)
    lnxmlhttp.onreadystatechange = function() {
        if (lnxmlhttp.readyState == 3) {
            // Get hold of the array and change scriptname?
            window.open(lnxmlhttp.responseText, "_self");
        }
    }
}

function sendCountry_m(sel, GN) {
    let which = 0;
    if (document.getElementById('languageCode').style.display == 'block') {
        which = 1;
    } else {
        which = 2;
    }

    lnxmlhttp = getHTTPObject(); // the ISO object (see JavaScript function getHTTPObject() above)
    if (lnxmlhttp == null) {
        return;
    }
    Scriptname = '';

    lnxmlhttp.open("GET", "../include/nav_ln_array.php?q=" + sel.options[sel.selectedIndex].value, true)
    lnxmlhttp.send(null)
    lnxmlhttp.onreadystatechange = function() {
        if (lnxmlhttp.readyState == 4) {
            // Get hold of the array and change scriptname?
            window.open(lnxmlhttp.responseText + "?sortby=country&name=" + GN + "&number=" + which, "_self");
        }
    }
}

let FCBHVisible = 0;
function FCBHClick(FCBHnumOfiframes) {
    FCBHnumOfiframes = typeof(FCBHnumOfiframes) != 'undefined' ? FCBHnumOfiframes : 1;
    let divHeight = 0;
    if (FCBHVisible == 0) {
        $("#FCBHb").show();
        FCBHVisible = 1;
    } else {
        $("#FCBHb").hide();
        FCBHVisible = 0;
    }
}

let OTTableVisible = 0;
function OTTableClick() {
    let divHeight = 0;
    if (OTTableVisible == 0) {
        $("#OTTable").show();
        OTTableVisible = 1;
    } else {
        $("#OTTable").hide();
        OTTableVisible = 0;
    }
}

let NTTableVisible = 0;
function NTTableClick() {
    //let intElemScrollTop = $(window).scrollTop();
    let divHeight = 0;
    if (NTTableVisible == 0) {
        //$("#NTTable").show(0, function() {			// 0 is to simulate display="block" immediatley
        // your codes to scrolltop comes here
        //$(window).scrollTop(intElemScrollTop);
        //});
        $("#NTTable").show();
        NTTableVisible = 1;
    } else {
        $("#NTTable").hide();
        NTTableVisible = 0;
    }
}

function iOSLanguage(st, idx, LN, assetURL) {
    if (assetURL.startsWith("http://") || assetURL.startsWith("https://")) {
        if (assetURL.endsWith(".zip")) {
            const link = document.createElement("a");
            //			link.href = 'data:application/zip,'+assetURL;
            link.href = assetURL;
            link.download = asssetURL.substr(assetURL.lastIndexOf('/') + 1);
            link.click();
        } else {
            window.open(assetURL, '_blank');
        }
    } else if (assetURL.startsWith("asset://")) {
		// "procolor not defined" - it seems that "asset:" isn't a procolor!
  		//location.protocol = 'file:';							'file:' will not work nor 'https'
		//        URL = URL.replace("asset://", "https://");
        const link = document.createElement("a");
        //		link.href = 'data:application/zip,'+URL;
        link.href = assetURL;
        link.download = assetURL.substr(assetURL.lastIndexOf('/') + 1);
        link.click();
    } else {
        alert('This isnt suppose to happen! (LangSearch.js function iOSLanguage)');
    }

    Scriptname = window.location.pathname;

    //window.open(Scriptname + '?asset=1', '_self');

    return;
}
