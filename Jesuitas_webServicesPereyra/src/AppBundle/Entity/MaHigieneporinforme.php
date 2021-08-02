<?php

namespace AppBundle\Entity;

/**
 * MaHigieneporinforme
 */
class MaHigieneporinforme
{
    /**
     * @var integer
     */
    private $higieneporinformeid;

    /**
     * @var \AppBundle\Entity\MaHigiene
     */
    private $higieneid;

    /**
     * @var \AppBundle\Entity\MaInforme
     */
    private $informeid;


    /**
     * Get higieneporinformeid
     *
     * @return integer
     */
    public function getHigieneporinformeid()
    {
        return $this->higieneporinformeid;
    }

    /**
     * Set higieneid
     *
     * @param \AppBundle\Entity\MaHigiene $higieneid
     *
     * @return MaHigieneporinforme
     */
    public function setHigieneid(\AppBundle\Entity\MaHigiene $higieneid = null)
    {
        $this->higieneid = $higieneid;

        return $this;
    }

    /**
     * Get higieneid
     *
     * @return \AppBundle\Entity\MaHigiene
     */
    public function getHigieneid()
    {
        return $this->higieneid;
    }

    /**
     * Set informeid
     *
     * @param \AppBundle\Entity\MaInforme $informeid
     *
     * @return MaHigieneporinforme
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

