// JavaScript Document
// Scott Starker
// pure JavaScript code:


/*************************************************************************************************************************************
*
* 			CAREFUL when your making any additions! Any "onclick", "change", etc. that occurs on "input", "a", "div", etc.
* 			should be placed in "_js/CMS_events.js". Also, in "_js/CMS_events.js" any errors in previous statements will
* 			not works in any of the satesments then on. It can also help in the Firefox browser (version 79.0+) run
* 			"Scripture_[Add|Edit].php", menu "Tools", "Web developement", and "Toggle Tools". Then menu "Debugger". In the left
* 			side of the windows click on "Scripture {Add|Edit]", Localhost", "_js", and "CMS_events.js". Look down the js file
* 			and find out if there are errors using the "underline" indicator and fix them if there are any. You can also
* 			use "Scripture_[Add|Edit].php" just to make sure that the document.getElementById('...') name is corrent.
*
* 			There no stements in "_js/CMS_events.js" (8/2020) in "Submit{Add|Edit]Confirm.php".
*
*			In either Scripture_[Add|Edit].php if one function is one php and it isn't in the other it will fail! Take a look at
*				addSABHTMLEdit and addSABHTMLAdd where they fail.
*
*			But, BE CAREFUL!
*
**************************************************************************************************************************************/


// Add script
document.getElementById('addRowTableCountry').addEventListener( 'click', function() { addRowToTableCol1('tableEngCountries', 'Eng_country'); } );

document.getElementById('removeRowTableCountry').addEventListener( 'click', function() { removeRowFromTable('tableEngCountries'); } );

document.getElementById('addRowTableAlt').addEventListener( 'click', function() { addRowToTableALN('tableAltNames', 'txtAltNames'); } );

document.getElementById('removeRowTableAlt').addEventListener( 'click', function() { removeRowFromTable('tableAltNames'); } );

document.getElementById('Open_OT_PDFs').addEventListener( 'click', function() { classChange('OT_Books', 'DisplayBlock', 'OT_PDF_Button'); } );

document.getElementById('Close_OT_PDF').addEventListener( 'click', function() { classChange('OT_Books', 'DisplayNone', 'OT_PDF_Button'); } );

document.getElementById('OT_PDF_Books').addEventListener( 'click', function() { All_PDF_OT_Books(); } );

document.getElementById('No_OT_PDF_Books').addEventListener( 'click', function() { No_PDF_OT_Books(); } );

document.getElementById('Open_NT_PDFs').addEventListener( 'click', function() { classChange('NT_Books', 'DisplayBlock', 'PDF_Button'); } );

document.getElementById('Close_NT_PDF').addEventListener( 'click', function() { classChange('NT_Books', 'DisplayNone', 'PDF_Button'); } );

document.getElementById('NT_PDF_Books').addEventListener( 'click', function() { All_PDF_NT_Books(); } );

document.getElementById('No_NT_PDF_Books').addEventListener( 'click', function() { No_PDF_NT_Books(); } );

document.getElementById('Open_OT_audio').addEventListener( 'click', function() { classChange('OT_Audio', 'DisplayBlock', 'OT_Audio_Button'); } );

document.getElementById('Close_OT_audio').addEventListener( 'click', function() { classChange('OT_Audio', 'DisplayNone', 'OT_Audio_Button'); } );

document.getElementById('OT_Audio_Chapters').addEventListener( 'click', function() { All_Audio_OT_Chapters(); } );

document.getElementById('No_OT_Audio_Chapters').addEventListener( 'click', function() { No_Audio_OT_Chapters(); } );

document.getElementById('Open_NT_audio').addEventListener( 'click', function() { classChange('NT_Audio', 'DisplayBlock', 'Audio_Button'); } );

document.getElementById('Close_NT_audio').addEventListener( 'click', function() { classChange('NT_Audio', 'DisplayNone', 'Audio_Button'); } );

document.getElementById('NT_Audio_Chapters').addEventListener( 'click', function() { All_Audio_NT_Chapters(); } );

document.getElementById('No_NT_Audio_Chapters').addEventListener( 'click', function() { No_Audio_NT_Chapters(); } );

//document.getElementById('addSABHTMLEdit').addEventListener( 'click', function() { addRowToTableSABHTMLEdit(); } );

//document.getElementById('removeSABHTMLEdit').addEventListener( 'click', function() { removeRowFromTable('tableSABHTMLEdit'); } );

//document.getElementById('addSABHTMLAdd').addEventListener( 'click', function() { addRowToTableSABHTMLAdd(); } );

//document.getElementById('removeSABHTMLAdd').addEventListener( 'click', function() { removeRowFromTable('tableSABHTMLAdd'); } );

