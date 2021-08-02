<?php

namespace AppBundle\Entity;

/**
 * TpRuta
 */
class TpRuta
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var integer
     */
    private $capacidad;

    /**
     * @var float
     */
    private $preciocontrato;

    /**
     * @var integer
     */
    private $tipoviaje;

    /**
     * @var integer
     */
    private $tipoprecio;

    /**
     * @var \DateTime
     */
    private $vigenciainicio;

    /**
     * @var \DateTime
     */
    private $vigenciafin;

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
    private $sabado;

    /**
     * @var boolean
     */
    private $domingo;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var string
     */
    private $alias;

    /**
     * @var integer
     */
    private $rutaid;

    /**
     * @var \AppBundle\Entity\CjSubconcepto
     */
    private $subconceptoid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return TpRuta
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
     * Set capacidad
     *
     * @param integer $capacidad
     *
     * @return TpRuta
     */
    public function setCapacidad($capacidad)
    {
        $this->capacidad = $capacidad;

        return $this;
    }

    /**
     * Get capacidad
     *
     * @return integer
     */
    public function getCapacidad()
    {
        return $this->capacidad;
    }

    /**
     * Set preciocontrato
     *
     * @param float $preciocontrato
     *
     * @return TpRuta
     */
    public function setPreciocontrato($preciocontrato)
    {
        $this->preciocontrato = $preciocontrato;

        return $this;
    }

    /**
     * Get preciocontrato
     *
     * @return float
     */
    public function getPreciocontrato()
    {
        return $this->preciocontrato;
    }

    /**
     * Set tipoviaje
     *
     * @param integer $tipoviaje
     *
     * @return TpRuta
     */
    public function setTipoviaje($tipoviaje)
    {
        $this->tipoviaje = $tipoviaje;

        return $this;
    }

    /**
     * Get tipoviaje
     *
     * @return integer
     */
    public function getTipoviaje()
    {
        return $this->tipoviaje;
    }

    /**
     * Set tipoprecio
     *
     * @param integer $tipoprecio
     *
     * @return TpRuta
     */
    public function setTipoprecio($tipoprecio)
    {
        $this->tipoprecio = $tipoprecio;

        return $this;
    }

    /**
     * Get tipoprecio
     *
     * @return integer
     */
    public function getTipoprecio()
    {
        return $this->tipoprecio;
    }

    /**
     * Set vigenciainicio
     *
     * @param \DateTime $vigenciainicio
     *
     * @return TpRuta
     */
    public function setVigenciainicio($vigenciainicio)
    {
        $this->vigenciainicio = $vigenciainicio;

        return $this;
    }

    /**
     * Get vigenciainicio
     *
     * @return \DateTime
     */
    public function getVigenciainicio()
    {
        return $this->vigenciainicio;
    }

    /**
     * Set vigenciafin
     *
     * @param \DateTime $vigenciafin
     *
     * @return TpRuta
     */
    public function setVigenciafin($vigenciafin)
    {
        $this->vigenciafin = $vigenciafin;

        return $this;
    }

    /**
     * Get vigenciafin
     *
     * @return \DateTime
     */
    public function getVigenciafin()
    {
        return $this->vigenciafin;
    }

    /**
     * Set horainicio
     *
     * @param \DateTime $horainicio
     *
     * @return TpRuta
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
     * @return TpRuta
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
     * Set sabado
     *
     * @param boolean $sabado
     *
     * @return TpRuta
     */
    public function setSabado($sabado)
    {
        $this->sabado = $sabado;

        return $this;
    }

    /**
     * Get sabado
     *
     * @return boolean
     */
    public function getSabado()
    {
        return $this->sabado;
    }

    /**
     * Set domingo
     *
     * @param boolean $domingo
     *
     * @return TpRuta
     */
    public function setDomingo($domingo)
    {
        $this->domingo = $domingo;

        return $this;
    }

    /**
     * Get domingo
     *
     * @return boolean
     */
    public function getDomingo()
    {
        return $this->domingo;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return TpRuta
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
     * Set alias
     *
     * @param string $alias
     *
     * @return TpRuta
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get alias
     *
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Get rutaid
     *
     * @return integer
     */
    public function getRutaid()
    {
        return $this->rutaid;
    }

    /**
     * Set subconceptoid
     *
     * @param \AppBundle\Entity\CjSubconcepto $subconceptoid
     *
     * @return TpRuta
     */
    public function setSubconceptoid(\AppBundle\Entity\CjSubconcepto $subconceptoid = null)
    {
        $this->subconceptoid = $subconceptoid;

        return $this;
    }

    /**
     * Get subconceptoid
     *
     * @return \AppBundle\Entity\CjSubconcepto
     */
    public function getSubconceptoid()
    {
        return $this->subconceptoid;
    }
}

