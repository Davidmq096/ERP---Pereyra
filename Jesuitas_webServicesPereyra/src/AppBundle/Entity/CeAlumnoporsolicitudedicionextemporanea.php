<?php

namespace AppBundle\Entity;

/**
 * CeAlumnoporsolicitudedicionextemporanea
 */
class CeAlumnoporsolicitudedicionextemporanea
{
    /**
     * @var integer
     */
    private $alumnoporsolicitudedicionextemporaneaid;

    /**
     * @var \AppBundle\Entity\CeSolicitudedicionextemporanea
     */
    private $solicitudedicionextemporaneaid;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;


    /**
     * Get alumnoporsolicitudedicionextemporaneaid
     *
     * @return integer
     */
    public function getAlumnoporsolicitudedicionextemporaneaid()
    {
        return $this->alumnoporsolicitudedicionextemporaneaid;
    }

    /**
     * Set solicitudedicionextemporaneaid
     *
     * @param \AppBundle\Entity\CeSolicitudedicionextemporanea $solicitudedicionextemporaneaid
     *
     * @return CeAlumnoporsolicitudedicionextemporanea
     */
    public function setSolicitudedicionextemporaneaid(\AppBundle\Entity\CeSolicitudedicionextemporanea $solicitudedicionextemporaneaid = null)
    {
        $this->solicitudedicionextemporaneaid = $solicitudedicionextemporaneaid;

        return $this;
    }

    /**
     * Get solicitudedicionextemporaneaid
     *
     * @return \AppBundle\Entity\CeSolicitudedicionextemporanea
     */
    public function getSolicitudedicionextemporaneaid()
    {
        return $this->solicitudedicionextemporaneaid;
    }

    /**
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return CeAlumnoporsolicitudedicionextemporanea
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
}

