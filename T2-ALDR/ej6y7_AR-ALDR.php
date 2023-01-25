<?php
$arrayBits = [];
$arrayInverso = [];
define("NUMBITS",10); // definimos una constante con nombre  

// generamos el array de bits
for ($i=0; $i<NUMBITS; $i++) {
    $arrayBits[] = rand(0,1);  
}

// cambiamos los 1 por los 0 y al contrario
for ($i=0; $i<NUMBITS; $i++) {
    if ($arrayBits[$i]==1) {
        $arrayInverso[$i]=0;
    } else {
       $arrayInverso[$i]=1; 
    }  
}

?>

<html>
    <head>
         <title>Ej6y7: Arrays</title>
    </head>
    <body>
        <center>
            <h1>EJERCICIO 6 y 7</h1> <br>
            
            <table>
                <tr>
                    <?php for ($i=0; $i<NUMBITS;$i++): ?>
                    <td> <?= $arrayBits[$i] ?> </td>
                    <?php endfor; ?>
                </tr>
            </table>
            <table>
                <tr>
                    <?php for ($i=0; $i<NUMBITS;$i++): ?>
                    <td> <?= $arrayInverso[$i] ?> </td>
                    <?php endfor; ?>
                </tr>
            </table>
            
            <br><br> <a href="index.php"><h1>Inicio</h1></a>
            <a href="<?= htmlspecialchars($_SERVER['PHP_SELF'])?>"><h1>Recargar</h1></a> <br>
        </center>
    </body>
   
</html>

