<?php

namespace AppBundle\Entity;

/**
 * CbRegistroenviocorreo
 */
class CbRegistroenviocorreo
{
    /**
     * @var \DateTime
     */
    private $fecha;

    /**
     * @var integer
     */
    private $registroenviocorreoid;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;


    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return CbRegistroenviocorreo
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Get registroenviocorreoid
     *
     * @return integer
     */
    public function getRegistroenviocorreoid()
    {
        return $this->registroenviocorreoid;
    }

    /**
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return CbRegistroenviocorreo
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
}

