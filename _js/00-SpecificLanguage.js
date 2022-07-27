// JavaScript Document
// 00-SpecificLanguage.js
// Created by Scott Starker

var Major_OT_array = [];
var Major_NT_array = [];

var CT = []; // an array of country table from the database

switch (MajorLang) {
    case "Span":
        Major_OT_array = ["Génesis", "Éxodo", "Levítico", "Números", "Deuteronomio", "Josué", "Jueces", "Rut", "1 Samuel", "2 Samuel", "1 Reyes", "2 Reyes", "1 Crónicas", "2 Crónicas", "Esdras", "Nehemías", "Ester", "Job", "Salmos", "Proverbios", "Eclesiastés", "Cantares", "Isaías", "Jeremías", "Lamentaciones", "Ezequiel", "Daniel", "Oseas", "Joel", "Amós", "Abdías", "Jonás", "Miqueas", "Nahúm", "Habacuc", "Sofonías", "Hageo", "Zacarías", "Malaquías"];
        Major_NT_array = ["Mateo", "Marcos", "Lucas", "Juan", "Hechos", "Romanos", "1 Corintios", "2 Corintios", "Gálatas", "Efesios", "Filipenses", "Colosenses", "1 Tesalonicenses", "2 Tesalonicenses", "1 Timoteo", "2 Timoteo", "Tito", "Filemón", "Hebreos", "Santiago", "1 Pedro", "2 Pedro", "1 Juan", "2 Juan", "3 Juan", "Judas", "Apocalipsis"];
        break;
    case "Eng":
        Major_OT_array = ["Genesis", "Exodus", "Leviticus", "Numbers", "Deuteronomy", "Joshua", "Judges", "Ruth", "1 Samuel", "2 Samuel", "1 Kings", "2 Kings", "1 Chronicles", "2 Chronicles", "Ezra", "Nehemiah", "Esther", "Job", "Psalms", "Proverbs", "Ecclesiastes", "Song of Solomon", "Isaiah", "Jeremiah", "Lamentations", "Ezekiel", "Daniel", "Hosea", "Joel", "Amos", "Obadiah", "Jonah", "Micah", "Nahum", "Habukkuk", "Zephaniah", "Haggai", "Zechariah", "Malachi"];
        Major_NT_array = ["Matthew", "Mark", "Luke", "John", "Acts", "Romans", "1 Corinthians", "2 Corinthians", "Galatians", "Ephesians", "Philippians", "Colossians", "1 Thessalonians", "2 Thessalonians", "1 Timothy", "2 Timothy", "Titus", "Philemon", "Hebrews", "James", "1 Peter", "2 Peter", "1 John", "2 John", "3 John", "Jude", "Revelation"];
        break;
    case "Port":
        Major_OT_array = ["Gênesis", "Êxodo", "Levítico", "Números", "Deuteronômio", "Josué", "Juízes", "Rute", "1 Samuel", "2 Samuel", "1 Reis", "2 Reis", "1 Crônicas", "2 Crônicas", "Ezdras", "Neemias", "Esther", "Jó", "Salmos", "Provérbios", "Eclesiastes", "Cantares de Salomão", "Isaías", "Jeremias", "Lamentações", "Ezequiel", "Daniel", "Oséias", "Joel", "Amós", "Obadias", "Jonas", "Miquéias", "Naum", "Habacuque", "Sofonias", "Ageu", "Zacarias", "Malaquias"];
        Major_NT_array = ["Mateus", "Marcos", "Lucas", "João", "Atos", "Romanos", "1 Coríntios", "2 Coríntios", "Gálatas", "Efésios", "Filipenses", "Colossenses", "1 Tessalonicenses", "2 Tessalonicenses", "1 Timóteo", "2 Timóteo", "Tito", "Filemón", "Hebreus", "Tiago", "1 Pedro", "2 Pedro", "1 João", "2 João", "3 João", "Judas", "Apocalipse"];
        break;
    case "Fra":
        Major_OT_array = ["Genèse", "Exode", "Lévitique", "Nombres", "Deutéronome", "Josué", "Juges", "Ruth", "1 Samuel", "2 Samuel", "1 Rois", "2 Rois", "1 Chroniques", "2 Chroniques", "Esdras", "Néhémie", "Esther", "Job", "Psaume", "Proverbes", "Ecclésiaste", "Cantique des Cantiqu", "Ésaïe", "Jérémie", "Lamentations", "Ézéchiel", "Daniel", "Osée", "Joël", "Amos", "Abdias", "Jonas", "Michée", "Nahum", "Habacuc", "Sophonie", "Aggée", "Zacharie", "Malachie"];
        Major_NT_array = ["Matthieu", "Marc", "Luc", "Jean", "Actes", "Romains", "1 Corinthiens", "2 Corinthiens", "Galates", "Éphésiens", "Philippiens", "Colossiens", "1 Thessaloniciens", "2 Thessaloniciens", "1 Timothée", "2 Timothée", "Tite", "Philémon", "Hébreux", "Jacques", "1 Pierre", "2 Pierre", "1 Jean", "2 Jean", "3 Jean", "Jude", "Apocalypse"];
        break;
    case "Nld":
        Major_OT_array = ["Genesis", "Exodus", "Leviticus", "Numberi", "Deuteronomium", "Jozua", "Richtere", "Ruth", "1 Samuel", "2 Samuel", "1 Koningen", "2 Koningen", "1 Kronieken", "2 Kronieken", "Ezra", "Nehemia", "Esther", "Job", "Psalmen", "Spreuken", "Prediker", "Hooglied", "Jesaja", "Jeremia", "Klaagliederen", "Ezechiël", "Daniël", "Hosea", "Joël", "Amos", "Obadja", "Jona", "Micha", "Nahum", "Habakuk", "Zefanja", "Haggaï", "Zacharia", "Maleachi"];
        Major_NT_array = ["Mattheüs", "Markus", "Lukas", "Johannes", "Handelingen", "Romeinen", "1 Corinthiërs", "2 Corinthiërs", "Galaten", "Efeziërs", "Filippenzen", "Colossenzen", "1 Thessalonicenzen", "2 Thessalonicenzen", "1 Timotheüs", "2 Timotheüs", "Titus", "Filémon", "Hebreeën", "Jakobus", "1 Petrus", "2 Petrus", "1 Johannes", "2 Johannes", "3 Johannes", "Judas", "Openbaring"];
        break;
    case "Deu":
        Major_OT_array = ["Genesis", "Exodus", "Levitikus", "Numeri", "Deuteronomium", "Josua", "Richter", "Rut", "1 Samuel", "2 Samuel", "1 Könige", "2 Könige", "1 Chronik", "2 Chronik", "Esra", "Nehemia", "Ester", "Ijob", "Psalmen", "Sprichwörter", "Prediger", "Lied Salomos", "Jesaja", "Jeremia", "Klagelieder", "Ezechiel", "Daniel", "Hosea", "Joël", "Amos", "Obadja", "Jona", "Micha", "Nahum", "Habakuk", "Zefanja", "Haggai", "Sacharja", "Maleachi"];
        Major_NT_array = ["Matthäus", "Markus", "Lukas", "Johannes", "Apostelgeschichte", "Römer", "1 Korinther", "2 Korinther", "Galater", "Epheser", "Philipper", "Kolosser", "1 Thessalonicher", "2 Thessalonicher", "1 Timotheus", "2 Timotheus", "Titus", "Philemon", "Hebräer", "Jakobus", "1 Petrus", "2 Petrus", "1 Johannes", "2 Johannes", "3 Johannes", "Judas", "Offenbarung des Johannes"];
        break;
    case "Chi":
        Major_OT_array = ["Genesis", "Exodus", "Levitikus", "Numeri", "Deuteronomium", "Josua", "Richter", "Rut", "1 Samuel", "2 Samuel", "1 Könige", "2 Könige", "1 Chronik", "2 Chronik", "Esra", "Nehemia", "Ester", "Ijob", "Psalmen", "Sprichwörter", "Prediger", "Lied Salomos", "Jesaja", "Jeremia", "Klagelieder", "Ezechiel", "Daniel", "Hosea", "Joël", "Amos", "Obadja", "Jona", "Micha", "Nahum", "Habakuk", "Zefanja", "Haggai", "Sacharja", "Maleachi"];
        Major_NT_array = ["Matthäus", "Markus", "Lukas", "Johannes", "Apostelgeschichte", "Römer", "1 Korinther", "2 Korinther", "Galater", "Epheser", "Philipper", "Kolosser", "1 Thessalonicher", "2 Thessalonicher", "1 Timotheus", "2 Timotheus", "Titus", "Philemon", "Hebräer", "Jakobus", "1 Petrus", "2 Petrus", "1 Johannes", "2 Johannes", "3 Johannes", "Judas", "Offenbarung des Johannes"];
        break;
}

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
        //$("#btn").click(function() {
        $.ajax({
            url: "LinkedCounter.php",
            data: { "LC": filename },
            success: function(result) {
                //alert( result );
            }
        });
        //});
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
        //w.document.write("<title>Save Audio Zip</title>")
        //w.document.write("<h1 style='color: white; background-color: brown; text-align: center; '>Creating the zip file. Please wait...</h1>")
        w.document.body.innerHTML = "<div style='position: absolute; top: 0px; left: 0px; padding: 20px; background-color: #008ff7; width: 400px; height: 320px; '><h2 style='font-family: Arial, Helvetica, sans-serif; padding: 20px; margin-top: 80px; text-align: center; border: 4px solid white; background-color: #002f78; color: white; '>" + text + "</h2></div>";
    } else {
        var w = window.open(url, "_normal");
        //w.document.write("<title>Save Audio Zip</title>");
        //w.document.write("<h1 style='color: white; background-color: brown; text-align: center; '>Creating the zip file. Please wait...</h1>");
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
        //w.document.write("<title>Save Audio Zip</title>");
        //w.document.write("<h1 style='color: white; background-color: brown; text-align: center; '>Creating the zip file. Please wait...</h1>");
        w.document.body.innerHTML = "<div style='position: absolute; top: 0px; left: 0px; padding: 20px; background-color: #008ff7; width: 400px; height: 320px; '><h2 style='font-family: Arial, Helvetica, sans-serif; padding: 20px; margin-top: 80px; text-align: center; border: 4px solid white; background-color: #002f78; color: white; '>" + text + "</h2></div>";
    } else {
        var w = window.open(url, "_normal");
        //w.document.write("<title>Save Audio Zip</title>");
        //w.document.write("<h1 style='color: white; background-color: brown; text-align: center; '>Creating the zip file. Please wait...</h1>");
        w.document.body.innerHTML = "<div style='padding: 1.4em; background-color: #008ff7; width: 100%; height: 100%; '><h2 style='font-size: 2.6em; font-weight: bold; font-family: Arial, Helvetica, sans-serif; padding: 1.4em; margin-top: 4em; text-align: center; border: .4em solid white; background-color: #002f78; color: white; '>" + text + "</h2></div>";
    }
    return false; //cancels href action 
}

