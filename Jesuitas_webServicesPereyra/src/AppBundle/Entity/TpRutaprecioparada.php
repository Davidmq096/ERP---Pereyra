<?php

namespace AppBundle\Entity;

/**
 * TpRutaprecioparada
 */
class TpRutaprecioparada
{
    /**
     * @var integer
     */
    private $orden;

    /**
     * @var string
     */
    private $parada;

    /**
     * @var float
     */
    private $precio;

    /**
     * @var string
     */
    private $duracion;

    /**
     * @var string
     */
    private $coordenadas;

    /**
     * @var integer
     */
    private $rutaprecioparadaid;

    /**
     * @var \AppBundle\Entity\TpRuta
     */
    private $rutaid;


    /**
     * Set orden
     *
     * @param integer $orden
     *
     * @return TpRutaprecioparada
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
     * Set parada
     *
     * @param string $parada
     *
     * @return TpRutaprecioparada
     */
    public function setParada($parada)
    {
        $this->parada = $parada;

        return $this;
    }

    /**
     * Get parada
     *
     * @return string
     */
    public function getParada()
    {
        return $this->parada;
    }

    /**
     * Set precio
     *
     * @param float $precio
     *
     * @return TpRutaprecioparada
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get precio
     *
     * @return float
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set duracion
     *
     * @param string $duracion
     *
     * @return TpRutaprecioparada
     */
    public function setDuracion($duracion)
    {
        $this->duracion = $duracion;

        return $this;
    }

    /**
     * Get duracion
     *
     * @return string
     */
    public function getDuracion()
    {
        return $this->duracion;
    }

    /**
     * Set coordenadas
     *
     * @param string $coordenadas
     *
     * @return TpRutaprecioparada
     */
    public function setCoordenadas($coordenadas)
    {
        $this->coordenadas = $coordenadas;

        return $this;
    }

    /**
     * Get coordenadas
     *
     * @return string
     */
    public function getCoordenadas()
    {
        return $this->coordenadas;
    }

    /**
     * Get rutaprecioparadaid
     *
     * @return integer
     */
    public function getRutaprecioparadaid()
    {
        return $this->rutaprecioparadaid;
    }

    /**
     * Set rutaid
     *
     * @param \AppBundle\Entity\TpRuta $rutaid
     *
     * @return TpRutaprecioparada
     */
    public function setRutaid(\AppBundle\Entity\TpRuta $rutaid = null)
    {
        $this->rutaid = $rutaid;

        return $this;
    }

    /**
     * Get rutaid
     *
     * @return \AppBundle\Entity\TpRuta
     */
    public function getRutaid()
    {
        return $this->rutaid;
    }
}

