<?php
$text = "";

$idiomas = ["español", "inglés", "francés", "italiano"];
$palabras = [
    ["perro", "dog", "chien", "cane"],
    ["gato", "cat", "chat", "gatto"],
    ["enero", "january", "janvier", "gennaio"],
    ["feliz", "happy", "heureux", "felice"],
    ["viernes", "friday", "vendredi", "venerdì"],
    ["instituto", "high school", "lycée", "istituto"],
    ["vacaciones", "holidays", "vacances", "vazanze"],
    // ["noniná", "", "", ""]
];

$fila = mt_rand(0, count($palabras)-1); // fila (palabras)
$columna = mt_rand(1, count($idiomas)-1); // columnas (idiomas)

$text = " < ".$palabras[$fila][$columna]." > quiere decir < ".$palabras[$fila][0]." > en ".$idiomas[$columna]; 

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>
    Ej 8: Arrays. Diccionario multilingüe.
  </title>
</head>

<body>
  <center>
    <h1>Diccionario multilingüe</h1>

    <?= $text ?>
 
    <br><br> <a href="index.php"><h1>Inicio</h1></a>
            <a href="<?= htmlspecialchars($_SERVER['PHP_SELF'])?>"><h1>Recargar</h1></a> <br>
  </center>
</body>
</html>
