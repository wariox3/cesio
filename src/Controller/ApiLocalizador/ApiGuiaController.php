<?php

namespace App\Controller\ApiLocalizador;


use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class ApiGuiaController extends FOSRestController
{
    /**
     * @Rest\Get("/api/localizador/guia/estado/{codigoOperador}/{codigoGuia}", name="api_localizador_guia_estado")
     */
    public function guia(Request $request, $codigoOperador, $codigoGuia)
    {
        set_time_limit(0);
        ini_set("memory_limit", -1);

        $prueba = array();
        $prueba[] = array('estado' => "bodega", 'valor' => "SI", 'fecha' => "...");
        $prueba[] = array('estado' => "embarque", 'valor' => "SI", 'fecha' => "...");
        $prueba[] = array('estado' => "despacho", 'valor' => "SI", 'fecha' => "...");
        $prueba[] = array('estado' => "entrega", 'valor' => "SI", 'fecha' => "...");
        return $prueba;
    }


}
