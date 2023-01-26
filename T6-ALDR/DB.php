<?php
include_once './constantes.php';
include_once './Familia.php';
include_once './Producto.php';

class DB {
    
     protected static function ejecuta_consulta_preparada ($consulta, $parametros) {
         
         try {
            $bd = new PDO(dsn, user, password);

            $resultado = $bd->prepare($consulta);
            $resultado->execute($parametros);
           
            /* $produc = $prepare->fetchAll();
            return $produc; */
            
            return $resultado;
            
        } catch (Exception $exc) {
            throw $exc;
        }
        
    }
     
    protected static function ejecuta_consulta_sinPreparar ($consulta) {
        
        try {
            $bd = new PDO(dsn, user, password);

            $resultado = $bd->query($consulta);

            return $resultado;
            
        } catch (Exception $exc) {
            throw $ex;
        }
        
    }
     
    public static function obtiene_familias () {
        $sql = "SELECT * FROM familia";
        // se crea un array vacio
        $familias = [];
        
        try {
           $res = self::ejecuta_consulta_sinPreparar($sql);
           
           // se recorre res y se saca las filas para meterlo luego en el objeto de la clase familia
           foreach ($res as $fila) {
               // en el array vacio se crea un objeto de la clase familia y se mete en el array
               $familias[] = new Familia ($fila);
           }
               
           
        } catch (Exception $exc) {
           throw $exc;
        }
        
        return $familias;
 
    }
    
    // hacer igual que en obtener_familias
    public static function obtiene_productos ($codFam) {
        $sql = "SELECT cod, nombre, nombre_corto, PVP, familia FROM producto WHERE familia=:familia";
        $productos = [];
        
        try {
            
           $res = self::ejecuta_consulta_preparada($sql, [':familia' => $codFam]);
           // $res = self::ejecuta_consulta_sinPreparar($sql);
           $produc = $res->fetchAll();
           
            foreach ($produc as $fila) {
               $productos[] = new Producto ($fila);
           }
             
           
        } catch (Exception $exc) {
           throw $exc;
        }
        
        return $productos;
    }
    
    // aqui no, aqui solo devuelve truo o false dependiendo de si existe o no
    public static function verificar_cliente ($usuario, $passwd) {
        $sql = "SELECT * FROM usuarios WHERE usuario=:nombre AND password=:clave";
        $verificado = false;
        
        try {
           $res = self::ejecuta_consulta_preparada($sql, [':nombre' => $usuario, ':clave' => $passwd]);
            
           $numFilas = $res->rowCount();
           
           if ($numFilas==0) {
               $verificado = false;
               
           } else {
               $verificado = true;
           }
           
        } catch (Exception $exc) {
           throw $exc;
        }
      
        return $verificado;
        
    }
    
    public static function obtiene_producto ($cod_prod) {
        // hacer lo de antes para sacar de un producto indicado
        $sql = "SELECT * FROM producto WHERE cod=:codProd";
        
        $producto;
        
        try {
            
           $res = self::ejecuta_consulta_preparada($sql, [':codProd' => $cod_prod]);
           
           $prod = $res->fetch();
            
           $producto = new Producto ($prod);
            
                        
        } catch (Exception $exc) {
           throw $exc;
        }
        
        return $producto;
        
    }
    
     public static function obtiene_tv ($cod) {
        $sql = "SELECT televisor.*, producto.nombre, producto.nombre_corto, producto.PVP, producto.familia FROM televisor, producto WHERE televisor.cod=:codigo AND producto.cod=televisor.cod;";
        $tv = [];
        
        try {
           $res = self::ejecuta_consulta($sql, [':codigo' => $cod]);
           // return $res->fetchAll();
           
            foreach ($res as $fila) {
               $tv[] = new Producto_Detalle ($fila);
           }
             
           
        } catch (Exception $exc) {
           throw $exc;
        }
        
     }
     
     public static function vacia ($productos) {
        
        if (count($productos) > 0) {
            return false;
        } else {
            return true;
        }
        
    }
    
    
    
}

?>