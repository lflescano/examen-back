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

    public function testCalculoAlquiler()
    {
    	$client = static::createClient();

        $client->request(
            'POST',
            '/api/login_check',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"_email":"thebatman@gmail.com","_password":"batpass"}'
        );
        $responseData = json_decode($client->getResponse()->getContent(), true);

        $alquiler = array(
            'fecha_inicio' => '25/03/2019',
            'cantidad_dias' => '15',
            'departamento_id' => '1'
        );
        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $responseData['token']));
        $client->request(
            'POST',
            '/api/alquilar/calculo_precio',
            $alquiler,
            [],
            ['CONTENT_TYPE' => 'application/json']
        );
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAlquiler()
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/login_check',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"_email":"thebatman@gmail.com","_password":"batpass"}'
        );
        $responseData = json_decode($client->getResponse()->getContent(), true);

        $alquiler = array(
            'fecha_inicio' => '25/03/2019',
            'cantidad_dias' => '15',
            'departamento_id' => '1'
        );
        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $responseData['token']));
        $client->request(
            'POST',
            '/api/alquilar',
            $alquiler,
            [],
            ['CONTENT_TYPE' => 'application/json']
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
