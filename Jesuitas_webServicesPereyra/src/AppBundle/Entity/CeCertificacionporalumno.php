<?php

namespace AppBundle\Entity;

/**
 * CeCertificacionporalumno
 */
class CeCertificacionporalumno
{
    /**
     * @var float
     */
    private $calificacion;

    /**
     * @var \DateTime
     */
    private $fechacertificado;

    /**
     * @var string
     */
    private $vigencia;

    /**
     * @var integer
     */
    private $certificacionporalumnoid;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;

    /**
     * @var \AppBundle\Entity\CeCertificacion
     */
    private $certificacionid;


    /**
     * Set calificacion
     *
     * @param float $calificacion
     *
     * @return CeCertificacionporalumno
     */
    public function setCalificacion($calificacion)
    {
        $this->calificacion = $calificacion;

        return $this;
    }

    /**
     * Get calificacion
     *
     * @return float
     */
    public function getCalificacion()
    {
        return $this->calificacion;
    }

    /**
     * Set fechacertificado
     *
     * @param \DateTime $fechacertificado
     *
     * @return CeCertificacionporalumno
     */
    public function setFechacertificado($fechacertificado)
    {
        $this->fechacertificado = $fechacertificado;

        return $this;
    }

    /**
     * Get fechacertificado
     *
     * @return \DateTime
     */
    public function getFechacertificado()
    {
        return $this->fechacertificado;
    }

    /**
     * Set vigencia
     *
     * @param string $vigencia
     *
     * @return CeCertificacionporalumno
     */
    public function setVigencia($vigencia)
    {
        $this->vigencia = $vigencia;

        return $this;
    }

    /**
     * Get vigencia
     *
     * @return string
     */
    public function getVigencia()
    {
        return $this->vigencia;
    }

    /**
     * Get certificacionporalumnoid
     *
     * @return integer
     */
    public function getCertificacionporalumnoid()
    {
        return $this->certificacionporalumnoid;
    }

    /**
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return CeCertificacionporalumno
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
     * Set certificacionid
     *
     * @param \AppBundle\Entity\CeCertificacion $certificacionid
     *
     * @return CeCertificacionporalumno
     */
    public function setCertificacionid(\AppBundle\Entity\CeCertificacion $certificacionid = null)
    {
        $this->certificacionid = $certificacionid;

        return $this;
    }

    /**
     * Get certificacionid
     *
     * @return \AppBundle\Entity\CeCertificacion
     */
    public function getCertificacionid()
    {
        return $this->certificacionid;
    }
}

