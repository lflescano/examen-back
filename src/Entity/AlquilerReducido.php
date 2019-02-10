<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class AlquilerReducido extends Alquiler
{
	public function getPrecioEstadia(){
		$precio = $this->cantidad_dias * $this->getDepartamento()->getValorNoche();
		return $this->getUsuario()->aplicarDescuentos($precio);
	}
}
