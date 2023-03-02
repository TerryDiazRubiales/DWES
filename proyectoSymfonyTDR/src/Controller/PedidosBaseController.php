<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\Familia;
use App\Entity\Usuario;
use App\Service\CestaCompra;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Producto;


/**
* @IsGranted("ROLE_USER")
*/

class PedidosBaseController extends AbstractController
{
    /**
     * @Route("/familias", name="familias")
     */
    public function obtenerFamilias(ManagerRegistry $doctrine): Response
    {
       
        $familias = $doctrine->getRepository(Familia::class)->findAll();
        $argumento = ['familias' => $familias];
        return $this->render('pedidos_base/familias.html.twig', $argumento);
    }
    
    /**
     * @Route("/productos/{familia}", name="productos")
     */
    public function obtenerProductos(ManagerRegistry $doctrine, $familia): Response
    {
       
        $productos = $doctrine->getRepository(Familia::class)->find($familia)->getProductos();
        $argumento = ['productos' => $productos];
        return $this->render('pedidos_base/listado_productos.html.twig', $argumento);
    }
    
    /**
     * @Route("/anadir/{idProd}", name="anadir")
     */
    public function anadirProducto(ManagerRegistry $doctrine, $idProd, Request $request, CestaCompra $cesta): Response
    {
       $producto = $doctrine->getRepository(Producto::class)->find($idProd);
       $unidades = $request->request->get('unidades');
       
       $cesta->cargarProducto($unidades, $producto);
       $cesta->guardarCesta();
       
       // redirecciono a controlador de la cesta
       return $this->redirectToRoute('cesta');
    }
    
    /**
     * @Route("/eliminar/{cod_prod}", name="eliminar")
     */
    public function eliminarProd(ManagerRegistry $doctrine, $cod_prod, Request $request, CestaCompra $cesta): Response
    {
       $producto = $doctrine->getRepository(Producto::class)->find($cod_prod);
       $unidades = $request->request->get('unidades');
       
       $cesta->borrarProducto($unidades, $producto);
       $cesta->guardarCesta();
       
       // redirecciono a controlador de la cesta
       return $this->redirectToRoute('cesta');
    }
    
     /**
     * @Route("/cesta", name="cesta")
     */
    public function muestraCesta(CestaCompra $cesta): Response
    {
        $productos = $cesta->obtenerProductos();
        $precioTotal = $cesta->obtenerPrecioTotal();
        
        $argumento = ['productos' => $productos, 'precioTotal' => $precioTotal];
        return $this->render('pedidos_base/cesta.html.twig', $argumento);
    
     }
     
     
     /**
     * @Route("/pedido", name="pedido")
     */
     public function realizarPedido(CestaCompra $cesta): Response
    {
        
     }
     
     
}
