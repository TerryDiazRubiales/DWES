<?php
$dsn ='mysql:dbname=dwes;host=127.0.0.1';
$user = 'dwes';
$password = 'abc123.';

// nos conectams a la base de datos
try {
    $bd = new PDO ($dsn, $user, $password);
} catch (Exception $ex) {
    die('<p>Error con la base de datos: ' . $ex->getMessage() . '</p>');
}

// si se a seleccionado un producto, recogemos el cod del producto
if (isset($_POST['cod_produc'])) {
    $cod_prod = $_POST['cod_produc'];
}

// UPDATE
if (isset($_POST['modificar'])) {
    // se recoge los valores para usarlos para el update
    $unidadesModif = $_POST['unidades'];
    $codTiendasModif = $_POST['tiendas'];
    $cod_prod = $_POST['cod_produc'];
    
    $preparada_update = "UPDATE stock SET unidades = :unidades WHERE producto = '"
    .$cod_prod."' AND tienda = :tienda"; 
    
    $consultaPreparada = $bd->prepare($preparada_update);
    
    for ($i = 0; $i < count($codTiendasModif); $i++) {
        $parametrosUniYTienda = [':unidades'=> $unidadesModif[$i], ':tienda'=>$codTiendasModif[$i]];
        $consultaPreparada->execute ($parametrosUniYTienda); 
    }
   
    
}

// hacemos un select de la base de datos para ver el stock en las tiendas de ese producto
$select = "SELECT cod, nombre FROM producto";
$query_select = $bd->query($select);
$productos = $query_select->fetchAll();

if (isset($cod_prod)) {
    $cod_prod = $_POST['cod_produc'];
    // $nombre_prod = $productos;
    
    $conseguir_stock = "SELECT tienda.nombre, stock.unidades, tienda.cod as cod_tienda, ". 
            "producto.nombre as nombre_prod FROM stock JOIN producto ".
            "INNER JOIN tienda ON stock.tienda=tienda.cod AND producto.cod=stock.producto ".
            "WHERE stock.producto=:producto";
    
    $preparada_stock = $bd->prepare($conseguir_stock);
    $parametros = [':producto'=> $cod_prod];
    $preparada_stock->execute($parametros);
    
    $stock = $preparada_stock->fetchAll();
    
    if (count($stock)>0) {
        $nombre_prod = $stock[0]['nombre_prod'];
        
    } else {
        
        foreach ($productos as $fila) {
            if ($fila['cod']==$cod_prod) {
                // if (array_search($cod_prod, $productos)) {
                // $nombre_prod = $fila['nombre'];
                // }
                $nombre_prod = $fila['nombre'];
            }
        }
      
    }
    
}





?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01
Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html;
charset=UTF-8">
<title> (copia) Ejercicio 1.2 con PDO</title>
<link href="dwes.css" rel="stylesheet" type="text/css">
</head>
<body>
    
<div id="encabezado">
<h1>Ejercicio: </h1>

<form id="form_seleccion" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
    
    <label>Productos: </label> <!-- Label con texto que saldrá antes del selector -->
    <!-- se crea el selector y se hace un bucle para recoger todos los codigos y mostrar los nombres en el selector  -->
    <select name="cod_produc">
        <?php foreach ($productos as $fila): ?>
            <?php if ($cod_prod==$fila['cod']): ?>
                <option value="<?= $fila['cod'] ?>" selected><?= $fila['nombre'] ?></option>
            <?php else: ?>
                <option value="<?= $fila['cod'] ?>"><?= $fila['nombre'] ?></option>
            <?php endif; ?>
            
        <?php endforeach; ?>
    </select>
    <input type="submit" name="enviar" value="Enviar"/>
    
</form>
</div>
    
<div id="contenido">
   
    <?php if (isset($cod_prod) && isset($stock) && count($stock) != 0): ?>
    <h2>Stock del producto <?= $nombre_prod ?> en las tiendas</h2>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        
        <?php foreach ($stock as $fila): ?>
        <p><?= $fila['nombre']?>: <input type="text" name="unidades[]" value="<?= $fila['unidades'] ?>"></p>
        <input type="hidden" name="tiendas[]" value="<?= $fila['cod_tienda'] ?>">
         <?php endforeach; ?>
        <input type="hidden" name="cod_produc" value="<?= $cod_prod ?>">
        <input type="submit" name="modificar" value="Modificar"/>
    </form>
     <br>
    <table>
        <tr>
            <th>Tienda</th>
            <th>Unidades</th>
        </tr>
        <?php foreach ($stock as $fila): ?>
            <tr>
                <td><?= $fila['nombre'] ?></td>
                <td><?= $fila['unidades'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
        
    <?php elseif (isset($stock) && count($stock) == 0): ?>
    <p> No hay Stock del producto <?= $nombre_prod ?> </p>
    <?php endif; ?>
    
    <center>
        <br><br> <a href="index.php"><h1>Inicio</h1></a>
        <a href="<?= htmlspecialchars($_SERVER['PHP_SELF'])?>"><h1>Recargar</h1></a> <br>
    </center>
</div>
<div id="pie">
</div>
    
</body>
</html>

