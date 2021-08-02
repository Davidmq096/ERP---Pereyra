<?php

namespace AppBundle\Entity;

/**
 * Modulo
 */
class Modulo
{
    /**
     * @var string
     */
    private $identificador;

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
    private $sistema;

    /**
     * @var integer
     */
    private $orden;

    /**
     * @var integer
     */
    private $moduloid;


    /**
     * Set identificador
     *
     * @param string $identificador
     *
     * @return Modulo
     */
    public function setIdentificador($identificador)
    {
        $this->identificador = $identificador;

        return $this;
    }

    /**
     * Get identificador
     *
     * @return string
     */
    public function getIdentificador()
    {
        return $this->identificador;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Modulo
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
     * @return Modulo
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
     * Set sistema
     *
     * @param integer $sistema
     *
     * @return Modulo
     */
    public function setSistema($sistema)
    {
        $this->sistema = $sistema;

        return $this;
    }

    /**
     * Get sistema
     *
     * @return integer
     */
    public function getSistema()
    {
        return $this->sistema;
    }

    /**
     * Set orden
     *
     * @param integer $orden
     *
     * @return Modulo
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;

        return $this;
    }

    /**
     * Get orden
     *
     * @return integer
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * Get moduloid
     *
     * @return integer
     */
    public function getModuloid()
    {
        return $this->moduloid;
    }
}

