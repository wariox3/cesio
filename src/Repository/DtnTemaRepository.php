<?php

namespace App\Repository;

use App\Entity\DtnTema;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;


class DtnTemaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DtnTema::class);
    }

    /**
     * @param $arrDatos
     * @return mixed
     */
    public function buscar($arrDatos)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->from(DtnTema::class, "t")
            ->select("t")
            ->where('t.codigoTemaPk <> 0');
        if ($arrDatos['tipoBusqueda'] == 'TOD') {
            $qb->andWhere("t.titulo LIKE '%{$arrDatos['busqueda']}%' ")
                ->orWhere("t.descripcion LIKE '%{$arrDatos['busqueda']}%' ");
        } elseif($arrDatos['tipoBusqueda'] == 'TIT'){
            $qb->andWhere("t.titulo LIKE '%{$arrDatos['busqueda']}%' ");
        } else {
            $qb->andWhere("t.descripcion LIKE '%{$arrDatos['busqueda']}%' ");
        }
        return $qb->getQuery()->execute();
    }

    /**
     * @param $arrDatos array
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function calificar($arrDatos)
    {
        $em = $this->_em;
        $arTema = $em->find(DtnTema::class, $arrDatos['id']);
        if ($arTema) {
            $arTema->setCalificacion((int)$arrDatos['calificacion']);
            $em->persist($arTema);
            $em->flush();
        }
    }
}
