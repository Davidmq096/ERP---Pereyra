<?php

namespace AppBundle\Entity;

/**
 * BcEstatusdictamen
 */
class BcEstatusdictamen
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var integer
     */
    private $estatusid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return BcEstatusdictamen
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
     * Get estatusid
     *
     * @return integer
     */
    public function getEstatusid()
    {
        return $this->estatusid;
    }
}

