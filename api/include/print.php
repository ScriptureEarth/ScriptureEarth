<?php
		$first .= '"'.($m-1).'": ';
		$first .= '{"type": "iso",';
		$first .= '"id": "'.$m.'",';
		$first .= '"attributes": {';
		$first .= '"iso": "'.$iso.'",';
		$first .= '"num_nav":			6,';
		$first .= '"navigation": {';
		$first .= '"english":			"00eng.php",';
		$first .= '"spanish":			"00spa.php",';
		$first .= '"portugues":			"00por.php",';
		$first .= '"french":			"00fra.php",';
		$first .= '"dutch":				"00nld.php",';
		$first .= '"german":			"00deu.php",';
		$first .= '"chinese":			"00cmn.php",';
		$first .= '"korean":			"00kor.php"';
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
		$first .= '"english":			"'.$LN_English.'",';
		$first .= '"spanish":			"'.$LN_Spanish.'",';
		$first .= '"portuguese":		"'.$LN_Portuguese.'",';
		$first .= '"french":			"'.$LN_French.'",';
		$first .= '"dutch":				"'.$LN_Dutch.'",';
		$first .= '"german":			"'.$LN_German.'",';
		$first .= '"chinese":			"'.$LN_Chinese.'",';
		$first .= '"korean":			"'.$LN_Korean.'",';
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