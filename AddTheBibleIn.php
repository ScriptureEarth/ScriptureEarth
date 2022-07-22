<?php
	include("conn.php");		
	// connect to the database 

	$query="SELECT ISO, ROD_Code FROM scripture_main";
	$result_Temp=mysql_query($query);
	if (!$result_Temp || (mysql_num_rows($result_Temp) < 1)) {
		die("Error. scripture_main does not exists.");
	}
	
	$num = mysql_num_rows($result_Temp);
	$i = 0;
	
	while ($i < $num) {
		$ISO = mysql_result($result_Temp,$i,"ISO");
		$ROD_Code = mysql_result($result_Temp,$i,"ROD_Code");
		$query="SELECT ISO_countries FROM ISO_countries WHERE ISO = '$ISO' AND ROD_Code = '$ROD_Code'";
		$result=mysql_query($query);
		if (!$result || (mysql_num_rows($result) < 1)) {
		}
		else {
			$ISO_countries = mysql_result($result,0,"ISO_countries");
			if ($ISO_countries == "MX") {
				$query="UPDATE scripture_main SET AddTheBibleIn = 1 WHERE ISO = '$ISO' AND ROD_Code = '$ROD_Code'";
				$result_alt=mysql_query($query);
				if (!$result_alt) {
					die("Error. UPDATE scripture_main does not exists.");
				}
				echo "UPDATE scripture_main SET AddTheBibleIn = 1 WHERE ISO = '$ISO' AND ROD_Code = '$ROD_Code'<br />";
			}
		}
		$i++;
	}
?>