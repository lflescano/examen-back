<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class AlquilerProlongado extends Alquiler
{
    public function getPrecioEstadia(){
        $precio = intdiv($this->cantidad_dias, 30) * $this->getDepartamento()->getValorMes();
        $precio += ($this->cantidad_dias % 30) * $this->getDepartamento()->getValorNoche();
        $precio = $precio - ($precio * Alquiler::DESCUENTO_PROLONGADO);
        return $this->getUsuario()->aplicarDescuentos($precio);
    }
}
