<?php

namespace AppBundle\Entity;

/**
 * CePlanestudios
 */
class CePlanestudios
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var boolean
     */
    private $vigente = '0';

    /**
     * @var integer
     */
    private $puntopase;

    /**
     * @var integer
     */
    private $calificacionminima;

    /**
     * @var integer
     */
    private $decimalescapturanumerica;

    /**
     * @var integer
     */
    private $calificacionextraordinario;

    /**
     * @var integer
     */
    private $planestudioid;

    /**
     * @var \AppBundle\Entity\CeAreaespecializacion
     */
    private $areaespecializacionid;

    /**
     * @var \AppBundle\Entity\Ciclo
     */
    private $ciclofinalid;

    /**
     * @var \AppBundle\Entity\Ciclo
     */
    private $cicloinicialid;

    /**
     * @var \AppBundle\Entity\Grado
     */
    private $gradoid;

    /**
     * @var \AppBundle\Entity\CeTiporedondeo
     */
    private $tiporedondeofinalid;

    /**
     * @var \AppBundle\Entity\CeTiporedondeo
     */
    private $tiporedondeoperiodoid;

    /**
     * @var \AppBundle\Entity\CeTiporedondeo
     */
    private $tiporedondeocalfinalid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CePlanestudios
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
     * Set vigente
     *
     * @param boolean $vigente
     *
     * @return CePlanestudios
     */
    public function setVigente($vigente)
    {
        $this->vigente = $vigente;

        return $this;
    }

    /**
     * Get vigente
     *
     * @return boolean
     */
    public function getVigente()
    {
        return $this->vigente;
    }

    /**
     * Set puntopase
     *
     * @param integer $puntopase
     *
     * @return CePlanestudios
     */
    public function setPuntopase($puntopase)
    {
        $this->puntopase = $puntopase;

        return $this;
    }

    /**
     * Get puntopase
     *
     * @return integer
     */
    public function getPuntopase()
    {
        return $this->puntopase;
    }

    /**
     * Set calificacionminima
     *
     * @param integer $calificacionminima
     *
     * @return CePlanestudios
     */
    public function setCalificacionminima($calificacionminima)
    {
        $this->calificacionminima = $calificacionminima;

        return $this;
    }

    /**
     * Get calificacionminima
     *
     * @return integer
     */
    public function getCalificacionminima()
    {
        return $this->calificacionminima;
    }

    /**
     * Set decimalescapturanumerica
     *
     * @param integer $decimalescapturanumerica
     *
     * @return CePlanestudios
     */
    public function setDecimalescapturanumerica($decimalescapturanumerica)
    {
        $this->decimalescapturanumerica = $decimalescapturanumerica;

        return $this;
    }

    /**
     * Get decimalescapturanumerica
     *
     * @return integer
     */
    public function getDecimalescapturanumerica()
    {
        return $this->decimalescapturanumerica;
    }

    /**
     * Set calificacionextraordinario
     *
     * @param integer $calificacionextraordinario
     *
     * @return CePlanestudios
     */
    public function setCalificacionextraordinario($calificacionextraordinario)
    {
        $this->calificacionextraordinario = $calificacionextraordinario;

        return $this;
    }

    /**
     * Get calificacionextraordinario
     *
     * @return integer
     */
    public function getCalificacionextraordinario()
    {
        return $this->calificacionextraordinario;
    }

    /**
     * Get planestudioid
     *
     * @return integer
     */
    public function getPlanestudioid()
    {
        return $this->planestudioid;
    }

    /**
     * Set areaespecializacionid
     *
     * @param \AppBundle\Entity\CeAreaespecializacion $areaespecializacionid
     *
     * @return CePlanestudios
     */
    public function setAreaespecializacionid(\AppBundle\Entity\CeAreaespecializacion $areaespecializacionid = null)
    {
        $this->areaespecializacionid = $areaespecializacionid;

        return $this;
    }

    /**
     * Get areaespecializacionid
     *
     * @return \AppBundle\Entity\CeAreaespecializacion
     */
    public function getAreaespecializacionid()
    {
        return $this->areaespecializacionid;
    }

    /**
     * Set ciclofinalid
     *
     * @param \AppBundle\Entity\Ciclo $ciclofinalid
     *
     * @return CePlanestudios
     */
    public function setCiclofinalid(\AppBundle\Entity\Ciclo $ciclofinalid = null)
    {
        $this->ciclofinalid = $ciclofinalid;

        return $this;
    }

    /**
     * Get ciclofinalid
     *
     * @return \AppBundle\Entity\Ciclo
     */
    public function getCiclofinalid()
    {
        return $this->ciclofinalid;
    }

    /**
     * Set cicloinicialid
     *
     * @param \AppBundle\Entity\Ciclo $cicloinicialid
     *
     * @return CePlanestudios
     */
    public function setCicloinicialid(\AppBundle\Entity\Ciclo $cicloinicialid = null)
    {
        $this->cicloinicialid = $cicloinicialid;

        return $this;
    }

    /**
     * Get cicloinicialid
     *
     * @return \AppBundle\Entity\Ciclo
     */
    public function getCicloinicialid()
    {
        return $this->cicloinicialid;
    }

    /**
     * Set gradoid
     *
     * @param \AppBundle\Entity\Grado $gradoid
     *
     * @return CePlanestudios
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

    /**
     * Set tiporedondeofinalid
     *
     * @param \AppBundle\Entity\CeTiporedondeo $tiporedondeofinalid
     *
     * @return CePlanestudios
     */
    public function setTiporedondeofinalid(\AppBundle\Entity\CeTiporedondeo $tiporedondeofinalid = null)
    {
        $this->tiporedondeofinalid = $tiporedondeofinalid;

        return $this;
    }

    /**
     * Get tiporedondeofinalid
     *
     * @return \AppBundle\Entity\CeTiporedondeo
     */
    public function getTiporedondeofinalid()
    {
        return $this->tiporedondeofinalid;
    }

    /**
     * Set tiporedondeoperiodoid
     *
     * @param \AppBundle\Entity\CeTiporedondeo $tiporedondeoperiodoid
     *
     * @return CePlanestudios
     */
    public function setTiporedondeoperiodoid(\AppBundle\Entity\CeTiporedondeo $tiporedondeoperiodoid = null)
    {
        $this->tiporedondeoperiodoid = $tiporedondeoperiodoid;

        return $this;
    }

    /**
     * Get tiporedondeoperiodoid
     *
     * @return \AppBundle\Entity\CeTiporedondeo
     */
    public function getTiporedondeoperiodoid()
    {
        return $this->tiporedondeoperiodoid;
    }

    /**
     * Set tiporedondeocalfinalid
     *
     * @param \AppBundle\Entity\CeTiporedondeo $tiporedondeocalfinalid
     *
     * @return CePlanestudios
     */
    public function setTiporedondeocalfinalid(\AppBundle\Entity\CeTiporedondeo $tiporedondeocalfinalid = null)
    {
        $this->tiporedondeocalfinalid = $tiporedondeocalfinalid;

        return $this;
    }

    /**
     * Get tiporedondeocalfinalid
     *
     * @return \AppBundle\Entity\CeTiporedondeo
     */
    public function getTiporedondeocalfinalid()
    {
        return $this->tiporedondeocalfinalid;
    }
}

