<?php
// Definimos las variables
$codColor = 'white';
$arrayColores = ['rojo'=>'#ff0000', 
    'amarillo'=>'#ffff00', 
    'azul'=>'#0000ff',
    'naranja'=>'#ff8000'];

// Capturo la información del formulario
// Si se ha pulsado el boton, ha mandado algo
if ( isset($_POST['enviar']) ) {
    $codColor = $_POST['colores'];
} 

?>

<html>
    <head>
         <title>Ej5: Arrays</title>
    </head>
    <body bgcolor="<?=$codColor?>">
        <center>
            <h1>EJERCICIO 5</h1> <br>
            
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
                
                <select name='colores'>
                    <?php foreach($arrayColores as $nombreColor=>$codHex): ?>
                    
                        <?php if ($codColor==$codHex): ?>
                            <option selected value='<?= $codHex ?>'> <?= $nombreColor ?> </option>;
                        
                        <?php else: ?>
                             <option value='<?= $codHex ?>'> <?= $nombreColor ?> </option>;
                        <?php endif; ?>
                          
                    <?php endforeach; ?> 
                    <input type="submit" value="enviar" name="enviar"/>
                </select>
                
            </form>
           
            <?= $codColor ?>
            
            
            
            <br><br> <a href="index.php"><h1>Inicio</h1></a>
            <a href="<?= htmlspecialchars($_SERVER['PHP_SELF'])?>"><h1>Recargar</h1></a> <br>
        </center>
    </body>
   
</html>