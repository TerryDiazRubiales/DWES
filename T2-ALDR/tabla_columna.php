<?php

$pintarTabla = false;
$text = "";
$filas = "";

if ( isset($_POST["enviar"]) ) {
    $filas = $_POST["filas"];
    
    if ($filas === " " || $filas === "") {
    $pintarTabla;
    $text = "\n\n << Introduzca un numero >>";
} elseif (!ctype_digit($filas)) { // comprobar si es digito, sin puntos o negativo
    $text = "\n\n << No ha introducido un número entero o positivo >>";
} elseif ($filas<0 || $filas>20) {
    $text = "Rango superior";
} else {
    $pintarTabla = true;
}
} 

?>



<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ej 2: Bucles. Formulario Columna</title>
    </head>
    <body>
    <center>
        <?php if($pintarTabla):?>
            <table border="1px">
                <tr><th>Columnas</th></tr>
              
                    <?php for($i=1; $i<=$filas;$i++):?>
                <tr><td><?=$i?></td></tr>
                
               <?php endfor;?>   
               
                  
                   
            </table>
        <br><br> <a href="ej3_BU-ALDR.php"><h2>Atras</h2></a>
           
            
            <?php else: ?>
                 <p><?=$text;?></p>
            
            <?php endif;?>

    </center>
        
    </body>
</html>