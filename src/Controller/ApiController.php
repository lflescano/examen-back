<?php
/**
 * ApiController.php
 *
 * API Controller
 *
 * @category   Controller
 */
 
namespace App\Controller;
 
use App\Entity\Usuario;
use App\Entity\Alquiler;
use App\Entity\Departamento;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
/**
 * Class ApiController
 *
 * @Route("/api")
 */
class ApiController extends FOSRestController
{
    /**
     * @Rest\Post("/registro", name="user_register")
     *
     * @SWG\Response(
     *     response=201,
     *     description="El usuario se registro correctamente"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="El usuario no pudo registrarse"
     * )
     *
     * @SWG\Parameter(
     *     name="_nombre",
     *     in="body",
     *     type="string",
     *     description="El nombre",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="_apellido",
     *     in="body",
     *     type="string",
     *     description="El apellido",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="_email",
     *     in="body",
     *     type="string",
     *     description="El email",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="_password",
     *     in="query",
     *     type="string",
     *     description="El password"
     * )
     *
     * @SWG\Tag(name="Registro")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $encoder) {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
 
        $user = [];
        $message = "";
 
        try {
            $code = 200;
            $error = false;
 
            $nombre = $request->request->get('_nombre');
            $apellido = $request->request->get('_apellido');
            $email = $request->request->get('_email');
            $password = $request->request->get('_password');
            if(!is_null($nombre) && !is_null($apellido) && !is_null($email) && !is_null($password)){
                $user = new Usuario();
                $user->setNombre($nombre);
                $user->setApellido($apellido);
                $user->setEmail($email);
                $user->setPassword($encoder->encodePassword($user, $password));
     
                $em->persist($user);
                $em->flush();
            }
            else {
                $code = 500;
                $error = true;
                $message = "Ocurrio un error durante el registro del usuario - Error: Debe completar todos los campos requeridos";
            }
 
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Ocurrio un error durante el registro del usuario - Error: {$ex->getMessage()}";
        }
 
        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $user : $message,
        ];
 
        return new Response($serializer->serialize($response, "json"));
    }
    /**
     * @Rest\Get("/departamentos", name="lista_departamentos", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Listado de departamentos disponibles."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Ocurrio un error al tratar de recuperar los departamentos."
     * )
     *
     * @SWG\Tag(name="Departamentos")
     */
    public function getDepartamentos(Request $request) {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        $departamentos = [];
        $message = "";
 
        try {
            $code = 200;
            $error = false;
 
            $departamentos = $em->getRepository("App:Departamento")->findAll();
 
            if (is_null($departamentos)) {
                $departamentos = [];
            }
 
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Ocurrio un error al tratar de recuperar los departamentos - Error: {$ex->getMessage()}";
        }
 
        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $departamentos : $message,
        ];
 
