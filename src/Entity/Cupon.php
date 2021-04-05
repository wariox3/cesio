<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CuponRepository")
 */
class Cupon
{
    /**
     * @ORM\Id()
     * @ORM\Column(name="codigo_grupo_pk", type="string", length=30, unique=true)
     */
    private $codigoCuponPk;

    /**
     * @ORM\Column(name="estado_aplicado", type="boolean", nullable=true, options={"default" : false})
     */
    private $estadoAplicado = false;

    /**
     * @ORM\Column(name="vr_cupon", type="float", options={"default":0})
     */
    private $vrCupon = 0;

    /**
     * @ORM\Column(name="dias", type="integer", nullable=true, options={"default" : 0})
     */
    private $dias = 0;

    /**
     * @ORM\Column(name="fecha_apicacion", type="datetime", nullable=true)
     */
    private $fechaApicacion;

    /**
     * @ORM\Column(name="usuario_aplicado", type="string", length=50, nullable=true)
     * @Assert\Length(max = 50, maxMessage="El campo no puede contener más de 50 caracteres")
     */
    private $usuarioAplicado;

    /**
     * @return mixed
     */
    public function getCodigoCuponPk()
    {
        return $this->codigoCuponPk;
    }

    /**
     * @param mixed $codigoCuponPk
     */
    public function setCodigoCuponPk($codigoCuponPk): void
    {
        $this->codigoCuponPk = $codigoCuponPk;
    }

    /**
     * @return bool
     */
    public function getEstadoAplicado(): bool
    {
        return $this->estadoAplicado;
    }

    /**
     * @param bool $estadoAplicado
     */
    public function setEstadoAplicado(bool $estadoAplicado): void
    {
        $this->estadoAplicado = $estadoAplicado;
    }

    /**
     * @return mixed
     */
    public function getVrCupon()
    {
        return $this->vrCupon;
    }

    /**
     * @param mixed $vrCupon
     */
    public function setVrCupon($vrCupon): void
    {
        $this->vrCupon = $vrCupon;
    }

    /**
     * @return int
     */
    public function getDias(): int
    {
        return $this->dias;
    }

    /**
     * @param int $dias
     */
    public function setDias(int $dias): void
    {
        $this->dias = $dias;
    }

    /**
     * @return mixed
     */
    public function getFechaApicacion()
    {
        return $this->fechaApicacion;
    }

    /**
     * @param mixed $fechaApicacion
     */
    public function setFechaApicacion($fechaApicacion): void
    {
        $this->fechaApicacion = $fechaApicacion;
    }

    /**
     * @return mixed
     */
    public function getUsuarioAplicado()
    {
        return $this->usuarioAplicado;
    }

    /**
     * @param mixed $usuarioAplicado
     */
    public function setUsuarioAplicado($usuarioAplicado): void
    {
        $this->usuarioAplicado = $usuarioAplicado;
    }






}