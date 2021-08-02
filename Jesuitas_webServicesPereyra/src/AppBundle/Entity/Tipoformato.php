<?php

namespace AppBundle\Entity;

/**
 * Tipoformato
 */
class Tipoformato
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var boolean
     */
    private $restringido;

    /**
     * @var integer
     */
    private $tipoformatoid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Tipoformato
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
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Tipoformato
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
     * Set restringido
     *
     * @param boolean $restringido
     *
     * @return Tipoformato
     */
    public function setRestringido($restringido)
    {
        $this->restringido = $restringido;

        return $this;
    }

    /**
     * Get restringido
     *
     * @return boolean
     */
    public function getRestringido()
    {
        return $this->restringido;
    }

    /**
     * Get tipoformatoid
     *
     * @return integer
     */
    public function getTipoformatoid()
    {
        return $this->tipoformatoid;
    }
}

