<?php
require_once './funciones.php';
require_once './DB.php';
require_once './CestaCompra.php';
comprobarSession();

$cesta = CestaCompra::cargarCesta();

if ($_SERVER['REQUEST_METHOD']=='POST') {
    $codigo_producto = $_POST['codigo'];
    $unidades = $_POST['unidades'];

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