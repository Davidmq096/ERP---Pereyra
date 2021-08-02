<?php

namespace AppBundle\Entity;

/**
 * CjUsocfdi
 */
class CjUsocfdi
{
    /**
     * @var string
     */
    private $clave;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var boolean
     */
    private $fisica;

    /**
     * @var boolean
     */
    private $moral;

    /**
     * @var boolean
     */
    private $activo = '1';

    /**
     * @var integer
     */
    private $usocfdiid;


    /**
     * Set clave
     *
     * @param string $clave
     *
     * @return CjUsocfdi
     */
    public function setClave($clave)
    {
        $this->clave = $clave;

        return $this;
    }

    /**
     * Get clave
     *
     * @return string
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return CjUsocfdi
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
     * Set fisica
     *
     * @param boolean $fisica
     *
     * @return CjUsocfdi
     */
    public function setFisica($fisica)
    {
        $this->fisica = $fisica;

        return $this;
    }

    /**
     * Get fisica
     *
     * @return boolean
     */
    public function getFisica()
    {
        return $this->fisica;
    }

    /**
     * Set moral
     *
     * @param boolean $moral
     *
     * @return CjUsocfdi
     */
    public function setMoral($moral)
    {
        $this->moral = $moral;

        return $this;
    }

    /**
     * Get moral
     *
     * @return boolean
     */
    public function getMoral()
    {
        return $this->moral;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CjUsocfdi
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
     * Get usocfdiid
     *
     * @return integer
     */
    public function getUsocfdiid()
    {
        return $this->usocfdiid;
    }
}

