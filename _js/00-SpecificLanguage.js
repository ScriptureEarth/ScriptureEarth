// JavaScript Document
// 00-SpecificLanguage.js
// Created by Scott Starker

var CT = []; // an array of country table from the database

var SABwin;

function setHeight() {
    "use strict";
    var divHeight = document.getElementById("container").offsetHeight; // once: body onLoad
    divHeight += 18;
    if (divHeight < 720) {
        divHeight = 720;
    }
    document.getElementById("container").style.height = divHeight + "px";

    // drop shadow using the whole 'container' window
    var myShadow = $("#container").dropShadow({ left: 5, top: 5, blur: 2, opacity: 0.5, color: "black", swap: false });
}

function LinkedCounter(c, URL) { // Bible.is, Jesus Film
    var filename = "counter/" + c + ".link";
    $(document).ready(function() {
        $.ajax({
            url: "LinkedCounter.php",
            data: { "LC": filename },
            success: function(result) {}
        });
    });
    window.open(URL, "_blank");
}

function loadWindow(ml, CTPHC, Window) {
    "use strict";
    window.open("00" + ml + "-CTPHC.php?I=" + CTPHC + "&Window=" + Window);
}

function BPDF(st, iso, rod, BookFilename) {
    "use strict";
    var url = "00-DownloadPDF.php?T=B&st=" + st + "&iso=" + iso + "&rod=" + rod + "&BookFilename=" + BookFilename;
    var w = window.open(url, "_normal", "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=400, height=320");
    return false; //cancels href action 
}

function SPDF(st, iso, rod, BookFilename) {
    "use strict";
    var url = "00-DownloadPDF.php?T=S&st=" + st + "&iso=" + iso + "&rod=" + rod + "&BookFilename=" + BookFilename;
    var w = window.open(url, "_normal", "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=400, height=320");
    return false; //cancels href action 
}

function OTPDF(st, iso, rod, BookFilename) {
    "use strict";
    var url = "00-DownloadPDF.php?T=OT&st=" + st + "&iso=" + iso + "&rod=" + rod + "&BookFilename=" + BookFilename;
    var w = window.open(url, "_normal", "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=400, height=320");
    return false; //cancels href action 
}

function NTPDF(st, iso, rod, BookFilename) {
    "use strict";
    var url = "00-DownloadPDF.php?T=NT&st=" + st + "&iso=" + iso + "&rod=" + rod + "&BookFilename=" + BookFilename;
    var w = window.open(url, "_normal", "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=400, height=320");
    return false; //cancels href action 
}

function Study(st, iso, rod, URL) {
    "use strict";
    var url = "00-DownloadStudy.php?st=" + st + "&iso=" + iso + "&rod=" + rod + "&URL=" + URL;
    var w = window.open(url, "_normal", "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=400, height=320");
    return false; //cancels href action 
}

function CellPhoneModule(st, iso, rod, CellPhoneFile) {
    "use strict";
    var url = "00-CellPhoneModule.php?T=OT&st=" + st + "&iso=" + iso + "&rod=" + rod + "&CellPhoneFile=" + CellPhoneFile;
    var w = window.open(url, "_normal", "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=400, height=320");
    return false; //cancels href action 
}

function OTAudio(st, iso, rod, mobile, text) {
    "use strict";
    var OT = "";
    var a_index;
    // 0 - 38 books
    for (var a = 0; a < 39; a++) {
        a_index = 'OT_audio_' + a.toString();
        if (document.getElementById(a_index) !== null) {
            if (document.getElementById(a_index).checked === true) {
                OT = OT + a_index.substring(a_index.lastIndexOf('_') + 1) + ",";
            }
        }
    }
    var url = "00-AudioSaveZip.php" + "?T=OT&st=" + st + "&iso=" + iso + "&rod=" + rod + "&Books=" + OT.substring(0, OT.length - 1);
    if (mobile == 0) { // this needs to stay at == not ===!
        var left = (screen.width / 2) - (440 / 2);
        var top = (screen.height / 2) - (360 / 2);
        var w = window.open(url, "_normal", "toolbar=no, location=no, directories=no, status=yes, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=440, height=360, top=" + top + ", left=" + left);
        w.document.body.innerHTML = "<div style='position: absolute; top: 0px; left: 0px; padding: 20px; background-color: #008ff7; width: 400px; height: 320px; '><h2 style='font-family: Arial, Helvetica, sans-serif; padding: 20px; margin-top: 80px; text-align: center; border: 4px solid white; background-color: #002f78; color: white; '>" + text + "</h2></div>";
    } else {
        var w = window.open(url, "_normal");
        w.document.body.innerHTML = "<div style='padding: 1.4em; background-color: #008ff7; width: 100%; height: 100%; '><h2 style='font-size: 2.6em; font-weight: bold; font-family: Arial, Helvetica, sans-serif; padding: 1.4em; margin-top: 4em; text-align: center; border: .4em solid white; background-color: #002f78; color: white; '>" + text + "</h2></div>";
    }
    return false; //cancels href action 
}

