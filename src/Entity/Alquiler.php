<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AlquilerRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="tipo", type="string", length=5)
 * @ORM\DiscriminatorMap({
 *     "corto"="AlquilerReducido",
 *     "medio"="AlquilerMedio",
 *     "largo"="AlquilerProlongado"
 * })
 */
abstract class Alquiler
{
    const ALQ_MEDIO_INICIO = 5;
    const ALQ_MEDIO_FIN = 15;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Usuario", inversedBy="alquileres")
     * @ORM\JoinColumn(nullable=false)
     */
    private $usuario;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Departamento", inversedBy="alquileres")
     * @ORM\JoinColumn(nullable=false)
     */
    private $departamento;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha_inicio;

    /**
     * @ORM\Column(type="integer")
     */
    private $cantidad_dias;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $finalizado;

    protected function getAlquilerConcreto($cantidad_dias): Alquiler{
        if($cantidad_dias < $this::ALQ_MEDIO_INICIO){return new AlquilerReducido;}
        if(($cantidad_dias >= $this::ALQ_MEDIO_INICIO)&&($cantidad_dias <= $this::ALQ_MEDIO_FIN))
        {return new AlquilerMedio;}
        if($cantidad_dias > $this::ALQ_MEDIO_FIN){return new AlquilerProlongado;}
            
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getDepartamento(): ?Departamento
    {
        return $this->departamento;
    }

    public function setDepartamento(?Departamento $departamento): self
    {
        $this->departamento = $departamento;

        return $this;
    }

    public function getFechaInicio(): ?\DateTimeInterface
    {
        return $this->fecha_inicio;
    }

    public function setFechaInicio(\DateTimeInterface $fecha_inicio): self
    {
        $this->fecha_inicio = $fecha_inicio;

        return $this;
    }

    public function getCantidadDias(): ?int
    {
        return $this->cantidad_dias;
    }

    public function setCantidadDias(int $cantidad_dias): self
    {
        $this->cantidad_dias = $cantidad_dias;

        return $this;
    }

    public function getFinalizado(): ?bool
    {
        return $this->finalizado;
    }

    public function setFinalizado(?bool $finalizado): self
    {
        $this->finalizado = $finalizado;

        return $this;
    }
}
