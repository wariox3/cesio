<?php

namespace App\Controller\ApiDocumentacion;

use App\Entity\DtnTema;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

class ApiDocumentacionController extends AbstractController
{
    /**
     * @param Request $request
     * @return false|string
     * @Rest\Post("/api/documentacion/buscar", name="api_documentacion_buscar")
     */
    public function buscar(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $arrDatos = json_decode($request->getContent(), true);
        $arTemas = $em->getRepository(DtnTema::class)->buscar($arrDatos);
        return $arTemas;
    }

    /**
     * @param Request $request
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     * @Rest\Post("/api/documentacion/calificar", name="api_documentacion_calificar")
     */
    public function actualizarCalificacion(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $arrDatos = json_decode($request->getContent(), true);
        $em->getRepository(DtnTema::class)->calificar($arrDatos);
        return true;
    }

    /**
     * @param Request $request
     * @return mixed
     * @Rest\Post("/api/documentacion/consultarHtml", name="api_documentacion_consultarHtml")
     */
    public function consultarHtml(Request $request){
        $em = $this->getDoctrine()->getManager();
        $arrDatos = json_decode($request->getContent(), true);
        $contenidoHtml = $em->find(DtnTema::class,$arrDatos['id'])->getContenidoHtml();
        return $contenidoHtml;
    }
}