<?php

namespace AppBundle\Entity;

/**
 * IdecTablaponderacion
 */
class IdecTablaponderacion
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var boolean
     */
    private $vista;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var integer
     */
    private $tablaponderacionid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return IdecTablaponderacion
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
     * Set vista
     *
     * @param boolean $vista
     *
     * @return IdecTablaponderacion
     */
    public function setVista($vista)
    {
        $this->vista = $vista;

        return $this;
    }

    /**
     * Get vista
     *
     * @return boolean
     */
    public function getVista()
    {
        return $this->vista;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return IdecTablaponderacion
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
     * Get tablaponderacionid
     *
     * @return integer
     */
    public function getTablaponderacionid()
    {
        return $this->tablaponderacionid;
    }
}

