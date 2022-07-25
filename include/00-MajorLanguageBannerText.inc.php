<?php
include './include/nav_ln_array.php';							// Master Array
foreach($nav_ln_array as $code => $array){
	if ($st == $array[0]){
		echo "<li class=\"bottomBannerText\"><a class=\"bottomBannerWord\" href=\"#\" onmouseup=\"loadWindow('".$array[4]."', 'CR', 'Window')\">" . translate('Copyright', $st, 'sys') . "</a></li>";
		echo "<li class=\"bottomBannerText\">|</li>";
		echo "<li class=\"bottomBannerText\"><a class=\"bottomBannerWord\" href=\"#\" onmouseup=\"loadWindow('".$array[4]."', 'TC', 'Window')\">" . translate('Terms and Conditions', $st, 'sys') . "</a></li>";
		echo "<li class=\"bottomBannerText\">|</li>";
		echo "<li class=\"bottomBannerText\"><a class=\"bottomBannerWord\" href=\"#\" onmouseup=\"loadWindow('".$array[4]."', 'P', 'Window')\">" . translate('Privacy', $st, 'sys') . "</a></li>";
		echo "<li class=\"bottomBannerText\">|</li>";
		echo "<li class=\"bottomBannerText\"><a class=\"bottomBannerWord\" href=\"#\" onmouseup=\"loadWindow('".$array[4]."', 'H', 'Window')\">" . translate('Help', $st, 'sys') . "</a></li>";
		echo "<li class=\"bottomBannerText\">|</li>";
		echo "<li class=\"bottomBannerText\"><a class=\"bottomBannerWord\" href=\"#\" onmouseup=\"loadWindow('".$array[4]."', 'CU', 'Window')\">" . translate('Contacts/Links', $st, 'sys') . "</a></li>";
	}
}
?>