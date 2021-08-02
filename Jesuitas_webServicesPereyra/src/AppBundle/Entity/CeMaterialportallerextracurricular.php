<?php

namespace AppBundle\Entity;

/**
 * CeMaterialportallerextracurricular
 */
class CeMaterialportallerextracurricular
{
    /**
     * @var integer
     */
    private $materialportallerextracurricularid;

    /**
     * @var \AppBundle\Entity\CeTallerextracurricular
     */
    private $tallerextracurricularid;

    /**
     * @var \AppBundle\Entity\CeTallermaterial
     */
    private $tallermaterialid;


    /**
     * Get materialportallerextracurricularid
     *
     * @return integer
     */
    public function getMaterialportallerextracurricularid()
    {
        return $this->materialportallerextracurricularid;
    }

    /**
     * Set tallerextracurricularid
     *
     * @param \AppBundle\Entity\CeTallerextracurricular $tallerextracurricularid
     *
     * @return CeMaterialportallerextracurricular
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
     * Set tallermaterialid
     *
     * @param \AppBundle\Entity\CeTallermaterial $tallermaterialid
     *
     * @return CeMaterialportallerextracurricular
     */
    public function setTallermaterialid(\AppBundle\Entity\CeTallermaterial $tallermaterialid = null)
    {
        $this->tallermaterialid = $tallermaterialid;

        return $this;
    }

    /**
     * Get tallermaterialid
     *
     * @return \AppBundle\Entity\CeTallermaterial
     */
    public function getTallermaterialid()
    {
        return $this->tallermaterialid;
    }
}

