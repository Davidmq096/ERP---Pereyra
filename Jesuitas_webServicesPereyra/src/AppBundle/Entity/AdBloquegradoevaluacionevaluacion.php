<?php

namespace AppBundle\Entity;

/**
 * AdBloquegradoevaluacionevaluacion
 */
class AdBloquegradoevaluacionevaluacion
{
    /**
     * @var integer
     */
    private $evaluacionid;

    /**
     * @var integer
     */
    private $bloquegradoevaluacionid;

    /**
     * @var integer
     */
    private $bloquegradoevaluacionevaluacionid;


    /**
     * Set evaluacionid
     *
     * @param integer $evaluacionid
     *
     * @return AdBloquegradoevaluacionevaluacion
     */
    public function setEvaluacionid($evaluacionid)
    {
        $this->evaluacionid = $evaluacionid;

        return $this;
    }

    /**
     * Get evaluacionid
     *
     * @return integer
     */
    public function getEvaluacionid()
    {
        return $this->evaluacionid;
    }

    /**
     * Set bloquegradoevaluacionid
     *
     * @param integer $bloquegradoevaluacionid
     *
     * @return AdBloquegradoevaluacionevaluacion
     */
    public function setBloquegradoevaluacionid($bloquegradoevaluacionid)
    {
        $this->bloquegradoevaluacionid = $bloquegradoevaluacionid;

        return $this;
    }

    /**
     * Get bloquegradoevaluacionid
     *
     * @return integer
     */
    public function getBloquegradoevaluacionid()
    {
        return $this->bloquegradoevaluacionid;
    }

    /**
     * Get bloquegradoevaluacionevaluacionid
     *
     * @return integer
     */
    public function getBloquegradoevaluacionevaluacionid()
    {
        return $this->bloquegradoevaluacionevaluacionid;
    }
}

