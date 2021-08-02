<?php

namespace AppBundle\Entity;

/**
 * BrExamenporcalendario
 */
class BrExamenporcalendario
{
    /**
     * @var integer
     */
    private $orden;

    /**
     * @var boolean
     */
    private $dependeanterior = '0';

    /**
     * @var float
     */
    private $puntajeminimo;

    /**
     * @var integer
     */
    private $intentospermitidos = '1';

    /**
     * @var boolean
     */
    private $limitartiempo = '0';

    /**
     * @var \DateTime
     */
    private $tiempo;

    /**
     * @var boolean
     */
    private $mostrartiempo = '0';

    /**
     * @var integer
     */
    private $numerocaptura;

    /**
     * @var integer
     */
    private $examenporcalendarioid;

    /**
     * @var \AppBundle\Entity\BrCalendarioexamen
     */
    private $calendarioexamenid;

    /**
     * @var \AppBundle\Entity\BrExamen
     */
    private $examenid;

    /**
     * @var \AppBundle\Entity\CeCriterioevaluaciongrupo
     */
    private $criterioevaluaciongrupoid;


    /**
     * Set orden
     *
     * @param integer $orden
     *
     * @return BrExamenporcalendario
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
     * Set dependeanterior
     *
     * @param boolean $dependeanterior
     *
     * @return BrExamenporcalendario
     */
    public function setDependeanterior($dependeanterior)
    {
        $this->dependeanterior = $dependeanterior;

        return $this;
    }

    /**
     * Get dependeanterior
     *
     * @return boolean
     */
    public function getDependeanterior()
    {
        return $this->dependeanterior;
    }

    /**
     * Set puntajeminimo
     *
     * @param float $puntajeminimo
     *
     * @return BrExamenporcalendario
     */
    public function setPuntajeminimo($puntajeminimo)
    {
        $this->puntajeminimo = $puntajeminimo;

        return $this;
    }

    /**
     * Get puntajeminimo
     *
     * @return float
     */
    public function getPuntajeminimo()
    {
        return $this->puntajeminimo;
    }

    /**
     * Set intentospermitidos
     *
     * @param integer $intentospermitidos
     *
     * @return BrExamenporcalendario
     */
    public function setIntentospermitidos($intentospermitidos)
    {
        $this->intentospermitidos = $intentospermitidos;

        return $this;
    }

    /**
     * Get intentospermitidos
     *
     * @return integer
     */
    public function getIntentospermitidos()
    {
        return $this->intentospermitidos;
    }

    /**
     * Set limitartiempo
     *
     * @param boolean $limitartiempo
     *
     * @return BrExamenporcalendario
     */
    public function setLimitartiempo($limitartiempo)
    {
        $this->limitartiempo = $limitartiempo;

        return $this;
    }

    /**
     * Get limitartiempo
     *
     * @return boolean
     */
    public function getLimitartiempo()
    {
        return $this->limitartiempo;
    }

    /**
     * Set tiempo
     *
     * @param \DateTime $tiempo
     *
     * @return BrExamenporcalendario
     */
    public function setTiempo($tiempo)
    {
        $this->tiempo = $tiempo;

        return $this;
    }

    /**
     * Get tiempo
     *
     * @return \DateTime
     */
    public function getTiempo()
    {
        return $this->tiempo;
    }

    /**
     * Set mostrartiempo
     *
     * @param boolean $mostrartiempo
     *
     * @return BrExamenporcalendario
     */
    public function setMostrartiempo($mostrartiempo)
    {
        $this->mostrartiempo = $mostrartiempo;

        return $this;
    }

    /**
     * Get mostrartiempo
     *
     * @return boolean
     */
    public function getMostrartiempo()
    {
        return $this->mostrartiempo;
    }

    /**
     * Set numerocaptura
     *
     * @param integer $numerocaptura
     *
     * @return BrExamenporcalendario
     */
    public function setNumerocaptura($numerocaptura)
    {
        $this->numerocaptura = $numerocaptura;

        return $this;
    }

    /**
     * Get numerocaptura
     *
     * @return integer
     */
    public function getNumerocaptura()
    {
        return $this->numerocaptura;
    }

    /**
     * Get examenporcalendarioid
     *
     * @return integer
     */
    public function getExamenporcalendarioid()
    {
        return $this->examenporcalendarioid;
    }

    /**
     * Set calendarioexamenid
     *
     * @param \AppBundle\Entity\BrCalendarioexamen $calendarioexamenid
     *
     * @return BrExamenporcalendario
     */
    public function setCalendarioexamenid(\AppBundle\Entity\BrCalendarioexamen $calendarioexamenid = null)
    {
        $this->calendarioexamenid = $calendarioexamenid;

        return $this;
    }

    /**
     * Get calendarioexamenid
     *
     * @return \AppBundle\Entity\BrCalendarioexamen
     */
    public function getCalendarioexamenid()
    {
        return $this->calendarioexamenid;
    }

    /**
     * Set examenid
     *
     * @param \AppBundle\Entity\BrExamen $examenid
     *
     * @return BrExamenporcalendario
     */
    public function setExamenid(\AppBundle\Entity\BrExamen $examenid = null)
    {
        $this->examenid = $examenid;

        return $this;
    }

    /**
     * Get examenid
     *
     * @return \AppBundle\Entity\BrExamen
     */
    public function getExamenid()
    {
        return $this->examenid;
    }

    /**
     * Set criterioevaluaciongrupoid
     *
     * @param \AppBundle\Entity\CeCriterioevaluaciongrupo $criterioevaluaciongrupoid
     *
     * @return BrExamenporcalendario
     */
    public function setCriterioevaluaciongrupoid(\AppBundle\Entity\CeCriterioevaluaciongrupo $criterioevaluaciongrupoid = null)
    {
        $this->criterioevaluaciongrupoid = $criterioevaluaciongrupoid;

        return $this;
    }

    /**
     * Get criterioevaluaciongrupoid
     *
     * @return \AppBundle\Entity\CeCriterioevaluaciongrupo
     */
    public function getCriterioevaluaciongrupoid()
    {
        return $this->criterioevaluaciongrupoid;
    }
}

