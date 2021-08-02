<?php

namespace AppBundle\Entity;

/**
 * CjPagoestatus
 */
class CjPagoestatus
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var boolean
     */
    private $esadeudo;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var integer
     */
    private $pagoestatusid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CjPagoestatus
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
     * Set esadeudo
     *
     * @param boolean $esadeudo
     *
     * @return CjPagoestatus
     */
    public function setEsadeudo($esadeudo)
    {
        $this->esadeudo = $esadeudo;

        return $this;
    }

    /**
     * Get esadeudo
     *
     * @return boolean
     */
    public function getEsadeudo()
    {
        return $this->esadeudo;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CjPagoestatus
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
     * Get pagoestatusid
     *
     * @return integer
     */
    public function getPagoestatusid()
    {
        return $this->pagoestatusid;
    }
}

