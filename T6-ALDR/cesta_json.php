<?php
require_once './funciones.php';
require_once './CestaCompra.php';
require_once './Producto.php';
comprobarSession();

$cesta = CestaCompra::cargarCesta();
echo json_encode($cesta->getCarrito());


 ?>
