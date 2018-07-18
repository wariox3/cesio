<?php

namespace App\Controller\ApiLocalizador;


use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class ApiGuiaController extends FOSRestController
{
    /**
     * @Rest\Get("/api/localizador/guia/estado/{codigoGuia}", name="api_localizador_guia_estado")
     */
    public function guia(Request $request, $codigoGuia)
    {
        set_time_limit(0);
        ini_set("memory_limit", -1);

        $prueba = array();
        $prueba[] = array('estadoRecibido' => "SI", 'estadoEmbarcado' => "SI", 'estadoDespachado' => "NO");
        return $prueba;
    }


}
