<?php
$mensaje_borrado = " ";


require_once 'funcion.php';
comprobarSession();

// si hay visitas anteriores las recopilos
if (isset($_SESSION['visitas'])) {
    $visitasAnteriores = $_SESSION['visitas'];

// si no la creo
} else {
    $_SESSION['visitas'] = [];
}

// añade al final
$_SESSION['visitas'][] = date("d-m-Y H:i:s", time());

?>
<html>
    <head>
        <title>Principal 2</title>
    </head>
    
    <body>
        <h1>Sesion</h1>
        <form action="log_out.php" method="post">
            <input type="submit" name="cerrar_sesion" value="Cerrar Sesion"></input>
        </form>

        <?php if (isset($visitasAnteriores)): ?>
        
            <?php foreach ($visitasAnteriores as $value): ?>
                    <p><?= $value ?></p>
            <?php endforeach; ?>
        
         <?php elseif ($_REQUEST['borrar']): ?>
                    <p> ¡Visitas Borradas! </p>
                    
        <?php else: ?>
            <p>¡Bienvenido!</p>
            
        <?php endif; ?>
            
        <form action="borrarSesion.php" method="post">
                <input type="submit" name="borrarSesion" value="Borrar Sesion"></input>
        </form>
            
        <center>
        <br><br> <a href="index.php"><h1>Inicio</h1></a>
        <a href="<?= htmlspecialchars($_SERVER['PHP_SELF'])?>"><h1>Recargar</h1></a> <br>
        </center>
    
    </body>
    
</html>