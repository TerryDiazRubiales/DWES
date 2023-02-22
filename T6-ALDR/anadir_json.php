<?php
require_once './funciones.php';
require_once './CestaCompra.php';
comprobarSession();

if ($_SERVER['REQUEST_METHOD']=='POST') {
    $codigo_producto = $_POST['cod'];
    $unidades = $_POST['unid'];

    try {
        $cesta = CestaCompra::cargarCesta();
        
    } catch (Exception $ex) {
        echo $ex . getMessage();
        echo $ex . getTrace();
    }
    
    $cesta->cargar_articulo($codigo_producto, $unidades);
    $cesta->guardarCesta();
   
} 

/* if (isset($_POST['enviar'])) {
    $codigo_producto = $_POST['codigo'];
    $unidades = $_POST['unidades'];

    $cesta->cargar_articulo($codigo_producto, $unidades);
    $cesta->guardarCesta();
    $lista_prod = $cesta->getCarrito();
    
} */

?>