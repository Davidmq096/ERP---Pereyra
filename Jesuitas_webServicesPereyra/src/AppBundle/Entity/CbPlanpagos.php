<?php

namespace AppBundle\Entity;

/**
 * CbPlanpagos
 */
class CbPlanpagos
{
    /**
     * @var string
     */
    private $matricula;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $concepto;

    /**
     * @var \DateTime
     */
    private $fechacompromiso;

    /**
     * @var float
     */
    private $importecompromiso;

    /**
     * @var string
     */
    private $observaciones;

    /**
     * @var integer
     */
    private $planpagosid;

    /**
     * @var \AppBundle\Entity\CbAcuerdo
     */
    private $acuerdoid;


    /**
     * Set matricula
     *
     * @param string $matricula
     *
     * @return CbPlanpagos
     */
    public function setMatricula($matricula)
    {
        $this->matricula = $matricula;

        return $this;
    }

    /**
     * Get matricula
     *
     * @return string
     */
    public function getMatricula()
    {
        return $this->matricula;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CbPlanpagos
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
     * Set concepto
     *
     * @param string $concepto
     *
     * @return CbPlanpagos
     */
    public function setConcepto($concepto)
    {
        $this->concepto = $concepto;

        return $this;
    }

    /**
     * Get concepto
     *
     * @return string
     */
    public function getConcepto()
    {
        return $this->concepto;
    }

    /**
     * Set fechacompromiso
     *
     * @param \DateTime $fechacompromiso
     *
     * @return CbPlanpagos
     */
    public function setFechacompromiso($fechacompromiso)
    {
        $this->fechacompromiso = $fechacompromiso;

        return $this;
    }

    /**
     * Get fechacompromiso
     *
     * @return \DateTime
     */
    public function getFechacompromiso()
    {
        return $this->fechacompromiso;
    }

    /**
     * Set importecompromiso
     *
     * @param float $importecompromiso
     *
     * @return CbPlanpagos
     */
    public function setImportecompromiso($importecompromiso)
    {
        $this->importecompromiso = $importecompromiso;

        return $this;
    }

    /**
     * Get importecompromiso
     *
     * @return float
     */
    public function getImportecompromiso()
    {
        return $this->importecompromiso;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return CbPlanpagos
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
     * Get planpagosid
     *
     * @return integer
     */
    public function getPlanpagosid()
    {
        return $this->planpagosid;
    }

    /**
     * Set acuerdoid
     *
     * @param \AppBundle\Entity\CbAcuerdo $acuerdoid
     *
     * @return CbPlanpagos
     */
    public function setAcuerdoid(\AppBundle\Entity\CbAcuerdo $acuerdoid = null)
    {
        $this->acuerdoid = $acuerdoid;

        return $this;
    }

    /**
     * Get acuerdoid
     *
     * @return \AppBundle\Entity\CbAcuerdo
     */
    public function getAcuerdoid()
    {
        return $this->acuerdoid;
    }
}

