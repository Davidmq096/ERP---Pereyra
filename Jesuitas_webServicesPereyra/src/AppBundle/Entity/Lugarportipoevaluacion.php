<?php

namespace AppBundle\Entity;

/**
 * Lugarportipoevaluacion
 */
class Lugarportipoevaluacion
{
    /**
     * @var integer
     */
    private $lugarportipoevaluacionid;

    /**
     * @var \AppBundle\Entity\Lugar
     */
    private $lugarid;

    /**
     * @var \AppBundle\Entity\Tipoevaluacion
     */
    private $tipoevaluacionid;


    /**
     * Get lugarportipoevaluacionid
     *
     * @return integer
     */
    public function getLugarportipoevaluacionid()
    {
        return $this->lugarportipoevaluacionid;
    }

    /**
     * Set lugarid
     *
     * @param \AppBundle\Entity\Lugar $lugarid
     *
     * @return Lugarportipoevaluacion
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
     * Set tipoevaluacionid
     *
     * @param \AppBundle\Entity\Tipoevaluacion $tipoevaluacionid
     *
     * @return Lugarportipoevaluacion
     */
    public function setTipoevaluacionid(\AppBundle\Entity\Tipoevaluacion $tipoevaluacionid = null)
    {
        $this->tipoevaluacionid = $tipoevaluacionid;

        return $this;
    }

    /**
     * Get tipoevaluacionid
     *
     * @return \AppBundle\Entity\Tipoevaluacion
     */
    public function getTipoevaluacionid()
    {
        return $this->tipoevaluacionid;
    }
}