document.getElementById('addBibleIs').addEventListener( 'click', function() { addRowToTableBibleIs(); } );

document.getElementById('removeBibleIs').addEventListener( 'click', function() { removeRowFromTable('tableBibleIs'); } );

document.getElementById('addYouVer').addEventListener( 'click', function() { addRowToTableYouVer('YouVersion'); } );

document.getElementById('removeYouVer').addEventListener( 'click', function() { removeRowFromTable('tableYouVersion'); } );
 
document.getElementById('addBiblesorg').addEventListener( 'click', function() { addRowToTableYouVer('Biblesorg'); } );

document.getElementById('removeBiblesorg').addEventListener( 'click', function() {removeRowFromTable('tableBiblesorg'); } );

document.getElementById('addGRN').addEventListener( 'click', function() { addRowToTableYouVer('GRN'); } );

document.getElementById('removeGRN').addEventListener( 'click', function() {removeRowFromTable('tableGRN'); } );

document.getElementById('addCell').addEventListener( 'click', function() { addRowToCellPhone(); } );

document.getElementById('removeCell').addEventListener( 'click', function() { removeRowFromTable('tableCellPhone'); } );

document.getElementById('addWatch').addEventListener( 'click', function() { addWatchRowToTableCol4(); } );

document.getElementById('removeWatch').addEventListener( 'click', function() { removeRowFromTable('tableWatch'); } );

document.getElementById('addStudy').addEventListener( 'click', function() { addRowToTableCol5('Study'); } );

document.getElementById('removeStudy').addEventListener( 'click', function() { removeRowFromTable('tableStudy'); } );

document.getElementById('addOther').addEventListener( 'click', function() { addRowToTableOther(); } );

document.getElementById('removeOther').addEventListener( 'click', function() { removeRowFromTable('tableOtherBooks'); } );

document.getElementById('addBuy').addEventListener( 'click', function() { addRowToTableCol3('Buy'); } );
 
document.getElementById('removeBuy').addEventListener( 'click', function() { removeRowFromTable('tableBuy'); } );

document.getElementById('addLinks').addEventListener( 'click', function() { addLinksRowToTableCol4(); } );
 
document.getElementById('removeLinks').addEventListener( 'click', function() { removeRowFromTable('tableLinks'); } );

document.getElementById('addPLAudio').addEventListener( 'click', function() { addRowToPlaylist('Audio'); } );
 
document.getElementById('removePLAudio').addEventListener( 'click', function() { removeRowFromTable('tableAudioPlaylist'); } );

document.getElementById('addPLVideo').addEventListener( 'click', function() { addRowToPlaylist('Video'); } );
 
document.getElementById('removePLVideo').addEventListener( 'click', function() { removeRowFromTable('tableVideoPlaylist'); } );

document.getElementById("SILlink").addEventListener("click", function() { 
	if (document.getElementById("SILlink").checked)
		document.getElementById("SILlinker").value = "on";
	else
		document.getElementById("SILlinker").value = "off";
});


// edit script
//document.getElementById('iso_idx_goto').addEventListener( 'click', function() { iso_idx(); } );

document.getElementById('OT_PDF_Books').addEventListener( 'click', function() { All_PDF_OT_Books(); } );

document.getElementById('No_OT_PDF_Books').addEventListener( 'click', function() { No_PDF_OT_Books(); } );

document.getElementById('NT_PDF_Books').addEventListener( 'click', function() { All_PDF_NT_Books(); } );

document.getElementById('No_NT_PDF_Books').addEventListener( 'click', function() { No_PDF_NT_Books(); } );

document.getElementById('OT_Audio_Chapters').addEventListener( 'click', function() { All_Audio_OT_Chapters(); } );

document.getElementById('No_OT_Audio_Chapters').addEventListener( 'click', function() { No_Audio_OT_Chapters(); } );

document.getElementById('NT_Audio_Chapters').addEventListener( 'click', function() { All_Audio_NT_Chapters(); } );

document.getElementById('No_NT_Audio_Chapters').addEventListener( 'click', function() { No_Audio_NT_Chapters(); } );

document.getElementById('viewer').addEventListener( 'click', function() {
	if (document.getElementById("viewer").checked)
		document.getElementById("viewerer").value = "on";
	else
		document.getElementById("viewerer").value = "off";
});

document.getElementById('rtl').addEventListener( 'click', function() {
	if (document.getElementById("rtl").checked)
		document.getElementById("rtler").value = "on";
	else
		document.getElementById("rtler").value = "off";
});

document.getElementById('eBible').addEventListener( 'click', function() {
	if (document.getElementById("eBible").checked)
		document.getElementById("eBibleer").value = "on";
	else
		document.getElementById("eBibleer").value = "off";
});
