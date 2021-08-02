<?php

namespace AppBundle\Entity;

/**
 * CjBitacoracaja
 */
class CjBitacoracaja
{
    /**
     * @var \DateTime
     */
    private $fechaapertura;

    /**
     * @var \DateTime
     */
    private $fechacierre;

    /**
     * @var \DateTime
     */
    private $fechaprocesonocturno;

    /**
     * @var boolean
     */
    private $cierrecaja;

    /**
     * @var string
     */
    private $observaciones;

    /**
     * @var integer
     */
    private $bitacoracajaid;

    /**
     * @var \AppBundle\Entity\CjCaja
     */
    private $cajaid;

    /**
     * @var \AppBundle\Entity\Usuario
     */
    private $usuarioid;


    /**
     * Set fechaapertura
     *
     * @param \DateTime $fechaapertura
     *
     * @return CjBitacoracaja
     */
    public function setFechaapertura($fechaapertura)
    {
        $this->fechaapertura = $fechaapertura;

        return $this;
    }

    /**
     * Get fechaapertura
     *
     * @return \DateTime
     */
    public function getFechaapertura()
    {
        return $this->fechaapertura;
    }

    /**
     * Set fechacierre
     *
     * @param \DateTime $fechacierre
     *
     * @return CjBitacoracaja
     */
    public function setFechacierre($fechacierre)
    {
        $this->fechacierre = $fechacierre;

        return $this;
    }

    /**
     * Get fechacierre
     *
     * @return \DateTime
     */
    public function getFechacierre()
    {
        return $this->fechacierre;
    }

    /**
     * Set fechaprocesonocturno
     *
     * @param \DateTime $fechaprocesonocturno
     *
     * @return CjBitacoracaja
     */
    public function setFechaprocesonocturno($fechaprocesonocturno)
    {
        $this->fechaprocesonocturno = $fechaprocesonocturno;

        return $this;
    }

    /**
     * Get fechaprocesonocturno
     *
     * @return \DateTime
     */
    public function getFechaprocesonocturno()
    {
        return $this->fechaprocesonocturno;
    }

    /**
     * Set cierrecaja
     *
     * @param boolean $cierrecaja
     *
     * @return CjBitacoracaja
     */
    public function setCierrecaja($cierrecaja)
    {
        $this->cierrecaja = $cierrecaja;

        return $this;
    }

    /**
     * Get cierrecaja
     *
     * @return boolean
     */
    public function getCierrecaja()
    {
        return $this->cierrecaja;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return CjBitacoracaja
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
     * Get bitacoracajaid
     *
     * @return integer
     */
    public function getBitacoracajaid()
    {
        return $this->bitacoracajaid;
    }

    /**
     * Set cajaid
     *
     * @param \AppBundle\Entity\CjCaja $cajaid
     *
     * @return CjBitacoracaja
     */
    public function setCajaid(\AppBundle\Entity\CjCaja $cajaid = null)
    {
        $this->cajaid = $cajaid;

        return $this;
    }

    /**
     * Get cajaid
     *
     * @return \AppBundle\Entity\CjCaja
     */
    public function getCajaid()
    {
        return $this->cajaid;
    }

    /**
     * Set usuarioid
     *
     * @param \AppBundle\Entity\Usuario $usuarioid
     *
     * @return CjBitacoracaja
     */
    public function setUsuarioid(\AppBundle\Entity\Usuario $usuarioid = null)
    {
        $this->usuarioid = $usuarioid;

        return $this;
    }

    /**
     * Get usuarioid
     *
     * @return \AppBundle\Entity\Usuario
     */
    public function getUsuarioid()
    {
        return $this->usuarioid;
    }
}

