<?php

namespace AppBundle\Entity;

/**
 * CeConfiguracionpantallacalificaciones
 */
class CeConfiguracionpantallacalificaciones
{
    /**
     * @var boolean
     */
    private $consultaportalpadres = '1';

    /**
     * @var boolean
     */
    private $boletaportalpadres = '1';

    /**
     * @var boolean
     */
    private $consultaapppadres = '1';

    /**
     * @var boolean
     */
    private $boletaapppadres = '1';

    /**
     * @var boolean
     */
    private $consultaportalalumnos = '1';

    /**
     * @var boolean
     */
    private $boletaportalalumnos = '1';

    /**
     * @var boolean
     */
    private $consultaappalumnos = '1';

    /**
     * @var boolean
     */
    private $boletaappalumnos = '1';

    /**
     * @var integer
     */
    private $configuracionpantallacalificacionid;

    /**
     * @var \AppBundle\Entity\Grado
     */
    private $gradoid;


    /**
     * Set consultaportalpadres
     *
     * @param boolean $consultaportalpadres
     *
     * @return CeConfiguracionpantallacalificaciones
     */
    public function setConsultaportalpadres($consultaportalpadres)
    {
        $this->consultaportalpadres = $consultaportalpadres;

        return $this;
    }

    /**
     * Get consultaportalpadres
     *
     * @return boolean
     */
    public function getConsultaportalpadres()
    {
        return $this->consultaportalpadres;
    }

    /**
     * Set boletaportalpadres
     *
     * @param boolean $boletaportalpadres
     *
     * @return CeConfiguracionpantallacalificaciones
     */
    public function setBoletaportalpadres($boletaportalpadres)
    {
        $this->boletaportalpadres = $boletaportalpadres;

        return $this;
    }

    /**
     * Get boletaportalpadres
     *
     * @return boolean
     */
    public function getBoletaportalpadres()
    {
        return $this->boletaportalpadres;
    }

    /**
     * Set consultaapppadres
     *
     * @param boolean $consultaapppadres
     *
     * @return CeConfiguracionpantallacalificaciones
     */
    public function setConsultaapppadres($consultaapppadres)
    {
        $this->consultaapppadres = $consultaapppadres;

        return $this;
    }

    /**
     * Get consultaapppadres
     *
     * @return boolean
     */
    public function getConsultaapppadres()
    {
        return $this->consultaapppadres;
    }

    /**
     * Set boletaapppadres
     *
     * @param boolean $boletaapppadres
     *
     * @return CeConfiguracionpantallacalificaciones
     */
    public function setBoletaapppadres($boletaapppadres)
    {
        $this->boletaapppadres = $boletaapppadres;

        return $this;
    }

    /**
     * Get boletaapppadres
     *
     * @return boolean
     */
    public function getBoletaapppadres()
    {
        return $this->boletaapppadres;
    }

    /**
     * Set consultaportalalumnos
     *
     * @param boolean $consultaportalalumnos
     *
     * @return CeConfiguracionpantallacalificaciones
     */
    public function setConsultaportalalumnos($consultaportalalumnos)
    {
        $this->consultaportalalumnos = $consultaportalalumnos;

        return $this;
    }

    /**
     * Get consultaportalalumnos
     *
     * @return boolean
     */
    public function getConsultaportalalumnos()
    {
        return $this->consultaportalalumnos;
    }

    /**
     * Set boletaportalalumnos
     *
     * @param boolean $boletaportalalumnos
     *
     * @return CeConfiguracionpantallacalificaciones
     */
    public function setBoletaportalalumnos($boletaportalalumnos)
    {
        $this->boletaportalalumnos = $boletaportalalumnos;

        return $this;
    }

    /**
     * Get boletaportalalumnos
     *
     * @return boolean
     */
    public function getBoletaportalalumnos()
    {
        return $this->boletaportalalumnos;
    }

    /**
     * Set consultaappalumnos
     *
     * @param boolean $consultaappalumnos
     *
     * @return CeConfiguracionpantallacalificaciones
     */
    public function setConsultaappalumnos($consultaappalumnos)
    {
        $this->consultaappalumnos = $consultaappalumnos;

        return $this;
    }

    /**
     * Get consultaappalumnos
     *
     * @return boolean
     */
    public function getConsultaappalumnos()
    {
        return $this->consultaappalumnos;
    }

    /**
     * Set boletaappalumnos
     *
     * @param boolean $boletaappalumnos
     *
     * @return CeConfiguracionpantallacalificaciones
     */
    public function setBoletaappalumnos($boletaappalumnos)
    {
        $this->boletaappalumnos = $boletaappalumnos;

        return $this;
    }

    /**
     * Get boletaappalumnos
     *
     * @return boolean
     */
    public function getBoletaappalumnos()
    {
        return $this->boletaappalumnos;
    }

    /**
     * Get configuracionpantallacalificacionid
     *
     * @return integer
     */
    public function getConfiguracionpantallacalificacionid()
    {
        return $this->configuracionpantallacalificacionid;
    }

    /**
     * Set gradoid
     *
     * @param \AppBundle\Entity\Grado $gradoid
     *
     * @return CeConfiguracionpantallacalificaciones
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
}

