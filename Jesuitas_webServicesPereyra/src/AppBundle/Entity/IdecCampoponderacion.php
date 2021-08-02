<?php

namespace AppBundle\Entity;

/**
 * IdecCampoponderacion
 */
class IdecCampoponderacion
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
    private $campoponderacionid;

    /**
     * @var \AppBundle\Entity\IdecTablaponderacion
     */
    private $tablaponderacionid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return IdecCampoponderacion
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
     * @return IdecCampoponderacion
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
     * Get campoponderacionid
     *
     * @return integer
     */
    public function getCampoponderacionid()
    {
        return $this->campoponderacionid;
    }

    /**
     * Set tablaponderacionid
     *
     * @param \AppBundle\Entity\IdecTablaponderacion $tablaponderacionid
     *
     * @return IdecCampoponderacion
     */
    public function setTablaponderacionid(\AppBundle\Entity\IdecTablaponderacion $tablaponderacionid = null)
    {
        $this->tablaponderacionid = $tablaponderacionid;

        return $this;
    }

    /**
     * Get tablaponderacionid
     *
     * @return \AppBundle\Entity\IdecTablaponderacion
     */
    public function getTablaponderacionid()
    {
        return $this->tablaponderacionid;
    }
}

