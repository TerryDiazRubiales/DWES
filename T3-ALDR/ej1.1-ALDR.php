<?php
// Conexión
$host='127.0.0.1';
$user = 'dwes';
$password = 'abc123.';
$bd = 'dwes';

$mensaje='mensaje no editado';
$cod_enviado = null;
$nombre_producto_selec = 'null';
$stock = [];
// Vemos si ha ocurrido un error
try {
    $conexion = new mysqli ($host, $user, $password, $bd);
} catch (Exception $ex) {
    die('<p>Error conexión: ' . $e->getMessage() . '</p>');
}

// Comprobamos si se ha pulsado el boton enviar
if ( isset($_POST['enviar']) ) { // aqui lleva siempre el name del boton
    // Creamos variable para recoger el codigo del producto enviado
    $cod_enviado = $_POST['cod_prod']; // se pone el nombre que tiene el select

    $consulta_stock="SELECT tienda.nombre, stock.unidades FROM stock"
          . " INNER JOIN tienda ON stock.tienda=tienda.cod "
          . "WHERE stock.producto='". $cod_enviado. "'";
    
    $resultado_stock= $conexion->query($consulta_stock);
    
    if ($resultado_stock) {
        $stock=$resultado_stock->fetch_all(MYSQLI_ASSOC);
    }
        
}

// Crea la consulta
$query='SELECT cod, nombre FROM producto';
$resultado=$conexion->query($query); 

// Si se conecta devuelve todas las filas, si no, mensaje de error
if ($resultado) {
    $familias=$resultado->fetch_all(MYSQLI_ASSOC);
    
    // Para sacar el nombre del producto a partir del codigo seleccionado
    foreach ($familias as $value) {
        if ($value['cod']==$cod_enviado) {
            $nombre_producto_selec = $value['nombre'];
        }
    }
    
} else {
    $mensaje = "La consulta no se ha realizado correctamente";
}
    

?>

<html>
<head>
<meta http-equiv="content-type" content="text/html;
charset=UTF-8">
<title>Plantilla para Ejercicios Tema 3</title>
<link href="dwes.css" rel="stylesheet" type="text/css">
</head>
<body>
     <!-- <pre><?php // print_r($productos) ?></pre> -->
    
<div id="encabezado">
            <h1>Ejercicio: </h1>
            <form id="form_seleccion" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <label>Productos</label>
                <select name="cod_prod">
                    
                    <?php foreach ($familias as $value): ?>
                    
                        <?php if ($cod_enviado == $value['cod']): ?>
                            <option value="<?= $value['cod'] ?>" selected> <?= $value['nombre'] ?> </option>
                        <?php else: ?>
                            <option value="<?= $value['cod'] ?>"> <?= $value['nombre'] ?> </option>
                        <?php endif; ?>
                        
                    <?php endforeach; ?>
                                       
                </select>
                <input type="submit" name="enviar" value="Enviar"/>
            </form>
        </div>
        <div id="contenido">
            <h2>Stock del producto "<?= $nombre_producto_selec ?>" en las tiendas</h2>
            
            <?php if (isset($cod_enviado) && count($stock) != 0): // Si tengo codigo enviado y no esta vacio ?>
            
            <table>
                <tr>
                    <th>Nombre de la tienda</th>
                    <th> Unidades</th>
                </tr>
                <?php foreach ($stock as $value): ?>
                    <tr>
                        <td><?= $value['nombre'] ?></td>
                        <td><?= $value['unidades'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <?php elseif (count($stock) == 0): ?>
            <p>No hay Stock del producto "<?= $nombre_producto_selec ?>" </p>
            <?php endif; ?>
                        
            <!-- Para recargar e ir al inicio -->
            <center>
                <br><br> <a href="index.php"><h1>Inicio</h1></a>
                <a href="<?= htmlspecialchars($_SERVER['PHP_SELF'])?>"><h1>Recargar</h1></a> <br>
            </center>
            
        </div>
        <div id="pie">
        </div>
    


</body>
</html>
