<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\Producto;
use App\Entity\Pedido;
use App\Entity\PedidoProductos;
use App\Entity\Familia;
use App\Entity\Usuario;
use App\Service\CestaCompra;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Swift_Mailer;

/**
* @IsGranted("ROLE_USER")
*/

class PedidosBaseController extends AbstractController
{
    private $mailer;
    
    public function __construct(Swift_Mailer $mailer) {
        $this->mailer = $mailer;
    }
    
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
     public function realizarPedido(Request $request, ManagerRegistry $doctrine, CestaCompra $cesta): Response
    {
        $error = false;
         
        $productos = $cesta->obtenerProductos();
        $precioTotal = $cesta->obtenerPrecioTotal();
        
        $entityManager = $doctrine->getManager();
        
        $pedido = new Pedido ();
        $pedido->setFecha(\DateTime::createFromFormat('Y-m-d',date("Y-m-d")));
        $pedido->setUsuario($this->getUser());
        $pedido->setCoste($precioTotal);
        
        $entityManager->persist($pedido);
        
        foreach ($productos as $producto) {
            $pedProd = new PedidoProductos ();
            
            $produc = $doctrine->getRepository(Producto::class)->find($producto['producto']->getId());
            $pedProd->setProducto($produc);
            
            $pedProd->setUnidades($producto['unidades']);
            $pedProd->setPedido($pedido);
            
            $entityManager->persist($pedProd);
           
        }
        
         try {
             $entityManager->flush();
             
         } catch (Exception $ex) {
             $error = true;
             
         }
        
         if($error==true) {
            
            $mensaje = "Hubo un error";
            return $this->render('pedidos_base/pedido.html.twig', array('error'=>$mensaje,'pedido_id'=>$pedido->getId(),'usuario'=>$this->getUser()->getUsername(),'cesta'=>$productos, 'precio'=>$precioTotal));
        
         } else {
             
             $cesta->borrarCesta();
             $cesta->guardarCesta();
             $mensaje = false;
             return $this->render('pedidos_base/pedido.html.twig', array('error'=>$mensaje,'pedido_id'=>$pedido->getId(),'usuario'=>$this->getUser()->getUsername(),'cesta'=>$productos, 'precio'=>$precioTotal));
             
         }
         
         $message = (new \Swift_Message('Confirmación de pedido'))
          ->setFrom('aidadeprueba@gmail.com')
          ->setTo($usuario->getEmail())
          ->setBody(
            $this->renderView(
                'pedidos_base/confirmacion_pedido.html.twig',
                ['pedido' => $pedido, 'cesta' => $cesta->obtenerProductos()]
            ),
            'text/html'
         );
        $this->mailer->send($message);
        
        
         
     }
     
     /**
     * @Route("/pedidos", name="pedidos")
     */
     public function historial(ManagerRegistry $doctrine): Response
    {
         $pedidos = $doctrine->getRepository(Pedido::class)->findBy(array('usuario'=>$this->getUser()));
         return $this->render('pedidos_base/pedidos.html.twig', array('pedidos'=>$pedidos));
             
     }
     
}
