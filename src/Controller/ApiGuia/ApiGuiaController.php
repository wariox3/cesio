<?php

namespace App\Controller\ApiGuia;


use App\Entity\Operador;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class ApiGuiaController extends FOSRestController
{
    /**
     * @Rest\Get("/api/localizador/guia/estado/{codigoOperador}/{codigoGuia}/{documentoCliente}", name="api_localizador_guia_estado")
     */
    public function estado(Request $request, $codigoOperador, $codigoGuia = 0, $documentoCliente = '')
    {
        set_time_limit(0);
        ini_set("memory_limit", -1);
        $em = $this->getDoctrine()->getManager();
        $arOperador = $em->getRepository(Operador::class)->find($codigoOperador);
        $direccion = $arOperador->getUrlServicio();
        if($codigoGuia){
            $url = $direccion . "/transporte/api/app/guia/consulta/{$codigoGuia}/0";
        } else {
            $url = $direccion . "/transporte/api/app/guia/consulta/0/{$documentoCliente}";
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
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
        $arOperador = $em->getRepository(Operador::class)->find($codigoOperador);
        $direccion = $arOperador->getUrlServicio();
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POST => 1,
            //CURLOPT_URL => 'http://localhost/cromo/public/index.php/documental/api/masivo/masivo/1',
            CURLOPT_URL => $direccion . '/documental/api/masivo/masivo/tte_guia/' . $codigoGuia,
        ));
        $resp = json_decode(curl_exec($curl), true);
        curl_close($curl);

        return $resp;
    }

    /**
     * @param Request $request
     * @param $codigoOperador
     * @param $codigoGuia
     * @return mixed
     * @Rest\Get("/api/localizador/guia/novedad/{codigoOperador}/{codigoGuia}", name="api_localizador_guia_cumplido")
     */
    public function novedad(Request $request, $codigoOperador, $codigoGuia){
        $em = $this->getDoctrine()->getManager();
        $arOperador = $em->getRepository(Operador::class)->find($codigoOperador);
        $direccion = $arOperador->getUrlServicio();
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url = $direccion . "/transporte/api/app/guia/novedad/{$codigoGuia}",
        ]);
        $resp = json_decode(curl_exec($curl), true);
        curl_close($curl);

        return $resp;
    }
}
