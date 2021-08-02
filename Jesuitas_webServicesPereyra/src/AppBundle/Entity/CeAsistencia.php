<?php

namespace AppBundle\Entity;

/**
 * CeAsistencia
 */
class CeAsistencia
{
    /**
     * @var \DateTime
     */
    private $fecha;

    /**
     * @var \DateTime
     */
    private $hora;

    /**
     * @var string
     */
    private $motivocancelacioninasistencia;

    /**
     * @var \DateTime
     */
    private $fechamodificacion;

    /**
     * @var integer
     */
    private $asistenciaid;

    /**
     * @var \AppBundle\Entity\CeAlumnoporciclo
     */
    private $alumnoporcicloid;

    /**
     * @var \AppBundle\Entity\CeProfesorpormateriaplanestudios
     */
    private $profesorpormateriaplanestudioid;

    /**
     * @var \AppBundle\Entity\CeEstatusinasistencia
     */
    private $estatusinasistenciaid;

    /**
     * @var \AppBundle\Entity\CeTipoasistencia
     */
    private $tipoasistenciaid;

    /**
     * @var \AppBundle\Entity\Usuario
     */
    private $usuarioid;


    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return CeAsistencia
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set hora
     *
     * @param \DateTime $hora
     *
     * @return CeAsistencia
     */
    public function setHora($hora)
    {
        $this->hora = $hora;

        return $this;
    }

    /**
     * Get hora
     *
     * @return \DateTime
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * Set motivocancelacioninasistencia
     *
     * @param string $motivocancelacioninasistencia
     *
     * @return CeAsistencia
     */
    public function setMotivocancelacioninasistencia($motivocancelacioninasistencia)
    {
        $this->motivocancelacioninasistencia = $motivocancelacioninasistencia;

        return $this;
    }

    /**
     * Get motivocancelacioninasistencia
     *
     * @return string
     */
    public function getMotivocancelacioninasistencia()
    {
        return $this->motivocancelacioninasistencia;
    }

    /**
     * Set fechamodificacion
     *
     * @param \DateTime $fechamodificacion
     *
     * @return CeAsistencia
     */
    public function setFechamodificacion($fechamodificacion)
    {
        $this->fechamodificacion = $fechamodificacion;

        return $this;
    }

    /**
     * Get fechamodificacion
     *
     * @return \DateTime
     */
    public function getFechamodificacion()
    {
        return $this->fechamodificacion;
    }

    /**
     * Get asistenciaid
     *
     * @return integer
     */
    public function getAsistenciaid()
    {
        return $this->asistenciaid;
    }

    /**
     * Set alumnoporcicloid
     *
     * @param \AppBundle\Entity\CeAlumnoporciclo $alumnoporcicloid
     *
     * @return CeAsistencia
     */
    public function setAlumnoporcicloid(\AppBundle\Entity\CeAlumnoporciclo $alumnoporcicloid = null)
    {
        $this->alumnoporcicloid = $alumnoporcicloid;

        return $this;
    }

    /**
     * Get alumnoporcicloid
     *
     * @return \AppBundle\Entity\CeAlumnoporciclo
     */
    public function getAlumnoporcicloid()
    {
        return $this->alumnoporcicloid;
    }

    /**
     * Set profesorpormateriaplanestudioid
     *
     * @param \AppBundle\Entity\CeProfesorpormateriaplanestudios $profesorpormateriaplanestudioid
     *
     * @return CeAsistencia
     */
    public function setProfesorpormateriaplanestudioid(\AppBundle\Entity\CeProfesorpormateriaplanestudios $profesorpormateriaplanestudioid = null)
    {
        $this->profesorpormateriaplanestudioid = $profesorpormateriaplanestudioid;

        return $this;
    }

    /**
     * Get profesorpormateriaplanestudioid
     *
     * @return \AppBundle\Entity\CeProfesorpormateriaplanestudios
     */
    public function getProfesorpormateriaplanestudioid()
    {
        return $this->profesorpormateriaplanestudioid;
    }

    /**
     * Set estatusinasistenciaid
     *
     * @param \AppBundle\Entity\CeEstatusinasistencia $estatusinasistenciaid
     *
     * @return CeAsistencia
     */
    public function setEstatusinasistenciaid(\AppBundle\Entity\CeEstatusinasistencia $estatusinasistenciaid = null)
    {
        $this->estatusinasistenciaid = $estatusinasistenciaid;

        return $this;
    }

    /**
     * Get estatusinasistenciaid
     *
     * @return \AppBundle\Entity\CeEstatusinasistencia
     */
    public function getEstatusinasistenciaid()
    {
        return $this->estatusinasistenciaid;
    }

    /**
     * Set tipoasistenciaid
     *
     * @param \AppBundle\Entity\CeTipoasistencia $tipoasistenciaid
     *
     * @return CeAsistencia
     */
    public function setTipoasistenciaid(\AppBundle\Entity\CeTipoasistencia $tipoasistenciaid = null)
    {
        $this->tipoasistenciaid = $tipoasistenciaid;

        return $this;
    }

    /**
     * Get tipoasistenciaid
     *
     * @return \AppBundle\Entity\CeTipoasistencia
     */
    public function getTipoasistenciaid()
    {
        return $this->tipoasistenciaid;
    }

    /**
     * Set usuarioid
     *
     * @param \AppBundle\Entity\Usuario $usuarioid
     *
     * @return CeAsistencia
     */
    public function setUsuarioid(\AppBundle\Entity\Usuario $usuarioid = null)
    {
        $this->usuarioid = $usuarioid;

        return $this;
    }

    /**
     * Get usuarioid
     *
     * @return \AppBundle\Entity\Usuario
     */
    public function getUsuarioid()
    {
        return $this->usuarioid;
    }
}

