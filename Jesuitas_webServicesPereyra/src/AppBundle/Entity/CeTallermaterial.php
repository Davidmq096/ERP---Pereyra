<?php

namespace AppBundle\Entity;

/**
 * CeTallermaterial
 */
class CeTallermaterial
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var boolean
     */
    private $pedirtalla = '0';

    /**
     * @var boolean
     */
    private $activo = '0';

    /**
     * @var integer
     */
    private $tallermaterialid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeTallermaterial
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
     * Set pedirtalla
     *
     * @param boolean $pedirtalla
     *
     * @return CeTallermaterial
     */
    public function setPedirtalla($pedirtalla)
    {
        $this->pedirtalla = $pedirtalla;

        return $this;
    }

    /**
     * Get pedirtalla
     *
     * @return boolean
     */
    public function getPedirtalla()
    {
        return $this->pedirtalla;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CeTallermaterial
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
     * Get tallermaterialid
     *
     * @return integer
     */
    public function getTallermaterialid()
    {
        return $this->tallermaterialid;
    }
}

