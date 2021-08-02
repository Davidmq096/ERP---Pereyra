<?php

namespace AppBundle\Entity;

/**
 * Gradoporformato
 */
class Gradoporformato
{
    /**
     * @var integer
     */
    private $gradoporformatoid;

    /**
     * @var \AppBundle\Entity\Formato
     */
    private $formatoid;

    /**
     * @var \AppBundle\Entity\Grado
     */
    private $gradoid;


    /**
     * Get gradoporformatoid
     *
     * @return integer
     */
    public function getGradoporformatoid()
    {
        return $this->gradoporformatoid;
    }

    /**
     * Set formatoid
     *
     * @param \AppBundle\Entity\Formato $formatoid
     *
     * @return Gradoporformato
     */
    public function setFormatoid(\AppBundle\Entity\Formato $formatoid = null)
    {
        $this->formatoid = $formatoid;

        return $this;
    }

    /**
     * Get formatoid
     *
     * @return \AppBundle\Entity\Formato
     */
    public function getFormatoid()
    {
        return $this->formatoid;
    }

    /**
     * Set gradoid
     *
     * @param \AppBundle\Entity\Grado $gradoid
     *
     * @return Gradoporformato
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

