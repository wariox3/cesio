<?php

namespace App\Repository;

use App\Entity\Licencia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Licencia|null find($id, $lockMode = null, $lockVersion = null)
 * @method Licencia|null findOneBy(array $criteria, array $orderBy = null)
 * @method Licencia[]    findAll()
 * @method Licencia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LicenciaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Licencia::class);
    }

    public function activar($clave){
        $em=$this->getEntityManager();
        $arLicencia=$em->createQueryBuilder()
            ->from('App\Entity\Licencia','licencia')
            ->addSelect('licencia.codigoLicenciaPk')
            ->addSelect('licencia.fechaValidaHasta as fechaVencimiento')
            ->addSelect('licencia.turno')
            ->addSelect('licencia.transporte')
            ->addSelect('licencia.seguridad')
            ->addSelect('licencia.recursoHumano')
            ->addSelect('licencia.inventario')
            ->addSelect('licencia.general')
            ->addSelect('licencia.financiero')
            ->addSelect('licencia.documental')
            ->addSelect('licencia.compra')
            ->addSelect('licencia.producto')
            ->addSelect('licencia.cartera')
            ->addSelect('licencia.numeroUsuarios')
            ->where("licencia.codigoLicenciaPk='{$clave}'")
            ->getQuery()->getOneOrNullResult();

        return $arLicencia;
    }

    // /**
    //  * @return Licencia[] Returns an array of Licencia objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Licencia
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
