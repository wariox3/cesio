<?php

namespace App\Repository;

use App\Entity\ConPost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ConPostRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ConPost::class);
    }


    /**
     * @param $arrDatos
     * @return mixed
     */
    public function lista($arrDatos){
        $qb = $this->_em->createQueryBuilder()->from(ConPost::class,'p')
            ->select('p')
            ->where('p.codigoPostPk <> 0');
        if($arrDatos['busqueda'] != ''){
            $qb->andWhere("p.descripcion LIKE '%{$arrDatos['busqueda']}%'")
                ->orWhere("p.autor LIKE '%{$arrDatos['busqueda']}%'")
                ->orWhere("p.titulo LIKE '%{$arrDatos['busqueda']}%'")
                ->orWhere("p.tags LIKE '%{$arrDatos['busqueda']}%'");
        }
        return $qb->getQuery()->execute();
    }
}