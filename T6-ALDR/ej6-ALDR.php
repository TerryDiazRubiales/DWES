<?php
require_once './DB.php';


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
$mensaje_bderror = " ";
$mensaje_loginerror = " ";

if (isset($_POST['enviar'])) {
        // recogemos usuario y contraseña
        $usuario = $_POST['usuario'];
        $passwd = $_POST['clave'];
        
        try {
             /* con esto comprobaremos si existe o no el usuario, 
         * si devuele fila "Existe", si no devuelve filas "No existe" */
        $iniciar = DB::verificar_cliente($usuario, $passwd);
                
        if ($iniciar == false) {
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
        } catch (Exception $ex) {

        }
       
    }
  
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Ejercicio 1T6: Login</title>		
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
