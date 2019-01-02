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

    public static function getTiempoTranscurrido($datetime)
    {
        if( empty($datetime) )
        {
            return;
        }

        // check datetime var type
        $strTime = ( is_object($datetime) ) ? $datetime->format('Y-m-d H:i:s') : $datetime;

        $time = strtotime($strTime);
        $time = time() - $time;
        $time = ($time<1)? 1 : $time;

        $tokens = array (
            31536000 => 'año',
            2592000 => 'mes',
            604800 => 'semana',
            86400 => 'día',
            3600 => 'hora',
            60 => 'minuto',
            1 => 'segundo'
        );

        foreach ($tokens as $unit => $text)
        {
            if ($time < $unit) continue;
            $numberOfUnits = floor($time / $unit);
            $plural = ($unit == 2592000) ? 'es' : 's';
            return $numberOfUnits . ' ' . $text . ( ($numberOfUnits > 1) ? $plural : '' );
        }
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
