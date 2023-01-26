<?php
require_once './funciones.php';
require_once './CestaCompra.php';
comprobarSession();

$cesta = CestaCompra::cargarCesta();
$cesta->getCarrito();

echo json_encode($cesta)


 ?>
