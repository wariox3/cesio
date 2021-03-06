<?php

namespace App\Controller\ApiComunidad;

use App\Entity\ComMeGustaComentario;
use App\Entity\ComMeGustaPublicacion;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

class ApiPublicacionController extends FOSRestController
{
    /**
     * @Rest\Get("/api/comunidad/publicacion/misPublicaciones/{username}", name="api_comunidad_publicacion_misPublicaciones")
     */
    public function misPublicaciones($username)
    {
        if($username!=""){
            $arUsuario=InformacionGeneralController::usuarioExistente($username);
            if($arUsuario){
                $em=$this->getDoctrine();
                $arPublicacionUsuario=$em->getRepository('App\Entity\ComPublicacion')->listaMisPublicaciones($arUsuario->getCodigoUsuarioPk());
                return [
                    'estado'=>true,
                    'datos'=>$arPublicacionUsuario,
                ];
            }
        }
    }


    /**
     * @Rest\Get("/api/comunidad/publicacion/publicaciones/{username}", name="api_comunidad_publicacion_publicaciones")
     */
    public function publicaciones($username)
    {
        if($username!=""){
            $arUsuario=InformacionGeneralController::usuarioExistente($username);
            if($arUsuario){
                $em=$this->getDoctrine();
                $arPublicacionUsuario=$em->getRepository('App\Entity\ComPublicacion')->listaPublicaciones($arUsuario->getCodigoUsuarioPk());
                return [
                    'estado'=>true,
                    'datos'=>$arPublicacionUsuario,
                ];
            }
        }
    }

    /**
     * @Rest\Post("/api/comunidad/publicacion/crear/{username}", name="api_comunidad_publicacion_crear")
     */
    public function crearPublicacion(Request $request, $username){
        $data=json_decode($request->getContent(),true);
        if($username!=""){
            $arUsuario=InformacionGeneralController::usuarioExistente($username);
            if($arUsuario){
                $em=$this->getDoctrine();
                return $em->getRepository('App\Entity\ComPublicacion')->crear($arUsuario->getCodigoUsuarioPk(),$data['datos']);

            }
        }
    }


    /**
     * @Rest\Post("/api/comunidad/publicacion/comentario/crear/{username}", name="api_comunidad_publicacion_comentario_crear")
     */
    public function crearComentario(Request $request, $username){
        $data=json_decode($request->getContent(),true);
        if($username!=""){
            $arUsuario=InformacionGeneralController::usuarioExistente($username);
            if($arUsuario){
                $em=$this->getDoctrine();
                return $em->getRepository('App\Entity\ComPublicacion')->crearComentario($arUsuario->getCodigoUsuarioPk(),$data['datos']);

            }
        }
    }

    /**
     * @Rest\Get("/api/comunidad/publicacion/meGusta/{username}/{publicacion}", name="api_comunidad_publicacion_meGusta")
     */
    public function meGustaPublicacion($username,$publicacion){
        $em=$this->getDoctrine()->getManager();
        $arUsuario=InformacionGeneralController::usuarioExistente($username);
        try{
            if($arUsuario){
                $arPublicacion=$em->getRepository('App\Entity\ComPublicacion')->find($publicacion);
                if($arPublicacion){
                    $arMegustaPublicacion=$em->getRepository('App\Entity\ComMeGustaPublicacion')->findOneBy(['codigoUsuarioFk'=>$username,'codigoPublicacionFk'=>$publicacion]);
                    if($arMegustaPublicacion){
                        $arPublicacion->setMeGusta($arPublicacion->getMeGusta()-1);
                        $em->persist($arPublicacion);
                        $em->remove($arMegustaPublicacion);
                    }else{
                        $arMegustaPublicacion=(new ComMeGustaPublicacion())
                            ->setFecha(new \DateTime('now'))
                            ->setUsuarioRel($arUsuario)
                            ->setPublicacionRel($arPublicacion);
                        $arPublicacion->setMeGusta($arPublicacion->getMeGusta()+1);
                        $em->persist($arPublicacion);
                        $em->persist($arMegustaPublicacion);

                    }
                    $em->flush();
                }
                return [
                    'estado'=>true,
                    'datos'=>[
                        'meGustas'=>$arPublicacion->getMeGusta(),
                    ],
                ];
            }
        }catch (\Exception $exception){
            return [
                'estado'=>false,
                'datos'=>[
                    'message'=>$exception->getMessage(),
                ],
            ];
        }
    }


