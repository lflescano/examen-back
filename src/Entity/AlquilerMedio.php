<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class AlquilerMedio extends Alquiler
{
	public function getPrecioEstadia(){
		$precio = $this->getCantidadDias() * $this->getDepartamento()->getValorNoche();
		$precio = $precio - ($precio * Alquiler::DESCUENTO_MEDIO);
		return $this->getUsuario()->aplicarDescuento($precio);
	}
}
