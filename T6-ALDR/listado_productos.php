<?php
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


if (isset($_POST['anadir'])) {
    $unidades = $_POST['unidades'];
    $codProd = $_POST['cod_prod'];

    $cesta->cargar_articulo($codProd, $unidades);
    $cesta->guardarCesta();
    $lista_prod = $cesta->getCarrito();
    
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
                <hr />
                <?php if (isset($cesta) && $cesta->estaVacia()==false): ?>
                <!-- mostrar la cesta -->
                <table>
                    
                    <?php foreach ($lista_prod as $fila): ?>
                    <tr>
                        
                       <td><?= $fila['producto']->getCodigo() ?></td>
                        <td><?= $fila['producto']->getNombre_corto() ?></td>
                        <td><?= $fila['producto']->getPVP() ?></td>
                        <td><?= $fila['unidades'] ?></td>
                    </tr>
                       
                    <?php endforeach; ?>
                </table>
               
                
                <?php else: ?>
                <h4>Cesta vacia</h4>
                
                <?php endif; ?>
                
 		<form id='vaciar' action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>' method='post'>
			<input type='submit' name='vaciar' value='Vaciar Cesta'
				<?php if ($cesta_vacia) print "disabled='true'"; ?>
			/>
                        <input type="hidden" name="familia" value="<?= $cod_fam ?>"/>
		</form>
		<form id='comprar' action='cesta.php' method='post'>
			<input type='submit' name='comprar' value='Comprar'
				<?php if ($cesta_vacia) print "disabled='true'"; ?>
			/>
                        
		</form>
            </div>

            <div id="productos">
                
                <?php if (isset($productos) && count($productos)>0): ?>
            <table>
                
                <!-- Se hace el bucle para mostrar la info que queremos de todos los productos que hay de esa familia  -->
                <?php foreach ($productos as $producto): ?>
                <!-- Se hace el form y en cada uno se ira metiendo cada dato para que en el input que creamos dentro solo recoja la info de dicho producto  -->
                <form id="form_seleccion" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <tr>
                    <td>
                       <input type="number" name="unidades" value="<?= $unidades = 1 ?>"/>
                       <input type="submit" name="anadir" value="Añadir"/>
                    </td>
                    <td><?= $producto->getNombre_corto() ?>: </td>
                    <td><?= $producto->getPVP() ?> euros</td>
                
                <!-- Aqui mandamos las unidades -->
                
                <!-- Aqui mandamos los datos en oculto para luego poder recogerlos en el php de editar -->
                <input type="hidden" name="cod_prod" value="<?= $producto->getCodigo() ?>">
                
                </tr>
                
                </form>
                
                <?php endforeach; ?>
                
            </table>
            <?php elseif (isset($productos) && DB::vacia($productos) == true): ?>
                <h4> No hay productos de esta familia</h4>
            <?php endif; ?>
                
            </div>
           
            <br class="divisor" />
            <div id="pie">
               <form action="listado_familias.php" method="post">
                <input type="submit" name="atras" value="atras"></input>
            </form>

            </div>
        </div>
    </body>
</html>

