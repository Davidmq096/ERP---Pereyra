<?php

namespace AppBundle\Entity;

/**
 * Pregunta
 */
class Pregunta
{
    /**
     * @var string
     */
    private $pregunta;

    /**
     * @var integer
     */
    private $valorporcentaje;

    /**
     * @var boolean
     */
    private $tipoordenamiento;

    /**
     * @var boolean
     */
    private $anidada;

    /**
     * @var boolean
     */
    private $resaltar;

    /**
     * @var integer
     */
    private $color;

    /**
     * @var boolean
     */
    private $validar;

    /**
     * @var integer
     */
    private $preguntaid;

    /**
     * @var \AppBundle\Entity\Respuesta
     */
    private $padreid;

    /**
     * @var \AppBundle\Entity\Tipopregunta
     */
    private $tipopreguntaid;


    /**
     * Set pregunta
     *
     * @param string $pregunta
     *
     * @return Pregunta
     */
    public function setPregunta($pregunta)
    {
        $this->pregunta = $pregunta;

        return $this;
    }

    /**
     * Get pregunta
     *
     * @return string
     */
    public function getPregunta()
    {
        return $this->pregunta;
    }

    /**
     * Set valorporcentaje
     *
     * @param integer $valorporcentaje
     *
     * @return Pregunta
     */
    public function setValorporcentaje($valorporcentaje)
    {
        $this->valorporcentaje = $valorporcentaje;

        return $this;
    }

    /**
     * Get valorporcentaje
     *
     * @return integer
     */
    public function getValorporcentaje()
    {
        return $this->valorporcentaje;
    }

    /**
     * Set tipoordenamiento
     *
     * @param boolean $tipoordenamiento
     *
     * @return Pregunta
     */
    public function setTipoordenamiento($tipoordenamiento)
    {
        $this->tipoordenamiento = $tipoordenamiento;

        return $this;
    }

    /**
     * Get tipoordenamiento
     *
     * @return boolean
     */
    public function getTipoordenamiento()
    {
        return $this->tipoordenamiento;
    }

    /**
     * Set anidada
     *
     * @param boolean $anidada
     *
     * @return Pregunta
     */
    public function setAnidada($anidada)
    {
        $this->anidada = $anidada;

        return $this;
    }

    /**
     * Get anidada
     *
     * @return boolean
     */
    public function getAnidada()
    {
        return $this->anidada;
    }

    /**
     * Set resaltar
     *
     * @param boolean $resaltar
     *
     * @return Pregunta
     */
    public function setResaltar($resaltar)
    {
        $this->resaltar = $resaltar;

        return $this;
    }

    /**
     * Get resaltar
     *
     * @return boolean
     */
    public function getResaltar()
    {
        return $this->resaltar;
    }

    /**
     * Set color
     *
     * @param integer $color
     *
     * @return Pregunta
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return integer
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set validar
     *
     * @param boolean $validar
     *
     * @return Pregunta
     */
    public function setValidar($validar)
    {
        $this->validar = $validar;

        return $this;
    }

    /**
     * Get validar
     *
     * @return boolean
     */
    public function getValidar()
    {
        return $this->validar;
    }

    /**
     * Get preguntaid
     *
     * @return integer
     */
    public function getPreguntaid()
    {
        return $this->preguntaid;
    }

    /**
     * Set padreid
     *
     * @param \AppBundle\Entity\Respuesta $padreid
     *
     * @return Pregunta
     */
    public function setPadreid(\AppBundle\Entity\Respuesta $padreid = null)
    {
        $this->padreid = $padreid;

        return $this;
    }

    /**
     * Get padreid
     *
     * @return \AppBundle\Entity\Respuesta
     */
    public function getPadreid()
    {
        return $this->padreid;
    }

    /**
     * Set tipopreguntaid
     *
     * @param \AppBundle\Entity\Tipopregunta $tipopreguntaid
     *
     * @return Pregunta
     */
    public function setTipopreguntaid(\AppBundle\Entity\Tipopregunta $tipopreguntaid = null)
    {
        $this->tipopreguntaid = $tipopreguntaid;

        return $this;
    }

    /**
     * Get tipopreguntaid
     *
     * @return \AppBundle\Entity\Tipopregunta
     */
    public function getTipopreguntaid()
    {
        return $this->tipopreguntaid;
    }
}

