<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DepartamentoRepository")
 */
class Departamento
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ubicacion;

    /**
     * @ORM\Column(type="integer")
     */
    private $ambientes;

    /**
     * @ORM\Column(type="float")
     */
    private $metros_cuadrados;

    /**
     * @ORM\Column(type="float")
     */
    private $valor_noche;

    /**
     * @ORM\Column(type="float")
     */
    private $valor_mes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Alquiler", mappedBy="departamento")
     */
    private $alquileres;

    public function __construct()
    {
        $this->alquileres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUbicacion(): ?string
    {
        return $this->ubicacion;
    }

    public function setUbicacion(string $ubicacion): self
    {
        $this->ubicacion = $ubicacion;

        return $this;
    }

    public function getAmbientes(): ?int
    {
        return $this->ambientes;
    }

    public function setAmbientes(int $ambientes): self
    {
        $this->ambientes = $ambientes;

        return $this;
    }

    public function getMetrosCuadrados(): ?float
    {
        return $this->metros_cuadrados;
    }

    public function setMetrosCuadrados(float $metros_cuadrados): self
    {
        $this->metros_cuadrados = $metros_cuadrados;

        return $this;
    }

    public function getValorNoche(): ?float
    {
        return $this->valor_noche;
    }

    public function setValorNoche(float $valor_noche): self
    {
        $this->valor_noche = $valor_noche;

        return $this;
    }

    public function getValorMes(): ?float
    {
        return $this->valor_mes;
    }

    public function setValorMes(float $valor_mes): self
    {
        $this->valor_mes = $valor_mes;

        return $this;
    }

    /**
     * @return Collection|Alquiler[]
     */
    public function getAlquileres(): Collection
    {
        return $this->alquileres;
    }

    public function addAlquilere(Alquiler $alquilere): self
    {
        if (!$this->alquileres->contains($alquilere)) {
            $this->alquileres[] = $alquilere;
            $alquilere->setDepartamento($this);
        }

        return $this;
    }

    public function removeAlquilere(Alquiler $alquilere): self
    {
        if ($this->alquileres->contains($alquilere)) {
            $this->alquileres->removeElement($alquilere);
            // set the owning side to null (unless already changed)
            if ($alquilere->getDepartamento() === $this) {
                $alquilere->setDepartamento(null);
            }
        }

        return $this;
    }
}
