<?php

namespace AppBundle\Entity;

/**
 * Evaluacion
 */
class Evaluacion
{
    /**
     * @var integer
     */
    private $usuarioid;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var integer
     */
    private $evaluacionid;

    /**
     * @var \AppBundle\Entity\Ciclo
     */
    private $cicloid;

    /**
     * @var \AppBundle\Entity\Tipoevaluacion
     */
    private $tipoevaluacionid;


    /**
     * Set usuarioid
     *
     * @param integer $usuarioid
     *
     * @return Evaluacion
     */
    public function setUsuarioid($usuarioid)
    {
        $this->usuarioid = $usuarioid;

        return $this;
    }

    /**
     * Get usuarioid
     *
     * @return integer
     */
    public function getUsuarioid()
    {
        return $this->usuarioid;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Evaluacion
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Evaluacion
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Get evaluacionid
     *
     * @return integer
     */
    public function getEvaluacionid()
    {
        return $this->evaluacionid;
    }

    /**
     * Set cicloid
     *
     * @param \AppBundle\Entity\Ciclo $cicloid
     *
     * @return Evaluacion
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
     * Set tipoevaluacionid
     *
     * @param \AppBundle\Entity\Tipoevaluacion $tipoevaluacionid
     *
     * @return Evaluacion
     */
    public function setTipoevaluacionid(\AppBundle\Entity\Tipoevaluacion $tipoevaluacionid = null)
    {
        $this->tipoevaluacionid = $tipoevaluacionid;

        return $this;
    }

    /**
     * Get tipoevaluacionid
     *
     * @return \AppBundle\Entity\Tipoevaluacion
     */
    public function getTipoevaluacionid()
    {
        return $this->tipoevaluacionid;
    }
}

