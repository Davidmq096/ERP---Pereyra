<?php

namespace AppBundle\Entity;

/**
 * CbAlumnoporacuerdo
 */
class CbAlumnoporacuerdo
{
    /**
     * @var float
     */
    private $importe;

    /**
     * @var integer
     */
    private $alumnoporacuerdoid;

    /**
     * @var \AppBundle\Entity\CbAcuerdo
     */
    private $acuerdoid;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;


    /**
     * Set importe
     *
     * @param float $importe
     *
     * @return CbAlumnoporacuerdo
     */
    public function setImporte($importe)
    {
        $this->importe = $importe;

        return $this;
    }

    /**
     * Get importe
     *
     * @return float
     */
    public function getImporte()
    {
        return $this->importe;
    }

    /**
     * Get alumnoporacuerdoid
     *
     * @return integer
     */
    public function getAlumnoporacuerdoid()
    {
        return $this->alumnoporacuerdoid;
    }

    /**
     * Set acuerdoid
     *
     * @param \AppBundle\Entity\CbAcuerdo $acuerdoid
     *
     * @return CbAlumnoporacuerdo
     */
    public function setAcuerdoid(\AppBundle\Entity\CbAcuerdo $acuerdoid = null)
    {
        $this->acuerdoid = $acuerdoid;

        return $this;
    }

    /**
     * Get acuerdoid
     *
     * @return \AppBundle\Entity\CbAcuerdo
     */
    public function getAcuerdoid()
    {
        return $this->acuerdoid;
    }

    /**
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return CbAlumnoporacuerdo
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