function NTAudio(st, iso, rod, mobile, text) {
    "use strict";
    var NT = "";
    var a_index;
    // 0 - 26 books
    for (var a = 0; a < 27; a++) {
        a_index = 'NT_audio_' + a.toString();
        if (document.getElementById(a_index) !== null) {
            if (document.getElementById(a_index).checked === true) {
                NT = NT + a_index.substring(a_index.lastIndexOf('_') + 1) + ",";
            }
        }
    }
    var url = "00-AudioSaveZip.php" + "?T=NT&st=" + st + "&iso=" + iso + "&rod=" + rod + "&Books=" + NT.substring(0, NT.length - 1);
    if (mobile == 0) { // this needs to stay at == not ===!
        var left = (screen.width / 2) - (440 / 2);
        var top = (screen.height / 2) - (360 / 2);
        var w = window.open(url, "_normal", "toolbar=no, location=no, directories=no, status=yes, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=440, height=360, top=" + top + ", left=" + left);
        w.document.body.innerHTML = "<div style='position: absolute; top: 0px; left: 0px; padding: 20px; background-color: #008ff7; width: 400px; height: 320px; '><h2 style='font-family: Arial, Helvetica, sans-serif; padding: 20px; margin-top: 80px; text-align: center; border: 4px solid white; background-color: #002f78; color: white; '>" + text + "</h2></div>";
    } else {
        var w = window.open(url, "_normal");
        w.document.body.innerHTML = "<div style='padding: 1.4em; background-color: #008ff7; width: 100%; height: 100%; '><h2 style='font-size: 2.6em; font-weight: bold; font-family: Arial, Helvetica, sans-serif; padding: 1.4em; margin-top: 4em; text-align: center; border: .4em solid white; background-color: #002f78; color: white; '>" + text + "</h2></div>";
    }
    return false; //cancels href action 
}

function PlaylistAudioZip(st, iso, rod, PlaylistGroupIndex, PlaylistIndexMax, mobile, text) {
    "use strict";
    var a_index = "";
    var PL = "";
    var temp = "";
    for (var a = 1; a <= PlaylistIndexMax; a++) {
        a_index = 'Playlist_audio_' + PlaylistGroupIndex + '_' + a.toString();
        if (document.getElementById(a_index) !== null) {
            if (document.getElementById(a_index).checked === true) {
                temp = document.getElementById(a_index).value;
                PL = PL + temp.substr(temp.lastIndexOf("/") + 1) + "|";
            }
        }
    }
    PL = PL.substring(0, PL.length - 1);
    var url = "00-PlaylistAudioSaveZip.php" + "?st=" + st + "&iso=" + iso + "&rod=" + rod + "&Books=" + PL;
    if (mobile == 0) { // this needs to stay at == not ===!
        var left = (screen.width / 2) - (440 / 2);
        var top = (screen.height / 2) - (360 / 2);
        var w = window.open(url, "_normal", "toolbar=no, location=no, directories=no, status=yes, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=440, height=360, top=" + top + ", left=" + left);
        w.document.body.innerHTML = "<div style='position: absolute; top: 0px; left: 0px; padding: 20px; background-color: #008ff7; width: 400px; height: 320px; '><h2 style='font-family: Arial, Helvetica, sans-serif; padding: 20px; margin-top: 80px; text-align: center; border: 4px solid white; background-color: #002f78; color: white; '>" + text + "</h2></div>";
    } else {
        var w = window.open(url, "_normal");
        w.document.body.innerHTML = "<div style='padding: 1.4em; background-color: #008ff7; width: 100%; height: 100%; '><h2 style='font-size: 2.6em; font-weight: bold; font-family: Arial, Helvetica, sans-serif; padding: 1.4em; margin-top: 4em; text-align: center; border: .4em solid white; background-color: #002f78; color: white; '>" + text + "</h2></div>";
    }
    return false; //cancels href action 
}