function PlaylistAudioZip(st, iso, rod, PlaylistGroupIndex, PlaylistIndexMax, mobile, text) {
    "use strict";
    var a_index = "";
    var PL = "";
    //var arr = array_map(function($val) { return explode('^', $val); }, explode('|', $homepage));		// put the string into 2D array
    //var arr = PlaylistString.split("|");
    var temp = "";
    for (var a = 1; a <= PlaylistIndexMax; a++) {
        a_index = 'Playlist_audio_' + PlaylistGroupIndex + '_' + a.toString();
        if (document.getElementById(a_index) !== null) {
            if (document.getElementById(a_index).checked === true) {
                //PL = PL + arr[a-1].substring(arr[a-1].indexOf("^")+1).replace("data/"+iso+"/audio/", "")  + "|";
                //PL = PL + arr[a-1] + "|";
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
        //w.document.write("<title>Save Audio Zip</title>");
        //w.document.write("<h1 style='color: white; background-color: brown; text-align: center; '>Creating the zip file. Please wait...</h1>");
        w.document.body.innerHTML = "<div style='position: absolute; top: 0px; left: 0px; padding: 20px; background-color: #008ff7; width: 400px; height: 320px; '><h2 style='font-family: Arial, Helvetica, sans-serif; padding: 20px; margin-top: 80px; text-align: center; border: 4px solid white; background-color: #002f78; color: white; '>" + text + "</h2></div>";
    } else {
        var w = window.open(url, "_normal");
        //w.document.write("<title>Save Audio Zip</title>")
        //w.document.write("<h1 style='color: white; background-color: brown; text-align: center; '>Creating the zip file. Please wait...</h1>")
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
    } else {
        //newHTML = newHTML + '<object id="myFlash" type="application/x-shockwave-flash" data="player_mp3_maxi.swf" width="320" height="20">';
    }
    //$(document).ready(function(){
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
            //$(jQuery_jPlayer).unbind($.jPlayer.event.repeat + ".jPlayer");
            //$(jQuery_jPlayer).unbind(".jPlayerRepeat");
    });
    //});

    if (whichListenTo === 'OTListenNow') {
        document.getElementById('OTBookChapter').innerHTML = newHTML;
        if (document.getElementById('OTListenNow').style.display !== "block") {
            document.getElementById('OTListenNow').style.marginLeft = "0px";
            $('#OTListenNow').show();
            //divHeight = 32;
        } else {
            //divHeight = -2;
        }
        /*$(document).ready(function() {
        	divHeight += document.getElementById("container").offsetHeight;
        	document.getElementById("container").style.height = divHeight + "px";
        	// if the table is long enough IE goes to dark black (blur and opacity). I don't know why.
        	$("#container").redrawShadow({left: 5, top: 5, blur: 2, opacity: 0.5, color: "black", swap: false});
        });*/
    } else if (whichListenTo === 'NTListenNow') {
        document.getElementById('NTBookChapter').innerHTML = newHTML;
        if (document.getElementById('NTListenNow').style.display !== "block") {
            document.getElementById('NTListenNow').style.marginLeft = "0px";
            $('#NTListenNow').show();
            //divHeight = 32;
        } else {
            //divHeight = -2;
        }
        /*$(document).ready(function() {
        	divHeight += document.getElementById("container").offsetHeight;
        	document.getElementById("container").style.height = divHeight + "px";
        	if the table is long enough IE goes to dark black (blur and opacity). I don't know why.
        	$("#container").redrawShadow({left: 5, top: 5, blur: 2, opacity: 0.5, color: "black", swap: false});
        });*/
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
    } else {
        //newHTML = newHTML + '<object id="myFlash" type="application/x-shockwave-flash" data="player_mp3_maxi.swf" width="320" height="20">';
    }

    //$(document).ready(function(){
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
            //$(jQuery_jPlayer).unbind($.jPlayer.event.repeat + ".jPlayer");
            //$(jQuery_jPlayer).unbind(".jPlayerRepeat");
    });
    //});

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

