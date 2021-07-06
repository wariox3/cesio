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
            ->select("uc.calidadImagen")
            ->where("uc.codigoUsuarioConfiguracionPk = '{$usuario}' ");
        $arConfuraciones = $queryBuilder->getQuery()->getArrayResult();
        return $arConfuraciones;
    }

    public function apiActualizarCalidadImagen($raw)
    {
        $em = $this->getEntityManager();
        $usuario = $raw['codigoUsuario'] ?? null;
        $calidadImagen = $raw['calidadImagen'] ?? null;
        if($usuario) {
            $arUsuario = $em->getRepository(Usuario::class)->find($usuario);
            if ($arUsuario) {
                $arUsuarioConfiguracion = $em->getRepository(UsuarioConfiguracion::class)->findOneBy(['codigoUsuarioConfiguracionPk'=>$arUsuario->getUsuario()]);
                $arUsuarioConfiguracion->setCalidadImagen($calidadImagen);
                $em->persist($arUsuarioConfiguracion);
                $em->flush();
                return [
                    'error' => false,
                    'errorMensaje' => "Se asigno la configuración de manera correcta"
                ];
            } else {
                return [
                    'error' => true,
                    'errorMensaje' => "No existe el usuario"
                ];
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => "Faltan datos para el consumo de la api"
            ];
        }
    }

}