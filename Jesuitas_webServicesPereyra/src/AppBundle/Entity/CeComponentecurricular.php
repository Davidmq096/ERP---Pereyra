<?php

namespace AppBundle\Entity;

/**
 * CeComponentecurricular
 */
class CeComponentecurricular
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var boolean
     */
    private $mostrarcapturaopciones;

    /**
     * @var boolean
     */
    private $habilitarcapturaopciones;

    /**
     * @var boolean
     */
    private $realizarpromedioponderacion;

    /**
     * @var boolean
     */
    private $ponderacionparacapturaopciones;

    /**
     * @var integer
     */
    private $componentecurricularid;

    /**
     * @var \AppBundle\Entity\CePonderacion
     */
    private $ponderacionid;

    /**
     * @var \AppBundle\Entity\CeTipocalificacion
     */
    private $tipocalificacionid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeComponentecurricular
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
     * @return CeComponentecurricular
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
     * Set mostrarcapturaopciones
     *
     * @param boolean $mostrarcapturaopciones
     *
     * @return CeComponentecurricular
     */
    public function setMostrarcapturaopciones($mostrarcapturaopciones)
    {
        $this->mostrarcapturaopciones = $mostrarcapturaopciones;

        return $this;
    }

    /**
     * Get mostrarcapturaopciones
     *
     * @return boolean
     */
    public function getMostrarcapturaopciones()
    {
        return $this->mostrarcapturaopciones;
    }

    /**
     * Set habilitarcapturaopciones
     *
     * @param boolean $habilitarcapturaopciones
     *
     * @return CeComponentecurricular
     */
    public function setHabilitarcapturaopciones($habilitarcapturaopciones)
    {
        $this->habilitarcapturaopciones = $habilitarcapturaopciones;

        return $this;
    }

    /**
     * Get habilitarcapturaopciones
     *
     * @return boolean
     */
    public function getHabilitarcapturaopciones()
    {
        return $this->habilitarcapturaopciones;
    }

    /**
     * Set realizarpromedioponderacion
     *
     * @param boolean $realizarpromedioponderacion
     *
     * @return CeComponentecurricular
     */
    public function setRealizarpromedioponderacion($realizarpromedioponderacion)
    {
        $this->realizarpromedioponderacion = $realizarpromedioponderacion;

        return $this;
    }

    /**
     * Get realizarpromedioponderacion
     *
     * @return boolean
     */
    public function getRealizarpromedioponderacion()
    {
        return $this->realizarpromedioponderacion;
    }

    /**
     * Set ponderacionparacapturaopciones
     *
     * @param boolean $ponderacionparacapturaopciones
     *
     * @return CeComponentecurricular
     */
    public function setPonderacionparacapturaopciones($ponderacionparacapturaopciones)
    {
        $this->ponderacionparacapturaopciones = $ponderacionparacapturaopciones;

        return $this;
    }

    /**
     * Get ponderacionparacapturaopciones
     *
     * @return boolean
     */
    public function getPonderacionparacapturaopciones()
    {
        return $this->ponderacionparacapturaopciones;
    }

    /**
     * Get componentecurricularid
     *
     * @return integer
     */
    public function getComponentecurricularid()
    {
        return $this->componentecurricularid;
    }

    /**
     * Set ponderacionid
     *
     * @param \AppBundle\Entity\CePonderacion $ponderacionid
     *
     * @return CeComponentecurricular
     */
    public function setPonderacionid(\AppBundle\Entity\CePonderacion $ponderacionid = null)
    {
        $this->ponderacionid = $ponderacionid;

        return $this;
    }

    /**
     * Get ponderacionid
     *
     * @return \AppBundle\Entity\CePonderacion
     */
    public function getPonderacionid()
    {
        return $this->ponderacionid;
    }

    /**
     * Set tipocalificacionid
     *
     * @param \AppBundle\Entity\CeTipocalificacion $tipocalificacionid
     *
     * @return CeComponentecurricular
     */
    public function setTipocalificacionid(\AppBundle\Entity\CeTipocalificacion $tipocalificacionid = null)
    {
        $this->tipocalificacionid = $tipocalificacionid;

        return $this;
    }

    /**
     * Get tipocalificacionid
     *
     * @return \AppBundle\Entity\CeTipocalificacion
     */
    public function getTipocalificacionid()
    {
        return $this->tipocalificacionid;
    }
}

