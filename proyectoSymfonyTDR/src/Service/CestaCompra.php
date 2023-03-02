<?php
/**
 * Description of CestaCompra
 *
 * @author aida
 */
namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;
use App\Entity\Producto;


class CestaCompra {
    
    protected $carrito=[];
    protected $requestStack;
    protected $sesion;
    
    public function __construct(RequestStack $requestStack ) {
        
        $this->requestStack=$requestStack;
        $this->sesion=$requestStack->getCurrentRequest()->getSession();
        $this->cargarCesta();
        
    }
    
    public function guardarCesta() {
        $this->sesion->set('cesta', $this->carrito); 
    }
    
    protected function cargarCesta() {
        
        if ($this->sesion->has('cesta')) {
            $this->carrito = $this->sesion->get('cesta');
            
        } else {
            $this->carrito = [];
            // $this->sesion->set('cesta', ''); 
        }
        
    }
    
    public function cargarProducto($unidades, Producto $producto) {
        $codProd = $producto->getCod();
        
        if (array_key_exists($codProd, $this->carrito)) {
            $this->carrito[$codProd]['unidades'] += $unidades;
            
        } else {
            $this->carrito[$codProd]['unidades'] = $unidades;
            $this->carrito[$codProd]['producto'] = $producto;
           
        }
    }
    
    public function obtenerProductos() {
        return $this->carrito;
    }
    
    public function obtenerPrecioTotal() {
        $precioTotal = 0;
        
        foreach ($this->carrito as $producto) {
            $precio = $producto['producto']->getPrecio();
            $unidades = $producto['unidades'];
            $subTotal = $precio * $unidades;
            $precioTotal += $subTotal;
        }
        
        return $precioTotal;
    }
    
     public function borrarProducto($unidades, Producto $producto) {
        $codprod = $producto->getCod();
        
        if (array_key_exists($codprod, $this->carrito)) {
            $unidades =  intval($this->carrito[$codprod]['unidades']);
            
            if ($unidades <= 1) {
                unset($this->carrito[$codprod]);
            } else {
                $this->carrito[$codprod]['unidades'] = intval($this->carrito[$codprod]['unidades']) -1;
            }
        }
       
    }
    
    public function borrarCesta () {
         $this->carrito = [];
    }

}
