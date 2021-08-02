<?php

namespace AppBundle\Entity;

/**
 * Lugar
 */
class Lugar
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var integer
     */
    private $cupo;

    /**
     * @var boolean
     */
    private $equipocomputo;

    /**
     * @var integer
     */
    private $equipocantidad;

    /**
     * @var boolean
     */
    private $proyector;

    /**
     * @var boolean
     */
    private $internet;

    /**
     * @var boolean
     */
    private $activo = '1';

    /**
     * @var integer
     */
    private $lugarid;

    /**
     * @var \AppBundle\Entity\Edificio
     */
    private $edificioid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Lugar
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
     * Set cupo
     *
     * @param integer $cupo
     *
     * @return Lugar
     */
    public function setCupo($cupo)
    {
        $this->cupo = $cupo;

        return $this;
    }

    /**
     * Get cupo
     *
     * @return integer
     */
    public function getCupo()
    {
        return $this->cupo;
    }

    /**
     * Set equipocomputo
     *
     * @param boolean $equipocomputo
     *
     * @return Lugar
     */
    public function setEquipocomputo($equipocomputo)
    {
        $this->equipocomputo = $equipocomputo;

        return $this;
    }

    /**
     * Get equipocomputo
     *
     * @return boolean
     */
    public function getEquipocomputo()
    {
        return $this->equipocomputo;
    }

    /**
     * Set equipocantidad
     *
     * @param integer $equipocantidad
     *
     * @return Lugar
     */
    public function setEquipocantidad($equipocantidad)
    {
        $this->equipocantidad = $equipocantidad;

        return $this;
    }

    /**
     * Get equipocantidad
     *
     * @return integer
     */
    public function getEquipocantidad()
    {
        return $this->equipocantidad;
    }

    /**
     * Set proyector
     *
     * @param boolean $proyector
     *
     * @return Lugar
     */
    public function setProyector($proyector)
    {
        $this->proyector = $proyector;

        return $this;
    }

    /**
     * Get proyector
     *
     * @return boolean
     */
    public function getProyector()
    {
        return $this->proyector;
    }

    /**
     * Set internet
     *
     * @param boolean $internet
     *
     * @return Lugar
     */
    public function setInternet($internet)
    {
        $this->internet = $internet;

        return $this;
    }

    /**
     * Get internet
     *
     * @return boolean
     */
    public function getInternet()
    {
        return $this->internet;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Lugar
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
     * Get lugarid
     *
     * @return integer
     */
    public function getLugarid()
    {
        return $this->lugarid;
    }

    /**
     * Set edificioid
     *
     * @param \AppBundle\Entity\Edificio $edificioid
     *
     * @return Lugar
     */
    public function setEdificioid(\AppBundle\Entity\Edificio $edificioid = null)
    {
        $this->edificioid = $edificioid;

        return $this;
    }

    /**
     * Get edificioid
     *
     * @return \AppBundle\Entity\Edificio
     */
    public function getEdificioid()
    {
        return $this->edificioid;
    }
}

