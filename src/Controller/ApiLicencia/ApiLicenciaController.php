<?php

namespace App\Controller\ApiLicencia;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

class ApiLicenciaController extends AbstractController
{
    /**
     * @param Request $request
     * @return array
     * @Rest\Post("/api/licencia/activar", name="api_licencia_activar")
     */
    public function activar(Request $request)
    {
        try{
            $estado=false;
            $datos=json_decode($request->getContent(),true);
            $em=$this->getDoctrine()->getManager();
            if($datos && isset($datos['datos']['clave'])){
                $datos=$datos['datos'];
                $arLicencia=$em->getRepository('App\Entity\Licencia')->activar($datos['clave']);
                if($arLicencia){
                    $estado=true;
                    $modulos=[];
                    foreach (array_keys($arLicencia) as $modulo){
                        if(is_bool($arLicencia[$modulo]) && $arLicencia[$modulo]){
                            array_push($modulos,$modulo);
                        }
                    }

                }
            }
            return [
                'estado'=>$estado,
                'datos'=>$estado?
                    [
                        'clave'=>$arLicencia['codigoLicenciaPk'],
                        'fechaVencimiento'=>$arLicencia['fechaVencimiento']?$arLicencia['fechaVencimiento']->format("Y-m-d h:i:s"):null,
                        'modulos'=>$modulos,
                        'numeroUsuarios'=>$arLicencia['numeroUsuarios']
                    ]
                    :
                    [
                        'mensaje'=>"La clave del producto que ingreso es incorrecta"
                    ],
            ];
        }
        catch (\Exception $exception){
            return [
                'estado'=>false,
                'datos'=>[
                    'mensaje'=>$exception->getMessage(),
                ],
            ];
        }
    }
}
