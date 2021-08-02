<?php

namespace AppBundle\Entity;

/**
 * CbEstatusacuerdo
 */
class CbEstatusacuerdo
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
    private $estatusacuerdoid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CbEstatusacuerdo
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
     * @return CbEstatusacuerdo
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
     * Get estatusacuerdoid
     *
     * @return integer
     */
    public function getEstatusacuerdoid()
    {
        return $this->estatusacuerdoid;
    }
}

