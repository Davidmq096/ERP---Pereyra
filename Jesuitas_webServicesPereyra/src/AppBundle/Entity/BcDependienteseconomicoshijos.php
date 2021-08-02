<?php

namespace AppBundle\Entity;

/**
 * BcDependienteseconomicoshijos
 */
class BcDependienteseconomicoshijos
{
    /**
     * @var string
     */
    private $nombrecompleto;

    /**
     * @var string
     */
    private $nombreescuela;

    /**
     * @var string
     */
    private $nivel;

    /**
     * @var string
     */
    private $grado;

    /**
     * @var string
     */
    private $costoanual;

    /**
     * @var string
     */
    private $porcentaje;

    /**
     * @var string
     */
    private $otorgadopor;

    /**
     * @var boolean
     */
    private $tienebeca;

    /**
     * @var integer
     */
    private $dependienteseconomicosid;

    /**
     * @var \AppBundle\Entity\BcSolicitudbeca
     */
    private $solicitudid;


    /**
     * Set nombrecompleto
     *
     * @param string $nombrecompleto
     *
     * @return BcDependienteseconomicoshijos
     */
    public function setNombrecompleto($nombrecompleto)
    {
        $this->nombrecompleto = $nombrecompleto;

        return $this;
    }

    /**
     * Get nombrecompleto
     *
     * @return string
     */
    public function getNombrecompleto()
    {
        return $this->nombrecompleto;
    }

    /**
     * Set nombreescuela
     *
     * @param string $nombreescuela
     *
     * @return BcDependienteseconomicoshijos
     */
    public function setNombreescuela($nombreescuela)
    {
        $this->nombreescuela = $nombreescuela;

        return $this;
    }

    /**
     * Get nombreescuela
     *
     * @return string
     */
    public function getNombreescuela()
    {
        return $this->nombreescuela;
    }

    /**
     * Set nivel
     *
     * @param string $nivel
     *
     * @return BcDependienteseconomicoshijos
     */
    public function setNivel($nivel)
    {
        $this->nivel = $nivel;

        return $this;
    }

    /**
     * Get nivel
     *
     * @return string
     */
    public function getNivel()
    {
        return $this->nivel;
    }

    /**
     * Set grado
     *
     * @param string $grado
     *
     * @return BcDependienteseconomicoshijos
     */
    public function setGrado($grado)
    {
        $this->grado = $grado;

        return $this;
    }

    /**
     * Get grado
     *
     * @return string
     */
    public function getGrado()
    {
        return $this->grado;
    }

    /**
     * Set costoanual
     *
     * @param string $costoanual
     *
     * @return BcDependienteseconomicoshijos
     */
    public function setCostoanual($costoanual)
    {
        $this->costoanual = $costoanual;

        return $this;
    }

    /**
     * Get costoanual
     *
     * @return string
     */
    public function getCostoanual()
    {
        return $this->costoanual;
    }

    /**
     * Set porcentaje
     *
     * @param string $porcentaje
     *
     * @return BcDependienteseconomicoshijos
     */
    public function setPorcentaje($porcentaje)
    {
        $this->porcentaje = $porcentaje;

        return $this;
    }

    /**
     * Get porcentaje
     *
     * @return string
     */
    public function getPorcentaje()
    {
        return $this->porcentaje;
    }

    /**
     * Set otorgadopor
     *
     * @param string $otorgadopor
     *
     * @return BcDependienteseconomicoshijos
     */
    public function setOtorgadopor($otorgadopor)
    {
        $this->otorgadopor = $otorgadopor;

        return $this;
    }

    /**
     * Get otorgadopor
     *
     * @return string
     */
    public function getOtorgadopor()
    {
        return $this->otorgadopor;
    }

    /**
     * Set tienebeca
     *
     * @param boolean $tienebeca
     *
     * @return BcDependienteseconomicoshijos
     */
    public function setTienebeca($tienebeca)
    {
        $this->tienebeca = $tienebeca;

        return $this;
    }

    /**
     * Get tienebeca
     *
     * @return boolean
     */
    public function getTienebeca()
    {
        return $this->tienebeca;
    }

    /**
     * Get dependienteseconomicosid
     *
     * @return integer
     */
    public function getDependienteseconomicosid()
    {
        return $this->dependienteseconomicosid;
    }

    /**
     * Set solicitudid
     *
     * @param \AppBundle\Entity\BcSolicitudbeca $solicitudid
     *
     * @return BcDependienteseconomicoshijos
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
}

