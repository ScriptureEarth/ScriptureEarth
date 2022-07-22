	<?php
// http://localhost/listen.php?LN=Chinantec,%20Comaltepec&book=John&chapter=1&chapterFilename=cco-44-JHN-01.mp3&ISO=cco
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
	//divide the URL in half at the '?'
	var urlHalves = String(document.location).split('?');
	var urlVarValue = '';
	if (urlHalves[1]){
		//load all the name/value pairs into an array
		var urlVars = urlHalves[1].split('&');
		//loop over the list, and find the specified url variable
		for(i=0; i<=(urlVars.length); i++){
			if (urlVars[i]){
				//load the name/value pair into an array
				var urlVarPair = urlVars[i].split('=');
				if (urlVarPair[0] && urlVarPair[0] == urlVarName) {
					//I found a variable that matches, load it's value into the return variable
					urlVarValue = urlVarPair[1];
				}
			}
		}
	}
	return urlVarValue;   
}

// http://localhost/listen.php?LN=Chinantec,%20Comaltepec&book=John&chapter=1&chapterFilename=cco-44-JHN-01.mp3&ISO=cco
var chapterFilename = getURLVar("chapterFilename");			// path and filename
var ISO = getURLVar("ISO");
var chapter = getURLVar("chapter");
var listenFilename = "data/"+ISO+"/audio/"+chapterFilename;
var Plugin = getURLVar("Plugin");
var agt=navigator.userAgent.toLowerCase();
//function setEmbed(ID, dir) {
//    var element = document.getElementById(ID);
function setEmbed(dir) {
    var element = document.getElementById('chapter');
    //element.innerHTML = '<embed src="'+dir+ID+'.m3u" autostart="0" loop="0" height="45" width="170" type="'+getMimeType()+'"></embed>';
	element.innerHTML = '<embed src="'+dir+'" autoplay="true" autostart="1" loop="0" height="63" width="280" type="'+getMimeType()+'"></embed>';
}
function getMimeType() {
	//var mimeType = "application/x-mplayer2";							// default (IE)
	if (mimeIsReady("application/x-mplayer2")) return "application/x-mplayer2";
	// http://port25.technet.com/videos/downloads/wmpfirefoxplugin.exe
	if (mimeIsReady("application/x-mpeg")) return "application/x-mpeg";
	if (mimeIsReady("audio/x-mpeg")) return "audio/x-mpeg";
	if (mimeIsReady("audio/mpeg")) return "audio/mpeg";
	if (navigator.userAgent.toLowerCase().indexOf("windows")) {
		if (window.getComputedStyle) {										// FF & Opera
			answer = confirm("Do you want to download the Firefox plugin to enable the audio?");
			if (answer) {
				window.location.assign("http://port25.technet.com/videos/downloads/wmpfirefoxplugin.exe");
				alert("You need to close your browser and then re-start it AFTER the file has been downloaded and ran...");
				return "application/x-mplayer2";
			}
		}
	}
	return "audio/mpeg";
	//alert("Audio player not found.");
	//return '';

/*	if (window.getComputedStyle) {										// FF & Opera
		return "audio/mpeg";
	}
	if (navigator.mimeTypes && navigator.userAgent.toLowerCase().indexOf("windows") == -1) {
		var plugin=navigator.mimeTypes["audio/mpeg"].enabledPlugin;		// non-IE, no-Windows
		if (plugin)
			mimeType = "audio/mpeg";									// Mac/Safari & Linux/FFox
	}
	return mimeType;*/
}

function mimeIsReady(mimeType) {
	for (var i = 0; i < navigator.mimeTypes.length; i++) {
		//document.write(navigator.mimeTypes[i].type+'<br />');
		if (navigator.mimeTypes[i].type == mimeType) {
			if (navigator.mimeTypes[i].enabledPlugin != null) {
				//document.write("true");
				return true;
			}
		}
	}
	//document.write("false");
	return false;
}

