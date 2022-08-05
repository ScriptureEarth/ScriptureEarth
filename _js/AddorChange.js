// JavaScript Document
// Scott Starker

var OT_abbr_array = ["GEN", "EXO", "LEV", "NUM", "DEU", "JOS", "JDG", "RUT", "1SA", "2SA", "1KI", "2KI", "1CH", "2CH", "EZR", "NEH", "EST", "JOB", "PSA", "PRO", "ECC", "SNG", "ISA", "JER", "LAM", "EZK", "DAN", "HOS", "JOL", "AMO", "OBA", "JON", "MIC", "NAM", "HAB", "ZEP", "HAG", "ZEC", "MAL"];
var OT_How_Many_Chapters_array = [50, 40, 27, 36, 34, 24, 21, 4, 31, 24, 22, 25, 29, 36, 10, 13, 10, 42, 150, 31, 12, 8, 66, 52, 5, 48, 12, 14, 3, 9, 1, 4, 7, 3, 3, 3, 2, 14, 4];
var NT_abbr_array = ["MAT", "MRK", "LUK", "JHN", "ACT", "ROM", "1CO", "2CO", "GAL", "EPH", "PHP", "COL", "1TH", "2TH", "1TI", "2TI", "TIT", "PHM", "HEB", "JAS", "1PE", "2PE", "1JN", "2JN", "3JN", "JUD", "REV"];
var NT_How_Many_Chapters_array = [28, 16, 24, 21, 28, 16, 16, 13, 6, 6, 4, 4, 5, 3, 6, 4, 3, 1, 13, 5, 5, 3, 5, 1, 1, 1, 22];

function All_Books_On_Or_Off(oneTable, trueOrFalse) {
    var table = document.getElementById(oneTable);
    var rows = table.rows;
    var num = 0;
    if (oneTable.startsWith("NT", 0)) { // OT_PDF_Table or NT_PDF_Table
        num = 27;
    } else {
        num = 39;
    }
    for (var rowLoop = 0; rowLoop < num; rowLoop++) {
        var cells = rows[rowLoop].cells;
        var cb = cells[0].getElementsByTagName("input")[0]; // cells[0] = 1st column; [0] = the 1st element in the cell
        if (trueOrFalse) {
            cb.checked = true;
        } else {
            cb.checked = false;
        }
    }
}

function All_Audio_On_Or_Off(tables, OTorNT, trueOrFalse) {
    for (var index = 0; index < OTorNT; index++) {
        var oneTable = tables + "-" + index;
        /*alert (oneTable + " " + trueOrFalse);*/
        Audio_On_Or_Off(oneTable, trueOrFalse);
    }
}

function Audio_On_Or_Off(oneTable, trueOrFalse) { // e.g. "NT_Audio_Table3-"+index
    var table = document.getElementById(oneTable);
    var rows = table.rows; // tr rows
    var i = 1;
    for (var rowLoop = 0; rowLoop < rows.length; rowLoop++) { // iterate 0 through the last tr row
        var cells = rows[rowLoop].cells;
        for (var cellLoop = 0; cellLoop < cells.length; cellLoop++) { // iterate 0 through before the last cell
            var cb = cells[cellLoop].getElementsByTagName("input")[0]; // cells[0] = 1st column; [0] = the 1st element in the cell
            if (!cb) break;
            cells[cellLoop].getElementsByTagName("input")[0].checked = trueOrFalse;
        }
        i++;
    }
}

/*****************************************************
			classChange - makes visible invisible
******************************************************/
function classChange(element, newclass, elementHidden) {
    var newEl = new Array();
    newEl = element.split("_");
    var newElement = newEl[0] + "_Off_" + newEl[1];
    if (newclass == "DisplayBlock") {
        document.getElementById(element).style.display = "block";
        document.getElementById(newElement).style.display = "none";
        document.getElementById(elementHidden).value = "Yes";
    } else {
        document.getElementById(element).style.display = "none";
        document.getElementById(newElement).style.display = "block";
        document.getElementById(elementHidden).value = "No";
    }
}

/*****************************************************
			Alt Language Names
******************************************************/
function addRowToTableALN(tableId, txtId) {
    var tbl = document.getElementById(tableId);
    var lastRow = tbl.rows.length;
    if (tbl.rows[lastRow - 1].cells[1].getElementsByTagName("input")[0].value == "") { // if the last value is empty then return
        return;
    }
    var iteration = lastRow + 1;
    var row = tbl.insertRow(lastRow);

    // left cell
    var cellLeft = row.insertCell(0);
    var textNode1 = document.createTextNode(" ");
    cellLeft.appendChild(textNode1);

    // center cell
    var cellCenter = row.insertCell(1);
    var el = document.createElement("input");
    el.type = "text";
    //el.name = "txtAltNames-" + iteration;
    //el.id = "txtAltNames-" + iteration;
    el.name = txtId + "-" + iteration;
    el.id = txtId + "-" + iteration;
    el.style.color = "navy";
    el.size = 50;
    el.onclick = function() { ALNidx(iteration); }; // onclick function
    cellCenter.appendChild(el);

    // right cell
    var cellRight = row.insertCell(2);
    var textNode2 = document.createTextNode(" ");
    cellRight.appendChild(textNode2);
}

ALNindex = 0;

function ALNidx(idx) { // set the txtAltNames-zz so that function moveUpDownALN(tableId, upDown) will work
    ALNindex = idx;
}

/*****************************************************
			English Countries
******************************************************/
function addRowToTableCol1(tableId, txtId) {
    var tbl = document.getElementById(tableId);
    var lastRow = tbl.rows.length;
    var iteration = lastRow + 1;
    var row = tbl.insertRow(lastRow);

    // left cell
    var cellLeft = row.insertCell(0);
    var textNode1 = document.createTextNode(" ");
    cellLeft.appendChild(textNode1);

    // center cell
    var cellCenter = row.insertCell(1);
    var el = document.createElement("input");
    el.type = "text";
    //el.name = "txtAltNames-" + iteration;
    //el.id = "txtAltNames-" + iteration;
    el.name = txtId + "-" + iteration;
    el.id = txtId + "-" + iteration;
    el.size = 60;
    cellCenter.appendChild(el);

    // right cell
    var cellRight = row.insertCell(2);
    var textNode2 = document.createTextNode(" ");
    cellRight.appendChild(textNode2);
}

/*****************************************************
					Cell Phone
******************************************************/
function addRowToCellPhone() {
    var tbl = document.getElementById("tableCellPhone");
    var lastRow = tbl.rows.length;
    var iteration = lastRow + 1;
    var row = tbl.insertRow(lastRow);

    // left cell
    var cellLeft = row.insertCell(0);
    var textNode1 = document.createTextNode(" ");
    cellLeft.appendChild(textNode1);

    // Title cell
    var cellTitle = row.insertCell(1);
    var el = document.createElement("select");
    el.name = "txtCellPhoneTitle" + "-" + iteration;
    el.id = "txtCellPhoneTitle" + "-" + iteration;
    el.style.color = "navy"
    cellTitle.appendChild(el);

    objOption = document.createElement('option');
    objOption.text = "GoBible (Java)";
    //objOption.appendChild(document.createTextNode('Buy'));
    objOption.value = "CPJava-" + iteration;
    //el.options.add(objOption);
    el.appendChild(objOption);

    var objOption = document.createElement("option");
    objOption.text = "MySword (Android)";
    //objOption.appendChild(document.createTextNode('Other'));
    objOption.value = "CPAndroid-" + iteration;
    //el.options.add(objOption);
    el.appendChild(objOption);

    objOption = document.createElement('option');
    objOption.text = "iPhone";
    //objOption.appendChild(document.createTextNode('Map'));
    objOption.value = "CPiPhone-" + iteration;
    //el.options.add(objOption);
    el.appendChild(objOption);

    //objOption = document.createElement('option');
    //objOption.text="Windows";
    //objOption.appendChild(document.createTextNode('Map'));
    //objOption.value = "CPWindows-" + iteration;
    //el.options.add(objOption);
    //el.appendChild(objOption);

    //objOption = document.createElement('option');
    //objOption.text="Blackberry";
    //objOption.appendChild(document.createTextNode('Map'));
    //objOption.value = "CPBlackberry-" + iteration;
    //el.options.add(objOption);
    //el.appendChild(objOption);

    //objOption = document.createElement('option');
    //objOption.text="Standard Cell Phone";
    //objOption.appendChild(document.createTextNode('Map'));
    //objOption.value = "CPStandard-" + iteration;
    //el.options.add(objOption);
    //el.appendChild(objOption);

    objOption = document.createElement('option');
    objOption.text = "Android App (apk)";
    //objOption.appendChild(document.createTextNode('Map'));
    objOption.value = "CPAndroidApp-" + iteration;
    //el.options.add(objOption);
    el.appendChild(objOption);

    objOption = document.createElement('option');
    objOption.text = "iOS Asset Package";
    //objOption.appendChild(document.createTextNode('Map'));
    objOption.value = "CPiOSAssetPackage-" + iteration;
    //el.options.add(objOption);
    el.appendChild(objOption);

    // File cell
    var cellFile = row.insertCell(2);
    var el = document.createElement("input");
    el.type = "text";
    el.name = "txtCellPhoneFile" + "-" + iteration;
    el.id = "txtCellPhoneFile" + "-" + iteration;
    el.size = 35;
    el.style.color = "navy"
    cellFile.appendChild(el);

    // File cell
    var cellOption = row.insertCell(3);
    var el = document.createElement("input");
    el.type = "text";
    el.name = "txtCellPhoneOptional" + "-" + iteration;
    el.id = "txtCellPhoneOptional" + "-" + iteration;
    el.size = 35;
    el.style.color = "navy"
    cellOption.appendChild(el);

    // right cell
    var cellRight = row.insertCell(4);
    var textNode2 = document.createTextNode(" ");
    cellRight.appendChild(textNode2);
}

