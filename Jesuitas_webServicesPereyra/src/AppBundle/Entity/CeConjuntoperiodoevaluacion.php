<?php

namespace AppBundle\Entity;

/**
 * CeConjuntoperiodoevaluacion
 */
class CeConjuntoperiodoevaluacion
{
    /**
     * @var boolean
     */
    private $promediable = '0';

    /**
     * @var integer
     */
    private $conjuntoperiodoevaluacionid;

    /**
     * @var \AppBundle\Entity\Ciclo
     */
    private $cicloid;


    /**
     * Set promediable
     *
     * @param boolean $promediable
     *
     * @return CeConjuntoperiodoevaluacion
     */
    public function setPromediable($promediable)
    {
        $this->promediable = $promediable;

        return $this;
    }

    /**
     * Get promediable
     *
     * @return boolean
     */
    public function getPromediable()
    {
        return $this->promediable;
    }

    /**
     * Get conjuntoperiodoevaluacionid
     *
     * @return integer
     */
    public function getConjuntoperiodoevaluacionid()
    {
        return $this->conjuntoperiodoevaluacionid;
    }

    /**
     * Set cicloid
     *
     * @param \AppBundle\Entity\Ciclo $cicloid
     *
     * @return CeConjuntoperiodoevaluacion
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
}

