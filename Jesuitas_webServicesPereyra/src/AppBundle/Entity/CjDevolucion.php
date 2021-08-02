<?php

namespace AppBundle\Entity;

/**
 * CjDevolucion
 */
class CjDevolucion
{
    /**
     * @var integer
     */
    private $usuarioidautoriza;

    /**
     * @var string
     */
    private $personarecibedinero;

    /**
     * @var string
     */
    private $motivo;

    /**
     * @var string
     */
    private $monto;

    /**
     * @var \DateTime
     */
    private $fecha;

    /**
     * @var boolean
     */
    private $facturado;

    /**
     * @var integer
     */
    private $devolucionid;

    /**
     * @var \AppBundle\Entity\CjBitacoracaja
     */
    private $bitacoracajaid;

    /**
     * @var \AppBundle\Entity\CjCaja
     */
    private $cajaid;

    /**
     * @var \AppBundle\Entity\CjEmpresa
     */
    private $empresaid;

    /**
     * @var \AppBundle\Entity\CePadresotutores
     */
    private $padresotutoresid;

    /**
     * @var \AppBundle\Entity\CjPago
     */
    private $pagoid;

    /**
     * @var \AppBundle\Entity\Usuario
     */
    private $usuarioid;


    /**
     * Set usuarioidautoriza
     *
     * @param integer $usuarioidautoriza
     *
     * @return CjDevolucion
     */
    public function setUsuarioidautoriza($usuarioidautoriza)
    {
        $this->usuarioidautoriza = $usuarioidautoriza;

        return $this;
    }

    /**
     * Get usuarioidautoriza
     *
     * @return integer
     */
    public function getUsuarioidautoriza()
    {
        return $this->usuarioidautoriza;
    }

    /**
     * Set personarecibedinero
     *
     * @param string $personarecibedinero
     *
     * @return CjDevolucion
     */
    public function setPersonarecibedinero($personarecibedinero)
    {
        $this->personarecibedinero = $personarecibedinero;

        return $this;
    }

    /**
     * Get personarecibedinero
     *
     * @return string
     */
    public function getPersonarecibedinero()
    {
        return $this->personarecibedinero;
    }

    /**
     * Set motivo
     *
     * @param string $motivo
     *
     * @return CjDevolucion
     */
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;

        return $this;
    }

    /**
     * Get motivo
     *
     * @return string
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * Set monto
     *
     * @param string $monto
     *
     * @return CjDevolucion
     */
    public function setMonto($monto)
    {
        $this->monto = $monto;

        return $this;
    }

    /**
     * Get monto
     *
     * @return string
     */
    public function getMonto()
    {
        return $this->monto;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return CjDevolucion
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set facturado
     *
     * @param boolean $facturado
     *
     * @return CjDevolucion
     */
    public function setFacturado($facturado)
    {
        $this->facturado = $facturado;

        return $this;
    }

    /**
     * Get facturado
     *
     * @return boolean
     */
    public function getFacturado()
    {
        return $this->facturado;
    }

    /**
     * Get devolucionid
     *
     * @return integer
     */
    public function getDevolucionid()
    {
        return $this->devolucionid;
    }

    /**
     * Set bitacoracajaid
     *
     * @param \AppBundle\Entity\CjBitacoracaja $bitacoracajaid
     *
     * @return CjDevolucion
     */
    public function setBitacoracajaid(\AppBundle\Entity\CjBitacoracaja $bitacoracajaid = null)
    {
        $this->bitacoracajaid = $bitacoracajaid;

        return $this;
    }

    /**
     * Get bitacoracajaid
     *
     * @return \AppBundle\Entity\CjBitacoracaja
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
     * @return CjDevolucion
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
     * Set empresaid
     *
     * @param \AppBundle\Entity\CjEmpresa $empresaid
     *
     * @return CjDevolucion
     */
    public function setEmpresaid(\AppBundle\Entity\CjEmpresa $empresaid = null)
    {
        $this->empresaid = $empresaid;

        return $this;
    }

    /**
     * Get empresaid
     *
     * @return \AppBundle\Entity\CjEmpresa
     */
    public function getEmpresaid()
    {
        return $this->empresaid;
    }

    /**
     * Set padresotutoresid
     *
     * @param \AppBundle\Entity\CePadresotutores $padresotutoresid
     *
     * @return CjDevolucion
     */
    public function setPadresotutoresid(\AppBundle\Entity\CePadresotutores $padresotutoresid = null)
    {
        $this->padresotutoresid = $padresotutoresid;

        return $this;
    }

    /**
     * Get padresotutoresid
     *
     * @return \AppBundle\Entity\CePadresotutores
     */
    public function getPadresotutoresid()
    {
        return $this->padresotutoresid;
    }

    /**
     * Set pagoid
     *
     * @param \AppBundle\Entity\CjPago $pagoid
     *
     * @return CjDevolucion
     */
    public function setPagoid(\AppBundle\Entity\CjPago $pagoid = null)
    {
        $this->pagoid = $pagoid;

        return $this;
    }

    /**
     * Get pagoid
     *
     * @return \AppBundle\Entity\CjPago
     */
    public function getPagoid()
    {
        return $this->pagoid;
    }

    /**
     * Set usuarioid
     *
     * @param \AppBundle\Entity\Usuario $usuarioid
     *
     * @return CjDevolucion
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

