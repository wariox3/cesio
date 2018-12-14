<?php

namespace App\Controller\ApiComunidad;

use App\Entity\SocSolicitud;
use App\Entity\ComUsuarioAmigo;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use http\Env\Request;

class ApiBusquedaController extends FOSRestController
{
    /**
     * @Rest\Get("/api/social/busqueda/{username}/{palabraClave}", name="api_social_busqueda")
     */
    public function busqueda($username, $palabraClave)
    {
        if($palabraClave!=""){
            $em=$this->getDoctrine();
            $arSocUsuario=$em->getRepository('App\Entity\ComUsuario')->lista($palabraClave, $username);
            return [
                'estado'=>true,
                'datos'=>$arSocUsuario,
            ];
        }
    }

    /**
     * @Rest\Get("/api/social/enviarSolicitud/{usernameSolicitante}/{usernameSolicitado}", name="api_social_enviarSolicitud")
     */
    public function agregarSolicitud($usernameSolicitante, $usernameSolicitado)
    {
        try{

            $em=$this->getDoctrine()->getManager();
            $arSocUsuarioSolicitante=$em->getRepository('App\Entity\ComUsuario')->find($usernameSolicitante);
            $arSocUsuarioSolicitado=$em->getRepository('App\Entity\ComUsuario')->find($usernameSolicitado);
            $arSolicitud=(new ComUsuarioAmigo())
                ->setUsuarioRel($arSocUsuarioSolicitante)
                ->setUsuarioAmigoRel($arSocUsuarioSolicitado)
                ->setFechaAgregado(new \DateTime('now'))
                ->setEstado("solicitud");
            $em->persist($arSolicitud);
            $em->flush();
            return [
                'estado'=>true,
            ];
        }
        catch (\Exception $exception){
            return[
                'estado'=>false,
                'error' =>$exception->getMessage(),
            ];
        }
    }

    /**
     * @Rest\Get("/api/social/eliminarAmigo/{usernameSolicitante}/{usernameSolicitado}", name="api_social_eliminarAmigo")
     */
    public function eliminarAmigo($usernameSolicitante, $usernameSolicitado)
    {
        try{

            $em=$this->getDoctrine()->getManager();
            $arUsuarioAmigo=$em->getRepository('App\Entity\ComUsuarioAmigo')->findOneBy(['codigoUsuarioFk'=>$usernameSolicitante,'codigoUsuarioEsAmigoFk'=>$usernameSolicitado]);
            if(!$arUsuarioAmigo){
                $arUsuarioAmigo=$em->getRepository('App\Entity\ComUsuarioAmigo')->findOneBy(['codigoUsuarioFk'=>$usernameSolicitado,'codigoUsuarioEsAmigoFk'=>$usernameSolicitante]);
            }
            $em->remove($arUsuarioAmigo);
            $em->flush();
            return [
                'estado'=>true,
            ];
        }
        catch (\Exception $exception){
            return[
                'estado'=>false,
                'error' =>$exception->getMessage(),
            ];
        }
    }

    /**
     * @Rest\Get("/api/social/aceptarAmigo/{usernameSolicitante}/{usernameSolicitado}", name="api_social_aceptarAmigo")
     */
    public function agregarAmigo($usernameSolicitante, $usernameSolicitado)
    {
        try{

            $em=$this->getDoctrine()->getManager();
            $arUsuarioAmigo=$em->getRepository('App\Entity\ComUsuarioAmigo')->findOneBy(['codigoUsuarioFk'=>$usernameSolicitante,'codigoUsuarioEsAmigoFk'=>$usernameSolicitado]);
            if(!$arUsuarioAmigo){
                $arUsuarioAmigo=$em->getRepository('App\Entity\ComUsuarioAmigo')->findOneBy(['codigoUsuarioFk'=>$usernameSolicitado,'codigoUsuarioEsAmigoFk'=>$usernameSolicitante]);
            }
            $arUsuarioAmigo
                ->setEstado('amigo')
                ->setFechaAgregado(new \DateTime('now'));
            $em->persist($arUsuarioAmigo);
            $em->flush();
            return [
                'estado'=>true,
            ];
        }
        catch (\Exception $exception){
            return[
                'estado'=>false,
                'error' =>$exception->getMessage(),
            ];
        }
    }


    /**
     * @Rest\Get("/api/social/cancelarSolicitud/{usernameSolicitante}/{usernameSolicitado}", name="api_social_cancelarSolicitud")
     */
    public function cancelarSolicitud($usernameSolicitante, $usernameSolicitado)
    {
        try{

            $em=$this->getDoctrine()->getManager();
            $arSolicitud=$em->getRepository('App\Entity\ComUsuarioAmigo')->findOneBy(['codigoUsuarioFk'=>$usernameSolicitante,'codigoUsuarioEsAmigoFk'=>$usernameSolicitado,'estado'=>'solicitud']);
            if(!$arSolicitud){
                $arSolicitud=$em->getRepository('App\Entity\ComUsuarioAmigo')->findOneBy(['codigoUsuarioFk'=>$usernameSolicitado,'codigoUsuarioEsAmigoFk'=>$usernameSolicitante,'estado'=>'solicitud']);
            }
            $em->remove($arSolicitud);
            $em->flush();
            return [
                'estado'=>true,
            ];
        }
        catch (\Exception $exception){
            return[
                'estado'=>false,
                'error' =>$exception->getMessage(),
            ];
        }
    }

    /**
     * @Rest\Get("/api/social/solicitudesPendientes/{usernameSolicitante}", name="api_social_solicitudesPendientes")
     */
    public function misSolicitudesRecibidas($usernameSolicitante){
        try{
            $em=$this->getDoctrine()->getManager();
            $datos=$em->getRepository('App\Entity\ComUsuarioAmigo')->solicitudAmigos($usernameSolicitante);

            return[
                'estado'=>true,
                'datos'=>$datos,
            ];
        }
        catch (\Exception $exception){
            return [
                'estado'=>false,
                'error'=>$exception->getMessage()
            ];
        }

    }


    /**
     * @Rest\Post("/api/social/misAmigos/{usernameSolicitante}", name="api_social_misAmigos")
     */
    public function misAmigos(\Symfony\Component\HttpFoundation\Request $request,$usernameSolicitante){
        try{
            $dato=json_decode($request->getContent(),true);
            $em=$this->getDoctrine()->getManager();

            $datos=$em->getRepository('App\Entity\ComUsuarioAmigo')->misAmigos($usernameSolicitante,$dato);

            return[
                'estado'=>true,
                'datos'=>$datos,
            ];
        }
        catch (\Exception $exception){
            return [
                'estado'=>false,
                'error'=>$exception->getMessage()
            ];
        }

    }
}


