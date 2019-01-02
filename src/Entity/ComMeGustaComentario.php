<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ComMeGustaComentarioRepository")
 */
class ComMeGustaComentario
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="codigo_me_gusta_comentario_pk", unique=true)
     */
    private $codigoMeGustaComentarioPk;

    /**
     * @ORM\Column(name="codigo_usuario_fk", type="string", nullable=false, length=100)
     */
    private $codigoUsuarioFk;

    /**
     * @ORM\Column(name="codigo_comentario_fk", type="integer", nullable=false)
     */
    private $codigoComentarioFk;

    /**
     * @ORM\Column(name="fecha", type="datetime", nullable=false)
     */
    private $fecha;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ComUsuario", inversedBy="meGustaComentarioUsuarioRel")
     * @ORM\JoinColumn(name="codigo_usuario_fk", referencedColumnName="codigo_usuario_pk")
     */
    protected $usuarioRel;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ComComentario", inversedBy="meGustaComentarioComentarioRel")
     * @ORM\JoinColumn(name="codigo_comentario_fk", referencedColumnName="codigo_comentario_pk")
     */
    protected $comentarioRel;

    /**
     * @return mixed
     */
    public function getCodigoMeGustaComentarioPk()
    {
        return $this->codigoMeGustaComentarioPk;
    }

    /**
     * @param mixed $codigoMeGustaComentarioPk
     */
    public function setCodigoMeGustaComentarioPk($codigoMeGustaComentarioPk)
    {
        $this->codigoMeGustaComentarioPk = $codigoMeGustaComentarioPk;
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
    public function getCodigoComentarioFk()
    {
        return $this->codigoComentarioFk;
    }

    /**
     * @param mixed $codigoComentarioFk
     */
    public function setCodigoComentarioFk($codigoComentarioFk)
    {
        $this->codigoComentarioFk = $codigoComentarioFk;
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
    public function getComentarioRel()
    {
        return $this->comentarioRel;
    }

    /**
     * @param mixed $comentarioRel
     */
    public function setComentarioRel($comentarioRel)
    {
        $this->comentarioRel = $comentarioRel;
        return $this;
    }


}
