<?php

if(!isset($_COOKIE['contador'])){
	setcookie('contador', '1', time() + 3600 * 24);
	echo "Bienvenido por primera vez";
} else {
	$contador = (int) $_COOKIE['contador'];
	$contador++;
	setcookie('contador', $contador, time() + 3600 * 24);
	echo "Bienvenido por $contador vez";
}

?>
<html>
    <head>
       
    </head>
    
    <body>
        
        <center>
        <br><br> <a href="index.php"><h1>Inicio</h1></a>
        <a href="<?= htmlspecialchars($_SERVER['PHP_SELF'])?>"><h1>Recargar</h1></a> <br>
        </center>
    
    </body>
    
</html>
