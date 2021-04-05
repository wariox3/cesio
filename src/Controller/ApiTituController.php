<?php

namespace App\Controller;


use App\Entity\Cupon;
use App\Entity\Operador;
use App\Entity\Usuario;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class ApiTituController extends FOSRestController
{
    /**
     * @Rest\Post("/api/titu/usuario/autenticar", name="api_titu_usuario_autenticar")
     */
    public function autenticar(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $usuario = $raw['usuario'] ?? null;
        $clave = $raw['clave'] ?? null;
        if($usuario && $clave) {
            $arUsuario = $em->getRepository(Usuario::class)->findOneBy(array('usuario' => $usuario, 'clave' => $clave));
            if ($arUsuario) {
                $habilitado = true;
                $fechaActual = new \DateTime('now');
                if ($arUsuario->getFechaHabilitacion() < $fechaActual) {
                    $habilitado = false;
                }
                return [
                    'error' => false,
                    'autenticar' => true,
                    'operador' => $arUsuario->getCodigoOperadorFk(),
                    'fechaHabilitacion' => $arUsuario->getFechaHabilitacion(),
                    'estadoHabilitado' => $habilitado
                ];
            } else {
                return [
                    'error' => false,
                    'autenticar' => false
                ];
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => "Faltan datos para el consumo de la api"
            ];
        }
    }

    /**
     * @Rest\Post("/api/titu/usuario/nuevo", name="api_titu_usuario_nuevo")
     */
    public function nuevoUsuario(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $respuesta = $em->getRepository(Usuario::class)->apiNuevo($raw);
        return $respuesta;
    }

    /**
     * @Rest\Post("/api/titu/usuario/cambiarcontrasena", name="api_titu_usuario_cambiarcontrasena")
     */
    public function cambiarContrasena(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $respuesta = $em->getRepository(Usuario::class)->apiCambiarContrasena($raw);
        return $respuesta;
    }

    /**
     * @Rest\Post("/api/titu/usuario/recuperarcontrasena", name="api_titu_usuario_recuperarcontrasena")
     */
    public function recuperarcontrasena(Request $request)
    {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            $respuesta = $em->getRepository(Usuario::class)->apiRecuperarContrasena($raw);
            return $respuesta;
        } catch (\Exception $e) {
            return ['error' => 1, 'mensaje' => "Ocurrio un error en la api " . $e->getMessage(),];
        }
    }


}
