<?php

namespace App\Controller\ApiLocalizador;


use App\Entity\Operador;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class ApiGuiaController extends FOSRestController
{
    /**
     * @Rest\Get("/api/localizador/guia/estado/{codigoOperador}/{codigoGuia}", name="api_localizador_guia_estado")
     */
    public function estado(Request $request, $codigoOperador, $codigoGuia)
    {
        set_time_limit(0);
        ini_set("memory_limit", -1);
        $em = $this->getDoctrine()->getManager();
        $arOperador =$em->getRepository(Operador::class)->find($codigoOperador);
        $direccion = $arOperador->getUrlServicio();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $direccion . "/transporte/api/guia/consulta/$codigoGuia");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        $arrEstados = json_decode($response, true);
        return $arrEstados;
    }

    /**
     * @Rest\Post("/api/localizador/guia/cumplido/{codigoOperador}/{codigoGuia}", name="api_localizador_guia_cumplido")
     */
    public function cumplido(Request $request, $codigoOperador, $codigoGuia)
    {
        $em = $this->getDoctrine()->getManager();
        $arOperador =$em->getRepository(Operador::class)->find($codigoOperador);
        $direccion = $arOperador->getUrlServicio();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POST => 1,
            //CURLOPT_URL => 'http://localhost/cromo/public/index.php/documental/api/registro/masivo/1',
            CURLOPT_URL => $direccion . '/documental/api/registro/masivo/guia/' . $codigoGuia,
        ));
        $resp = json_decode(curl_exec($curl), true);
        curl_close($curl);

        return $resp;
    }
}
