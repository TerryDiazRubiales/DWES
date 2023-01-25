<?php
$diaActual = date('N');
$numero = date('d');
$mesActual = date('n');
$yearActual = date('Y');

$arrayDiaSemana=['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];
$arrayMes=['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

$diaActual=$diaActual-1;
$mesActual=$mesActual-1;
$mensaje = "$arrayDiaSemana[$diaActual], $numero de $arrayMes[$mesActual] de $yearActual ";

?>

<html>
    <head>
         <title>Ej3: Estructgura de control</title>
    </head>
    <body>     
        <center> 
            <h1>EJERCICIO 3</h1>
           
            <p>Hoy es: </p>
            <p>"<?=$mensaje?>"</p>
            
            <br><br> <a href="index.php"><h1>Inicio</h1></a>
            <a href="<?= htmlspecialchars($_SERVER['PHP_SELF'])?>"><h1>Recargar</h1></a> <br>
        </center>
    </body>
   
</html>