var AllDownloadAudioPlaylist = false;

function PlaylistAllAudioZip(PlaylistGroupIndex, PlaylistIndexMax, AllText, NoText) {
    "use strict";
    var Playlist_Download_MB = "Playlist_Download_MB_" + PlaylistGroupIndex.toString();
    var a_index = "";
    if (AllDownloadAudioPlaylist == false) {
        for (var a = 1; a <= PlaylistIndexMax; a++) {
            a_index = 'Playlist_audio_' + PlaylistGroupIndex + '_' + a.toString();
            document.getElementById(a_index).checked = true;
        }
        document.getElementById(Playlist_Download_MB).style.display = 'block';
        var MB = "MB_" + PlaylistGroupIndex.toString();
        var MB_Total_Amount = document.getElementById(MB).innerHTML;
        document.getElementById(Playlist_Download_MB).innerHTML = "~" + MB_Total_Amount + " MB";
        var AorN = "AllOrNone_" + PlaylistGroupIndex.toString();
        document.getElementById(AorN).value = NoText;
    } else {
        for (var a = 1; a <= PlaylistIndexMax; a++) {
            a_index = 'Playlist_audio_' + PlaylistGroupIndex + '_' + a.toString();
            document.getElementById(a_index).checked = false;
        }
        document.getElementById(Playlist_Download_MB).style.display = 'none';
        document.getElementById(Playlist_Download_MB).innerHTML = "";
        var AorN = "AllOrNone_" + PlaylistGroupIndex.toString();
        document.getElementById(AorN).value = AllText;
    }
    AllDownloadAudioPlaylist = AllDownloadAudioPlaylist == true ? false : true;
}

function AudioChangeChapters(WhichTestament, iso, rod, BookNumber) { // The array NumberOfChapters won't work. Hmmm...
    var Testament = "NT_Chapters_mp3";
    if (WhichTestament === "OT") {
        Testament = "OT_Chapters_mp3";
    }
    var elSel = document.getElementById(Testament);
    var i = 0;
    for (i = elSel.length - 1; i >= 0; i--) {
        elSel.remove(i); // first, delete all the 'option's
    }
    var Chapters = new Array();
    Chapters = BookNumber.split(','); // Split the BookNumber into an array where the ',' are separators
    var BookNumber = Chapters[0]; // The number of the Book of the Bible
    var Book = Major_NT_array[BookNumber];
    if (WhichTestament === "OT") {
        Book = Major_OT_array[BookNumber];
    }
    /*
    	This is not neccessary EXCEPT if the audio was not complete. I.e., if the books of the Bible
    	did not have all of the chapters. However, the chapter audio filenames have to be there.
    */
    for (i = 1; i < Chapters.length; i = i + 2) {
        var eNew = document.createElement('option'); // The 'var' needs to be there!
        eNew.text = Chapters[i];
        eNew.value = Book + "^data/" + iso + "/audio/" + Chapters[i + 1];
        try {
            elSel.add(eNew, null); // standards compliant; doesn't work in IE
        } catch (ex) {
            elSel.add(eNew); // IE only
        }
    }
}