/*****************************************************
				Buy (only 'Buy' variable!)
******************************************************/
function addRowToTableCol3(DatabaseTable) {
    var whatTable = "";
    var txtWebSource = "";
    var txtResource = "";
    var txtURL = "";

    if (DatabaseTable == "Buy") {
        whatTable = "tableBuy";
        txtWebSource = "txtBuyWebSource-";
        txtResource = "txtBuyResource-";
        txtURL = "txtBuyURL-";
    } else { // DatabaseTable == "Link"
        whatTable = "tableLinks";
        txtWebSource = "txtLinkCompany-";
        txtResource = "txtLinkCompanyTitle-";
        txtURL = "txtLinkURL-";
    }

    var tbl = document.getElementById(whatTable);
    var lastRow = tbl.rows.length;
    var iteration = lastRow + 1;
    var row = tbl.insertRow(lastRow);

    // head cell
    var cellHead = row.insertCell(0);
    var textNode1 = document.createTextNode(" ");
    cellHead.appendChild(textNode1);

    // left cell
    var cellLeft = row.insertCell(1);
    var el = document.createElement("input");
    el.type = "text";
    el.name = txtWebSource + iteration;
    el.id = txtWebSource + iteration;
    el.size = 28;
    el.style.color = "navy"
    cellLeft.appendChild(el);

    // center cell
    var cellCenter = row.insertCell(2);
    var el = document.createElement("input");
    el.type = "text";
    el.name = txtResource + iteration;
    el.id = txtResource + iteration;
    el.size = 28;
    el.style.color = "navy"
    cellCenter.appendChild(el);

    // right center cell
    var cellRight = row.insertCell(3);
    var el = document.createElement("input");
    el.type = "text";
    el.name = txtURL + iteration;
    el.id = txtURL + iteration;
    el.size = 34;
    el.style.color = "navy"
    cellRight.appendChild(el);

    // tail cell
    var cellTail = row.insertCell(4);
    var textNode2 = document.createTextNode(" ");
    cellTail.appendChild(textNode2);
}

/*************************************************
					Links
*************************************************/
function addLinksRowToTableCol4() {
    var tbl = document.getElementById("tableLinks");
    var lastRow = tbl.rows.length;
    var iteration = lastRow + 1;
    var row = tbl.insertRow(lastRow);

    // head cell
    var cellHead = row.insertCell(0);
    var textNode1 = document.createTextNode(" ");
    cellHead.appendChild(textNode1);

    // left cell
    var cellLeft = row.insertCell(1);
    var el = document.createElement("input");
    el.type = "text";
    el.name = "txtLinkCompany-" + iteration;
    el.id = "txtLinkCompany-" + iteration;
    el.size = 25;
    el.style.color = "navy"
    cellLeft.appendChild(el);

    // left center cell
    var cellLeftCenter = row.insertCell(2);
    var el = document.createElement("input");
    el.type = "text";
    el.name = "txtLinkCompanyTitle-" + iteration;
    el.id = "txtLinkCompanyTitle-" + iteration;
    el.size = 25;
    el.style.color = "navy"
    cellLeftCenter.appendChild(el);

    // right center cell
    var cellRightCenter = row.insertCell(3);
    var el = document.createElement("input");
    el.type = "text";
    el.name = "txtLinkURL-" + iteration;
    el.id = "txtLinkURL-" + iteration;
    el.size = 27;
    el.style.color = "navy"
    cellRightCenter.appendChild(el);

    // right cell
    var cellRight = row.insertCell(4);
    var el = document.createElement("select");
    el.name = "linksIcon-" + iteration;
    el.id = "linksIcon-" + iteration;
    //el.style.marginLeft = "9px"
    el.style.color = "navy";
    cellRight.appendChild(el);

    var objOption = document.createElement("option");
    objOption.text = "Other";
    //objOption.appendChild(document.createTextNode('Other'));
    objOption.value = "linksOther-" + iteration;
    //el.options.add(objOption);
    el.appendChild(objOption);

    objOption = document.createElement('option');
    objOption.text = "Buy";
    //objOption.appendChild(document.createTextNode('Buy'));
    objOption.value = "linksBuy-" + iteration;
    //el.options.add(objOption);
    el.appendChild(objOption);

    objOption = document.createElement('option');
    objOption.text = "Map";
    //objOption.appendChild(document.createTextNode('Map'));
    objOption.value = "linksMap-" + iteration;
    //el.options.add(objOption);
    el.appendChild(objOption);

    objOption = document.createElement('option');
    objOption.text = "Google Play";
    //objOption.appendChild(document.createTextNode('GooglePlay'));
    objOption.value = "linksGooglePlay-" + iteration;
    //el.options.add(objOption);
    el.appendChild(objOption);

    // tail cell
    var cellTail = row.insertCell(5);
    var textNode2 = document.createTextNode(" ");
    cellTail.appendChild(textNode2);
}

/******************************************************
					Other Books
******************************************************/
function addRowToTableOther() {
    var tbl = document.getElementById("tableOtherBooks");
    var lastRow = tbl.rows.length;
    var iteration = lastRow + 1;
    var row = tbl.insertRow(lastRow);

    // head cell
    var cellHead = row.insertCell(0);
    var textNode1 = document.createTextNode(" ");
    cellHead.appendChild(textNode1);

    // left cell
    var cellLeft = row.insertCell(1);
    var el = document.createElement("input");
    el.type = "text";
    el.name = "txtOther-" + iteration;
    el.id = "txtOther-" + iteration;
    el.size = 17;
    el.style.color = "navy";
    cellLeft.appendChild(el);

    // left center cell
    var cellLeftCenter = row.insertCell(2);
    var el = document.createElement("input");
    el.type = "text";
    el.name = "txtOtherTitle-" + iteration;
    el.id = "txtOtherTitle-" + iteration;
    el.size = 18;
    el.style.color = "navy";
    cellLeftCenter.appendChild(el);

    // right center cell
    var cellRightCenter = row.insertCell(3);
    var el = document.createElement("input");
    el.type = "text";
    el.name = "txtOtherPDF-" + iteration;
    el.id = "txtOtherPDF-" + iteration;
    el.size = 18;
    el.style.color = "navy";
    cellRightCenter.appendChild(el);

    // right cell
    var cellRight = row.insertCell(4);
    var el = document.createElement("input");
    el.type = "text";
    el.name = "txtOtherAudio-" + iteration;
    el.id = "txtOtherAudio-" + iteration;
    el.size = 18;
    el.style.color = "navy";
    cellRight.appendChild(el);

    // last cell
    var cellLast = row.insertCell(5);
    var el = document.createElement("input");
    el.type = "text";
    el.name = "txtDownload_video-" + iteration;
    el.id = "txtDownload_video-" + iteration;
    el.size = 18;
    el.style.color = "navy";
    cellLast.appendChild(el);

    // tail cell
    var cellTail = row.insertCell(6);
    var textNode2 = document.createTextNode(" ");
    cellTail.appendChild(textNode2);
}

