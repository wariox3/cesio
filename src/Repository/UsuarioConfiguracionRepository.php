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

    public function apiCalidadImagen($raw)
    {
        $em = $this->getEntityManager();
        $usuario = $raw['codigoUsuario'] ?? null;
        $calidaImagen = $raw['calidaImagen'] ?? null;
        if($usuario) {
            $arUsuario = $em->getRepository(Usuario::class)->find($usuario);
            if ($arUsuario) {
                $arUsuarioConfiguracion = $em->getRepository(UsuarioConfiguracion::class)->findOneBy(['codigoUsuarioFk'=>$usuario]);
                if($arUsuarioConfiguracion == null){
                    $arUsuarioConfiguracion = new UsuarioConfiguracion();
                    $arUsuarioConfiguracion->setUsuarioRel($arUsuario);
                }
                $arUsuarioConfiguracion->setCalidaImagen($calidaImagen);
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