    /**
     * @Rest\Get("/api/comunidad/comentario/meGusta/{username}/{comentario}", name="api_comunidad_comentario_meGusta")
     */
    public function meGustaComentario($username,$comentario){
        $em=$this->getDoctrine()->getManager();
        $arUsuario=InformacionGeneralController::usuarioExistente($username);
        try{
            if($arUsuario){
                $arComentario=$em->getRepository('App\Entity\ComComentario')->find($comentario);
                if($arComentario){
                    $arMegustaComentario=$em->getRepository('App\Entity\ComMeGustaComentario')->findOneBy(['codigoUsuarioFk'=>$username,'codigoComentarioFk'=>$comentario]);
                    if($arMegustaComentario){
                        $arComentario->setMeGusta($arComentario->getMeGusta()-1);
                        $em->persist($arComentario);
                        $em->remove($arMegustaComentario);
                    }else{
                        $arMegustaComentario=(new ComMeGustaComentario())
                            ->setFecha(new \DateTime('now'))
                            ->setUsuarioRel($arUsuario)
                            ->setComentarioRel($arComentario);
                        $arComentario->setMeGusta($arComentario->getMeGusta()+1);
                        $em->persist($arComentario);
                        $em->persist($arMegustaComentario);

                    }
                    $em->flush();
                }
                return [
                    'estado'=>true,
                    'datos'=>[
                        'meGustas'=>$arComentario->getMeGusta(),
                    ],
                ];
            }
        }catch (\Exception $exception){
            return [
                'estado'=>false,
                'datos'=>[
                    'message'=>$exception->getMessage(),
                ],
            ];
        }
    }

    /**
     * @Rest\Get("/api/comunidad/publicacion/editar/{username}/{publicacion}", name="api_comunidad_publicacion_editar")
     */
    public function editarPublicacion($username,$publicacion){
        $em=$this->getDoctrine()->getManager();
        try{
            $arUsuario=InformacionGeneralController::usuarioExistente($username);
            if($arUsuario){
                $arPublicacion=$em->getRepository('App\Entity\ComPublicacion')->editarPublicacion($publicacion);
                if($arPublicacion){
                    return [
                        'estado'=>true,
                        'datos'=>$arPublicacion
                    ];
                }
                else{
                    return [
                        'estado'=>false,
                        'datos'=>[
                            'mensaje'=>"No se pudo consultar la informacion de la publicacion",
                        ],
                    ];
                }
            }
        }catch (\Exception $exception){
            return [
                'estado'=>false,
                'datos'=>[
                    'mensaje'=>$exception->getMessage(),
                ],
            ];
        }
    }

    /**
     * @Rest\Post("/api/comunidad/publicacion/actualizar/{username}", name="api_comunidad_publicacion_actualizar")
     */
    public function actualizarPublicacion(Request $request,$username){
        $em=$this->getDoctrine()->getManager();
        try{
            $arUsuario=InformacionGeneralController::usuarioExistente($username);
            if($arUsuario){
                $data=json_decode($request->getContent(),true);
                $data=$data['datos'];
                $arPublicacion=$em->getRepository('App\Entity\ComPublicacion')->find($data['publicacion']);
                if($arPublicacion){
                    $arPublicacion->setTextoPublicacion($data['texto']);
                    $em->persist($arPublicacion);
                    $em->flush();
                    return [
                        'estado'=>true,
                        'datos'=>[
                            'publicacion'=>$arPublicacion->getCodigoPublicacionPk(),
                            'textoPublicacion'=>$arPublicacion->getTextoPublicacion(),
                            'tiempoTranscurrido'=>InformacionGeneralController::getTiempoTranscurrido($arPublicacion->getFecha()),
                            'nombre'=>$arPublicacion->getUsuarioRel()->getNombreCorto(),

                        ]
                    ];
                }
                else{
                    return [
                        'estado'=>false,
                        'datos'=>[
                            'mensaje'=>"No se pudo editar la publicacion",
                        ],
                    ];
                }
            }
        }catch (\Exception $exception){
            return [
                'estado'=>false,
                'datos'=>[
                    'mensaje'=>$exception->getMessage(),
                ],
            ];
        }
    }


    /**
     * @Rest\Get("/api/comunidad/comentario/editar/{username}/{comentario}", name="api_comunidad_comentario_editar")
     */
    public function editarComentario($username,$comentario){
        $em=$this->getDoctrine()->getManager();
        try{
            $arUsuario=InformacionGeneralController::usuarioExistente($username);
            if($arUsuario){
                $arComentario=$em->getRepository('App\Entity\ComComentario')->editarComentario($comentario);
                if($arComentario){
                    return [
                        'estado'=>true,
                        'datos'=>$arComentario
                    ];
                }
                else{
                    return [
                        'estado'=>false,
                        'datos'=>[
                            'mensaje'=>"No se pudo consultar la informacion del comentario",
                        ],
                    ];
                }
            }
        }catch (\Exception $exception){
            return [
                'estado'=>false,
                'datos'=>[
                    'mensaje'=>$exception->getMessage(),
                ],
            ];
        }
    }

