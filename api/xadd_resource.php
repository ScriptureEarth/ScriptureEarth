<?php
/*
https://scriptureearth.org/api/add_resource.php?v=1&key=<key>&json=https//...
*/

/* Scriptoria should send json file: https://thisinterestsme.com/sending-json-via-post-php/ */
/* This recieves the data: https://thisinterestsme.com/receiving-json-post-data-via-php/ */

// add_resource.php won't work with Curl. Curl gives '406 Not Acceptable'!!!!! However, it will work with wget, Postman, and ARC.

require_once '../include/conn.inc.php';															// connect to the database named 'scripture'
$db = get_my_db();

include 'include/v.key.php';																	// get v and key

if (!isset($_GET['json'])) {
    //Make sure that it is a POST request.
    if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
        $exception = new Exception('Request method must be POST!', 405);
        echo $exception->getMessage();
        echo "\r\nCode: " . $exception->getCode();
        echo "\r\nrequest = @" . $_SERVER["REQUEST_METHOD"] . '@';
        throw $exception;
    }

    //Make sure that the content type of the POST request has been set to application/json
    $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
//    $contentType = isset($_SERVER["ACCEPT"]) ? trim($_SERVER["ACCEPT"]) : '';
    if(strcasecmp($contentType, 'application/json') != 0){
        throw new Exception('Content type must be: application/json');
    }

    // Receive the RAW post data from the request
    $json = trim(file_get_contents('php://input'));
}
else {
    $request_url = $_GET['json'];
    $json = trim(file_get_contents($request_url));
}

if (empty($json)) { throw new Exception('Received content is empty!'); }

$handle = fopen('API_check.txt', "a");				                                            // Open for writing appends
fwrite($handle, 'json: ' . $json);
fclose($handle);

// Attempt to decode the incoming RAW post data from JSON. The data is in PHP associative array.
$data = json_decode($json, true);

// If json_decode failed, the JSON is invalid.
if (!is_array($data)) { throw new Exception('Received content contained invalid JSON!'); }

$stmt_main = $db->prepare("SELECT ISO, ROD_Code, Variant_Code FROM scripture_main WHERE ISO_ROD_index = ?");
$stmt_add_resource = $db->prepare("INSERT INTO add_resource (`iso`, `rod`, `var`, `idx`, `type`, `url`, `projectName`, `projectDescription`, `username`, `organization`, `subfolder`, `email`, `createdDate`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURDATE())");

$message = '';

// Access values from the associative array
foreach ($data as $items => $value) {
    $type = $data[$items]["type"];
    $idx = (int)$data[$items]["idx"];
    $email = $data[$items]["email"];
    $projectName = $data[$items]["projectName"];
    $projectDescription = $data[$items]["projectDescription"];
    $username = $data[$items]["username"];
    $organization = $data[$items]["organization"];
    $url = $data[$items]["url"];

    $subfolder = '';

    if ($data[$items]["type"] == 'sab_html') {
        if (isset($data[$items]["subfolder"])) {
            $subfolder = $data[$items]["subfolder"];
            if (stripos($url, 'scriptureearth.org') !== false) {
                $url = preg_replace('/.+\.org\/(data\/[a-z]{3}\/sab\/[a-zA-Z0-9]{3,})\/index\.html/i', '$1', $url);
            }
        }
        elseif (stripos($url, 'scriptureearth.org') !== false) {
            $subfolder = preg_replace('/.+\.org\/data\/[a-z]{3}\/sab\/([a-zA-Z0-9]{3,})\/index\.html/i', '$1', $url);
            $url = preg_replace('/.+\.org\/(data\/[a-z]{3}\/sab\/[a-zA-Z0-9]{3,})\/index\.html/i', '$1', $url);
        }
        else {
            // $subfolder = '' && $url != 'scriptureearth.org'
        }
    }
    elseif ($data[$items]["type"] == 'apk') {
        //$url = $data[$items]["url"];
    }
    elseif ($data[$items]["type"] == 'ios') {
        //$url = $data[$items]["url"];
    }
    elseif ($data[$items]["type"] == 'google_play') {
        //$url = $data[$items]["url"];
    }
    else {
        die('type does not exists');
    }

    $stmt_main->bind_param('i', $idx);
    $stmt_main->execute();																        // execute query for scripture_main table
    $result_main = $stmt_main->get_result();
    if ($result_main->num_rows === 0) {
        die('ISO_ROD_index ' . $idx . ' is not found.');
    }
    $row_main = $result_main->fetch_assoc();
    $iso = $row_main['ISO'];
    $rod = $row_main['ROD_Code'];
    $var = $row_main['Variant_Code'];
   
    $stmt_add_resource->bind_param('sssissssssss', $iso, $rod, $var, $idx, $type, $url, $projectName, $projectDescription, $username, $organization, $subfolder, $email);	    // bind parameters for markers
    $stmt_add_resource->execute();																// execute query for add_resource table

    // These \r\n 's need to be here!
    $message .= "Using CMS Examine:
    <br />
    idx: $idx / iso: $iso; rod: $rod; var: $var
    <br />
    type: $type
    <br />
    Project Name: $projectName
    <br />
    Project Description: $projectDescription
    <br />
    URL: $url
    <br />
    User Name: $username
    <br />
    Organization: $organization";

    if ($type == 'sab_html') {
        $message .= "<br />subfolder: $subfolder";
    }
    elseif ($type == 'apk') {
        //$message .= "<br />url: $url";
    }
    elseif ($type == 'ios') {
        //$message .= "<br />url: $url";
    }
    elseif ($type == 'google_play') {
        //$message .=  "<br />url: $url
    }

    $message .= "<br />email: $email";
    $message .= "<br /><br /><br />";
}

