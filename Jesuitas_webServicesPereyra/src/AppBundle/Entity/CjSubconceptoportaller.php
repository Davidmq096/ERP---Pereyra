<?php

namespace AppBundle\Entity;

/**
 * CjSubconceptoportaller
 */
class CjSubconceptoportaller
{
    /**
     * @var integer
     */
    private $subconceptoportallerid;

    /**
     * @var \AppBundle\Entity\CjSubconcepto
     */
    private $subconceptoid;

    /**
     * @var \AppBundle\Entity\CeTallerextracurricular
     */
    private $tallerextracurricularid;


    /**
     * Get subconceptoportallerid
     *
     * @return integer
     */
    public function getSubconceptoportallerid()
    {
        return $this->subconceptoportallerid;
    }

    /**
     * Set subconceptoid
     *
     * @param \AppBundle\Entity\CjSubconcepto $subconceptoid
     *
     * @return CjSubconceptoportaller
     */
    public function setSubconceptoid(\AppBundle\Entity\CjSubconcepto $subconceptoid = null)
    {
        $this->subconceptoid = $subconceptoid;

        return $this;
    }

    /**
     * Get subconceptoid
     *
     * @return \AppBundle\Entity\CjSubconcepto
     */
    public function getSubconceptoid()
    {
        return $this->subconceptoid;
    }

    /**
     * Set tallerextracurricularid
     *
     * @param \AppBundle\Entity\CeTallerextracurricular $tallerextracurricularid
     *
     * @return CjSubconceptoportaller
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
}

