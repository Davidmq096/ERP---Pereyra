<?php

namespace AppBundle\Entity;

/**
 * BcSolicitudporalumno
 */
class BcSolicitudporalumno
{
    /**
     * @var float
     */
    private $calificacion;

    /**
     * @var integer
     */
    private $alumnosolicitudid;

    /**
     * @var \AppBundle\Entity\Grado
     */
    private $gradoiddestino;

    /**
     * @var \AppBundle\Entity\Grado
     */
    private $gradoidorigen;

    /**
     * @var \AppBundle\Entity\BcMotivocancelacion
     */
    private $motivocancelacionid;

    /**
     * @var \AppBundle\Entity\BcSolicitudbeca
     */
    private $solicitudid;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;

    /**
     * @var \AppBundle\Entity\BcEstatussolicitudbeca
     */
    private $estatusid;


    /**
     * Set calificacion
     *
     * @param float $calificacion
     *
     * @return BcSolicitudporalumno
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
     * Get alumnosolicitudid
     *
     * @return integer
     */
    public function getAlumnosolicitudid()
    {
        return $this->alumnosolicitudid;
    }

    /**
     * Set gradoiddestino
     *
     * @param \AppBundle\Entity\Grado $gradoiddestino
     *
     * @return BcSolicitudporalumno
     */
    public function setGradoiddestino(\AppBundle\Entity\Grado $gradoiddestino = null)
    {
        $this->gradoiddestino = $gradoiddestino;

        return $this;
    }

    /**
     * Get gradoiddestino
     *
     * @return \AppBundle\Entity\Grado
     */
    public function getGradoiddestino()
    {
        return $this->gradoiddestino;
    }

    /**
     * Set gradoidorigen
     *
     * @param \AppBundle\Entity\Grado $gradoidorigen
     *
     * @return BcSolicitudporalumno
     */
    public function setGradoidorigen(\AppBundle\Entity\Grado $gradoidorigen = null)
    {
        $this->gradoidorigen = $gradoidorigen;

        return $this;
    }

    /**
     * Get gradoidorigen
     *
     * @return \AppBundle\Entity\Grado
     */
    public function getGradoidorigen()
    {
        return $this->gradoidorigen;
    }

    /**
     * Set motivocancelacionid
     *
     * @param \AppBundle\Entity\BcMotivocancelacion $motivocancelacionid
     *
     * @return BcSolicitudporalumno
     */
    public function setMotivocancelacionid(\AppBundle\Entity\BcMotivocancelacion $motivocancelacionid = null)
    {
        $this->motivocancelacionid = $motivocancelacionid;

        return $this;
    }

    /**
     * Get motivocancelacionid
     *
     * @return \AppBundle\Entity\BcMotivocancelacion
     */
    public function getMotivocancelacionid()
    {
        return $this->motivocancelacionid;
    }

    /**
     * Set solicitudid
     *
     * @param \AppBundle\Entity\BcSolicitudbeca $solicitudid
     *
     * @return BcSolicitudporalumno
     */
    public function setSolicitudid(\AppBundle\Entity\BcSolicitudbeca $solicitudid = null)
    {
        $this->solicitudid = $solicitudid;

        return $this;
    }

    /**
     * Get solicitudid
     *
     * @return \AppBundle\Entity\BcSolicitudbeca
     */
    public function getSolicitudid()
    {
        return $this->solicitudid;
    }

    /**
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return BcSolicitudporalumno
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
     * Set estatusid
     *
     * @param \AppBundle\Entity\BcEstatussolicitudbeca $estatusid
     *
     * @return BcSolicitudporalumno
     */
    public function setEstatusid(\AppBundle\Entity\BcEstatussolicitudbeca $estatusid = null)
    {
        $this->estatusid = $estatusid;

        return $this;
    }

    /**
     * Get estatusid
     *
     * @return \AppBundle\Entity\BcEstatussolicitudbeca
     */
    public function getEstatusid()
    {
        return $this->estatusid;
    }
}

