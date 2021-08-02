<?php

namespace AppBundle\Entity;

/**
 * Formato
 */
class Formato
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $formatocontenido;

    /**
     * @var string
     */
    private $formatosize;

    /**
     * @var string
     */
    private $formatotipo;

    /**
     * @var boolean
     */
    private $obligatorio;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var integer
     */
    private $formatoid;

    /**
     * @var \AppBundle\Entity\Tipoformato
     */
    private $tipoformatoid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Formato
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
     * Set formatocontenido
     *
     * @param string $formatocontenido
     *
     * @return Formato
     */
    public function setFormatocontenido($formatocontenido)
    {
        $this->formatocontenido = $formatocontenido;

        return $this;
    }

    /**
     * Get formatocontenido
     *
     * @return string
     */
    public function getFormatocontenido()
    {
        return $this->formatocontenido;
    }

    /**
     * Set formatosize
     *
     * @param string $formatosize
     *
     * @return Formato
     */
    public function setFormatosize($formatosize)
    {
        $this->formatosize = $formatosize;

        return $this;
    }

    /**
     * Get formatosize
     *
     * @return string
     */
    public function getFormatosize()
    {
        return $this->formatosize;
    }

    /**
     * Set formatotipo
     *
     * @param string $formatotipo
     *
     * @return Formato
     */
    public function setFormatotipo($formatotipo)
    {
        $this->formatotipo = $formatotipo;

        return $this;
    }

    /**
     * Get formatotipo
     *
     * @return string
     */
    public function getFormatotipo()
    {
        return $this->formatotipo;
    }

    /**
     * Set obligatorio
     *
     * @param boolean $obligatorio
     *
     * @return Formato
     */
    public function setObligatorio($obligatorio)
    {
        $this->obligatorio = $obligatorio;

        return $this;
    }

    /**
     * Get obligatorio
     *
     * @return boolean
     */
    public function getObligatorio()
    {
        return $this->obligatorio;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Formato
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
     * Get formatoid
     *
     * @return integer
     */
    public function getFormatoid()
    {
        return $this->formatoid;
    }

    /**
     * Set tipoformatoid
     *
     * @param \AppBundle\Entity\Tipoformato $tipoformatoid
     *
     * @return Formato
     */
    public function setTipoformatoid(\AppBundle\Entity\Tipoformato $tipoformatoid = null)
    {
        $this->tipoformatoid = $tipoformatoid;

        return $this;
    }

    /**
     * Get tipoformatoid
     *
     * @return \AppBundle\Entity\Tipoformato
     */
    public function getTipoformatoid()
    {
        return $this->tipoformatoid;
    }
}