/********************************************
					Watch
********************************************/
function addWatchRowToTableCol4() {
    var whatTable = "tableWatch";
    var txtWebSource = "txtWatchWebSource-";
    var txtResource = "txtWatchResource-";
    var txtURL = "txtWatchURL-";
    var txtWatch = "txtWatchJesusFilm-";
    var txtYouTube = "txtWatchYouTube-";

    var tbl = document.getElementById(whatTable);
    var lastRow = tbl.rows.length;
    var iteration = lastRow + 1;
    var row = tbl.insertRow(lastRow);

    // head cell
    var cellHead = row.insertCell(0);
    var textNode1 = document.createTextNode(" ");
    cellHead.appendChild(textNode1);

    // left cell
    var cellLeft = row.insertCell(1);
    var el = document.createElement("input");
    el.type = "text";
    el.name = txtWebSource + iteration;
    el.id = txtWebSource + iteration;
    el.size = 26;
    el.style.color = "navy";
    cellLeft.appendChild(el);

    // left center cell
    var cellLeftCenter = row.insertCell(2);
    var el = document.createElement("input");
    el.type = "text";
    el.name = txtResource + iteration;
    el.id = txtResource + iteration;
    el.size = 26;
    el.style.color = "navy";
    cellLeftCenter.appendChild(el);

    // right center cell
    var cellRightCenter = row.insertCell(3);
    var el = document.createElement("input");
    el.type = "text";
    el.name = txtURL + iteration;
    el.id = txtURL + iteration;
    el.size = 29;
    el.style.color = "navy";
    cellRightCenter.appendChild(el);

    // JesusFilm cell
    var cellJesusFilm = row.insertCell(4);
    var el = document.createElement("input");
    el.type = "checkbox";
    el.name = txtWatch + iteration;
    el.id = txtWatch + iteration;
    el.size = 1;
    el.style.textAlign = "center";
    el.style.marginLeft = "19px";
    cellJesusFilm.appendChild(el);

    // YouTube cell
    var cellYouTube = row.insertCell(5);
    var el = document.createElement("input");
    el.type = "checkbox";
    el.name = txtYouTube + iteration;
    el.id = txtYouTube + iteration;
    el.size = 1;
    el.style.textAlign = "center";
    el.style.marginLeft = "9px";
    cellYouTube.appendChild(el);

    // tail cell
    var cellTail = row.insertCell(6);
    var textNode2 = document.createTextNode(" ");
    cellTail.appendChild(textNode2);
}

/**********************************************************
					Study
**********************************************************/
function addRowToTableCol5(DatabaseTable) {
    var tbl = document.getElementById("table" + DatabaseTable);
    var lastRow = tbl.rows.length;
    var iteration = lastRow + 1;
    var row = tbl.insertRow(lastRow);

    // head cell
    var cellHead = row.insertCell(0);
    var textNode1 = document.createTextNode(" ");
    cellHead.appendChild(textNode1);

    // left cell
    var cellLeft = row.insertCell(1);
    var el = document.createElement("input");
    el.type = "text";
    el.name = "txtScriptureDescription-" + iteration;
    el.id = "txtScriptureDescription-" + iteration;
    el.size = 14;
    el.style.color = "navy";
    cellLeft.appendChild(el);

    // Testament cell
    var cellTestament = row.insertCell(2);
    var el = document.createElement("select");
    el.name = "txtTestament" + "-" + iteration;
    el.id = "txtTestament" + "-" + iteration;
    el.style.color = "navy"
    cellTestament.appendChild(el);

    objOption = document.createElement('option');
    objOption.text = "New Testament";
    //objOption.appendChild(document.createTextNode('New Testament'));
    objOption.value = "SNT-" + iteration;
    //el.options.add(objOption);
    el.appendChild(objOption);

    var objOption = document.createElement("option");
    objOption.text = "Old Testament";
    //objOption.appendChild(document.createTextNode('Old Testament'));
    objOption.value = "SOT-" + iteration;
    //el.options.add(objOption);
    el.appendChild(objOption);

    objOption = document.createElement('option');
    objOption.text = "Bible";
    //objOption.appendChild(document.createTextNode('Bible'));
    objOption.value = "SBible-" + iteration;
    //el.options.add(objOption);
    el.appendChild(objOption);

    // Alphabet cell
    var cellAlphabet = row.insertCell(3);
    var el = document.createElement("select");
    el.name = "txtAlphabet" + "-" + iteration;
    el.id = "txtAlphabet" + "-" + iteration;
    el.style.color = "navy"
    cellAlphabet.appendChild(el);

    objOption = document.createElement('option');
    objOption.text = "Standard alphabet";
    //objOption.appendChild(document.createTextNode('Standard alphabet'));
    objOption.value = "SStandAlphabet-" + iteration;
    //el.options.add(objOption);
    el.appendChild(objOption);

    var objOption = document.createElement("option");
    objOption.text = "Tranditional alphabet";
    //objOption.appendChild(document.createTextNode('Tranditional alphabet'));
    objOption.value = "STranAlphabet-" + iteration;
    //el.options.add(objOption);
    el.appendChild(objOption);

    objOption = document.createElement('option');
    objOption.text = "New alphabet";
    //objOption.appendChild(document.createTextNode('New alphabet'));
    objOption.value = "SNewAlphabet-" + iteration;
    //el.options.add(objOption);
    el.appendChild(objOption);

    // left center cell
    var cellLeftCenter = row.insertCell(4);
    var el = document.createElement("input");
    el.type = "text";
    el.name = "txtScriptureURL-" + iteration;
    el.id = "txtScriptureURL-" + iteration;
    el.size = 6;
    el.style.color = "navy";
    cellLeftCenter.appendChild(el);

    // center
    var cellCenter = row.insertCell(5);
    var el = document.createElement("input");
    el.type = "text";
    el.name = "txtStatement-" + iteration;
    el.id = "txtStatement-" + iteration;
    el.size = 13;
    el.style.color = "navy";
    cellCenter.appendChild(el);

    // right center cell
    var cellRightCenter = row.insertCell(6);
    var el = document.createElement("input");
    el.type = "text";
    el.name = "txtOthersiteDescription-" + iteration;
    el.id = "txtOthersiteDescription-" + iteration;
    el.size = 5;
    el.style.color = "navy";
    cellRightCenter.appendChild(el);

    // right cell
    var cellRight = row.insertCell(7);
    var el = document.createElement("input");
    el.type = "text";
    el.name = "txtOthersiteURL-" + iteration;
    el.id = "txtOthersiteURL-" + iteration;
    el.size = 14;
    el.style.color = "navy";
    cellRight.appendChild(el);

    // tail cell
    var cellTail = row.insertCell(8);
    var textNode2 = document.createTextNode(" ");
    cellTail.appendChild(textNode2);
}

/**********************************************************
					SAB HTMLs (Edit)
**********************************************************/
function addRowToTableSABHTMLEdit() {
    var tbl = document.getElementById("tableSABHTMLEdit");
    var lastRow = tbl.rows.length;
    var iteration = lastRow + 1;
    var row = tbl.insertRow(lastRow);

    // head cell
    var cellHead = row.insertCell(0);
    var textNode1 = document.createTextNode(" ");
    cellHead.appendChild(textNode1);

    // SABsubfolder cell
    var cellSABsubfolder = row.insertCell(1);
    var el = document.createElement("input");
    el.type = "text";
    el.name = "txtSABsubfolder-" + iteration;
    el.id = "txtSABsubfolder-" + iteration;
    el.size = 15;
    el.style.color = "navy";
    cellSABsubfolder.appendChild(el);

    // SABurl cell
    var cellSABurl = row.insertCell(2);
    var el = document.createElement("input");
    el.type = "text";
    el.name = "txtSABurl-" + iteration;
    el.id = "txtSABurl-" + iteration;
    el.size = 31;
    el.style.color = "navy";
    cellSABurl.appendChild(el);

    // SABdescription cell
    var cellSABdescription = row.insertCell(3);
    var el = document.createElement("input");
    el.type = "text";
    el.name = "txtSABdescription-" + iteration;
    el.id = "txtSABdescription-" + iteration;
    el.size = 31;
    el.style.color = "navy";
    cellSABdescription.appendChild(el);

    // SABpre_scriptoria cell
    var cellSABpre_scriptoria = row.insertCell(4);
    var el = document.createElement("input");
    el.type = "text";
    el.name = "txtSABpre_scriptoria-" + iteration;
    el.id = "txtSABpre_scriptoria-" + iteration;
    el.size = 12;
    el.style.color = "navy";
    cellSABpre_scriptoria.appendChild(el);

    // tail cell
    var cellTail = row.insertCell(5);
    var textNode2 = document.createTextNode(" ");
    cellTail.appendChild(textNode2);
}

