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
        $sql = "SELECT * FROM usuarios WHERE usuario=:nombre";
        $verificado = false;
        
        try {
           $res = self::ejecuta_consulta_preparada($sql, [':nombre' => $usuario]);
           
           // comprobamos que hay resultados, depende de eso devuelve true o false
           $numFilas = $res->rowCount();
           
           if ($numFilas>0) {
            // aqui lo de comparar contrase??as hash y la otra para que sea correcta
                // saco todo de la consulta de arriba y lo guardo en $user
               $user = $res->fetch();
                // de $user, obtengo la contrase??a
               $hash = $user['password'];
                // las comparo
               $login_ok = password_verify($passwd, $hash);
              
               if ($login_ok) {
                   $verificado = true;
               } else {
                   $verificado = false;
               }
               
           } else {
              $verificado = false;
               
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
   
     public static function vacia ($productos) {
        
        if (count($productos) > 0) {
            return false;
        } else {
            return true;
        }
        
    }
    
     public static function obtiene_tv($cod_producto) {
        $sql = "SELECT producto.cod, producto.nombre_corto, producto.descripcion, producto.PVP, producto.familia, televisor.pulgadas, televisor.resolucion, televisor.panel FROM televisor INNER JOIN producto WHERE producto.cod = televisor.cod AND producto.cod = :cod_producto";
        $tv;
        
        try{
            $resultado = self::ejecuta_consulta_preparada($sql, [':cod_producto' => $cod_producto]);
          
            if( ($resultado->rowCount()>0)){
                $tv = new Televisor($resultado->fetch());
            }
            
        } catch (Exception $ex) {
            throw $ex;
        }
        return $tv;
    }
    
    public static function obtiene_sobremesa($cod_producto) {
        $sql = "SELECT producto.cod, producto.nombre_corto, producto.descripcion, producto.PVP, producto.familia, sobremesa.marca, sobremesa.modelo, sobremesa.procesador, sobremesa.ram, sobremesa.rom, sobremesa.extras FROM producto INNER JOIN sobremesa WHERE producto.cod = sobremesa.cod AND producto.cod = :cod_producto";
        $sobremesa;
        
        try {
            $resultado = self::ejecuta_consulta_preparada($sql, [':cod_producto' => $cod_producto]);
            
            if( ($resultado->rowCount()>0)){
                $sobremesa = new Sobremesa($resultado->fetch(PDO::FETCH_ASSOC));
            }
            
        } catch (Exception $exc) {
            throw $exc;
        }
        return $sobremesa;
    }
    
}

?>