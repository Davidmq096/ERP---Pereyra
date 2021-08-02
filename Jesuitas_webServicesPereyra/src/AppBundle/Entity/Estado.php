<?php

namespace AppBundle\Entity;

/**
 * Estado
 */
class Estado
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $abreviatura;

    /**
     * @var boolean
     */
    private $activo = '1';

    /**
     * @var integer
     */
    private $estadoid;

    /**
     * @var \AppBundle\Entity\Pais
     */
    private $paisid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Estado
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set abreviatura
     *
     * @param string $abreviatura
     *
     * @return Estado
     */
    public function setAbreviatura($abreviatura)
    {
        $this->abreviatura = $abreviatura;

        return $this;
    }

    /**
     * Get abreviatura
     *
     * @return string
     */
    public function getAbreviatura()
    {
        return $this->abreviatura;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Estado
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Get estadoid
     *
     * @return integer
     */
    public function getEstadoid()
    {
        return $this->estadoid;
    }

    /**
     * Set paisid
     *
     * @param \AppBundle\Entity\Pais $paisid
     *
     * @return Estado
     */
    public function setPaisid(\AppBundle\Entity\Pais $paisid = null)
    {
        $this->paisid = $paisid;

        return $this;
    }

    /**
     * Get paisid
     *
     * @return \AppBundle\Entity\Pais
     */
    public function getPaisid()
    {
        return $this->paisid;
    }
}

