<?php

namespace AppBundle\Entity;

/**
 * CeMateriafrecuenciacaptura
 */
class CeMateriafrecuenciacaptura
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
    private $materiafrecuenciacapturaid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeMateriafrecuenciacaptura
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
     * @return CeMateriafrecuenciacaptura
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
     * Get materiafrecuenciacapturaid
     *
     * @return integer
     */
    public function getMateriafrecuenciacapturaid()
    {
        return $this->materiafrecuenciacapturaid;
    }
}

