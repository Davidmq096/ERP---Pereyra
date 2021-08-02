<?php

namespace AppBundle\Entity;

/**
 * CjDotacionfolio
 */
class CjDotacionfolio
{
    /**
     * @var string
     */
    private $prefijo;

    /**
     * @var integer
     */
    private $folioinicial;

    /**
     * @var integer
     */
    private $foliofinal;

    /**
     * @var integer
     */
    private $dotacionfolioid;

    /**
     * @var \AppBundle\Entity\CjCaja
     */
    private $cajaid;


    /**
     * Set prefijo
     *
     * @param string $prefijo
     *
     * @return CjDotacionfolio
     */
    public function setPrefijo($prefijo)
    {
        $this->prefijo = $prefijo;

        return $this;
    }

    /**
     * Get prefijo
     *
     * @return string
     */
    public function getPrefijo()
    {
        return $this->prefijo;
    }

    /**
     * Set folioinicial
     *
     * @param integer $folioinicial
     *
     * @return CjDotacionfolio
     */
    public function setFolioinicial($folioinicial)
    {
        $this->folioinicial = $folioinicial;

        return $this;
    }

    /**
     * Get folioinicial
     *
     * @return integer
     */
    public function getFolioinicial()
    {
        return $this->folioinicial;
    }

    /**
     * Set foliofinal
     *
     * @param integer $foliofinal
     *
     * @return CjDotacionfolio
     */
    public function setFoliofinal($foliofinal)
    {
        $this->foliofinal = $foliofinal;

        return $this;
    }

    /**
     * Get foliofinal
     *
     * @return integer
     */
    public function getFoliofinal()
    {
        return $this->foliofinal;
    }

    /**
     * Get dotacionfolioid
     *
     * @return integer
     */
    public function getDotacionfolioid()
    {
        return $this->dotacionfolioid;
    }

    /**
     * Set cajaid
     *
     * @param \AppBundle\Entity\CjCaja $cajaid
     *
     * @return CjDotacionfolio
     */
    public function setCajaid(\AppBundle\Entity\CjCaja $cajaid = null)
    {
        $this->cajaid = $cajaid;

        return $this;
    }

    /**
     * Get cajaid
     *
     * @return \AppBundle\Entity\CjCaja
     */
    public function getCajaid()
    {
        return $this->cajaid;
    }
}

