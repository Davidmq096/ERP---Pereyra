<?php

namespace AppBundle\Entity;

/**
 * BrExamenpresentacion
 */
class BrExamenpresentacion
{
    /**
     * @var string
     */
    private $instrucciones;

    /**
     * @var boolean
     */
    private $ordenaleatorioreactivo;

    /**
     * @var boolean
     */
    private $ordenaleatoriorespuesta;

    /**
     * @var boolean
     */
    private $seleccionaleatorioreactivos;

    /**
     * @var integer
     */
    private $cantidadreactivos;

    /**
     * @var boolean
     */
    private $calificacionautomatica;

    /**
     * @var integer
     */
    private $examenpresentacionid;

    /**
     * @var \AppBundle\Entity\BrMostrarreactivos
     */
    private $mostrarreactivoid;


    /**
     * Set instrucciones
     *
     * @param string $instrucciones
     *
     * @return BrExamenpresentacion
     */
    public function setInstrucciones($instrucciones)
    {
        $this->instrucciones = $instrucciones;

        return $this;
    }

    /**
     * Get instrucciones
     *
     * @return string
     */
    public function getInstrucciones()
    {
        return $this->instrucciones;
    }

    /**
     * Set ordenaleatorioreactivo
     *
     * @param boolean $ordenaleatorioreactivo
     *
     * @return BrExamenpresentacion
     */
    public function setOrdenaleatorioreactivo($ordenaleatorioreactivo)
    {
        $this->ordenaleatorioreactivo = $ordenaleatorioreactivo;

        return $this;
    }

    /**
     * Get ordenaleatorioreactivo
     *
     * @return boolean
     */
    public function getOrdenaleatorioreactivo()
    {
        return $this->ordenaleatorioreactivo;
    }

    /**
     * Set ordenaleatoriorespuesta
     *
     * @param boolean $ordenaleatoriorespuesta
     *
     * @return BrExamenpresentacion
     */
    public function setOrdenaleatoriorespuesta($ordenaleatoriorespuesta)
    {
        $this->ordenaleatoriorespuesta = $ordenaleatoriorespuesta;

        return $this;
    }

    /**
     * Get ordenaleatoriorespuesta
     *
     * @return boolean
     */
    public function getOrdenaleatoriorespuesta()
    {
        return $this->ordenaleatoriorespuesta;
    }

    /**
     * Set seleccionaleatorioreactivos
     *
     * @param boolean $seleccionaleatorioreactivos
     *
     * @return BrExamenpresentacion
     */
    public function setSeleccionaleatorioreactivos($seleccionaleatorioreactivos)
    {
        $this->seleccionaleatorioreactivos = $seleccionaleatorioreactivos;

        return $this;
    }

    /**
     * Get seleccionaleatorioreactivos
     *
     * @return boolean
     */
    public function getSeleccionaleatorioreactivos()
    {
        return $this->seleccionaleatorioreactivos;
    }

    /**
     * Set cantidadreactivos
     *
     * @param integer $cantidadreactivos
     *
     * @return BrExamenpresentacion
     */
    public function setCantidadreactivos($cantidadreactivos)
    {
        $this->cantidadreactivos = $cantidadreactivos;

        return $this;
    }

    /**
     * Get cantidadreactivos
     *
     * @return integer
     */
    public function getCantidadreactivos()
    {
        return $this->cantidadreactivos;
    }

    /**
     * Set calificacionautomatica
     *
     * @param boolean $calificacionautomatica
     *
     * @return BrExamenpresentacion
     */
    public function setCalificacionautomatica($calificacionautomatica)
    {
        $this->calificacionautomatica = $calificacionautomatica;

        return $this;
    }

    /**
     * Get calificacionautomatica
     *
     * @return boolean
     */
    public function getCalificacionautomatica()
    {
        return $this->calificacionautomatica;
    }

    /**
     * Get examenpresentacionid
     *
     * @return integer
     */
    public function getExamenpresentacionid()
    {
        return $this->examenpresentacionid;
    }

    /**
     * Set mostrarreactivoid
     *
     * @param \AppBundle\Entity\BrMostrarreactivos $mostrarreactivoid
     *
     * @return BrExamenpresentacion
     */
    public function setMostrarreactivoid(\AppBundle\Entity\BrMostrarreactivos $mostrarreactivoid = null)
    {
        $this->mostrarreactivoid = $mostrarreactivoid;

        return $this;
    }

    /**
     * Get mostrarreactivoid
     *
     * @return \AppBundle\Entity\BrMostrarreactivos
     */
    public function getMostrarreactivoid()
    {
        return $this->mostrarreactivoid;
    }
}

