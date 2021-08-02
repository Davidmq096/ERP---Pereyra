<?php

namespace AppBundle\Entity;

/**
 * CeEventopornivel
 */
class CeEventopornivel
{
    /**
     * @var integer
     */
    private $eventopornivelid;

    /**
     * @var \AppBundle\Entity\CeEvento
     */
    private $eventoid;

    /**
     * @var \AppBundle\Entity\Nivel
     */
    private $nivelid;


    /**
     * Get eventopornivelid
     *
     * @return integer
     */
    public function getEventopornivelid()
    {
        return $this->eventopornivelid;
    }

    /**
     * Set eventoid
     *
     * @param \AppBundle\Entity\CeEvento $eventoid
     *
     * @return CeEventopornivel
     */
    public function setEventoid(\AppBundle\Entity\CeEvento $eventoid = null)
    {
        $this->eventoid = $eventoid;

        return $this;
    }

    /**
     * Get eventoid
     *
     * @return \AppBundle\Entity\CeEvento
     */
    public function getEventoid()
    {
        return $this->eventoid;
    }

    /**
     * Set nivelid
     *
     * @param \AppBundle\Entity\Nivel $nivelid
     *
     * @return CeEventopornivel
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

