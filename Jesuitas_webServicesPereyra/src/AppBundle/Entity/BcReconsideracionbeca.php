<?php

namespace AppBundle\Entity;

/**
 * BcReconsideracionbeca
 */
class BcReconsideracionbeca
{
    /**
     * @var \DateTime
     */
    private $fechasolicitud;

    /**
     * @var string
     */
    private $motivo;

    /**
     * @var integer
     */
    private $estatusid;

    /**
     * @var integer
     */
    private $porcentajebecaid;

    /**
     * @var string
     */
    private $observaciones;

    /**
     * @var integer
     */
    private $reconsideracionbecaid;

    /**
     * @var \AppBundle\Entity\BcBecas
     */
    private $becaid;


    /**
     * Set fechasolicitud
     *
     * @param \DateTime $fechasolicitud
     *
     * @return BcReconsideracionbeca
     */
    public function setFechasolicitud($fechasolicitud)
    {
        $this->fechasolicitud = $fechasolicitud;

        return $this;
    }

    /**
     * Get fechasolicitud
     *
     * @return \DateTime
     */
    public function getFechasolicitud()
    {
        return $this->fechasolicitud;
    }

    /**
     * Set motivo
     *
     * @param string $motivo
     *
     * @return BcReconsideracionbeca
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
     * Set estatusid
     *
     * @param integer $estatusid
     *
     * @return BcReconsideracionbeca
     */
    public function setEstatusid($estatusid)
    {
        $this->estatusid = $estatusid;

        return $this;
    }

    /**
     * Get estatusid
     *
     * @return integer
     */
    public function getEstatusid()
    {
        return $this->estatusid;
    }

    /**
     * Set porcentajebecaid
     *
     * @param integer $porcentajebecaid
     *
     * @return BcReconsideracionbeca
     */
    public function setPorcentajebecaid($porcentajebecaid)
    {
        $this->porcentajebecaid = $porcentajebecaid;

        return $this;
    }

    /**
     * Get porcentajebecaid
     *
     * @return integer
     */
    public function getPorcentajebecaid()
    {
        return $this->porcentajebecaid;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return BcReconsideracionbeca
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
     * Get reconsideracionbecaid
     *
     * @return integer
     */
    public function getReconsideracionbecaid()
    {
        return $this->reconsideracionbecaid;
    }

    /**
     * Set becaid
     *
     * @param \AppBundle\Entity\BcBecas $becaid
     *
     * @return BcReconsideracionbeca
     */
    public function setBecaid(\AppBundle\Entity\BcBecas $becaid = null)
    {
        $this->becaid = $becaid;

        return $this;
    }

    /**
     * Get becaid
     *
     * @return \AppBundle\Entity\BcBecas
     */
    public function getBecaid()
    {
        return $this->becaid;
    }
}

