<?php
$mensaje = " ";

// si han pulsado el boton editar (hago todo)
if (isset($_POST['editar'])) {
    // recogemos los datos enviados al dar en el botón "editar"
    $cod_prod=$_POST['cod_prod'];
    $nombre_prod=$_POST['nombre_prod'];
    $nombre_corto=$_POST['abreviacion_prod'];
    $descripcion=$_POST['descrip_prod'];
    $pvp=$_POST['pvp_prod'];

// si no, mensaje error con enlace a listado
} else {
    die ("¡No se ha pulsado en editar!");
    
}

?>

<html>
    <head>
        <title>Ejercicio 4</title>
        <link href="estilo_ej4.css" rel="stylesheet" type="text/css">
    </head>
    
    <body>
        
        <div id="edicion">
            
            <h1>Editar: </h1>
            <!-- Se crea un form con los datos a cambiar más uno oculto que será el cod que 
            necesitaremos para la actualización siguiente y ponemos uno de los botones 
            dentro del form para que al darle te redireccione a la de actualizar y te haga 
            la actualizacion -->
            <form action="actualizar-ALDR.php" method="post">
                
                <input type="text" name="nombre_prod" value="<?= $nombre_prod ?>">
                <input type="text" name="nombre_corto" value="<?= $nombre_corto ?>">
                <input type="text" name="descripcion" value="<?= $descripcion ?>">
                <input type="text" name="pvp" value="<?= $pvp ?>">
                <input type="hidden" name="cod_prod" value="<?= $cod_prod ?>">
            <br>    
            <input type="submit" name="actualizar" value="Actualizar"/>
            </form>
            <!-- Mientras que el otro se pone en un form diferente
            para que te envie a una página intermedia con un mensaje que te diga que se canceló 
            y luego al darle al boton de ahí de redireccione de nuevo a la lista -->
            <form action="cancelado-ALDR.php" method="post">
                <input type="submit" name="cancelar" value="Cancelar"/>
            </form>
            
        </div>
        
    </body>
    
</html>