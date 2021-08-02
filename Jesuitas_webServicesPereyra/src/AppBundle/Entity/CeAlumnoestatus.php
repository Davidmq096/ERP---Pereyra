<?php

namespace AppBundle\Entity;

/**
 * CeAlumnoestatus
 */
class CeAlumnoestatus
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var boolean
     */
    private $esbaja;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var integer
     */
    private $alumnoestatusid;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CeAlumnoestatus
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
     * Set esbaja
     *
     * @param boolean $esbaja
     *
     * @return CeAlumnoestatus
     */
    public function setEsbaja($esbaja)
    {
        $this->esbaja = $esbaja;

        return $this;
    }

    /**
     * Get esbaja
     *
     * @return boolean
     */
    public function getEsbaja()
    {
        return $this->esbaja;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CeAlumnoestatus
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
     * Get alumnoestatusid
     *
     * @return integer
     */
    public function getAlumnoestatusid()
    {
        return $this->alumnoestatusid;
    }
}

