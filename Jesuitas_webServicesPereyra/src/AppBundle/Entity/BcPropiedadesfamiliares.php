<?php

namespace AppBundle\Entity;

/**
 * BcPropiedadesfamiliares
 */
class BcPropiedadesfamiliares
{
    /**
     * @var string
     */
    private $tipopropiedad;

    /**
     * @var string
     */
    private $valoraproximado;

    /**
     * @var string
     */
    private $creditoanombrede;

    /**
     * @var string
     */
    private $propiedadanombrede;

    /**
     * @var boolean
     */
    private $domicilioactual = '0';

    /**
     * @var string
     */
    private $mtsterreno;

    /**
     * @var string
     */
    private $mtsconstruccion;

    /**
     * @var string
     */
    private $ubicacion;

    /**
     * @var integer
     */
    private $portal;

    /**
     * @var integer
     */
    private $propiedadfamiliaid;

    /**
     * @var \AppBundle\Entity\BcSolicitudbeca
     */
    private $solicitudid;

    /**
     * @var \AppBundle\Entity\BcEstatuspropiedad
     */
    private $estatusid;


    /**
     * Set tipopropiedad
     *
     * @param string $tipopropiedad
     *
     * @return BcPropiedadesfamiliares
     */
    public function setTipopropiedad($tipopropiedad)
    {
        $this->tipopropiedad = $tipopropiedad;

        return $this;
    }

    /**
     * Get tipopropiedad
     *
     * @return string
     */
    public function getTipopropiedad()
    {
        return $this->tipopropiedad;
    }

    /**
     * Set valoraproximado
     *
     * @param string $valoraproximado
     *
     * @return BcPropiedadesfamiliares
     */
    public function setValoraproximado($valoraproximado)
    {
        $this->valoraproximado = $valoraproximado;

        return $this;
    }

    /**
     * Get valoraproximado
     *
     * @return string
     */
    public function getValoraproximado()
    {
        return $this->valoraproximado;
    }

    /**
     * Set creditoanombrede
     *
     * @param string $creditoanombrede
     *
     * @return BcPropiedadesfamiliares
     */
    public function setCreditoanombrede($creditoanombrede)
    {
        $this->creditoanombrede = $creditoanombrede;

        return $this;
    }

    /**
     * Get creditoanombrede
     *
     * @return string
     */
    public function getCreditoanombrede()
    {
        return $this->creditoanombrede;
    }

    /**
     * Set propiedadanombrede
     *
     * @param string $propiedadanombrede
     *
     * @return BcPropiedadesfamiliares
     */
    public function setPropiedadanombrede($propiedadanombrede)
    {
        $this->propiedadanombrede = $propiedadanombrede;

        return $this;
    }

    /**
     * Get propiedadanombrede
     *
     * @return string
     */
    public function getPropiedadanombrede()
    {
        return $this->propiedadanombrede;
    }

    /**
     * Set domicilioactual
     *
     * @param boolean $domicilioactual
     *
     * @return BcPropiedadesfamiliares
     */
    public function setDomicilioactual($domicilioactual)
    {
        $this->domicilioactual = $domicilioactual;

        return $this;
    }

    /**
     * Get domicilioactual
     *
     * @return boolean
     */
    public function getDomicilioactual()
    {
        return $this->domicilioactual;
    }

    /**
     * Set mtsterreno
     *
     * @param string $mtsterreno
     *
     * @return BcPropiedadesfamiliares
     */
    public function setMtsterreno($mtsterreno)
    {
        $this->mtsterreno = $mtsterreno;

        return $this;
    }

    /**
     * Get mtsterreno
     *
     * @return string
     */
    public function getMtsterreno()
    {
        return $this->mtsterreno;
    }

    /**
     * Set mtsconstruccion
     *
     * @param string $mtsconstruccion
     *
     * @return BcPropiedadesfamiliares
     */
    public function setMtsconstruccion($mtsconstruccion)
    {
        $this->mtsconstruccion = $mtsconstruccion;

        return $this;
    }

    /**
     * Get mtsconstruccion
     *
     * @return string
     */
    public function getMtsconstruccion()
    {
        return $this->mtsconstruccion;
    }

    /**
     * Set ubicacion
     *
     * @param string $ubicacion
     *
     * @return BcPropiedadesfamiliares
     */
    public function setUbicacion($ubicacion)
    {
        $this->ubicacion = $ubicacion;

        return $this;
    }

    /**
     * Get ubicacion
     *
     * @return string
     */
    public function getUbicacion()
    {
        return $this->ubicacion;
    }

    /**
     * Set portal
     *
     * @param integer $portal
     *
     * @return BcPropiedadesfamiliares
     */
    public function setPortal($portal)
    {
        $this->portal = $portal;

        return $this;
    }

    /**
     * Get portal
     *
     * @return integer
     */
    public function getPortal()
    {
        return $this->portal;
    }

    /**
     * Get propiedadfamiliaid
     *
     * @return integer
     */
    public function getPropiedadfamiliaid()
    {
        return $this->propiedadfamiliaid;
    }

    /**
     * Set solicitudid
     *
     * @param \AppBundle\Entity\BcSolicitudbeca $solicitudid
     *
     * @return BcPropiedadesfamiliares
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

    /**
     * Set estatusid
     *
     * @param \AppBundle\Entity\BcEstatuspropiedad $estatusid
     *
     * @return BcPropiedadesfamiliares
     */
    public function setEstatusid(\AppBundle\Entity\BcEstatuspropiedad $estatusid = null)
    {
        $this->estatusid = $estatusid;

        return $this;
    }

    /**
     * Get estatusid
     *
     * @return \AppBundle\Entity\BcEstatuspropiedad
     */
    public function getEstatusid()
    {
        return $this->estatusid;
    }
}

