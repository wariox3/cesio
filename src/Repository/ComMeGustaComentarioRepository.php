<?php

namespace App\Repository;

use App\Entity\ComMeGustaComentario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ComMeGustaComentario|null find($id, $lockMode = null, $lockVersion = null)
 * @method ComMeGustaComentario|null findOneBy(array $criteria, array $orderBy = null)
 * @method ComMeGustaComentario[]    findAll()
 * @method ComMeGustaComentario[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComMeGustaComentarioRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ComMeGustaComentario::class);
    }

    // /**
    //  * @return ComMeGustaComentario[] Returns an array of ComMeGustaComentario objects
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
    public function findOneBySomeField($value): ?ComMeGustaComentario
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
