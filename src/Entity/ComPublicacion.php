<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ComPublicacionRepository")
 */
class ComPublicacion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="codigo_publicacion_pk", unique=true)
     */
    private $codigoPublicacionPk;

    /**
     * @ORM\Column(name="codigo_usuario_fk", type="string", nullable=false, length=100)
     */
    private $codigoUsuarioFk;

    /**
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @ORM\Column(name="total_comentarios", type="integer", options={"default":0})
     */
    private $totalComentarios;

    /**
     * @ORM\Column(name="texto_publicacion", type="string", length=512, nullable=false)
     */
    private $textoPublicacion;

    /**
     * @ORM\Column(name="me_gusta", type="integer", options={"default":0})
     */
    private $meGusta;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ComUsuario", inversedBy="publicacionComUsuarioRel")
     * @ORM\JoinColumn(name="codigo_usuario_fk", referencedColumnName="codigo_usuario_pk")
     */
    protected $usuarioRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ComComentario", mappedBy="publicacionRel", cascade={"persist","remove"})
     */
    protected $comentarioPublicacionRel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ComMeGustaPublicacion", mappedBy="publicacionRel", cascade={"persist", "remove"})
     */
    protected $meGustaPublicacionPublicacionRel;

    /**
     * @return mixed
     */
    public function getCodigoPublicacionPk()
    {
        return $this->codigoPublicacionPk;
    }

    /**
     * @param mixed $codigoPublicacionPk
     */
    public function setCodigoPublicacionPk($codigoPublicacionPk)
    {
        $this->codigoPublicacionPk = $codigoPublicacionPk;
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
    public function getTotalComentarios()
    {
        return $this->totalComentarios;
    }

    /**
     * @param mixed $totalComentarios
     */
    public function setTotalComentarios($totalComentarios)
    {
        $this->totalComentarios = $totalComentarios;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTextoPublicacion()
    {
        return $this->textoPublicacion;
    }

    /**
     * @param mixed $textoPublicacion
     */
    public function setTextoPublicacion($textoPublicacion)
    {
        $this->textoPublicacion = $textoPublicacion;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMeGusta()
    {
        return $this->meGusta;
    }

    /**
     * @param mixed $meGusta
     */
    public function setMeGusta($meGusta)
    {
        $this->meGusta = $meGusta;
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
     * @param mixed $UsuarioRel
     */
    public function setUsuarioRel($usuarioRel)
    {
        $this->usuarioRel = $usuarioRel;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComentarioPublicacionRel()
    {
        return $this->comentarioPublicacionRel;
    }

    /**
     * @param mixed $comentarioPublicacionRel
     */
    public function setComentarioPublicacionRel($comentarioPublicacionRel)
    {
        $this->comentarioPublicacionRel = $comentarioPublicacionRel;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMeGustaPublicacionPublicacionRel()
    {
        return $this->meGustaPublicacionPublicacionRel;
    }

    /**
     * @param mixed $meGustaPublicacionPublicacionRel
     */
    public function setMeGustaPublicacionPublicacionRel($meGustaPublicacionPublicacionRel)
    {
        $this->meGustaPublicacionPublicacionRel = $meGustaPublicacionPublicacionRel;
        return $this;
    }



}
