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
}
