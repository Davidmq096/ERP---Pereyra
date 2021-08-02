<?php

namespace AppBundle\Entity;

/**
 * MaActividadporinforme
 */
class MaActividadporinforme
{
    /**
     * @var integer
     */
    private $actividadporinformeid;

    /**
     * @var \AppBundle\Entity\MaActividad
     */
    private $actividadid;

    /**
     * @var \AppBundle\Entity\MaInforme
     */
    private $informeid;


    /**
     * Get actividadporinformeid
     *
     * @return integer
     */
    public function getActividadporinformeid()
    {
        return $this->actividadporinformeid;
    }

    /**
     * Set actividadid
     *
     * @param \AppBundle\Entity\MaActividad $actividadid
     *
     * @return MaActividadporinforme
     */
    public function setActividadid(\AppBundle\Entity\MaActividad $actividadid = null)
    {
        $this->actividadid = $actividadid;

        return $this;
    }

    /**
     * Get actividadid
     *
     * @return \AppBundle\Entity\MaActividad
     */
    public function getActividadid()
    {
        return $this->actividadid;
    }

    /**
     * Set informeid
     *
     * @param \AppBundle\Entity\MaInforme $informeid
     *
     * @return MaActividadporinforme
     */
    public function setInformeid(\AppBundle\Entity\MaInforme $informeid = null)
    {
        $this->informeid = $informeid;

        return $this;
    }

    /**
     * Get informeid
     *
     * @return \AppBundle\Entity\MaInforme
     */
    public function getInformeid()
    {
        return $this->informeid;
    }
}

