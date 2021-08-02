<?php

namespace AppBundle\Entity;

/**
 * Parametros
 */
class Parametros
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $valor;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var integer
     */
    private $parametrosid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Parametros
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
     * Set valor
     *
     * @param string $valor
     *
     * @return Parametros
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Parametros
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
     * Get parametrosid
     *
     * @return integer
     */
    public function getParametrosid()
    {
        return $this->parametrosid;
    }
}

