<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class AlquilerProlongado extends Alquiler
{
    public function getPrecioEstadia(){
        $precio = intdiv($this->getCantidadDias(), 30) * $this->getDepartamento()->getValorMes();
        $precio += ($this->getCantidadDias() % 30) * $this->getDepartamento()->getValorNoche();
        $precio = $precio - ($precio * Alquiler::DESCUENTO_PROLONGADO);
        return $this->getUsuario()->aplicarDescuento($precio);
    }
}
