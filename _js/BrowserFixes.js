// JavaScript Document Browser Fixes

/*
	Inspite of all the css options there are still problems with html.
	1) In index.htm and 00z-Scripture_Index.php,
		#bottomBanner ul has to have margin: 0px 0px 0px 0px; and li.bottomBannerText padding: 67px 0px 0px 0px; for Firefox and Netscape vertical align of the words
		#bottomBanner ul has to have margin: 53px 0px 0px 0px; and li.bottomBannerText padding: 0px 0px 0px 0px; for IE and Opera vertical align of the words
		#bottomBanner ul has to have margin: 33px 0px 0px 0px; and li.bottomBannerText padding: 0px 0px 0px 0px; for Safari vertical align of the words
	2) In 00z-Scripture_Index.php,

if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)){ //test for MSIE x.x;
 var ieversion=new Number(RegExp.$1) // capture x.x portion and store as a number
 if (ieversion>=8)
  document.write("You're using IE8 or above")
 else if (ieversion>=7)
  document.write("You're using IE7.x")
 else if (ieversion>=6)
  document.write("You're using IE6.x")
 else if (ieversion>=5)
  document.write("You're using IE5.x")
}

*/

/*function zgetCSSRule(name) {
    if (document.styleSheets) {
        for (var ii=0; ii<document.styleSheets.length; ii++) {
            var styleSheet = document.styleSheets[ii];
            var cssRules;
            try {
                if (styleSheet.cssRules) {
                    cssRules = styleSheet.cssRules;
                } else {
                    cssRules = styleSheet.rules;
                }
            } catch(e) {
                console.log('security error getting css rules');
            }
            if (cssRules != undefined) {
                for (var jj=0; jj<cssRules.length; jj++) {
                    var cssRule = cssRules[jj];
                    if (cssRule.selectorText.toLowerCase() == name.toLowerCase()) {
                        return cssRule;
                    }
                }
            }
        }
    }
    return null;
}*/

function getCSSRule(ruleName, deleteFlag) {                     // Return requested style obejct
	ruleName=ruleName.toLowerCase();                            // Convert test string to lower case.
	if (document.styleSheets) {                                 // If browser can play with stylesheets
		for (var i=0; i<document.styleSheets.length; i++) {     // For each stylesheet
			var styleSheet=document.styleSheets[i];             // Get the current Stylesheet
			var ii=0;                                           // Initialize subCounter.
			var cssRule=false;                                  // Initialize cssRule.
			do {                                                // For each rule in stylesheet
				if (styleSheet.cssRules) {                      // Browser uses cssRules?
					cssRule = styleSheet.cssRules[ii];          // Yes --Mozilla Style
				} else {                                        // Browser usses rules?
					cssRule = styleSheet.rules[ii];             // Yes IE style.
				}                                               // End IE check.
				if (cssRule)  {                                 // If we found a rule...
//alert('one');
//alert(cssRule.selectorText);
					if (cssRule.selectorText != undefined) {
//alert (cssRule.selectorText.toLowerCase() + "     " + ruleName);
					if (cssRule.selectorText.toLowerCase()==ruleName) { //  match ruleName?
//alert('two');
						if (deleteFlag=='delete') {             // Yes.  Are we deleteing?
							if (styleSheet.cssRules) {          // Yes, deleting...
								styleSheet.deleteRule(ii);      // Delete rule, Moz Style
							} else {                            // Still deleting.
								styleSheet.removeRule(ii);      // Delete rule IE style.
							}                                   // End IE check.
							return true;                        // return true, class deleted.
						} else {                                // found and not deleting.
							return cssRule;                     // return the style object.
						}                                       // End delete Check
					}                                           // End found rule name
					}
				}                                               // end found cssRule
				ii++;                                           // Increment sub-counter
			} while (cssRule)                                   // end While loop
		}                                                       // end For loop
	}                                                           // end styleSheet ability check
	return false;                                               // we found NOTHING!
}                                                               // end getCSSRule

