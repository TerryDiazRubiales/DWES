<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of CestaCompra
 *
 * @author aida
 */
class CestaCompra {
    
    protected $carrito=[];
    private $requestStack;
    protected $sesion;
    
    public function __construct(RequestStack $requestStack ) {
        
        $this->requestStack=$requestStack;
        $this->sesion=$requestStack->getCurrentRequest()->getSession();
        $this->cargarCesta();
        
    }
    
    public function guardarCesta() {
        $this->sesion->set('cesta', $this->carrito); 
    }
    
    public function cargarCesta() {
        
        if ($this->sesion->has('cesta')) {
            $this->sesion->get('cesta');
            
        } else {
            $this->sesion->set('cesta', ); 
        }
        
    }

}
