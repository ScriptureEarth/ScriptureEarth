<?php
switch ($st) {
	case "eng":
		echo "<li class=\"aboutText\"><a class=\"aboutWord\" href=\"#\" onmouseup=\"loadWindow('i', 'CR', 'Window')\">" . translate('Copyright', $st, 'sys') . "</a></li>";
		echo "<li class=\"aboutText\"><a class=\"aboutWord\" href=\"#\" onmouseup=\"loadWindow('i', 'TC', 'Window')\">" . translate('Terms and Conditions', $st, 'sys') . "</a></li>";
		echo "<li class=\"aboutText\"><a class=\"aboutWord\" href=\"#\" onmouseup=\"loadWindow('i', 'P', 'Window')\">" . translate('Privacy', $st, 'sys') . "</a></li>";
		echo "<li class=\"aboutText\"><a class=\"aboutWord\" href=\"#\" onmouseup=\"loadWindow('i', 'H', 'Window')\">" . translate('Help', $st, 'sys') . "</a></li>";
		echo "<li class=\"aboutText\"><a class=\"aboutWord\" href=\"#\" onmouseup=\"loadWindow('i', 'CU', 'Window')\">" . translate('Contacts/Links', $st, 'sys') . "</a></li>";
		break;
	case "spa":
		echo "<li class=\"aboutText\"><a class=\"aboutWord\" href=\"#\" onmouseup=\"loadWindow('e', 'CR', 'Window')\">" . translate('Copyright', $st, 'sys') . "</a></li>";
		echo "<li class=\"aboutText\"><a class=\"aboutWord\" href=\"#\" onmouseup=\"loadWindow('i', 'TC', 'Window')\">" . translate('Terms and Conditions', $st, 'sys') . "</a></li>";
		echo "<li class=\"aboutText\"><a class=\"aboutWord\" href=\"#\" onmouseup=\"loadWindow('i', 'P', 'Window')\">" . translate('Privacy', $st, 'sys') . "</a></li>";
		echo "<li class=\"aboutText\"><a class=\"aboutWord\" href=\"#\" onmouseup=\"loadWindow('e', 'H', 'Window')\">" . translate('Help', $st, 'sys') . "</a></li>";
		echo "<li class=\"aboutText\"><a class=\"aboutWord\" href=\"#\" onmouseup=\"loadWindow('i', 'CU', 'Window')\">" . translate('Contacts/Links', $st, 'sys') . "</a></li>";
		break;
	case "por":
		echo "<li class=\"aboutText\"><a class=\"aboutWord\" href=\"#\" onmouseup=\"loadWindow('p', 'CR', 'Window')\">Copirraite</a></li>";
		echo "<li class=\"aboutText\"><a class=\"aboutWord\" href=\"#\" onmouseup=\"loadWindow('i', 'TC', 'Window')\">Termos e circunstâncias</a></li>";
		echo "<li class=\"aboutText\"><a class=\"aboutWord\" href=\"#\" onmouseup=\"loadWindow('i', 'P', 'Window')\">Privacidade</a></li>";
		echo "<li class=\"aboutText\"><a class=\"aboutWord\" href=\"#\" onmouseup=\"loadWindow('i', 'H', 'Window')\">Ajuda</a></li>";
		echo "<li class=\"aboutText\"><a class=\"aboutWord\" href=\"#\" onmouseup=\"loadWindow('i', 'CU', 'Window')\">Contate-nos</a></li>";
		break;
	case "fra":
		echo "<li class=\"aboutText\"><a class=\"aboutWord\" href=\"#\" onmouseup=\"loadWindow('f', 'CR', 'Window')\">Droits d'auteur</a></li>";
		echo "<li class=\"aboutText\"><a class=\"aboutWord\" href=\"#\" onmouseup=\"loadWindow('i', 'TC', 'Window')\">Conditions d'utilisation</a></li>";
		echo "<li class=\"aboutText\"><a class=\"aboutWord\" href=\"#\" onmouseup=\"loadWindow('i', 'P', 'Window')\">Confidentialité de l'information</a></li>";
		echo "<li class=\"aboutText\"><a class=\"aboutWord\" href=\"#\" onmouseup=\"loadWindow('i', 'H', 'Window')\">Aide</a></li>";
		echo "<li class=\"aboutText\"><a class=\"aboutWord\" href=\"#\" onmouseup=\"loadWindow('i', 'CU', 'Window')\">Nous contacter</a></li>";
		break;
	case "nld":
		echo "<li class=\"aboutText\"><a class=\"aboutWord\" href=\"#\" onmouseup=\"loadWindow('d', 'CR', 'Window')\">Auteursrecht</a></li>";
		echo "<li class=\"aboutText\"><a class=\"aboutWord\" href=\"#\" onmouseup=\"loadWindow('i', 'TC', 'Window')\">Voorwaarden</a></li>";
		echo "<li class=\"aboutText\"><a class=\"aboutWord\" href=\"#\" onmouseup=\"loadWindow('i', 'P', 'Window')\">Privacy</a></li>";
		echo "<li class=\"aboutText\"><a class=\"aboutWord\" href=\"#\" onmouseup=\"loadWindow('i', 'H', 'Window')\">Hulp</a></li>";
		echo "<li class=\"aboutText\"><a class=\"aboutWord\" href=\"#\" onmouseup=\"loadWindow('i', 'CU', 'Window')\">Neem contact op</a></li>";
		break;
	default:
		echo 'This isn’t supposed to happen! The default MajorLanguageAbout isn’t found.';
		break;
}
?>