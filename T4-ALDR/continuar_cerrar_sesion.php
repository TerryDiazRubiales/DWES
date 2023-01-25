<?php
require_once 'funcion.php';
comprobarSession2();

$mensaje = " ";

if (isset($_REQUEST['iniciado'])) {
    $res = $_REQUEST['iniciado'];

}

?>

<html>
    <head>
        <title>Ej 3.1: Conitnuar o Cerrar sesion</title>		
        <meta charset = "UTF-8">
    </head>
    
    <body>
        <?= $mensaje ?>
        <?php if($res == 0): ?>
            <p>Ya hay una sesisión, ¿Quiere continuar o iniciar en otra?</p>

            <form action="listado_familias.php" method="post">
                <input type="submit" name="continuar" value="Continuar"></input>
            </form>

            <form action="logout.php" method="post">
                <input type="submit" name="cerrar" value="Cerrar Sesión"></input>
            </form>
        
        <?php endif; ?>
        
    </body>
</html>