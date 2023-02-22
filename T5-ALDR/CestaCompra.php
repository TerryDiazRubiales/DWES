<?php
require_once './DB.php';

class CestaCompra {
    protected $carrito = [];
    
    public function cargar_articulo($codprod, $unidades) {
            
        // si el producto ya está en la cesta
        if (array_key_exists($codprod, $this->carrito)) {

            // $cesta[$codprod] = [$producto];
            $this->carrito[$codprod]['unidades'] += $unidades;
        } else {
            $producto = DB::obtiene_producto($codprod);
            $this->carrito[$codprod]['unidades'] = $unidades;
            $this->carrito[$codprod]['producto'] = $producto;
           
        }
     
    }

   public static function cargarCesta() {

        if (!isset($_SESSION['cesta'])) {
            // si no existe sesion, la crea
            $carrito = new CestaCompra();
            
        } else {
            // si existe la cesta
            // recupera la cesta de la sesion y la mete en variable cesta
            $carrito = $_SESSION['cesta'];
        }

        return $carrito;
    }

    public function guardarCesta() {
        $_SESSION['cesta'] = $this;
    }

    public function eliminar_Producto($codprod, $unidades) {

        $this->carrito[$codprod]['unidades'] -= $unidades;

        if ($this->carrito[$codprod]['unidades'] <= 0) {
            unset($this->carrito[$codprod]);
        }
    }
    
    public function estaVacia () {
        
        if (count($this->carrito) > 0) {
            return false;
        } else {
            return true;
        }
        
    }
   
    public function getCarrito() {
        return $this->carrito;
    }

   
   
}
