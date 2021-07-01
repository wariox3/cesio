<?php

namespace App\Repository;

use App\Entity\Cupon;
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
        $em = $this->getEntityManager();
        $fechaActual = new \DateTime('now');
        $usuario = $raw['usuario'] ?? null;
        $contrasena = $raw['contrasena'] ?? null;
        $celular = $raw['celular'] ?? null;
        if ($usuario && $contrasena && $celular) {
            if (filter_var($usuario, FILTER_VALIDATE_EMAIL)) {
                if (is_numeric($celular)) {
                    $arUsuario = $em->getRepository(Usuario::class)->findBy(['usuario' => $usuario]);
                    if (!$arUsuario) {
                        $arUsuario = new Usuario();
                        $arUsuario->setClave($contrasena);
                        $arUsuario->setUsuario($usuario);
                        $arUsuario->setCelular($celular);
                        $arUsuario->setFechaCreacion($fechaActual);
                        $arUsuario->setFechaHabilitacion(date_create('2021-10-31'));
                        $em->persist($arUsuario);
                        $em->flush();
                        return [
                            'error' => false
                        ];
                    } else {
                        return [
                            'error' => true,
                            'errorMensaje' => "El usuario ya existe"
                        ];
                    }
                } else {
                    return [
                        'error' => true,
                        'errorMensaje' => "El celular debe ser un numero valido"
                    ];
                }
            } else {
                return [
                    'error' => true,
                    'errorMensaje' => "El usuario debe ser un correo valido"
                ];
            }
        } else {
            return [
                'error' => true,
                'errorMensaje' => "Faltan datos para el consumo de la api"
            ];
        }
    }

    public function apiCambiarContrasena($raw)
    {
        $em = $this->getEntityManager();
        $usuario = $raw['codigoUsuario'] ?? null;
        $contrasenaNueva = $raw['contrasena'] ?? null;
        if($usuario && $contrasenaNueva) {
            $arUsuario = $em->getRepository(Usuario::class)->find($usuario);
            if ($arUsuario) {
                $arUsuario->setClave($contrasenaNueva);
                $em->persist($arUsuario);
                $em->flush();
                return [
                    'error' => false
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

    public function apiRecuperarContrasena($raw)
    {
        $em = $this->getEntityManager();
        $usuario = $raw['usuario'] ?? null;
        if ($usuario){
            $arUsuario = $em->getRepository(Usuario::class)->findOneBy(['usuario' => $usuario]);
            if ($arUsuario){
                $asunto = "Titu, recuperación de contraseña";
                $mensaje = "Usuario: {$arUsuario->getUsuario()}, su clave de ingreso es {$arUsuario->getClave()}";
                $datosJson = json_encode([
                    "correo" => $usuario,
                    "asunto" => $asunto,
                    "contenido" => $mensaje
                ]);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'http://104.248.81.122/dubnio/public/index.php/api/correo/enviar');
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $datosJson);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Content-Type: application/json',
                        'Content-Length: ' . strlen($datosJson))
                );
                $respuestaApiDubnio = curl_exec($ch);
                curl_close($ch);
                return [
                    'error' => false
                ];
            } else{
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

    public function apiPerfil($raw)
    {
        $em = $this->getEntityManager();
        $usuario = $raw['codigoUsuario'] ?? null;
        if($usuario) {
            $arUsuario = $em->getRepository(Usuario::class)->find($usuario);
            if ($arUsuario) {
                return [
                    'error' => false,
                    'codigoUsuario' => $arUsuario->getCodigoUsuarioPk(),
                    'usuario' => $arUsuario->getUsuario(),
                    'celular' => $arUsuario->getCelular(),
                    'fechaHabilitacion' => $arUsuario->getFechaHabilitacion(),
                    'urlFoto' => $arUsuario->getUrlFoto()
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
