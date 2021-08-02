<?php

namespace AppBundle\Entity;

/**
 * CePeriodoevaluacion
 */
class CePeriodoevaluacion
{
    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var string
     */
    private $descripcioncorta;

    /**
     * @var \DateTime
     */
    private $fechainicio;

    /**
     * @var \DateTime
     */
    private $fechafin;

    /**
     * @var integer
     */
    private $porcentajecalificacionfinal;

    /**
     * @var \DateTime
     */
    private $fechalimedicionplantilla;

    /**
     * @var \DateTime
     */
    private $fechalimedicionprofesor;

    /**
     * @var \DateTime
     */
    private $fechacapturacalinicio;

    /**
     * @var \DateTime
     */
    private $fechacapturacalfin;

    /**
     * @var \DateTime
     */
    private $fechapublicacionprevia;

    /**
     * @var \DateTime
     */
    private $fechaperiodorevisioninicio;

    /**
     * @var \DateTime
     */
    private $fechaperiodorevisionfin;

    /**
     * @var \DateTime
     */
    private $fechapublicaciondefinitiva;

    /**
     * @var integer
     */
    private $periodoevaluacionid;

    /**
     * @var \AppBundle\Entity\CeConjuntoperiodoevaluacion
     */
    private $conjuntoperiodoevaluacionid;


    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return CePeriodoevaluacion
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
     * Set descripcioncorta
     *
     * @param string $descripcioncorta
     *
     * @return CePeriodoevaluacion
     */
    public function setDescripcioncorta($descripcioncorta)
    {
        $this->descripcioncorta = $descripcioncorta;

        return $this;
    }

    /**
     * Get descripcioncorta
     *
     * @return string
     */
    public function getDescripcioncorta()
    {
        return $this->descripcioncorta;
    }

    /**
     * Set fechainicio
     *
     * @param \DateTime $fechainicio
     *
     * @return CePeriodoevaluacion
     */
    public function setFechainicio($fechainicio)
    {
        $this->fechainicio = $fechainicio;

        return $this;
    }

    /**
     * Get fechainicio
     *
     * @return \DateTime
     */
    public function getFechainicio()
    {
        return $this->fechainicio;
    }

    /**
     * Set fechafin
     *
     * @param \DateTime $fechafin
     *
     * @return CePeriodoevaluacion
     */
    public function setFechafin($fechafin)
    {
        $this->fechafin = $fechafin;

        return $this;
    }

    /**
     * Get fechafin
     *
     * @return \DateTime
     */
    public function getFechafin()
    {
        return $this->fechafin;
    }

    /**
     * Set porcentajecalificacionfinal
     *
     * @param integer $porcentajecalificacionfinal
     *
     * @return CePeriodoevaluacion
     */
    public function setPorcentajecalificacionfinal($porcentajecalificacionfinal)
    {
        $this->porcentajecalificacionfinal = $porcentajecalificacionfinal;

        return $this;
    }

    /**
     * Get porcentajecalificacionfinal
     *
     * @return integer
     */
    public function getPorcentajecalificacionfinal()
    {
        return $this->porcentajecalificacionfinal;
    }

    /**
     * Set fechalimedicionplantilla
     *
     * @param \DateTime $fechalimedicionplantilla
     *
     * @return CePeriodoevaluacion
     */
    public function setFechalimedicionplantilla($fechalimedicionplantilla)
    {
        $this->fechalimedicionplantilla = $fechalimedicionplantilla;

        return $this;
    }

    /**
     * Get fechalimedicionplantilla
     *
     * @return \DateTime
     */
    public function getFechalimedicionplantilla()
    {
        return $this->fechalimedicionplantilla;
    }

    /**
     * Set fechalimedicionprofesor
     *
     * @param \DateTime $fechalimedicionprofesor
     *
     * @return CePeriodoevaluacion
     */
    public function setFechalimedicionprofesor($fechalimedicionprofesor)
    {
        $this->fechalimedicionprofesor = $fechalimedicionprofesor;

        return $this;
    }

    /**
     * Get fechalimedicionprofesor
     *
     * @return \DateTime
     */
    public function getFechalimedicionprofesor()
    {
        return $this->fechalimedicionprofesor;
    }

