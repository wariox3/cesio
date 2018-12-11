<?php

namespace App\Repository;

use App\Entity\SocUsuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SocUsuario|null find($id, $lockMode = null, $lockVersion = null)
 * @method SocUsuario|null findOneBy(array $criteria, array $orderBy = null)
 * @method SocUsuario[]    findAll()
 * @method SocUsuario[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SocUsuarioRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SocUsuario::class);
    }

    // /**
    //  * @return SocUsuario[] Returns an array of SocUsuario objects
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
    public function findOneBySomeField($value): ?SocUsuario
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
