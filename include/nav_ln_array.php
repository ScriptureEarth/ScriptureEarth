<?php
// Start the session
session_start();
?>
<?php

if (isset($_REQUEST["q"])){
    $q = $_REQUEST["q"];

    if ($q !== "") {
        $test = strtolower($q);
        foreach ($_SESSION['nav_ln_array'] as $code => $array){
            if ($test == $array[0]){
                echo $array[2];
            }
        }
    }
}
?>