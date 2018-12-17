<?php

namespace App\Controller\ApiComunidad;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

class ApiPublicacionController extends FOSRestController
{
    /**
     * @Rest\Get("/api/comunidad/pubicacion/misPublicaciones/{username}", name="api_comunidad_publicacion_misPublicaciones")
     */
    public function busqueda($username)
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
}