/**********************************************************
					SAB HTMLs (Add)
**********************************************************/
function addRowToTableSABHTMLAdd() {
    var tbl = document.getElementById("tableSABHTMLAdd");
    var lastRow = tbl.rows.length;
    var iteration = lastRow + 1;
    var row = tbl.insertRow(lastRow);

    // head cell
    var cellHead = row.insertCell(0);
    var textNode1 = document.createTextNode(" ");
    cellHead.appendChild(textNode1);

    // SABsubfolder cell
    var cellSABsubfolder = row.insertCell(1);
    var el = document.createElement("input");
    el.type = "text";
    el.name = "txtSABsubfolderAdd-" + iteration;
    el.id = "txtSABsubfolderAdd-" + iteration;
    el.size = 15;
    el.style.color = "navy";
    cellSABsubfolder.appendChild(el);

    // SABurl cell
    var cellSABurl = row.insertCell(2);
    var el = document.createElement("input");
    el.type = "text";
    el.name = "txtSABurlAdd-" + iteration;
    el.id = "txtSABurlAdd-" + iteration;
    el.size = 41;
    el.style.color = "navy";
    cellSABurl.appendChild(el);

    // SABdescription cell
    var cellSABdescription = row.insertCell(3);
    var el = document.createElement("input");
    el.type = "text";
    el.name = "txtSABdescriptionAdd-" + iteration;
    el.id = "txtSABdescriptionAdd-" + iteration;
    el.size = 41;
    el.style.color = "navy";
    cellSABdescription.appendChild(el);

    // tail cell
    var cellTail = row.insertCell(4);
    var textNode2 = document.createTextNode(" ");
    cellTail.appendChild(textNode2);
}

/**********************************************************
					Bible.is
**********************************************************/
function addRowToTableBibleIs() {
    var tbl = document.getElementById("tableBibleIs");
    var lastRow = tbl.rows.length;
    var iteration = lastRow + 1;
    var row = tbl.insertRow(lastRow);

    // head cell
    var cellHead = row.insertCell(0);
    var textNode1 = document.createTextNode(" ");
    cellHead.appendChild(textNode1);

    // left cell
    var cellLeft = row.insertCell(1);
    var el = document.createElement("input");
    el.type = "text";
    el.name = "txtLinkBibleIsTitle-" + iteration;
    el.id = "txtLinkBibleIsTitle-" + iteration;
    el.size = 54;
    el.style.color = "navy";
    cellLeft.appendChild(el);

    // URL cell
    var cellURL = row.insertCell(2);
    var el = document.createElement("input");
    el.type = "text";
    el.name = "txtLinkBibleIsURL-" + iteration;
    el.id = "txtLinkBibleIsURL-" + iteration;
    el.size = 30;
    el.style.color = "navy";
    cellURL.appendChild(el);

    // Testament cell
    /*
    var cellTestament = row.insertCell(2);
    var el = document.createElement("select");
    el.name = "BibleIsTestament" + "-" + iteration;
    el.id = "BibleIsTestament" + "-" + iteration;
    el.style.color = "navy"
    cellTestament.appendChild(el);

    objOption = document.createElement('option');
    objOption.text="New Testament";
    / /objOption.appendChild(document.createTextNode('New Testament'));
    objOption.value = "BibleIsNT-" + iteration;
    / /el.options.add(objOption);
    el.appendChild(objOption);

    var objOption = document.createElement("option");
    objOption.text="Old Testament";
    / /objOption.appendChild(document.createTextNode('Old Testament'));
    objOption.value = "BibleIsOT-" + iteration;
    / /el.options.add(objOption);
    el.appendChild(objOption);
	
    // URL cell
    var cellIcon = row.insertCell(3);
    objOption = document.createElement('option');
    objOption.text="Bible";
    / /objOption.appendChild(document.createTextNode('Bible'));
    objOption.value = "BibleIsBible-" + iteration;
    / /el.options.add(objOption);
    el.appendChild(objOption);
    */

    // Which Icon cell
    var cellTitle = row.insertCell(3);
    var el = document.createElement("select");
    el.name = "txtLinkBibleIs" + "-" + iteration;
    el.id = "txtLinkBibleIs" + "-" + iteration;
    el.style.color = "navy"
    cellTitle.appendChild(el);

    objOption = document.createElement('option');
    objOption.text = "Default";
    objOption.value = "BibleIsDefault-" + iteration;
    el.appendChild(objOption);

    var objOption = document.createElement("option");
    objOption.text = "Text";
    objOption.value = "BibleIsText-" + iteration;
    el.appendChild(objOption);

    objOption = document.createElement('option');
    objOption.text = "Audio";
    objOption.value = "BibleIsAudio-" + iteration;
    el.appendChild(objOption);

    objOption = document.createElement('option');
    objOption.text = "BibleIsVideo";
    objOption.value = "BibleIsVideo-" + iteration;
    el.appendChild(objOption);

    // tail cell
    var cellTail = row.insertCell(4);
    var textNode2 = document.createTextNode(" ");
    cellTail.appendChild(textNode2);
}

/******************************************************
				YouVerion and Bible.org and GRN
******************************************************/
function addRowToTableYouVer(DatabaseTable) {
    if (DatabaseTable == "Biblesorg") {
        var name = "Biblesorg";
        var title = "Biblesorg";
        var url = "Biblesorg";
    } else if (DatabaseTable == "YouVersion") {
        var name = "YouVersion";
        var title = "YouVersion";
        var url = "YouVersion";
    } else { // GRN
        var name = "GRN";
        var title = "GRN";
        var url = "GRN";
    }

    var tbl = document.getElementById("table" + DatabaseTable);
    var lastRow = tbl.rows.length;
    var iteration = lastRow + 1;

    var row = tbl.insertRow(lastRow);

    // head cell
    var cellHead = row.insertCell(0);
    var textNode1 = document.createTextNode(" ");
    cellHead.appendChild(textNode1);

    // left
    var cellLeft = row.insertCell(1);
    var el = document.createElement("input");
    el.type = "text";
    el.name = "txtLink" + name + "Name-" + iteration;
    el.id = "txtLink" + name + "Name-" + iteration;
    el.size = 13;
    el.style.color = "navy";
    cellLeft.appendChild(el);

    // center
    var cellCenter = row.insertCell(2);
    var el = document.createElement("input");
    el.type = "text";
    el.name = "txtLink" + title + "Title-" + iteration;
    el.id = "txtLink" + title + "Title-" + iteration;
    el.size = 20;
    el.style.color = "navy";
    cellCenter.appendChild(el);

    // right
    var cellRight = row.insertCell(3);
    var el = document.createElement("input");
    el.type = "text";
    el.name = "txtLink" + url + "URL-" + iteration;
    el.id = "txtLink" + url + "URL-" + iteration;
    el.size = 60;
    el.style.color = "navy";
    cellRight.appendChild(el);

    // tail cell
    var cellTail = row.insertCell(4);
    var textNode2 = document.createTextNode(" ");
    cellTail.appendChild(textNode2);
}

/*****************************************************
					Playlist (Audio and Video)
******************************************************/
function addRowToPlaylist(Playlist) {
    var tbl;
    var Title = "";
    var Filename = "";
    var cellDownload;
    var size_1 = 40;
    var size_2 = 60;
    var insert = 3;
    if (Playlist == "Audio") {
        tbl = document.getElementById("tableAudioPlaylist");
        Title = "txtPlaylistAudioTitle-";
        Filename = "txtPlaylistAudioFilename-";
    } else { // "Video"
        tbl = document.getElementById("tableVideoPlaylist");
        Title = "txtPlaylistVideoTitle-";
        Filename = "txtPlaylistVideoFilename-";
        size_1 = 40;
        size_2 = 40;
        insert = 4;
    }
    var lastRow = tbl.rows.length;
    var iteration = lastRow + 1;
    var row = tbl.insertRow(lastRow);

    // head cell
    var cellHead = row.insertCell(0);
    var textNode1 = document.createTextNode(" ");
    cellHead.appendChild(textNode1);

    // left cell
    var cellLeft = row.insertCell(1);
    var el = document.createElement("input");
    el.type = "text";
    el.name = Title + iteration;
    el.id = Title + iteration;
    el.size = size_1;
    el.style.color = "navy"
    cellLeft.appendChild(el);

    // right center cell
    var cellRight = row.insertCell(2);
    var el = document.createElement("input");
    el.type = "text";
    el.name = Filename + iteration;
    el.id = Filename + iteration;
    el.size = size_2;
    el.style.color = "navy"
    cellRight.appendChild(el);

    // Is it Video?
    if (Playlist == 'Video') {
        var cellDownload = row.insertCell(3);
        var el = document.createElement("select");
        el.name = "PlaylistVideoDownloadIcon-" + iteration;
        el.id = "PlaylistVideoDownloadIcon-" + iteration;
        el.style.color = "navy";
        cellDownload.appendChild(el);

        objOption = document.createElement('option');
        objOption.text = "View";
        objOption.value = "PlaylistVideoView-" + iteration;
        el.appendChild(objOption);

        var objOption = document.createElement("option");
        objOption.text = "Download";
        objOption.value = "PlaylistVideoDownload-" + iteration;
        el.appendChild(objOption);
    }

    // tail cell
    var cellTail = row.insertCell(insert);
    var textNode2 = document.createTextNode(" ");
    cellTail.appendChild(textNode2);
}

