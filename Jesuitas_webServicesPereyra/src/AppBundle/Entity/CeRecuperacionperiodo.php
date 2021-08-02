<?php

namespace AppBundle\Entity;

/**
 * CeRecuperacionperiodo
 */
class CeRecuperacionperiodo
{
    /**
     * @var integer
     */
    private $intento;

    /**
     * @var float
     */
    private $calificacion;

    /**
     * @var integer
     */
    private $recuperacionperiodoid;

    /**
     * @var \AppBundle\Entity\CeAlumnoporciclo
     */
    private $alumnoporcicloid;

    /**
     * @var \AppBundle\Entity\CePeriodoevaluacion
     */
    private $periodoevaluacionid;

    /**
     * @var \AppBundle\Entity\CeProfesorpormateriaplanestudios
     */
    private $profesorpormateriaplanestudioid;


    /**
     * Set intento
     *
     * @param integer $intento
     *
     * @return CeRecuperacionperiodo
     */
    public function setIntento($intento)
    {
        $this->intento = $intento;

        return $this;
    }

    /**
     * Get intento
     *
     * @return integer
     */
    public function getIntento()
    {
        return $this->intento;
    }

    /**
     * Set calificacion
     *
     * @param float $calificacion
     *
     * @return CeRecuperacionperiodo
     */
    public function setCalificacion($calificacion)
    {
        $this->calificacion = $calificacion;

        return $this;
    }

    /**
     * Get calificacion
     *
     * @return float
     */
    public function getCalificacion()
    {
        return $this->calificacion;
    }

    /**
     * Get recuperacionperiodoid
     *
     * @return integer
     */
    public function getRecuperacionperiodoid()
    {
        return $this->recuperacionperiodoid;
    }

    /**
     * Set alumnoporcicloid
     *
     * @param \AppBundle\Entity\CeAlumnoporciclo $alumnoporcicloid
     *
     * @return CeRecuperacionperiodo
     */
    public function setAlumnoporcicloid(\AppBundle\Entity\CeAlumnoporciclo $alumnoporcicloid = null)
    {
        $this->alumnoporcicloid = $alumnoporcicloid;

        return $this;
    }

    /**
     * Get alumnoporcicloid
     *
     * @return \AppBundle\Entity\CeAlumnoporciclo
     */
    public function getAlumnoporcicloid()
    {
        return $this->alumnoporcicloid;
    }

    /**
     * Set periodoevaluacionid
     *
     * @param \AppBundle\Entity\CePeriodoevaluacion $periodoevaluacionid
     *
     * @return CeRecuperacionperiodo
     */
    public function setPeriodoevaluacionid(\AppBundle\Entity\CePeriodoevaluacion $periodoevaluacionid = null)
    {
        $this->periodoevaluacionid = $periodoevaluacionid;

        return $this;
    }

    /**
     * Get periodoevaluacionid
     *
     * @return \AppBundle\Entity\CePeriodoevaluacion
     */
    public function getPeriodoevaluacionid()
    {
        return $this->periodoevaluacionid;
    }

    /**
     * Set profesorpormateriaplanestudioid
     *
     * @param \AppBundle\Entity\CeProfesorpormateriaplanestudios $profesorpormateriaplanestudioid
     *
     * @return CeRecuperacionperiodo
     */
    public function setProfesorpormateriaplanestudioid(\AppBundle\Entity\CeProfesorpormateriaplanestudios $profesorpormateriaplanestudioid = null)
    {
        $this->profesorpormateriaplanestudioid = $profesorpormateriaplanestudioid;

        return $this;
    }

    /**
     * Get profesorpormateriaplanestudioid
     *
     * @return \AppBundle\Entity\CeProfesorpormateriaplanestudios
     */
    public function getProfesorpormateriaplanestudioid()
    {
        return $this->profesorpormateriaplanestudioid;
    }
}

