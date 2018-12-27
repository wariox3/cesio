<?php

namespace App\Repository;

use App\Controller\ApiComunidad\InformacionGeneralController;
use App\Entity\ComComentario;
use App\Entity\ComPublicacion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ComPublicacion|null find($id, $lockMode = null, $lockVersion = null)
 * @method ComPublicacion|null findOneBy(array $criteria, array $orderBy = null)
 * @method ComPublicacion[]    findAll()
 * @method ComPublicacion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComPublicacionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ComPublicacion::class);
    }

    public function listaMisPublicaciones($usuario){
        $em=$this->getEntityManager();
        $arPublicaciones=$em->createQueryBuilder()
            ->from('App\Entity\ComPublicacion','p')
            ->join("p.usuarioRel",'u')
            ->addSelect("u.nombreCorto as nombre")
            ->addSelect("p.codigoPublicacionPk as publicacion")
            ->addSelect("p.textoPublicacion as texto")
            ->addSelect("p.fecha")
            ->addSelect("p.meGusta")
            ->addSelect("p.totalComentarios")
            ->addSelect("p.codigoUsuarioFk as usuario")
            ->andWhere("p.codigoUsuarioFk='{$usuario}'")
            ->orderBy("p.fecha","DESC")
            ->getQuery()->getResult();

        for ($i=0;$i<count($arPublicaciones); $i++){
            $arPublicaciones[$i]['fecha']=$arPublicaciones[$i]['fecha']->format('h:iA F dS, Y');
            $arPublicaciones[$i]['tiempoTranscurrido']=InformacionGeneralController::getTiempoTranscurrido($arPublicaciones[$i]['fecha']);
            $arComentarios=$em->createQueryBuilder()
                ->from('App\Entity\ComComentario','c')
                ->join("c.usuarioRel","u")
                ->select('c.codigoComentarioPk as comentario')
                ->addSelect('u.nombreCorto as nombre')
                ->addSelect('c.texto_comentario as texto')
                ->addSelect('c.fecha')
                ->addSelect('c.meGusta')
                ->addSelect('c.codigoUsuarioFk as usuario')
                ->andWhere("c.codigoPadreFk IS NULL")
                ->andWhere("c.codigoPublicacionFk={$arPublicaciones[$i]['publicacion']}")
                ->orderBy("c.fecha","DESC")
//                ->setMaxResults(2)
                ->getQuery()->getResult();
            $arPublicaciones[$i]['comentarios']=$arComentarios;

        }
        return $arPublicaciones;
    }


    public function listaPublicaciones($usuario)
    {
        $em = $this->getEntityManager();
        $arPublicaciones = $em->createQueryBuilder()
            ->from('App\Entity\ComPublicacion', 'p')
            ->leftJoin("p.usuarioRel", 'u')
            ->leftJoin("u.usuarioAmigoRel", 'ua')
            ->leftJoin("u.usuarioEsAmigoRel", 'uea')
            ->addSelect("p.codigoPublicacionPk as publicacion")
            ->addSelect("u.nombreCorto as nombre")
            ->addSelect("p.textoPublicacion as texto")
            ->addSelect("p.fecha")
            ->addSelect("p.meGusta")
            ->addSelect("p.totalComentarios")
            ->addSelect("p.codigoUsuarioFk as usuario")
            ->andWhere("(ua.codigoUsuarioFk='{$usuario}' OR ua.codigoUsuarioEsAmigoFk='{$usuario}') AND ua.estado='amigo'")
            ->orWhere("(uea.codigoUsuarioFk='{$usuario}' OR uea.codigoUsuarioEsAmigoFk='{$usuario}') AND uea.estado='amigo'")
            ->orderBy("p.fecha", "DESC")
//            ->groupBy("p.codigoPublicacionPk")
            ->getQuery()->getResult();

        for ($i = 0; $i < count($arPublicaciones); $i++) {
            $arPublicaciones[$i]['fecha'] = $arPublicaciones[$i]['fecha']->format('h:iA F dS, Y');
            $arPublicaciones[$i]['tiempoTranscurrido'] = InformacionGeneralController::getTiempoTranscurrido($arPublicaciones[$i]['fecha']);
            $arComentarios = $em->createQueryBuilder()
                ->from('App\Entity\ComComentario', 'c')
                ->join("c.usuarioRel","u")
                ->select('c.codigoComentarioPk as comentario')
                ->addSelect('u.nombreCorto as nombre')
                ->addSelect('c.texto_comentario as texto')
                ->addSelect('c.fecha')
                ->addSelect('c.meGusta')
                ->addSelect('c.codigoUsuarioFk as usuario')
                ->andWhere("c.codigoPadreFk IS NULL")
                ->andWhere("c.codigoPublicacionFk={$arPublicaciones[$i]['publicacion']}")
                ->orderBy("c.fecha", "DESC")
//                ->setMaxResults(2)
                ->getQuery()->getResult();
            $arPublicaciones[$i]['comentarios'] = $arComentarios;
        }
        return $arPublicaciones;
    }


    public function crear($username, $data){
        $em=$this->getEntityManager();
        try{
            $usuario=InformacionGeneralController::usuarioExistente($username);
            if($usuario){
                $publicacion=(new ComPublicacion())
                    ->setUsuarioRel($usuario)
                    ->setFecha(new \DateTime('now'))
                    ->setTextoPublicacion($data['texto'])
                    ->setTotalComentarios(0)
                    ->setMeGusta(0);

                $em->persist($publicacion);
                $em->flush();

                return [
                    'estado'=>true,
                    'datos'=>[
                        'publicacion'       =>$publicacion->getCodigoPublicacionPk(),
                        'texto'             =>$publicacion->getTextoPublicacion(),
                        'fecha'             =>$publicacion->getFecha()->format('h:iA F dS, Y'),
                        'tiempoTranscurrido'=>InformacionGeneralController::getTiempoTranscurrido($publicacion->getFecha()),
                        'meGusta'           =>$publicacion->getMeGusta(),
                        'totalComentarios'  =>$publicacion->getTotalComentarios(),
                        'comentarios'       =>[],
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


    public function crearComentario($username, $data){
        $em=$this->getEntityManager();
        try{
            $usuario=InformacionGeneralController::usuarioExistente($username);
            if($usuario){
                $arPublicacion=$em->getRepository('App\Entity\ComPublicacion')->find($data['comentario']);
                $arComentario=(new ComComentario())
                    ->setUsuarioRel($usuario)
                    ->setFecha(new \DateTime('now'))
                    ->setTextoComentario($data['texto'])
                    ->setPublicacionRel($arPublicacion)
                    ->setMeGusta(0);

                $arPublicacion->setTotalComentarios($arPublicacion->getTotalComentarios()+1);
                $em->persist($arPublicacion);
                $em->persist($arComentario);
                $em->flush();

                return [
                    'estado'=>true,
                    'datos'=>[
                        'comentario'        =>$arComentario->getCodigoComentarioPk(),
                        'texto'             =>$arComentario->getTextoComentario(),
                        'fecha'             =>$arComentario->getFecha()->format('h:iA F dS, Y'),
                        'tiempoTranscurrido'=>InformacionGeneralController::getTiempoTranscurrido($arComentario->getFecha()),
                        'meGusta'           =>$arComentario->getMeGusta(),
                        'totalComentarios'  =>$arPublicacion->getTotalComentarios(),
//                        'comentarios'       =>[],
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

    // /**
    //  * @return ComPublicacion[] Returns an array of ComPublicacion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ComPublicacion
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
