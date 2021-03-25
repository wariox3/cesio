<?php

namespace App\Repository;

use App\Entity\Operador;
use App\Entity\Usuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\True_;

class UsuarioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Usuario::class);
    }

    public function apiNuevo($raw)
    {
        return $raw;
        $em = $this->getEntityManager();
        $respuesta = ['error' => 0, 'mensaje' => '', 'autenticar' => false ];
        $codigoOperador = $raw['codigoOperador'] ?? null;
        $contrasena = $raw['contrasena'] ?? null;
        $usuarioNombre = $raw['usuarioNombre'] ?? null;
        if($codigoOperador){
            $arOperador = $em->getRepository(Operador::class)->find($codigoOperador);
            if ($arOperador){
                $validarUsarioExistente = $em->getRepository(Usuario::class)->findBy(['usuario' => $usuarioNombre]);
                if ($validarUsarioExistente == null){
                    if (strlen($contrasena) >= 8){
                        $arUsuario = new Usuario();
                        $arUsuario->setClave($contrasena);
                        $arUsuario->setUsuario($usuarioNombre);
                        $arUsuario->setCodigoOperadorFk(trim($codigoOperador));
                        $em->persist($arUsuario);
                        $em->flush();
                        $respuesta['mensaje'] = "Usuario registrado con éxito, bienvenido a Titu {$usuarioNombre}";
                        $respuesta['autenticar'] = True;
                    } else {
                        $respuesta['error'] = 1;
                        $respuesta['mensaje'] = "La contraseña tiene que tener  mínimo 8 caracteres, puede ser letras o número";
                    }
                } else {
                    $respuesta['error'] = 1;
                    $respuesta['mensaje'] = "El usuario ya existe ";
                }
            } else {
                $respuesta['error'] = 1;
                $respuesta['mensaje'] = "El operador ingresado no existe";
            }
        } else {
            $respuesta['error'] = 1;
            $respuesta['mensaje'] = "El operador no puede estar vacío";
        }

        return $respuesta;
    }
}
