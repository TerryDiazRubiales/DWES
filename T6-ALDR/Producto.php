<?php

class Producto implements JsonSerializable {
        protected $codigo;
        protected $nombre;
        protected $nombre_corto;
        protected $PVP;
        protected $codFam;
        
        public function jsonSerialize() {
            $array_producto = ['codigo'=>$this->getCodigo(),
                                'nombre_corto'=>$this->getNombre_corto(),
                                'PVP'=>$this->getPVP(),
                                'familia'=>$this->getCodFam()];
            
            return $array_producto;
        }
        
        public function muestra() {
            print "<p>" . $this->codigo . "</p>";
        }
        
        public function __construct($row) {
            $this->codigo = $row['cod'];
            $this->nombre = $row['nombre'];
            $this->nombre_corto = $row['nombre_corto'];
            $this->PVP = $row['PVP'];
            $this->codFam = $row['familia'];
        }
        
        public function getCodigo() {
            return $this->codigo;
        }

        public function getNombre() {
            return $this->nombre;
        }

        public function getNombre_corto() {
            return $this->nombre_corto;
        }

        public function getPVP() {
            return $this->PVP;
        }
        
        public function getCodFam() {
            return $this->codFam;
        }

    

}

    

?>