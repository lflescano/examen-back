<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsuarioRepository")
 */
class Usuario
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $apellido;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Alquiler", mappedBy="usuario")
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
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

    public function getApellido(): ?string
    {
        return $this->apellido;
    }

    public function setApellido(string $apellido): self
    {
        $this->apellido = $apellido;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

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
            $alquilere->setUsuario($this);
        }

        return $this;
    }

    public function removeAlquilere(Alquiler $alquilere): self
    {
        if ($this->alquileres->contains($alquilere)) {
            $this->alquileres->removeElement($alquilere);
            // set the owning side to null (unless already changed)
            if ($alquilere->getUsuario() === $this) {
                $alquilere->setUsuario(null);
            }
        }

        return $this;
    }
}
