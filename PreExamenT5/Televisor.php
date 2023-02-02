<?php
require_once './Producto.php';

class Televisor extends Producto {
    public $pulgadas;
    public $resolucion;
    public $panel;
    
    public function __construct($row) {
    parent::__construct($row);
        $this->pulgadas = $row['pulgadas'];
        $this->resolucion = $row['resolucion'];
        $this->panel = $row['panel'];
    }
    
    public function getPulgadas() {
        return $this->pulgadas;
    }
    
    public function getResolucion() {
        return $this->resolucion;
    }

    public function getPanel() {
        return $this->panel;
    }

}
