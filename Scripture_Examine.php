<?php
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
if (isset($_POST['accept'])) {          // the "Submit" button
    if (!isset($_POST['iso']) || !isset($_POST['rod']) || !isset($_POST['var']) || !isset($_POST['idx']) || !isset($_POST['type']) || !isset($_POST['email']) || !isset($_POST['projectName']) || !isset($_POST['url']) || !isset($_POST['projectDescription']) || !isset($_POST['subfolder'])) {
        /*if (!isset($_POST['iso'])) echo 'iso is not POSTed.<br />';
        if (!isset($_POST['rod'])) echo 'rod is not POSTed.<br />';
        if (!isset($_POST['var'])) echo 'var is not POSTed.<br />';
        if (!isset($_POST['idx'])) echo 'idx is not POSTed.<br />';
        if (!isset($_POST['type'])) echo 'type is not POSTed.<br />';
        if (!isset($_POST['email'])) echo 'email is not POSTed.<br />';
        if (!isset($_POST['projectName'])) echo 'project name is not POSTed.<br />';
        if (!isset($_POST['url'])) echo 'url is not POSTed.<br />';
        if (!isset($_POST['projectDescription'])) echo 'project desciption is not POSTed.<br />';
        if (!isset($_POST['subfolder'])) echo 'subfolder is not POSTed.<br />';*/
        die('Hacker!');
    }
    $iso = $_POST['iso'];								// iso
    $rod = $_POST['rod'];							    // rod
    $var = $_POST['var'];						        // var
    $idx = (int)$_POST['idx'];						    // index
    $type = $_POST['type'];
    $email = $_POST['email'];
    $projectName = $_POST['projectName'];
    $projectDescription = $_POST['projectDescription'];
    $projectDescription = substr($projectDescription, 0, strpos($projectDescription, ';') - 1);
    $url = $_POST['url'];
    $username = $_POST['username'];
    $organization = $_POST['organization'];
    $subfolder = $_POST['subfolder'];

    //$db->query("INSERT INTO add_resource (`iso`, `rod`, `var`, `idx`, `type`, `url`, `projectName`, `projectDescription`, `username`, `organization`, `subfolder`, `email`) VALUES ('$iso', '$rod', '$var', $idx, '$type', '$url', '$projectName', '$projectDescription', '$username', '$organization', '$sab/ZZZZZZ/', '$email')");

    // print_r($_POST);
    // INSERT add_resource fields into "type" => 
    //      "sab_html" (SAB_Scirptoria table:  ISO	ROD_Code	Variant_Code	ISO_ROD_index	subfolder = subfolder	description = projectDescription	pre_scriptoria),
    //      "apk" (CellPhone table: ISO	ROD_Code	Variant_Code	ISO_ROD_index	Cell_Phone_Title = 'Android App'	Cell_Phone_File = url),
    //      "ios" (CellPhone table: ISO	ROD_Code	Variant_Code	ISO_ROD_index	Cell_Phone_Title = 'iOS Asset Package'	Cell_Phone_File = url),
    //      and "google_play" (links table:  ISO	ROD_Code	Variant_Code	ISO_ROD_index	company = 'Google Play Store'   company_title =	URL = url	buy	map	BibleIs	YouVersion	Bibles_org	GooglePlay = 1	GRN)
    // UPDATE add_resource to accept = 1
    /******************************************************************************************************
            potential problem. What if the user wants to update from $subfolder to sab/$subfolder/?
     ******************************************************************************************************/
    if ($type == 'sab_html') {
        if ($subfolder != '') {                 // SAB HTML
            $query = "SELECT * FROM SAB_scriptoria WHERE ISO_ROD_index = $idx AND subfolder = 'sab/$subfolder/'";
            $result = $db->query($query);
            if ($result->num_rows == 0) {
                $db->query("INSERT INTO SAB_scriptoria (ISO, ROD_Code, Variant_Code, ISO_ROD_index, `url`, subfolder, `description`, pre_scriptoria, SAB_number) VALUES ('$iso', '$rod', '$var', $idx, '$url', 'sab/$subfolder/', '', '', 1)");
                $db->query("UPDATE add_resource SET accept = 1, wait = 0, toAdd = 0, reject = 0 WHERE idx = $idx AND `type` = '$type'");
                $db->query("UPDATE scripture_main SET SAB = 1 WHERE ISO_ROD_index = $idx");
                $SAB_number = 1;
            }
            else {
                $db->query("UPDATE add_resource SET accept = 1, wait = 0, toAdd = 0, reject = 0 WHERE idx = $idx AND `type` = '$type'");
                echo 'SAB_Scriptoria table has index number ' . $idx . ' (sab/' . $subfolder . '/) already there.<br />';
                if ($result->num_rows == 0) {
                    die('SAB_Scriptoria ' . $idx . ' and ' . $subfolder . ' is not found.');
                }
                $row = $result->fetch_assoc();
                $SAB_number = $row['SAB_number'];
            }
            include 'include/SAB_inc.php';      // add and index SAB table
        }
        else {                                  // SAB HTML links
            $query = "SELECT * FROM SAB_scriptoria WHERE ISO_ROD_index = $idx AND `url` = '$url'";
            $result = $db->query($query);
            if ($result->num_rows == 0) {
                $db->query("INSERT INTO SAB_scriptoria (ISO, ROD_Code, Variant_Code, ISO_ROD_index, `url`, subfolder, `description`, pre_scriptoria, SAB_number) VALUES ('$iso', '$rod', '$var', $idx, '$url', '', '', '', 1)");
                $db->query("UPDATE add_resource SET accept = 1, wait = 0, toAdd = 0, reject = 0 WHERE idx = $idx AND `type` = '$type'");
                $db->query("UPDATE scripture_main SET SAB = 1 WHERE ISO_ROD_index = $idx");
            }
            else {
                $db->query("UPDATE add_resource SET accept = 1, wait = 0, toAdd = 0, reject = 0 WHERE idx = $idx AND `type` = '$type'");
                echo 'SAB_Scriptoria table has index number ' . $idx . ' (URL: ' . $url . ') already there.<br />';
            }
        }
    }
    elseif ($type == 'apk') {
        $query = "SELECT * FROM CellPhone WHERE ISO_ROD_index = $idx AND Cell_Phone_Title = 'Android App'";
        $result = $db->query($query);
        if ($result->num_rows == 0) {
            $db->query("INSERT INTO CellPhone (ISO, ROD_Code, Variant_Code, ISO_ROD_index, Cell_Phone_Title, Cell_Phone_File, optional) VALUES ('$iso', '$rod', '$var', $idx, 'Android App', '$url', '')");
            $db->query("UPDATE add_resource SET accept = 1, wait = 0, toAdd = 0, reject = 0 WHERE idx = $idx AND `type` = '$type'");
            $db->query("UPDATE scripture_main SET CellPhone = 1 WHERE ISO_ROD_index = $idx");
        }
        else {
            $db->query("UPDATE add_resource SET accept = 1, wait = 0, toAdd = 0, reject = 0 WHERE idx = $idx AND `type` = '$type'");
            echo 'CellPhone table has ' . $idx . ' and "Android App" already there.<br />';
        }
    }
    elseif ($type == 'ios') {
        $query = "SELECT * FROM CellPhone WHERE ISO_ROD_index = $idx AND Cell_Phone_Title = 'iOS Asset Package'";
        $result = $db->query($query);
        if ($result->num_rows == 0) {
            $db->query("INSERT INTO CellPhone (ISO, ROD_Code, Variant_Code, ISO_ROD_index, Cell_Phone_Title, Cell_Phone_File, optional) VALUES ('$iso', '$rod', '$var', $idx, 'iOS Asset Package', '$url', '')");
            $db->query("UPDATE add_resource SET accept = 1, wait = 0, toAdd = 0, reject = 0 WHERE idx = $idx AND `type` = '$type'");
            $db->query("UPDATE scripture_main SET CellPhone = 1 WHERE ISO_ROD_index = $idx");
        }
        else {
            $db->query("UPDATE add_resource SET accept = 1, wait = 0, toAdd = 0, reject = 0 WHERE idx = $idx AND `type` = '$type'");
            echo 'CellPhone table has ' . $idx . ' and "iOS Asset Package" already there.<br />';
        }
    }
    elseif ($type == 'google_play') {
        $query = "SELECT * FROM links WHERE ISO_ROD_index = $idx AND `URL` = '$url' AND GooglePlay = 1";
        $result = $db->query($query);
        if ($result->num_rows == 0) {
            $db->query("INSERT INTO links (ISO, ROD_Code, Variant_Code, ISO_ROD_index, company, company_title, `URL`, buy, map, BibleIs, YouVersion, Bibles_org, GooglePlay, GRN) VALUES ('$iso', '$rod', '$var', $idx, 'Google Play Store', '$projectDescription', '$url', 0, 0, 0, 0, 0, 1, 0)");
            $db->query("UPDATE add_resource SET accept = 1, wait = 0, toAdd = 0, reject = 0 WHERE idx = $idx AND `type` = '$type'");
            $db->query("UPDATE scripture_main SET links = 1 WHERE ISO_ROD_index = $idx");
        }
        else {
            $db->query("UPDATE add_resource SET accept = 1, wait = 0, toAdd = 0, reject = 0 WHERE idx = $idx AND `type` = '$type'");
            echo 'links table: ' . $idx . ' and ' . $url . ' and GooglePlay = 1 is already there.<br />';
        }
    }
    else {
        die('This isn\'t suppose to happen!');
    }
    //unset($_POST['accept']);
    // include('Scripture_Examine.php');
    // exit();
    ?>
    <script>
        window.location.href = 'Scripture_Examine.php';
    </script>
    <?php
}
//else {
//	echo 'No sumbit!<br />';
//}

