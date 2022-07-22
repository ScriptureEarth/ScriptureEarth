<?php
            $stmt_country->bind_param('i', $idx);											// bind parameters for markers
            $stmt_country->execute();														// execute query
            $result_temp = $stmt_country->get_result();
            if ($result_temp->num_rows > 0) {
                $country_count = $result_temp->num_rows;									// 0 or 1
                while ($row_temp = $result_temp->fetch_assoc()) {
                    $country_name[] = $row_temp['English'];
                    $country_code[] = $row_temp['ISO_countries'];
                }
            }

            $first .= '"'.($m-1).'": ';
            $first .= '{"type": "iso",';
            $first .= '"id": "'.$m.'",';
            $first .= '"iso":               "'.$iso.'",';
            $first .= '"rod":				"'.$rod.'",';
            $first .= '"var_code":		   	"'.$var.'",';
            $first .= '"var_name":		   	"'.$var_name.'",';
            $first .= '"iso_query_string":	"sortby=lang&iso='.$iso;
            if ($rod != '00000') {
                $first .= '&rod='.$rod;
            }
            if ($var != '') {
                $first .= '&var='.$var;
            }
            $first .= '",';
            $first .= '"idx":		        '.$idx.',';
            $first .= '"idx_query_string":	"sortby=lang&idx='.$idx.'",';
            $first .= '"ln_OR_alt":         "'.$ln_OR_alt.'",';
            $first .= '"language_name": {';
            $first .= '"english":			"'.$LN_English.'"';
            //$first .= '"spanish":			"'.$LN_Spanish.'",';
            //$first .= '"portuguese":		"'.$LN_Portuguese.'",';
            //$first .= '"french":			"'.$LN_French.'",';
            //$first .= '"dutch":			"'.$LN_Dutch.'",';
            //$first .= '"german":			"'.$LN_German.'",';
            //$first .= '"minority":		""';
            $first .= '},';
            $first .= '"alternate_language_count":		'.$alt_count.',';                              // how many
            $r=0;
            $first .= '"alternate_language_names": {';
            foreach ($alt as $alt_name) {
                $first .= '"'.$r++.'":		"'.$alt_name.'",';
            }
            $first = rtrim($first, ',');
            $first .= '},';
            $first .= '"country_count":		'.$country_count.',';                              		// how many
            $r=0;
            $first .= '"countries_names": {';
            foreach ($country_name as $country) {
                $first .= '"'.$r++.'":		"'.$country.'",';
            }
            $first = rtrim($first, ',');
            $first .= '},';
            $r=0;
            $first .= '"countries_codes": {';
            foreach ($country_code as $country) {
                $first .= '"'.$r++.'":		"'.$country.'",';
            }
            $first = rtrim($first, ',');
            $first .= '}},';
?>