<?php

namespace AppBundle\Entity;

/**
 * BcIngresoslux
 */
class BcIngresoslux
{
    /**
     * @var float
     */
    private $ingresomensualbruto;

    /**
     * @var float
     */
    private $ingresomensualneto;

    /**
     * @var float
     */
    private $rentas;

    /**
     * @var float
     */
    private $donativo;

    /**
     * @var float
     */
    private $otrosingresos;

    /**
     * @var float
     */
    private $fondodeahorro;

    /**
     * @var float
     */
    private $aguinaldo;

    /**
     * @var float
     */
    private $utilidades;

    /**
     * @var float
     */
    private $interesesporinversion;

    /**
     * @var integer
     */
    private $ingresosluxid;


    /**
     * Set ingresomensualbruto
     *
     * @param float $ingresomensualbruto
     *
     * @return BcIngresoslux
     */
    public function setIngresomensualbruto($ingresomensualbruto)
    {
        $this->ingresomensualbruto = $ingresomensualbruto;

        return $this;
    }

    /**
     * Get ingresomensualbruto
     *
     * @return float
     */
    public function getIngresomensualbruto()
    {
        return $this->ingresomensualbruto;
    }

    /**
     * Set ingresomensualneto
     *
     * @param float $ingresomensualneto
     *
     * @return BcIngresoslux
     */
    public function setIngresomensualneto($ingresomensualneto)
    {
        $this->ingresomensualneto = $ingresomensualneto;

        return $this;
    }

    /**
     * Get ingresomensualneto
     *
     * @return float
     */
    public function getIngresomensualneto()
    {
        return $this->ingresomensualneto;
    }

    /**
     * Set rentas
     *
     * @param float $rentas
     *
     * @return BcIngresoslux
     */
    public function setRentas($rentas)
    {
        $this->rentas = $rentas;

        return $this;
    }

    /**
     * Get rentas
     *
     * @return float
     */
    public function getRentas()
    {
        return $this->rentas;
    }

    /**
     * Set donativo
     *
     * @param float $donativo
     *
     * @return BcIngresoslux
     */
    public function setDonativo($donativo)
    {
        $this->donativo = $donativo;

        return $this;
    }

    /**
     * Get donativo
     *
     * @return float
     */
    public function getDonativo()
    {
        return $this->donativo;
    }

    /**
     * Set otrosingresos
     *
     * @param float $otrosingresos
     *
     * @return BcIngresoslux
     */
    public function setOtrosingresos($otrosingresos)
    {
        $this->otrosingresos = $otrosingresos;

        return $this;
    }

    /**
     * Get otrosingresos
     *
     * @return float
     */
    public function getOtrosingresos()
    {
        return $this->otrosingresos;
    }

    /**
     * Set fondodeahorro
     *
     * @param float $fondodeahorro
     *
     * @return BcIngresoslux
     */
    public function setFondodeahorro($fondodeahorro)
    {
        $this->fondodeahorro = $fondodeahorro;

        return $this;
    }

    /**
     * Get fondodeahorro
     *
     * @return float
     */
    public function getFondodeahorro()
    {
        return $this->fondodeahorro;
    }

    /**
     * Set aguinaldo
     *
     * @param float $aguinaldo
     *
     * @return BcIngresoslux
     */
    public function setAguinaldo($aguinaldo)
    {
        $this->aguinaldo = $aguinaldo;

        return $this;
    }

    /**
     * Get aguinaldo
     *
     * @return float
     */
    public function getAguinaldo()
    {
        return $this->aguinaldo;
    }

    /**
     * Set utilidades
     *
     * @param float $utilidades
     *
     * @return BcIngresoslux
     */
    public function setUtilidades($utilidades)
    {
        $this->utilidades = $utilidades;

        return $this;
    }

    /**
     * Get utilidades
     *
     * @return float
     */
    public function getUtilidades()
    {
        return $this->utilidades;
    }

    /**
     * Set interesesporinversion
     *
     * @param float $interesesporinversion
     *
     * @return BcIngresoslux
     */
    public function setInteresesporinversion($interesesporinversion)
    {
        $this->interesesporinversion = $interesesporinversion;

        return $this;
    }

    /**
     * Get interesesporinversion
     *
     * @return float
     */
    public function getInteresesporinversion()
    {
        return $this->interesesporinversion;
    }

    /**
     * Get ingresosluxid
     *
     * @return integer
     */
    public function getIngresosluxid()
    {
        return $this->ingresosluxid;
    }
}

