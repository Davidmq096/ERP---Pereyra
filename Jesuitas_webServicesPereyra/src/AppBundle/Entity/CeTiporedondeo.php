<?php

namespace AppBundle\Entity;

/**
 * CeTiporedondeo
 */
class CeTiporedondeo
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
     * @var string
     */
    private $funcionredondeo;

    /**
     * @var integer
     */
    private $tiporedondeoid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeTiporedondeo
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
     * @return CeTiporedondeo
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
     * Set funcionredondeo
     *
     * @param string $funcionredondeo
     *
     * @return CeTiporedondeo
     */
    public function setFuncionredondeo($funcionredondeo)
    {
        $this->funcionredondeo = $funcionredondeo;

        return $this;
    }

    /**
     * Get funcionredondeo
     *
     * @return string
     */
    public function getFuncionredondeo()
    {
        return $this->funcionredondeo;
    }

    /**
     * Get tiporedondeoid
     *
     * @return integer
     */
    public function getTiporedondeoid()
    {
        return $this->tiporedondeoid;
    }
}

