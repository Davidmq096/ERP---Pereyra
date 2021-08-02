<?php

namespace AppBundle\Entity;

/**
 * CeCriterioporidiomacertificacion
 */
class CeCriterioporidiomacertificacion
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var integer
     */
    private $criterioporidiomacertificacionid;

    /**
     * @var \AppBundle\Entity\CeIdiomacertificacion
     */
    private $idiomacertificacionid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeCriterioporidiomacertificacion
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Get criterioporidiomacertificacionid
     *
     * @return integer
     */
    public function getCriterioporidiomacertificacionid()
    {
        return $this->criterioporidiomacertificacionid;
    }

    /**
     * Set idiomacertificacionid
     *
     * @param \AppBundle\Entity\CeIdiomacertificacion $idiomacertificacionid
     *
     * @return CeCriterioporidiomacertificacion
     */
    public function setIdiomacertificacionid(\AppBundle\Entity\CeIdiomacertificacion $idiomacertificacionid = null)
    {
        $this->idiomacertificacionid = $idiomacertificacionid;

        return $this;
    }

    /**
     * Get idiomacertificacionid
     *
     * @return \AppBundle\Entity\CeIdiomacertificacion
     */
    public function getIdiomacertificacionid()
    {
        return $this->idiomacertificacionid;
    }
}

