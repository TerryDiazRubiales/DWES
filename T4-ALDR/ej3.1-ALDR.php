<?php
$mensaje = " ";

if (isset($_REQUEST['redirigido'])) {
    $res = $_REQUEST['redirigido'];

    
    if ($res == 0) {
        $mensaje = " ¡Debes poner usuario y contraseña";
       
    } else {
        $mensaje = " ¡Conectado! ";
    }
}

$mensaje_logout = " ";
if (isset($_REQUEST['logout'])) {
    $mensaje_logout = " ¡Sesión cerrada! ";
}

// nos conectamos a la base de datos
$dsn = 'mysql:dbname=dwes2;host=127.0.0.1';
$user = 'dwes2';
$password = 'abc123.';

$mensaje_bderror = " ";
$mensaje_loginerror = " ";

try {

    if (isset($_POST['enviar'])) {
        // recogemos usuario y contraseña
        $usuario = $_POST['usuario'];
        $passwd = $_POST['clave'];
        
        $bd = new PDO($dsn, $user, $password);
        
        /* con esto comprobaremos si existe o no el usuario, 
         * si devuele fila "Existe", si no devuelve filas "No existe" */
        $selectPrep = "SELECT * FROM usuarios WHERE usuario=:nombre AND password=:clave";
        $prepare = $bd->prepare($selectPrep);
        $parametros = [':nombre' => $usuario, ':clave' => $passwd];
        $prepare->execute($parametros);
        $filas = $prepare->rowCount();

        // 
        if ($filas == 0) {
            $mensaje_loginerror = "¡Error! Usuario inexistentes";
        } else {
            session_start();
            
            /* si existe un login de usuario, te manda a una pagina 
             * para saber si quieres seguir con ese o cerrar sesion
             * (si es que entraste a login forzosamente) */
            if (isset($_SESSION['usuario'])) {
                header("Location: continuar_cerrar_sesion.php?iniciado=0");
                
            // si no, te conecta
            } else {
                $_SESSION['usuario'] = $usuario;
                header("Location: listado_familias.php");
            }
            
            
        }
    }
} catch (Exception $ex) {
    $mensaje_bderror = '<p>Error con la base de datos: ' . $ex->getMessage() . '</p>';
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Ejercicio 3.1: Login</title>		
        <meta charset = "UTF-8">
    </head>
    <body>			
        <!-- MENSAJES -->
        <?= $mensaje ?>
        <?= $mensaje_loginerror ?>
        <?= $mensaje_bderror ?>
        <?= $mensaje_logout ?>
        
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
