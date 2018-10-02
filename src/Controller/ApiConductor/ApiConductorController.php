<?php

namespace App\Controller\ApiConductor;


use App\Entity\Operador;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class ApiConductorController extends FOSRestController
{
    /**
     * @Rest\Get("/api/conductor/despacho/guias/{codigoOperador}/{codigoDespacho}", name="api_conductor_despacho_guias")
     */
    public function guia(Request $request, $codigoOperador, $codigoDespacho)
    {

        set_time_limit(0);
        ini_set("memory_limit", -1);
        $em = $this->getDoctrine()->getManager();
        $arOperador =$em->getRepository(Operador::class)->find($codigoOperador);
        $direccion = $arOperador->getUrlServicio();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $direccion . "/transporte/api/guia/despacho/$codigoDespacho");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        $arrGuias = json_decode($response, true);
        if($arrGuias['error']) {
            return null;
        } else {
            return $arrGuias['guias'];
        }
        //return $arrGuias;

        /*$prueba = array();
        $prueba[] = array('codigoGuiaPk' => 11111);
        $prueba[] = array('codigoGuiaPk' => 22222);
        return $prueba;*/
    }


}
