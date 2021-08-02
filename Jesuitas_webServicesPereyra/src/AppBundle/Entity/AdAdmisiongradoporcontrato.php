<?php

namespace AppBundle\Entity;

/**
 * AdAdmisiongradoporcontrato
 */
class AdAdmisiongradoporcontrato
{
    /**
     * @var integer
     */
    private $gradopordocumentoid;

    /**
     * @var \AppBundle\Entity\AdAdmisioncontrato
     */
    private $contratoid;

    /**
     * @var \AppBundle\Entity\Grado
     */
    private $gradoid;


    /**
     * Get gradopordocumentoid
     *
     * @return integer
     */
    public function getGradopordocumentoid()
    {
        return $this->gradopordocumentoid;
    }

    /**
     * Set contratoid
     *
     * @param \AppBundle\Entity\AdAdmisioncontrato $contratoid
     *
     * @return AdAdmisiongradoporcontrato
     */
    public function setContratoid(\AppBundle\Entity\AdAdmisioncontrato $contratoid = null)
    {
        $this->contratoid = $contratoid;

        return $this;
    }

    /**
     * Get contratoid
     *
     * @return \AppBundle\Entity\AdAdmisioncontrato
     */
    public function getContratoid()
    {
        return $this->contratoid;
    }

    /**
     * Set gradoid
     *
     * @param \AppBundle\Entity\Grado $gradoid
     *
     * @return AdAdmisiongradoporcontrato
     */
    public function setGradoid(\AppBundle\Entity\Grado $gradoid = null)
    {
        $this->gradoid = $gradoid;

        return $this;
    }

    /**
     * Get gradoid
     *
     * @return \AppBundle\Entity\Grado
     */
    public function getGradoid()
    {
        return $this->gradoid;
    }
}

