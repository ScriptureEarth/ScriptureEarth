<?php
/*
  query:
	v=1 -> version
	key=[your key]
		and
	(
		all=justsubfamilies -> only the ISOs of the subfamilies
			or
		all=subfamilies -> all of the elements of the ISOs of the subfamilies
			or
		subfamily=[the particular ISOs/names of the subfamily] e.g. Náhuatl (the ISOs within that subfamily)
	)
*/

$m = $i = $j = 0;
$index = 0;
$all = '';
$subfamily = '';
$first = '';
$marks = [];

/*
	e.g.,
	$stmt_var = $db->prepare("SELECT Variant_Eng FROM Variants WHERE Variant_Code = ?");
	$stmt_var->bind_param('s', $var);														// bind parameters for markers
	$stmt_var->execute();																	// execute query
	$result_temp = $stmt_var->get_result();
	$row_temp = $result_temp->fetch_assoc();
	$Variant_name = $row_temp['Variant_Eng'];
*/

require_once '../include/conn.inc.php';														// connect to the database named 'scripture'
$db = get_my_db();

include 'include/v.key.php';																// get v and key

if (isset($_GET['all'])) {
	$all = $_GET['all'];																	// only the ISOs of the subfamilies
	if ($all == 'justsubfamilies') {
		$index = 1;
		$stmt_subfamilies = $db->prepare("SELECT `subfamily`, `multipleCountries`, `countryCodes` FROM `subfamilies` WHERE `ISO` = '' ORDER BY `subfamily`");
		$stmt_subfamilies->execute();															// execute query
		$result_subfamilies = $stmt_subfamilies->get_result();
	}
	elseif ($all == 'subfamilies') {															// all subfamilies
		$index = 3;
		$stmt_subfamilies = $db->prepare("SELECT `subfamily`, `multipleCountries`, `countryCodes` FROM `subfamilies` WHERE `ISO` = '' ORDER BY `subfamily`");
		$stmt_subfamilies->execute();															// execute query
		$result_subfamilies = $stmt_subfamilies->get_result();
		if ($result_subfamilies->num_rows === 0) {
			die('subfamilies table does not have empty ISO\'s.');
		}
		$stmt_subfamily = $db->prepare("SELECT ISO, ROD_Code, Variant_Code, ISO_ROD_index, `subfamily`, LN_English, multipleCountries, countryCodes FROM `subfamilies` WHERE  `subfamily` = ? AND LN_English <> '' ORDER BY `subfamily`, `ISO`, `ROD_Code`");
		//$stmt_countries = $db->prepare("SELECT countries.English FROM countries, ISO_Lang_Countries WHERE countries.ISO_Country = ISO_Lang_Countries.ISO_Country AND ISO_Lang_Countries.ISO = ?");
		$stmt_english_country = $db->prepare("SELECT English FROM countries WHERE ISO_Country = ?");
		$stmt_var = $db->prepare("SELECT Variant_Eng FROM Variants WHERE Variant_Code = ?");
	}
	else {
		die('Suspicious activity!');
	}
}
elseif (isset($_GET['subfamily'])) {															// a subfamily
	$subfamily = $_GET['subfamily'];
	$index = 2;
	$stmt_subfamilies = $db->prepare("SELECT `multipleCountries`, `countryCodes` FROM `subfamilies` WHERE `subfamily` = '$subfamily' AND `ISO` = '' ORDER BY `subfamily`");
	$stmt_subfamilies->execute();																// execute query
	$result_subfamilies = $stmt_subfamilies->get_result();
	if ($result_subfamilies->num_rows === 0) {
		die('subfamilies table does not have empty ISO\'s within the '.$subfamily.' subfamily.');
	}
	$stmt_subfamily = $db->prepare("SELECT ISO, ROD_Code, Variant_Code, ISO_ROD_index, LN_English, multipleCountries, countryCodes FROM `subfamilies` WHERE `subfamily` = '$subfamily' AND LN_English <> '' ORDER BY `ISO`, `ROD_Code`");
	$stmt_subfamily->execute();																// execute query
	$result_subfamily = $stmt_subfamily->get_result();
	//$stmt_countries = $db->prepare("SELECT countries.English FROM countries, ISO_Lang_Countries WHERE countries.ISO_Country = ISO_Lang_Countries.ISO_Country AND ISO_Lang_Countries.ISO = ?");
	$stmt_english_country = $db->prepare("SELECT English FROM countries WHERE ISO_Country = ?");
	$stmt_var = $db->prepare("SELECT Variant_Eng FROM Variants WHERE Variant_Code = ?");
}
else {
	die('Suspicious activity!');
}

