<?php

namespace AppBundle\Entity;

/**
 * CbTipobloqueoporbloqueomanual
 */
class CbTipobloqueoporbloqueomanual
{
    /**
     * @var integer
     */
    private $tipobloqueoporbloqueomanual;

    /**
     * @var \AppBundle\Entity\CbTipobloqueo
     */
    private $tipobloqueoid;

    /**
     * @var \AppBundle\Entity\CbBloqueomanual
     */
    private $bloqueomanualid;


    /**
     * Get tipobloqueoporbloqueomanual
     *
     * @return integer
     */
    public function getTipobloqueoporbloqueomanual()
    {
        return $this->tipobloqueoporbloqueomanual;
    }

    /**
     * Set tipobloqueoid
     *
     * @param \AppBundle\Entity\CbTipobloqueo $tipobloqueoid
     *
     * @return CbTipobloqueoporbloqueomanual
     */
    public function setTipobloqueoid(\AppBundle\Entity\CbTipobloqueo $tipobloqueoid = null)
    {
        $this->tipobloqueoid = $tipobloqueoid;

        return $this;
    }

    /**
     * Get tipobloqueoid
     *
     * @return \AppBundle\Entity\CbTipobloqueo
     */
    public function getTipobloqueoid()
    {
        return $this->tipobloqueoid;
    }

    /**
     * Set bloqueomanualid
     *
     * @param \AppBundle\Entity\CbBloqueomanual $bloqueomanualid
     *
     * @return CbTipobloqueoporbloqueomanual
     */
    public function setBloqueomanualid(\AppBundle\Entity\CbBloqueomanual $bloqueomanualid = null)
    {
        $this->bloqueomanualid = $bloqueomanualid;

        return $this;
    }

    /**
     * Get bloqueomanualid
     *
     * @return \AppBundle\Entity\CbBloqueomanual
     */
    public function getBloqueomanualid()
    {
        return $this->bloqueomanualid;
    }
}