    /**
     * @Rest\Post("/api/comunidad/comentario/actualizar/{username}", name="api_comunidad_comentario_actualizar")
     */
    public function actualizarComentario(Request $request,$username){
        $em=$this->getDoctrine()->getManager();
        try{
            $arUsuario=InformacionGeneralController::usuarioExistente($username);
            if($arUsuario){
                $data=json_decode($request->getContent(),true);
                $data=$data['datos'];
                $arComentario=$em->getRepository('App\Entity\ComComentario')->find($data['comentario']);
                if($arComentario){
                    $arComentario->setTextoComentario($data['texto']);
                    $em->persist($arComentario);
                    $em->flush();
                    return [
                        'estado'=>true,
                        'datos'=>[
                            'comentario'=>$arComentario->getCodigoComentarioPk(),
                            'textoPublicacion'=>$arComentario->getTextoComentario(),
                            'tiempoTranscurrido'=>InformacionGeneralController::getTiempoTranscurrido($arComentario->getFecha()),
                            'nombre'=>$arComentario->getUsuarioRel()->getNombreCorto(),

                        ]
                    ];
                }
                else{
                    return [
                        'estado'=>false,
                        'datos'=>[
                            'mensaje'=>"No se pudo editar el comentario",
                        ],
                    ];
                }
            }
        }catch (\Exception $exception){
            return [
                'estado'=>false,
                'datos'=>[
                    'mensaje'=>$exception->getMessage(),
                ],
            ];
        }
    }

    /**
     * @Rest\Get("/api/comunidad/comentario/eliminar/{username}/{comentario}", name="api_comunidad_comentario_eliminar")
     */
    public function eliminarComentario($username, $comentario){
        $em=$this->getDoctrine()->getManager();
        try{
            $arUsuario=InformacionGeneralController::usuarioExistente($username);
            if($arUsuario){
                $arComentario=$em->getRepository('App\Entity\ComComentario')->find($comentario);
                if($arComentario){
                    $arMeGustaComentario=$em->getRepository('App\Entity\ComMeGustaComentario')->findBy(['codigoComentarioFk'=>$comentario]);
                    if($arMeGustaComentario){
                        foreach ($arMeGustaComentario as $megusta)
                            $em->remove($megusta);
                    }
                    $arPublicacion=$em->getRepository('App\Entity\ComPublicacion')->find($arComentario->getCodigoPublicacionFk());
                    $arPublicacion->setTotalComentarios($arPublicacion->getTotalComentarios()-1);
                    $em->remove($arComentario);
                    $em->flush();
                    return [
                        'estado'=>true,
                        'datos'=>[
                            'totalComentario'   =>$arPublicacion->getTotalComentarios(),
                            'publicacion'       =>$arPublicacion->getCodigoPublicacionPk()
                        ]
                    ];
                }else{
                    return [
                        'estado'=>false,
                        'datos'=>[
                            'mensaje'=>"No se pudo eliminar el comentario",
                        ],
                    ];
                }
            }
        }catch (\Exception $exception){
            return [
                'estado'=>false,
                'datos'=>[
                    'mensaje'=>$exception->getMessage(),
                ],
            ];
        }
    }

    /**
     * @Rest\Get("/api/comunidad/publicacion/eliminar/{username}/{publicacion}", name="api_comunidad_publicacion_eliminar")
     */
    public function eliminarPublicacion($username, $publicacion){
        $em=$this->getDoctrine()->getManager();
        try{
            $arUsuario=InformacionGeneralController::usuarioExistente($username);
            if($arUsuario){
                $arPublicacion=$em->getRepository('App\Entity\ComPublicacion')->find($publicacion);
                if($arPublicacion){
                    $arMeGustaPublicacion=$em->getRepository('App\Entity\ComMeGustaPublicacion')->findBy(['codigoPublicacionFk'=>$publicacion]);
                    $arComentarios=$em->getRepository('App\Entity\ComComentario')->findBy(['codigoPublicacionFk'=>$publicacion]);
                    if($arComentarios){
                        foreach ($arComentarios as $comentario){
                            $em->remove($comentario);
                        }
                    }
                    if($arMeGustaPublicacion){
                        foreach ($arMeGustaPublicacion as $megusta)
                            $em->remove($megusta);
                    }
                    $em->remove($arPublicacion);
                    $em->flush();
                    return [
                        'estado'=>true,
                    ];
                }else{
                    return [
                        'estado'=>false,
                        'datos'=>[
                            'mensaje'=>"No se pudo eliminar la publicacion",
                        ],
                    ];
                }
            }
        }catch (\Exception $exception){
            return [
                'estado'=>false,
                'datos'=>[
                    'mensaje'=>$exception->getMessage(),
                ],
            ];
        }
    }

}
