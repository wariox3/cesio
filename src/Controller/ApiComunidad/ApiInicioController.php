<?php

namespace App\Controller\ApiComunidad;

use App\Entity\ComUsuario;
use App\Entity\Usuario;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;

class ApiInicioController extends AbstractController
{
    /**
     * @Rest\Post("/api/comunidad/conexion/{username}", name="api_comunidad_conexion")
     * @param $arUsuario ComUsuario
     */
    public function conexion(Request $request,$username)
    {
        $em=$this->getDoctrine()->getManager();
        $datos=json_decode($request->getContent(),true);
        $arUsuario=InformacionGeneralController::usuarioExistente($username);
        $estadoConexionDeUsuario=false;
        if($arUsuario){
            if(isset($datos['datos']['estado'])){
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
            if(isset($datos['datos']) && !isset($datos['datos']['estado'])){
                $arUsuario=(new ComUsuario())
                    ->setCodigoUsuarioPk($username)
                    ->setClave($datos['datos']['clave'])
                    ->setNombreCorto($datos['datos']['nombreCorto'])
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
