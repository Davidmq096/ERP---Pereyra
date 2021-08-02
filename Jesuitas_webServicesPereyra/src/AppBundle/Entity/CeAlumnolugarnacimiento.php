<?php

namespace AppBundle\Entity;

/**
 * CeAlumnolugarnacimiento
 */
class CeAlumnolugarnacimiento
{
    /**
     * @var integer
     */
    private $alumnolugarnacimientoid;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;

    /**
     * @var \AppBundle\Entity\Estado
     */
    private $estadoid;

    /**
     * @var \AppBundle\Entity\Municipio
     */
    private $municipioid;

    /**
     * @var \AppBundle\Entity\Pais
     */
    private $paisid;


    /**
     * Get alumnolugarnacimientoid
     *
     * @return integer
     */
    public function getAlumnolugarnacimientoid()
    {
        return $this->alumnolugarnacimientoid;
    }

    /**
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return CeAlumnolugarnacimiento
     */
    public function setAlumnoid(\AppBundle\Entity\CeAlumno $alumnoid = null)
    {
        $this->alumnoid = $alumnoid;

        return $this;
    }

    /**
     * Get alumnoid
     *
     * @return \AppBundle\Entity\CeAlumno
     */
    public function getAlumnoid()
    {
        return $this->alumnoid;
    }

    /**
     * Set estadoid
     *
     * @param \AppBundle\Entity\Estado $estadoid
     *
     * @return CeAlumnolugarnacimiento
     */
    public function setEstadoid(\AppBundle\Entity\Estado $estadoid = null)
    {
        $this->estadoid = $estadoid;

        return $this;
    }

    /**
     * Get estadoid
     *
     * @return \AppBundle\Entity\Estado
     */
    public function getEstadoid()
    {
        return $this->estadoid;
    }

    /**
     * Set municipioid
     *
     * @param \AppBundle\Entity\Municipio $municipioid
     *
     * @return CeAlumnolugarnacimiento
     */
    public function setMunicipioid(\AppBundle\Entity\Municipio $municipioid = null)
    {
        $this->municipioid = $municipioid;

        return $this;
    }

    /**
     * Get municipioid
     *
     * @return \AppBundle\Entity\Municipio
     */
    public function getMunicipioid()
    {
        return $this->municipioid;
    }

    /**
     * Set paisid
     *
     * @param \AppBundle\Entity\Pais $paisid
     *
     * @return CeAlumnolugarnacimiento
     */
    public function setPaisid(\AppBundle\Entity\Pais $paisid = null)
    {
        $this->paisid = $paisid;

        return $this;
    }

    /**
     * Get paisid
     *
     * @return \AppBundle\Entity\Pais
     */
    public function getPaisid()
    {
        return $this->paisid;
    }
}

