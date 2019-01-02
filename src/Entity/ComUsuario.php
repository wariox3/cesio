<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ComUsuarioRepository")
 */
class ComUsuario
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
     * @ORM\OneToMany(targetEntity="App\Entity\ComUsuarioAmigo", mappedBy="usuarioRel", cascade={"remove","persist"})
     */
    protected $usuarioAmigoRel;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ComUsuarioAmigo", mappedBy="usuarioAmigoRel", cascade={"remove","persist"})
     */
    protected $usuarioEsAmigoRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ComPublicacion", mappedBy="usuarioRel", cascade={"remove","persist"})
     */
    protected $publicacionComUsuarioRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ComComentario", mappedBy="usuarioRel", cascade={"remove","persist"})
     */
    protected $comentarioUsuarioRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ComMeGustaPublicacion", mappedBy="usuarioRel", cascade={"remove","persist"})
     */
    protected $meGustaPublicacionUsuarioRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ComMeGustaComentario", mappedBy="usuarioRel", cascade={"remove", "persist"})
     */
    protected $meGustaComentarioUsuarioRel;

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

    /**
     * @return mixed
     */
    public function getPublicacionComUsuario()
    {
        return $this->publicacionComUsuario;
    }

    /**
     * @param mixed $publicacionComUsuario
     */
    public function setPublicacionComUsuario($publicacionComUsuario)
    {
        $this->publicacionComUsuario = $publicacionComUsuario;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPublicacionComUsuarioRel()
    {
        return $this->publicacionComUsuarioRel;
    }

    /**
     * @param mixed $publicacionComUsuarioRel
     */
    public function setPublicacionComUsuarioRel($publicacionComUsuarioRel)
    {
        $this->publicacionComUsuarioRel = $publicacionComUsuarioRel;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComentarioUsuarioRel()
    {
        return $this->comentarioUsuarioRel;
    }

    /**
     * @param mixed $comentarioUsuarioRel
     */
    public function setComentarioUsuarioRel($comentarioUsuarioRel)
    {
        $this->comentarioUsuarioRel = $comentarioUsuarioRel;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMeGustaPublicacionUsuarioRel()
    {
        return $this->meGustaPublicacionUsuarioRel;
    }

    /**
     * @param mixed $meGustaPublicacionUsuarioRel
     */
    public function setMeGustaPublicacionUsuarioRel($meGustaPublicacionUsuarioRel)
    {
        $this->meGustaPublicacionUsuarioRel = $meGustaPublicacionUsuarioRel;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMeGustaComentarioUsuarioRel()
    {
        return $this->meGustaComentarioUsuarioRel;
    }

    /**
     * @param mixed $meGustaComentarioUsuarioRel
     */
    public function setMeGustaComentarioUsuarioRel($meGustaComentarioUsuarioRel)
    {
        $this->meGustaComentarioUsuarioRel = $meGustaComentarioUsuarioRel;
        return $this;
    }





}
