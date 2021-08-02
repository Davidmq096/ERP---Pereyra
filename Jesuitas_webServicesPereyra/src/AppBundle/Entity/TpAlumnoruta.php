<?php

namespace AppBundle\Entity;

/**
 * TpAlumnoruta
 */
class TpAlumnoruta
{
    /**
     * @var integer
     */
    private $alumnorutaid;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;

    /**
     * @var \AppBundle\Entity\TpContrato
     */
    private $contratoid;

    /**
     * @var \AppBundle\Entity\TpRuta
     */
    private $rutaid;


    /**
     * Get alumnorutaid
     *
     * @return integer
     */
    public function getAlumnorutaid()
    {
        return $this->alumnorutaid;
    }

    /**
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return TpAlumnoruta
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
     * Set contratoid
     *
     * @param \AppBundle\Entity\TpContrato $contratoid
     *
     * @return TpAlumnoruta
     */
    public function setContratoid(\AppBundle\Entity\TpContrato $contratoid = null)
    {
        $this->contratoid = $contratoid;

        return $this;
    }

    /**
     * Get contratoid
     *
     * @return \AppBundle\Entity\TpContrato
     */
    public function getContratoid()
    {
        return $this->contratoid;
    }

    /**
     * Set rutaid
     *
     * @param \AppBundle\Entity\TpRuta $rutaid
     *
     * @return TpAlumnoruta
     */
    public function setRutaid(\AppBundle\Entity\TpRuta $rutaid = null)
    {
        $this->rutaid = $rutaid;

        return $this;
    }

    /**
     * Get rutaid
     *
     * @return \AppBundle\Entity\TpRuta
     */
    public function getRutaid()
    {
        return $this->rutaid;
    }
}

