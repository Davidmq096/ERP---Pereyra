<?php

namespace AppBundle\Entity;

/**
 * CeConfiguracionhorario
 */
class CeConfiguracionhorario
{
    /**
     * @var integer
     */
    private $orden;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var \DateTime
     */
    private $horainicio;

    /**
     * @var \DateTime
     */
    private $horafin;

    /**
     * @var boolean
     */
    private $esclase;

    /**
     * @var integer
     */
    private $configuracionhorarioid;

    /**
     * @var \AppBundle\Entity\Ciclo
     */
    private $cicloid;

    /**
     * @var \AppBundle\Entity\Grado
     */
    private $gradoid;


    /**
     * Set orden
     *
     * @param integer $orden
     *
     * @return CeConfiguracionhorario
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;

        return $this;
    }

    /**
     * Get orden
     *
     * @return integer
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeConfiguracionhorario
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
     * Set horainicio
     *
     * @param \DateTime $horainicio
     *
     * @return CeConfiguracionhorario
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
     * @return CeConfiguracionhorario
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
     * Set esclase
     *
     * @param boolean $esclase
     *
     * @return CeConfiguracionhorario
     */
    public function setEsclase($esclase)
    {
        $this->esclase = $esclase;

        return $this;
    }

    /**
     * Get esclase
     *
     * @return boolean
     */
    public function getEsclase()
    {
        return $this->esclase;
    }

    /**
     * Get configuracionhorarioid
     *
     * @return integer
     */
    public function getConfiguracionhorarioid()
    {
        return $this->configuracionhorarioid;
    }

    /**
     * Set cicloid
     *
     * @param \AppBundle\Entity\Ciclo $cicloid
     *
     * @return CeConfiguracionhorario
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
     * @return CeConfiguracionhorario
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

