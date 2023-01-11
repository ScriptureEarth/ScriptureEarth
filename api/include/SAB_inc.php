	<?php
    // SAB
	/*
		$SAB (bitwise):
			decimal		binary		meaning
			1			000001		NT Synchronized text and audio
			2			000010		OT Synchronized text and audio
			4			000100		NT Synchronized audio where available
			8			001000		OT Synchronized audio where available
			16			010000		NT View text only
			32			100000		OT View text only
			
			Scriptoria needs help on audio
	*/
	$db->query("DELETE FROM SAB WHERE ISO_ROD_index = $idx AND SAB_number = $SAB_number");
    $SAB_Path = './data/'.$iso.'/sab/'.$subfolder;
//echo 'SAB_Path = ' . $SAB_Path . '<br /><br />';
    $query="INSERT INTO SAB (ISO, ROD_Code, Variant_Code, ISO_ROD_index, Book_Chapter_HTML, SAB_Book, SAB_Chapter, SAB_Audio, SAB_number) VALUES ('$iso', '$rod', '$var', $idx, ?, ?, ?, 0, $SAB_number)";
    $stmt_SAB=$db->prepare($query);
    $SAB_array = glob($SAB_Path.'/*.html');
    if (empty($SAB_array) === false) {																	// there are html files here
        foreach ($SAB_array as $SAB_record) {															// $SAB_array = glob($SAB_Path.'*.html'). e.g. "tuoC-02-GEN-001.html"
            $SAB_record = substr($SAB_record, strrpos($SAB_record, '/')+1);								// gets rids of directories. strrpos - returns the poistion of the last occurrence of the substring
            if (preg_match('/-([0-9]+)-[A-Z0-9][A-Z]{2}-/', $SAB_record, $match)) {
                //echo $SAB_record . '<br />';
            }
            else {
                continue;
            }
            $book_number = (int)$match[1];
            preg_match('/-([0-9]+)\.html/', $SAB_record, $match);
            $chapter = (int)$match[1];
            $stmt_SAB->bind_param("sii", $SAB_record, $book_number, $chapter);							// bind parameters for markers
            $stmt_SAB->execute();
        }
    }
    else {
        ?>
        <script>
            text += "\r\nAlso, no HTML files found in <?php echo $SAB_Path ?>. Be sure you uploaded the HTML files from you\'re comptuer to the SE server AND then re-run the Edit of CMS again.";
        </script>
        <?php
    }
    $stmt_SAB->close();
?>