<?php
$resultado = 1;
 
// si se le dió a actualizar hacer
if (isset($_POST['actualizar'])) {
    // recogemos los datos enviados al dar en el botón "actualizar"
    $cod_prod=$_POST['cod_prod'];
    $nombre_prod=$_POST['nombre_prod'];
    $nombre_corto=$_POST['nombre_corto'];
    $descripcion=$_POST['descripcion'];
    $pvp=$_POST['pvp'];
        
    // accedemos a la base de datos
    $dsn ='mysql:dbname=dwes;host=127.0.0.1';
    $user = 'dwes';
    $password = 'abc123.';
    
    try {
        $bd = new PDO ($dsn, $user, $password);
    } catch (Exception $ex) {
        die('<p>Error con la base de datos: ' . $ex->getMessage() . '</p>');
    }
    
    // hacemos el update del producto elegido y la consulta preparada
        // UPDATE producto SET nombre='Bacalao, nombre_corto='Bac, descripcion='Bacalao sin espinas', PVP='6.30' WHERE cod='COD1';
        // UPDATE producto SET nombre='Anchoas', nombre_corto='An', descripcion='Sin descripcion', PVP='9.50' WHERE cod='COD1';
    $update = "UPDATE producto SET nombre=:nombre, nombre_corto=:corto, ".
            "descripcion=:descripcion, PVP=:pvp WHERE cod='".$cod_prod."'"; 
  
    $update_preparada = $bd->prepare($update);
    $parametros = [':nombre'=>$nombre_prod, ':corto'=>$nombre_corto, ':descripcion'=>$descripcion, ':pvp'=>$pvp];
    $update_preparada->execute($parametros); 
    
// si no se dió al botón, un header para decir en listado que no se dió a ningun boton
// es decir, que se accedió por url a actualizar
} else {
    $resultado = 0;
    header ("Location:listado-ALDR.php?resultado=$resultado");
}

// Hacemos el header
    // header (Location: "lista.php");
header ("Location:listado-ALDR.php?resultado=$resultado");


?>
