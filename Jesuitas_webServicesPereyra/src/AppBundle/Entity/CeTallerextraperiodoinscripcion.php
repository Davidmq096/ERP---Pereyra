<?php

namespace AppBundle\Entity;

/**
 * CeTallerextraperiodoinscripcion
 */
class CeTallerextraperiodoinscripcion
{
    /**
     * @var \DateTime
     */
    private $fechainicio;

    /**
     * @var \DateTime
     */
    private $fechafin;

    /**
     * @var integer
     */
    private $tallerextraperiodoinscripcionid;

    /**
     * @var \AppBundle\Entity\CeSemestre
     */
    private $semestreid;

    /**
     * @var \AppBundle\Entity\Nivel
     */
    private $nivelid;

    /**
     * @var \AppBundle\Entity\CeTallerextraperiodoinscripciontipo
     */
    private $tallerextraperiodoinscripciontipoid;


    /**
     * Set fechainicio
     *
     * @param \DateTime $fechainicio
     *
     * @return CeTallerextraperiodoinscripcion
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
     * @return CeTallerextraperiodoinscripcion
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
     * Get tallerextraperiodoinscripcionid
     *
     * @return integer
     */
    public function getTallerextraperiodoinscripcionid()
    {
        return $this->tallerextraperiodoinscripcionid;
    }

    /**
     * Set semestreid
     *
     * @param \AppBundle\Entity\CeSemestre $semestreid
     *
     * @return CeTallerextraperiodoinscripcion
     */
    public function setSemestreid(\AppBundle\Entity\CeSemestre $semestreid = null)
    {
        $this->semestreid = $semestreid;

        return $this;
    }

    /**
     * Get semestreid
     *
     * @return \AppBundle\Entity\CeSemestre
     */
    public function getSemestreid()
    {
        return $this->semestreid;
    }

    /**
     * Set nivelid
     *
     * @param \AppBundle\Entity\Nivel $nivelid
     *
     * @return CeTallerextraperiodoinscripcion
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
     * Set tallerextraperiodoinscripciontipoid
     *
     * @param \AppBundle\Entity\CeTallerextraperiodoinscripciontipo $tallerextraperiodoinscripciontipoid
     *
     * @return CeTallerextraperiodoinscripcion
     */
    public function setTallerextraperiodoinscripciontipoid(\AppBundle\Entity\CeTallerextraperiodoinscripciontipo $tallerextraperiodoinscripciontipoid = null)
    {
        $this->tallerextraperiodoinscripciontipoid = $tallerextraperiodoinscripciontipoid;

        return $this;
    }

    /**
     * Get tallerextraperiodoinscripciontipoid
     *
     * @return \AppBundle\Entity\CeTallerextraperiodoinscripciontipo
     */
    public function getTallerextraperiodoinscripciontipoid()
    {
        return $this->tallerextraperiodoinscripciontipoid;
    }
}

