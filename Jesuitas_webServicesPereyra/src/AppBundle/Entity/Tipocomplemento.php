<?php

namespace AppBundle\Entity;

/**
 * Tipocomplemento
 */
class Tipocomplemento
{
    /**
     * @var string
     */
    private $tipo;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var integer
     */
    private $tipocomplementoid;


    /**
     * Set tipo
     *
     * @param string $tipo
     *
     * @return Tipocomplemento
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Tipocomplemento
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
     * Get tipocomplementoid
     *
     * @return integer
     */
    public function getTipocomplementoid()
    {
        return $this->tipocomplementoid;
    }
}

