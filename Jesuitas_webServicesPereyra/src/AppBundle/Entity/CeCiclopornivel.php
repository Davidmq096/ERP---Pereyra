<?php

namespace AppBundle\Entity;

/**
 * CeCiclopornivel
 */
class CeCiclopornivel
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
     * @var \DateTime
     */
    private $fechainicios1;

    /**
     * @var \DateTime
     */
    private $fechafins1;

    /**
     * @var \DateTime
     */
    private $fechainicios2;

    /**
     * @var \DateTime
     */
    private $fechafins2;

    /**
     * @var integer
     */
    private $ciclopornivelid;

    /**
     * @var \AppBundle\Entity\Nivel
     */
    private $nivelid;

    /**
     * @var \AppBundle\Entity\Ciclo
     */
    private $cicloid;


    /**
     * Set fechainicio
     *
     * @param \DateTime $fechainicio
     *
     * @return CeCiclopornivel
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
     * @return CeCiclopornivel
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
     * Set fechainicios1
     *
     * @param \DateTime $fechainicios1
     *
     * @return CeCiclopornivel
     */
    public function setFechainicios1($fechainicios1)
    {
        $this->fechainicios1 = $fechainicios1;

        return $this;
    }

    /**
     * Get fechainicios1
     *
     * @return \DateTime
     */
    public function getFechainicios1()
    {
        return $this->fechainicios1;
    }

    /**
     * Set fechafins1
     *
     * @param \DateTime $fechafins1
     *
     * @return CeCiclopornivel
     */
    public function setFechafins1($fechafins1)
    {
        $this->fechafins1 = $fechafins1;

        return $this;
    }

    /**
     * Get fechafins1
     *
     * @return \DateTime
     */
    public function getFechafins1()
    {
        return $this->fechafins1;
    }

    /**
     * Set fechainicios2
     *
     * @param \DateTime $fechainicios2
     *
     * @return CeCiclopornivel
     */
    public function setFechainicios2($fechainicios2)
    {
        $this->fechainicios2 = $fechainicios2;

        return $this;
    }

    /**
     * Get fechainicios2
     *
     * @return \DateTime
     */
    public function getFechainicios2()
    {
        return $this->fechainicios2;
    }

    /**
     * Set fechafins2
     *
     * @param \DateTime $fechafins2
     *
     * @return CeCiclopornivel
     */
    public function setFechafins2($fechafins2)
    {
        $this->fechafins2 = $fechafins2;

        return $this;
    }

    /**
     * Get fechafins2
     *
     * @return \DateTime
     */
    public function getFechafins2()
    {
        return $this->fechafins2;
    }

    /**
     * Get ciclopornivelid
     *
     * @return integer
     */
    public function getCiclopornivelid()
    {
        return $this->ciclopornivelid;
    }

    /**
     * Set nivelid
     *
     * @param \AppBundle\Entity\Nivel $nivelid
     *
     * @return CeCiclopornivel
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
     * Set cicloid
     *
     * @param \AppBundle\Entity\Ciclo $cicloid
     *
     * @return CeCiclopornivel
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

