<?php

namespace AppBundle\Entity;

/**
 * Colorpornivel
 */
class Colorpornivel
{
    /**
     * @var string
     */
    private $color;

    /**
     * @var integer
     */
    private $colorpornivelid;

    /**
     * @var \AppBundle\Entity\Nivel
     */
    private $nivelid;


    /**
     * Set color
     *
     * @param string $color
     *
     * @return Colorpornivel
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Get colorpornivelid
     *
     * @return integer
     */
    public function getColorpornivelid()
    {
        return $this->colorpornivelid;
    }

    /**
     * Set nivelid
     *
     * @param \AppBundle\Entity\Nivel $nivelid
     *
     * @return Colorpornivel
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
}

