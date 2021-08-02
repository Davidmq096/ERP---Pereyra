<?php

namespace AppBundle\Entity;

/**
 * BcDeudascreditos
 */
class BcDeudascreditos
{
    /**
     * @var string
     */
    private $importetotal;

    /**
     * @var string
     */
    private $pagomensual;

    /**
     * @var string
     */
    private $bancoinstitucion;

    /**
     * @var string
     */
    private $limitecredito;

    /**
     * @var integer
     */
    private $portal;

    /**
     * @var integer
     */
    private $deudascreditosid;

    /**
     * @var \AppBundle\Entity\BcSolicitudbeca
     */
    private $solicitudid;

    /**
     * @var \AppBundle\Entity\BcTipocredito
     */
    private $tipocreditoid;


    /**
     * Set importetotal
     *
     * @param string $importetotal
     *
     * @return BcDeudascreditos
     */
    public function setImportetotal($importetotal)
    {
        $this->importetotal = $importetotal;

        return $this;
    }

    /**
     * Get importetotal
     *
     * @return string
     */
    public function getImportetotal()
    {
        return $this->importetotal;
    }

    /**
     * Set pagomensual
     *
     * @param string $pagomensual
     *
     * @return BcDeudascreditos
     */
    public function setPagomensual($pagomensual)
    {
        $this->pagomensual = $pagomensual;

        return $this;
    }

    /**
     * Get pagomensual
     *
     * @return string
     */
    public function getPagomensual()
    {
        return $this->pagomensual;
    }

    /**
     * Set bancoinstitucion
     *
     * @param string $bancoinstitucion
     *
     * @return BcDeudascreditos
     */
    public function setBancoinstitucion($bancoinstitucion)
    {
        $this->bancoinstitucion = $bancoinstitucion;

        return $this;
    }

    /**
     * Get bancoinstitucion
     *
     * @return string
     */
    public function getBancoinstitucion()
    {
        return $this->bancoinstitucion;
    }

    /**
     * Set limitecredito
     *
     * @param string $limitecredito
     *
     * @return BcDeudascreditos
     */
    public function setLimitecredito($limitecredito)
    {
        $this->limitecredito = $limitecredito;

        return $this;
    }

    /**
     * Get limitecredito
     *
     * @return string
     */
    public function getLimitecredito()
    {
        return $this->limitecredito;
    }

    /**
     * Set portal
     *
     * @param integer $portal
     *
     * @return BcDeudascreditos
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
     * Get deudascreditosid
     *
     * @return integer
     */
    public function getDeudascreditosid()
    {
        return $this->deudascreditosid;
    }

    /**
     * Set solicitudid
     *
     * @param \AppBundle\Entity\BcSolicitudbeca $solicitudid
     *
     * @return BcDeudascreditos
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
     * Set tipocreditoid
     *
     * @param \AppBundle\Entity\BcTipocredito $tipocreditoid
     *
     * @return BcDeudascreditos
     */
    public function setTipocreditoid(\AppBundle\Entity\BcTipocredito $tipocreditoid = null)
    {
        $this->tipocreditoid = $tipocreditoid;

        return $this;
    }

    /**
     * Get tipocreditoid
     *
     * @return \AppBundle\Entity\BcTipocredito
     */
    public function getTipocreditoid()
    {
        return $this->tipocreditoid;
    }
}

