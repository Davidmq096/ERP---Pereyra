<?php

namespace AppBundle\Entity;

/**
 * CeAlumnoporpersonal
 */
class CeAlumnoporpersonal
{
    /**
     * @var integer
     */
    private $personaid;

    /**
     * @var integer
     */
    private $alumnopersonalid;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;


    /**
     * Set personaid
     *
     * @param integer $personaid
     *
     * @return CeAlumnoporpersonal
     */
    public function setPersonaid($personaid)
    {
        $this->personaid = $personaid;

        return $this;
    }

    /**
     * Get personaid
     *
     * @return integer
     */
    public function getPersonaid()
    {
        return $this->personaid;
    }

    /**
     * Get alumnopersonalid
     *
     * @return integer
     */
    public function getAlumnopersonalid()
    {
        return $this->alumnopersonalid;
    }

    /**
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return CeAlumnoporpersonal
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

