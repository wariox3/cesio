<?php

namespace App\Repository;

use App\Entity\Operador;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class OperadorRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Operador::class);
    }

    public function apiWindowsValidar($raw)
    {
        $em = $this->getEntityManager();
        $operador = $raw['operador']?? null;
        if($operador) {
            $qb = $em->createQueryBuilder();
            $qb->from(Operador::class, "o")
                ->select("o.codigoOperadorPk")
                ->addSelect("o.nombre")
                ->addSelect("o.urlServicio")
                ->where("o.codigoOperadorPk ='{$operador}'");
            $arrOperador =  $qb->getQuery()->getResult();
            if($arrOperador) {
                return $arrOperador[0];
            } else {
                ["error" => "No existe el operador"];
            }
        } else {
            return ["error" => "No fue enviado el dato del operador"];
        }
    }

}
