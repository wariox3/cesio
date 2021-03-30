<?php


namespace App\Repository;


use App\Entity\Cupon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CuponRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cupon::class);
    }

    public function validarVigengia($nombreUsuario)
    {
        $fechaActual = new \DateTime('now');
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(Cupon::class, 'c')
            ->select('c.codigoCuponPk')
            ->addSelect('c.dias')
            ->addSelect('c.fechaApicacion')
            ->where('c.estadoAplicado = 1')
            ->andWhere("c.usuarioAplicado = '{$nombreUsuario}' ")
            ->andWhere("c.fechaApicacion > '{$fechaActual->format('Y-m-d H:i:s')} 23:59:59'")
            ->setMaxResults(1);
        $arCupon = $queryBuilder->getQuery()->getResult();
        return $arCupon;
    }
}