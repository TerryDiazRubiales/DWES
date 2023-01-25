<?php

$nombre = 'Antonio';
$apellidos = 'López';

function printNombre() {
   
    foreach ($GLOBALS as $key => $value) {
        if($key == 'nombre' || $key ==  'apellidos') {
            echo 'Clave: ' . $key . 'Valor: ' . $value . '<br>';
        // echo "Clave: $key Valor: $value <br>";
        }
        
    }   
}

function cambiarNombre() {
    $GLOBALS['nombre'] = 'Maria';
   
}


printNombre();
cambiarNombre();
echo " El nuevo nombre es: $nombre";

?>