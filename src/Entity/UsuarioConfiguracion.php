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
     * @ORM\Column(name="codigo_usuario_configuracion_pk", type="string", length=200, nullable=true)
     */
    private $codigoUsuarioConfiguracionPk;

    /**
     * @ORM\Column(name="calida_imagen", type="string", length=10, options={"default":"bajo"})
     */
    private $calidaImagen = 'bajo';

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




}