<?php

namespace App\Repository;

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
            ->addSelect("p.codigoPublicacionPk as publicacion")
            ->addSelect("p.textoPublicacion as texto")
            ->addSelect("p.fecha")
            ->addSelect("p.meGusta")
            ->addSelect("p.totalComentarios")
            ->andWhere("p.codigoUsuarioFk='{$usuario}'")
            ->getQuery()->getResult();

        for ($i=0;$i<count($arPublicaciones); $i++){
            $arComentarios=$em->createQueryBuilder()
                ->from('App\Entity\ComComentario','c')
                ->select('c.codigoComentarioPk as comentario')
                ->addSelect('c.texto_comentario as texto')
                ->addSelect('c.fecha')
                ->addSelect('c.meGusta')
                ->andWhere("c.codigoPadreFk IS NULL")
                ->andWhere("c.codigoPublicacionFk={$arPublicaciones[$i]['publicacion']}")
                ->setMaxResults(2)
                ->getQuery()->getResult();
            $arPublicaciones[$i]['comentarios']=$arComentarios;

        }
        return $arPublicaciones;
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