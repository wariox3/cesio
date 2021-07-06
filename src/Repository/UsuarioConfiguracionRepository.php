<?php


namespace App\Repository;


use App\Entity\Usuario;
use App\Entity\UsuarioConfiguracion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UsuarioConfiguracionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UsuarioConfiguracion::class);
    }

    public function lista($usuario)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()->from(UsuarioConfiguracion::class, 'uc')
            ->select("uc.calidaImagen")
            ->where("uc.codigoUsuarioConfiguracionPk = '{$usuario}' ");
        $arConfuraciones = $queryBuilder->getQuery()->getArrayResult();
        return $arConfuraciones;
    }





}