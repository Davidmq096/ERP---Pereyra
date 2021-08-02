<?php

namespace AppBundle\Entity;

/**
 * CeActividad
 */
class CeActividad
{
    /**
     * @var \DateTime
     */
    private $fecha;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var integer
     */
    private $actividadid;

    /**
     * @var \AppBundle\Entity\CeTipoactividad
     */
    private $tipoactividadid;

    /**
     * @var \AppBundle\Entity\Usuario
     */
    private $usuariodestinoid;

    /**
     * @var \AppBundle\Entity\Usuario
     */
    private $usuarioorigenid;

    /**
     * @var \AppBundle\Entity\CeMateriaporplanestudios
     */
    private $materiaporplanestudioid;


    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return CeActividad
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
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return CeActividad
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Get actividadid
     *
     * @return integer
     */
    public function getActividadid()
    {
        return $this->actividadid;
    }

    /**
     * Set tipoactividadid
     *
     * @param \AppBundle\Entity\CeTipoactividad $tipoactividadid
     *
     * @return CeActividad
     */
    public function setTipoactividadid(\AppBundle\Entity\CeTipoactividad $tipoactividadid = null)
    {
        $this->tipoactividadid = $tipoactividadid;

        return $this;
    }

    /**
     * Get tipoactividadid
     *
     * @return \AppBundle\Entity\CeTipoactividad
     */
    public function getTipoactividadid()
    {
        return $this->tipoactividadid;
    }

    /**
     * Set usuariodestinoid
     *
     * @param \AppBundle\Entity\Usuario $usuariodestinoid
     *
     * @return CeActividad
     */
    public function setUsuariodestinoid(\AppBundle\Entity\Usuario $usuariodestinoid = null)
    {
        $this->usuariodestinoid = $usuariodestinoid;

        return $this;
    }

    /**
     * Get usuariodestinoid
     *
     * @return \AppBundle\Entity\Usuario
     */
    public function getUsuariodestinoid()
    {
        return $this->usuariodestinoid;
    }

    /**
     * Set usuarioorigenid
     *
     * @param \AppBundle\Entity\Usuario $usuarioorigenid
     *
     * @return CeActividad
     */
    public function setUsuarioorigenid(\AppBundle\Entity\Usuario $usuarioorigenid = null)
    {
        $this->usuarioorigenid = $usuarioorigenid;

        return $this;
    }

    /**
     * Get usuarioorigenid
     *
     * @return \AppBundle\Entity\Usuario
     */
    public function getUsuarioorigenid()
    {
        return $this->usuarioorigenid;
    }

    /**
     * Set materiaporplanestudioid
     *
     * @param \AppBundle\Entity\CeMateriaporplanestudios $materiaporplanestudioid
     *
     * @return CeActividad
     */
    public function setMateriaporplanestudioid(\AppBundle\Entity\CeMateriaporplanestudios $materiaporplanestudioid = null)
    {
        $this->materiaporplanestudioid = $materiaporplanestudioid;

        return $this;
    }

    /**
     * Get materiaporplanestudioid
     *
     * @return \AppBundle\Entity\CeMateriaporplanestudios
     */
    public function getMateriaporplanestudioid()
    {
        return $this->materiaporplanestudioid;
    }
}

