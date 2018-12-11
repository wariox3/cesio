<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SocSolicitudRepository")
 */
class SocSolicitud
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="codigo_solicitud_pk", unique=true)
     */
    private $codigoSolicitudPk;

    /**
     * @ORM\Column(name="codigo_usuario_solicitante_fk", type="string", length=100, nullable=false)
     */
    private $codigoUsuarioSolicitanteFk;

    /**
     * @ORM\Column(name="codigo_usuario_solicitado_fk", type="string", length=100, nullable=false)
     */
    private $codigoUsuarioSolicitadoFk;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SocUsuario", inversedBy="solicitanteRel")
     * @ORM\JoinColumn(name="codigo_usuario_solicitante_fk", referencedColumnName="codigo_usuario_pk")
     */
    protected $usuarioSolicitanteRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SocUsuario", inversedBy="solicitadoRel")
     * @ORM\JoinColumn(name="codigo_usuario_solicitado_fk", referencedColumnName="codigo_usuario_pk")
     */
    protected $usuarioSolicitadoRel;

    /**
     * @return mixed
     */
    public function getCodigoSolicitudPk()
    {
        return $this->codigoSolicitudPk;
    }

    /**
     * @return mixed
     */
    public function getCodigoUsuarioSolicitanteFk()
    {
        return $this->codigoUsuarioSolicitanteFk;
    }

    /**
     * @param mixed $codigoUsuarioSolicitanteFk
     */
    public function setCodigoUsuarioSolicitanteFk($codigoUsuarioSolicitanteFk)
    {
        $this->codigoUsuarioSolicitanteFk = $codigoUsuarioSolicitanteFk;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCodigoUsuarioSolicitadoFk()
    {
        return $this->codigoUsuarioSolicitadoFk;
    }

    /**
     * @param mixed $codigoUsuarioSolicitadoFk
     */
    public function setCodigoUsuarioSolicitadoFk($codigoUsuarioSolicitadoFk)
    {
        $this->codigoUsuarioSolicitadoFk = $codigoUsuarioSolicitadoFk;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsuarioSolicitanteRel()
    {
        return $this->usuarioSolicitanteRel;
    }

    /**
     * @param mixed $usuarioSolicitanteRel
     */
    public function setUsuarioSolicitanteRel($usuarioSolicitanteRel)
    {
        $this->usuarioSolicitanteRel = $usuarioSolicitanteRel;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsuarioSolicitadoRel()
    {
        return $this->usuarioSolicitadoRel;
    }

    /**
     * @param mixed $usuarioSolicitadoRel
     */
    public function setUsuarioSolicitadoRel($usuarioSolicitadoRel)
    {
        $this->usuarioSolicitadoRel = $usuarioSolicitadoRel;
        return $this;
    }



}