/* SAB with chapters
function SABChangeChapters(WhichTestament, iso, rod, BookNumber) {			// The array NumberOfChapters won't work. Hmmm...
	var Testament = "NT_SAB_Chapters";
	if (WhichTestament == "OT") {
		Testament = "OT_SAB_Chapters";
	}
	var elSel = document.getElementById(Testament);
	var i = 0;
	for (i = elSel.length - 1; i >= 0; i--) {
		elSel.remove(i);								// first, delete all the 'option's
	}
	var Chapters = new Array();
	Chapters = BookNumber.split(',');					// Split the BookNumber into an array where the ',' are separators
	var BookNumber = Chapters[0];						// The number of the Book of the Bible
	var Book = Major_NT_array[BookNumber];
	if (WhichTestament == "OT") {
		Book = Major_OT_array[BookNumber];
	}
	/*
		This is not neccessary EXCEPT if the audio was not complete. I.e., if the books of the Bible
		did not have all of the chapters. However, the chapter SAB filenames have to be there.
	* /
	for (i=1; i < Chapters.length; i=i+2) {
		var eNew = document.createElement('option');	// The 'var' needs to be there!
		eNew.text = Chapters[i];
		eNew.value = Book + "^data/" + iso + "/sab/" + Chapters[i+1];
		try {
			elSel.add(eNew, null);						// standards compliant; doesn't work in IE
		}
		catch (ex) {
			elSel.add(eNew);							// IE only
		}
	}
}
*/

