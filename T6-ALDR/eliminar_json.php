<?php
require_once './funciones.php';
require_once './CestaCompra.php';
comprobarSession();

if ($_SERVER['REQUEST_METHOD']=='POST') {
    $codprod = $_POST['cod'];
    
    try {
        $cesta = CestaCompra::cargarCesta();
        
    } catch (Exception $ex) {
        echo $ex . getMessage();
        echo $ex . getTrace();
    }
    
    $cesta->eliminar_Producto($codprod, $unidades);
    $cesta->guardarCesta();
}

?>

