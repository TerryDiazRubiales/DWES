<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

        $dado1 = mt_rand(1, 6);
        $dado2 = mt_rand(1,6);
        $resto;
        $max;
        $min;
        $text = "¡Error!";
  
        if ($dado1!=$dado2) {
            $max=max($dado1,$dado2);
            $min=min($dado1,$dado2);
            $resto = $max-$min;
            $text = "\n << ¡¡Valores DIFERENTES!! >> \n El resto de los valores es: << $resto >>"; 
             
        } else {
            $text = "\n << ¡¡Valores IGUALES!! >> \n Has conseguido pareja de $dado1";
        }
        
        ?>

<html>
    <head>
         <title>Ej1: Estructura de control</title>
    </head>
    <body>
        <center>
            <h1>EJERCICIO 1</h1> <br>
            <img src="./img/<?=$dado1?>.svg">
            <img src="./img/<?=$dado2?>.svg"> <br>
            <?=$text?>
            <br><br> <a href="index.php"><h1>Inicio</h1></a>
            <a href="<?= htmlspecialchars($_SERVER['PHP_SELF'])?>"><h1>Recargar</h1></a> <br>
        </center>
    </body>
   
    
     
    
</html>