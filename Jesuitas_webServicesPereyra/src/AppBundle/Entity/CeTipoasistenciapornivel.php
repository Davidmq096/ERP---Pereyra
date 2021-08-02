<?php

namespace AppBundle\Entity;

/**
 * CeTipoasistenciapornivel
 */
class CeTipoasistenciapornivel
{
    /**
     * @var integer
     */
    private $tipoasistenciaid;

    /**
     * @var integer
     */
    private $nivelid;

    /**
     * @var integer
     */
    private $tipoasistenciapornivelid;


    /**
     * Set tipoasistenciaid
     *
     * @param integer $tipoasistenciaid
     *
     * @return CeTipoasistenciapornivel
     */
    public function setTipoasistenciaid($tipoasistenciaid)
    {
        $this->tipoasistenciaid = $tipoasistenciaid;

        return $this;
    }

    /**
     * Get tipoasistenciaid
     *
     * @return integer
     */
    public function getTipoasistenciaid()
    {
        return $this->tipoasistenciaid;
    }

    /**
     * Set nivelid
     *
     * @param integer $nivelid
     *
     * @return CeTipoasistenciapornivel
     */
    public function setNivelid($nivelid)
    {
        $this->nivelid = $nivelid;

        return $this;
    }

    /**
     * Get nivelid
     *
     * @return integer
     */
    public function getNivelid()
    {
        return $this->nivelid;
    }

    /**
     * Get tipoasistenciapornivelid
     *
     * @return integer
     */
    public function getTipoasistenciapornivelid()
    {
        return $this->tipoasistenciapornivelid;
    }
}

