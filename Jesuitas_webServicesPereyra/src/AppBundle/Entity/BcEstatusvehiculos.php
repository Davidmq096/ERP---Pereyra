<?php

namespace AppBundle\Entity;

/**
 * BcEstatusvehiculos
 */
class BcEstatusvehiculos
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var integer
     */
    private $estatus;

    /**
     * @var integer
     */
    private $idestatusvehiculo;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return BcEstatusvehiculos
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
     * Set estatus
     *
     * @param integer $estatus
     *
     * @return BcEstatusvehiculos
     */
    public function setEstatus($estatus)
    {
        $this->estatus = $estatus;

        return $this;
    }

    /**
     * Get estatus
     *
     * @return integer
     */
    public function getEstatus()
    {
        return $this->estatus;
    }

    /**
     * Get idestatusvehiculo
     *
     * @return integer
     */
    public function getIdestatusvehiculo()
    {
        return $this->idestatusvehiculo;
    }
}