function ListenAudio(mp3Info, autostart, whichListenTo, OTNT) {
    whichListenTo = typeof(whichListenTo) != 'undefined' ? whichListenTo : "";
    // whichListenTo = "OTListenNow" or "NTListenNow" or ""
    // autostart = true or false
    // mp3Info = array: number of the book of the Bible AND the audio filename
    // OTNT = 0 or 1 or 2 ($OT_Audio + $NT_Audio)
    OTNT = typeof(OTNT) != 'undefined' ? OTNT : 0;
    $("#jquery_jplayer_1").jPlayer("destroy");
    $("#jquery_jplayer_2").jPlayer("destroy");
    if (OTNT === 2) {
        $("#jquery_jplayer_2").jPlayer("destroy");
        setTimeout( // wait until the audio is done
            function() {
                //do something special
            }, 500);
    }
    var AudioFileName = new Array();
    AudioFileName = mp3Info.value.split('^'); // split the mp3Info into an array where the '^' are separators
    var listenBook = AudioFileName[0]; // the number of the book of the Bible 
    var listenFilename = AudioFileName[1]; // audio filename
    var divHeight = 0;
    var listenChapter = mp3Info.options[mp3Info.selectedIndex].text; // name of the chapter
    /*
    	I want to be able to print out
    		alert ("The mp3 file does not exists on server.");
    	but javascript does not have 'if filename exists on server' (only in AJAX).
    	[How about http://www.ScriptureEarth.org/data/[iso code]/audio/listenFilename?]
    */

    var jQuery_jPlayer = "";
    var newHTML = "";
    var cssSelector = "";
    if (whichListenTo === "OTListenNow") {
        newHTML = "<span id='OTBookChapter' style='vertical-align: top; '>" + listenBook + " " + listenChapter + "</span> &nbsp;&nbsp; ";
        jQuery_jPlayer = "#jquery_jplayer_2";
        cssSelector = "#jp_container_2";
    } else if (whichListenTo === "NTListenNow") {
        newHTML = "<span id='NTBookChapter' style='vertical-align: top; '>" + listenBook + " " + listenChapter + "</span> &nbsp;&nbsp; ";
        jQuery_jPlayer = "#jquery_jplayer_1";
        cssSelector = "#jp_container_1";
    } else {}
    $(jQuery_jPlayer).jPlayer({ // create jPlayer
        ready: function(event) {
            $(this).jPlayer("setMedia", {
                mp3: listenFilename // audio filename
            }).jPlayer("play"); // Attempt to auto play the media
        },
        volume: 0.6, // volume from 0 to 1
        repeat: false,
        swfPath: "_js",
        supplied: "mp3",
        cssSelectorAncestor: cssSelector, // this isn't stated for only one jPlayer
        wmode: "window",
        smoothPlayBar: true,
        keyEnabled: true,
        ended: function(event) { // "ended" event automatically fired every time the chapter is ended
            // Add 1 to the chapter and then continue to play.
        }
    });

    if (whichListenTo === 'OTListenNow') {
        document.getElementById('OTBookChapter').innerHTML = newHTML;
        if (document.getElementById('OTListenNow').style.display !== "block") {
            document.getElementById('OTListenNow').style.marginLeft = "0px";
            $('#OTListenNow').show();
        } else {}
    } else if (whichListenTo === 'NTListenNow') {
        document.getElementById('NTBookChapter').innerHTML = newHTML;
        if (document.getElementById('NTListenNow').style.display !== "block") {
            document.getElementById('NTListenNow').style.marginLeft = "0px";
            $('#NTListenNow').show();
        } else {}
    } else {
        document.getElementById('ListenNow').style.marginLeft = "0px";
        $('"#ListenNow').show();
        document.getElementById('ListenNow').innerHTML = newHTML;
    }
}

function VideoChangeStories(WhichTestament, iso, rod, BookNumber) { // The array NumberOfChapters won't work. Hmmm...
    var Testament = "NT_Chapters_mp3";
    if (WhichTestament === "OT") {
        Testament = "OT_Chapters_mp3";
    }
    var elSel = document.getElementById(Testament);
    var i = 0;
    for (i = elSel.length - 1; i >= 0; i--) {
        elSel.remove(i); // first, delete all the 'option's
    }
    var Chapters = new Array();
    Chapters = BookNumber.split(','); // Split the BookNumber into an array where the ',' are separators
    var BookNumber = Chapters[0]; // The number of the Book of the Bible
    var Book = Major_NT_array[BookNumber];
    if (WhichTestament === "OT") {
        Book = Major_OT_array[BookNumber];
    }
    /*
    	This is not neccessary EXCEPT if the audio was not complete. I.e., if the books of the Bible
    	did not have all of the chapters. However, the chapter audio filenames have to be there.
    */
    for (i = 1; i < Chapters.length; i = i + 2) {
        var eNew = document.createElement('option'); // The 'var' needs to be there!
        eNew.text = Chapters[i];
        eNew.value = Book + "^data/" + iso + "/audio/" + Chapters[i + 1];
        try {
            elSel.add(eNew, null); // standards compliant; doesn't work in IE
        } catch (ex) {
            elSel.add(eNew); // IE only
        }
    }
}

