<?php
require_once 'funcion.php';
comprobarSession2();
$cesta = cargarCesta();

$precioFinal = 0;

if (isset($_POST['quitar'])) {
    $producto = ['unidad'=>$_POST['unidad']];
    $codprod = $_POST['cod_prod'];
    quitarProducto($cesta, $producto, $codprod);
    guardarCesta($cesta);
    
    foreach ($cesta as $key => $fila) {
    $precioFinal += $fila['pvp']*$fila['unidades'];
    }

    
} else {
    foreach ($cesta as $key => $fila) {
    $precioFinal += $fila['pvp']*$fila['unidades'];
    }

}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!-- Tienda Web: cesta.php -->
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>Cesta de la Compra</title>
  <link href="tienda.css" rel="stylesheet" type="text/css">
</head>

<body class="pagcesta">

<div id="contenedor">
  <div id="encabezado">
    <h1>Cesta de la compra</h1>
  </div>
  <div id="productos">
<?php if (isset($cesta) && count($cesta)!=0): ?>
                <!-- mostrar la cesta -->
                <table>
                    
                    <?php foreach ($cesta as $key => $fila): ?>
                    <form id="form_seleccion" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <tr>
                        <td><?= $key ?></td>
                        
                        <td><?= $fila['nombre'] ?></td>
                        <td> 
                            <input type='text' name='unidad' value="<?= $fila['unidades'] ?>" id="cantidad"/>
                        </td>
                        <td> x <?= $fila['pvp'] ?></td>
                        <td>
                            <input type="submit" name="quitar" value="Quitar"/>
                        </td>
                        
                        <input type="hidden" name="cod_prod" value="<?= $key ?>">
                    </tr>
                    </form>
                    <?php endforeach; ?>
                </table>
               
                
                <?php else: ?>
                <p>Cesta vacia</p>
                <?php endif; ?>
    <hr />
    <p><span class='pagar'>Precio total: <?= $precioFinal ?> €</span></p>
    <form action='pagar.php' method='post'>
        <p><span class='pagar'>
            <input type='submit' name='pagar' value='Pagar'/>
        </span></p>
    </form>
  </div>
  <br class="divisor" />
  <div id="pie">
      <form action="listado_familias.php" method="post">
          <input type="submit" name="atras" value="atras"></input>
      </form>
    <form action='logout.php' method='post'>
        <input type='submit' name='cerrar' value='Cerrar'/>
    </form>        
  </div>
</div>
</body>
</html>
