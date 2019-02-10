<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiControllerTest extends WebTestCase
{
    public function testListaDepartamentos()
    {
        $client = static::createClient();

        $client->request('GET', '/api/departamentos');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testRegistro()
    {
    	$client = static::createClient();

    	$data = array(
            '_nombre' => 'Bruce',
            '_apellido' => 'Wayne',
            '_email' => 'thebatman@gmail.com',
            '_password' => 'batpass'
        );

        $client->request('POST', '/api/registro', $data);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testRegistroDatosFaltantes()
    {
    	$client = static::createClient();

    	$data = array(
            '_nombre' => 'Bruce',
            '_email' => 'thebatman@gmail.com',
            '_password' => 'batpass'
        );

        $client->request('POST', '/api/registro', $data);

        $this->assertEquals(500, $client->getResponse()->getStatusCode());
    }

    public function testAltaDepartamento()
    {
    	$client = static::createClient();

    	$data = array(
            'ubicacion' => 'Avenida los Arrayanes 801, Lago Puelo, Chubut',
            'ambientes' => '2',
            'metros_cuadrados' => '64',
            'valor_noche' => '650',
            'valor_mes' => '15000'
        );

        $client->request('POST', '/api/add/departamento', $data);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAltaDepartamentoDatosFaltantes()
    {
    	$client = static::createClient();

    	$data = array(
            'ubicacion' => 'Avenida los Arrayanes 801, Lago Puelo, Chubut',
            'valor_noche' => '650',
            'valor_mes' => '15000'
        );

        $client->request('POST', '/api/add/departamento', $data);

        $this->assertEquals(500, $client->getResponse()->getStatusCode());
    }
    /*public function testAlquiler()
    {
    	$client = static::createClient();

        $login = array(
        	'email' => 'thebatman@gmail.com',
            'password' => 'batpass'
        );

        $client->request('POST', '/api/login_check', $data);

        $departamentos = $em->getRepository("App:Departamento")->findAll();

        //$this->assertEquals(200, $client->getResponse()->getStatusCode());
    }*/
}
