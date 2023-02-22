<?php
require_once './funciones.php';
require_once './DB.php';

comprobarSession();

$productos = '';

 if (isset($_SESSION['family'])) {
    $cod_fam = $_SESSION['family'];
    
    try {
        $productos = DB::obtiene_productos($cod_fam);
        
    } catch (Exception $exc) {
        echo $exc->getMessage();
    }
}

echo json_encode($productos, true);


?>