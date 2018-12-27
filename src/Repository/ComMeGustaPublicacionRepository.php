<?php

namespace App\Repository;

use App\Entity\ComMeGustaPublicacion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ComMeGustaPublicacion|null find($id, $lockMode = null, $lockVersion = null)
 * @method ComMeGustaPublicacion|null findOneBy(array $criteria, array $orderBy = null)
 * @method ComMeGustaPublicacion[]    findAll()
 * @method ComMeGustaPublicacion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComMeGustaPublicacionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ComMeGustaPublicacion::class);
    }

    // /**
    //  * @return ComMeGustaPublicacion[] Returns an array of ComMeGustaPublicacion objects
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
    public function findOneBySomeField($value): ?ComMeGustaPublicacion
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
