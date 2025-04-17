<?php
		$first .= '"'.($m-1).'": ';
		$first .= '{"type": "iso",';
		$first .= '"id": "'.$m.'",';
		$first .= '"attributes": {';
		$first .= '"iso": "'.$iso.'",';
		$first .= '"num_nav":			9,';
		$first .= '"navigation": {';
		$first .= '"English":			"00eng.php",';
		$first .= '"Spanish":			"00spa.php",';
		$first .= '"Portugues":			"00por.php",';
		$first .= '"French":			"00fra.php",';
		$first .= '"Dutch":				"00nld.php",';
		$first .= '"German":			"00deu.php",';
		$first .= '"Chinese":			"00cmn.php",';
		$first .= '"Korean":			"00kor.php",';
		$first .= '"Russian":			"00rus.php",';
		$first .= '"Arabic":			"00arb.php"';
		$first .= '}';
		$first .= '},';
		$first .= '"relationships":';
		$first .= '{';
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
        $first .= '"idx_query_string":	"idx='.$idx.'",';
		$first .= '"language_name": {';
		$first .= '"English":			"'.$LN_English.'",';
		$first .= '"Spanish":			"'.$LN_Spanish.'",';
		$first .= '"Portuguese":		"'.$LN_Portuguese.'",';
		$first .= '"French":			"'.$LN_French.'",';
		$first .= '"Dutch":				"'.$LN_Dutch.'",';
		$first .= '"German":			"'.$LN_German.'",';
		$first .= '"Chinese":			"'.$LN_Chinese.'",';
		$first .= '"Korean":			"'.$LN_Korean.'",';
		$first .= '"Russian":			"'.$LN_Russian.'",';
		$first .= '"Arabic":			"'.$LN_Arabic.'",';
		$first .= '"minority":			""';
		$first .= '},';
		$first .= '"alternate_language_count":		'.$alt_ln.',';                              // how many
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
		$first .= '},';
		$first .= '"se_apps": {';
		$first .= '"android":			'.$AndroidAppCellNum.',';								// download from SE
		$first .= '"ios":				'.$AppleAppCellNum;										// download from SE
		$first .= '},';
		$first .= '"se_sab": {';
		$first .= '"text":				'.$SAB_Text.',';
		$first .= '"audio":				'.$SAB_Audio.',';
		$first .= '"video":				'.$SAB_Video;
		$first .= '},';
		$first .= '"se_online_viewer":	'.$viewer.',';
		$first .= '"se_media": {';
		$first .= '"text":				'.($OT_PDF + $NT_PDF).',';
		$first .= '"ePub":				'.$ePubCellNum.',';
		$first .= '"audio": 			'.($OT_Audio + $NT_Audio).',';
		$first .= '"video":				0,';
		$first .= '"playlist_audio":	'.$PlaylistAudio.',';									// .txt
		$first .= '"playlist_video":	'.$PlaylistVideo;										// .txt
		$first .= '},';
		$first .= '"se_download_media": {';
		$first .= '"text":				'.($OT_PDF + $NT_PDF).',';
		$first .= '"audio": 			'.($OT_Audio + $NT_Audio).',';
		$first .= '"video":				0,';
		$first .= '"playlist_video":	'.$PlaylistVideoDownload;
		$first .= '},';
		$first .= '"se_google_play":	'.$GooglePlay.',';
		$first .= '"se_other_software": {';
		$first .= '"GoBible":			'.$GoBibleNum.',';
		$first .= '"MySword":			'.$MySwordNum.',';
		$first .= '"theWord":			'.$study;
		$first .= '},';
		$first .= '"links_media": {';
		$first .= '"Bible.is":			'.$BibleIs.',';
		$first .= '"Bible.is_Gospel_Film":	'.$BibleIsGospelFilm.',';
		$first .= '"YouVersion":		'.$YouVersion.',';
		$first .= '"eBible":			'.$eBible.',';
		$first .= '"GRN":				'.$GRN;
		$first .= '},';
		$first .= '"buy":				'.$buy.',';
		$first .= '"maps":				'.$map.',';
		$first .= '"watch":				'.$watch.',';
		$first .= '"websites":			'.$websites.',';
		$first .= '"other_titles":		'.$other_titles.',';
		$first .= '"SIL_link":			'.$SILlink;
		$first .= '}},';
?>