        return new Response($serializer->serialize($response, "json"));
    }

    /**
     * @Rest\Post("/add/departamento", name="departamento_add", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=201,
     *     description="El departamento se agrego exitosamente"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Ocurrio un error al tratar de crear el departamento"
     * )
     *
     * @SWG\Parameter(
     *     name="ubicacion",
     *     in="body",
     *     type="string",
     *     description="La ubicacion",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="ambientes",
     *     in="body",
     *     type="string",
     *     description="Los ambientes",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="metros_cuadrados",
     *     in="body",
     *     type="string",
     *     description="Los metros cuadrados",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="valor_noche",
     *     in="body",
     *     type="string",
     *     description="El valor por noche",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="valor_mes",
     *     in="body",
     *     type="string",
     *     description="El valor por mes",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="Departamentos")
     */
    public function addDepartamentoAction(Request $request) {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        $departamento = null;
        $message = "";
 
        try {
           $code = 201;
           $error = false;

           $ubicacion = $request->request->get('ubicacion');
           $ambientes = $request->request->get('ambientes');
           $metros_cuadrados = $request->request->get('metros_cuadrados');
           $valor_noche = $request->request->get('valor_noche');
           $valor_mes = $request->request->get('valor_mes');
 
           if (!is_null($ubicacion) && !is_null($ambientes) && !is_null($metros_cuadrados) && !is_null($valor_noche) && !is_null($valor_mes)) {
               $departamento = new Departamento();
               $departamento->setUbicacion($ubicacion);
               $departamento->setAmbientes($ambientes);
               $departamento->setMetrosCuadrados($metros_cuadrados);
               $departamento->setValorNoche($valor_noche);
               $departamento->setValorMes($valor_mes);
 
               $em->persist($departamento);
               $em->flush();
 
           } else {
               $code = 500;
               $error = true;
               $message = "Ocurrio un error al tratar de crear un departamento - Error: Debe completar todos los campos requeridos";
           }
 
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Ocurrio un error al tratar de crear un departamento - Error: {$ex->getMessage()}";
        }
 
        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 201 ? $departamento : $message,
        ];
 
        return new Response($serializer->serialize($response, "json"));
    }
	/**
     * @Rest\Post("/alquilar", name="alquilar_departamento", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=201,
     *     description="El departamento fue alquilado exitosamente"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Ocurrio un erro al tratar de alquilar el departamento"
     * )
     *
     * @SWG\Parameter(
     *     name="fecha_inicio",
     *     in="body",
     *     type="date",
     *     description="La fecha de inicio",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="cantidad_dias",
     *     in="body",
     *     type="integer",
     *     description="La cantidad de dias",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="departamento_id",
     *     in="body",
     *     type="integer",
     *     description="El ID del departamento alquilado",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="Alquilar")
     */
    public function alquilerAction(Request $request) {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        $alquiler = null;
        $message = "";
 
        try {
            $code = 201;
            $error = false;

            $userId = $this->getUser()->getId();

            $fechaInicio = $request->request->get("fecha_inicio", null);
            $cantidadDias = $request->request->get("cantidad_dias", null);
            $departamentoId= $request->request->get("departamento_id", null);
 
            if (!is_null($fechaInicio) && !is_null($cantidadDias) && !is_null($departamentoId)) {
                $alquiler = Alquiler::getAlquilerConcreto($cantidadDias);
                $usuario = $em->getRepository("App:Usuario")->find($userId);
                $departamento = $em->getRepository("App:Departamento")->find($departamentoId);
                $alquiler->setUsuario($usuario);
                $alquiler->setDepartamento($departamento);
                $alquiler->setFechaInicio(\DateTime::createFromFormat('d/m/Y', $fechaInicio));
                $alquiler->setCantidadDias($cantidadDias);
 
                $em->persist($alquiler);
                $em->flush();
 
            } else {
                $code = 500;
                $error = true;
                $message = "Ocurrio un error al tratar de alquilar el departamento - Error: Debe completar todos los campos requeridos";
            }
 
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Ocurrio un error al tratar de alquilar el departamento - Error: {$ex->getMessage()}";
        }
 
        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 201 ? $alquiler : $message,
        ];
 
        return new Response($serializer->serialize($response, "json"));
    }

    	/**
     * @Rest\POST("/alquilar/calculo_precio", name="calcular_precio", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Calculo de precio de un alquiler"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Ocurrio un error al calcular el precio del alquiler"
     * )
     *
     * @SWG\Parameter(
     *     name="fecha_inicio",
     *     in="body",
     *     type="date",
     *     description="La fecha de inicio",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="cantidad_dias",
     *     in="body",
     *     type="integer",
     *     description="La cantidad de dias",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="departamento_id",
     *     in="body",
     *     type="integer",
     *     description="El ID del departamento alquilado",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="Alquilar")
     */
    public function calcularAction(Request $request) {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        $precio = null;
        $message = "";
 
        try {
            $code = 200;
            $error = false;

            $userId = $this->getUser()->getId();

            $fechaInicio = $request->request->get("fecha_inicio", null);
            $cantidadDias = $request->request->get("cantidad_dias", null);
            $departamentoId= $request->request->get("departamento_id", null);
 
            if (!is_null($fechaInicio) && !is_null($cantidadDias) && !is_null($departamentoId)) {
                $alquiler = Alquiler::getAlquilerConcreto($cantidadDias);
                $usuario = $em->getRepository("App:Usuario")->find($userId);
                $departamento = $em->getRepository("App:Departamento")->find($departamentoId);
                $alquiler->setUsuario($usuario);
                $alquiler->setDepartamento($departamento);
                $alquiler->setFechaInicio(\DateTime::createFromFormat('d/m/Y', $fechaInicio));
                $alquiler->setCantidadDias($cantidadDias);
 				$precio = $alquiler->getPrecioEstadia();
            } else {
                $code = 500;
                $error = true;
                $message = "Ocurrio un error al calcular el precio del alquiler - Error: Debe completar todos los campos requeridos";
            }
 
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "Ocurrio un error al calcular el precio del alquiler - Error: {$ex->getMessage()}";
        }
 
        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? ['precio' => $precio] : $message,
        ];
 
        return new Response($serializer->serialize($response, "json"));
    }
}