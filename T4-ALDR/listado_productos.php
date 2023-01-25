<?php
require_once 'funcion.php';
comprobarSession2();
$cesta = cargarCesta();

$cesta_vacia = "";

$mensaje_bderror = " ";

$dsn = 'mysql:dbname=dwes2;host=127.0.0.1';
$user = 'dwes2';
$password = 'abc123.';

try {
    $bd = new PDO($dsn, $user, $password);

    $mensaje_sinfamilia = " ";
    if (isset($_REQUEST['familia'])) {
        $cod_fam = $_REQUEST['familia'];
        
        // SELECT cod, nombre_corto, pvp FROM `producto` WHERE familia='CAMARA';
        $selectPrep = "SELECT cod as codprod, nombre_corto as nombre, pvp, familia FROM producto WHERE familia=:familia";
        $prepare = $bd->prepare($selectPrep);
        $parametros = [':familia' => $cod_fam];
        $prepare->execute($parametros);
        $productos = $prepare->fetchAll();
        
        
    } else {
        $mensaje_sinfamilia = "¡No se eligió ninguna familia! Acceso forzado";
    }
    
} catch (Exception $ex) {
    $mensaje_bderror = '<p>Error con la base de datos: ' . $ex->getMessage() . '</p>';
}

if (isset($_POST['anadir'])) {
    $producto = ['familia'=>$_POST['familia'], 'unidades'=>$_POST['unidades'], 'nombre'=>$_POST['nombre'] , 'pvp'=>$_POST['pvp']];
    $codprod = $_POST['cod_prod'];
    anadirProducto($cesta, $producto, $codprod);
    guardarCesta($cesta);
    
} 

if (isset($_POST['vaciar'])) {
    $cesta = [];
    $_SESSION['cesta'] = [];
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
                <h3><img src='img/cesta.png' alt='Cesta' width='24' height='21'> Cesta</h3>
                <hr />
                <?php if (isset($cesta) && count($cesta)!=0): ?>
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
                <p>Cesta vacia</p>
                
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
                <?php if (isset($cod_fam) && isset($productos) && count($productos) != 0): ?>
            <table>
                
                <!-- Se hace el bucle para mostrar la info que queremos de todos los productos que hay de esa familia  -->
                <?php foreach ($productos as $fila): ?>
                <!-- Se hace el form y en cada uno se ira metiendo cada dato para que en el input que creamos dentro solo recoja la info de dicho producto  -->
                <form id="form_seleccion" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <tr>
                    <td>
                       <input type="submit" name="anadir" value="Añadir"/>
                    </td>
                    <td><?= $fila['nombre'] ?>: </td>
                    <td><?= $fila['pvp'] ?> euros</td>
                
                <!-- Aqui mandamos las unidades -->
                <input type="hidden" name="unidades" value="<?= $unidad = 1 ?>"/>
                <!-- Aqui mandamos los datos en oculto para luego poder recogerlos en el php de editar -->
                <input type="hidden" name="cod_prod" value="<?= $fila['codprod'] ?>">
                <input type="hidden" name="familia" value="<?= $fila['familia'] ?>">
                <input type="hidden" name="nombre" value="<?= $fila['nombre'] ?>">
                <input type="hidden" name="pvp" value="<?= $fila['pvp'] ?>">
                </tr>
                <!-- se envia codigo producto invisible -->
               
                </form>
                
                <?php endforeach; ?>
                
            </table>
            <?php elseif (isset($productos) && count($productos) == 0): ?>
                <p> No hay productos de esta familia</p>
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
