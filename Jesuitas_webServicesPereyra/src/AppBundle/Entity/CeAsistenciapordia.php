<?php

namespace AppBundle\Entity;

/**
 * CeAsistenciapordia
 */
class CeAsistenciapordia
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
     * @var boolean
     */
    private $ignorar;

    /**
     * @var integer
     */
    private $asistenciapordiaid;

    /**
     * @var \AppBundle\Entity\CeAlumnoporciclo
     */
    private $alumnoporcicloid;

    /**
     * @var \AppBundle\Entity\CeEstatusinasistencia
     */
    private $estatusinasistenciaid;

    /**
     * @var \AppBundle\Entity\CeGrupo
     */
    private $grupoid;

    /**
     * @var \AppBundle\Entity\CePeriodoevaluacion
     */
    private $periodoevaluacionid;

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
     * @return CeAsistenciapordia
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
     * @return CeAsistenciapordia
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
     * Set ignorar
     *
     * @param boolean $ignorar
     *
     * @return CeAsistenciapordia
     */
    public function setIgnorar($ignorar)
    {
        $this->ignorar = $ignorar;

        return $this;
    }

    /**
     * Get ignorar
     *
     * @return boolean
     */
    public function getIgnorar()
    {
        return $this->ignorar;
    }

    /**
     * Get asistenciapordiaid
     *
     * @return integer
     */
    public function getAsistenciapordiaid()
    {
        return $this->asistenciapordiaid;
    }

    /**
     * Set alumnoporcicloid
     *
     * @param \AppBundle\Entity\CeAlumnoporciclo $alumnoporcicloid
     *
     * @return CeAsistenciapordia
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
     * Set estatusinasistenciaid
     *
     * @param \AppBundle\Entity\CeEstatusinasistencia $estatusinasistenciaid
     *
     * @return CeAsistenciapordia
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
     * Set grupoid
     *
     * @param \AppBundle\Entity\CeGrupo $grupoid
     *
     * @return CeAsistenciapordia
     */
    public function setGrupoid(\AppBundle\Entity\CeGrupo $grupoid = null)
    {
        $this->grupoid = $grupoid;

        return $this;
    }

    /**
     * Get grupoid
     *
     * @return \AppBundle\Entity\CeGrupo
     */
    public function getGrupoid()
    {
        return $this->grupoid;
    }

    /**
     * Set periodoevaluacionid
     *
     * @param \AppBundle\Entity\CePeriodoevaluacion $periodoevaluacionid
     *
     * @return CeAsistenciapordia
     */
    public function setPeriodoevaluacionid(\AppBundle\Entity\CePeriodoevaluacion $periodoevaluacionid = null)
    {
        $this->periodoevaluacionid = $periodoevaluacionid;

        return $this;
    }

    /**
     * Get periodoevaluacionid
     *
     * @return \AppBundle\Entity\CePeriodoevaluacion
     */
    public function getPeriodoevaluacionid()
    {
        return $this->periodoevaluacionid;
    }

    /**
     * Set tipoasistenciaid
     *
     * @param \AppBundle\Entity\CeTipoasistencia $tipoasistenciaid
     *
     * @return CeAsistenciapordia
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
     * @return CeAsistenciapordia
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

