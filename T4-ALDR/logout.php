<?php
require_once 'funcion.php';
comprobarSession2();

if (isset($_POST['cerrar'])) {
    $_SESSION = array ();
    
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
        );
    }
    
    session_destroy();

    header("Location: ej3.1-ALDR.php?logout");
}


?>
