<?php

namespace AppBundle\Entity;

/**
 * CeConfiguracionnivel
 */
class CeConfiguracionnivel
{
    /**
     * @var boolean
     */
    private $configurarapoyos = '0';

    /**
     * @var boolean
     */
    private $configurarobservaciones = '0';

    /**
     * @var boolean
     */
    private $configurarmaestrotitular = '0';

    /**
     * @var boolean
     */
    private $configurarmaestrocotitular = '0';

    /**
     * @var boolean
     */
    private $capturacalificacionvistaalumnos = '0';

    /**
     * @var boolean
     */
    private $asistenciapordia;

    /**
     * @var integer
     */
    private $configuracionnivelid;


    /**
     * Set configurarapoyos
     *
     * @param boolean $configurarapoyos
     *
     * @return CeConfiguracionnivel
     */
    public function setConfigurarapoyos($configurarapoyos)
    {
        $this->configurarapoyos = $configurarapoyos;

        return $this;
    }

    /**
     * Get configurarapoyos
     *
     * @return boolean
     */
    public function getConfigurarapoyos()
    {
        return $this->configurarapoyos;
    }

    /**
     * Set configurarobservaciones
     *
     * @param boolean $configurarobservaciones
     *
     * @return CeConfiguracionnivel
     */
    public function setConfigurarobservaciones($configurarobservaciones)
    {
        $this->configurarobservaciones = $configurarobservaciones;

        return $this;
    }

    /**
     * Get configurarobservaciones
     *
     * @return boolean
     */
    public function getConfigurarobservaciones()
    {
        return $this->configurarobservaciones;
    }

    /**
     * Set configurarmaestrotitular
     *
     * @param boolean $configurarmaestrotitular
     *
     * @return CeConfiguracionnivel
     */
    public function setConfigurarmaestrotitular($configurarmaestrotitular)
    {
        $this->configurarmaestrotitular = $configurarmaestrotitular;

        return $this;
    }

    /**
     * Get configurarmaestrotitular
     *
     * @return boolean
     */
    public function getConfigurarmaestrotitular()
    {
        return $this->configurarmaestrotitular;
    }

    /**
     * Set configurarmaestrocotitular
     *
     * @param boolean $configurarmaestrocotitular
     *
     * @return CeConfiguracionnivel
     */
    public function setConfigurarmaestrocotitular($configurarmaestrocotitular)
    {
        $this->configurarmaestrocotitular = $configurarmaestrocotitular;

        return $this;
    }

    /**
     * Get configurarmaestrocotitular
     *
     * @return boolean
     */
    public function getConfigurarmaestrocotitular()
    {
        return $this->configurarmaestrocotitular;
    }

    /**
     * Set capturacalificacionvistaalumnos
     *
     * @param boolean $capturacalificacionvistaalumnos
     *
     * @return CeConfiguracionnivel
     */
    public function setCapturacalificacionvistaalumnos($capturacalificacionvistaalumnos)
    {
        $this->capturacalificacionvistaalumnos = $capturacalificacionvistaalumnos;

        return $this;
    }

    /**
     * Get capturacalificacionvistaalumnos
     *
     * @return boolean
     */
    public function getCapturacalificacionvistaalumnos()
    {
        return $this->capturacalificacionvistaalumnos;
    }

    /**
     * Set asistenciapordia
     *
     * @param boolean $asistenciapordia
     *
     * @return CeConfiguracionnivel
     */
    public function setAsistenciapordia($asistenciapordia)
    {
        $this->asistenciapordia = $asistenciapordia;

        return $this;
    }

    /**
     * Get asistenciapordia
     *
     * @return boolean
     */
    public function getAsistenciapordia()
    {
        return $this->asistenciapordia;
    }

    /**
     * Get configuracionnivelid
     *
     * @return integer
     */
    public function getConfiguracionnivelid()
    {
        return $this->configuracionnivelid;
    }
}

