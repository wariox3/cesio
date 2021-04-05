<?php

namespace App\Controller;


use App\Entity\Cupon;
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
                $fechaActual = date_create($fechaActual->format('Y-m-d'));
                if ($arUsuario->getFechaHabilitacion() < $fechaActual) {
                    $habilitado = false;
                }
                return [
                    'error' => false,
                    'autenticar' => true,
                    'codigoUsuario' => $arUsuario->getCodigoUsuarioPk(),
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
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $respuesta = $em->getRepository(Usuario::class)->apiRecuperarContrasena($raw);
        return $respuesta;
    }

    /**
     * @Rest\Post("/api/titu/usuario/perfil", name="api_titu_usuario_perfil")
     */
    public function perfil(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $respuesta = $em->getRepository(Usuario::class)->apiPerfil($raw);
        return $respuesta;
    }

    /**
     * @Rest\Post("/api/titu/cupon/aplicar", name="api_titu_cupon_aplicar")
     */
    public function cuponAplicar(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $respuesta = $em->getRepository(Cupon::class)->apiAplicar($raw);
        return $respuesta;
    }


}
