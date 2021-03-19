<?php

namespace App\Repository;

use App\Entity\ComComentario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class ComComentarioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
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

}
