<?php

$pintarTabla = false;
$text = "";
$filas = "";

if ( isset($_POST["enviar"]) ) {
    $filas = $_POST["filas"];
    $columnas=$_POST["columnas"];
    
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

<html>
    <head>
        <title> Ej 3: Bucles. Formulario Columna</title>
    </head>
    <body>
    <center>
        <?php if($pintarTabla):?>
            <table border="1px">
                
              
                <?php for($i=1; $i<=$filas;$i++):?>
                <tr>
                    <?php for($j=1; $j<=$columnas;$j++):?>
                    <td><?="$i-$j"?></td>
                    <?php endfor;?>
                </tr>
                
               <?php endfor;?>     
                   
            </table>
        
        <br><br> <a href="ej3_BU-ALDR.php"><h2>Atras</h2></a>
            
            <?php else: ?>
                 <p><?=$text;?></p>
            
            <?php endif;?>
    </center>
         
    </body>
</html>