// JavaScript Document Header Icon Browser Fixes

/*
	Inspite of all the css options there are still problems with html.
	1) IE7 and FF 3 have the problem with img.emptyHeaderIcon { height: 35px; }.
		IE 7 - img.emptyHeaderIcon { margin-bottom: 0px; }
		FF 3 - img.emptyHeaderIcon { margin-bottom: 3px; }
*/

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
					if (cssRule.selectorText.toLowerCase()==ruleName) { //  match ruleName?
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
window.Iterator 						Detects Firefox2+
document.all 							Detects IE4+
window.attachEvent 						Detects IE5+
window.createPopup 						Detects IE5.5+
document.compatMode && document.all 	Detects IE6+
window.XMLHttpRequest 					Detects IE7, Firefox1+, and Opera8+
window.XMLHttpRequest && document.all 	Detects IE7. Note: Will fail if visitor explicitly disables native xmlHTTPRequest support (under Toolbar-> Internet Options-> Advanced)
document.documentElement && typeof document.documentElement.style.maxHeight!="undefined" 	Another way of detecting IE7 that is more reliable than the above.
window.opera 							Detects Opera (any version)

var isIE = document.all;
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
	BO[”ie7"]		= (BO[”ie”] && document.implementation != null && document.compatMode != null && window.XMLHttpRequest != null);
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

if (document.all && document.documentElement && typeof document.documentElement.style.maxHeight!="undefined") { // Detects IE7
	var emptyHeaderIcon = getCSSRule('img.emptyHeaderIcon');
	emptyHeaderIcon.style.marginBottom = '0px';
}
else {
	if (window.Iterator) {	// Detects FF 2+
		var emptyHeaderIcon = getCSSRule('img.emptyHeaderIcon');
		emptyHeaderIcon.style.marginBottom = '3px';
	}
	else {
		if (document.all && document.implementation && document.implementation.hasFeature) { // Detects IE6
			var emptyHeaderIcon = getCSSRule('img.emptyHeaderIcon');
			emptyHeaderIcon.style.marginBottom = '0px';
		}
		else {
			if (window.getComputedStyle && self.opera) { // Detects Opera
				var emptyHeaderIcon = getCSSRule('img.emptyHeaderIcon');
				emptyHeaderIcon.style.marginBottom = '3px';
				var HeaderPicture = getCSSRule('img.HeaderPicture');
				HeaderPicture.style.marginBottom = '3px';
			}
			else {
				if (document.childNodes && !document.all && !navigator.taintEnabled && !navigator.accentColorName) { // Dectects Safari
					var emptyHeaderIcon = getCSSRule('img.emptyHeaderIcon');
					emptyHeaderIcon.style.marginBottom = '3px';
				}
			}
		}
	}
}