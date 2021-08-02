<?php

namespace AppBundle\Entity;

/**
 * TpContratoestatus
 */
class TpContratoestatus
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
    private $contratoestatusid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return TpContratoestatus
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
     * @return TpContratoestatus
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
     * Get contratoestatusid
     *
     * @return integer
     */
    public function getContratoestatusid()
    {
        return $this->contratoestatusid;
    }
}