/**********************************************
				Remove row
**********************************************/
function removeRowFromTable(tableId) {
    var tbl = document.getElementById(tableId);
    var lastRow = tbl.rows.length;
    if (lastRow > 1) tbl.deleteRow(lastRow - 1);
}


/**********************************************
				All PDF OT Books
**********************************************/
function All_PDF_OT_Books() { // fills in OT book PDFs
    try {
        var OT_PDF_Filename = document.getElementById("OT_PDF_Filename-0");
        if (OT_PDF_Filename.value != "") {
            var BookNumber_RegExp = new RegExp(/[0-9]{2}/);
            var BookName_RegExp = new RegExp(/[A-Z][A-Z]{2}/);
            var ISOCode_RegExp = new RegExp(/[a-z]{3}/);
            var BookNumberArray = OT_PDF_Filename.value.match(BookNumber_RegExp);
            var BookNameArray = OT_PDF_Filename.value.match(BookName_RegExp);
            var ISOCodeArray = OT_PDF_Filename.value.match(ISOCode_RegExp);
            for (index = 1; index < 39; index++) {
                if (BookNumber_RegExp.test(OT_PDF_Filename.value)) {
                    document.getElementById("OT_PDF_Filename-" + index).value = OT_PDF_Filename.value.replace(BookNumberArray[0], (Number(BookNumberArray[0]) + index < 10 ? '0' + (Number(BookNumberArray[0]) + index) : Number(BookNumberArray[0]) + index));
                } else {
                    alert("Error. The Book Number provided is not valid for " + OT_abbr_array[index] + ".");
                }
                if (BookName_RegExp.test(OT_PDF_Filename.value)) {
                    document.getElementById("OT_PDF_Filename-" + index).value = document.getElementById("OT_PDF_Filename-" + index).value.replace(BookNameArray[0], OT_abbr_array[index]);
                } else {
                    alert("Error. The Book Name abbreviation provided is not valid for " + OT_abbr_array[index] + ".");
                }
            }
            All_Books_On_Or_Off("OT_PDF_Table", true);
        }
    } catch (e) {
        alert("Error! This isn't supposs to happen!");
    }
}

/**********************************************
				No PDF OT Books
**********************************************/
function No_PDF_OT_Books() { // fills in NT book PDFs
    try {
        var OT_PDF_Filename = document.getElementById("OT_PDF_Filename-0");
        if (OT_PDF_Filename.value == "") {
            for (index = 1; index < 39; index++) {
                document.getElementById("OT_PDF_Filename-" + index).value = '';
            }
            All_Books_On_Or_Off("OT_PDF_Table", false);
        }
    } catch (e) {
        alert("Error! This isn't supposs to happen!");
    }
}

/**********************************************
				All PDF NT Books
**********************************************/
function All_PDF_NT_Books() { // fills in NT book PDFs
    try {
        var PDF_Filename = document.getElementById("NT_PDF_Filename-0");
        if (PDF_Filename.value != "") {
            var BookNumber_RegExp = new RegExp(/[0-9]{2}/);
            var BookName_RegExp = new RegExp(/[A-Z][A-Z]{2}/);
            var ISOCode_RegExp = new RegExp(/[a-z]{3}/);
            var BookNumberArray = PDF_Filename.value.match(BookNumber_RegExp);
            var BookNameArray = PDF_Filename.value.match(BookName_RegExp);
            var ISOCodeArray = PDF_Filename.value.match(ISOCode_RegExp);
            for (index = 1; index < 27; index++) {
                if (BookNumber_RegExp.test(PDF_Filename.value)) {
                    document.getElementById("NT_PDF_Filename-" + index).value = PDF_Filename.value.replace(BookNumberArray[0], Number(BookNumberArray[0]) + index);
                } else {
                    alert("Error. The Book Number provided is not valid for " + NT_abbr_array[index] + ".");
                }
                if (BookName_RegExp.test(PDF_Filename.value)) {
                    document.getElementById("NT_PDF_Filename-" + index).value = document.getElementById("NT_PDF_Filename-" + index).value.replace(BookNameArray[0], NT_abbr_array[index]);
                } else {
                    alert("Error. The Book Name abbreviation provided is not valid for " + NT_abbr_array[index] + ".");
                }
            }
            All_Books_On_Or_Off("NT_PDF_Table", true);
        }
    } catch (e) {
        alert("Error! This isn't supposs to happen!");
    }
}

/**********************************************
				No PDF NT Books
**********************************************/
function No_PDF_NT_Books() { // deletes in NT book PDFs
    try {
        var PDF_Filename = document.getElementById("NT_PDF_Filename-0");
        if (PDF_Filename.value == "") {
            for (index = 1; index < 27; index++) {
                document.getElementById("NT_PDF_Filename-" + index).value = '';
            }
            All_Books_On_Or_Off("NT_PDF_Table", false);
        }
    } catch (e) {
        alert("Error! This isn't supposs to happen!");
    }
}

