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
        $codprod = $producto->getCod();
        
        if (array_key_exists($codprod, $this->carrito)) {
            
            if (!(intval($unidades) < 1)) {
                $total_unidades= $this->carrito[$codProd]['unidades'] += $unidades;
            
                if ($total_unidades < 1) {
                    unset($this->carrito[$codprod]);
                } else {
                    $this->carrito[$codprod]['unidades'] = $total_unidades;
                }
                
            }
            
        } else {
            $this->carrito[$codprod]['unidades'] = $unidades;
            $this->carrito[$codprod]['producto'] = $producto;
           
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
            
            if (!(intval($unidades) < 1)) {
                $total_unidades = intval($this->carrito[$codprod]['unidades']) - intval($unidades);
            
                if ($total_unidades < 1) {
                    unset($this->carrito[$codprod]);
                } else {
                    $this->carrito[$codprod]['unidades'] = $total_unidades;
                }
                
            }
            
        }
       
    }
    
    public function borrarCesta () {
         $this->carrito = [];
    }

}
