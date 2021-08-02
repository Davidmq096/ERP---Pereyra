<?php

namespace AppBundle\Entity;

/**
 * CjDomiciliacionporalumno
 */
class CjDomiciliacionporalumno
{
    /**
     * @var integer
     */
    private $domiciliacionporalumnoid;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;

    /**
     * @var \AppBundle\Entity\CjDomiciliacion
     */
    private $domiciliacionid;


    /**
     * Get domiciliacionporalumnoid
     *
     * @return integer
     */
    public function getDomiciliacionporalumnoid()
    {
        return $this->domiciliacionporalumnoid;
    }

    /**
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return CjDomiciliacionporalumno
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
     * Set domiciliacionid
     *
     * @param \AppBundle\Entity\CjDomiciliacion $domiciliacionid
     *
     * @return CjDomiciliacionporalumno
     */
    public function setDomiciliacionid(\AppBundle\Entity\CjDomiciliacion $domiciliacionid = null)
    {
        $this->domiciliacionid = $domiciliacionid;

        return $this;
    }

    /**
     * Get domiciliacionid
     *
     * @return \AppBundle\Entity\CjDomiciliacion
     */
    public function getDomiciliacionid()
    {
        return $this->domiciliacionid;
    }
}

