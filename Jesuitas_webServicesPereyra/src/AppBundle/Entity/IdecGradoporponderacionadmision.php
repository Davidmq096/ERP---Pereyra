<?php

namespace AppBundle\Entity;

/**
 * IdecGradoporponderacionadmision
 */
class IdecGradoporponderacionadmision
{
    /**
     * @var integer
     */
    private $gradoporponderacionadmision;

    /**
     * @var \AppBundle\Entity\IdecPonderacionadmision
     */
    private $ponderacionadmisionid;

    /**
     * @var \AppBundle\Entity\Grado
     */
    private $gradoid;


    /**
     * Get gradoporponderacionadmision
     *
     * @return integer
     */
    public function getGradoporponderacionadmision()
    {
        return $this->gradoporponderacionadmision;
    }

    /**
     * Set ponderacionadmisionid
     *
     * @param \AppBundle\Entity\IdecPonderacionadmision $ponderacionadmisionid
     *
     * @return IdecGradoporponderacionadmision
     */
    public function setPonderacionadmisionid(\AppBundle\Entity\IdecPonderacionadmision $ponderacionadmisionid = null)
    {
        $this->ponderacionadmisionid = $ponderacionadmisionid;

        return $this;
    }

    /**
     * Get ponderacionadmisionid
     *
     * @return \AppBundle\Entity\IdecPonderacionadmision
     */
    public function getPonderacionadmisionid()
    {
        return $this->ponderacionadmisionid;
    }

    /**
     * Set gradoid
     *
     * @param \AppBundle\Entity\Grado $gradoid
     *
     * @return IdecGradoporponderacionadmision
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

