<?php

namespace AppBundle\Entity;

/**
 * CjMediopago
 */
class CjMediopago
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
    private $mediopagoid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CjMediopago
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
     * @return CjMediopago
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
     * Get mediopagoid
     *
     * @return integer
     */
    public function getMediopagoid()
    {
        return $this->mediopagoid;
    }
}

