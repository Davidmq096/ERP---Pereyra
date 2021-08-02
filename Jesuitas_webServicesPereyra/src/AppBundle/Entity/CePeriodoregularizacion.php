<?php

namespace AppBundle\Entity;

/**
 * CePeriodoregularizacion
 */
class CePeriodoregularizacion
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var \DateTime
     */
    private $fechainicio;

    /**
     * @var \DateTime
     */
    private $fechafin;

    /**
     * @var boolean
     */
    private $permitecursos;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var \DateTime
     */
    private $fechalimiteasignacion;

    /**
     * @var integer
     */
    private $periodoregularizacionid;

    /**
     * @var \AppBundle\Entity\Ciclo
     */
    private $cicloid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CePeriodoregularizacion
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
     * Set fechainicio
     *
     * @param \DateTime $fechainicio
     *
     * @return CePeriodoregularizacion
     */
    public function setFechainicio($fechainicio)
    {
        $this->fechainicio = $fechainicio;

        return $this;
    }

    /**
     * Get fechainicio
     *
     * @return \DateTime
     */
    public function getFechainicio()
    {
        return $this->fechainicio;
    }

    /**
     * Set fechafin
     *
     * @param \DateTime $fechafin
     *
     * @return CePeriodoregularizacion
     */
    public function setFechafin($fechafin)
    {
        $this->fechafin = $fechafin;

        return $this;
    }

    /**
     * Get fechafin
     *
     * @return \DateTime
     */
    public function getFechafin()
    {
        return $this->fechafin;
    }

    /**
     * Set permitecursos
     *
     * @param boolean $permitecursos
     *
     * @return CePeriodoregularizacion
     */
    public function setPermitecursos($permitecursos)
    {
        $this->permitecursos = $permitecursos;

        return $this;
    }

    /**
     * Get permitecursos
     *
     * @return boolean
     */
    public function getPermitecursos()
    {
        return $this->permitecursos;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CePeriodoregularizacion
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
     * Set fechalimiteasignacion
     *
     * @param \DateTime $fechalimiteasignacion
     *
     * @return CePeriodoregularizacion
     */
    public function setFechalimiteasignacion($fechalimiteasignacion)
    {
        $this->fechalimiteasignacion = $fechalimiteasignacion;

        return $this;
    }

    /**
     * Get fechalimiteasignacion
     *
     * @return \DateTime
     */
    public function getFechalimiteasignacion()
    {
        return $this->fechalimiteasignacion;
    }

    /**
     * Get periodoregularizacionid
     *
     * @return integer
     */
    public function getPeriodoregularizacionid()
    {
        return $this->periodoregularizacionid;
    }

    /**
     * Set cicloid
     *
     * @param \AppBundle\Entity\Ciclo $cicloid
     *
     * @return CePeriodoregularizacion
     */
    public function setCicloid(\AppBundle\Entity\Ciclo $cicloid = null)
    {
        $this->cicloid = $cicloid;

        return $this;
    }

    /**
     * Get cicloid
     *
     * @return \AppBundle\Entity\Ciclo
     */
    public function getCicloid()
    {
        return $this->cicloid;
    }
}