    /**
     * Set fechacapturacalinicio
     *
     * @param \DateTime $fechacapturacalinicio
     *
     * @return CePeriodoevaluacion
     */
    public function setFechacapturacalinicio($fechacapturacalinicio)
    {
        $this->fechacapturacalinicio = $fechacapturacalinicio;

        return $this;
    }

    /**
     * Get fechacapturacalinicio
     *
     * @return \DateTime
     */
    public function getFechacapturacalinicio()
    {
        return $this->fechacapturacalinicio;
    }

    /**
     * Set fechacapturacalfin
     *
     * @param \DateTime $fechacapturacalfin
     *
     * @return CePeriodoevaluacion
     */
    public function setFechacapturacalfin($fechacapturacalfin)
    {
        $this->fechacapturacalfin = $fechacapturacalfin;

        return $this;
    }

    /**
     * Get fechacapturacalfin
     *
     * @return \DateTime
     */
    public function getFechacapturacalfin()
    {
        return $this->fechacapturacalfin;
    }

    /**
     * Set fechapublicacionprevia
     *
     * @param \DateTime $fechapublicacionprevia
     *
     * @return CePeriodoevaluacion
     */
    public function setFechapublicacionprevia($fechapublicacionprevia)
    {
        $this->fechapublicacionprevia = $fechapublicacionprevia;

        return $this;
    }

    /**
     * Get fechapublicacionprevia
     *
     * @return \DateTime
     */
    public function getFechapublicacionprevia()
    {
        return $this->fechapublicacionprevia;
    }

    /**
     * Set fechaperiodorevisioninicio
     *
     * @param \DateTime $fechaperiodorevisioninicio
     *
     * @return CePeriodoevaluacion
     */
    public function setFechaperiodorevisioninicio($fechaperiodorevisioninicio)
    {
        $this->fechaperiodorevisioninicio = $fechaperiodorevisioninicio;

        return $this;
    }

    /**
     * Get fechaperiodorevisioninicio
     *
     * @return \DateTime
     */
    public function getFechaperiodorevisioninicio()
    {
        return $this->fechaperiodorevisioninicio;
    }

    /**
     * Set fechaperiodorevisionfin
     *
     * @param \DateTime $fechaperiodorevisionfin
     *
     * @return CePeriodoevaluacion
     */
    public function setFechaperiodorevisionfin($fechaperiodorevisionfin)
    {
        $this->fechaperiodorevisionfin = $fechaperiodorevisionfin;

        return $this;
    }

    /**
     * Get fechaperiodorevisionfin
     *
     * @return \DateTime
     */
    public function getFechaperiodorevisionfin()
    {
        return $this->fechaperiodorevisionfin;
    }

    /**
     * Set fechapublicaciondefinitiva
     *
     * @param \DateTime $fechapublicaciondefinitiva
     *
     * @return CePeriodoevaluacion
     */
    public function setFechapublicaciondefinitiva($fechapublicaciondefinitiva)
    {
        $this->fechapublicaciondefinitiva = $fechapublicaciondefinitiva;

        return $this;
    }

    /**
     * Get fechapublicaciondefinitiva
     *
     * @return \DateTime
     */
    public function getFechapublicaciondefinitiva()
    {
        return $this->fechapublicaciondefinitiva;
    }

    /**
     * Get periodoevaluacionid
     *
     * @return integer
     */
    public function getPeriodoevaluacionid()
    {
        return $this->periodoevaluacionid;
    }

    /**
     * Set conjuntoperiodoevaluacionid
     *
     * @param \AppBundle\Entity\CeConjuntoperiodoevaluacion $conjuntoperiodoevaluacionid
     *
     * @return CePeriodoevaluacion
     */
    public function setConjuntoperiodoevaluacionid(\AppBundle\Entity\CeConjuntoperiodoevaluacion $conjuntoperiodoevaluacionid = null)
    {
        $this->conjuntoperiodoevaluacionid = $conjuntoperiodoevaluacionid;

        return $this;
    }

    /**
     * Get conjuntoperiodoevaluacionid
     *
     * @return \AppBundle\Entity\CeConjuntoperiodoevaluacion
     */
    public function getConjuntoperiodoevaluacionid()
    {
        return $this->conjuntoperiodoevaluacionid;
    }
}