</script>
</head>
<!--body style="background-color: #993300; color: white; padding: 0; margin: 0; " onload="setEmbed('chapter', '<php echo $chapterFilename ?>')"-->
<body style="background-color: #993300; color: white; padding: 0; margin: 0; ">
		<br /><br />
		<img src='images/ScriptureEarth.jpg' width='400' height='112' />
		<br /><br />

	<?php
		//$filename = $chapterFilename;
		
		if (file_exists($listenFilename)) {
			/*echo "The file $filename exists.";*/
			echo "<div style='text-align: center; font-size: 16pt; '>$LN</div>";
	?>
			<br />
			<div style='text-align: center; font-size: 14pt; font-weight: bold; '><?php echo $book ?> <?php echo $chapter ?></div><br />
			<div ID='chapter' style="background-color: #993300; position: absolute; bottom: 20px; left: 60px; ">
<script type="text/javascript">
	if (Plugin == "0") {
		// browser default
		//document.write("&nbsp;<a style='font-size: 11pt; ' href='"+listenFilename+"' target='_blank'>"+chapter+"</a>&nbsp;");	// this the only line that is different from below!
		//document.write('<div id="BrowserDefault"></div>');
		//document.getElementById("BrowserDefault").innerHTML =
		window.location.assign(listenFilename);
	}
	else if (Plugin == "1") {
		setEmbed(listenFilename);
	}
	else if (Plugin == "2") {
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
	else {
		document.write('<object id="player1" width="280" height="18"');
			document.write('classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"');
			document.write('codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab"');
			document.write('standby="Loading Adobe Flash Player..." type="application/x-shockwave-flash">');
			document.write('<param name="movie" value="player.swf" />');
			document.write('<param name="allowfullscreen" value="false" />');
			document.write('<param name="allowscriptaccess" value="always" />');
			//<!--param name="flashvars" value="file=video.flv&image=preview.jpg" /-->
			document.write('<param name="flashvars" value="file='+listenFilename+'&autostart=true&volume=50" />');
			document.write('<object type="application/x-shockwave-flash" data="player.swf" width="280" height="18">');
				document.write('<param name="movie" value="player.swf" />');
				document.write('<param name="allowfullscreen" value="false" />');
				document.write('<param name="allowscriptaccess" value="always" />');
				//<!--param name="flashvars" value="file=video.flv&image=preview.jpg" /-->
				document.write('<param name="flashvars" value="file='+listenFilename+'&autostart=true&volume=50" />');
				document.write('<embed src="player.swf" bgcolor="#ffffff"');
				document.write('width="280" height="18" name="player1" align="middle"');
				document.write('allowScriptAccess="always" type="application/x-shockwave-flash"');
				document.write('pluginspage="http://get.adobe.com/flashplayer" />');
				document.write('<p><a href="http://get.adobe.com/flashplayer">Get Flash</a> to download this player.</p>');
			document.write('</object>');
		document.write('</object>');
	}
</script>				<!--<object data='<php $l ?><php echo $l ?>' type='audio/mpeg' width='280' height='27'>
				  <param name='src' value='<php echo $l ?>' />
				  <param name='autoplay' value='true' />
				  <param name='autoStart' value='1' />
				  <embed src="<php $l ?><php echo $l ?>" controller="true" autoplay="true" autostart="true" type="audio/mpeg" />
				</object>-->
	
				<!--object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" codebase="http://www.apple.com/qtactivex/qtplugin.cab" width="280" height="16">
					<param name="pluginspage" value="http://www.apple.com/quicktime/download"/ >
					<param name="src" value="<php echo $filename ?>" />
					<param name="controller" value="true" />
					<param name="autoplay" value="true" />
					<param name="autostart" value="1" /-->
					<!--[if !IE]> <-->
					<!--object type="audio/mpeg" data="<php $filename ?><php echo $filename ?>" width="280" height="16">
						<param name="src" value="<php echo $filename ?>" />
						<param name="controller" value="true" />
						<param name="autoplay" value="true" />
						<param name="autostart" value="1" />
						<param name="pluginurl" value="http://www.apple.com/quicktime/download/" />
						<embed src="<php $filename ?><php echo $filename ?>" autostart="1" autoplay="true" loop="false" width="280" height="16" type="audio/mpeg" controller="true" />
					</object-->
					<!--> <![endif]-->
				<!--/object-->
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
