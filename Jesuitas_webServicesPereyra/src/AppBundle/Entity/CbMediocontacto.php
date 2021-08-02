<?php

namespace AppBundle\Entity;

/**
 * CbMediocontacto
 */
class CbMediocontacto
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $activo;

    /**
     * @var integer
     */
    private $mediocontactoid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CbMediocontacto
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
     * @param string $activo
     *
     * @return CbMediocontacto
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return string
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Get mediocontactoid
     *
     * @return integer
     */
    public function getMediocontactoid()
    {
        return $this->mediocontactoid;
    }
}

