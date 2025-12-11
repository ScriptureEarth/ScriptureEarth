<?php
/*
    Examine Sumbit
	created by Scott Starker - 10/24/2025

    from Scripture_Examiner.php
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

/****************************************************************************************************************
    GET variables
****************************************************************************************************************/
    if (isset($_GET['number'])) $number = $_GET['number']; else { die('none'); }                    // 1a - 5b
    if (preg_match('/^[1-5][ab]$/', $number) == 0) { die('none'); }			                        // only one number and lower case letter allowed
    if (isset($_GET['name'])) $name = $_GET['name']; else { die('none'); }                          // projectName from add_resource table
    if (isset($_GET['description'])) $description = $_GET['description']; else { die('none'); }     // description from add_resource table
    if (isset($_GET['iso'])) $iso = $_GET['iso']; else { die('none'); }                             // iso from add_resource table
    $name = preg_replace("/^(\s?-?\s?$iso\s?-?\s?)/", '', $name);                                   // remove the $iso- part at the beginning of the name
    $name = ' - ' . $name;                                                                          // add ' - ' at the beginning of the name
    $name = $description != '' ? $name . ' - ' . $description : $name;
    if (substr($number, 1, 1) == 'b') {                                                             // for INSERTs only
        if (isset($_GET['rod'])) $rod = $_GET['rod']; else { die('none'); }                         // rod from add_resource table
        if (isset($_GET['var'])) $var = $_GET['var']; else { die('none'); }                         // var from add_resource table
    }
    if ($number == '1a' || $number == '1b') {
        if (isset($_GET['subfolder'])) $subfolder = $_GET['subfolder']; else { die('none'); }       // subfolder from add_resource table
    }
    else {
        if (isset($_GET['url'])) $url = $_GET['url']; else { die('none'); }                         // url from add_resource table
    }
    if (isset($_GET['idx'])) $idx = (int)$_GET['idx']; else { die('none'); }                        // idx from add_resource table
    if (isset($_GET['add_index'])) $add_index = (int)$_GET['add_index']; else { die('none'); }      // add_index from add_resource table

require_once './include/conn.inc.php';													            // connect to the database named 'scripture'
$db = get_my_db();

$result = $db->query("UPDATE add_resource SET accept = 1, reject = 0, wait = 0, toAdd = 0 WHERE add_index = $add_index");
if (!$result) {
    die('Database UPDATE failed: ' . $db->error);
}

