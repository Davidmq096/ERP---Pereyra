<?php

namespace AppBundle\Entity;

/**
 * CeBoletaporciclo
 */
class CeBoletaporciclo
{
    /**
     * @var integer
     */
    private $boletaporcicloid;

    /**
     * @var \AppBundle\Entity\CeBoletas
     */
    private $boletaid;

    /**
     * @var \AppBundle\Entity\Ciclo
     */
    private $cicloid;


    /**
     * Get boletaporcicloid
     *
     * @return integer
     */
    public function getBoletaporcicloid()
    {
        return $this->boletaporcicloid;
    }

    /**
     * Set boletaid
     *
     * @param \AppBundle\Entity\CeBoletas $boletaid
     *
     * @return CeBoletaporciclo
     */
    public function setBoletaid(\AppBundle\Entity\CeBoletas $boletaid = null)
    {
        $this->boletaid = $boletaid;

        return $this;
    }

    /**
     * Get boletaid
     *
     * @return \AppBundle\Entity\CeBoletas
     */
    public function getBoletaid()
    {
        return $this->boletaid;
    }

    /**
     * Set cicloid
     *
     * @param \AppBundle\Entity\Ciclo $cicloid
     *
     * @return CeBoletaporciclo
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

