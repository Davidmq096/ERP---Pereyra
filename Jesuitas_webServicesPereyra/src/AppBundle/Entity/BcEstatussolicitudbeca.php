<?php

namespace AppBundle\Entity;

/**
 * BcEstatussolicitudbeca
 */
class BcEstatussolicitudbeca
{
    /**
     * @var integer
     */
    private $activo;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var integer
     */
    private $estatusid;


    /**
     * Set activo
     *
     * @param integer $activo
     *
     * @return BcEstatussolicitudbeca
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return integer
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return BcEstatussolicitudbeca
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Get estatusid
     *
     * @return integer
     */
    public function getEstatusid()
    {
        return $this->estatusid;
    }
}

