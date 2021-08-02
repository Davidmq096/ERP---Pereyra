<?php

namespace AppBundle\Entity;

/**
 * BcEstatuspropiedad
 */
class BcEstatuspropiedad
{
    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var integer
     */
    private $instituto;

    /**
     * @var integer
     */
    private $estatusid;


    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return BcEstatuspropiedad
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
     * Set instituto
     *
     * @param integer $instituto
     *
     * @return BcEstatuspropiedad
     */
    public function setInstituto($instituto)
    {
        $this->instituto = $instituto;

        return $this;
    }

    /**
     * Get instituto
     *
     * @return integer
     */
    public function getInstituto()
    {
        return $this->instituto;
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

