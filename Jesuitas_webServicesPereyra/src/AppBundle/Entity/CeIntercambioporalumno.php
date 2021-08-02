<?php

namespace AppBundle\Entity;

/**
 * CeIntercambioporalumno
 */
class CeIntercambioporalumno
{
    /**
     * @var \DateTime
     */
    private $fechainicio;

    /**
     * @var \DateTime
     */
    private $fechafin;

    /**
     * @var string
     */
    private $observaciones;

    /**
     * @var integer
     */
    private $intercambioporalumnoid;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;


    /**
     * Set fechainicio
     *
     * @param \DateTime $fechainicio
     *
     * @return CeIntercambioporalumno
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
     * @return CeIntercambioporalumno
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
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return CeIntercambioporalumno
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Get intercambioporalumnoid
     *
     * @return integer
     */
    public function getIntercambioporalumnoid()
    {
        return $this->intercambioporalumnoid;
    }

    /**
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return CeIntercambioporalumno
     */
    public function setAlumnoid(\AppBundle\Entity\CeAlumno $alumnoid = null)
    {
        $this->alumnoid = $alumnoid;

        return $this;
    }

    /**
     * Get alumnoid
     *
     * @return \AppBundle\Entity\CeAlumno
     */
    public function getAlumnoid()
    {
        return $this->alumnoid;
    }
}

