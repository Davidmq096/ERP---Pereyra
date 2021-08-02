<?php

namespace AppBundle\Entity;

/**
 * CeTareaalumnovinculo
 */
class CeTareaalumnovinculo
{
    /**
     * @var integer
     */
    private $tareaalumnoid;

    /**
     * @var string
     */
    private $vinculo;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var boolean
     */
    private $leido;

    /**
     * @var integer
     */
    private $tareaalumnovinculoid;


    /**
     * Set tareaalumnoid
     *
     * @param integer $tareaalumnoid
     *
     * @return CeTareaalumnovinculo
     */
    public function setTareaalumnoid($tareaalumnoid)
    {
        $this->tareaalumnoid = $tareaalumnoid;

        return $this;
    }

    /**
     * Get tareaalumnoid
     *
     * @return integer
     */
    public function getTareaalumnoid()
    {
        return $this->tareaalumnoid;
    }

    /**
     * Set vinculo
     *
     * @param string $vinculo
     *
     * @return CeTareaalumnovinculo
     */
    public function setVinculo($vinculo)
    {
        $this->vinculo = $vinculo;

        return $this;
    }

    /**
     * Get vinculo
     *
     * @return string
     */
    public function getVinculo()
    {
        return $this->vinculo;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return CeTareaalumnovinculo
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
     * Set leido
     *
     * @param boolean $leido
     *
     * @return CeTareaalumnovinculo
     */
    public function setLeido($leido)
    {
        $this->leido = $leido;

        return $this;
    }

    /**
     * Get leido
     *
     * @return boolean
     */
    public function getLeido()
    {
        return $this->leido;
    }

    /**
     * Get tareaalumnovinculoid
     *
     * @return integer
     */
    public function getTareaalumnovinculoid()
    {
        return $this->tareaalumnovinculoid;
    }
}

