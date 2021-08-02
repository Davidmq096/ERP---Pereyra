<?php

namespace AppBundle\Entity;

/**
 * IdecDetallerubro
 */
class IdecDetallerubro
{
    /**
     * @var float
     */
    private $valor;

    /**
     * @var integer
     */
    private $detallerubroid;

    /**
     * @var \AppBundle\Entity\IdecCampoponderacion
     */
    private $campoponderacionid;

    /**
     * @var \AppBundle\Entity\IdecPonderacionadmision
     */
    private $ponderacionadmisionid;

    /**
     * @var \AppBundle\Entity\Preguntaporevaluacion
     */
    private $preguntaporevaluacionid;

    /**
     * @var \AppBundle\Entity\IdecTipodetallerubro
     */
    private $tipodetallerubroid;


    /**
     * Set valor
     *
     * @param float $valor
     *
     * @return IdecDetallerubro
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return float
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Get detallerubroid
     *
     * @return integer
     */
    public function getDetallerubroid()
    {
        return $this->detallerubroid;
    }

    /**
     * Set campoponderacionid
     *
     * @param \AppBundle\Entity\IdecCampoponderacion $campoponderacionid
     *
     * @return IdecDetallerubro
     */
    public function setCampoponderacionid(\AppBundle\Entity\IdecCampoponderacion $campoponderacionid = null)
    {
        $this->campoponderacionid = $campoponderacionid;

        return $this;
    }

    /**
     * Get campoponderacionid
     *
     * @return \AppBundle\Entity\IdecCampoponderacion
     */
    public function getCampoponderacionid()
    {
        return $this->campoponderacionid;
    }

    /**
     * Set ponderacionadmisionid
     *
     * @param \AppBundle\Entity\IdecPonderacionadmision $ponderacionadmisionid
     *
     * @return IdecDetallerubro
     */
    public function setPonderacionadmisionid(\AppBundle\Entity\IdecPonderacionadmision $ponderacionadmisionid = null)
    {
        $this->ponderacionadmisionid = $ponderacionadmisionid;

        return $this;
    }

    /**
     * Get ponderacionadmisionid
     *
     * @return \AppBundle\Entity\IdecPonderacionadmision
     */
    public function getPonderacionadmisionid()
    {
        return $this->ponderacionadmisionid;
    }

    /**
     * Set preguntaporevaluacionid
     *
     * @param \AppBundle\Entity\Preguntaporevaluacion $preguntaporevaluacionid
     *
     * @return IdecDetallerubro
     */
    public function setPreguntaporevaluacionid(\AppBundle\Entity\Preguntaporevaluacion $preguntaporevaluacionid = null)
    {
        $this->preguntaporevaluacionid = $preguntaporevaluacionid;

        return $this;
    }

    /**
     * Get preguntaporevaluacionid
     *
     * @return \AppBundle\Entity\Preguntaporevaluacion
     */
    public function getPreguntaporevaluacionid()
    {
        return $this->preguntaporevaluacionid;
    }

    /**
     * Set tipodetallerubroid
     *
     * @param \AppBundle\Entity\IdecTipodetallerubro $tipodetallerubroid
     *
     * @return IdecDetallerubro
     */
    public function setTipodetallerubroid(\AppBundle\Entity\IdecTipodetallerubro $tipodetallerubroid = null)
    {
        $this->tipodetallerubroid = $tipodetallerubroid;

        return $this;
    }

    /**
     * Get tipodetallerubroid
     *
     * @return \AppBundle\Entity\IdecTipodetallerubro
     */
    public function getTipodetallerubroid()
    {
        return $this->tipodetallerubroid;
    }
}

