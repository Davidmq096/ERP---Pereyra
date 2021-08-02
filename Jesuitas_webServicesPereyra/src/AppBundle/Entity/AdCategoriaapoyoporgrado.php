<?php

namespace AppBundle\Entity;

/**
 * AdCategoriaapoyoporgrado
 */
class AdCategoriaapoyoporgrado
{
    /**
     * @var integer
     */
    private $categoriaapoyoporgradoid;

    /**
     * @var \AppBundle\Entity\AdCategoriaapoyo
     */
    private $categoriaapoyoid;

    /**
     * @var \AppBundle\Entity\Grado
     */
    private $gradoid;


    /**
     * Get categoriaapoyoporgradoid
     *
     * @return integer
     */
    public function getCategoriaapoyoporgradoid()
    {
        return $this->categoriaapoyoporgradoid;
    }

    /**
     * Set categoriaapoyoid
     *
     * @param \AppBundle\Entity\AdCategoriaapoyo $categoriaapoyoid
     *
     * @return AdCategoriaapoyoporgrado
     */
    public function setCategoriaapoyoid(\AppBundle\Entity\AdCategoriaapoyo $categoriaapoyoid = null)
    {
        $this->categoriaapoyoid = $categoriaapoyoid;

        return $this;
    }

    /**
     * Get categoriaapoyoid
     *
     * @return \AppBundle\Entity\AdCategoriaapoyo
     */
    public function getCategoriaapoyoid()
    {
        return $this->categoriaapoyoid;
    }

    /**
     * Set gradoid
     *
     * @param \AppBundle\Entity\Grado $gradoid
     *
     * @return AdCategoriaapoyoporgrado
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

