<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SocUsuarioAmigoRepository")
 */
class SocUsuarioAmigo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="codigo_usuario_amigo_pk", unique=true)
     */
    private $codigoUsuarioAmigoPk;

    /**
     * @ORM\Column(name="codigo_usuario_fk", type="string", nullable=false, length=100)
     */
    private $codigoUsuarioFk;

    /**
     * @ORM\Column(name="codigo_usuario_es_amigo_fk", type="string", nullable=false, length=100)
     */
    private $codigoUsuarioEsAmigoFk;

    /**
     * @ORM\Column(name="fecha_agregado", type="datetime", nullable=false)
     */
    private $fechaAgregado;

    /**
     * @ORM\Column(name="estado_amistad", type="boolean", options={"default":true})
     */
    private $estadoAmistad;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SocUsuario", inversedBy="usuarioAmigoRel")
     * @ORM\JoinColumn(name="codigo_usuario_fk", referencedColumnName="codigo_usuario_pk")
     */
    protected $usuarioRel;

    /**
     * @return mixed
     */
    public function getCodigoUsuarioAmigoPk()
    {
        return $this->codigoUsuarioAmigoPk;
    }

    /**
     * @param mixed $codigoAmigoPk
     */
    public function setCodigoUsuarioAmigoPk($codigoUsuarioAmigoPk)
    {
        $this->codigoUsuarioAmigoPk = $codigoUsuarioAmigoPk;
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
     * @param mixed $codigoPerfilFk
     */
    public function setCodigoUsuarioFk($codigoUsuarioFk)
    {
        $this->codigoUsuarioFk = $codigoUsuarioFk;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCodigoUsarioEsAmigoFk()
    {
        return $this->codigoUsuarioEsAmigoFk;
    }

    /**
     * @param mixed $codigoPerfilAmigoFk
     */
    public function setCodigoUsuarioEsAmigoFk($codigoUsuarioEsAmigoFk)
    {
        $this->codigoUsuarioEsAmigoFk = $codigoUsuarioEsAmigoFk;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFechaAgregado()
    {
        return $this->fechaAgregado;
    }

    /**
     * @param mixed $fechaAgregado
     */
    public function setFechaAgregado($fechaAgregado)
    {
        $this->fechaAgregado = $fechaAgregado;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEstadoAmistad()
    {
        return $this->estadoAmistad;
    }

    /**
     * @param mixed $estadoAmistad
     */
    public function setEstadoAmistad($estadoAmistad)
    {
        $this->estadoAmistad = $estadoAmistad;
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
     * @param mixed $perfilRel
     */
    public function setUsuarioRel($usuarioRel)
    {
        $this->usuarioRel = $usuarioRel;
        return $this;
    }



}
