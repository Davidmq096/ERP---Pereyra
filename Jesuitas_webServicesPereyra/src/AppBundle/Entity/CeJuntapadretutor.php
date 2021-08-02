<?php

namespace AppBundle\Entity;

/**
 * CeJuntapadretutor
 */
class CeJuntapadretutor
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
    private $bloqueocalificacion;

    /**
     * @var integer
     */
    private $juntapadreotutorid;

    /**
     * @var \AppBundle\Entity\CeGrupo
     */
    private $grupoid;

    /**
     * @var \AppBundle\Entity\Usuario
     */
    private $usuarioid;

    /**
     * @var \AppBundle\Entity\CePeriodoevaluacion
     */
    private $periodoevaluacionid;


    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return CeJuntapadretutor
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
     * @return CeJuntapadretutor
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
     * Set bloqueocalificacion
     *
     * @param boolean $bloqueocalificacion
     *
     * @return CeJuntapadretutor
     */
    public function setBloqueocalificacion($bloqueocalificacion)
    {
        $this->bloqueocalificacion = $bloqueocalificacion;

        return $this;
    }

    /**
     * Get bloqueocalificacion
     *
     * @return boolean
     */
    public function getBloqueocalificacion()
    {
        return $this->bloqueocalificacion;
    }

    /**
     * Get juntapadreotutorid
     *
     * @return integer
     */
    public function getJuntapadreotutorid()
    {
        return $this->juntapadreotutorid;
    }

    /**
     * Set grupoid
     *
     * @param \AppBundle\Entity\CeGrupo $grupoid
     *
     * @return CeJuntapadretutor
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
     * Set usuarioid
     *
     * @param \AppBundle\Entity\Usuario $usuarioid
     *
     * @return CeJuntapadretutor
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

    /**
     * Set periodoevaluacionid
     *
     * @param \AppBundle\Entity\CePeriodoevaluacion $periodoevaluacionid
     *
     * @return CeJuntapadretutor
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
}

