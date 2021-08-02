<?php

namespace AppBundle\Entity;

/**
 * CeBoletas
 */
class CeBoletas
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $formato;

    /**
     * @var integer
     */
    private $boletaid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeBoletas
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
     * Set formato
     *
     * @param string $formato
     *
     * @return CeBoletas
     */
    public function setFormato($formato)
    {
        $this->formato = $formato;

        return $this;
    }

    /**
     * Get formato
     *
     * @return string
     */
    public function getFormato()
    {
        return $this->formato;
    }

    /**
     * Get boletaid
     *
     * @return integer
     */
    public function getBoletaid()
    {
        return $this->boletaid;
    }
}

