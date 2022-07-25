<?php
switch ($st) {
	case "spa":
		// VD already there.
		break;
	case "eng":
		if ($VD == "alfabeto tradicional") $VD = "traditional alphabet";
		if ($VD == "alfabeto nuevo") $VD = "new alphabet";
		if ($VD == "edição-Brasil") $VD = "Brazil edition";
		if ($VD == "edición-Perú") $VD = "Peru edition";
		if ($VD == "edición-Colombia") $VD = "Colombia edition";
		if ($VD == "ortografía alternativa") $VD = "alternative orthography";
		break;
	case "por":
		break;
	case "fre":
		break;
	case "dut":
		break;
}
?>