<?php

namespace App\Controller\ApiComunidad;

use App\Entity\ComMeGustaPublicacion;
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
     * @Rest\Get("/api/comunidad/publicacion/publicaciones/{username}", name="api_comunidad_publicacion_publicaciones")
     */
    public function publicaciones($username)
    {
        if($username!=""){
            $arUsuario=InformacionGeneralController::usuarioExistente($username);
            if($arUsuario){
                $em=$this->getDoctrine();
                $arPublicacionUsuario=$em->getRepository('App\Entity\ComPublicacion')->listaPublicaciones($arUsuario->getCodigoUsuarioPk());
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
                return $em->getRepository('App\Entity\ComPublicacion')->crear($arUsuario->getCodigoUsuarioPk(),$data['datos']);

            }
        }
    }


    /**
     * @Rest\Post("/api/comunidad/publicacion/comentario/crear/{username}", name="api_comunidad_publicacion_comentario_crear")
     */
    public function crearComentario(Request $request, $username){
        $data=json_decode($request->getContent(),true);
        if($username!=""){
            $arUsuario=InformacionGeneralController::usuarioExistente($username);
            if($arUsuario){
                $em=$this->getDoctrine();
                return $em->getRepository('App\Entity\ComPublicacion')->crearComentario($arUsuario->getCodigoUsuarioPk(),$data['datos']);

            }
        }
    }

    /**
     * @Rest\Get("/api/comunidad/publicacion/meGusta/{username}/{publicacion}", name="api_comunidad_publicacion_meGusta")
     */
    public function meGustaPublicacion($username,$publicacion){
        $em=$this->getDoctrine()->getManager();
        $arUsuario=InformacionGeneralController::usuarioExistente($username);
        try{
            if($arUsuario){
                $arPublicacion=$em->getRepository('App\Entity\ComPublicacion')->find($publicacion);
                if($arPublicacion){
                    $arMegustaPublicacion=$em->getRepository('App\Entity\ComMeGustaPublicacion')->findOneBy(['codigoUsuarioFk'=>$username,'codigoPublicacionFk'=>$publicacion]);
                    if($arMegustaPublicacion){
                        $arPublicacion->setMeGusta($arPublicacion->getMeGusta()-1);
                        $em->persist($arPublicacion);
                        $em->remove($arMegustaPublicacion);
                    }else{
                        $arMegustaPublicacion=(new ComMeGustaPublicacion())
                            ->setFecha(new \DateTime('now'))
                            ->setUsuarioRel($arUsuario)
                            ->setPublicacionRel($arPublicacion);
                        $arPublicacion->setMeGusta($arPublicacion->getMeGusta()+1);
                        $em->persist($arPublicacion);
                        $em->persist($arMegustaPublicacion);

                    }
                    $em->flush();
                }
                return [
                'estado'=>true,
                'datos'=>[
                    'meGustas'=>$arPublicacion->getMeGusta(),
                    ],
                ];
            }
        }catch (\Exception $exception){
            return [
            'estado'=>false,
            'datos'=>[
                'message'=>$exception->getMessage(),
                ],
            ];
        }
    }

}
