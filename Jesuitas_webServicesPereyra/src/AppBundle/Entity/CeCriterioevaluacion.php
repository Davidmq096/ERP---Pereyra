<?php

namespace AppBundle\Entity;

/**
 * CeCriterioevaluacion
 */
class CeCriterioevaluacion
{
    /**
     * @var string
     */
    private $aspecto;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var integer
     */
    private $porcentajecalificacion;

    /**
     * @var integer
     */
    private $capturas;

    /**
     * @var integer
     */
    private $puntajemaximo;

    /**
     * @var boolean
     */
    private $eliminaraspecto = '0';

    /**
     * @var boolean
     */
    private $editarporcentajecalificacion = '0';

    /**
     * @var boolean
     */
    private $editarcapturas = '0';

    /**
     * @var boolean
     */
    private $editarpuntajemaximo = '0';

    /**
     * @var integer
     */
    private $minimo;

    /**
     * @var integer
     */
    private $maximo;

    /**
     * @var boolean
     */
    private $configurartarea = '0';

    /**
     * @var boolean
     */
    private $configurarexamen = '0';

    /**
     * @var integer
     */
    private $criterioevaluacionid;

    /**
     * @var \AppBundle\Entity\CeConjuntocriterioevaluacion
     */
    private $conjuntocriterioevaluacionid;

    /**
     * @var \AppBundle\Entity\CePeriodoevaluacion
     */
    private $periodoevaluacionid;


    /**
     * Set aspecto
     *
     * @param string $aspecto
     *
     * @return CeCriterioevaluacion
     */
    public function setAspecto($aspecto)
    {
        $this->aspecto = $aspecto;

        return $this;
    }

    /**
     * Get aspecto
     *
     * @return string
     */
    public function getAspecto()
    {
        return $this->aspecto;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return CeCriterioevaluacion
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
     * Set porcentajecalificacion
     *
     * @param integer $porcentajecalificacion
     *
     * @return CeCriterioevaluacion
     */
    public function setPorcentajecalificacion($porcentajecalificacion)
    {
        $this->porcentajecalificacion = $porcentajecalificacion;

        return $this;
    }

    /**
     * Get porcentajecalificacion
     *
     * @return integer
     */
    public function getPorcentajecalificacion()
    {
        return $this->porcentajecalificacion;
    }

    /**
     * Set capturas
     *
     * @param integer $capturas
     *
     * @return CeCriterioevaluacion
     */
    public function setCapturas($capturas)
    {
        $this->capturas = $capturas;

        return $this;
    }

    /**
     * Get capturas
     *
     * @return integer
     */
    public function getCapturas()
    {
        return $this->capturas;
    }

    /**
     * Set puntajemaximo
     *
     * @param integer $puntajemaximo
     *
     * @return CeCriterioevaluacion
     */
    public function setPuntajemaximo($puntajemaximo)
    {
        $this->puntajemaximo = $puntajemaximo;

        return $this;
    }

    /**
     * Get puntajemaximo
     *
     * @return integer
     */
    public function getPuntajemaximo()
    {
        return $this->puntajemaximo;
    }

    /**
     * Set eliminaraspecto
     *
     * @param boolean $eliminaraspecto
     *
     * @return CeCriterioevaluacion
     */
    public function setEliminaraspecto($eliminaraspecto)
    {
        $this->eliminaraspecto = $eliminaraspecto;

        return $this;
    }

    /**
     * Get eliminaraspecto
     *
     * @return boolean
     */
    public function getEliminaraspecto()
    {
        return $this->eliminaraspecto;
    }

    /**
     * Set editarporcentajecalificacion
     *
     * @param boolean $editarporcentajecalificacion
     *
     * @return CeCriterioevaluacion
     */
    public function setEditarporcentajecalificacion($editarporcentajecalificacion)
    {
        $this->editarporcentajecalificacion = $editarporcentajecalificacion;

        return $this;
    }

    /**
     * Get editarporcentajecalificacion
     *
     * @return boolean
     */
    public function getEditarporcentajecalificacion()
    {
        return $this->editarporcentajecalificacion;
    }

    /**
     * Set editarcapturas
     *
     * @param boolean $editarcapturas
     *
     * @return CeCriterioevaluacion
     */
    public function setEditarcapturas($editarcapturas)
    {
        $this->editarcapturas = $editarcapturas;

        return $this;
    }

    /**
     * Get editarcapturas
     *
     * @return boolean
     */
    public function getEditarcapturas()
    {
        return $this->editarcapturas;
    }

    /**
     * Set editarpuntajemaximo
     *
     * @param boolean $editarpuntajemaximo
     *
     * @return CeCriterioevaluacion
     */
    public function setEditarpuntajemaximo($editarpuntajemaximo)
    {
        $this->editarpuntajemaximo = $editarpuntajemaximo;

        return $this;
    }

    /**
     * Get editarpuntajemaximo
     *
     * @return boolean
     */
    public function getEditarpuntajemaximo()
    {
        return $this->editarpuntajemaximo;
    }

    /**
     * Set minimo
     *
     * @param integer $minimo
     *
     * @return CeCriterioevaluacion
     */
    public function setMinimo($minimo)
    {
        $this->minimo = $minimo;

        return $this;
    }

    /**
     * Get minimo
     *
     * @return integer
     */
    public function getMinimo()
    {
        return $this->minimo;
    }

    /**
     * Set maximo
     *
     * @param integer $maximo
     *
     * @return CeCriterioevaluacion
     */
    public function setMaximo($maximo)
    {
        $this->maximo = $maximo;

        return $this;
    }

    /**
     * Get maximo
     *
     * @return integer
     */
    public function getMaximo()
    {
        return $this->maximo;
    }

    /**
     * Set configurartarea
     *
     * @param boolean $configurartarea
     *
     * @return CeCriterioevaluacion
     */
    public function setConfigurartarea($configurartarea)
    {
        $this->configurartarea = $configurartarea;

        return $this;
    }

    /**
     * Get configurartarea
     *
     * @return boolean
     */
    public function getConfigurartarea()
    {
        return $this->configurartarea;
    }

    /**
     * Set configurarexamen
     *
     * @param boolean $configurarexamen
     *
     * @return CeCriterioevaluacion
     */
    public function setConfigurarexamen($configurarexamen)
    {
        $this->configurarexamen = $configurarexamen;

        return $this;
    }

    /**
     * Get configurarexamen
     *
     * @return boolean
     */
    public function getConfigurarexamen()
    {
        return $this->configurarexamen;
    }

    /**
     * Get criterioevaluacionid
     *
     * @return integer
     */
    public function getCriterioevaluacionid()
    {
        return $this->criterioevaluacionid;
    }

    /**
     * Set conjuntocriterioevaluacionid
     *
     * @param \AppBundle\Entity\CeConjuntocriterioevaluacion $conjuntocriterioevaluacionid
     *
     * @return CeCriterioevaluacion
     */
    public function setConjuntocriterioevaluacionid(\AppBundle\Entity\CeConjuntocriterioevaluacion $conjuntocriterioevaluacionid = null)
    {
        $this->conjuntocriterioevaluacionid = $conjuntocriterioevaluacionid;

        return $this;
    }

    /**
     * Get conjuntocriterioevaluacionid
     *
     * @return \AppBundle\Entity\CeConjuntocriterioevaluacion
     */
    public function getConjuntocriterioevaluacionid()
    {
        return $this->conjuntocriterioevaluacionid;
    }

    /**
     * Set periodoevaluacionid
     *
     * @param \AppBundle\Entity\CePeriodoevaluacion $periodoevaluacionid
     *
     * @return CeCriterioevaluacion
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

