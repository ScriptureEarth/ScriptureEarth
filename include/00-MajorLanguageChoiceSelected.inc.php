<?php
	if ($st == "eng") {
		echo '<option selected="selected">English</option>';
	}
	else {
		echo '<option class="languageChoiceDefault" value="Eng">English</option>';
	}
	if ($st == "spa") {
		echo '<option selected="selected">Español</option>';
	}
	else {
		echo '<option class="languageChoiceDefault" value="Spa">Español</option>';
	}
	if ($st == "por") {
		echo '<option selected="selected">Português</option>';
	}
	else {
		echo '<option class="languageChoiceDefault" value="Por">Português</option>';
	}
	if ($st == "fre") {
		echo '<option selected="selected">Français</option>';
	}
	else {
		echo '<option class="languageChoiceDefault" value="Fra">Français</option>';
	}
	if ($st == "dut") {
		echo '<option selected="selected">Nederlands</option>';
	}
	else {
		echo '<option class="languageChoiceDefault" value="Dut">Nederlands</option>';
	}
?>