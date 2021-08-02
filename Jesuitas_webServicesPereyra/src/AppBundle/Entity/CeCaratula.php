<?php

namespace AppBundle\Entity;

/**
 * CeCaratula
 */
class CeCaratula
{
    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var boolean
     */
    private $criterioevaluacion;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var integer
     */
    private $caratulaid;

    /**
     * @var \AppBundle\Entity\CeProfesorpormateriaplanestudios
     */
    private $profesorpormateriaplanestudiosid;


    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CeCaratula
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
     * Set criterioevaluacion
     *
     * @param boolean $criterioevaluacion
     *
     * @return CeCaratula
     */
    public function setCriterioevaluacion($criterioevaluacion)
    {
        $this->criterioevaluacion = $criterioevaluacion;

        return $this;
    }

    /**
     * Get criterioevaluacion
     *
     * @return boolean
     */
    public function getCriterioevaluacion()
    {
        return $this->criterioevaluacion;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return CeCaratula
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Get caratulaid
     *
     * @return integer
     */
    public function getCaratulaid()
    {
        return $this->caratulaid;
    }

    /**
     * Set profesorpormateriaplanestudiosid
     *
     * @param \AppBundle\Entity\CeProfesorpormateriaplanestudios $profesorpormateriaplanestudiosid
     *
     * @return CeCaratula
     */
    public function setProfesorpormateriaplanestudiosid(\AppBundle\Entity\CeProfesorpormateriaplanestudios $profesorpormateriaplanestudiosid = null)
    {
        $this->profesorpormateriaplanestudiosid = $profesorpormateriaplanestudiosid;

        return $this;
    }

    /**
     * Get profesorpormateriaplanestudiosid
     *
     * @return \AppBundle\Entity\CeProfesorpormateriaplanestudios
     */
    public function getProfesorpormateriaplanestudiosid()
    {
        return $this->profesorpormateriaplanestudiosid;
    }
}