function killCSSRule(ruleName) {                          // Delete a CSS rule
	return getCSSRule(ruleName,'delete');                  // just call getCSSRule w/delete flag.
}                                                         // end killCSSRule

function addCSSRule(ruleName) {                           // Create a new css rule
	if (document.styleSheets) {                            // Can browser do styleSheets?
		if (!getCSSRule(ruleName)) {                        // if rule doesn't exist...
			if (document.styleSheets[0].addRule) {           // Browser is IE?
				document.styleSheets[0].addRule(ruleName, null,0);      // Yes, add IE style
			} else {                                         // Browser is IE?
			document.styleSheets[0].insertRule(ruleName+' { }', 0); // Yes, add Moz style.
			}                                                // End browser check
		}                                                   // End already exist check.
	}                                                      // End browser ability check.
	return getCSSRule(ruleName);                           // return rule we just created.
}

/*
Scheme  								Description
------									-----------
document.getElementById 				Detects modern browsers in general, which covers IE5+, Firefox1+, and Opera7+
window.getComputedStyle 				Detects Firefox1+ and Opera 8+
Array.every 							Detects Firefox1.5+ (method detection)
window.Iterator 						Detects Firefox2+ and Netscape 9
document.all 							Detects IE4+
window.attachEvent 						Detects IE5+
window.createPopup 						Detects IE5.5+
document.compatMode && document.all 	Detects IE6+
window.XMLHttpRequest 					Detects IE7, Firefox1+, and Opera8+
window.XMLHttpRequest && document.all 	Detects IE7. Note: Will fail if visitor explicitly disables native xmlHTTPRequest support (under Toolbar-> Internet Options-> Advanced)
document.documentElement && typeof document.documentElement.style.maxHeight!="undefined" 	Another way of detecting IE7 that is more reliable than the above.
window.opera 							Detects Opera (any version)
document.getElementsByClassName			Detects Firefox 3

var isIE = document.all;
var isIE8 = window.XDomainRequest;
var isIE7 = isIE && window.XMLHttpRequest && window.ActiveXObject;
var isIE6 = isIE && document.implementation;
var isgteIE6 = isIE7 isIE6;
var isIE5 = isIE && window.print && !isgteIE6;
var isIEDOM2 = isIE5 isgteIE6;
var isIE4 = isIE && !isIEDOM2 && navigator.cookieEnabled;
var isIE3 = isIE && !isIE4 && !isIEDOM2;
var isNS = navigator.mimeTypes && !isIE;
var isNS3 = isNS && !navigator.language;
var isNS4 = document.layers;
var isNS6 = document.getElementById && !isIE;
var isNS7 = isNS6;
var isNS71 = document.designMode;
var isNSDOM2 = isNS6;
var isDOM2 = isIEDOM2 isNSDOM2;

function detectBrowser() { 
    var BO = new Object(); 
    BO["ie"]        = document.all || true; 
    BO["ie4"]       = BO["ie"] && (document.getElementById == null); 
    BO["ie5"]       = BO["ie"] && (document.namespaces == null) && (!BO["ie4"]); 
    BO["ie6"]       = BO["ie"] && (document.implementation != null) && (document.implementation.hasFeature != null); 
    BO["ie55"]      = BO["ie"] && (document.namespaces != null) && (!BO["ie6"]); 
	BO["ie7"]		= (BO["ie"] && document.implementation != null && document.compatMode != null && window.XMLHttpRequest != null);
    BO["ns4"]       = !BO["ie"] &&  (document.layers != null) &&  (window.confirm != null) && (document.createElement == null); 
    BO["opera"]     = (self.opera != null); 
    BO["gecko"]     = (document.getBoxObjectFor != null); 
    BO["khtml"]     = (navigator.vendor == "KDE"); 
    BO["konq"]      = ((navigator.vendor == 'KDE') || (document.childNodes) && (!document.all) && (!navigator.taintEnabled)); 
    BO["safari"]    = (document.childNodes) && (!document.all) && (!navigator.taintEnabled) && (!navigator.accentColorName); 
    BO["safari1.2"] = (parseInt(0).toFixed == null) && (BO["safari"] && (window.XMLHttpRequest != null)); 
    BO["safari2.0"] = (parseInt(0).toFixed != null) && BO["safari"] && !BO["safari1.2"]; 
    BO["safari1.1"] = BO["safari"] && !BO["safari1.2"] && !BO["safari2.0"]; 
    return BO; 
} 
 
var BO = new detectBrowser(); 
*/

