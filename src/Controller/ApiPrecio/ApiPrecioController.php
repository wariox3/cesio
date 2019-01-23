<?php

namespace App\Controller\ApiPrecio;

use App\Entity\Operador;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

class ApiPrecioController extends AbstractController
{
    /**
     * @param Request $request
     * @param string $ciudadOrigen
     * @param string $ciudadDestino
     * @param string $producto
     * @param int $peso
     * @param string $codigoOperador
     * @param int $listaPrecio
     * @return mixed
     * @Rest\Get("/api/precio/calcular/{ciudadOrigen}/{ciudadDestino}/{producto}/{peso}/{codigoOperador}/{listaPrecio}")
     */
    public function crearGuia(Request $request, $ciudadOrigen = '', $ciudadDestino = '', $producto = '', $peso = 0,  $codigoOperador = '', $listaPrecio = 0)
    {
        $em = $this->getDoctrine()->getManager();
        $arOperador = $em->find(Operador::class, $codigoOperador);
        $url = $arOperador->getUrlServicio() . "/transporte/api/cesio/precio/calcular/{$ciudadOrigen}/{$ciudadDestino}/{$producto}/{$peso}/{$listaPrecio}";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $repuesta = curl_exec($ch);
        curl_close($ch);
        return $repuesta;
    }
}