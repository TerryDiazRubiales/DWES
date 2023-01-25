<?php
require './tabla_columna.php';
?>

<html>
<head>

  <title>
    Ej 2: Bucles. Formulario Columna
  </title>
</head>

<body>
    <center>
  <h1>Tabla de una columna (Formulario)</h1>

  <form action="tabla_columna.php" method="post">
    <p>Escriba un número (0 &lt; número &le; 200) y mostraré una tabla de una columna
      y tantas filas como indique.
    </p>

    <p><label>Número de filas: <input type="text" name="filas" min="1" max="200" value="10"></label></p>

    <p>
      <input type="submit" name="enviar" value="Mostrar">
      <input type="reset" value="Borrar">
    </p>
  </form>
  
  
    <br><br> <a href="index.php"><h1>Inicio</h1></a>
             <a href="<?= htmlspecialchars($_SERVER['PHP_SELF'])?>"><h1>Recargar</h1></a> <br>

  </center> 

</body>
</html>



