<?php

namespace AppBundle\Entity;

/**
 * Nivel
 */
class Nivel
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $nombrecorto;

    /**
     * @var string
     */
    private $letra;

    /**
     * @var string
     */
    private $claverevoe;

    /**
     * @var boolean
     */
    private $activo = '1';

    /**
     * @var boolean
     */
    private $requieresemestre;

    /**
     * @var integer
     */
    private $nivelid;

    /**
     * @var \AppBundle\Entity\CeConfiguracionnivel
     */
    private $configuracionnivelid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Nivel
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
     * Set nombrecorto
     *
     * @param string $nombrecorto
     *
     * @return Nivel
     */
    public function setNombrecorto($nombrecorto)
    {
        $this->nombrecorto = $nombrecorto;

        return $this;
    }

    /**
     * Get nombrecorto
     *
     * @return string
     */
    public function getNombrecorto()
    {
        return $this->nombrecorto;
    }

    /**
     * Set letra
     *
     * @param string $letra
     *
     * @return Nivel
     */
    public function setLetra($letra)
    {
        $this->letra = $letra;

        return $this;
    }

    /**
     * Get letra
     *
     * @return string
     */
    public function getLetra()
    {
        return $this->letra;
    }

    /**
     * Set claverevoe
     *
     * @param string $claverevoe
     *
     * @return Nivel
     */
    public function setClaverevoe($claverevoe)
    {
        $this->claverevoe = $claverevoe;

        return $this;
    }

    /**
     * Get claverevoe
     *
     * @return string
     */
    public function getClaverevoe()
    {
        return $this->claverevoe;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Nivel
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
     * Set requieresemestre
     *
     * @param boolean $requieresemestre
     *
     * @return Nivel
     */
    public function setRequieresemestre($requieresemestre)
    {
        $this->requieresemestre = $requieresemestre;

        return $this;
    }

    /**
     * Get requieresemestre
     *
     * @return boolean
     */
    public function getRequieresemestre()
    {
        return $this->requieresemestre;
    }

    /**
     * Get nivelid
     *
     * @return integer
     */
    public function getNivelid()
    {
        return $this->nivelid;
    }

    /**
     * Set configuracionnivelid
     *
     * @param \AppBundle\Entity\CeConfiguracionnivel $configuracionnivelid
     *
     * @return Nivel
     */
    public function setConfiguracionnivelid(\AppBundle\Entity\CeConfiguracionnivel $configuracionnivelid = null)
    {
        $this->configuracionnivelid = $configuracionnivelid;

        return $this;
    }

    /**
     * Get configuracionnivelid
     *
     * @return \AppBundle\Entity\CeConfiguracionnivel
     */
    public function getConfiguracionnivelid()
    {
        return $this->configuracionnivelid;
    }
}

