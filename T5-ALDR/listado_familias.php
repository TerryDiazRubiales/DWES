<?php
require_once './funciones.php';
require_once './CestaCompra.php';
require_once './DB.php';
require_once './Producto.php';
 
$cesta_vacia = "";

$mensaje_bderror = " ";


comprobarSession();

$cesta = CestaCompra::cargarCesta();

try {
    $familias = DB::obtiene_familias();
    
} catch (Exception $ex) {
    $mensaje_bderror = '<p>Error con la base de datos: ' . $ex->getMessage() . '</p>';
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!-- Tienda Web: listado_familias.php -->
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <title>Listado de familias</title>
        <link href="tienda.css" rel="stylesheet" type="text/css">
    </head>

    <body class="pagproductos">
        <?= $mensaje_bderror ?>
        
        <div id="contenedor">
            <div id="encabezado">
                <h1>Listado de familias</h1>
             
                <!-- hiperviculos con todas las familias -->
                
                
            </div>

            <!-- Dividir en varios templates -->
            <div id="cesta">      
                <h2><img src='img/cesta.png' alt='Cesta' width='24' height='21'> Cesta</h2>
                <hr />
                <?php if (isset($cesta) && $cesta->estaVacia()==false): ?>
                <!-- mostrar la cesta -->
                <table>
                    
                    <?php foreach ($cesta as $key => $fila): ?>
                    <tr>
                        <td><?= $key ?></td>
                        
                        <td><?= $fila['familia'] ?></td>
                        <td><?= $fila['pvp'] ?></td>
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

	    <!--Lista de vínculos con la forma listado_productos.php?categoria=-->
            <div id="productos">
                <ul>
                    <?php foreach ($familias as $familia): ?>
                    <li><a href="listado_productos.php?family=<?= $familia->getCodFam() ?>"> <?= $familia->getNombreFam() ?></a> </li>
                    <?php endforeach; ?> 
                </ul>
            </div>

            <br class="divisor" />
            
            <div id="pie">
                
            </div>
        </div>
    </body>
</html>

