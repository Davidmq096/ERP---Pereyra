<?php

namespace AppBundle\Entity;

/**
 * CjCuentacontable
 */
class CjCuentacontable
{
    /**
     * @var string
     */
    private $clave;

    /**
     * @var string
     */
    private $claveanterior;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var boolean
     */
    private $naturaleza;

    /**
     * @var boolean
     */
    private $activo;

    /**
     * @var integer
     */
    private $cuentacontableid;

    /**
     * @var \AppBundle\Entity\CjEmpresa
     */
    private $empresaid;


    /**
     * Set clave
     *
     * @param string $clave
     *
     * @return CjCuentacontable
     */
    public function setClave($clave)
    {
        $this->clave = $clave;

        return $this;
    }

    /**
     * Get clave
     *
     * @return string
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * Set claveanterior
     *
     * @param string $claveanterior
     *
     * @return CjCuentacontable
     */
    public function setClaveanterior($claveanterior)
    {
        $this->claveanterior = $claveanterior;

        return $this;
    }

    /**
     * Get claveanterior
     *
     * @return string
     */
    public function getClaveanterior()
    {
        return $this->claveanterior;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return CjCuentacontable
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
     * Set naturaleza
     *
     * @param boolean $naturaleza
     *
     * @return CjCuentacontable
     */
    public function setNaturaleza($naturaleza)
    {
        $this->naturaleza = $naturaleza;

        return $this;
    }

    /**
     * Get naturaleza
     *
     * @return boolean
     */
    public function getNaturaleza()
    {
        return $this->naturaleza;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     *
     * @return CjCuentacontable
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
     * Get cuentacontableid
     *
     * @return integer
     */
    public function getCuentacontableid()
    {
        return $this->cuentacontableid;
    }

    /**
     * Set empresaid
     *
     * @param \AppBundle\Entity\CjEmpresa $empresaid
     *
     * @return CjCuentacontable
     */
    public function setEmpresaid(\AppBundle\Entity\CjEmpresa $empresaid = null)
    {
        $this->empresaid = $empresaid;

        return $this;
    }

    /**
     * Get empresaid
     *
     * @return \AppBundle\Entity\CjEmpresa
     */
    public function getEmpresaid()
    {
        return $this->empresaid;
    }
}

