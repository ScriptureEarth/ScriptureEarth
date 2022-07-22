<?php
	$LN = $_GET["LN"];
	$book =  $_GET["book"];
	$chapter = $_GET["chapter"];
	$chapterFilename = trim($_GET["chapterFilename"]);			// path and filename
	//$chapterFilename = str_replace("%2D","-",  $chapterFilename);
	//$simpleChapterFilename = substr($chapterFilename, strrpos($chapterFilename, "/")); 		// filename with '/' in front
	//echo "<br /><br />".$simpleChapterFilename;
	//$ID = substr($simpleChapterFilename, 0, strrpos($simpleChapterFilename, "."));	// ID
	//echo "<br /><br />".$ID;
	$ISO = $_GET["ISO"];
	$listenFilename = "data/".$ISO."/audio/".$chapterFilename;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Play chapter audio</title>
<script language="JavaScript" type="text/javascript">
function getURLVar(urlVarName) {
	// divide the URL in half at the '?'
	var urlHalves = String(document.location).split('?');
	var urlVarValue = '';
	if (urlHalves[1]){
		// load all the name/value pairs into an array
		var urlVars = urlHalves[1].split('&');
		// loop over the list, and find the specified url variable
		for(i=0; i<=(urlVars.length); i++){
			if (urlVars[i]){
				// load the name/value pair into an array
				var urlVarPair = urlVars[i].split('=');
				if (urlVarPair[0] && urlVarPair[0] == urlVarName) {
					// I found a variable that matches, load it's value into the return variable
					urlVarValue = urlVarPair[1];
				}
			}
		}
	}
	return urlVarValue;   
}

var chapterFilename = getURLVar("chapterFilename");			// path and filename
var ISO = getURLVar("ISO");
var chapter = getURLVar("chapter");
var listenFilename = "data/"+ISO+"/audio/"+chapterFilename;
var Plugin = getURLVar("Plugin");

function detectFlash() {
	if (navigator.mimeTypes.length > 0) { return navigator.mimeTypes['application/x-shockwave-flash'].enabledPlugin != null; }
	if (!window.ActiveXObject) return false;			// IE 5.5 and up
	try { if (new ActiveXObject('ShockwaveFlash.ShockwaveFlash')) return true; }
	catch (oError) { return false; }
}

function detectQuickTime() {
	if (navigator.mimeTypes.length > 0) { return navigator.mimeTypes['audio/mpeg'].enabledPlugin != null; }
	if (!window.ActiveXObject) return false;			// IE 5.5 and up
	try { if (new ActiveXObject('QuickTime.QuickTime')) return true; }
	catch (e) {}
	try { if (new ActiveXObject('QuickTimeCheckObject.QuickTimeCheck')) return true; }
	catch (e) {};
	return false;
}

</script>
</head>
<body style="background-color: #993300; color: white; padding: 0; margin: 0; ">
		<br /><br />
		<img src='images/ScriptureEarth.jpg' width='400' height='112' />
		<br /><br />
<?php
	if (file_exists($listenFilename)) {
		echo "<div style='text-align: center; font-size: 16pt; '>$LN</div>";
?>
		<br />
		<div style='text-align: center; font-size: 14pt; font-weight: bold; '><?php echo $book ?> <?php echo $chapter ?></div><br />
		<div ID='chapter' style="background-color: #993300; position: absolute; bottom: 20px; left: 40px; ">
		<script type="text/javascript">
			/*if (detectQuickTime() == true) {
                document.write('<object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" codebase="http://www.apple.com/qtactivex/qtplugin.cab" width="280" height="16">');
                    document.write('<param name="pluginspage" value="http://www.apple.com/quicktime/download"/ >');
                    document.write('<param name="src" value="'+listenFilename+'" />');
                    document.write('<param name="controller" value="true" />');
                    document.write('<param name="autoplay" value="true" />');
                    document.write('<param name="autostart" value="1" />');
                    document.write('<!--[if !IE]> <-->');
                    document.write('<object type="audio/mpeg" data="'+listenFilename+'" width="280" height="16">');
                        document.write('<param name="src" value="'+listenFilename+'" />');
                        document.write('<param name="controller" value="true" />');
                        document.write('<param name="autoplay" value="true" />');
                        document.write('<param name="autostart" value="1" />');
                        document.write('<param name="pluginurl" value="http://www.apple.com/quicktime/download/" />');
                        document.write('<embed src="'+listenFilename+'" autostart="1" autoplay="true" loop="false" width="280" height="16" type="audio/mpeg" controller="true" />');
                    document.write('</object>');
                    document.write('<!--> <![endif]-->');
                document.write('</object>');
            }
            else {*/
                /*document.write('<object id="player1" width="280" height="18"');
                    document.write('classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"');
                    document.write('codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab"');
                    document.write('standby="Loading Adobe Flash Player..." type="application/x-shockwave-flash">');
                    document.write('<param name="movie" value="player.swf" />');
                    document.write('<param name="allowfullscreen" value="false" />');
                    document.write('<param name="allowscriptaccess" value="always" />');
                    document.write('<param name="flashvars" value="file='+listenFilename+'&autostart=true&volume=50" />');*/
                   /* document.write('<object type="application/x-shockwave-flash" data="player.swf" width="280" height="18">');
                        document.write('<param name="movie" value="player.swf" />');
                        document.write('<param name="allowfullscreen" value="false" />');
                        document.write('<param name="allowscriptaccess" value="always" />');
                        document.write('<param name="flashvars" value="file='+listenFilename+'&autostart=true&volume=50" />');
                        */
						document.write('<embed src="player.swf" bgcolor="#ffffff"');
                        document.write('width="320" height="18" name="player1" align="middle" flashvars="file='+listenFilename+'&autostart=true&volume=50"');
                        document.write('allowScriptAccess="always" type="application/x-shockwave-flash"');
                        document.write('pluginspage="http://get.adobe.com/flashplayer"></embed>');
                        //document.write('<p><a href="http://get.adobe.com/flashplayer">Get Flash</a> to download this player.</p>');
                    //document.write('</object>');
		/*echo "<embed src='http://stream.faithcomesbyhearing.com/widget.swf'
			quality='high'
			pluginspage='http://www.adobe.com/go/getflashplayer' play='true'
			loop='true' scale='showall' wmode='window' devicefont='false'
			bgcolor='#ffffff' name='widget' menu='true' allowfullscreen='false'
			allowscriptaccess='always'
			flashvars='sku=$TP&display_language=eng&display_artwork=true'
			salign='' type='application/x-shockwave-flash'
			width='500' align='right' height='126' style='margin-top: 15px; margin-bottom: 15px; margin-right: 15px; '>
			</embed>";*/
                //document.write('</object>');
            //}
        </script>
		</div>
	<?php
	}
	else {
		echo "<div style='text-align: center; color: #CC6600; font-size: 9pt; font-family: Arial, Helvetica, sans-serif; '><br />The mp3 file ($filename)<br />does not exist.</div>";
	}
	?>
	<div style="padding: 2px; color: black; background-color: white; position: absolute; top: 10px; left: 10px; font-size: 8pt; font-family: Arial, Helvetica, sans-serif; ">Download: <a href="saveas.php?file=<?php echo str_replace('-', '%2D', $chapterFilename) ?>&ISO=<?php echo $ISO ?>"><?php echo $book ?> <?php echo $chapter ?></a></div>
	<div style="padding: 2px; color: black; background-color: white; position: absolute; top: 10px; right: 10px; font-size: 8pt; font-family: Arial, Helvetica, sans-serif; "><a href="JavaScript:window.close()">[Close]</a></div>

</body>
</html>
