<?php

namespace AppBundle\Entity;

/**
 * CeTareaalumno
 */
class CeTareaalumno
{
    /**
     * @var \DateTime
     */
    private $fecha;

    /**
     * @var integer
     */
    private $entiempo;

    /**
     * @var string
     */
    private $calificacion;

    /**
     * @var integer
     */
    private $tareaalumnoid;

    /**
     * @var \AppBundle\Entity\CeAlumno
     */
    private $alumnoid;

    /**
     * @var \AppBundle\Entity\CeTarea
     */
    private $tareaid;


    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return CeTareaalumno
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set entiempo
     *
     * @param integer $entiempo
     *
     * @return CeTareaalumno
     */
    public function setEntiempo($entiempo)
    {
        $this->entiempo = $entiempo;

        return $this;
    }

    /**
     * Get entiempo
     *
     * @return integer
     */
    public function getEntiempo()
    {
        return $this->entiempo;
    }

    /**
     * Set calificacion
     *
     * @param string $calificacion
     *
     * @return CeTareaalumno
     */
    public function setCalificacion($calificacion)
    {
        $this->calificacion = $calificacion;

        return $this;
    }

    /**
     * Get calificacion
     *
     * @return string
     */
    public function getCalificacion()
    {
        return $this->calificacion;
    }

    /**
     * Get tareaalumnoid
     *
     * @return integer
     */
    public function getTareaalumnoid()
    {
        return $this->tareaalumnoid;
    }

    /**
     * Set alumnoid
     *
     * @param \AppBundle\Entity\CeAlumno $alumnoid
     *
     * @return CeTareaalumno
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

    /**
     * Set tareaid
     *
     * @param \AppBundle\Entity\CeTarea $tareaid
     *
     * @return CeTareaalumno
     */
    public function setTareaid(\AppBundle\Entity\CeTarea $tareaid = null)
    {
        $this->tareaid = $tareaid;

        return $this;
    }

    /**
     * Get tareaid
     *
     * @return \AppBundle\Entity\CeTarea
     */
    public function getTareaid()
    {
        return $this->tareaid;
    }
}

