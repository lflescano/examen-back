<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsuarioFixture extends Fixture
{
	private $encoder;
	public function __construct(UserPasswordEncoderInterface $encoder)
	{
	    $this->encoder = $encoder;
	}

    public function load(ObjectManager $manager)
    {
        $usuario = new Usuario();
        $usuario->setNombre('Bruce');
        $usuario->setApellido('Wayne');
        $usuario->setEmail('thebatman@gmail.com');
        $usuario->setPassword($this->encoder->encodePassword($usuario, 'batpass'));
        $manager->persist($usuario);
        $usuario2 = new Usuario();
        $usuario2->setNombre('Harvey');
        $usuario2->setApellido('Dent');
        $usuario2->setEmail('twofaces@gmail.com');
        $usuario2->setPassword($this->encoder->encodePassword($usuario2, 'yesno'));
        $manager->persist($usuario2);

        $manager->flush();
    }
}
