<?php

namespace AppBundle\Entity;

/**
 * Paisadmisionextranjero
 */
class Paisadmisionextranjero
{
    /**
     * @var integer
     */
    private $paisadmisionextranjero;

    /**
     * @var \AppBundle\Entity\Pais
     */
    private $paisid;

    /**
     * @var \AppBundle\Entity\Solicitudadmision
     */
    private $solicitudadmisionid;


    /**
     * Get paisadmisionextranjero
     *
     * @return integer
     */
    public function getPaisadmisionextranjero()
    {
        return $this->paisadmisionextranjero;
    }

    /**
     * Set paisid
     *
     * @param \AppBundle\Entity\Pais $paisid
     *
     * @return Paisadmisionextranjero
     */
    public function setPaisid(\AppBundle\Entity\Pais $paisid = null)
    {
        $this->paisid = $paisid;

        return $this;
    }

    /**
     * Get paisid
     *
     * @return \AppBundle\Entity\Pais
     */
    public function getPaisid()
    {
        return $this->paisid;
    }

    /**
     * Set solicitudadmisionid
     *
     * @param \AppBundle\Entity\Solicitudadmision $solicitudadmisionid
     *
     * @return Paisadmisionextranjero
     */
    public function setSolicitudadmisionid(\AppBundle\Entity\Solicitudadmision $solicitudadmisionid = null)
    {
        $this->solicitudadmisionid = $solicitudadmisionid;

        return $this;
    }

    /**
     * Get solicitudadmisionid
     *
     * @return \AppBundle\Entity\Solicitudadmision
     */
    public function getSolicitudadmisionid()
    {
        return $this->solicitudadmisionid;
    }
}

