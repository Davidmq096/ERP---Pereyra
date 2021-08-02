<?php

namespace AppBundle\Entity;

/**
 * CbTipoacuerdo
 */
class CbTipoacuerdo
{
    /**
     * @var string
     */
    private $nombre = 'NULL';

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var integer
     */
    private $tipoacuerdoid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CbTipoacuerdo
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
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CbTipoacuerdo
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
     * Get tipoacuerdoid
     *
     * @return integer
     */
    public function getTipoacuerdoid()
    {
        return $this->tipoacuerdoid;
    }
}

