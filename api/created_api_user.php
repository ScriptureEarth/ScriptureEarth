<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ScriptureEarth.org API - User</title>
</head>
<body>
    <?php
        $index = 0;
        if (isset($_POST['btsubmit'])) {
            if (!isset($_POST['name'])) {
                die('No "Name". Refresher this URL and try again.');
            }
            $name = $_POST['name'];
            if (preg_match('/^([a-zA-Z][\.\-_ a-zA-Z]+[a-zA-Z])/', $name, $match)) {
                $name = $match[1];
            }
            else {
                die('Illegal "Name" ('.$name.'). Refresher this URL and try again.');
            }

            if (!isset($_POST['email'])) {
                die('No "Email". Refresher this URL and try again.');
            }
            $email = $_POST['email'];
            // Remove all illegal characters from email
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            // Validate e-mail
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                die('Illegal "Email" ('.$email.'). Refresher this URL and try again.');
            }

            if (!isset($_POST['organization'])) {
                die('No "Organization". Refresher this URL and try again.');
            }
            $organization = $_POST['organization'];
            if (preg_match('/^([a-zA-Z][\.\-_ a-zA-Z]*[a-zA-Z])/', $organization, $match)) {
                $organization = $match[1];
            }
            else {
                die('Illegal "Organization" ('.$organization.'). Refresher this URL and try again.');
            }

            $key = str_rand();

            require_once '../include/conn.inc.php';															// connect to the database named 'scripture'
            $db = get_my_db();
            
            $query = "SELECT * FROM api_users WHERE `name` = '$name' AND `email` = '$email' AND organization = '$organization'";
            $result=$db->query($query) or die ('Query failed: ' . $db->error . '</body></html>');
            if ($result->num_rows <= 0) {
                $db->query("INSERT INTO api_users (`name`, `email`, organization, `key`, date_created, date_modified) VALUES ('$name', '$email', '$organization', '$key', CURDATE(), CURDATE())");
                echo '<br /><br /><div style="font-size: 16pt; margin-left: 20px; ">key: <span style="color: red; ">' . $key . '</span></div><br />';
                echo '<div style="font-size: 15pt; margin-left: 20px; ">Email the key to <span style="color: red; ">'.$name.' &lt;'.$email.'&gt;</span>.</div><br /><br /><br />';
            }
            else {
                die ('<div style="background-color: white; color: red; font-size: 16pt; padding-top: 20px; padding-bottom: 20px; margin-left: 20px; margin-top: 200px; ">The record is found so this records is skipped.</div></body></html>');
            }

        }
    ?>

<h1 style='color: darkblue; '>ScriptureEarth.org API</h1>
<form name="myForm" id='myForm' action="created_api_user.php" method="post">
    Full Name:
    <input id="name" type="text" name="name" />
    <br /><br />
    Email address:
    <input id="email" type="text" name="email" />
    <br /><br />
    Organization:
    <input id="organization" type="text" name="organization" />
    <br />
    <br />
    <br />
    <input type="submit" name="btsubmit" value="Submit" />
    <br /><br />
    <br />
</form>

<?php
    // PHP >= 7
    $email = '';
    function str_rand(int $length = 32) {
        //$ascii_codes = str_split('1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz');
        $ascii_temp= range(48, 57) + range(65, 90);
        $ascii_codes = array_merge($ascii_temp, range(97, 122));
        $codes_lenght = (count($ascii_codes)-1);
        shuffle($ascii_codes);
        $string = '';
        for($i = 1; $i <= $length; $i++){
            $previous_char = $char ?? '';
            $char = chr($ascii_codes[random_int(0, $codes_lenght)]);
            while($char == $previous_char){
                $char = chr($ascii_codes[random_int(0, $codes_lenght)]);
            }
            $string .= $char;
        }
        return $string;
    }
    if ($index == 1) {
    ?>
        <script>
            document.getElementById('myForm').style.display = 'none';
        </script>
    <?php
    }
    else {
        ?>
        <script>
            document.getElementById('name').focus();
        </script>
    <?php
    }
    ?>
</body>
</html>
