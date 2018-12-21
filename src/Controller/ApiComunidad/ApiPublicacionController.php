<?php

namespace App\Controller\ApiComunidad;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

class ApiPublicacionController extends FOSRestController
{
    /**
     * @Rest\Get("/api/comunidad/publicacion/misPublicaciones/{username}", name="api_comunidad_publicacion_misPublicaciones")
     */
    public function misPublicaciones($username)
    {
        if($username!=""){
            $arUsuario=InformacionGeneralController::usuarioExistente($username);
            if($arUsuario){
            $em=$this->getDoctrine();
            $arPublicacionUsuario=$em->getRepository('App\Entity\ComPublicacion')->listaMisPublicaciones($arUsuario->getCodigoUsuarioPk());
            return [
                'estado'=>true,
                'datos'=>$arPublicacionUsuario,
            ];
            }
        }
    }

    /**
     * @Rest\Post("/api/comunidad/publicacion/crear/{username}", name="api_comunidad_publicacion_crear")
     */
    public function crearPublicacion(Request $request, $username){
        $data=json_decode($request->getContent(),true);
        if($username!=""){
            $arUsuario=InformacionGeneralController::usuarioExistente($username);
            if($arUsuario){
                $em=$this->getDoctrine();
                return $em->getRepository('App\Entity\ComPublicacion')->crear($arUsuario->getCodigoUsuarioPk(),$data['data']);

            }
        }
    }
}