/****************************************************************************************************************
    sab_html with subfolder (1a and 1b)
****************************************************************************************************************/
if ($number == '1a') {                            // type = sab_html      UPDATE
    if (isset($_GET['SABIndex'])) $SABIndex = (int) $_GET['SABIndex']; else { die('none'); }        // SAB_index from SAB_scriptoria table

    $db->query("UPDATE `SAB_scriptoria` SET `url` = '', `subfolder` = 'sab/$subfolder/', `description` = '$name' WHERE `SAB_index` = $SABIndex");

    include 'api/include/SAB_inc.php';            // add html files to the SAB table

    echo 'done';
}
elseif ($number == '1b') {                        // type = sab_html     INSERT
    if (isset($_GET['SAB_number'])) $SAB_number = (int) $_GET['SAB_number']; else { die('none'); }  // SAB_number from add_resource table

    $db->query("INSERT INTO SAB_scriptoria (ISO, ROD_Code, Variant_Code, ISO_ROD_index, `url`, subfolder, `description`, pre_scriptoria, SAB_number) VALUES ('$iso', '$rod', '$var', $idx, '', 'sab/$subfolder/', '$name', '', $SAB_number)");

    include 'api/include/SAB_inc.php';            // add html files to the SAB table

    echo 'done';
}  
/****************************************************************************************************************
    sab_html with url (2a and 2b)
****************************************************************************************************************/
elseif ($number == '2a') {                        // type = sab_html     UPDATE
    // SABUPDATE2(url, projectName, description, idx, SABIndex, add_index)
    if (isset($_GET['SABIndex'])) $SABIndex = (int) $_GET['SABIndex']; else { die('none'); }        // SAB_index from SAB_scriptoria table

    $db->query("UPDATE SAB_scriptoria SET `url` = '$url', `subfolder` = '', `description` = '$name' WHERE `SAB_index` = $SABIndex");
    echo 'done';
}  
elseif ($number == '2b') {                       // type = sab_html      INSERT
    // SABINSERT2(url, projectName, description, idx, iso, rod, variant, SAB_number, add_index)
    if (isset($_GET['SAB_number'])) $SAB_number = (int) $_GET['SAB_number']; else { die('none'); }  // SAB_number from add_resource table

    $db->query("INSERT INTO SAB_scriptoria (ISO, ROD_Code, Variant_Code, ISO_ROD_index, `url`, subfolder, `description`, pre_scriptoria, SAB_number) VALUES ('$iso', '$rod', '$var', $idx, '$url', '', '$name', '', $SAB_number)");
    echo 'done';
}
/****************************************************************************************************************
    apk (3a and 3b)
****************************************************************************************************************/
elseif ($number == '3a') {                       // type = apk           UPDATE
    // APKUPDATE(url, projectName, description, idx, APKIndex, add_index)
    if (isset($_GET['APKIndex'])) $APKIndex = (int)$_GET['APKIndex']; else { die('none'); }         // APKIndex from CellPhone table

    $db->query("UPDATE CellPhone SET Cell_Phone_File = '$url', optional = '$name' WHERE `CellPhone_index` = $APKIndex");
    echo 'done';
}
elseif ($number == '3b') {                      // type = apk            INSERT
    // APKINSERT(url, projectName, description, idx, iso, rod, variant, add_index)

    $db->query("INSERT INTO CellPhone (ISO, ROD_Code, Variant_Code, ISO_ROD_index, Cell_Phone_Title, Cell_Phone_File, optional) VALUES ('$iso', '$rod', '$var', $idx, 'Android App', '$url', '$name')");
    echo 'done';
}
/****************************************************************************************************************
    ios (4a and 4b)
****************************************************************************************************************/
elseif ($number == '4a') {                      // type = ios           UPDATE
    // iosUPDATE(url, projectName, description, idx, iosIndex, add_index)
    if (isset($_GET['iosIndex'])) $iosIndex = (int)$_GET['iosIndex']; else { die('none'); }         // iosIndex from CellPhone table

    $db->query("UPDATE CellPhone SET Cell_Phone_File = '$url', optional = '$name' WHERE `CellPhone_index` = $iosIndex");
    echo 'done';
}
elseif ($number == '4b') {                      // type = ios            INSERT
    // iosINSERT(url, projectName, description, idx, iso, rod, variant, add_index)

    $db->query("INSERT INTO CellPhone (ISO, ROD_Code, Variant_Code, ISO_ROD_index, Cell_Phone_Title, Cell_Phone_File, optional) VALUES ('$iso', '$rod', '$var', $idx, 'iOS Asset Package', '$url', '$name')");
    echo 'done';
}
/****************************************************************************************************************
    google play store (5a and 5b)
****************************************************************************************************************/
elseif ($number == '5a') {                      // type = google play store  UPDATE
    // GPSUPDATE(url, projectName, description, idx, GPSIndex, add_index)
    if (isset($_GET['GPSIndex'])) $GPSIndex = (int)$_GET['GPSIndex']; else { die('none'); }         // iosIndex from CellPhone table

    $db->query("UPDATE links SET `URL` = '$url', company_title = '$name' WHERE `links_index` = $GPSIndex");
    echo 'done';
}  
elseif ($number == '5b') {                      // type = google play store    INSERT
    // GPSINSERT(url, projectName, description, idx, iso, rod, variant, add_index)

    $db->query("INSERT INTO links (ISO, ROD_Code, Variant_Code, ISO_ROD_index, company, company_title, `URL`, buy, map, BibleIs, YouVersion, Bibles_org, GooglePlay, GRN, email, Kalaam) VALUES ('$iso', '$rod', '$var', $idx, 'Google Play Store', '$name', '$url', 0, 0, 0, 0, 0, 1, 0, 0, 0)");
    echo 'done';
} 
else {
    echo 'none';
}
?>