<?php

$index = 0;
$marks = [];

require_once '../include/conn.inc.php';															// connect to the database named 'scripture'
$db = get_my_db();

include 'include/v.key.php';																	// get v and key

$country = '';
if (isset($_GET['pc'])) {
	$country = $_GET['pc'];
	if (strlen($country) < 2) {
        $marks = json_decode('{"error": "country is less that three letters."}');
        header('Content-Type: application/json');
        echo json_encode($marks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        exit;
	}
}
else {
	$marks = json_decode('{"error": "Please provide a partial country name. For example, if you want to pull the record(s) for the Mexico, you can use \'?pc=Mex\'."}');
	header('Content-Type: application/json');
	echo json_encode($marks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
	exit;
}

$SpecificCountry = 'English';
if (isset($_GET['ml'])) {
	$SpecificCountry = $_GET['ml'];
    // ISO_Country
	if ($SpecificCountry == 'English' || $SpecificCountry == 'Spanish' || $SpecificCountry == 'Portuguese' || $SpecificCountry == 'French' || $SpecificCountry == 'Dutch' || $SpecificCountry == 'German' || $SpecificCountry == 'Chinese' || $SpecificCountry == 'Korean' || $SpecificCountry == 'Russian' || $SpecificCountry == 'Arabic') {
	}
    else {
        $marks = json_decode('{"error": "A navigational language is not found."}');
        header('Content-Type: application/json');
        echo json_encode($marks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        exit;
    }
}

$query="SELECT ISO_Country, ISO_ROD_index, ISO, ROD_Code, Variant_Code, $SpecificCountry FROM countries, ISO_countries WHERE countries.ISO_Country = ISO_countries.ISO_countries AND countries.$SpecificCountry RLIKE '(^|[- \(]+)$country' ORDER BY $SpecificCountry";		// create a prepared statement; RLIKE '(^|[- \(]+)$country' equals REGEX the parial $country at the beggining of the line OR the line with -, "space", ")" at the beginning a of word.
$result=$db->query($query) or die ('Query failed: ' . $db->error);
if ($result->num_rows <= 0) {
	$marks = json_decode('{"error": "The partial "'.$country.'" could not be found."}');
	header('Content-Type: application/json');
	echo json_encode($marks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
	exit;
}

$stmt = $db->prepare("SELECT LN_English FROM LN_English WHERE ISO_ROD_index = ?");
$stmt_alt = $db->prepare("SELECT DISTINCT alt_lang_name FROM alt_lang_names WHERE ISO_ROD_index = ?");

$m=0;
$first = '{';
while ($row = $result->fetch_assoc()) {
    $iso = $row['ISO'];
    $rod = $row['ROD_Code'];
    $var = $row['Variant_Code'];
    $Variant_name = '';
    if ($var != '') {
        $stmt_var->bind_param('s', $var);													// bind parameters for markers
        $stmt_var->execute();																// execute query
        $result_temp = $stmt_var->get_result();
        $row_temp = $result_temp->fetch_assoc();
        $Variant_name = $row_temp['Variant_Eng'];
    }
    $idx = $row['ISO_ROD_index'];
    $fullCountry = $row["$SpecificCountry"];
    $country_Code = $row['ISO_Country'];

    $alt_ln = 0;
    $alt = '';
    $stmt_alt->bind_param('i', $idx);											    	        // bind parameters for markers
    $stmt_alt->execute();																    	// execute query
    $result_alt = $stmt_alt->get_result();
    if ($result_alt->num_rows > 0) {
        $alt_ln = $result_alt->num_rows;													    // 0 or 1
        while ($row_alt = $result_alt->fetch_assoc()) {
            $alt .= $row_alt['alt_lang_name'] . ', ';
        }
        $alt = rtrim($alt, ', ');
    }
    
    //$query = "SELECT LN_$SpecificCountry FROM LN_$SpecificCountry WHERE ISO_ROD_index = $idx";
    $stmt->bind_param('i', $idx);							                	                // bind parameters for markers
	$stmt->execute();													                        // execute query
	$result_LN = $stmt->get_result();
    if ($result_LN->num_rows <= 0) {
    	$marks = json_decode('{"error": "The idx "'.$idx.'" for iso "'.$iso.'" is not found."}');
        header('Content-Type: application/json');
        echo json_encode($marks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        exit;
    }
    $row_LN = $result_LN->fetch_assoc();
    $LN = $row_LN["LN_English"];
    $m++;

    $first .= '"'.($m-1).'": ';
    $first .= '{"type":                     "Partial Countries",';
    $first .= '"id":                        "'.$m.'",';
    $first .= '"country":                   "'.$fullCountry.'",';
    $first .= '"country_code":              "'.$country_Code.'",';
    $first .= '"relationships": {';
    $first .= '"iso":                       "'.$iso.'",';
    $first .= '"rod":				        "'.$rod.'",';
    $first .= '"var_code":		    	    "'.$var.'",';
    $first .= '"var_name":			        "'.$Variant_name.'",';
    $first .= '"iso_query_string":	        "iso='.$iso;
    if ($rod != '00000') {
        $first .= '&rod='.$rod;
    }
    if ($var != '') {
        $first .= '&var='.$var;
    }
    $first .= '",';
    $first .= '"idx":		                '.$idx.',';
    $first .= '"idx_query_string":          "idx='.$idx.'",';
    $first .= '"English_language_name":     "'.$LN.'",';
    $first .= '"alternate_language_number":	'.$alt_ln.',';                                  // how many
    $first .= '"alternate_language_names":  "'.$alt.'"';
    $first .= '}},';
}
$first = rtrim($first, ',');
$first .= '}';

$marks = [];
$marks = json_decode($first);
//echo $first;

header('Content-Type: application/json');														// instead of <pre></pre>
// An associative array
$json_string = json_encode($marks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
//echo '<pre>'.$json_string.'</pre>';
echo $json_string;

?>
