<?php

namespace App\Controller\ApiSocial;

use App\Entity\SocUsuario;
use App\Entity\Usuario;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;

class ApiInicioController extends AbstractController
{
    /**
     * @Rest\Post("/api/social/conexion/{username}", name="api_social_conexion")
     * @param $arUsuario SocUsuario
     */
    public function conexion(Request $request,$username)
    {
        $em=$this->getDoctrine()->getManager();
        $datos=json_decode($request->getContent(),true);
        $arUsuario=InformacionGeneralController::usuarioExistente($username);
        $estadoConexionDeUsuario=false;
        if($arUsuario){
            if(isset($datos['data']['estado'])){
                $estadoConexionDeUsuario=$arUsuario->getEstadoConexion();
            }
            else{
                if(!$arUsuario->getEstadoConexion()){
                    $estadoConexionDeUsuario=true;
                }
                $arUsuario->setEstadoConexion($estadoConexionDeUsuario);
            }
        }
        else{
            if(isset($datos['data']) && !isset($datos['data']['estado'])){
                $arUsuario=(new SocUsuario())
                    ->setCodigoUsuarioPk($username)
                    ->setClave($datos['data']['clave'])
                    ->setEstadoConexion(true)
                    ->setEstadoCuenta(true);
            }
            else{

            return[
                'usuario'=>false,
                'conectado'=>$estadoConexionDeUsuario,
            ];
            }
        }
        $em->persist($arUsuario);
        $em->flush();
        return [
            'usuario'=>true,
            'conectado'=>$estadoConexionDeUsuario,
        ];
    }
}
