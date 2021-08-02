<?php

namespace AppBundle\Entity;

/**
 * CeAvisosporcaratulaestatus
 */
class CeAvisosporcaratulaestatus
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
    private $avisocaratulaestatusid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeAvisosporcaratulaestatus
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
     * @return CeAvisosporcaratulaestatus
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
     * Get avisocaratulaestatusid
     *
     * @return integer
     */
    public function getAvisocaratulaestatusid()
    {
        return $this->avisocaratulaestatusid;
    }
}

