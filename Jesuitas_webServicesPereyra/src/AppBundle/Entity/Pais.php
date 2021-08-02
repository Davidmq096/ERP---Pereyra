<?php

namespace AppBundle\Entity;

/**
 * Pais
 */
class Pais
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $sigla3;

    /**
     * @var string
     */
    private $sigla2;

    /**
     * @var boolean
     */
    private $activo = '1';

    /**
     * @var integer
     */
    private $paisid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Pais
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
     * Set sigla3
     *
     * @param string $sigla3
     *
     * @return Pais
     */
    public function setSigla3($sigla3)
    {
        $this->sigla3 = $sigla3;

        return $this;
    }

    /**
     * Get sigla3
     *
     * @return string
     */
    public function getSigla3()
    {
        return $this->sigla3;
    }

    /**
     * Set sigla2
     *
     * @param string $sigla2
     *
     * @return Pais
     */
    public function setSigla2($sigla2)
    {
        $this->sigla2 = $sigla2;

        return $this;
    }

    /**
     * Get sigla2
     *
     * @return string
     */
    public function getSigla2()
    {
        return $this->sigla2;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Pais
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Get paisid
     *
     * @return integer
     */
    public function getPaisid()
    {
        return $this->paisid;
    }
}

