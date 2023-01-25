<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Project/PHP/PHPProject.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        $dado1 = mt_rand(1, 6);
        $dado2 = mt_rand(1,6);
        $resto;
        
        if ($dado1!=$dado2) {
            $resto = $dado1-$dado2;
             echo "<p> << ¡¡Valores DIFERENTES!! >> </p>";
             echo "<p> El resto de los valores es: << $resto >> </p>"; // poner la diferencia entre los valores
             
        } else {
            echo "<p> << ¡¡Valores IGUALES!! >> </p>";
             echo "<p> Has conseguido pareja de $dado1 </p>";
        }
        
        ?>
    </body>
</html>
