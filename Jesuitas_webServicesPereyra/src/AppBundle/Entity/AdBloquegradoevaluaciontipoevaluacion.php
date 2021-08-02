<?php

namespace AppBundle\Entity;

/**
 * AdBloquegradoevaluaciontipoevaluacion
 */
class AdBloquegradoevaluaciontipoevaluacion
{
    /**
     * @var integer
     */
    private $tipoevaluacionid;

    /**
     * @var integer
     */
    private $bloquegradoevaluacionid;

    /**
     * @var integer
     */
    private $bloquegradoevaluaciontipoevaluacionid;


    /**
     * Set tipoevaluacionid
     *
     * @param integer $tipoevaluacionid
     *
     * @return AdBloquegradoevaluaciontipoevaluacion
     */
    public function setTipoevaluacionid($tipoevaluacionid)
    {
        $this->tipoevaluacionid = $tipoevaluacionid;

        return $this;
    }

    /**
     * Get tipoevaluacionid
     *
     * @return integer
     */
    public function getTipoevaluacionid()
    {
        return $this->tipoevaluacionid;
    }

    /**
     * Set bloquegradoevaluacionid
     *
     * @param integer $bloquegradoevaluacionid
     *
     * @return AdBloquegradoevaluaciontipoevaluacion
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
     * Get bloquegradoevaluaciontipoevaluacionid
     *
     * @return integer
     */
    public function getBloquegradoevaluaciontipoevaluacionid()
    {
        return $this->bloquegradoevaluaciontipoevaluacionid;
    }
}