function ListenVideo(mp3Info, autostart, whichListenTo, OTNT) {
    whichListenTo = typeof(whichListenTo) != 'undefined' ? whichListenTo : "";
    // whichListenTo = "OTListenNow" or "NTListenNow" or ""
    // autostart = true or false
    // mp3Info = array: number of the book of the Bible AND the audio filename
    // OTNT = 0 or 1 or 2 ($OT_Audio + $NT_Audio)
    OTNT = typeof(OTNT) != 'undefined' ? OTNT : 0;
    $("#jquery_jplayer_11").jPlayer("destroy");
    $("#jquery_jplayer_12").jPlayer("destroy");
    if (OTNT === 2) {
        $("#jquery_jplayer_12").jPlayer("destroy");
        setTimeout( // wait until the audio is done
            function() {
                //do something special
            }, 500);
    }
    var AudioFileName = new Array();
    AudioFileName = mp3Info.value.split('^'); // split the mp3Info into an array where the '^' are separators
    var listenBook = AudioFileName[0]; // the number of the book of the Bible 
    var listenFilename = AudioFileName[1]; // audio filename
    var divHeight = 0;
    var listenChapter = mp3Info.options[mp3Info.selectedIndex].text; // name of the chapter
    /*
    	I want to be able to print out
    		alert ("The mp3 file does not exists on server.");
    	but javascript does not have 'if filename exists on server' (only in AJAX).
    	[How about http://www.ScriptureEarth.org/data/[iso]/audio/listenFilename?]
    */

    var jQuery_jPlayer = "";
    var newHTML = "";
    var cssSelector = "";
    if (whichListenTo === "OTListenNow") {
        newHTML = "<span id='OTBookChapter' style='vertical-align: top; '>" + listenBook + " " + listenChapter + "</span> &nbsp;&nbsp; ";
        jQuery_jPlayer = "#jquery_jplayer_12";
        cssSelector = "#jp_container_12";
    } else if (whichListenTo === "NTListenNow") {
        newHTML = "<span id='NTBookChapter' style='vertical-align: top; '>" + listenBook + " " + listenChapter + "</span> &nbsp;&nbsp; ";
        jQuery_jPlayer = "#jquery_jplayer_11";
        cssSelector = "#jp_container_11";
    } else {}

    $(jQuery_jPlayer).jPlayer({ // create jPlayer
        ready: function(event) {
            $(this).jPlayer("setMedia", {
                mp3: listenFilename // audio filename
            }).jPlayer("play"); // Attempt to auto play the media
        },
        volume: 0.6, // volume from 0 to 1
        repeat: false,
        swfPath: "_js",
        supplied: "mp3",
        cssSelectorAncestor: cssSelector, // this isn't stated for only one jPlayer
        wmode: "window",
        smoothPlayBar: true,
        keyEnabled: true,
        ended: function(event) { // "ended" event automatically fired every time the chapter is ended
            // Add 1 to the chapter and then continue to play.
            if ((mp3Info.selectedIndex + 1) < mp3Info.options.length) { // selected item option + 1 < total number of options
                mp3Info.selectedIndex = mp3Info.selectedIndex + 1; // the next chapter
                AudioFileName = mp3Info.value.split('^'); // split the mp3Info into an array where the '^' are separators
                listenBook = AudioFileName[0]; // the number of the book of the Bible 
                listenFilename = AudioFileName[1]; // audio filename
                listenChapter = mp3Info.options[mp3Info.selectedIndex].text; // name of the chapter
                $(this).jPlayer("setMedia", { // play the next chap;ter
                    mp3: listenFilename // audio filename
                }).jPlayer("play");
            }
        }
    });

    if (whichListenTo === 'OTListenNow') {
        document.getElementById('OTBookChapter').innerHTML = newHTML;
        if (document.getElementById('OTListenNow').style.display !== "block") {
            document.getElementById('OTListenNow').style.marginLeft = "0px";
            $('#OTListenNow').show();
            divHeight = 32;
        } else {
            divHeight = -2;
        }
        $(document).ready(function() {
            divHeight += document.getElementById("container").offsetHeight;
            document.getElementById("container").style.height = divHeight + "px";
            // if the table is long enough IE goes to dark black (blur and opacity). I don't know why.
            $("#container").redrawShadow({ left: 5, top: 5, blur: 2, opacity: 0.5, color: "black", swap: false });
        });
    } else if (whichListenTo === 'NTListenNow') {
        document.getElementById('NTBookChapter').innerHTML = newHTML;
        if (document.getElementById('NTListenNow').style.display !== "block") {
            document.getElementById('NTListenNow').style.marginLeft = "0px";
            $('#NTListenNow').show();
            divHeight = 32;
        } else {
            divHeight = -2;
        }
        $(document).ready(function() {
            divHeight += document.getElementById("container").offsetHeight;
            document.getElementById("container").style.height = divHeight + "px";
            // if the table is long enough IE goes to dark black (blur and opacity). I don't know why.
            $("#container").redrawShadow({ left: 5, top: 5, blur: 2, opacity: 0.5, color: "black", swap: false });
        });
    } else {
        document.getElementById('ListenNow').style.marginLeft = "0px";
        $('#ListenNow').show();
        document.getElementById('ListenNow').innerHTML = newHTML;
    }
}

