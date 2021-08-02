<?php

namespace AppBundle\Entity;

/**
 * BcIngresosfamiliares
 */
class BcIngresosfamiliares
{
    /**
     * @var string
     */
    private $ingresospadre;

    /**
     * @var string
     */
    private $ingresosmadre;

    /**
     * @var string
     */
    private $otrosfamiliares;

    /**
     * @var string
     */
    private $otrosingresos;

    /**
     * @var string
     */
    private $egresosfamiliares;

    /**
     * @var integer
     */
    private $ingresosid;

    /**
     * @var \AppBundle\Entity\BcSolicitudbeca
     */
    private $solicitudid;


    /**
     * Set ingresospadre
     *
     * @param string $ingresospadre
     *
     * @return BcIngresosfamiliares
     */
    public function setIngresospadre($ingresospadre)
    {
        $this->ingresospadre = $ingresospadre;

        return $this;
    }

    /**
     * Get ingresospadre
     *
     * @return string
     */
    public function getIngresospadre()
    {
        return $this->ingresospadre;
    }

    /**
     * Set ingresosmadre
     *
     * @param string $ingresosmadre
     *
     * @return BcIngresosfamiliares
     */
    public function setIngresosmadre($ingresosmadre)
    {
        $this->ingresosmadre = $ingresosmadre;

        return $this;
    }

    /**
     * Get ingresosmadre
     *
     * @return string
     */
    public function getIngresosmadre()
    {
        return $this->ingresosmadre;
    }

    /**
     * Set otrosfamiliares
     *
     * @param string $otrosfamiliares
     *
     * @return BcIngresosfamiliares
     */
    public function setOtrosfamiliares($otrosfamiliares)
    {
        $this->otrosfamiliares = $otrosfamiliares;

        return $this;
    }

    /**
     * Get otrosfamiliares
     *
     * @return string
     */
    public function getOtrosfamiliares()
    {
        return $this->otrosfamiliares;
    }

    /**
     * Set otrosingresos
     *
     * @param string $otrosingresos
     *
     * @return BcIngresosfamiliares
     */
    public function setOtrosingresos($otrosingresos)
    {
        $this->otrosingresos = $otrosingresos;

        return $this;
    }

    /**
     * Get otrosingresos
     *
     * @return string
     */
    public function getOtrosingresos()
    {
        return $this->otrosingresos;
    }

    /**
     * Set egresosfamiliares
     *
     * @param string $egresosfamiliares
     *
     * @return BcIngresosfamiliares
     */
    public function setEgresosfamiliares($egresosfamiliares)
    {
        $this->egresosfamiliares = $egresosfamiliares;

        return $this;
    }

    /**
     * Get egresosfamiliares
     *
     * @return string
     */
    public function getEgresosfamiliares()
    {
        return $this->egresosfamiliares;
    }

    /**
     * Get ingresosid
     *
     * @return integer
     */
    public function getIngresosid()
    {
        return $this->ingresosid;
    }

    /**
     * Set solicitudid
     *
     * @param \AppBundle\Entity\BcSolicitudbeca $solicitudid
     *
     * @return BcIngresosfamiliares
     */
    public function setSolicitudid(\AppBundle\Entity\BcSolicitudbeca $solicitudid = null)
    {
        $this->solicitudid = $solicitudid;

        return $this;
    }

    /**
     * Get solicitudid
     *
     * @return \AppBundle\Entity\BcSolicitudbeca
     */
    public function getSolicitudid()
    {
        return $this->solicitudid;
    }
}

