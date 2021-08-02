<?php

namespace AppBundle\Entity;

/**
 * CeTallerperiodoinscripcion
 */
class CeTallerperiodoinscripcion
{
    /**
     * @var \DateTime
     */
    private $fechanuevoingresoinicio;

    /**
     * @var \DateTime
     */
    private $fechanuevoingresofin;

    /**
     * @var \DateTime
     */
    private $fechareingresoinicio;

    /**
     * @var \DateTime
     */
    private $fechareingresofin;

    /**
     * @var integer
     */
    private $tallerperiodoinscripcionid;

    /**
     * @var \AppBundle\Entity\CeClasificadorparaescolares
     */
    private $clasificadorparaescolaresid;


    /**
     * Set fechanuevoingresoinicio
     *
     * @param \DateTime $fechanuevoingresoinicio
     *
     * @return CeTallerperiodoinscripcion
     */
    public function setFechanuevoingresoinicio($fechanuevoingresoinicio)
    {
        $this->fechanuevoingresoinicio = $fechanuevoingresoinicio;

        return $this;
    }

    /**
     * Get fechanuevoingresoinicio
     *
     * @return \DateTime
     */
    public function getFechanuevoingresoinicio()
    {
        return $this->fechanuevoingresoinicio;
    }

    /**
     * Set fechanuevoingresofin
     *
     * @param \DateTime $fechanuevoingresofin
     *
     * @return CeTallerperiodoinscripcion
     */
    public function setFechanuevoingresofin($fechanuevoingresofin)
    {
        $this->fechanuevoingresofin = $fechanuevoingresofin;

        return $this;
    }

    /**
     * Get fechanuevoingresofin
     *
     * @return \DateTime
     */
    public function getFechanuevoingresofin()
    {
        return $this->fechanuevoingresofin;
    }

    /**
     * Set fechareingresoinicio
     *
     * @param \DateTime $fechareingresoinicio
     *
     * @return CeTallerperiodoinscripcion
     */
    public function setFechareingresoinicio($fechareingresoinicio)
    {
        $this->fechareingresoinicio = $fechareingresoinicio;

        return $this;
    }

    /**
     * Get fechareingresoinicio
     *
     * @return \DateTime
     */
    public function getFechareingresoinicio()
    {
        return $this->fechareingresoinicio;
    }

    /**
     * Set fechareingresofin
     *
     * @param \DateTime $fechareingresofin
     *
     * @return CeTallerperiodoinscripcion
     */
    public function setFechareingresofin($fechareingresofin)
    {
        $this->fechareingresofin = $fechareingresofin;

        return $this;
    }

    /**
     * Get fechareingresofin
     *
     * @return \DateTime
     */
    public function getFechareingresofin()
    {
        return $this->fechareingresofin;
    }

    /**
     * Get tallerperiodoinscripcionid
     *
     * @return integer
     */
    public function getTallerperiodoinscripcionid()
    {
        return $this->tallerperiodoinscripcionid;
    }

    /**
     * Set clasificadorparaescolaresid
     *
     * @param \AppBundle\Entity\CeClasificadorparaescolares $clasificadorparaescolaresid
     *
     * @return CeTallerperiodoinscripcion
     */
    public function setClasificadorparaescolaresid(\AppBundle\Entity\CeClasificadorparaescolares $clasificadorparaescolaresid = null)
    {
        $this->clasificadorparaescolaresid = $clasificadorparaescolaresid;

        return $this;
    }

    /**
     * Get clasificadorparaescolaresid
     *
     * @return \AppBundle\Entity\CeClasificadorparaescolares
     */
    public function getClasificadorparaescolaresid()
    {
        return $this->clasificadorparaescolaresid;
    }
}

