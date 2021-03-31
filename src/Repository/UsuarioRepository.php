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
        $respuesta = ['error' => 0, 'mensaje' => '', 'autenticar' => false];
        $codigoOperador = $raw['codigoOperador'] ?? null;
        $contrasena = $raw['contrasena'] ?? null;
        $usuarioNombre = $raw['usuarioNombre'] ?? null;
        $celular = $raw['celular'] ?? null;
        $correo = $raw['correo'] ?? null;
        $fechaActual = new \DateTime('now');
        if ($correo != null) {
            if (filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                if (is_numeric($celular)) {
                    if ($codigoOperador) {
                        $arOperador = $em->getRepository(Operador::class)->find($codigoOperador);
                        if ($arOperador) {
                            $validarUsarioExistente = $em->getRepository(Usuario::class)->findBy(['usuario' => $usuarioNombre]);
                            if ($validarUsarioExistente == null) {
                                if (strlen($contrasena) >= 8) {
                                    /**
                                     * @IDEA: CREACIÓN DEL USUARIO
                                     */
                                    $arUsuario = new Usuario();
                                    $arUsuario->setClave($contrasena);
                                    $arUsuario->setUsuario($usuarioNombre);
                                    $arUsuario->setCodigoOperadorFk(trim($codigoOperador));
                                    $arUsuario->setCelular($celular);
                                    $arUsuario->setCorreo($correo);
                                    $arUsuario->setFechaCreacion($fechaActual);
                                    $arUsuario->setFechaHabilitacion($fechaActual);
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
                } else {
                    $respuesta['error'] = 1;
                    $respuesta['mensaje'] = "El número de celular ingresado no esta valido, solo numero";
                }
            } else {
                $respuesta['error'] = 1;
                $respuesta['mensaje'] = "Esta dirección de correo ($correo) es no es válida.";
            }
        } else {
            $respuesta['error'] = 1;
            $respuesta['mensaje'] = "El campo correo es obligatorio";
        }

        return $respuesta;
    }

    public function apiCambiarContrasena($raw)
    {
        $em = $this->getEntityManager();
        $respuesta = ['error' => 0, 'mensaje' => '',];
        $contrasenaNueva = $raw['contrasenaNueva'] ?? null;
        $usuarioNombre = $raw['usuario'] ?? null;
        $arUsuario = $em->getRepository(Usuario::class)->findOneBy(['usuario' => $usuarioNombre]);

        if ($arUsuario) {
            $arUsuario->setClave($contrasenaNueva);
            $em->persist($arUsuario);
            $em->flush();
            $respuesta['mensaje'] = "Cambio de clave exitoso";
        } else {
            $respuesta['error'] = 1;
            $respuesta['mensaje'] = "Usuario no existe ";
        }

        return $respuesta;
    }

    public function apiRecuperarContrasena($raw)
    {
        $em = $this->getEntityManager();
        $respuesta = ['error' => 0, 'mensaje' => '',];
        $correoElectronico = $raw['correoElectronico'] ?? null;
        if ($correoElectronico){
            $arUsuario = $em->getRepository(Usuario::class)->findOneBy(['correo' => $correoElectronico]);
            if ($arUsuario){
                $asunto = "Titu, recuperación de contraseña";
                $mensaje = "Hola usuario: {$arUsuario->getUsuario()}, su clave de ingreso es {$arUsuario->getClave()}";
                $datosJson = json_encode([
                    "correo" => $arUsuario->getCorreo(),
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
                $respuesta = array_merge($respuesta, (array)json_decode($respuestaApiDubnio));
                return $respuesta;
            } else{
                $respuesta['error'] = 1;
                $respuesta['mensaje'] = "Usuario no existe ";
            }
        } else{
            $respuesta['error'] = 1;
            $respuesta['mensaje'] = "Debe ingresar un correo";
        }
        return $respuesta;

    }
}