/**********************************************
				All OT Audio Chapters
**********************************************/
function All_Audio_OT_Chapters() { // fills in OT audio chapters
    try {
        var OT_Audio_Filename = document.getElementById("OT_Audio_Filename-0-0");
        if (OT_Audio_Filename.value != "") {
            var ISOCode_RegExp = new RegExp(/[a-z]{3}/);
            var BookNumber_RegExp = new RegExp(/[0-9]+/);
            var BookName_RegExp = new RegExp(/[0-9A-Z][A-Z]{2}/);
            var ChapterNumber_RegExp = new RegExp(/01/);
            var Hyphen_RegExp = new RegExp(/[-_]{1,}([.].*$)/);
            var ISOCodeArray = OT_Audio_Filename.value.match(ISOCode_RegExp); // ISO
            var BookNumberArray = OT_Audio_Filename.value.match(BookNumber_RegExp); // book number
            var BookNameArray = OT_Audio_Filename.value.match(BookName_RegExp); // book name
            var ChapterNumberArray = OT_Audio_Filename.value.match(ChapterNumber_RegExp); // chapter number
            for (index = 0; index < 39; index++) { // inerate through number of books
                OT_abbr = OT_abbr_array[index]; // 3 uppercase OT book name
                OT_chapters = OT_How_Many_Chapters_array[index]; // how many chapters per book
                for (z = 0; z < OT_chapters; z++) { // iterate through number of chapters
                    if (BookNumber_RegExp.test(OT_Audio_Filename.value)) { // test if OT_Audio_Filename.value (getElementById("OT_Audio_Filename-0-0")) contains book number 
                        var temp = (parseInt(BookNumberArray[0]) + index).toString(); // book number + inerated number of the book to string
                        var ans;
                        if (parseInt(BookNumberArray[0]) == 18 && parseInt(ChapterNumberArray[0]) > 99) { // PSA and chapeters above 99
                            ans = temp;
                        } else {
                            var pad = "00";
                            ans = pad.substring(0, pad.length - temp.length) + temp; // padding for "01" to "09"
                        }
                        document.getElementById("OT_Audio_Filename-" + index + "-" + z).value = OT_Audio_Filename.value.replace(BookNumberArray[0], ans);
                    } else {
                        alert("Error. The Book Number provided is not valid for " + OT_abbr + ".");
                    }
                    if (BookName_RegExp.test(OT_Audio_Filename.value)) {
                        document.getElementById("OT_Audio_Filename-" + index + "-" + z).value = document.getElementById("OT_Audio_Filename-" + index + "-" + z).value.replace(BookNameArray[0], OT_abbr);
                    } else {
                        alert("Error. The Book Name abbreviation provided is not valid for " + OT_abbr + ".");
                    }
                    y = z + 1;
                    //if (ChapterNumber_RegExp.test(OT_Audio_Filename.value)) { // The Audio_Filename.value should be here!
                    var numBefore = document.getElementById("OT_Audio_Filename-" + index + "-" + z).value.lastIndexOf("01"); // get the end IndexOf of "01" from "OT_Audio_Filename-"+index+"-"+z
                    var numAfter = numBefore + 2;
                    var charBefore = document.getElementById("OT_Audio_Filename-" + index + "-" + z).value.substring(0, numBefore);
                    var charAfter = document.getElementById("OT_Audio_Filename-" + index + "-" + z).value.substring(numAfter);
                    //alert("charBefore: " + charBefore + "\r\ncharAfter: " + charAfter);
                    if (OT_chapters == 1) {
                        //document.getElementById("OT_Audio_Filename-"+index+"-"+z).value = document.getElementById("OT_Audio_Filename-"+index+"-"+z).value.replace(ChapterNumberArray[0], "");
                        document.getElementById("OT_Audio_Filename-" + index + "-" + z).value = charBefore + charAfter;
                        document.getElementById("OT_Audio_Filename-" + index + "-" + z).value = document.getElementById("OT_Audio_Filename-" + index + "-" + z).value.replace(Hyphen_RegExp, "$1");
                    } else {
                        if (z < 9) {
                            //document.getElementById("OT_Audio_Filename-"+index+"-"+z).value = document.getElementById("OT_Audio_Filename-"+index+"-"+z).value.replace(ChapterNumberArray[0], "0"+y);
                            document.getElementById("OT_Audio_Filename-" + index + "-" + z).value = charBefore + "0" + y + charAfter;
                        } else if (z < 99) {
                            //document.getElementById("OT_Audio_Filename-"+index+"-"+z).value = document.getElementById("OT_Audio_Filename-"+index+"-"+z).value.replace(ChapterNumberArray[0], y);
                            document.getElementById("OT_Audio_Filename-" + index + "-" + z).value = charBefore + y + charAfter;
                        } else {
                            if (charBefore.endsWith("0")) { // if it end with "0"
                                charBefore = charBefore.substring(0, charBefore.length - 1); // then delete "0" from the end
                            }
                            document.getElementById("OT_Audio_Filename-" + index + "-" + z).value = charBefore + y + charAfter;
                        }
                    }
                    //}
                    //else {
                    //	alert("Error. The Chapter Number provided is not valid for " + OT_abbr + " and chapter " + y + ".");
                    //}
                }
            }
            All_Audio_On_Or_Off("OT_Audio_Table3", 39, true);
        }
    } catch (e) {
        alert("Error! This isn't supposs to happen! " + e);
    }
}

/**********************************************
				No OT Audio Chapters
**********************************************/
function No_Audio_OT_Chapters() { // deletes in OT audio chapters
    try {
        var OT_Audio_Filename = document.getElementById("OT_Audio_Filename-0-0");
        if (OT_Audio_Filename.value == "") {
            for (index = 0; index < 39; index++) {
                OT_abbr = OT_abbr_array[index];
                OT_chapters = OT_How_Many_Chapters_array[index];
                for (z = 0; z < OT_chapters; z++) {
                    document.getElementById("OT_Audio_Filename-" + index + "-" + z).value = '';
                }
            }
            All_Audio_On_Or_Off("OT_Audio_Table3", 39, false);
        }
    } catch (e) {
        alert("Error! This isn't supposs to happen! " + e);
    }
}

/**********************************************
				One OT Audio Chapters
**********************************************/
function One_OT_Audio_Chapters(index) {
    var OT_Audio_Filename = document.getElementById("OT_Audio_Filename-" + index + "-0");
    if (OT_Audio_Filename.value != "") {
        var ISOCode_RegExp = new RegExp(/[a-z]{3}/);
        var BookNumber_RegExp = new RegExp(/[0-9]+/);
        var BookName_RegExp = new RegExp(/[0-9A-Z][A-Z]{2}/);
        //var ChapterNumber_RegExp = new RegExp(/01/g);
        var ISOCodeArray = OT_Audio_Filename.value.match(ISOCode_RegExp); // ISO
        var BookNumberArray = OT_Audio_Filename.value.match(BookNumber_RegExp); // book number
        var BookNameArray = OT_Audio_Filename.value.match(BookName_RegExp); // book name
        //var ChapterNumberArray = OT_Audio_Filename.value.match(ChapterNumber_RegExp);
        OT_abbr = OT_abbr_array[index]; // 3 uppercase OT book name
        OT_chapters = OT_How_Many_Chapters_array[index];; // how many chapters per book
        for (z = 0; z < OT_chapters; z++) { // iterate through number of chapters
            if (BookNumber_RegExp.test(OT_Audio_Filename.value)) { // test if OT_Audio_Filename.value (getElementById("OT_Audio_Filename-"+index+"-0")) contains book number
                document.getElementById("OT_Audio_Filename-" + index + "-" + z).value = OT_Audio_Filename.value.replace(BookNumberArray[0], BookNumberArray[0].toString());
            } else {
                alert("Error. The Book Number provided is not valid for " + OT_abbr + ".");
            }
            if (BookName_RegExp.test(OT_Audio_Filename.value)) {
                document.getElementById("OT_Audio_Filename-" + index + "-" + z).value = document.getElementById("OT_Audio_Filename-" + index + "-" + z).value.replace(BookNameArray[0], OT_abbr);
            } else {
                alert("Error. The Book Name abbreviation provided is not valid for " + OT_abbr + ".");
            }
            y = z + 1;
            //if (ChapterNumber_RegExp.test(OT_Audio_Filename.value)) { // The Audio_Filename.value should be here!
            var numBefore = document.getElementById("OT_Audio_Filename-" + index + "-" + z).value.lastIndexOf("01"); // get the end IndexOf of "01" from "OT_Audio_Filename-"+index+"-"+z
            var numAfter = numBefore + 2;
            var charBefore = document.getElementById("OT_Audio_Filename-" + index + "-" + z).value.substring(0, numBefore);
            var charAfter = document.getElementById("OT_Audio_Filename-" + index + "-" + z).value.substring(numAfter);
            //alert("charBefore: " + charBefore + "\r\ncharAfter: " + charAfter);
            if (OT_chapters == 1) {
                //document.getElementById("OT_Audio_Filename-"+index+"-"+z).value = document.getElementById("OT_Audio_Filename-"+index+"-"+z).value.replace(ChapterNumberArray[0], "");
                document.getElementById("OT_Audio_Filename-" + index + "-" + z).value = charBefore + charAfter;
            } else {
                if (z < 9) {
                    //document.getElementById("OT_Audio_Filename-"+index+"-"+z).value = document.getElementById("OT_Audio_Filename-"+index+"-"+z).value.replace(ChapterNumberArray[0], "0"+y);
                    document.getElementById("OT_Audio_Filename-" + index + "-" + z).value = charBefore + "0" + y + charAfter;
                } else if (z < 99) {
                    //document.getElementById("OT_Audio_Filename-"+index+"-"+z).value = document.getElementById("OT_Audio_Filename-"+index+"-"+z).value.replace(ChapterNumberArray[0], y);
                    document.getElementById("OT_Audio_Filename-" + index + "-" + z).value = charBefore + y + charAfter;
                } else {
                    if (charBefore.endsWith("0")) { // if it end with "0"
                        charBefore = charBefore.substring(0, charBefore.length - 1); // then delete "0" from the end
                    }
                    document.getElementById("OT_Audio_Filename-" + index + "-" + z).value = charBefore + y + charAfter;
                }
            }
            //}
            //else {
            //	alert("Error. The Chapter Number provided is not valid for " + OT_abbr + " and chapter " + y + ".");
            //}
        }
        Audio_On_Or_Off("OT_Audio_Table3-" + index, true);
    }
}

/**********************************************
				No one OT Audio Chapters
**********************************************/
function One_No_OT_Audio_Chapters(num_book_sel) {
    var OT_Audio_Filename = document.getElementById("OT_Audio_Filename-" + num_book_sel + "-0");
    if (OT_Audio_Filename.value == "") {
        OT_abbr = OT_abbr_array[num_book_sel];
        OT_chapters = OT_How_Many_Chapters_array[num_book_sel];
        for (z = 0; z < OT_chapters; z++) {
            document.getElementById("OT_Audio_Filename-" + num_book_sel + "-" + z).value = '';
        }
        Audio_On_Or_Off("OT_Audio_Table3-" + num_book_sel, false);
    }
}

