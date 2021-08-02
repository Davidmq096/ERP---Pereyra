<?php

namespace AppBundle\Entity;

/**
 * CjFacturaestatus
 */
class CjFacturaestatus
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var integer
     */
    private $facturaestatusid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CjFacturaestatus
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
     * @return CjFacturaestatus
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
     * Get facturaestatusid
     *
     * @return integer
     */
    public function getFacturaestatusid()
    {
        return $this->facturaestatusid;
    }
}

