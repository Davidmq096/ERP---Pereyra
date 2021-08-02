<?php

namespace AppBundle\Entity;

/**
 * Correo
 */
class Correo
{
    /**
     * @var string
     */
    private $motivo;

    /**
     * @var string
     */
    private $cuerpo;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var integer
     */
    private $correoid;


    /**
     * Set motivo
     *
     * @param string $motivo
     *
     * @return Correo
     */
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;

        return $this;
    }

    /**
     * Get motivo
     *
     * @return string
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * Set cuerpo
     *
     * @param string $cuerpo
     *
     * @return Correo
     */
    public function setCuerpo($cuerpo)
    {
        $this->cuerpo = $cuerpo;

        return $this;
    }

    /**
     * Get cuerpo
     *
     * @return string
     */
    public function getCuerpo()
    {
        return $this->cuerpo;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return Correo
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
     * Get correoid
     *
     * @return integer
     */
    public function getCorreoid()
    {
        return $this->correoid;
    }
}

