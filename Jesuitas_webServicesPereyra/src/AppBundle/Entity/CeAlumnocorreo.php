<?php

namespace AppBundle\Entity;

/**
 * CeAlumnocorreo
 */
class CeAlumnocorreo
{
    /**
     * @var string
     */
    private $correo;

    /**
     * @var string
     */
    private $observaciones;

    /**
     * @var integer
     */
    private $alumnocorreoid;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;


    /**
     * Set correo
     *
     * @param string $correo
     *
     * @return CeAlumnocorreo
     */
    public function setCorreo($correo)
    {
        $this->correo = $correo;

        return $this;
    }

    /**
     * Get correo
     *
     * @return string
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     *
     * @return CeAlumnocorreo
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
     * Get alumnocorreoid
     *
     * @return integer
     */
    public function getAlumnocorreoid()
    {
        return $this->alumnocorreoid;
    }

    /**
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return CeAlumnocorreo
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

