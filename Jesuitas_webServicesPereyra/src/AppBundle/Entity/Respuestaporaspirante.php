<?php

namespace AppBundle\Entity;

/**
 * Respuestaporaspirante
 */
class Respuestaporaspirante
{
    /**
     * @var string
     */
    private $respuestaabierta;

    /**
     * @var boolean
     */
    private $correcta;

    /**
     * @var integer
     */
    private $respuestaporaspiranteid;

    /**
     * @var \AppBundle\Entity\Pregunta
     */
    private $preguntaid;

    /**
     * @var \AppBundle\Entity\Evaluacionporsolicitudadmision
     */
    private $evaluacionporsolicitudadmisionid;

    /**
     * @var \AppBundle\Entity\Respuesta
     */
    private $respuestaid;


    /**
     * Set respuestaabierta
     *
     * @param string $respuestaabierta
     *
     * @return Respuestaporaspirante
     */
    public function setRespuestaabierta($respuestaabierta)
    {
        $this->respuestaabierta = $respuestaabierta;

        return $this;
    }

    /**
     * Get respuestaabierta
     *
     * @return string
     */
    public function getRespuestaabierta()
    {
        return $this->respuestaabierta;
    }

    /**
     * Set correcta
     *
     * @param boolean $correcta
     *
     * @return Respuestaporaspirante
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
     * Get respuestaporaspiranteid
     *
     * @return integer
     */
    public function getRespuestaporaspiranteid()
    {
        return $this->respuestaporaspiranteid;
    }

    /**
     * Set preguntaid
     *
     * @param \AppBundle\Entity\Pregunta $preguntaid
     *
     * @return Respuestaporaspirante
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

    /**
     * Set evaluacionporsolicitudadmisionid
     *
     * @param \AppBundle\Entity\Evaluacionporsolicitudadmision $evaluacionporsolicitudadmisionid
     *
     * @return Respuestaporaspirante
     */
    public function setEvaluacionporsolicitudadmisionid(\AppBundle\Entity\Evaluacionporsolicitudadmision $evaluacionporsolicitudadmisionid = null)
    {
        $this->evaluacionporsolicitudadmisionid = $evaluacionporsolicitudadmisionid;

        return $this;
    }

    /**
     * Get evaluacionporsolicitudadmisionid
     *
     * @return \AppBundle\Entity\Evaluacionporsolicitudadmision
     */
    public function getEvaluacionporsolicitudadmisionid()
    {
        return $this->evaluacionporsolicitudadmisionid;
    }

    /**
     * Set respuestaid
     *
     * @param \AppBundle\Entity\Respuesta $respuestaid
     *
     * @return Respuestaporaspirante
     */
    public function setRespuestaid(\AppBundle\Entity\Respuesta $respuestaid = null)
    {
        $this->respuestaid = $respuestaid;

        return $this;
    }

    /**
     * Get respuestaid
     *
     * @return \AppBundle\Entity\Respuesta
     */
    public function getRespuestaid()
    {
        return $this->respuestaid;
    }
}

