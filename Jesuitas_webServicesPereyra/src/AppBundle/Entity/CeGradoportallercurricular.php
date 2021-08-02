<?php

namespace AppBundle\Entity;

/**
 * CeGradoportallercurricular
 */
class CeGradoportallercurricular
{
    /**
     * @var integer
     */
    private $gradoportallercurricularid;

    /**
     * @var \AppBundle\Entity\CeIdiomanivel
     */
    private $idiomanivelid;

    /**
     * @var \AppBundle\Entity\CeMateriaporplanestudios
     */
    private $materiaporplanestudioid;

    /**
     * @var \AppBundle\Entity\CeTallercurricular
     */
    private $tallercurricularid;

    /**
     * @var \AppBundle\Entity\Grado
     */
    private $gradoid;


    /**
     * Get gradoportallercurricularid
     *
     * @return integer
     */
    public function getGradoportallercurricularid()
    {
        return $this->gradoportallercurricularid;
    }

    /**
     * Set idiomanivelid
     *
     * @param \AppBundle\Entity\CeIdiomanivel $idiomanivelid
     *
     * @return CeGradoportallercurricular
     */
    public function setIdiomanivelid(\AppBundle\Entity\CeIdiomanivel $idiomanivelid = null)
    {
        $this->idiomanivelid = $idiomanivelid;

        return $this;
    }

    /**
     * Get idiomanivelid
     *
     * @return \AppBundle\Entity\CeIdiomanivel
     */
    public function getIdiomanivelid()
    {
        return $this->idiomanivelid;
    }

    /**
     * Set materiaporplanestudioid
     *
     * @param \AppBundle\Entity\CeMateriaporplanestudios $materiaporplanestudioid
     *
     * @return CeGradoportallercurricular
     */
    public function setMateriaporplanestudioid(\AppBundle\Entity\CeMateriaporplanestudios $materiaporplanestudioid = null)
    {
        $this->materiaporplanestudioid = $materiaporplanestudioid;

        return $this;
    }

    /**
     * Get materiaporplanestudioid
     *
     * @return \AppBundle\Entity\CeMateriaporplanestudios
     */
    public function getMateriaporplanestudioid()
    {
        return $this->materiaporplanestudioid;
    }

    /**
     * Set tallercurricularid
     *
     * @param \AppBundle\Entity\CeTallercurricular $tallercurricularid
     *
     * @return CeGradoportallercurricular
     */
    public function setTallercurricularid(\AppBundle\Entity\CeTallercurricular $tallercurricularid = null)
    {
        $this->tallercurricularid = $tallercurricularid;

        return $this;
    }

    /**
     * Get tallercurricularid
     *
     * @return \AppBundle\Entity\CeTallercurricular
     */
    public function getTallercurricularid()
    {
        return $this->tallercurricularid;
    }

    /**
     * Set gradoid
     *
     * @param \AppBundle\Entity\Grado $gradoid
     *
     * @return CeGradoportallercurricular
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

