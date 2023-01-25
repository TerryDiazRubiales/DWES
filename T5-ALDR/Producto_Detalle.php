<?php

class Producto_Detalle extends Producto {
     public $pulgadas;
      public $panel;
      
      public function __construct($row) {
          parent::__construct($row);
          $this->pulgadas = $row['pulgadas'];
          $this->panel = $row['panel'];
      }
      
      public function getPulgadas() {
          return $this->pulgadas;
      }

      public function getPanel() {
          return $this->panel;
      }


}
