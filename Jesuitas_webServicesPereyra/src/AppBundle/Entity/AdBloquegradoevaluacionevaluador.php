<?php

namespace AppBundle\Entity;

/**
 * AdBloquegradoevaluacionevaluador
 */
class AdBloquegradoevaluacionevaluador
{
    /**
     * @var integer
     */
    private $cupo;

    /**
     * @var integer
     */
    private $bloquegradoevaluacionevaluadorid;

    /**
     * @var \AppBundle\Entity\AdBloquegradoevaluacion
     */
    private $bloquegradoevaluacionid;

    /**
     * @var \AppBundle\Entity\Lugar
     */
    private $lugarid;

    /**
     * @var \AppBundle\Entity\Usuario
     */
    private $usuarioid;


    /**
     * Set cupo
     *
     * @param integer $cupo
     *
     * @return AdBloquegradoevaluacionevaluador
     */
    public function setCupo($cupo)
    {
        $this->cupo = $cupo;

        return $this;
    }

    /**
     * Get cupo
     *
     * @return integer
     */
    public function getCupo()
    {
        return $this->cupo;
    }

    /**
     * Get bloquegradoevaluacionevaluadorid
     *
     * @return integer
     */
    public function getBloquegradoevaluacionevaluadorid()
    {
        return $this->bloquegradoevaluacionevaluadorid;
    }

    /**
     * Set bloquegradoevaluacionid
     *
     * @param \AppBundle\Entity\AdBloquegradoevaluacion $bloquegradoevaluacionid
     *
     * @return AdBloquegradoevaluacionevaluador
     */
    public function setBloquegradoevaluacionid(\AppBundle\Entity\AdBloquegradoevaluacion $bloquegradoevaluacionid = null)
    {
        $this->bloquegradoevaluacionid = $bloquegradoevaluacionid;

        return $this;
    }

    /**
     * Get bloquegradoevaluacionid
     *
     * @return \AppBundle\Entity\AdBloquegradoevaluacion
     */
    public function getBloquegradoevaluacionid()
    {
        return $this->bloquegradoevaluacionid;
    }

    /**
     * Set lugarid
     *
     * @param \AppBundle\Entity\Lugar $lugarid
     *
     * @return AdBloquegradoevaluacionevaluador
     */
    public function setLugarid(\AppBundle\Entity\Lugar $lugarid = null)
    {
        $this->lugarid = $lugarid;

        return $this;
    }

    /**
     * Get lugarid
     *
     * @return \AppBundle\Entity\Lugar
     */
    public function getLugarid()
    {
        return $this->lugarid;
    }

    /**
     * Set usuarioid
     *
     * @param \AppBundle\Entity\Usuario $usuarioid
     *
     * @return AdBloquegradoevaluacionevaluador
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

