<?php

namespace AppBundle\Entity;

/**
 * CeAlumnoporclavefamiliar
 */
class CeAlumnoporclavefamiliar
{
    /**
     * @var integer
     */
    private $alumnoporclavefamiliar;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;

    /**
     * @var \AppBundle\Entity\CeClavefamiliar
     */
    private $clavefamiliarid;


    /**
     * Get alumnoporclavefamiliar
     *
     * @return integer
     */
    public function getAlumnoporclavefamiliar()
    {
        return $this->alumnoporclavefamiliar;
    }

    /**
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return CeAlumnoporclavefamiliar
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
     * Set clavefamiliarid
     *
     * @param \AppBundle\Entity\CeClavefamiliar $clavefamiliarid
     *
     * @return CeAlumnoporclavefamiliar
     */
    public function setClavefamiliarid(\AppBundle\Entity\CeClavefamiliar $clavefamiliarid = null)
    {
        $this->clavefamiliarid = $clavefamiliarid;

        return $this;
    }

    /**
     * Get clavefamiliarid
     *
     * @return \AppBundle\Entity\CeClavefamiliar
     */
    public function getClavefamiliarid()
    {
        return $this->clavefamiliarid;
    }
}

