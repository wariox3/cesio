<?php

namespace App\Repository;

use App\Entity\SocUsuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SocUsuario|null find($id, $lockMode = null, $lockVersion = null)
 * @method SocUsuario|null findOneBy(array $criteria, array $orderBy = null)
 * @method SocUsuario[]    findAll()
 * @method SocUsuario[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SocUsuarioRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SocUsuario::class);
    }

    public function lista($palabraClave, $usuario)
    {
        $em = $this->getEntityManager();

        $arSocUsuario = $em->createQueryBuilder()
            ->from('App\Entity\SocUsuario', 'su')
            ->leftJoin('su.usuarioEsAmigoRel', 'ua')
            ->leftJoin('su.usuarioAmigoRel', 'ui')
            ->select('su.codigoUsuarioPk as username')
            ->addSelect('su.nombreCorto as nombre')
            ->addSelect("
            (CASE
                WHEN ua.codigoUsuarioFk='{$usuario}' THEN ua.codigoUsuarioFk
                WHEN ui.codigoUsuarioEsAmigoFk = '{$usuario}' THEN ui.codigoUsuarioFk
                ELSE 'null'
            END
            ) as codigoUsuarioFk
            ")
            ->addSelect("
            (CASE
                WHEN ua.codigoUsuarioFk='{$usuario}' THEN ua.codigoUsuarioEsAmigoFk
                WHEN ui.codigoUsuarioEsAmigoFk = '{$usuario}' THEN ui.codigoUsuarioEsAmigoFk
                ELSE 'null'
            END
            ) as codigoUsuarioEsAmigoFk
            ")
            ->addSelect("
            (CASE
                WHEN ua.codigoUsuarioFk='{$usuario}' THEN ua.estado
                WHEN ui.codigoUsuarioEsAmigoFk = '{$usuario}' THEN ui.estado
                ELSE 'null'
            END
            ) as estado
            ")

            ->where("su.codigoUsuarioPk != '{$usuario}'")
            ->andWhere("su.nombreCorto LIKE '%{$palabraClave}%'")
            ->andWhere("ua.codigoUsuarioFk='{$usuario}' OR ua.codigoUsuarioFk IS NULL")
            ->andWhere("ui.codigoUsuarioEsAmigoFk='{$usuario}' OR ui.codigoUsuarioEsAmigoFk IS NULL")
            ->getQuery()->getResult();

        return $arSocUsuario;
    }



    // /**
    //  * @return SocUsuario[] Returns an array of SocUsuario objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SocUsuario
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
