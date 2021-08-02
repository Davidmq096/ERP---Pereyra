<?php

namespace AppBundle\Entity;

/**
 * Escuelaprocedencia
 */
class Escuelaprocedencia
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $municipio;

    /**
     * @var string
     */
    private $causaseparacion;

    /**
     * @var string
     */
    private $seccion;

    /**
     * @var string
     */
    private $gradoinicio;

    /**
     * @var string
     */
    private $gradofin;

    /**
     * @var string
     */
    private $matricula;

    /**
     * @var integer
     */
    private $escuelaprocedenciaid;

    /**
     * @var \AppBundle\Entity\Escuelajesuita
     */
    private $escuelajesuitaid;

    /**
     * @var \AppBundle\Entity\Datoaspirante
     */
    private $datoaspiranteid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Escuelaprocedencia
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
     * Set municipio
     *
     * @param string $municipio
     *
     * @return Escuelaprocedencia
     */
    public function setMunicipio($municipio)
    {
        $this->municipio = $municipio;

        return $this;
    }

    /**
     * Get municipio
     *
     * @return string
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }

    /**
     * Set causaseparacion
     *
     * @param string $causaseparacion
     *
     * @return Escuelaprocedencia
     */
    public function setCausaseparacion($causaseparacion)
    {
        $this->causaseparacion = $causaseparacion;

        return $this;
    }

    /**
     * Get causaseparacion
     *
     * @return string
     */
    public function getCausaseparacion()
    {
        return $this->causaseparacion;
    }

    /**
     * Set seccion
     *
     * @param string $seccion
     *
     * @return Escuelaprocedencia
     */
    public function setSeccion($seccion)
    {
        $this->seccion = $seccion;

        return $this;
    }

    /**
     * Get seccion
     *
     * @return string
     */
    public function getSeccion()
    {
        return $this->seccion;
    }

    /**
     * Set gradoinicio
     *
     * @param string $gradoinicio
     *
     * @return Escuelaprocedencia
     */
    public function setGradoinicio($gradoinicio)
    {
        $this->gradoinicio = $gradoinicio;

        return $this;
    }

    /**
     * Get gradoinicio
     *
     * @return string
     */
    public function getGradoinicio()
    {
        return $this->gradoinicio;
    }

    /**
     * Set gradofin
     *
     * @param string $gradofin
     *
     * @return Escuelaprocedencia
     */
    public function setGradofin($gradofin)
    {
        $this->gradofin = $gradofin;

        return $this;
    }

    /**
     * Get gradofin
     *
     * @return string
     */
    public function getGradofin()
    {
        return $this->gradofin;
    }

    /**
     * Set matricula
     *
     * @param string $matricula
     *
     * @return Escuelaprocedencia
     */
    public function setMatricula($matricula)
    {
        $this->matricula = $matricula;

        return $this;
    }

    /**
     * Get matricula
     *
     * @return string
     */
    public function getMatricula()
    {
        return $this->matricula;
    }

    /**
     * Get escuelaprocedenciaid
     *
     * @return integer
     */
    public function getEscuelaprocedenciaid()
    {
        return $this->escuelaprocedenciaid;
    }

    /**
     * Set escuelajesuitaid
     *
     * @param \AppBundle\Entity\Escuelajesuita $escuelajesuitaid
     *
     * @return Escuelaprocedencia
     */
    public function setEscuelajesuitaid(\AppBundle\Entity\Escuelajesuita $escuelajesuitaid = null)
    {
        $this->escuelajesuitaid = $escuelajesuitaid;

        return $this;
    }

    /**
     * Get escuelajesuitaid
     *
     * @return \AppBundle\Entity\Escuelajesuita
     */
    public function getEscuelajesuitaid()
    {
        return $this->escuelajesuitaid;
    }

    /**
     * Set datoaspiranteid
     *
     * @param \AppBundle\Entity\Datoaspirante $datoaspiranteid
     *
     * @return Escuelaprocedencia
     */
    public function setDatoaspiranteid(\AppBundle\Entity\Datoaspirante $datoaspiranteid = null)
    {
        $this->datoaspiranteid = $datoaspiranteid;

        return $this;
    }

    /**
     * Get datoaspiranteid
     *
     * @return \AppBundle\Entity\Datoaspirante
     */
    public function getDatoaspiranteid()
    {
        return $this->datoaspiranteid;
    }
}