if ($index == 1) {																			// just subfamilies
	$m = 1;
	$first = '{ "just_subfamilies": {';
	while ($row_subfamilies=$result_subfamilies->fetch_assoc()) {
		$subfamily=trim($row_subfamilies['subfamily']);
		$first .= '"'.($m-1).'": ';
		$first .= '{"subfamily": "'.$subfamily.'"},';
		$m++;
	}
	$first = rtrim($first, ',');
	$first .= '}}';
}
elseif ($index == 2) {																		// one subfamily
	$first = '{';
	$first .= '"'.$subfamily.'": {';
	$row_subfamilies = $result_subfamilies->fetch_assoc();
	$subfamilyCountryCodes = $row_subfamilies['countryCodes'];
	$countryCodesArray = explode(' ', $subfamilyCountryCodes);								// convert string to array using ' '
	$first .= '"total_countries": {';
	$j = 1;
	$englishCountry = '';
	foreach ($countryCodesArray as $countryCodes) {											// iterate through array
		$first .= '"'.($j-1).'": {';
		$first .= '"country_code": "'.$countryCodes.'",';
		$stmt_english_country->bind_param('s', $countryCodes);								// bind parameters for markers
		$stmt_english_country->execute();													// execute query
		$result_english_country = $stmt_english_country->get_result();
		if ($result_english_country->num_rows === 0) {
			$englishCountry = '';
		}
		else {
			$row_english_country = $result_english_country->fetch_assoc();
			$englishCountry = $row_english_country['English'];
		}
		$first .= '"country_name": "'.$englishCountry.'"},';
		$j++;
	}
	$first = rtrim($first, ',');
	$first .= '},';
	$first .= '"languages": {';
	$m = 0;
	while ($row = $result_subfamily->fetch_assoc()) {
		$m++;
		$iso = $row['ISO'];
		$rod = $row['ROD_Code']; 
		$var = $row['Variant_Code'];
		$idx = $row['ISO_ROD_index'];
		$LN_English = $row['LN_English'];
		//$multipleCountries = $row['multipleCountries'];
		$countryCodes = $row['countryCodes'];
		$Variant_name = '';
		if ($var != '') {
			$stmt_var->bind_param('s', $var);												// bind parameters for markers
			$stmt_var->execute();															// execute query
			$result_temp = $stmt_var->get_result();
			$row_temp = $result_temp->fetch_assoc();
			$Variant_name = $row_temp['Variant_Eng'];
		}
		
		$first .= '"'.($m-1).'": {';
		$first .= '"language_code":';
		$first .= '{';
		$first .= '"iso":				"'.$iso.'",';
		$first .= '"rod":				"'.$rod.'",';
		$first .= '"var_code":		   	"'.$var.'",';
		$first .= '"var_name":			"'.$Variant_name.'",';
		$first .= '"iso_query_string":	"iso='.$iso;
		if ($rod != '00000') {
			$first .= '&rod='.$rod;
		}
		if ($var != '') {
			$first .= '&var='.$var;
		}
		$first .= '",';
		$first .= '"idx":		        '.$idx.',';
		$first .= '"idx_query_string":	"idx='.$idx.'"},';
		$first .= '"language_name": {';
		$first .= '"English":			"'.$LN_English.'"},';
		$first .= '"countries":	{';
		$subfamilyCountryCodes = $row_subfamilies['countryCodes'];
		$countryCodesArray = explode(' ', $subfamilyCountryCodes);							// convert string to array using ' '
		$j = 1;
		$englishCountry = '';
		foreach ($countryCodesArray as $countryCodes) {										// iterate through array
			$first .= '"'.($j-1).'": ';
			$first .= '{"country_code": "'.$countryCodes.'",';
			$stmt_english_country->bind_param('s', $countryCodes);							// bind parameters for markers
			$stmt_english_country->execute();												// execute query
			$result_english_country = $stmt_english_country->get_result();
			if ($result_english_country->num_rows === 0) {
				$englishCountry = '';
			}
			else {
				$row_english_country = $result_english_country->fetch_assoc();
				$englishCountry = $row_english_country['English'];
			}
			$first .= '"country_name": "'.$englishCountry.'"},';
			$j++;
		}
		$first = rtrim($first, ',');
		$first .= '}},';
	}
	$first = rtrim($first, ',');
	$first .= '}}}';
}
elseif ($index == 3) {																		// all subfamilies
	$i = 1;
	$first = '{ "all_subfamilies": {';
	while ($row_subfamilies = $result_subfamilies->fetch_assoc()) {
		$subfamily = $row_subfamilies['subfamily'];
		$first .= '"'.($i-1).'": {';
		$first .= '"'.$subfamily.'": {';
		$subfamilyCountryCodes = $row_subfamilies['countryCodes'];
		$countryCodesArray = explode(' ', $subfamilyCountryCodes);							// convert string to array using ' '
		$first .= '"total_countries": {';
		$j = 1;
		$englishCountry = '';
		foreach ($countryCodesArray as $countryCodes) {										// iterate through array
			$first .= '"'.($j-1).'": ';
			$first .= '{"country_code": "'.$countryCodes.'",';
			$stmt_english_country->bind_param('s', $countryCodes);							// bind parameters for markers
			$stmt_english_country->execute();												// execute query
			$result_english_country = $stmt_english_country->get_result();
			if ($result_english_country->num_rows === 0) {
				$englishCountry = '';
			}
			else {
				$row_english_country = $result_english_country->fetch_assoc();
				$englishCountry = $row_english_country['English'];
			}
			$first .= '"country_name": "'.$englishCountry.'"},';
			$j++;
		}
		$first = rtrim($first, ',');
		$first .= '},';
		$first .= '"languages": {';
		$m = 0;
		$stmt_subfamily->bind_param('s', $subfamily);											// bind parameters for markers
		$stmt_subfamily->execute();															// execute query
		$result_subfamily = $stmt_subfamily->get_result();
		while ($row = $result_subfamily->fetch_assoc()) {
			$m++;
			$iso = $row['ISO'];
			$rod = $row['ROD_Code']; 
			$var = $row['Variant_Code'];
			$idx = $row['ISO_ROD_index'];
			$LN_English = $row['LN_English'];
			//$multipleCountries = $row['multipleCountries'];
			$countryCodes = $row['countryCodes'];
			$Variant_name = '';
			if ($var != '') {
				$stmt_var->bind_param('s', $var);											// bind parameters for markers
				$stmt_var->execute();														// execute query
				$result_temp = $stmt_var->get_result();
				$row_temp = $result_temp->fetch_assoc();
				$Variant_name = $row_temp['Variant_Eng'];
			}
			
			$first .= '"'.($m-1).'": {';
			$first .= '"language_code":';
			$first .= '{';
			$first .= '"iso":				"'.$iso.'",';
			$first .= '"rod":				"'.$rod.'",';
			$first .= '"var_code":		   	"'.$var.'",';
			$first .= '"var_name":			"'.$Variant_name.'",';
			$first .= '"iso_query_string":	"iso='.$iso;
			if ($rod != '00000') {
				$first .= '&rod='.$rod;
			}
			if ($var != '') {
				$first .= '&var='.$var;
			}
			$first .= '",';
			$first .= '"idx":		        '.$idx.',';
			$first .= '"idx_query_string":	"idx='.$idx.'"},';
			$first .= '"language_name": {';
			$first .= '"English":			"'.$LN_English.'"},';
			$first .= '"countries":	{';
			$subfamilyCountryCodes = $row_subfamilies['countryCodes'];
			$countryCodesArray = explode(' ', $subfamilyCountryCodes);						// convert string to array using ' '
			$j = 1;
			$englishCountry = '';
			foreach ($countryCodesArray as $countryCodes) {									// iterate through array
				$first .= '"'.($j-1).'": ';
				$first .= '{"country_code": "'.$countryCodes.'",';
				$stmt_english_country->bind_param('s', $countryCodes);						// bind parameters for markers
				$stmt_english_country->execute();											// execute query
				$result_english_country = $stmt_english_country->get_result();
				if ($result_english_country->num_rows === 0) {
					$englishCountry = '';
				}
				else {
					$row_english_country = $result_english_country->fetch_assoc();
					$englishCountry = $row_english_country['English'];
				}
				$first .= '"country_name": "'.$englishCountry.'"},';
				$j++;
			}
			$first = rtrim($first, ',');
			$first .= '}},';
		}
		$first = rtrim($first, ',');
		$first .= '}}},';
		$i++;
	}
	$first = rtrim($first, ',');
	$first .= '}}';
}
else {
	
}

