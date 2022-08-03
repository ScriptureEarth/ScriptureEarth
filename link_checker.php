<?php
require_once './include/conn.inc.php';							// connect to the database named 'scripture'
$db = get_my_db();

// Master list of languages for the site to run in
$links = [];
$link_query = "SELECT `URL`, `Links_index`, `ISO`, `Company` FROM `links` ORDER BY `ISO`";
$link_result=$db->query($link_query) or die ('Query failed:  ' . $db->error . '</body></html>');
if ($link_result->num_rows == 0) {
	die ('<div style="background-color: white; color: red; font-size: 16pt; padding-top: 20px; padding-bottom: 20px; margin-top: 200px; ">' . translate('The links are not found.', $st, 'sys') . '</div></body></html>');
}

while ($link_row = $link_result->fetch_array()){
	$temp[0] = $link_row['URL'];
	$temp[1] = $link_row['Company'];
	$temp[2] = $link_row['ISO'];
	$links[$link_row['Links_index']] = $temp;
}
?>
<body>
    <h1>Links that dose not work</h1>
    <?php
    foreach($links as $index => $array){
        // Initialize an URL to the variable
        $url = $array[0];
        
        //echo "<p>".$url."</p>";
    
        // Use condition to check the existence of URL
        if(filter_var($url, FILTER_VALIDATE_URL) === false) {
            $status = "URL doesn't work";
            echo "<p>Status: ".$status.", Language code: ".$array[2].", Company: ".$array[1]."</p>";
        }
    }
    ?>
</body>