<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Familia;
use App\Entity\Usuario;
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
}
