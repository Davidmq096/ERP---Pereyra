<?php

namespace AppBundle\Entity;

/**
 * BcPeriodobeca
 */
class BcPeriodobeca
{
    /**
     * @var \DateTime
     */
    private $fechainipagoestudiose;

    /**
     * @var \DateTime
     */
    private $fechafinpagoestudiose;

    /**
     * @var \DateTime
     */
    private $fechainicapturas;

    /**
     * @var \DateTime
     */
    private $fechafincapturas;

    /**
     * @var \DateTime
     */
    private $fechainientregade;

    /**
     * @var \DateTime
     */
    private $fechafinentregade;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var integer
     */
    private $periodobecaid;

    /**
     * @var \AppBundle\Entity\Ciclo
     */
    private $cicloid;


    /**
     * Set fechainipagoestudiose
     *
     * @param \DateTime $fechainipagoestudiose
     *
     * @return BcPeriodobeca
     */
    public function setFechainipagoestudiose($fechainipagoestudiose)
    {
        $this->fechainipagoestudiose = $fechainipagoestudiose;

        return $this;
    }

    /**
     * Get fechainipagoestudiose
     *
     * @return \DateTime
     */
    public function getFechainipagoestudiose()
    {
        return $this->fechainipagoestudiose;
    }

    /**
     * Set fechafinpagoestudiose
     *
     * @param \DateTime $fechafinpagoestudiose
     *
     * @return BcPeriodobeca
     */
    public function setFechafinpagoestudiose($fechafinpagoestudiose)
    {
        $this->fechafinpagoestudiose = $fechafinpagoestudiose;

        return $this;
    }

    /**
     * Get fechafinpagoestudiose
     *
     * @return \DateTime
     */
    public function getFechafinpagoestudiose()
    {
        return $this->fechafinpagoestudiose;
    }

    /**
     * Set fechainicapturas
     *
     * @param \DateTime $fechainicapturas
     *
     * @return BcPeriodobeca
     */
    public function setFechainicapturas($fechainicapturas)
    {
        $this->fechainicapturas = $fechainicapturas;

        return $this;
    }

    /**
     * Get fechainicapturas
     *
     * @return \DateTime
     */
    public function getFechainicapturas()
    {
        return $this->fechainicapturas;
    }

    /**
     * Set fechafincapturas
     *
     * @param \DateTime $fechafincapturas
     *
     * @return BcPeriodobeca
     */
    public function setFechafincapturas($fechafincapturas)
    {
        $this->fechafincapturas = $fechafincapturas;

        return $this;
    }

    /**
     * Get fechafincapturas
     *
     * @return \DateTime
     */
    public function getFechafincapturas()
    {
        return $this->fechafincapturas;
    }

    /**
     * Set fechainientregade
     *
     * @param \DateTime $fechainientregade
     *
     * @return BcPeriodobeca
     */
    public function setFechainientregade($fechainientregade)
    {
        $this->fechainientregade = $fechainientregade;

        return $this;
    }

    /**
     * Get fechainientregade
     *
     * @return \DateTime
     */
    public function getFechainientregade()
    {
        return $this->fechainientregade;
    }

    /**
     * Set fechafinentregade
     *
     * @param \DateTime $fechafinentregade
     *
     * @return BcPeriodobeca
     */
    public function setFechafinentregade($fechafinentregade)
    {
        $this->fechafinentregade = $fechafinentregade;

        return $this;
    }

    /**
     * Get fechafinentregade
     *
     * @return \DateTime
     */
    public function getFechafinentregade()
    {
        return $this->fechafinentregade;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return BcPeriodobeca
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
     * Get periodobecaid
     *
     * @return integer
     */
    public function getPeriodobecaid()
    {
        return $this->periodobecaid;
    }

    /**
     * Set cicloid
     *
     * @param \AppBundle\Entity\Ciclo $cicloid
     *
     * @return BcPeriodobeca
     */
    public function setCicloid(\AppBundle\Entity\Ciclo $cicloid = null)
    {
        $this->cicloid = $cicloid;

        return $this;
    }

    /**
     * Get cicloid
     *
     * @return \AppBundle\Entity\Ciclo
     */
    public function getCicloid()
    {
        return $this->cicloid;
    }
}

