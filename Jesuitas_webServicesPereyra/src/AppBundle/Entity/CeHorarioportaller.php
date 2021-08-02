<?php

namespace AppBundle\Entity;

/**
 * CeHorarioportaller
 */
class CeHorarioportaller
{
    /**
     * @var string
     */
    private $dia;

    /**
     * @var \DateTime
     */
    private $horainicio;

    /**
     * @var \DateTime
     */
    private $horafin;

    /**
     * @var integer
     */
    private $horarioportallerid;

    /**
     * @var \AppBundle\Entity\CeTallerextracurricular
     */
    private $tallerextracurricularid;


    /**
     * Set dia
     *
     * @param string $dia
     *
     * @return CeHorarioportaller
     */
    public function setDia($dia)
    {
        $this->dia = $dia;

        return $this;
    }

    /**
     * Get dia
     *
     * @return string
     */
    public function getDia()
    {
        return $this->dia;
    }

    /**
     * Set horainicio
     *
     * @param \DateTime $horainicio
     *
     * @return CeHorarioportaller
     */
    public function setHorainicio($horainicio)
    {
        $this->horainicio = $horainicio;

        return $this;
    }

    /**
     * Get horainicio
     *
     * @return \DateTime
     */
    public function getHorainicio()
    {
        return $this->horainicio;
    }

    /**
     * Set horafin
     *
     * @param \DateTime $horafin
     *
     * @return CeHorarioportaller
     */
    public function setHorafin($horafin)
    {
        $this->horafin = $horafin;

        return $this;
    }

    /**
     * Get horafin
     *
     * @return \DateTime
     */
    public function getHorafin()
    {
        return $this->horafin;
    }

    /**
     * Get horarioportallerid
     *
     * @return integer
     */
    public function getHorarioportallerid()
    {
        return $this->horarioportallerid;
    }

    /**
     * Set tallerextracurricularid
     *
     * @param \AppBundle\Entity\CeTallerextracurricular $tallerextracurricularid
     *
     * @return CeHorarioportaller
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

