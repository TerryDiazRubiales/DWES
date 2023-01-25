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

// PARA MOSTRAR LA TABLA DE LAS TIENDAS DEL PRODUCTO INDICADO DIRECTAMENTE ABAJO
$cod_fam = 'COD4';

// hacemos un select de la base de datos para ver el stock en las tiendas de ese producto
$select = "SELECT cod, nombre FROM producto";
$query_select = $bd->query($select);
$familias = $query_select->fetchAll();

// PREDEFINIMOS EL UPDATE E INSERT
$update = "UPDATE stock SET unidades = 1 WHERE producto = '"
    .$cod_fam."' AND tienda = 'tienda2'";

$insert = "INSERT INTO stock VALUES ('COD4', 1, 4)";

// COMPROBAMOS LA CONEXIÓN A LA BD y TRANSACCION
if (isset($_POST['traspasar'])) {
    try {
    $bd = new PDO ($dsn, $user, $password);
	echo "Conexión realizada con éxito<br>";
        
	$bd->beginTransaction();
        
	$update = "UPDATE stock SET unidades = 1 WHERE producto = '"
        .$cod_fam."' AND tienda = 2";
        $insert = "INSERT INTO stock VALUES ('COD4', 4, 1)";
        
        $resulInsert = $bd->query($insert);
	$resulUpdate = $bd->query($update);	
	        
	if(!$resulUpdate && !$resulInsert){
		echo "Error: " . print_r($bd->errorinfo());
		$bd->rollback();
		echo "<br>Transacción anulada<br>";
	}else{
		$bd->commit();
	}	
} catch (PDOException $e) {
    die('<p>Error con la base de datos: ' . $e->getMessage() . '</p>');
} 
}

// DELETE FROM stock WHERE tienda=4 AND producto='COD4'

if (isset($cod_fam)) {
    // $cod_prod = $_POST['cod_produc'];
    // $nombre_prod = $productos;
    
    $conseguir_stock = "SELECT tienda.nombre, stock.unidades, tienda.cod as cod_tienda, ". 
            "producto.nombre as nombre_prod FROM stock JOIN producto ".
            "INNER JOIN tienda ON stock.tienda=tienda.cod AND producto.cod=stock.producto ".
            "WHERE stock.producto=:producto";
    
    $preparada_stock = $bd->prepare($conseguir_stock);
    $parametros = [':producto'=> $cod_fam];
    $preparada_stock->execute($parametros);
    
    $stock = $preparada_stock->fetchAll();
    
    if (count($stock)>0) {
        $nombre_prod = $stock[0]['nombre_prod'];
        
    } else {
        
        foreach ($familias as $fila) {
            if ($fila['cod']==$cod_fam) {
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
<title>Ej Transacción con PDO</title>
<link href="dwes.css" rel="stylesheet" type="text/css">
</head>
<body>
    
<div id="encabezado">
<h1>Ejercicio: </h1>

</div>
    
<div id="contenido">
   
    <h2>Stock del producto <?= $nombre_prod ?> en las tiendas</h2>
    <!-- Aqui se hará la transacción al darle al boton -->
    
    
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
     
     <form id="form_seleccion" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
         <input type="submit" name="traspasar" value="Traspasar"/>
     </form>
     
    <center>
        <br><br> <a href="index.php"><h1>Inicio</h1></a>
        <a href="<?= htmlspecialchars($_SERVER['PHP_SELF'])?>"><h1>Recargar</h1></a> <br>
    </center>
</div>
<div id="pie">
</div>
    
</body>
</html>

