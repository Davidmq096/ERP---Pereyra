<?php

namespace AppBundle\Entity;

/**
 * CeProfesorpornivel
 */
class CeProfesorpornivel
{
    /**
     * @var integer
     */
    private $activo;

    /**
     * @var integer
     */
    private $profesorpornivelid;

    /**
     * @var \AppBundle\Entity\Ciclo
     */
    private $cicloid;

    /**
     * @var \AppBundle\Entity\Nivel
     */
    private $nivelid;

    /**
     * @var \AppBundle\Entity\CeProfesor
     */
    private $profesorid;


    /**
     * Set activo
     *
     * @param integer $activo
     *
     * @return CeProfesorpornivel
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return integer
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Get profesorpornivelid
     *
     * @return integer
     */
    public function getProfesorpornivelid()
    {
        return $this->profesorpornivelid;
    }

    /**
     * Set cicloid
     *
     * @param \AppBundle\Entity\Ciclo $cicloid
     *
     * @return CeProfesorpornivel
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

    /**
     * Set nivelid
     *
     * @param \AppBundle\Entity\Nivel $nivelid
     *
     * @return CeProfesorpornivel
     */
    public function setNivelid(\AppBundle\Entity\Nivel $nivelid = null)
    {
        $this->nivelid = $nivelid;

        return $this;
    }

    /**
     * Get nivelid
     *
     * @return \AppBundle\Entity\Nivel
     */
    public function getNivelid()
    {
        return $this->nivelid;
    }

    /**
     * Set profesorid
     *
     * @param \AppBundle\Entity\CeProfesor $profesorid
     *
     * @return CeProfesorpornivel
     */
    public function setProfesorid(\AppBundle\Entity\CeProfesor $profesorid = null)
    {
        $this->profesorid = $profesorid;

        return $this;
    }

    /**
     * Get profesorid
     *
     * @return \AppBundle\Entity\CeProfesor
     */
    public function getProfesorid()
    {
        return $this->profesorid;
    }
}

