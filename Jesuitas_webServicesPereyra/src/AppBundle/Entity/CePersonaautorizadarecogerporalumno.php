<?php

namespace AppBundle\Entity;

/**
 * CePersonaautorizadarecogerporalumno
 */
class CePersonaautorizadarecogerporalumno
{
    /**
     * @var integer
     */
    private $personaautorizadarecogerporalumnoid;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;

    /**
     * @var \AppBundle\Entity\CePersonaautorizadarecoger
     */
    private $personaautorizadarecogerid;


    /**
     * Get personaautorizadarecogerporalumnoid
     *
     * @return integer
     */
    public function getPersonaautorizadarecogerporalumnoid()
    {
        return $this->personaautorizadarecogerporalumnoid;
    }

    /**
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return CePersonaautorizadarecogerporalumno
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
     * Set personaautorizadarecogerid
     *
     * @param \AppBundle\Entity\CePersonaautorizadarecoger $personaautorizadarecogerid
     *
     * @return CePersonaautorizadarecogerporalumno
     */
    public function setPersonaautorizadarecogerid(\AppBundle\Entity\CePersonaautorizadarecoger $personaautorizadarecogerid = null)
    {
        $this->personaautorizadarecogerid = $personaautorizadarecogerid;

        return $this;
    }

    /**
     * Get personaautorizadarecogerid
     *
     * @return \AppBundle\Entity\CePersonaautorizadarecoger
     */
    public function getPersonaautorizadarecogerid()
    {
        return $this->personaautorizadarecogerid;
    }
}

