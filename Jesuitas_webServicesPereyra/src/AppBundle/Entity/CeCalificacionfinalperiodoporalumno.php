<?php

namespace AppBundle\Entity;

/**
 * CeCalificacionfinalperiodoporalumno
 */
class CeCalificacionfinalperiodoporalumno
{
    /**
     * @var string
     */
    private $calificacion;

    /**
     * @var string
     */
    private $observacion;

    /**
     * @var integer
     */
    private $calificacionfinalperiodoporalumnoid;

    /**
     * @var \AppBundle\Entity\CePonderacionopcion
     */
    private $ponderacionopcionid;


    /**
     * Set calificacion
     *
     * @param string $calificacion
     *
     * @return CeCalificacionfinalperiodoporalumno
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
     * Set observacion
     *
     * @param string $observacion
     *
     * @return CeCalificacionfinalperiodoporalumno
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;

        return $this;
    }

    /**
     * Get observacion
     *
     * @return string
     */
    public function getObservacion()
    {
        return $this->observacion;
    }

    /**
     * Get calificacionfinalperiodoporalumnoid
     *
     * @return integer
     */
    public function getCalificacionfinalperiodoporalumnoid()
    {
        return $this->calificacionfinalperiodoporalumnoid;
    }

    /**
     * Set ponderacionopcionid
     *
     * @param \AppBundle\Entity\CePonderacionopcion $ponderacionopcionid
     *
     * @return CeCalificacionfinalperiodoporalumno
     */
    public function setPonderacionopcionid(\AppBundle\Entity\CePonderacionopcion $ponderacionopcionid = null)
    {
        $this->ponderacionopcionid = $ponderacionopcionid;

        return $this;
    }

    /**
     * Get ponderacionopcionid
     *
     * @return \AppBundle\Entity\CePonderacionopcion
     */
    public function getPonderacionopcionid()
    {
        return $this->ponderacionopcionid;
    }
}

