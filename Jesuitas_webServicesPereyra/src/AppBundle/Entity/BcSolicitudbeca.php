<?php

namespace AppBundle\Entity;

/**
 * BcSolicitudbeca
 */
class BcSolicitudbeca
{
    /**
     * @var integer
     */
    private $activo;

    /**
     * @var \DateTime
     */
    private $fechacreacion;

    /**
     * @var \DateTime
     */
    private $fechamodificacion;

    /**
     * @var string
     */
    private $observaciones;

    /**
     * @var boolean
     */
    private $hijodepersonal;

    /**
     * @var integer
     */
    private $pagado;

    /**
     * @var integer
     */
    private $solicitudid;

    /**
     * @var \AppBundle\Entity\CeClavefamiliar
     */
    private $clavefamiliarid;

    /**
     * @var \AppBundle\Entity\BcEstatussolicitudbeca
     */
    private $estatusid;

    /**
     * @var \AppBundle\Entity\Ciclo
     */
    private $cicloid;

    /**
     * @var \AppBundle\Entity\Usuario
     */
    private $usuarioid;


    /**
     * Set activo
     *
     * @param integer $activo
     *
     * @return BcSolicitudbeca
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return integer
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set fechacreacion
     *
     * @param \DateTime $fechacreacion
     *
     * @return BcSolicitudbeca
     */
    public function setFechacreacion($fechacreacion)
    {
        $this->fechacreacion = $fechacreacion;

        return $this;
    }

    /**
     * Get fechacreacion
     *
     * @return \DateTime
     */
    public function getFechacreacion()
    {
        return $this->fechacreacion;
    }

    /**
     * Set fechamodificacion
     *
     * @param \DateTime $fechamodificacion
     *
     * @return BcSolicitudbeca
     */
    public function setFechamodificacion($fechamodificacion)
    {
        $this->fechamodificacion = $fechamodificacion;

        return $this;
    }

    /**
     * Get fechamodificacion
     *
     * @return \DateTime
     */
    public function getFechamodificacion()
    {
        return $this->fechamodificacion;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return BcSolicitudbeca
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
     * Set hijodepersonal
     *
     * @param boolean $hijodepersonal
     *
     * @return BcSolicitudbeca
     */
    public function setHijodepersonal($hijodepersonal)
    {
        $this->hijodepersonal = $hijodepersonal;

        return $this;
    }

    /**
     * Get hijodepersonal
     *
     * @return boolean
     */
    public function getHijodepersonal()
    {
        return $this->hijodepersonal;
    }

    /**
     * Set pagado
     *
     * @param integer $pagado
     *
     * @return BcSolicitudbeca
     */
    public function setPagado($pagado)
    {
        $this->pagado = $pagado;

        return $this;
    }

    /**
     * Get pagado
     *
     * @return integer
     */
    public function getPagado()
    {
        return $this->pagado;
    }

    /**
     * Get solicitudid
     *
     * @return integer
     */
    public function getSolicitudid()
    {
        return $this->solicitudid;
    }

    /**
     * Set clavefamiliarid
     *
     * @param \AppBundle\Entity\CeClavefamiliar $clavefamiliarid
     *
     * @return BcSolicitudbeca
     */
    public function setClavefamiliarid(\AppBundle\Entity\CeClavefamiliar $clavefamiliarid = null)
    {
        $this->clavefamiliarid = $clavefamiliarid;

        return $this;
    }

    /**
     * Get clavefamiliarid
     *
     * @return \AppBundle\Entity\CeClavefamiliar
     */
    public function getClavefamiliarid()
    {
        return $this->clavefamiliarid;
    }

    /**
     * Set estatusid
     *
     * @param \AppBundle\Entity\BcEstatussolicitudbeca $estatusid
     *
     * @return BcSolicitudbeca
     */
    public function setEstatusid(\AppBundle\Entity\BcEstatussolicitudbeca $estatusid = null)
    {
        $this->estatusid = $estatusid;

        return $this;
    }

    /**
     * Get estatusid
     *
     * @return \AppBundle\Entity\BcEstatussolicitudbeca
     */
    public function getEstatusid()
    {
        return $this->estatusid;
    }

    /**
     * Set cicloid
     *
     * @param \AppBundle\Entity\Ciclo $cicloid
     *
     * @return BcSolicitudbeca
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
     * Set usuarioid
     *
     * @param \AppBundle\Entity\Usuario $usuarioid
     *
     * @return BcSolicitudbeca
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

