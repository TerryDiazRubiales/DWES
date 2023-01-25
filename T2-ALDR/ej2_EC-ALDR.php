<?php

        $dado1 = mt_rand(1, 6);
        $dado2 = mt_rand(1,6);
        $dado3 = mt_rand(1,6);
        $resto;
        $max; 
        $min;
        $text = "¡Error!";
                
        if ($dado1==$dado2 && $dado2==$dado3 && $dado1==$dado3){
             $text = "\n Ha salido un trio de $dado1";
             
        } elseif ($dado1==$dado2 || $dado1==$dado3) {
             $text = "\n Ha salido un duo de $dado1";
             
        } elseif ($dado2==$dado3) {
             $text = "\n Ha salido un duo de $dado2";
             
        } else {
            $max=max($dado1,$dado2,$dado3);
            $min=min($dado1,$dado2,$dado3);
            $resto = $max-$min;
            $text = "\n ¡Todos son diferentes! \n El resto del mayor y menor es: << $resto >>";
        }
             
        
        
       
        ?>

<html>
    <head>
         <title>Ej2: Estructura de control</title>
    </head>
    <body>
        <center>
            <h1>EJERCICIO 2</h1> <br>
            <img src="./img/<?=$dado1?>.svg">
            <img src="./img/<?=$dado2?>.svg">
            <img src="./img/<?=$dado3?>.svg"> <br>
            <?=$text?>
            <br><br> <a href="index.php"><h1>Inicio</h1></a>
            <a href="<?= htmlspecialchars($_SERVER['PHP_SELF'])?>"><h1>Recargar</h1></a> <br>
        </center>
    </body>
    
    
     
    
</html>


