<?php

namespace AppBundle\Entity;

/**
 * CeEstatusestudio
 */
class CeEstatusestudio
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var integer
     */
    private $activo;

    /**
     * @var integer
     */
    private $estatusestudioid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeEstatusestudio
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
     * @param integer $activo
     *
     * @return CeEstatusestudio
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return integer
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Get estatusestudioid
     *
     * @return integer
     */
    public function getEstatusestudioid()
    {
        return $this->estatusestudioid;
    }
}

