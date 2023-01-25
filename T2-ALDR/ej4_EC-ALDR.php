<?php
$edad = 0;
$text = "";
$estilo = "";

if ( isset($_POST['enviando']) ) {
    $edad = $_POST['edad'];
    $login =  $_POST['usuario'];
    
    if ($login == "" && $edad == "") {
        $text = "\n\n << Usted tiene que añadir un nombre y una edad >>";
    } elseif ($login == "") {
        $text = "\n\n << Usted tiene que añadir un nombre >>";
    } elseif ($edad == "") {
        $text = "\n\n << Usted tiene que añadir una edad >>";
    } elseif (!ctype_digit($edad)) { // comprobar si es digito, sin puntos o negativo
        $text = "\n\n << No ha introducido un número entero o positivo >>";
    } elseif ($edad<10) {
        $text = "\n\n Eres muy joven $login";
        $estilo = "rojo";
    } elseif ($edad>=10 && $edad<=20) {
        $text = "\n\n Que mala edad tienes $login";
        $estilo = "rojo";
    } elseif ($edad>=21 && $edad<=30) {
        $text = "\n\n Estas en el mejor momento $login";
        $estilo = "rojo";
    } elseif ($edad>30) {
        $text = "\n\n Que bien te veo $login";
        $estilo = "verde";
    } else {
        $text = "\n\n  << ¡Ninguna de las opciones! >> ";
    }
    

} 



?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Formulario edad</title>
<style>
	h1{
		text-align:center;
	}

	table{
		background-color:#FFC;
		padding:5px;
		border:#666 5px solid;
	}
	
	.rojo{
		font-size:18px;
		color:#F00;
		font-weight:bold;
		text-align:center;
	}
	
	.verde{
		font-size:18px;
		color:#0C3;
		font-weight:bold;
		text-align:center;
	}


</style>
</head>

<body>
<h1>INTRODUCE TU EDAD</h1>

<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" name="datos_usuario" id="datos_usuario">
  <table width="15%" align="center">
    <tr>
      <td>Nombre:</td>
      <td><label for="nombre_usuario"></label>
      <input type="text" name="usuario" id="usuario"></td>
    </tr>
    <tr>
      <td>Edad:</td>
      <td><label for="edad_usuario"></label>
      <input type="text" name="edad" id="edad"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="enviando" id="enviando" value="Enviar"></td>
    </tr>
  </table>
</form>

<?php
// A partir de aqui el ejercicio en si 
?>

<center>
    <p class='<?=$estilo?>'> <?=$text?> </p>
   
</center>


<br><br> <a href="index.php"><h1>Inicio</h1></a>
         <a href="<?= htmlspecialchars($_SERVER['PHP_SELF'])?>"><h1>Recargar</h1></a> <br>

</body>
</html>
