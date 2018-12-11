<?php

namespace App\Repository;

use App\Entity\SocSolicitud;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SocSolicitud|null find($id, $lockMode = null, $lockVersion = null)
 * @method SocSolicitud|null findOneBy(array $criteria, array $orderBy = null)
 * @method SocSolicitud[]    findAll()
 * @method SocSolicitud[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SocSolicitudRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SocSolicitud::class);
    }

    // /**
    //  * @return SocSolicitud[] Returns an array of SocSolicitud objects
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
    public function findOneBySomeField($value): ?SocSolicitud
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
