<?php

namespace AppBundle\Entity;

/**
 * TpAlumnomes
 */
class TpAlumnomes
{
    /**
     * @var integer
     */
    private $year;

    /**
     * @var integer
     */
    private $month;

    /**
     * @var integer
     */
    private $alumnomesid;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;

    /**
     * @var \AppBundle\Entity\TpContrato
     */
    private $contratoid;


    /**
     * Set year
     *
     * @param integer $year
     *
     * @return TpAlumnomes
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set month
     *
     * @param integer $month
     *
     * @return TpAlumnomes
     */
    public function setMonth($month)
    {
        $this->month = $month;

        return $this;
    }

    /**
     * Get month
     *
     * @return integer
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * Get alumnomesid
     *
     * @return integer
     */
    public function getAlumnomesid()
    {
        return $this->alumnomesid;
    }

    /**
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return TpAlumnomes
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
     * Set contratoid
     *
     * @param \AppBundle\Entity\TpContrato $contratoid
     *
     * @return TpAlumnomes
     */
    public function setContratoid(\AppBundle\Entity\TpContrato $contratoid = null)
    {
        $this->contratoid = $contratoid;

        return $this;
    }

    /**
     * Get contratoid
     *
     * @return \AppBundle\Entity\TpContrato
     */
    public function getContratoid()
    {
        return $this->contratoid;
    }
}

