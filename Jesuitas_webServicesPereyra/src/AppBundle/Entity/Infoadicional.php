<?php

namespace AppBundle\Entity;

/**
 * Infoadicional
 */
class Infoadicional
{
    /**
     * @var string
     */
    private $estadosalud;

    /**
     * @var string
     */
    private $aspectosinportantes;

    /**
     * @var boolean
     */
    private $necesidadespecial;

    /**
     * @var string
     */
    private $descripcionnecesidad;

    /**
     * @var boolean
     */
    private $hijopersonal;

    /**
     * @var boolean
     */
    private $alumnoinstituto;

    /**
     * @var integer
     */
    private $infoadicionalid;


    /**
     * Set estadosalud
     *
     * @param string $estadosalud
     *
     * @return Infoadicional
     */
    public function setEstadosalud($estadosalud)
    {
        $this->estadosalud = $estadosalud;

        return $this;
    }

    /**
     * Get estadosalud
     *
     * @return string
     */
    public function getEstadosalud()
    {
        return $this->estadosalud;
    }

    /**
     * Set aspectosinportantes
     *
     * @param string $aspectosinportantes
     *
     * @return Infoadicional
     */
    public function setAspectosinportantes($aspectosinportantes)
    {
        $this->aspectosinportantes = $aspectosinportantes;

        return $this;
    }

    /**
     * Get aspectosinportantes
     *
     * @return string
     */
    public function getAspectosinportantes()
    {
        return $this->aspectosinportantes;
    }

    /**
     * Set necesidadespecial
     *
     * @param boolean $necesidadespecial
     *
     * @return Infoadicional
     */
    public function setNecesidadespecial($necesidadespecial)
    {
        $this->necesidadespecial = $necesidadespecial;

        return $this;
    }

    /**
     * Get necesidadespecial
     *
     * @return boolean
     */
    public function getNecesidadespecial()
    {
        return $this->necesidadespecial;
    }

    /**
     * Set descripcionnecesidad
     *
     * @param string $descripcionnecesidad
     *
     * @return Infoadicional
     */
    public function setDescripcionnecesidad($descripcionnecesidad)
    {
        $this->descripcionnecesidad = $descripcionnecesidad;

        return $this;
    }

    /**
     * Get descripcionnecesidad
     *
     * @return string
     */
    public function getDescripcionnecesidad()
    {
        return $this->descripcionnecesidad;
    }

    /**
     * Set hijopersonal
     *
     * @param boolean $hijopersonal
     *
     * @return Infoadicional
     */
    public function setHijopersonal($hijopersonal)
    {
        $this->hijopersonal = $hijopersonal;

        return $this;
    }

    /**
     * Get hijopersonal
     *
     * @return boolean
     */
    public function getHijopersonal()
    {
        return $this->hijopersonal;
    }

    /**
     * Set alumnoinstituto
     *
     * @param boolean $alumnoinstituto
     *
     * @return Infoadicional
     */
    public function setAlumnoinstituto($alumnoinstituto)
    {
        $this->alumnoinstituto = $alumnoinstituto;

        return $this;
    }

    /**
     * Get alumnoinstituto
     *
     * @return boolean
     */
    public function getAlumnoinstituto()
    {
        return $this->alumnoinstituto;
    }

    /**
     * Get infoadicionalid
     *
     * @return integer
     */
    public function getInfoadicionalid()
    {
        return $this->infoadicionalid;
    }
}

