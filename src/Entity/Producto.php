<?php

namespace App\Entity;

use App\Repository\ProductoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductoRepository::class)]
class Producto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(unique: true)]
    private ?int $claveProducto = null;

    #[ORM\Column(length: 255)]
    private ?string $Nombre = null;

    #[ORM\Column]
    private ?float $Precio = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClaveProducto(): ?int
    {
        return $this->claveProducto;
    }

    public function setClaveProducto(int $claveProducto): static
    {
        $this->claveProducto = $claveProducto;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->Nombre;
    }

    public function setNombre(string $Nombre): static
    {
        $this->Nombre = $Nombre;

        return $this;
    }

    public function getPrecio(): ?float
    {
        return $this->Precio;
    }

    public function setPrecio(float $Precio): static
    {
        $this->Precio = $Precio;

        return $this;
    }
}
