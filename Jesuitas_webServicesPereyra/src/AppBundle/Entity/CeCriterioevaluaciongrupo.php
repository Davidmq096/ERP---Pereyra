<?php

namespace AppBundle\Entity;

/**
 * CeCriterioevaluaciongrupo
 */
class CeCriterioevaluaciongrupo
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
    private $criterioevaluaciongrupoid;

    /**
     * @var \AppBundle\Entity\CePeriodoevaluacion
     */
    private $periodoevaluacionid;

    /**
     * @var \AppBundle\Entity\CeCriterioevaluacion
     */
    private $criterioevaluacionid;

    /**
     * @var \AppBundle\Entity\CeProfesorpormateriaplanestudios
     */
    private $profesorpormateriaplanestudiosid;


    /**
     * Set aspecto
     *
     * @param string $aspecto
     *
     * @return CeCriterioevaluaciongrupo
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
     * @return CeCriterioevaluaciongrupo
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
     * @return CeCriterioevaluaciongrupo
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
     * @return CeCriterioevaluaciongrupo
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
     * @return CeCriterioevaluaciongrupo
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
     * @return CeCriterioevaluaciongrupo
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
     * @return CeCriterioevaluaciongrupo
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
     * @return CeCriterioevaluaciongrupo
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
     * @return CeCriterioevaluaciongrupo
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
     * @return CeCriterioevaluaciongrupo
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
     * @return CeCriterioevaluaciongrupo
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
     * @return CeCriterioevaluaciongrupo
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
     * @return CeCriterioevaluaciongrupo
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
     * Get criterioevaluaciongrupoid
     *
     * @return integer
     */
    public function getCriterioevaluaciongrupoid()
    {
        return $this->criterioevaluaciongrupoid;
    }

    /**
     * Set periodoevaluacionid
     *
     * @param \AppBundle\Entity\CePeriodoevaluacion $periodoevaluacionid
     *
     * @return CeCriterioevaluaciongrupo
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
     * Set criterioevaluacionid
     *
     * @param \AppBundle\Entity\CeCriterioevaluacion $criterioevaluacionid
     *
     * @return CeCriterioevaluaciongrupo
     */
    public function setCriterioevaluacionid(\AppBundle\Entity\CeCriterioevaluacion $criterioevaluacionid = null)
    {
        $this->criterioevaluacionid = $criterioevaluacionid;

        return $this;
    }

    /**
     * Get criterioevaluacionid
     *
     * @return \AppBundle\Entity\CeCriterioevaluacion
     */
    public function getCriterioevaluacionid()
    {
        return $this->criterioevaluacionid;
    }

    /**
     * Set profesorpormateriaplanestudiosid
     *
     * @param \AppBundle\Entity\CeProfesorpormateriaplanestudios $profesorpormateriaplanestudiosid
     *
     * @return CeCriterioevaluaciongrupo
     */
    public function setProfesorpormateriaplanestudiosid(\AppBundle\Entity\CeProfesorpormateriaplanestudios $profesorpormateriaplanestudiosid = null)
    {
        $this->profesorpormateriaplanestudiosid = $profesorpormateriaplanestudiosid;

        return $this;
    }

    /**
     * Get profesorpormateriaplanestudiosid
     *
     * @return \AppBundle\Entity\CeProfesorpormateriaplanestudios
     */
    public function getProfesorpormateriaplanestudiosid()
    {
        return $this->profesorpormateriaplanestudiosid;
    }
}

