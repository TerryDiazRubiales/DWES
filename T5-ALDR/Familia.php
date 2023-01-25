<?php

class Familia {
   public $codFam;
   public $nombreFam;
   
   public function __construct($row) {
        $this->codFam = $row['cod'];
        $this->nombreFam = $row['nombre'];
   }
   
   public function setCodFam ($row) {
       $this->codFam = $row['cod'];
   }
   
   public function getCodFam () {
       return $this->codFam;
   }
   
   public function setNombreFam ($row) {
       $this->nombreFam = $row['nombre'];
   }
   
   public function getNombreFam () {
       return $this->nombreFam;
   }
   
}

?>