<?php

namespace AppBundle\Entity;

/**
 * TpBoletoestatus
 */
class TpBoletoestatus
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
    private $boletoestatusid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return TpBoletoestatus
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
     * @return TpBoletoestatus
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
     * Get boletoestatusid
     *
     * @return integer
     */
    public function getBoletoestatusid()
    {
        return $this->boletoestatusid;
    }
}

