<?php

namespace AppBundle\Entity;

/**
 * CeBoletaporgrado
 */
class CeBoletaporgrado
{
    /**
     * @var boolean
     */
    private $oficial;

    /**
     * @var integer
     */
    private $boletaporgradoid;

    /**
     * @var \AppBundle\Entity\CeBoletas
     */
    private $boletaid;

    /**
     * @var \AppBundle\Entity\Grado
     */
    private $gradoid;


    /**
     * Set oficial
     *
     * @param boolean $oficial
     *
     * @return CeBoletaporgrado
     */
    public function setOficial($oficial)
    {
        $this->oficial = $oficial;

        return $this;
    }

    /**
     * Get oficial
     *
     * @return boolean
     */
    public function getOficial()
    {
        return $this->oficial;
    }

    /**
     * Get boletaporgradoid
     *
     * @return integer
     */
    public function getBoletaporgradoid()
    {
        return $this->boletaporgradoid;
    }

    /**
     * Set boletaid
     *
     * @param \AppBundle\Entity\CeBoletas $boletaid
     *
     * @return CeBoletaporgrado
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
     * Set gradoid
     *
     * @param \AppBundle\Entity\Grado $gradoid
     *
     * @return CeBoletaporgrado
     */
    public function setGradoid(\AppBundle\Entity\Grado $gradoid = null)
    {
        $this->gradoid = $gradoid;

        return $this;
    }

    /**
     * Get gradoid
     *
     * @return \AppBundle\Entity\Grado
     */
    public function getGradoid()
    {
        return $this->gradoid;
    }
}

