<?php
require_once './funciones.php';
require_once './CestaCompra.php';

comprobarSession();

$cesta_compra = CestaCompra::cargarCesta();
$cesta = $cesta_compra->getCarrito();
echo json_encode($cesta);


 ?>
