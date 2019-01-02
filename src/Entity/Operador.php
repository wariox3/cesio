<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OperadorRepository")
 */
class Operador
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=20, nullable=false, unique=true)
     */
    private $codigoOperadorPk;

    /**
     * @ORM\Column(name="nombre", type="string", length=200, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(name="url_servicio", type="string", length=500, nullable=true)
     */
    private $urlServicio;

    /**
     * @return mixed
     */
    public function getCodigoOperadorPk()
    {
        return $this->codigoOperadorPk;
    }

    /**
     * @param mixed $codigoOperadorPk
     */
    public function setCodigoOperadorPk($codigoOperadorPk): void
    {
        $this->codigoOperadorPk = $codigoOperadorPk;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getUrlServicio()
    {
        return $this->urlServicio;
    }

    /**
     * @param mixed $urlServicio
     */
    public function setUrlServicio($urlServicio): void
    {
        $this->urlServicio = $urlServicio;
    }



}

