<?php

namespace App\Controller\ApiPrecio;

use App\Entity\Operador;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

class ApiPrecioController extends AbstractController
{
    /**
     * @param Request $request
     * @param int $ciudadOrigen
     * @param int $ciudadDestino
     * @param string $producto
     * @param int $peso
     * @param string $codigoOperador
     * @param string $codigoEmpresa
     * @return mixed
     * @Rest\Get("/api/precio/calcular/{ciudadOrigen}/{ciudadDestino}/{producto}/{peso}/{codigoOperador}/{codigoEmpresa}")
     */
    public function crearGuia(Request $request, $ciudadOrigen = 0, $ciudadDestino = 0, $producto = '', $peso = 0,  $codigoOperador = '', $codigoEmpresa = '')
    {
        $em = $this->getDoctrine()->getManager();
        $arOperador = $em->find(Operador::class, $codigoOperador);
        $ch = curl_init($arOperador->getUrlServicio() . "transporte/api/cesio/precio/calcular/{$ciudadOrigen}/{$ciudadDestino}/{$producto}/{$peso}/{$codigoEmpresa}");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        $repuesta = json_decode(curl_exec($ch));
        return $repuesta;
    }
}