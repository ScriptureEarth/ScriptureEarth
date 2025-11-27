<?php
/*
    Scripture Examine
    created by Scott Starker
    updated by Scott Starker - 10/24/2025
*/
include './include/session.php';
global $session;
/* Login attempt */
$retval = $session->checklogin();
if (!$retval) {
	echo "<br /><div style='text-align: center; font-size: 16pt; font-weight: bold; padding: 10px; color: navy; background-color: #dddddd; '>You are not logged in!</div>";
	/* Link back to the main page */
	header('Location: login.php');
	exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type"				content="text/html; charset=utf-8" />
<meta http-equiv="Content-Script-Type"		content="text/javascript" />
<meta name="ObjectType" 					content="Document" />
<meta http-equiv="Window-target" 			content="_top" />
<meta name="Created-by" 					content="Scott Starker" />
<title>Scripture Examine</title>
<link type="text/css" rel="stylesheet" href="_css/Scripture_Examine.css" />
<!--script type="text/javascript" language="javascript" src="_js/jquery-1.10.1.min.js"></script-->

<script type="text/javascript" language="javascript">
    function Reject(idx, typeElement) {
        const xmlRejecthttp = new XMLHttpRequest();
        let url = "add_Reject_Wait.php";
        url = url + "?idx=" + idx;
        url = url + "&type=" + typeElement;
        url = url + "&reject=Reject";
        url = url + "&sid=" + Math.random();
        xmlRejecthttp.open("GET", url);
        // Defining event listener for readystatechange event
        xmlRejecthttp.onreadystatechange = function() {
            // Check if the request is compete and was successful
            if (this.readyState === 4 && this.status === 200) {
                // Inserting the response from server into an HTML element
                // this.responseText has return in add_Reject_Wait.php
                document.getElementById("result").innerHTML = this.responseText;
                document.getElementById("buttons").style.display = 'none';
                document.getElementById("cancel").value = 'Ok';
            }
        }
        // Sending the request to the server
        xmlRejecthttp.send();   
    }

    function Wait(idx, typeElement) {
        const xmlWaithttp = new XMLHttpRequest();
        var url = "add_Reject_Wait.php";
        url = url + "?idx=" + idx;
        url = url + "&type=" + typeElement;
        url = url + "&wait=Wait";
        url = url + "&sid=" + Math.random();
        xmlWaithttp.open("GET", url);
        // Defining event listener for readystatechange event
        xmlWaithttp.onreadystatechange = function() {
            // Check if the request is compete and was successful
            if (this.readyState === 4 && this.status === 200) {
                // Inserting the response from server into an HTML element
                // this.responseText has return in add_Reject_Wait.php
                document.getElementById("result").innerHTML = this.responseText;
                document.getElementById("buttons").style.display = 'none';
                document.getElementById("cancel").value = 'Ok';
            }
        }
        // Sending the request to the server
        xmlWaithttp.send();
    }

    function Cancel() {
        //window.open('Scripture_Examine.php', '_self');
        window.location.href = 'Scripture_Examine.php';
    }

    message = 0;
    text = '';
</script>

</head>
<body>
<?php
include './include/conn.inc.php';
$db = get_my_db();

echo "<div class='content' style='background-color: white; padding: 20px; width: 1020px; height: 100px; margin-left: auto; margin-right: auto; vertical-align: middle; border-radius: 15px; -moz-border-radius: 15px; -webkit-box-shadow: 15px; '>";
echo "<img style='margin-left: 40px; ' src='images/guyReading.png' /><div style='text-align: center; margin-top: -60px; margin-left: 180px; font-size: 18pt; font-weight: bold; color: black; '>Examine the Scriptoria Records</div>";
echo "</div><br />";
echo "<div style='background-color: white; padding: 20px; width: 1020px; margin-left: auto; margin-right: auto; border-radius: 15px; -moz-border-radius: 15px; -webkit-box-shadow: 15px; '>";
echo "<a style='float: right; font-size: small; font-weight: normal; vertical-align: bottom; margin: 10px 10px 0px 0px; ' href='process.php'>[Logout]</a>";
echo "<a style='float: right; font-size: small; font-weight: normal; vertical-align: bottom; margin: 10px 10px 0px 0px; ' href='Scripture_Edit.php'>[Scripture Edit]</a>";

// Checks that the form was submitted after Scripture_Examine.php submitted.
/*************************************************************************************
 * 
 *          is 'accept' button clicked
 * 
 *************************************************************************************/
if (isset($_POST['accept'])) {                      // the "Submit" button
    if (!isset($_POST['iso']) || !isset($_POST['rod']) || !isset($_POST['var']) || !isset($_POST['idx']) || !isset($_POST['type']) || !isset($_POST['email']) || !isset($_POST['projectName']) || !isset($_POST['url']) || !isset($_POST['projectDescription']) || !isset($_POST['subfolder'])) {
        /*if (!isset($_POST['add_index'])) echo 'index is not POSTed.<br />';
        if (!isset($_POST['iso'])) echo 'iso is not POSTed.<br />';
        if (!isset($_POST['rod'])) echo 'rod is not POSTed.<br />';
        if (!isset($_POST['var'])) echo 'var is not POSTed.<br />';
        if (!isset($_POST['idx'])) echo 'idx is not POSTed.<br />';
        if (!isset($_POST['type'])) echo 'type is not POSTed.<br />';
        if (!isset($_POST['email'])) echo 'email is not POSTed.<br />';
        if (!isset($_POST['projectName'])) echo 'project name is not POSTed.<br />';
        if (!isset($_POST['url'])) echo 'url is not POSTed.<br />';
        if (!isset($_POST['projectDescription'])) echo 'project desciption is not POSTed.<br />';
        if (!isset($_POST['subfolder'])) echo 'subfolder is not POSTed.<br />';*/
        die('Did you make a mistake?');
    }
    $add_index = (int)$_POST['add_index'];              // add_index from add_resource table
    $iso = $_POST['iso'];								// iso
    $rod = $_POST['rod'];							    // rod
    $var = $_POST['var'];						        // var
    $idx = (int)$_POST['idx'];						    // index
    $type = $_POST['type'];                             // sab_html, apk, ios, or google_play: 'sab', 'Android App', 'iOS Asset Package', or 'Google Play Store'
    $email = $_POST['email'];
    $projectName = $_POST['projectName'];
    $projectDescription = '';
    if (isset($_POST['projectDescription'])) {
        $projectDescription = $_POST['projectDescription'];
        $projectDescription = substr($projectDescription, 0, strpos($projectDescription, ';') - 1);
    }
    $url = $_POST['url'];
    $username = $_POST['username'];
    $organization = $_POST['organization'];
    $subfolder = $_POST['subfolder'];

    //$db->query("INSERT INTO add_resource (`iso`, `rod`, `var`, `idx`, `type`, `url`, `projectName`, `projectDescription`, `username`, `organization`, `subfolder`, `email`) VALUES ('$iso', '$rod', '$var', $idx, '$type', '$url', '$projectName', '$projectDescription', '$username', '$organization', '$sab/ZZZZZZ/', '$email')");

    //      "sab_html" (SAB_Scirptoria table:  ISO	ROD_Code	Variant_Code	ISO_ROD_index	subfolder = subfolder	description = projectDescription	pre_scriptoria),
    //      "apk" (CellPhone table: ISO	ROD_Code	Variant_Code	ISO_ROD_index	Cell_Phone_Title = 'Android App'	Cell_Phone_File = url),
    //      "ios" (CellPhone table: ISO	ROD_Code	Variant_Code	ISO_ROD_index	Cell_Phone_Title = 'iOS Asset Package'	Cell_Phone_File = url),
    //      "google_play" (links table:  ISO	ROD_Code	Variant_Code	ISO_ROD_index	company = 'Google Play Store'   company_title =  projectDescription URL = url	buy	map	BibleIs	YouVersion	Bibles_org	GooglePlay = 1	GRN)

    /**********************************************************************************
    ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
            SAB HTML
    ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    **********************************************************************************/
    if ($type == 'sab_html') {
        /**********************************************************************************
        ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
                SAB HTML and no URL but subfolder
        ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
        **********************************************************************************/
        if ($subfolder != '' && (substr($url, 0, 5) == 'data/' || $url == '')) {                         // SAB HTML
            $query = "SELECT * FROM SAB_scriptoria WHERE ISO_ROD_index = $idx";
            $result = $db->query($query) or die('Query failed: ' . $db->error);
            if ($result->num_rows == 0) {
                $name = preg_replace("/^\s?-\s?$iso\s?-\s?/", '', $projectName);         // remove the $iso- part at the beginning of the $projectName
                $name = ' - ' . $name;                                            // add ' - ' at the beginning of the $name
                $db->query("INSERT INTO SAB_scriptoria (ISO, ROD_Code, Variant_Code, ISO_ROD_index, `url`, subfolder, `description`, pre_scriptoria, SAB_number) VALUES ('$iso', '$rod', '$var', $idx, '', 'sab/$subfolder/', '$name', '', 1)");
                $db->query("UPDATE add_resource SET accept = 1, wait = 0, toAdd = 0, reject = 0 WHERE add_index = $add_index");
                $db->query("UPDATE scripture_main SET SAB = 1 WHERE ISO_ROD_index = $idx");
                $SAB_number = 1;
                include 'api/include/SAB_inc.php';                  // add html files to the SAB table
                ?>
                    <script>
                        window.location.href = 'Scripture_Examine.php';
                    </script>
                <?php
            }
            else {
                echo 'Two or more SAB (Read/Listen/View) are found!<br />Which one do you want to UPDATE with this new one?<br />';
                echo '<span style="color: darkgreen; font-weight: bold; ">This new one is:<br />';
                echo "&nbsp;&nbsp;&nbsp;&nbsp;username: <span style='color: darkblue' >$username</span>; projectName: <span style='color: darkblue' >$projectName</span>; Description: <span style='color: darkblue' >$projectDescription</span><br />";
                echo "&nbsp;&nbsp;&nbsp;&nbsp;email: <span style='color: darkblue' >$email</span>; organization: <span style='color: darkblue' >$organization</span><br />";
                echo "&nbsp;&nbsp;&nbsp;&nbsp;subfolder: <span style='color: darkblue' >$subfolder</span><br /></span>";
                $url = '';                                                                      // no URL
                $SABIndexArray = [];								                            // SAB_index
                //$SABurlArray = [];							                                    // URL
                $SABSubfolderArray = [];							                            // subfolder
                $SABDescriptionArray = [];						                                // description
                while ($row = $result->fetch_assoc()) {                                         // SAB_scriptoria table
                    $SABIndexArray[] = $row['SAB_index'];								        // SAB_index
                    //$SABurlArray[] = $row['url'];							                    // url
                    $SABSubfolderArray[] = substr($row['subfolder'], 4, -1);                    // subfolder without 'sab/' and trailing '/'
                    $SABDescriptionArray[] = $row['description'];						        // description
                }
                // UPDATE, INSERT, or Cancel
                echo "<div style='margin-top: 20px; '>";
                echo "Choose which SAB (Read/Listen/View) to UPDATE: &nbsp; <select id='SABSelect' name='SABSelect'>";
                $k=0;
                for ($k=0; $k < count($SABIndexArray); $k++) {
                    $num = $k + 1;
                    echo "<option value='$SABIndexArray[$k]'>$num => Description: $SABDescriptionArray[$k]; subfolder: $SABSubfolderArray[$k]</option>";
                }
                echo "</select><br /><br />&nbsp;&nbsp;&nbsp;";
                echo "<input type='button' name='accept' value='UPDATE' onclick='SABUPDATE(\"$projectName\", \"$projectDescription\", $idx, \"$subfolder\", document.getElementById(\"SABSelect\").value, $add_index, \"$iso\")' />&nbsp;&nbsp;&nbsp;";      // document.getElementById(\"SABSelect\").value) = $SABIndexArray[$k] of the selected SABIndexArray = SAB_index
                echo "<input type='button' name='result' value='INSERT as new SAB' onclick='SABINSERT(\"$projectName\", \"$projectDescription\", $idx, \"$iso\", \"$rod\", \"$var\", \"$subfolder\", $k, $add_index)' />&nbsp;&nbsp;&nbsp;";
                echo "<input id='cancel' type='button' value='Cancel' onclick='window.location.href = window.location.href' />";    // No changes made to CellPhone table WHILE $idx AND 'Android App'. So, return to Scripture_Examine.php.
                echo "</div>";
                ?>
                <script>
                    /****************************************************************************************************************
                        fetch - ExamineSubmit.php - UPDATE SAB
                    ****************************************************************************************************************/
                    async function SABUPDATE(projectName, projectDescription, idx, subfolder, SABIndex, add_index, iso) {
                        try {
                            const responseSAB = await fetch("ExamineSubmit.php?number=1a&name="+projectName+"&description="+projectDescription+"&idx="+idx+"&subfolder="+subfolder+"&SABIndex="+SABIndex+"&add_index="+add_index+"&iso="+iso);
                            const textSAB = await responseSAB.text();
                            if (textSAB == "none") {
                                console.log("1a. Did you make a mistake?");
                            }
                            else {
                                console.log("1a. SAB_scriptoria table already has index number <?php echo $idx ?>. UPDATEd anyway.");
                            }
                        }
                        catch (error) {
                            console.log(error);
                        }
                        window.location.href = 'Scripture_Examine.php';
                        //include 'api/include/SAB_inc.php';          // add html files to the SAB table
                    }
                    /****************************************************************************************************************
                        fetch - ExamineSubmit.php - INSERT SAB
                    ****************************************************************************************************************/
                    async function SABINSERT(projectName, projectDescription, idx, iso, rod, variant, subfolder, SAB_number, add_index) {
                        try {
                            const responseSAB = await fetch("ExamineSubmit.php?number=1b&name="+projectName+"&description="+projectDescription+"&idx="+idx+"&iso="+iso+"&rod="+rod+"&var="+variant+"&subfolder="+subfolder+"&SAB_number="+SAB_number+"&add_index="+add_index);
                            const textSAB = await responseSAB.text();
                            if (textSAB == "none") {
                                console.log("1b. Did you make a mistake?");
                            }
                            else {
                                console.log("1b. SAB_scriptoria table already has index number <?php echo $idx . '. (sab/' . $subfolder . '/)' ?>. INSERTed anyway.");
                            }
                        }
                        catch (error) {
                            console.log(error);
                        }
                        window.location.href = 'Scripture_Examine.php';
                        //include 'api/include/SAB_inc.php';          // add html files to the SAB table
                    }
                </script>
                <?php
            }
        }
        /**********************************************************************************
        ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
                SAB HTML and URL but no subfolder
        ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
        **********************************************************************************/
       else {                                          // SAB HTML links
            $query = "SELECT * FROM SAB_scriptoria WHERE ISO_ROD_index = $idx AND `url` LIKE '$url%'";
            $result = $db->query($query) or die('Query failed: ' . $db->error);
            if ($result->num_rows == 0) {
                $name = preg_replace("/^\s?-\s?$iso\s?-\s?/", '', $projectName);         // remove the $iso- part at the beginning of the $projectName
                $name = ' - ' . $name;                                                   // add ' - ' at the beginning of the $name
                $db->query("INSERT INTO SAB_scriptoria (ISO, ROD_Code, Variant_Code, ISO_ROD_index, `url`, subfolder, `description`, pre_scriptoria, SAB_number) VALUES ('$iso', '$rod', '$var', $idx, '$url', '', '$name', '', 1)");
                $db->query("UPDATE add_resource SET accept = 1, wait = 0, toAdd = 0, reject = 0 WHERE add_index = $add_index");
                $db->query("UPDATE scripture_main SET SAB = 1 WHERE ISO_ROD_index = $idx");
                ?>
                    <script>
                        window.location.href = 'Scripture_Examine.php';
                    </script>
                <?php
            }
            else {
            echo 'Two or more SAB (Read/Listen/View) are found!<br />Which one do you want to UPDATE with this new one?<br />';
            echo '<span style="color: darkgreen; font-weight: bold; ">This new one is:<br />';
            echo "&nbsp;&nbsp;&nbsp;&nbsp;username: <span style='color: darkblue' >$username</span>; projectName: <span style='color: darkblue' >$projectName</span>; Description: <span style='color: darkblue' >$projectDescription</span><br />";
            echo "&nbsp;&nbsp;&nbsp;&nbsp;email: <span style='color: darkblue' >$email</span>; organization: <span style='color: darkblue' >$organization</span><br />";
            echo "&nbsp;&nbsp;&nbsp;&nbsp;URL: <span style='color: darkblue' >$url</span><br /></span>";
            $SABIndexArray = [];								                            // SAB_index
            $SABurlArray = [];							                                    // URL
            $SABDescriptionArray = [];						                                // description
            while ($row = $result->fetch_assoc()) {                                         // SAB_scriptoria table
                $SABIndexArray[] = $row['SAB_index'];								        // SAB_index
                $SABurlArray[] = $row['url'];							                    // url
                $SABDescriptionArray[] = $row['description'];						        // description
            }
            // UPDATE, INSERT, or Cancel
            echo "<div style='margin-top: 20px; '>";
            echo "Choose which SAB (Read/Listen/View) to UPDATE:<br /> &nbsp; <select id='SABSelect' name='SABSelect'>";
            $k=0;
            for ($k=0; $k < count($SABIndexArray); $k++) {
                $num = $k + 1;
                echo "<option value='$SABIndexArray[$k]'>$num => Description: $SABDescriptionArray[$k]; URL: $SABurlArray[$k]</option>";
            }
            echo "</select><br /><br />&nbsp;&nbsp;&nbsp;";
            echo "<input type='button' name='accept' value='UPDATE' onclick='SABUPDATE2(\"$url\", \"$projectName\", \"$projectDescription\", $idx, document.getElementById(\"SABSelect\").value, $add_index)' />&nbsp;&nbsp;&nbsp;";
            echo "<input type='button' name='result' value='INSERT as new SAB' onclick='SABINSERT2(\"$url\", \"$projectName\", \"$projectDescription\", $idx, \"$iso\", \"$rod\", \"$var\", $k, $add_index)' />&nbsp;&nbsp;&nbsp;";
            echo "<input id='cancel' type='button' value='Cancel' onclick='window.location.href = window.location.href' />";    // No changes made to CellPhone table WHILE $idx AND 'Android App'. So, return to Scripture_Examine.php.
            echo "</div>";
            ?>
            <script>
                /****************************************************************************************************************
                    fetch - ExamineSubmit.php - UPDATE SAB with URL
                ****************************************************************************************************************/
                async function SABUPDATE2(url, projectName, projectDescription, idx, SABIndex, add_index) {
                    try {
                        const responseSAB = await fetch("ExamineSubmit.php?number=2a&url="+url+"&name="+projectName+"&description="+projectDescription+"&idx="+idx+"&SABIndex="+SABIndex+"&add_index="+add_index);
                        const textSAB = await responseSAB.text();
                        if (textSAB == "none") {
                            console.log("2a. Did you make a mistake?");
                        }
                        else {
                            console.log("2a. SAB_scriptoria table already has index number <?php echo $idx ?>. UPDATEd anyway.");
                        }
                    }
                    catch (error) {
                        console.log(error);
                    }
                    window.location.href = 'Scripture_Examine.php';
                }
                /****************************************************************************************************************
                    fetch - ExamineSubmit.php - INSERT SAB with URL
                ****************************************************************************************************************/
                async function SABINSERT2(url, projectName, projectDescription, idx, iso, rod, variant, SAB_number, add_index) {
                    try {
                        const responseSAB = await fetch("ExamineSubmit.php?number=2b&url="+url+"&name="+projectName+"&description="+projectDescription+"&idx="+idx+"&iso="+iso+"&rod="+rod+"&var="+variant+"&SAB_number="+SAB_number+"&add_index="+add_index);
                        const textSAB = await responseSAB.text();
                        if (textSAB == "none") {
                            console.log("2b. Did you make a mistake?");
                        }
                        else {
                            console.log("2b. SAB_scriptoria table already has index number <?php echo $idx ?>. INSERTed anyway.");
                        }
                    }
                    catch (error) {
                        console.log(error);
                    }
                    window.location.href = 'Scripture_Examine.php';
                }
            </script>
            <?php
            }
        }
    }
    /**********************************************************************************
    ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
            apk
    ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    **********************************************************************************/
    elseif ($type == 'apk') {
        $query = "SELECT * FROM CellPhone WHERE ISO_ROD_index = $idx AND Cell_Phone_Title = 'Android App'";
        $result = $db->query($query) or die('Query failed: ' . $db->error);
        if ($result->num_rows === 0) {
            $name = preg_replace("/^\s?-\s?$iso\s?-\s?/", '', $projectName);         // remove the $iso- part at the beginning of the $projectName
            $name = ' - ' . $name;                                            // add ' - ' at the beginning of the $name
            $db->query("INSERT INTO CellPhone (ISO, ROD_Code, Variant_Code, ISO_ROD_index, Cell_Phone_Title, Cell_Phone_File, optional) VALUES ('$iso', '$rod', '$var', $idx, 'Android App', '$url', '$name')");
            $db->query("UPDATE add_resource SET accept = 1, wait = 0, toAdd = 0, reject = 0 WHERE add_index = $add_index");
            $db->query("UPDATE scripture_main SET CellPhone = 1 WHERE ISO_ROD_index = $idx");
            ?>
                <script>
                    window.location.href = 'Scripture_Examine.php';
                </script>
            <?php
        }
        else {
            echo 'Two or more APKs found!<br />Which one do you want to UPDATE with this new one?<br />';
            echo '<span style="color: darkgreen; font-weight: bold; ">This new one is:<br />';
            echo "&nbsp;&nbsp;&nbsp;&nbsp;username: <span style='color: darkblue' >$username</span>; projectName: <span style='color: darkblue' >$projectName</span>; Description: <span style='color: darkblue' >$projectDescription</span><br />";
            echo "&nbsp;&nbsp;&nbsp;&nbsp;email: <span style='color: darkblue' >$email</span>; organization: <span style='color: darkblue' >$organization</span><br />";
            echo "&nbsp;&nbsp;&nbsp;&nbsp;URL: <span style='color: darkblue' >$url</span><br /></span>";
            $APKIndexArray = [];                                                            // CellPhone_index
            $APKFilenameArray = [];							                                // Cell_Phone_File
            $DescriptionArray = [];						                                    // optional
            while ($row = $result->fetch_assoc()) {
                $APKIndexArray[] = $row['CellPhone_index'];								    // CellPhone_index
                $APKFilenameArray[] = $row['Cell_Phone_File'];							    // Cell_Phone_File
                $APKDescriptionArray[] = $row['optional'];						            // optional
            }
            // UPDATE, INSERT, or Cancel
            echo "<div style='margin-top: 20px; '>";
            echo "Choose which APK to UPDATE: &nbsp; <select id='APKSelect' name='APKSelect'>";
            $k=0;
            for ($k=0; $k < count($APKIndexArray); $k++) {
                $num = $k + 1;
                echo "<option value='$APKIndexArray[$k]'>$num => Description: $APKDescriptionArray[$k]; Filename: $APKFilenameArray[$k]</option>";
            }
            echo "</select><br /><br />&nbsp;&nbsp;&nbsp;";
            echo "<input type='button' name='accept' value='UPDATE' onclick='APKUPDATE(\"$url\", \"$projectName\", \"$projectDescription\", $idx, document.getElementById(\"APKSelect\").value, $add_index)' />&nbsp;&nbsp;&nbsp;";      // document.getElementById(\"APKSelect\").value) = $APKIndexArray[$k] of the selected APKIndexArray = CellPhone_index
            echo "<input type='button' name='result' value='INSERT as new APK' onclick='APKINSERT(\"$url\", \"$projectName\", \"$projectDescription\", $idx, \"$iso\", \"$rod\", \"$var\", $add_index)' />&nbsp;&nbsp;&nbsp;";
            echo "<input id='cancel' type='button' value='Cancel' onclick='window.location.href = window.location.href' />";    // No changes made to CellPhone table WHILE $idx AND 'Android App'. So, return to Scripture_Examine.php.
            echo "</div>";
            ?>
            <script>
                /****************************************************************************************************************
                    fetch - ExamineSubmit.php - UPDATE APK
                ****************************************************************************************************************/
                async function APKUPDATE(url, projectName, projectDescription, idx, APKIndex, add_index) {
                    try {
                        const responseAPK = await fetch("ExamineSubmit.php?number=3a&url="+url+"&name="+projectName+"&description="+projectDescription+"&idx="+idx+"&APKIndex="+APKIndex+"&add_index="+add_index);
                        const textAPK = await responseAPK.text();
                        if (textAPK == "none") {
                            console.log("3a. Did you make a mistake?");
                        }
                        else {
                            console.log("3a. CellPhone table already has index number <?php echo $idx ?> and 'Android App'. UPDATEd anyway.");
                        }
                    }
                    catch (error) {
                        console.log(error);
                    }
                    window.location.href = 'Scripture_Examine.php';
                }
                /****************************************************************************************************************
                    fetch - ExamineSubmit.php - INSERT APK
                ****************************************************************************************************************/
                async function APKINSERT(url, projectName, projectDescription, idx, iso, rod, variant, add_index) {
                    try {
                        const responseAPK = await fetch("ExamineSubmit.php?number=3b&url="+url+"&name="+projectName+"&description="+projectDescription+"&idx="+idx+"&iso="+iso+"&rod="+rod+"&var="+variant+"&add_index="+add_index);
                        const textAPK = await responseAPK.text();
                        if (textAPK == "none") {
                            console.log("3b. Did you make a mistake?");
                        }
                        else {
                            console.log("3b. CellPhone table already has index number <?php echo $idx ?> and 'Android App'. INSERTed anyway.");
                        }
                    }
                    catch (error) {
                        console.log(error);
                    }
                    window.location.href = 'Scripture_Examine.php';
                }
            </script>
            <?php
        }
    }
    /**********************************************************************************
    ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
            iOS Asset Package
    ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    **********************************************************************************/
    elseif ($type == 'ios') {           // CellPhone WHERE ISO_ROD_index = $idx AND Cell_Phone_Title = 'iOS Asset Package'";
        $query = "SELECT * FROM CellPhone WHERE ISO_ROD_index = $idx AND Cell_Phone_Title = 'iOS Asset Package'";
        $result = $db->query($query) or die('Query failed: ' . $db->error);
        if ($result->num_rows == 0) {
            $name = preg_replace("/^\s?-\s?$iso\s?-\s?/", '', $projectName);         // remove the $iso- part at the beginning of the $projectName
            $name = ' - ' . $name;                                                   // add ' - ' at the beginning of the $name
            $db->query("INSERT INTO CellPhone (ISO, ROD_Code, Variant_Code, ISO_ROD_index, Cell_Phone_Title, Cell_Phone_File, optional) VALUES ('$iso', '$rod', '$var', $idx, 'iOS Asset Package', '$url', '$name')");
            $db->query("UPDATE add_resource SET accept = 1, wait = 0, toAdd = 0, reject = 0 WHERE add_index = $add_index");
            $db->query("UPDATE scripture_main SET CellPhone = 1 WHERE ISO_ROD_index = $idx");
            ?>
                <script>
                    window.location.href = 'Scripture_Examine.php';
                </script>
            <?php
        }
        else {
            echo 'Two or more iOS Asset Package are found!<br />Which one do you want to UPDATE with this new one?<br />';
            echo '<span style="color: darkgreen; font-weight: bold; ">This  new one is:<br />';
            echo "&nbsp;&nbsp;&nbsp;&nbsp;username: <span style='color: darkblue' >$username</span>; projectName: <span style='color: darkblue' >$projectName</span>; Description: <span style='color: darkblue' >$projectDescription</span><br />";
            echo "&nbsp;&nbsp;&nbsp;&nbsp;email: <span style='color: darkblue' >$email</span>; organization: <span style='color: darkblue' >$organization</span><br />";
            echo "&nbsp;&nbsp;&nbsp;&nbsp;URL: <span style='color: darkblue' >$url</span><br /></span>";
            $iosIndexArray = [];                                                            // CellPhone_index
            $iosFilenameArray = [];							                                // Cell_Phone_File
            $iosDescriptionArray = [];						                                // optional
            while ($row = $result->fetch_assoc()) {
                $iosIndexArray[] = $row['CellPhone_index'];								    // CellPhone_index
                $iosFilenameArray[] = $row['Cell_Phone_File'];							    // Cell_Phone_File
                $iosDescriptionArray[] = $row['optional'];						            // optional
            }
            // UPDATE, INSERT, or Cancel
            echo "<div style='margin-top: 20px; '>";
            echo "Choose which iOS Asset Package: &nbsp; <select id='iosSelect' name='iosSelect'>";
            $k=0;
            for ($k=0; $k < count($iosIndexArray); $k++) {
                $num = $k + 1;
                $temp = substr($iosFilenameArray[$k], 0, strrpos($iosFilenameArray[$k], ':'));
                echo "<option value='$iosIndexArray[$k]'>$num => Description: $iosDescriptionArray[$k]; Filename: $temp...</option>";
            }
            echo "</select><br /><br />&nbsp;&nbsp;&nbsp;";
            echo "<input type='button' name='accept' value='UPDATE' onclick='iosUPDATE(\"$url\", \"$projectName\", \"$projectDescription\", $idx, document.getElementById(\"iosSelect\").value, $add_index)' />&nbsp;&nbsp;&nbsp;";
            echo "<input type='button' name='result' value='INSERT as new iOS Asset Package' onclick='iosINSERT(\"$url\", \"$projectName\", \"$projectDescription\", $idx, \"$iso\", \"$rod\", \"$var\", $add_index)' />&nbsp;&nbsp;&nbsp;";
            echo "<input id='cancel' type='button' value='Cancel' onclick='window.location.href = window.location.href' />";    // No changes made to CellPhone table WHILE $idx AND 'iOS Asset Package'. So, return to Scripture_Examine.php.
            echo "</div>";
            ?>
            <script>
                /****************************************************************************************************************
                    fetch - ExamineSubmit.php - UPDATE iOS Asset Package
                ****************************************************************************************************************/
                async function iosUPDATE(url, projectName, projectDescription, idx, iosIndex, add_index) {
                    try {
                        const responseios = await fetch("ExamineSubmit.php?number=4a&url="+url+"&name="+projectName+"&description="+projectDescription+"&idx="+idx+"&iosIndex="+iosIndex+"&add_index="+add_index);
                        const textios = await responseios.text();
                        if (textios== "none") {
                            console.log("4a. Did you make a mistake?");
                        }
                        else {
                            console.log("4a. CellPhone table already has index number <?php echo $idx ?> and 'iOS Asset Package'. UPDATEd anyway.");
                        }
                    }
                    catch (error) {
                        console.log(error);
                    }
                    window.location.href = 'Scripture_Examine.php';
                }
                /****************************************************************************************************************
                    fetch - ExamineSubmit.php - INSERT iOS Asset Package
                ****************************************************************************************************************/
                async function iosINSERT(url, projectName, projectDescription, idx, iso, rod, variant, add_index) {
                    try {
                        const responseios = await fetch("ExamineSubmit.php?number=4b&url="+url+"&name="+projectName+"&description="+projectDescription+"&idx="+idx+"&iso="+iso+"&rod="+rod+"&var="+variant+"&add_index="+add_index);
                        const textios = await responseios.text();
                        if (textios == "none") {
                            console.log("4b. Did you make a mistake?");
                        }
                        else {
                            alert(textios);
                            console.log("4b. CellPhone table already has index number <?php echo $idx ?> and 'iOS Asset Package'. INSERTed anyway.");
                        }
                    }
                    catch (error) {
                        console.log(error);
                    }
                    window.location.href = 'Scripture_Examine.php';
                }
            </script>
            <?php
        }
    }
    /**********************************************************************************
    ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
            Google Play Store
    ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    **********************************************************************************/
    elseif ($type == 'google_play') {
        $query = "SELECT * FROM links WHERE ISO_ROD_index = $idx AND GooglePlay = 1";
        $result = $db->query($query) or die('Query failed: ' . $db->error);
        if ($result->num_rows == 0) {
            $name = preg_replace("/^\s?-\s?$iso\s?-\s?/", '', $projectName);         // remove the $iso- part at the beginning of the $projectName
            $name = ' - ' . $name;                                                   // add ' - ' at the beginning of the $name
            $db->query("INSERT INTO links (ISO, ROD_Code, Variant_Code, ISO_ROD_index, company, company_title, `URL`, buy, map, BibleIs, YouVersion, Bibles_org, GooglePlay, GRN, email, Kalaam) VALUES ('$iso', '$rod', '$var', $idx, 'Google Play Store', '$name', '$url', 0, 0, 0, 0, 0, 1, 0, 0, 0)");
            $db->query("UPDATE add_resource SET accept = 1, wait = 0, toAdd = 0, reject = 0 WHERE add_index = $add_index");
            $db->query("UPDATE scripture_main SET links = 1 WHERE ISO_ROD_index = $idx");
            ?>
                <script>
                    window.location.href = 'Scripture_Examine.php';
                </script>
            <?php
        }
        else {
            echo 'Two or more Google Play Store are found!<br />Which one do you want to UPDATE with this new one?<br />';
            echo '<span style="color: darkgreen; font-weight: bold; ">This new one is:<br />';
            echo "&nbsp;&nbsp;&nbsp;&nbsp;username: <span style='color: darkblue' >$username</span>; projectName: <span style='color: darkblue' >$projectName</span>; Description: <span style='color: darkblue' >$projectDescription</span><br />";
            echo "&nbsp;&nbsp;&nbsp;&nbsp;email: <span style='color: darkblue' >$email</span>; organization: <span style='color: darkblue' >$organization</span><br />";
            echo "&nbsp;&nbsp;&nbsp;&nbsp;URL: <span style='color: darkblue' >$url</span><br /></span>";
            $LinksIndexArray = [];                                                          // Links_index
            $LinksTitleArray = [];							                                // company_title
            $LinksURLArray = [];						                                    // URL
            while ($row = $result->fetch_assoc()) {
                $LinksIndexArray[] = $row['Links_index'];								    // Links_index
                $LinksTitleArray[] = $row['company_title'];						     	    // company_title
                $LinksURLArray[] = $row['URL'];						                        // URL
            }
            // UPDATE, INSERT, or Cancel
            echo "<div style='margin-top: 20px; '>";
            echo "Choose which Google Play Store to UPDATE: &nbsp; <select id='GPSSelect' name='GPSSelect'>";
            $k=0;
            for ($k=0; $k < count($LinksIndexArray); $k++) {
                $num = $k + 1;
                echo "<option value='$LinksIndexArray[$k]'>$num => Title: $LinksTitleArray[$k]; URL: $LinksURLArray[$k]</option>";
            }
            echo "</select><br /><br />&nbsp;&nbsp;&nbsp;";
            echo "<input type='button' name='accept' value='UPDATE' onclick='GPSUPDATE(\"$url\", \"$projectName\", \"$projectDescription\", $idx, document.getElementById(\"GPSSelect\").value, $add_index)' />&nbsp;&nbsp;&nbsp;";
            echo "<input type='button' name='result' value='INSERT as new Google Play Store' onclick='GPSINSERT(\"$url\", \"$projectName\", \"$projectDescription\", $idx, \"$iso\", \"$rod\", \"$var\", $add_index)' />&nbsp;&nbsp;&nbsp;";
            echo "<input id='cancel' type='button' value='Cancel' onclick='window.location.href = window.location.href' />";    // No changes made to CellPhone table WHILE $idx AND 'Android App'. So, return to Scripture_Examine.php.
            echo "</div>";
            ?>
            <script>
                /****************************************************************************************************************
                    fetch - ExamineSubmit.php - UPDATE Google Play Store
                ****************************************************************************************************************/
                async function GPSUPDATE(url, projectName, projectDescription, idx, GPSIndex, add_index) {
                    try {
                        const responseGPS = await fetch("ExamineSubmit.php?number=5a&url="+url+"&name="+projectName+"&description="+projectDescription+"&idx="+idx+"&GPSIndex="+GPSIndex+"&add_index="+add_index);
                        const textGPS = await responseGPS.text();
                        if (textGPS == "none") {
                            console.log("5a. Did you make a mistake?");
                        }
                        else {
                            console.log("5a. Links table already has index number <?php echo $idx ?> and 'Google Play Store'. UPDATEd anyway.");
                        }
                    }
                    catch (error) {
                        console.log(error);
                    }
                    window.location.href = 'Scripture_Examine.php';
                }
                /****************************************************************************************************************
                    fetch - ExamineSubmit.php - INSERT Google Play Store
                ****************************************************************************************************************/
                async function GPSINSERT(url, projectName, projectDescription, idx, iso, rod, variant, add_index) {
                    try {
                        const responseGPS = await fetch("ExamineSubmit.php?number=5b&url="+url+"&name="+projectName+"&description="+projectDescription+"&idx="+idx+"&iso="+iso+"&rod="+rod+"&var="+variant+"&add_index="+add_index);
                        const textGPS = await responseGPS.text();
                        if (textGPS == "none") {
                            console.log("5b. Did you make a mistake?");
                        }
                        else {
                            console.log("5b. Links table already has index number <?php echo $idx ?> and 'Google Play Store'. INSERTed anyway.");
                        }
                    }
                    catch (error) {
                        console.log(error);
                    }
                    window.location.href = 'Scripture_Examine.php';
                }
            </script>
            <?php
        }
    }
    else {
        die('This isn\'t suppose to happen!');
    }
}

/************************************************
 * 
 *  	does NOT have idx && !accept
 *
 ************************************************/
	if (!isset($_GET["idx"]) && !isset($_POST['accept'])) {
		?>
		<h2>Choose the 'pencil' to examine</h2>
        <?php
		echo "<table class='examines'>";
            echo "<tr id='examine'>";
                echo "<th width='6%' class='secondHeader'>Edit:</th>";
                echo "<th width='6%' class='secondHeader'>Index / ISO:</th>";
                echo "<th width='10%' class='secondHeader'>Type:</th>";
                echo "<th width='28%' class='secondHeader'>Email:</th>";
                echo "<th width='50%' class='secondHeader'>Project Name:</th>";
            echo '</tr>';
            // add_resource => `iso`, `rod`, `var`, `idx`, `type`, `url`, `projectName`, `projectDescription`, `username`, `organization`, `subfolder`, `email`, `accept`, `reject`, `wait`, `toAdd`
            $query = "SELECT * FROM add_resource WHERE toAdd = 1 OR wait = 1 ORDER BY iso, rod, `var`";
            $result = $db->query($query);
            $num = $result->num_rows;

            $i=0;
            while ($row = $result->fetch_assoc()) {
                if ($i % 2)
                    $color = "f8fafa";
                else
                    $color = "EEF1F2";

                $add_index = $row['add_index'];                 // add_index
                $iso = $row['iso'];								// iso
                $rod = $row['rod'];							    // rod
                $var = $row['var'];						        // var
                $idx = $row['idx'];						        // index
                $type = $row['type'];
                $email = $row['email'];
                $projectName = $row['projectName'];
                $projectDescription = '';
                if (isset($row['projectDescription'])) {
                    $projectDescription = $row['projectDescription'];
                }
                $username = $row['username'];
                $organization = $row['organization'];
                $url = $row['url'];
                $subfolder = $row['subfolder'];

                $accept = $row['accept'];                       // boolean
                $reject = $row['reject'];                       // boolean
                $wait = $row['wait'];                           // boolean
                $toAdd = $row['toAdd'];                         // boolean

                // $query = "SELECT * FROM CelCross Site Scripting (XSS) attack happens where client side code (usually JavaScript) gets injected into the output of your PHP script. The next line cleans it up.
                // $LN = htmlspecialchars($LN, ENT_QUOTES, 'UTF-8');
                echo "<tr valign='middle' style='color: black; background-color: #$color; margin: 0px; padding: 0px; '>";
                echo "<td width='6%' style='cursor: pointer; ' onclick='parent.location=\"Scripture_Examine.php?idx=$idx&type=$type\"'><img style='margin-bottom: 3px; margin-left: 13px; cursor: hand; ' src='images/pencil_edit.png' /></td>";
                echo "<td width='6%' style='background-color: #$color; margin: 0px; padding: 3px 5px 3px 5px; border-width: thin; border-style: none; border-color: #$color; '>$idx / $iso</td>";
                echo "<td width='10%' style='background-color: #$color; margin: 0px; padding: 3px 5px 3px 5px; border-width: thin; border-style: none; border-color: #$color; '>$type</td>";
                echo "<td width='28%' style='margin: 0px; padding: 3px 5px 3px 5px; border-width: thin; border-style: none; border-color: #$color; '>$email</td>";
                echo "<td width='50%' style='margin: 0px; padding: 3px 5px 3px 5px; border-width: thin; border-style: none; border-color: #$color; '>$projectName</td>";
                echo '</tr>';
                $i++;
            }
		echo '</table>';
		/* Explicitly destroy the table */
		echo "<div id='count' style='margin: 40px; font-size: 14pt; color: navy; font-weight: bold; '>Numbers from add to and wait are $num</div>";
	}

/************************************************
 * 
 *	    does have idx
 *
 ************************************************/
	elseif (isset($_GET['idx'])) {
		$idx = (int)$_GET['idx'];
		if (!is_numeric($idx)) {
			echo '<script type="text/javascript" language="javascript">
					location.replace("process.php");
					document.write ("Did you make a mistake?");
				</script>'; 
		}
        if (!isset($_GET['type'])) {
            die('Did you make a mistake?');
        }
        $type = $_GET['type'];
        if (!preg_match('/^([_a-zA-Z0-9])+/', $type)) {
            die('Did you make a mistake?');
        }
		echo '<br />';
		
		$query="SELECT * FROM add_resource WHERE (toAdd = 1 OR wait = 1) AND idx = $idx AND `type` = '$type'";
		$result=$db->query($query) or die ('Query failed: ' . $db->error . '</body></html>');
		//if ($db->error) {
		if ($result->num_rows == 0) {
			//die ("'add_resource' index is not found.<br />" . $db->error . '</body></html>');
			die("The $idx index is not found.");
			//Scripture_Examine.php
		}
		$row = $result->fetch_assoc();
        $add_index = $row['add_index'];                 // add_index
        $iso = $row['iso'];								// iso
        $rod = $row['rod'];							    // rod
        $var = $row['var'];						        // var
        /*$idx = $row['idx'];						        // index
        $type = $row['type'];*/
        $email = trim($row['email']);
        $projectName = trim($row['projectName']);
        $projectDescription = '';
        if (isset($row['projectDescription'])) {
            $projectDescription = trim($row['projectDescription']);
        }
        $username = trim($row['username']);
        $organization = trim($row['organization']);
        $url = trim($row['url']);
        $subfolder = trim($row['subfolder']);

        //$accept = $row['accept'];                       // boolean
        //$reject = $row['reject'];                       // boolean
        //$wait = $row['wait'];                           // boolean
        //$toAdd = $row['toAdd'];                         // boolean
        ?>
		<form name='myForm' action='Scripture_Examine.php' method='post'>
		<div class='enter' style='color: navy; font-weight: bold; '>
            idx: <?php echo $idx; ?><br />
            iso: <?php echo $iso; ?><br />
            rod: <?php echo $rod; ?><br />
            var: <?php echo $var; ?><br />
            <br />
            type: <?php echo $type; ?><br />
            Project Name: <?php echo $projectName; ?><br />
            <?php if ($projectDescription != '') { ?>
                Project Description: <?php echo $projectDescription; ?><br />
            <?php } ?>
            URL: <?php echo $url; ?><br />
            User Name: <?php echo $username; ?><br />
            Organization: <?php echo $organization; ?>

            <?php
            if ($type == "sab_html") {
                $subfolder = trim($subfolder);
//                if ($subfolder == '') {
//                    $subfolder = $iso;
//                }
                echo "<br />subfolder: $subfolder<br />";
            }
            elseif ($type == "apk") {
            }
            elseif ($type == "ios") {
            }
            elseif ($type == "google_play") {
            }
            else {
                die('type is not listed.');
            }

            echo "<br />email: $email<br /><br ><br />";
            ?>
        </div>
        
        <input type='hidden' name='add_index' id='add_index' value='<?php echo $add_index; ?>' />
        <input type='hidden' name='idx' id='idx' value='<?php echo $idx; ?>' />
        <input type='hidden' name='iso' id='iso' value='<?php echo $iso; ?>' />
        <input type='hidden' name='rod' id='rod' value='<?php echo $rod; ?>' />
		<input type='hidden' name='var' id='var' value='<?php echo $var; ?>' />
		<input type='hidden' name='type' id='type' value='<?php echo $type; ?>' />
		<input type='hidden' name='email' id='email' value='<?php echo $email; ?>' />
		<input type='hidden' name='projectName' id='projectName' value='<?php echo $projectName; ?>' />
		<input type='hidden' name='projectDescription' id='projectDescription' value='<?php echo $projectDescription; ?>' />
        <input type='hidden' name='username' id='username' value='<?php echo $username; ?>' />
        <input type='hidden' name='organization' id='organization' value='<?php echo $organization; ?>' />
	    <input type='hidden' name='subfolder' id='subfolder' value='<?php echo $subfolder; ?>' />
		<input type='hidden' name='url' id='url' value='<?php echo $url; ?>' />

        <div id="result"></div>
        <div id="buttons">
            <input id="accept" name="accept" style="font-size: 9pt; " type="Submit" value="Accept" />
            <input id="reject" name="reject" style="font-size: 9pt; " onclick="Reject(<?php echo $idx; ?>, '<?php echo $type; ?>')" type="button" value="Reject" />
            <input id="wait" name="wait" style="font-size: 9pt; " onclick="Wait(<?php echo $idx; ?>, '<?php echo $type; ?>')" type="button" value="Wait" />
        </div>
        <br />
        <input id="cancel" name="cancel" style="font-size: 9pt; " onclick="Cancel()" type="button" value="Cancel" />
        </form>

        <?php
    }
    echo '</div>';
    ?>
</body>
</html>