<?php

namespace AppBundle\Entity;

/**
 * Colonia
 */
class Colonia
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var integer
     */
    private $cp;

    /**
     * @var integer
     */
    private $coloniaid;

    /**
     * @var \AppBundle\Entity\Municipio
     */
    private $municipioid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Colonia
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
     * Set cp
     *
     * @param integer $cp
     *
     * @return Colonia
     */
    public function setCp($cp)
    {
        $this->cp = $cp;

        return $this;
    }

    /**
     * Get cp
     *
     * @return integer
     */
    public function getCp()
    {
        return $this->cp;
    }

    /**
     * Get coloniaid
     *
     * @return integer
     */
    public function getColoniaid()
    {
        return $this->coloniaid;
    }

    /**
     * Set municipioid
     *
     * @param \AppBundle\Entity\Municipio $municipioid
     *
     * @return Colonia
     */
    public function setMunicipioid(\AppBundle\Entity\Municipio $municipioid = null)
    {
        $this->municipioid = $municipioid;

        return $this;
    }

    /**
     * Get municipioid
     *
     * @return \AppBundle\Entity\Municipio
     */
    public function getMunicipioid()
    {
        return $this->municipioid;
    }
}

