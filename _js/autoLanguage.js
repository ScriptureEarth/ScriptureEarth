// JavaScript Document

// Get the HTTP Object
	function getHTTPObject() {													// get the AJAX object; can be used more than once
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

	function showLanguage(str, st) {											// get the names of the languages
		if (str.length <= 2) {
			document.getElementById("languageSearchID").options.length = 0;		// delete all of the options
			document.getElementById("languageSearchID").style.height = '25px';
			var arrayOption;
			arrayOption = document.createElement("option");						// create the option
			arrayOption.text = ' Select the languages...';
			document.getElementById("languageSearchID").add(arrayOption);		// add the option
			return;
		}
		else {
			//document.getElementById("languageSearchID").size = "6";			// WONT WORK!
		}
		var re = /[ A-Za-záéíóúÑñç.,'-()ãõâêîôûäëöüï&]/;
		var foundArray = re.exec(str.substring(str.length - 1));				// the last character of the str
		if (!foundArray) {														// is the value of the last character of the str isn't A-Za - z then it returns
			document.getElementById("showLanguageID").value = document.getElementById("showLanguageID").value.substring(0, document.getElementById("showLanguageID").value.length-1);
			alert(str.substring(str.length - 1) + " is an invalid character. Use an alphabetic character.");
			str = str.substring(0, str.length-1);
			if (str.length == 0) {
				document.getElementById("languageSearchID").innerHTML = "";
				//document.getElementById("languageSearchID").style.border = "0px";
			}
			return;
		}
		xmlhttp = getHTTPObject();												// the ISO object (see JavaScript function getHTTPObject() above)
		if (xmlhttp == null) {
			return;
		}
		/****************************************************************************************************************
			AJAX - languageSearch.php
		****************************************************************************************************************/
		var url = "languageSearch.php";
		url = url + "?language=" + str;
		url = url + "&st=" + st;
		url = url + "&sid=" + Math.random();
		xmlhttp.open("GET", url, true);											// open the AJAX object with livesearch.php
		xmlhttp.send(null);
		xmlhttp.onreadystatechange = function() {								// the function that returns for AJAZ object
			if (xmlhttp.readyState == 4) {										// if the readyState = 4 then livesearch is displayed
				var splits = xmlhttp.responseText.split('<br />');				// Display all of the languages that have 'language' as a part of it.
				var x = document.getElementById("languageSearchID");
				x.options.length = 0;											// delete all of the options
				//var arrayOption;
				//var firstSplit;
				var arrayOption;
				arrayOption = document.createElement("option");					// create the option
				arrayOption.text = splits[0];
				arrayOption.value = '';
				x.add(arrayOption);												// add the option
				for (var i = 1; i < splits.length; i++) {
					var firstSplit = splits[i].split('|');
					arrayOption = document.createElement("option");				// create the option
					arrayOption.text = firstSplit[0];
					arrayOption.value = firstSplit[1];
					x.add(arrayOption);											// add the option
				}
				//x.size = '6';													// WONT WORK!
				//x.setAttribute('style', 'size: 6');							// WONT WORK!
			}
		}
	}	

	function dispLang(ISO_ROD_index, st) {										// display the 1 language
		if (ISO_ROD_index == 'undefined') return;								// i.e. "This language is not found." without an ISO_ROD_index
		dispLangxmlhttp = getHTTPObject();
		if (dispLangxmlhttp == null) {
			return;
		}
		var root = '';
		switch (st) {
			case 'dut':
				root = '00d-Bijbel_Indice.php';
				break;
			case 'spa':
				root = '00e-Escrituras_Indice.php';
				break;
			case 'fre':
				root = '00f-Ecritures_Indice.php';
				break;
			case 'eng':
				root = '00i-Scripture_Index.php';
				break;
			case 'por':
				root = '00p-Escrituras_Indice.php';
				break;
			default:
				alert('"root" never found.');
		}
		/****************************************************************************************************************
			AJAX - languageReveal.php
		****************************************************************************************************************/
		var url = "languageReveal.php";
		url = url + "?ISO_ROD_index=" + ISO_ROD_index;
		url = url + "&sid=" + Math.random();
		dispLangxmlhttp.open("GET", url, true);
		dispLangxmlhttp.send(null);
		dispLangxmlhttp.onreadystatechange = function() {
			if (dispLangxmlhttp.readyState == 4) {
				var str = dispLangxmlhttp.responseText;
				var res = str.split("|");
				var ISO = res[0];
				var ROD_Code = res[1];
				var Variant_Code = res[2];
				location.replace(root+'?sortby=lang&name='+ISO+'&ROD_Code='+ROD_Code+'&Variant_Code='+Variant_Code);
				return;
			}
		}
	}