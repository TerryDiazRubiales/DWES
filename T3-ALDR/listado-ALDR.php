<?php
$mensaje = " ";

if (isset($_REQUEST['resultado'])) {
    $res = $_REQUEST['resultado'];
    
    // si no se le dió a actualizar
    if ($res==0) {
        $mensaje = " ¡No se ha pulsado a actualizar! Se ha intentado acceder directamente";
    // si se le dió a actualizar
    } else {
        $mensaje = " ¡Actualización hecha correctamente! ";
    }
}

// accedemos a la base de datos
$dsn ='mysql:dbname=dwes;host=127.0.0.1';
$user = 'dwes';
$password = 'abc123.';

try {
    $bd = new PDO ($dsn, $user, $password);
} catch (Exception $ex) {
    die('<p>Error con la base de datos: ' . $ex->getMessage() . '</p>');
}

// recogemos el codigo de la familia
if (isset($_POST['cod_familia'])) {
    $cod_fam = $_POST['cod_familia'];
}

// hacemos un select para usarlo para hacer el desplegable con los nombres de las familias existentes
$select = "SELECT cod as cod_fami, nombre as nombre_fami FROM familia";
$query_select = $bd->query($select);
$familias = $query_select->fetchAll();

// si se seleccionó un codigo de familia y se dió a "mostrar"
if (isset($cod_fam)) {
    $cod_fam = $_POST['cod_familia'];
    // hacemos el select para recoger todos los productos de dicha familia seleccionada
        // SELECT cod as cod_prod, nombre as nombre_prod, nombre_corto as abreviacion_prod, PVP as pvp_prod FROM producto WHERE familia='3';
    $select_prod = "SELECT cod as cod_prod, nombre as nombre_prod, ".
        "nombre_corto as abreviacion_prod, PVP as pvp_prod, descripcion as descrip_prod ".
         "FROM producto WHERE familia=:cod_famili";
    $preparada_prod = $bd->prepare($select_prod);
    $parametros = [':cod_famili'=> $cod_fam];
    $preparada_prod->execute($parametros);
    
    $productos = $preparada_prod->fetchAll();

}


?>

<html>
    <head>
        <title>Ejercicio 4</title>
        <link href="estilo_ej4.css" rel="stylesheet" type="text/css">
    </head>
    
    <body>
        <!-- MENSAJES -->
        <?= $mensaje ?>
        
        <!-- Aqui se muestra el desplegable de las familias existentes -->
        <div id="encabezado">
            <h1>LISTADO: </h1>
            <form id="form_seleccion" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
    
            <label>Familias: </label> 
            <select name="cod_familia">
                <?php foreach ($familias as $fila): ?>
                    <?php if ($cod_fam==$fila['cod_fami']): ?>
                        <option value="<?= $fila['cod_fami'] ?>" selected><?= $fila['nombre_fami'] ?></option>
                    <?php else: ?>
                        <option value="<?= $fila['cod_fami'] ?>"><?= $fila['nombre_fami'] ?></option>
                    <?php endif; ?>
            
                <?php endforeach; ?>
            </select>
            <input type="submit" name="mostrar" value="Mostrar"/>
    
        </form >
        </div>
        
        <!-- Aqui se muestra en una tabla todos los productos que tiene la familia escogida junto a un botón de editar para cada uno, metidos en un form cada producto -->
        <div id="conten">
            <?php if (isset($cod_fam) && isset($productos) && count($productos) != 0): ?>
            <table>
                <tr>
                    <th>Nombre Producto</th>
                    <th>Nombre Corto</th>
                    <th>PVP</th>
                </tr>
                <!-- Se hace el bucle para mostrar la info que queremos de todos los productos que hay de esa familia  -->
                <?php foreach ($productos as $fila): ?>
                <!-- Se hace el form y en cada uno se ira metiendo cada dato para que en el input que creamos dentro solo recoja la info de dicho producto  -->
                <form id="form_seleccion" action="editar-ALDR.php" method="post">
                <tr>
                    <td><?= $fila['nombre_prod'] ?></td>
                    <td><?= $fila['abreviacion_prod'] ?></td>
                    <td><?= $fila['pvp_prod'] ?></td>
                    <td>
                       <input type="submit" name="editar" value="Editar"/>
                    </td>
                <!-- Aqui mandamos los datos en oculto para luego poder recogerlos en el php de editar -->
                <input type="hidden" name="nombre_prod" value="<?= $fila['nombre_prod'] ?>">
                <input type="hidden" name="abreviacion_prod" value="<?= $fila['abreviacion_prod'] ?>"> 
                <input type="hidden" name="pvp_prod" value="<?= $fila['pvp_prod'] ?>">
                
                <input type="hidden" name="descrip_prod" value="<?= $fila['descrip_prod'] ?>">
                <input type="hidden" name="cod_prod" value="<?= $fila['cod_prod'] ?>">
                
                </tr>
                <!-- se envia codigo producto invisible -->
               
                </form>
                
                <?php endforeach; ?>
                
            </table>
            <?php elseif (isset($productos) && count($productos) == 0): ?>
                <p> No hay productos de esta familia</p>
            <?php endif; ?>
            
            <!-- Si se hizo una actualización mostrar -->
        </div>
        
        <center>
        <br><br> <a href="index.php"><h1>Inicio</h1></a>
        <a href="<?= htmlspecialchars($_SERVER['PHP_SELF'])?>"><h1>Recargar</h1></a> <br>
        </center>
    
    </body>
    
</html>