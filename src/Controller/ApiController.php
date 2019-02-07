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
     * @Rest\Post("/login_check", name="user_login_check")
     *
     * @SWG\Response(
     *     response=200,
     *     description="Usuario logeado exitosamente"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="El usuario no pudo iniciar sesion"
     * )
     *
     * @SWG\Parameter(
     *     name="_email",
     *     in="body",
     *     type="string",
     *     description="El email",
     *     schema={
     *     }
     * )
     *
     * @SWG\Parameter(
     *     name="_password",
     *     in="body",
     *     type="string",
     *     description="El password",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="Usuario")
     */
    public function loginCheckAction() {}
 
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
 
            $user = new Usuario();
            $user->setNombre($nombre);
            $user->setApellido($apellido);
            $user->setEmail($email);
            $user->setPassword($encoder->encodePassword($user, $password));
 
            $em->persist($user);
            $em->flush();
 
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
     * @SWG\Parameter(
     *     name="id",
     *     in="query",
     *     type="string",
     *     description="El ID del departamento"
     * )
     *
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
 
            //$userId = $this->getUser()->getId();
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
        $task = [];
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
                $alquiler->setFechaInicio($fechaInicio);
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
            'data' => $code == 201 ? $task : $message,
        ];
 
        return new Response($serializer->serialize($response, "json"));
    }
}