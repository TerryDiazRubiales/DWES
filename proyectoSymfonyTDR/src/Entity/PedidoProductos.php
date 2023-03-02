<?php

namespace App\Entity;

use App\Repository\PedidoProductosRepository;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=PedidoProductosRepository::class)
 */
class PedidoProductos
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $unidades;

    /**
     * @ORM\ManyToOne(targetEntity=Pedido::class, inversedBy="pedidoProductos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pedido;

    /**
     * @ORM\ManyToOne(targetEntity=Producto::class, inversedBy="pedidoProductos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $producto;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUnidades(): ?int
    {
        return $this->unidades;
    }

    public function setUnidades(int $unidades): self
    {
        $this->unidades = $unidades;

        return $this;
    }

    public function getPedido(): ?Pedido
    {
        return $this->pedido;
    }

    public function setPedido(?Pedido $pedido): self
    {
        $this->pedido = $pedido;

        return $this;
    }

    public function getProducto(): ?Producto
    {
        return $this->producto;
    }

    public function setProducto(?Producto $producto): self
    {
        $this->producto = $producto;

        return $this;
    }
}
