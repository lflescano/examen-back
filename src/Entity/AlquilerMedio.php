<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class AlquilerMedio extends Alquiler
{
	public function getPrecioEstadia(){
		$precio = $this->cantidad_dias * $this->getDepartamento()->getValorNoche();
		$precio = $precio - ($precio * Alquiler::DESCUENTO_MEDIO);
		return $this->getUsuario()->aplicarDescuentos($precio);
	}
}
