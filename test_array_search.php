<?php
$nav_ln_array = array (
    'zh' => array ('cmn', 'Chinese', '00cmn.php', 7, 'cmn'),
    'de' => array ('deu', 'German', '00de-Sprachindex.php', 6, 'de'),
    'en' => array ('eng', 'English', '00i-Scripture_Index.php', 1, 'i'),
    'fr' => array ('fra', 'French', '00f-Ecritures_Indice.php', 4, 'f'),
    'nl' => array ('nld', 'Dutch', '00d-Bijbel_Indice.php', 5, 'd'),
    'pt' => array ('por', 'Portuguese', '00p-Escrituras_Indice.php', 3, 'p'),
    'es' => array ('spa', 'Spanish', '00e-Escrituras_Indice.php', 2, 'e')
);
//$temp = array_values($nav_ln_array);
//$search = array_search(4, $temp[3]);
//print_r($nav_ln_array);
//print_r(array_values($nav_ln_array));
$temp = array_values($nav_ln_array);
$search = $temp[0][3];
echo $search;
?>