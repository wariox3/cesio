<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsuarioConfiguracionRepository")
 */
class UsuarioConfiguracion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $codigoUsuarioConfiguracionPk;

    /**
     * @ORM\Column(name="calida_imagen", type="string", options={"default":"baja"})
     */
    private $calidaImagen;

    /**
     * @ORM\Column(name="codigo_usuario_fk", type="integer")
     */
    private $codigoUsuarioFk;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Usuario", inversedBy="usuariosUsuarioConfiguracionRel")
     * @ORM\JoinColumn(name="codigo_usuario_fk", referencedColumnName="codigo_usuario_pk")
     */
    protected $usuarioRel;

    /**
     * @return mixed
     */
    public function getCodigoUsuarioConfiguracionPk()
    {
        return $this->codigoUsuarioConfiguracionPk;
    }

    /**
     * @param mixed $codigoUsuarioConfiguracionPk
     */
    public function setCodigoUsuarioConfiguracionPk($codigoUsuarioConfiguracionPk): void
    {
        $this->codigoUsuarioConfiguracionPk = $codigoUsuarioConfiguracionPk;
    }

    /**
     * @return mixed
     */
    public function getCalidaImagen()
    {
        return $this->calidaImagen;
    }

    /**
     * @param mixed $calidaImagen
     */
    public function setCalidaImagen($calidaImagen): void
    {
        $this->calidaImagen = $calidaImagen;
    }

    /**
     * @return mixed
     */
    public function getCodigoUsuarioFk()
    {
        return $this->codigoUsuarioFk;
    }

    /**
     * @param mixed $codigoUsuarioFk
     */
    public function setCodigoUsuarioFk($codigoUsuarioFk): void
    {
        $this->codigoUsuarioFk = $codigoUsuarioFk;
    }

    /**
     * @return mixed
     */
    public function getUsuarioRel()
    {
        return $this->usuarioRel;
    }

    /**
     * @param mixed $usuarioRel
     */
    public function setUsuarioRel($usuarioRel): void
    {
        $this->usuarioRel = $usuarioRel;
    }




}