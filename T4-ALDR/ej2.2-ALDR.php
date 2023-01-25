<?php

if (isset($_POST['enviar'])) {
    $dsn = 'mysql:dbname=empresa;host=127.0.0.1';
    $user = 'empresa';
    $password = 'abc123.';
    
    // nos conectamos a la base de datos
    try {
        $bd = new PDO($dsn, $user, $password);
    } catch (Exception $ex) {
        die('<p>Error con la base de datos: ' . $ex->getMessage() . '</p>');
    }


    $usuario = $_POST['usuario'];
    $passwd = $_POST['clave'];
    
    $selectPrep = "SELECT * FROM usuarios WHERE nombre=:nombre AND clave=:clave";
    $prepare = $bd->prepare($selectPrep);
    $parametros = [':nombre'=> $usuario, ':clave' => $passwd];
    $prepare->execute($parametros);
    $filas = $prepare->rowCount();
    
    if ($filas == 0) {
        echo "¡Error! Usuario inexistentes";
    } else {
        header("Location: principal.php");
    }
} 



?>

<!DOCTYPE html>
<html>
    <head>
        <title>Ejercicio 2.2: Formulario de login</title>		
        <meta charset = "UTF-8">
    </head>
    <body>			
        
        <form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method = "POST">
            <label for = "usuario">Usuario</label> 
            <input value = "<?php if (isset($usuario)) echo $usuario; ?>"
                   id = "usuario" name = "usuario" type = "text">				

            <label for = "clave">Clave</label> 
            <input id = "clave" name = "clave" type = "password">			

            <input type = "submit" name="enviar" value="Enviar">
        </form>

    <center>
        <br><br> <a href="index.php"><h1>Inicio</h1></a>
        <a href="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>"><h1>Recargar</h1></a> <br>
    </center>
</body>
</html>
