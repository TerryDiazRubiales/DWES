<?php

function filtraVector ($arrayOriginal, $max, $min) {
    // con while
    $i = 0;
    $arraySalida = [];
    
    while ($i<count($arrayOriginal)) {
        if ($arrayOriginal[$i] >=$min && $arrayOriginal[$i] <=$max) {
            $arraySalida[] = $arrayOriginal[$i];
        } 
        $i++;
    }
    
    return $arraySalida;
    
}

function imprimeArray($arraySalida) {
    foreach ($arraySalida as $value) {
        echo "$value"." ";
    }
    
}

?>