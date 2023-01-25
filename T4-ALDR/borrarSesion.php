<?php
require_once 'funcion.php';
comprobarSession();

// si se le dió al botón de borrar
if (isset($_POST['borrarSesion'])) {
    
    // si hay visitas
    if (isset($_SESSION['visitas'])) {
        
        unset($_SESSION['visitas']); // te asegura que se borra la variable
        // para que aunque te cargues la variable haya una al menos vacia
        $_SESSION['visitas'] = [];
      
    }
    
}

header("Location: principal2.php?borrar=true");

?>
