<?php

namespace AppBundle\Entity;

/**
 * CjPago
 */
class CjPago
{
    /**
     * @var integer
     */
    private $empleadoid;

    /**
     * @var string
     */
    private $folio;

    /**
     * @var string
     */
    private $importe;

    /**
     * @var \DateTime
     */
    private $fecha;

    /**
     * @var integer
     */
    private $pagoid;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;

    /**
     * @var \AppBundle\Entity\CjBitacoracaja
     */
    private $bitacoracajaid;

    /**
     * @var \AppBundle\Entity\CjCaja
     */
    private $cajaid;

    /**
     * @var \AppBundle\Entity\Ciclo
     */
    private $cicloid;

    /**
     * @var \AppBundle\Entity\CjEmpresa
     */
    private $empresaid;

    /**
     * @var \AppBundle\Entity\CjPagoestatus
     */
    private $pagoestatusid;

    /**
     * @var \AppBundle\Entity\Solicitudadmision
     */
    private $solicitudadmisionid;

    /**
     * @var \AppBundle\Entity\Usuario
     */
    private $usuarioid;


    /**
     * Set empleadoid
     *
     * @param integer $empleadoid
     *
     * @return CjPago
     */
    public function setEmpleadoid($empleadoid)
    {
        $this->empleadoid = $empleadoid;

        return $this;
    }

    /**
     * Get empleadoid
     *
     * @return integer
     */
    public function getEmpleadoid()
    {
        return $this->empleadoid;
    }

    /**
     * Set folio
     *
     * @param string $folio
     *
     * @return CjPago
     */
    public function setFolio($folio)
    {
        $this->folio = $folio;

        return $this;
    }

    /**
     * Get folio
     *
     * @return string
     */
    public function getFolio()
    {
        return $this->folio;
    }

    /**
     * Set importe
     *
     * @param string $importe
     *
     * @return CjPago
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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return CjPago
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
     * Get pagoid
     *
     * @return integer
     */
    public function getPagoid()
    {
        return $this->pagoid;
    }

    /**
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return CjPago
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

    /**
     * Set bitacoracajaid
     *
     * @param \AppBundle\Entity\CjBitacoracaja $bitacoracajaid
     *
     * @return CjPago
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
     * @return CjPago
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
     * Set cicloid
     *
     * @param \AppBundle\Entity\Ciclo $cicloid
     *
     * @return CjPago
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

    /**
     * Set empresaid
     *
     * @param \AppBundle\Entity\CjEmpresa $empresaid
     *
     * @return CjPago
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
     * Set pagoestatusid
     *
     * @param \AppBundle\Entity\CjPagoestatus $pagoestatusid
     *
     * @return CjPago
     */
    public function setPagoestatusid(\AppBundle\Entity\CjPagoestatus $pagoestatusid = null)
    {
        $this->pagoestatusid = $pagoestatusid;

        return $this;
    }

    /**
     * Get pagoestatusid
     *
     * @return \AppBundle\Entity\CjPagoestatus
     */
    public function getPagoestatusid()
    {
        return $this->pagoestatusid;
    }

    /**
     * Set solicitudadmisionid
     *
     * @param \AppBundle\Entity\Solicitudadmision $solicitudadmisionid
     *
     * @return CjPago
     */
    public function setSolicitudadmisionid(\AppBundle\Entity\Solicitudadmision $solicitudadmisionid = null)
    {
        $this->solicitudadmisionid = $solicitudadmisionid;

        return $this;
    }

    /**
     * Get solicitudadmisionid
     *
     * @return \AppBundle\Entity\Solicitudadmision
     */
    public function getSolicitudadmisionid()
    {
        return $this->solicitudadmisionid;
    }

    /**
     * Set usuarioid
     *
     * @param \AppBundle\Entity\Usuario $usuarioid
     *
     * @return CjPago
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

