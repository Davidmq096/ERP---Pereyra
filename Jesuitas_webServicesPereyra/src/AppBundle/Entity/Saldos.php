<?php

namespace AppBundle\Entity;

/**
 * Saldos
 */
class Saldos
{
    /**
     * @var string
     */
    private $alumno;

    /**
     * @var string
     */
    private $subconcepto;

    /**
     * @var string
     */
    private $periodo;

    /**
     * @var string
     */
    private $importe;

    /**
     * @var string
     */
    private $recargos;

    /**
     * @var string
     */
    private $anio;

    /**
     * @var integer
     */
    private $mes;

    /**
     * @var integer
     */
    private $clave;

    /**
     * @var \DateTime
     */
    private $fechavencimiento;

    /**
     * @var integer
     */
    private $subconceptoid;

    /**
     * @var integer
     */
    private $alumnoid;

    /**
     * @var integer
     */
    private $gradoid;

    /**
     * @var integer
     */
    private $pk;


    /**
     * Set alumno
     *
     * @param string $alumno
     *
     * @return Saldos
     */
    public function setAlumno($alumno)
    {
        $this->alumno = $alumno;

        return $this;
    }

    /**
     * Get alumno
     *
     * @return string
     */
    public function getAlumno()
    {
        return $this->alumno;
    }

    /**
     * Set subconcepto
     *
     * @param string $subconcepto
     *
     * @return Saldos
     */
    public function setSubconcepto($subconcepto)
    {
        $this->subconcepto = $subconcepto;

        return $this;
    }

    /**
     * Get subconcepto
     *
     * @return string
     */
    public function getSubconcepto()
    {
        return $this->subconcepto;
    }

    /**
     * Set periodo
     *
     * @param string $periodo
     *
     * @return Saldos
     */
    public function setPeriodo($periodo)
    {
        $this->periodo = $periodo;

        return $this;
    }

    /**
     * Get periodo
     *
     * @return string
     */
    public function getPeriodo()
    {
        return $this->periodo;
    }

    /**
     * Set importe
     *
     * @param string $importe
     *
     * @return Saldos
     */
    public function setImporte($importe)
    {
        $this->importe = $importe;

        return $this;
    }

    /**
     * Get importe
     *
     * @return string
     */
    public function getImporte()
    {
        return $this->importe;
    }

    /**
     * Set recargos
     *
     * @param string $recargos
     *
     * @return Saldos
     */
    public function setRecargos($recargos)
    {
        $this->recargos = $recargos;

        return $this;
    }

    /**
     * Get recargos
     *
     * @return string
     */
    public function getRecargos()
    {
        return $this->recargos;
    }

    /**
     * Set anio
     *
     * @param string $anio
     *
     * @return Saldos
     */
    public function setAnio($anio)
    {
        $this->anio = $anio;

        return $this;
    }

    /**
     * Get anio
     *
     * @return string
     */
    public function getAnio()
    {
        return $this->anio;
    }

    /**
     * Set mes
     *
     * @param integer $mes
     *
     * @return Saldos
     */
    public function setMes($mes)
    {
        $this->mes = $mes;

        return $this;
    }

    /**
     * Get mes
     *
     * @return integer
     */
    public function getMes()
    {
        return $this->mes;
    }

    /**
     * Set clave
     *
     * @param integer $clave
     *
     * @return Saldos
     */
    public function setClave($clave)
    {
        $this->clave = $clave;

        return $this;
    }

    /**
     * Get clave
     *
     * @return integer
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * Set fechavencimiento
     *
     * @param \DateTime $fechavencimiento
     *
     * @return Saldos
     */
    public function setFechavencimiento($fechavencimiento)
    {
        $this->fechavencimiento = $fechavencimiento;

        return $this;
    }

    /**
     * Get fechavencimiento
     *
     * @return \DateTime
     */
    public function getFechavencimiento()
    {
        return $this->fechavencimiento;
    }

    /**
     * Set subconceptoid
     *
     * @param integer $subconceptoid
     *
     * @return Saldos
     */
    public function setSubconceptoid($subconceptoid)
    {
        $this->subconceptoid = $subconceptoid;

        return $this;
    }

    /**
     * Get subconceptoid
     *
     * @return integer
     */
    public function getSubconceptoid()
    {
        return $this->subconceptoid;
    }

    /**
     * Set alumnoid
     *
     * @param integer $alumnoid
     *
     * @return Saldos
     */
    public function setAlumnoid($alumnoid)
    {
        $this->alumnoid = $alumnoid;

        return $this;
    }

    /**
     * Get alumnoid
     *
     * @return integer
     */
    public function getAlumnoid()
    {
        return $this->alumnoid;
    }

    /**
     * Set gradoid
     *
     * @param integer $gradoid
     *
     * @return Saldos
     */
    public function setGradoid($gradoid)
    {
        $this->gradoid = $gradoid;

        return $this;
    }

    /**
     * Get gradoid
     *
     * @return integer
     */
    public function getGradoid()
    {
        return $this->gradoid;
    }

    /**
     * Get pk
     *
     * @return integer
     */
    public function getPk()
    {
        return $this->pk;
    }
}