//echo $first;
//exit;

$marks = json_decode($first);																// convert a JSON encoded string into a PHP array

header('Content-Type: application/json');													// instead of <pre></pre>
// An associative array
$json_string = json_encode($marks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);				// encode an associative array into a JSON object

echo $json_string;

// all done!

function removeDiacritics($txt) {
    $transliterationTable = [
		'à' => 'a', 'À' => 'A', 'á' => 'a', 'Á' => 'A', 'â' => 'a', 'Â' => 'A', 'ä' => 'a', 'Ä' => 'A', 'ā' => 'a', 'Ã' => 'A', 'å' => 'a', 'Å' => 'A', 'æ' => 'ae', 'Æ' => 'AE', 'ǣ' => 'ae', 'Ǣ' => 'AE',
		'ç' => 'c', 'Ç' => 'C',
		'�' => 'D', '�' => 'dh', '�' => 'Dh',
		'é' => 'e', 'É' => 'E', 'è' => 'e', 'È' => 'E', 'ë' => 'e', 'Ë' => 'E', 'ē' => 'e', 'Ê' => 'E',
		'ī' => 'i', '�' => 'I', 'í' => 'i', '�' => 'I', 'ì' => 'i', '�' => 'I', 'ï' => 'i', '�' => 'I',
		'ñ' => 'n', 'Ñ' => 'N',
		'ō' => 'o', '�' => 'O', 'ó' => 'o', '�' => 'O', 'ò' => 'o', '�' => 'O', 'ö' => 'o', '�' => 'O', '�' => 'oe', '�' => 'OE', 'œ' => 'oe', 'Œ' => 'OE',
		'ś' => 's', 'Ś' => 'S', '�' => 'SS',
		'ū' => 'u', '�' => 'U', 'ú' => 'u', '�' => 'U', 'ù' => 'u', '�' => 'U', '�' => 'ue', '�' => 'UE',
		'ŷ' => 'y', 'Ŷ' => 'Y', 'ÿ' => 'y', 'Ÿ' => 'Y',
		'ź' => 'z', 'Ź' => 'Z'
	];
	return strtr($txt, $transliterationTable);
}    // or, return str_replace(array_keys($transliterationTable), array_values($transliterationTable), $txt);


// Author: 'ChickenFeet'
function CheckLetters($field){
    $letters = [
        0 => "a à á â ä æ ã å ā",
        1 => "c ç ć č",
        2 => "e é è ê ë ę ė ē",
        3 => "i ī į í ì ï î",
        4 => "l ł",
        5 => "n ñ ń",
        6 => "o ō ø œ õ ó ò ö ô",
        7 => "s ß ś š",
        8 => "u ū ú ù ü û",
        9 => "w ŵ",
        10 => "y ŷ ÿ",
        11 => "z ź ž ż"
    ];
    foreach ($letters as &$values){
        $newValue = substr($values, 0, 1);
        $values = substr($values, 2, strlen($values));
        $values = explode(' ', $values);
        foreach ($values as &$oldValue){
            while (strpos($field, $oldValue) !== false){
                $field = preg_replace('/' . $oldValue . '/', $newValue, $field, 1);
            }
        }
    }
    return $field;
}
?>