/**********************************************
				All NT Audio Chapters
**********************************************/
function All_Audio_NT_Chapters() { // fills in NT audio chapters
    try {
        var Audio_Filename = document.getElementById("NT_Audio_Filename-0-0");
        if (Audio_Filename.value != "") {
            var ISOCode_RegExp = new RegExp(/[a-z]{3}/);
            var BookNumber_RegExp = new RegExp(/[0-9]+/);
            var BookName_RegExp = new RegExp(/[0-9A-Z][A-Z]{2}/);
            var ChapterNumber_RegExp = new RegExp(/01/);
            var Hyphen_RegExp = new RegExp(/[-_]{1,}([.].*$)/);
            var ISOCodeArray = Audio_Filename.value.match(ISOCode_RegExp);
            var BookNumberArray = Audio_Filename.value.match(BookNumber_RegExp);
            var BookNameArray = Audio_Filename.value.match(BookName_RegExp);
            var ChapterNumberArray = Audio_Filename.value.match(ChapterNumber_RegExp);
            for (index = 0; index < 27; index++) {
                NT_abbr = NT_abbr_array[index];
                NT_chapters = NT_How_Many_Chapters_array[index];
                for (z = 0; z < NT_chapters; z++) {
                    if (BookNumber_RegExp.test(Audio_Filename.value)) {
                        document.getElementById("NT_Audio_Filename-" + index + "-" + z).value = Audio_Filename.value.replace(BookNumberArray[0], Number(BookNumberArray[0]) + index);
                    } else {
                        alert("Error. The Book Number provided is not valid for " + NT_abbr + ".");
                    }
                    if (BookName_RegExp.test(Audio_Filename.value)) {
                        document.getElementById("NT_Audio_Filename-" + index + "-" + z).value = document.getElementById("NT_Audio_Filename-" + index + "-" + z).value.replace(BookNameArray[0], NT_abbr);
                    } else {
                        alert("Error. The Book Name abbreviation provided is not valid for " + NT_abbr + ".");
                    }
                    y = z + 1;
                    if (ChapterNumber_RegExp.test(Audio_Filename.value)) { // The Audio_Filename.value should be here!
                        if (NT_chapters == 1) {
                            document.getElementById("NT_Audio_Filename-" + index + "-" + z).value = document.getElementById("NT_Audio_Filename-" + index + "-" + z).value.replace(ChapterNumberArray[0], "");
                            document.getElementById("NT_Audio_Filename-" + index + "-" + z).value = document.getElementById("NT_Audio_Filename-" + index + "-" + z).value.replace(Hyphen_RegExp, "$1");
                        } else {
                            if (z < 9) {
                                document.getElementById("NT_Audio_Filename-" + index + "-" + z).value = document.getElementById("NT_Audio_Filename-" + index + "-" + z).value.replace(ChapterNumberArray[0], "0" + y);
                            } else {
                                document.getElementById("NT_Audio_Filename-" + index + "-" + z).value = document.getElementById("NT_Audio_Filename-" + index + "-" + z).value.replace(ChapterNumberArray[0], y);
                            }
                        }
                    } else {
                        alert("Error. The Chapter Number provided is not valid for " + NT_abbr + " and chapter " + y + ".");
                    }
                }
            }
            All_Audio_On_Or_Off("NT_Audio_Table3", 27, true);
        }
    } catch (e) {
        alert("Error! This isn't supposs to happen! " + e);
    }
}

/**********************************************
				No all NT Audio Chapters
**********************************************/
function No_Audio_NT_Chapters() { // deletes in NT audio chapters
    try {
        var Audio_Filename = document.getElementById("NT_Audio_Filename-0-0");
        if (Audio_Filename.value == "") {
            for (index = 0; index < 27; index++) {
                NT_abbr = NT_abbr_array[index];
                NT_chapters = NT_How_Many_Chapters_array[index];
                for (z = 0; z < NT_chapters; z++) {
                    document.getElementById("NT_Audio_Filename-" + index + "-" + z).value = '';
                }
            }
            All_Audio_On_Or_Off("NT_Audio_Table3", 27, false);
        }
    } catch (e) {
        alert("Error! This isn't supposs to happen! " + e);
    }
}

/**********************************************
				One NT Audio Chapters
**********************************************/
function One_NT_Audio_Chapters(index) {
    var Audio_Filename = document.getElementById("NT_Audio_Filename-" + index + "-0"); // index is the number of the book (0 through < 27). 0 is the chapter number
    if (Audio_Filename.value != "") { // e.g. 41-[ISO]-MAT-01.mp3
        var ISOCode_RegExp = new RegExp(/[a-z]{3}/); // the RegExp pattern for ISO code
        var BookNumber_RegExp = new RegExp(/[0-9]+/); // the RegExp pattern for last number: 01
        var BookName_RegExp = new RegExp(/[0-9A-Z][A-Z]{2}/); // the RegExp pattern for standard SIL abbreviation
        //var ChapterNumber_RegExp = new RegExp(/01/);
        var ISOCodeArray = Audio_Filename.value.match(ISOCode_RegExp); // the ISO code
        var BookNumberArray = Audio_Filename.value.match(BookNumber_RegExp); // the last number: 01
        var BookNameArray = Audio_Filename.value.match(BookName_RegExp); // the standard SIL abbreviation
        //var ChapterNumberArray = Audio_Filename.value.match(ChapterNumber_RegExp);
        NT_abbr = NT_abbr_array[index]; // In this js file above: 3 uppercase standard SIL abbreviation
        NT_chapters = NT_How_Many_Chapters_array[index]; // In this js file above: the number of the last chapter of the book
        for (z = 0; z < NT_chapters; z++) { // iterate through the chapters
            if (BookNumber_RegExp.test(Audio_Filename.value)) { // test Audio_Filename.value for the last /[0-9]+/. test = 'true' then
                document.getElementById("NT_Audio_Filename-" + index + "-" + z).value = Audio_Filename.value.replace(BookNumberArray[0], BookNumberArray[0].toString()); // add to empty
            } else {
                alert("Error. The Book Number provided is not valid for " + NT_abbr + "."); // The book number of ISO is not valid.
            }
            if (BookName_RegExp.test(Audio_Filename.value)) { // test Audio_Filename.value for /[0-9A-Z][A-Z]{2}/. test = 'true' then
                document.getElementById("NT_Audio_Filename-" + index + "-" + z).value = document.getElementById("NT_Audio_Filename-" + index + "-" + z).value.replace(BookNameArray[0], NT_abbr); // add to empty
            } else {
                alert("Error. The Book Name abbreviation provided is not valid for " + NT_abbr + "."); // The book name abbreviation of ISO is not valid.
            }
            y = z + 1;
            //if (ChapterNumber_RegExp.test(Audio_Filename.value)) { // The Audio_Filename.value should be here!
            var numBefore = document.getElementById("NT_Audio_Filename-" + index + "-" + z).value.lastIndexOf("01");
            var numAfter = numBefore + 2;
            var charBefore = document.getElementById("NT_Audio_Filename-" + index + "-" + z).value.substring(0, numBefore); // e.g. 41-MAT-[ISO]-
            var charAfter = document.getElementById("NT_Audio_Filename-" + index + "-" + z).value.substring(numAfter); // e.g. .mp3
            //alert("charBefore: " + charBefore + "\r\ncharAfter: " + charAfter);
            if (NT_chapters == 1) { // if the last chapter = 1
                //document.getElementById("NT_Audio_Filename-"+index+"-"+z).value = document.getElementById("NT_Audio_Filename-"+index+"-"+z).value.replace(ChapterNumberArray[0], "");
                document.getElementById("NT_Audio_Filename-" + index + "-" + z).value = charBefore + charAfter;
            } else {
                if (z < 9) {
                    //document.getElementById("NT_Audio_Filename-"+index+"-"+z).value = document.getElementById("NT_Audio_Filename-"+index+"-"+z).value.replace(ChapterNumberArray[0], "0"+y);
                    document.getElementById("NT_Audio_Filename-" + index + "-" + z).value = charBefore + "0" + y + charAfter;
                } else {
                    //document.getElementById("NT_Audio_Filename-"+index+"-"+z).value = document.getElementById("NT_Audio_Filename-"+index+"-"+z).value.replace(ChapterNumberArray[0], y);
                    document.getElementById("NT_Audio_Filename-" + index + "-" + z).value = charBefore + y + charAfter;
                }
            }
            //}
            //else {
            //	alert("Error. The Chapter Number provided is not valid for " + NT_abbr + " and chapter " + y + ".");
            //}
        }
        Audio_On_Or_Off("NT_Audio_Table3-" + index, true);
    }
}

