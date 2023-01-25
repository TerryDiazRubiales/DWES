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

    $select = "SELECT * FROM familia";
    $query_select = $bd->query($select);
    $familias = $query_select->fetchAll();
    
} catch (Exception $ex) {
    $mensaje_bderror = '<p>Error con la base de datos: ' . $ex->getMessage() . '</p>';
}

if (isset($_POST['vaciar'])) {
    $cesta = [];
    $_SESSION['cesta'] = [];
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

	    <!--Lista de vínculos con la forma listado_productos.php?categoria=-->
            <div id="productos">
                <ul>
                    <?php foreach ($familias as $fila): ?>
                    <li><a href="listado_productos.php?familia=<?= $fila['cod'] ?>"> <?= $fila['nombre'] ?></a> </li>
                    <?php endforeach; ?> 
                </ul>
            </div>

            <br class="divisor" />
            
            <div id="pie">
                
            </div>
        </div>
    </body>
</html>
