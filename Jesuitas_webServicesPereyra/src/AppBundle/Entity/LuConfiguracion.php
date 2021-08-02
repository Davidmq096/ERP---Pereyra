<?php

namespace AppBundle\Entity;

/**
 * LuConfiguracion
 */
class LuConfiguracion
{
    /**
     * @var \DateTime
     */
    private $fechainicio;

    /**
     * @var \DateTime
     */
    private $fechafin;

    /**
     * @var integer
     */
    private $configuracionid;

    /**
     * @var \AppBundle\Entity\Nivel
     */
    private $nivelid;

    /**
     * @var \AppBundle\Entity\LuTipo
     */
    private $tipoid;


    /**
     * Set fechainicio
     *
     * @param \DateTime $fechainicio
     *
     * @return LuConfiguracion
     */
    public function setFechainicio($fechainicio)
    {
        $this->fechainicio = $fechainicio;

        return $this;
    }

    /**
     * Get fechainicio
     *
     * @return \DateTime
     */
    public function getFechainicio()
    {
        return $this->fechainicio;
    }

    /**
     * Set fechafin
     *
     * @param \DateTime $fechafin
     *
     * @return LuConfiguracion
     */
    public function setFechafin($fechafin)
    {
        $this->fechafin = $fechafin;

        return $this;
    }

    /**
     * Get fechafin
     *
     * @return \DateTime
     */
    public function getFechafin()
    {
        return $this->fechafin;
    }

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
     * Set nivelid
     *
     * @param \AppBundle\Entity\Nivel $nivelid
     *
     * @return LuConfiguracion
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
     * Set tipoid
     *
     * @param \AppBundle\Entity\LuTipo $tipoid
     *
     * @return LuConfiguracion
     */
    public function setTipoid(\AppBundle\Entity\LuTipo $tipoid = null)
    {
        $this->tipoid = $tipoid;

        return $this;
    }

    /**
     * Get tipoid
     *
     * @return \AppBundle\Entity\LuTipo
     */
    public function getTipoid()
    {
        return $this->tipoid;
    }
}

