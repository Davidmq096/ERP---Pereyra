<?php

namespace AppBundle\Entity;

/**
 * Bitacora
 */
class Bitacora
{
    /**
     * @var string
     */
    private $usuario;

    /**
     * @var string
     */
    private $direccionip;

    /**
     * @var string
     */
    private $accion;

    /**
     * @var string
     */
    private $bitacora;

    /**
     * @var \DateTime
     */
    private $registro = 'CURRENT_TIMESTAMP';

    /**
     * @var integer
     */
    private $bitacoraid;

    /**
     * @var \AppBundle\Entity\Pantalla
     */
    private $pantallaid;


    /**
     * Set usuario
     *
     * @param string $usuario
     *
     * @return Bitacora
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return string
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set direccionip
     *
     * @param string $direccionip
     *
     * @return Bitacora
     */
    public function setDireccionip($direccionip)
    {
        $this->direccionip = $direccionip;

        return $this;
    }

    /**
     * Get direccionip
     *
     * @return string
     */
    public function getDireccionip()
    {
        return $this->direccionip;
    }

    /**
     * Set accion
     *
     * @param string $accion
     *
     * @return Bitacora
     */
    public function setAccion($accion)
    {
        $this->accion = $accion;

        return $this;
    }

    /**
     * Get accion
     *
     * @return string
     */
    public function getAccion()
    {
        return $this->accion;
    }

    /**
     * Set bitacora
     *
     * @param string $bitacora
     *
     * @return Bitacora
     */
    public function setBitacora($bitacora)
    {
        $this->bitacora = $bitacora;

        return $this;
    }

    /**
     * Get bitacora
     *
     * @return string
     */
    public function getBitacora()
    {
        return $this->bitacora;
    }

    /**
     * Set registro
     *
     * @param \DateTime $registro
     *
     * @return Bitacora
     */
    public function setRegistro($registro)
    {
        $this->registro = $registro;

        return $this;
    }

    /**
     * Get registro
     *
     * @return \DateTime
     */
    public function getRegistro()
    {
        return $this->registro;
    }

    /**
     * Get bitacoraid
     *
     * @return integer
     */
    public function getBitacoraid()
    {
        return $this->bitacoraid;
    }

    /**
     * Set pantallaid
     *
     * @param \AppBundle\Entity\Pantalla $pantallaid
     *
     * @return Bitacora
     */
    public function setPantallaid(\AppBundle\Entity\Pantalla $pantallaid = null)
    {
        $this->pantallaid = $pantallaid;

        return $this;
    }

    /**
     * Get pantallaid
     *
     * @return \AppBundle\Entity\Pantalla
     */
    public function getPantallaid()
    {
        return $this->pantallaid;
    }
}

