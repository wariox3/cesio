<?php

namespace App\Controller\ApiWindows;


use App\Entity\Operador;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class ApiTransporteController extends FOSRestController
{
    /**
     * @return array
     * @Rest\Post("/api/windows/transporte/operador/validar")
     */
    public function validarOperador(Request $request) {
        try {
            $em = $this->getDoctrine()->getManager();
            $raw = json_decode($request->getContent(), true);
            return $em->getRepository(Operador::class)->apiWindowsValidar($raw);

        } catch (\Exception $e) {
            return [
                'error' => "Ocurrio un error en la api " . $e->getMessage(),
            ];
        }
    }
}
