<?php
	// get the TryISO parameter from URL
	if (isset($_GET["iso"])) $TryISO = $_GET["iso"]; else { die('Hack!'); }
	include './include/conn.inc.php';
	$db = get_my_db();
	if (strlen($TryISO) > 0) {
		$query="SELECT DISTINCT ISO FROM scripture_main ORDER BY ISO";
		$result=$db->query($query);
		//$num=mysql_num_rows($result);
		$hint = "";
		//$i=0;
		while ($r = $result->fetch_array()) {
			$iso = $r['ISO'];
			if ($TryISO == substr($iso, 0, strlen($TryISO))) {
				if ($hint == "") {
					$hint = $iso;
				}
				else {
					$hint = $hint . "<br />" . $iso;
				}
			}
			//$i++;
		}
	}

	if ($hint == "" && strlen($TryISO) == 3) {
		$response = "<span id='response' style='font-weight: bold; color: navy; '>Success for ISO.</span>";
//		$inputs['iso'] = $TryISO;
//		$inputs['rod'] = "00000";
//		$inputs['var'] = "";
	}
	elseif (strlen($TryISO) == 3) {
		$response = $hint . "&nbsp;&nbsp;=&gt;&nbsp;&nbsp;" . "<span id='response' style='color: red; font-weight: bold; '>Wrong ISO code!</span>"; 			//But, getting ROD codes now...
	}
	elseif ($hint == "") {
		$response = "<span id='response'>So far, success...</span>";
	}
	else {
		$response = $hint;
	}
	// output the response
	echo $response;
?>