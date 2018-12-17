<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ComComentarioRepository")
 */
class ComComentario
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="codigo_comentario_pk", unique=true)
     */
    private $codigoComentarioPk;

    /**
     * @ORM\Column(name="codigo_publicacion_fk", type="integer", nullable=false)
     */
    private $codigoPublicacionFk;

    /**
     * @ORM\Column(name="codigo_padre_fk", type="integer", nullable=true)
     */
    private $codigoPadreFk;

    /**
     * @ORM\Column(name="texto_comentario", type="string", length=512)
     */
    private $texto_comentario;

    /**
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @ORM\Column(name="me_gusta", type="integer", options={"default":0})
     */
    private $meGusta;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ComPublicacion", inversedBy="comentarioPublicacionRel")
     * @ORM\JoinColumn(name="codigo_publicacion_fk", referencedColumnName="codigo_publicacion_pk")
     */
    protected $publicacionRel;

    /**
     * @return mixed
     */
    public function getCodigoComentarioPk()
    {
        return $this->codigoComentarioPk;
    }

    /**
     * @param mixed $codigoComentarioPk
     */
    public function setCodigoComentarioPk($codigoComentarioPk)
    {
        $this->codigoComentarioPk = $codigoComentarioPk;
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
    public function getCodigoPadreFk()
    {
        return $this->codigoPadreFk;
    }

    /**
     * @param mixed $codigoPadreFk
     */
    public function setCodigoPadreFk($codigoPadreFk)
    {
        $this->codigoPadreFk = $codigoPadreFk;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTextoComentario()
    {
        return $this->texto_comentario;
    }

    /**
     * @param mixed $texto_comentario
     */
    public function setTextoComentario($texto_comentario)
    {
        $this->texto_comentario = $texto_comentario;
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
