<?php

namespace App\Entity;

use App\Repository\ProductoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Familia;

/**
 * @ORM\Entity(repositoryClass=ProductoRepository::class)
 */
class Producto
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\Column(type="integer")
     */
    private $precio;

    /**
     * @ORM\ManyToOne(targetEntity=familia::class, inversedBy="productos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $familia;

    /**
     * @ORM\OneToMany(targetEntity=PedidoProductos::class, mappedBy="producto", orphanRemoval=true)
     */
    private $pedidoProductos;

    /**
     * @ORM\Column(type="string", unique=true, length=255)
     */
    private $cod;

    public function __construct()
    {
        $this->pedidoProductos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getPrecio(): ?int
    {
        return $this->precio;
    }

    public function setPrecio(int $precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    public function getFamilia(): ?familia
    {
        return $this->familia;
    }

    public function setFamilia(?familia $familia): self
    {
        $this->familia = $familia;

        return $this;
    }

    /**
     * @return Collection<int, PedidoProductos>
     */
    public function getPedidoProductos(): Collection
    {
        return $this->pedidoProductos;
    }

    public function addPedidoProducto(PedidoProductos $pedidoProducto): self
    {
        if (!$this->pedidoProductos->contains($pedidoProducto)) {
            $this->pedidoProductos[] = $pedidoProducto;
            $pedidoProducto->setProducto($this);
        }

        return $this;
    }

    public function removePedidoProducto(PedidoProductos $pedidoProducto): self
    {
        if ($this->pedidoProductos->removeElement($pedidoProducto)) {
            // set the owning side to null (unless already changed)
            if ($pedidoProducto->getProducto() === $this) {
                $pedidoProducto->setProducto(null);
            }
        }

        return $this;
    }

    public function getCod(): ?string
    {
        return $this->cod;
    }

    public function setCod(string $cod): self
    {
        $this->cod = $cod;

        return $this;
    }
}