// email

$contactName = $username;

// From email 
//$email = 'Scott_Starker@sil.org'; 

$subject = 'IMPORTANT! There\'s at least one Scriptoria record for you to examine.'; 

// Send To Email Address
//$ax_mailTo = "Scott_Starker@sil.org";
$ax_mailTo = "info@ScriptureEarth.org";

// Body:
$body = '
    <p>Name: ' . $contactName . '</p>
    <p>Subject: '.$subject.'</p>
    <p><br />' . $message . '</p>
';

// Headers
// Always set content-type when sending HTML email. Also, always use "\r\n" (with "!) at the end of the $headers lines.
$headers = 'From: ' . $contactName . ' <' . $email . '>'."\r\n";
$headers .= 'Reply-To: ' . $contactName . ' <' . $email . '>'."\r\n";
//$headers .= 'To: ' . $ax_mailTo."\r\n";
$headers .= 'Return-Path: ' . $contactName . ' <' . $email . '>'."\r\n";
$headers .= 'Bcc: Scott_Starker@sil.org'."\r\n";
$headers .= 'X-Mailer: PHP v'.phpversion()."\r\n";
$headers .= 'MIME-Version: 1.0'."\r\n";
$headers .= 'Content-type: text/html; charset=UTF-8'."\r\n";
$headers .= 'Message-ID: <' . time() .'-' . md5($email . $ax_mailTo) . '@' . $_SERVER['SERVER_NAME'].'>'."\r\n";

// Send it
@ini_set('sendmail_from', $email);													// for Windows
//@ini_set('sendmail_path', );
// For example, to send HTML mail, the Content-type header must be set
//$headers[] = 'MIME-Version: 1.0';													// $headers array is from PHP 7+
//$headers[] = 'Content-type: text/html; charset=iso-8859-1';
// Additional headers
//$headers[] = 'To: Mary <mary@example.com>, Kelly <kelly@example.com>';
//$headers[] = 'From: Birthday Reminder <birthday@example.com>';
//$headers[] = 'Cc: birthdayarchive@example.com';
//$headers[] = 'Bcc: birthdaycheck@example.com';
// Mail it
//mail($to, $subject, $message, implode("\r\n", $headers));
if (mail($ax_mailTo, $subject, $body, $headers)) {
    //echo 'SENT!<br />';
    $emailSent = true;
}
else {
    //echo 'DID NOT SEND!<br />';
    $errorMessage = error_get_last()['message'];
    echo $errorMessage . '<br />';
}

?>