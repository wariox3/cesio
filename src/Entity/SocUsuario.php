<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SocUsuarioRepository")
 */
class SocUsuario
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(name="codigo_usuario_pk", type="string", nullable=false, length=100)
     */
    private $codigoUsuarioPk;

    /**
     * @ORM\Column(name="nombre_corto", type="string",length=120)
     */
    private $nombreCorto;

    /**
     * @ORM\Column(name="clave", type="string", length=64)
     */
    private $clave;

    /**
     * @ORM\Column(name="estado_conexion", type="boolean", options={"default":false})
     */
    private $estadoConexion;

    /**
     * @ORM\Column(name="estado_cuenta", type="boolean", options={"default":true})
     */
    private $estadoCuenta;

    /**
     * @ORM\Column(name="empresa_pertenece", type="string", nullable=true, length=100)
     */
    private $empresaPertenece;

    /**
     * @ORM\Column(name="acerca_de_mi", type="string", nullable=true, length=512)
     */
    private $acercaDeMi;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SocUsuarioAmigo", mappedBy="usuarioRel", cascade={"remove","persist"})
     */
    protected $usuarioAmigoRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SocSolicitud", mappedBy="usuarioSolicitanteRel", cascade={"remove","persist"})
     */
    protected $solicitanteRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SocSolicitud", mappedBy="usuarioSolicitadoRel", cascade={"remove","persist"})
     */
    protected $solicitadoRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SocUsuarioAmigo", mappedBy="usuarioAmigoRel", cascade={"remove","persist"})
     */
    protected $usuarioEsAmigoRel;



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
    public function setCodigoUsuarioPk($codigoUsuarioPk)
    {
        $this->codigoUsuarioPk = $codigoUsuarioPk;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getEstadoCuenta()
    {
        return $this->estadoCuenta;
    }

    /**
     * @param mixed $estadoCuenta
     */
    public function setEstadoCuenta($estadoCuenta)
    {
        $this->estadoCuenta = $estadoCuenta;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmpresaPertenece()
    {
        return $this->empresaPertenece;
    }

    /**
     * @param mixed $empresaPertenece
     */
    public function setEmpresaPertenece($empresaPertenece)
    {
        $this->empresaPertenece = $empresaPertenece;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAcercaDeMi()
    {
        return $this->acercaDeMi;
    }

    /**
     * @param mixed $acercaDeMi
     */
    public function setAcercaDeMi($acercaDeMi)
    {
        $this->acercaDeMi = $acercaDeMi;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAmigoRel()
    {
        return $this->amigoRel;
    }

    /**
     * @param mixed $amigoRel
     */
    public function setAmigoRel($amigoRel)
    {
        $this->amigoRel = $amigoRel;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSolicitanteRel()
    {
        return $this->solicitanteRel;
    }

    /**
     * @param mixed $solicitanteRel
     */
    public function setSolicitanteRel($solicitanteRel)
    {
        $this->solicitanteRel = $solicitanteRel;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSolicitadoRel()
    {
        return $this->solicitadoRel;
    }

    /**
     * @param mixed $solicitadoRel
     */
    public function setSolicitadoRel($solicitadoRel)
    {
        $this->solicitadoRel = $solicitadoRel;
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
    public function getEstadoConexion()
    {
        return $this->estadoConexion;
    }

    /**
     * @param mixed $estadoConexion
     */
    public function setEstadoConexion($estadoConexion)
    {
        $this->estadoConexion = $estadoConexion;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsuarioAmigoRel()
    {
        return $this->usuarioAmigoRel;
    }

    /**
     * @param mixed $usuarioAmigoRel
     */
    public function setUsuarioAmigoRel($usuarioAmigoRel)
    {
        $this->usuarioAmigoRel = $usuarioAmigoRel;
        return $this;
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
    public function setClave($clave)
    {
        $this->clave = $clave;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNombreCorto()
    {
        return $this->nombreCorto;
    }/**
 * @param mixed $nombreCorto
 */
    public function setNombreCorto($nombreCorto)
    {
        $this->nombreCorto = $nombreCorto;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsuarioEsAmigoRel()
    {
        return $this->usuarioEsAmigoRel;
    }

    /**
     * @param mixed $usuarioEsAmigoRel
     */
    public function setUsuarioEsAmigoRel($usuarioEsAmigoRel)
    {
        $this->usuarioEsAmigoRel = $usuarioEsAmigoRel;
        return $this;
    }



}
