<?php

namespace App\Controller\ApiConductor;


use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class ApiConductorController extends FOSRestController
{
    /**
     * @Rest\Get("/api/conductor/despacho/guias/{codigoDespacho}", name="api_conductor_despacho_guias")
     */
    public function guia(Request $request, $codigoDespacho)
    {
        set_time_limit(0);
        ini_set("memory_limit", -1);
        /*$em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT g.codigoGuiaPk, 
        WHERE g.codigoDespachoFk = :codigoDespacho'
        )->setParameter('codigoDespacho', 1);

        $qb = $em->createQueryBuilder();
        $qb->from(TteGuia::class, "g")
            ->select("g.codigoGuiaPk")
            ->where("g.codigoDespachoFk = 1");
        return $qb->getQuery()->getResult();*/

        //return $query->execute();

        $prueba = array();
        $prueba[] = array('codigoGuiaPk' => 11111);
        $prueba[] = array('codigoGuiaPk' => 22222);
        return $prueba;
    }


}
