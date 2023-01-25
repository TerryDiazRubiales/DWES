<?php
// seleccionamos uno previo
$idioma = "esp";

// si ha enviado cogemos el idioma que se seleccionó
if(isset($_POST['enviar'])) {
    
    $idioma = $_POST['idioma'];
    setcookie('idioma', $idioma, time() + 3600 * 24);

// si no ha enviado se muestra el almacenado en cookie
} else {
    if (isset($_COOKIE['idioma'])) {
        $idioma = $_COOKIE['idioma'];
    }
}







?>

<html>
    <head>
        <title>Ejercicio 2.1</title>
    </head>
    
    <body>
        <h1>Selecciona un idioma para el contenido de la Web</h1>
        <form id="formulario" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
            <label>Idiomas:</label>
            <select name="idioma">
                
                <?php if(isset($idioma) && $idioma=="esp"): ?>
                    <option value="esp" selected> Español</option>
                    <option value="ing"> Ingles</option>
                    
                <?php elseif(isset($idioma) && $idioma=="ing"): ?>
                    <option value="esp"> Español</option>
                    <option value="ing" selected> Ingles</option>
                    
                <?php endif; ?> 
                <input type="submit" name="enviar" value="Enviar" />
                
            </select>
        </form>
        
        <!-- Contenido dependiendo del idioma -->
        <?php if($idioma=="ing"): ?>
            <h1>Tittle</h1>
            
        <?php elseif($idioma=="esp"): ?>
            <h1>Titulo</h1>
            
        <?php endif; ?>
        
        
        <center>
        <br><br> <a href="index.php"><h1>Inicio</h1></a>
        <a href="<?= htmlspecialchars($_SERVER['PHP_SELF'])?>"><h1>Recargar</h1></a> <br>
        </center>
    
    </body>
    
</html>