// SAB without chapters
function GoSAB(iso, Book_Chapter_HTML) {
    "use strict";
    if (SABwin && !SABwin.closed) { SABwin.close(); }
    SABwin = window.open("data/" + iso + "/sab/" + Book_Chapter_HTML, 'SABPage');
    SABwin.focus();
    return false; // cancels href action 
}

function GoSAB_subfolder(iso, Book_HTML, subfolder) {
    "use strict";
    if (SABwin && !SABwin.closed) { SABwin.close(); }
    SABwin = window.open("data/" + iso + "/" + subfolder + Book_HTML, 'SABPage');
    SABwin.focus();
    return false; // cancels href action 
}

function PlaylistVideo(videos, getElById, mobile) { // passing argument by reference (this.)
    "use strict";
    // The extra styles are for the mobile Andoid to work! (6/17/17)
    if (mobile == 1) {
        if (document.getElementById(getElById).style.display === "table-row") {
            document.getElementById(getElById).style.display = "none";
            document.getElementById(getElById).style.overflow = "hidden";
            document.getElementById(getElById).style.float = "left";
            document.getElementById(getElById).style.lineHeight = "0px";
            $("#jquery_jplayer_" + videos).jPlayer("pause");
       } else {
            document.getElementById(getElById).style.display = "table-row";
            document.getElementById(getElById).style.overflow = "visible";
            document.getElementById(getElById).style.float = "none";
            document.getElementById(getElById).style.lineHeight = "100%";
        }
    } else {
        if (document.getElementById(getElById).style.display === "table-row") {
            document.getElementById(getElById).style.display = "none";
            document.getElementById(getElById).style.overflow = "hidden";
            document.getElementById(getElById).style.float = "left";
            document.getElementById(getElById).style.lineHeight = "0px";
            $("#jquery_jplayer_"+videos).jPlayer("pause");
        } else {
            document.getElementById(getElById).style.display = "table-row";
            document.getElementById(getElById).style.overflow = "visible";
            document.getElementById(getElById).style.float = "none";
            document.getElementById(getElById).style.lineHeight = "100%";
        }
    }
}

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

let eBibleVisible_0 = 0;
let eBibleVisible_1 = 0;
let eBibleVisible_2 = 0;
let eBibleVisible_3 = 0;
let eBibleVisible_4 = 0;
let eBibleVisible_5 = 0;
let eBibleVisible_6 = 0;
let eBibleVisible_7 = 0;
let eBibleVisible_8 = 0;
let eBibleVisible_9 = 0;
function eBibleClick(eBibleCnt) {
	let eBibleCount = String(eBibleCnt);
    let eBibleVisible = window.eval("eBibleVisible_" + eBibleCount); // Set assign a variable + variable to ZFVD (because of the + sign)
	let eBibleClick = "#eBibleClick_"+eBibleCount;
    if (eBibleVisible == 0) {
        $(eBibleClick).show();
        //eBibleVisible+'_'+eBibleCount = 1;
		window.eval("eBibleVisible_" + eBibleCount + " = 1");
    } else {
        $(eBibleClick).hide();
        //eBibleVisible+'_'+eBibleCount = 0;
 		window.eval("eBibleVisible_" + eBibleCount + " = 0");
   }
}

function eBibleShow(URL, st, mobile, eBibleCnt) { // the AJAX for the live search on the iso input
    eBibleItems = getHTTPObject(); // the eBible object (see JavaScript function getHTTPObject() above)
    if (eBibleItems == null) {
        return;
    }
	let eBibleCount = String(eBibleCnt);			// convert a number to a string
    let url = "eBibleItems.php";
    url = url + "?URL=" + URL;
    url = url + "&st=" + st;
    url = url + "&mobile=" + mobile;
	url = url + "&eBibleCount=" + eBibleCount;
    url = url + "&sid=" + Math.random();
    eBibleItems.open("GET", url, true); // open the AJAX object
    eBibleItems.send(null);
    eBibleItems.onreadystatechange = function() { // the function that returns for AJAX object
        if (this.readyState == 4 && this.status == 200) { 		// if the readyState = 4 then eBible is displayed
            let tempArray = [];
            tempArray = this.responseText.split("|");
            if (tempArray.length == 1) {
                document.getElementById("eBibleItems_"+eBibleCount).innerHTML = tempArray[0];
            } else {
                document.getElementById("vernacularTitle_"+eBibleCount).innerHTML = tempArray[0];
                document.getElementById("eBibleItems_"+eBibleCount).innerHTML = tempArray[1];
            }
        }
    }
}

