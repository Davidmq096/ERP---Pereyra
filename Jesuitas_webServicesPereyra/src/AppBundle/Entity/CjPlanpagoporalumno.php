<?php

namespace AppBundle\Entity;

/**
 * CjPlanpagoporalumno
 */
class CjPlanpagoporalumno
{
    /**
     * @var integer
     */
    private $planpagoporalumnoid;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;

    /**
     * @var \AppBundle\Entity\Ciclo
     */
    private $cicloid;

    /**
     * @var \AppBundle\Entity\CjPlanpago
     */
    private $planpagoid;

    /**
     * @var \AppBundle\Entity\Solicitudadmision
     */
    private $solicitudadmisionid;


    /**
     * Get planpagoporalumnoid
     *
     * @return integer
     */
    public function getPlanpagoporalumnoid()
    {
        return $this->planpagoporalumnoid;
    }

    /**
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return CjPlanpagoporalumno
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
     * Set cicloid
     *
     * @param \AppBundle\Entity\Ciclo $cicloid
     *
     * @return CjPlanpagoporalumno
     */
    public function setCicloid(\AppBundle\Entity\Ciclo $cicloid = null)
    {
        $this->cicloid = $cicloid;

        return $this;
    }

    /**
     * Get cicloid
     *
     * @return \AppBundle\Entity\Ciclo
     */
    public function getCicloid()
    {
        return $this->cicloid;
    }

    /**
     * Set planpagoid
     *
     * @param \AppBundle\Entity\CjPlanpago $planpagoid
     *
     * @return CjPlanpagoporalumno
     */
    public function setPlanpagoid(\AppBundle\Entity\CjPlanpago $planpagoid = null)
    {
        $this->planpagoid = $planpagoid;

        return $this;
    }

    /**
     * Get planpagoid
     *
     * @return \AppBundle\Entity\CjPlanpago
     */
    public function getPlanpagoid()
    {
        return $this->planpagoid;
    }

    /**
     * Set solicitudadmisionid
     *
     * @param \AppBundle\Entity\Solicitudadmision $solicitudadmisionid
     *
     * @return CjPlanpagoporalumno
     */
    public function setSolicitudadmisionid(\AppBundle\Entity\Solicitudadmision $solicitudadmisionid = null)
    {
        $this->solicitudadmisionid = $solicitudadmisionid;

        return $this;
    }

    /**
     * Get solicitudadmisionid
     *
     * @return \AppBundle\Entity\Solicitudadmision
     */
    public function getSolicitudadmisionid()
    {
        return $this->solicitudadmisionid;
    }
}

