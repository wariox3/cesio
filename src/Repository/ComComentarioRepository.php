<?php

namespace App\Repository;

use App\Entity\ComComentario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ComComentario|null find($id, $lockMode = null, $lockVersion = null)
 * @method ComComentario|null findOneBy(array $criteria, array $orderBy = null)
 * @method ComComentario[]    findAll()
 * @method ComComentario[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComComentarioRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ComComentario::class);
    }

    public function editarComentario($comentario){
        $em=$this->getEntityManager();
        $arComentario=$em->createQueryBuilder()
            ->from('App\Entity\ComComentario','c')
            ->addSelect('c.codigoComentarioPk as comentario')
            ->addSelect('c.texto_comentario as textoComentario')
            ->andWhere("c.codigoComentarioPk='{$comentario}'")
            ->getQuery()->getOneOrNullResult();

        return $arComentario;
    }
    // /**
    //  * @return ComComentario[] Returns an array of ComComentario objects
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
    public function findOneBySomeField($value): ?ComComentario
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
