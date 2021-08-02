<?php

namespace AppBundle\Entity;

/**
 * IdecPonderacionadmision
 */
class IdecPonderacionadmision
{
    /**
     * @var string
     */
    private $rubro;

    /**
     * @var float
     */
    private $valor;

    /**
     * @var integer
     */
    private $ponderacionadmisionid;

    /**
     * @var \AppBundle\Entity\IdecTiporubro
     */
    private $tiporubroid;


    /**
     * Set rubro
     *
     * @param string $rubro
     *
     * @return IdecPonderacionadmision
     */
    public function setRubro($rubro)
    {
        $this->rubro = $rubro;

        return $this;
    }

    /**
     * Get rubro
     *
     * @return string
     */
    public function getRubro()
    {
        return $this->rubro;
    }

    /**
     * Set valor
     *
     * @param float $valor
     *
     * @return IdecPonderacionadmision
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return float
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Get ponderacionadmisionid
     *
     * @return integer
     */
    public function getPonderacionadmisionid()
    {
        return $this->ponderacionadmisionid;
    }

    /**
     * Set tiporubroid
     *
     * @param \AppBundle\Entity\IdecTiporubro $tiporubroid
     *
     * @return IdecPonderacionadmision
     */
    public function setTiporubroid(\AppBundle\Entity\IdecTiporubro $tiporubroid = null)
    {
        $this->tiporubroid = $tiporubroid;

        return $this;
    }

    /**
     * Get tiporubroid
     *
     * @return \AppBundle\Entity\IdecTiporubro
     */
    public function getTiporubroid()
    {
        return $this->tiporubroid;
    }
}

