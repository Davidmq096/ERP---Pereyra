<?php

namespace AppBundle\Entity;

/**
 * CbEstatusbloqueo
 */
class CbEstatusbloqueo
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
    private $estatusbloqueoid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CbEstatusbloqueo
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
     * @return CbEstatusbloqueo
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
     * Get estatusbloqueoid
     *
     * @return integer
     */
    public function getEstatusbloqueoid()
    {
        return $this->estatusbloqueoid;
    }
}

