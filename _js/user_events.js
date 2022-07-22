// JavaScript Document
// Scott Starker
// pure JavaScript code:


/*************************************************************************************************************************************
*
* 			CAREFUL when your making any additions! Any "onclick", "change", etc. that occurs on "input", "a", "div", etc.
* 			should be placed in "_js/user_events.js". Also, in "_js/user_events.js" any errors in previous statements will
* 			not works in any of the satesments then on. It can also help in the Firefox browser (version 79.0+) run
* 			"00-SpecificLanguage.inc.php", menu "Tools", "Web developement", and "Toggle Tools". Then menu "Debugger". In the left
* 			side of the windows click on "00-SpecificLanguage.inc.php", Localhost", "_js", and "user_events.js". Look down the js file
* 			and find out if there are errors using the "underline" indicator and fix them if there are any. You can also
* 			use "00-SpecificLanguage.inc.php" just to make sure that the document.getElementById('...') name is corrent.
*			But, BE CAREFUL!
*
**************************************************************************************************************************************/


if (document.getElementById('OT_SAB_Book') != null) {
	document.getElementById('OT_SAB_Book').addEventListener( 'change', function() { SAB_OT(); } );
	document.getElementById('OT_SABRL_b').addEventListener( 'click', function() { SAB_OT(); } );
	document.getElementById('OT_SABRL_a').addEventListener( 'click', function() { SAB_OT(); } );
}

if (document.getElementById('NT_SAB_Book') != null) {
	document.getElementById('NT_SAB_Book').addEventListener( 'change', function() { SAB_NT(); } );
	document.getElementById('NT_SABRL_b').addEventListener( 'click', function() { SAB_NT(); } );
	document.getElementById('NT_SABRL_a').addEventListener( 'click', function() { SAB_NT(); } );
}

