<?php

namespace AppBundle\Entity;

/**
 * CeCertificacion
 */
class CeCertificacion
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var integer
     */
    private $tipovigencia;

    /**
     * @var integer
     */
    private $anovigencia;

    /**
     * @var integer
     */
    private $certificacionid;

    /**
     * @var \AppBundle\Entity\CeIdioma
     */
    private $idiomaid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeCertificacion
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
     * Set tipovigencia
     *
     * @param integer $tipovigencia
     *
     * @return CeCertificacion
     */
    public function setTipovigencia($tipovigencia)
    {
        $this->tipovigencia = $tipovigencia;

        return $this;
    }

    /**
     * Get tipovigencia
     *
     * @return integer
     */
    public function getTipovigencia()
    {
        return $this->tipovigencia;
    }

    /**
     * Set anovigencia
     *
     * @param integer $anovigencia
     *
     * @return CeCertificacion
     */
    public function setAnovigencia($anovigencia)
    {
        $this->anovigencia = $anovigencia;

        return $this;
    }

    /**
     * Get anovigencia
     *
     * @return integer
     */
    public function getAnovigencia()
    {
        return $this->anovigencia;
    }

    /**
     * Get certificacionid
     *
     * @return integer
     */
    public function getCertificacionid()
    {
        return $this->certificacionid;
    }

    /**
     * Set idiomaid
     *
     * @param \AppBundle\Entity\CeIdioma $idiomaid
     *
     * @return CeCertificacion
     */
    public function setIdiomaid(\AppBundle\Entity\CeIdioma $idiomaid = null)
    {
        $this->idiomaid = $idiomaid;

        return $this;
    }

    /**
     * Get idiomaid
     *
     * @return \AppBundle\Entity\CeIdioma
     */
    public function getIdiomaid()
    {
        return $this->idiomaid;
    }
}

