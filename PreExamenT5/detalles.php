<?php
include_once './DB.php';
include_once './Televisor.php';
include_once './Producto.php';
require_once './funciones.php';

comprobarSession();

$cod_familia = '';
$mensaje_excepcion = '';

// Obtener la familia
if (isset($_SESSION['family'])) {
    $cod_familia = $_SESSION['family'];
}

if (isset($_POST['detalle'])) {
    
    try {
        $cod = $_POST['cod_pro'];
        
        if ($cod_familia == 'TV') {
            $tv = DB::obtiene_tv($cod);
            $nombre = $tv->getNombre_corto();
            $pulgadas = $tv->getPulgadas();
            $resolucion = $tv->getResolucion();
            $panel = $tv->getPanel();
            $precio = $tv->getPVP();
            
        } elseif ($cod_familia == 'ORDENA') {
            $ordenador = DB::obtiene_sobremesa($cod);
            $nombre = $ordenador->getNombre_corto();
            $marca = $ordenador->getMarca();
            $modelo = $ordenador->getModelo();
            $procesador = $ordenador->getProcesador();
            $ram = $ordenador->getRam();
            $rom = $ordenador->getRom();
            $extras = $ordenador->getExtras();
            $precio = $ordenador->getPVP();
        }
        
    } catch (Exception $ex) {
        $mensaje_excepcion = $ex->getMessage();
    }
    
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">

        <title>Detalle producto</title>
            <link href="tienda.css" rel="stylesheet" type="text/css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    </head>
    <body class="pagproductos">
        <div id="contenedor">
            <div id="encabezado">
                <h1>Detalle de producto</h1>
            </div>
            <div id="productos">
                <?php if ($cod_familia == 'TV'): ?>
                    <table border="0">
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Nombre</th>
                                <th>Resolución</th>
                                <th>Pulgadas</th>
                                <th>Panel</th>
                                <th>PVP</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= $cod ?></td>
                                <td><?= $nombre ?></td>
                                <td><?= $resolucion ?></td>
                                <td><?= $pulgadas ?></td>
                                <td><?= $panel ?></td>
                                <td><?= $precio ?></td>
                            </tr>
                        </tbody>
                    </table>
                <?php elseif ($cod_familia == 'ORDENA'): ?>
                    <table border="0">
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Nombre</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Procesador</th>
                                <th>Ram</th>
                                <th>Rom</th>
                                <th>Extras</th>
                                <th>PVP</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= $cod ?></td>
                                <td><?= $nombre ?></td>
                                <td><?= $marca ?></td>
                                <td><?= $modelo ?></td>
                                <td><?= $procesador ?></td>
                                <td><?= $ram ?></td>
                                <td><?= $rom ?></td>
                                <td><?= $extras ?></td>
                                <td><?= $precio ?></td>
                            </tr>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>

            <br class="divisor" />
            <div id="pie">
               <form action="listado_familias.php" method="post">
                <input type="submit" name="atras" value="atras"></input>
            </form>

            </div>
        </div>

        <div class="excepciones alert alert-info"><?= $mensaje_excepcion ?></div>
    </body>
</html>