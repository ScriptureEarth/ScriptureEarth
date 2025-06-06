<?php
/*
  query:
	v=1 -> version
	key=[your key]
		and
	(
		all=justdialects -> just the dialect names only
			or
		all=dialects -> all of the dialects
			or
		dialect=[the particular name of the dialect]
	)
*/

$m = $i = $j = 0;
$index = 0;
$all = '';
$dialect = '';
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
	$all = $_GET['all'];																	// just the name of the dialects
	if ($all == 'justdialects') {
		$index = 1;
		$stmt_dialects = $db->prepare("SELECT `dialect`, `multipleCountries`, `countryCodes` FROM `dialects` WHERE `ISO` = '' ORDER BY `dialect`");
		$stmt_dialects->execute();															// execute query
		$result_dialects = $stmt_dialects->get_result();
	}
	elseif ($all == 'dialects') {															// all dialects
		$index = 3;
		$stmt_dialects = $db->prepare("SELECT `dialect`, `multipleCountries`, `countryCodes` FROM `dialects` WHERE `ISO` = '' ORDER BY `dialect`");
		$stmt_dialects->execute();															// execute query
		$result_dialects = $stmt_dialects->get_result();
		if ($result_dialects->num_rows === 0) {
			die('dialects table does not have empty ISO\'s.');
		}
		$stmt_dialect = $db->prepare("SELECT ISO, ROD_Code, Variant_Code, ISO_ROD_index, `dialect`, LN_English, multipleCountries, countryCodes FROM `dialects` WHERE  `dialect` = ? AND LN_English <> '' ORDER BY `dialect`, `ISO`, `ROD_Code`");
		//$stmt_countries = $db->prepare("SELECT countries.English FROM countries, ISO_Lang_Countries WHERE countries.ISO_Country = ISO_Lang_Countries.ISO_Country AND ISO_Lang_Countries.ISO = ?");
		$stmt_english_country = $db->prepare("SELECT English FROM countries WHERE ISO_Country = ?");
		$stmt_var = $db->prepare("SELECT Variant_Eng FROM Variants WHERE Variant_Code = ?");
	}
	else {
		die('Suspicious activity!');
	}
}
elseif (isset($_GET['dialect'])) {															// a dialect
	$dialect = $_GET['dialect'];
	$index = 2;
	$stmt_dialects = $db->prepare("SELECT `multipleCountries`, `countryCodes` FROM `dialects` WHERE `dialect` = '$dialect' AND `ISO` = '' ORDER BY `dialect`");
	$stmt_dialects->execute();																// execute query
	$result_dialects = $stmt_dialects->get_result();
	if ($result_dialects->num_rows === 0) {
		die('dialects table does not have empty ISO\'s within the '.$dialect.' dialect.');
	}
	$stmt_dialect = $db->prepare("SELECT ISO, ROD_Code, Variant_Code, ISO_ROD_index, LN_English, multipleCountries, countryCodes FROM `dialects` WHERE `dialect` = '$dialect' AND LN_English <> '' ORDER BY `ISO`, `ROD_Code`");
	$stmt_dialect->execute();																// execute query
	$result_dialect = $stmt_dialect->get_result();
	//$stmt_countries = $db->prepare("SELECT countries.English FROM countries, ISO_Lang_Countries WHERE countries.ISO_Country = ISO_Lang_Countries.ISO_Country AND ISO_Lang_Countries.ISO = ?");
	$stmt_english_country = $db->prepare("SELECT English FROM countries WHERE ISO_Country = ?");
	$stmt_var = $db->prepare("SELECT Variant_Eng FROM Variants WHERE Variant_Code = ?");
}
else {
	die('Suspicious activity!');
}

if ($index == 1) {																			// just dialects
	$m = 1;
	$first = '{ "just_dialects": {';
	while ($row_dialects=$result_dialects->fetch_assoc()) {
		$dialect=trim($row_dialects['dialect']);
		$first .= '"'.($m-1).'": ';
		$first .= '{"dialect": "'.$dialect.'"},';
		$m++;
	}
	$first = rtrim($first, ',');
	$first .= '}}';
}
elseif ($index == 2) {																		// one dialect
	$first = '{';
	$first .= '"'.$dialect.'": {';
	$row_dialects = $result_dialects->fetch_assoc();
	$dialectCountryCodes = $row_dialects['countryCodes'];
	$countryCodesArray = explode(' ', $dialectCountryCodes);								// convert string to array using ' '
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
	while ($row = $result_dialect->fetch_assoc()) {
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
		$dialectCountryCodes = $row_dialects['countryCodes'];
		$countryCodesArray = explode(' ', $dialectCountryCodes);							// convert string to array using ' '
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
elseif ($index == 3) {																		// all dialects
	$i = 1;
	$first = '{ "all_dialects": {';
	while ($row_dialects = $result_dialects->fetch_assoc()) {
		$dialect = $row_dialects['dialect'];
		$first .= '"'.($i-1).'": {';
		$first .= '"'.$dialect.'": {';
		$dialectCountryCodes = $row_dialects['countryCodes'];
		$countryCodesArray = explode(' ', $dialectCountryCodes);							// convert string to array using ' '
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
		$stmt_dialect->bind_param('s', $dialect);											// bind parameters for markers
		$stmt_dialect->execute();															// execute query
		$result_dialect = $stmt_dialect->get_result();
		while ($row = $result_dialect->fetch_assoc()) {
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
			$dialectCountryCodes = $row_dialects['countryCodes'];
			$countryCodesArray = explode(' ', $dialectCountryCodes);						// convert string to array using ' '
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
