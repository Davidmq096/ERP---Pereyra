<?php

namespace AppBundle\Entity;

/**
 * CeConductacalificacionescala
 */
class CeConductacalificacionescala
{
    /**
     * @var float
     */
    private $minimo;

    /**
     * @var float
     */
    private $maximo;

    /**
     * @var string
     */
    private $resultado;

    /**
     * @var integer
     */
    private $conductacalificacionescalaid;


    /**
     * Set minimo
     *
     * @param float $minimo
     *
     * @return CeConductacalificacionescala
     */
    public function setMinimo($minimo)
    {
        $this->minimo = $minimo;

        return $this;
    }

    /**
     * Get minimo
     *
     * @return float
     */
    public function getMinimo()
    {
        return $this->minimo;
    }

    /**
     * Set maximo
     *
     * @param float $maximo
     *
     * @return CeConductacalificacionescala
     */
    public function setMaximo($maximo)
    {
        $this->maximo = $maximo;

        return $this;
    }

    /**
     * Get maximo
     *
     * @return float
     */
    public function getMaximo()
    {
        return $this->maximo;
    }

    /**
     * Set resultado
     *
     * @param string $resultado
     *
     * @return CeConductacalificacionescala
     */
    public function setResultado($resultado)
    {
        $this->resultado = $resultado;

        return $this;
    }

    /**
     * Get resultado
     *
     * @return string
     */
    public function getResultado()
    {
        return $this->resultado;
    }

    /**
     * Get conductacalificacionescalaid
     *
     * @return integer
     */
    public function getConductacalificacionescalaid()
    {
        return $this->conductacalificacionescalaid;
    }
}

