<?php

namespace AppBundle\Entity;

/**
 * CeIdiomacertificacion
 */
class CeIdiomacertificacion
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var integer
     */
    private $idiomaid;

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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeIdiomacertificacion
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
     * Set idiomaid
     *
     * @param integer $idiomaid
     *
     * @return CeIdiomacertificacion
     */
    public function setIdiomaid($idiomaid)
    {
        $this->idiomaid = $idiomaid;

        return $this;
    }

    /**
     * Get idiomaid
     *
     * @return integer
     */
    public function getIdiomaid()
    {
        return $this->idiomaid;
    }

    /**
     * Set tipovigencia
     *
     * @param integer $tipovigencia
     *
     * @return CeIdiomacertificacion
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
     * @return CeIdiomacertificacion
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
}

