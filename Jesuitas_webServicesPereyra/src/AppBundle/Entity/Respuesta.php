<?php

namespace AppBundle\Entity;

/**
 * Respuesta
 */
class Respuesta
{
    /**
     * @var string
     */
    private $respuesta;

    /**
     * @var boolean
     */
    private $correcta;

    /**
     * @var integer
     */
    private $valorporcentaje;

    /**
     * @var integer
     */
    private $respuestaid;

    /**
     * @var \AppBundle\Entity\Complemento
     */
    private $complementoid;

    /**
     * @var \AppBundle\Entity\Pregunta
     */
    private $preguntaid;


    /**
     * Set respuesta
     *
     * @param string $respuesta
     *
     * @return Respuesta
     */
    public function setRespuesta($respuesta)
    {
        $this->respuesta = $respuesta;

        return $this;
    }

    /**
     * Get respuesta
     *
     * @return string
     */
    public function getRespuesta()
    {
        return $this->respuesta;
    }

    /**
     * Set correcta
     *
     * @param boolean $correcta
     *
     * @return Respuesta
     */
    public function setCorrecta($correcta)
    {
        $this->correcta = $correcta;

        return $this;
    }

    /**
     * Get correcta
     *
     * @return boolean
     */
    public function getCorrecta()
    {
        return $this->correcta;
    }

    /**
     * Set valorporcentaje
     *
     * @param integer $valorporcentaje
     *
     * @return Respuesta
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
     * Get respuestaid
     *
     * @return integer
     */
    public function getRespuestaid()
    {
        return $this->respuestaid;
    }

    /**
     * Set complementoid
     *
     * @param \AppBundle\Entity\Complemento $complementoid
     *
     * @return Respuesta
     */
    public function setComplementoid(\AppBundle\Entity\Complemento $complementoid = null)
    {
        $this->complementoid = $complementoid;

        return $this;
    }

    /**
     * Get complementoid
     *
     * @return \AppBundle\Entity\Complemento
     */
    public function getComplementoid()
    {
        return $this->complementoid;
    }

    /**
     * Set preguntaid
     *
     * @param \AppBundle\Entity\Pregunta $preguntaid
     *
     * @return Respuesta
     */
    public function setPreguntaid(\AppBundle\Entity\Pregunta $preguntaid = null)
    {
        $this->preguntaid = $preguntaid;

        return $this;
    }

    /**
     * Get preguntaid
     *
     * @return \AppBundle\Entity\Pregunta
     */
    public function getPreguntaid()
    {
        return $this->preguntaid;
    }
}