/* SAB with chapters
function GoSAB(SABInfo) {
	if (SABwin && !SABwin.closed) SABwin.close();
	var SABFileName = new Array();
	SAB = SABInfo.value.split('^');						// split the SABInfo into an array where the '^' are separators
	//var SABBook = SAB[0];								// the number of the book of the Bible
	var SABFilename = SAB[1];							// SAB filename
	//var SABChapter = SABInfo.options[SABInfo.selectedIndex].text;	// the number of the book of the Bible
	SABwin = window.open(SABFilename, 'SABPage');
	//setTimeout(function() { SABwin.focus(); }, 1000);
	SABwin.focus();
	return false;										// cancels href action 
}*/

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

function PlaylistVideo(orgVideoPixels, getElById, mobile) { // passing argument by reference (this.)
    "use strict";
    // I need windows height to go here
    var divHeight = 0;
    // The extra styles are for the mobile Andoid to work! (6/17/17)
    if (mobile == 1) {
        if (document.getElementById(getElById).style.display === "table-row") {
            document.getElementById(getElById).style.display = "none";
            document.getElementById(getElById).style.overflow = "hidden";
            document.getElementById(getElById).style.float = "left";
            document.getElementById(getElById).style.lineHeight = "0px";
        } else {
            document.getElementById(getElById).style.display = "table-row";
            document.getElementById(getElById).style.overflow = "visible";
            document.getElementById(getElById).style.float = "none";
            document.getElementById(getElById).style.lineHeight = "100%";
        }
    } else {
        ////// $(document).ready(function() {
        if (document.getElementById(getElById).style.display === "table-row") {
            document.getElementById(getElById).style.display = "none";
            document.getElementById(getElById).style.overflow = "hidden";
            document.getElementById(getElById).style.float = "left";
            document.getElementById(getElById).style.lineHeight = "0px";
            //divHeight = -585;
            ////// divHeight = this.orgVideoPixels;
        } else {
            ////// this.orgVideoPixels = document.body.scrollHeight - 42;
            //divHeight = 581;
            document.getElementById(getElById).style.display = "table-row";
            document.getElementById(getElById).style.overflow = "visible";
            document.getElementById(getElById).style.float = "none";
            document.getElementById(getElById).style.lineHeight = "100%";
            ///// divHeight = document.body.scrollHeight - 26;
        }
        //divHeight += document.getElementById("container").offsetHeight;
        ////// document.getElementById("container").style.height = divHeight + "px";
        // if the table is long enough IE goes to dark black (blur and opacity). I don't know why.
        ////// $("#container").redrawShadow({left: 5, top: 5, blur: 2, opacity: 0.5, color: "black", swap: false});
        /////// });
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

function eBibleShow(URL, st, mobile) { // the AJAX for the live search on the iso input
    eBibleItems = getHTTPObject(); // the eBible object (see JavaScript function getHTTPObject() above)
    if (eBibleItems == null) {
        return;
    }
    var url = "eBibleItems.php";
    url = url + "?URL=" + URL;
    url = url + "&st=" + st;
    url = url + "&mobile=" + mobile;
    url = url + "&sid=" + Math.random();
    eBibleItems.open("GET", url, true); // open the AJAX object
    eBibleItems.send(null);
    eBibleItems.onreadystatechange = function() { // the function that returns for AJAX object
        if (eBibleItems.readyState == 4) { // if the readyState = 4 then eBible is displayed
            var tempArray = [];
            tempArray = eBibleItems.responseText.split("|");
            if (tempArray.length == 1) {
                document.getElementById("eBibleItems").innerHTML = tempArray[0];
            } else {
                document.getElementById("vernacularTitle").innerHTML = tempArray[0];
                document.getElementById("eBibleItems").innerHTML = tempArray[1];
            }
        }
    }
}

/*// Get the HTTP Object
function videoHTTPObject() {								// get the AJAX object; can be used more than once
	try {
		// IE 7+, Opera 8.0+, Firefox, Safari
		return new XMLHttpRequest();
	}
	catch (e) {
		// Internet Explorer browsers
		try {
			return new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e) {
			try {
				return new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e) {
				// Something went wrong
				alert("XML HTTP Request is not able to be set. Maybe the version of the web browser is old?");
				return null;
			}
		}
	}
}

function saveAsVideo(SaveAsVideo) {							// the AJAX for the live search on the iso input
	videoSaveAs = videoHTTPObject();						// the eBible object (see JavaScript function getHTTPObject() above)
	if (videoSaveAs == null) {
		return;
	}
	var saveAs = "SaveAsVideo.php";
	saveAs = saveAs + "?SaveAsVideo=" + SaveAsVideo;
	saveAs = saveAs + "&sid=" + Math.random();
	videoSaveAs.open("GET", saveAs, true);					// open the AJAX object
	videoSaveAs.send(null);
	videoSaveAs.onreadystatechange = function() {			// the function that returns for AJAX object
		if (videoSaveAs.readyState == 4) {					// if the readyState = 4 then eBible is displayed
			document.getElementById("ff").innerHTML = videoSaveAs.responseText;
			alert('hi');
		}
	}
}
*/

function saveAsVideo(iso, st, mobile, saveAsVideo, text) {
    "use strict";
    var url = "00-SaveAsVideoZip.php" + "?st=" + st + "&iso=" + iso + "&saveAsVideo=" + saveAsVideo;
    if (mobile == 0) { // this needs to stay at == not === !
        var left = (screen.width / 2) - (440 / 2);
        var top = (screen.height / 2) - (360 / 2);
        var w = window.open(url, "_normal", "toolbar=no, location=no, directories=no, status=yes, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=440, height=360, top=" + top + ", left=" + left);
        //w.document.write("<title>Save Audio Zip</title>");
        //w.document.write("<h1 style='color: white; background-color: brown; text-align: center; '>Creating the zip file. Please wait...</h1>");
        w.document.body.innerHTML = "<div style='position: absolute; top: 0px; left: 0px; padding: 20px; background-color: #008ff7; width: 400px; height: 320px; '><h2 style='font-family: Arial, Helvetica, sans-serif; padding: 20px; margin-top: 80px; text-align: center; border: 4px solid white; background-color: #002f78; color: white; '>" + text + "</h2></div>";
    } else {
        var w = window.open(url, "_normal");
        //w.document.write("<title>Save Audio Zip</title>");
        //w.document.write("<h1 style='color: white; background-color: brown; text-align: center; '>Creating the zip file. Please wait...</h1>");
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
        //w.document.write("<title>Save Audio Zip</title>");
        //w.document.write("<h1 style='color: white; background-color: brown; text-align: center; '>Creating the zip file. Please wait...</h1>");
        w.document.body.innerHTML = "<div style='position: absolute; top: 0px; left: 0px; padding: 20px; background-color: #008ff7; width: 400px; height: 320px; '><h2 style='font-family: Arial, Helvetica, sans-serif; padding: 20px; margin-top: 80px; text-align: center; border: 4px solid white; background-color: #002f78; color: white; '>" + message + "</h2></div>";
    } else {
        var w = window.open(url, "_normal");
        //w.document.write("<title>Save Audio Zip</title>");
        //w.document.write("<h1 style='color: white; background-color: brown; text-align: center; '>Creating the zip file. Please wait...</h1>");
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
    eval("var ZFVD = ZipFilesVideoDownload_" + z); // Set assign a variable + variable to ZFVD (because of the + sign)
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