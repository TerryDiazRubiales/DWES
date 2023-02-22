<?php

/* me falta la funcion crear tabla y crear fila para 
 * que me cree una tabla con los productos de una familia indicada
como la hecha aqui en html pero desde una funcion en cargarDatos.js */
require_once './funciones.php';
require_once './DB.php';
require_once './CestaCompra.php';
require_once './Producto.php';

comprobarSession();

$cesta = CestaCompra::cargarCesta();
$lista_prod = $cesta->getCarrito();
 
$cesta_vacia = "";
$mensaje_bderror = " ";

try {
     $mensaje_sinfamilia = " ";
    
   if (isset($_GET['family'])) {
       $cod_fam = htmlspecialchars($_GET['family']);
        $_SESSION['family'] = $cod_fam;   
    
    } else if (isset($_SESSION['family'])) {
        $cod_fam = $_SESSION['family'];
    } else {
         $mensaje_sinfamilia = "¡No se eligió ninguna familia! Acceso forzado";
    }
    
     // si no hay codigo familia 
    if (isset($cod_fam)) {
        $productos = DB::obtiene_productos($cod_fam);
    } 
    
} catch (Exception $ex) {
    $mensaje_bderror = '<p>Error con la base de datos: ' . $ex->getMessage() . '</p>';
}



if (isset($_POST['vaciar'])) {
    unset($_SESSION['cesta']);
    $cesta = CestaCompra::cargarCesta();
}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!-- Tienda Web: listado_productos.php -->
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <title>Listado de productos</title>
        <link href="tienda.css" rel="stylesheet" type="text/css">
        
    </head>

    <body class="pagproductos">
       
        <?= $mensaje_bderror ?>
        <!-- si se intenta acceder directamente sin cliquear en familias -->
        <?= $mensaje_sinfamilia ?>
                
        <div id="contenedor">
            <div id="encabezado">
                <h1>Listado de productos</h1>
            </div>

            <!-- Dividir en varios templates -->
            <div id="cesta">      
                <h2><img src='img/cesta.png' alt='Cesta' width='24' height='21'> Cesta</h2>
                <hr/>
               
            </div>

            <div id="productos">
           
                
            </div>
           
            <br class="divisor" />
            <div id="pie">
               <form action="listado_familias.php" method="post">
                <input type="submit" name="atras" value="atras"></input>
            </form>

            </div>
        </div>
        
        <script src="cargarDatos.js"></script>
    </body>
</html>

