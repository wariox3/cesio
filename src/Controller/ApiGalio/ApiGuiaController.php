<?php

namespace App\Controller\ApiGalio;


use App\Entity\Operador;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class ApiGuiaController extends FOSRestController
{
    /**
     * @Rest\Post("/api/galio/guia/lista/cliente")
     */
    public function guiaClienteLista(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $raw = json_decode($request->getContent(), true);
        $codigoOperador = $raw['codigoOperador']?? '';
        $codigoCliente = $raw['codigoCliente']?? '';
        $fechaDesde = $raw['fechaDesde']?? '';
        $fechaHasta = $raw['fechaHasta']?? '';
        $numero = $raw['numero']?? '';
        $documento = $raw['documento']?? '';
        if($codigoOperador && $codigoCliente && $fechaDesde && $fechaHasta) {
            $arOperador = $em->getRepository(Operador::class)->find($codigoOperador);
            $direccion = $arOperador->getUrlServicio();
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_POST => 1,
                CURLOPT_URL => $direccion . '/transporte/api/cesio/guia/lista/cliente',
                CURLOPT_POSTFIELDS => json_encode([
                    'codigoCliente' => $codigoCliente,
                    'fechaDesde' => $fechaDesde,
                    'fechaHasta' => $fechaHasta,
                    'numero' => $numero,
                    'documento' => $documento
                ])
            ));
            $resp = json_decode(curl_exec($curl), true);
            curl_close($curl);
            return $resp;
        } else {
            return [
                'error' => "Faltan datos en el post"
            ];
        }
    }
}
