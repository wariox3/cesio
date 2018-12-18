<?php

namespace App\Controller\ApiContenido;

use App\Entity\ConPost;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

class ApiContenidoController extends AbstractController
{
    /**
     * @param Request $request
     * @return mixed
     * @Rest\Post("/api/contenido/post", name="api_contenido_post")
     */
    public function buscar(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $arrDatos = json_decode($request->getContent(), true);
        $arPosts = $em->getRepository(ConPost::class)->lista($arrDatos);
        return $arPosts;
    }

    /**
     * @param Request $request
     * @return mixed
     * @Rest\Post("/api/contenido/post/descripcion", name="api_contenido_post_descripcion")
     */
    public function consultarDescripcion(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $arrDatos = json_decode($request->getContent(), true);
        $arPost = $em->find(ConPost::class, $arrDatos['id']);
        $arrPost['descripcion'] = $arPost->getDescripcion();
        $arrPost['titulo'] = $arPost->getTitulo();
        return $arrPost;
    }
}