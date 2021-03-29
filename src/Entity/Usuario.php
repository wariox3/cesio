<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsuarioRepository")
 */
class Usuario
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $codigoUsuarioPk;

    /**
     * @ORM\Column(type="string", length=20, nullable=false)
     */
    private $codigoOperadorFk;

    /**
     * @ORM\Column(name="usuario", type="string", length=50, nullable=true)
     */
    private $usuario;

    /**
     * @ORM\Column(name="clave", type="string", length=50, nullable=true)
     */
    private $clave;


    /**
     * @ORM\Column(name="celular", type="string", length=30, nullable=true)
     * @Assert\Length( max = 30, maxMessage = "El campo no puede contener mas de {{ limit }} caracteres")
     */
    private $celular;

    /**
     * @ORM\Column(name="correo", type="string", length=1000, nullable=true)
     * @Assert\Length( max = 1000, maxMessage = "El campo no puede contener mas de {{ limit }} caracteres")
     */
    private $correo;

    /**
     * @ORM\Column(name="fecha", type="date", nullable=true)
     */
    private $fechaHabilitacion;

    /**
     * @return mixed
     */
    public function getCodigoUsuarioPk()
    {
        return $this->codigoUsuarioPk;
    }

    /**
     * @param mixed $codigoUsuarioPk
     */
    public function setCodigoUsuarioPk($codigoUsuarioPk): void
    {
        $this->codigoUsuarioPk = $codigoUsuarioPk;
    }

    /**
     * @return mixed
     */
    public function getCodigoOperadorFk()
    {
        return $this->codigoOperadorFk;
    }

    /**
     * @param mixed $codigoOperadorFk
     */
    public function setCodigoOperadorFk($codigoOperadorFk): void
    {
        $this->codigoOperadorFk = $codigoOperadorFk;
    }

    /**
     * @return mixed
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param mixed $usuario
     */
    public function setUsuario($usuario): void
    {
        $this->usuario = $usuario;
    }

    /**
     * @return mixed
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * @param mixed $clave
     */
    public function setClave($clave): void
    {
        $this->clave = $clave;
    }


    /**
     * @return mixed
     */
    public function getCelular()
    {
        return $this->celular;
    }

    /**
     * @param mixed $celular
     */
    public function setCelular($celular): void
    {
        $this->celular = $celular;
    }

    /**
     * @return mixed
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * @param mixed $correo
     */
    public function setCorreo($correo): void
    {
        $this->correo = $correo;
    }

    /**
     * @return mixed
     */
    public function getFechaHabilitacion()
    {
        return $this->fechaHabilitacion;
    }

    /**
     * @param mixed $fechaHabilitacion
     */
    public function setFechaHabilitacion($fechaHabilitacion): void
    {
        $this->fechaHabilitacion = $fechaHabilitacion;
    }
}