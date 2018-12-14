<?php

namespace App\Controller\ApiComunidad;

use App\Entity\ComUsuario;
use App\BaseDatos;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

final class InformacionGeneralController
{

    private static function getInstance()
    {
        static $instance = null;
        if ($instance === null) {
            $instance = new InformacionGeneralController();
        }
        return $instance;
    }

    public static function usuarioExistente($username)
    {
        $em=BaseDatos::getEm();
        $arUsuario=$em->getRepository('App\Entity\ComUsuario')->find($username);
        return $arUsuario;

    }



//    /**
//     * @param $username ComUsuario
//     */
//    public static function cambiarEstadoConexionUsuario($username, $estadoConexion){
//        $em=BaseDatos::getEm();
//        $arUsuario=$em->getRepository('App\Entity\ComUsuario')->find($username);
//        if($arUsuario){
//            $arUsuario->getEstadoConexion($estadoConexion);
//        }
//    }
}