//URLfilename = (document.location.href).((document.location.href).substring((document.location.href).lastIndexOf('/')+1)).substring((document.location.href).IndexOf('?'));	// just the filename of the URL
URLfilename = (document.location.href).substring((document.location.href).lastIndexOf('/')+1);	// just the filename of the URL
if (document.all && document.documentElement && typeof document.documentElement.style.maxHeight!="undefined") { // Detects IE7+
	if (window.XDomainRequest) {									// IE 8
		var languages = getCSSRule('div.languages');				// IE 8 - The localhost is different from the Internet!
		if (navigator.appVersion.indexOf('Windows NT 6.0') != -1) {
			languages.style.top = '89px';
		}
		else {								// Windows NT 6.1
			languages.style.top = '89px';
		}
		var counter_Scripture = getCSSRule('div.counter_Scripture');
		counter_Scripture.style.margin = '9px 17px 17px 10px';
		var languageChoiceSelected = getCSSRule('.languageChoiceSelected');
		languageChoiceSelected.style.height = "1.4em";
	}
	else {
//alert('1 ' + URLfilename);
		var languages = getCSSRule('div.languages');				// IE 7 - The localhost is different from the Internet!
		languages.style.top = '68px';
		var counter_Scripture = getCSSRule('div.counter_Scripture');
		counter_Scripture.style.margin = '9px 17px 17px 10px';
	}
}
else {
	if (document.all && document.implementation && document.implementation.hasFeature) {	// Detects IE6
		var languages = getCSSRule('div.languages');
		languages.style.top = '68px';
		var counter_Scripture = getCSSRule('div.counter_Scripture');
		counter_Scripture.style.margin = '8px 9px 18px 0px';
	}
	else {
		if ((document.childNodes) && (!document.all) && (!navigator.taintEnabled) && (!navigator.accentColorName)) {	// Detects Safari
				var languages = getCSSRule('div.languages');
				languages.style.top = '87px';
				var counter_Scripture = getCSSRule('div.counter_Scripture');
				counter_Scripture.style.margin = '9px 15px 16px 10px';
		}
		else {
			if (navigator.userAgent.toLowerCase().indexOf('chrome') > -1) {															// Detects Chrome
			}
			else {
				if (self.opera) {															// Detects Opera
						var languages = getCSSRule('div.languages');
						languages.style.top = '75px';
						var counter_Scripture = getCSSRule('div.counter_Scripture');
						counter_Scripture.style.margin = '9px 15px 18px 10px';
						var google = getCSSRule('#google');
						google.style.marginTop = "18px";
						var languageChoiceSelected = getCSSRule('.languageChoiceSelected');
						languageChoiceSelected.style.height = "1.4em";
				}
				else {
					if (document.getElementsByClassName) {									// Detects Firefox 3
						var languages = getCSSRule('div.languages');						// The localhost is different from the Internet!
						languages.style.top = '88px';
						var counter_Scripture = getCSSRule('div.counter_Scripture');
						counter_Scripture.style.margin = '9px 15px 16px 10px';
					}
					else {
						if (window.Iterator) {												// Detects Netscape 9 (which is based on Firefox 2)
							var languages = getCSSRule('div.languages');
							languages.style.top = '91px';
							var counter_Scripture = getCSSRule('div.counter_Scripture');
							counter_Scripture.style.margin = '-9px 15px 16px 10px';
							//var FCBH = getCSSRule('div.FCBH');
							//FCBH.style.paddingTop = "-150px";
							var languageChoiceSelected = getCSSRule('.languageChoiceSelected');
							languageChoiceSelected.style.height = "1.3em";
						}
					}
				}
			}
		}
	}
}