/**********************************************
				No one OT Audio Chapters
**********************************************/
function One_No_NT_Audio_Chapters(index) {
    var Audio_Filename = document.getElementById("NT_Audio_Filename-" + index + "-0");
    if (Audio_Filename.value == "") {
        NT_abbr = NT_abbr_array[index];
        NT_chapters = NT_How_Many_Chapters_array[index];
        //alert(Audio_Filename.value + ' # ' + NT_abbr + ' Z ' + NT_chapters);
        for (z = 0; z < NT_chapters; z++) {
            document.getElementById("NT_Audio_Filename-" + index + "-" + z).value = '';
        }
        Audio_On_Or_Off("NT_Audio_Table3-" + index, false);
    }
}

// http://www.foo.com/index.html?bob=123&frank=321&tom=213#top
// var frank_param = getURLvar("frank");
function getURLvar(name) {
    name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
    var regexS = "[\\?&]" + name + "=([^&#]*)";
    var regex = new RegExp(regexS);
    var results = regex.exec(window.location.href);
    if (results == null)
        return "";
    else
        return results[1];
}

/**********************************************************
				Alternate Language Name: up or down
**********************************************************/
function moveUpDownALN(tableId, upDown) {
    var tbl = document.getElementById(tableId);
    var lastRow = tbl.rows.length; // that is 'tr'
    var currentValue = "";
    var idIndex = 0;

    // ALNindex is a global variable

    // build the array id from the input id numbers
    var id = [];
    var temp = "";
    for (var curRow = 0; curRow < lastRow; curRow++) { // index start with 0; ingore "curRow"
        temp = tbl.rows[curRow].cells[1].getElementsByTagName("input")[0].id;
        id.push(parseInt(temp.substr(temp.indexOf("-") + 1))); // add to id
        //console.log("curRow (index) = " + curRow + "; id[curRow] (value) = " + id[curRow] + "; " + tbl.rows[curRow].cells[1].getElementsByTagName("input")[0].value);								// value
    };

    // which input text ('txtAltNames-'+ALNindex) has the focus?
    idIndex = id.indexOf(ALNindex); // 0 to lastRow - 1 order by actual input list; equals position
    if (idIndex === 0 && upDown == "up") {
        return;
    }
    if (idIndex === lastRow - 1 && upDown == "down") {
        return;
    }

    //console.log("id[idIndex] = " + id[idIndex]);
    currentValue = document.getElementById('txtAltNames-' + id[idIndex]).value;

    if (upDown == "up") {
        var idxUp = id[idIndex - 1];
        document.getElementById('txtAltNames-' + id[idIndex]).value = document.getElementById('txtAltNames-' + idxUp).value;
        document.getElementById('txtAltNames-' + idxUp).value = currentValue;
        document.getElementById('txtAltNames-' + idxUp).focus();
        ALNindex = idxUp;
    } else { // upDown == "down"
        var idxDown = id[idIndex + 1];
        document.getElementById('txtAltNames-' + id[idIndex]).value = document.getElementById('txtAltNames-' + idxDown).value;
        document.getElementById('txtAltNames-' + idxDown).value = currentValue;
        document.getElementById('txtAltNames-' + idxDown).focus();
        ALNindex = idxDown;
    }
}

/**********************************************************
				ISO ROD index
**********************************************************/
function iso_idx() {
    var isoIdx = document.getElementById('iso_idx').value;
    var result = /^[0-9]{1,4}$/.test(isoIdx);
    if (result == false) {
        result = /^[a-z]{3}$/.test(isoIdx);
        if (result == false) {
            document.getElementById('iso_response').innerHTML = '<div style="color: red; margin-top: 12px; font-size: 16pt; ">Can only be the 3 lowercase letters or numbers up to 4 digits.</div>';
            document.getElementById('iso_idx').value = '';
            return;
        } else {
            // iso code
            var response = '';
            const xmlhttp = new XMLHttpRequest();
            var url = "iso_direct.php";
            url = url + "?iso=" + isoIdx;
            url = url + "&sid=" + Math.random();
            xmlhttp.open("GET", url);
            // Defining event listener for readystatechange event
            xmlhttp.onreadystatechange = function() {
                    // Check if the request is compete and was successful
                    if (this.readyState === 4 && this.status === 200) {
                        // Inserting the response from server into an HTML element
                        // this.responseText has return in iso_direct.php
                        if (this.responseText.indexOf("|") === -1) {
                            if (/^[0-9]/.test(this.responseText)) {
                                var tempArray = this.responseText.split("~");
                                parent.location = "Scripture_Edit.php?idx=" + tempArray[0]; // [0] = $idx
                                return;
                            } else {
                                // start with a letter
                                document.getElementById('iso_response').innerHTML = '<div style="color: red; margin-top: 12px; font-size: 16pt; ">' + this.responseText + '</div>';
                                return;
                            }
                        }
                        var idx = 0;
                        var LN = '';
                        var alt = '';
                        var iso = '';
                        var rod = '';
                        var VD = '';
                        var Eng_country = '';
                        var iso_response = [];
                        var iso_responses = this.responseText.split("|");
                        response = "<div id='NamesLang' class='callR'>";
                        response += "<div id='CT'>";
                        response += "<table id='CountryTable'>";
                        response += "<h2>Choose the 'pencil' to edit</h2>";
                        response += "<th width='6%' class='secondHeader'>Edit:</th>";
                        response += "<th width='32%' class='secondHeader'>Language Name:</th>";
                        response += "<th width='34%' class='secondHeader'>Alternate Language Names:</th>";
                        response += "<th width='20%' class='secondHeader'>ISO ROD Code<br />Variant Code:</th>";
                        response += "<th width='8%' class='secondHeader'>Country:</th>";
                        var i = 0;
                        while (i < iso_responses.length) {
                            if (i % 2)
                                color = "f8fafa";
                            else
                                color = "EEF1F2";
                            iso_response = iso_responses[i].split("~");
                            // idx . '~' . LN . '~' . alt '~' . iso . '~' . rod . '~' . VD . '~' . Eng_country
                            idx = iso_response[0];
                            LN = iso_response[1];
                            alt = iso_response[2];
                            iso = iso_response[3];
                            rod = iso_response[4];
                            VD = iso_response[5];
                            Eng_country = iso_response[6];
                            response += "<tr valign='middle' style='color: black; background-color: #" + color + "; margin: 0px; padding: 0px; '>";
                            response += "<td width='6%' style='cursor: pointer; ' onclick='parent.location=\"Scripture_Edit.php?idx=" + idx + "\"'><img style='margin-bottom: 3px; margin-left: 13px; cursor: hand; ' src='images/pencil_edit.png' /></td>";
                            response += "<td width='28%' style='background-color: #" + color + "; margin: 0px; padding: 3px 5px 3px 5px; border-width: thin; border-style: none; border-color: #" + color + "; '>" + LN + "</td>";
                            response += "<td width='31%' style='background-color: #" + color + "; margin: 0px; padding: 3px 5px 3px 5px; border-width: thin; border-style: none; border-color: #" + color + "; '>" + alt + "</td>";
                            response += "<td width='15%' style='background-color: #" + color + "; margin: 0px; padding: 3px 5px 3px 5px; border-width: thin; border-style: none; border-color: #" + color + "; '>" + iso + " " + rod;
                            if (VD != '') {
                                response += "<br /><span style='font-style: italic; font-size: 8pt; '>(" + VD + ")</span>";
                            }
                            response += '</td>';
                            response += "<td width='20%'style='margin: 0px; padding: 3px 5px 3px 5px; border-width: thin; border-style: none; border-color: #" + color + "; '>" + Eng_country + "</td>";
                            response += '</tr>';
                            i++;
                        }
                        response += '</table>';
                        response += '</div>';
                        response += '</div>';
                        document.getElementById('iso_response').innerHTML = response;
                        //document.getElementById("buttons").style.display = 'none';
                    }
                }
                // Sending the request to the server
            xmlhttp.send();
            //parent.location="Scripture_Edit.php?idx="+isoIdx;
        }
    } else {
        // idx numbers
        parent.location = "Scripture_Edit.php?idx=" + isoIdx;
    }
}