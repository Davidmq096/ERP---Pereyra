<?php

namespace AppBundle\Entity;

/**
 * CeAlumnotelefono
 */
class CeAlumnotelefono
{
    /**
     * @var integer
     */
    private $tipotelefonoid;

    /**
     * @var string
     */
    private $telefono;

    /**
     * @var string
     */
    private $observaciones = '';

    /**
     * @var integer
     */
    private $alumnotelefonoid;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;


    /**
     * Set tipotelefonoid
     *
     * @param integer $tipotelefonoid
     *
     * @return CeAlumnotelefono
     */
    public function setTipotelefonoid($tipotelefonoid)
    {
        $this->tipotelefonoid = $tipotelefonoid;

        return $this;
    }

    /**
     * Get tipotelefonoid
     *
     * @return integer
     */
    public function getTipotelefonoid()
    {
        return $this->tipotelefonoid;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     *
     * @return CeAlumnotelefono
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return CeAlumnotelefono
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Get alumnotelefonoid
     *
     * @return integer
     */
    public function getAlumnotelefonoid()
    {
        return $this->alumnotelefonoid;
    }

    /**
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return CeAlumnotelefono
     */
    public function setAlumnoid(\AppBundle\Entity\CeAlumno $alumnoid = null)
    {
        $this->alumnoid = $alumnoid;

        return $this;
    }

    /**
     * Get alumnoid
     *
     * @return \AppBundle\Entity\CeAlumno
     */
    public function getAlumnoid()
    {
        return $this->alumnoid;
    }
}

