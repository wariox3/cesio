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
     * @ORM\Column(name="usuario", type="string", length=200, nullable=true)
     */
    private $usuario;

    /**
     * @ORM\Column(name="clave", type="string", length=50, nullable=true)
     */
    private $clave;

    /**
     * @ORM\Column(name="celular", type="string", length=50, nullable=true)
     */
    private $celular;

    /**
     * @ORM\Column(name="fecha_creacion", type="datetime", nullable=true)
     */
    private $fechaCreacion;

    /**
     * @ORM\Column(name="fecha_habilitacion", type="date", nullable=true)
     */
    private $fechaHabilitacion;

    /**
     * @ORM\Column(name="url_foto", type="string", length=500, nullable=true)
     */
    private $urlFoto;


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
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    /**
     * @param mixed $fechaCreacion
     */
    public function setFechaCreacion($fechaCreacion): void
    {
        $this->fechaCreacion = $fechaCreacion;
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

    /**
     * @return mixed
     */
    public function getUrlFoto()
    {
        return $this->urlFoto;
    }

    /**
     * @param mixed $urlFoto
     */
    public function setUrlFoto($urlFoto): void
    {
        $this->urlFoto = $urlFoto;
    }

}