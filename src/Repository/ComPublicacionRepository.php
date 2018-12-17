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
