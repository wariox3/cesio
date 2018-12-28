<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ComMeGustaPublicacionRepository")
 */
class ComMeGustaPublicacion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="codigo_me_gusta_publicacion_pk", unique=true)
     */
    private $codigoMeGustaPublicacionPk;

    /**
     * @ORM\Column(name="codigo_usuario_fk", type="string", nullable=false, length=100)
     */
    private $codigoUsuarioFk;

    /**
     * @ORM\Column(name="codigo_publicacion_fk", type="integer", nullable=false)
     */
    private $codigoPublicacionFk;

    /**
     * @ORM\Column(name="fecha", type="datetime", nullable=false)
     */
    private $fecha;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ComUsuario", inversedBy="meGustaPublicacionUsuarioRel")
     * @ORM\JoinColumn(name="codigo_usuario_fk", referencedColumnName="codigo_usuario_pk")
     */
    protected $usuarioRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ComPublicacion", inversedBy="meGustaPublicacionPublicacionRel")
     * @ORM\JoinColumn(name="codigo_publicacion_fk", referencedColumnName="codigo_publicacion_pk")
     */
    protected $publicacionRel;

    /**
     * @return mixed
     */
    public function getCodigoMeGustaPublicacionPk()
    {
        return $this->codigoMeGustaPublicacionPk;
    }

    /**
     * @param mixed $codigoMeGustaPublicacionPk
     */
    public function setCodigoMeGustaPublicacionPk($codigoMeGustaPublicacionPk)
    {
        $this->codigoMeGustaPublicacionPk = $codigoMeGustaPublicacionPk;
        return $this;
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
    public function setCodigoUsuarioFk($codigoUsuarioFk)
    {
        $this->codigoUsuarioFk = $codigoUsuarioFk;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCodigoPublicacionFk()
    {
        return $this->codigoPublicacionFk;
    }

    /**
     * @param mixed $codigoPublicacionFk
     */
    public function setCodigoPublicacionFk($codigoPublicacionFk)
    {
        $this->codigoPublicacionFk = $codigoPublicacionFk;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
        return $this;
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
    public function setUsuarioRel($usuarioRel)
    {
        $this->usuarioRel = $usuarioRel;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPublicacionRel()
    {
        return $this->publicacionRel;
    }

    /**
     * @param mixed $publicacionRel
     */
    public function setPublicacionRel($publicacionRel)
    {
        $this->publicacionRel = $publicacionRel;
        return $this;
    }



}
