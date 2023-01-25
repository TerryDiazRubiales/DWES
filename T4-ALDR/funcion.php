<?php
function comprobarSession () {
    session_start();
    
    if (!isset($_SESSION['usuario'])) {
         header("Location: ej2.3-ALDR.php?redirigido=0");
    }
}

function comprobarSession2 () {
    session_start();
    
    if (!isset($_SESSION['usuario'])) {
         header("Location: ej3.1-ALDR.php?redirigido=0");
    }
}

function anadirProducto (&$cesta, $producto, $codprod) {
   
    // si el producto ya está en la cesta
        if (array_key_exists($codprod, $cesta)) {
            
            // $cesta[$codprod] = [$producto];
            $cesta[$codprod]['unidades']+=$producto['unidades'];
            
        } else {
            $cesta[$codprod] = $producto;
            
        }
        
      
}

function cargarCesta () {
   
    if (!isset($_SESSION['cesta'])) {
        $_SESSION['cesta'] = [];
    } 
    
    return $_SESSION['cesta'];
}

function guardarCesta ($cesta) {
    $_SESSION['cesta']=$cesta;
}

function quitarProducto (&$cesta, $producto, $codprod) {
    
    $cesta[$codprod]['unidades']-=$producto['unidad'];
    
    if ($cesta[$codprod]['unidades']<=0) {
        unset($cesta[$codprod]);
    }
   
    
}

?>
