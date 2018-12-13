<?php

namespace App\Repository;

use App\Entity\SocUsuarioAmigo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SocUsuarioAmigo|null find($id, $lockMode = null, $lockVersion = null)
 * @method SocUsuarioAmigo|null findOneBy(array $criteria, array $orderBy = null)
 * @method SocUsuarioAmigo[]    findAll()
 * @method SocUsuarioAmigo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SocUsuarioAmigoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SocUsuarioAmigo::class);
    }



    // /**
    //  * @return SocUsuarioAmigo[] Returns an array of SocUsuarioAmigo objects
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
    public function findOneBySomeField($value): ?SocUsuarioAmigo
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
