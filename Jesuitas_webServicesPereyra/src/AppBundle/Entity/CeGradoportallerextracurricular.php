<?php

namespace AppBundle\Entity;

/**
 * CeGradoportallerextracurricular
 */
class CeGradoportallerextracurricular
{
    /**
     * @var integer
     */
    private $gradoportallerextracurricularid;

    /**
     * @var \AppBundle\Entity\CeTallerextracurricular
     */
    private $tallerextracurricularid;

    /**
     * @var \AppBundle\Entity\Grado
     */
    private $gradoid;


    /**
     * Get gradoportallerextracurricularid
     *
     * @return integer
     */
    public function getGradoportallerextracurricularid()
    {
        return $this->gradoportallerextracurricularid;
    }

    /**
     * Set tallerextracurricularid
     *
     * @param \AppBundle\Entity\CeTallerextracurricular $tallerextracurricularid
     *
     * @return CeGradoportallerextracurricular
     */
    public function setTallerextracurricularid(\AppBundle\Entity\CeTallerextracurricular $tallerextracurricularid = null)
    {
        $this->tallerextracurricularid = $tallerextracurricularid;

        return $this;
    }

    /**
     * Get tallerextracurricularid
     *
     * @return \AppBundle\Entity\CeTallerextracurricular
     */
    public function getTallerextracurricularid()
    {
        return $this->tallerextracurricularid;
    }

    /**
     * Set gradoid
     *
     * @param \AppBundle\Entity\Grado $gradoid
     *
     * @return CeGradoportallerextracurricular
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

