<?php
$date = getdate();
$hh = $date['hours'];
$mm = $date['minutes'];
$ss = $date['seconds'];
$wd = $date['weekday'];
$md = $date['mday'];
$mo = $date['month'];
$yy = $date['year'];

$hora = "a las $hh:$mm:$ss del $wd, $md de $mo  de $yy";
setcookie('hora', $hora, time() + 3600 * 24);



?>
<html>
    <head>
        <title>Principal</title>
    </head>
    
    <body>
        
        <?php if(!isset($_COOKIE['hora'])): ?>
            <p>¡Bienvenido!</p>
            
        <?php else: ?>
            <p>Tu última vez fué <?= $_COOKIE['hora']; ?></p>
            
        <?php endif; ?>
        
        <center>
        <br><br> <a href="index.php"><h1>Inicio</h1></a>
        <a href="<?= htmlspecialchars($_SERVER['PHP_SELF'])?>"><h1>Recargar</h1></a> <br>
        </center>
    
    </body>
    
</html>