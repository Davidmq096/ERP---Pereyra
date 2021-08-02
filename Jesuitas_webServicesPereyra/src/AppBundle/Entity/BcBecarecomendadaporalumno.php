<?php

namespace AppBundle\Entity;

/**
 * BcBecarecomendadaporalumno
 */
class BcBecarecomendadaporalumno
{
    /**
     * @var string
     */
    private $becarecomendada;

    /**
     * @var integer
     */
    private $becarecomendadaporalumnoid;

    /**
     * @var \AppBundle\Entity\BcSolicitudporalumno
     */
    private $alumnosolicitudid;


    /**
     * Set becarecomendada
     *
     * @param string $becarecomendada
     *
     * @return BcBecarecomendadaporalumno
     */
    public function setBecarecomendada($becarecomendada)
    {
        $this->becarecomendada = $becarecomendada;

        return $this;
    }

    /**
     * Get becarecomendada
     *
     * @return string
     */
    public function getBecarecomendada()
    {
        return $this->becarecomendada;
    }

    /**
     * Get becarecomendadaporalumnoid
     *
     * @return integer
     */
    public function getBecarecomendadaporalumnoid()
    {
        return $this->becarecomendadaporalumnoid;
    }

    /**
     * Set alumnosolicitudid
     *
     * @param \AppBundle\Entity\BcSolicitudporalumno $alumnosolicitudid
     *
     * @return BcBecarecomendadaporalumno
     */
    public function setAlumnosolicitudid(\AppBundle\Entity\BcSolicitudporalumno $alumnosolicitudid = null)
    {
        $this->alumnosolicitudid = $alumnosolicitudid;

        return $this;
    }

    /**
     * Get alumnosolicitudid
     *
     * @return \AppBundle\Entity\BcSolicitudporalumno
     */
    public function getAlumnosolicitudid()
    {
        return $this->alumnosolicitudid;
    }
}

