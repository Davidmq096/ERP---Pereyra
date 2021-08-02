<?php

namespace AppBundle\Entity;

/**
 * CjDatoadicionalporbitacorapagoconbanco
 */
class CjDatoadicionalporbitacorapagoconbanco
{
    /**
     * @var string
     */
    private $dato;

    /**
     * @var string
     */
    private $valor;

    /**
     * @var integer
     */
    private $datoadicionalporbitacorapagoconbancoid;

    /**
     * @var \AppBundle\Entity\CjBitacorapagoconbanco
     */
    private $bitacorapagoconbancoid;


    /**
     * Set dato
     *
     * @param string $dato
     *
     * @return CjDatoadicionalporbitacorapagoconbanco
     */
    public function setDato($dato)
    {
        $this->dato = $dato;

        return $this;
    }

    /**
     * Get dato
     *
     * @return string
     */
    public function getDato()
    {
        return $this->dato;
    }

    /**
     * Set valor
     *
     * @param string $valor
     *
     * @return CjDatoadicionalporbitacorapagoconbanco
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Get datoadicionalporbitacorapagoconbancoid
     *
     * @return integer
     */
    public function getDatoadicionalporbitacorapagoconbancoid()
    {
        return $this->datoadicionalporbitacorapagoconbancoid;
    }

    /**
     * Set bitacorapagoconbancoid
     *
     * @param \AppBundle\Entity\CjBitacorapagoconbanco $bitacorapagoconbancoid
     *
     * @return CjDatoadicionalporbitacorapagoconbanco
     */
    public function setBitacorapagoconbancoid(\AppBundle\Entity\CjBitacorapagoconbanco $bitacorapagoconbancoid = null)
    {
        $this->bitacorapagoconbancoid = $bitacorapagoconbancoid;

        return $this;
    }

    /**
     * Get bitacorapagoconbancoid
     *
     * @return \AppBundle\Entity\CjBitacorapagoconbanco
     */
    public function getBitacorapagoconbancoid()
    {
        return $this->bitacorapagoconbancoid;
    }
}

