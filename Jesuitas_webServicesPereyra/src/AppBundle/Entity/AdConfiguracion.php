<?php

namespace AppBundle\Entity;

/**
 * AdConfiguracion
 */
class AdConfiguracion
{
    /**
     * @var integer
     */
    private $configuracionid;

    /**
     * @var \AppBundle\Entity\Ciclo
     */
    private $cicloid;

    /**
     * @var \AppBundle\Entity\Nivel
     */
    private $nivelid;

    /**
     * @var \AppBundle\Entity\AdTablero
     */
    private $tableroid;


    /**
     * Get configuracionid
     *
     * @return integer
     */
    public function getConfiguracionid()
    {
        return $this->configuracionid;
    }

    /**
     * Set cicloid
     *
     * @param \AppBundle\Entity\Ciclo $cicloid
     *
     * @return AdConfiguracion
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

    /**
     * Set nivelid
     *
     * @param \AppBundle\Entity\Nivel $nivelid
     *
     * @return AdConfiguracion
     */
    public function setNivelid(\AppBundle\Entity\Nivel $nivelid = null)
    {
        $this->nivelid = $nivelid;

        return $this;
    }

    /**
     * Get nivelid
     *
     * @return \AppBundle\Entity\Nivel
     */
    public function getNivelid()
    {
        return $this->nivelid;
    }

    /**
     * Set tableroid
     *
     * @param \AppBundle\Entity\AdTablero $tableroid
     *
     * @return AdConfiguracion
     */
    public function setTableroid(\AppBundle\Entity\AdTablero $tableroid = null)
    {
        $this->tableroid = $tableroid;

        return $this;
    }

    /**
     * Get tableroid
     *
     * @return \AppBundle\Entity\AdTablero
     */
    public function getTableroid()
    {
        return $this->tableroid;
    }
}

