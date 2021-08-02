<?php

namespace AppBundle\Entity;

/**
 * BcTipodocumento
 */
class BcTipodocumento
{
    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var integer
     */
    private $tipodocumentoid;


    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return BcTipodocumento
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
     * Set activo
     *
     * @param boolean $activo
     *
     * @return BcTipodocumento
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
     * Get tipodocumentoid
     *
     * @return integer
     */
    public function getTipodocumentoid()
    {
        return $this->tipodocumentoid;
    }
}

