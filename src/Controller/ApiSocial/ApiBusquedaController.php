<?php

namespace App\Controller\ApiSocial;

use App\Entity\SocSolicitud;
use App\Entity\SocUsuarioAmigo;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

class ApiBusquedaController extends FOSRestController
{
    /**
     * @Rest\Get("/api/social/busqueda/{username}/{palabraClave}", name="api_social_busqueda")
     */
    public function busqueda($username, $palabraClave)
    {
        if($palabraClave!=""){
            $em=$this->getDoctrine();
            $arSocUsuario=$em->getRepository('App\Entity\SocUsuario')->lista($palabraClave, $username);
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
            $arSocUsuarioSolicitante=$em->getRepository('App\Entity\SocUsuario')->find($usernameSolicitante);
            $arSocUsuarioSolicitado=$em->getRepository('App\Entity\SocUsuario')->find($usernameSolicitado);
            $arSolicitud=(new SocUsuarioAmigo())
                ->setUsuarioRel($arSocUsuarioSolicitado)
                ->setUsuarioAmigoRel($arSocUsuarioSolicitante)
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
     * @Rest\Get("/api/social/eliminarAmigo/{usernameSolicitante}/{usernameSolicitado}", name="api_social_enviarSolicitud")
     */
    public function eliminarAmigo($usernameSolicitante, $usernameSolicitado)
    {
        try{

            $em=$this->getDoctrine()->getManager();
            $arUsuarioAmigo=$em->getRepository('App\Entity\SocUsuarioAmigo')->findOneBy(['codigoUsuarioFk'=>$usernameSolicitante,'codigoUsuarioEsAmigoFk'=>$usernameSolicitado]);
            $arUsuarioAmigo2=$em->getRepository('App\Entity\SocUsuarioAmigo')->findOneBy(['codigoUsuarioFk'=>$usernameSolicitado,'codigoUsuarioEsAmigoFk'=>$usernameSolicitante]);
            $em->remove($arUsuarioAmigo);
            $em->remove($arUsuarioAmigo2);
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
     * @Rest\Get("/api/social/eliminarAmigo/{usernameSolicitante}/{usernameSolicitado}", name="api_social_enviarSolicitud")
     */
    public function agregarAmigo($usernameSolicitante, $usernameSolicitado)
    {
        try{

            $em=$this->getDoctrine()->getManager();
            $arUsuario1=$em->getRepository('App\Entity\SocUsuarioAmigo')->find($usernameSolicitante);
            $arUsuario2=$em->getRepository('App\Entity\SocUsuarioAmigo')->find($usernameSolicitado);
            $arUsuarioAmigo=(new SocUsuarioAmigo())
                ->setCodigoUsuarioAmigoPk($arUsuario1)
                ->setCodigoUsuarioEsAmigoFk($arUsuario2)
                ->setEstadoAmistad(1)
                ->setFechaAgregado(new \DateTime('Y-m-d'));
            $arUsuarioAmigo2=(new SocUsuarioAmigo())
                ->setCodigoUsuarioAmigoPk($arUsuario2)
                ->setCodigoUsuarioEsAmigoFk($arUsuario1)
                ->setEstadoAmistad(1)
                ->setFechaAgregado(new \DateTime('Y-m-d'));
            $em->persist($arUsuarioAmigo);
            $em->persist($arUsuarioAmigo2);
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
            $arSolicitud=$em->getRepository('App\Entity\SocSolicitud')->findOneBy(['codigoUsuarioSolicitadoFk'=>$usernameSolicitante,'codigoUsuarioSolicitanteFk'=>$usernameSolicitado]);
            if(!$arSolicitud){
                $arSolicitud=$em->getRepository('App\Entity\SocSolicitud')->findOneBy(['codigoUsuarioSolicitadoFk'=>$usernameSolicitado,'codigoUsuarioSolicitanteFk'=>$usernameSolicitante]);
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
}