/************************************************
	does NOT have idx
************************************************/
	if (!isset($_GET["idx"])) {
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

                $iso = $row['iso'];								// iso
                $rod = $row['rod'];							    // rod
                $var = $row['var'];						        // var
                $idx = $row['idx'];						        // index
                $type = $row['type'];
                $email = $row['email'];
                $projectName = $row['projectName'];
                $projectDescription = $row['projectDescription'];
                $username = $row['username'];
                $organization = $row['organization'];
                $url = $row['url'];
                $subfolder = $row['subfolder'];

                $accept = $row['accept'];                       // boolean
                $reject = $row['reject'];                       // boolean
                $wait = $row['wait'];                           // boolean
                $toAdd = $row['toAdd'];                         // boolean

                // Cross Site Scripting (XSS) attack happens where client side code (usually JavaScript) gets injected into the output of your PHP script. The next line cleans it up.
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
	does have idx
************************************************/
	elseif (isset($_GET['idx'])) {
		$idx = (int)$_GET['idx'];
		if (!is_numeric($idx)) {
			echo '<script type="text/javascript" language="javascript">
					location.replace("process.php");
					document.write ("DIE you Hacker!");
				</script>'; 
		}
        if (!isset($_GET['type'])) {
            die('Hack!');
        }
        $type = $_GET['type'];
        if (!preg_match('/^([_a-zA-Z0-9])+/', $type)) {
            die('Hack!');
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
        $iso = $row['iso'];								// iso
        $rod = $row['rod'];							    // rod
        $var = $row['var'];						        // var
        /*$idx = $row['idx'];						        // index
        $type = $row['type'];*/
        $email = trim($row['email']);
        $projectName = trim($row['projectName']);
        $projectDescription = trim($row['projectDescription']);
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
            Project Description: <?php echo $projectDescription; ?><br />
            URL: <?php echo $url; ?><br />
            User Name: <?php echo $username; ?><br />
            Organization: <?php echo $organization; ?>
            <?php
            if ($type == "sab_html") {
                $subfolder = trim($subfolder);
                if ($subfolder == '') {
                    $subfolder = $iso;
                }
                echo "<br />subfolder: $subfolder<br />";
                //echo "description: $projectDescription<br />";
            }
            elseif ($type == "apk") {
                //echo "<br />url: $url<br />";
            }
            elseif ($type == "ios") {
                //echo "<br />url: $url<br />";
            }
            elseif ($type == "google_play") {
                //echo "<br />url: $url<br />";
                //echo "<br />description: $projectDescription";
            }
            else {
                die('type is not listed.');
            }
            echo "<br />email: $email<br /><br ><br />";
            ?>
        </div>
        
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
            <input id="reject" name="reject" style="font-size: 9pt; " onClick="Reject(<?php echo $idx; ?>, '<?php echo $type; ?>')" type="button" value="Reject" />
            <input id="wait" name="wait" style="font-size: 9pt; " onClick="Wait(<?php echo $idx; ?>, '<?php echo $type; ?>')" type="button" value="Wait" />
        </div>
        <br />
        <input id="cancel" name="cancel" style="font-size: 9pt; " onClick="Cancel()" type="button" value="Cancel" />
        </form>

        <?php
    }
    echo '</div>';
    ?>
</body>
</html>