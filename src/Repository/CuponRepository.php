<?php


namespace App\Repository;


use App\Entity\Cupon;
use App\Entity\Usuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CuponRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cupon::class);
    }

    public function apiAplicar($raw) {
        $em = $this->getEntityManager();
        $cupon = $raw['cupon'] ?? null;
        $usuario = $raw['usuario'] ?? null;
        if ($cupon && $usuario){
            $arUsuario = $em->getRepository(Usuario::class)->find($usuario);
            if($arUsuario) {
                $arCupon = $em->getRepository(Cupon::class)->find($cupon);
                if ($arCupon){
                    if(!$arCupon->getEstadoAplicado()) {
                        $dias = $arCupon->getDias();
                        $stringFecha = $arUsuario->getFechaHabilitacion()->format('Y-m-d');
                        $fechaHabilitacion = date_create($stringFecha);
                        $fechaHabilitacion->modify("+ " . (string)$dias . " day");
                        $arUsuario->setFechaHabilitacion($fechaHabilitacion);
                        $em->persist($arUsuario);

                        $arCupon->setEstadoAplicado(1);
                        $arCupon->setUsuarioAplicado($usuario);
                        $arCupon->setFechaApicacion(new \DateTime('now'));
                        $em->persist($arCupon);
                        $em->flush();
                        return [
                            'error' => false
                        ];
                    } else {
                        return [
                            'error' => true,
                            'errorMensaje' => "El cupon ya fue aplicado al usuario {$arCupon->getUsuarioAplicado()} el dia {$arCupon->getFechaApicacion()->format('Y-m-d')}"
                        ];
                    }
                } else{
                    return [
                        'error' => true,
                        'errorMensaje' => "El cupon no existe"
                    ];
                }
            } else {
                return [
                    'error' => true,
                    'errorMensaje' => "El usuario no existe"
                ];
            }
        } else{
            return [
                'error' => true,
                'errorMensaje' => "Faltan datos para el consumo de la api"
            ];
        }

    }

}