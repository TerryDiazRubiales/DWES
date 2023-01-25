<?php

/* Escribe una funcion que reciba un array de numeros
 * y dos limites, superior e inferior
 * devuelve otro array cuyo elementos estan entre los limites inclusive  */

require './ej3_AR_Funciones-ALDR.php';
?>

<html>
    <head>
         <title>Ej3: Arrays</title>
    </head>
    <body>
        <center>
            <h1>EJERCICIO 3</h1> <br>
            <?php 
            $arrayOriginal = [4,7,10,8,3];
            $max = 8;
            $min = 1;
            $newArray;
            
            echo "Original: ";
            imprimeArray($arrayOriginal);
            echo "<br>";
            
            echo "Nuevo: ";
            $newArray = filtraVector($arrayOriginal, $max, $min);
            imprimeArray($newArray);  
            echo "<br>";
            ?>
            
            <br><br> <a href="index.php"><h1>Inicio</h1></a>
            <a href="<?= htmlspecialchars($_SERVER['PHP_SELF'])?>"><h1>Recargar</h1></a> <br>
        </center>
    </body>
   
</html>