function saveAsVideo(iso, st, mobile, saveAsVideo, text) {
    "use strict";
    var url = "00-SaveAsVideoZip.php" + "?st=" + st + "&iso=" + iso + "&saveAsVideo=" + saveAsVideo;
    if (mobile == 0) { // this needs to stay at == not === !
        var left = (screen.width / 2) - (440 / 2);
        var top = (screen.height / 2) - (360 / 2);
        var w = window.open(url, "_normal", "toolbar=no, location=no, directories=no, status=yes, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=440, height=360, top=" + top + ", left=" + left);
        w.document.body.innerHTML = "<div style='position: absolute; top: 0px; left: 0px; padding: 20px; background-color: #008ff7; width: 400px; height: 320px; '><h2 style='font-family: Arial, Helvetica, sans-serif; padding: 20px; margin-top: 80px; text-align: center; border: 4px solid white; background-color: #002f78; color: white; '>" + text + "</h2></div>";
    } else {
        var w = window.open(url, "_normal");
        w.document.body.innerHTML = "<div style='padding: 1.4em; background-color: #008ff7; width: 100%; height: 100%; '><h2 style='font-size: 2.6em; font-weight: bold; font-family: Arial, Helvetica, sans-serif; padding: 1.4em; margin-top: 4em; text-align: center; border: .4em solid white; background-color: #002f78; color: white; '>" + text + "</h2></div>";
    }
    return false; //cancels href action 
}

function DownloadVideoPlaylistZip(st, iso, PlaylistVideoFilename, idNumber, mobile, message) {
    "use strict";
    var CB = "";
    var temp = "";
    var checkboxes = document.getElementsByName("DownloadVideoPlaylist_" + idNumber).length; // Get the number of chechboxs
    for (var a = 0; a < checkboxes; a++) {
        // alert(CB); WHAT's wrong! the first 14 checkboxes are not checked when there suppossed to be!
        if (document.getElementById("DVideoPlaylist_" + idNumber + "_" + a).checked === true) {
            temp = document.getElementById("DVideoPlaylist_" + idNumber + "_" + a).value;
            CB = CB + temp + "|";
        }
    }
    CB = CB.substring(0, CB.length - 1); // delete the final "|"
    var url = "00-PlaylistDownloadVideoZip.php" + "?st=" + st + "&iso=" + iso + "&PlaylistVideoFilename=" + PlaylistVideoFilename + "&checkBoxes=" + CB;
    if (mobile == 0) { // this needs to stay at == not === !
        var left = (screen.width / 2) - (440 / 2);
        var top = (screen.height / 2) - (360 / 2);
        var w = window.open(url, "_normal", "toolbar=no, location=no, directories=no, status=yes, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=440, height=360, top=" + top + ", left=" + left);
        w.document.body.innerHTML = "<div style='position: absolute; top: 0px; left: 0px; padding: 20px; background-color: #008ff7; width: 400px; height: 320px; '><h2 style='font-family: Arial, Helvetica, sans-serif; padding: 20px; margin-top: 80px; text-align: center; border: 4px solid white; background-color: #002f78; color: white; '>" + message + "</h2></div>";
    } else {
        var w = window.open(url, "_normal");
        w.document.body.innerHTML = "<div style='padding: 1.4em; background-color: #008ff7; width: 100%; height: 100%; '><h2 style='font-size: 2.6em; font-weight: bold; font-family: Arial, Helvetica, sans-serif; padding: 1.4em; margin-top: 4em; text-align: center; border: .4em solid white; background-color: #002f78; color: white; '>" + message + "</h2></div>";
    }
    return false; //cancels href action 
}

