<?php

function comprobarSession () {
    session_start();
    
    if (!isset($_SESSION['usuario'])) {
         header("Location: ej5-ALDR.php?redirigido=0");
    }
}


?>
