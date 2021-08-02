<?php

namespace AppBundle\Entity;

/**
 * AdAdmisionestatuscontrato
 */
class AdAdmisionestatuscontrato
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var integer
     */
    private $estatuscontratoid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return AdAdmisionestatuscontrato
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
     * Get estatuscontratoid
     *
     * @return integer
     */
    public function getEstatuscontratoid()
    {
        return $this->estatuscontratoid;
    }
}

