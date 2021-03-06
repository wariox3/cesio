<?php

namespace App\Repository;

use App\Entity\ComUsuarioAmigo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ComUsuarioAmigo|null find($id, $lockMode = null, $lockVersion = null)
 * @method ComUsuarioAmigo|null findOneBy(array $criteria, array $orderBy = null)
 * @method ComUsuarioAmigo[]    findAll()
 * @method ComUsuarioAmigo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComUsuarioAmigoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ComUsuarioAmigo::class);
    }

    public function solicitudAmigos($usuario){
        $em=$this->getEntityManager();
        $arUsuarioAmigoSolicitud=$em->createQueryBuilder()
            ->from('App\Entity\ComUsuarioAmigo','ua')
            ->join('ua.usuarioRel','u')
            ->select("u.nombreCorto as nombre")
            ->addSelect("u.codigoUsuarioPk as username")
            ->where("ua.estado='solicitud'")
            ->andWhere("ua.codigoUsuarioEsAmigoFk='{$usuario}'")
            ->getQuery()->getResult();

        return $arUsuarioAmigoSolicitud;
    }

    public function misAmigos($usuario, $dato){
        $em=$this->getEntityManager();
        $arUsuarioAmigo=$em->createQueryBuilder()
            ->from('App\Entity\ComUsuarioAmigo','ua')
            ->join('ua.usuarioRel','u')
            ->join('ua.usuarioAmigoRel','uar')
            ->addSelect("
                (   CASE
                        WHEN ua.codigoUsuarioFk='{$usuario}' THEN uar.nombreCorto
                        WHEN ua.codigoUsuarioEsAmigoFk='{$usuario}' THEN u.nombreCorto
                        ELSE 'null'
                    END
                ) as nombre
            ")
            ->addSelect("
                (   CASE
                        WHEN ua.codigoUsuarioFk='{$usuario}' THEN uar.codigoUsuarioPk
                        WHEN ua.codigoUsuarioEsAmigoFk='{$usuario}' THEN u.codigoUsuarioPk
                        ELSE 'null'
                    END         
                ) as username
            ")
            ->where("ua.estado='amigo'");
            if(isset($dato['datos']['maximo_resultado'])){
                $arUsuarioAmigo=$arUsuarioAmigo->setMaxResults($dato['datos']['maximo_resultado']);
            }
            $arUsuarioAmigo=$arUsuarioAmigo->getQuery()->getResult();

        return $arUsuarioAmigo;
    }

    public function numeroDeAmigos($usernameSolicitante){
        $em=$this->getEntityManager();

        $amigos=$em->createQueryBuilder()
            ->from('App\Entity\ComUsuarioAmigo','ua')
            ->select('COUNT(ua.codigoUsuarioAmigoPk) as amigos')
            ->where("ua.codigoUsuarioFk='{$usernameSolicitante}' OR ua.codigoUsuarioEsAmigoFk='{$usernameSolicitante}'")
            ->andWhere("ua.estado='amigo'")
            ->getQuery()->getSingleResult();

        return $amigos['amigos'];
    }

    // /**
    //  * @return ComUsuarioAmigo[] Returns an array of ComUsuarioAmigo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ComUsuarioAmigo
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
