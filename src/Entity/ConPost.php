<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ConPostRepository")
 */
class ConPost
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="codigo_post_pk")
     */
    private $codigoPostPk;

    /**
     * @ORM\Column(name="titulo", type="string", length=100, nullable=true)
     */
    private $titulo;

    /**
     * @ORM\Column(name="tags", type="string", length=255, nullable=true)
     */
    private $tags;

    /**
     * @ORM\Column(name="autor", type="string", length=100, nullable=true)
     */
    private $autor;

    /**
     * @ORM\Column(name="descripcion", type="text", nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\Column(name="fecha_publicacion", type="datetime", nullable=true)
     */
    private $fechaPublicacion;

    /**
     * @ORM\Column(name="numero_comentarios", type="integer", nullable=true)
     */
    private $numeroComentarios;

    /**
     * @ORM\Column(name="imagen_html", type="text", nullable=true)
     */
    private $imagenHtml;

    /**
     * @return mixed
     */
    public function getCodigoPostPk()
    {
        return $this->codigoPostPk;
    }

    /**
     * @param mixed $codigoPostPk
     */
    public function setCodigoPostPk($codigoPostPk): void
    {
        $this->codigoPostPk = $codigoPostPk;
    }

    /**
     * @return mixed
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * @param mixed $titulo
     */
    public function setTitulo($titulo): void
    {
        $this->titulo = $titulo;
    }

    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param mixed $tags
     */
    public function setTags($tags): void
    {
        $this->tags = $tags;
    }

    /**
     * @return mixed
     */
    public function getAutor()
    {
        return $this->autor;
    }

    /**
     * @param mixed $autor
     */
    public function setAutor($autor): void
    {
        $this->autor = $autor;
    }

    /**
     * @return mixed
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param mixed $descripcion
     */
    public function setDescripcion($descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @return mixed
     */
    public function getFechaPublicacion()
    {
        return $this->fechaPublicacion;
    }

    /**
     * @param mixed $fechaPublicacion
     */
    public function setFechaPublicacion($fechaPublicacion): void
    {
        $this->fechaPublicacion = $fechaPublicacion;
    }

    /**
     * @return mixed
     */
    public function getNumeroComentarios()
    {
        return $this->numeroComentarios;
    }

    /**
     * @param mixed $numeroComentarios
     */
    public function setNumeroComentarios($numeroComentarios): void
    {
        $this->numeroComentarios = $numeroComentarios;
    }

    /**
     * @return mixed
     */
    public function getImagenHtml()
    {
        return $this->imagenHtml;
    }

    /**
     * @param mixed $imagenHtml
     */
    public function setImagenHtml($imagenHtml): void
    {
        $this->imagenHtml = $imagenHtml;
    }
}