var ZipFilesVideoDownload_1 = 0;
var ZipFilesVideoDownload_2 = 0;
var ZipFilesVideoDownload_3 = 0;
var ZipFilesVideoDownload_4 = 0;
var ZipFilesVideoDownload_5 = 0;
var ZipFilesVideoDownload_6 = 0;
var ZipFilesVideoDownload_7 = 0;
var ZipFilesVideoDownload_8 = 0;
var ZipFilesVideoDownload_9 = 0;
var ZipFilesVideoDownload_10 = 0;
function DownloadVideoPlaylistClick(a_index, VideoFile, z) { // check box name, the book
    var ZFVD = window.eval("ZipFilesVideoDownload_" + z); // Set assign a variable + variable to ZFVD (because of the + sign)
    if (document.getElementById("DVideoPlaylist_" + z + "_" + a_index).checked) {
        ZFVD += VideoFile;
    } else {
        ZFVD -= VideoFile;
    }
    ZFVD = Math.round(ZFVD * 100) / 100; // rounded just does integers!
    if (ZFVD <= 0.049) {
        $("#PlaylistVideoDownload_MB_" + z).hide();
    } else {
        $("#PlaylistVideoDownload_MB_" + z).show();
        document.getElementById("PlaylistVideoDownload_MB_" + z).innerHTML = "~" + ZFVD + " MB&nbsp;";
    }
    eval('ZipFilesVideoDownload_' + z + ' = ZFVD'); // Set ZFVD to assign a variable + variable (because of the + sign)
}

var AllDownloadVideoPlaylist_1 = false;
var AllDownloadVideoPlaylist_2 = false;
var AllDownloadVideoPlaylist_3 = false;
var AllDownloadVideoPlaylist_4 = false;
var AllDownloadVideoPlaylist_5 = false;
var AllDownloadVideoPlaylist_6 = false;
var AllDownloadVideoPlaylist_7 = false;
var AllDownloadVideoPlaylist_8 = false;
var AllDownloadVideoPlaylist_9 = false;
var AllDownloadVideoPlaylist_10 = false;
function DownloadAllVideoPlaylistClick(VideoPlaylistGroupIndex, AllText, NoText) {
    var totalCheckboxes = document.querySelectorAll('input[name="DownloadVideoPlaylist_' + VideoPlaylistGroupIndex + '"]').length; // retrieve all of the checkboxes in this "input" in the "name" tag
    var Playlist_Video_Download_MB = "PlaylistVideoDownload_MB_" + VideoPlaylistGroupIndex;
    var a_index = "";
    eval("var tempor = AllDownloadVideoPlaylist_" + VideoPlaylistGroupIndex); // assign a variable + variable to true (because of the + sign)
    if (tempor == false) {
        for (var a = 0; a < totalCheckboxes; a++) {
            a_index = 'DVideoPlaylist_' + VideoPlaylistGroupIndex + '_' + a.toString();
            document.getElementById(a_index).checked = true;
        }
        document.getElementById(Playlist_Video_Download_MB).style.display = 'block';
        document.getElementById(Playlist_Video_Download_MB).innerHTML = "~" + document.getElementById("TotalZipFile_" + VideoPlaylistGroupIndex).value + " MB&nbsp;";
        var AorN = "AllOrNoneVideo_" + VideoPlaylistGroupIndex.toString();
        document.getElementById(AorN).value = NoText;
        eval('AllDownloadVideoPlaylist_' + VideoPlaylistGroupIndex + ' = true'); // assign a variable + variable to true (because of the + sign)
        eval('ZipFilesVideoDownload_' + VideoPlaylistGroupIndex + ' = ' + document.getElementById("TotalZipFile_" + VideoPlaylistGroupIndex).value); // Set to assign a variable + variable (because of the + sign)
    } else {
        for (var a = 0; a < totalCheckboxes; a++) {
            a_index = 'DVideoPlaylist_' + VideoPlaylistGroupIndex + '_' + a.toString();
            document.getElementById(a_index).checked = false;
        }
        document.getElementById(Playlist_Video_Download_MB).style.display = 'none';
        document.getElementById(Playlist_Video_Download_MB).innerHTML = "";
        var AorN = "AllOrNoneVideo_" + VideoPlaylistGroupIndex;
        document.getElementById(AorN).value = AllText;
        eval('AllDownloadVideoPlaylist_' + VideoPlaylistGroupIndex + ' = false'); // assign a variable + variable to false (because of the + sign)
        eval('ZipFilesVideoDownload_' + VideoPlaylistGroupIndex + ' = 0'); // Set ZFVD to assign a variable + variable (because of the + sign)
    }
}