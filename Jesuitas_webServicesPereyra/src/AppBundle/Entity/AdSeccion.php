<?php

namespace AppBundle\Entity;

/**
 * AdSeccion
 */
class AdSeccion
{
    /**
     * @var string
     */
    private $configuracion;

    /**
     * @var string
     */
    private $query;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $propiedades;

    /**
     * @var integer
     */
    private $seccionid;

    /**
     * @var \AppBundle\Entity\AdConfiguracion
     */
    private $configuracionid;


    /**
     * Set configuracion
     *
     * @param string $configuracion
     *
     * @return AdSeccion
     */
    public function setConfiguracion($configuracion)
    {
        $this->configuracion = $configuracion;

        return $this;
    }

    /**
     * Get configuracion
     *
     * @return string
     */
    public function getConfiguracion()
    {
        return $this->configuracion;
    }

    /**
     * Set query
     *
     * @param string $query
     *
     * @return AdSeccion
     */
    public function setQuery($query)
    {
        $this->query = $query;

        return $this;
    }

    /**
     * Get query
     *
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return AdSeccion
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
     * Set propiedades
     *
     * @param string $propiedades
     *
     * @return AdSeccion
     */
    public function setPropiedades($propiedades)
    {
        $this->propiedades = $propiedades;

        return $this;
    }

    /**
     * Get propiedades
     *
     * @return string
     */
    public function getPropiedades()
    {
        return $this->propiedades;
    }

    /**
     * Get seccionid
     *
     * @return integer
     */
    public function getSeccionid()
    {
        return $this->seccionid;
    }

    /**
     * Set configuracionid
     *
     * @param \AppBundle\Entity\AdConfiguracion $configuracionid
     *
     * @return AdSeccion
     */
    public function setConfiguracionid(\AppBundle\Entity\AdConfiguracion $configuracionid = null)
    {
        $this->configuracionid = $configuracionid;

        return $this;
    }

    /**
     * Get configuracionid
     *
     * @return \AppBundle\Entity\AdConfiguracion
     */
    public function getConfiguracionid()
    {
        return $this->configuracionid;
    }
}

