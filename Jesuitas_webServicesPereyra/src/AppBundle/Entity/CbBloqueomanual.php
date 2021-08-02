<?php

namespace AppBundle\Entity;

/**
 * CbBloqueomanual
 */
class CbBloqueomanual
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
    private $bloqueomanualid;

    /**
     * @var \AppBundle\Entity\CeAlumnoporciclo
     */
    private $alumnoporcicloid;

    /**
     * @var \AppBundle\Entity\CbEstatusbloqueo
     */
    private $estatusbloqueoid;


    /**
     * Set fechainicio
     *
     * @param \DateTime $fechainicio
     *
     * @return CbBloqueomanual
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
     * @return CbBloqueomanual
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
     * @return CbBloqueomanual
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
     * Get bloqueomanualid
     *
     * @return integer
     */
    public function getBloqueomanualid()
    {
        return $this->bloqueomanualid;
    }

    /**
     * Set alumnoporcicloid
     *
     * @param \AppBundle\Entity\CeAlumnoporciclo $alumnoporcicloid
     *
     * @return CbBloqueomanual
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
     * Set estatusbloqueoid
     *
     * @param \AppBundle\Entity\CbEstatusbloqueo $estatusbloqueoid
     *
     * @return CbBloqueomanual
     */
    public function setEstatusbloqueoid(\AppBundle\Entity\CbEstatusbloqueo $estatusbloqueoid = null)
    {
        $this->estatusbloqueoid = $estatusbloqueoid;

        return $this;
    }

    /**
     * Get estatusbloqueoid
     *
     * @return \AppBundle\Entity\CbEstatusbloqueo
     */
    public function getEstatusbloqueoid()
    {
        return $this->estatusbloqueoid;
    }
}

