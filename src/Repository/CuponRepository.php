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

    public function generarCupon()
    {
        return  bin2hex(random_bytes(4));
    }
}