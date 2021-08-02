<?php

namespace AppBundle\Entity;

/**
 * CjCodigoconsmov
 */
class CjCodigoconsmov
{
    /**
     * @var integer
     */
    private $codigoconsmov;

    /**
     * @var string
     */
    private $transaccion;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var string
     */
    private $origen;

    /**
     * @var string
     */
    private $tipo;

    /**
     * @var integer
     */
    private $tipoconciliacion;

    /**
     * @var integer
     */
    private $codigoconsmovid;

    /**
     * @var \AppBundle\Entity\CjFormapago
     */
    private $formapagoid;


    /**
     * Set codigoconsmov
     *
     * @param integer $codigoconsmov
     *
     * @return CjCodigoconsmov
     */
    public function setCodigoconsmov($codigoconsmov)
    {
        $this->codigoconsmov = $codigoconsmov;

        return $this;
    }

    /**
     * Get codigoconsmov
     *
     * @return integer
     */
    public function getCodigoconsmov()
    {
        return $this->codigoconsmov;
    }

    /**
     * Set transaccion
     *
     * @param string $transaccion
     *
     * @return CjCodigoconsmov
     */
    public function setTransaccion($transaccion)
    {
        $this->transaccion = $transaccion;

        return $this;
    }

    /**
     * Get transaccion
     *
     * @return string
     */
    public function getTransaccion()
    {
        return $this->transaccion;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return CjCodigoconsmov
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
     * Set origen
     *
     * @param string $origen
     *
     * @return CjCodigoconsmov
     */
    public function setOrigen($origen)
    {
        $this->origen = $origen;

        return $this;
    }

    /**
     * Get origen
     *
     * @return string
     */
    public function getOrigen()
    {
        return $this->origen;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     *
     * @return CjCodigoconsmov
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set tipoconciliacion
     *
     * @param integer $tipoconciliacion
     *
     * @return CjCodigoconsmov
     */
    public function setTipoconciliacion($tipoconciliacion)
    {
        $this->tipoconciliacion = $tipoconciliacion;

        return $this;
    }

    /**
     * Get tipoconciliacion
     *
     * @return integer
     */
    public function getTipoconciliacion()
    {
        return $this->tipoconciliacion;
    }

    /**
     * Get codigoconsmovid
     *
     * @return integer
     */
    public function getCodigoconsmovid()
    {
        return $this->codigoconsmovid;
    }

    /**
     * Set formapagoid
     *
     * @param \AppBundle\Entity\CjFormapago $formapagoid
     *
     * @return CjCodigoconsmov
     */
    public function setFormapagoid(\AppBundle\Entity\CjFormapago $formapagoid = null)
    {
        $this->formapagoid = $formapagoid;

        return $this;
    }

    /**
     * Get formapagoid
     *
     * @return \AppBundle\Entity\CjFormapago
     */
    public function getFormapagoid()
    {
        return $this->formapagoid;
    }
}

