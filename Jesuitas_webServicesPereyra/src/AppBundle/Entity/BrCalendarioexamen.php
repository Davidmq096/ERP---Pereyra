<?php

namespace AppBundle\Entity;

/**
 * BrCalendarioexamen
 */
class BrCalendarioexamen
{
    /**
     * @var boolean
     */
    private $resumenresultados;

    /**
     * @var boolean
     */
    private $revision;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var \DateTime
     */
    private $fechaaplicacion;

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
    private $calendarioexamenid;

    /**
     * @var \AppBundle\Entity\Ciclo
     */
    private $cicloid;

    /**
     * @var \AppBundle\Entity\Grado
     */
    private $gradoid;

    /**
     * @var \AppBundle\Entity\BrMedioaplicacion
     */
    private $medioaplicacionid;

    /**
     * @var \AppBundle\Entity\BrTipoaplicacion
     */
    private $tipoaplicacionid;

    /**
     * @var \AppBundle\Entity\BrTipoexamen
     */
    private $tipoexamenid;


    /**
     * Set resumenresultados
     *
     * @param boolean $resumenresultados
     *
     * @return BrCalendarioexamen
     */
    public function setResumenresultados($resumenresultados)
    {
        $this->resumenresultados = $resumenresultados;

        return $this;
    }

    /**
     * Get resumenresultados
     *
     * @return boolean
     */
    public function getResumenresultados()
    {
        return $this->resumenresultados;
    }

    /**
     * Set revision
     *
     * @param boolean $revision
     *
     * @return BrCalendarioexamen
     */
    public function setRevision($revision)
    {
        $this->revision = $revision;

        return $this;
    }

    /**
     * Get revision
     *
     * @return boolean
     */
    public function getRevision()
    {
        return $this->revision;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return BrCalendarioexamen
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set fechaaplicacion
     *
     * @param \DateTime $fechaaplicacion
     *
     * @return BrCalendarioexamen
     */
    public function setFechaaplicacion($fechaaplicacion)
    {
        $this->fechaaplicacion = $fechaaplicacion;

        return $this;
    }

    /**
     * Get fechaaplicacion
     *
     * @return \DateTime
     */
    public function getFechaaplicacion()
    {
        return $this->fechaaplicacion;
    }

    /**
     * Set horainicio
     *
     * @param \DateTime $horainicio
     *
     * @return BrCalendarioexamen
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
     * @return BrCalendarioexamen
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
     * Get calendarioexamenid
     *
     * @return integer
     */
    public function getCalendarioexamenid()
    {
        return $this->calendarioexamenid;
    }

    /**
     * Set cicloid
     *
     * @param \AppBundle\Entity\Ciclo $cicloid
     *
     * @return BrCalendarioexamen
     */
    public function setCicloid(\AppBundle\Entity\Ciclo $cicloid = null)
    {
        $this->cicloid = $cicloid;

        return $this;
    }

    /**
     * Get cicloid
     *
     * @return \AppBundle\Entity\Ciclo
     */
    public function getCicloid()
    {
        return $this->cicloid;
    }

    /**
     * Set gradoid
     *
     * @param \AppBundle\Entity\Grado $gradoid
     *
     * @return BrCalendarioexamen
     */
    public function setGradoid(\AppBundle\Entity\Grado $gradoid = null)
    {
        $this->gradoid = $gradoid;

        return $this;
    }

    /**
     * Get gradoid
     *
     * @return \AppBundle\Entity\Grado
     */
    public function getGradoid()
    {
        return $this->gradoid;
    }

    /**
     * Set medioaplicacionid
     *
     * @param \AppBundle\Entity\BrMedioaplicacion $medioaplicacionid
     *
     * @return BrCalendarioexamen
     */
    public function setMedioaplicacionid(\AppBundle\Entity\BrMedioaplicacion $medioaplicacionid = null)
    {
        $this->medioaplicacionid = $medioaplicacionid;

        return $this;
    }

    /**
     * Get medioaplicacionid
     *
     * @return \AppBundle\Entity\BrMedioaplicacion
     */
    public function getMedioaplicacionid()
    {
        return $this->medioaplicacionid;
    }

    /**
     * Set tipoaplicacionid
     *
     * @param \AppBundle\Entity\BrTipoaplicacion $tipoaplicacionid
     *
     * @return BrCalendarioexamen
     */
    public function setTipoaplicacionid(\AppBundle\Entity\BrTipoaplicacion $tipoaplicacionid = null)
    {
        $this->tipoaplicacionid = $tipoaplicacionid;

        return $this;
    }

    /**
     * Get tipoaplicacionid
     *
     * @return \AppBundle\Entity\BrTipoaplicacion
     */
    public function getTipoaplicacionid()
    {
        return $this->tipoaplicacionid;
    }

    /**
     * Set tipoexamenid
     *
     * @param \AppBundle\Entity\BrTipoexamen $tipoexamenid
     *
     * @return BrCalendarioexamen
     */
    public function setTipoexamenid(\AppBundle\Entity\BrTipoexamen $tipoexamenid = null)
    {
        $this->tipoexamenid = $tipoexamenid;

        return $this;
    }

    /**
     * Get tipoexamenid
     *
     * @return \AppBundle\Entity\BrTipoexamen
     */
    public function getTipoexamenid()
    {
        return $this->tipoexamenid;
    }
}

