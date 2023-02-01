<?php
require_once './CestaCompra.php';
require_once './funciones.php';

comprobarSession();
$cesta = CestaCompra::cargarCesta();

unset($_SESSION['cesta']);
$cesta = CestaCompra::cargarCesta();
    
die("Gracias por su compra.<br />Quiere <a href='listado_familias.php'>comenzar de nuevo</a>?");
?>